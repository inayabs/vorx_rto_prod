<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Agent;
use App\Models\AgentDetail;
use App\Models\AgentCommissionSetting;
use App\Models\Course;
use App\Models\Student\OfferLetter\OfferLetter;
use App\Models\OfferLetterFee;
use App\Models\PaymentScheduleDetail;
use App\Models\PaymentScheduleTemplate;
use App\Models\AgentReleaseCommission;
use App\Models\AgentReleaseCommissionAttachment;
use Carbon\Carbon;
use Auth;
use DB;
use Storage;
use File;
use Illuminate\Validation\Rules\Exists;
use Response as Resp;

// Models that needed to be added in Models
// use App\Models\OnlinePayment;
// use App\Models\CashPayment;

// Models that needed to be added in Database and Models
// use App\Models\AgentCommissionMonitor;
// use App\Models\AgentCommissionArchive;
// use App\Models\AgentPaymentAdvice;

class AgentCommissionController extends Controller
{
    //

    public function agent_commission_report_v4($agent_id = 117, $path = null, $payablesReport = 0, $view = 0)
    {
        $cut_off_start = date('Y-m-d') > date('Y-m-15') ? date('Y-m-16') : date('Y-m-1');
        $cut_off_end = date('Y-m-d') > date('Y-m-15') ? date('Y-m-t') : date('Y-m-15');
        // $studs = OfferLetter::with(['payment_sched_preview', 'fees', 'course_details.course', 'course_details.status', 'course_details.paymentsched.payment_details', 'status'])->whereIn('status_id', [3, 2, 7, 4, 5, 8, 9, 10, 11])->where('agent_id', $agent_id)->orderBy('issued_date', 'asc')->get();
        $studs = OfferLetter::with(['fees', 'student.party.person', 'course_details.course', 'course_details.status', 'course_details.payment_template.payment_detail', 'status'])->whereIn('status_id', [3, 2, 7, 4, 5, 8, 9, 10, 11])->where('agent_id', $agent_id)->whereHas('course_details', function($q){
            $q->whereIn('status_id', [3, 2, 7, 4, 5, 8, 9, 11]);
        })->orderBy('issued_date', 'asc')->get();

        $agent = AgentCommissionSetting::with(['agent.party', 'agent.detail'])->where('agent_id', $agent_id)->get();
        if ($agent->isEmpty()) {
            // return response()->view("errors.general");
            return "no data";
        }

        
        $release_commission = AgentReleaseCommission::where('agent_id', $agent_id)->where('released_date', '<=', date('Y-m-d 23:59:59'))->where('status_id', 1)->sum('amount');
        // dd($release_commission);
        // dd($release_commission);
        $p = 0;
        $zz = 0;
        $xx = 0;
        $totalActualAmount = 0;
        $totalStudentPayment = 0;
        $totalCommissionPaid = $release_commission ? (float) $release_commission : 0.00;
        $totalCommissionPayable = 0;
        $totalCommissionAdvance = 0;
        $registeredGST = 1;
        $gst_start_date = $agent[0]->gst_start_date;
        $plusGST = 0;
        $getinitial = 0;
        $gstType = '';

        // new totals
        $TotalCommissionWithoutGstFromBreakdown = 0;
        $TotalCommissionFromBreakdown = 0;
        $TotalPayableCommissionFromBreakdown = 0;

        $students = [];

        // dd($studs->count());

        foreach ($studs as $k => $v) {
            $resourceLoop = 0;
            $studentCommTotal = 0;
            $totalCommComputeNoDeduction = 0;
            $hasStarted = 0;
            // if ($v->student_id == 'ETI-1019') {
            //     dd($v);
            // }
            // if(isset($students[$v->student_id]) && in_array($students[$v->student_id]['status_id'], [3, 2, 7, 4, 5, 8, 9, 11])){
            //     $hasStarted = 1;
            // }else{
                $students[$v->student_id] = [
                    'firstname' => $v->student->party->person->firstname,
                    'lastname' => $v->student->party->person->lastname,
                    'dob' => $v->student->party->person->date_of_birth,
                    'student_id' => $v->student_id,
                    'status' => $v->status->description,
                    'status_id' => $v->status->id,
                    'count' => $k,
                ];
            // }
            foreach ($v->course_details as $getKey => $getValue) {
                $releasedPayment = 0;
                $commissionLimit = $getValue->commission_limit;

                $initialReleaseDate = $v->date_paid != '0000-00-00' ?  $v->date_paid : null;

                if ($getValue->course_start_date <= date('Y-m-d') && in_array($getValue->status_id, [3, 2, 7, 4, 5, 8, 9, 11]) || $initialReleaseDate != null && in_array($getValue->status_id, [2, 3, 8, 9])) {
                    $hasStarted = 1;

                    $app_fee = $getValue->order == 1 ? $v->fees->application_fee : 0;
                    // $initalPaymentRequired = $getValue->order == 1 ? $v->fees->payment_required  : 0;
                    $initalPaymentRequired = $getValue->order == 1 ? $v->fees->payment_required : 0;
                    // insurance OHSC echos
                    $course_fee_due = $getValue->tuition_fees + $app_fee + $getValue->material_fees;
                    
                    $students[$v->student_id]['courses'][$getValue->course_code] = [
                        'course_start_date' => $getValue->course_start_date,
                        'course_end_date' => $getValue->course_end_date,
                        'course_name' => $getValue->course_code . ' - ' . $getValue->course->name,
                        'tuition_fee' => $getValue->tuition_fees,
                        'non_tuition_fee' => $app_fee + $getValue->material_fees,
                        'status' => $getValue->status->description,
                        'commission_limit' => $getValue->commission_limit,
                        'commValue' => $agent[0]->gst_type == 'Including' ? round($agent[0]->commission_value + ($agent[0]->commission_value * 0.10), 0) : round($agent[0]->commission_value, 0),
                        'order' => $getValue->order,
                    ];

                    $students[$v->student_id]['status_id'] = $getValue->status_id;
                    
                    if ($students[$v->student_id]['courses'][$getValue->course_code]['non_tuition_fee'] != 0 && $course_fee_due != 0) {
                        $resourcePercentage = $students[$v->student_id]['courses'][$getValue->course_code]['non_tuition_fee'] != 0 ? ($students[$v->student_id]['courses'][$getValue->course_code]['non_tuition_fee'] / $course_fee_due) : 0;
                    } else {
                        $resourcePercentage = 0;
                    }


                    // start for initial Payments
                    $intital_compute_full = $getValue->order == 1 ? $v->fees->payment_required : 0;
                    $intital_compute_full = $getValue->payment_template->count() == 0 ? $getValue->tuition_fees : $intital_compute_full;
                    $intital_compute_full = $intital_compute_full - ($app_fee + $getValue->material_fees); // initial payment - non-tuition fees
                    $actualInitialPayment = $intital_compute_full;
                    if($getValue->status_id == 9 && $v->fees->is_comm_release != 1){
                        $intital_compute_full = 0;
                    }

                    $intital_compute = 0;

                    $commVal = 0;
                    foreach ($agent as $commSet) {
                        if ($commSet->course_code == $v->course_details[0]->course_code) {
                            if (!in_array($commSet->starting_student_count, [0, null]) && $commSet->starting_student_count >= $k + 1) {
                                $intital_compute = $intital_compute_full != 0 ? $intital_compute_full * ($commSet->starting_commission_value / 100) : 0;
                                $commVal = $commSet->starting_commission_value;
                            } else {
                                $intital_compute = $intital_compute_full != 0 ? $intital_compute_full * ($commSet->commission_value / 100) : 0;
                                $commVal = $commSet->commission_value;
                            }
                            $students[$v->student_id]['commission_value'] = $commVal;
                            $plusGST = !is_null($commSet->gts_value) ? 1 : 0;
                            $gstType = $commSet->gst_type;
                            $registeredGST = $commSet->registered_gst;

                            break;
                        }
                    }

                    $getinitial = $intital_compute;
                    $validateGST = 0;
                    if ($registeredGST == 1) {
                        if ($gst_start_date != null && $gst_start_date <= $v->date_paid) {
                            $validateGST = 1;
                        }elseif($gst_start_date == null){
                            $validateGST = 1;
                        }
                    }
                    if($validateGST == 1){
                        if ($gstType == 'Excluding') {
                            $gst = $intital_compute * 0.1;
                            $getinitial = $intital_compute + $gst;
                        } elseif ($gstType == 'Including') {
                            $gst_value = round(($commVal / 10), 2);
                            $getinitial = $intital_compute + ($intital_compute_full * ($gst_value / 100));
                        }
                    }

                    $paymentRequired = $v->fees->payment_required;
                    if ($getValue->status_id == 9) {
                        $getinitial = (int) $getinitial * -1;
                        $paymentRequired = (int) $v->fees->payment_required * -1;

                        if ($v->fees->is_comm_release != 1) {
                            // $intital_compute_full = $intital_compute_full + $getinitial;
                            $getinitial = 0;
                            $intital_compute = 0;
                        }
                    }
                    // i check niya if mas dako ang pre deducted kay sa comm payable, pre deducted ang gamiton. vice versa
                    if($v->fees->comm_advance != 0 && $v->fees->comm_advance < $getinitial){
                        $preComPayable = $getinitial;
                    }elseif($v->fees->comm_advance != 0 && $v->fees->comm_advance > $getinitial){
                        $preComPayable = $v->fees->comm_advance;
                    }else{
                        $preComPayable = $getinitial;
                    }
                    $studentCommTotal = $studentCommTotal + $preComPayable;
                    $totalCommComputeNoDeduction = $totalCommComputeNoDeduction + $getinitial;
                    if ($getValue->order == 1) {
                        $students[$v->student_id]['courses'][$getValue->course_code]['initial_payment'] = [
                            'id' => $v->fees->id,
                            'student_payment_due_date' => $v->issued_date,
                            'amount_received' => $paymentRequired,
                            'actual_amount' => $actualInitialPayment,
                            'date_paid' => $v->fees->initial_payment_date_paid != null ? Carbon::parse($v->fees->initial_payment_date_paid)->format('d/m/Y') : '',
                            'pre_deducted_amount' => in_array($v->fees->initial_payment_commission_pre_deducted_amount, [null, 0.00, 0]) ? 0 : $v->fees->initial_payment_commission_pre_deducted_amount,
                            'commission_payable' => $intital_compute,
                            'commission_payable_gst' => $getinitial,
                            'student_commission_total' => $studentCommTotal,
                            'is_comm_released' => $v->fees->initial_payment_commission_release_status_id
                        ];

                        // if($v->student_id == 'ETI10142'){
                        //     dump($studentCommTotal);
                        //     dump('----------------');
                        // }

                        $TotalCommissionWithoutGstFromBreakdown += $getinitial;

                        if ($v->fees->is_comm_release == 1) {
                            $releasedPayment +=  $registeredGST == 1 ? $getinitial : $intital_compute;
                        }

                        // total actual amount in ip
                        $totalActualAmount += $getValue->payment_template->count() == 0 ? $getValue->tuition_fees : $paymentRequired;

                        $totalCommissionAdvance = $totalCommissionAdvance + $v->fees->comm_advance;
                    }else{
                        $studentCommTotal = 0;
                        $totalCommComputeNoDeduction = 0;
                    }

                    // if($getValue->course_code == 'SIT40516' && $v->student_id == 'ETI10216'){
                    //     dd($studentCommTotal);
                    // }

                    // end for initial payments

                    $onLimit = 0;
                    $stackResource = 0;
                    $comm_compute = 0;
                    $comm_compute_gst = 0;
                    $payTemCount = 1;

                    // dd($getValue->payment_template);

                    foreach ($getValue->payment_template as $kk => $vv) {
                        $payTemCount++;
                        // $psdAmountPaid = isset($vv->payment_detail[0]) ? str_replace(',', '', $vv->payment_detail[0]->total_amount_paid) : $vv->amount_paid;
                        // $psdDeductedAmount = isset($vv->payment_detail[0]) ? str_replace(',', '', $vv->payment_detail[0]->total_deducted_amount) : $vv->comm_deducted_amount;

                        // if (isset($vv->payment_detail[0]) && $vv->payment_detail[0]->status_id == 1 && $vv->payment_detail[0]->comm_status_id == 1) {
                        //     $psdAmountPaid = $vv->payment_detail[0]->amount;
                        // }
                        // dd($vv->payment_detail);

                        // Payment Details          
                        if(isset($vv->payment_detail[0])){
                            foreach($vv->payment_detail as $kpd => $vpd){
                                $psdAmountPaid = $vpd->amount;
                                $amountWithResource = $psdAmountPaid;
                                $psdDeductedAmount = $vpd->pre_deducted_amount;

                                if($vpd->status_id == 1 && !in_array($vpd->agent_comm_status_id, [null, 0])){
                                    $psdAmountPaid = 0;
                                    $amountWithResource = 0;
                                    $psdDeductedAmount = 0;
                                }

                                $isCommReleased = $vpd->agent_comm_status_id;
                                // if (isset($vv->payment_detail[0])) {
                                if ($vpd->status_id == 1 && $vpd->agent_comm_status_id == 1) {
                                    $psdAmountPaid = $vpd->amount;
                                    // dump($vv->payment_detail[0]->id);
                                    $isCommReleased = 2;
                                } else {
                                    $isCommReleased = $vpd->agent_comm_status_id;
                                }
                                $datePaid = $vpd->date_paid;

                                
                                $totalStudentPayment = $totalStudentPayment + $amountWithResource;
                                foreach ($agent as $commSet) {
                                    if ($commSet->course_code == $v->course_details[0]->course_code) {

                                        if (!in_array($commSet->starting_student_count, [0, null]) && $commSet->starting_student_count >= $k + 1) {
                                            $comm_compute = $amountWithResource != 0 ? $amountWithResource * ($commSet->starting_commission_value / 100) : 0;
                                            $p = ($commSet->starting_commission_value / 100);
                                        } else {
                                            $comm_compute = $amountWithResource != 0 ? $amountWithResource * ($commSet->commission_value / 100) : 0;
                                            $p = ($commSet->commission_value / 100);
                                        }

                                        $registeredGST = $commSet->registered_gst;
                                        $gstType = $commSet->gst_type;
                                    }
                                }

                                $comm_compute_gst = $comm_compute;

                                $validateGST = 0;
                                if ($registeredGST == 1) {
                                    if ($gst_start_date != null && isset($vv->payment_detail[0]) && $gst_start_date <= $vv->payment_detail[0]->date_paid) {
                                        $validateGST = 1;
                                    } elseif ($gst_start_date == null) {
                                        // dump('without');
                                        $validateGST = 1;
                                    }
                                }

                                if ($validateGST == 1) {
                                    if ($gstType == 'Excluding') {
                                        $gst = $comm_compute * 0.1;
                                        $comm_compute_gst = $comm_compute + $gst;
                                    } elseif ($gstType == 'Including') {
                                        $gst_value = round(($commVal / 10), 2);
                                        $comm_compute_gst = $comm_compute + ($amountWithResource * ($gst_value / 100));
                                    }
                                }


                                // i check niya if mas dako ang pre deducted kay sa comm payable, pre deducted ang gamiton. vice versa
                                if ($psdDeductedAmount != 0 && $psdDeductedAmount < $comm_compute_gst) {
                                    $installPreComPayable = $comm_compute_gst;
                                } elseif ($psdDeductedAmount != 0 && $psdDeductedAmount > $comm_compute_gst) {
                                    $installPreComPayable = $psdDeductedAmount;
                                } else {
                                    $installPreComPayable = $comm_compute_gst;
                                }

                                if ($onLimit == 0 && ($studentCommTotal + $installPreComPayable) < $commissionLimit) {
                                    $studentCommTotal = $studentCommTotal + $installPreComPayable;
                                } else {
                                    if (floor($studentCommTotal) != floor($commissionLimit)) {
                                        $comm_left = ($studentCommTotal + $installPreComPayable) - $commissionLimit;
                                        $comm_compute_gst = $comm_compute_gst - $comm_left;
                                        $studentCommTotal = $studentCommTotal + $comm_compute_gst;
                                    } else {
                                        $comm_compute = 0.00;
                                        $comm_compute_gst = 0.00;
                                    }
                                    $onLimit = 1;
                                }
                                
                                $students[$v->student_id]['courses'][$getValue->course_code]['payment_schedule'][$payTemCount][] = [
                                    'id' => $vpd->id,
                                    'payment_template_id' => $vv->id,
                                    'student_payment_due_date' => $vv->due_date,
                                    'amount_received' => $psdAmountPaid,
                                    'actual_amount' => $psdAmountPaid != 0 ? $amountWithResource : '0.00',
                                    'date_paid' => $datePaid,
                                    'pre_deducted_amount' => in_array($psdDeductedAmount, [null, 0.00, 0]) ? 0 : $psdDeductedAmount,
                                    'commission_payable' => $comm_compute,
                                    'commission_payable_gst' => $comm_compute_gst,
                                    'student_commission_total' => $studentCommTotal,
                                    'is_comm_released' => $isCommReleased,
                                ];

                                $TotalCommissionWithoutGstFromBreakdown += $comm_compute;

                                // total actual amount in installment
                                $totalActualAmount += $psdAmountPaid != 0 ? $amountWithResource : '0.00';

                                if ($isCommReleased == 1) {
                                    $releasedPayment += $registeredGST == 1 ? $comm_compute_gst : $comm_compute;
                                }

                                $totalCommissionAdvance = $totalCommissionAdvance + $psdDeductedAmount;

                                // if with pre-deducted amount. commission must not be the commission payable GST.
                                $forTotalCommComputNoDeduct = $comm_compute_gst;
                                if ($psdDeductedAmount != 0) {
                                    $forTotalCommComputNoDeduct = $psdDeductedAmount;
                                }
                                // ------------------------------------------------------------------------------

                                $totalCommComputeNoDeduction = $totalCommComputeNoDeduction + $forTotalCommComputNoDeduct;

                                $totalCommissionPayable = $totalCommissionPayable + ($comm_compute - $psdDeductedAmount);
                            }
                        }else{
                            $students[$v->student_id]['courses'][$getValue->course_code]['payment_schedule'][$payTemCount][] = [
                                'id' => null,
                                'peyment_template_id' => $vv->id,
                                'student_payment_due_date' => $vv->due_date,
                                'amount_received' => 0.00,
                                'actual_amount' => 0.00,
                                'date_paid' => '',
                                'pre_deducted_amount' => 0.00,
                                'commission_payable' => 0.00,
                                'commission_payable_gst' => 0.00,
                                'student_commission_total' => 0.00,
                                'is_comm_released' => 0,
                            ];
                            // $totalCommComputeNoDeduction = 0;
                            // $studentCommTotal = 0;
                        }

                        
                        
                    }
                    // dump($totalCommComputeNoDeduction);
                    $payableAmountNoReleased = $totalCommComputeNoDeduction - $releasedPayment;
                    // dump($payableAmountNoReleased);
                    // dump($totalCommComputeNoDeduction);
                    // $xx += $totalCommComputeNoDeduction - $payableAmountNoReleased;
                    $TotalCommissionFromBreakdown += $totalCommComputeNoDeduction;
                    $TotalPayableCommissionFromBreakdown += $payableAmountNoReleased;
                    $students[$v->student_id]['courses'][$getValue->course_code] = array_merge($students[$v->student_id]['courses'][$getValue->course_code], ['stud_commission_payable' => $studentCommTotal, 'stud_commission_payable_no_deduction' => $totalCommComputeNoDeduction, 'stud_commission_payable_no_released' => $payableAmountNoReleased]);
                    $studentCommTotal = 0;
                    $totalCommComputeNoDeduction = 0;
                    
                    $totalStudentPayment = $totalStudentPayment + $intital_compute_full;
                    // dump($totalStudentPayment);
                    // dump('-----------------------------------------');
                }
            }
            if ($hasStarted == 0) {
                // if ($v->student_id == 'ETI10453') {
                //     dump($students[$v->student_id]);
                //     dd($v);
                // }
                // if(!in_array($students[$v->student_id]['status_id'], [3, 2, 7, 4, 5, 8, 9, 11])){
                    unset($students[$v->student_id]);
                // }
            }
            // if ($v->student_id == 'ETI01494') {
            //     dd($students['ETI01494']);
            // }

        }
        // dump($TotalCommissionFromBreakdown);
        // dump($TotalCommissionWithoutGstFromBreakdown);
        // dump($TotalPayableCommissionFromBreakdown);
        $totalCommissionPaid = $totalCommissionPaid + $totalCommissionAdvance;
        $totalCommissionPayable = ($totalStudentPayment * $p) - $totalCommissionPaid;

        if ($gstType == 'Excluding') {
            $gst = ($totalStudentPayment * round($p, 3)) * 0.1;
        } else {
            $gst = ($totalStudentPayment * round($p, 3)) * 0.1;
        }

        $totalCommissionPayableGST = $totalCommissionPayable + $gst;

        if ($registeredGST == 1) {
            $getGST = $totalCommissionPayableGST / 11;
            $totalCommissionPayable = $totalCommissionPayableGST - $getGST;
        }

        if (round($totalCommissionPayableGST) == 0 && $totalCommissionPayableGST < 0) {
            $totalCommissionPayableGST = 0;
        }
        if (round($totalCommissionPayable) == 0 && $totalCommissionPayable < 0) {
            $totalCommissionPayable = 0;
        }

        $totalCommissionPayable = $TotalCommissionWithoutGstFromBreakdown - $totalCommissionPaid;
        $totalCommissionPayableGST = $TotalCommissionFromBreakdown - $totalCommissionPaid;

        if ($payablesReport == 1) {
            return [
                'agent_id' => $agent_id,
                'agent_name' => $agent[0]->agent->agent_detail->company_name,
                'bank_details' => $agent[0]->agent->bank_detail,
                'total_amount_received_from_students_excluding_resource' => $totalStudentPayment,
                'total_commission_already_paid' => $totalCommissionPaid,
                'due_commission_payable' => $totalCommissionPayable,
                'amount_payable_including_gst' => $totalCommissionPayableGST,
                'registeredGST' => $registeredGST,
                'gstType' => $gstType
            ];
        }


        if ($path == null) {
            if ($view == 1) {
                if($registeredGST == 1 && $gstType == 'Including'){
                    $zz = 'Including GST';
                }elseif($registeredGST == 1 && $gstType == 'Excluding'){
                    $zz = 'Plus GST';
                }else{
                    $zz = 'No GST';
                }
                return [
                    'agent_id' => $agent_id,
                    'agent_name' => $agent[0]->agent->detail->company_name,
                    'bank_details' => $agent[0]->agent->detail,
                    'total_amount_received_from_students_excluding_resource' => $totalStudentPayment,
                    'total_commission_already_paid' => $totalCommissionPaid,
                    'due_commission_payable' => $totalCommissionPayable,
                    'amount_payable_including_gst' => $totalCommissionPayableGST,
                    'registeredGST' => $registeredGST,
                    'gstType' => $gstType,
                    'totalStudentPayment ' => $totalStudentPayment,
                    'students' => $students,
                    'studentCount' => count($students),
                    'agent' => $agent,
                    'commLabel' => $zz,
                    'commValue' => $agent[0]->gst_type == 'Including' ? round($agent[0]->commission_value + ($agent[0]->commission_value * 0.10), 0) : round($agent[0]->commission_value, 0)
                ];
            }

            // dd($students['ETI10800']);

            $date = Carbon::now()->setTimezone('Australia/Brisbane');

            $nextmonth = Carbon::now()->addMonth()->format('Y-m-01');

            $date_path = $date->format('Y-m-d') <= date('Y-m-15') ? date('Y-m-15') : $nextmonth;

            $path = 'agent_commission/' . $date_path;
            if (!Storage::disk('local')->exists($path)) {
                Storage::disk('local')->makeDirectory($path, $mode = 0777, true, true);
            }
            $company = str_replace('/', '', $agent[0]->agent->detail->company_name);
            $path1 = storage_path('app/' . $path . '/Automatic Commission Payment Results for ' . $company . '.pdf');

            return \PDF::loadView('agents.commission-report.v4_automatic_commission_payment_results', compact('students', 'studs', 'agent', 'totalStudentPayment', 'totalCommissionPaid', 'totalCommissionPayable', 'totalCommissionPayableGST', 'registeredGST', 'gstType', 'cut_off_start'))->setPaper('A4', 'portrait')->stream($path1);
            // \PDF::loadView('agents.commission-report.v4_automatic_commission_payment_results', compact('students', 'studs', 'agent', 'totalStudentPayment', 'totalCommissionPaid', 'totalCommissionPayable', 'totalCommissionPayableGST', 'registeredGST', 'gstType', 'cut_off_start'))->setPaper('A4', 'portrait')->save($path1);

            // return response()->file($path1);
        } else {

            // dd($path['date']);

            // $date = Carbon::now()->setTimezone('Australia/Brisbane');
            // $nextmonth = Carbon::now()->addMonth()->format('Y-m-01');
            $date_path = $path['date'];

            // AgentCommissionArchive::updateOrCreate(
            //     [
            //         'agent_id' => $agent_id,
            //         'cut_off_date' => $date_path,
            //     ],
            //     [
            //         'agent_id'          => $agent_id,
            //         'user_id'           => Auth::user()->id,
            //         'cut_off_date'      => $date_path,
            //         'date_saved'        => Carbon::now()->format('Y-m-d H:i:s'),
            //         'data'              => json_encode([
            //             'students' => $students,
            //             // 'studs' => $studs,
            //             'agent' => $agent,
            //             'totalStudentPayment' => $totalStudentPayment,
            //             'totalCommissionPaid' => $totalCommissionPaid,
            //             'totalCommissionPayable' => $totalCommissionPayable,
            //             'totalCommissionPayableGST' => $totalCommissionPayableGST,
            //             'registeredGST' => $registeredGST,
            //             'gstType' => $gstType,
            //             'cut_off_start' => $date_path
            //         ])
            //     ]
            // );

            \PDF::loadView('agents.commission-report.v4_automatic_commission_payment_results', compact('students', 'studs', 'agent', 'totalStudentPayment', 'totalCommissionPaid', 'totalCommissionPayable', 'totalCommissionPayableGST', 'registeredGST', 'gstType', 'cut_off_start'))->setPaper('A4', 'portrait')->save($path['path']);

            return [
                'agent_id' => $agent_id,
                'agent_name' => $agent[0]->agent->agent_detail->company_name,
                'bank_details' => $agent[0]->agent->bank_detail,
                'total_amount_received_from_students_excluding_resource' => $totalStudentPayment,
                'total_commission_already_paid' => $totalCommissionPaid,
                'due_commission_payable' => $totalCommissionPayable,
                'amount_payable_including_gst' => $totalCommissionPayableGST,
                'registeredGST' => $registeredGST,
                'totalStudentPayment ' => $totalStudentPayment,
                'gstType' => $gstType,
                // 'students' => $students,
                'agent' => $agent
            ];

            return true;
        }
        exit();
    }

