<?php

namespace App\Http\Controllers\Automation;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Reports\ReportsController;
use App\Http\Controllers\Send\EmailSendingController;
use App\Http\Controllers\Automation\AgentReminderController;
use App\Models\Attendance;
use App\Models\AttendanceDetail;
use App\Models\Automation;
use App\Models\AutomationAudit;
use App\Models\CompletionStudentCourse;
use App\Models\EmailTemplate;
use App\Models\EmailWarningTrail;
use App\Models\PreferredAttendance;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use \DB;
use PHPMailer\PHPMailer\PHPMailer;
use Validator;

class AutomationController extends Controller
{

    public function __construct()
    {
        $this->middleware('checkModule:automation');
        $this->middleware('auth');
    }
    //

    private $AutoDate;

    public function index()
    {

        // dd(Automation::where('type', 'enrolment-list')->first());
        $automation = Automation::all();

        \JavaScript::put([
            'enrolment_list' => $automation->where('type', 'enrolment-list')->first(),
            'email_warning' => $automation->where('type', 'email-warning-fees')->first(),
            'email_warning_attendance' => $automation->where('type', 'email-warning-attendance')->first(),
            'pd_plan'=>$automation->where('type','pd-plan')->first(),
            'agent_reminder'=>$automation->where('type','agent-reminder')->first(),
        ]);

        return view('automation.index');
    }

    public function store(Request $request)
    {

        if(in_array($request->emails, ['', null])){
            return ['status' => 'error', 'msg' => 'Email is required!'];
        }

        $emails = explode(',', preg_replace('/\s+/', '', $request->emails));
        
        foreach ($emails as $v){
            if(!filter_var($v, FILTER_VALIDATE_EMAIL)){
                return ['status' => 'error', 'msg' => 'Invalid email "'. $v . '"'];
            }
        }

        try {
            DB::beginTransaction();

            $data = Automation::updateOrCreate(
                [
                    'type' => $request->type,
                ],
                [
                    'type' => $request->type,
                    'config' => $request->config,
                    'emails' => $request->emails,
                    'occurrence_type' => $request->occurrence_type,
                    'month' => $request->month,
                    'day' => $request->day,
                    'time' => $request->time,
                ]
            );

            DB::commit();

            return ['status' => 'success'];

        } catch (\Throwable $th) {
            DB::rollback();
            return ['status' => 'error', 'msg' => $th];
            // throw $th;
        }
    }

