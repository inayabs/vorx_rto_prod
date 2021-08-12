<?php

namespace App\Http\Controllers\NewStudent;

use DB;
use App\Http\Controllers\Controller;
use App\Models\AvtClientIndigenousStatus;
use App\Models\AvtCountryIdentifier;
use App\Models\AvtDisabilityTypes;
use App\Models\AvtHighestSchlLvlCompleted;
use App\Models\AvtLabourForceStatus;
use App\Models\AvtLangIdentifier;
use App\Models\AvtPostcode;
use App\Models\AvtPriorEducationAchievement;
use App\Models\AvtStateIdentifier;
use App\Models\AvtSurveyContactStatus;
use App\Models\FundedStudentContactDetails;
use App\Models\FundedStudentDetails;
use App\Models\FundedStudentVisaDetails;
use App\Models\FundedStudentCourse;
use App\Models\AgentDetail;
use App\Models\CourseMatrix;
use App\Models\CoursePackage;
use App\Models\Student\Student;
use App\Models\TrainingOrganisation;
use App\Models\VisaStatus;

use App\Models\TrainingDeliveryLoc;
use App\Models\Course;
use App\Models\Unit;
use App\Models\OfferLetterStatus;
use App\Models\StudentClass;

use App\Models\AvtCommencingCourse;
use App\Models\AvtCompletionStatus;
use App\Models\AvtFundingSourceNational;
use App\Models\AvtFundingSourceState;
use App\Models\AvtOutcomeStatus;
use App\Models\AvtPredominantDlvrMode;
use App\Models\AvtSpecificFunding;
use App\Models\AvtStudyReason;
use App\Models\AvtFundingType;
use App\Models\AvtDeliveryMode;
use App\Models\StudentCompletionDetail;
use App\Models\PaymentStatus;
use App\Models\CommissionStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function student(Student $student)
    {
        $app_setting = TrainingOrganisation::first();
        $visa =  VisaStatus::select(DB::raw('id, IF(id=1, "Not Applicable", concat(type, " - ", visa)) AS value'))->orderBy('value', 'asc')->get();
        $states = AvtStateIdentifier::orderBy('state_name')->pluck('state_name', 'state_key');
        $agent = AgentDetail::all();
        // avetmiss
        $slct_labour_force_status = AvtLabourForceStatus::pluck('status', 'value');
        $slct_schl_lvl_completed = AvtHighestSchlLvlCompleted::pluck('description', 'value');
        $slct_indigenous_status = AvtClientIndigenousStatus::pluck('description', 'value');
        $slct_lang_identifer = AvtLangIdentifier::orderBy('description', 'asc')->pluck('value', 'description');
        $slct_survey_contact_status = AvtSurveyContactStatus::pluck('description', 'value');
        $slct_postcode = AvtPostcode::orderBy('suburb')->get();
        $slct_postcode = $slct_postcode->map(function ($item) {
            return ['id' => $item->id, 'value' => $item->postcode . ' '. $item->suburb .' , '. $item->state];
        });
        $slct_country = AvtCountryIdentifier::orderBy('full_name', 'asc')->get();
        $slct_country = $slct_country->map(function ($item) {
            return ['id' => $item->identifier, 'value' => $item->full_name];
        });
        $slct_disability = AvtDisabilityTypes::all();
        $slct_disability = $slct_disability->map(function($item){
            return ['id'=> $item->value,'value'=> $item->description];
        });
        $slct_educ_achievement = AvtPriorEducationAchievement::all();
        $slct_educ_achievement = $slct_educ_achievement->map(function ($item) {
            return ['id' => $item->value, 'value' => $item->description];
        });

        $offer_packages = CoursePackage::with('detail.course.detail')->get();
        $offer_matrix = CourseMatrix::with('detail')->get();

        // course details
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
        // select course
        if ($slct_course != null) {
            $slct_course = $slct_course->merge($unit_com);
        } else {
            $slct_course = $unit_com;
        }
        $payment_status = PaymentStatus::all();
        $comm_status = CommissionStatus::all();
        $student_status = OfferLetterStatus::whereIn('id', [1, 3, 4, 5, 7])->get();
        $slct_offer_lttr_statuses = $student_status->pluck('description', 'id');
        $slct_completion_statuses = AvtCompletionStatus::all(); 
        $slct_class = StudentClass::select(DB::raw("CONCAT(`desc`) AS description"), 'id')->pluck('description', 'id');
        $slct_state = AvtStateIdentifier::orderBy('state_name')->pluck('state_name', 'state_key');
        // ENROLMENT DETAILS
        $slct_dlvr_mode = AvtDeliveryMode::pluck('description', 'value');
        $slct_com_course = AvtCommencingCourse::pluck('description', 'value');
        $slct_funding_source_national = AvtFundingSourceNational::pluck('description', 'value');
        $slct_funding_source_state = AvtFundingSourceState::pluck('description', 'value');
        $slct_outcome_status = AvtOutcomeStatus::pluck('description', 'value');
        $slct_predom_dlvr_mode = AvtPredominantDlvrMode::pluck('description', 'value');
        $slct_specific_fund = AvtSpecificFunding::pluck('description', 'identifier');
        $slct_study_reason = AvtStudyReason::pluck('description', 'value');
        $slc_funding_type = AvtFundingType::all();
        \JavaScript::put([
            'app_settings' => $app_setting,
            'student_id' => $student->student_id,
            'payment_status' => $payment_status,
            'comm_status'   => $comm_status,
            'visa' => $visa,
            'slct_labour_force_status' => $slct_labour_force_status,
            'slct_schl_lvl_completed' => $slct_schl_lvl_completed,
            'slct_indigenous_status' => $slct_indigenous_status,
            'slct_lang_identifer' => $slct_lang_identifer,
            'slct_survey_contact_status' => $slct_survey_contact_status,
            'slct_postcode' => $slct_postcode,
            'slct_country' => $slct_country,
            'slct_disability' => $slct_disability,
            'slct_educ_achievement' => $slct_educ_achievement,
            'offer_package' => $offer_packages,
            'offer_non_package' => $offer_matrix,
            'states' => $states,
            'agents' => $agent,
            // COURSE DETAILS
            'student' => $student->id,
            'slct_course' => $slct_course,
            'slct_class' => $slct_class,
            'courses'   => $courses,
            'student_status' => $student_status,
            'slct_state' => $slct_state,
            'slct_offer_lttr_statuses' => $slct_offer_lttr_statuses,
            'slct_training_dlvr_loc' => $slct_training_dlvr_loc,
            'slct_dlvr_mode' => $slct_dlvr_mode,
            'slct_com_course' => $slct_com_course,
            'slct_funding_source_national' => $slct_funding_source_national,
            'slct_funding_source_state' => $slct_funding_source_state,
            'slct_outcome_status' => $slct_outcome_status,
            'slct_predom_dlvr_mode' => $slct_predom_dlvr_mode,
            'slct_specific_fund' => $slct_specific_fund,
            'slct_study_reason' => $slct_study_reason,
            'slc_funding_type' => $slc_funding_type,
            'slct_completion_statuses' => $slct_completion_statuses,
            'units' => Unit::all(),
            'demoUser' => \Auth::user()->hasRole('Demo'),
        ]);
        return view('students.new.show');
    }

    public function show(Student $student)
    {
        // $student->load(['party.person']);
        // $data = collect($student)->except('id', 'user_id', 'party_id', 'party.id', 'party.person.id', 'party.person.party_id');
          $student->load(
            [
                'party.person',
                'party.user',
                'type',
                'contact_detail.postcode',
                'latest_offer_letter.student_details',
                'funded_detail',
                'visa_details.type:id,visa',
                'invoice',
                'funded_course.course',
                'funded_course.attendance'=>function($q) use($student){
                    $q->where('student_id',$student->student_id);
                },
                'funded_course.attendance.student_class',
                'funded_course.attendance.attendance_details'=>function($q){
                    $q->orderBy('id','desc');
                },
                'funded_course.status',
                'funded_course.detail.funding_type',
                'funded_course.course_completion.completion.details.unit', // student_course_id by funded course id (course_completion)
                'funded_course.course_completion.completion.certificate.', // student_course_id by funded course id (course_completion)
                'funded_course.course_completion_by_ol.completion.details.unit', // student_course_id by offer_letter_course_detail_id (course_completion)
                'funded_course.course_completion_by_ol.completion.certificate.details', // student_course_id by offer_letter_course_detail_id (course_completion)
                'funded_course.payment_details.attachment',
                'funded_course.payment_sched',
                'enrolment_pack.funded_course.attendance'=>function($q) use($student){
                    $q->where('student_id',$student->student_id);
                },
                'enrolment_pack.funded_course.attendance.student_class',
                'enrolment_pack.funded_course.attendance.attendance_details'=>function($q){
                    $q->orderBy('id','desc');
                },
                'enrolment_pack.funded_course.course',
                'enrolment_pack.funded_course.status',
                'enrolment_pack.funded_course.detail.funding_type',
                'enrolment_pack.funded_course.course_completion.completion.details.unit', // student_course_id by funded course id (course_completion)
                'enrolment_pack.funded_course.course_completion.completion.certificate.details', // student_course_id by funded course id (course_completion)
                'enrolment_pack.funded_course.course_completion_by_ol.completion.details.unit', // student_course_id by offer_letter_course_detail_id (course_completion)
                'enrolment_pack.funded_course.course_completion_by_ol.completion.certificate.details', // student_course_id by offer_letter_course_detail_id (course_completion)
                'enrolment_pack.funded_course.payment_details.attachment',
                'enrolment_pack.funded_course.payment_sched',
                'completion.details',
                'enrolment_pack.offer_letter.fees',
                'enrolment_pack.offer_letter.course_details',
                'enrolment_pack.offer_letter.student_details',
                'notes.user.party',
                'warning_history.template'
                ]
            );
        return  $student;
    }

    public function storeupdate(Request $request)
    {
        // UPDATE PERSONAL TAB 
        $student = Student::where('student_id', $request->student_id)->first();
        if ($student == null) {
            return response()->json(['status' => 'error', 'message' => 'Student ID does not exist'], 500);
        }
        try {
            $party = $student->party;
            $person = $student->party->person;
            $person->firstname = $request->firstname;
            $person->lastname = $request->lastname;
            $person->middlename = $request->middlename;
            $person->prefix = $request->prefix;
            $person->gender = $request->gender;
            $person->date_of_birth = $request->date_of_birth != '' ? Carbon::parse($request->date_of_birth)->timezone('Australia/Melbourne')->format('Y-m-d') : null;
            $person->update();
            $fullname = $person->full_name;
            $party->name = $fullname;
            $party->update();
            $data = $request->all();
            $data['name'] = $fullname;
            return response()->json(['status' => 'success', 'data' => $data], 200);

            //code...
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function contact_storeupdate(Request $request){
        $inputs = $request->except('home_address');
        if (count($request['addr_suburb']) != 0) {
            $suburb = $request['addr_suburb']; 
            $suburb_id = $suburb['id'];
            $postcode = AvtPostcode::where('id', $suburb_id)->first();
            $suburb = $postcode->suburb;
            $state = AvtStateIdentifier::where('state_key', $postcode->state)->first();
            $state_id = $state->id;

            $inputs['addr_suburb'] = $suburb;
            $inputs['postcode'] = $postcode->postcode;
            $inputs['state_id'] = $state_id;
        }
        try {
            DB::beginTransaction();
            $home_address = $request->home_address; 
            FundedStudentContactDetails::updateOrCreate([
                'id' => $request->id,
                'student_id' => $request->student_id,
            ],[$inputs]);
            $student = Student::where('student_id',$request->student_id)->first();
            $shome = $student->latest_offer_letter->student_details;
            $shome->home_address = $home_address;
            $shome->update();
            DB::commit();
            return response()->json(['status'=>'success','data'=>$request->all()]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return response()->json(['status'=>'error','message'=>$th->getMessage()]);
        }
    }

    public function visa_storeupdate(Request $request){
        
        $inputs = $request->all();
        $inputs['issue_date'] = $inputs['issue_date']  != null ? Carbon::parse($inputs['issue_date'])->timezone('Australia/Melbourne')->format('Y-m-d') : $inputs['issue_date'];
        $inputs['expiry_date'] = $inputs['expiry_date']  != null ? Carbon::parse($inputs['expiry_date'])->timezone('Australia/Melbourne')->format('Y-m-d') : $inputs['expiry_date'];
        $inputs['expiry_date_visa_type'] = $inputs['expiry_date_visa_type']  != null ? Carbon::parse($inputs['expiry_date_visa_type'])->timezone('Australia/Melbourne')->format('Y-m-d') : $inputs['expiry_date_visa_type'];
        $inputs['visa_type'] = $inputs['visa_type'] != null ? $inputs['visa_type']['id'] : $inputs['visa_type'];
        try {
            DB::beginTransaction();
            FundedStudentVisaDetails::updateOrCreate([
                'student_id'=>$request->student_id
            ], $inputs);
            DB::commit();
            return response()->json(['status' => 'success', 'data' => $request->all()]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
    public function avetmiss_storeupdate(Request $request){
        $inputs = $request->all();
        $disability = [];
        $pea = [];
        $country = [];
        foreach ($inputs['disability_ids'] as $key => $value) {
            array_push($disability, $value['id']);
        }
        // prior_educational_achievement_ids
        foreach ($inputs['prior_educational_achievement_ids'] as $key => $value) {
            array_push($pea, $value['id']);
        }

        foreach ($inputs['country_id'] as $key => $value) {
            array_push($country, $value['id']);
        }

        $disability = implode(',', $disability);
        $pea = implode(',', $pea);
        $country = implode(',', $country);

        $inputs['disability_ids'] = $disability;
        $inputs['prior_educational_achievement_ids'] = $pea;
        $inputs['country_id'] = $country;
        try {
            //code...
            DB::beginTransaction();
            FundedStudentDetails::updateOrCreate([
                'student_id'=> $request->student_id
            ], $inputs);
            DB::commit();
            return response()->json(['status'=>'success','data'=>$request->all()]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
    public function certcompletion_storeupdate(Request $request){
        dd($request->all());
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
    public function completion_storeupdate(Request $request){
        try {
            DB::beginTransaction();
            foreach($request->all() as $unit){
                // dd($unit['id']);
               $detail =  StudentCompletionDetail::find($unit['id']);
                if (in_array($unit['completion_status_id'], [3, 4, 6, 7])) {
                    $cert_units[] = $unit;
                }
               $detail->actual_start = $unit['actual_start'] != '' ? Carbon::parse($unit['actual_start'])->timezone('Australia/Melbourne')->format('Y-m-d') : '';
               $detail->actual_end = $unit['actual_end'] != '' ? Carbon::parse($unit['actual_end'])->timezone('Australia/Melbourne')->format('Y-m-d') : '';
               $detail->completion_status_id = $unit['completion_status_id'];
               $detail->update();
               
               
            }
            $completion = $detail->completion;
            if(count($request->all()) <= 5){
                $completion->completion_status_id  = 5;
                $completion->update();
            }else{
                if(count($cert_units) == count($request->all())){
                    // dd('cert');
                    $completion->completion_status_id  = 3;
                    $completion->update();
                }else{
                    // dd('notcert');  
                    $completion->completion_status_id  = 5;
                    $completion->update();
                }

            }
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Updated Successfully.']);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
}
