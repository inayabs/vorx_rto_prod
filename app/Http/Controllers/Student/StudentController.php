<?php

namespace App\Http\Controllers\Student;

use Validator;
use Auth;
use DB;
use Carbon\Carbon;
use App\Models\AvtCompletionStatus;
use App\Models\TrainingOrganisation;
use App\Models\StudentAttachment;
use App\Models\EnrolmentPack;
use App\Models\Agent;
use App\Models\Student\Type;
use App\Models\Student\Party;
use App\Models\PaymentStatus;
use App\Models\Student\Person;
use App\Models\Student\Student;
use App\Models\Student\OfferLetter\OfferLetter;
use App\Models\CommissionStatus;
use App\Models\OfferLetterStatus;
use App\Http\Resources\StudentResource;
use App\Http\Resources\PartyStudentResource;
use App\Http\Controllers\Controller;
use App\Models\AgentDetail;
use App\Models\AvtClientIndigenousStatus;
use App\Models\AvtCommencingCourse;
use App\Models\AvtCountryIdentifier;
use App\Models\AvtDeliveryMode;
use App\Models\AvtDisabilityTypes;
use App\Models\AvtFundingSourceNational;
use App\Models\AvtFundingSourceState;
use App\Models\AvtFundingType;
use App\Models\AvtHighestSchlLvlCompleted;
use App\Models\AvtLabourForceStatus;
use App\Models\AvtLangIdentifier;
use App\Models\AvtOutcomeStatus;
use App\Models\AvtPredominantDlvrMode;
use App\Models\AvtPriorEducationAchievement;
use App\Models\AvtSpecificFunding;
use App\Models\AvtStateIdentifier;
use App\Models\AvtStudyReason;
use App\Models\AvtSurveyContactStatus;
use App\Models\EnglishTest;
use App\Models\PaymentMethod;
use App\Models\FundedStudentContactDetails;
use App\Models\FundedStudentDetails;
use App\Models\FundedStudentVisaDetails;
use App\Models\VisaStatus;
use App\Models\StudentEnglishTest;
use App\Models\EmailWarningTrail;
use App\Models\Course;
use App\Models\Notification;
use App\Models\OfferLetterDiscount;
use App\Models\TrainingDeliveryLoc;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Enrolment\EnrolmentPCAController;
use App\Http\Controllers\Enrolment\EnrolmentController;
use App\Models\CompletionStudentCourse;
use App\Models\FundedStudentCourse;
use App\Models\ReportCourseStatuses;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
        return view('students.index');
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
     * @return \Illuminate\Http\Re1`sponse
     */
    public function store(Request $request)
    {
        //
        // check if student exist/has already data
        $result = $this->check_student($request);
        if ($result == false) {
            // declaration of models 
            $party = new Party;
            $person = new Person;
            $student = new Student;
            $avetmiss = new FundedStudentDetails;

            $to = TrainingOrganisation::first();
            $studIDPrefix = in_array($to->student_id_prefix, [null, '']) ? 'VRX' : $to->student_id_prefix;
            // dd($studIDPrefix);
            $validator = Validator::make($request->all(), [
                'firstname' => 'required',
                'lastname' => 'required',
                'date_of_birth' => 'required',
                'student_type' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'errors', 'errors' => $validator->messages()]);
            }
            // start storing data
            try {

                DB::beginTransaction();
                $party->fill([
                    'party_type_id'    => 1,
                    'name'          => preg_replace('/\s+/', ' ', $request->firstname . ' ' . $request->middlename . ' ' . $request->lastname),
                    // 'active'        => 1
                ]);
                    
                $party->save();
                
                $person->fill([
                    'firstname'     => $request->firstname,
                    'middlename'    => $request->middlename,
                    'lastname'      => $request->lastname,
                    'date_of_birth' => $request->date_of_birth,
                    'gender'        => $request->prefix == 'Mr.' ? 'Male' : 'Female',
                    'prefix'        => $request->prefix,
                    'person_type_id'   => 5
                ]);
                $person->party()->associate($party);
                $person->save();

                $student->fill([
                    'is_active' => 1,
                    'student_type_id' => $request->student_type,
                ]);
                $student->party()->associate($party);
                $student->user()->associate(Auth::user());
                $student->save();
                // $student->student_id = $studIDPrefix . str_pad($student->id + 1, 5, 0, STR_PAD_LEFT);
                $student->student_id = $this->generate_student_id();
                $student->update();
                
                // $training_org_prefix = $to->student_id_prefix;

                // Create Enrolment Pack to generate Enrolment form if student did not created in online enrolment form.
                if(in_array(config('app.name'), ['Phoenix', 'CEA'])){
                    if(config('app.name') =='Phoenix'){
                        $enrolment_pca = new EnrolmentPCAController;
                        $process_id = $enrolment_pca->codeNumber();
                        $student_name = $request->firstname.' '.$request->lastname;
    
                        $enrolment_pack = new EnrolmentPack;
                        $enrolment_pack->process_id = $process_id;
                        $enrolment_pack->student_id = $student->student_id;
                        $enrolment_pack->student_name = $student_name;
                        $enrolment_pack->student_type = $request->student_type;
                        $enrolment_pack->save();
                    }else{
                        $enrolment_ = new EnrolmentController;
                        $process_id = $enrolment_->codeNumber();
                        $student_name = $request->firstname.' '.$request->lastname;
    
                        $enrolment_pack = new EnrolmentPack;
                        $enrolment_pack->process_id = $process_id;
                        $enrolment_pack->student_id = $student->student_id;
                        $enrolment_pack->student_name = $student_name;
                        $enrolment_pack->student_type = $request->student_type;
                        $enrolment_pack->save();
                    }
                }

                $avetmiss->fill([
                    'student_id' => $student->student_id
                ]);
                $avetmiss->save();

                // SAVE TO FUNDED IF THE STUDENT TYPE IS "DOMESTIC(2)"
                // if ($student->student_type_id == 2) {
                    $funded_student = new FundedStudentDetails;
                    $contact = new FundedStudentContactDetails;
                    $contact->fill([
                        'student_id' => $student->student_id,
                    ]);
                    $contact->save();
                    $funded_student->fill([
                        'student_id' => $student->student_id,
                        'funded_student_contact_detail_id' => $contact->id,
                    ]);
                    $funded_student->save();

                    $student_visa = new FundedStudentVisaDetails;
                    $student_visa->fill([
                        'student_id' => $student->student_id,
                    ]);
                    $student_visa->save();
                // }

                $notify = new Notification;

                $notify->fill([
                    'type' => 'student',
                    'table_name' => 'student',
                    'reference_id' => $student->student_id,
                    'date_recorded' => Carbon::now()->format('Y-m-d H:i:s'),
                    'message' => '<b>' . $party->name . '</b> is added in the student list',
                    'is_seen' => 0,
                    'action' => 'created',
                    'link' => $student->student_type_id == 1 ? '/student/' . $student->id : '/student/domestic/' . $student->id
                ]);
                $notify->user()->associate(\Auth::user());
                $notify->save();

                DB::commit();

                return new StudentResource($student);
            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }
        } else {
            return json_encode(['data' => $request->all(), 'status' => 'exist']);
        }
    }

    public function generate_student_id($student_id = null)
    {
        $to = TrainingOrganisation::first();
        if($student_id == null){
            $student = Student::where('student_id', '!=', null)->latest()->first();
            if($student == null){
                $student_id = 0;
            }else{
                $student_id = $student->student_id;
            }
            
            
        }
        $next_id = abs(str_replace($to->student_id_prefix,"",$student_id));
        $next_id++;
        $prefix = in_array($to->student_id_prefix, [null, '']) ? 'VRX' : $to->student_id_prefix;
        $next_id = $prefix . str_pad($next_id , 5, 0, STR_PAD_LEFT);

        $check = Student::where('student_id', $next_id)->first();

        if($check){
            $this->generate_student_id($next_id);
        }
        
        // dd($next_id);
        return $next_id;
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
        // dd($id);


        $student = Student::with('english_test', 'visa_details')->where('id', $id)->first();
        $statuses = AvtCompletionStatus::all();
        $student_details = FundedStudentDetails::with('contact', 'course')->where('student_id', $student->student_id)->first();
        if ($student_details == null) {
            $student_details = new FundedStudentDetails;
            $student_details->fill(['student_id', $student->student_id]);
            $student_details->save();
        }
        $contact = $student_details->contact;
        $courses = Course::get();
        $unit_com = [
            '@@@@' => 'Unit of Competency'
        ];
        if (\Auth::user()->hasRole('Demo')) {
            $slct_training_dlvr_loc = TrainingDeliveryLoc::where('user_id', \Auth::user()->id)->orderBy('train_org_dlvr_loc_name')->pluck('train_org_dlvr_loc_id', 'train_org_dlvr_loc_name');
            $slct_course = Course::select(DB::raw("CONCAT(code,' - ',name) AS name"), 'code')->where('user_id', \Auth::user()->id)->pluck('name', 'code');
        } else {
            $slct_training_dlvr_loc = TrainingDeliveryLoc::orderBy('train_org_dlvr_loc_name')->pluck('train_org_dlvr_loc_id', 'train_org_dlvr_loc_name');
            $slct_course = Course::select(DB::raw("CONCAT(code,' - ',name) AS name"), 'code')->pluck('name', 'code');
        }

        $payment_status = PaymentStatus::all();
        $comm_status = CommissionStatus::all();
        $offer_status = OfferLetterStatus::whereNotIn('id', ['3'])->get();
        $payment_methods = PaymentMethod::all();
        $englishTest = EnglishTest::all();
        $app_setting = TrainingOrganisation::first();
        $slct_visa_type = VisaStatus::select(DB::raw('id, IF(id=1, "Not Applicable", concat(type, " - ", visa)) AS value'))->orderBy('value', 'asc')->get();
        $visa_info = FundedStudentVisaDetails::where('student_id', $student->student_id)->first();
        // ENROLMENT DETAILS 
        $slct_offer_lttr_statuses = $offer_status->pluck('description', 'id');
        $slct_com_course = AvtCommencingCourse::pluck('description', 'value');
        $slct_funding_source_national = AvtFundingSourceNational::pluck('description', 'value');
        $slct_funding_source_state = AvtFundingSourceState::pluck('description', 'value');
        $slct_funding_source_statecomplete = AvtFundingSourceState::all();
        $slct_outcome_status = AvtOutcomeStatus::pluck('description', 'value');
        $slct_predom_dlvr_mode = AvtPredominantDlvrMode::pluck('description', 'value');
        $slct_specific_fund = AvtSpecificFunding::pluck('description', 'identifier');
        $slct_study_reason = AvtStudyReason::pluck('description', 'value');
        $slc_funding_type = AvtFundingType::where('state_key', $student_details->location)->get();
        // MULTISELECT
        $slct_country = AvtCountryIdentifier::orderBy('full_name', 'asc')->get();
        $slct_disability = AvtDisabilityTypes::all();
        $slct_educ_achievement = AvtPriorEducationAchievement::all();
        $slct_state = AvtStateIdentifier::orderBy('state_name')->pluck('state_name', 'state_key');
        $slct_schl_lvl_completed = AvtHighestSchlLvlCompleted::pluck('description', 'value');
        $slct_indigenous_status = AvtClientIndigenousStatus::pluck('description', 'value');
        $slct_labour_force_status = AvtLabourForceStatus::pluck('status', 'value');
        $slct_lang_identifer = AvtLangIdentifier::orderBy('description', 'asc')->pluck('value', 'description');
        $slct_survey_contact_status = AvtSurveyContactStatus::pluck('description', 'value');
        $offer_discount = OfferLetterDiscount::all();
        $slct_state = AvtStateIdentifier::orderBy('state_name')->pluck('state_name', 'state_key');
        $arr_country_val = [];
        $arr_disability = [];
        $arr_disability_val = [];
        $arr_pea_val = [];
        $arr_country = [];

        foreach ($slct_disability as $key => $value) {
            $arr_disability[] = [
                'id'          => $value->value,
                'value'       => $value->description
            ];
        }
        foreach ($slct_country as $key => $value) {
            $arr_country[] = [
                'id'          => $value->identifier,
                'value'       => $value->full_name
            ];
        }
        foreach ($slct_educ_achievement as $key => $value) {
            $arr_educ_achievement[] = [
                'id'          => $value->value,
                'value'       => $value->description
            ];
        }

        if ($student_details->disability_ids != null) {
            $disability = null;

            if ($student_details->disability_ids != '') {
                $disability = explode(',', $student_details->disability_ids);
            }

            if ($disability !== null) {
                foreach ($disability as $key => $dis) {
                    $dis = AvtDisabilityTypes::where('value', $dis)->first();
                    $arr_disability_val[] = [
                        'id'        => $dis['value'],
                        'value'     => $dis['description']
                    ];
                }
            }
        }
        // prior_educational_achievement_ids
        if ($student_details->prior_educational_achievement_ids != null) {
            $pea = null;
            if ($student_details->prior_educational_achievement_ids != '') {
                $pea = explode(',', $student_details->prior_educational_achievement_ids);
            }
            if ($pea !== null) {

                foreach ($pea as $key => $p) {
                    $p = AvtPriorEducationAchievement::where('value', $p)->first();
                    $arr_pea_val[] = [
                        'id'        => $p['value'],
                        'value'     => $p['description']
                    ];
                }
            }
        }
        // country_id
        
        if ($student_details->country_id != null) {
            $c = AvtCountryIdentifier::where('identifier', $student_details->country_id)->first();
            $arr_country_val = [
                'id'        => $c['identifier'],
                'value'     => $c['full_name']
            ];
        }

        $ptr = [];
        // dd($student);
        $offerLetter = OfferLetter::with('enrolment_pack')->where('student_id', $student->student_id)->orderBy('id', 'DESC')->get();

        foreach ($offerLetter as $ol) {
            if (isset($ol->enrolment_pack->ptr)) {
                $pdf = StudentAttachment::where('student_id', $student->student_id)->where('_input', 'pre_training_review')->first();
                $enrol_pack = ['epack' => $ol->enrolment_pack, 'ptr' => json_decode($ol->enrolment_pack->ptr), 'pdf' => $pdf];
                array_push($ptr, $enrol_pack);
            }
        }

        $slct_dlvr_mode = AvtDeliveryMode::pluck('description', 'value');
        $arr_student_details = [
            'id'                                    => $student_details->id,
            'student_id'                            => $student->student_id,
            'vetrack_id'                            => $student_details->vetrack_id,
            'location'                              => $student_details->location,
            'funded_student_contact_detail_id'      => null,
            'name_for_encryption'                   => $student_details->name_for_encryption,
            'highest_school_level_completed_id'     => $student_details->highest_school_level_completed_id,
            'indigenous_status_id'                  => $student_details->indigenous_status_id,
            'language_id'                           => $student_details->language_id,
            'labour_force_status_id'                => $student_details->labour_force_status_id,
            'country_id'                            => $arr_country_val,
            'disability_flag'                       => $student_details->disability_flag,
            'disability_ids'                        => $arr_disability_val,
            'prior_educational_achievement_flag'    => $student_details->prior_educational_achievement_flag,
            'prior_educational_achievement_ids'     => $arr_pea_val,
            'at_school_flag'                        => $student_details->at_school_flag,
            'verified'                              => $student_details->verified,
            'unique_student_id'                     => $student_details->unique_student_id,
            'survey_contact_status'                 => $student_details->survey_contact_status,
            'statistical_area_level_1_id'           => $student_details->statistical_area_level_1_id,
            'statistical_area_level_2_id'           => $student_details->statistical_area_level_2_id,
            'year_completed'                        => $student_details->year_completed
        ];
        $demoUser = \Auth::user()->hasRole('Demo');
        \JavaScript::put([
            'student' => $id,
            'student_id' => $student->student_id,
            'is_test' => $student->is_test,
            'report_avetmiss' => $student->report_avetmiss,
            'report_course_statuses' => ReportCourseStatuses::all(),
            'student_type' => $student->student_type_id,
            'payment_status' => $payment_status,
            'comm_status'   => $comm_status,
            'offer_status'   => $offer_status,
            'payment_methods' => $payment_methods,
            'englishTest' => $englishTest,
            'contact'     => $contact,
            'englishData' => $student->english_test,
            'app_settings' => $app_setting,
            'slct_visa_type' => $slct_visa_type,
            'slct_funding_source_statecomplete' => $slct_funding_source_statecomplete,
            'visa_info'     => $visa_info,
            'slct_educ_achievement' => $arr_educ_achievement,
            'slct_disability' => $arr_disability,
            'slct_country' => $arr_country,
            'slc_funding_type' => $slc_funding_type,
            'slct_study_reason' => $slct_study_reason,
            'slct_specific_fund' => $slct_specific_fund,
            'slct_predom_dlvr_mode' => $slct_predom_dlvr_mode,
            'slct_outcome_status' => $slct_outcome_status,
            'slct_funding_source_state' => $slct_funding_source_state,
            'slct_funding_source_national' => $slct_funding_source_national,
            'slct_com_course' => $slct_com_course,
            'slct_state' => $slct_state,
            'student_details' => $arr_student_details,
            'slct_schl_lvl_completed' => $slct_schl_lvl_completed,
            'slct_indigenous_status' => $slct_indigenous_status,
            'slct_labour_force_status' => $slct_labour_force_status,
            'slct_lang_identifer' => $slct_lang_identifer->toArray(),
            'slct_survey_contact_status' => $slct_survey_contact_status,
            'slct_offer_lttr_statuses' => $slct_offer_lttr_statuses,
            'slct_course'               => $slct_course,
            'slct_training_dlvr_loc'   => $slct_training_dlvr_loc,
            'slct_dlvr_mode'           => $slct_dlvr_mode,
            'demoUser' => $demoUser,
            'ptr' => $ptr,
            'offer_discount' => $offer_discount,
            'statuses' => $statuses,
            'viewing' => 'students'
        ]);
        return view('offer-letter.show');
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
        try {
            //code...
            DB::beginTransaction();
            $student = Student::find($id);
            $student->party->person->firstname = $request->firstname;
            $student->party->person->lastname = $request->lastname;
            $student->party->person->middlename = $request->middlename;
            $student->party->person->prefix = $request->prefix;
            $student->party->person->gender = $request->gender;
            $student->party->person->date_of_birth = Carbon::parse($request->date_of_birth)->format('Y-m-d');
            $student->party->person->update();
            $student->party->name = preg_replace('/\s+/', ' ', $request->firstname . ' ' . $request->middlename . ' ' . $request->lastname);
            $student->party->update();

            if ($request->englishTest != null) {
                $englishtest = StudentEnglishTest::updateOrCreate(
                    [
                        'student_id' => $student->student_id,

                    ],
                    [
                        'english_test_id' => $request->englishTest,
                        'score' =>  $request->englishTest !== 9 ? $request->testScore : 0,
                        'test_date' => $request->testDateL !== 'Invalid date' ? Carbon::createFromFormat('d/m/Y', $request->testDateL)->format('Y-m-d') : null,
                        'user_id' => Auth::user()->id
                    ]
                );
            }
            DB::commit();
            return json_encode(['data' => $request->all(), 'status' => 'updated']);
        } catch (\Throwable $th) {
            DB::rollback();
            // throw $th;
            return json_encode(['student' => $request->all(), 'status' => 'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::find($id);

        $student->delete();
        // dd($student);
    }

    public function list(Request $request)
    {
        // dd(Student::all());
        $student = collect();
        if ($request->sort) {

            // dump($request->all());
            if (isset($request->search) && $request->search != null) {
                // dump($request->all());
                // dump($request['search']);
                // dump($request->search); 
                if (\Auth::user()->hasRole('Demo')) {
                    $student = Student::select('party.id as id', 'students.id as _id', 'students.student_id', 'party.name as name', 'type.type', 'students.report_avetmiss')->with('latest_offer_letter.offer_course.course', 'latest_funded_course.course')
                        ->join('party as party', 'party.id', '=', 'students.party_id')
                        // ->join('party as party', 'party.id', '=', 'students.party_id')
                        ->join('student_types as type', 'type.id', '=', 'students.student_type_id')
                        ->where('is_test',0)
                        ->where('user_id', \Auth::user()->id)
                        ->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('students.student_id', 'like', '%' . $request->search . '%')
                        ->orWhere('type', 'like', '%' . $request->search . '%');
                } else {
                    if (\Auth::user()->hasRole('Super-Admin')) {
                        $student = Student::select('party.id as id', 'students.id as _id', 'students.student_id', 'party.name as name', 'type.type', 'students.report_avetmiss')->with('latest_offer_letter.offer_course.course', 'latest_funded_course.course')
                            ->join('party as party', 'party.id', '=', 'students.party_id')
                            // ->join('party as party', 'party.id', '=', 'students.party_id')
                            ->join('student_types as type', 'type.id', '=', 'students.student_type_id')
                            ->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('students.student_id', 'like', '%' . $request->search . '%')
                            ->orWhere('type', 'like', '%' . $request->search . '%');
                    }else{
                        $student = Student::select('party.id as id', 'students.id as _id', 'students.student_id', 'party.name as name', 'type.type', 'students.report_avetmiss')->with('latest_offer_letter.offer_course.course', 'latest_funded_course.course')
                            ->join('party as party', 'party.id', '=', 'students.party_id')
                            // ->join('party as party', 'party.id', '=', 'students.party_id')
                            ->join('student_types as type', 'type.id', '=', 'students.student_type_id')
                            ->where('is_test', 0)
                            ->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('students.student_id', 'like', '%' . $request->search . '%')
                            ->orWhere('type', 'like', '%' . $request->search . '%');
                    }
                    // if(\Auth::user()->role())
                    // $student = Student::select('party.id as id', 'students.id as _id', 'students.student_id', 'party.name as name', 'type.type', 'students.report_avetmiss')->with('latest_offer_letter.offer_course.course', 'latest_funded_course.course')
                    //     ->join('party as party', 'party.id', '=', 'students.party_id')
                    //     // ->join('party as party', 'party.id', '=', 'students.party_id')
                    //     ->join('student_types as type', 'type.id', '=', 'students.student_type_id')
                    //     ->where('is_test', 0)
                    //     ->where('name', 'like', '%' . $request->search . '%')
                    //     ->orWhere('students.student_id', 'like', '%' . $request->search . '%')
                    //     ->orWhere('type', 'like', '%' . $request->search . '%');
                }
                // ->where('student_id', 'like', '%'.$request->search.'%')->where('name', 'like', '%'.$request->search.'%')->where('type', 'like', '%'.$request->search.'%');

                // $student = Student::where('student_id','like', '%' . $request->search . '%');
            } else {
                // dd($request->sort);
                if (\Auth::user()->hasRole('Demo')) {
                    $student = Student::select('party.id as id', 'students.id as _id', 'student_id', 'party.name as name', 'type.type', 'report_avetmiss')->with('latest_offer_letter.offer_course.course', 'latest_funded_course.course')->join('party as party', 'party.id', '=', 'students.party_id')->join('student_types as type', 'type.id', '=', 'students.student_type_id')->where('is_test', 0)->where('user_id', \Auth::user()->id)->orderBy($request->sort, $request->direction);
                } else {
                    if(\Auth::user()->hasRole('Super-Admin')){
                        $student = Student::select('party.id as id', 'students.id as _id', 'student_id', 'party.name as name', 'type.type', 'report_avetmiss')->with('latest_offer_letter.offer_course.course', 'latest_funded_course.course')->join('party as party', 'party.id', '=', 'students.party_id')->join('student_types as type', 'type.id', '=', 'students.student_type_id')->orderBy($request->sort, $request->direction);
                    }else{
                        $student = Student::select('party.id as id', 'students.id as _id', 'student_id', 'party.name as name', 'type.type', 'report_avetmiss')->with('latest_offer_letter.offer_course.course', 'latest_funded_course.course')->join('party as party', 'party.id', '=', 'students.party_id')->join('student_types as type', 'type.id', '=', 'students.student_type_id')->where('is_test', 0)->orderBy($request->sort, $request->direction);

                    }
                }
                // $student->orderBy($request->sort, $request->direction)->paginate(10);
                // dd($student->paginate(10));
            }
            // dd($student->orderBy($request->sort, $request->direction)->paginate(10));

        } else {
            // dd('heee');
            // dump('wew');
            if (\Auth::user()->hasRole('Demo')) {
                $student = Student::where('user_id', \Auth::user()->user_id)->orderBy('id', 'desc');
            } else {
                $student = Student::where('is_test',0)->orderBy('student_id', 'desc');
            }
        }
        // $student = Student::orderBy('id', 'desc')->paginate(10);
        // $student1 =  StudentResource::collection($student->paginate(10));
        // dd($student);
        /* $student1 = $student->get();
        $student1[0]->firstname = 'HELLO';
        return StudentResource::collection($this->paginate($student1)); */
        // dd($student1[0]);
        // dd('hee');
        return StudentResource::collection($student->paginate($request->limit));
    }

    public function search($student)
    {
        if (\Auth::user()->hasRole('Demo')) {
            $list = Party::with('student')->has('student')->where('name', 'like', '%' . $student . '%')->where('user_id', \Auth::user()->user_id)->orderBy('id', 'desc')->paginate(10);
        } else {
            $list = Party::with('student')->has('student')->where('name', 'like', '%' . $student . '%')->orderBy('id', 'desc')->paginate(10);
        }

        return PartyStudentResource::collection($list);
    }

    public function info($student)
    {
        $info = Student::with('party.person', 'type', 'checklist', 'english_test')->find($student);
        $type = Type::all();
        $country = AvtCountryIdentifier::orderBy('full_name')->get();
        $state = AvtStateIdentifier::orderBy('state_name')->get();
        $agent = AgentDetail::all();
        $email_trail = EmailWarningTrail::where('student_id', $info->student_id)->get();

        return response()->json(['student' => $info, 'type' => $type, 'country' => $country, 'state' => $state, 'agent' => $agent, 'emailTrail' => $email_trail]);
    }

    public function paginate($items, $perPage = 15, $page = null, $baseUrl = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        $lap = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);

        if ($baseUrl) {
            $lap->setPath($baseUrl);
        }

        return $lap;
    }


    public function top_search($search)
    {
        /* $students = Party::with('student', 'person')->whereHas('person', function($q){
            $q->where('person_type_id', 5);
        })->where('name', 'like', '%'.$search.'%')->orWhereHas('student', function($qq) use($search){
            $qq->where('student_id', 'like', '%'.$search.'%');
        })->get(); */

        if (\Auth::user()->hasRole('Demo')) {

            $user_id = \Auth::user()->id;
            $students = Party::with('student', 'person')->whereHas('student', function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })->whereHas('person', function ($q) {
                $q->where('person_type_id', 5);
            })->where('name', 'like', '%' . $search . '%')->orWhereHas('student', function ($qq) use ($search) {
                $qq->where('student_id', 'like', '%' . $search . '%');
            })->whereHas('student', function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })->get();
        } else {
            $students = Party::with('student', 'person')->whereHas('person', function ($q) {
                $q->where('person_type_id', 5);
            })->where('name', 'like', '%' . $search . '%')->orWhereHas('student', function ($qq) use ($search) {
                $qq->where('student_id', 'like', '%' . $search . '%');
            })->get();
        }



        $studs = [];
        foreach ($students as $stud) {
            $studs[] = [
                'student_name' => $stud->student->student_id . ' - ' . $stud->name,
                'name' => $stud->name,
                'student_id' => $stud->student->student_id,
                'student_type' => $stud->student->student_type_id,
                'student_table_id' => $stud->student->id,
            ];
        }

        return $studs;
    }

    public function generate_student_details($student_id)
    {
        $stud_details = Student::with('party.person', 'type', 'visa_details', 'funded_detail', 'funded_course.detail')->where('student_id', $student_id)->first();
        $stud_info = $stud_details->party->person;
        $stud_funded = $stud_details->funded_detail;

        if ($stud_details->type->type == 'Domestic') {
            $stud = $stud_details->with('funded_course.detail', 'contact_detail', 'funded_detail')->where('student_id', $student_id)->first();
            $stud_contact = $stud->contact_detail;
            // $stud_funded = $stud->funded_detail;
            $stud_courses = $stud->funded_course;

            if ($stud_funded != null || $stud_funded != '') {
                $user_id = $stud_funded->verified_by;
            } else {
                $user_id = '';
            }

            if ($stud_contact->state_id != null) {
                $state = AvtStateIdentifier::where('id', $stud_contact->state_id)->first();
                $state = $state->state_key;
            } else {
                $state = '';
            }

            $mobile = $stud_contact->phone_mobile;
            $telephone = $stud_contact->phone_home;
            $email = $stud_contact->email;
            $st_addr = $stud_contact->addr_street_num . ' ' . $stud_contact->addr_street_name;
            $address = $stud_contact->addr_suburb . ', ' . $state . ' ' . $stud_contact->postcode;

            $student_courses = [];
            foreach ($stud_courses as $course) {
                $status = OfferLetterStatus::where('id', $course->status_id)->first();
                if ($course->course_code != '@@@@') {
                    $course_ = Course::where('code', $course->course_code)->first();
                    $course_name = $course_->code . ' ' . '-' . ' ' . $course_->name;
                } else {
                    $course_name = 'Unit of Competency';
                }

                if($course->detail != null){
                    if($course->detail->study_reason_id != null || $course->detail->study_reason_id != ''){
                        $study_reason = AvtStudyReason::where('value', $course->detail->study_reason_id)->first();
                    }
                }
                
                $student_courses[] = [
                    'start_date'    => $course->start_date,
                    'end_date'      => $course->end_date,
                    'status'        => isset($status->description) ? $status->description : null,
                    'aiss_date'      => $course->aiss_date,
                    'course_code'   => $course->course_code == '@@@@' ? 'Unit of Competency' : $course->course_code,
                    'course_name'   => $course_name,
                    'remarks'       => $course->remarks,
                    'course_fee'    => $course->course_fee,
                    'study_reason'  => $study_reason != null ? $study_reason->description : '',
                ];
            }
        } else {

            $stud = OfferLetter::with(['student_details', 'course_details.course', 'course_details.payment_template', 'course_details.payments', 'course_details.funded_course.detail'])->where('student_id', $student_id)->first();
            $stud_contact = $stud->student_details->where('offer_letter_id', $stud->id)->first();
            // $stud_funded = '';
            $stud_courses = $stud->course_details;

            if ($stud_funded != null || $stud_funded != '') {
                $user_id = $stud_funded->verified_by;
            } else {
                $user_id = '';
            }

            $mobile = $stud_contact->mobile;
            $telephone = $stud_contact->telephone;
            $email = $stud->student_details->email_personal;
            $st_addr = '';
            $address = $stud->student_details->current_address;

            $student_courses = [];
            foreach ($stud_courses as $course) {

                $status = OfferLetterStatus::where('id', $course->status_id)->first();
                if ($course->course_code != '@@@@') {
                    $course_ = Course::where('code', $course->course_code)->first();
                    $course_name = $course_->code . ' ' . '-' . ' ' . $course_->name;
                } else {
                    $course_name = 'Unit of Competency';
                }

                if($course->funded_course->detail != null){
                    if($course->funded_course->detail->study_reason_id != null || $course->funded_course->detail->study_reason_id != ''){
                        $study_reason = AvtStudyReason::where('value', $course->funded_course->detail->study_reason_id)->first();
                    }
                }

                $student_courses[] = [
                    'start_date'    => $course->course_start_date,
                    'end_date'      => $course->course_end_date,
                    'status'        => $status->description,
                    'aiss_date'     => '',
                    'course_code'   => $course->course_code == '@@@@' ? 'Unit of Competency' : $course->course_code,
                    'course_name'   => $course_name,
                    'remarks'       => $course->remarks,
                    'course_fee'    => $course->course_fee,
                    'study_reason'  => $study_reason != null ? $study_reason->description : '',
                ];
            }
        }

        // dd($stud_funded);
        // STUDENT DETAILS (AVETMISS)
        $arr_student_details = [];
        if ($stud_funded != '') {
            // dump($stud_funded);
            $arr_disability_val = [];
            $arr_pea_val = [];
            $arr_country_val = [];

            // disability_ids multiselect
            if ($stud_funded->disability_ids != null) {
                $disability = null;

                if ($stud_funded->disability_ids != '') {
                    $disability = explode(',', $stud_funded->disability_ids);
                }

                if ($disability !== null) {
                    foreach ($disability as $key => $dis) {
                        $dis = AvtDisabilityTypes::where('value', $dis)->first();
                        // $arr_disability_val[] = [
                        //     'id'        => $dis['value'],
                        //     'value'     => $dis['description']
                        // ];
                        array_push($arr_disability_val, $dis['description']);
                    }
                }
                $disability = implode(',', $arr_disability_val);
            } else {
                $disability = '';
            }


            // prior_educational_achievement_ids multiselect
            if ($stud_funded->prior_educational_achievement_ids != null) {
                $pea = null;
                if ($stud_funded->prior_educational_achievement_ids != '') {
                    $pea = explode(',', $stud_funded->prior_educational_achievement_ids);
                }
                if ($pea !== null) {

                    foreach ($pea as $key => $p) {
                        $p = AvtPriorEducationAchievement::where('value', $p)->first();
                        // $arr_pea_val[] = [
                        //     'id'        => $p['value'],
                        //     'value'     => $p['description']
                        // ];
                        array_push($arr_pea_val, $p['description']);
                    }
                }
                $prior_ed = implode(',', $arr_pea_val);
            } else {
                $prior_ed = '';
            }


            // country_id singleselect
            if ($stud_funded->country_id != null) {
                $c = AvtCountryIdentifier::where('identifier', $stud_funded->country_id)->first();
                $arr_country_val = [
                    'id'        => $c['identifier'],
                    'value'     => $c['full_name']
                ];
            }

            if ($stud_funded->highest_school_level_completed_id != null) {
                $hslc = AvtHighestSchlLvlCompleted::where('value',  $stud_funded->highest_school_level_completed_id)->first();
                $hslc = $hslc->description;
            } else {
                $hslc = '';
            }
            if ($stud_funded->location != null) {
                $loc = AvtStateIdentifier::where('state_key', $stud_funded->location)->first();
                $loc = $loc->state_name;
            } else {
                $loc = '';
            }
            if ($stud_funded->indigenous_status_id != null) {
                $ind = AvtClientIndigenousStatus::where('value', $stud_funded->indigenous_status_id)->first();
                $ind = $ind->description;
            } else {
                $ind = '';
            }
            if ($stud_funded->language_id != null) {
                $lang = AvtLangIdentifier::where('value', $stud_funded->language_id)->first();
                $lang = $lang->description;
            } else {
                $lang = '';
            }

            if ($stud_funded->labour_force_status_id != null) {
                $labour = AvtLabourForceStatus::where('value', $stud_funded->labour_force_status_id)->first();
                $labour = $labour->status;
            } else {
                $labour = '';
            }

            if ($stud_funded->survey_contact_status != null) {
                $survey = AvtSurveyContactStatus::where('value', $stud_funded->survey_contact_status)->first();
                $survey = $survey->description;
            } else {
                $survey = '';
            }

            $arr_student_details = [
                'id'                                    => $stud_funded->id,
                // 'student_id'                            => $student->student_id,
                // 'vetrack_id'                            => $stud_funded->vetrack_id,
                'location'                              => $loc,
                // 'funded_student_contact_detail_id'      => $stud_contact->id,
                // 'name_for_encryption'                   => $stud_funded->name_for_encryption,
                'highest_school_level_completed_id'     => $hslc,
                'indigenous_status_id'                  => $ind,
                'language_id'                           => $lang,
                'labour_force_status_id'                => $labour,
                'country_id'                            => $arr_country_val,
                'disability_flag'                       => $stud_funded->disability_flag,
                'disability_ids'                        => $disability,
                'prior_educational_achievement_flag'    => $stud_funded->prior_educational_achievement_flag,
                'prior_educational_achievement_ids'     => $prior_ed,
                'at_school_flag'                        => $stud_funded->at_school_flag,
                // 'verified'                              => $stud_funded->verified,
                // 'unique_student_id'                     => $stud_funded->unique_student_id,
                'survey_contact_status'                 => $survey,
                'statistical_area_level_1_id'           => $stud_funded->statistical_area_level_1_id,
                'statistical_area_level_2_id'           => $stud_funded->statistical_area_level_2_id,
                'year_completed'                        => $stud_funded->year_completed,
                'institute'                             => $stud_funded->institute,

            ];
        }
        // dd($arr_student_details);

        $verified_by = \Auth::user()->with('party.person')->where('id', $user_id)->first();
        if ($stud_details->visa_details != null) {
            $visa_type = VisaStatus::where('id', $stud_details->visa_details->visa_type)->first();
        }

        $info = [
            'student_details'   => $stud_details,
            'details'           => $stud_info,
            'courses'           => $student_courses,
            'contact'           => $stud_contact,
            'email'             => $email,
            'mobile'            => $mobile,
            'telephone'         => $telephone,
            'st_address'        => $st_addr,
            'address'           => $address,
            'usi'               => isset($stud_funded) ? $stud_funded : '',
            'usi_verified_by'   => isset($verified_by) ? $verified_by->party->name : '',
            'visa_details'      => isset($stud_details->visa_details) ? $stud_details->visa_details : '',
            'visa_type'         => isset($visa_type) ? $visa_type->visa : '',
            'avetmiss'          => $arr_student_details,
        ];
        // dd($info);
        // Company Details
        $com_setting = TrainingOrganisation::first();
        if ($com_setting->logo_img != null) {
            $logo = 'storage/config/images/' . $com_setting->logo_img;
        } else {
            $logo = 'images/logo/vorx_logo.png';
        }
        $logo_url = url('/' . $logo . '');

        if ($com_setting->training_organisation_id != '') {
            $rto_code = $com_setting->training_organisation_id;
        } else {
            $rto_code = '';
        }
        $file_name = $student_id . ' - ' . $stud_details->party->name . '.pdf';
        return \PDF::loadView('students.student_details_pdf', compact('info', 'logo_url', 'rto_code'))->setPaper(array(0, 0, 595, 842), 'portrait')->stream($file_name);
    }

    public function update_avetmiss_report($student_id, $value)
    {
        $student = Student::with(['party.person', 'contact_detail', 'offer_letter.course_details.funded_course', 'offer_letter.course_details.course_completion.completion.details', 'funded_course.course_completion.completion.details', 'funded_detail'])->where('student_id', $student_id)->first();
        $valid = 0;
        $errors = [];
        
        // dd($student->offer_letter->toArray());

        $check = [
            'funded_detail' => [
                'highest_school_level_completed_id' => 'Highest School Level Completed',
                'indigenous_status_id' => 'Indigenous Status',
                'language_id' => 'Language Identifier',
                'labour_force_status_id' => 'Labour Force Status',
                'country_id' => 'Country',
                'disability_flag' => 'Disability',
                'prior_educational_achievement_flag' => 'Prior Educational Achievement',
                'at_school_flag' => 'At School',
                'unique_student_id' => 'USI',
            ],
            'person' => [
                'gender' => 'Gender',
                'date_of_birth' => 'Date of Birth',
                'student_name' => 'Student Name'
            ],
            'contact_detail' => [
                'postcode' => 'Postcode',
                'state_id' => 'State',
                'addr_suburb' => 'Suburb',
                'addr_street_num' => 'Street Number',
                'addr_street_name' => 'Street Name',
                // 'phone' => 'Phone Number',
                // 'email' => 'Email',
            ],
            'course_detail' => [
                'funding_source_national' => 'Funding Source National',
                'commence_prg_identifier' => 'Commencing Course',
                'study_reason_id' => 'Study Reason',
                'predominant_delivery_mode' => 'Predominant Delivery Mode',
            ],
            'offer_letter' => [
                'shore_type' => 'Shore Type / Student Location'
            ]
        ];
        
        // dd($check['course_detail']);

        if ($student) {
            if ($student->report_avetmiss == 0) {
                // Validate course completion
                if($student->student_type_id == 2){
                    // domestic students
                    if(isset($student->funded_course[0])) {
                        foreach ($student->funded_course as $value) {
                            $course_dets = [];
                            // dump($value->report_course_status_id);
                            if(isset($value->course_completion->completion->id) && $value->report_course_status_id != 1) {
                                if(in_array($value->course_completion->completion->completion_status_id, [3,5]) && $value->course_completion->completion->partial_completion == 1) {
                                    $valid = 1;
                                }else{
                                    $course_dets[] = 'Course progress is not yet updated';
                                }

                                // check delivery mode per unit
                                $valUnitDelMode = 0;
                                foreach ($value->course_completion->completion->details as $kkk => $vvv) {
                                    if(in_array($vvv->delivery_mode_id, ['', null])) {
                                        $valUnitDelMode = 1;
                                    }
                                }
                                if($valUnitDelMode == 1) {
                                    $course_dets[] = 'Delivery Mode must be updated';
                                }

                            }

                            if($valid == 0 && count($course_dets) == 0) {
                                $errors['data'][] = 'No course available';
                            }else{
                                // funded course details
                                if(isset($value->detail->id)) {
                                    $fund_course_det = $value->detail->toArray();
                                    // dump($fund_course_det);
                                    foreach ($check['course_detail'] as $key => $v) {
                                        if( in_array($fund_course_det[$key], ['', null]) ) {
                                            $course_dets[] = $v . ' is required';
                                        }
                                    }
                                }
        
                                if( count($course_dets) > 0 ) {
                                    $errors['courses'][$value->course_code] = $course_dets;
                                }
                            }
    
                            
                        }
                    }else {
                        $errors['data'][] = 'No course available';
                    }
                }else{
                    // international students
                    if(isset($student->offer_letter[0])) {
                        foreach($student->offer_letter as $kk => $vv) {

                            foreach($vv->course_details as $value) {
                                $course_dets = [];
                                // dump($value->course_completion);
                                if(isset($value->course_completion->completion->id) && isset($value->funded_course) && $value->funded_course->report_course_status_id != 1) {
                                    if(in_array($value->course_completion->completion->completion_status_id, [3,5]) && $value->course_completion->completion->partial_completion == 1) {
                                        $valid = 1;
                                    }else{
                                        $course_dets[] = 'Course progress is not yet updated';
                                    }

                                    // check shore type 
                                    if(!in_array($vv->shore_type, ['ONSHORE', 'OFFSHORE'])) {
                                        $errors['data'][] = 'Shore Type / Student Location is required';
                                    }
                                    
                                    // check delivery mode per unit
                                    $valUnitDelMode = 0;
                                    foreach ($value->course_completion->completion->details as $kkk => $vvv) {
                                        if(in_array($vvv->delivery_mode_id, ['', null])) {
                                            $valUnitDelMode = 1;
                                        }
                                    }
                                    if($valUnitDelMode == 1) {
                                        $course_dets[] = 'Delivery Mode must be updated';
                                    }
                                
                                }

                                if($valid == 0 && count($course_dets) == 0) {
                                    $errors['data'][] = 'No course available';
                                }else{
                                    // funded course details
                                    if(isset($value->funded_course->detail->id)) {
                                        $fund_course_det = $value->funded_course->detail->toArray();
                                        // dump($fund_course_det);
                                        foreach ($check['course_detail'] as $key => $v) {
                                            if( in_array($fund_course_det[$key], ['', null]) ) {
                                                $course_dets[] = $v . ' is required';
                                            }
                                        }
                                    }
        
                                    if( count($course_dets) > 0 ) {
                                        $errors['courses'][$value->course_code] = $course_dets;
                                    }
                                }
                            }
                        }
                    }else{
                        $errors['data'][] = 'No course available';
                    }
                }

                // validate required avetmiss data
                foreach ($check as $k => $v) {
                    foreach ($v as $kk => $vv) {
                        switch ($k) {
                            case 'funded_detail':
                                if(isset($student->funded_detail->id)){
                                    $d = $student->funded_detail->toArray();
                                    if( is_null($d[$kk]) ) {
                                        $errors['data'][] = $vv . ' is required';
                                        $valid = 0;
                                    }
                                    if($kk == 'disability_flag' && $d[$kk] == 'Y' && in_array($d['disability_ids'], ['', null])) {
                                        $errors['data'][] = $vv . ' types must be inputed if yes';
                                        $valid = 0;
                                    }
                                    if($kk == 'prior_educational_achievement_flag' && $d[$kk] == 'Y' && in_array($d['prior_educational_achievement_ids'], ['', null])) {
                                        $errors['data'][] = $vv . ' types must be inputed if yes';
                                        $valid = 0;
                                    }
                                }
                                break;
                            case 'person':
                                if(isset($student->party->person->id)){
                                    $d = $student->party->person->toArray();
                                    if( $kk == 'student_name' ) {
                                        if(in_array($d['firstname'], ['', null]) && in_array($d['lastname'], ['', null])){
                                            $errors['data'][] = $vv . ' is required';
                                            $valid = 0;
                                        }
                                    }elseif( is_null($d[$kk]) ) {
                                        $errors['data'][] = $vv . ' is required';
                                        $valid = 0;
                                    }
                                }
                                break;
                            case 'contact_detail':
                                if(isset($student->contact_detail->id)){
                                    $d = $student->contact_detail->toArray();
                                    if( $kk == 'phone' ) {
                                        if(in_array($d['phone_home'], ['', null]) && in_array($d['phone_work'], ['', null]) && in_array($d['phone_mobile'], ['', null])){
                                            $errors['data'][] = $vv . ' is required';
                                            $valid = 0;
                                        }
                                    }elseif( is_null($d[$kk]) ) {
                                        $errors['data'][] = $vv . ' is required';
                                        $valid = 0;
                                    }
                                }
                                break;
                        }
                    }
                }

                $value = 1;
            } else {
                $valid = 1;
                $value = 0;
            }
            // dd($errors);
            // dd($student);
            $valid = count($errors) > 0 ? 0 : 1;
            
            if($valid == 1) {
                $student->report_avetmiss = $value;
                $student->update();
                return ['status' => 'success', 'value' => $student->report_avetmiss, 'errors' => $errors];
            }else {
                return ['status' => 'error', 'value' => $student->report_avetmiss, 'errors' => $errors];
            }
        } else {
            return ['status' => 'error', 'message' => 'Nothing to update'];
        }
    }

    public function update_report_course_status(Request $request)
    {
        $funded_course = FundedStudentCourse::with('student')->where('id', $request->id)->first();
        $funded_course->report_course_status_id = $request->report_course_status_id;
        $funded_course->update();
        
        if($request->prevReportCourseId != 2 || $request->report_course_status_id != 3){
            $funded_course->student->report_avetmiss = 0;
            $funded_course->student->update();
        }

        return ['status' => 'success'];
    }

    public function check_student($details)
    {

        $result = false;
        $name = preg_replace('/\s+/', ' ', $details->firstname . ' ' . $details->middlename . ' ' . $details->lastname);
        $dob = $details->date_of_birth;

        $student = Student::with(['party', 'party.person'])->whereHas('party', function ($q) use ($name) {
            $q->where('name', 'like', '%' . $name . '%'); // student name
        })->whereHas('party.person', function ($q) use ($dob) {
            $q->where('date_of_birth', 'LIKE', '%' . $dob . '%'); // student dob
        })->first();

        if ($student != null) {
            $result = true;
        }

        return $result;
    }

    // Logins for student portal
    public function fetch_logins($student_id)
    {
        // dd($student_id);
        $stud = Student::with('party.user')->where('student_id', $student_id)->first();

        return ['party' => $stud->party];
    }

    public function store_logins(Request $request)
    {
        // dd($request->user['make_password']);

        $stud = Student::with('party.user')->where('student_id', $request->student_id)->first();
        $user = null;
        if ($stud->party->user) {
            $user = $stud->party->user;
            $user->fill($request->user);
            if (isset($request->user['make_password']) && !in_array($request->user['make_password'], ['', null])) {
                $user->password = Hash::make($request->user['make_password']);
            }
            $user->update();
        } else {
            $user = new User;
            $user->username = $request->user['username'];
            if (isset($request->user['make_password']) && !in_array($request->user['make_password'], ['', null])) {
                $user->password = Hash::make($request->user['make_password']);
            }
            $user->is_active = isset($request->user['is_active']) && !in_array($request->user['is_active'], [0, null, false]) ? 1 : 0;
            $user->profile_image = 'default-profile.png';
            $user->party()->associate($stud->party);
            $user->save();
            $user->assignRole('Student');
        }

        return ['status' => 'success', 'user' => $user];
    }

    public function fetch_student($student_id)
    {
        $stud = Student::with(['party.person'])->where('student_id', $student_id)->first();

        return $stud;
    }

    public function check_enrolment($process_id, $type = 'agent_email')
    {
        $enrolment_form = null;
        
        switch (config('app.name')) {
            case 'CEA':
                if(Storage::exists('/public/enrolment/international/' . $process_id . '/enrolment-form.txt')) {
                    $enrolment_form = Storage::get('/public/enrolment/international/' . $process_id . '/enrolment-form.txt');
                    $enrolment_form = json_decode($enrolment_form,true);
                    if($type == 'agent_email') {
                        $agentEmail = isset($enrolment_form[4]['component'][1]['inputs'][4]['value']) ? $enrolment_form[4]['component'][1]['inputs'][4]['value'] : null;
                        if($agentEmail && filter_var($agentEmail, FILTER_VALIDATE_EMAIL)) {
                            return $agentEmail;
                        }
                    }
                }
                break;
            case 'Phoenix':
                if(Storage::exists('/public/enrolment/' . $process_id . '/enrolment-form.txt')) {
                    $enrolment_form = Storage::get('/public/enrolment/' . $process_id . '/enrolment-form.txt');
                    $enrolment_form = json_decode($enrolment_form,true);
                    if($type == 'agent_email') {
                        $agentEmail = isset($enrolment_form[3]['component'][2]['inputs'][4]['value']) ? $enrolment_form[3]['component'][2]['inputs'][4]['value'] : null;
                        if($agentEmail && filter_var($agentEmail, FILTER_VALIDATE_EMAIL)) {
                            return $agentEmail;
                        }
                    }
                }
                break;
        }      
        return null;
    }

    public function change_type($student_id,$type){
        // dd('hi');
        $student_type = $type =='true' ? 2 : 1 ;
        $student = Student::where('student_id',$student_id)->first();

        foreach($student->funded_course as $funded_course){
            $completion = CompletionStudentCourse::where('student_course_id',$funded_course->id)->where('student_type',$student->student_type_id)->first();
            if($completion != null){
                $completion->student_type = $student_type;
                $completion->save();
            }
        }
        $student->student_type_id = $student_type ;
        $student->save();
        if($student_type == 2){
            return ['status' => 'success' ,'type' => 'domestic' ,'student' => $student->id];
        }else{
            return ['status' => 'success' ,'type' => 'international' ,'student' => $student->id];
        }
    }
}
