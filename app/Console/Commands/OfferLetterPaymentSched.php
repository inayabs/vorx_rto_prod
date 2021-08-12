<?php

namespace App\Console\Commands;

use App\Models\OfferLetterPaymentSched as paymentsched;
use Carbon\Carbon;
use Illuminate\Console\Command;

class OfferLetterPaymentSched extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offerletter:paymentsched';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email for Payment schedule 3 days before';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        dump(Carbon::now());
        
        // ETI Offer letter - Payment schedule email sending.
        $datedie = Carbon::now()->addDays(3)->format('Y-m-d');
        $lists = paymentsched::with(['offer_letter'])->whereDate('due_date',$datedie)->get();
        
        foreach($lists as $list){

            $data = '<!DOCTYPE html>
                    <html lang="en">
                      <head>
                        <meta charset="utf-8">
                        <meta http-equiv="X-UA-Compatible" content="IE=edge">
                        <meta name="viewport" content="width=device-width, initial-scale=1">
                        <title>ETI Payment Receipt - Email Template</title>
                    <style type="text/css">
                      .no-padding {padding: 0;}
                      .no-margin {margin: 0;}
                      ul.rto-code {padding: none;text-align: center;margin-top: 15px;font-size: 14px;font-weight: bold;}
                      ul.rto-code li{list-style: none;display: inline;padding: 0 10px; border-right: 1px solid #363636;}
                       ul.rto-code li:last-child{border:0;}
                    </style>
                      </head>
                      <body  style="font-family: "Malgun Gothic", Arial, sans-serif; margin: 0; padding: 0; width: 100%; -webkit-text-size-adjust: none; -webkit-font-smoothing: antialiased; position: relative;">
                    <div class="main-wrapper" style="padding: 20px;">
                          <table class="table-responsive" align="center" width="800" style="box-shadow: 0px 0px 3px #cccccc;">
                          <tbody class="">
                            <tr>
                              <td colspan="2"><div class="clearfix" style="height:40px;"></div></td>
                            </tr>
                          <tr>
                            <td width="50%" style="padding-left: 60px;">
                              <img src="http://eti.edu.au/files/email/images/eti_coloredtext_new_logo.png" style="margin: 0 auto;display: block; width: 200px;">
                            </td>
                            <td style="font-size: 10px;padding-right: 60px;" width="50%">
                              <p class="no-margin">20, Otter Street, Collingwood VIC 3066</p>
                              <p class="no-margin">Phone: 03 9088 0255</p>
                              <p class="no-margin">National Provider Number: 40965</p>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2" style="padding: 0 60px;">
                              <ul class="rto-code ">
                                <li>RTO Provider No.  40965</li>
                                <li>CRICOS Code  03470A</li>
                                <li>Nationally Recognised Training</li>
                              </ul>
                              <div class="clearfix" style="height: 20px;"></div>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2" style="padding: 0 60px;">
                              <div class="title">
                                <!-- <h1 class="" style="color: #147347;font-size: 32px;text-align: center;margin: 30px 0;">Title Here</h1> -->
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td width="50%" style="padding-left: 60px;">

                              <p class="no-margin"style="font-size: 14px" >Dear,</p>
                              <p class="no-margin"style="font-size: 14px" >%name%</p>
                            </td>
                            <!-- <td width="50%" valign="top" class="no-padding" style="padding-right: 60px;text-align: right">
                              <p class="no-margin ">Dated: %date%</p>
                            </td> -->
                          </tr>
                          <tr>
                            <td colspan="2" style="font-size: 14px;padding: 0 60px;">
                              <div class="email-container">
                              <div class="clearfix"></div>
                                    <p style="font-size: 18px;">Thank you for enrolling to ETI Electronic Statements. We are sending your bill through your email.
                    </p>
                                    <div class="clearfix" style="height: 20px;"></div>
                                    <table width="100%" class="payment-receipt-table">
                                      <tr>
                                        <td width="25%">Account Name:</td>
                                        <td width="75%">%name%</td>
                                      </tr>
                                      <tr>
                                        <td>Student ID:</td>
                                        <td>%stud_id%</td>
                                      </tr>
                                       <tr>
                                        <td>Statement Date:</td>
                                        <td>%statement_date%</td>
                                      </tr>
                                      <tr>
                                        <td>Total Amount Due:</td>
                                        <td>AUD %amount_due%</td>
                                      </tr>
                                      <tr>
                                        <td>Due Date:</td>
                                        <td>%due_date%</td>
                                      </tr>
                                    </table>
                                  <p>This serves as your electronic receipt. You may keep this for your reference.</p>
                                  <p>Should you have any questions regarding this bill, please call our Customer Care 03 9088 0255 or email <a href="mailto:accounts@eti.edu.au.">accounts@eti.edu.au.</a></p>
                                  <p>Thank you for choosing ETI.</p>
                                  <div class="clearfix" style="height:50px;"></div>
                                  <p class="no-margin">Regards</p>
                                  <p class="no-margin">ETI Online Billing Administrator</p>
                                  <!-- <p class="no-margin">Elite Training Institute</p> -->
                                  <div class="clearfix" style="height:50px;"></div>
                                  <p class="no-margin">Disclaimer: *Please disregard this email if you have already settled your accounts for this month.</p>
                                  <p class="no-margin">** This is a system generated e-mail. Please do not reply.**</p>
                              </div>
                              <div class="clearfix" style="height:80px;"></div>
                              <div class="footer" style="text-decoration: underline;padding-bottom: 40px;">
                                <p class="no-margin"><a style="color: #78B526;">Unsubscibe</a></p>
                                <p class="no-margin"><a style="color: #78B526;">View this email on the web</a></p>
                                <p class="no-margin"><a style="color: #78B526;">www.eti.edu.au</a></p>
                              </div>
                            </td>
                          </tr>
                          </tbody>
                        </table>
                    </div>
                      </body>
                    </html>';

            dump($list->offer_letter->firstname.' '.$list->offer_letter->lastname);

            $email = $list->offer_letter->email;
            $name = $list->offer_letter->firstname.' '.$list->offer_letter->lastname;
            $stud_id = $list->offer_letter->student_id;
            $statement_date = Carbon::now()->format('d/m/Y');
            $amount_due = $list->payable_amount;
            $due_date = $list->due_date;
            $data = str_replace('%name%',$name,$data);
            $data = str_replace('%stud_id%',$stud_id,$data);
            $data = str_replace('%statement_date%',$statement_date,$data);
            $data = str_replace('%date%',$statement_date,$data);
            $data = str_replace('%amount_due%',$amount_due,$data);
            $data = str_replace('%due_date%',Carbon::parse($due_date)->format('d/m/Y'),$data);
            $mailer = new \Mailer;
                $mailer->isSMTP();
                $mailer->SMTPOptions = array(
                    'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                );                                                // Set mailer to use SMTP
                $mailer->Host = env('MAIL_HOST');                                 // Specify main and backup SMTP servers
                $mailer->SMTPAuth = true;
                $mailer->Username = env('MAIL_USERNAME');                           // SMTP username
                $mailer->Password = env('MAIL_PASSWORD');                                 // SMTP password    k
                // $mail->SMTPAutoTLS = true;
                $mailer->SMTPSecure = 'tls';                                      // Enable TLS encryption, `ssl` also accepted
                $mailer->Port = 587;                                              // TCP port to connect to
                // $mail->SMTPDebug = 1;                                           // Enable SMTP authentication

                $mailer->setFrom(env('MAIL_USERNAME'));
                $mailer->addAddress($email);     // Add a recipient
                // $mailer->addAddress();     // Add a recipient
                $mailer->addBcc('caloy@eti.edu.au');     // Add a recipient
                $mailer->addBcc('niwang101@gmail.com');     // Add a recipient
                $mailer->addBcc('accounts@eti.edu.au');     // Add a recipient
                $mailer->isHTML(true);                                  // Set email format to HTML
                $mailer->Subject = 'ETI Electronic Statement due on '.Carbon::parse($due_date)->format('d/m/Y');
                $mailer->Body    = $data;
                 if(!$mailer->send()) {
                    dump($mailer->ErrorInfo);
                } else {
                  // $mailer->copyToFolder("Sent");
                    // return redirect()->route('deals.index')->with('message', 'Email sent successfully!');
                    // dd('success');
                 }
        }
        
    }
}
