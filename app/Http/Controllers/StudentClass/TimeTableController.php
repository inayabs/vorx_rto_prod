<?php

namespace App\Http\Controllers\StudentClass;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ClassTimeTable;
use App\Models\CourseProspectus;
use App\Models\FundedStudentCourse;
use App\Models\Holiday;
use App\Models\StudentClass;
use App\Models\StudentCompletion;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class TimeTableController extends Controller
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
        // dd($request->tt['total_training_hours']);
        //
        // dd(Carbon::parse($request->tt['duration_start_date'])->setTimezone('Australia/Melbourne')->format('Y-m-d'));
        if(isset($request->tt['time_table']) && count($request->tt['time_table']) > 0){
            try {
                $class = StudentClass::where('id', $request->class['id'])->first();
    
                DB::beginTransaction();
                
                if(isset($request->tt['id'])){
                    $tt = ClassTimeTable::where('id', $request->tt['id'])->first();
                    $tt->fill($request->tt);
                    // $tt->duration_month = $request->class['time_table_type'] == 'Straight' ? $request->tt['duration_month'] : null;
                    $tt->duration_start_date = Carbon::parse($request->tt['duration_start_date'])->setTimezone('Australia/Melbourne')->format('Y-m-d');
                    $tt->update();
                }else{
                    $tt = new ClassTimeTable;
                    $tt->fill($request->tt);
                    // $tt->duration_month = $request->class['time_table_type'] == 'Straight' ? $request->tt['duration_month'] : null;
                    $tt->duration_start_date = Carbon::parse($request->tt['duration_start_date'])->setTimezone('Australia/Melbourne')->format('Y-m-d');
                    $tt->class()->associate($class);
                    $tt->user()->associate(\Auth::user());
                    $tt->save();
                }

                // if($request->class['time_table_type'] == 'Rotating'){
                //     $tt->total_training_hours = $request->tt['total_training_hours'] / 2;
                //     $tt->total_weeks = $request->tt['total_weeks'] / 2;
                //     $tt->update();
                // }
    
                $start = $request->tt['time_table'][0];
                $end = $request->tt['time_table'][count($request->tt['time_table']) - 1];
                $class->start_date = Carbon::parse($start['dates']['start'])->setTimezone('Australia/Melbourne')->format('Y-m-d');
                $class->end_date = Carbon::parse($end['dates']['end'])->setTimezone('Australia/Melbourne')->format('Y-m-d');
                $class->update();
    
                DB::commit();
    
                // return to index on success
                return json_encode(['status' => 'success']);
    
            }catch (\Exception $e) {
                DB::rollBack();
                return json_encode(['status' => 'error', 'message' => $e]);
                throw $e;
            }

        }else{
            return json_encode(['status' => 'error', 'message' => 'Please setup time table.']);
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
        //

        $class = StudentClass::with(['delivery_location', 'course', 'time_table'])->where('id', $id)->first();
        $holidays = [];

        foreach(Holiday::all() as $k => $v){
            $x = 0;
            // dd($v);
            foreach(json_decode($v->location, true) as $kk => $vv){
                if($vv['id'] == $class->location){
                    $x = 1;
                }
            }
            if($x == 1){
                $holidays[] = $v;
            }
        }
        // dd($holidays);
        // dd(json_decode($holidays[0]->location, true));

        $time_table = [];
        $is_save = 0;
        // dd($class);

        if($class->time_table){
            // dd($class->time_table);
            $time_table = $class->time_table;
            // dd($time_table->time_table);
            $is_save = 1;
        }else{
            $prospectus = CourseProspectus::where('course_code', $class->course->code)->where('location', 'like', '%'.$class->location.'%')->first();
            // dump($prospectus->unit_selected);
            if($prospectus && in_array($class->location, explode(',',$prospectus->location))){
                // dd('in');
                $tt = [];
                foreach($prospectus->unit_selected as $k => $v){
                    $tt[] = [
                        'unit' => $v,
                        'training_hours' => $v->scheduled_hours, 
                    ];
                }
                if($class->time_table_type == 'Rotating'){
                    foreach($prospectus->unit_selected as $k => $v){
                        $tt[] = [
                            'unit' => $v,
                            'isRotate' => 1
                        ];
                    }
                }
                $time_table = [
                    'time_table' => $tt,
                    'total_training_hours' => 0,
                    'total_weeks' => 0,
                    // 'no_order' => 1,
                    // 'class_start_day' => 'Monday',
                    'duration_start_date' => $class->start_date,
                    // 'training_hours_daily' => 8,
                    'training_hours_weekly' => 20,
                    'training_days_weekly' => [
                        ['day'=>'Mon', 'value' => 'Monday', 'order' => 1, 'time_start' => null, 'time_end' => null, 'hours' => 0],
                        ['day'=>'Tue', 'value' => 'Teusday', 'order' => 2, 'time_start' => null, 'time_end' => null, 'hours' => 0],
                        // ['day'=>'Wed', 'value' => 'Wednesday', 'order' => 3, 'time_start' => null, 'time_end' => null, 'hours' => 0],
                        ['day'=>'Wed', 'value' => 'Wednesday', 'order' => 3, 'time_start' => '09:00', 'time_end' => '17:00', 'hours' => 8],
                        // ['day'=>'Thu', 'value' => 'Thursday', 'order' => 4, 'time_start' => null, 'time_end' => null, 'hours' => 0],
                        ['day'=>'Thu', 'value' => 'Thursday', 'order' => 4, 'time_start' => '09:00', 'time_end' => '17:00', 'hours' => 8],
                        // ['day'=>'Fri', 'value' => 'Friday', 'order' => 5, 'time_start' => null, 'time_end' => null, 'hours' => 0]
                        ['day'=>'Fri', 'value' => 'Friday', 'order' => 5, 'time_start' => '09:00', 'time_end' => '13:00', 'hours' => 4]
                    ]
                ];
            }
        }


        // dd($time_table);

        \JavaScript::put([
            // for course
            'class' => $class,
            'trainers' => $class->trainer_selected,
            'time_table' => $time_table,
            'is_save' => $is_save,
            'holidays' => $holidays,
            'days' => [
                ['day'=>'Mon', 'value' => 'Monday', 'order' => 1],
                ['day'=>'Tue', 'value' => 'Teusday', 'order' => 2],
                ['day'=>'Wed', 'value' => 'Wednesday', 'order' => 3],
                ['day'=>'Thu', 'value' => 'Thursday', 'order' => 4],
                ['day'=>'Fri', 'value' => 'Friday', 'order' => 5],
                ['day'=>'Sat', 'value' => 'Saturday', 'order' => 6],
                ['day'=>'Sun', 'value' => 'Sunday', 'order' => 7]
            ]
        ]);

        if($class->time_table_type == 'Straight'){
            return view('classes.time-table.straight');
        }else{
            return view('classes.time-table.rotating');
        }
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

    public function reset($id)
    {

        $tt = ClassTimeTable::where('class_id', $id)->first();
        $data = [];
        if($tt){
            $tt->delete();

            $class = StudentClass::with(['course', 'time_table'])->where('id', $id)->first();
            $time_table = [];

            $prospectus = CourseProspectus::where('course_code', $class->course->code)->where('location', 'like', '%'.$class->location.'%')->first();
            // dump($prospectus->unit_selected);
            
            if($prospectus && in_array($class->location, explode(',',$prospectus->location))){
                // dd('in');
                $tt = [];
                foreach($prospectus->unit_selected as $k => $v){
                    $tt[] = [
                        'unit' => $v,
                        'training_hours' => $v->scheduled_hours ? $v->scheduled_hours : 0,
                    ];
                }
                if($class->time_table_type == 'Rotating'){
                    foreach($prospectus->unit_selected as $k => $v){
                        $tt[] = [
                            'unit' => $v,
                            'isRotate' => 1
                        ];
                    }
                }
                $time_table = [
                    'time_table' => $tt,
                    'total_training_hours' => 0,
                    'total_weeks' => 0,
                    'reset' => 1,
                    'duration_start_date' => $class->start_date,
                    // 'no_order' => 1,
                    // 'class_start_day' => 'Monday',
                    'training_hours_daily' => 4,
                    'training_days_weekly' => [
                        ['day'=>'Mon', 'value' => 'Monday', 'order' => 1, 'time_start' => null, 'time_end' => null, 'hours' => 0],
                        ['day'=>'Tue', 'value' => 'Teusday', 'order' => 2, 'time_start' => null, 'time_end' => null, 'hours' => 0],
                        ['day'=>'Wed', 'value' => 'Wednesday', 'order' => 3, 'time_start' => null, 'time_end' => null, 'hours' => 0],
                        ['day'=>'Thu', 'value' => 'Thursday', 'order' => 4, 'time_start' => null, 'time_end' => null, 'hours' => 0],
                        ['day'=>'Fri', 'value' => 'Friday', 'order' => 5, 'time_start' => null, 'time_end' => null, 'hours' => 0]
                    ]
                ];
            }


        // dd($time_table);

        $data = [
            // for course
            'class' => $class,
            'time_table' => $time_table,
            'status' => 'success',
            'is_save' => 0,
            'days' => [
                ['day'=>'Mon', 'value' => 'Monday', 'order' => 1],
                ['day'=>'Tue', 'value' => 'Teusday', 'order' => 2],
                ['day'=>'Wed', 'value' => 'Wednesday', 'order' => 3],
                ['day'=>'Thu', 'value' => 'Thursday', 'order' => 4],
                ['day'=>'Fri', 'value' => 'Friday', 'order' => 5],
                ['day'=>'Sat', 'value' => 'Saturday', 'order' => 6],
                ['day'=>'Sun', 'value' => 'Sunday', 'order' => 7]
            ]
        ];

        return $data;
            
        }

        // dd($tt);

    }

    public function generate_time_table($start_date = '2020-10-23', $class_id = 4, $funded_course = null, $fetch_data = 1)
    {
        // dd($start_date);
        $end_date = null;
        
        $course = FundedStudentCourse::with(['course_completion.completion.details', 'detail','offer_detail.course_completion.completion.details','student'])->where('id', $funded_course)->first();
        // dd($course);
        $class = StudentClass::with(['delivery_location','time_table'])->where('id', $class_id)->first();
        // dd('we');
        // dd($class);
        if(!isset($class) || $class->time_table_type == 'Straight'){
            return 0;
        }
        
        // hours weekly
        $hw = $class->time_table->training_hours_weekly;
        // hours daily
        $hd = $class->time_table->training_hours_daily;

        // dd($class->delivery_location);
        
        // dd($course->offer_detail->course_completion->completion->details);
        $u = [];
        // if(isset($course->offer_detail->course_completion->completion->details[0])) {
        //     $units = $course->offer_detail->course_completion->completion->details;
        // }elseif(isset($course->course_completion->completion->details[0])) {
        //     $units = $course->course_completion->completion->details;
        // }else{
        //     $units = $class->time_table->time_table;
        // }
        $units = $class->time_table->time_table;
        // $units = isset($course->offer_detail->course_completion->completion->details) ? $course->offer_detail->course_completion->completion->details : $class->time_table->time_table;

        // dump('start date: '.$start_date);
        // dump('hours weekly: '.$hw);
        // dump('hours daily: '.$hd);

        // dd($course->course_completion);

        $training_hours_left = null;

        $start = $start_date;
        $end = null;
        $fetch_units = [];
        // $end = Carbon::createFromFormat('Y-m-d', $start)->addDays(7)->format('Y-m-d');

        foreach($units as $key => $value){
            // dd($v);
           
            $is_current = 1;
            // dump($training_hours_left);
            // dump($v->unit->scheduled_hours);

            // $training_hours_left = $training_hours_left - $v->unit->scheduled_hours;
            // dump($training_hours_left);

            if(isset($value['isRotate']) && $value['isRotate'] == 1) {
                $is_current = 0;
            }

            if($is_current == 1){
                // dd('test');
                // foreach
                if(isset($course->start_date)){
                    $search_com_details = isset($course->offer_detail->course_completion->completion->details[0]) ? $course->offer_detail->course_completion->completion->details : $course->course_completion->completion->details;
                    foreach($search_com_details as $k => $v){
                        if($v->unit->code == $value['unit']['code']){
                            $training_hours_left = $training_hours_left == null ? $hw : $training_hours_left;
                            // $scheduled_hours = isset($v->unit->scheduled_hours) ? $v->unit->scheduled_hours : $value['training_hours'];
                            $scheduled_hours = $value['training_hours'];
                            // $unit_hours_left = isset($v->unit->scheduled_hours) ? $v->unit->scheduled_hours : $value['training_hours'];
                            $unit_hours_left = $value['training_hours'];
                            $unit_training_hours_left = $training_hours_left;
                            // dump($unit_training_hours_left);
                            // dd($unit_hours_left);
                            $dayForWeekDuration = 0;
                            while($unit_hours_left > 0){
                                // dump('- '.$unit_hours_left);
                                $unit_hours_left = $unit_hours_left - $unit_training_hours_left;
                                // dump('UNIT HOURS LEFT -> '.$unit_hours_left);
                
                                $unit_training_hours_left = $unit_training_hours_left - abs($unit_hours_left);
                                // dump('UNIT TRAINING HOURS LEFT -> '. $unit_training_hours_left);
                
                                if($unit_training_hours_left < 1){
                                    $unit_training_hours_left = $hw;
                                }
                                $dayForWeekDuration = $dayForWeekDuration + 7;
                
                            }
                            // dump('DAYS FOR WEEK DURATION -> '. $dayForWeekDuration);
                            // dd('end');
                            
                            $end = Carbon::createFromFormat('Y-m-d', $start)->addDays($dayForWeekDuration - 1)->format('Y-m-d');
                            
                            // dump('-----------------------------------------');
                            // $unt = isset($v->unit->code) ? $v->unit->code : $value['unit']['code'];
                            // dump('UNIT : '. $v->unit->code);
                            // $schd_hr = isset($v->unit->scheduled_hours) ? $v->unit->scheduled_hours : $value['training_hours'];
                            // dump('SCHEDULED HOUR : '. $schd_hr);
                            // dump('START : '. $start);
                            // dump('END : '. $end);
                            
                            $end_date = $end;
                
                            if(isset($course->start_date)){
                                // update unit's start and end date in student completion details
                                $v->start_date = $start;
                                $v->end_date = $end;
                                $v->training_hours = $value['training_hours'];
                                $v->trainer_id = isset($value['trainer']['id']) ? $value['trainer']['id'] : null;
                                $v->order = $key + 1;
                                if($fetch_data == 0){
                                    $v->update();
                                }
                                $fetch_units[] = $v->toArray();
                                // dump(' -> UPDATE UNIT');
                            }else{
                                $u = [
                                    'course_unit_code' => $value['unit']['code'],
                                    'start_date' => $start,
                                    'end_date' => $end,
                                    'trainer_id' => isset($value['trainer']['id']) ? $value['trainer']['id'] : null,
                                    'training_hours' => $value['training_hours'],
                                    'train_org_loc_id' => $class->delivery_location->train_org_dlvr_loc_id,
                                ];
                                // if($fetch_data == 0){
                                    
                                    // create student completion
                                    // $completion = StudentCompletion::updateOrCreate([
                                    //     'student_id' => $,
                                    //     'course_code' => ,
                                    // ],
                                    // [
                
                                    // ]);
                                    // $fetch_units[] = $v->;
                                    // create student completion details 
                                    // dump(' -> CREATE UNIT');
                                // }
                                $fetch_units[] = $u;
                            }
            
                            $training_hours_left = $training_hours_left - $scheduled_hours;
            
                            // dump('WEEKLY HOURS LEFT : '. $training_hours_left);
                            // dump('-----------------------------------------');
                            
                
                            
                            
                            if($training_hours_left < 1) {
                                $next_start_day = 0;
                                while($training_hours_left < 1){
                                    $next_start_day += 7;
                                    $training_hours_left = $hw + $training_hours_left;
                                }
                                
                                $start = Carbon::createFromFormat('Y-m-d', $start)->addDays($next_start_day)->format('Y-m-d');
                               
                                
                            }
                            
                        }
                    }
                }else {
                    // dd();
                    $days_of_course = $class->time_table->total_weeks * 7;
                    $end_date = Carbon::createFromFormat('Y-m-d', $start_date)->addDays($days_of_course - 1)->format('Y-m-d');
                }

            }

            // if($key == 3){
            //     break;
            // }
            
        }


        // dump('-----------------------------------------');
        // dump('COURSE START DATE : '. $start_date);
        // dump('COURSE END DATE : '. $end_date);

        if($fetch_data == 1){
            return ['course_start_date' => $start_date, 'course_end_date' => $end_date, 'units' => $fetch_units];
        }else{
            $course->start_date = $start_date;
            $course->end_date = $end_date;
            $course->update();

            if(isset($course->offer_detail->course_start_date)){
                $course->offer_detail->course_start_date = $start_date;
                $course->offer_detail->course_end_date = $end_date;
                $course->offer_detail->update();
            }
            // course_completion.completion.details
            // if(isset($course->course_completion->completion->))
        }
        
        // dd('END');

    }

    public function fetch_course_dates($start_date, $class_id, $course_id)
    {
        // dump($start_date);
        // dump($class_id);
        // dd($course_id);
        $course_id = $course_id == 0 ? null : $course_id;
        return $this->generate_time_table($start_date, $class_id = 4, $course_id, 1);
    }

    public function test()
    {
        $time_table = [
            'time_table' => 'test',
            'total_training_hours' => 0,
            'total_weeks' => 0,
            // 'no_order' => 1,
            // 'class_start_day' => 'Monday',
            'duration_start_date' => null,
            // 'training_hours_daily' => 8,
            'training_hours_weekly' => 20,
            'training_days_weekly' => [
                ['day'=>'Mon', 'value' => 'Monday', 'order' => 1, 'time_start' => null, 'time_end' => null, 'hours' => 0],
                ['day'=>'Tue', 'value' => 'Teusday', 'order' => 2, 'time_start' => null, 'time_end' => null, 'hours' => 0],
                // ['day'=>'Wed', 'value' => 'Wednesday', 'order' => 3, 'time_start' => null, 'time_end' => null, 'hours' => 0],
                ['day'=>'Wed', 'value' => 'Wednesday', 'order' => 3, 'time_start' => '09:00', 'time_end' => '17:00', 'hours' => 8],
                // ['day'=>'Thu', 'value' => 'Thursday', 'order' => 4, 'time_start' => null, 'time_end' => null, 'hours' => 0],
                ['day'=>'Thu', 'value' => 'Thursday', 'order' => 4, 'time_start' => '09:00', 'time_end' => '17:00', 'hours' => 8],
                // ['day'=>'Fri', 'value' => 'Friday', 'order' => 5, 'time_start' => null, 'time_end' => null, 'hours' => 0]
                ['day'=>'Fri', 'value' => 'Friday', 'order' => 5, 'time_start' => '09:00', 'time_end' => '13:00', 'hours' => 4]
            ]
        ];


        // parameters
        $trainHrs = 40;
        $hrsPerWeek = 20;
        $dw = $time_table['training_days_weekly'];
        $dayStart = 'Mon';

        $days = 0;
        $weeks = 0;
        $isoWeek = [
            'Mon',
            'Tue',
            'Wed',
            'Thu',
            'Fri',
            'Sat',
            'Sun',
        ];

        while($trainHrs > 0) {
            $weeks++;
            // $trainHrs = $trainHrs - $hrsPerWeek;
            $daysOfWeekCounter = 0;
            
            //get days of week counter 
            while($daysOfWeekCounter < 7){

                if($trainHrs < 1) {
                    break;
                }

                foreach ($isoWeek as $iso) {
                    # code...

                    if($daysOfWeekCounter == 7 || $trainHrs < 1) {
                        break;
                    }

                    if($daysOfWeekCounter != 0) {
                        $days++;
                        $daysOfWeekCounter++;
                        dump('count '.$iso.' - '. $daysOfWeekCounter);
                    }

                    if($iso == $dayStart && $daysOfWeekCounter == 0) {
                        $days++;
                        $daysOfWeekCounter++;
                        dump('first count '.$iso.' - '. $daysOfWeekCounter);
                    }

                    if($daysOfWeekCounter != 0) {
                        foreach($dw as $k => $v) {
                            if($v['day'] == $iso && !in_array($v['hours'], [0,null])) {
                                $trainHrs = $trainHrs - $v['hours'];
                            }
                        }
                    }
                    // dump('traini g hours left - '. $trainHrs);
                    
                }
                
                // $weeks++;

                // dump('daysOfWeekCounter - '. $daysOfWeekCounter);
            }

            dump('DAYS COUNT - '. $days);
            // dump('days - '. $days);
            // dump('weeks - '. $weeks);
            // dd($trainHrs);
            // insert dw
            

            // dd($trainHrs);
        }

        dump('days - '. $days);
        dump('weeks - '. $weeks);
        dump('training hours of that day left - '. abs($trainHrs));
        dd('end');
    }
}
