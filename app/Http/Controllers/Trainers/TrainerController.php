<?php

namespace App\Http\Controllers\Trainers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use \DB;
use App\Models\Trainer;
use App\Models\TrainerCommissionSetting;
use App\Models\AvtPostcode;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\Course;
use App\Models\Unit;
use App\Models\StateIdentifier;
use Illuminate\Validation\Rule;
use App\Http\Resources\TrainerResource;
use App\Models\Student\Party;
use App\Models\Student\Person;
use Validator;

class TrainerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        //
        return view('trainer.index');
    }
    
    public function trainer_list(){
        $trainerList = Trainer::with('commission_settings')->orderBy('id', 'desc')->get();

        if($trainerList!=null){
            foreach($trainerList as $tl){
            //    dd(json_decode($tl->course_location));
               $tl->course_location = json_decode($tl->course_location);
            }
        }
        // dd($trainerList);

        return TrainerResource::collection($trainerList);
    }

    public function trainer_fetch($user_id){
        $trainer = Trainer::where('hasLogins',$user_id)->first();
        return $trainer;
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
        // dump($request->all());
        $checkuser = Auth::user();
        $user_id = $checkuser->id;
       
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'phone_number' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'errors', 'errors' => $validator->messages()]);
        }

        try {
            // start db transaction
            DB::beginTransaction();

            $trainer = new Trainer;

            $trainer->fill([
                'user_id'       => $user_id,
                'firstname'     => $request->firstname,
                'lastname'      => $request->lastname,
                'email'         => $request->email,
                'phone_number'  => $request->phone_number
            ]);
            $trainer->save();

            DB::commit();

            // return response()->json(['data'=>$request->all(), 'status' => 'success']);
            // return response()->json(['success'=>'Done!']);
            return json_encode(['data'=>$request->all(), 'status' => 'success']);
        } catch (\Exception $e) {
            // rollback db transactions
            DB::rollBack();
            
            // return to previous page with errors
            return  response()->json(['message' => $e->getMessage(), 'status' => 'error']);
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // $course_list = Course::select(DB::raw('id, code, concat(code, " - ", name) as name'))->get();
        // dd($course_list);
        //
        $trainer = Trainer::with(['has_login'])->where('id', $id)->first();
        $trainer->course_location = is_array(json_decode($trainer->course_location))==true ? $trainer->course_location : null;
        // $trainer->course_location = json_decode($trainer->course_location);
        // dd($trainer->course_location);
        $courses = Course::select(DB::raw('id, code, concat(code, " - ", name) as name'))->get();

        $uoc = Unit::select(DB::raw('id,code,concat(code," - ",description) as name,extra_unit'))->where('extra_unit',1)->get();//unit of comp
        // dd($course_list[0],$uoc[0]);
        $course_list = array_merge($courses->toArray(),$uoc->toArray());
        // dd($course_list);
        \JavaScript::put([
            'trainer_id' => $id,
            'trainer' => $trainer,
            'course_location' => AvtPostcode::all(),
            'course_list' => $course_list,
            'hasLogins' => isset($trainer->has_login->id) ? $trainer->has_login : false,
        ]);

        return view('trainer.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $trainer = Trainer::find($id);
        if ($trainer != null) {
            $trainer->delete();
            return json_encode(['id'=>$id, 'status' => 'success']);
        } 
    }


    public function trainer_info($id){
        $trainer = Trainer::where('id', $id)->first();
        $ct = $trainer->course_taught;
        $cl = $trainer->course_location;
        $course_list = Course::all();
        $course_location = StateIdentifier::all();
        $ct_list = [];
        $arr_course = [];

        // COURSE TAUGHT LIST
        if($ct != null){
            $course_taught = explode(',',$trainer->course_taught);
            foreach ($course_taught as $key => $value) {
                $ct_list[] = [
                    'id'   => Course::where('code', $value)->first()->id,
                    'code' => $value,
                    'name' => $value.' '.'-'.' '.Course::where('code', $value)->first()->name 
                ];
            }
            $count_ct_list = count($ct_list);
            if($count_ct_list != 0){
                $ct = $ct_list;
            }
        }
        
        //course loc list 

       
        // COURSE LIST
        foreach ($course_list as $key => $value){
            $arr_course[] = [
                'id' => $value->id,
                'code' => $value->code,
                'name' => $value->code.' '.'-'.' '.$value->name 
            ];
        }

        $data = [
            'trainer' => $trainer,
            'course_taught_list'  => $ct,
            'course_list' => $arr_course,
            'course_location' => $course_location,
        ];
        // dd($data);

        return $data;
    }

    public function trainer_info_update(Request $request, $id){
        // dd($request->all());
        try {
            DB::beginTransaction();
            
            if(isset($request->user['username']) && !in_array($request->user['username'], ['', null])){
                if(isset($request->trainer['hasLogins']) && !in_array($request->trainer['hasLogins'], ['', null])){
                    $getUser = User::where('username', $request->user['username'])->where('id', '!=', $request->trainer['hasLogins'])->first();
                }else{
                    $getUser = User::where('username', $request->user['username'])->first();
                }
                if($getUser){
                    return ['status' => 'error', 'message' => 'Username already been taken.'];
                }
            }

            $trainer = Trainer::with(['has_login'])->where('id', $request->id)->first();
            $trainer->fill($request->trainer);
            $trainer->update();

            if($trainer->hasLogins == null && !in_array($request->user['username'], ['', null]) && !in_array($request->user['make_password'], ['',null])){
                $party = new Party;
                // new instance of Person Model
                $person = new Person;
                // new instance of User Model
                $user = new User;

                $party->fill([
                    'party_type_id'    => 1,
                    'name'          => preg_replace('/\s+/', ' ', $request->trainer['firstname'] . ' ' . $request->trainer['lastname'])
                ]);
                $party->save();

                $person->fill([
                    'person_type_id' =>  1,
                    'firstname'   => $request->trainer['firstname'],
                    'lastname'    => $request->trainer['lastname'],
                ]);
                $person->party()->associate($party);
                $person->save();


                $password = Hash::make($request->user['make_password']);
                $user->fill([
                    'username'      => $request->user['username'],
                    'password'      => $password,
                    'is_active'     => isset($request->user['is_active']) && in_array($request->user['is_active'], [true, 1]) ? 1 : 0,
                    'profile_image' => 'default-profile.png'
                ]);
                $user->party()->associate($party);
                $user->save();

                $user->assignRole('Trainer');
                
                $trainer->has_login()->associate($user);
                $trainer->update();
            }elseif($trainer->hasLogins != null && !in_array($request->user['username'], ['', null])){
                
                $trainer->has_login->username = $request->user['username'];
                $trainer->has_login->is_active = isset($request->user['is_active']) && in_array($request->user['is_active'], [true, 1]) ? 1 : 0;
                if(isset($request->user['make_password']) && !in_array($request->user['make_password'], ['',null])){
                    $password = Hash::make($request->user['make_password']);
                    $trainer->has_login->password = $password;
                }
                $trainer->has_login->update();

            }


            DB::commit();

            // return to users index page
            return json_encode(['data'=>$trainer, 'status' => 'updated']);
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();
            exit();

            // return to previous page with errors
            return json_encode(['message'=>$e->getMessage(), 'status' => 'error']);
        }
    }


}
