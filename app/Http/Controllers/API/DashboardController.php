<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AgentTempUpdate;
use App\Models\AvtPostcode;
use App\Models\AvtStateIdentifier;
use App\Models\Student\Student;
use App\Models\Student\Party;
use App\Models\FundedStudentCourse;
use App\Models\FundedStudentPaymentDetails;
use App\Models\Collection;
use App\Models\CommissionDetail;
use App\Models\Audit;
use App\Models\User;
use App\Models\OfferLetterStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;

class DashboardController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        // $user = User::where('username',$username)->first();
        $user = \Auth::user();
        $students = [];
        $earnings = 0;
        $ctr = 1;
        if($user->id == 1){
            $funded_course = FundedStudentCourse::with('student','course','payment_details','payment_sched','offer_detail','status')->orderBy('id','desc')->get();
            $earnings = FundedStudentPaymentDetails::where('verified', 1)->sum('pre_deduc_comm');
            $total_students = Student::count();
        }else{
            $agent = $user->agent_details;
            $funded_course = $agent->funded_course->load(['student','course','payment_details','payment_sched','offer_detail','status'])->sortByDesc('id');
            $earnings = FundedStudentPaymentDetails::where('agent_id', $agent->id)->where('verified', 1)->sum('pre_deduc_comm');
            $offer_letter = $agent->offer_letters->load('student');
            $arr_students = [];
            // get offerletter under agent na 
            if(count($offer_letter) > 0){
                foreach($offer_letter as $ol){
                    array_push($arr_students, $ol->student_id);
                }
            }
            // get fundedcourse under agent
            if(count($funded_course) > 0){
                foreach($funded_course as $fc){
                    //$agent_com = $fc->payment_details->where('verified', 1)->sum('pre_deduc_comm');
                    array_push($arr_students, $fc->student_id);
                }
            }
            // get unique student_id (total students)
            $total_students = count(array_unique($arr_students));
        }

        $funded_course_ = $funded_course->whereIn('status_id', [2,3,4]);
        foreach($funded_course_ as $fcourse){
            $balance = 0;
            $balance = (float)$fcourse->course_fee - $fcourse->payment_details->sum('amount');

            $status_color = 'positive';
            if($fcourse->status_id == 1){
                $status_color = 'warning';
            }elseif($fcourse->status_id == 2 || $fcourse->status_id == 3 || $fcourse->status_id == 4){
                $status_color = 'positive';
            }else{
                $status_color = 'negative';
            }

            $payments = $this->payments($fcourse);
            $course = [];
            if($fcourse->course  == null){
                if($fcourse->course_code == '@@@@'){
                    $course[] = [
                        'item' => $ctr++,
                        'code' => $fcourse->course_code,
                        'name' => 'Unit of Compentency',
                        'course_fee_type' => $fcourse->course_fee_type,
                        'status' => $fcourse->status->description,
                        'status_color' => $status_color,
                        'payment_details' => number_format($fcourse->payment_details->sum('amount'),2),
                        'course_fee' => $fcourse->course_fee,
                        'balance' => $balance > 0 ? number_format($balance,2) : 0.00,
                        'current_payment_sched' => $payments['current_sched'],
                        'payment_plan' => $payments['payment_plan'],
                        
                    ];
                }else{
                    $course[] = [
                        'item' => $ctr++,
                        'code' => $fcourse->course_code,
                        'name' => 'NO COURSE ENROLLED',
                        'course_fee_type' => $fcourse->course_fee_type,
                        'status' => $fcourse->status->description,
                        'status_color' => $status_color,
                        'payment_details' => number_format($fcourse->payment_details->sum('amount'),2),
                        'course_fee' => $fcourse->course_fee,
                        'balance' =>  $balance > 0 ? number_format($balance,2) : 0.00,
                        'current_payment_sched' => $payments['current_sched'],
                        'payment_plan' => $payments['payment_plan'],
                    ];
                }
            }else{
                $course[] = [
                    'item' => $ctr++,
                    'code' => $fcourse->course_code,
                    'name' => $fcourse->course->name,
                    'course_fee_type' => $fcourse->course_fee_type,
                    'status' => $fcourse->status->description,
                    'status_color' => $status_color,
                    'payment_details' => number_format($fcourse->payment_details->sum('amount'),2),
                    'course_fee' => $fcourse->course_fee,
                    'balance' =>  $balance > 0 ? number_format($balance,2) : 0.00,
                    'current_payment_sched' => $payments['current_sched'],
                    'payment_plan' => $payments['payment_plan'],
                ];

            }

            if($balance > 0){
                $students[] = [
                    'student_id' => $fcourse->student->student_id,
                    'name'=> $fcourse->student->party->name,
                    'type'=> $fcourse->student->type->type,
                    'courses' => $course,
                ];
            }
                    
        }
        
        $dashboard  = [
            'total_students'=> $total_students,
            'commission_earnings' => $earnings > 0 ? number_format($earnings,2) : 0.00,
            'studentList'   => $students,
            'activities'    => $this->activities_details(),
            'total_activities'    => count($this->activities_details()),
        ];

       return $dashboard;
    }


    public function activities_details(){
        $user = \Auth::user();
        $logout = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/user/logout";
        $audits = Audit::with('user.party')->select(DB::raw('id, event, user_id, auditable_id, auditable_type, old_values, new_values, url, MINUTE(created_at) AS created_min, created_at'))->where('url', '!=', $logout)->orderBy('id', 'desc')->limit(25)->get();
        $agent_id = '';
        if($user->hasRole('Agent')){
            $agent = $user->agent_details; 
            $agent_id = $agent->id;
        }

        $activity = [];
        foreach ($audits as $k => $v) {
            $url = explode('/', $v->url);
            $dname = '';
            $student_details = [];

            // Student Module Audits  
            if($url[3] == 'student' || $v->auditable_type == 'App\Models\FundedStudentPaymentDetails' || $v->auditable_type == 'App\Models\Collection'){

                $student_status = '';
                $studentID = '';
                $audit_type = '';
                $student_id = '';
                $collection_status = "";
                $agent_stud = false;

                $old_v = json_decode($v->old_values, true);
                $new_v = json_decode($v->new_values, true);
                // student status
                if(isset($old_v['status_id'])){
                    if(isset($new_v['status_id'])){
                        $status = OfferLetterStatus::where('id',$new_v['status_id'])->first();
                        $student_status = $status->description;
                    }
                }

                if($v->auditable_type == 'App\Models\FundedStudentCourse'){
                    $audit_type = 'Course';
                    $funded_c = FundedStudentCourse::with('student')->where('id', $v->auditable_id)->first();
                    if($funded_c){
                        $student_id = $funded_c->student->student_id;
                        if($funded_c->agent_id !== null && $funded_c->agent_id == $agent_id){
                            $agent_stud = true;
                        }
                    }
                }elseif($v->auditable_type == 'App\Models\FundedStudentPaymentDetails' || $v->auditable_type == 'App\Models\Collection'){
                    $audit_type = 'Payment';
                    if($v->auditable_type == 'App\Models\FundedStudentPaymentDetails'){
                        $payment_details = FundedStudentPaymentDetails::with('student')->where('id', $v->auditable_id)->first();
                        if($payment_details){
                            $student_id = $payment_details->student->student_id;
                            if($payment_details->agent_id !== null && $payment_details->agent_id == $agent_id){
                                $agent_stud = true;
                            }
                        }
                    }else{
                        $collection = Collection::with('student')->where('id', $v->auditable_id)->first();
                        if($collection){
                            $student_id = $collection->student->student_id;
                            if($collection->agent_id !== null && $collection->agent_id == $agent_id){
                                $agent_stud = true;
                            }
                        }
                    }
                    if(isset($old_v['verified'])){
                        if(isset($new_v['verified'])){
                            if($new_v['verified'] == 1){
                                $collection_status = 'Verified';
                            }elseif($new_v['verified'] == 0){
                                $collection_status = 'Pending';
                            }elseif($new_v['verified'] == 2){
                                $collection_status = 'Declined';
                            } 
                        }
                    }
                }elseif($v->auditable_type == 'App\Models\Student\Student'){
                    $audit_type = 'Student';
                    $stud_idx = Student::where('id', $v->auditable_id)->first();
                    if($stud_idx){
                        $student_id = $stud_idx->student_id;
                    }
                }

                $student = Student::with('party.person', 'funded_course')->where('student_id', $student_id)->first();
                if($student !== null){
                    $student_details = [
                        'student_id' => $student->student_id,
                        'name' => isset($student->party->name) ? $student->party->name : '',
                        'firstname' => $student->party->person->firstname,
                        'lastname' => $student->party->person->lastname,
                        'status' => $student_status,
                        'audit_type' => $audit_type,
                        'agent_stud' => $agent_stud
                    ];
                }
            }

            // Student Module Audits    
            if($url[3] == 'student' || $v->auditable_type == 'App\Models\FundedStudentPaymentDetails' || $v->auditable_type == 'App\Models\Collection'){
                if($agent_id !== '' || $v->user_id == $user->id){
                    //under agent students only
                    if(count($student_details) > 0 && $student_details['agent_stud'] == true){
                        // if($student_details['agent_stud'] == true){
                            array_push($activity, [
                                'id' => $v->id,
                                'name' => $v->user->hasRole('Agent') ? $v->user->agent_details->agent_name : 'Admin Staff',
                                // 'firstname' => $v->user->party->person->firstname,
                                // 'lastname' => $v->user->party->person->lastname,
                                'avatar' => '/storage/user/avatars/' . $v->user->profile_image,
                                'url' => $url,
                                'old_values' => $old_v,
                                'new_values' => $new_v,
                                'created_at' => Carbon::parse($v->created_at)->format('Y-m-d H:m:s'),
                                'created_min' =>  Carbon::parse($v->created_at)->diffForHumans(),
                                'event' => $v->event,
                                'dname' => $dname,
                                'student' => $student_details,
                                'collection_status' => $collection_status
                            ]);
                        // }
                    }else{
                        // new enrolled isset($new_v['name'])
                        if($v->event == 'created'){
                            array_push($activity, [
                                'id' => $v->id,
                                'name' => $v->user->hasRole('Agent') ? $v->user->agent_details->agent_name : 'Admin Staff',
                                // 'firstname' => $v->user->party->person->firstname,
                                // 'lastname' => $v->user->party->person->lastname,
                                'avatar' => '/storage/user/avatars/' . $v->user->profile_image,
                                'url' => $url,
                                'old_values' => $old_v,
                                'new_values' => $new_v,
                                'created_at' => Carbon::parse($v->created_at)->format('Y-m-d H:m:s'),
                                'created_min' =>  Carbon::parse($v->created_at)->diffForHumans(),
                                'event' => $v->event,
                                'dname' => $dname,
                                'student' => $student_details,
                                'collection_status' => $collection_status
                            ]);
                        }
                    }
                }else{
                    array_push($activity, [
                        'id' => $v->id,
                        'name' => $v->user->hasRole('Agent') ? $v->user->agent_details->agent_name : 'Admin Staff',
                        // 'firstname' => $v->user->party->person->firstname,
                        // 'lastname' => $v->user->party->person->lastname,
                        'avatar' => '/storage/user/avatars/' . $v->user->profile_image,
                        'url' => $url,
                        'old_values' => $old_v,
                        'new_values' => $new_v,
                        'created_at' => Carbon::parse($v->created_at)->format('Y-m-d H:m:s'),
                        'created_min' =>  Carbon::parse($v->created_at)->diffForHumans(),
                        'event' => $v->event,
                        'dname' => $dname,
                        'student' => $student_details,
                        'collection_status' => $collection_status
                    ]);
                }
                
            }                    

        }
        // dd($activity);
        return $activity;
    }

    public function notifications(){
        // $user = User::where('username',$username)->first();
        $user = \Auth::user();
        $user_id = '';
        $agent = $user->agent_details;
        if($agent){
            $user_id = $agent->id;
            $notifications = Notification::where('type', 'payment_collection')->where('reference_id', $user_id)->where('is_seen', 0)->orderBy('id','desc')->get();
        }else{
            $user_id = $user->id;
            $notifications = Notification::where('type', 'payment_collection')->where('is_seen', 0)->orderBy('id','desc')->get();
        }

       $n = [];
        foreach($notifications as $notif){

            $course = [];
            $collection = Collection::with('student.party','funded_student_course.course')->where('id', $notif->table_id)->first();
            if($collection){
                $funded_course = $collection->funded_student_course;
                $collection_status = "";
                if($collection->verified == 1){
                    $collection_status = 'Verified';
                }elseif($collection->verified == 0){
                    $collection_status = 'Pending';
                }elseif($collection->verified == 2){
                    $collection_status = 'Declined';
                }              
                
                if($funded_course->course_code == '@@@@'){
                    $course = [
                        'name' => 'Unit of Compentency',
                        'code' => $funded_course->course_code,
                        'collection_status' => $collection_status
                    ];
                }else{
                    $course = [
                        'name' => $funded_course->course->name,
                        'code' => $funded_course->course_code,
                        'collection_status' => $collection_status
                    ];
                }
                
                $n[] = [
                    'id' => $notif->id,
                    'label' => $notif->message,
                    'is_seen' => $notif->is_seen,
                    'student_id' => $collection->student_id,
                    'student_name' => $collection->student->party->name,
                    'created_at' => Carbon::parse($notif->created_at)->format('Y-m-d H:m:s'),
                    'created_min' =>  Carbon::parse($notif->created_at)->diffForHumans(),
                    'course' => $course
                ]; 
            }                           
        }

        return $n;
    }

    public function top_search($search){
        $studs = [];
        // $user = User::where('username', $username)->first();
        $user = \Auth::user();
        $user_id = $user->id;
        if ($user->hasRole('Agent')) {
            $agent = $user->agent_details; 
            $agent_id = $agent->id;
            $students = Student::with('funded_course','party.person')->has('funded_course')->where('student_id', 'like', '%' . $search . '%')->orWhereHas('party.person', function ($q) use ($search) {
                $q->where('firstname', 'like', '%'.$search.'%'); // student name
            })->orWhereHas('party', function($q) use ($search) {
                 $q->where('name', 'LIKE', '%'. $search . '%'); // student name
            })->whereHas('funded_course', function ($q) use ($agent_id) {
                $q->where('agent_id', $agent_id);
            })->get();
            
            // students with agent's ID in funded course only
            foreach ($students as $stud) {
                if(count($stud->funded_course) > 0){
                    foreach($stud->funded_course as $fc){
                        if($fc->agent_id == $agent_id){
                            $studs[] = [
                                'student_name' => $stud->student_id . ' - ' . $stud->party->name,
                                'name' => $stud->party->name,
                                'student_id' => $stud->student_id,
                                'student_type' => $stud->student_type_id,
                                'student_table_id' => $stud->party->id,
                            ];
                        }
                    }
                }
            }
            $studs = array_map("unserialize", array_unique(array_map("serialize", $studs))); // student has many course
        } else {
            $students = Student::with('funded_course', 'party.person')->has('funded_course')->where('student_id', 'like', '%' . $search . '%')->orWhereHas('party', function($q) use ($search) {
                $q->where('name', 'LIKE', '%'. $search . '%');
            })->get();
            // all students
            foreach ($students as $stud) {
                $studs[] = [
                    'student_name' => $stud->student_id . ' - ' . $stud->party->name,
                    'name' => $stud->party->name,
                    'student_id' => $stud->student_id,
                    'student_type' => $stud->student_type_id,
                    'student_table_id' => $stud->party->id,
                ];
            }
        }

        return $studs;
    }

    public function payments($student_course){
        $funded_course = $student_course;
        $date_now = Carbon::now()->setTimezone('Australia/Melbourne')->format('d/m/Y');
        $current_sched = [];
        $payment_plan = [];
        $pl = [];
        $cp = [];
        $ctr = 1;

        $due_dates_arr = [];
        foreach($funded_course->payment_sched as $key => $psched){

            $balance = 0;
            $balance = (float)$psched->payable_amount - $psched->approved_amount_paid;

            $pd = [];
            foreach($psched->payment_detail as $payment_detail){
                
                $pd[] = [
                    'id' => $payment_detail->id,  
                    'transaction_code' => $payment_detail->transaction_code,  
                    'payment_date' =>  Carbon::parse($payment_detail->payment_date)->format('d/m/Y'),  
                    'amount' => $payment_detail->amount,  
                    'pre_deduc_comm' => $payment_detail->pre_deduc_comm,  
                    'verified' => $payment_detail->verified,  
                    'note' => $payment_detail->note,  
                ];
            }

            $pl[]= [
                'number'             => $ctr++,
                'id'                 => $psched->id,
                'name'               => $psched->id,
                'due_date'           => Carbon::parse($psched->due_date)->format('d/m/Y'),
                'adjusted_date'      => $psched->adjusted_date != '' ? Carbon::parse($psched->adjusted_date)->format('d/m/Y') : null,
                'payable_amount'     => $psched->payable_amount,
                'payment_details'    => $pd,
                'total_paid'         => $psched->amount_paid,
                'total_paid_approved'=> $psched->approved_amount_paid,
                'balance'            => $balance,
            ];
            
            //get priority payment sched
            $due_date = Carbon::parse($psched->due_date)->format('d/m/Y');
            if($psched->approved_amount_paid < $psched->payable_amount){
                array_push($due_dates_arr, $due_date);
                if($due_dates_arr[0] == $due_date){
                    $cp = [
                        'id'                 => $psched->id,
                        'name'               => $psched->id,
                        'due_date'           => Carbon::parse($psched->due_date)->format('d/m/Y'),
                        'adjusted_date'      => $psched->adjusted_date != '' ? Carbon::parse($psched->adjusted_date)->format('d/m/Y') : null,
                        'payable_amount'     => $psched->payable_amount,
                        'payment_details'    => $pd,
                        'total_paid'         => $psched->amount_paid,
                        'total_paid_approved'=> $psched->approved_amount_paid,
                        'balance'            => $balance,
                    ];
                }                                            
                // if($date_now <= $due_date || $date_now >= $due_date){
                //     array_push($due_dates_arr, $due_date);
                //     $next_sched = $this->find_closest($due_dates_arr, $date_now);
                //     if($next_sched == $due_date){
                //         $cp = [
                //             'id'                 => $psched->id,
                //             'name'               => $psched->id,
                //             'due_date'           => Carbon::parse($psched->due_date)->format('d/m/Y'),
                //             'adjusted_date'      => $psched->adjusted_date != '' ? Carbon::parse($psched->adjusted_date)->format('d/m/Y') : null,
                //             'payable_amount'     => $psched->payable_amount,
                //             'payment_details'    => $pd,
                //             'total_paid'         => $psched->amount_paid,
                //             'total_paid_approved'=> $psched->approved_amount_paid,
                //             'balance'            => $balance,
                //         ];     
                //     }
                // }elseif($date_now >= $due_date){
                //     array_push($due_dates_arr, $due_date);
                //     $next_sched = $this->find_closest($due_dates_arr, $date_now);
                //     if($next_sched == $due_date){
                //         $cp = [
                //             'id'                 => $psched->id,
                //             'name'               => $psched->id,
                //             'due_date'           => Carbon::parse($psched->due_date)->format('d/m/Y'),
                //             'adjusted_date'      => $psched->adjusted_date != '' ? Carbon::parse($psched->adjusted_date)->format('d/m/Y') : null,
                //             'payable_amount'     => $psched->payable_amount,
                //             'payment_details'    => $pd,
                //             'total_paid'         => $psched->amount_paid,
                //             'total_paid_approved'=> $psched->approved_amount_paid,
                //             'balance'            => $balance,
                //         ];  
                //     } 
                // }
            }
            
        }

        $data = [
            'payment_plan' => $pl,
            'current_sched' => $cp
        ];

        return $data;
    }

    public function find_closest($array, $date){
        //$count = 0;
        foreach($array as $day){
            //$interval[$count] = abs(strtotime($date) - strtotime($day));
            $interval[] = abs(strtotime($date) - strtotime($day));
            //$count++;
        }
    
        asort($interval);
        $closest = key($interval);
        // dump($array[$closest]);
        return $array[$closest];
    }

    public function updateNotification($id){
        try {
            DB::beginTransaction();
            $notif = Notification::where('id',$id)->first();
            $notif->is_seen = 1;
            $notif->update();
            DB::commit();
            return response(['status'=>'success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
}
