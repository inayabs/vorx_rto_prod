<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\FundedStudentPaymentDetails;
use App\Models\Student\Student;
use App\Models\CompletionStudentCourse;
use App\Models\Unit;
use App\Models\Deal;
use App\Models\User;
use App\Models\Agent;
use App\Models\Audit;
use App\Models\EnrolmentPack;
use App\Models\FundedStudentCourse;
use App\Models\Notification;
use App\Models\Party;
use App\Models\Attendance;
use App\Models\AvtCountryIdentifier;
use App\Models\AvtOrgType;
use App\Models\AvtPostcode;
use App\Models\StudentClass;
use App\Models\TrainingDeliveryLoc;
use App\Models\TrainingOrganisation;
use Hamcrest\Arrays\IsArray;
use Spatie\Permission\Models\Role;

// use Spatie\Permission\Contracts\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $tdl = TrainingDeliveryLoc::all();

        // if(!$tdl) {
        //     return $this->rto_config();
        // }
        \JavaScript::put([
            'role'=>Auth::user()->roles->first()->name
        ]);
        switch (\Auth::user()->roles[0]->name) {
            case 'Student':
                return $this->student_dashboard();
                break;
            case 'Trainer':
                return $this->trainer_dashboard();
                break;
            default:
                return $this->admin_dashboard();
                break;
        }
    }

    public function trainer_dashboard()
    {
        $AllClasses = StudentClass::with(['time_table', 'attendance.student.party.user'])->get();
        $trainerClass = [];
        $trainer = \Auth::user()->trainer;
        $class_statuses = [
            'not_yet_taken' => 0,
            'ongoing' => 0,
            'finish' => 0,
        ];
        $ongoingStudent = [];

        // dd($AllClasses);

        foreach ($AllClasses as $v) {
            $x = explode(',', $v->trainer_id);
            if (in_array($trainer->id, $x)) {
                $trainerClass[] = $v;

                switch ($v->class_status) {
                    case 'Ongoing':
                        $class_statuses['ongoing']++;
                        break;
                    case 'Not yet taken':
                        $class_statuses['not_yet_taken']++;
                        break;
                    case 'Finish':
                        $class_statuses['finish']++;
                        break;
                    default:
                        # code...
                        break;
                }

                if ($v->class_status == 'Ongoing') {
                    $ongoingStudent[] = [
                        'class' => $v->desc . ' - ' . $v->course_code,
                        'students' => isset($v->attendance[0]) ? $v->attendance : [],
                    ];
                }
            }
        }

        // dd($ongoingStudent);
        // dd($trainerClass[0]);
        return view('trainer-portal.dashboard', compact('class_statuses', 'trainerClass', 'ongoingStudent'));
    }

    public function student_dashboard()
    {
        if (\Auth::user()->hasRole('Demo')) {
            $course_tp_code = Course::where('user_id', \Auth::user()->id)->groupBy('tp_code')->get()->pluck('tp_code');

            $dashboard  = [
                'students' => Student::where('user_id', \Auth::user()->id)->count(),
                'payments' => FundedStudentPaymentDetails::where('user_id', \Auth::user()->id)->sum('amount'),
                'programs' => Course::where('user_id', \Auth::user()->id)->count(),
                'units' => $course_tp_code->count() >  0 ? Unit::whereIn('tp_code', $course_tp_code->toArray())->count() : 0,
                // 'units' => 0,
            ];
        } else {
            // $course_tp_code = Course::groupBy('tp_code')->get()->pluck('tp_code');
            $user = \Auth::user();
            $student = $user->party->student;

            $studentDetails = [
                'student_id' => $student->student_id,
                'firstname' => $user->party->person->firstname,
                'lastname' => $user->party->person->lastname,
                'fullname' => $user->party->person->fullName
            ];
            $course = $student->funded_course()->with('course', 'course_details', 'payment_details', 'course_completion.completion')->whereIn('status_id', ['2', '3'])->latest()->first();
            // dd($course);
            $payments = 0;
            $student_attendance = null;
            $units_completed = [];
            $units = [];
            $att_detail = [];
            if ($course != null) {
                if ($student->student_type_id == 1) {
                    // dd($course->offer_detail->offer_letter->id);
                    $payments = $course->offer_detail->payment_template->sum('payable_amount') - $course->offer_detail->payments->sum('amount');
                    $cs = CompletionStudentCourse::where('student_course_id', $course->offer_letter_course_detail_id)->where('student_type', 1)->first();
                    $course_completion = $cs;
                } else {
                    // dd($course->offer_letter_course_detail_id);
                    if ($course->offer_letter_course_detail_id == null) {
                        $course_completion = $course->course_completion()->with('completion')->where('student_type', $student->student_type_id)->first();
                    } else {
                        $cs = CompletionStudentCourse::where('student_course_id', $course->offer_letter_course_detail_id)->where('student_type', $student->student_type_id)->first();
                        // dd($cs);
                        // dd($cs);
                        // dd($cs);
                        $course_completion = $cs;
                    }

                    if ($course->payment_details != null) {
                        $payments =  (int) $course->course_fee - $course->payment_details->sum('amount');
                    } else {
                        $payments = $course->course_fee;
                    }
                }

                $completion = $course_completion->completion;

                $units_completed = $completion->details()->whereIn('completion_status_id', [3, 4, 6])->orderBy('order')->get();
                $units_taken = $completion->details()->orderBy('order')->get();
                $courseDetails = [
                    'course' => $course->course->name,
                    'code'   => $course->course->code,
                    'fee'    => $payments,
                    'units_completed' => $units_completed->count(),
                    'units_taken' => $units_taken->count()
                ];

                $attendance = Attendance::where('student_id', $studentDetails['student_id'])->where('course_code', $courseDetails['code'])->first();
                // dd($attendance);
                if ($attendance != null) {
                    $studentDetails['attendance_id'] = $attendance->id;
                    $diffDatesStart = Carbon::parse($attendance->student_class->start_date);
                    $diffDatesEnd = Carbon::parse($attendance->student_class->end_date);
                    $spandays = $diffDatesEnd->diffInDays($diffDatesStart);
                    $student_attendance = $attendance->attendance_details()->where('status', 'Present')->whereBetween('date_taken', [$attendance->student_class->start_date, $attendance->student_class->end_date])->get();
                    $att_detail = $attendance->attendance_details()->orderBy('date_taken', 'desc')->get();
                    // dump($student_attendance);
                    // dump($completion->details);
                    $_units = $completion->details;
                    foreach ($_units  as $key => $unit) {
                        $hours = 0;
                        $percentage = 0;
                        $color = 'bg-danger';
                        foreach ($student_attendance as $sattendance) {
                            if ($sattendance->unit_code == $unit->course_unit_code) {
                                // dd($sattendance);
                                $hours += $sattendance->actual_hours;
                                // dump($hours);
                                // dump($sattendance->course_unit->scheduled_hours);
                                // dump($unit->training_hours);
                                if (in_array($unit->training_hours, [0, null, '']) && $sattendance->course_unit->scheduled_hours != 0) {
                                    // dump('1a');
                                    $percentage = ($hours / $sattendance->course_unit->scheduled_hours) * 100;
                                } elseif (!in_array($unit->training_hours, [0, null, '']) && $sattendance->course_unit->scheduled_hours == 0) {
                                    // dump('2a');
                                    $percentage = ($hours / $unit->training_hours) * 100;
                                }else{
                                    $percentage = ($hours / $unit->training_hours) * 100;
                                }
                                // dd($percentage);
                                if ($percentage > 90) {
                                    $color = 'bg-success';
                                } elseif ($percentage <= 90 && $percentage > 80) {
                                    $color = '';
                                } elseif ($percentage <= 80 && $percentage > 60) {
                                    $color = 'bg-info';
                                } elseif ($percentage <= 60 && $percentage > 30) {
                                    $color = 'bg-warning';
                                } elseif ($percentage <= 30 && $percentage > 20) {
                                    $color = 'bg-danger';
                                } else {
                                    $color = 'bg-danger';
                                }
                                $units[$key] = [
                                    'code' => $sattendance->unit_code,
                                    'name' => $sattendance->course_unit->description,
                                    'hours' => number_format($hours, 1),
                                    'total_hours' => $sattendance->course_unit->nominal_hours,
                                    'percentage' => $percentage,
                                    'color'      => $color,
                                ];
                            } else {
                                $units[$key] = [
                                    'code' => $unit->course_unit_code,
                                    'name' => $unit->unit->description,
                                    'hours' => number_format($hours, 1),
                                    'total_hours' => $unit->unit->nominal_hours,
                                    'percentage' => $percentage,
                                    'color'      => $color,
                                ];
                            }
                        }

                        if ($student_attendance->isEmpty()) {
                            $units[$key] = [
                                'code' => $unit->course_unit_code,
                                'name' => $unit->unit->description,
                                'hours' => number_format($hours, 1),
                                'total_hours' => $unit->unit->nominal_hours,
                                'percentage' => $percentage,
                                'color'      => $color,
                            ];
                        }
                    }
                } else {
                    $_units = $completion->details;
                    foreach ($_units  as $key => $unit) {
                        $hours = 0;
                        $percentage = 0;
                        $color = 'bg-danger';
                        $units[$key] = [
                            'code' => $unit->course_unit_code,
                            'name' => $unit->unit->description,
                            'hours' => number_format($hours, 1),
                            'total_hours' => $unit->unit->nominal_hours,
                            'percentage' => $percentage,
                            'color'      => $color,
                        ];
                    }
                }
            } else {
                if (count($units_completed) == 0) {
                    $units_completed = 0;
                } else {
                    $units_completed = $units_completed->count();
                }
                $courseDetails = [
                    'course' => '',
                    'code'   => '',
                    'fee'    => $payments,
                    'units_completed' => $units_completed,
                    'units_taken' => $units_completed
                ];
            }

            $e_pack = EnrolmentPack::where('student_id', $student->student_id)->first();
            // dd($e_pack);
            if($e_pack != null){
                $process_id = $e_pack->process_id;

            }else{
                $process_id = null;
            }

            if ($course != null) {
                if ($course->offer_detail != null) {
                    $offer_letter_id = $course->offer_detail->offer_letter->id;
                } else {
                    $offer_letter_id = null;
                }
            } else {
                $offer_letter_id = null;
            }
            
            $dashboard  = [
                'student'       => $studentDetails,
                'courseDetail'  => $courseDetails,
                'payments'      => FundedStudentPaymentDetails::sum('amount'),
                'programs'      => Course::count(),
                'attendance'    => $student_attendance != null ? $student_attendance->count() : 0,
                // 'units' => $course_tp_code->count() >  0 ? Unit::whereIn('tp_code', $course_tp_code->toArray())->count() : 0,
                'units' => $units,
                'attendance_detail' => $att_detail,
                // 'units' => 0,
                'process_id'    => $process_id,
                'offer_letter_id' => $offer_letter_id,
            ];
        }

        $activities = $this->activities_details();
        \JavaScript::put([
            'chartData'  => $this->getChart()
        ]);
        return view('student_portal.dashboard', compact('dashboard', 'activities', 'e_pack'));
    }

    public function admin_dashboard()
    {
        // $payments = FundedStudentPaymentDetails::all();
        // $roles = Role::all();
        // dd($roles);
        // dd(\Auth::user()->roles[0]->name);
        if (\Auth::user()->hasRole('Demo')) {
            $course_tp_code = Course::where('user_id', \Auth::user()->id)->groupBy('tp_code')->get()->pluck('tp_code');

            $dashboard  = [
                'students' => Student::where('user_id', \Auth::user()->id)->count(),
                'payments' => FundedStudentPaymentDetails::where('user_id', \Auth::user()->id)->sum('amount'),
                'programs' => Course::where('user_id', \Auth::user()->id)->count(),
                'units' => $course_tp_code->count() >  0 ? Unit::whereIn('tp_code', $course_tp_code->toArray())->count() : 0,
                'usi' => null,
            ];
        } else {
            // $course_tp_code = Course::groupBy('tp_code')->get()->pluck('tp_code');
            $usi = FundedStudentCourse::with('student.funded_detail')->whereYear('start_date', '2020')->whereIn('status_id', ['2', '3', '4'])->groupBy('student_id')->get();
            $arr = [];
            foreach ($usi as $u) {
                if ($u->student->funded_detail->unique_student_id == null || $u->student->funded_detail->verified == 0) {
                    $arr[] = $u;
                }
            }
            $dashboard  = [
                'students' => Student::count(),
                'payments' => FundedStudentPaymentDetails::sum('amount'),
                'programs' => Course::count(),
                // 'units' => $course_tp_code->count() >  0 ? Unit::whereIn('tp_code', $course_tp_code->toArray())->count() : 0,
                'units' => Unit::all()->count(),
                'usi' => $arr,
            ];
        }
        $org = TrainingOrganisation::first();
        $activities = $this->activities_details();

        \JavaScript::put([
            'chartData'  => $this->getChart()
        ]);
        return view('dashboard', compact('dashboard', 'activities','org'));
    }

    public function getChart()
    {
        $datas = FundedStudentPaymentDetails::select(DB::raw("MONTH(payment_date) as month"), DB::raw("DATE_FORMAT(payment_date,'%b') as abr"), DB::raw("SUM(amount) as amount"))
            ->whereBetween('payment_date', [Carbon::now()->subMonth(3)->format('Y-m-d'), Carbon::now()->format('Y-m-d')])
            ->where('user_id', \Auth::user()->id)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
        return $datas;
        // exit();


    }

    public function dynamic_form()
    {
        return view('dynamic-form');
    }

    public function get_user_nav()
    {
        $data = [
            'role' => \Auth::user()->roles[0]->name,
            'user' => \Auth::user(),
        ];

        return $data;
    }

    public function activities_details()
    {

        $logout = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/user/logout";

        $audits = Audit::with('user.party.person')->select(DB::raw('event, user_id, auditable_id, auditable_type, url, MINUTE(created_at) AS created_min, created_at'))->where('url', '!=', $logout)->groupBy('event', 'url', 'user_id', 'created_min')->where('user_id', \Auth::user()->id)->orderBy('id', 'desc')->limit(10)->get();

        $activity = [];
        foreach ($audits as $k => $v) {
            $url = explode('/', $v->url);
            // if($url[3] == 'agent'){
            //     dd($v->user_id);
            //     $agent = Agent::with('party.person')->where('id', $v->user_id)->first();
            //     array_push($activity, ['name' => $agent->party->name . " (Agent)",
            //     'firstname' => $agent->party->person->firstname,
            //     'lastname' => $agent->party->person->lastname,
            //     'avatar' => '/storage/user/avatars/default-profile.png',
            //     'url' => $v->url,
            //     'created_at' => Carbon::parse($v->created_at)->format('Y-m-d H:m:s'),
            //     'created_min' =>  Carbon::parse($v->created_at)->diffForHumans(),
            //     'event' => $v->event,
            //     'dname' => '']);
            // }else{
            $dname = '';
            // if($url[3] == 'deals'){
            //   $party = Party::where('id', $v->auditable_id)->withTrashed()->first();
            //   $dname = isset($party) ? $party->name : '';
            // }
            if (isset($v->user->party->person) && $v->user->id != 1) {
                array_push($activity, [
                    'name' => isset($v->user->party->name) ? $v->user->party->name : '',
                    'firstname' => $v->user->party->person->firstname,
                    'lastname' => $v->user->party->person->lastname,
                    'avatar' => '/storage/user/avatars/' . $v->user->profile_image,
                    'url' => $v->url,
                    'created_at' => Carbon::parse($v->created_at)->format('Y-m-d H:m:s'),
                    'created_min' =>  Carbon::parse($v->created_at)->diffForHumans(),
                    'event' => $v->event,
                    'dname' => $dname
                ]);
            }
            // }

        }
        // dd($activity);
        return $activity;
    }
    public function student_status_alert()
    {
        // $stud = FundedStudentCourse::where('end_date', '<', date('Y-m-d'))->whereNotIn('status_id', [4,5,7,9])->get();
        $stud = Student::with(['party', 'funded_course', 'offer_letter.offer_course'])->whereHas('funded_course', function ($q) {
            $q->where('end_date', '<', date('Y-m-d'));
            $q->whereNotIn('status_id', [4, 5, 7, 9]);
            $q->where('end_date', '>', date('Y-01-01'));
        })->orWhereHas('offer_letter.offer_course', function ($q) {
            $q->where('course_end_date', '<', date('Y-m-d'));
            $q->whereNotIn('status_id', [4, 5, 7, 9]);
            $q->where('course_end_date', '>', date('Y-01-01'));
        })->get();

        // dump($stud);

        $students = [];
        foreach ($stud as $s) {
            foreach ($s->funded_course as $fc) {
                if ($fc->end_date < date('Y-m-d') && !in_array($fc->status_id, [4, 5, 7, 9])) {
                    $students[] = [
                        // 'student' => $s->student_id.' - '.$s->party->name,
                        // 'name' => $s->party->name,
                        // 'student_id' => $s->student_id,
                        // 'course_code' => $fc->course_code,
                        // 'message' => '<b></b>needs to change status.',
                        // 'date' => Carbon::createFromFormat('Y-m-d', $fc->end_date)->format('F d, Y'),
                        // 'student_type' => 2,
                        // 'student_table_id' => $s->id
                        'fa_class' => 'fas fa-school text-white',
                        'sort_date' => Carbon::createFromFormat('Y-m-d', $fc->end_date)->format('Y-m-d'),
                        'date' =>  Carbon::createFromFormat('Y-m-d', $fc->end_date)->format('F d, Y'),
                        'message' => '<span class="font-weight-bold">' . $s->party->name . '</span> needs to change status.',
                        'link' => '/student/domestic/' . $s->id

                    ];
                }
            }
            foreach ($s->offer_letter as $ol) {
                foreach ($ol as $olcd) {
                    if ($olcd->end_date < date('Y-m-d') && !in_array($olcd->status_id, [4, 5, 7, 9])) {
                        $students[] = [
                            // 'student' => $s->student_id.' - '.$s->party->name,
                            // 'name' => $s->party->name,
                            // 'student_id' => $s->student_id,
                            // 'course_code' => $olcd->course_code,
                            // 'date' => Carbon::createFromFormat('Y-m-d', $olcd->course_end_date)->format('F d, Y'),
                            // 'student_type' => 1,
                            // 'student_table_id' => $s->id
                            'fa_class' => 'fas fa-plane text-white',
                            'sort_date' => Carbon::createFromFormat('Y-m-d H:i:s', $olcd->course_end_date)->format('Y-m-d'),
                            'date' =>  Carbon::createFromFormat('Y-m-d H:i:s', $olcd->course_end_date)->format('F d, Y'),
                            'message' => '<span class="font-weight-bold">' . $s->party->name . '</span> needs to change status.',
                            'link' => '/student/' . $s->id
                        ];
                    }
                }
            }
        }

        // enrolment pack
        $ep = EnrolmentPack::where('status', 'complete')->get();

        foreach ($ep as $k => $v) {
            $students[] = [
                'fa_class' => 'fas fa-scroll text-white',
                'sort_date' => Carbon::createFromFormat('Y-m-d H:i:s', $v->updated_at)->format('Y-m-d'),
                'date' =>  Carbon::createFromFormat('Y-m-d H:i:s', $v->updated_at)->format('F d, Y'),
                'message' => 'New Enrolment Application to be Verified<span class="font-weight-bold">(' . $v->student_name . ')</span>',
                'link' => '/enrolment-application'
            ];
        }

        // notifications
        $notif = Notification::with(['user.party.person'])->limit(10)->orderBy('date_recorded', 'desc')->get();
        $students = [];

        foreach ($notif as $key => $value) {
            // dd($value->user->party->person);
            $students[] = [
                'fa_class' => 'fas fa-scroll text-white',
                // 'sort_date' => Carbon::createFromFormat('Y-m-d H:i:s', $v->updated_at)->format('Y-m-d'),
                'date' =>  Carbon::createFromFormat('Y-m-d H:i:s', $value->date_recorded)->format('F d, Y'),
                'message' => $value->message,
                'link' => $value->link,
                'user' => isset($value->user->party->person) ? 'by ' . $value->user->party->person->firstname . ' ' . $value->user->party->person->lastname : null,
            ];
        }

        // dd($students);

        // dd($students);

        $students = collect($students);

        // dd($students);

        return [
            'count' => $students->count(),
            'students' => collect($students)
        ];
    }

    public function notifs(){
        $user = Auth::user();
        $user_role = $user->roles->first()->name;
        
        if($user_role == 'Staff' || $user_role == 'Admin' || $user_role == 'Super-Admin'){
            $notifs = Notification::with(['user.party.person'])->where('type','agent')->orderBy('date_recorded', 'desc')->limit(7)->get();
            foreach($notifs as $n){
                $start = Carbon::parse($n->updated_at);
                $n->timeDiff = $start->diffForHumans();
            }
        }

        return $notifs;
    }

    public function fetch_enrolments()
    {
        $e = EnrolmentPack::where('status', 'complete')->orderBy('created_at', 'desc')->get();

        return $e ? $e->toArray() : [];
    }

    public function rto_config()
    {

        $to = TrainingOrganisation::all();

        if($to[0]->is_setup == 1) {
            return redirect('/dashboard');
        }

        $org_id = TrainingOrganisation::first();
        $postcode = AvtPostcode::orderBy('suburb')->get();
        $country_id = AvtCountryIdentifier::orderBy('full_name')->get();

        $arr_postcode = [];
        foreach ($postcode as $key => $value) {
            $arr_postcode[] = [
                'id' => $value->id,
                'postcode' => $value->postcode,
                'suburb' => $value->suburb,
                'state' => $value->state,
                'postcode_name' => $value->suburb . ', ' . $value->state . ' ' . $value->postcode
            ];
        }

        \JavaScript::put([
            'training_organisation_id' => $org_id->training_organisation_id,
            'organisation_id' => $org_id->id,
            'slct_country_identifier' => $country_id,
            'slct_postcode' => $arr_postcode,
            'organisation_types' => AvtOrgType::all(),
            'setup' => 1,
        ]);

        return view('organisation.configuration');
    }

    public function rto_config_finish(Request $request)
    {
        if($request->is_done == 1) {
            $to = TrainingOrganisation::first();
            $to->is_setup = 1;
            $to->update();
            return ['status' => 'success'];
        }else{
            return ['status' => 'error'];
        }
    }
    
    public function view_notif($id){
        $notif = Notification::find($id);
        $notif->is_seen = 1;
        $notif->update();
    }
}
