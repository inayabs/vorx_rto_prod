<?php

namespace App\Http\Controllers\Trainers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Trainer;
use App\Models\StudentClass;
use App\Models\PreferredAttendance;
use App\Models\Student\Student;
use App\Models\Course;
use App\Models\User;
use App\Models\AvtDeliveryMode;
use App\Models\Unit;
use App\Models\Attendance;
use App\Models\AttendanceDetail;
use App\Models\StudentCompletion;
use App\Models\StudentCompletionDetail;
use App\Models\FundedStudentCourse;
use App\Models\TrainingDeliveryLoc;
use Carbon\Carbon;
use DB;

class TrainerPortalController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){

    }

    public function trainer_classes(){
        $id = Auth::user()->id;
        // dd($id);
        // $usr = Auth::user();
        // dd(Auth::user()->id);
        $trainer = Trainer::where('hasLogins',$id)->first();
        // dd($trainer);
        \JavaScript::put([
            'trainer'=>$trainer
        ]);
        // dd(Trainer::all());
        return view('trainer-portal.trainer-class');
    }
    
    public function getTrainerClasses($id){//trainer_id
        $classes = StudentClass::all();
        // dd($trainer);
        $trainer_classes = [];
        foreach($classes as $c){
            if(isset($c->trainer_id)){
                $trainers = explode(',',$c->trainer_id);
                foreach($trainers as $t){
                    // dd($trainer->id);
                    if($id==$t){
                        array_push($trainer_classes,$c);
                    }
                }
            }
        }
        
        foreach($classes as $class){
            $class->trainer_selected = $class->trainer_selected;
            $class->delivery_location = $class->delivery_loc?TrainingDeliveryLoc::where('id',$class->delivery_loc)->first():'';
            $class->del_mode = $class->delivery_mode?AvtDeliveryMode::where('value',$class->delivery_mode)->first():'';
        }
        // dd($trainer_classes);
        return $trainer_classes;
    }

    public function class_units($class_id){//kwaon pila ka units ang na assign si trainer sa tiem table
        $my_id = Auth::user()->id;
        $trainer_id = Trainer::where('hasLogins',$my_id)->first()->id;
        // dd($trainer_id);
        $classes = StudentClass::where('id',$class_id)->with('time_table')->first();
        // dd($classes);
        $my_units = [];
        
        foreach($classes->time_table->time_table as $class){
            if(isset($class['trainer'])){
                // dd($class['trainer']['id'],$trainer_id);
                if($class['trainer']['id']==$trainer_id){
                    array_push($my_units,$class);
                }
            }
        }
        
        // dd($units);
        return $my_units?$my_units:'';
    }

    public function getStudentList(Request $request){
        //get students in class --> check student completion units 
        // dd($request->unit['unit']['code']);
        // dd($request->unit['unit']['code']);
        $class_id = $request->class_id;
        $unit_code = $request->unit['unit']['code'];
        $attendance_date = Carbon::parse($request->date)->timezone('Australia/Melbourne')->format('Y-m-d');
        $isRotate = isset($request->unit['isRotate'])?$request->unit['isRotate']:null;
        
        $att_det_count = count(AttendanceDetail::where('unit_code',$unit_code)->where('date_taken',$attendance_date)->get());

        $student_attendance = Attendance::where('class_id',$class_id)->get();
        $student_class = StudentClass::find($class_id);
        // dd($student_class);
        // dd($student_attendance);
        $filtered_students = [];
        $students_list = [];
        $tt_codes = [];
        if(isset($student_attendance)){
            $student_ids = [];
            foreach($student_attendance as $sa){
                array_push($student_ids,$sa->student_id);   
            }
            for($i=0;$i<count($student_attendance);$i++){
                $student = Student::where('student_id',$student_attendance[$i]->student_id)->with('party.person')->first();
                if(isset($student)){
                    $attendance = Attendance::with('student_class.time_table')->where('class_id',$class_id)->where('student_id',$student_attendance[$i]->student_id)->first();
                    $student_completion_units = StudentCompletion::where('student_id',$student_attendance[$i]->student_id)->where('course_code',$student_class->course_code)->with(['details'=>function($q) use($unit_code){
                        $q->where('course_unit_code',$unit_code)->with('unit');
                    },'student.party'])->first();
                    $funded_course = FundedStudentCourse::where('student_id',$student_attendance[$i]->student_id)->where('course_code',$student_attendance[$i]->course_code)->first();
                    $attendance_today = AttendanceDetail::where('attendance_id',$attendance->id)->where('date_taken',$attendance_date)->where('unit_code',$unit_code)->first();
                    
                    
                    
                    $proposed_date = $funded_course->start_date; // para makuha ang time table lods
                    
                    $class_time_table = $attendance->student_class->time_table->time_table;
                    $tts = [];
                    $tt_codes = [];
                    foreach($class_time_table as $ctt){
                        $tt_date = Carbon::parse($ctt['dates']['start'])->timezone('Australia/Melbourne')->format('Y-m-d');
                        
                        $date_diff = strtotime($tt_date) - strtotime($proposed_date);
                        // dd($date_diff);
                        if(isset($ctt['unit'])){
                            if($ctt['unit']['code']==$unit_code && $date_diff>=0){
                                if(!in_array($unit_code,$tt_codes)){
                                    // dd($tts);
                                    array_push($tts,$ctt);
                                    array_push($tt_codes,$ctt['unit']['code']);
                                }
                            }
                        }
                    }
                    // dd( $tts);
                    $student_attendance[$i]->student = $student;
                    $student_attendance[$i]->attendance_today = $attendance_today;
                    $student_attendance[$i]->time_table = $tts;
                    $student_attendance[$i]->funded_student_course = $funded_course;
                    $student_attendance[$i]->attendance = $attendance;
                    $student_attendance[$i]->unit = $student_completion_units->details;
                }
            }

        }
        foreach($student_attendance as $sa){//filter students based on time table rotation
            if(isset($sa->student)){//if naay laman si student
                if($isRotate==1){
                    // dd($sa->time_table[0]['isRotate']);
                    if(isset($sa->time_table[0]['isRotate'])){
                        array_push($filtered_students,$sa);
                    }
                }else{
                    if(!isset($sa->time_table[0]['isRotate'])){
                        array_push($filtered_students,$sa);
                    }
                }
            }               
        }
        // dd($filtered_students);
        return response()->json(['students'=>$filtered_students,'att_det_count'=>$att_det_count]);

    }

    public function getStudentList2(Request $request){
        $class_id = $request->class_id;
        $unit_code = $request->unit['unit']['code'];
        $attendance_date = Carbon::parse($request->date)->timezone('Australia/Melbourne')->format('Y-m-d');
        $isRotate = isset($request->unit['isRotate'])?$request->unit['isRotate']:null;
        
        $att_det_count = count(AttendanceDetail::where('unit_code',$unit_code)->where('date_taken',$attendance_date)->get());

        $student_attendance = Attendance::where('class_id',$class_id)->get();
        $student_class = StudentClass::find($class_id);
        // dd($student_class);
        // dd($student_attendance);
        $filtered_students = [];
        $students_list = [];
        $tt_codes = [];
        if(isset($student_attendance)){
            $student_ids = [];
            foreach($student_attendance as $sa){
                array_push($student_ids,$sa->student_id);   
            }
            for($i=0;$i<count($student_attendance);$i++){
                $student = Student::where('student_id',$student_attendance[$i]->student_id)->with('party.person')->first();
                if(isset($student)){
                    $attendance = Attendance::with('student_class.time_table')->where('class_id',$class_id)->where('student_id',$student_attendance[$i]->student_id)->first();
                    $student_completion_units = StudentCompletion::where('student_id',$student_attendance[$i]->student_id)->where('course_code',$student_class->course_code)->with(['details'=>function($q) use($unit_code){
                        $q->where('course_unit_code',$unit_code)->with('unit');
                    },'student.party'])->first();
                    

                    $funded_course = FundedStudentCourse::where('student_id',$student_attendance[$i]->student_id)->where('course_code',$student_attendance[$i]->course_code)->first();
                    $attendance_today = AttendanceDetail::where('attendance_id',$attendance->id)->where('date_taken',$attendance_date)->where('unit_code',$unit_code)->first();
                    $_user = User::where('username',$student_attendance[$i]->student_id)->first();
                    
                    
                    $course_start_date = $funded_course->start_date; // para makuha ang time table lods
                    $course_end_date   = $funded_course->end_date;

                    $class_time_table = $attendance->student_class->time_table->time_table;
                    $tts = [];
                    $tt_codes = [];
                    foreach($class_time_table as $ctt){
                        $tt_date = Carbon::parse($ctt['dates']['start'])->timezone('Australia/Melbourne')->format('Y-m-d');
                        
                        $date_diff = strtotime($tt_date) - strtotime($course_start_date);
                        // dd($date_diff);
                        if($date_diff>=0){
                            if(!in_array($unit_code,$tt_codes)){
                                // dd($tts);
                                array_push($tts,$ctt);
                                array_push($tt_codes,$ctt['unit']['code']);
                            }
                        }
                        // if(isset($ctt['unit'])){
                        //     if($ctt['unit']['code']==$unit_code && $date_diff>=0){
                        //         if(!in_array($unit_code,$tt_codes)){
                        //             // dd($tts);
                        //             array_push($tts,$ctt);
                        //             array_push($tt_codes,$ctt['unit']['code']);
                        //         }
                        //     }
                        // }
                    }
                    // dd( $tts);
                    $student_attendance[$i]->student = $student;
                    $student_attendance[$i]->attendance_today = $attendance_today;
                    $student_attendance[$i]->time_table = $tts;
                    $student_attendance[$i]->funded_student_course = $funded_course;
                    $student_attendance[$i]->attendance = $attendance;
                    $student_attendance[$i]->unit = $student_completion_units->details;
                    $student_attendance[$i]->user = $_user;
                }
            }

        }
        
        foreach($student_attendance as $sa){//filter students based on time table rotation
            if(isset($sa->student)){//if naay laman si student
                // $ttstart = Carbon::parse($sa->time_table[0]['dates']['start'])->timezone('Australia/Melbourne')->format('Y-m-d');
                // $ttend = Carbon::parse($sa->time_table[0]['dates']['end'])->timezone('Australia/Melbourne')->format('Y-m-d');
                // dd($sa->funded_student_course->start_date);
                $course_start = $sa->funded_student_course->start_date; 
                $course_end = $sa->funded_student_course->end_date; 
                // dd($course_start_date,$course_end_date,$attendance_date,$sa->student);
                // dd($ttstart,$ttend,$attendance_date);
                if(isset($course_start) && isset($course_end)){
                    if($attendance_date>=$course_start && $attendance_date<=$course_end){
                        array_push($filtered_students,$sa);
                    }
                }
                // if($isRotate==1){
                //     // dd($sa->time_table[0]['isRotate']);
                //     if(isset($sa->time_table[0]['isRotate'])){
                //         if(isset($course_start) && isset($course_end)){
                //             if($attendance_date>=$course_start && $attendance_date<=$course_end){
                //                 array_push($filtered_students,$sa);
                //             }
                //         }
                //     }
                // }else{
                //     if(!isset($sa->time_table[0]['isRotate'])){
                //         if(isset($course_start) && isset($course_end)){
                //             if($attendance_date>=$course_start && $attendance_date<=$course_end){
                //                 array_push($filtered_students,$sa);
                //             }
                //         }
                //     }
                // }
            }               
        }
        // dd($filtered_students);
        return response()->json(['students'=>$filtered_students,'att_det_count'=>$att_det_count]);

    }

    public function save_attendance(Request $request){
        $class_id = $request->class_id;
        $date = Carbon::parse($request->date)->timezone('Australia/Melbourne')->format('Y-m-d');
        // dd($date);
        $student_list = $request->student_list;
        $errors = 0;
        
        foreach($student_list as $student){
            if(isset($student['attendance_today'])){//if naa nay existing attendance si student for the day
                $attendance_detail_id = $student['attendance_today']['id'];
                // dd($student['time_start']);
                try{
                    $att_detail = AttendanceDetail::find($attendance_detail_id);
                    
                    $att_detail->preferred_hours = isset($student['preferred_hours']) ? $student['preferred_hours'] : 8;
                    $att_detail->actual_hours = isset($student['actual_hours']) ? $student['actual_hours'] : 0;
                    $att_detail->status = isset($student['status'])?$student['status']:null;
                    $att_detail->update();
                    
                    // return 'success';
                }catch(Exception $e){   
                    $errors++;
                    // return response()->json(['error'=>$e]);
                }
            }else{
                $attendance_id = $student['attendance']['id'];
                $unit_code = $request->unit['unit']['code'];
                $status = isset($student['actual_hours'])?'Present':'N/A';
                // dd($status);
                try{
                    // dd($student['time_start']);
                    $att_detail = new AttendanceDetail;

                    $att_detail->attendance_id = $attendance_id;
                    $att_detail->unit_code = $unit_code;
                    $att_detail->date_taken = $date;
                    $att_detail->preferred_hours = isset($student['preferred_hours']) ? $student['preferred_hours'] : 8;
                    $att_detail->actual_hours = isset($student['actual_hours']) ? $student['actual_hours'] : 0;
                    $att_detail->status = $status;
                    $att_detail->save();

                    // return 'success';
                }catch(Exception $e){   
                    $errors++;
                    // return response()->json(['error'=>$e]);
                }
            }
        }
        
        return $errors==0?'success':response()->json(['error count'=>$errors]);
    }

    public function update_status($class_id,$status){
        $student_class = StudentClass::find($class_id);
        $student_class->class_status = $status;
        $student_class->save();

        return "success";
    }

    public function clear_attendance(Request $request){
        $class_id = $request->class_id;
        $unit_code = $request->unit['unit']['code'];
        $attendance_date = Carbon::parse($request->date)->timezone('Australia/Melbourne')->format('Y-m-d');

        $att_det = AttendanceDetail::where('unit_code',$unit_code)->where('date_taken',$attendance_date)->get();
        
        //test

        if(isset($att_det)){
            $deleted_att = 0;
            foreach($att_det as $ad){
                $detail = AttendanceDetail::where('id',$ad->id);
                $detail->delete();
                $deleted_att++;
            }
            return response()->json(['message'=>'success','No. of deleted attendance'=>$deleted_att]);
        }else{
            return response()->json(['message'=>'nothing was deleted']);
        }
    }

    public function update_student_class_status(Request $request){
        $att_det_id = $request->attendance_today['id'];
        $status = $request->status;

        // dd($att_det_id,$status);
        try{
            $att_det = AttendanceDetail::find($att_det_id);
            $att_det->status = $status;
            $att_det->update();            

            return response()->json(['response'=>'success']);
        }catch(Exception $e){
            return response()->json(['response'=>'error']);
        }
    }

    public function get_pref_time(Request $request){
        $date_taken = Carbon::parse($request->date)->timezone('Australia/Melbourne')->format('Y-m-d');
        
        $pref_attendance = PreferredAttendance::where('class_id',$request->class_id)->where('unit_code',$request->unit_code)->where('date_taken',$date_taken)->first();

        return $pref_attendance;
    }
}
