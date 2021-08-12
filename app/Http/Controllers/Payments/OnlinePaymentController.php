<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Send\EmailSendingController;
use App\Models\EmailAutomation;
use App\Models\User;
use App\Models\Student\Student;
use App\Models\TrainingOrganisation;
use Illuminate\Http\Request;
use Stripe;
use Session;
use Validator;
use Auth;
use File;
use Carbon\Carbon;

use App\Models\FundedStudentContactDetails;
use App\Models\FundedStudentCourse;
use App\Models\StripePayment;
use App\Models\StripeCustomer;
use App\Models\Student\OfferLetter\OfferLetter;
use App\Models\OnlinePayment;
use App\Models\FundedStudentPaymentDetails;
use App\Models\Party;

class OnlinePaymentController extends Controller
{
    public function __construct(){
        // $this->middleware('auth');
    }

    public function stripe($id){
        $funded_student_course_id = base64_decode($id);
        // dd($funded_student_course_id);
        $funded_student_course = FundedStudentCourse::with('payment_details','payment_sched')->where('id',$funded_student_course_id)->first();
        // dd($funded_student_course);
        $student_details = OfferLetter::with('student_details','student.party.person')->where('student_id',$funded_student_course->student_id)->first();
        $total_payment = 0;
        $total_due = 0;
        // dd($funded_student_course->payment_sched);
        foreach($funded_student_course->payment_details as $pd){
            if(count($funded_student_course->payment_details)>0){
                $total_payment += $pd->amount;
            }
        }
        // dd($total_payment);
        foreach($funded_student_course->payment_sched as $ps){
            $total_due += $ps->payable_amount;
        }
        // dd($total_due);
        $remaining_balance = $total_due - $total_payment;
        // dd($remaining_balance);

        $user = User::where('username',$funded_student_course->student_id)->first();
        // dd($user);
        \JavaScript::put([
            'payment_data'=> $funded_student_course,
            'student_details'=>$student_details,
            'user_id'=>$user->id,
            'remaining_balance'=>$remaining_balance
        ]);
        return view('student_portal.online-payment');
    }

    public function stripe_checkout(Request $request){
        // $send = new EmailSendingController;
        $training_org = TrainingOrganisation::first();
        // dd($request->all());
        $validator = Validator::make($request->all(),[
                "name_on_card" => "required",
        ]);

        if($validator->fails()){
            return response()->json(['status' => 'error', 'errors' => $validator->messages()]);
        }
        // dd($request->all());
        // try{
            // $customer_id = $this->getCus();
            // dd($customer_id);
            $charge = Stripe::charges()->create([
                'currency'=>'aud',
                'amount'=>$request->amount,
                'source'=>$request->stripe_token,
                'description'=>'description goes here',
            ]);
            if(isset($charge)){
                $charge_id = $charge['id'];
                
                $stripe_payment = new StripePayment;
                $stripe_payment->firstname = $request->firstname;
                $stripe_payment->lastname = $request->lastname;
                $stripe_payment->address = $request->full_addres;
                $stripe_payment->postcode = $request->postal_code;
                $stripe_payment->receipt_email = $request->receipt_email;
                $stripe_payment->contact_no = $request->phone;
                $stripe_payment->currency = 'aud';
                $stripe_payment->amount = $request->amount;
                $stripe_payment->name_on_card = $request->name_on_card;
                
                $stripe_payment->save();

                $funded_student_payment = new FundedStudentPaymentDetails;
                $funded_student_payment->student_id = Auth::user()->username;
                $funded_student_payment->student_course_id = $request->funded_course_id;
                $funded_student_payment->offer_letter_course_detail_id = $request->offer_letter_course_detail_id;
                $funded_student_payment->stripe_payments_id = $stripe_payment->id;
                $funded_student_payment->customer_id = $request->customer_id;
                $funded_student_payment->transaction_code = $charge_id;
                $funded_student_payment->note = 'Stripe Online Payment';
                $funded_student_payment->payment_date = now();
                $funded_student_payment->amount = $request->amount;
                $funded_student_payment->payment_method_id = 6; //Online payments
                $funded_student_payment->user_id = Auth::user()->id;
                $funded_student_payment->save();
                
                

                // $subject = 'Online Payment - '.$training_org->student_id_prefix;
                // $content = 'test payment';
                // $from = [$training_org->training_organisation_name=>$training_org->email_address];
                // $email_to = [$request->receipt_email];
                
                
                
                // $send = $this->send_receipt($funded_student_payment->id);
                
                // dd($send);
                // dd($if_sent);

                $funded_student_course = FundedStudentCourse::with('payment_details','payment_sched')->where('id',$request->funded_course_id)->first();
                
                $total_payment = 0;
                $total_due = 0;
                foreach($funded_student_course->payment_details as $pd){
                    if(count($funded_student_course->payment_details)>0){
                        $total_payment += $pd->amount;
                    }
                }
                // dd($total_payment);
                foreach($funded_student_course->payment_sched as $ps){
                    $total_due += $ps->payable_amount;
                }

                $remaining_balance = $total_due - $total_payment;
                
                return response()->json(['status'=>'success','message'=>'Thank you! Your payment has been accepted','remaining_balance'=>$remaining_balance]);
                
                // if($send['status']=='success'){
                //     return response()->json(['status'=>'success','message'=>'Thank you! Your payment has been accepted','remaining_balance'=>$remaining_balance]);
                // }
            }

        // } catch (\Throwable $th) {
        //     //throw $th;
        //     return back()->with(['status'=>'error','errors'=>$th]);
        // }
    }

