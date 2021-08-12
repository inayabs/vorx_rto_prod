<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link type="text/css" href="{{public_path()}}/progress-report/style.css" rel="stylesheet" />
	<title>Invoice</title>
</head>
<body class="exo2-regular position-relative">
	<!-- <div id="page-background" class="overlay">
        <img src="{{public_path()}}/qir-pdf/images/progress-report-bg.jpg" height="100%" width="100%" style="position: absolute; width: 80%;z-index: -1;left: 10%;top:10%;">
     </div>  -->
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper proximanova-regular">
				<div class="pdf-header">
                  <div>
						<table width="100%">
							<tr>
								<td width="50%">
									<div class="eti-logo">
										<!-- <img src="{{public_path()}}/images/logo/vorx_logo.png" alt=""> -->
                                        <img src="{{ $logo_url }}" alt="">
									</div>
								</td>
								<td width="50%">
									<p class="primary-font-color px-16-font text-right line-height-1point2 europa-bold">INVOICE</p>
								</td>
							</tr>
						</table>
				</div>
				</div>
                <div class="clearfix" style="height:30px;"></div>
				<div class="pdf-wrapper pdf-body">
                    <div class="invoice-header">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="50%" valign="top">
                                        <p class="px-12-font line-height-1">{{$com_setting->training_organisation_name}}</p>
                                        <!-- <p class="px-12-font line-height-1">ABN: 42163187862</p>
                                        <br> -->
                                        <p class="px-12-font line-height-1">{{ $com_setting->addr_line1 }}</p>
                                        <p class="px-12-font line-height-1">{{$com_setting->addr_location}} {{ $com_setting->state_identifier }} {{ $com_setting->postcode }}</p>
                                        <p class="px-12-font line-height-1">Phone: {{ $com_setting->telephone_number }}</p>
                                        <p class="px-12-font line-height-1">Email: {{ $com_setting->email_address }}</p>
                                        <br>
                                    </td>
                                    <td width="50%" class="text-right" valign="top">
                                        <p class="px-12-font line-height-1">INVOICE NO: <span>{{ $student_invoice['invoice_number'] }}</span></p>
                                        <p class="px-12-font line-height-1">DATE: 
                                        @if($student_invoice['date'] != null)
                                            <span>{{ \Carbon\Carbon::parse($student_invoice['date'])->format('d/m/Y')}}</span>
                                        @endif
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <br>
                                        <p class="px-12-font line-height-1 europa-bold">TO:</p>
                                        <p class="px-12-font line-height-1">{{ $invoice_details['fullname'] }}</p>
                                        {{-- <p class="px-12-font line-height-1">
                                            @if($invoice_details['street_addr'] != null)
                                                <span>{{ $invoice_details['street_addr']}} </span>
                                             @endif
                                             <br>
                                            @if($invoice_details['address'] != null)
                                                <span>{{ $invoice_details['address'] }}</span>
                                             @endif
                                        </p> --}}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <br>
                                        <table width="100%" class="green-bordered-table">
                                            <thead>
                                                <tr>
                                                    <th width="40%">Course</th>
                                                    <th>Description</th>
                                                    <th>Due Date</th>
                                                    <th>Amount</th>
                                                </tr>   
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="px-14-font line-height-1point2">{{ $invoice_details['course'] }}</td>
                                                    <td class="px-14-font line-height-1point2">
                                                    @if(isset($invoice_details['description']))
                                                        @if($invoice_details['description'] == 'C')
                                                            <span>Concessional</span>
                                                        @elseif($invoice_details['description'] == 'NC')
                                                            <span>Government Funded</span>
                                                        @elseif($invoice_details['description'] == 'FF')
                                                            <span>Fee For Service</span>
                                                        @else
                                                            <span>{{ $invoice_details['description'] }}</span>
                                                        @endif
                                                    @endif
                                                    </td>
                                                    <td class="px-14-font line-height-1point2">
                                                    {{ \Carbon\Carbon::parse($invoice_details['due_date'])->format('d/m/Y')}}
                                                    </td>
                                                    <td class="px-14-font line-height-1point2 text-right">
                                                    @if(isset($invoice_details['amount']))
                                                        <span>{{ $invoice_details['amount'] }}</span>
                                                    @endif
                                                    </td>
                                                    {{--  <td class="text-right">
                                                        @if($invoice_details['course_fee_type'] == 'C')
                                                            @if($student_invoice['amount'] != null)
                                                                <span>${{ $student_invoice['amount'] }}</span>
                                                            @else
                                                                <span>$0</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td class="text-right">
                                                        @if($invoice_details['course_fee_type'] == 'NC')
                                                            @if($student_invoice['amount'] != null)
                                                                <span>${{ $student_invoice['amount'] }}</span>
                                                            @else
                                                                <span>$0</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td class="text-right">
                                                        @if($invoice_details['course_fee_type'] == 'FF')
                                                            @if($student_invoice['amount'] != null)
                                                                <span>${{ $student_invoice['amount'] }}</span>
                                                            @else
                                                                <span>$0</span>
                                                            @endif
                                                        @endif
                                                    </td>  --}}
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <br>
                                        <!-- <p class="px-10-font line-height-1point2"><i>* Co-contribution Fee represents the total non-government subsidized portion of essential training costs for the participant to undertake the qualification which includes total cost to the student to enrol, undertake training and be awarded the qualification.</i></p> -->
                                        <br>
                                        <p class="px-12-font line-height-1">Please note:</p>
                                        <p class="px-12-font line-height-1">Please put in your name and Invoice number as reference when doing payments by direct deposit.</p>
                                        <p class="px-12-font line-height-1">Please deposit the due amount:</p>
                                        @if($bank_details != null)
                                        <table width="100%" class="green-bordered-table">
                                            <tbody>
                                                <tr>
                                                    <td width="30%">BANK</td>
                                                    <td width="70%">{{ $bank_details->bank_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>BSB</td>
                                                    <td>{{ $bank_details->bsb }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Account Name</td>
                                                    <td>{{ $bank_details->account_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Account Number</td>
                                                    <td>{{ $bank_details->account_number }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @endif
                                        <br>
                                        <!-- <p class="px-12-font line-height-1">For refund and complaint and appeals please refer to Refund Policy and Procedure. Also available at http://qld.eti.edu.au/student-support/#student_policies</p> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-center">
                                    <br>
                                    <br>
                                    <br>
                                    THANK YOU FOR BUSINESS!
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
				</div>
			</div>
			<div class="pdf-footer">
						<table width="100%">
							<tr>
								<td>
									<div class="footer bottom-placement px-10-font text-center primary-font-color">
										<!-- <p style="margin-bottom: 2px;">© Elite Training Institute | Invoice Version 1.1 | RTO No. 40965 | RTO CRICOS Code 03470A</p> -->
										<p style="margin-bottom: 2px;">© VORX RTO | Invoice</p>
										<p class=" px-10-font europa-bold">Page 1 of 1</p>
									</div>
								</td>
							</tr>
						</table>
				    </div>
		</div>
	</div>
</body>
</html>