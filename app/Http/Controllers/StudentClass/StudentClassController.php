<?php

namespace App\Http\Controllers\StudentClass;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\StudentClass;
use App\Models\Student\Student;
use App\Models\ClassTimeTable;
use App\Models\OfferLetterCourseDetail;
use App\Models\PreferredAttendance;
use App\Models\CompletionStudentCourse;
use App\Models\Trainer;
use App\Models\TrainingDeliveryLoc;
use App\Models\TrainingOrganisation;
use App\Models\AvtDeliveryMode;
use App\Models\Course;
use App\Models\Unit;
use App\Models\Attendance;
use App\Models\AttendanceDetail;
use App\Models\StudentCompletion;
use App\Models\StudentCompletionDetail;
use App\Models\EnrolmentPack;
use App\Models\FundedStudentCourse;
use Carbon\Carbon;
use PDF;
use Auth;

class StudentClassController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        
    }
    public function class_list(){
        $classes = StudentClass::with(['delivery_location'])->orderBy('id','desc')->get();
        // dd($classes);
        return $classes;
    }
    public function index(){
        $user_role = Auth::user()->roles->first();
        // dd(Auth::user()->id);
        
        $trainers = Trainer::orderBy('firstname','asc')->get();
        $delivery_loc = TrainingDeliveryLoc::with(['state'])->orderBy('train_org_dlvr_loc_name','asc')->get();
        $delivery_modes = AvtDeliveryMode::get();
        // dd($delivery_modes);
        $courses = Course::with(['courseprospectus'])->orderBy('code','asc')->get();
        \JavaScript::put([
            'trainers'=>$trainers,
            'delivery_loc'=>$delivery_loc,
            'delivery_modes'=>$delivery_modes,
            'courses'=>$courses,
            'user_role'=>$user_role,
            'user_id'=>Auth::user()->id
        ]);
        return view('classes.index');
    }
    public function add_class(Request $request){
        $trainer = [];
        if(isset($request->trainer)){
            foreach($request->trainer as $tre){
                array_push($trainer,$tre['id']);
            }
            $trainer = implode(',',$trainer);
        }
        $validator = Validator::make($request->all(),[
            'description'=>'required',
            'course_code'=>'required'
        ]);
        if($validator->fails()){
            return response()->json(['status' => 'error', 'errors' => $validator->messages()]);
        }

        if(isset($request->delivery_loc['id'])){
            $dl = TrainingDeliveryLoc::where('id', $request->delivery_loc['id'])->first()->state?TrainingDeliveryLoc::where('id', $request->delivery_loc['id'])->first()->state->state_key:null;
        }else{
            $dl = $request->location;
        }

        try{
            $classes = new StudentClass;
            $classes->desc = $request->description;
            $classes->trainer_id = $trainer;
            $classes->delivery_loc = $request->delivery_loc['id'];
            $classes->delivery_mode = isset($request->delivery_mode)?$request->delivery_mode['value']:null;
            $classes->location = $dl;
            $classes->venue = $request->venue;
            $classes->course_code = $request->course_code['code'];
            $classes->start_date = $request->start_date?Carbon::parse($request->start_date)->format('Y-m-d'):null;
            $classes->end_date = $request->end_date?Carbon::parse($request->end_date)->format('Y-m-d'):null;
            // $classes->class_start_time = $request->class_start_time;
            // $classes->class_end_time = $request->class_end_time;
            $classes->time_table_type = $request->time_table_type;
            $classes->save();
            // $class_trainer = new ClassTrainer;
            
        }catch(Exception $e){
            return response()->json(['status'=>'error','errors'=>$e]);
        }
    }

    public function get_class_fields($class_id){

        $class_fields = StudentClass::with('course.courseprospectus','delivery_location','attendance')->find($class_id);
        // dd($class_fields);
        if($class_fields->trainer_id != null){
            // $class_fields->trainer_selected = 'bullshit';
            // dd('fuck u');
            $class_fields->trainer_selected = $class_fields->trainer_selected;
        }
        // $class_fields->trainer_selected = isset($class_fields->trainer_selected) ? $class_fields->trainer_selected : '';
        return $class_fields;
    }

    public function attendance($id){
        $class = StudentClass::where('id',$id)->with('course','delivery_location')->first();
        // dd($class);
        $class->trainer_selected = $class->trainer_selected;
        if(isset($class->delivery_mode)){
            $class->del_mode = AvtDeliveryMode::where('value',$class->delivery_mode)->first();
        }
        // dd($class->trainer_selected);
        // dd($class);
        \JavaScript::put([
            'class'=>$class
        ]);
        return view('classes.attendance');
    }

    public function get_students($type_id,$class_id){
        // return $type_id.','.$class_id;
        $class = StudentClass::find($class_id);
        $course_code = $class->course_code;
        
        $students = [];
        if($type_id==2){
            
            $stewds = Student::with(['attendance'=>function($q) use($course_code){
                $q->where('course_code',$course_code)->where('class_id','!=',0);
            },'funded_course'=>function($qu) use($course_code){
                $qu->where('course_code',$course_code)->first();
            },'party.person'=>function($query){
                $query->orderBy('firstname','asc');
            }])->where('student_type_id',$type_id)->whereHas('funded_course',function($q) use ($course_code){
                $q->where('course_code','=',$course_code);
            })->get()->sortBy('party.name');//regardless of status
            
            foreach($stewds as $s){
                if(count($s->attendance)==0 && count($s->funded_course)!=0){ //dapat wala pa syay attendance ug dapat naa syay funded_course
                    $s->funded_course_id = $s->funded_course[0]->id;
                    array_push($students,$s);
                }   
            }
            // dd($students);
            // dd($students);
        }else{
            $stewds = Student::with(['offer_letter.course_details','attendance'=>function($q) use($course_code){
                $q->where('course_code',$course_code)->where('class_id','!=',0);
            },'funded_course'=>function($qu) use($course_code){
                $qu->where('course_code',$course_code)->first();
            },'party.person'])->whereHas('offer_letter.course_details',function($query) use($course_code){
                $query->where('course_code',$course_code);
            })->where('student_type_id',$type_id)->get();//disregard status
            // dd($stewds);
            // return $stewds; 
            foreach($stewds as $s){
                if(count($s->attendance)==0 && count($s->funded_course)!=0){ //dapat wala pa syay attendance ug dapat naa syay funded_course
                    $s->funded_course_id = $s->funded_course[0]->id;
                    array_push($students,$s);
                }
            }
        }
        
        return $students;
    }

    public function get_student_attendance($attendance_id){
        $student_attendance = AttendanceDetail::where('attendance_id','=',$attendance_id)->orderBy('id','desc')->get();
        return $student_attendance;
    }

    public function new_student_attendance(Request $request){
        // dd($request->all());
        $class = StudentClass::find($request->class_id);
        $validator = Validator::make($request->all(),[
            'student'=>'required',
        ]);
        if($validator->fails()){
            return response()->json(['status' => 'error', 'errors' => $validator->messages()]);
        }
        $errors = [];
        try{
            foreach($request->student as $rs){
                $attendance = Attendance::where('student_id',$rs['student_id'])->where('course_code',$class->course_code)->where('class_id','!=',0)->first();
                // return $attendance;
                if(isset($attendance)){
                    // dd($rs);
                    $existing_student = $rs;
                    array_push($errors,$existing_student);
                }
            }

            if(count($errors)>0){
                // dd('error');
                return response()->json(['status'=>'validation_error','errors'=>$errors]);
            }else{
                // dd('not error');
                foreach($request->student as $req){
                    $attendance = new Attendance;
                    $attendance->class_id = $request->class_id;
                    $attendance->student_id = $req['student_id'];
                    $attendance->funded_student_course_id = $req['funded_course_id'];
                    $attendance->course_code = $class->course_code;//la pa unod
                    $attendance->save();
                }

                return response()->json(['status'=>'success']);
            }
        }catch(Exception $e){
            return response()->json(['status'=>'error','errors'=>$e]);
        }
    }

    public function fetch_attendance($class_id){
        $attendance = Attendance::with('student.party','student.type')->where('class_id',$class_id)->orderBy('id','desc')->get();

        foreach($attendance as $a){
            $a->funded_course = FundedStudentCourse::where('student_id',$a->student_id)->where('course_code',$a->course_code)->first();
        }
        // $attendance->funded_course = FundedStudentCourse::where('student_id',$student_attendance[$i]->student_id)->where('course_code',$student_attendance[$i]->course_code)->first();
        // $attendance->student_funded_course = 
        // dd($attendance);
        $att = [];
        foreach($attendance as $at){
            if(isset($at->student)){//if data is existing in student table
                array_push($att,$at);
            }
        }
        // dd($att);
        return $att;
        // return $attendance;
    }

    public function student_attendance($attendance_id){
        $student_attendance = Attendance::where('id',$attendance_id)->with('student.party')->first();
        $course_code = $student_attendance->course_code;
        // dd($course_code);
        $student_id = $student_attendance->student_id;
        $student_completion = StudentCompletion::where('student_id',$student_id)->where('course_code',$course_code)->with(['details.unit'])->first();
        // dd($student_completion);
        $units = [];
    // dd($student_completion->details);
        if(isset($student_completion)){
            foreach($student_completion->details as $scd){
                // dd($scd);
                array_push($units,$scd['unit']);
            }
        }
        
        \JavaScript::put([
            'student_attendance'=>$student_attendance,
            'units'=>$units,
            'student_id'=>$student_attendance->student_id
        ]);
        return view('classes.student-attendance');
    }

    public function new_student_attendance_detail(Request $request){
        if($request->class_status=='Present'){
            $validator = Validator::make($request->all(),[
                'date_taken'=>'required',
                'status'=>'required',
            ]);
        }else{
            $validator = Validator::make($request->all(),[
                'date_taken'=>'required',
                'status'=>'required',
            ]);
        }
        
        if($validator->fails()){
            return response()->json(['status' => 'error', 'errors' => $validator->messages()]);
        }
        
        $ifExist = AttendanceDetail::where('date_taken',$request->date_taken)->where('attendance_id',$request->attendance_id)->first();
        // dd($ifExist);
        if(isset($ifExist)){
            return response()->json(['status'=>'update','id'=>$ifExist->id]);
        }

        $date_taken = Carbon::parse($request->date_taken)->timezone('Australia/Melbourne')->format('Y-m-d');
        
        try{
            $attendance_detail = new AttendanceDetail;
            $attendance_detail->attendance_id   = $request->attendance_id;
            $attendance_detail->unit_code       = isset($request->unit)?$request->unit['code']:'code'; 
            $attendance_detail->date_taken      = $date_taken;
            $attendance_detail->preferred_hours = isset($request->preferred_hours) ? $request->preferred_hours : 8;
            $attendance_detail->actual_hours    = isset($request->actual_hours) ? $request->actual_hours : 0;
            $attendance_detail->status          = $request->status;
            $attendance_detail->student_sig     = 1;
            $attendance_detail->trainer_sig     = 1;
            $attendance_detail->save();

            $att = Attendance::where('id',$request->attendance_id)->first();
            $ep = EnrolmentPack::with('funded_course.attendance.attendance_details')->where('student_id',$att->student_id)->first();

            return response()->json(['status' => 'success', 'enrolment_pack' => $ep]);

        }catch(Exception $e){
            return response()->json(['status' => 'error', 'errors' => $e]);
        }
    }

    public function update_student_attendance_detail(Request $request){
        // dd($request->all());
        // dd($request->all());
        if($request->class_status=='Present'){
            $validator = Validator::make($request->all(),[
                // 'unit_code'=>'required',
                'date_taken'=>'required',
                'time_start'=>'required',
                'time_end'=>'required',
                'status'=>'required',
            ]);
        }else{
            $validator = Validator::make($request->all(),[
                // 'unit_code'=>'required',
                'date_taken'=>'required',
                'status'=>'required',
            ]);
        }
        if($validator->fails()){
            return response()->json(['status' => 'error', 'errors' => $validator->messages()]);
        } 
        
        $date_taken = Carbon::parse($request->date_taken)->timezone('Australia/Melbourne')->format('Y-m-d');


        try{
            $attendance_detail = AttendanceDetail::find($request->id);
            $attendance_detail->attendance_id   = $request->attendance_id;
            $attendance_detail->unit_code       = isset($request->unit)?$request->unit['code']:'code';
            $attendance_detail->date_taken      = Carbon::parse($request->date_taken)->format('Y-m-d');
            $attendance_detail->preferred_hours = isset($request->preferred_hours) ? $request->preferred_hours : 8;
            $attendance_detail->actual_hours    = isset($request->actual_hours) ? $request->actual_hours : 0;
            $attendance_detail->status          = $request->status;
            $attendance_detail->student_sig     = 1;
            $attendance_detail->trainer_sig     = 1;
            $attendance_detail->save();
        }catch(Exception $e){
            return response()->json(['status' => 'error', 'errors' => $e]);
        }
    }

    public function update_class(Request $request,$id){
        $trainer = [];
        if(isset($request->trainer)){
            foreach($request->trainer as $tre){
                array_push($trainer,$tre['id']);
            }
            $trainer = implode(',',$trainer);
        }
        $validator = Validator::make($request->all(),[
            'desc'=>'required',
            'trainer'=>'required',
            'course'=>'required',
        ]);
        if($validator->fails()){
            return response()->json(['status' => 'error', 'errors' => $validator->messages()]);
        }
        $student = StudentClass::where('id',$id)->with(['attendance'])->get();
        
        $existing_course = $student[0]->course_code;
        $student_count = count($student[0]->attendance);
        
        if($request->course['code']!=$existing_course){
            if($student_count>0){
                return response()->json(['status' => 'error', 'errors' => ['course_code'=>['course cannot be altered']]]);
            }
        }

        if(isset($request->delivery_location['id'])){
            $dl = TrainingDeliveryLoc::where('id', $request->delivery_location['id'])->first()->state?TrainingDeliveryLoc::where('id', $request->delivery_location['id'])->first()->state->state_key:null;
        }else{
            $dl= $request->location;
        }
        // dd($dl);
        try{
            
            $class = StudentClass::find($id);
            $class->desc = $request->desc;
            $class->trainer_id = $trainer;
            $class->delivery_loc = $request->delivery_location?$request->delivery_location['id']:null;
            $class->delivery_mode = isset($request->delivery_mode)?$request->delivery_mode['value']:null;
            // $class->location = TrainingDeliveryLoc::where('id', $request->delivery_location['id'])->first()->state ? TrainingDeliveryLoc::where('id', $request->delivery_location['id'])->first()->state->state_key : null;
            $class->location = $dl;
            $class->venue = $request->venue;
            $class->course_code = $request->course['code'];
            $class->start_date = $request->start_date?Carbon::parse($request->start_date)->format('Y-m-d'):null;
            $class->end_date = $request->end_date?Carbon::parse($request->end_date)->format('Y-m-d'):null;
            // $class->class_start_time = $request->class_start_time;
            // $class->class_end_time = $request->class_end_time;
            $class->time_table_type = $request->time_table_type;
            $class->save();
        }catch(Exception $e){
            return response()->json(['status'=>'error','errors'=>$e]);
        }
    }

    public function get_student_attendance_detail_fields($id){
        $attendance_details = AttendanceDetail::with(['course_unit','attendance'])->find($id);
        // dd($attendance_details);
        return $attendance_details;
    }

    public function pdf($id){
        $attendance = Attendance::where('id',$id)->with(['attendance_details.course_unit','student.party','course','attendance_details'=>function($query){
            $query->where('status','!=','N/A')->orderBy('date_taken','asc');
        }])->first();
        $attendance->total_hours = 0;
        // dd($attendance);
        if(isset($attendance->attendance_details)){
            foreach($attendance->attendance_details as $ad){
                $attendance->total_hours += $ad->actual_hours;
            }
        }
        
        $app_settings = TrainingOrganisation::first();
        
        $pdf = PDF::loadView('classes.attendance-sheet.attendance-sheet-landscape',compact('attendance','app_settings'));
        return $pdf->setPaper('A4','landscape')->stream();
    }

    public function delete_class(Request $request){ 
        
        StudentClass::find($request->id)->delete();
        return "class removed";
    }
    
    public function delete_student(Request $request){ 
        // $att_details = AttendanceDetail::where('attendance_id',$request->id)->get();
        // if(isset($att_details)){
        //     foreach($att_details as $ad){
        //         $detail = AttendanceDetail::where('id',$ad->id)->first();
        //         // dd($detail->id);
        //         $detail->delete();
        //     }
        // }
        Attendance::find($request->id)->delete();
        // dd($att_details);
        return "attendance removed";
    }

    public function delete_attendance_detail(Request $request){ 
        
        AttendanceDetail::find($request->id)->delete();
        return "attendance detail removed";
    }
    //students
    //domestic 
    public function get_courses($id){
        $courses = FundedStudentCourse::with('student','course')->where('student_id',$id)->where('status_id',3)->get();
        
        return $courses[0];
    }

    public function get_classes($id){//student classes
        // dd('ha');
        $funded_courses = FundedStudentCourse::where('student_id',$id)->get();
        $attendance = [];
        // return $funded_courses;
        for($i = 0; $i < count($funded_courses); $i++){
            $attendance[$i] = Attendance::with(['student','student_class.delivery_location','course','attendance_details'=>function($query){
                $query->orderBy('id','desc');
            }])->where('student_id',$id)->where('course_code',$funded_courses[$i]->course_code)->where('class_id','!=',0)->first();
        }
        // return $attendance;
        // dd('a');
        foreach($attendance as $att){
            $att->total_hours = 0;
            if(isset($att->student_class)){
                $att->student_class->trainer_selected = $att->student_class->trainer_selected;
            }

            if(isset($att->attendance_details)){
                foreach($att->attendance_details as $ad){
                    $att->total_hours += $ad->actual_hours;
                }
            }
        }
        // $attendance->student_class->trainer_selected = $attendance->student_class->trainer_selected;
        // $student_completion = StudentCompletion::where('student_id',$id)->where('course_code',$attendance[0]->course_code)->with(['details.unit'])->get();
        // dd($attendance);
        
        return $attendance;
    }

    public function get_units($id,$course_code){
        // dd($id,$course_code);
        $student_completion = StudentCompletion::where('student_id',$id)->where('course_code',$course_code)->with(['details.unit'])->get();
        $units = [];
        if($student_completion->isEmpty()){
            $units = '';
        }else{
            foreach($student_completion[0]->details as $scd){
                array_push($units,$scd['unit']);
            }
        } 
        
        return $units;
    }

    //intl
    public function get_avail_classes($course_code){
        $avail_classes = StudentClass::where('course_code',$course_code)->get();
        // dd($avail_classes);
        return $avail_classes;
    }
    public function add_student_class(Request $request){
        // dd($request->all());
        try{
            $attendance = new Attendance;
            $attendance->class_id = $request->class_id['id'];
            $attendance->student_id = $request->student_id;
            $attendance->course_code = $request->course_code;
            $attendance->save();
        }catch(Exception $e){
            return response()->json(['status'=>'error','errors'=>$e]);
        }
        
    }
    public function get_intl_student_attendance($id,$course_code){
        // dd($id,$course_code);
        $attendance = Attendance::with('attendance_details','student_class')->where('student_id',$id)->where('course_code',$course_code)->orderBy('id','desc')->get();
        // dd($attendance);
        return $attendance;
        // dd($attendance);
    }
    public function get_package_units($offer_letter_id,$course_code){
        $offer_letter = OfferLetterCourseDetail::with('package.detail.course')->where('offer_letter_id',$offer_letter_id)->where('course_code',$course_code)->first();
        
        $units = CompletionStudentCourse::with('completion.details.unit')->where('student_course_id',$offer_letter->id)->where('student_type',1)->first();
        
        return $units->completion->details;
    }

    public function get_preferred($class_id,$day){
        $time_table = ClassTimeTable::where('class_id',$class_id)->first();
        if(isset($time_table)){
            // dd($time_table->training_days_weekly);
            if(isset($time_table->training_days_weekly)){
                $training_days = $time_table->training_days_weekly;
                foreach($training_days as $td){
                    if($td['day']==$day){
                        $hours = $td['hours'];
                    }
                }
                if(isset($hours)){
                    return response()->json(['status'=>'success','hours'=>$hours]);
                }
            }else{
                return response()->json(['status'=>'error','message'=>'Something went wrong.']);
            }
        }else{
            return response()->json(['status'=>'error','message'=>'Time Table not found']);
        }
        // dd($class_id,$day);
    }
}

