<?php

namespace App\Http\Controllers\Student;

use Validator;
use Auth;
use DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Student\Student;
use App\Models\FundedStudentPaymentDetails;
use App\Models\FundedStudentCourse;
use App\Models\PaymentScheduleTemplate;
use App\Models\StudentInvoice;
use App\Models\EmailWarningTrail;

class DomesticPaymentController extends Controller
{
    public function __construct()
    {
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

    public function payment_store(Request $request, $student)
    {
        $info = Student::with('party.person', 'type', 'funded_course')->find($student);
        $comm_status = 0;
        if(isset($request->comm_release_status) && $request->comm_release_status !== ''){
            $comm_status = $request->comm_release_status;
        }
        if (isset($request->id)) {
            try {
                // start db transaction
                DB::beginTransaction();

                $payment_details = FundedStudentPaymentDetails::where('id', $request->id)->first();
                $payment_details->update([
                    'note'                 =>  $request->note,
                    'payment_date'          => $request->payment_date,
                    'amount'                => $request->amount,
                    'pre_deduc_comm'        => isset($request->pre_deduc_comm) ? $request->pre_deduc_comm : null,
                    'comm_release_status'   => $comm_status,
                    'user_id'               => Auth::user()->id
                ]);
                // Update status when  $expected_bal > $actual_bal
                $this->updateWarningTrail($payment_details);

                DB::commit();

                return json_encode(['data' => $request->all(), 'status' => 'success']);
            } catch (\Exception $e) {
                // rollback db transactions
                DB::rollBack();

                // return to previous page with errors
                return  response()->json(['message' => $e->getMessage(), 'status' => 'errors']);
            }
        } else {
            $inputs = [];
            $inputs = [
                'note' => $request->note,
                'payment_date' => $request->payment_date,
                'amount' => $request->amount,
                'pre_deduc_comm'        => isset($request->pre_deduc_comm) ? $request->pre_deduc_comm : null,
                'comm_release_status'   => $comm_status,
            ];
            // dump($inputs);
            // dump($inputs['payment_date']);
            if ($inputs['payment_date'] == 'Invalid date') {
                $inputs['payment_date'] = null;
            }

            $validator = Validator::make($inputs, [
                'note' => 'required',
                'payment_date' => 'required',
                'amount' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'errors', 'errors' => $validator->messages()]);
            }
            try {
                // start db transaction
                DB::beginTransaction();

                $payment_details = new FundedStudentPaymentDetails;
                if($request->student_type == 2){
                    $payment_details->fill([
                        'student_id'            => $info->student_id,
                        'student_course_id'     => $request->course_id,
                        'note'                 =>  $inputs['note'],
                        'payment_date'          => $inputs['payment_date'],
                        'amount'                => $inputs['amount'],
                        'pre_deduc_comm'        => $inputs['pre_deduc_comm'],
                        'comm_release_status'   => $inputs['comm_release_status'],
                        'user_id'               => Auth::user()->id
                    ]);
                    
                }else{
                    $payment_details->fill([
                        'student_id'            => $info->student_id,
                        'offer_letter_course_detail_id'=> $request->course_id,
                        'student_course_id'     => $request->funded_id,
                        'note'                  =>  $inputs['note'],
                        'payment_date'          => $inputs['payment_date'],
                        'amount'                => $inputs['amount'],
                        'pre_deduc_comm'        => $inputs['pre_deduc_comm'],
                        'comm_release_status'   => $inputs['comm_release_status'],
                        'user_id'               => Auth::user()->id
                    ]);
                }
                
                $payment_details->save();
                // Update status when  $expected_bal > $actual_bal
                $this->updateWarningTrail($payment_details);

                DB::commit();


                return json_encode(['data' => $request->all(), 'status' => 'success']);
            } catch (\Exception $e) {
                // rollback db transactions
                DB::rollBack();

                // return to previous page with errors
                return  response()->json(['message' => $e->getMessage(), 'status' => 'errors']);
            }
        }
    }

    public function payment_details($student)
    {
        $info = Student::with('party.person', 'type', 'funded_course.collection.agent' ,'funded_course.payment_details.attachment','funded_course.payment_details.user.party', 'funded_course.payment_sched')->where('id', $student)->first();
        $funded_course = $info->funded_course;
        $student_invoice = StudentInvoice::where('student_id', $info->student_id)->get();

        $data = [
            'student'           => $info,
            'course_payments'   => $funded_course,
            'course_invoice'    => $student_invoice
        ];

        return $data;
    }

    public function pd_delete($student, $pd_id)
    {
        // dump($pd_id);
        // dd($student);
        $pd = FundedStudentPaymentDetails::find($pd_id);
        if ($pd != null) {
            $pd->delete();
            return json_encode(['id' => $pd_id, 'status' => 'success']);
        }
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
}