    public function automate()
    {
        
        $this->AutoDate = Carbon::now()->setTimezone('Australia/Melbourne');
        // $time = $this->AutoDate;
        $now = $this->AutoDate->format('H:i');
        $past = Carbon::now()->setTimezone('Australia/Melbourne')->sub(10, 'minutes')->format('H:i');
        $future = Carbon::now()->setTimezone('Australia/Melbourne')->add(10, 'minutes')->format('H:i');
        // $time = '00:00';
        // dump(Automation::all());
        $auto = Automation::where('time', '>', $past)->where('time', '<', $future)->whereNotIn('type',['email-warning-fees'])->get();
        $agent_reminder = new AgentReminderController;
        // dump($auto);
        // dump($now);
        // dump($past);
        // dump($future);
        // test automation query
        // $auto = Automation::where('type', 'email-warning-attendance')->get();

        // dd($auto);
        // $getCount = $auto->count();
        // if($auto){
            // dump('here');
            // Daily
            foreach($auto as $schedule){
                // $schedule = $auto->where('occurrence_type', 'Daily');
                // dump($schedule);
                if($schedule->time <= $now){
                    if($schedule->occurrence_type == 'Daily'){
                        // foreach($schedule as $v){
    
                            // dd('pasok');
    
                            $autoAudit = AutomationAudit::where('type', 'enrolment-list')->where('date_triggered', 'like', Carbon::now()->format('Y-m-d ').'%')->first();
                            
                            if($autoAudit){
                                return false;
                            }
    
                            switch ($schedule->type) {
                                case 'enrolment-list':
                                    $this->enrolment_list($schedule);
                                    break;
                                case 'email-warning-attendance':
                                    // dd('in sd');
                                    $this->attendance_email_warning($schedule);
                                    break;
                                case 'agent-reminder':
                                    $agent_reminder = $agent_reminder->send_agent_reminder($schedule);
                                    break;
                            }
                        // }
                    }
                    
                    // Monthly
                    if($schedule->occurrence_type == 'Monthly'){
                        // foreach($schedule as $v){
    
                            $autoAudit = AutomationAudit::where('type', 'enrolment-list')->where('date_triggered', 'like', Carbon::now()->format('Y-'.$schedule->month).'%')->first();
    
                            if($autoAudit){
                                return false;
                            }
    
                            $day = $schedule->day > $this->AutoDate->format('t') ? $this->AutoDate->format('t') : $schedule->day;
                            if($day == $this->AutoDate->format('d')){
                                switch ($schedule->type) {
                                    case 'enrolment-list':
                                        $this->enrolment_list($schedule);
                                        break;
                                    case 'email-warning-attendance':
                                        $this->attendance_email_warning($schedule);
                                        break;
                                    case 'agent-reminder':
                                        $agent_reminder = $agent_reminder->send_agent_reminder($schedule);
                                        break;
                                }
                            }
                        // }
                    }
        
                    // Yearly
                    if($schedule->occurrence_type == 'Yearly'){
    
                        $autoAudit = AutomationAudit::where('type', 'enrolment-list')->where('date_triggered', 'like', Carbon::now()->format('Y').'%')->first();
    
                        if($autoAudit){
                            return false;
                        }
    
                        // foreach($schedule as $v){
                            if($schedule->month == $this->AutoDate->format('m')){
                                $day = $schedule->day > $this->AutoDate->format('t') ? $this->AutoDate->format('t') : $schedule->day;
                                if($day == $this->AutoDate->format('d')){
                                    switch ($schedule->type) {
                                        case 'enrolment-list':
                                            $this->enrolment_list($schedule);
                                            break;
                                        case 'email-warning-attendance':
                                            $this->attendance_email_warning($schedule);
                                            break;
                                        case 'agent-reminder':
                                            $agent_reminder = $agent_reminder->send_agent_reminder($schedule);
                                            break;
                                    }
                                }
                            }
                        // }
                    }
                }

            }
            
        // }

        // dd('end');

    }

    public function enrolment_list($v)
    {
        
        // dd('sulodens!');
    
        $from = Carbon::parse($this->AutoDate)->subMonths(2)->format('Y-m');
        $to = $this->AutoDate->format('Y-m');

        $rqst = [
            'student_type' => 2,
            'from' => $from,
            'to' => $to,
            'get_status' => '*',
            'get_course' => '*',
            'automate' => true,
        ];

        $newRequest = new Request();
        $newRequest->replace($rqst);

        $reports = new ReportsController;

        $lists = $reports->student_list($newRequest);
        // $newRequest->replace($rqst);
        $rqst['enrolments'] = $lists;
        $newRequest->replace($rqst);

        $reports->list_generator($newRequest);

        
        $from = Carbon::createFromFormat('Y-m', $newRequest->from)->format('M');
        $to = Carbon::createFromFormat('Y-m', $newRequest->to)->format('M');
        $title = 'Enrolment List '.$from.' - '.$to.' '.Carbon::now()->format('Y');
        $emails = explode(',', preg_replace('/\s+/', '', $v->emails));

        $paths = [];
        $paths[] = storage_path('app/excel/Enrolment List.xlsx');

        $this->send_automate($title , $title, $emails, $paths);

        $saveAutoAudit = new AutomationAudit;
        $saveAutoAudit->fill($v->toArray());
        $saveAutoAudit->date_triggered =  $this->AutoDate->format('Y-m-d');
        $saveAutoAudit->automation()->associate($v);
        $saveAutoAudit->save();
        
        // dd('done');
    
    }