    public function agent_commission_report_v4_view($agent_id)
    {
        $data = $this->agent_commission_report_v4($agent_id, null, 0, 1);
        // dump($data);
        // dd($data['students']['ET10315']['courses']);
        return $data;
    }

    public function agent_commission_report_v4_toggle_release(Request $request)
    {
        // dd($request->all());
        $status = '';
        if($request->payType == 'detail'){
            $r = PaymentScheduleDetail::where('id', $request->id)->first();
            $r->agent_comm_status_id = $r->agent_comm_status_id == 1 ? 0 : 1;
            $status = $r->agent_comm_status_id == 1 ? 'released' : 'removed';
            $r->update();
        }else{
            $r = OfferLetterFee::where('id', $request->id)->first();
            $r->initial_payment_commission_release_status_id = $r->initial_payment_commission_release_status_id == 1 ? 0 : 1;
            $status = $r->initial_payment_commission_release_status_id == 1 ? 'released' : 'removed';
            $r->update();
        }

        return ['status' => 'success', 'isReleased' => $status];
    }

    public function agent_release_commission($agent_id)
    {
        $commission = AgentReleaseCommission::with(['comm_status'])->where('agent_id', $agent_id)->orderBy('released_date', 'desc')->get();
        return $commission;
    }

    public function agent_release_commission_edit($id)
    {
        $commission = AgentReleaseCommission::with(['comm_status'])->where('id', $id)->first();
        return $commission;
    }

