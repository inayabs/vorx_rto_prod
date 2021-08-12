<?php

namespace App\Http\Controllers\StudentPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use Auth;
use DB;
use Curl;
use Illuminate\Support\Str;

use Carbon\Carbon;
use App\Models\Agent;
use App\Models\Student\Type;
use App\Models\Student\Party;
use App\Models\PaymentStatus;
use App\Models\User;
use App\Models\Student\Person;
use App\Models\Student\Student;
use App\Models\FundedStudentContactDetails;
use App\Models\FundedStudentVisaDetails;
use App\Models\Student\OfferLetter\OfferLetter;
use App\Models\VisaStatus;
use App\Models\AvtStateIdentifier;
use App\Models\AvtPostcode;
use App\Models\AvtCountryIdentifier;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class StudentProfileController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // dump(Auth::user()->party_id);
        $user = User::with(['party', 'party.person', 'roles'])->where('id', Auth::user()->id)->first();
        $avtr_path = '/storage/user/avatars/' . $user->profile_image;

        $student = Student::with(['party.person','type','contact_detail'])->where('party_id', Auth::user()->party_id)->first();
        $visa_info = FundedStudentVisaDetails::where('student_id', $student->student_id)->first();
        // $slct_postcode = AvtPostcode::select(DB::raw("CONCAT(suburb,', ',state) AS name"), 'id')->pluck('name', 'id');
        if($student->type->type == 'Domestic'){
            $contact = $student->contact_detail;
        }else{
            $offerLetter = OfferLetter::with('student_details')->where('student_id', $student->student_id)->first();
            $contact = $offerLetter->student_details;
        }
        $slct_visa_type = VisaStatus::select(DB::raw('id, IF(id=1, "Not Applicable", concat(type, " - ", visa)) AS value'))->orderBy('value', 'asc')->get();
        $arr_visa_type = [];
        foreach ($slct_visa_type as $key => $v) {
            $arr_visa_type[] = [
                'id'          => $v->id,
                'value'       => $v->value
            ];
        }
        $slct_country = AvtCountryIdentifier::orderBy('full_name', 'asc')->get();
        $arr_country = [];
        foreach ($slct_country as $key => $value) {
            $arr_country[] = [
                'id'          => $value->identifier,
                'value'       => $value->full_name
            ];
        }
        $slct_postcode = AvtPostcode::orderBy('suburb')->get();
        $arr_postcode = [];
        foreach ($slct_postcode as $key => $value) {
            $arr_postcode[] = [
                'id' => $value->id,
                'value' => $value->postcode . ' ' . '-' . ' ' . $value->suburb . ',' . ' ' . $value->state
            ];
        }
        $slct_state = AvtStateIdentifier::orderBy('state_name')->pluck('state_name', 'state_key');
        // dd($slct_state);
        \JavaScript::put([
            'user_id'       => Auth::user()->id,
            'student'       => $student->id,
            'student_id'    => $student->student_id,
            'student_info'  => $student->party->person,
            'student_type'  => $student->type->type,
            'avtr_path'     => $avtr_path,
            'visa_info'     => $visa_info,
            'contact'       => $contact,
            'slct_visa_type'=> $arr_visa_type,
            'slct_country'  => $arr_country,
            'slct_state'    => $slct_state,
            'slct_postcode' => $arr_postcode,
        ]);

        return view('student_portal.info.index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    }

    public function info_update(Request $request, $student_id){

        $logins = $request->user;
        $inputs = $request->inputs;
        
        try {

            DB::beginTransaction();
            //student personal update
            $student = Student::with(['party.person', 'party.user', 'type'])->where('student_id', $student_id)->first();
            $student->party->person->firstname = $inputs['firstname'];
            $student->party->person->lastname = $inputs['lastname'];
            $student->party->person->middlename = $inputs['middlename'];
            $student->party->person->prefix = $inputs['prefix'];
            $student->party->person->gender = $inputs['gender'];
            $student->party->person->date_of_birth = Carbon::parse($inputs['date_of_birth'])->format('Y-m-d');
            $student->party->person->update();
            $student->party->name = preg_replace('/\s+/', ' ', $inputs['firstname'] . ' ' . $inputs['middlename'] . ' ' . $inputs['lastname']);
            $student->party->update();
            
            // user PASSWORD update
            if($student->party->user != null){
                $user = $student->party->user;
                $user->fill($logins);
                if(isset($logins['make_password']) && !in_array($logins['make_password'], ['', null])){
                    $user->password = Hash::make($logins['make_password']);
                }
                $user->update(); 
            }
            

            DB::commit();
            return json_encode(['data' => $request, 'status' => 'updated']);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            return json_encode(['student' => $request, 'status' => 'error']);
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


    public function contact_info(){

        $student = Student::with(['party.person','type','contact_detail'])->where('party_id', Auth::user()->party_id)->first();

        $arr_suburb_val = [];

        if($student->type->type == 'Domestic'){
            $contact = $student->contact_detail;
            $telephone = $contact->phone_home;
            $mobile = $contact->phone_mobile;
            $email = $contact->email;
            $suburb_val = AvtPostcode::where('suburb', $contact->addr_suburb)->get();
            foreach ($suburb_val as $key => $value) {
                if ($contact->postcode != null && $contact->postcode == $value->postcode) {
                    $arr_suburb_val = [
                        'id' => $value['id'],
                        'value' => $value['postcode'] . ' ' . '-' . ' ' . $value['suburb'] . ',' . ' ' . $value['state']
                    ];
                }
            }
        }else{
            $offerLetter = OfferLetter::with('student_details')->where('student_id', $student->student_id)->first();
            $contact = $offerLetter->student_details;
            $telephone = $contact->telephone;
            $mobile = $contact->mobile;
            $email = $contact->email_personal;
            $suburb_val = AvtPostcode::where('state', $contact->state_province)->get();
            foreach ($suburb_val as $key => $value) {
                if ($contact->postcode != null && $contact->postcode == $value->postcode) {
                    $arr_suburb_val = [
                        'id' => $value['id'],
                        'value' => $value['postcode'] . ' ' . '-' . ' ' . $value['state']
                    ];
                }
            }
        }

        $arr_country_birth = [];
        // dump($contact->country_birth);
        if ($contact->country_birth != null) {
            $c = AvtCountryIdentifier::where('identifier', $contact->country_birth)->first();
            $arr_country_birth = [
                'id'        => $c->identifier,
                'value'     => $c->full_name
            ];
        }

        // dd($contact);
        $contact_details = [
            // Domestic (funded student details)
            'addr_flat_unit_detail'=> isset($contact->addr_flat_unit_detail) ? $contact->addr_flat_unit_detail : null,
            'addr_building_property_name'=> isset($contact->addr_building_property_name) ? $contact->addr_building_property_name : null,
            'addr_street_num'=>isset($contact->addr_street_num) ? $contact->addr_street_num : null,
            'addr_street_name'=>isset($contact->addr_street_name) ? $contact->addr_street_name : null,
            'email_at'=>isset($contact->email_at) ? $contact->email_at : null,
            'phone_work'=>isset($contact->phone_work) ? $contact->phone_work : null,
            'emer_name'=>isset($contact->emer_name) ? $contact->emer_name : null,
            'emer_address'=>isset($contact->emer_address) ? $contact->emer_address : null,
            'emer_telephone'=>isset($contact->emer_telephone) ? $contact->emer_telephone : null,
            'emer_relationship'=>isset($contact->emer_relationship) ? $contact->emer_relationship : null,
            'addr_postal_delivery_box'=>isset($contact->addr_postal_delivery_box) ? $contact->addr_postal_delivery_box : null,
            // BOTH (get from offerletter or fundedstudentcontactdetails)
            'phone_home'=>isset($telephone) ? $telephone : null,
            'phone_mobile'=>isset($mobile) ? $mobile : null,
            'email'=>isset($email) ? $email : null,
            'addr_suburb'=>$arr_suburb_val,
            // International OfferLetter Details
            'country_birth'=>$arr_country_birth,
            'current_address' => isset($contact->current_address) ? $contact->current_address : null,
            'home_address'=> isset($contact->home_address) ? $contact->home_address : null,
        ];
        // dd($contact_details);
        return response()->json([
            'contact'           => $contact,
            'contact_details'   => $contact_details
        ]);
    }

    public function contact_update(Request $request, $student_id)
    {
        $request = $request->inputs;
        $info = Student::with('party.person', 'type')->where('student_id', $student_id)->first();
        $type = $info->type->type;

        if (count($request['addr_suburb']) != 0) {
            $suburb = $request['addr_suburb'];
            $suburb_id = $suburb['id'];
            $postcode = AvtPostcode::where('id', $suburb_id)->first();
            $suburb = $postcode->suburb;
            $state = AvtStateIdentifier::where('state_key', $postcode->state)->first();
            $state_id = $state->id;
        }

        if($type == 'Domestic'){
            
            try {
                // start db transaction
                DB::beginTransaction();
    
                $contact = FundedStudentContactDetails::where('student_id', $info->student_id)->first();
                $contact->update([
                    // 'student_id'                    => $request->student_id,
                    'addr_suburb'                   => isset($suburb) ? $suburb : null,
                    'addr_postal_delivery_box'      => $request['addr_postal_delivery_box'],
                    'addr_street_name'              => $request['addr_street_name'],
                    'addr_street_num'               => $request['addr_street_num'],
                    'addr_flat_unit_detail'         => $request['addr_flat_unit_detail'],
                    'addr_building_property_name'   => $request['addr_building_property_name'],
                    'postcode'                      => isset($postcode->postcode) ? $postcode->postcode : null,
                    'state_id'                      => isset($state_id) ? $state_id : null,
                    'phone_home'                    => $request['phone_home'],
                    'phone_work'                    => $request['phone_work'],
                    'phone_mobile'                  => $request['phone_mobile'],
                    'email'                         => $request['email'],
                    'email_at'                      => $request['email_at'],
                    'emer_name'                     => $request['emer_name'],
                    'emer_address'                  => $request['emer_address'],
                    'emer_telephone'                => $request['emer_telephone'],
                    'emer_relationship'             => $request['emer_relationship']
                ]);
                DB::commit();
    
                return json_encode(['data' => $request, 'status' => 'updated']);
            } catch (\Exception $e) {
                // rollback db transactions
                DB::rollBack();
    
                echo $e->getMessage();
                exit();
                // return to previous page with errors
                return  response()->json(['message' => $e->getMessage(), 'status' => 'error']);
            }
        }else{
            // dd('international');
            try {
                // start db transaction
                DB::beginTransaction();
    
                $offerLetter = OfferLetter::with('student_details')->where('student_id', $student_id)->first();
                $offerLetterDetails = $offerLetter->student_details;
                $offerLetterDetails->update([
                    'current_address'   => $request['current_address'],
                    'home_address'      => $request['home_address'],
                    // 'country'           => $request['country'],
                    'state_province'    => isset($postcode->state) ? $postcode->state : null,
                    'postcode'          => isset($postcode->postcode) ? $postcode->postcode : null,
                    'mobile'            => $request['phone_mobile'],
                    'telephone'         => $request['phone_home'],
                    'email_personal'    => $request['email'],
                    'country_birth'     => $request['country_birth']['id'],
                ]);
                DB::commit();
    
                return json_encode(['data' => $request, 'status' => 'updated']);
            } catch (\Exception $e) {
                // rollback db transactions
                DB::rollBack();
    
                echo $e->getMessage();
                exit();
                // return to previous page with errors
                return  response()->json(['message' => $e->getMessage(), 'status' => 'error']);
            }
        }

    }

    public function commbank(){
        
        $commweb = Curl::to('https://paymentgateway.commbank.com.au/api/rest/version/1/information')->get();

        $cw = $commweb ? json_decode($commweb) : '';
        
        if($cw->status=='OPERATING'){
            return "operating";
        }else{
            return "not operating";
        }
    }
}