    public function attendance_email_warning($sched = null)
    {
        
        $now = Carbon::now()->format('Y-m-d');
        // $class = StudentClass::where('start_date', '<=', $now)->where('end_date', '>=', $now)->get();
        $class = StudentClass::with('time_table','attendance.student.funded_course')->where('class_status', 'Ongoing')->get();
        // $students = [];

        // dump($class[0]->attendance);
        // dd($class);
        
        // loop class
        foreach ($class as $val) {
            // dd($val->toArray());
            $hours_per_day = $val->time_table->training_hours_daily;
            $hours_per_week = $val->time_table->training_hours_weekly;
            // dump($val->time_table->total_training_hours);
            $total_training_hours = $val->time_table->total_training_hours;
            $tth = 0;
            $attendance = [];
            // dump(strtoupper($val->desc));
            // dump('total_training_hours: '. $total_training_hours);
            if ($val->attendance) {
                // loop students form a class
                foreach ($val->attendance as $v) {
                    if(isset($v->student->party->name)){

                        dump($v->student->party->name);

                        $attendance[$v->student->student_id]['contact'] = $v->student->contact_detail; 
                        $attendance[$v->student->student_id]['student'] = $v->student->party->person; 
                        $attendance[$v->student->student_id]['course'] = $val->course_code; 

                        $attendance[$v->student->student_id]['attendance']['actual'] = 0;
                        $attendance[$v->student->student_id]['attendance']['prefer'] = 0;

                        // dump('- '.$v->student->party->name .' - '. $v->student->student_id);
                        // $student_type = $v->student->student_type_id;
                        // dd($attendance);

                        foreach ($v->attendance_details as $ad) {
                            // dd($ad->preferred_hours);
                            if($ad->status != 'N/A'){
                                if($ad->status == 'Present') {
                                    $attendance[$v->student->student_id]['attendance']['actual'] += $ad->actual_hours;
                                }
                                $attendance[$v->student->student_id]['attendance']['prefer'] += $ad->preferred_hours;
                            }
                        }

                        // dd($attendance[$v->student->student_id]['attendance']);

                        // dd('end');

                        /* if(isset($v->student->funded_course) && $v->student->funded_course) {
                            // loop student course
                            foreach ($v->student->funded_course as $vv) {
                                // dump($vv->course_code .' - '. $val->course_code);
                                if($vv->course_code == $val->course_code && in_array($vv->status_id, [2,3])){
                                    // dump('* Currently Studying');
                                    $completion = null;
                                    if($vv->offer_letter_course_detail_id != null){
                                        // dump('1');
                                        $completion = CompletionStudentCourse::with('completion.details')->where('student_course_id', $vv->offer_letter_course_detail_id)->first();
                                    }else{
                                        // dump('2');
                                        $completion = CompletionStudentCourse::with('completion.details')->where('student_course_id', $vv->id)->first();
                                    }
                                
                                    

                                    if(isset($completion->completion->details[0])){
                                        // record dates per student
                                        $dates = [];
                                        // dump('wew');
                                        // loop student completion details
                                        foreach ($completion->completion->details as $com_det) {
                                            // dump($com_det->course_unit_code .' : '. $com_det->training_hours);
                                            // if($v->student->student_id == 'PCA00033'){
                                            //     dump($com_det->unit);
                                            // }
                                            $tth = $tth + $com_det->training_hours;
                                            $attendance[$v->student->student_id]['attendance'][$com_det->course_unit_code]['actual'] = 0;
                                            $attendance[$v->student->student_id]['attendance'][$com_det->course_unit_code]['prefer'] = 0;
                                            $attendance[$v->student->student_id]['attendance'][$com_det->course_unit_code]['suggest'] = $com_det->training_hours != null ? $com_det->training_hours : $com_det->unit->scheduled_hours;
                                            $attendance[$v->student->student_id]['attendance'][$com_det->course_unit_code]['remaining'] = $com_det->training_hours != null ? $com_det->training_hours : $com_det->unit->scheduled_hours;
                                            $attendance[$v->student->student_id]['attendance'][$com_det->course_unit_code]['active'] = 0;
                                            // loop attendance detail of the student
                                            foreach ($v->attendance_details as $ad) {
                                                // dump($ad->status);
                                                
                                                if($ad->unit_code == $com_det->course_unit_code && $ad->status != 'N/A') { 
                                                    if(!in_array($ad->date_taken, $dates)) {
                                                        $dates[$ad->date_taken] = $hours_per_day;
                                                    }
                                                    // dump($dates);
                                                    // preferred time computation
                                                    $prefer_check = PreferredAttendance::where('class_id', $val->id)->where('unit_code', $ad->unit_code)->where('date_taken', $ad->date_taken)->first();
                                                    if($prefer_check) {
                                                        $pstart = Carbon::createFromFormat('H:i:s', $prefer_check->pref_time_start);
                                                        $pend = Carbon::createFromFormat('H:i:s', $prefer_check->pref_time_end);
                                                    }else{
                                                        $pstart = Carbon::createFromFormat('H:i:s', $val->class_start_time);
                                                        $pend = Carbon::createFromFormat('H:i:s', $val->class_end_time);
                                                    }
                                                    $p_hours = $pend->diffInMinutes($pstart);
                                                    $p_hours = round($p_hours / 60, 2) > 8 ? 8 : round($p_hours / 60, 2);
                                                    // dump($attendance[$v->student->student_id]['attendance']);
                                                    // if($p_hours < $attendance[$v->student->student_id]['attendance'][$ad->unit_code]['remaining']){
                                                    //     $attendance[$v->student->student_id]['attendance'][$ad->unit_code]['remaining'] = $attendance[$v->student->student_id]['attendance'][$ad->unit_code]['remaining'] - $dates[$ad->date_taken];
                                                    //     $dates[$ad->date_taken] = $dates[$ad->date_taken] - $p_hours;
                                                    //     $attendance[$v->student->student_id]['attendance'][$ad->unit_code]['prefer'] += $dates[$ad->date_taken];
                                                    // }else{
                                                    //     $hours_left = $p_hours - $attendance[$v->student->student_id]['attendance'][$ad->unit_code]['remaining'];
                                                    //     $dates[$ad->date_taken] = $hours_left;
                                                    //     $attendance[$v->student->student_id]['attendance'][$ad->unit_code]['prefer'] += $attendance[$v->student->student_id]['attendance'][$ad->unit_code]['remaining'];
                                                    //     $attendance[$v->student->student_id]['attendance'][$ad->unit_code]['remaining'] = 0;
                                                    // }
                                                    // dump($dates);
                                                    $attendance[$v->student->student_id]['attendance'][$ad->unit_code]['prefer'] += $p_hours;
                                                    $attendance[$v->student->student_id]['attendance'][$ad->unit_code]['prefer'] = $attendance[$v->student->student_id]['attendance'][$ad->unit_code]['prefer'] > $attendance[$v->student->student_id]['attendance'][$ad->unit_code]['suggest'] ? $attendance[$v->student->student_id]['attendance'][$ad->unit_code]['suggest'] : $attendance[$v->student->student_id]['attendance'][$ad->unit_code]['prefer'];
                                                    // dump('prefer - '. $attendance[$v->student->student_id]['attendance'][$ad->unit_code]['prefer']);

                                                    // actual time computation
                                                    if($ad->status == 'Present'){
                                                        // dump('qq');
                                                        $start = Carbon::createFromFormat('H:i:s', $ad->time_start);
                                                        $end = Carbon::createFromFormat('H:i:s', $ad->time_end);
                                                        $att_hours = $end->diffInMinutes($start);
                                                        $att_hours = round($att_hours / 60, 2) > 8 ? 8 : round($att_hours / 60, 2);
                                                        $attendance[$v->student->student_id]['attendance'][$ad->unit_code]['actual'] += $att_hours;
                                                        $attendance[$v->student->student_id]['attendance'][$ad->unit_code]['actual'] = $attendance[$v->student->student_id]['attendance'][$ad->unit_code]['actual'] > $attendance[$v->student->student_id]['attendance'][$ad->unit_code]['suggest'] ? $attendance[$v->student->student_id]['attendance'][$ad->unit_code]['suggest'] : $attendance[$v->student->student_id]['attendance'][$ad->unit_code]['actual'];
                                                        // dump('actual - '.$attendance[$v->student->student_id]['attendance'][$ad->unit_code]['actual']);
                                                    }
                                                    
                                                    // set unit to active
                                                    $attendance[$v->student->student_id]['attendance'][$com_det->course_unit_code]['active'] = 1;
                                                    
                                                    // dump($att_hours.' - hours_trained');
                                                }
                                            }

                                        }
                                    }
                                    // dump($attendance);
                                    // dump('Actual Attendance :'. $actual_attendance);
                                    // dump('TTH :'. $tth);
                                    // dd('ww');
                                    
                                }
                            }

                        } */
                    }
                }
                // dump('------------------------------');
                // dd($attendance);
                // dump($attendance['PCA00033']);
                // loop constructed student attendance
                foreach ($attendance as $key => $stud) {
                    $actual_att = $stud['attendance']['actual'];
                    $pref_att = $stud['attendance']['prefer'];
                    // foreach ($stud['attendance'] as $att) {
                    //     if($att['active'] == 1) {
                    //         $actual_att += $att['actual'];
                    //         $pref_att += $att['prefer'];
                    //     }
                    // }

                    // if($key == 'VRX00029') {
                        dump('STUDENT: ' . $key);
                        dump('ACTUAL: ' . $actual_att);
                        dump('PREFER: ' . $pref_att);

                        

                        // check allowed attendance
                        $attendance_checker = $pref_att * 0.8;

                        // dump($attendance_checker);

                        // dd('end');

                        if($actual_att < $attendance_checker) {
                            // dump('- SEND WARNING LETTER FOR ATTENDANCE');

                            // send warning letter for attendance
                            $template = EmailTemplate::where('email_type', 'email-warning-for-attendance')->first();

                            if($template) {
                                $check_email_warnings = EmailWarningTrail::where('email_template_type', $template->email_type)->where('student_id', $key)->where('course_code', $stud['course'])->first();
                                // dd($check_email_warnings);
                                if($check_email_warnings == null) {
                                    $content = $template->email_content;
                                    $content = str_replace('%studentID%', $key ,$content);
                                    $content = str_replace('%studentName%', $stud['student']->full_name ,$content);
                                    $content = str_replace('%studentAddress%', $stud['contact']->address ,$content);
                                    // dd($content);
                                    // dd($stud['contact']->address);
    
                                    $send = new EmailSendingController;
                                    $if_sent = $send->send_automate($template->name, $content, ['Phoenix College Admin'=>'admin@phoenixcollege.edu.au'], ['konstant.claro@gmail.com']);
    
                                    if(isset($if_sent['status']) && $if_sent['status'] == 'success') {
                                        $ew = new EmailWarningTrail;
                                        $ew->student_id = $key;
                                        $ew->email_template_id = $template->id;
                                        $ew->email_template_type = $template->email_type;
                                        $ew->date_sent = Carbon::now()->setTimezone('Australia/Brisbane')->format('Y-m-d');
                                        $ew->course_code = $stud['course'];
                                        $ew->user_id = 1;
                                        $ew->status_id = 1;
                                        $ew->save();
                                    }
                                }else {
                                    dump('ALREADY SENT');
                                }

                            }

                        }else {
                            dump('- SAFE FOR WARNING LETTER FOR ATTENDANCE');
                        }
                    // }
                    dump('------------------------------');
                }
            }
            dump('------------------------------------------------------------------------------');
        }
        

        // dd('end new');
        
        /* foreach ($class as $val) {
            // dump($val);
            if($val->time_table){
                $startDate = $val->start_date;
                $endDate = $val->end_date;
                $studentIDs = $val->attendance->pluck('id')->count() > 0 ? $val->attendance->pluck('id')->toArray()  : null;
                $class_id = $val->id;
                $hours_per_day = $val->time_table->training_hours_daily;
                $hours_per_week = $val->time_table->training_hours_weekly;

                $warningHours = $val->time_table->total_training_hours - ($val->time_table->total_training_hours * 0.8);
                // dd($studentIDs);
                // dump($endDate);
                // dump($now);
    
                while ($startDate <= $now) {
                    // dump('-----------------------------------------');
                    dump($startDate);
    
                    $att_det = AttendanceDetail::where('date_taken', $startDate)->whereIn('attendance_id', $studentIDs)->whereHas('attendance', function($q) use($class_id) {
                        $q->where('class_id', $class_id);
                    })->get();
    
                    dump($att_det);
    
                    
                    foreach ($att_det as $d){
                        // dump($d);
    
                        // getting absences per hour
                        if(!isset($students[$d->attendance_id])){
                            $students[$d->attendance_id] = 0;
                        }
                        if($d->time_start == null && $d->time_end == null){
                            // dump($d);
                            $students[$d->attendance_id] += $hours_per_day;
                            // dump($students[$d->attendance_id]);
                            // dump('yes');
                        }else{
                            // dump($val->time_table);
                            // dump('no');
                            $start = Carbon::createFromFormat('H:i:s', $d->time_start);
                            $end = Carbon::createFromFormat('H:i:s', $d->time_end);

                            $att_hours = $end->diffInMinutes($start);

                            $att_hours = round($att_hours / 60, 2) > 8 ? 8 : round($att_hours / 60, 2);

                            $hours_absent = $hours_per_day - $att_hours;

                            $students[$d->attendance_id] = $hours_absent > 0 ? $students[$d->attendance_id] + $hours_absent : $students[$d->attendance_id];
                            // dump($att_hours);
                        }
                            
    
                    }
    
                    // if(isset($val->attendance[0])){
                    //     foreach ($val->attendance as $v) {
                            
                    //         dump($v->attendance_details);
                    //     }
                    //     // dump($v->attendance_details);
                    // }
    
                    $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->add(1,'days')->format('Y-m-d');
                    dump('-----------------------------------------');
                }

            }


        }

        foreach($students as $k => $v) {
            if($v >= $warningHours){
                dump($k.' - SEND WARNING LETTER FOR ATTENDANCE');
            }else{
                dump($k.' - SAFE FOR WARNING LETTER FOR ATTENDANCE');
            }
        }

        dump($students);
        dd('end'); */
    }

