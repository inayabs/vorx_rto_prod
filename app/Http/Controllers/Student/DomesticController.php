<?php

namespace App\Http\Controllers\Student;

use Validator;
use Auth;
use DB;
use Illuminate\Support\Str;

use Carbon\Carbon;
use App\Models\Agent;
use App\Models\AvtCompletionStatus;
use App\Models\Student\Type;
use App\Models\Student\Party;
use App\Models\PaymentStatus;
use App\Models\Student\Person;
use App\Models\Student\Student;
use App\Models\FundedStudentContactDetails;
use App\Models\FundedStudentDetails;
use App\Models\FundedStudentPaymentDetails;
use App\Models\CommissionStatus;
use App\Models\OfferLetterStatus;
use App\Http\Resources\StudentResource;
use App\Http\Resources\PartyStudentResource;
use App\Http\Controllers\Controller;
use App\Http\Controllers\StudentClass\TimeTableController;
use App\Models\AgentDetail;
use App\Models\CompletionStudentCourse;
use App\Models\AvtHighestSchlLvlCompleted;
use App\Models\AvtClientIndigenousStatus;
use App\Models\AvtLabourForceStatus;
use App\Models\AvtFundingType;
use App\Models\AvtLangIdentifier;
use App\Models\AvtDisabilityTypes;
use App\Models\AvtCountryIdentifier;
use App\Models\AvtStateIdentifier;
use App\Models\AvtPostcode;
use App\Models\AvtPriorEducationAchievement;
use App\Models\AvtDeliveryMode;
use App\Models\AvtSurveyContactStatus;

use App\Models\AvtCommencingCourse;
use App\Models\AvtFundingSourceNational;
use App\Models\AvtFundingSourceState;
use App\Models\AvtOutcomeStatus;
use App\Models\AvtPredominantDlvrMode;
use App\Models\AvtSpecificFunding;
use App\Models\AvtStudyReason;

use App\Models\VisaStatus;
use App\Models\FundedStudentVisaDetails;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Models\FundedStudentCourse;
use App\Models\FundedStudentCourseDetail;
use App\Models\FundedStudentExtraUnits;
use App\Models\Course;
use App\Models\Unit;
use App\Models\CourseMatrix;
use App\Models\FundedCourseMatrices;
use App\Models\CourseProspectus;
use App\Models\TrainingDeliveryLoc;
use App\Models\StudentCompletion as CourseCompletion;
use App\Models\StudentCompletionDetail as CourseCompletionDetail;
use App\Models\StudentInvoice;
use App\Models\TrainingOrganisation;
use App\Models\TrainingOrgBankDetails;
use App\Models\PaymentScheduleTemplate;
use App\Models\EmailWarningTrail;

use App\Models\StudentClass;
use App\Models\Attendance;
use App\Models\AttendanceDetail;
use App\Models\ClassTimeTable;
use App\Models\OfferLetterCourseDetail;
use App\Models\Student\OfferLetter\OfferLetter;
use App\Models\StudentAttachment;

use App\Models\EnrolmentPack;
use App\Http\Controllers\Enrolment\EnrolmentController; //CEA
use App\Http\Controllers\Enrolment\EnrolmentPCAController;
use App\Http\Controllers\Enrolment\EnrolmentPCADomesticController;
use App\Models\ReportCourseStatuses;
use Illuminate\Support\Facades\Storage;