    public function agent_release_commission_save(Request $request, $id)
    {
        $agent = Agent::with(['commission_settings'])->where('id', $request['agentID'])->first();

        $validator = \Validator::make($request->all(), [
            'acr.relesed_date' => 'required',
            'acr.amount' => 'required | number',
        ]);

        // validator nice names
        $validator->setAttributeNames([
            'acr.relesed_date'  => 'Released Date',
            'acr.amount'        => 'Amount',
        ]);

        try {
            // start db transaction
            DB::beginTransaction();

            if(isset($request['acr']['id'])){
                // update
                $acr = AgentReleaseCommission::where('id', $request['acr']['id'])->first();
                $acr->released_date = isset($request['acr']['released_date']) && $request['acr']['released_date'] != null ? Carbon::parse($request['acr']['released_date'])->format('Y-m-d') : null;
                $acr->amount = $request['acr']['amount'];
                $acr->status_id = $request['acr']['status_id'];
                $acr->payable_amount = $request['acr']['payable_amount'];
                $acr->total_amount_received = $request['acr']['total_amount_received'];
                $acr->remarks = $request['acr']['remarks'];
                $acr->update();
            }else{
                // create
                $acr = new AgentReleaseCommission;
                $acr->released_date = isset($request['acr']['released_date']) && $request['acr']['released_date'] != null ? Carbon::parse($request['acr']['released_date'])->format('Y-m-d') : null;;
                $acr->amount = $request['acr']['amount'];
                $acr->status_id = $request['acr']['status_id'];
                $acr->payable_amount = isset($request['acr']['payable_amount']) ? $request['acr']['payable_amount'] : 0;
                $acr->total_amount_received = isset($request['acr']['total_amount_received']) ? $request['acr']['total_amount_received'] : 0;
                $acr->remarks = isset($request['acr']['remarks']) ? $request['acr']['remarks'] : null;
                $acr->agent()->associate($agent);
                $acr->user()->associate(\Auth::user());
                $acr->save();
            }
            // commit db transactions
            DB::commit();

            return ['status' => 'success'];

        } catch (\Exception $e) {
            // rollback db transactions
            DB::rollBack();

            // return to previous page with errors
            return ['status' => 'error', 'msg' => $e->getMessage()];
        }
        
    }

}
