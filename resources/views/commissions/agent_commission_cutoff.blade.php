<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link type="text/css" href="{{public_path()}}/css/automatic_commission_payment_results.css" rel="stylesheet" />
	<title>Commission Payment Results for {{ $setting['cutoff']->agent_detail->company_name }} </title>
	<style>
		.paid{background-color: #AED581;}
		.cancelled-student{color: #f44336 !important; font-family: 'Montserrat-Bold';}
		.not-exact-amount-over{color: #f44336 !important; font-size: 12px;}
		.not-exact-amount-less{color: #FF7032 !important; font-size: 12px;}
		table.legends tr td span{width: 20px;height: 10px;display: inline-block;}
		table.legends tr td span.commission-paid{background-color: #AED581;}
		table.legends tr td span.over-pd{background-color: #f44336;}
		table.legends tr td span.less-pd{background-color: #FF7032;}
	</style>
</head>
    @foreach ($setting['students'] as $student)
	<body class="exo2-regular position-relative">
		<div class="col-xs-12 no-padding position-relative">
			<div class="clearfix" style="height: 20px;"></div>
				<div class="pdf-wrapper proximanova-regular">
					<div class="pdf-header" style="border: 0!important;">
						<div>
                            <table width="100%">
                                <tr>
                                    <td width="60%" valign="middle">
                                        <div class="eti-logo">
                                            {{-- <img src="{{public_path()}}/images/commission_payment_images/ETI-colored-logo.png" alt="" style="width: 200px;"> --}}
                                            <img src="{{$setting['logo']}}" style="width: 200px;"alt="">
                                        </div>
                                    </td>
                                    <td width="40%" valign="middle">
                                        <p class="primary-font-color px-12-font line-height-1 europa-bold">{{ $setting['com_setting']->training_organisation_name }}</p>
                                        <p class="gray-font-color px-10-font line-height-1">{{ $setting['com_setting']->addr_line1 }}</p>
                                        <p class="gray-font-color px-10-font line-height-1">{{ $setting['com_setting']->telephone_number }}</p>
                                        <p class="gray-font-color px-10-font line-height-1">{{ $setting['com_setting']->email_address }}</p>
                                    </td>
                                </tr>
                            </table>
						</div>
					</div>
					<div class="pdf-wrapper pdf-body">
                       {{-- start ulo --}}
                       @if($loop->index == 0)
                        <p class="primary-font-color px-24-font text-center" style="line-height: 20px;">Commission Payment Results for <br> {{ $setting['cutoff']->agent_detail->company_name }}</p>
                        <div class="clearfix" style="height:20px;"></div>
                            <table class="text-center pull-right" width="20%" style="border: 1px solid #363636; margin-left: auto;">
                                <tr style="background-color: #f4783f; color: #FFFFFF;">
                                    <td class="line-height-12 europa-bold px-12-font">Total No. of Students</td>
                                </tr>
                                <tr>
                                    <td class="europa-bold line-height-12 px-16-font">{{ count($setting['students']) }}</td>
                                </tr>
                            </table>
                            <div class="clearfix" style="height:50px;"></div>
                            <table width="100%">
                                <tr>
                                    <td width="80%" class="text-right px-14-font europa-bold line-height-12">Total amount received for all students excluding enrolment and material fee&nbsp;&nbsp;&nbsp;:</td>
                                    <td class="text-right px-14-font europa-bold line-height-12">$ {{ number_format($setting['cutoff']->total_actual_amount_received,2) }}</td>
                                </tr>
                                <tr>
                                    <td width="80%" class="text-right px-14-font europa-bold line-height-12">Total commission already paid for all students&nbsp;&nbsp;&nbsp;:</td>
                                    <td class="text-right px-14-font europa-bold line-height-12">$ {{ number_format($setting['cutoff']->total_commission_paid,2) }}</td>
                                </tr>
                            </table>
                            <div class="clearfix" style="height: 5px;"></div>
                            <div style="border-bottom: dotted #555555; width: 100%;"></div>
                            <table width="100%">
                                {{-- <tr>
                                    <td width="80%" class="text-right px-14-font europa-bold line-height-12">Total computed commission payable as of {{date('d/m/Y')}}&nbsp;&nbsp;&nbsp;: </td>
                                    <td class="text-right px-14-font europa-bold line-height-12">$  {{ number_format($setting['cutoff']->total_computed_commission,2) }}</td>
                                </tr> --}}
                                <tr>
                                    <td width="80%" class="text-right px-14-font europa-bold line-height-12">Due commission payable as of {{date('d/m/Y')}}&nbsp;&nbsp;&nbsp;: </td>
                                    <td class="text-right px-14-font europa-bold line-height-12">$  {{ number_format($setting['cutoff']->due_comission - $setting['cutoff']->total_over_payment,2) }}</td>
                                </tr>
                                {{-- <tr>
                                    <td width="80%" class="text-right px-14-font europa-bold line-height-12">Total Amount Pre-deducted Commission&nbsp;&nbsp;&nbsp;:  </td>
                                    <td class="text-right px-14-font europa-bold line-height-12">$ {{ number_format($setting['cutoff']->total_pre_deducted_comission,2) }}</td>
                                </tr>
                                <tr>
                                    <td width="80%" class="text-right px-14-font europa-bold line-height-12">Total Amount Overpaid&nbsp;&nbsp;&nbsp;:  </td>
                                    <td class="text-right px-14-font europa-bold line-height-12">$ {{ number_format($setting['cutoff']->total_over_payment,2) }}</td>
                                </tr> --}}
                            </table>
                            <div class="clearfix" style="height:10px;"></div>
                            {{-- end ulo --}}
                            @endif
                            <table width="100%" class="green-bordered-table">
                            <tr>
                                <td width="12%" class="primary-bg-color white-font-color">Student Name</td>
                                <td width="40%" class="dark-grey-font-color">
                                    {{$student['name']}}
                                </td>
                                <td width="10%" class="primary-bg-color white-font-color">Student ID</td>
                                <td width="10%" class="dark-grey-font-color">{{$student['student_id']}}</td>
                                <td class="primary-bg-color white-font-color" width="15%">Date of Birth</td>
                                <td class="dark-grey-font-color">{{\Carbon\Carbon::createFromFormat('Y-m-d', $student['dob'])->format('d/m/Y')}}</td>
                            </tr>
                            <tr>
                                <td colspan="1" class="primary-bg-color white-font-color">Course Start</td>
                                <td colspan="1" class="dark-grey-font-color">{{\Carbon\Carbon::createFromFormat('Y-m-d', $student['course_start'])->format('d/m/Y')}}</td>
                                <td colspan="1" class="primary-bg-color white-font-color">Course End</td>
                                <td colspan="1" class="dark-grey-font-color">{{\Carbon\Carbon::createFromFormat('Y-m-d', $student['course_end'])->format('d/m/Y')}}</td>
                                <td colspan="1" class="primary-bg-color white-font-color">Status</td>
                                <td colspan="1" class="{{in_array($student['status'], ['Cancelled', 'Withdrawn']) ? 'cancelled-student' : ''}} dark-grey-font-color">{{$student['status']}}</td>
                            </tr>
                            <tr>
                                <td colspan="1" width="15%" class="primary-bg-color white-font-color">Course Name</td>
                                <td class="dark-grey-font-color"{{$student['course']}}</td>
                                <td class="primary-bg-color white-font-color">Tuition Fee</td>
                                <td class="text-right dark-grey-font-color">$ {{$student['tuition']}}</td>
                                <td class="primary-bg-color white-font-color">Non-Tuition Fee</td>
                                <td class="text-right dark-grey-font-color">$ {{$student['non_tuition']}}</td>
                            </tr>
                        </table>
                        <table width="100%" class="receipt-content px-12-font line-height-1">
                            <tr class="primary-bg-color white-font-color">
                                <td width="8%" class="text-center montserrat-bold">No.</td>
                                <td width="10%" class="text-center montserrat-bold">Student <br> Payment Date</td>
                                <td width="10%" class="text-center montserrat-bold">Amount<br>Received</td>
                                {{-- <td width="10%" class="text-center montserrat-bold">Date<br>Paid</td> --}}
                                <td width="20%" class="text-center montserrat-bold">Actual Amount<br>(does not include enrolment & material fee which is divided equally over installment months & does not apply to 1st payment if tuition fee is not paid in full)</td>
                                <td width="10%" class="text-center montserrat-bold">Pre-Deducted<br>Commission</td>
                                <td width="10%" class="text-center montserrat-bold">Commission<br>Payable</td>
                                <!-- <td width="10%" class="text-center montserrat-bold">Commission<br>Limit Count</td> -->
                                <!-- <td width="10%" class="text-center montserrat-bold">Commission<br>Paid</td> -->
                                <!-- <td width="10%" class="text-center montserrat-bold">Commission<br>Balance</td> -->
                            </tr>
                             @foreach ($student['payments'] as $payment)
                                <tr class="line-height-1">
                                    <td width="8%" class="px-12-font text-center europa-regular">No. {{ $loop->iteration }} </td>
                                    <td width="10%" class="px-12-font text-center europa-regular"> {{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                                    <td width="10%" class="px-12-font text-center europa-regular">$ {{ $payment->amount_received }}</td>
                                    {{-- <td width="10%" class="text-center europa-regular">Date<br>Paid</td> --}}
                                    <td width="20%" class="px-12-font text-center europa-regular">$ {{ $payment->actual_amount }}</td>
                                    <td width="10%" class="px-12-font text-center europa-regular">$ {{ $payment->pre_deducted_comission == null ? 0.00 : $payment->pre_deducted_comission }}</td>
                                    <td width="10%" class="px-12-font text-center europa-regular">$ {{ $payment->commission_payable }}</td>
                                    <!-- <td width="10%" class="text-center montserrat-bold">Commission<br>Limit Count</td> -->
                                    <!-- <td width="10%" class="text-center montserrat-bold">Commission<br>Paid</td> -->
                                    <!-- <td width="10%" class="text-center montserrat-bold">Commission<br>Balance</td> -->
                                </tr>
                            @endforeach
                        </table>
                        <div style="border-bottom: dotted #555555; width: 100%;"></div>
                        <table width="100%" class="total-payment px-14-font line-height-1">
                            <tr>
                                <td width="50%" valign="top">
                                    <table width="100%" class="legends px-12-font">
                                        <tr>
                                            <td><span class="commission-paid"></span> - Commission Paid </td>
                                        </tr>
                                        <tr>
                                            <td><span class="over-pd"></span> - Over Pre-deduction </td>
                                        </tr>
                                        <tr>
                                            <td><span class="less-pd"></span> - Less Pre-deduction </td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="50%" valign="top">
                                    <table width="100%" class="total-payment px-12-font">
                                        <tr>
                                            <td width="85%" class="text-right">Total calculated commission:</td>
                                            <td width="" class="text-center"><span class="europa-bold">${{number_format($student['payments']->sum('computed_commission'), 2)}}</span></td>
                                        </tr>
                                        <tr>
                                            <td width="85%" class="text-right">Total commission payable:</td>
                                            <td width="" class="text-center"><span class="europa-bold">${{number_format($student['payments']->sum('commission_payable'), 2)}}</span></td>
                                        </tr> 
                                        <tr>
                                            <td class="text-right">Above amount includes 10% GST</td>
                                        </tr>
                                        <tr>
                                            @php
                                                $initalPay = isset($item['initial_payment']) ? $item['initial_payment']['pre_deducted_amount'] : 0;
                                            @endphp
                                            <td width="85%" class="text-right">Calculated Pre-Deducted Commission: </td>
                                            <td width="" class="text-center"><span class="europa-bold">${{number_format($student['payments']->sum('pre_deducted_comission'), 2)}}</span></td>
                                        </tr>
                                        <tr>
                                            <td width="85%" class="text-right">Commission Limit: </td>
                                            <td width="" class="text-center"><span class="europa-bold">${{number_format($student['commission_limit'], 2)}}</span></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <div style="border-bottom: dotted #555555; width: 100%;"></div>
			        </div>
			</div>
            <div>
                <div class="pdf-footer bottom-placement" style="padding: 0 15px 0;">
                    <table width="100%">
                        <tr>
                            <td width="25%" valign="top" class="text-left">
                                <p class="px-10-font">Page {{ $loop->iteration }}</p>
                            </td>
                            <td width="50%" valign="middle" class="text-center">
                                <p class="px-12-font primary-font-color europa-bold line-height-1">ELITE TRAINING INSTITUTE PTY LTD </p>
                                <p class="px-8-font line-height-1">RTO CODE 40965 | CRICOS NO 03470A | ABN NUMBER: 42 163 187 862</p>
                                <p class="px-8-font line-height-1">Document Uncontrolled when Printed</p>
                            </td>
                            <td width="25%" valign="bottom" class="text-right">
                                <p class="px-10-font">Printed {{date('d/m/Y')}}</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </body>
    @endforeach
</html>
				