    public function getCus($student_id){
        $customer_id = 'cus_'.$student_id;
        $stripe_cus = StripeCustomer::where('student_id',$student_id)->first();
        $student_details = FundedStudentCourse::with('student.party.person','student.contact_detail')->where('student_id',$student_id)->first();
        // return $student_details;
        // dd($request->receipt_email);
        
        if(isset($stripe_cus)){
            return $stripe_cus->customer_id;
        }else{
            $customer = Stripe::customers()->create([
                'name'=>$student_details->student->party->name,
                'email'=>$student_details->student->contact_detail->email,
                'phone'=>$student_details->student->contact_detail->phone_mobile
            ]);

            $sc = new StripeCustomer;
            $sc->student_id = $student_id;
            $sc->customer_id = $customer['id'];
            $sc->save();

            return $sc->customer_id;
            // dd($customer);
        }
    }

    public function cust_id(){
        
    }

    public function stripePost(){
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => 100 * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com." 
        ]);
        
        // Session::flash('success', 'Payment successful!');
            
        return back();
    }
    
    public function payment_receipt($id){
        
        $fc = FundedStudentPaymentDetails::where('id', $id)->first();
        $path = storage_path() . '/app/public/student/receipt/' . $fc->student_id . '/online-payment-receipt-'.$id.'.pdf';
        
        if(file_exists($path)){
             // raw file contents
            $fileContent = File::get($path);
            return response($fileContent)->header('Content-Type', 'application/pdf');
        }else{
            // abort(403, 'No File Found.'); 
            // create and view if file not found
            $gr = $this->generate_reciept($fc);
            $fileContent = File::get($gr['path']);
            return response($fileContent)->header('Content-Type', 'application/pdf');
        }
    } 

    public function generate_reciept($payment_details)
    {

        $sd = Student::with('party.person','funded_course.course')->where('student_id', $payment_details->student_id)->first();
        $funded_course = null;
        if(count($sd->funded_course) > 0){
            foreach($sd->funded_course as $fc){
                if($payment_details->offer_letter_course_detail_id != null && $payment_details->offer_letter_course_detail_id == $fc->offer_letter_course_detail_id){
                    $funded_course = $fc; //Offerletter ID
                }elseif($payment_details->student_course_id != null && $payment_details->student_course_id == $fc->id){
                    $funded_course = $fc; //Fundedcourse ID
                }
            }
        }

        $to = TrainingOrganisation::first();
        $receiptDate = $payment_details->payment_date == null ? Carbon::now()->setTimezone('Australia/Melbourne')->format('d/m/Y') : Carbon::createFromFormat('Y-m-d', $payment_details->payment_date)->format('d/m/Y');
        $onlinePayment = 1;
        $path = storage_path('app/public/student/receipt/'.$payment_details->student_id);

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        \PDF::loadView('custom.pca.payment-receipt-pdf', compact('payment_details','funded_course','sd', 'to', 'receiptDate','onlinePayment'))->setPaper('A5', 'portrate')->save($path.'/payment-receipt-'.$payment_details->id.'.pdf')->stream('payment-receipt');
        

        return ['path' => $path . '/payment-receipt-'.$payment_details->id.'.pdf', 'name' => 'payment-receipt-'.$payment_details->id.'.pdf'];
    }

    public function send_receipt($id)
    {
        // dd($id);
        $payment_details = FundedStudentPaymentDetails::where('id', $id)->first();
        $sd = Student::with('party.person','funded_course.course','contact_detail','offer_letter','funded_detail')->where('student_id', $payment_details->student_id)->first();
        $student_detail = OfferLetter::with('student_details','student.party.person')->where('student_id',$payment_details->student_id)->first();
        
        
        $funded_course = null;
        if(count($sd->funded_course) > 0){
            foreach($sd->funded_course as $fc){
                if($payment_details->offer_letter_course_detail_id != null && $payment_details->offer_letter_course_detail_id == $fc->offer_letter_course_detail_id){
                    $funded_course = $fc; //Offerletter ID
                }elseif($payment_details->student_course_id != null && $payment_details->student_course_id == $fc->id){
                    $funded_course = $fc; //Fundedcourse ID
                }
            }
        }

        // email ray naglahi 
        $org = TrainingOrganisation::first();
        
        $email = $student_detail->student_details->email_personal?[$student_detail->student_details->email_personal]:[''];
        // dd($email);
        // dd($email);
        if(count($email) < 1){
            return ['status' => 'error', 'message' => 'Please provide student email'];
        }

        $send = new EmailSendingController;
        $admin_emails = EmailAutomation::where('addOn', 'payment_receipt')->pluck('email');

        $receipt = $this->generate_reciept($payment_details);
        if(isset($receipt['path'])){
            $paths[] = $receipt;
        }
        
        $content = 'Dear '.$sd->party->name.',<br><br>Greetings of the day from Phoenix College of Australia (PCA).<br><br>We confirm the receipt of <b>$'.$payment_details->amount.'</b> towards your fees for the course <b>'.$funded_course->course->code.' - '.$funded_course->course->name.'</b>. We would like to thank you for the payment.<br><br>Please see attached file for the pdf copy of the receipt.<br><br>Regards<br><b>Admin Team</b><br>Phoenix College of Australia<br>RTO NO 45633 CRICOS CODE 03871F <br><a href="http://phoenixcollege.edu.au/">http://phoenixcollege.edu.au/</a>';
        // dd($admin_emails);
        $s = $send->send_automate('Fees Receipt', $content, [$org->training_organisation_name => $org->email_address], $email, $paths, $admin_emails);
        //     // $s = $send->send_automate('CEA Enrolment Application', $content, ['Community Education Australia' => 'constant.claro@gmail.com'], ['konstant.claro@gmail.com']);

        if($s['status'] == 'success'){
            
            $pd = FundedStudentPaymentDetails::where('student_id', $payment_details->student_id)->where('id', $id)->first();
            if($pd){
                $pd->sent_receipt = 1;
                $pd->update();
            }

            return ['status' => 'success'];
        }else{
            return ['status' => 'error', 'message' => 'Something went wrong => send_receipt function'];
        }

        
    }
}
