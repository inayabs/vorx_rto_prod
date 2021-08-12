<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
// use App\r;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
// use App\Models\Email;
// use App\Models\Departments;
use App\Models\Student\Party;
use App\Models\Student\Person;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use \DB;
use Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkModule:users', ['except' => ['show', 'user_info', 'user_info_update', 'avatar']]);
        $this->middleware('auth');
        $this->middleware(['role:'.config('global.roles')]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // dd());
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'errors', 'errors' => $validator->messages()]);
        }
        
        try {
            DB::beginTransaction();
            // new instance of Party Model
            $party = new Party;
            // new instance of Person Model
            $person = new Person;
            // new instance of User Model
            $user = new User;

            $party->fill([
                'party_type_id'    => 1,
                'name'          => preg_replace('/\s+/', ' ', $request->firstname . ' ' . $request->lastname)
            ]);
            $party->save();

            $person->fill([
                'person_type_id' =>  1,
                'firstname'   => $request->firstname,
                'lastname'    => $request->lastname
            ]);
            $person->party()->associate($party);
            $person->save();
            

            $password = Hash::make($request->password);
            $user->fill([
                'username'      => $request->username,
                'password'      => $password,
                'is_active'     => 1,
                'profile_image' => 'default-profile.png'
            ]);
            $user->party()->associate($party);
            $user->save();
            
            $user->assignRole('Staff');
            

            DB::commit();

            
            return json_encode(['data'=>$request->all(), 'status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();

            dd($e->getMessage());

            // return to previous page with errors
            // return back()->withInput()->withErrors(['status'=>'error', 'message' => $e->getMessage()]);//
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\r  $r
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        \JavaScript::put([
            'user_id' => $id
        ]);

    return view('users.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\r  $r
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\r  $r
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\r  $r
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user != null) {
            $user->delete();
            return json_encode(['id'=>$id, 'status' => 'success']);
        } 
    }


    public function user_list(){
        // $userList = User::with(['party', 'party.person', 'roles'])->has('party')->where('id', '<>', 1)->orderBy('id', 'desc')->get();
        $userList = User::with(['party', 'party.person', 'roles'])->has('party')->where('id', '<>', 1)->whereHas('roles', function ($q) {
            $q->whereIn('name', ['Admin', 'Staff', 'Demo']);
        })->orderBy('id', 'desc')->get();

        return UserResource::collection($userList);
    }

    public function user_search(Request $request)
    {
        if ($request->search == null) {
            return $this->user_list();
        }
        $r_search = $request->search;
        $userList = User::with(['party', 'party.person'])->WhereHas('party.person', function ($q) use ($r_search) {
                $q->where('firstname', 'like', '%'.$r_search.'%');
            })->where('id', '<>', 1)->orWhereHas('party',function($q) use ($r_search) {
                 $q->where('name', 'LIKE', '%'. $r_search . '%');
            })->where('id', '<>', 1)->orderBy('id', 'desc')->paginate(10);

        return UserResource::collection($userList);
    }

    public function user_info($id)
    {
        $user = User::with(['party', 'party.person', 'roles'])->where('id', $id)->first();
        $avtr_path = '/storage/user/avatars/' . $user->profile_image;
        
        // $department = Departments::all();
        $role = Role::all();
        // dd($user->roles[0]);
        $data = [
            'user' => $user,
            'avtr_path' => $avtr_path,
            'user_role' => isset($user->roles[0]->name) ? $user->roles[0]->name : null,
            // 'department' => $department,
            'role' => $role
        ];

        // dd($data);
        return $data;
    }

    public function user_info_update(Request $request, $id)
    {

        try {
            DB::beginTransaction();

            $user = User::with(['party', 'party.person', 'roles'])->where('id', $request->id)->first();

            // update party
            $user->party->update([
                'name'      => preg_replace('/\s+/', ' ', $request->firstname . ' ' . $request->lastname)
            ]);

            // update a person & associate person with a party
            $user->party->person->update([
                'firstname'   => $request->firstname,
                'lastname'    => $request->lastname
            ]);
            
            if ($request->password == null || $request->email_password == null) {
                $user_password = $user->password;
                $email_password = Hash::make($user->email_password);
            } else {
                $user_password = Hash::make($request->password);
                $email_password = Hash::make($request->email_password);
            }



            $user->update([
                'username'          => $request->username,
                'password'          => $user_password,
                // 'department_type'   => $request->slct_department,
                'is_active'         => $request->is_active,
                'email'             => $request->email,
                'email_password'    => $request->email_password
            ]);

            // Remove Roles
            if(isset($user->roles)){
                foreach ($user->roles as $value) {
                    $user->removeRole($value);
                }
            }
            //  Update Roles
            if(isset($request->role) && !in_array($request->role, ['', null])){
                $user->assignRole($request->role);
            }
            // foreach ($request->role['roles'] as $value) {
                // $user->assignRole($value['name']);
            // }

            DB::commit();


            // return to users index page
            return json_encode(['data' => $request->all(), 'status' => 'updated']);
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();
            exit();

            // return to previous page with errors
            return json_encode(['message' => $e->getMessage(), 'status' => 'error']);
        }
    }

    public function avatar(Request $request)
    {
        $image = $request->file('file');
        // $image_name = $request->name.'_'.mt_rand(0,10).'.'.$image->guessClientExtension();
        $image_name = $request->name . '.' . $image->guessClientExtension();
        $image->storeAs('public/user/avatars', $image_name);

        $img_exist = User::where('id', $request->user_id)->first();
        if ($img_exist) {
            $img_exist->profile_image = $image_name;
            $img_exist->update();
        }

        return json_encode(['data'=>$request->all(), 'status' => 'success']);
    }
}