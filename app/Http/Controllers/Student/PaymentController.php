<?php

namespace App\Http\Controllers\Student;

use Auth;
use DB;

use Omnipay\Common\CreditCard;
use Omnipay\Omnipay;
use App\Models\Student\Student;
use Validator;
use Carbon\Carbon;
use App\Models\CashPayment;
use App\Models\OnlinePayment;
use App\Models\OfferLetterFee;
use App\Models\PaymentScheduleDetail;
use App\Models\AgentDetail;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Send\EmailSendingController;
use App\Models\EmailAutomation;
use App\Models\OfferLetterCourseDetail;
use App\Models\PaymentScheduleTemplate;
use App\Models\FundedStudentPaymentDetails;
use App\Models\EmailWarningTrail;
use App\Models\PaymentAttachment;
use App\Models\TrainingOrganisation;
use App\Models\Notification;

use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('checkModule:payments');
        return $this->middleware('auth');
    }
    public function generate_string($input = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', $strength = 16)
    {
        $input_length = strlen($input);
        $random_string = '';

        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        $validate = CashPayment::where('trxn_code', $random_string)->first();

        if ($validate) {
            $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $this->generate_string($permitted_chars, 12);
        } else {
            return $random_string;
        }
    }

    public function nab_trans($data)
    {


        $gateway = Omnipay::create('NABTransact_SecureXML');

        $gateway->setMerchantId('6WZ0010'); //XYZ0010
        $gateway->setTransactionPassword('abc123'); //abcd1234

        $gateway->setTestMode(true);

        $card = new CreditCard([
            'firstName'   => $data['firstname'],
            'lastName'    => $data['lastname'],
            'number'      => $data['card_number'],
            'expiryMonth' => $data['month'],
            'expiryYear'  => $data['year'],
            'cvv'         => $data['cvv'],
            'email'       => $data['email'],
        ]);


        $response = $gateway->purchase([
            'amount'        => $data['amount'],
            'transactionId' => $data['trxn_id'],
            'currency'      => 'AUD',
            'card'          => $card,
        ])->send();


        return $response;
    }

    public function store_online(Request $request)
    {

        $student = Student::where('student_id', $request->student_id)->first();
        $firstname = $student->party->person->firstname;
        $lastname = $student->party->person->lastname;
        $email = $student->latest_offer_letter->student_details->email_personal;

        $card_details = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'card_number' => $request->card_number,
            'month' => $request->month,
            'year' => $request->year,
            'cvv' => $request->cvv,
            'amount' => $request->amount,
            'trxn_id' => $request->trxn_id,
        ];

        try {
            //code...
            $card_result = $this->nab_trans($card_details);
            if ($card_result->isSuccessful()) {
                try {
                    DB::beginTransaction();
                    $online = new OnlinePayment;
                    $online->fill([
                        'student_id' => $request->student_id,
                        'trxn_code' => $request->trxn_id,
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'email_ad' => $email,
                        'amount' => $request->amount,
                        'card_number' => $request->card_number,
                        'name_on_card' => $request->name_card,
                        'card_expiry_month' => $request->month,
                        'card_expiry_year' => $request->year,
                        'cvv' => $request->ccv,
                        'response' => $card_result->getCode(),
                        'site_source' => 'CRM_SITE',
                        'user_id' => Auth::user()->id,
                        'remarks' => $card_result->getMessage() . ' ' . $request->remarks,
                    ]);
                    $online->save();
                    DB::commit();
                    return response()->json(['status' => 'success', 'message' =>  $card_result->getMessage(), 'response_code' => $card_result->getCode()]);
                } catch (\Throwable $th) {
                    DB::rollback();
                    return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
                    //throw $th;
                }
            } else {
                try {
                    DB::beginTransaction();
                    $online = new OnlinePayment;
                    $online->fill([
                        'student_id' => $request->student_id,
                        'trxn_code' => $request->trxn_id,
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'email_ad' => $email,
                        'amount' => $request->amount,
                        'card_number' => $request->card_number,
                        'name_on_card' => $request->name_card,
                        'card_expiry_month' => $request->month,
                        'card_expiry_year' => $request->year,
                        'cvv' => $request->ccv,
                        'response' => $card_result->getCode(),
                        'site_source' => 'CRM_SITE',
                        'user_id' => Auth::user()->id,
                        'remarks' => $card_result->getMessage() . ' ' . $request->remarks,
                    ]);
                    $online->save();
                    DB::commit();
                    return response()->json(['status' => 'success', 'message' =>  $card_result->getMessage()]);
                } catch (\Throwable $th) {
                    DB::rollback();
                    return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
                    //throw $th;
                }
            }
        } catch (\Throwable $th) {
            DB::beginTransaction();
            $online = new OnlinePayment;
            $online->fill([
                'student_id' => $request->student_id,
                'trxn_code' => $request->trxn_id,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email_ad' => $email,
                'amount' => $request->amount,
                'card_number' => $request->card_number,
                'name_on_card' => $request->name_card,
                'card_expiry_month' => $request->month,
                'card_expiry_year' => $request->year,
                'cvv' => $request->ccv,
                'response' => '',
                'site_source' => 'CRM_SITE',
                'user_id' => Auth::user()->id,
                'remarks' => $th->getMessage() . ' ' . $request->remarks,
            ]);
            $online->save();
            DB::commit();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
    public function store_cash(Request $request)
    {
        try {
            DB::beginTransaction();
            $cash = new CashPayment;
            $cash->fill([
                'trxn_code' => $request->trxn_id,
                'student_id' => $request->student_id,
                'is_initial_payment' => $request->initial_payment ? 1 : 0,
                'payment_method_id' => $request->payment_method,
                'amount'    => $request->amount,
                'amount_applied' => $request->amount,
                'remarks' => $request->remarks
            ]);
            $cash->user()->associate(Auth::user());
            $cash->save();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'success']);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);

            //throw $th;
        }
    }
    public function payment_history($student_id)
    {
        $ph = [];
        $cash = CashPayment::where('student_id', $student_id)->get();
        $online = OnlinePayment::where('student_id', $student_id)->get();
        foreach ($cash as $c) {
            $data = [
                'id' => $c->id,
                'date_paid' => $c->payment_date->format('d/m/Y'),
                '_date_paid' => $c->payment_date->format('Y-m-d'),
                'description' => $c->trxn_code . ' ' . $c->status,
                'type'        => 'CASH',
                'status'      => '08',
                'amount'        => $c->amount
            ];
            $ph[]  =  $data;
        }
        foreach ($online as $o) {
            $data = [
                'id' => $o->id,
                'date_paid' => $o->created_at->format('d/m/Y'),
                '_date_paid' => $o->created_at->format('Y-m-d'),
                'description' => $o->trxn_code . ' ' . $o->remarks,
                'type'        => 'ONLINE',
                'status'      => $o->response,
                'amount'        => $o->amount
            ];
            $ph[] = $data;
        }
        usort($ph, function ($a, $b) {
            $t1 = strtotime($a['_date_paid']);
            $t2 = strtotime($b['_date_paid']);
            return $t1 - $t2;
        });
        return $ph;
    }
    public function payment_detail($detail)
    {
        $details = PaymentScheduleDetail::with('commission_status')->where('payment_schedule_template_id', $detail)->orderBy('id', 'asc')->get();

        return $details;
    }

    public function payment_detail_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'payment_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'errors', 'errors' => $validator->messages()]);
        }

        try {



            DB::beginTransaction();

            if (isset($request->id)) {
                $payment_details = FundedStudentPaymentDetails::where('id', $request->id)->first();
                $payment_details->update([
                    'note'                 =>  $request->note,
                    'payment_date'          => $request->payment_date,
                    'amount'                => $request->amount,
                    'pre_deduc_comm'                => $request->pre_deduc_comm,
                    'comm_release_status'                    => $request->comm_release_status == '' ? 0 : $request->comm_release_status,
                    'user_id'               => Auth::user()->id
                ]);
                $payment_details->save();

                // Update status when  $expected_bal > $actual_bal
                $this->updateWarningTrail($payment_details);
                //Update Payment Receipt
                $this->generate_reciept($payment_details);
            } else {
                $old = OfferLetterCourseDetail::find($request->offer_letter_course_detail_id);
                // dd($old->funded_course);
                $funded = null;
                
                if($old->funded_course != null){
                    $funded = $old->funded_course->id;
                }
                $payment_details = new FundedStudentPaymentDetails;
                $payment_details->fill([
                    'student_id'                        => $request->student_id,
                    'offer_letter_course_detail_id'     => $request->offer_letter_course_detail_id,
                    'student_course_id'                 => $funded,
                    'note'                              =>  $request->note,
                    'payment_date'                      => $request->payment_date,
                    'amount'                            => $request->amount,
                    'pre_deduc_comm'                    => $request->pre_deduc_comm,
                    'comm_release_status'                    => $request->comm_release_status == '' ? 0 : $request->comm_release_status,
                    'user_id'                           => Auth::user()->id
                ]);
                $payment_details->save();

                // Update status when  $expected_bal > $actual_bal
                $this->updateWarningTrail($payment_details);
                //Create Payment Receipt
                $this->generate_reciept($payment_details);
            }
            DB::commit();
            //  return json_encode(['data' => $request, 'status' => 'success']);





            // $pd = new PaymentScheduleDetail;
            // $pd->fill(
            //     [
            //         'amount' => $request->amount,
            //         'date_paid' => Carbon::parse($request->date_paid)->format('Y-m-d'),
            //         'notes'    => $request->notes,
            //         'payment_status_id' => $request->payment_status,
            //         'agent_comm_status_id' => $request->comm_release_status,
            //         'pre_deducted_amount'   => $request->pre_deducted_comm,
            //         'agent_comm_release_date'   => $request->comm_release_status == 1 ? Carbon::now()->format('Y-m-d') : null
            //     ]
            // );
            // $pd->payment_schedule_template()->associate($request->payment_template);
            // $pd->save();

            // DB::commit();
            return response()->json(['status' => 'success']);
            //code...
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['status' => 'message_errors', 'message' => $th->getMessage()]);
        }
    }
    public function payment_detail_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'date_paid' => 'required',
            'payment_status' => 'required',
            'comm_release_status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'errors', 'errors' => $validator->messages()]);
        }

        try {
            DB::beginTransaction();
            $pd = PaymentScheduleDetail::where('id', $request->payment_id)
                ->update([
                    'amount' => $request->amount,
                    'date_paid' => Carbon::parse($request->date_paid)->format('Y-m-d'),
                    'notes'    => $request->notes,
                    'payment_status_id' => $request->payment_status,
                    'agent_comm_status_id' => $request->comm_release_status,
                    'pre_deducted_amount'   => $request->pre_deducted_comm,
                    'agent_comm_release_date'   => $request->comm_release_status == 1 ? Carbon::now()->format('Y-m-d') : null
                ]);
            // Update status when  $expected_bal > $actual_bal
            $this->updateWarningTrail($payment_details);

            DB::commit();
            return response()->json(['status' => 'success']);
            //code...
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['status' => 'message_errors', 'message' => $th->getMessage()]);
        }
    }

    public function payment_detail_destory(PaymentScheduleDetail $payment_detail)
    {
        try {
            //code...
            DB::beginTransaction();
            $payment_detail->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => ' ERROR - ' . $th->getMessage()]);
        }
    }
    public function fees_store(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            // $cash = new CashPayment;
            // $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            // $trnx_id = $this->generate_string($permitted_chars, 12);


            $ol_fee = OfferLetterFee::where('id', $id)
                ->update([
                    'initial_payment_amount' => $request->initial_payment_amount,
                    'initial_payment_date_paid' => Carbon::parse($request->initial_payment_date_paid)->format('Y-m-d')
                ]);
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'success']);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
    public function changeDate(Request $request)
    {
        $payment = PaymentScheduleTemplate::find($request->template_id);
        $change_date = Carbon::parse($request->due_date)->timezone('Australia/Melbourne')->format('Y-m-d');
        $payment->adjusted_date = $change_date;
        $payment->update();
        return response()->json(['status' => 'success']);
    }

    public function paymentResched($id)
    {
        $payments = PaymentScheduleTemplate::where('offer_letter_course_detail_id', $id)->get();
        if ($payments->isEmpty()) {
            $cd = OfferLetterCourseDetail::find($id);
            $this->createPayment($cd);
            return response()->json(['status' => 'success']);
        } else {
            $nopayment = true;
            foreach ($payments as $payment) {
                if (!$payment->payment_detail->isEmpty()) {
                    $nopayment = false;
                    break;
                }
            }
            if ($nopayment) {
                try {
                    DB::beginTransaction();
                    foreach ($payments as $payment) {
                        $payment->delete();
                    }
                    $p = new PaymentScheduleTemplate;
                    $cd = OfferLetterCourseDetail::find($id);
                    $this->createPayment($cd);
                    DB::commit();
                    return response()->json(['status' => 'success']);
                } catch (\Throwable $th) {
                    DB::rollback();
                    return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => 'naai unod']);
            }
        }
    }
    public function createPayment($course_detail)
    {
        try {

            DB::beginTransaction();


            if ($course_detail->order != 1) {

                $weekCount = 0;
                $startDuration = \Carbon\Carbon::parse($course_detail->course_start_date);
                $cstart_date = Carbon::createFromFormat('Y-m-d', $course_detail->course_end_date);
                $monthly = $cstart_date->diffInMonths($course_detail->course_start_date);
                // $monthly = $course_detail->course_end_date->diffInMonths($course_detail->course_start_date);
                for ($i = 0; $i < $monthly; $i++) {
                    $payment = new PaymentScheduleTemplate;
                    $curr_balance = isset($curr_balance) ? $curr_balance : $course_detail->tuition_fees;
                    $noRound = round($course_detail->tuition_fees / $monthly);
                    $round = round($course_detail->tuition_fees / $monthly, -2);
                    $checkNegative = number_format($curr_balance - ($course_detail->tuition_fees / $monthly));

                    if ($checkNegative > 0) {
                        $roundPayable = $noRound > $round ? $round + 100 : $round;
                    } else {
                        $roundPayable = $curr_balance;
                    }
                    $payment->fill([
                        'due_date' => ($i == 0) ? $startDuration->addWeek($weekCount)->format('Y-m-d') : $startDuration->addMonth()->format('Y-m-d'),
                        'payable_amount' => (float) $roundPayable
                    ]);
                    $payable = $roundPayable;
                    $curr_balance = (isset($curr_balance) ? floor((int) $curr_balance - (int) $payable) : (int) $course_detail->tuition_fees);
                    $payment->course_detail()->associate($course_detail);
                    $payment->user()->associate(Auth::user());
                    if ($roundPayable != 0) {
                        $payment->save();
                    }
                }
            } else {


                // new computation
                $course_fees = $course_detail->offer_letter->fees;
                $initial = $course_fees->initial_payment_amount == 0  ? $course_fees->payment_required : $course_fees->initial_payment_amount;
                $week_tuition = $course_fees->course_tuition_fee / $course_detail->week_duration;
                $nonTuition = $course_fees->application_fee + $course_fees->materials_fee;
                $balance = $initial - $nonTuition;

                $week = round($balance / $week_tuition);
                $bduration = $course_detail->week_duration;
                $duration = $bduration - $week;
                $startdate = Carbon::parse($course_detail->course_start_date)->addWeek($week);
                $balance_ = $course_fees->course_tuition_fee - $course_fees->discounted_amount - $balance;

                for ($i = 0; $i < 2; $i++) {
                    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $invoice_no = $this->generate_string($permitted_chars, 12);
                    $payment = new PaymentScheduleTemplate;
                    $payable = $course_fees->initial_payment_amount == 0  ? $course_fees->payment_required : $course_fees->initial_payment_amount;
                    $payment->fill([
                        'invoice_no' => $invoice_no,
                        'due_date' => ($i == 0) ?  Carbon::parse($course_detail->course_start_date)->subDays(3)->format('Y-m-d') : $startdate->format('Y-m-d'),
                        'payable_amount' => ($i == 0) ? $payable : $balance_
                    ]);
                    $payment->offerLetter()->associate($course_detail->offer_letter);
                    $payment->course_detail()->associate($course_detail);
                    $payment->user()->associate(\Auth::user());
                    $payment->save();
                }


                // old computation

                // $course_fees = $course_detail->offer_letter->fees;
                // $tuitDur = round($course_fees->course_tuition_fee / $course_detail->week_duration);
                // // dd($tuitDur);
                // $weekCount = $course_fees->payment_required != 0 ? round($course_fees->payment_required / $tuitDur) : 0;
                // $startDuration = \Carbon\Carbon::parse($course_detail->course_start_date);
                // $cstart_date = Carbon::createFromFormat('Y-m-d', $course_detail->course_end_date);
                // $monthly = $cstart_date->diffInMonths($course_detail->course_start_date);
                // // dd($monthly);
                // for ($i = 0; $i < $monthly; $i++) {
                //     $payment = new PaymentScheduleTemplate;
                //     $curr_balance = isset($curr_balance) ? $curr_balance : $course_fees->balance_due;
                //     $noRound = round($course_fees->balance_due / $monthly);
                //     $round = round($course_fees->balance_due / $monthly, -2);

                //     $checkNegative = number_format($curr_balance - ($course_fees->balance_due / $monthly));

                //     if ($checkNegative > 0) {
                //         $roundPayable = $noRound > $round ? $round + 100 : $round;
                //     } else {
                //         $roundPayable = $curr_balance;
                //     }
                //     $payment->fill([
                //         'due_date' => ($i == 0) ? $startDuration->addWeek($weekCount)->format('Y-m-d') : $startDuration->addMonth()->format('Y-m-d'),
                //         'payable_amount' => (float) $roundPayable
                //     ]);
                //     $payable = $roundPayable;
                //     $curr_balance = (isset($curr_balance) ? floor((int) $curr_balance - (int) $payable) : (int) $offerLetter->fees->balance_due);
                //     $payment->offerLetter()->associate($course_detail->offer_letter);
                //     $payment->course_detail()->associate($course_detail);
                //     $payment->user()->associate(Auth::user());
                //     if ($roundPayable != 0) {
                //         $payment->save();
                //     }
                // }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function index()
    {
        return view('payment.index');
    }
    public function payment_list(Request $request)
    {
        // public function index(Request $request){


        $int = FundedStudentPaymentDetails::select(
            'students.id',
            'funded_student_payment_details.id as payment_id',
            'funded_student_payment_details.student_id',
            'funded_student_payment_details.note',
            'funded_student_payment_details.payment_date',
            'party.name',
            'offer_letter_course_details.course_code',
            'courses.name  as course_name',
            'student_types.type',
            DB::raw('SUM(vrx_funded_student_payment_details.amount) as amount')

        )
            ->join('students', 'funded_student_payment_details.student_id', '=', 'students.student_id')
            ->join('student_types', 'students.student_type_id', '=', 'student_types.id')
            ->join('party as party', 'students.party_id', '=', 'party.id')
            ->join('offer_letter_course_details', 'offer_letter_course_details.id', 'funded_student_payment_details.offer_letter_course_detail_id')
            ->join('courses', 'offer_letter_course_details.course_code', '=', 'courses.code')
            ->groupBy('course_code', 'funded_student_payment_details.student_id');
        
        if ($request->sort) {
            $pl = FundedStudentPaymentDetails::select(
                'students.id',
                'funded_student_payment_details.id as payment_id',
                'funded_student_payment_details.student_id',
                'funded_student_payment_details.note',
                'funded_student_payment_details.payment_date',
                'party.name',
                'funded_student_course.course_code',
                'courses.name  as course_name',
                'student_types.type',
                DB::raw('SUM(vrx_funded_student_payment_details.amount) as amount')
            )
                ->join('students', 'funded_student_payment_details.student_id', '=', 'students.student_id')
                ->join('student_types', 'students.student_type_id', '=', 'student_types.id')
                ->join('party', 'students.party_id', '=', 'party.id')
                ->join('funded_student_course', 'funded_student_payment_details.student_course_id', '=', 'funded_student_course.id')
                ->join('courses', 'funded_student_course.course_code', '=', 'courses.code')
                ->union($int)
                ->orderBy($request->sort, $request->direction)
                ->groupBy('course_code', 'funded_student_payment_details.student_id')
                ->paginate(10);
        } else {
            $pl = FundedStudentPaymentDetails::select(
                'students.id',
                'funded_student_payment_details.id as payment_id',
                'funded_student_payment_details.student_id',
                'funded_student_payment_details.note',
                'funded_student_payment_details.payment_date',
                'party.name',
                'funded_student_course.course_code',
                'courses.name  as course_name',
                'student_types.type',
                DB::raw('SUM(vrx_funded_student_payment_details.amount) as amount')
            )
                ->join('students', 'funded_student_payment_details.student_id', '=', 'students.student_id')
                ->join('student_types', 'students.student_type_id', '=', 'student_types.id')
                ->join('party', 'students.party_id', '=', 'party.id')
                ->join('funded_student_course', 'funded_student_payment_details.student_course_id', '=', 'funded_student_course.id')
                ->join('courses', 'funded_student_course.course_code', '=', 'courses.code')
                ->union($int)
                ->orderBy('name', 'desc')
                ->groupBy('course_code', 'funded_student_payment_details.student_id')
                ->paginate(10);
        }

        return $pl;
    }

    public function paymentDetailView($odetail_id)
    {
        $details = PaymentScheduleTemplate::where('offer_letter_course_detail_id', $odetail_id)->get();
        if ($details->isEmpty()) {
            $cd = OfferLetterCourseDetail::find($odetail_id);
            $this->createPayment($cd);
            $details = PaymentScheduleTemplate::where('offer_letter_course_detail_id', $odetail_id)->get();
            return $details;
        }
        return $details;
    }

    public function updateWarningTrail($payment_details)
    {
        $date_now = Carbon::now()->format('Y-m-d');
        $all_pd = FundedStudentPaymentDetails::where('student_course_id', $payment_details->student_course_id)->get();
        $payment_sched = PaymentScheduleTemplate::where('funded_student_course_id', $payment_details->student_course_id)->get();
        $x =  $payment_sched->where('due_date',  '<=', $date_now);
        $expected_bal = $payment_sched->sum('payable_amount') - $x->sum('payable_amount');
        $actual_bal =  $payment_sched->sum('payable_amount') - $all_pd->sum('amount');

        $warningTrail = EmailWarningTrail::where('student_id', $payment_details->student_id)->get();
        if ($expected_bal > $actual_bal) {
            foreach ($warningTrail as $wt) {
                if ($wt->email_template_type == 'First Warning Letter' || $wt->email_template_type == 'Second Warning Letter') {

                    try {

                        DB::beginTransaction();

                        $up_wt = $wt->where('id', $wt->id)->first();
                        $up_wt->update([
                            'status_id' => 1
                        ]);

                        DB::commit();
                    } catch (\Throwable $th) {
                        DB::rollback();
                        throw $th;
                    }
                }
            }
        }
    }

    public function updatePaymentSchedDetail(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $pst = PaymentScheduleTemplate::where('id', $request->detail['id'])->first();
            
            if($pst){
                $pst->due_date = Carbon::parse($request->detail['due_date'])->setTimezone('Australia/Brisbane')->format('Y-m-d');
                $pst->payable_amount = $request->detail['payable_amount'];
                $pst->update();
                
                DB::commit();

                $all = $pst->offer_letter_course_detail_id == null ? PaymentScheduleTemplate::where('funded_student_course_id', $pst->funded_student_course_id)->get() : PaymentScheduleTemplate::where('offer_letter_course_detail_id', $pst->offer_letter_course_detail_id)->get();

                return response()->json(['status' => 'success', 'payment_template' => $all]);
            
            }else{
                return response()->json(['status' => 'error']);
            }

            
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
            //throw $th;
        }
    }

    public function paymentAttachment(Request $request){
        $peyment  = FundedStudentPaymentDetails::find($request->payment_id);
        // dump($peyment);
        // dd($request->all());

        $path = '';
        $file = null;
        try {
            DB::beginTransaction();
            $file = $request->file('payment_attachment');
            $path = $file->store('public/student/new/attachments/' . $peyment->student_id . '/payments/');
            $hashFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->hashName());

            $studentAttachment = new PaymentAttachment([
                'name'      => $file->getClientOriginalName(),
                'hash_name' => $hashFileName,
                'size'      => $file->getClientSize(),
                'mime_type' => $file->getMimeType(),
                'ext'       => $file->guessClientExtension(),
                'path_id'   => $peyment->student_id,
                '_input'       => 'payment_attachment',
            ]);
            $studentAttachment->user()->associate(\Auth::user());
            $studentAttachment->payment()->associate($peyment);
            $studentAttachment->save();
            DB::commit();
            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            DB::rollBack();

            // remove file
            Storage::delete($path);
            dd($e->getMessage());
        }
    }
    
    public function paymentAttachmentView(PaymentAttachment $id){

        $path = null;
        // file path
        // if ($file->path_id == $file->student_id) {
        $path_new = storage_path() . '/app/public/student/new/attachments/' . $id->path_id . '/payments/' . $id->hash_name . '.' . $id->ext;
        // } else {
        $path_old = storage_path() . '/app/public/student/old/attachments/' . $id->path_id . '/payments/' . $id->hash_name . '.' . $id->ext;
        // }
        
        $path = file_exists($path_old) ? $path_old : $path_new;

        // raw file contents
        $fileContent = File::get($path);
        
        return response($fileContent)->header('Content-Type', $id->mime_type);
    }

    public function send_receipt($student_id, $id)
    {

        $sd = Student::with('party.person','funded_course.course','contact_detail')->where('student_id', $student_id)->first();
        $payment_details = FundedStudentPaymentDetails::where('id', $id)->first();
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

        // SEND COE
        $org = TrainingOrganisation::first();

        $email = [];
        if(isset($sd->contact_detail->email) && !in_array($sd->contact_detail->email, ['', null])){
            $email[] = $sd->contact_detail->email; 
        }
        if(isset($sd->contact_detail->email_at) && !in_array($sd->contact_detail->email_at, ['', null])){
            $email[] = $sd->contact_detail->email_at; 
        }
        
        if(count($email) < 1){
            return ['status' => 'error', 'message' => 'Please provide student email'];
        }

        $send = new EmailSendingController;
        $admin_emails = EmailAutomation::where('addOn', 'payment_receipt')->pluck('email');

        $receipt = $this->generate_reciept($payment_details);
        if(isset($receipt['path'])){
            $paths[] = $receipt;
        }

        $content = 'Dear '.$sd->party->name.',<br><br>Greetings of the day from Phoenix College of Australia (PCA).<br><br>We confirm the receipt of <b>$'.$payment_details->amount.'</b> (GST not included) towards your fees for the course <b>'.$funded_course->course->code.' - '.$funded_course->course->name.'</b>. We would like to thank you for the payment.<br><br>Please see attached file for the pdf copy of the receipt.<br><br>Regards<br><b>Admin Team</b><br>Phoenix College of Australia<br>RTO NO 45633 CRICOS CODE 03871F <br><a href="http://phoenixcollege.edu.au/">http://phoenixcollege.edu.au/</a>';
        // dd($admin_emails);
        $s = $send->send_automate('Fees Receipt', $content, [$org->training_organisation_name => $org->email_address], $email, $paths, $admin_emails);
        //     // $s = $send->send_automate('CEA Enrolment Application', $content, ['Community Education Australia' => 'constant.claro@gmail.com'], ['konstant.claro@gmail.com']);

        if($s['status'] == 'success'){
            
            $pd = FundedStudentPaymentDetails::where('student_id', $student_id)->where('id', $id)->first();
            if($pd){
                $pd->sent_receipt = 1;
                $pd->update();
            }

            return ['status' => 'success'];
        }else{
            return ['status' => 'error', 'message' => 'Something went wrong.'];
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

        $path = storage_path('app/public/student/receipt/'.$payment_details->student_id);

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        \PDF::loadView('custom.pca.payment-receipt-pdf', compact('payment_details','funded_course','sd', 'to', 'receiptDate'))->setPaper('A5', 'portrate')->save($path.'/payment-receipt-'.$payment_details->id.'.pdf')->stream('payment-receipt');
        

        return ['path' => $path . '/payment-receipt-'.$payment_details->id.'.pdf', 'name' => 'payment-receipt-'.$payment_details->id.'.pdf'];
    }

    public function paymentReceiptView($id){

        $fc = FundedStudentPaymentDetails::where('id', $id)->first();
        $path = storage_path() . '/app/public/student/receipt/' . $fc->student_id . '/payment-receipt-'.$id.'.pdf';

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

    public function student_payments(){
        return view('payment.list');
    }
    public function student_payments_list(Request $request){

        if ($request->sort) {
            $sortBy = $request->sort;
            $dir = $request->direction;
        }else{
            $sortBy = 'id';
            $dir = 'desc';
        }

        if (isset($request->search)) {
            $search = $request->search;
            $pd = FundedStudentPaymentDetails::with('student.party.person','funded_student_course.course','offer_detail.course')->wherein('sent_receipt', ['0', '1'])->where('student_id', 'like', '%' . $search . '%')->orWhereHas('student.party.person', function ($q) use ($search) {
                $q->where('firstname', 'like', '%'.$search.'%'); // student name
            })->orWhereHas('student.party.person', function($q) use ($search) {
                $q->where('lastname', 'LIKE', '%'. $search . '%'); // student name
            })->orWhereHas('funded_student_course.course', function($q) use ($search){
                $q->where('code', 'LIKE', '%' . $search . '%'); //course code
            })->orWhereHas('funded_student_course.course', function($q) use ($search){
                $q->where('name', 'LIKE', '%' . $search . '%'); //course name
            })->orderBy($sortBy, $dir)->paginate($request->limit);
            return $pd;
        } else {
            $pd = FundedStudentPaymentDetails::with('student.party.person','funded_student_course.course','offer_detail.course')->wherein('sent_receipt', ['0', '1'])->orderBy($sortBy, $dir)->paginate($request->limit);
            return $pd;
        }
    }

    public function Delete(Request $request,$id){
        $payment = PaymentScheduleTemplate::find($id);
        $payment->delete();
        return ['status'=> 'success'];
    }

    public function paymentDetailVerify(Request $request){
        // return $request->all();
        $payment_details = $request->payment_details;
        $payment_schedule = $request->payment_schedule;
        $trnx_id = $request['transaction_code'];
        // return $payment_details['agent'];
        if(isset($payment_details['agent'])){
            $emailsTo[] = $payment_details['agent']['email'];
            $name = $payment_details['agent']['agent_name'];
        }else{
            return response()->json(['status'=>'error','message'=>'Agent email not found']);
        }
        
        $org = TrainingOrganisation::first();
        
        $payment_detail = FundedStudentPaymentDetails::with(['funded_student_course.course'])->where('id',$payment_details['id'])->first();
        

        try{
            DB::beginTransaction();

            $unverified_amount = $payment_details['amount'];

            // if(isset($payment_schedule)){ //pag naay payment plan   
            //     foreach(){
                    
            //     }
            // }else{

            // }

            $payment_detail->verified = 1;
            $payment_detail->update();

            $this->notifyAgent($payment_detail);

            $send = new EmailSendingController;

            $content = '<b>Dear ' . $name . ',</b><br><br>Your payment has been verified and accepted.<br>Trxn no: '.$trnx_id;

            $s = $send->send_automate('Payment Verified', $content, ['Vorx' => $org->email_address], $emailsTo);
            // $s['status']='success';
            
            if($s['status']=='success'){
                DB::commit();
            }else{
                DB::rollback();
            }

            return response()->json(['status'=>'success','message'=>$s]);
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }

    }

    public function notifyAgent($payments){

        $student = Student::with(['party.person'])->where('student_id', $payments->student_id)->first();
        $funded_course = $payments->funded_student_course;
        $course = '';
        if($funded_course->course_code == '@@@@'){
            $course = 'Unit of Compentency';
        }else{
            $course = $funded_course->course_code.' - '. $funded_course->course->name;
        }

        $collection_status = "";
        if($payments->verified == 1){
            $collection_status = 'Verified';
        }elseif($payments->verified == 0){
            $collection_status = 'Pending';
        }elseif($payments->verified == 2){
            $collection_status = 'Declined';
        } 

        try {
            DB::beginTransaction();
            
            $notify = new Notification;
            $notify->fill([
                'type' => 'payment_collection',
                'table_name' => 'funded_student_payment_details',
                'table_id' => $payments->id,
                'reference_id' => $payments->agent_id !== null ? $payments->agent_id : $student->student_id, 
                'date_recorded' => Carbon::now()->setTimezone('Australia/Melbourne')->format('Y-m-d H:i:s'),
                'message' => 'Payment collection has been '. $collection_status .' under '. $course . ' course.',
                'is_seen' => 0,
                'action' => 'updated',
                'link' => $student->student_type_id == 1 ? '/student/' . $student->id : '/student/domestic/' . $student->id
            ]);
            $notify->user()->associate(\Auth::user());
            $notify->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();

            throw $th;
        }
    }
}
