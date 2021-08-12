<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Commission Payment Results for ({{$agent[0]->agent->detail->company_name}})</title>
	<link type="text/css" href="{{public_path()}}/css/automatic_commission_payment_results.css" rel="stylesheet" />
	
	<style>
		.paid{background-color: #AED581;}
		.paid-refund{background-color: #91d1ff;}
		.cancelled-student{color: #f44336 !important; font-family: 'Montserrat-Bold';}
		.not-exact-amount-over{color: #f44336 !important; font-size: 12px;}
		.not-exact-amount-less{color: #FF7032 !important; font-size: 12px;}
		table.legends tr td span{width: 20px;height: 10px;display: inline-block;}
		table.legends tr td span.commission-paid{background-color: #AED581;}
        table.legends tr td span.commission-refund{background-color: #91d1ff;}
		table.legends tr td span.over-pd{background-color: #f44336;}
		table.legends tr td span.less-pd{background-color: #FF7032;}
		/* @font-face {font-family: 'Europa-Regular';src: url('fonts/commission_payment_fonts/Europa-Regular.ttf')  format('truetype');  font-style: normal;font-weight: normal;}
		.europa-regular{font-family:'Europa-Regular'!important;} */
	</style>
</head>
<!-- Page 1 of 1 -->
<!-- Automatic Commission Payment -->
<!-- 
	legend:
	counter 0 = main header (agent name & totals)
	counter 1 = student tables
	counter 2 = page headers
	counter 3 = footer
 -->
@php
	$counter = 0;
	$totals = 0;
	$studentRowCounter = 0;
	$pageNumber = 1;
@endphp

@foreach ($students as $key => $stud)
 	@foreach ($stud['courses'] as $item)
		@if ($counter == 0)
			<body class="exo2-regular position-relative">
				<div id="page-background" class="overlay">
					<!-- <img src="images/progress-report-bg.jpg" height="100%" width="100%" style="position: absolute; width: 100%;z-index: -1;"> -->
				</div> 
				<div>
					<div class="col-xs-12 no-padding position-relative">
						<div class="clearfix" style="height: 20px;"></div>
						<div class="pdf-wrapper proximanova-regular">
							<div class="pdf-header" style="border: 0!important;">
							<div>
									<table width="100%">
										<tr>
											<td width="60%" valign="middle">
												<div class="eti-logo">
													<img src="{{public_path()}}/images/commission_payment_images/ETI-colored-logo.png" alt="" style="width: 200px;">
												</div>
											</td>
											<td width="40%" valign="middle">
												<p class="primary-font-color px-12-font line-height-1 europa-bold">ELITE TRAINING INSTITUTE PTY. LTD.</p>
												<p class=" px-10-font line-height-1">20 Otter Street, Collingwood, VIC, 3066</p>
												<p class=" px-10-font line-height-1">0390880255</p>
												<p class=" px-10-font line-height-1">accounts@eti.edu.au</p>
												<p class=" px-10-font line-height-1">http://www.eti.edu.au/</p>
												<p class=" px-10-font line-height-1">ABN 42163187862 | RTO CODE: 40965 | CRICOS NO: 03470A</p>
											</td>
										</tr>
									</table>
							</div>
							</div>
							<div class="pdf-wrapper pdf-body">
								<p class="primary-font-color px-24-font text-center" style="line-height: 20px;">Commission Payment Results for<br>{{$agent[0]->agent->detail->company_name}}</p>
								<div class="clearfix" style="height:20px;"></div>
								<table class="text-center pull-right" width="20%" style="border: 1px solid #363636; margin-left: auto;">
									<tr style="background-color: #78B426; color: #FFFFFF;">
										<td class="line-height-12 europa-bold px-12-font">Total No. of Students</td>
									</tr>
									<tr>
										<td class="europa-bold line-height-12 px-16-font">{{count($students)}}</td>
									</tr>
								</table>
								<div class="clearfix"></div>
								<div class="clearfix" style="height:50px;"></div>
								@if ($totals == 0)
									<table width="100%">
										<tr>
											<td width="88%" class="text-right px-14-font europa-bold line-height-12">Total amount received for all students&nbsp;&nbsp;&nbsp;:</td>
											<td class="text-right px-14-font europa-bold line-height-12">${{number_format($totalStudentPayment, 2)}}</td>
										</tr>
										<tr>
											<td width="88%" class="text-right px-14-font europa-bold line-height-12">Total commission already paid for all students&nbsp;&nbsp;&nbsp;:</td>
											<td class="text-right px-14-font europa-bold line-height-12">${{number_format($totalCommissionPaid, 2)}}</td>
										</tr>
									</table>
									<div class="clearfix" style="height: 5px;"></div>
									<div style="border-bottom: dotted #555555; width: 100%;"></div>
									<table width="100%">
										{{-- <tr>
											<td width="90%" class="text-right px-14-font europa-bold line-height-12">Due commission payable as of {{\Carbon\Carbon::now()->setTimezone('Australia/Brisbane')->format('d/m/Y')}}&nbsp;&nbsp;&nbsp;: </td>
											<td class="text-right px-14-font europa-bold line-height-12">${{number_format($totalCommissionPayable, 2)}}</td>
										</tr> --}}
										<tr>
											@php
												if($registeredGST == 1 && $gstType == 'Including'){
													$zz = 'Including GST';
												}elseif($registeredGST == 1 && $gstType == 'Excluding'){
													$zz = 'Plus GST';
												}else{
													$zz = 'No GST';
												}
											@endphp
											<td width="88%" class="text-right px-14-font europa-bold line-height-12">Total Amount Payable as of {{\Carbon\Carbon::now()->setTimezone('Australia/Brisbane')->format('d/m/Y')}} {{$item['commValue']}}% {{$zz}}&nbsp;&nbsp;&nbsp;: </td>
											@if ($registeredGST == 1)
												<td class="text-right px-14-font europa-bold line-height-12">${{number_format($totalCommissionPayableGST, 2)}}</td>
											@elseif ($registeredGST == 0)
												{{-- <td class="text-right px-14-font europa-bold line-height-12">N/A</td> --}}
												<td class="text-right px-14-font europa-bold line-height-12">${{number_format($totalCommissionPayable, 2)}}</td>
											@endif
										</tr>
									</table>
									<div class="clearfix" style="height:10px;"></div>
									@php
										$totals = 1;
									@endphp
								@endif

			@php
				if($counter == 0){ $counter = 1; }
			@endphp
			
			{{-- <table class="text-right pull-right" width="100%" style="margin-left: auto;">
				<tr>
					<td class="europa-bold line-height-12 px-16-font">* 2nd Course *</td>
				</tr>
			</table>

			<div class="clearfix" style="height:30px;"></div> --}}
			
		@elseif ($counter == 2)
			</div>
					</div>
						</div>
						<div class="pdf-footer bottom-placement" style="padding: 0 15px 0;">
							<table width="100%">
								<tr>
									<td width="25%" valign="top" class="text-left">
										<p class="px-10-font">Page {{$pageNumber}} </p>
										@php
											$pageNumber++;
										@endphp
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
			<body class="exo2-regular position-relative">
				<div id="page-background" class="overlay">
					<!-- <img src="images/progress-report-bg.jpg" height="100%" width="100%" style="position: absolute; width: 100%;z-index: -1;"> -->
				</div> 
				<div>
					<div class="col-xs-12 no-padding position-relative">
						<div class="clearfix" style="height: 20px;"></div>
						<div class="pdf-wrapper proximanova-regular">
							<div class="pdf-header" style="border: 0!important;">
							<div>
									<table width="100%">
										<tr>
											<td width="60%" valign="middle">
												<div class="eti-logo">
													<img src="{{public_path()}}/images/commission_payment_images/ETI-colored-logo.png" alt="" style="width: 200px;">
												</div>
											</td>
											<td width="40%" valign="middle">
												<p class="primary-font-color px-12-font line-height-1 europa-bold">ELITE TRAINING INSTITUTE PTY. LTD.</p>
												<p class=" px-10-font line-height-1">20 Otter Street, Collingwood, VIC, 3066</p>
												<p class=" px-10-font line-height-1">0390880255</p>
												<p class=" px-10-font line-height-1">accounts@eti.edu.au</p>
												<p class=" px-10-font line-height-1">http://www.eti.edu.au/</p>
												<p class=" px-10-font line-height-1">ABN 42163187862 | RTO CODE: 40965 | CRICOS NO: 03470A</p>
											</td>
										</tr>
									</table>
							</div>
							</div>
							<div class="pdf-wrapper pdf-body">
								<!-- <p class="primary-font-color px-24-font text-center" style="line-height: 20px;">Automatic Commission Payment<br>Results for (Agent John Doe PTY LTD)</p> -->
								<!-- <div class="clearfix" style="height:20px;"></div> -->
								
		@elseif ($counter == 3)

		@endif
			@if ($item['order'] != 1)
				@php
					$order = '';
					switch ($item['order']){
						case 2:
							$order = '2nd Course';
						break;
						case 3:
							$order = '3rd Course';
						break;
						default:
							$order = $item['order'].'th Course';
					}
				@endphp
				<table class="text-right pull-right" width="15%" style="margin-left: auto;">
					<tr>
						<td>
							<div class="primary-color europa-bold line-height-12 px-14-font" style="border: 2px solid #08486b; padding: 3px 5px;"> * {{$order}} * </div>
						</td>
					</tr>
				</table>
				<div class="clearfix" style="height:40px;"></div>
			@endif

		@php
			$studentRowCounter = 1;
			$totalCommDue = 0;
			$totalCommDueGST = 0;
			$totalCommAdvance = 0;
			$totalCommPaid = 0;
			$totalFeesPaid = 0;
		@endphp
		<!-- Student Payments -->
		<table width="100%" class="green-bordered-table">
			<tr>
				<td width="12%" class="primary-bg-color white-font-color">Student Name</td>
				<td width="40%" class="">
					{{$stud['firstname']}} {{$stud['lastname'] != '-' ? $stud['lastname'] : ''}}
				</td>
				<td width="10%" class="primary-bg-color white-font-color">ETI ID</td>
				<td width="10%">{{$stud['student_id']}}</td>
				<td class="primary-bg-color white-font-color" width="15%">Date of Birth</td>
				<td>{{\Carbon\Carbon::createFromFormat('Y-m-d', $stud['dob'])->format('d/m/Y')}}</td>
			</tr>
			<tr>
				<td colspan="1" class="primary-bg-color white-font-color">Course Start</td>
				<td colspan="1">{{\Carbon\Carbon::parse($item['course_start_date'])->format('d/m/Y')}}</td>
				<td colspan="1" class="primary-bg-color white-font-color">Course End</td>
				<td colspan="1">{{\Carbon\Carbon::parse($item['course_end_date'])->format('d/m/Y')}}</td>
				<td colspan="1" class="primary-bg-color white-font-color">Status</td>
				<td colspan="1" class="{{in_array($item['status'], ['Cancelled', 'Withdrawn']) ? 'cancelled-student' : ''}}">{{$item['status']}}</td>
			</tr>
			<tr>
				<td colspan="1" width="15%" class="primary-bg-color white-font-color">Course Name</td>
				<td>{{$item['course_name']}}</td>
				<td class="primary-bg-color white-font-color">Tuition Fee</td>
				<td class="text-right">${{number_format($item['tuition_fee'], 2)}}</td>
				<td class="primary-bg-color white-font-color">Non-Tuition Fee</td>
				<td class="text-right">${{number_format($item['non_tuition_fee'], 2)}}</td>
			</tr>
		</table>
		<div class="clearfix" style="height: 10px;"></div>
		<div>
			<table width="100%" class="receipt-content px-12-font line-height-1">
				<tr class="primary-bg-color white-font-color">
					<td width="8%" class="text-center montserrat-bold">No.</td>
					<td width="10%" class="text-center montserrat-bold">Student Payment<br>Due Date</td>
					<td width="10%" class="text-center montserrat-bold">Amount<br>Received</td>
					<td width="10%" class="text-center montserrat-bold">Date<br>Paid /<br>Refund<br>Date</td>
					<td width="20%" class="text-center montserrat-bold">Actual Amount<br>(does not include application & material fee)</td>
					<td width="10%" class="text-center montserrat-bold">Pre-Deducted<br>Commission</td>
					<td width="10%" class="text-center montserrat-bold">Commission<br>Payable</td>
					<!-- <td width="10%" class="text-center montserrat-bold">Commission<br>Limit Count</td> -->
					<!-- <td width="10%" class="text-center montserrat-bold">Commission<br>Paid</td> -->
					<!-- <td width="10%" class="text-center montserrat-bold">Commission<br>Balance</td> -->
				</tr>
				{{-- START INITIAL PAYMENT --}}
				@if( isset($item['initial_payment']) )
					@if( $item['initial_payment']['is_comm_released'] == 1 )
						<tr class="paid {{-- if paid add class paid in this section --}}">
					@elseif ($item['initial_payment']['is_comm_released'] != 1 && $item['initial_payment']['pre_deducted_amount'] != 0.00)
						<tr class="paid {{-- if paid add class paid in this section --}}">
					@else
						<tr class="">
					@endif
							<td class="text-center" valign="top">1</td>
							<td class="text-center" valign="top">{{\Carbon\Carbon::parse($item['initial_payment']['student_payment_due_date'])->format('d/m/Y')}}</td>
							<td class="text-center" valign="top">${{number_format($item['initial_payment']['amount_received'], 2)}}</td>
							<td class="text-center" valign="top">{{$item['initial_payment']['date_paid']}}</td>
							<td class="text-center" valign="top">${{number_format($item['initial_payment']['actual_amount'], 2)}}</td>
							@php
								$totalFeesPaid += $item['initial_payment']['actual_amount'];
							@endphp
						<td class="text-center" valign="top">
							
							@if ($item['initial_payment']['pre_deducted_amount'] != 0.00 && $item['initial_payment']['pre_deducted_amount'] != $item['initial_payment']['commission_payable_gst'])
							<!-- DRI R -->
							@if($item['initial_payment']['pre_deducted_amount'] > $item['initial_payment']['commission_payable_gst'])
							<div class="not-exact-amount-over montserrat-bold">
								${{number_format($item['initial_payment']['pre_deducted_amount'], 2)}}
							</div>
							@else
							<div class="not-exact-amount-less montserrat-bold">
								${{number_format($item['initial_payment']['pre_deducted_amount'], 2)}}
							</div>
							@endif
							@else
							${{number_format($item['initial_payment']['pre_deducted_amount'], 2)}}
							@endif
						</td>
						<td class="text-center" valign="top">${{number_format($item['initial_payment']['commission_payable_gst'], 2)}}</td>
						{{-- <td class="text-center" valign="top">${{number_format($item['initial_payment']['student_commission_total'], 2)}}</td> --}}
					</tr>
					@php
						$totalCommDue = $totalCommDue + $item['initial_payment']['commission_payable'];
						$totalCommDueGST = $totalCommDueGST + ($item['initial_payment']['commission_payable_gst']);
						$resourceLoop = 0;
					@endphp
				@else
					<tr>
						<td class="text-center" valign="top">1</td>	
						<td class="text-center" valign="top"> - </td>	
						<td class="text-center" valign="top"> - </td>	
						<td class="text-center" valign="top"> - </td>	
						<td class="text-center" valign="top"> - </td>	
						<td class="text-center" valign="top"> - </td>	
						<td class="text-center" valign="top"> - </td>	
					</tr>	
				@endif
				{{-- END INITIAL PAYMENT --}}

				@if(isset($item['payment_schedule']))
					@foreach ($item['payment_schedule'] as $pay)
						@php
							$studentRowCounter++;
						@endphp
						
						@foreach ($pay as $kpd => $vpd)
							@php
								$totalCommDue = $totalCommDue + $vpd['commission_payable'];
								$totalCommDueGST = $totalCommDueGST + ($vpd['commission_payable_gst']);
								$totalCommAdvance = $totalCommAdvance + $vpd['pre_deducted_amount'];
							@endphp
							@if ($vpd['is_comm_released'] == 1 || $vpd['pre_deducted_amount'] != 0)
								<tr class="paid">
							@elseif ($vpd['is_comm_released'] == 2 && $vpd['pre_deducted_amount'] == 0)
								<tr class="paid-refund">
							@else
								<tr class="">
							@endif
							@if($kpd == 0)
								<td class="text-center vertical-middle" rowspan="{{count($pay)}}" valign="top">{{$studentRowCounter}}</td>
								<td class="text-center vertical-middle" rowspan="{{count($pay)}}" valign="top">
									{{\Carbon\Carbon::parse($vpd['student_payment_due_date'])->format('d/m/Y')}}
								</td>
							@endif
							<td class="text-center" valign="top">
								${{number_format($vpd['amount_received'], 2)}}
							</td>
							<td class="text-center" valign="top">
								{{$vpd['date_paid']}}
							</td>
							<td class="text-center" valign="top">
								${{number_format($vpd['actual_amount'], 2)}}
							</td>
							@php
								$totalFeesPaid += $vpd['actual_amount'];
							@endphp
							<td class="text-center" valign="top">
								
								@if ($vpd['pre_deducted_amount'] != 0.00 && $vpd['pre_deducted_amount'] != $vpd['commission_payable_gst'])
	
									@if($vpd['pre_deducted_amount'] > $vpd['commission_payable_gst'])
										<div class="not-exact-amount-over montserrat-bold">
										${{number_format($vpd['pre_deducted_amount'], 2)}}
										</div>
									@else
										<div class="not-exact-amount-less montserrat-bold">
										${{number_format($vpd['pre_deducted_amount'], 2)}}
										</div>
									@endif
								@else
									<!-- <div class="not-exact-amount-over"> -->
									${{number_format($vpd['pre_deducted_amount'], 2)}}
									<!-- </div> -->
								@endif
							</td>
							<td class="text-center" valign="top">${{number_format($vpd['commission_payable_gst'], 2)}}</td>
							{{-- <td class="text-center" valign="top">${{number_format($pay['student_commission_total'], 2)}}</td> --}}
	
						</tr>
						@endforeach
					
					@endforeach
				@endif
			</table>
			<div class="clearfix" style="height: 20px;"></div>
			<div style="border-bottom: dotted #555555; width: 100%;"></div>
			<table width="100%" class="total-payment px-14-font line-height-1">
				@php
					//$gst = $totalCommDue * 0.10;
					//$totalCommDue = $totalCommDue + $gst;
				@endphp
				<tr>
					<td width="50%" valign="top">
						<table width="100%" class="legends px-12-font">
							<tr>
								<td><span class="commission-paid"></span> - Commission Paid </td>
                            </tr>
                            <tr>
								<td><span class="commission-refund"></span> - Commission Paid but Payment Refunded</td>
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
							{{-- <tr>
								<td width="85%" class="text-right">Total calculated commission:</td>
								<td width="" class="text-center"><span class="europa-bold">${{number_format($item['stud_commission_payable'], 2)}}</span></td>
							</tr> --}}
							<tr>
								<td width="85%" class="text-right">Actual Total Amount Received as of {{\Carbon\Carbon::now()->setTimezone('Australia/Brisbane')->format('d/m/Y')}}: </td>
								<td width="" class="text-right"><span class="europa-bold">${{number_format($totalFeesPaid, 2)}}</span></td>
							</tr>
							<tr>
								<td width="85%" class="text-right">Total Calculated Paid Commission as of {{\Carbon\Carbon::now()->setTimezone('Australia/Brisbane')->format('d/m/Y')}}:</td>
								{{-- <td width="" class="text-right"><span class="europa-bold">${{number_format( $item['stud_commission_payable_no_deduction'] - $item['stud_commission_payable_no_released'], 2)}}</span></td> --}}
								<td width="" class="text-right"><span class="europa-bold">${{number_format( $item['stud_commission_payable'] - $item['stud_commission_payable_no_released'], 2)}}</span></td>
							</tr>
							<tr>
								<td width="85%" class="text-right">Total Commission Payable as of {{\Carbon\Carbon::now()->setTimezone('Australia/Brisbane')->format('d/m/Y')}}:</td>
								{{-- <td width="" class="text-right"><span class="europa-bold">${{number_format($item['stud_commission_payable_no_deduction'], 2)}}</span></td> --}}
								<td width="" class="text-right"><span class="europa-bold">${{number_format($item['stud_commission_payable_no_released'], 2)}}</span></td>
							</tr> 
							{{-- <tr>
								<td class="text-right">Above amount includes 10% GST</td>
							</tr> --}}
							<tr>
								@php
									$initalPay = isset($item['initial_payment']) ? $item['initial_payment']['pre_deducted_amount'] : 0;
								@endphp
								<td width="85%" class="text-right">Calculated Pre-Deducted Commission: </td>
								<td width="" class="text-right"><span class="europa-bold">${{number_format($totalCommAdvance + $initalPay, 2)}}</span></td>
							</tr>
							<tr>
								<td width="85%" class="text-right">Commission Limit: </td>
								<td width="" class="text-right"><span class="europa-bold">${{number_format($item['commission_limit'], 2)}}</span></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<div style="border-bottom: dotted #555555; width: 100%;"></div>
		<div class="clearfix" style="height:20px;"></div>
			<table width="100%" class="total-payment px-14-font line-height-1">
				<tr>
					<td valign="top">
						<table width="100%" class="total-payment px-12-font">
							<tr>
								<td width="90%" class="text-left" >Note:</td>
							</tr>
							<tr>
								<td width="90%" class="text-left" style="padding-top: 5px">*Upront Fees of <strong>${{number_format($item['non_tuition_fee'], 2)}}</strong> has been taken on the initial payment as part of the non-tuition fees thus remaining amount will be taken as part of the pre-tuition fees paid.</td>
							</tr>
							<tr>
								<td width="90%" class="text-left" style="padding-top: 5px">*If the student misses his/her instalment payment, an equal amount of enrolment and material fee will be deducted from the next payment.</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		@php
			if($studentRowCounter != 0){
				$counter = 2;
			}
		@endphp
	@endforeach
@endforeach

		</div>
			</div>
				</div>
				<div class="pdf-footer bottom-placement" style="padding: 0 15px 0;">
					<table width="100%">
						<tr>
							<td width="25%" valign="top" class="text-left">
								<p class="px-10-font">Page {{$pageNumber}} </p>
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
				
<!-- End Page 1 of 1 -->
</html>