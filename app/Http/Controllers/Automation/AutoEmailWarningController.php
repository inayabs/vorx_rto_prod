<?php

namespace App\Http\Controllers\Automation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EmailSending;
use App\Models\EmailTemplate;
use App\Models\EmailModule;
use App\Models\EmailWarningTrail;
use App\Models\Student\Student;
use App\Models\Student\OfferLetter\OfferLetter;
use App\Models\OfferLetterCourseDetail;
use App\Models\PaymentScheduleTemplate;
use App\Models\StudentInvoice;
use App\Models\OfferLetterFee;
use App\Models\CashPayment;
use App\Models\OnlinePayment;
use App\Models\PaymentScheduleDetail;

use App\Models\TrainingOrganisation;

use App\Models\Course;
use App\Models\FundedStudentDetails;
use App\Models\FundedStudentCourse;
use App\Models\FundedStudentCourseDetail;
use App\Models\FundedStudentPaymentDetails;

use Carbon\Carbon;
use DB;
use Storage;

use Mailer;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use App\Models\Automation;
use App\Models\AutomationAudit;

class AutoEmailWarningController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('checkModule:automation');
        $this->middleware('auth');
    }
    private $AutoDate;
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


    public function automate()
    {
        
        $this->AutoDate = Carbon::now()->setTimezone('Australia/Melbourne');
        $now = $this->AutoDate->format('H:i');
        $past = Carbon::now()->setTimezone('Australia/Melbourne')->sub(10, 'minutes')->format('H:i');
        $future = Carbon::now()->setTimezone('Australia/Melbourne')->add(10, 'minutes')->format('H:i');
        // dump($time);
        // $time = '00:00';
        $auto = Automation::where('type', 'email-warning-fees')->where('time', '>', $past)->where('time', '<', $future)->get();
        // $auto = Automation::where('type', 'email-warning-fees')->get(); //for test
        // dd($auto);
        // $getCount = $auto->count();
        // if($auto){
            // dump('here');
            // Daily
            if($auto->count() > 0 ){
              foreach($auto as $schedule){
                // $schedule = $auto->where('occurrence_type', 'Daily');
                // dump($schedule);
                if($schedule->time <= $now){
                  if($schedule->occurrence_type == 'Daily'){
                          $autoAudit = AutomationAudit::where('type', 'email-warning-fees')->where('date_triggered', 'like', Carbon::now()->format('Y-m-d ').'%')->first();
                          if($autoAudit){
                              return false;
                          }
                      // foreach($schedule as $v){
                          switch ($schedule->type) {
                              case 'email-warning-fees':
                                  $this->autosend_warning($schedule);
                                  break;
                          }
                      // }
                  }
                  
                  // Monthly
                  if($schedule->occurrence_type == 'Monthly'){
                      // dump($schedule);
                      // foreach($schedule as $v){
                          $autoAudit = AutomationAudit::where('type', 'email-warning-fees')->where('date_triggered', 'like', Carbon::now()->format('Y-'.$schedule->month).'%')->first();
                          if($autoAudit){
                              return false;
                          }
  
                          $day = $schedule->day > $this->AutoDate->format('t') ? $this->AutoDate->format('t') : $schedule->day;
                          // dump($day);
                          if($day == $this->AutoDate->format('d')){
                              // dump('yeagagag');
                              switch ($schedule->type) {
                                  case 'email-warning-fees':
                                      $this->autosend_warning($schedule);
                                      break;
                              }
                          }
                      // }
                  }
      
                  // Yearly
                  if($schedule->occurrence_type == 'Yearly'){
                          $autoAudit = AutomationAudit::where('type', 'email-warning-fees')->where('date_triggered', 'like', Carbon::now()->format('Y').'%')->first();
                          if($autoAudit){
                              return false;
                          }
                      // foreach($schedule as $v){
                          if($schedule->month == $this->AutoDate->format('m')){
                              $day = $schedule->day > $this->AutoDate->format('t') ? $this->AutoDate->format('t') : $schedule->day;
                              if($day == $this->AutoDate->format('d')){
                                  switch ($schedule->type) {
                                      case 'email-warning-fees':
                                          $this->autosend_warning($schedule);
                                          break;
                                  }
                              }
                          }
                      // }
                  }
                }
              }
            }else{
              // dump('nothing to send');
              // dd('yo set automation config first for email warning for fees');
              abort(404);
            }
            

    }
    // automated sending
    public function autosend_warning($sched){

      
      $config_emails = explode(',', preg_replace('/\s+/', '', $sched->emails));
      
      $et = EmailTemplate::all();
      $first_warning_interval = $et->where('email_type','first-warning')->first();
      $second_warning_interval = $et->where('email_type','second-warning')->first();
      $intention_to_report = $et->where('email_type','notification-of-intention-to-report')->first();
      $cancellation_interval = $et->where('email_type','cancellation')->first();

      if(isset($first_warning_interval) && $first_warning_interval->interval != 0){
        $swi = $first_warning_interval->interval;
      }else{
        $swi = 3;
      }

      if(isset($second_warning_interval) && $second_warning_interval->interval != 0){
        $ir = $second_warning_interval->interval;
      }else{
        $ir = 2;
      }

      if(isset($intention_to_report) && $intention_to_report->interval != 0){
        $ci = $intention_to_report->interval;
      }else{
        $ci = 20;
      }

      // $now = Carbon::now()->setTimezone('Australia/Melbourne');
      $date_now = $this->AutoDate->format('Y-m-d');
      $status = null;
      $send = null;
      $sentTo = [];

      
      
      // test only
      $student_details = Student::with('party.person','type', 'party.user')->whereIn('student_id',['PCA00036','VRX00029'])->has('party.user')->get();
      // $student_details = Student::with('party.person','type')->get(); //prod
      foreach($student_details as $stud){
        // get first warning-letter (1)
        $email_content = $this->email_content($stud->student_id, 1);
        $template = $this->email_template($email_content['content'], $email_content['title']);
        $email_trail = EmailWarningTrail::where('student_id', $stud->student_id)->where('course_code',$email_content['course_code'])->where('email_template_type', $email_content['email_type'])->first();
        // dump($email_content);
        // magsend lang if naay course na studying international for payments warning letter
        // send if email trail is null / wala pa nasendan with specific email template
        // if($email_content['course'] != null && $stud->type->type == 'International'){
          if($email_content['course'] != null && $email_trail == null){
            // $data = OfferLetter::with(['student_details', 'course_details.course', 'course_details.payment_template', 'course_details.payments'])->get();
            if($email_content['email_type'] == 'first-warning'){
              // add 1day to due date
              $after_due = Carbon::parse($email_content['due_date'])->addDays(1)->format('Y-m-d');
              if($after_due <= $date_now && $email_content['due_date'] != null){
                if($email_content['email'] != '' || $email_content['email'] != null){
                  $send = $this->mailer($email_content, $template, $config_emails);
                }
              }
              
            }else if($email_content['email_type'] == 'second-warning'){
              // dd('2nd');
                // add second_warning_interval to first_date_sent to send second warning template
                $fds = Carbon::parse($email_content['first_date_sent'])->addDays($swi)->format('Y-m-d');
                // check if date today is greater or equal $fds before sending warning 
                if($date_now >= $fds){
                     if($email_content['email'] != '' || $email_content['email'] != null){
                        $send = $this->mailer($email_content, $template, $config_emails);
                      }
                }
            }else if($email_content['email_type'] == 'notification-of-intention-to-report'){
              $sds = Carbon::parse($email_content['second_date_sent'])->addDays($ir)->format('Y-m-d');
              // dd($sds);
              // check if date today is greater or equal $sds before sending warning 
              if($date_now >= $sds){
                  // dd('send');
                  if($email_content['email'] != '' || $email_content['email'] != null){
                      $send = $this->mailer($email_content, $template, $config_emails);
                  }
              }
            }else if($email_content['email_type'] == 'cancellation'){
                // add cancellation_interval to third_date_sent to send cancellation warning template
                $irs = Carbon::parse($email_content['third_date_sent'])->addDays($ci)->format('Y-m-d');
                // check if date today is greater or equal $irs before sending warning 
                if($date_now >= $irs){
                    if($email_content['email'] != '' || $email_content['email'] != null){
                        $send = $this->mailer($email_content, $template, $config_emails);
                    }
                }
            }
            // else{
            //     // first warning
            //     // send other warning letters templates
            //     if($email_content['email'] != '' || $email_content['email'] != null){
            //         $send = $this->mailer($email_content, $template, $config_emails);
            //     }
            // }
            //   if($email_content['email'] != '' || $email_content['email'] != null){
            //     $send = $this->mailer($email_content, $template);
            //   }
        
            // if($send != null){
            //     $send = json_decode($send, true);
            //     if($send['status'] == 'success'){
            //       $sentTo[] = [
            //         'student_id'  => $stud->student_id,
            //         'type'        => $stud->type->type,
            //         'email'       => $email_content['email'],
            //         'status'      => $send['status']
            //         ];
            //         // dump($sentTo);
            //         // dump(count($sentTo) .' '.'warning letter sent'. ' '. $date_now);
            //         // return ['status' => 'success'];
            //     }else{
            //         // return ['status' => 'error', 'message' => 'Something went wrong.'];
            //     }
            // }
            // dd($sentTo);
            
            // return ['status' => 'success'];
            
        }
      }
      
      return ['status' => 'success'];
    }


    public function mailer($email_content, $template, $config_emails){
      
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
        $mail->Username = 'test@vorx.com.au';
        $mail->Password = '0fW$?MmZ!MMa';
        // $mail->SMTPAutoTLS = true;
        $mail->SMTPSecure = 'tls';                                      // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                              // TCP port to connect to
        // $mail->SMTPDebug = 1;                                           // Enable SMTP authentication

        $mail->setFrom('test@vorx.com.au', 'VORX - RTO');

        // emailTo (student recipient)
        // $mail->addAddress($email_content['email']);
        $mail->addAddress('xyshain@gmail.com');
        // emailBcc (emails in config/other recipients)
        foreach($config_emails as $v){
            $mail->addBcc($v);
        }
        
        // $mail->addBcc('admin1@eti.edu.au');
        // $mail->addBcc('xyshain@gmail.com');
        // $mail->addBcc('Elitetrainingoffice@gmail.com');

        // $mail->addCc('admission@eti.edu.au');     // Add a recipient

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $email_content['subject'];
        $mail->Body    = $template;
        // dd(\Auth::user()->id);
        if (!$mail->send()) {
            // return back()->withInput()->withErrors(['status' => 'error', 'message' => 'Email was not sent...']);
            dump($mail->ErrorInfo);
            return json_encode(['status' => 'error', 'msg' => $mail->ErrorInfo]);
            
        } else {
            // dd('sent');
            // $mail->copyToFolder("Sent");
              $email_trail = new EmailWarningTrail;
              $email_trail->fill([
                'student_id'          => $email_content['student_details']['student_id'],
                'email_template_id'   => $email_content['emailTemp_id'],
                'email_template_type' => $email_content['email_type'],
                'date_sent'           => Carbon::now()->format('Y-m-d'),
                // 'user_id'             => \Auth::user()->id,
                'user_id'             => 1,
                'course_code'         => isset($email_content['course_code']) ? $email_content['course_code'] : null
              ]);
              $email_trail->save();

            return json_encode(['status' => 'success']);
        }
    }


    public function email_content($student_id, $emailTemp_id){
      // dd($emailTemp_id);
      $student_details = Student::with('party.person','type')->where('student_id', $student_id)->first();
      $stud = $student_details->party->person;
      
      $middlename = '';
      if(isset($stud->middlename)){
        $middlename = $stud->middlename;
      }
      $course_code = '';
      $course = '';
      $email = '';
      $course_fee = '';
      $balance = 0;
      $latest_payment = null;
      $payment_sched = null;
      $expected_bal = 0;
      $actual_bal = 0;
      $date_now = Carbon::now()->format('Y-m-d');
      $address = '';
      // Get STUDYING course
      if($student_details->type->type == 'Domestic'){
        // dump('domestic stud');
        $funded_student = FundedStudentDetails::with('course.course', 'course.payment_details', 'course.payment_sched', 'contact')->where('student_id', $student_id)->first();
        $email = $funded_student->contact->email;
        $address = $funded_student->contact->addr_postal_delivery_box;
        // $funded_course = $funded_student->course->whereIn('status_id', [2,3,4])->first();
        $funded_course = $funded_student->course->whereNotIn('status_id', [5,7,9])->first();
        $latest_payment = FundedStudentPaymentDetails::where('student_id', $student_id)->latest('payment_date')->first();
        if($latest_payment != null){
          $latest_payment = $latest_payment->payment_date;
        }

        if($funded_course != null){
          //  $date_now
          $payment_sched = $funded_course->payment_sched;
          $x =  $funded_course->payment_sched->where('due_date',  '<=', $date_now);
          $expected_bal = $funded_course->payment_sched->sum('payable_amount') - $x->sum('payable_amount');
          $actual_bal =  $funded_course->payment_sched->sum('payable_amount') - $funded_course->payment_details->sum('amount');

          // $balance = $funded_course->course_fee - $funded_course->payment_details->sum('amount');
          if($funded_course->course_code == '@@@@'){
            $course_code = '@@@@';
            $course = '@@@@' . ' - ' . 'Unit of Competency';
          }else{
            $course_code = $funded_course->course->code;
            $course = $funded_course->course->code . ' - ' . $funded_course->course->name;
          }
        }else{
          $course = null;
        }
        
      }else if($student_details->type->type == 'International'){
        
        $data = OfferLetter::with(['student_details', 'course_details.course', 'course_details.payment_template', 'course_details.payments'])->where('student_id', $student_id)->first();
       if($data != null){
        $_stud_details = $data->student_details;
        $email = $_stud_details->email_personal;
        $address = $_stud_details->current_address;
        // $int_course = $data->course_details->whereIn('status_id',[2,3,4])->first();
        $int_course = $data->course_details->whereNotIn('status_id',[5,7,9])->first();

        if($int_course != null){
          $latest_payment = FundedStudentPaymentDetails::where('offer_letter_course_detail_id', $int_course->id)->latest('payment_date')->first();
          if($latest_payment != null){
            $latest_payment = $latest_payment->payment_date;
          }
        }


        if($int_course != null){
          $payment_sched = $int_course->payment_template;
          $x =  $int_course->payment_template->where('due_date',  '<=', $date_now);
          $expected_bal = $int_course->payment_template->sum('payable_amount') - $x->sum('payable_amount');
          $actual_bal =  $int_course->payment_template->sum('payable_amount') - $int_course->payments->sum('amount');
          
          // $balance = $int_course->payment_template->sum('payable_amount') - $int_course->payments->sum('amount');
          $course_code = $int_course->course->code;
          $course = $int_course->course->code . ' - ' . $int_course->course->name;
        }else{
          $course = null;
        }
       }
      }


      $due_date = null;
      if($payment_sched != null && $payment_sched->count() > 0){
        foreach($payment_sched as $key => $ps){
          if($ps->due_date != null){
            $z = Carbon::parse($ps->due_date)->format('Y-m-d');
            if($z <= $date_now){
              $due_date = $z;
            }
          }
        }
      }

      // GET EMAIL TEMPLATE
      $latest_warning_trail = EmailWarningTrail::where('student_id', $student_id)->where('status_id', 0)->latest()->first();
      // $email_template = EmailTemplate::with('email_module')->where('id', $emailTemp_id)->first();
      $first_sent = null;
      $second_sent = null;
      $third_sent  = null;
      // dump($latest_warning_trail->email_template_type);
      if($latest_warning_trail != null){
        // status 0 means current set of warning letter
        $all_warning_trail = EmailWarningTrail::where('student_id', $student_id)->where('status_id', 0)->get();
        foreach($all_warning_trail as $awt){
          // 2nd and cancellation warning letter
          $warning_type = $latest_warning_trail->email_template_type;
          if($awt->email_template_type == 'first-warning'){
            if(isset($awt->email_template_type) && $awt->email_template_type == 'first-warning'){
              $first_sent = $awt->date_sent;
            }
          }else if($awt->email_template_type == 'second-warning'){
            if(isset($awt->email_template_type) && $awt->email_template_type == 'second-warning'){
              $second_sent = $awt->date_sent;
            }
          }else if($awt->email_template_type == 'notification-of-intention-to-report'){
            if(isset($awt->email_template_type) && $awt->email_template_type == 'notification-of-intention-to-report'){
              $third_sent = $awt->date_sent;
            }
          }
        }
      }
      // dump($student_details->type->type);
      // dd($latest_payment);
      // dd($latest_warning_trail);
      $et = EmailTemplate::with('email_module')->get();
      $first_warning = $et->where('email_type', 'first-warning')->first();
      $second_warning = $et->where('email_type', 'second-warning')->first();
      $intention_to_report = $et->where('email_type', 'notification-of-intention-to-report')->first();
      $cancel_warning = $et->where('email_type', 'cancellation')->first();
      $other_templates = $et->where('id', $emailTemp_id)->first();

      // dump($expected_bal);
      // dump($actual_bal);
      
      // Get email template
      if($expected_bal < $actual_bal){
      // dd('yo');
        if($first_sent == null){
          // first warning
          if($emailTemp_id == 1){
            $email_template = $first_warning;
          }

        }else if($first_sent != null && $second_sent == null){
          // dump($latest_payment);
          // dd($first_sent);
          // $fds = new Carbon($first_sent);
          // $sds = $fds->addDays(7)->format('Y-m-d');
          // $date_now >= $sds && $first_sent > $latest_payment
          // sencond warning
          if(isset($latest_payment)){
            if($first_sent > $latest_payment){
              $email_template = $second_warning;
            }
          }else if($expected_bal < $actual_bal){
            $email_template = $second_warning;
          }
          
        }else if($first_sent != null && $second_sent != null){

          // $sds = new Carbon($second_sent);
          // $sds = $sds->addDays(20);
          //$date_now >= $sds && $second_sent > $latest_payment
          // notification-of-intention-to-report template
          if(isset($latest_payment)){
            if($second_sent > $latest_payment){
              $email_template = $intention_to_report;
            }
          }else if($expected_bal < $actual_bal){
            $email_template = $intention_to_report;
          }
          // cancellation template
          if($third_sent != null){
            if(isset($latest_payment)){
              if($third_sent > $latest_payment){
                $email_template = $cancel_warning;
              }
            }else if($expected_bal < $actual_bal){
              $email_template = $cancel_warning;
            }
          }
        }

      }else{
        // dd('waz');
        $email_template = $other_templates;
      }
     
     
      // if email type is "intention_to_report", get date to pay overdue fees(5days before cancellation email will be sent)
      $to_pay_overdue_fees = null;
      if($email_template->email_type == 'notification-of-intention-to-report'){
        $to_pay_overdue_fees = Carbon::parse($date_now)->addDays(15)->format('d/m/Y');
      }
      $f = null;
      $s = null;
      $t = null;
      if($first_sent != null){
        $f = Carbon::parse($first_sent)->format('d/m/Y');
      }
      if($first_sent != null){
        $s = Carbon::parse($second_sent)->format('d/m/Y');
      }
      if($first_sent != null){
        $t = Carbon::parse($third_sent)->format('d/m/Y');
      }

          $m_fields = $email_template->email_module;
          $m_fields = explode(',',$m_fields->fields);
          // fields should be aligned to values   
          // studentID,firstname,lastname,course,courseFee,address
          $fields = "%".implode("%,%",$m_fields)."%";
          $fields = explode(',',$fields); // $fields = array("%firstname%", "%lastname%", "%course%");
          $value   = array($student_id, $stud->firstname, $stud->lastname, $course, $actual_bal, $address, $f, $s, $to_pay_overdue_fees);

          $content = str_replace($fields, $value, $email_template->email_content);
          $title = $email_template->name;
          $subject = $email_template->email_subject;

          $data = [
            'student_details'     => $student_details,
            'emailTemp_id'        => $email_template->id,
            'title'               => $title,
            'email_type'          => $email_template->email_type,
            'subject'             => $subject,
            'content'             => $content,
            'course_code'         => $course_code,
            'course'              => $course,
            'email'               => $email,
            'first_date_sent'     => $first_sent,
            'second_date_sent'    => $second_sent,
            'third_date_sent'     => $third_sent,
            'to_pay_overdue_fees' => $to_pay_overdue_fees,
            // 'balance'           => $balance,
            'expected_balance'    => $expected_bal,
            'actual_balance'      => $actual_bal,
            'due_date'            => $due_date,
            'latest_payment'      => isset($latest_payment->payment_date) ? $latest_payment->payment_date : null
          ];

        return $data;
    }

    public function email_template($content, $title, $pdf = null, $date = null ){

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
        $com_setting = TrainingOrganisation::first();
        $address = $com_setting->addr_line1 .' '. $com_setting->addr_location .' '. $com_setting->state_identifier . ' ' . $com_setting->postcode;
        if($com_setting->logo_img != null){
          $logo = 'storage/config/images/' . $com_setting->logo_img;
        }else{
          $logo = 'images/logo/vorx_logo.png';
        }
        $logo_url = url('/'.$logo.'');

        $org_name = !in_array($com_setting->training_organisation_name, ['',null]) ? $com_setting->training_organisation_name : 'VORX';
        
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
                          <img src="'. $logo_url .'" style="margin: 0 auto;display: block; width: 180px;">
                        </td>
                        <td style="font-size: 10px;padding-right: 60px;" width="50%">
                          <p style="font-weight: bold;font-size: 9px; margin:3px 0 0;"> '. $com_setting->training_organisation_name .'</p>
                          <p style="font-size: 9px; margin:3px 0 0;"><span style="font-weight: bold;">ADDRESS:</span> ' . $address . '</p>
                          <p style="font-size: 9px; margin:3px 0 0;"><span style="font-weight: bold;">TELEPHONE NO:</span> '. $com_setting->telephone_number .'</p>
                          <p style="font-size: 9px; margin:3px 0 0;"><span style="font-weight: bold;">EMAIL:</span> '. $com_setting->email_address .'</p>
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
                          <h1 style="font-weight: bold;font-size: 16px;text-align: center;text-decoration: underline;">' .$title. '</h1>
                          <br>
                         <p style="text-align:justify;">'.$content.'</p><br>
                          <div class="clearfix" style="height:50px;"></div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="padding: 0 60px;">
                         <p style="text-align: center;font-size: 9px;">© '.$org_name.' 2020</p>
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