class DomesticController extends Controller
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
    public function index()
    {
        //
        // dd('ghorl');
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

        // dd('eeeee');
        $student = Student::with('party.person', 'type', 'offer_letter')->where('id', $id)->first();
        $statuses = AvtCompletionStatus::all();
        $student_id = $student->student_id;
        $student_personal_info = $student->party->person;

        $student_details = FundedStudentDetails::with('contact', 'course')->where('student_id', $student_id)->first();
        // dd($student_details);
        $offerData = $student->offer_letter()->with('student_details', 'course_details.payments','course_details.payments.agent', 'course_details.package.detail.course.detail', 'course_details.course_matrix.detail', 'course_details.enrolment', 'course_details.funded_course.detail', 'fees')->orderBy('id', 'DESC')->get();
        $contact = $student_details->contact;
        $course_details = $student_details->course;
        $visa_info = FundedStudentVisaDetails::where('student_id', $student_id)->first();

        $unit_details = '';
        $units_val = [];
        if ($student_details->extra_units != null) {
            $unit_details = $student_details->extra_units;
            $units = json_decode($unit_details->extra_units, true);
            // dd($unit_details);
            // EXTRA UNITS VALUE
            if ($units != null) {
                foreach ($units as $key => $value) {
                    $units_val[] = [
                        'id' => $value['id'],
                        'code' => $value['code'],
                        'value' => $value['code'] . ' ' . '-' . ' ' . $value['description'],
                        'description' =>  $value['description']
                    ];
                }
            }
        }
        // dump($unit_details);
        // SELECT OPTIONS
        $slct_schl_lvl_completed = AvtHighestSchlLvlCompleted::pluck('description', 'value');
        $slct_indigenous_status = AvtClientIndigenousStatus::pluck('description', 'value');
        $slct_labour_force_status = AvtLabourForceStatus::pluck('status', 'value');
        $slct_lang_identifer = AvtLangIdentifier::orderBy('description', 'asc')->pluck('value', 'description');
        $slct_survey_contact_status = AvtSurveyContactStatus::pluck('description', 'value');

        $slct_state = AvtStateIdentifier::orderBy('state_name')->pluck('state_name', 'state_key');
        $slct_postcode = AvtPostcode::select(DB::raw("CONCAT(suburb,', ',state) AS name"), 'id')->pluck('name', 'id');
        $student_status = OfferLetterStatus::whereIn('id', [1, 3, 4, 5, 7])->get();
        $slct_offer_lttr_statuses = $student_status->pluck('description', 'id');
        $slct_class = StudentClass::select(DB::raw("CONCAT(`desc`) AS description"), 'id')->pluck('description', 'id');
        // $slct_visa_type = VisaStatus::select(DB::raw("CONCAT(type,' - ',visa) AS name"), 'id')->pluck('name','id');
        $slct_visa_type = VisaStatus::select(DB::raw('id, IF(id=1, "Not Applicable", concat(type, " - ", visa)) AS value'))->orderBy('value', 'asc')->get();

        $arr_visa_type = [];
        foreach ($slct_visa_type as $key => $v) {
            $arr_visa_type[] = [
                'id'          => $v->id,
                'value'       => $v->value
            ];
        }

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

        $slct_dlvr_mode = AvtDeliveryMode::pluck('description', 'value');
        // ENROLMENT DETAILS
        $slct_com_course = AvtCommencingCourse::pluck('description', 'value');
        $slct_funding_source_national = AvtFundingSourceNational::pluck('description', 'value');
        $slct_funding_source_state = AvtFundingSourceState::pluck('description', 'value');
        $slct_outcome_status = AvtOutcomeStatus::pluck('description', 'value');
        $slct_predom_dlvr_mode = AvtPredominantDlvrMode::pluck('description', 'value');
        $slct_specific_fund = AvtSpecificFunding::pluck('description', 'identifier');
        $slct_study_reason = AvtStudyReason::pluck('description', 'value');
        $slc_funding_type = AvtFundingType::where('state_key', $student_details->location)->get();
        // MULTISELECT
        $slct_country = AvtCountryIdentifier::orderBy('full_name', 'asc')->get();
        $slct_disability = AvtDisabilityTypes::all();
        $slct_educ_achievement = AvtPriorEducationAchievement::all();
        $arr_disability = [];
        $app_setting = TrainingOrganisation::first();
        // dd($app_setting);
        foreach ($slct_disability as $key => $value) {
            $arr_disability[] = [
                'id'          => $value->value,
                'value'       => $value->description
            ];
        }
        $arr_educ_achievement = [];
        foreach ($slct_educ_achievement as $key => $value) {
            $arr_educ_achievement[] = [
                'id'          => $value->value,
                'value'       => $value->description
            ];
        }
        $arr_country = [];
        foreach ($slct_country as $key => $value) {
            $arr_country[] = [
                'id'          => $value->identifier,
                'value'       => $value->full_name
            ];
        }

        // STUDENT DETAILS (AVETMISS)
        $arr_student_details = [];
        if (isset($student_details)) {

            $arr_disability_val = [];
            $arr_pea_val = [];
            $arr_country_val = [];

            // disability_ids multiselect
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
            // prior_educational_achievement_ids multiselect
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

            $ptr = [];
            // dd($student->offer_letter);
            // dd($student->offer_letter);
            if (isset($student->offer_letter)) {
                $offerLetter = OfferLetter::with('enrolment_pack')->where('student_id', $student->student_id)->orderBy('id', 'DESC')->get();

                foreach ($offerLetter as $ol) {
                    if (isset($ol->enrolment_pack->ptr)) {
                        $pdf = StudentAttachment::where('student_id', $student->student_id)->where('_input', 'pre_training_review')->first();
                        $enrol_pack = ['epack' => $ol->enrolment_pack, 'ptr' => json_decode($ol->enrolment_pack->ptr), 'pdf' => $pdf];
                        array_push($ptr, $enrol_pack);
                    }
                }
            } else {
                // dd('no offer letter');
                $ptr = '';
            }
            

            // country_id singleselect
            if ($student_details->country_id != null) {
                $c = AvtCountryIdentifier::where('identifier', $student_details->country_id)->first();
                $arr_country_val = [
                    'id'        => $c['identifier'],
                    'value'     => $c['full_name']
                ];
            }

            $arr_student_details = [
                'id'                                    => $student_details->id,
                'student_id'                            => $student->student_id,
                'vetrack_id'                            => $student_details->vetrack_id,
                'location'                              => $student_details->location,
                'funded_student_contact_detail_id'      => $contact->id,
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
                'year_completed'                        => $student_details->year_completed,
                'institute'                             => $student_details->institute
            ];
        }

        // if ($course_details != null) {
        //     $cd = $course_details->where('student_id', $student_id)->get();
        //     foreach ($cd as $key => $value) {
        //         $course_details = [
        //             'id'                    => $value['id'],
        //             'student_id'            => $value['student_id'],
        //             'course_code'           => $value['course_code'],
        //             'eligibility'           => $value['eligibility'],
        //             // 'start_date'            => Carbon::parse($value['start_date'])->format('D M d Y H:i:s eO (e)'),
        //             'start_date'            => Carbon::parse($value['start_date'])->format('m/d/Y'),
        //             'end_date'              => Carbon::parse($value['end_date'])->format('m/d/Y'),
        //             'course_fee'            => $value['course_fee'],
        //             'course_fee_type'       => $value['course_fee_type']
        //         ];
        //     }
        // }


        // $unitTypes = Unit::orderBy('unit_type', 'ASC')->groupBy('unit_type')->get();
        // $unitArr = [];
        // foreach ($unitTypes as $key => $value) {
        //     $unitArr[$key]['unit-type'] = strtoupper($value->unit_type);
        //     $courseUnits = Unit::select(['code', 'description', 'unit_type'])->where('unit_type', $value->unit_type)->orderBy('id', 'DESC')->get();
        //     foreach ($courseUnits as $k => $v) {
        //         $utype = '';
        //         if($v->unit_type != null){
        //             $utype =  $v->unit_type;
        //         }
        //         $unitArr[$key]['unit-details'][] = [
        //             'subject_code' => $v->code,
        //             'description' => $v->description,
        //             'unit_type' => $utype,
        //         ];
        //     }
        //     // $unitArr[$value->unit_type][] = ['code' => $value->code, 'description' => $value->description];

        // }
        $unitTypes = Unit::orderBy('code', 'asc')->get();
        $unitArr = [];
        foreach ($unitTypes as $k => $v) {
            $unitArr[] = [
                'subject_code' => $v->code,
                'description' => $v->description,
                // 'unit_type' => $v->unit_type,
            ];
        }
        // $unit_list = CourseProspectus::where('course_code', '1111')->first();

        // $arr_units = [];
        // foreach ($unit_list->unit_selected as $key => $value) {
        //     $arr_units[] = [
        //         'id' => $value->id,
        //         'code' => $value->code,
        //         'value' => $value->code . ' ' . '-' . ' ' . $value->description,
        //         'description' =>  $value->description
        //     ];
        // }
        // dd($slct_class);
        $demoUser = \Auth::user()->hasRole('Demo');

        // dump($student_status);
        // dd(AgentDetail::all()->pluck('agent_name', 'id'));

        //WINDOW.DATA
        \JavaScript::put([
            'student' => $id,
            'student_id' => $student->student_id,
            'is_test' => $student->is_test,
            'report_avetmiss' => $student->report_avetmiss,
            'report_course_statuses' => ReportCourseStatuses::all(),
            'student_info' => $student_personal_info,
            'student_type' => $student->student_type_id,
            'contact' => $contact,
            'visa_info' => $visa_info,
            'student_details' => $arr_student_details,
            'course_details' => $course_details,
            'slct_schl_lvl_completed' => $slct_schl_lvl_completed,
            'slct_indigenous_status' => $slct_indigenous_status,
            'slct_labour_force_status' => $slct_labour_force_status,
            'slct_lang_identifer' => $slct_lang_identifer->toArray(),
            'slct_country' => $arr_country,
            'slct_disability' => $arr_disability,
            'slct_educ_achievement' => $arr_educ_achievement,
            'slct_survey_contact_status' => $slct_survey_contact_status,
            'slct_course' => $slct_course,
            'slct_class' => $slct_class,
            'courses'   => $courses,
            'slct_units' => $unitArr,
            'slct_state' => $slct_state,
            'slct_postcode' => $slct_postcode,
            'slct_offer_lttr_statuses' => $slct_offer_lttr_statuses,
            'slct_visa_type' => $arr_visa_type,
            'student_status' => $student_status,
            'xtra_unitList' => $unit_details,
            'slc_funding_type' => $slc_funding_type,
            'units_val' => $units_val,

            // Course Details
            'slct_training_dlvr_loc' => $slct_training_dlvr_loc,
            'slct_dlvr_mode' => $slct_dlvr_mode,
            'slct_com_course' => $slct_com_course,
            'slct_funding_source_national' => $slct_funding_source_national,
            'slct_funding_source_state' => $slct_funding_source_state,
            'slct_outcome_status' => $slct_outcome_status,
            'slct_predom_dlvr_mode' => $slct_predom_dlvr_mode,
            'slct_specific_fund' => $slct_specific_fund,
            'slct_study_reason' => $slct_study_reason,
            'app_settings' => $app_setting,
            'demoUser' => $demoUser,
            'agents' => AgentDetail::all()->pluck('agent_name', 'id'),
            'offerData' => $offerData,
            'ptr' => $ptr,
            'statuses' => $statuses,
            'viewing' => 'students'
        ]);

        return view('students.domestic.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function getCourses($student_id, $offer = null)
    {
        if ($offer == null) {
            $course = FundedStudentCourse::with('course.courseprospectus', 'course_completion.completion.details')->where('student_id', $student_id)->get();
        } else {
            $offer = explode(',', $offer);
            $course = FundedStudentCourse::with('course.courseprospectus', 'course_completion.completion.details')->where('student_id', $student_id)->whereIn('offer_letter_course_detail_id', $offer)->get();
        }
        $email_trail = EmailWarningTrail::where('student_id', $student_id)->get();
        $course_detail = [];
        foreach ($course as $key => $value) {
            // dump($value);
            $attendance = Attendance::where('student_id', $value->student_id)->where('course_code', $value->course_code)->first();

            if ($value->course_code != '@@@@') {
                $prospectus = $value->course->courseprospectus;
            } else {
                $prospectus = null;
            }

            // $completion = $value->course_completion->completion->where('course_code', $value->course_code)->first();

            $fscd = FundedStudentCourseDetail::where('funded_student_course_id', $value->id)->first();
            // dump($course_details);
            if ($fscd != null) {
                $funding_type = AvtFundingType::find($fscd->funding_type);
            }

            
            if($value->offer_letter_course_detail_id != null){
                $csc = CompletionStudentCourse::where('student_course_id',$value->offer_letter_course_detail_id)->where('student_type',$value->student->student_type_id)->first();
                if($csc == null){
                    $csc = $value->course_completion;
                }
                $completion = $csc->completion;
            }else{
                $completion = $value->course_completion->completion;
            }
            if ($completion != null) {
                $com_details = $completion->details->where('student_completion_id', $completion->id)->sortBy('order');

                //Get course subject details
                // dd($com_details);
                $arr_subjects = [];
                $arr_extraUnits = [];

                foreach ($com_details as $key => $cd) {

                    $dates = [];
                    if ($cd->start_date != null && $cd->end_date != null) {
                        $dates = [
                            'start_date' => $cd->start_date,
                            'end_date' => $cd->end_date
                        ];
                    }


                    $subject_code = $cd->course_unit_code;
                    $unit = Unit::where('code', $subject_code)->first();
                    // dump($dates);
                    if ($cd->extra_unit == 0) {
                        $arr_subjects[] = [
                            'subject_code'      => $subject_code,
                            'description'       => $unit->description,
                            'unit_type'         => $unit->unit_type,
                            'dates'             => $dates,
                            'train_org_loc_id'  => $cd->train_org_loc_id,
                            'delivery_mode_id'  => $cd->delivery_mode_id,
                            'order'  => $cd->order,
                        ];
                    } else {
                        $utype = '';
                        if ($unit->unit_type != null) {
                            $utype =  $unit->unit_type;
                        }
                        $arr_extraUnits[] = [
                            'subject_code'      => $subject_code,
                            'description'       => $unit->description,
                            'unit_type'         => $utype,
                            'dates'             => $dates,
                            'train_org_loc_id'  => $cd->train_org_loc_id,
                            'delivery_mode_id'  => $cd->delivery_mode_id,
                            'order'  => $cd->order,
                        ];
                    }
                }

                $unitTypes = Unit::orderBy('unit_type', 'ASC')->groupBy('unit_type')->get();
                $arr_extraUnits_val = [];
                foreach ($unitTypes as $key => $u) {
                    $arr_extraUnits_val[$key]['unit-type'] = strtoupper($u->unit_type);
                    // $courseUnits = Unit::select(['code', 'description', 'unit_type'])->where('unit_type', $u->unit_type)->orderBy('id', 'DESC')->get();
                    $extra_units = $completion->details->where('student_completion_id', $completion->id)->where('extra_unit', 1);
                    // dump($extra_units);
                    foreach ($extra_units as $k => $v) {
                        $utype = '';
                        $unit = Unit::where('code', $v->course_unit_code)->first();
                        // dd($unit);
                        if ($unit->unit_type != null) {
                            $utype =  $unit->unit_type;
                        }
                        $arr_extraUnits_val[$key]['unit-details'][] = [
                            'subject_code' => $unit->code,
                            'description' => $unit->description,
                            'unit_type' => $utype,
                        ];
                    }
                    // $unitArr[$value->unit_type][] = ['code' => $value->code, 'description' => $value->description];

                }
            } else {
                $arr_subjects = null;
                $arr_extraUnits = null;
                $arr_extraUnits_val = null;
            }

            $course_detail[] = [
                "id"                => $value->id,
                "student_id"        => $value->student_id,
                "process_id"        => $value->process_id,
                "course_code"       => $value->course_code,
                'name'              => isset($value->course->name) ? $value->course->name : 'Unit of Competency',
                "eligibility"       => $value->eligibility,
                "location"          => $value->location,
                "start_date"        => $value->start_date,
                "end_date"          => $value->end_date,
                "course_fee"        => $value->course_fee,
                "course_fee_type"   => $value->course_fee_type,
                "status_id"         => $value->status_id,
                "agent_id"         => $value->agent_id,
                "aiss_date"        => $value->aiss_date,
                "class"             => isset($attendance) ? $attendance->class_id : null,
                "remarks"           => $value->remarks,
                "report_course_status_id" => $value->report_course_status_id,
                'courseSubjects'    => $arr_subjects,
                'courseExtraUnits'       => $arr_extraUnits,
                'uc_description'     => $value->uc_description,
                'slct_extraUnits_val' => $arr_extraUnits_val,
                // 'completion'        => $completion 
                'outcome_id_national'                       => isset($fscd->outcome_id_national) ? $fscd->outcome_id_national : '',
                'funding_source_national'                   => isset($fscd->funding_source_national) ? $fscd->funding_source_national : '',
                'commence_prg_identifier'                   => isset($fscd->commence_prg_identifier) ? $fscd->commence_prg_identifier : '',
                'training_contract_id'                      => isset($fscd->training_contract_id) ? $fscd->training_contract_id : '',
                'client_id_apprenticeships'                 => isset($fscd->client_id_apprenticeships) ? $fscd->client_id_apprenticeships : '',
                'study_reason_id'                           => isset($fscd->study_reason_id) ? $fscd->study_reason_id : '',
                'specific_funding_id'                       => isset($fscd->specific_funding_id) ? $fscd->specific_funding_id : '',
                'funding_type'                              => ($fscd !== null) ? $funding_type : '',
                'funding_source_state_training_authority'   => isset($fscd->funding_source_state_training_authority) ? $fscd->funding_source_state_training_authority : '',
                'purchasing_contract_id'                    => isset($fscd->purchasing_contract_id) ? $fscd->purchasing_contract_id : '',
                'purchasing_contract_schedule_id'           => isset($fscd->purchasing_contract_schedule_id) ? $fscd->purchasing_contract_schedule_id : '',
                'associated_course_id'                      => isset($fscd->associated_course_id) ? $fscd->associated_course_id : '',
                'predominant_delivery_mode'                 => isset($fscd->predominant_delivery_mode) ? $fscd->predominant_delivery_mode : '',
                'full_time_leaning_option'                  => isset($fscd->full_time_leaning_option) ? $fscd->full_time_leaning_option : '',
            ];
            // $course_list[] = $course_detail;
        }
        // dd($student_id);
        return response()->json([
            // 'data'              => $course,
            'course_details'    => $course_detail,
            'warningLetterList'   => $email_trail,
        ]);
    }

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
        $request = $request->inputs;
        if ($request['date_of_birth'] != null) {
            $dob = Carbon::parse($request['date_of_birth'])->format('Y-m-d');
        } else {
            $dob = null;
        }

        try {
            //code...
            DB::beginTransaction();
            $student = Student::find($id);
            $student->party->person->firstname = $request['firstname'];
            $student->party->person->lastname = $request['lastname'];
            $student->party->person->middlename = $request['middlename'];
            $student->party->person->prefix = $request['prefix'];
            $student->party->person->gender = $request['gender'];
            $student->party->person->date_of_birth = $dob;
            $student->party->person->update();
            $student->party->name = preg_replace('/\s+/', ' ', $request['firstname'] . ' ' . $request['middlename'] . ' ' . $request['lastname']);
            $student->party->update();
            DB::commit();
            return json_encode(['data' => $request, 'status' => 'updated']);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            return json_encode(['student' => $request, 'status' => 'error']);
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
        //
        try {
            DB::beginTransaction();
            $course = FundedStudentCourse::with('course')->find($id);
            $course_details = FundedStudentCourseDetail::where('funded_student_course_id', $id)->first();
            $course_completion = CompletionStudentCourse::with('completion.details')->where('student_course_id', $id)->first();

            $attendance = Attendance::where('student_id',$course->student_id)->where('course_code',$course->course_code)->where('class_id','!=',0)->first();

            $completion = $course_completion->completion;
            $com_details = $completion->details;
            foreach ($com_details as $key => $value) {
                $subject = $value->find($value->id);
                if ($subject != null) {
                    $subject->delete();
                }
            }
            if ($course != null) {
                $course->delete();
            }
            if ($completion != null) {
                $completion = $completion->findOrFail($completion->id);
                $completion->delete();
            }
            if ($course_details != null) {
                $course_details = $course_details->findOrFail($course_details->id);
                $course_details->delete();
            }

            if($attendance != null){
                $attendance->delete();
            }

            DB::commit();
            //code...
            if($course->course_code == '@@@@'){
                return json_encode(['status' => 'success', 'message' =>'Unit of Competency deleted successfully']);
            }
            return json_encode(['status' => 'success', 'message' => $course->course->code . ' - ' . $course->course->name . ' deleted successfully']);
        } catch (\Throwable $th) {
            DB::rollback();
            return json_encode(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    public function student_info($student)
    {

        $info = Student::with('party.person', 'type')->find($student);
        $student_id = $info->student_id;

        // STUDENT DETAILS NAT80 and NAT85
        $student_details = FundedStudentDetails::with('contact')->where('student_id', $student_id)->first();
        $contact = $student_details->contact;

        $unit_details = '';
        $unitList = [];
        $units_val = [];
        if ($student_details->extra_units != null) {
            $unit_details = FundedStudentExtraUnits::where('student_id', $student_id)->get();


            foreach ($unit_details as $key => $value) {
                $units = json_decode($value->extra_units, true);

                if ($units != null) {
                    $units = array_column($units, 'code');
                    $units = implode(', ', $units);
                }

                $unitList[] = [
                    'id' => $value->id,
                    'student_id' => $value->student_id,
                    'units' => $units
                    // 'full_details' => $value->extra_units
                ];
            }
        }


        $type = Type::all();
        $country = AvtCountryIdentifier::orderBy('full_name')->get();
        $state = AvtStateIdentifier::orderBy('state_name')->get();
        $postcode = AvtPostcode::orderBy('suburb')->get();
        $suburb_val = AvtPostcode::where('suburb', $contact->addr_suburb)->get();

        $arr_suburb_val = [];
        foreach ($suburb_val as $key => $value) {
            if ($contact->postcode != null && $contact->postcode == $value->postcode) {
                $arr_suburb_val = [
                    'id' => $value['id'],
                    'value' => $value['postcode'] . ' ' . '-' . ' ' . $value['suburb'] . ',' . ' ' . $value['state']
                ];
            }
        }

        $arr_postcode = [];
        foreach ($postcode as $key => $value) {
            $arr_postcode[] = [
                'id' => $value->id,
                'value' => $value->postcode . ' ' . '-' . ' ' . $value->suburb . ',' . ' ' . $value->state
            ];
        }

        $student_extra_units = FundedStudentExtraUnits::all();
        foreach ($student_extra_units as $key => $value) {
            $unit_details = json_decode($value->extra_units, true);
        }


        // dd($unit_details);
        $agent = Agent::with('party')->has('party')->get();
        return response()->json([
            'student' => $info,
            'student_details' => $student_details,
            'type' => $type,
            'country' => $country,
            'state' => $state,
            'postcode' => $arr_postcode,
            'suburb_val' => $arr_suburb_val,
            'agent' => $agent,
            'unit_details' => $unit_details,
            'unitList' => $unitList
        ]);
    }

    public function contact_update(Request $request, $student)
    {
        $request = $request->inputs;
        $info = Student::with('party.person', 'type')->find($student);
        // dd($request);
        if (count($request['addr_suburb']) != 0) {
            $suburb = $request['addr_suburb'];
            $suburb_id = $suburb['value'];
            $postcode = AvtPostcode::where('id', $suburb_id)->first();
            $suburb = $postcode->suburb;
            $state = AvtStateIdentifier::where('state_key', $postcode->state)->first();
            $state_id = $state->id;
        }
        try {
            // start db transaction
            DB::beginTransaction();

            $contact = FundedStudentContactDetails::where('student_id', $info->student_id)->first();
            // dd($contact);
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
    }

    public function avetmiss_update(Request $request, $student)
    {
        $request = $request->inputs;
        $disability = [];
        $pea = [];

        // disability_ids
        foreach ($request['disability_ids'] as $key => $value) {
            array_push($disability, $value['id']);
        }
        // prior_educational_achievement_ids
        foreach ($request['prior_educational_achievement_ids'] as $key => $value) {
            array_push($pea, $value['id']);
        }
        $disability = implode(',', $disability);
        $pea = implode(',', $pea);

        if ($request['country_id'] != null) {
            $country = $request['country_id']['id'];
        } else {
            $country = null;
        }
        // $info = Student::with('party.person', 'type')->find($student);
        if (isset($request['id'])) {
            // dd('update ni ghorl');
            try {
                // start db transaction
                DB::beginTransaction();


                // if ($disability == '' || $request['disability_flag'] == 'N') {
                //     $disability = null;
                // }
                // if ($pea == '' || $request['prior_educational_achievement_flag'] == 'N') {
                //     $pea = null;
                // }

                $avetmiss = FundedStudentDetails::where('id', $request['id'])->first();
                $avetmiss->update([
                    // 'id'                                    => $request['id'],
                    'student_id'                            => $request['student_id'],
                    'vetrack_id'                            => $request['vetrack_id'],
                    'funded_student_contact_detail_id'      => $request['funded_student_contact_detail_id'],
                    'name_for_encryption'                   => $request['name_for_encryption'],
                    'location'                              => isset($request['location']) ? $request['location'] : null,
                    'highest_school_level_completed_id'     => isset($request['highest_school_level_completed_id']) ? $request['highest_school_level_completed_id'] : null,
                    'indigenous_status_id'                  => isset($request['indigenous_status_id']) ? $request['indigenous_status_id'] : null,
                    'language_id'                           => isset($request['language_id']) ? $request['language_id'] : null,
                    'labour_force_status_id'                => isset($request['labour_force_status_id']) ? $request['labour_force_status_id'] : null,
                    'country_id'                            => $country,
                    'disability_flag'                       => $request['disability_flag'],
                    'year_completed'                        => $request['year_completed'],
                    'institute'                             => isset($request['institute']),
                    'disability_ids'                        => isset($disability) ? $disability : null,
                    'prior_educational_achievement_flag'    => $request['prior_educational_achievement_flag'],
                    'prior_educational_achievement_ids'     => isset($pea) ? $pea : null,
                    'at_school_flag'                        => $request['at_school_flag'],
                    'unique_student_id'                     => $request['unique_student_id'],
                    'survey_contact_status'                 => $request['survey_contact_status'],
                    'statistical_area_level_1_id'           => $request['statistical_area_level_1_id'],
                    'statistical_area_level_2_id'           => $request['statistical_area_level_2_id']
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
        } else {
            // dd('create ni ghorl kay walay id :P');
        }
    }

    public function getClassTimetable($id, $location)
    {
        $class = StudentClass::with('time_table', 'delivery_location')->where('id', $id)->where('location', $location)->first();
        $timetable = $class->time_table;
        // dump($timetable);
        if ($timetable != null) {
            $training_loc = TrainingDeliveryLoc::where('id', $class->delivery_loc)->first();
            $holidays = null;

            if ($class->time_table_type == 'Straight') {
                // dd($class);
                $tt_units = $timetable->time_table;
                foreach ($tt_units as $ttu) {

                    $unit = $ttu['unit'];
                    if (isset($ttu['holidays'])) {
                        if (count($ttu['holidays']) > 0) {
                            $holidays = json_encode($ttu['holidays']);
                        }
                    }

                    $arr_tt_units[] = [
                        'subject_code'      => $unit['code'],
                        'description'       => $unit['description'],
                        'unit_type'         => $unit['unit_type'],
                        'dates'             => ['start' => $ttu['dates']['start'], 'end' => $ttu['dates']['end']],
                        'train_org_loc_id'  => $training_loc->train_org_dlvr_loc_id,
                        'trainer_id'        => isset($ttu['trainer']) ? $ttu['trainer']['id'] : null,
                        'training_hours'    => $ttu['training_hours'],
                        'holidays'          => $holidays,
                        'order'          => $ttu['order']
                    ];
                }
            } else {
                $time_table = collect($timetable->time_table);
                // $data = $time_table->where('dates.start', '>', '2020-11-22');
                // $tt_units = $timetable->time_table;
                $start_course = '';
                $end_lopper = false;

                foreach ($time_table as $ttu) {

                    if (isset($ttu['holidays'])) {
                        if (count($ttu['holidays']) > 0) {
                            $holidays = json_encode($ttu['holidays']);
                        }
                    }

                    if (isset($ttu['unit'])) {
                        $unit = $ttu['unit'];
                        $checkunits[] = $unit['code'];
                        $arr_tt_units[] = [
                            'subject_code'      => $unit['code'],
                            'description'       => $unit['description'],
                            'unit_type'         => $unit['unit_type'],
                            'dates'             => ['start' => $ttu['dates']['start'], 'end' => $ttu['dates']['end']],
                            'train_org_loc_id'  => $training_loc->train_org_dlvr_loc_id,
                            'trainer_id'        => isset($ttu['trainer']) ? $ttu['trainer']['id'] : null,
                            'training_hours'    => $ttu['training_hours'],
                            'holidays'          => $holidays,
                            'order'          => $ttu['order']
                        ];
                    }
                }
            }
        }
        return $arr_tt_units;
    }



    public function course_details_update(Request $request, $student)
    {
        if(isset($request->inputs)){
            $request = $request->inputs;
        }else{
            $request = $request->all();
        }
        // dd($request);
        $student_id = Student::where('id', $student)->first();
        $studenter = $student_id;
        $student_id = $student_id->student_id;
        // dd($request);
        if ($request['aiss_date'] == 'Invalid date' || $request['aiss_date'] == null) {
            $aiss_date = null;
        } else {
            // $aiss_date = Carbon::parse($request['aiss_date'])->format('Y-m-d');
            $aiss_date = $this->dateFormat($request['aiss_date']);
        }

        // dd($request);
        if ($request['course_code'] == '@@@@') {
            $validator = Validator::make($request, [
                'course_code' => 'required',
                'eligibility' => 'required',
                'location' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'course_fee' => 'required',
                'course_fee_type' => 'required',
                'courseExtraUnits'    => 'required|array',
                'commence_prg_identifier' => 'required',
                'funding_source_national' => 'required',
                'study_reason_id' => 'required',
                'predominant_delivery_mode' => 'required',
            ]);
        } else {
            $validator = Validator::make($request, [
                'course_code' => 'required',
                'eligibility' => 'required',
                'location' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'course_fee' => 'required',
                'course_fee_type' => 'required',
                'courseSubjects'    => 'required|array',
                'commence_prg_identifier' => 'required',
                'funding_source_national' => 'required',
                'study_reason_id' => 'required',
                'predominant_delivery_mode' => 'required',
            ]);
        }
        if ($validator->fails()) {
            return response()->json(['status' => 'errors', 'errors' => $validator->messages()]);
        }

        if (isset($request['id'])) {
            try {
                // start db transaction
                DB::beginTransaction();

                if ($request['start_date'] != null && $request['end_date'] != null) {
                    $start_date = $this->dateFormat($request['start_date']);
                    $end_date = $this->dateFormat($request['end_date']);
                } else {
                    $start_date = null;
                    $end_date = null;
                }
                
                
                $funded_student_course = FundedStudentCourse::where(['student_id' => $request['student_id'], 'id' => $request['id']])->first();
                $previous_start_date = $funded_student_course->start_date;
                $funded_student_course->update([
                    'course_code'           => $request['course_code'],
                    'eligibility'           => $request['eligibility'],
                    'location'              => $request['location'],
                    // 'start_date'            => $start_date,
                    // 'end_date'              => $end_date,
                    'course_fee'            => $request['course_fee'],
                    'course_fee_type'       => $request['course_fee_type'],
                    'status_id'             => $request['status_id'],
                    'aiss_date'             => $aiss_date,
                    'remarks'               => $request['remarks'],
                    'uc_description'        => $request['uc_description'],
                    'agent_id'              => $request['agent_id'],
                ]);

                // if($previous_start_date != $request['start_date']){
                $funded_student_course->start_date = $start_date;
                $funded_student_course->end_date = $end_date;
                $funded_student_course->update();
                // }

                if($funded_student_course->offer_detail != null){
                    $funded_student_course->offer_detail->status_id = $funded_student_course->status_id;
                    $funded_student_course->offer_detail->update();
                }

                // ADD/UPDATE ATTENDANCE
                $this->storeUpdate_attendance($request['class'], $funded_student_course);

                if($funded_student_course->wasChanged('course_fee')){
                    $this->createPaymentSchedule($funded_student_course);
                }

                //resched payment schedule (fullfee course only)
                // if ($funded_student_course->course_fee_type == 'FF') {
                //     $old_ps = PaymentScheduleTemplate::where('funded_student_course_id', $funded_student_course->id)->get();
                //     if ($old_ps != null) {
                //         foreach ($old_ps as $key => $ops) {
                //             $ops->delete();
                //         }
                //         $this->createPaymentSchedule($funded_student_course);
                //     } else {
                //         $this->createPaymentSchedule($funded_student_course);
                //     }
                // }


                // UPDATE FUNDED course details
                $course_details = FundedStudentCourseDetail::where('funded_student_course_id', $request['id'])->first();
                $course_details->update([
                    'outcome_id_national'                       => $request['outcome_id_national'],
                    'funding_source_national'                   => $request['funding_source_national'],
                    'commence_prg_identifier'                   => $request['commence_prg_identifier'],
                    'training_contract_id'                      => isset($request['training_contract_id']) ? $request['training_contract_id'] : null,
                    'client_id_apprenticeships'                 => $request['client_id_apprenticeships'],
                    'study_reason_id'                           => $request['study_reason_id'],
                    'funding_type'                              => isset($request['funding_type']) ? $request['funding_type']['id'] : null,
                    'specific_funding_id'                       => isset($request['specific_funding_id']) ? $request['specific_funding_id'] : null,
                    'funding_source_state_training_authority'   => isset($request['funding_source_state_training_authority']) ? $request['funding_source_state_training_authority'] : null,
                    'purchasing_contract_id'                    => isset($request['purchasing_contract_id']) ? $request['purchasing_contract_id'] : null,
                    'purchasing_contract_schedule_id'           => isset($request['purchasing_contract_schedule_id']) ? $request['purchasing_contract_schedule_id'] : null ,
                    'associated_course_id'                      => isset($request['associated_course_id']) ? $request['associated_course_id'] : null ,
                    'predominant_delivery_mode'                 => isset($request['predominant_delivery_mode']) ? $request['predominant_delivery_mode'] : null ,
                    'full_time_leaning_option'                  => isset($request['full_time_leaning_option']) ? $request['full_time_leaning_option'] : null ,
                ]);


                // ADD/UPDATE Subjects to Course Completion Details
                $completion = CourseCompletion::with('details')->where(['student_id' => $request['student_id'], 'course_code' => $request['course_code']])->first();

                // dd($completion);

                $prev_date = null;
                $temp_date = null;

                if (count($request['courseSubjects']) != $completion->details->where('extra_unit', 0)->count()) {

                    $completion_exist = [];
                    foreach ($request['courseSubjects'] as $key1 => $subject1) {
                        array_push($completion_exist, $subject1['subject_code']);
                    }
                    $exist_on_query = $completion->details->whereNotIn('course_unit_code', $completion_exist);
                    // dump($completion_exist);
                    // dd($exist_on_query);
                    foreach ($exist_on_query as $eq) {
                        $temp_date = $eq->start_date;
                        // dd($temp_date);
                        if ($eq->extra_unit == 0) {
                            $eq->delete();
                        }
                    }
                    // exit();
                }



                foreach ($request['courseSubjects'] as $key => $subject) {
                    $train_loc = '';
                    $dlvr_mode = '';
                    
                    // 	Delivery Location and Delivery Mode is REQUIRED!
                    $validator_cs = Validator::make($subject, [
                        'train_org_loc_id' => 'required',
                        'delivery_mode_id' => 'required',
                    ]);
                    if ($validator_cs->fails()) {
                        return response()->json(['status' => 'errors', 'errors' => $validator_cs->messages()]);
                    }

                    if (count($request['courseSubjects']) != $completion->details->where('extra_unit', 0)->count()) {

                        $com_det2 = CourseCompletionDetail::where('student_completion_id', $completion->id)->where(['course_unit_code' => $subject['subject_code'], 'extra_unit' => 0])->first();
                        // dd($com_det2);
                        if ($com_det2 != null) {
                            // dump('not null');
                            $start_date = $com_det2->start_date;
                            $end_date =  $com_det2->end_date;
                            $prev_date = $start_date;

                            $train_loc = $com_det2->train_org_loc_id;
                            $dlvr_mode = $com_det2->delivery_mode_id;
                            // dump($dlvr_mode);
                            // dump($com_det2);
                        } else {
                            // dump('$prev_date');
                            if ($prev_date == null) {
                                $prev_date = $temp_date;
                            }
                            $start_date = $prev_date;
                            $end_date =  $prev_date;
                        }
                    } else {
                        if ($subject['dates'] != null) {
                            if ($subject['dates']['start'] != null && $subject['dates']['end']) {
                                $start_date = $this->dateFormat($subject['dates']['start']);
                                $end_date = $this->dateFormat($subject['dates']['end']);
                            }
                        } else {
                            $start_date = null;
                            $end_date = null;
                        }
                    }
                    // dump($start_date);
                    // dump($end_date);
                    if (count($completion->details) == 0) {
                        $completion_details = new CourseCompletionDetail;
                        $completion_details->fill([
                            'course_unit_code'      => $subject['subject_code'],
                            'start_date'            => isset($start_date) ? $start_date : null,
                            'end_date'              => isset($end_date) ? $end_date : null,
                            'train_org_loc_id'      => isset($subject['train_org_loc_id']) ? $subject['train_org_loc_id'] : null,
                            'delivery_mode_id'      => isset($subject['delivery_mode_id']) ? $subject['delivery_mode_id'] : null,
                            'trainer_id'            => isset($subject['trainer_id']) ? $subject['trainer_id'] : null,
                            'training_hours'        => isset($subject['training_hours']) ? $subject['training_hours'] : null,
                            'holidays'        => isset($subject['holidays']) ? $subject['holidays'] : null,
                            'order'        => isset($subject['order']) ? $subject['order'] : null
                        ]);
                        $completion_details->completion()->associate($completion);
                        $completion_details->save();
                    } else {
                        // if($previous_start_date != $request['start_date']){
                        $com_det = CourseCompletionDetail::where('student_completion_id', $completion->id)->where(['course_unit_code' => $subject['subject_code'], 'extra_unit' => 0])->first();
                        if ($com_det != null) {
                            if ($studenter->student_type_id == 1) {
                                // dd($com_det);
                                $com_det->update([
                                    'course_unit_code'  => $subject['subject_code'],
                                    'start_date'        => isset($start_date) ? $start_date : null,
                                    'end_date'          => isset($end_date) ? $end_date : null,
                                    'train_org_loc_id'  => isset($subject['train_org_loc_id']) ? $subject['train_org_loc_id'] : null,
                                    'delivery_mode_id'  => isset($subject['delivery_mode_id']) ? $subject['delivery_mode_id'] : null,
                                    'trainer_id'            => isset($subject['trainer_id']) ? $subject['trainer_id'] : null,
                                    'training_hours'        => isset($subject['training_hours']) ? $subject['training_hours'] : null,
                                    'holidays'        => isset($subject['holidays']) ? $subject['holidays'] : null,
                                    'order'        => isset($subject['order']) ? $subject['order'] : null
                                ]);
                            } else {
                                $com_det->update([
                                    'course_unit_code'  => $subject['subject_code'],
                                    'start_date'        => isset($start_date) ? $start_date : null,
                                    'end_date'          => isset($end_date) ? $end_date : null,
                                    'train_org_loc_id'  => isset($subject['train_org_loc_id']) ? $subject['train_org_loc_id'] : null,
                                    'delivery_mode_id'  => isset($subject['delivery_mode_id']) ? $subject['delivery_mode_id'] : null,
                                    'trainer_id'            => isset($subject['trainer_id']) ? $subject['trainer_id'] : null,
                                    'training_hours'        => isset($subject['training_hours']) ? $subject['training_hours'] : null,
                                    'holidays'        => isset($subject['holidays']) ? $subject['holidays'] : null,
                                    'order'        => isset($subject['order']) ? $subject['order'] : null
                                ]);
                            }
                        } else {
                            $completion_details = new CourseCompletionDetail;
                            $completion_details->fill([
                                'course_unit_code'      => $subject['subject_code'],
                                'start_date'            => isset($start_date) ? $start_date : null,
                                'end_date'              => isset($end_date) ? $end_date : null,
                                'train_org_loc_id'      => isset($subject['train_org_loc_id']) ? $subject['train_org_loc_id'] : null,
                                'delivery_mode_id'      => isset($subject['delivery_mode_id']) ? $subject['delivery_mode_id'] : null,
                                'trainer_id'            => isset($subject['trainer_id']) ? $subject['trainer_id'] : null,
                                'training_hours'        => isset($subject['training_hours']) ? $subject['training_hours'] : null,
                                'holidays'        => isset($subject['holidays']) ? $subject['holidays'] : null
                            ]);
                            $completion_details->completion()->associate($completion);
                            $completion_details->save();
                        }
                        // }
                    }
                }

                // update start & end date of course and unit's student completion
                if ($request['class'] != 0) {
                    if (isset($request['start_date']) && !in_array($request['start_date'], ['', null]) && $previous_start_date != $request['start_date']) {
                        // dd('sulod');
                        $tt = new TimeTableController;
                        $sd = $this->dateFormat($request['start_date']);
                        $tt->generate_time_table($sd, $request['class'], $funded_student_course->id, 0);
                    }

                    // gnenrate coe for domestic students offer letter
                    if (isset($funded_student_course->offer_detail->offer_letter->id) && $funded_student_course->student->student_type_id == 2) {
                        $stud_att = new StudentAttachmentController;
                        $stud_att->generate_coe($funded_student_course->offer_detail->offer_letter->id);
                    }
                }


                // ADD/EDIT EXTRA UNITS 
                $this->store_extraUnits($request['courseExtraUnits'], $funded_student_course);


                // Update fee per unit - Invoice
                $unit_list_invoice = [];
                if (count($completion->details) != 0) {
                    $course_units_invoice = CourseCompletionDetail::where('student_completion_id', $completion->id)->get();
                    $fee_per_unit = round((int) $funded_student_course->course_fee / count($course_units_invoice)) . '.00';
                    foreach ($course_units_invoice as $cu) {
                        $unit_ = Unit::where('code', $cu->course_unit_code)->first();
                        $unit_list_invoice[] = [
                            'unit'          => $unit_->code . ' ' . $unit_->description,
                            'fee_per_unit'  => $fee_per_unit
                        ];
                    }
                }

                $student_invoice = StudentInvoice::where('student_id', $student_id)->where('course_code', $funded_student_course->course_code)->first();
                if ($student_invoice != null) {
                    $student_invoice->update([
                        'amount'        => $funded_student_course->course_fee,
                        'items'         => json_encode($unit_list_invoice),
                    ]);
                }

                DB::commit();


                return json_encode(['data' => $request, 'status' => 'updated']);
            } catch (\Exception $e) {
                // rollback db transactions
                DB::rollBack();
                // dd($e);
                // echo $e->getMessage();
                // exit();
                // return to previous page with errors
                return  response()->json(['message' => $e->getMessage(), 'status' => 'error']);
            }
        } else {

            // $validator = Validator::make($request, [
            //     'course_code' => 'required',
            //     'eligibility' => 'required',
            //     'location' => 'required',
            //     'start_date' => 'required',
            //     'end_date' => 'required',
            //     'course_fee' => 'required',
            //     'course_fee_type' => 'required'
            // ]);

            // if ($validator->fails()) {
            //     return response()->json(['status' => 'errors', 'errors' => $validator->messages()]);
            // }
            try {
                // start db transaction
                DB::beginTransaction();

                $funded_student_course = new FundedStudentCourse;
                $funded_student_course->fill([
                    'student_id'            => $student_id,
                    'process_id'            => $request['process_id'] == null ? $this->codeNumber() : $request['process_id'],
                    'course_code'           => $request['course_code'],
                    'eligibility'           => $request['eligibility'],
                    'location'              => $request['location'],
                    'start_date'            => $this->dateFormat($request['start_date']),
                    'end_date'              => $this->dateFormat($request['end_date']),
                    'course_fee'            => $request['course_fee'],
                    'course_fee_type'       => $request['course_fee_type'],
                    'status_id'             => $request['status_id'],
                    'aiss_date'             => $aiss_date,
                    'remarks'               => $request['remarks'],
                    'uc_description'        => $request['uc_description'],
                    'user_id'               => Auth::user()->id
                ]);
                $funded_student_course->save();
                
                // save to enrolment pack only if no process_id/enrolment pack
                if($request['process_id'] == null){
                    $this->createEnrolmentPack($funded_student_course);
                }
                

                // ADD/UPDATE ATTENDANCE
                $this->storeUpdate_attendance($request['class'], $funded_student_course);

                $this->createPaymentSchedule($funded_student_course);
                //create payment schedule (full fee course only)
                // if ($funded_student_course->course_fee_type == 'FF') {
                //     $this->createPaymentSchedule($funded_student_course);
                //     // dd('heeeeeeee');
                // }


                // ADD to Funded course details
                $course_details = new FundedStudentCourseDetail;
                $course_details->fill([
                    'outcome_id_national'                       => $request['outcome_id_national'],
                    'funding_source_national'                   => $request['funding_source_national'],
                    'commence_prg_identifier'                   => $request['commence_prg_identifier'],
                    'training_contract_id'                      => $request['training_contract_id'],
                    'client_id_apprenticeships'                 => $request['client_id_apprenticeships'],
                    'study_reason_id'                           => $request['study_reason_id'],
                    'funding_type'                              => isset($request['funding_type']) ? $request['funding_type']['id'] : null,
                    'specific_funding_id'                       => $request['specific_funding_id'],
                    'funding_source_state_training_authority'   => $request['funding_source_state_training_authority'],
                    'purchasing_contract_id'                    => $request['purchasing_contract_id'],
                    'purchasing_contract_schedule_id'           => $request['purchasing_contract_schedule_id'],
                    'associated_course_id'                      => $request['associated_course_id'],
                    'predominant_delivery_mode'                 => $request['predominant_delivery_mode'],
                    'full_time_leaning_option'                  => $request['full_time_leaning_option']
                ]);
                $course_details->funded_student_course()->associate($funded_student_course);
                $course_details->save();


                // ADD Course Completion
                $completion = new CourseCompletion;
                $completion->fill([
                    'student_id' => $student_id,
                    'course_code' => $request['course_code'],
                    'completion_status' => 5,
                    'user_id' => Auth::user()->id
                ]);
                $completion->save();

                $completion_student_course = new CompletionStudentCourse;
                $completion_student_course->fill(['student_type' => 2]);
                $completion_student_course->completion()->associate($completion);
                $completion_student_course->funded_course()->associate($funded_student_course);
                $completion_student_course->save();

                // ADD Subjects to Course Completion Details
                foreach ($request['courseSubjects'] as $key => $subject) {
                    $start_date = null;
                    $end_date = null;
                    // dump($subject['training_dlvr_loc']);    
                    if ($subject['dates'] != null) {
                        if ($subject['dates']['start'] != null && $subject['dates']['end'] != null) {
                            if ($subject['dates']['start'] == 'Invalid date' && $subject['dates']['end'] == 'Invalid date') {
                                // dd('null/invalid date so get funded_student_course start and end date');
                                $start_date = $funded_student_course->start_date;
                                $end_date = $funded_student_course->end_date;
                            } else {
                                // dd('not null/valid date so get subject dates');
                                $start_date = $this->dateFormat($subject['dates']['start']);
                                $end_date = $this->dateFormat($subject['dates']['end']);
                            }
                        }
                    } else {
                        // dd('null so get funded_student_course start and end date');
                        $start_date = $funded_student_course->start_date;
                        $end_date = $funded_student_course->end_date;
                    }
                    // dump($start_date);
                    // dump($end_date);
                    $completion_details = new CourseCompletionDetail;
                    $completion_details->fill([
                        'course_unit_code'  => $subject['subject_code'],
                        'start_date'        => $start_date,
                        'end_date'          => $end_date,
                        'train_org_loc_id'  => isset($subject['train_org_loc_id']) ? $subject['train_org_loc_id'] : null,
                        'delivery_mode_id'  => isset($subject['delivery_mode_id']) ? $subject['delivery_mode_id'] : null,
                        'trainer_id'            => isset($subject['trainer_id']) ? $subject['trainer_id'] : null,
                        'training_hours'        => isset($subject['training_hours']) ? $subject['training_hours'] : null,
                        'holidays'        => isset($subject['holidays']) ? $subject['holidays'] : null
                    ]);
                    $completion_details->completion()->associate($completion);
                    $completion_details->save();
                }


                // ADD/EDIT EXTRA UNITS 
                $this->store_extraUnits($request['courseExtraUnits'], $funded_student_course);

                DB::commit();


                return json_encode(['data' => $request, 'status' => 'success']);
            } catch (\Exception $e) {
                // rollback db transactions
                DB::rollBack();

                // return to previous page with errors
                return  response()->json(['message' => $e->getMessage(), 'status' => 'errors']);
            }
        }
    }
    public function storeUpdate_attendance($class, $details)
    {

        $attendance = Attendance::where('student_id', $details->student_id)->where('course_code', $details->course_code)->first();

        if (isset($attendance)) {
            try {
                // start db transaction
                DB::beginTransaction();

                $up_att = Attendance::where('id', $attendance->id)->first();
                if($up_att->class_id != $class) {
                    $up_att->update([
                        'class_id'      => $class
                    ]);
    
                    $attendance_details = AttendanceDetail::where('attendance_id', $up_att->id);
                    $attendance_details->delete();
                }
                DB::commit();

                return json_encode(['data' => $up_att, 'status' => 'updated']);
            } catch (\Exception $e) {
                // rollback db transactions
                DB::rollBack();

                echo $e->getMessage();
                exit();
                // return to previous page with errors
                return  response()->json(['message' => $e->getMessage(), 'status' => 'error']);
            }
        } else {
            try {
                // start db transaction
                DB::beginTransaction();

                $add_att = new Attendance;
                $add_att->fill([
                    'class_id'      =>  $class,
                    'student_id'    =>  $details->student_id,
                    'course_code'   =>  $details->course_code
                ]);
                $add_att->save();
                DB::commit();


                return json_encode(['data' => $add_att, 'status' => 'success']);
            } catch (\Exception $e) {
                // rollback db transactions
                DB::rollBack();

                // return to previous page with errors
                return  response()->json(['message' => $e->getMessage(), 'status' => 'errors']);
            }
        }
    }


    public function store_extraUnits($extra_units, $funded_student_course)
    {
        $stud_details = $funded_student_course;
        try {
            // start db transaction
            DB::beginTransaction();

            // GET STUDENT TYPE
            $stud = Student::where('student_id',$stud_details->student_id)->first();
            
            // ADD/UPDATE Subjects to Course Completion Details
            if($stud->student_type_id == 1 && $stud_details->offer_letter_course_detail_id != null) {
                $course_com = CompletionStudentCourse::with('completion.details')->where('student_course_id', $stud_details->offer_letter_course_detail_id)->first();
            }else{
                $course_com = CompletionStudentCourse::with('completion.details')->where('student_course_id', $stud_details->id)->first();
            }
            $com = $course_com ? $course_com->completion : null;
            // $com = CourseCompletion::with('details')->where(['student_id' => $stud_details->student_id, 'course_code' => $stud_details->course_code])->first();
            if ($com != null) {
                $old_eu = $com->details->where('extra_unit', 1);
                $new_eu = $extra_units;
                // dd($old_eu);
                // dd(count($new_eu));

                $prev_date = null;
                $temp_date = null;

                if (count($new_eu) != $old_eu->count()) {
                    // dump('asasdsa');
                    $completion_exist = [];
                    foreach ($new_eu as $key2 => $subject2) {
                        array_push($completion_exist, $subject2['subject_code']);
                    }
                    $exist_on_query = $old_eu->whereNotIn('course_unit_code', $completion_exist);
                    foreach ($exist_on_query as $eq) {
                        $temp_date = $eq->start_date;
                        // dd($temp_date);
                        if ($eq->extra_unit == 1) {
                            // $eq->delete();
                        }
                    }
                    // exit();
                }
                foreach ($new_eu as $key => $eu) {
                    $train_loc = '';
                    $dlvr_mode = '';
                    if (count($new_eu) != $old_eu->count()) {
                        // dump('not equal');
                        $com_det2 = CourseCompletionDetail::where('student_completion_id', $com->id)->where(['course_unit_code' => $eu['subject_code'], 'extra_unit' => 1])->first();
                        // dump($com_det2);
                        if ($com_det2 != null) {
                            $start_date = $com_det2->start_date;
                            $end_date =  $com_det2->end_date;
                            $prev_date = $start_date;

                            $train_loc = $com_det2->train_org_loc_id;
                            $dlvr_mode = $com_det2->delivery_mode_id;
                        } else {
                            // dump($prev_date);
                            if ($prev_date == null) {
                                $prev_date = $temp_date;
                            }
                            $start_date = $prev_date;
                            $end_date =  $prev_date;
                        }

                        if ($old_eu->count() == 0) {
                            if ($eu['dates'] != null) {
                                if ($eu['dates']['start'] != null && $eu['dates']['end'] != null) {
                                    $start_date = $this->dateFormat($eu['dates']['start']);
                                    $end_date = $this->dateFormat($eu['dates']['end']);
                                }
                            } else {
                                $start_date = null;
                                $end_date = null;
                            }
                        }
                    } else {
                        // dump('eq');
                        if ($eu['dates'] != null) {
                            if ($eu['dates']['start'] != null && $eu['dates']['end'] != null) {
                                $start_date = $this->dateFormat($eu['dates']['start']);
                                $end_date = $this->dateFormat($eu['dates']['end']);
                            }
                            // $start_date = Carbon::parse($eu['dates']['start'])->format('Y-m-d');
                            // $end_date = Carbon::parse($eu['dates']['end'])->format('Y-m-d');
                        } else {
                            $start_date = null;
                            $end_date = null;
                        }
                    }

                    // update default orientation date if offer letter is available
                    if(isset($stud_details->offer_letter_course_detail_id) && !in_array($stud_details->offer_letter_course_detail_id, ['',null,0])){
                        $offer = OfferLetterCourseDetail::with('offer_letter')->where('id',$stud_details->offer_letter_course_detail_id)->first();
                        if($offer && isset($offer->offer_letter->id) && $start_date != null){
                            $orientation_date = Carbon::createFromFormat('Y-m-d', $start_date)->subDays(3)->format('Y-m-d');
                            $offer->offer_letter->orientation_date = $orientation_date;
                            $offer->offer_letter->update();
                        }
                    }
                    // dump($start_date);
                    // dd($end_date);
                    if (count($old_eu) == 0) {
                        $completion_details_eu = new CourseCompletionDetail;
                        $completion_details_eu->fill([
                            'course_unit_code'      => $eu['subject_code'],
                            'start_date'            => isset($start_date) ? $start_date : null,
                            'end_date'              => isset($end_date) ? $end_date : null,
                            'train_org_loc_id'      => isset($eu['train_org_loc_id']) ? $eu['train_org_loc_id'] : null,
                            'delivery_mode_id'      => isset($eu['delivery_mode_id']) ? $eu['delivery_mode_id'] : null,
                            'extra_unit'            => 1
                        ]);
                        $completion_details_eu->completion()->associate($com);
                        $completion_details_eu->save();
                    } else {
                        $com_det_eu = CourseCompletionDetail::where('student_completion_id', $com->id)->where(['course_unit_code' => $eu['subject_code'], 'extra_unit' => 1])->first();
                        if ($com_det_eu != null) {
                            // dump('update');
                            $com_det_eu->update([
                                'course_unit_code'      => $eu['subject_code'],
                                'start_date'            => isset($start_date) ? $start_date : null,
                                'end_date'              => isset($end_date) ? $end_date : null,
                                'train_org_loc_id'      => isset($eu['train_org_loc_id']) ? $eu['train_org_loc_id'] : null,
                                'delivery_mode_id'      => isset($eu['delivery_mode_id']) ? $eu['delivery_mode_id'] : null,
                                'extra_unit'            => 1
                            ]);
                            // dd($com_det_eu);
                        } else {
                            $completion_details_eu = new CourseCompletionDetail;
                            $completion_details_eu->fill([
                                'course_unit_code'      => $eu['subject_code'],
                                'start_date'            => isset($start_date) ? $start_date : null,
                                'end_date'              => isset($end_date) ? $end_date : null,
                                'train_org_loc_id'      => isset($eu['train_org_loc_id']) ? $eu['train_org_loc_id'] : null,
                                'delivery_mode_id'      => isset($eu['delivery_mode_id']) ? $eu['delivery_mode_id'] : null,
                                'extra_unit'            => 1
                            ]);
                            $completion_details_eu->completion()->associate($com);
                            $completion_details_eu->save();
                        }
                    }
                }
            }

            DB::commit();

            // return json_encode(['data' => $request->all(), 'status' => 'updated']);
        } catch (\Exception $e) {
            // rollback db transactions
            DB::rollBack();
            dd($e);
            echo $e->getMessage();
            exit();
            // return to previous page with errors
            return  response()->json(['message' => $e->getMessage(), 'status' => 'error']);
        }
    }
    public function store_units(Request $request)
    {
        $student_id = Student::where('id', $student)->first();
        $student_id = $student_id->student_id;


        if (isset($request->id)) {
            try {
                // start db transaction
                DB::beginTransaction();

                $extra_units = FundedStudentExtraUnits::where('id', $request->id)->first();
                $old_xu = json_decode($extra_units->extra_units, true);


                $unit_details = [];
                foreach ($request->units as $key => $value) {
                    $key_id = $this->searchUnitId($value['id'], $old_xu);
                    $unit_details[] = [
                        'id' => $value['id'],
                        'code' => $value['code'],
                        'description' => $value['description'],
                        'start_date' => isset($key_id) ? $old_xu[$key_id]['start_date'] : '',
                        'end_date' => isset($key_id) ? $old_xu[$key_id]['end_date'] : '',
                        'status' => 1
                    ];
                }


                $extra_units->update([
                    'extra_units'           =>  json_encode($unit_details)
                ]);
                DB::commit();

                return json_encode(['data' => $request->all(), 'status' => 'updated']);
            } catch (\Exception $e) {
                // rollback db transactions
                DB::rollBack();

                echo $e->getMessage();
                exit();
                // return to previous page with errors
                return  response()->json(['message' => $e->getMessage(), 'status' => 'error']);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'units' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'errors', 'errors' => $validator->messages()]);
            }

            try {
                // start db transaction
                DB::beginTransaction();
                $unit_details = [];
                foreach ($request->units as $key => $value) {
                    // dump($value);
                    $unit_details[] = [
                        'id' => $value['id'],
                        'code' => $value['code'],
                        'description' => $value['description'],
                        'start_date' => '',
                        'end_date' => '',
                        'status' => 1
                    ];
                }

                $extra_units = new FundedStudentExtraUnits;
                $extra_units->fill([
                    'student_id'            => $student_id,
                    'extra_units'           =>  json_encode($unit_details)
                ]);
                $extra_units->save();

                DB::commit();


                return json_encode(['data' => $request, 'status' => 'updated']);
            } catch (\Exception $e) {
                // rollback db transactions
                DB::rollBack();

                // return to previous page with errors
                return  response()->json(['message' => $e->getMessage(), 'status' => 'errors']);
            }
        }
    }

    public function searchUnitId($id, $array)
    {
        foreach ($array as $key => $val) {
            if ($val['id'] === $id) {
                return $key;
            }
        }
        return null;
    }

    public function getOptions($filter, $code)
    {
        $filters = json_decode($filter);
        $class = [];
        if ($filters->location != null) {
            $class = StudentClass::select(DB::raw("CONCAT(`desc`,' ', '(',time_table_type,')') AS description"), 'id')->where('course_code', $code)->where('location', $filters->location)->pluck('description', 'id');
        }

        $course_subjects = CourseProspectus::where('course_code', $code)->get();
        $arr_loc = [];
        if ($course_subjects->count() > 0) {
            foreach ($course_subjects as $key => $cs) {
                array_push($arr_loc, $cs->location);
            }
        }
        $arr_loc = count($arr_loc) > 0 ? implode(',', $arr_loc) : null;
        $arr_loc = explode(',', $arr_loc);
        $slct_state = AvtStateIdentifier::whereIn('state_key', array_unique($arr_loc))->orderBy('state_name')->pluck('state_name', 'state_key');

        return response()->json([
            'slct_class' => $class,
            'slct_state' => $slct_state
        ]);
    }

    public function getFundingSourceState($location)
    {
        $slct_funding_source_state = AvtFundingSourceState::where('location', $location)->orderBy('description', 'asc')->pluck('description', 'value');

        return response()->json([
            'slct_funding_source_state' => $slct_funding_source_state,
        ]);
    }

    public function getCourseFee($filter, $code)
    {
        // dd($filter);
        // dump($code);
        $filters = json_decode($filter);
        $course_subjects_ = [];
        $course_fee = FundedCourseMatrices::where('course_code', $code)->where('location', $filters->location)->first();
        $student_course = FundedStudentCourse::where('student_id', $filters->student_id)->where('course_code', $code)->first();

        // dd($slct_class);
        // if(count($course_fee) == 1){
        //     $cf = $course_fee->where('location', $filters->location)->first();
        // }elseif(count($course_fee) > 1){
        //     foreach($course_fee as $key => $value){
        //         $cf = $value->where('location', $filters->location)->first();
        //     }
        // }else{
        //     $cf = null;
        // }


        // PROSPECTUS
        // $course_subjects = CourseProspectus::where('course_code', $code)->where('location', $filters->location)->first();
        $course_subjects = CourseProspectus::where('course_code', $code)->get();
        // $class_time_table = ClassTimeTable::where('class_id', $filters->class)->first();
        // if ($class_time_table) {
        //     $class_time_table = $class_time_table->time_table;
        // }
        $course_completion = CourseCompletion::where('student_id', $filters->student_id)->where('course_code', $code)->get();
        $arr_cs = [];
        foreach ($course_subjects as $key => $cs) {
            $locations = explode(',', $cs->location);

            foreach ($locations as $key => $loc) {
                // CHECK LOCATION
                if ($loc == $filters->location) {

                    $get_subs = $cs->where('course_code', $code)->where('location', $cs->location)->first();

                    if ($get_subs != null) {
                        $sub_list = json_decode($get_subs->course_units);
                        foreach ($sub_list as $key => $value) {
                            $subject_code = $value->code;
                            $unit = Unit::where('code', $subject_code)->first();

                            $arr_cs[] = [
                                'subject_code'      => $subject_code,
                                'description'       => $unit->description,
                                'unit_type'         => $unit->unit_type,
                                'dates'             => ['start' => null, 'end' => null],
                                'train_org_loc_id'  => $value->train_org_dlvr_loc_id,
                                'trainer_id'        => null,
                                'training_hours'    => null,
                                'holidays'          => null
                            ];
                        }
                    }
                    // dd('naa');
                } else {
                    // dd('wala');
                    $course_subjects = null;
                }
            }
        }

        // get class details /Timetable
        // 0 is None / No class
        $arr_tt_units = [];
        $checkunits = [];
        $class_details = null;
        if ($filters->class != 0) {
            $class = StudentClass::with('time_table', 'delivery_location')->where('id', $filters->class)->where('location', $filters->location)->first();
            if ($class) {
                $class_details = $class;
                $timetable = $class->time_table;
                // dump($timetable);
                if ($timetable != null) {
                    $training_loc = TrainingDeliveryLoc::where('id', $class->delivery_loc)->first();
                    $holidays = null;
                    if ($class->time_table_type == 'Straight') {
                        // dd($class);
                        $tt_units = $timetable->time_table;
                        foreach ($tt_units as $ttu) {

                            $unit = $ttu['unit'];
                            if (isset($ttu['holidays'])) {
                                if (count($ttu['holidays']) > 0) {
                                    $holidays = json_encode($ttu['holidays']);
                                }
                            }

                            $arr_tt_units[] = [
                                'subject_code'      => $unit['code'],
                                'description'       => $unit['description'],
                                'unit_type'         => $unit['unit_type'],
                                'dates'             => ['start' => $ttu['dates']['start'], 'end' => $ttu['dates']['end']],
                                'train_org_loc_id'  => $training_loc->train_org_dlvr_loc_id,
                                'trainer_id'        => isset($ttu['trainer']) ? $ttu['trainer']['id'] : null,
                                'training_hours'    => $ttu['training_hours'],
                                'holidays'          => $holidays,
                                'delivery_mode_id'  => $class->delivery_mode,
                                'order'          => $ttu['order']
                            ];
                        }
                    } else {
                        $time_table = collect($timetable->time_table);
                        // $data = $time_table->where('dates.start', '>', '2020-11-22');
                        // $tt_units = $timetable->time_table;
                        $start_course = '';
                        $end_lopper = false;

                        foreach ($time_table as $ttu) {

                            if (isset($ttu['holidays'])) {
                                if (count($ttu['holidays']) > 0) {
                                    $holidays = json_encode($ttu['holidays']);
                                }
                            }

                            if (isset($ttu['unit'])) {
                                $unit = $ttu['unit'];
                                $checkunits[] = $unit['code'];
                                $arr_tt_units[] = [
                                    'subject_code'      => $unit['code'],
                                    'description'       => $unit['description'],
                                    'unit_type'         => $unit['unit_type'],
                                    'dates'             => ['start' => $ttu['dates']['start'], 'end' => $ttu['dates']['end']],
                                    'train_org_loc_id'  => $training_loc->train_org_dlvr_loc_id,
                                    'trainer_id'        => isset($ttu['trainer']) ? $ttu['trainer']['id'] : null,
                                    'training_hours'    => $ttu['training_hours'],
                                    'holidays'          => $holidays,
                                    'delivery_mode_id'  => $class->delivery_mode,
                                    'order'          => $ttu['order']
                                ];
                            }
                        }
                        /* foreach($data as $ttu){
                            foreach($arr_cs as $key=>$cs){
                                if(isset($ttu['unit'])){
                                     if(isset($ttu['isRotate'])){
                                            $rotating = true;
                                        }else{
                                            $rotating = false;
                                        }
                                      $unit = $ttu['unit'];
                                    if($cs['subject_code'] == $unit['code']){
                                        if($start_course == ''){
                                            $start_course = $unit['code'];
                                           
                                            $arr_tt_units[] = [
                                                'subject_code'      => $unit['code'],
                                                'description'       => $unit['description'],
                                                'unit_type'         => $unit['unit_type'],
                                                'dates'             => ['start' => $ttu['dates']['start'], 'end' => $ttu['dates']['end']],
                                                'train_org_loc_id'  => $training_loc->train_org_dlvr_loc_id,
                                                'rotating'          => $rotating
                                            ];
                                        }else{
                                            if( $unit['code'] === $start_course){
                                                $end_lopper = true;
                                            break;
                                            }else{
                                                 $arr_tt_units[] = [
                                                'subject_code'      => $unit['code'],
                                                'description'       => $unit['description'],
                                                'unit_type'         => $unit['unit_type'],
                                                'dates'             => ['start' => $ttu['dates']['start'], 'end' => $ttu['dates']['end']],
                                                'train_org_loc_id'  => $training_loc->train_org_dlvr_loc_id,
                                                'rotating'          => $rotating
                                            ];
                                            }
                                        }
                                        
                                    }
                                }
                            }
                            if($end_lopper){
                            break;
                            }
                        } */
                    }
                }
            }
            // get units in timetable if with class
            $course_subjects_ = $arr_tt_units;
        } else {
            // get units in prospectus if without class
            $course_subjects_ = $arr_cs;
        }

        // dump($arr_tt_units);
        // dump(count($arr_cs));
        // dump($arr_cs);
        // dd($course_subjects_);
        return response()->json([
            'data'                      => $course_fee,
            'student_course'            => $student_course,
            'course_subjects'           => $course_subjects_,
            'course_completion'         => $course_completion,
            'timetable'                 => $checkunits,
            'prospectus_units'          => $arr_cs,
            'time_table_units'          => $arr_tt_units,
            'class_details'             => $class_details
        ]);
    }

    public function generate_invoice($student, $code)
    {
        $student_info = Student::with('party.person', 'funded_detail.contact')->where('id', $student)->first();
        $student_id = $student_info->student_id;
        $contact = $student_info->funded_detail->contact;
        if ($contact->state_id != null) {
            $state = AvtStateIdentifier::where('id', $contact->state_id)->first();
            $state = $state->state_key;
        } else {
            $state = '';
        }
        $course_units = null;
        $unit_list = [];
        $fee_per_unit = null;
        $page = 0;

        $course_details = FundedStudentCourse::with('completion')->where('student_id', $student_id)->where('course_code', $code)->first();
        $course_name = Course::where('code', $code)->first();
        $student_invoice = StudentInvoice::where('student_id', $student_id)->where('course_code', $code)->first();
        // dd($student_invoice);
        if (count($course_details->completion) != 0) {
            $com_id = $course_details->completion->where('course_code', $code)->first();
            $course_units = CourseCompletionDetail::where('student_completion_id', $com_id->id)->get();
            $fee_per_unit = round((int) $course_details->course_fee / count($course_units)) . '.00';

            foreach ($course_units as $cu) {
                $unit = Unit::where('code', $cu->course_unit_code)->first();
                $unit_list[] = [
                    'unit'          => $unit->code . ' ' . $unit->description,
                    'fee_per_unit'  => $fee_per_unit
                ];
            }
        }
        // $random_num = mt_rand(100000,999999); 

        $invoice_details = [];
        $invoice_details = [
            'id'                => $course_details->id,
            'student_id'        => $student_id,
            'fullname'          => $student_info->party->name,
            'street_addr'       => $contact->addr_street_num . ' ' . $contact->addr_street_name,
            'address'           => $contact->addr_suburb . ' ' . $state . ' ' . $contact->postcode,
            'course_code'       => $course_details->course_code,
            'course'            => $course_details->course_code == '@@@@' ? 'Unit of Competency' : $code . ' ' . '-' . ' ' . $course_name->name,
            'course_fee_type'   => $course_details->course_fee_type,
            'description'       => $course_details->course_fee_type,
            // 'course_fee'        => $course_details->course_fee,
            'fee_per_unit'      => $fee_per_unit,
            // 'invoice_number'    => '00'.$random_num,
            'course_units'      => $course_units,
            'unitList'          => $unit_list,
            'date_created'      => $course_details->start_date,
            'due_date'          => $course_details->start_date,
            'amount'            => $course_details->course_fee,
        ];
        // dd($student_invoice);
        if ($student_invoice == null) {
            $this->createInvoice($invoice_details);
            $student_invoice = StudentInvoice::where('student_id', $student_id)->where('course_code', $code)->first();
        }

        // Company Details
        $com_setting = TrainingOrganisation::first();
        $bank_details = TrainingOrgBankDetails::where('training_organisation_id', $com_setting->training_organisation_id)->first();
        // dd($com_setting);
        //  $address = $com_setting->addr_line1 .', '. $com_setting->addr_location .', '. $com_setting->state_identifier . ' ' . $com_setting->postcode .', '. 'Australia';
        if ($com_setting->logo_img != null) {
            $logo = 'storage/config/images/' . $com_setting->logo_img;
        } else {
            $logo = 'images/logo/vorx_logo.png';
        }
        $logo_url = url('/' . $logo . '');
        // Maximum unit per page (25)

        $invoice_items = json_decode($student_invoice->items, true);
        if ($invoice_items != null && count($invoice_items) > 25) {
            $unit_lists = array_chunk($invoice_items, 25);
            $page = count($unit_lists);
        } else {
            $unit_lists[0] = $invoice_items;
            $page = 1;
        }

        $file_name = $student_info->party->name . ' ' . '-' . ' ' . $code . '.pdf';
        return \PDF::loadView($com_setting->custom_invoice, compact('student_invoice', 'invoice_details', 'com_setting', 'logo_url', 'bank_details', 'unit_lists', 'page'))->setPaper(array(0, 0, 595, 842), 'portrait')->stream($file_name);
    }

    public function createInvoice($invoice_details)
    {

        $student_invoice = StudentInvoice::where('student_id', $invoice_details['student_id'])->where('course_code', $invoice_details['course_code'])->first();
        // $random_num = mt_rand(100000, 999999);
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $invoice_num = $this->generate_string($permitted_chars, 12);
        $transaction_num = $this->generate_string($permitted_chars, 12);

        try {
            DB::beginTransaction();
            if (!isset($student_invoice->id)) {
                $stud_invoice = new StudentInvoice;
                $stud_invoice->fill([
                    'student_id'            => $invoice_details['student_id'],
                    'course_code'           => $invoice_details['course_code'],
                    'invoice_number'        => $invoice_num,
                    'transaction_number'    => $transaction_num,
                    'description'           => $invoice_details['description'],
                    'amount'                => $invoice_details['amount'],
                    'items'                 => json_encode($invoice_details['unitList']),
                    'date'                  => Carbon::parse($invoice_details['date_created'])->format('Y-m-d'),
                    'due_date'              => Carbon::parse($invoice_details['due_date'])->format('Y-m-d'),
                    'user_id'               => Auth::user()->id
                ]);
                $stud_invoice->save();

                DB::commit();
            } else {
                dd('update invoice');
            }


            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();

            throw $th;
        }
    }

    public function generate_string($input = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', $strength = 16)
    {
        $input_length = strlen($input);
        $random_string = '';

        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        $validate = StudentInvoice::where('invoice_number', $random_string)->first();

        if ($validate) {
            $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $this->generate_string($permitted_chars, 12);
        } else {
            return $random_string;
        }
    }

    public function update_invoice(Request $request)
    {
        $request = $request->inputs;
        // dd($request);
        $validator = Validator::make($request, [
            'date' => 'required',
            'due_date' => 'required',
            'invoice_number' => 'required|size:12|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'errors', 'errors' => $validator->messages()]);
        }

        try {
            //code...
            DB::beginTransaction();

            $student_invoice = StudentInvoice::where('student_id', $request['student_id'])->where('course_code', $request['course_code'])->first();
            // dd($student_invoice);
            $student_invoice->update([
                'date'                      => Carbon::parse($request['date'])->format('Y-m-d'),
                'due_date'                  => Carbon::parse($request['due_date'])->format('Y-m-d'),
                'invoice_number'            => $request['invoice_number'],
            ]);

            DB::commit();
            return json_encode(['data' => $request, 'status' => 'updated']);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            return json_encode(['student' => $request, 'status' => 'error']);
        }
    }

    public function generate_payment_plan($student, $code)
    {

        $student_info = Student::with('party.person', 'funded_detail.contact')->where('id', $student)->first();
        $student_id = $student_info->student_id;
        $contact = $student_info->funded_detail->contact;
        if ($contact->state_id != null) {
            $state = AvtStateIdentifier::where('id', $contact->state_id)->first();
            $state = $state->state_key;
        } else {
            $state = '';
        }

        $course_details = FundedStudentCourse::with('matrices', 'payment_details')->where('student_id', $student_id)->where('course_code', $code)->first();
        // dd($this->createPaymentSchedule($course_details));
        $payment_sched = PaymentScheduleTemplate::where('funded_student_course_id', $course_details->id)->latest()->get();

        // dd($payment_sched);

        if ($code == '@@@@') {
            $course = 'Unit of Competency';
        } else {
            $course_name = Course::where('code', $code)->first();
            $course = $code . ' ' . '-' . ' ' . $course_name->name;
        }

        $stud_details = [];
        $stud_details = [
            'id'                => $course_details->id,
            'student_id'        => $student_id,
            'fullname'          => $student_info->party->name,
            'dob'               => $student_info->party->person->date_of_birth,
            'email'             => $contact->email,
            'street_addr'       => $contact->addr_street_num . ' ' . $contact->addr_street_name,
            'address'           => $contact->addr_suburb . ', ' . $state . ' ' . $contact->postcode,
            'course'            => $course,
            'start_date'        => $course_details->start_date,
            'end_date'          => $course_details->end_date,
            'course_fee_type'   => $course_details->course_fee_type,
            'course_fee'        => $course_details->course_fee,
            // 'min_payment'       => $matrix->min_payment,
            'date_created'      => $course_details->created_at
        ];
        // dd($stud_details);

        // Company Details
        $com_setting = TrainingOrganisation::first();
        if ($com_setting->logo_img != null) {
            $logo = 'storage/config/images/' . $com_setting->logo_img;
        } else {
            $logo = 'images/logo/vorx_logo.png';
        }
        $logo_url = url('/' . $logo . '');

        $file_name = $stud_details['fullname'] . ' ' . '-' . ' ' . $course . '.pdf';

        return \PDF::loadView('students.domestic.payment_plan', compact('stud_details', 'com_setting', 'logo_url', 'payment_sched'))->setPaper(array(0, 0, 595, 842), 'portrait')->stream($file_name);
    }

    public function createPaymentSchedule($funded_student_course)
    {
        $course_detail = $funded_student_course;
        // $funded_matrix = FundedCourseMatrices::where('course_code', $course_detail->course_code)->where('location', $course_detail->location)->first();
        // dump($course_detail);
        // dd($funded_matrix);
        try {

            DB::beginTransaction();

            $min_payment = 0;
            $weekCount = 0;
            $startDuration = \Carbon\Carbon::parse($course_detail->start_date);
            $cstart_date = Carbon::createFromFormat('Y-m-d', $course_detail->end_date);
            $monthly = $cstart_date->diffInMonths($course_detail->start_date);
            // $monthly = $course_detail->course_end_date->diffInMonths($course_detail->course_start_date);
            $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $invoice_no = $this->generate_string($permitted_chars, 12);
            $payment = new PaymentScheduleTemplate;
            $payment->fill([
                'invoice_no'                => $invoice_no,
                'due_date'                  => $startDuration->subDays(3)->format('Y-m-d'),
                'payable_amount'            => (float) $course_detail->course_fee
            ]);
            $payment->user()->associate(Auth::user());
            $payment->funded_course_detail()->associate($course_detail);
            $payment->save();

            // if ($funded_matrix != null) {

            //     $min_payment = $funded_matrix->min_payment;
            //     $mos_payment = round($course_detail->course_fee / $monthly);

            //     if ($min_payment < $mos_payment) {

            //         // minimum payment is less than monthly payment(duration)
            //         for ($i = 0; $i < $monthly; $i++) {
            //             $payment = new PaymentScheduleTemplate;
            //             $curr_balance = isset($curr_balance) ? $curr_balance : $course_detail->course_fee;
            //             $remaining_bal = number_format($monthly - 1);
            //             $checkNegative = number_format($course_detail->course_fee - $min_payment);

            //             if ($checkNegative > 0) {
            //                 // $roundPayable = $noRound > $round ? $round + 100 : $round;
            //                 $roundPayable = $min_payment;
            //             } else {
            //                 $roundPayable = $curr_balance;
            //             }

            //             $payment->fill([
            //                 'due_date'                  => ($i == 0) ? $startDuration->addWeek($weekCount)->format('Y-m-d') : $startDuration->addMonth()->format('Y-m-d'),
            //                 'payable_amount'            => ($i == $remaining_bal) ? (float) $curr_balance : (float) $roundPayable
            //             ]);

            //             $payable = $roundPayable;
            //             $curr_balance = (isset($curr_balance) ? floor((int) $curr_balance - (int) $payable) : (int) $course_detail->course_fee);
            //             $payment->funded_course_detail()->associate($course_detail);
            //             $payment->user()->associate(Auth::user());

            //             if ($roundPayable != 0) {
            //                 $payment->save();
            //             }
            //         }
            //     } elseif ($min_payment > $mos_payment) {

            //         // with course matrix but min payment is greater than monthly payment (base on duration)
            //         for ($i = 0; $i < $monthly; $i++) {
            //             $payment = new PaymentScheduleTemplate;
            //             $curr_balance = isset($curr_balance) ? $curr_balance : $course_detail->course_fee;
            //             $noRound = round($course_detail->course_fee / $monthly);
            //             $round = round($course_detail->course_fee / $monthly, -2);
            //             $checkNegative = number_format($curr_balance - ($course_detail->course_fee / $monthly));

            //             if ($checkNegative > 0) {
            //                 $roundPayable = $noRound > $round ? $round + 100 : $round;
            //             } else {
            //                 $roundPayable = $curr_balance;
            //             }
            //             $payment->fill([
            //                 'due_date'                  => ($i == 0) ? $startDuration->addWeek($weekCount)->format('Y-m-d') : $startDuration->addMonth()->format('Y-m-d'),
            //                 'payable_amount'            => (float) $roundPayable
            //             ]);
            //             $payable = $roundPayable;
            //             $curr_balance = (isset($curr_balance) ? floor((int) $curr_balance - (int) $payable) : (int) $course_detail->course_fee);

            //             $payment->funded_course_detail()->associate($course_detail);
            //             $payment->user()->associate(Auth::user());
            //             if ($roundPayable != 0) {
            //                 $payment->save();
            //             }
            //         }
            //     }
            // } else {
            //     // dd('without course matrix created');
            //     for ($i = 0; $i < $monthly; $i++) {
            //         $payment = new PaymentScheduleTemplate;
            //         $curr_balance = isset($curr_balance) ? $curr_balance : $course_detail->course_fee;
            //         $noRound = round($course_detail->course_fee / $monthly);
            //         $round = round($course_detail->course_fee / $monthly, -2);
            //         $checkNegative = number_format($curr_balance - ($course_detail->course_fee / $monthly));

            //         if ($checkNegative > 0) {
            //             $roundPayable = $noRound > $round ? $round + 100 : $round;
            //         } else {
            //             $roundPayable = $curr_balance;
            //         }
            //         $payment->fill([
            //             'due_date'                  => ($i == 0) ? $startDuration->addWeek($weekCount)->format('Y-m-d') : $startDuration->addMonth()->format('Y-m-d'),
            //             'payable_amount'            => (float) $roundPayable
            //         ]);
            //         $payable = $roundPayable;
            //         $curr_balance = (isset($curr_balance) ? floor((int) $curr_balance - (int) $payable) : (int) $course_detail->course_fee);

            //         $payment->funded_course_detail()->associate($course_detail);
            //         $payment->user()->associate(Auth::user());
            //         if ($roundPayable != 0) {
            //             $payment->save();
            //         }
            //     }
            // }
            // dd($min_payment);



            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();

            throw $th;
        }
    }

    public function visa_update(Request $request, $student_id)
    {
        $request = $request->inputs;
        $visa = FundedStudentVisaDetails::where('student_id', $student_id)->first();
        // dump($request['visa_type']);
        $subclass = null;
        if ($request['visa_type'] != null) {
            $vt = $request['visa_type']['value'];
            $vt = preg_replace('/\D/', '', $vt);
            $vt = str_split($vt, 3);
            $subclass = implode(',', $vt);
        }
        if ($subclass == '') {
            $subclass = null;
        }
        // dd($subclass);
        if ($request['issue_date'] == 'Invalid date') {
            $issue_date = null;
        } else {
            $issue_date = $request['issue_date'];
        }
        if ($request['expiry_date'] == 'Invalid date') {
            $expiry_date = null;
        } else {
            $expiry_date = $request['expiry_date'];
        }
        if ($request['expiry_date_visa_type'] == 'Invalid date') {
            $expiry_date_visa_type = null;
        } else {
            $expiry_date_visa_type = $request['expiry_date_visa_type'];
        }
        // dump($issue_date);
        // dump($expiry_date);
        // dump($expiry_date_visa_type);

        if (isset($visa)) {
            try {
                // start db transaction
                DB::beginTransaction();

                $visa_info = FundedStudentVisaDetails::where('student_id', $student_id)->first();
                $visa_info->update([
                    "nationality"               => $request['nationality'],
                    "passport_number"           => $request['passport_number'],
                    "issue_date"                => isset($issue_date) ? Carbon::parse($issue_date)->format('Y-m-d') : null,
                    "expiry_date"               => isset($expiry_date) ? Carbon::parse($expiry_date)->format('Y-m-d') : null,
                    "visa_type"                 => isset($request['visa_type']) ? $request['visa_type']['id'] : null,
                    "subclass"                  => isset($subclass) ? $subclass : null,
                    "expiry_date_visa_type"     => isset($expiry_date_visa_type) ? Carbon::parse($expiry_date_visa_type)->format('Y-m-d') : null,
                    "applied_for_au_residency"  => $request['applied_for_au_residency'],
                    "study_rights"              => $request['study_rights'],
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
        } else {
            try {
                // start db transaction
                DB::beginTransaction();

                $visa_info = new FundedStudentVisaDetails;
                // dd($contact);
                $visa_info->fill([
                    "student_id"                => $student_id,
                    "nationality"               => $request['nationality'],
                    "passport_number"           => $request['passport_number'],
                    "issue_date"                => isset($issue_date) ? Carbon::parse($issue_date)->format('Y-m-d') : null,
                    "expiry_date"               => isset($expiry_date) ? Carbon::parse($expiry_date)->format('Y-m-d') : null,
                    "visa_type"                 => isset($request['visa_type']) ? $request['visa_type']['id'] : null,
                    "subclass"                  => isset($subclass) ? $subclass : null,
                    "expiry_date_visa_type"     => isset($expiry_date_visa_type) ? Carbon::parse($expiry_date_visa_type)->format('Y-m-d') : null,
                    "applied_for_au_residency"  => $request['applied_for_au_residency'],
                    "study_rights"              => $request['study_rights'],
                ]);
                // dd($visa_info);
                $visa_info->save();
                DB::commit();

                return json_encode(['data' => $request, 'status' => 'success']);
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

    public function dateFormat($date = null){
        if(isset($date)){
            $date = Carbon::parse($date)->timezone('Australia/Melbourne')->format('Y-m-d');
        }
        return $date;
    }

    public function codeNumber()
    {
        $number = mt_rand(000000001, 999999999);

        $number = sprintf("%09d", $number);

        if (count($this->codeNumberExist($number))) {
            return $this->codeNumber();
        }

        return $number;
    }

    public function codeNumberExist($number)
    {
        return EnrolmentPack::where('process_id', $number)->get();
    }

    public function createEnrolmentPack($details){
        
        $student = Student::with('party.person', 'type')->where('student_id', $details->student_id)->first();
        $ep = null;
        $enrolment = null;

        $ep = new EnrolmentPack;
        $ep->process_id = $details->process_id;
        $ep->student_id = $student->student_id;
        $ep->student_name = $student->party->name;
        $ep->student_type = $student->student_type_id;
        // $ep->enrolment_form = $request->inputs;
        $ep->save();

        //get enrolment pages content
        if(config('app.name') == 'Phoenix'){
            if($student->student_type_id == 1){
                $enrolment = new EnrolmentPCAController;
            }else{
                $enrolment = new EnrolmentPCADomesticController;
            }
        }elseif(config('app.name') == 'CEA'){
            $enrolment = new EnrolmentController;
        }

        if($enrolment != null){
            $path ='/public/enrolment/' . $ep->process_id . '/enrolment-form.txt';
            Storage::put($path, json_encode($enrolment->pages()));
        }

        return ['status' => 'success', 'process' => $ep->process_id];
  
    }


    public function generate_receipt($student, $code)
    {
        $student_info = Student::with('party.person', 'funded_detail.contact')->where('id', $student)->first();
        $student_id = $student_info->student_id;
        $contact = $student_info->funded_detail->contact;
        if ($contact->state_id != null) {
            $state = AvtStateIdentifier::where('id', $contact->state_id)->first();
            $state = $state->state_key;
        } else {
            $state = '';
        }
        $course_units = null;
        $unit_list = [];
        $fee_per_unit = null;
        $page = 0;

        $course_details = FundedStudentCourse::with('completion','payment_details')->where('student_id', $student_id)->where('course_code', $code)->first();
        $total_amount_paid = $course_details->payment_details->sum('amount');
        $balance_owning = $course_details->course_fee - $total_amount_paid;
        $latest_payment = FundedStudentPaymentDetails::where('student_course_id', $course_details->id)->latest('payment_date')->first();
        if($latest_payment != null){
            $payment_date = $latest_payment->payment_date;
        }else{
            $payment_date = null;
        }
        
        $course_name = Course::where('code', $code)->first();
        $student_invoice = StudentInvoice::where('student_id', $student_id)->where('course_code', $code)->first();

        if (count($course_details->completion) != 0) {
            $com_id = $course_details->completion->where('course_code', $code)->first();
            $course_units = CourseCompletionDetail::where('student_completion_id', $com_id->id)->get();
            $fee_per_unit = round((int) $course_details->course_fee / count($course_units)) . '.00';

            foreach ($course_units as $cu) {
                $unit = Unit::where('code', $cu->course_unit_code)->first();
                $unit_list[] = [
                    'unit'          => $unit->code . ' ' . $unit->description,
                    'fee_per_unit'  => $fee_per_unit
                ];
            }
        }
        // $random_num = mt_rand(100000,999999); 

        $invoice_details = [];
        $invoice_details = [
            'id'                => $course_details->id,
            'student_id'        => $student_id,
            'fullname'          => $student_info->party->name,
            'street_addr'       => $contact->addr_street_num . ' ' . $contact->addr_street_name,
            'address'           => $contact->addr_suburb . ' ' . $state . ' ' . $contact->postcode,
            'course_code'       => $course_details->course_code,
            'course'            => $course_details->course_code == '@@@@' ? 'Unit of Competency' : $code . ' ' . '-' . ' ' . $course_name->name,
            'course_fee_type'   => $course_details->course_fee_type,
            'description'       => $course_details->course_fee_type,
            // 'course_fee'        => $course_details->course_fee,
            'fee_per_unit'      => $fee_per_unit,
            // 'invoice_number'    => '00'.$random_num,
            'course_units'      => $course_units,
            'unitList'          => $unit_list,
            'date_created'      => $course_details->start_date,
            'due_date'          => $course_details->start_date,
            'amount'            => $course_details->course_fee,
            'total_amount_paid' => $total_amount_paid,
            'balance_owning'    => $balance_owning,
            'payment_date'      => $payment_date,
        ];

        if ($student_invoice == null) {
            $this->createPaymentReceipt($invoice_details);
            $student_invoice = StudentInvoice::where('student_id', $student_id)->where('course_code', $code)->first();
        }
        
        // Company Details
        $com_setting = TrainingOrganisation::first();
        $bank_details = TrainingOrgBankDetails::where('training_organisation_id', $com_setting->training_organisation_id)->first();
        // dd($com_setting);
        //  $address = $com_setting->addr_line1 .', '. $com_setting->addr_location .', '. $com_setting->state_identifier . ' ' . $com_setting->postcode .', '. 'Australia';
        if ($com_setting->logo_img != null) {
            $logo = 'storage/config/images/' . $com_setting->logo_img; 
        } else {
            $logo = 'images/logo/vorx_logo.png';
        }
        $logo_url = url('/' . $logo . '');
        // Maximum unit per page (25)

        $invoice_items = json_decode($student_invoice->items, true);
        if ($invoice_items != null && count($invoice_items) > 25) {
            $unit_lists = array_chunk($invoice_items, 25);
            $page = count($unit_lists);
        } else {
            $unit_lists[0] = $invoice_items;
            $page = 1;
        }
        
        $file_name = $student_info->party->name . ' ' . '-' . ' ' .'Payment Receipt.pdf';
        return \PDF::loadView('custom.invoice.cea_payment_receipt', compact('student_invoice', 'invoice_details', 'com_setting', 'logo_url', 'bank_details', 'unit_lists', 'page'))->setPaper(array(0, 0, 595, 842), 'portrait')->stream($file_name);
    }

    public function createPaymentReceipt($invoice_details)
    {

        $student_invoice = StudentInvoice::where('student_id', $invoice_details['student_id'])->where('course_code', $invoice_details['course_code'])->first();
        // $random_num = mt_rand(100000, 999999);
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $invoice_num = $this->generate_string($permitted_chars, 12);
        $transaction_num = $this->generate_string($permitted_chars, 12);

        try {
            DB::beginTransaction();
            if (!isset($student_invoice->id)) {
                $stud_invoice = new StudentInvoice;
                $stud_invoice->fill([
                    'student_id'            => $invoice_details['student_id'],
                    'course_code'           => $invoice_details['course_code'],
                    'invoice_number'        => $invoice_num,
                    'transaction_number'    => $transaction_num,
                    'description'           => $invoice_details['description'],
                    'amount'                => $invoice_details['amount'],
                    'items'                 => json_encode($invoice_details['unitList']),
                    'date'                  => Carbon::parse($invoice_details['date_created'])->format('Y-m-d'),
                    'due_date'              => Carbon::parse($invoice_details['due_date'])->format('Y-m-d'),
                    'user_id'               => Auth::user()->id
                ]);
                $stud_invoice->save();

                DB::commit();
            } else {
                dd('update invoice');
            }


            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();

            throw $th;
        }
    }

    public function fundingSearch($loc){
        $funding_type = AvtFundingType::where('state_key', $loc)->get();
        return $funding_type;
    }
}
