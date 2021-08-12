<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
// use App\r;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
// use App\Models\Email;
// use App\Models\Departments;
use App\Models\Student\Party;
use App\Models\Student\Person;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use \DB;
use PHPMailer\PHPMailer\PHPMailer;
use Validator;
use \Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('party.person')->role('Demo')->get();

        return response()->json($users, 200);
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

        $request->request->add(['username' => $this->generate_username(), 'password' => $this->generate_password(10)]);

        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'errors', 'errors' => $validator->messages()]);
        }

        try {
            DB::beginTransaction();
            // new instance of Party Model
            $party = new Party;
            // new instance of Person Model
            $person = new Person;
            // new instance of User Model
            $user = new User;

            $party->fill([
                'party_type_id'    => 1,
                'name'          => preg_replace('/\s+/', ' ', $request->firstname . ' ' . $request->lastname)
            ]);
            $party->save();

            $person->fill([
                'person_type_id' =>  1,
                'firstname'   => $request->username,
                'lastname'    => 'User',
            ]);
            $person->party()->associate($party);
            $person->save();


            $password = Hash::make($request->password);
            $user->fill([
                'username'      => $request->username,
                'password'      => $password,
                'is_active'     => 1,
                'profile_image' => 'default-profile.png'
            ]);
            $user->party()->associate($party);
            $user->save();

            $user->assignRole('Demo');


            DB::commit();


            $send = $this->sendEmail($request);


            if ($send == 1) {
                $this->request_for_demo_send($request);
                return response()->json(['data' => $request->all(), 'status' => 'success'], 200);
            } else {
                return response()->json(['msg' => 'email was not sent', 'status' => 'error'], 200);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            dd($e->getMessage());

            // return to previous page with errors
            // return back()->withInput()->withErrors(['status'=>'error', 'message' => $e->getMessage()]);//
        }

        return response()->json($request->all(), 200);
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

    public function generate_username()
    {
        $username = 'demo' . rand(10, 999);
        if (User::where('username', $username)->first()) {
            $this->generate_username();
        } else {
            return $username;
        }
    }

    public function generate_password($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function sendEmail($request)
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

        $mail->setFrom('request@vorx.com.au', 'VORX Team');

        // $mail->addAddress($email_content['email']);
        $mail->addAddress($request->email);
        // $mail->addAddress($agent->email->email);

        // $mail->addBcc('admin1@eti.edu.au');
        // $mail->addBcc('xyshain@gmail.com');
        // $mail->addBcc('Elitetrainingoffice@gmail.com');

        // $mail->addCc('admission@eti.edu.au');     // Add a recipient

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Request Demo Logins';
        $mail->Body    = $this->email_template($request);
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

    public function request_for_demo_send($request)
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

        $mail->setFrom('request@vorx.com.au', 'VORX Team');

        // $mail->addAddress($email_content['email']);
        $mail->addAddress('contact@vorx.com.au');
        // $mail->addAddress($agent->email->email);

        // $mail->addBcc('admin1@eti.edu.au');
        // $mail->addBcc('xyshain@gmail.com');
        // $mail->addBcc('Elitetrainingoffice@gmail.com');

        // $mail->addCc('admission@eti.edu.au');     // Add a recipient
        $content = '';
        foreach ($request->all() as $k => $v) {
            if ($k != 'undefined') {
                $content .= $k . ' : ' . $v . '<br>';
            }
        }


        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Client Request for a Demo';
        $mail->Body    = $content;
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

    public function email_template($data, $pdf = null, $date = null)
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
                          <h1 style="font-weight: bold;font-size: 16px;text-align: center;text-decoration: underline;">Request Demo Logins</h1>
                          <br>
                         <p style="text-align:justify;">Dear ' . $data->fullname . ',<br><br> Thank you for submitting your request.  <br><br>Your demo log ins are as follows: <br><br> URL: <a href="https://demo.vorx.com.au/" target="_blank">https://demo.vorx.com.au/</a> <br> Username: ' . $data->username . ' <br> Password: ' . $data->password . '<br><br>For further advice please tell us more about your organisation:<br></p><ul><li> Things you would like to accomplish with our system</li><li>Number of users</li></ul><p style="text-align:justify;">Learn more and check our video tutorial:<br></p><ul><li><a href="https://vorx.com.au/#tutorial" target="_blank">https://vorx.com.au/#tutorial</a></li><li><a href="https://www.youtube.com/watch?v=xOMBDVOpHJU&feature=youtu.be" target="_blank">https://www.youtube.com/watch?v=xOMBDVOpHJU&feature=youtu.be</a></li></ul><p style="text-align:justify;">We then have excellent in-depth free live demo sessions via ZOOM<br><br><b>Our Team Are Within Reach</b><br>Connect with our professional account experts and more how we can assist you with your business.<br>Talk to us through phone, online or see us on site.</p>
                         <p style="text-align:justify;">Warm regards,<br>VORX Team</p>
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
