<?php

namespace App\Http\Controllers\Student;

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
use App\Models\Automation;
use App\Models\AutomationAudit;
use Carbon\Carbon;
use DB;
use Storage;

use Mailer;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailWarningController extends Controller
{
    //
    public function __construct()
    {
      // $this->middleware('checkModule:automation');
      return $this->middleware('auth');
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

    public function get_warning_letters($student_id){

      $student_details = Student::with('party.person','type')->where('student_id', $student_id)->first();
      $warning_letters = EmailTemplate::with('email_module')->where('active', 1)->get();
      // paments and student module 
      $warning_letters = $warning_letters->whereIn('email_module_id', [1,2]);
      // if($student_details->type->type == 'Domestic'){
      //   // student module only
      //   $warning_letters = $warning_letters->whereIn('email_module_id', 2);
      // }else{
      //   // paments and student module 
      //   $warning_letters = $warning_letters->whereIn('email_module_id', [1,2]);
      // }

        // Warning letters under student module      
        $email_trail = EmailWarningTrail::where('student_id', $student_id)->get();
        // dump($warning_letters);
        // dump($email_trail);
        $warningHistory = [];
        $arr_eTrail = [];
        $wl_checker = false;
        $info = '';
        
        if($warning_letters->count() > 0){
          foreach($warning_letters as $key => $wl){

            $info_ = $wl->where('id', $wl->id)->first();

            if(count($email_trail) > 0){
              foreach($email_trail as $et){
                // $info = $wl->where('id', $wl->id)->latest()->first();
                $check_wl = $et->where('email_template_id', $wl->id)->where('student_id', $student_id)->first();
                if($check_wl != null && $check_wl->status_id == 0){
                  $wl_checker = true;
                }else{
                  $wl_checker = false;
                }
                
              }

              $arr_eTrail[] = [
                'info'              => $wl->where('id', $wl->id)->first(),
                'email_template_id' => $wl->id,
                'sent'              => $wl_checker
              ];
              $arr_eTrail = array_map("unserialize", array_unique(array_map("serialize", $arr_eTrail)));

            }else{
              $arr_eTrail[] = [
                'info'              => $info_,
                'email_template_id' => $wl->id,
                'sent'              => $wl_checker
              ];
            }
          }
        }else{
          $warning_letters = null;
        }
          // dd($arr_eTrail);

        foreach($email_trail as $key => $value){
          $x = EmailTemplate::where('id', $value->email_template_id)->first();
          $warningHistory[] = [
            'id'    => $key+1,
            'email_template_type' => $x->name,
            'date_sent'           => $value->date_sent,
            'course_code'         => $value->course_code,
          ];
        }
        $data = [
          'warningLetters'      => $arr_eTrail,
          'warningHistory'      => $warningHistory
        ];

        return $data;
    }

    // automated sending naa sa Automation Controller :)
    // public function test_send(){
    //   $student_details = Student::with('party.person','type')->get();
      
    //   foreach($student_details as $stud){
    //     // dump($this->get_warning_letters($stud->student_id));
    //     $email_content = $this->email_content($stud->student_id, 1);
    //     $template = $this->email_template($email_content['content'], $email_content['title']);
    //     $date_now = Carbon::now()->format('Y-m-d');
    //     // dump($email_content);
    //     $status = null;
        
    //     // dump($email_content['email']);
    //     // magsend lang if naay course na studying international for payments warning letter
    //     if($email_content['course'] != null && $stud->type->type == 'International'){
    //       // dump($stud);
    //       // dump($email_content);
    //       // dump($email_content['email']);
    //       if($email_content['email'] != '' || $email_content['email'] != null){
    //         $send = $this->mailer($email_content, $template);
    //         $send = json_decode($send, true);
    //         $sentTo = [
    //           'student_id'  => $stud->student_id,
    //           'type'        => $stud->type->type,
    //           'email'       => $email_content['email'],
    //           'status'      => $send['status']
    //         ];
    //         dump($sentTo);
    //       // dump($stud->type->type);
    //       // return $status;
    //       }
          
    //     }

        
        
    //   }

    //   return json_encode(['status' => 'success']);
      
    // }


    // manual sending
    public function send_email_warnings($student_id, $emailTemp_id){

      $email_content = $this->email_content($student_id, $emailTemp_id);
      $template = $this->email_template($email_content['content'], $email_content['title']);
      $date_now = Carbon::now()->format('Y-m-d');
      $sched = Automation::where('type', 'email-warning-fees')->first();
      $config_emails = explode(',', preg_replace('/\s+/', '', $sched->emails));
      // dump($config_emails);
      // dd($email_content);
      // dd($template);
      
      // magsend lang if naay course na studying
      if($email_content['course'] != null){
        return $this->mailer($email_content, $template, $config_emails);
      }else{
        return json_encode(['status' => 'notStudying']);
      }

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


    public function view_email_warnings($student_id, $emailTemp_id){
        // dump($emailTemp_id);
        // dump($student_id);
        $email_content = $this->email_content($student_id, $emailTemp_id, true);
        // dump($email_content);
        $content = $email_content['content'];
        $title = $email_content['title'];
        $subject = $email_content['subject'];

        $pdf = '100%';
        $html = $this->email_template($content, $subject, $pdf);
        // dd($html);
        return \PDF::loadHTML($html)->setPaper(array(0, 0, 695, 942), 'portrait')->stream('warning-letter.pdf');
    }
    

    public function email_content($student_id, $emailTemp_id, $pdf_view = null){

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
        $funded_course = $funded_student->course->whereIn('status_id', [2,3])->first();
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
        $int_course = $data->course_details->whereIn('status_id',[2, 3])->first();

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
      if($payment_sched->count() > 0){
        foreach($payment_sched as $key => $ps){
          if($ps->due_date != null){
            $z = Carbon::parse($ps->due_date)->format('Y-m-d');
            if($z == $date_now){
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
      $third_sent = null;

      if($latest_warning_trail != null){
        // status 0 means current set of warning letter
        $all_warning_trail = EmailWarningTrail::where('student_id', $student_id)->where('status_id', 0)->get();
        foreach($all_warning_trail as $awt){
          // 2nd and cancellation warning letter
          $warning_type = $latest_warning_trail->email_template_type;
          // dump($warning_type);
          if($awt->email_template_type == 'first-warning'){
            $date_first_sent = $awt->where('email_template_type', 'first-warning')->first();
            $first_sent = $date_first_sent->date_sent;
          }else if($awt->email_template_type == 'second-warning'){
            $date_second_sent = $awt->where('email_template_type', 'second-warning')->first();
            $second_sent = $date_second_sent->date_sent;
          }else if($awt->email_template_type == 'notification-of-intention-to-report'){
            $date_third_sent = $awt->where('email_template_type', 'notification-of-intention-to-report')->first();
            $third_sent = $date_third_sent->date_sent;
          }
        }
      }
      // dump($second_sent);
      // dump($latest_payment);
      // dd($latest_warning_trail);
      $et = EmailTemplate::with('email_module')->get();
      $first_warning = $et->where('email_type', 'first-warning')->first();
      $second_warning = $et->where('email_type', 'second-warning')->first();
      $intention_to_report = $et->where('email_type', 'notification-of-intention-to-report')->first();
      $cancel_warning = $et->where('email_type', 'cancellation')->first();
      $other_templates = $et->where('id', $emailTemp_id)->first();
      // dd($pdf_view);
      // Get email template
      if($expected_bal < $actual_bal && $pdf_view == null){
        if($first_sent == null){

          if($emailTemp_id == 1){
            $email_template = $first_warning;
          }else{
            $email_template = $other_templates;
          }

        }else if($first_sent != null && $second_sent == null){

          // $fds = new Carbon($first_sent);
          // $sds = $fds->addDays(7)->format('Y-m-d');
          //$date_now >= $sds && $first_sent > $latest_payment
          if(isset($latest_payment)){
            if($first_sent > $latest_payment){
              $email_template = $second_warning;
            }
          }else if($expected_bal < $actual_bal){
            $email_template = $second_warning;
          }else{
            $email_template = $other_templates;
          }
          
        }else if($first_sent != null && $second_sent != null){

          // $sds = new Carbon($second_sent);
          // $sds = $sds->addDays(20);
          //$date_now >= $sds && $second_sent > $latest_payment
          // if(isset($latest_payment)){
          //   if($second_sent > $latest_payment){
          //     $email_template = $cancel_warning;
          //   }
          // }else if($expected_bal < $actual_bal){
          //   dump('dasdsadas');
          //   $email_template = $cancel_warning;
          // }else{
          //   $email_template = $other_templates;
          // }

          if(isset($latest_payment)){
            if($second_sent > $latest_payment){
              $email_template = $intention_to_report;
            }
          }else if($expected_bal < $actual_bal){
            $email_template = $intention_to_report;
          }else{
            $email_template = $other_templates;
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
          }else{
            $email_template = $other_templates;
          }
        }

      }if($pdf_view == true){
        $email_template = $other_templates;
      }else {
        $email_template = $other_templates;
      }
      // if($latest_warning_trail == null){
      //   // first-warning or other email templates
      //   //Except 2nd and cancellation warning letter
      //   $email_template = EmailTemplate::with('email_module')->where('id', $emailTemp_id)->first();

      // }else if($latest_warning_trail != null){
      //   $all_warning_trail = EmailWarningTrail::where('student_id', $student_id)->get();

      //   foreach($all_warning_trail as $awt){
      //     $date_first_sent = $awt->where('email_template_type', 'first-warning')->first();
      //     $date_second_sent = $awt->where('email_template_type', 'second-warning')->first();

      //     if($date_first_sent != null){
      //       $first_sent = $date_first_sent->date_sent;
      //     }

      //     // 2nd and cancellation warning letter
      //     $warning_type = $latest_warning_trail->email_template_type;

      //     if($warning_type == 'first-warning'){
      //       $email_template = $second_warning;
            
      //     }else if($warning_type == 'second-warning'){
      //       $second_sent = $date_second_sent->date_sent;
      //       $email_template = EmailTemplate::with('email_module')->where('name', 'cancellation')->first();
      //     }else {
      //       $email_template = EmailTemplate::with('email_module')->where('id', $emailTemp_id)->first();
      //     }

      //   }
      // }else{
      //   $email_template = EmailTemplate::with('email_module')->where('id', $emailTemp_id)->first();
      // }
      // dump($date_first_sent);
      // dump($date_second_sent);
      // dd($email_template);

      // foreach($e_warning_trail as $key => $ew_trail){
      //   $trail = $ew_trail->where('')
      // }
      // dump($e_warning_trail);
      // if($){

      // }
      // dump($emailTemp_id);
      // dd($email_template);

      
      // when email type is "intention_to_report", get date to pay overdue fees
      // cancellation will be sent 20days after "intention_to_report" was sent so "to_pay_overdue_fees" will be 15day?
      $to_pay_overdue_fees = null;
      if($email_template->email_type == 'intention_to_report'){
        $to_pay_overdue_fees = Carbon::parse($date_now)->addDays(15)->format('Y-m-d');
      }


      // get other types of warning letter here base dd($email_template);
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
        // studentID,firstname,lastname,course,courseFee,address,firstWarningSent,secondWarningSent,payOverdueDate
        // dump($fields);
        // dd($value);
        $content = str_replace($fields, $value, $email_template->email_content);
        $title = $email_template->name;
        $subject = $email_template->email_subject;

        $data = [
          'student_details'   => $student_details,
          'emailTemp_id'      => $email_template->id,
          'title'             => $title,
          'email_type'        => $email_template->email_type,
          'subject'           => $subject,
          'content'           => $content,
          'course_code'       => $course_code,
          'course'            => $course,
          'email'             => $email,
          'first_date_sent'   => $first_sent,
          'second_date_sent'  => $second_sent,
          'third_date_sent'   => $third_sent,
          'to_pay_overdue_fees' => $to_pay_overdue_fees,
          // 'balance'           => $balance,
          'expected_balance'  => $expected_bal,
          'actual_balance'    => $actual_bal,
          'due_date'          => $due_date,
          'latest_payment'    => isset($latest_payment->payment_date) ? $latest_payment->payment_date : null
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
                         <p style="text-align: center;font-size: 9px;">© VORX 2020</p>
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
