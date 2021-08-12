<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
use Auth;
use DB;
use Carbon\Carbon;
use PHPMailer\PHPMailer\PHPMailer;
use File;

use App\Models\Student\Student;
use App\Models\FundedStudentCourse;
use App\Models\FundedStudentCourseDetail;
use App\Models\FundedStudentContactDetails;
use App\Models\StudentInvoice;
use App\Models\TrainingOrganisation;
use App\Models\TrainingOrgBankDetails;
use App\Models\PaymentScheduleTemplate;
use App\Models\Course;
use App\Models\Unit;
use App\Models\Student\OfferLetter\OfferLetter;
use App\Models\StudentCompletion as CourseCompletion;
use App\Models\StudentCompletionDetail as CourseCompletionDetail;
use App\Models\EmailAutomation;


class StudentInvoiceController extends Controller
{
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

    public function createInvoice($invoice_details, $student_id, $invoice_num, $key)
    {
        $now = Carbon::now()->setTimezone('Australia/Melbourne');
        // $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $invoice_num = $this->generate_string($permitted_chars, 8); (naa sa offerletter)
        // $transaction_num = $this->generate_string($permitted_chars, 12);
        // dd($invoice_details);
        
        if(isset($invoice_details->offer_letter_course_detail_id) || $invoice_details->offer_letter_course_detail_id != null){
            $course_details = $invoice_details->course_detail->funded_course;
        }
        // dd($course_details);
        // elseif(isset($invoice_details->funded_student_course_id) || $invoice_details->funded_student_course_id != null){
        //     // data for domestic
        // }
        
        try {
            
            DB::beginTransaction();

            $student_invoice = StudentInvoice::where('student_id', $student_id)->where('course_code', $course_details->course_code)->where('payment_schedule_template_id', $invoice_details->id)->first();
            $keey = $key+1;
            if (!isset($student_invoice->id) && !isset($student_invoice->payment_schedule_template_id)) {

                $stud_invoice = new StudentInvoice;
                $stud_invoice->fill([
                    'student_id'            => $student_id,
                    'course_code'           => $course_details->course_code,
                    'invoice_number'        => $invoice_num,
                    // 'transaction_number'    => $transaction_num,
                    'amount'                => $invoice_details->payable_amount,
                    // 'items'                 => json_encode($invoice_details['unitList']),
                    // 'date'                  => Carbon::parse($invoice_details->date_created)->format('Y-m-d'),
                    'date'                  => null,
                    'due_date'              => Carbon::parse($invoice_details->due_date)->format('Y-m-d'),
                    'user_id'               => \Auth::user() != null ? Auth::user()->id : 1,
                    'description'           => 'Installment ' .$keey,
                ]);
                $stud_invoice->payment_template()->associate($invoice_details->id);
                $stud_invoice->save();

                DB::commit();
            } else {
                    $student_invoice->update([
                        'amount'                => $invoice_details->payable_amount,
                        // 'items'                 => json_encode($invoice_details['unitList']),
                        'date'                  => null,
                        'due_date'              => Carbon::parse($invoice_details->due_date)->format('Y-m-d'),
                        'user_id'               => \Auth::user() != null ? Auth::user()->id : 1,
                    ]);  
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();

            throw $th;
        }
    }

    public function generate_invoice($student_id, $payment_template_id){

        $student = Student::with(['party.person', 'type', 'funded_detail.contact'])->where('student_id', $student_id)->first();

        $course_units = null;
        $unit_list = [];
        $fee_per_unit = null;
        $page = 0;

        $student_invoice = StudentInvoice::where('payment_schedule_template_id', $payment_template_id)->first();
        $course_details = FundedStudentCourse::with('completion')->where('student_id', $student_id)->where('course_code', $student_invoice->course_code)->first();
        $course_name = Course::where('code', $student_invoice->course_code)->first();
        // dump($course_details);
        if($course_details != null){
            if (count($course_details->completion) != 0) {
                $com_id = $course_details->completion->where('course_code', $student_invoice->course_code)->first();
                // dd($com_id);
                $course_units = CourseCompletionDetail::where('student_completion_id', $com_id->id)->get();
                // dd($course_units);
                $fee_per_unit = round((int) $course_details->course_fee / count($course_units)) . '.00';
    
                foreach ($course_units as $cu) {
                    $unit = Unit::where('code', $cu->course_unit_code)->first();
                    $unit_list[] = [
                        'unit'          => $unit->code . ' ' . $unit->description,
                        'fee_per_unit'  => $fee_per_unit
                    ];
                }
            }
        

        $invoice_details = [];
        $invoice_details = [
            'id'                => $course_details->id,
            'student_id'        => $student_id,
            'fullname'          => $student->party->name,
            'course_code'       => $course_details->course_code,
            'course'            => $course_details->course_code == '@@@@' ? 'Unit of Competency' : $student_invoice->course_code . ' ' . '-' . ' ' . $course_name->name,
            'course_fee_type'   => $course_details->course_fee_type,
            'course_fee'        => $course_details->course_fee,
            'fee_per_unit'      => $fee_per_unit,
            'invoice_number'    => $student_invoice->invoice_number,
            'date_created'      => $student_invoice->date,
            'date'              => Carbon::parse($student_invoice->due_date)->subDays(3),
            'due_date'          => $student_invoice->due_date,
            // 'due_date'          => $student_invoice->due_date,
            'description'       => $student_invoice->description,
            'course_units'      => $course_units,
            'amount'            => $student_invoice->amount,
            'unitList'          => $unit_list,
        ];
        // dd($invoice_details);

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
        
        $unit_lists = [];
        if($student_invoice->items != null){
            $invoice_items = json_decode($student_invoice->items, true);
            if (count($invoice_items) > 25) {
                $unit_lists = array_chunk($invoice_items, 25);
                $page = count($unit_lists);
            } else {
                $unit_lists[0] = $invoice_items;
                $page = 1;
            }
        }

        $file_path = '';
        $pdf_file = null;
        $file_path = storage_path() . '/app/public/student/invoice/' . $student_id. '/'.$student_invoice->course_code;

        if (!File::isDirectory($file_path)) {
            File::makeDirectory($file_path, 0777, true, true);
        }

        $hashFileName = $student_invoice->description.' - '.'Invoice';
        $pdf_file = \PDF::loadView($com_setting->custom_invoice, compact('student_invoice', 'invoice_details', 'com_setting', 'logo_url', 'bank_details', 'unit_lists', 'page'))->setPaper(array(0, 0, 595, 842), 'portrait')->save($file_path.'/'. $hashFileName . '.pdf');


        $file_name = $student->party->name . ' ' . '-' . ' ' . 'Invoice' . '.pdf';
        return \PDF::loadView($com_setting->custom_invoice, compact('student_invoice', 'invoice_details', 'com_setting', 'logo_url', 'bank_details', 'unit_lists', 'page'))->setPaper(array(0, 0, 595, 842), 'portrait')->stream($file_name);
        }
    }

    public function send_invoice(){

        $now = Carbon::now()->setTimezone('Australia/Melbourne');
        $student_invoice = StudentInvoice::whereNull('date')->get();
        $org = TrainingOrganisation::first();

        foreach($student_invoice as $key => $inv){
            
            // $subbed_date = $now; //test
            $subbed_date = Carbon::parse($inv->due_date)->subDays(3);
            $emailsTo = [];
            if($subbed_date == $now){
                // dd('yeah send');
                $stud = Student::with(['party.person', 'type','funded_detail.contact'])->where('student_id', $inv->student_id)->first();
                $course = Course::where('code', $inv->course_code)->first();
                $course_name = $inv->course_code == '@@@@' ? 'Unit of Competency' : $inv->course_code . ' ' . '-' . ' ' . $course->name;
                
                
                if($stud->type->type == 'International'){
                    $offerletter = OfferLetter::with(['student_details'])->where('student_id', $inv->student_id)->first();
                    $contact = $offerletter->student_details;
                    if(!in_array($contact->email_personal, ['', null])){
                        $emailsTo[] = $contact->email_personal; 
                    }
                }else{
                    $contact = $stud->funded_detail->contact;
                    if(!in_array($contact->email, ['', null])){
                        $emailsTo[] = $contact->email; 
                    }
                    if(!in_array($contact->email_at, ['', null])){
                        $emailsTo[] = $contact->email_at; 
                    }
                    
                }

                $due_date = Carbon::parse($inv->due_date)->format('d/m/Y');
                $content = '<b>Dear '.$stud->party->name.',</b><br><br>Please see attached invoice for '.$course_name.'. Kindly settle amount due on or before '.$due_date.'. Once payment is done, please send us receipt copy.<br><br>Should you have doubts or clarifications, please let us know.<br><br>Regards,<br>PCA Team';
                $emailsBcc = EmailAutomation::where('addOn', 'invoice')->pluck('email');

                // get attachment
                $file_path = '';
                $attachment_path = [];
                if($inv->description != null){
                    // storage\app\public\student\invoice\VRX00012\Installment 1 - invoice.pdf
                    $file_path = storage_path() . '/app/public/student/invoice/' .  $inv->student_id. '/'.$inv->course_code;
                    $attachment_path[] = [
                        'path' => $file_path.'/'.$inv->description.' - '.'Invoice'.'.pdf',
                        'name' => $inv->description.' - '.'Invoice'.'.pdf',
                    ];
                }

                $send = $this->send_automate('PCA Invoice', $content, ['Phoenix College of Australia' => $org->email_address], $emailsTo, $attachment_path, $emailsBcc);
                if($send['status'] == 'success'){
                    // update date send 
                    $inv->update([
                        'date'    => $now->format('Y-m-d'),
                    ]);
                    return ['status' => 'success'];
                }else{
                    return ['status' => 'error', 'message' => 'Something went wrong.'];
                }
            }
            // else{
            //     // dd('nothing to send :) ');
            //     abort(404);
            // }
           
        }
       

    }
    public function send_automate($subject, $content, $emailFrom, $emailsTo, $paths = [], $emailsBcc = [])
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
        $mail->Host = "mail.vorx.com.au";
        $mail->Username = "request@vorx.com.au";
        $mail->Password ="9}9jgR(~Y^Tp";
        $mail->SMTPSecure = 'tls';                                      // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                              // TCP port to connect to

        // dump(env("MAIL_HOST"));
        // dump(env("MAIL_USERNAME"));
        // dd(env("MAIL_PASSWORD"));

        // $mail->Host = env("MAIL_HOST");
        // $mail->Username = env("MAIL_USERNAME");
        // $mail->Password = env("MAIL_PASSWORD");
        // $mail->SMTPAutoTLS = true;
        // $mail->SMTPSecure = 'tls';                                      // Enable TLS encryption, `ssl` also accepted
        // $mail->Port = env("MAIL_PORT", 587);                                              // TCP port to connect to
        // $mail->SMTPDebug = 1;                                           // Enable SMTP authentication

        if(is_array($emailFrom)){
          $mail->setFrom($emailFrom[array_keys($emailFrom)[0]], array_keys($emailFrom)[0]);
        }else{
          $mail->setFrom($emailFrom);
        }

        // $mail->addAddress($email_content['email']);
        // $mail->addAddress('contact@vorx.com.au');
        // $mail->addAddress($agent->email->email);

        foreach($emailsTo as $v){
            $mail->addAddress($v);
        }

        if(count($emailsBcc) > 0){
          foreach($emailsBcc as $v){
            $mail->addBcc($v);
          }
        }

        // -------------------------------------------------
        //  NOTE : $paths format [[ 'path' => '', 'name' => '']]
        // -------------------------------------------------

        if(count($paths) > 0){
          foreach($paths as $v){
              if(isset($v['name'])){
                $mail->addAttachment($v['path'], $v['name']);
              }else{
                $mail->addAttachment($v['path']);
              }
          }
        }

        // $mail->addBcc('admin1@eti.edu.au');
        // $mail->addBcc('xyshain@gmail.com');
        // $mail->addBcc('Elitetrainingoffice@gmail.com');
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
        // dd($mail);
        // dd(\Auth::user()->id);
        if (!$mail->send()) {
            // return back()->withInput()->withErrors(['status' => 'error', 'message' => 'Email was not sent...']);
            // dump($mail->ErrorInfo);
            return json_encode(['status' => 'error', 'msg' => $mail->ErrorInfo]);
        } else {
            // dd('sent');
            // $mail->copyToFolder("Sent");

            return ['status' => 'success'];
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
        $org = TrainingOrganisation::first();
        if($org && !in_array($org->logo_img, ['', null])){
          $logo = 'storage/config/images/'.$org->logo_img;
        }else{
          $logo = 'images/logo/vorx_logo.png';
        }
        $logo_url = url('/' . $logo . '');


        return '<!DOCTYPE html>
                <html lang="en">
                  <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title>'.$subject.'</title>
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
}
