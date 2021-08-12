<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link type="text/css" href="{{public_path()}}/progress-report/style.css" rel="stylesheet" />
    <link type="text/css" href="{{public_path()}}/css/offer_letter/pdf-style-v2.css" rel="stylesheet" />
	<title>Payment Plan</title>
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
									<p class="primary-font-color px-16-font text-right line-height-1point2 europa-bold">PAYMENT PLAN</p>
								</td>
							</tr>
						</table>
				</div>
				</div>
                <div class="clearfix" style="height:30px;"></div>
				<div class="pdf-wrapper pdf-body">
                <div class="content">
                        <p class="blue-font-color px-16-font text-center line-height-1">STUDENT INSTALLMENT PLAN OF COURSE FEES <br>
                        {{strtoupper($stud_details['course'])}}</p>
                        <div class="cleafix" style="height: 5px;"></div>
                        <table width="100%" class="package-course">
                            <tbody>
                                <tr>
                                    <td class="blue-bg-color white-font-color text-center" width="15%">Student ID:</td>
                                    <td width="35%">{{$stud_details['student_id']}}</td>
                                    <td class="blue-bg-color white-font-color text-center" width="15%">Student Name:</td>
                                    <td width="35%">{{$stud_details['fullname']}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%" class="package-course">
                            <tbody>
                                <tr>
                                    <td class="blue-bg-color white-font-color text-center" width="15%">Date of Birth:</td>
                                    <td width="35%">{{Carbon\Carbon::parse($stud_details['dob'])->format('d/m/Y')}}</td>
                                    <td class="blue-bg-color white-font-color text-center" width="15%">Email address:</td>
                                    <td width="35%">{{$stud_details['email']}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%" class="package-course">
                            <tbody>
                                <tr>
                                    <td class="blue-bg-color white-font-color text-center" width="15%">Address:</td>
                                    <td width="85%">{{$stud_details['street_addr']}} {{ $stud_details['address']}}</td>
                                </tr>
                            </tbody>
                        </table>
                         {{-- <table width="100%" class="package-course">
                            <tbody>
                                <tr>
                                    <td class="blue-bg-color white-font-color text-center" width="15%">Name of the Agent’s company</td>
                                    <td class="blue-bg-color white-font-color text-center" width="15%">Email of the agent:</td>
                                </tr>
                            </tbody>
                        </table> --}}
                        <div class="cleafix" style="height: 15px;"></div>


                        <table width="100%" class="package-course">
                            <thead>
                                <tr>
                                    <th class="proximanova-bold line-height-1point2 text-center px-11-font" colspan="2" style="padding: 10px;">Balance due after the initial<br>payment: AUD {{number_format($stud_details['course_fee'], 2)}}<br>(rest amount to be paid in monthly instalments after commencement of the first course)</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @if(count($payment_sched) > 0)
                                    @foreach( $payment_sched as $ps)
                                        <tr>
                                            <td class="text-center">{{Carbon\Carbon::parse($ps['due_date'])->format('d/m/Y')}}</td>
                                            <td class="text-center">{{$ps['payable_amount']}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="2">No Installment Plan</td>
                                    </tr>
                                @endif
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="blue-bg-color white-font-color text-center px-11-font" colspan="2" style="padding: 3px;">Proposed Course End Date: {{\Carbon\Carbon::parse($stud_details['end_date'])->format('d/m/Y')}}</td>
                                </tr>
                            </tfoot>
                        </table>
                        <p class="px-10-font text-justify line-height-1point2">Please be advised that the student will be provided with the installment plans before the commencement of the next course. </p>

                        <div class="clearfix" style="height: 30px;"></div>
                    
                        <table width="50%">
                            <tr>
                                <td>
                                    <div>
                                        <p class="blue-font-color px-14-font line-height-1">DECLARATION AND ACCEPTANCE BY APPLICANT: </p>
                                        <div class="clearfix" style="height: 5px;"></div>
                                        <p class="px-11-font">• I, <span class="blue-font-color">{{$stud_details['fullname']}}</span></p>
                                        <p class="px-11-font line-height-1point2"> agree that by signing this declaration, I am accepting the above payment terms and conditions as outlined within this Offer letter. </p>
                                        <div class="clearfix" style="height: 5px;"></div>
                                        <p class="px-11-font line-height-1point2">• I understand that my weekly payable tuition fees for the study period are calculated as:</p>
                                        <div class="clearfix" style="height: 5px;"></div>
                                        <table width="60%">
                                            <tr>
                                                <td class="text-center px-10-font">
                                                    <div class="line-height-1">Total Tuition Fees</div>
                                                    <div class="line-height-1">----------------------------------</div>
                                                    <div class="line-height-1">Total duration (No. of weeks)</div>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="clearfix" style="height: 5px;"></div>
                                        <p class="px-11-font line-height-1point2">• I understand that I have to keep paying the agreed amount according to the student instalment plans for the future
                                            course(s).</p>


                                        <div class="clearfix" style="height: 10px;"></div>
                                        <p class="px-11-font">Signed by Applicant:.........................................................................................................</p>
                                        <p class="px-11-font">Date: </p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div> 
			</div>
			<div class="pdf-footer">
						<table width="100%">
							<tr>
								<td>
									<div class="footer bottom-placement px-10-font text-center primary-font-color">
										<p style="margin-bottom: 2px;">© VORX RTO | Payment Plan</p>
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