    public function send_automate($subject, $content, $emails, $paths)
    {
        
        $mail = new PHPMailer(true);
        // $mail = new \Mailer;
        $mail->isSMTP();
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );                                                // Set mailer to use SMTP
        // $mail->Host = env('MAIL_HOST');                                 // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;
        // $mail->Username = env('MAIL_USERNAME');                           // SMTP username
        // $mail->Password = env('MAIL_PASSWORD');                                 // SMTP password    k
        $mail->Host = 'mail.vorx.com.au';
        $mail->Username = 'request@vorx.com.au';
        $mail->Password = '9}9jgR(~Y^Tp';
        // $mail->SMTPAutoTLS = true;
        $mail->SMTPSecure = 'tls';                                      // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                              // TCP port to connect to
        // $mail->SMTPDebug = 1;                                           // Enable SMTP authentication

        $mail->setFrom('request@vorx.com.au', 'VORX Automations');

        // $mail->addAddress($email_content['email']);
        // $mail->addAddress('contact@vorx.com.au');
        // $mail->addAddress($agent->email->email);

        foreach($emails as $v){
            $mail->addAddress($v);
        }

        foreach($paths as $v){
            $mail->addAttachment($v);
        }

        // $mail->addBcc('admin1@eti.edu.au');
        // $mail->addBcc('xyshain@gmail.com');
        // $mail->addBcc('Elitetrainingoffice@gmail.com');

