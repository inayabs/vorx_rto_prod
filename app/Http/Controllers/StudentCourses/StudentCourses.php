<?php

namespace App\Http\Controllers\StudentCourses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FundedStudentCourse;
use App\Models\FundedStudentPaymentDetails;
use App\Models\PaymentScheduleTemplate;
use App\Models\Attendance;
use App\Models\OfferLetterStatus;
use App\Models\Student\OfferLetter\OfferLetter;
use App\Models\AvtFundingType;
use App\Models\AvtDeliveryMode;
use App\Models\AvtCommencingCourse;
use App\Models\AvtStateIdentifier;
use App\Models\AvtFundingSourceNational;
use App\Models\StudentCompletion;
use App\Models\AvtStudyReason;
use App\Models\AvtPredominantDlvrMode;
use App\Models\AvtSpecificFunding;
use App\Models\AvtFundingSourceState;
use App\Models\TrainingDeliveryLoc;
use App\Models\Student\Student;


use Auth;
use Carbon\Carbon;

class StudentCourses extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(){
        $userid = Auth::user()->username;
        $student = Student::where('student_id',$userid)->first();
        
        \JavaScript::put([
            'student'=>$student
        ]);
        return view('student_portal.courses');
    }

    public function get_domStudent_courses($id){
        $course = FundedStudentCourse::with('detail','course', 'completion.details','payment_details')->where('student_id', $id)->get();
        // dd($course[0]->detail);
        foreach($course as $c){
            $c->subjects = StudentCompletion::where('student_id',$id)->where('course_code',$c->course->code)->with(['details.unit','details.training_delivery_location','details.delivery_mode'])->first();
            

            $c->start_date = $c->start_date?Carbon::parse($c->start_date)->format('d/m/Y'):'';
            $c->end_date = $c->end_date?Carbon::parse($c->end_date)->format('d/m/Y'):'';
            $c->aiss_date = $c->aiss_date?Carbon::parse($c->aiss_date)->format('d/m/Y'):'';
            $c->state = $c->location?AvtStateIdentifier::where('state_key',$c->location)->first():'';
            $c->status = $c->status_id?OfferLetterStatus::where('id',$c->status_id)->first():'';

            if(isset($c->detail)){
                $c->detail->funding_type = $c->detail->funding_type?AvtFundingType::where('id',$c->detail->funding_type)->first():'';
                $c->detail->funding_source_national = $c->detail->funding_source_national?AvtFundingSourceNational::where('value',$c->detail->funding_source_national)->first():'';
                $c->detail->commence_prg_identifier = $c->detail->commence_prg_identifier?AvtCommencingCourse::where('value',$c->detail->commence_prg_identifier)->first():'';
                $c->detail->study_reason = $c->detail->study_reason_id?AvtStudyReason::where('value',$c->detail->study_reason_id)->first():'';
                $c->detail->specific_funding = $c->detail->specific_funding_id?AvtSpecificFunding::where('identifier',$c->detail->specific_funding_id)->first():'';
                $c->detail->funding_source_state = $c->detail->funding_source_state_training_authority?AvtFundingSourceState::where('value',$c->detail->funding_source_state_training_authority)->first():'';
                $c->detail->pdelivery_mode = $c->detail->predominant_delivery_mode?AvtPredominantDlvrMode::where('value',$c->detail->predominant_delivery_mode)->first():'';
            }else{
                $c->detail='';
            }
            
            $attendance = Attendance::with(['student_class','attendance_details'=>function($query){
                $query->where('status','!=','N/A')->where('status','!=',null)->orderBy('id','desc');
            }])->where('student_id',$c->student_id)->where('course_code',$c->course_code)->first();
            // dd($attendance);
            if(isset($attendance)){//set date and time format
                if(isset($attendance->student_class)){
                    $attendance->student_class->trainer_selected = $attendance->student_class->trainer_id?$attendance->student_class->trainer_selected:'';
                    $attendance->student_class->start_date = $attendance->student_class->start_date?Carbon::parse($attendance->student_class->start_date)->format('d/m/Y'):'';
                    $attendance->student_class->end_date = $attendance->student_class->end_date?Carbon::parse($attendance->student_class->end_date)->format('d/m/Y'):'';
                    $attendance->student_class->class_start_time = $attendance->student_class->class_start_time?date('g:i A',strtotime($attendance->student_class->class_start_time)):'';
                    $attendance->student_class->class_end_time = $attendance->student_class->class_end_time?date('g:i A',strtotime($attendance->student_class->class_end_time)):'';
                    $attendance->student_class->delivery_location = $attendance->student_class->delivery_loc?TrainingDeliveryLoc::where('id',$attendance->student_class->delivery_loc)->first():'';
                    $attendance->student_class->del_mode = $attendance->student_class->delivery_mode?AvtDeliveryMode::where('value',$attendance->student_class->delivery_mode)->first():'';
                }else{
                    $attendance->student_class = '';
                }
            }else{
                $c->attendance = '';
            }
            $c->attendance = isset($attendance)?$attendance:'';
        }
        
        return $course;
    }

    public function time_table($id,$code){
        $student_completion = StudentCompletion::where('student_id',$id)->where('course_code',$code)->with(['details'=>function($q){
            $q->orderBy('order');
        },'details.unit','details.training_delivery_location','details.delivery_mode'])->first();
        
        // dd($student_completion);
        return $student_completion;
        // $course = FundedStudentCourse::with('detail','course', 'completion.details','payment_details')->where('student_id', $id)->where('course_code',$code)->first();
        // $proposed_start_date = $course->start_date;
        // // dd($proposed_start_date);
        // $student_completion = StudentCompletion::where('student_id',$id)->where('course_code',$code)->with(['details','details.unit','details.training_delivery_location','details.delivery_mode'])->first();
        // // dd($student_completion);
        // $attendance = Attendance::with(['student_class.time_table','attendance_details'=>function($query){
        //     $query->orderBy('id','desc');
        // }])->where('student_id',$student_completion->student_id)->where('course_code',$student_completion->course_code)->first();
        // // dd($attendance->student_class->time_table);
        // $student_units = [];
        // $tt_codes = [];
        // $student_completion->attendance = $attendance;

        // if($attendance!=''){//if naay class si student
        //     if($attendance->student_class->time_table!=''){
        //         $time_table = $student_completion->attendance->student_class;
        //         $student_course_units = $student_completion->details;
        //         foreach($student_course_units as $scu){
        //             foreach($time_table->time_table->time_table as $tt){
        //                 // dd($tt['dates']['start']);
        //                 $tt_date =  Carbon::parse($tt['dates']['start'])->timezone('Australia/Melbourne')->format('Y-m-d');
        //                 // dd($tt_date);
        //                 // dd($tt_date,$proposed_start_date);
        //                 $date_diff = strtotime($tt_date) - strtotime($proposed_start_date);
        //                 // dd($date_diff);
        //                 if(isset($tt['unit'])){
        //                     if($scu->course_unit_code == $tt['unit']['code'] && $date_diff>=0){
        //                         if(!in_array($scu->course_unit_code,$tt_codes)){
        //                             array_push($student_units,$tt);
        //                             array_push($tt_codes,$tt['unit']['code']);
        //                         }
        //                     } 
        //                 }else{//kung break sya
        //                     array_push($student_units,$tt);
        //                 }
        //             }
        //         }
        //     }else{
        //         $student_units = '';
        //     }
        // }else{//if wala pay class si student
        //     $completion_units = $student_completion->details;
        //     // dd($completion_units);
        //     $order = 0;
        //     // dd($completion_units);
        //     foreach($completion_units as $cu){
        //         $order++;
        //         if(isset($cu->unit)){
        //             array_push($student_units,[
        //                 'unit'=>$cu->unit,
        //                 'dates'=>'',
        //                 'order'=>$order,
        //                 'training_hours'=>$cu->unit->scheduled_hours,
        //                 'weeks'=>''
        //             ]);
        //         }
        //     }
        // }
        
        // // dd($student_units);
        // $student_units_ = [];
        // foreach($student_units as $key => $unit){
        //     $student_units_[$unit['order']] = $unit;
        // }
        // // dd($student_units_);
        // ksort($student_units_);
        // return array_values($student_units_);
    }

    public function student_fees(){
        $user = Auth::user();
        $student = Student::with('contact_detail','party')->where('student_id',$user->username)->first();
        
        \JavaScript::put([
            'student'=>$student,
            'user'=>$user
        ]);

        return view('student_portal.fees');
    }

    public function getFees($funded_student_course_id){
        // dd($funded_student_course_id);
        // $payments = PaymentScheduleTemplate::where('offer_letter_course_detail_id',$offer_letter_course_detail_id)->get();
        // if($student_type_id==1){
        //     $payments = FundedStudentPaymentDetails::where('offer_letter_course_detail_id',$id)->orderBy('id','desc')->get();
        // }else{
            $payments = FundedStudentPaymentDetails::where('student_course_id',$funded_student_course_id)->orderBy('id','desc')->get();
        // }
        $sched_template = PaymentScheduleTemplate::where('funded_student_course_id',$funded_student_course_id)->orderBy('due_date','asc')->get();
        // dd($sched_template);
        return response()->json(['payments'=>$payments,'schedule_template'=>$sched_template]);
    }

    
}
