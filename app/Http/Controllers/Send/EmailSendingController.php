<?php

namespace App\Http\Controllers\Send;

use App\Http\Controllers\Controller;
use App\Models\TrainingOrganisation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;

class EmailSendingController extends Controller
{
    //
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
        $mail->Username = "collection@vorx.com.au";
        $mail->Password ="@YUo]csl8QW%";
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

        // foreach($emailsTo as $v){
        //     $mail->addAddress($v);
        // }

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
        
        
        foreach($emailsTo as $v){
          $mail->addAddress($v);
          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = $subject;
          $mail->Body    = $cntnt;
          // dd($mail);
          // dd(\Auth::user()->id);
          if (!$mail->send()) {
              // return back()->withInput()->withErrors(['status' => 'error', 'message' => 'Email was not sent...']);
              // dump($mail->ErrorInfo);
              return json_encode(['status' => 'error', 'msg' => $mail->ErrorInfo]);
          }
          $mail->ClearAllRecipients(); // clear other recipients/to:
          // else {
          //     // dd('sent');
          //     // $mail->copyToFolder("Sent");
              
          //     // return ['status' => 'success'];
          // }
        }
        
        return ['status' => 'success'];
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

        $org_name = !in_array($org->training_organisation_name, ['',null]) ? $org->training_organisation_name : 'VORX';


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
                          <img src="' . asset($logo_url) . '" style="margin: 0 auto;display: block; width: 180px;">
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
                         <p style="text-align: center;font-size: 9px;">© '.$org_name.' 2020 </p>
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