        // $mail->addCc('admission@eti.edu.au');     // Add a recipient
        
        $cntnt = $this->email_template($content, $subject);
        // foreach ($request->all() as $k => $v) {
        //     if ($k != 'undefined') {
        //         $content .= $k . ' : ' . $v . '<br>';
        //     }
        // }
        
        

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $cntnt;
        // dd(\Auth::user()->id);
        if (!$mail->send()) {
            // return back()->withInput()->withErrors(['status' => 'error', 'message' => 'Email was not sent...']);
            // dump($mail->ErrorInfo);
            return json_encode(['status' => 'error', 'msg' => $mail->ErrorInfo]);
        } else {
            // dd('sent');
            // $mail->copyToFolder("Sent");

            return 1;
        }
    }

    public function email_template($content, $subject = '', $pdf = null, $date = null)
    {

        // $date = isset($data->created_at) ? Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->toFormattedDateString() : Carbon::now()->toFormattedDateString();
        if ($pdf) {
            $pdf = '100%';
        } else {
            $pdf = '800';
        }
        if ($date) {
            $date = Carbon::CreateFromFormat('Y-m-d H:i:s', $date)->format('d/m/Y');
        } else {
            $date = Carbon::now()->format('d/m/Y');
        }

        // Company Details
        $logo = 'images/logo/vorx_logo.png';
        $logo_url = url('/' . $logo . '');


        return '<!DOCTYPE html>
                <html lang="en">
                  <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title>Warning Letter</title>
                    <style type="text/css">
                      .text-right{text-align: right;}
                      .no-padding {padding: 0;}
                      .no-margin {margin: 0;}
                      ul.rto-code {padding: none;text-align: center;margin-top: 15px;font-size: 14px;font-weight: bold;}
                      ul.rto-code li{list-style: none;display: inline;padding: 0 10px; border-right: 1px solid #363636;}
                      ul.rto-code li:last-child{border:0;}
                    </style>
                  </head>
                  <body  style="font-family: "Malgun Gothic", Arial, sans-serif; margin: 0; padding: 0; width: 100%; -webkit-text-size-adjust: none; -webkit-font-smoothing: antialiased; position: relative;background-color: #EBF0EB;">
                <div class="main-wrapper" style="padding: 20px;">
                      <table class="table-responsive" align="center" width="' . $pdf . '" style="box-shadow: 0px 0px 3px #cccccc;font-size: 14px;color: #555555;background: #fff;">
                      <tbody class="">
                        <tr>
                          <td colspan="2"><div class="clearfix" style="height:50px;"></div></td>
                        </tr>
                      <tr>
                        <td width="50%" style="padding-left: 60px;">
                          <img src="' . $logo_url . '" style="margin: 0 auto;display: block; width: 180px;">
                        </td>
                      </tr>
                       <tr>
                        <td colspan="2" style="padding: 0 60px;">
                        <br>
                         <p style="font-weight: bold;">' . $date . '</p>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="padding: 0 60px;">
                          <h1 style="font-weight: bold;font-size: 16px;text-align: center;text-decoration: underline;">'.$subject.'</h1>
                          <br>
                         <p style="text-align:justify;">'.$content.'</p>
                            <div class="clearfix" style="height:50px;"></div>
                        </td> 
                      </tr>
                      <tr>
                        <td colspan="2" style="padding: 0 60px;">
                         <p style="text-align: center;font-size: 9px;">© VORX 2020 </p>
                         <div class="clearfix" style="height:10px;"></div>
                        </td>
                      </tr>
                      </tbody>
                    </table>
                </div>
                  </body>
                </html>';

        // return view('email-sending.templates.warning-letter', compact('content','date','title'));
    }

}
