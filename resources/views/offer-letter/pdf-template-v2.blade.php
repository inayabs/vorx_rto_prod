<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" href="{{public_path()}}/css/offer_letter/pdf-style-v2.css" rel="stylesheet" />
	<title>Student Payment Schedule Of Course Fees</title>
	<!-- Page 1 of 8 -->
<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="border-bottom: 5px solid #09455e; padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="50%">
								<div class="eti-logo">
									{{-- @if(!in_array($app_settings[0]->logo_img, ['', null]))
											<img class="img-profile img-fluid w-75" src="{{ asset('/storage/config/images/'.$app_settings[0]->logo_img) }}">
										@else
											<img class="img-profile img-fluid w-75" src="{{ asset('/images/logo/vorx_logo-colored.png') }}">
										@endif --}}
										<img src="{{public_path()}}/images/logo/vorx_logo.png"  class="img-profile img-fluid w-75" alt="">
								</div>
							</td>
							<td width="50%">
								<p class="blue-font-color px-16-font text-right line-height-1point2">OFFER LETTER AND ENROLMENT<br>ACCEPTANCE</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div class="pdf-wrapper" style="padding-top: 10px">
					<!-- <p class="px-10-font"><span class="proximanova-bold">Note:</span> Offer letter is subject to approval of SSVF eligibility by the International admission department of {{ $app_settings[0]->training_organisation_name }} Pty Ltd.</p>
					<div class="cleafix" style="height: 15px;"></div> -->
					<table width="100%" class="px-12-font" cellpadding="0" cellspacing="0" border="0">
						<tbody>
							<tr>
								<td width="50%" valign="top">
									<table width="100%" class="personal-details-no-border" cellpadding="0" cellspacing="0" border="0">
										<tbody>
											<tr>
												<td width="30%" class="blue-font-color" valign="top">Date of Issue: </td>
												<td width="70%">{{ $offerData['issued_date'] != '0000-00-00' ? \Carbon\Carbon::parse($offerData['issued_date'])->format('d/m/Y') : '' }}</td>
											</tr>
											<tr>
												<td width="30%" class="blue-font-color" valign="top">Student ID: </td>
												<td width="70%">{{$offerData['student_id'] ? $offerData['student_id'] : '12321-'.$offerData['old_id']}}</td>
											</tr>
											<tr>
												<td width="30%" class="blue-font-color" valign="top">Email Address: </td>
												<td width="70%">{{$offerData['student_details']['email_personal']}}</td>
											</tr>
											<tr>
												<td width="30%" class="blue-font-color" valign="top">Date of Birth: </td>
												<td width="70%">{{\Carbon\Carbon::createfromFormat('Y-m-d', $offerData['student']['party']['person']['date_of_birth'])->format('d/m/Y')}}</td>
											</tr>
										</tbody>
									</table>
								</td>
								<td width="50%" valign="top">
									<table width="100%" class="personal-details-no-border" cellpadding="0" cellspacing="0" border="0">
										<tbody>
											<tr>
												<td width="30%" class="blue-font-color" valign="top">Title: </td>
												<td width="70%">{{$offerData['student']['party']['person']['prefix']}}</td>
											</tr>
											<tr>
												<td width="30%" class="blue-font-color" valign="top">Family Name: </td>
												<td width="70%">{{$offerData['student']['party']['person']['lastname']}}</td>
											</tr>
											<tr>
												<td width="30%" class="blue-font-color" valign="top">Given Name: </td>
												<td width="70%">{{$offerData['student']['party']['person']['firstname']}}</td>
											</tr>
											<tr>
												<td width="30%" class="blue-font-color" valign="top">Student Address: </td>
												<td width="70%">{{$offerData['student_details']['current_address']}}</td>
											</tr>
											<!-- <tr>
												<td  width="30%" class="blue-font-color"></td>
												<td width="70%" ></td>
											</tr>
											<tr>
												<td  width="30%" class="blue-font-color"></td>
												<td width="70%" ></td>
											</tr> -->
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="cleafix" style="height: 10px;"></div>
					<div class="content">
						<p class="proximanova-bold px-11-font  text-justify">Dear {{$offerData['student']['party']['person']['prefix']}} {{$offerData['student']['party']['name']}},</p>
						<div class="cleafix" style="height: 5px;"></div>
						<p class="proximanova-bold px-11-font  text-justify">RE: Letter of Offer and Acceptance Agreement Conditional <span class="blue-font-color proximanova-bold"><span>
									@if ($offerData['location'] != null)
									{{-- {{$offerData['location'] == 'VIC' ? 'For Victoria ' : 'For Queensland '}} --}}
									For {{$offerData['location'] }}
									@endif
								</span>({{ucfirst($offerData['shore_type'])}})</span></p>
						<p class="px-11-font  text-justify">Thank you for your application to study at {{ $app_settings[0]->training_organisation_name }}. Further to an assessment of your application, we are pleased to offer you a place as an international student in the course/s as outlined below.</p>
						<p class="px-11-font  text-justify">Prior to accepting this offer it is important that you read the pre-enrolment information in student handbook or available from our website at www.vorx.edu.au</p>
						<div class="cleafix" style="height: 10px;"></div>
						<table width="100%" class="package-course" cellpadding="0" cellspacing="0" border="0">
							<thead>
								<tr>
									<th class="proximanova-bold line-height-1 text-center px-12-font no-border" colspan="11" style="padding: 5px 10px;">Course information: Offer letter and Enrolment Acceptance Agreement</th>
								</tr>
								<tr>
									<th class="proximanova-bold px-11-font text-center" width="10%">CRICOS Course Code:</th>
									<th class="proximanova-bold px-11-font text-center" width="22%">Course Code / Course Name</th>
									<th class="proximanova-bold px-11-font text-center">Duration (weeks)</th>
									<th class="proximanova-bold px-11-font text-center">Application Fees (Non-refundable)</th>
									<th class="proximanova-bold px-11-font text-center">Tuition Fees</th>
									<th class="proximanova-bold px-11-font text-center">Material Fees</th>
									<th class="proximanova-bold px-11-font text-center">Course Start Date</th>
									<th class="proximanova-bold px-11-font text-center">Course End Date</th>
									<!-- <th class="proximanova-bold px-11-font text-center">Total Course Fees</th> -->
									<th class="proximanova-bold px-11-font text-center">Total Fees</th>
									<th class="proximanova-bold px-11-font text-center">OSHC(Overseas Student Health Cover)</th>
									<th class="proximanova-bold px-11-font text-center">Delivery Location</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($offerData['course_details'] as $k => $od)
								@php
								if($k == 0){
								$course_name = explode(' - ', $od['course']['name']);
								$course_code = $od['course']['code'];
								}
								$tots = (int) $od['tuition_fees'] + (int) $od['material_fees'];
								$appFee = ($od['order'] == 1 ? $offerData['fees']['application_fee'] : 0.00);
								@endphp
								<tr>
									<td class="text-center">{{$od['cricos_code']}}</td>
									<td class="text-left">{{$od['course']['code']}} {{$od['course']['name']}} </td>
									<td class="text-center">{{$od['week_duration']}}</td>
									<td class="text-center">AUD {{number_format($appFee, 2)}}</td>
									<td class="text-center">AUD {{number_format($od['tuition_fees'], 2)}}</td>
									<td class="text-center">AUD {{number_format($od['material_fees'], 2)}}</td>
									<td class="text-center">{{\Carbon\Carbon::parse($od['course_start_date'])->format('d/m/Y')}}</td>
									<td class="text-center">{{\Carbon\Carbon::parse($od['course_end_date'])->format('d/m/Y')}}</td>
									<!-- <td class="text-center">AUD {{number_format($tots, 2)}}</td> -->
									<td class="text-center">AUD {{number_format($od['tuition_fees'] + ($appFee + $od['material_fees']), 2)}}</td>
									<td class="text-center">AUD {{number_format($offerData['fees']['oshc'], 2)}}</td>
									<td class="text-center">{{$offerData['location']}}</td>
								</tr>
								@endforeach
								<!-- <tr>
									<td class="text-center">098089J</td>
									<td class="text-left">CPC30211 Certificate III in Carpentry </td>
									<td class="text-center">52</td>
									<td class="text-center">AUD 12000.00</td>
									<td class="text-center">AUD 500</td>
									<td class="text-center">20/08/2018</td>
									<td class="text-center">19/08/2019</td>
									<td class="text-center">AUD 12,500</td>
								</tr>
								<tr>
									<td class="text-center" >098090E</td>
									<td class="text-left" >CPC50210 Diploma of Building and Construction (Building) </td>
									<td class="text-center" >52</td>
									<td class="text-center" >AUD 10000.00</td>
									<td class="text-center" >AUD 500</td>
									<td class="text-center" >16/09/2019</td>
									<td class="text-center" >14/09/2020</td>
									<td class="text-center" >AUD 10,500</td>
								</tr> -->
							</tbody>
						</table>
						@if ($offerData['remarks'] != null || $offerData['remarks'] != '')
						<div class="cleafix" style="height: 5px;"></div>
						<p class="px-8-font no-margin line-height-1"><span class="proximanova-bold">Note:</span> {{$offerData['remarks']}}</p>
						@endif
						<div class="cleafix" style="height: 10px;"></div>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tbody>
								<tr>
									<td width="50%" valign="top" style="padding-right: 7px;">
										<table width="100%" class="package-course text-justify" cellpadding="0" cellspacing="0" border="0">
											<thead>
												<tr>
													<th class="proximanova-bold no-border px-12-font" colspan="2">Initial payment required for the issuance of COE(s):</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td width="70%" class="proximanova-bold text-center">Item Description</td>
													<td width="30%" class="proximanova-bold text-center">Amount (AUD)</td>
												</tr>
												<tr>
													<td width="70%">Application Fees:</td>
													<td width="30%" class="text-right">AUD {{number_format($offerData['fees']['application_fee'], 2)}}</td>
												</tr>
												<tr>
													<td width="70%">Material Fees:</td>
													<td width="30%" class="text-right">AUD {{number_format($offerData['fees']['materials_fee'], 2)}}</td>
												</tr>
												<tr>
													<td width="70%">Tuition Fees:</td>
													@php
													// $tuitionFee = $offerData['fees']['payment_required'] - ( $offerData['fees']['application_fee'] + $offerData['fees']['materials_fee'] );
													$tuitionFee = ( $offerData['fees']['application_fee'] + $offerData['fees']['materials_fee'] ) - $offerData['fees']['payment_required']
													@endphp
													<td width="30%" class="text-right">AUD {{number_format($tuitionFee, 2)}}</td>
												</tr>
												<tr>
													<td width="70%">Miscellaneous Fees / OSHC (if applicable):</td>
													<td width="30%" class="text-right">AUD {{number_format($offerData['fees']['oshc'], 2)}}</td>
												</tr>
												<tr>
													<td width="70%" style="line-height: 1 !important;">Total Initial Payment Required for the issuance of the COE (to be deducted from the total fees of the first course):</td>
													<td width="30%" class="text-right">AUD {{number_format($offerData['fees']['payment_required'], 2)}}</td>
												</tr>
												<tr>
													<td colspan="2">
														<p>Notes:</p>
														<ul class="text-justify" style="padding-left: 10px !important; margin-bottom: 0 !important;">
															<li>Initial Payment is the amount required for the issuance of Confirmation of Enrolment (CoE) which is payable in advance or as directed by the {{ $app_settings[0]->training_organisation_name }} and constitute tuition and non-tuition fees towards your courses.</li>
															<li>All fees are in Australian dollars and are subject to change without notice.</li>
															<li>The balance due amount may be paid via Direct Debit based on agreed monthly payment plan, copy of the Student Payment Schedule of Course Fees attached.</li>
															<li>Late payment of fees may result in:</li>
															<li>The possibility of {{ $app_settings[0]->training_organisation_name }} reporting you to the Department of Home Affairs (DHA) and cancelling your enrolment.</li>
															<li>You will be informed about any changes done to your enrolment well in advance according to the {{ $app_settings[0]->training_organisation_name }} policies and procedures.</li>
														</ul>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
									<td width="50%" valign="top" style="padding-left: 7px;">
										<p class="blue-font-color">CONDITIONS:</p>
										<ol style="list-style-type: lower-alpha;text-align: justify; font-size: 10px;" class="line-height-1point2">
											<li>Please be advised that issuance of this offer letter does not guarantee the issuance of the eCOE until all the eligibility requirements are met.</li>
											<li>You must demonstrate an adequate level of ACSF in LLN test conducted by {{ $app_settings[0]->training_organisation_name }} at campus or under the supervision of the {{ $app_settings[0]->training_organisation_name }} representative or proficiency in English language to the level acceptable to Department of Home Affairs and as published in {{ $app_settings[0]->training_organisation_name }} Student Handbook.</li>
											<li>If you are currently studying at another provider and have completed less than 6 months of the principal course, a Letter of Release must be obtained from your current provider and submitted to {{ $app_settings[0]->training_organisation_name }} with the acceptance of this offer prior to issuance of COE(s), or</li>
											<li>Confirmation those 6 months of your principal course has passed or will pass before the commencement date of this course (or your first course for packaged courses),or</li>
											<li>You want to study a concurrent course at {{ $app_settings[0]->training_organisation_name }} along with your current principal course. Please see our one of the student support officers for further information in this regard.</li>
											<li>You will be required to undertake the Pre-training review and LLN test on the day of orientation as part of your enrollment process. Please make yourself familiar with {{ $app_settings[0]->training_organisation_name }} policies and procedures, which can be found at {{ $app_settings[0]->site_url }} website.</li>
											<li>Offer letter is subject to eligibility assessment by the international admission department/ {{ $app_settings[0]->training_organisation_name }} delegate/Student Support Officer of {{ $app_settings[0]->training_organisation_name }} Pty Ltd.</li>
											<li>Any gap in the study needs to be justified by providing information to {{ $app_settings[0]->training_organisation_name }} Admissions Officer/Student Support officer or {{ $app_settings[0]->training_organisation_name }} delegate.</li>
											<li>You must satisfy {{ $app_settings[0]->training_organisation_name }} that you have the intention to stay in Australia Temporarily.</li>
										</ol>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">© {{ $app_settings[0]->training_organisation_name }} - Offer Letter And Enrolment Acceptance Conditional Version 1.4 | RTO {{ $app_settings[0]->training_organisation_id }} | CRICOS No. 0000</p>
						<!-- <p>Page 1 of 14</p> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 1 of 8 -->
<!-- Start Page 2 of 8 -->

<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="border-bottom: 5px solid #09455e; padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="50%">
								<div class="eti-logo">
									{{-- @if(!in_array($app_settings[0]->logo_img, ['', null]))
											<img class="img-profile img-fluid w-75" src="{{ asset('/storage/config/images/'.$app_settings[0]->logo_img) }}">
										@else
											<img class="img-profile img-fluid w-75" src="{{ asset('/images/logo/vorx_logo-colored.png') }}">
										@endif --}}
										<img src="{{public_path()}}/images/logo/vorx_logo.png"  class="img-profile img-fluid w-75" alt="">
								</div>
							</td>
							<td width="50%">
								<p class="blue-font-color px-16-font text-right line-height-1point2">OFFER LETTER AND ENROLMENT<br>ACCEPTANCE</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div class="pdf-wrapper">
					<div class="content">
						<table width="100%" class="text-justify line-height-1point2" cellpadding="0" cellspacing="0" border="0">
							<tbody>
								<tr>
									<td width="50%" valign="top" style="padding-right: 7px;">
										<p class="px-12-font blue-font-color">VALIDITY OF OFFER</p>
										<p class="px-10-font line-height-1point2">This offer is only valid for 30 days from the date of issuance. A place in this course(s) is not confirmed until {{ $app_settings[0]->training_organisation_name }} receives the requested payment, the signed Enrolment Acceptance agreement (as attached) and issues you with a Confirmation of Enrolment (COE).</p>
										<div class="clearfix" style="height: 15px;"></div>
										<p class="px-12-font blue-font-color">PAYMENT REQUIRED FOR ACCEPTANCE</p>
										<p class="px-10-font line-height-1point2">You can choose any from the following methods to make your payment to {{ $app_settings[0]->training_organisation_name }}.</p>
									</td>
									<td width="50%" valign="top" style="padding-left: 7px;">
										<p class="px-12-font blue-font-color">COURSE DELIVERY</p>
										<p class="px-10-font line-height-1point2">{{ $app_settings[0]->training_organisation_name }} academic year is typically divided into study periods commonly referred to as Term1, Term 2, or more study periods. Study periods are course specific. {{ $app_settings[0]->training_organisation_name }}has determined that one study period consists of 24 weeks for any course which is 52 weeks or longer. For the shorter courses which 26 weeks or lesser, {{ $app_settings[0]->training_organisation_name }}will be considering the study period of 10 or 11 weeks for the purpose of monitoring course progress. The course will be delivered 20 hours per week in a classroom and the mode of delivery will be face to face. The students are required to attend classes according to time table. {{ $app_settings[0]->training_organisation_name }}will be contacting you to inform you about the date of orientation and location. Every student needs to attend the orientation program; failure to attend this program may result in cancellation of the enrollment at vorx.</p>
									</td>
								</tr>
							</tbody>
						</table>
						<p class="px-14-font blue-font-color">1. Direct Deposit</p>
						<div class="clearfix" style="height: 5px;"></div>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tbody>
								<tr>
									<td width="50%">
										<table width="100%" class="package-course" cellpadding="0" cellspacing="0" border="0">
											<thead>
												<tr>
													<th class="proximanova-bold no-border" width="40%" colspan="2" style="padding: 8px 10px;">Please forward your payment to:</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td width="40%" style="padding: 8px 10px;">Account Name:</td>
													<td width="60%" style="padding: 8px 10px;">{{ $app_settings[0]->training_organisation_name }}</td>
												</tr>
												<tr>
													<td style="padding: 8px 10px;">Bank’s name:</td>
													<td style="padding: 8px 10px;">XXXX XXXXX Bank</td>
												</tr>
												<tr>
													<td style="padding: 8px 10px;">BSB:</td>
													<td style="padding: 8px 10px;">000-000</td>
												</tr>
												<tr>
													<td style="padding: 8px 10px;">Account Number:</td>
													<td style="padding: 8px 10px;">00-000-000</td>
												</tr>
												<tr>
													<td style="padding: 8px 10px;">Swift Code:</td>
													<td style="padding: 8px 10px;">0000000000</td>
												</tr>
											</tbody>
										</table>
									</td>
									<td width="50%" style="border: 1px solid #78b643; font-size: 12px;padding: 10px;">
										<p class="px-11-font text-justify proximanova-bold line-height-1point2" style="color:#000;"><span class="text-italic">Note: The Student will start paying the remaining balance according to student payment schedule.</span></p>
										<p class="text-justify text-italic line-height-1point2">Please ensure that you have read and understand the {{ $app_settings[0]->training_organisation_name }} fee and refund policy. In order to accept this offer, please sign the declaration below on both copies sent to you and return one copy to the College. Please retain the second copy for your records. We look forward to welcoming you to {{ $app_settings[0]->training_organisation_name }} where you will be provided with high quality training and support, along with excellent career opportunities. Should you have any queries please do not hesitate to contact our Administration office.</p>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="clearfix" style="height: 5px;"></div>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tbody>
								<tr>
									<td width="50%" valign="top" style="padding-right: 7px;">
										<p class="px-11-font"><span class="blue-font-color px-14-font">2. Bank transfer</span> (bank details as above)</p>
										<p class="px-11-font text-justify line-height-1point2">For direct deposit of bank transfer, please provide your name as reference in order to easily track your payment.</p>
										<div class="clearfix" style="height: 5px;"></div>
										<p class="px-11-font"><span class="blue-font-color px-14-font">3. Online via website:</span></p>
										<p class="px-11-font text-justify line-height-1point2">Please go to <span class="blue-font-color">http://{{ $app_settings[0]->site_url }}/payment-form/</span> and provide your name as reference in order to easily track your payment.</p>
										<div class="clearfix" style="height: 5px;"></div>
										<p class="px-11-font line-height-1point2"><span class="blue-font-color px-14-font">4. Bank Draft:</span>Bank draft should be made payable to {{ $app_settings[0]->training_organisation_name }}.</p>
									</td>
									<td width="25%" valign="top" style="padding-left: 7px;"></td>
									<td width="25%" valign="top" style="padding-left: 7px;">
										<p class="px-14-font text-right">Yours sincerely,</p>
										<div class="clearfix" style="height: 15px;"></div>
										<div>
											<div class="signature-wrapper">
												{{-- <center><img src="{{public_path()}}/images/offer-letter/DALBIR-SIGNATURE12.png" alt="signature here"></center> --}}
											</div>
											<div class="text-center" style="border-top:2px solid #78b643;">
												<p class="text-uppercase line-height-1point2">John Doe</p>
												<p class="text-uppercase line-height-1point2">Training Manager</p>
											</div>
										</div>

									</td>
								</tr>
							</tbody>
						</table>
						<div class="clearfix" style="height: 15px;"></div>
						<p class="px-14-font blue-font-color text-uppercase width-100-percent" style="border-bottom: 3px solid #09455e;border-top: 3px solid #09455e;padding:5px 0;">ENROLMENT ACCEPTANCE AGREEMENT</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-10-font text-justify line-height-1point2">Prior to signing and accepting this enrolment acceptance, please read and ensure you understand the Terms and Conditions of Enrolment. You must also read the Student Handbook, Policies and Procedures on {{ $app_settings[0]->training_organisation_name }}‘s website carefully. Please contact our office if you prefer that we send you these documents via email or post.</p>
						<div class="clearfix" style="height: 15px;"></div>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tbody>
								<tr>
									<td width="50%" valign="top" style="padding-right: 7px;">
										<p class="px-14-font blue-font-color text-uppercase">ACADEMIC MISCONDUCT</p>
										<p class="px-10-font text-justify line-height-1point2">Students are also required to adhere to the Code of Conduct. If a student is found to have acted in a way that {{ $app_settings[0]->training_organisation_name }} deems to be misconduct, it may impair their successful completion of the course.</p>
										<div class="clearfix" style="height: 5px;"></div>
										<p class="px-10-font text-justify line-height-1point2">As outlined in the Code of Conduct, students are expected to approach training and assessment activities in an ethical manner. At {{ $app_settings[0]->training_organisation_name }}, our students strive to conduct themselves with integrity and do not engage in plagiarism or cheating. Confusion in relation to the definitions of both plagiarism and cheating can often occur and have been detailed below to avoid this occurrence and to eliminate their happening due to claims of confusion.</p>
										<div class="clearfix" style="height: 5px;"></div>
										<p class="px-10-font text-justify line-height-1point2"><span class="blue-font-color text-uppercase">CHEATING.</span>Cheating is the use of any means to gain an unfair advantage during the assessment process. Cheating may be (but not limited too) copying a friends answers, using mobile phones or other electronic devises during closed book assessments, bringing in and referring to pre prepared written answers in a closed book assessment and referring to texts during closed book assessments amongst others. Cheating in any form during assessments will result in the student’s assessment submission being invalidated.</p>
									</td>
									<td width="50%" valign="top" style="padding-left: 7px;">
										<p class="px-10-font text-justify line-height-1point2"><span class="blue-font-color text-uppercase">PLAGIARISM.</span> Plagiarism is the wrongful close imitation, or copying and publication, of another person’s language, thoughts, ideas, or expressions, and the representation of them as one's own work. This includes copying all or pieces of another students work and representing it as your own. Plagiarism will also lead to the student’s submission of the applicable work being invalidated. If students are including other people’s work in submissions e.g. passages from books or websites, then reference should be made to the source. For further information on what constitutes plagiarism please refer to: <span class="blue-font-color">http://www.plagiarism.org/</span> and refer to the Plagiarism policy of vorx. Submitting plagiarised work during assessments will result in the student’s assessment submission being invalidated.</p>
										<div class="clearfix" style="height: 5px;"></div>
										<p class="px-10-font text-justify line-height-1point2">Cheating and or plagiarism during assessments will be treated as a breach of the Code of Conduct and is deemed to be ‘Academic Misconduct’ and may lead to the student being removed from the course. No refund is applicable to the student in such circumstances.</p>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="clearfix" style="height: 15px;"></div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">© {{ $app_settings[0]->training_organisation_name }}- Offer Letter And Enrolment Acceptance Conditional Version 1.4 | RTO 0000 | CRICOS No. 0000</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 2 of 14 -->

<!-- Start Student Payment Schedule Of Course Fees -->

<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="border-bottom: 5px solid #09455e; padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%">
						<tr>
							<td width="50%">
								<div class="eti-logo">
									{{-- @if(!in_array($app_settings[0]->logo_img, ['', null]))
											<img class="img-profile img-fluid w-75" src="{{ asset('/storage/config/images/'.$app_settings[0]->logo_img) }}">
										@else
											<img class="img-profile img-fluid w-75" src="{{ asset('/images/logo/vorx_logo-colored.png') }}">
										@endif --}}
										<img src="{{public_path()}}/images/logo/vorx_logo.png"  class="img-profile img-fluid w-75" alt="">
								</div>
							</td>
							<td width="50%">
								<p class="blue-font-color px-16-font text-right line-height-1">OFFER LETTER AND ENROLMENT<br>ACCEPTANCE</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div class="pdf-wrapper">
					<div class="cleafix" style="height: 5px;"></div>
					<div class="content">
						<h2 class="blue-font-color px-16-font">STUDENT INSTALLMENT PLAN OF COURSE FEES {{$offerData['course_details'][0]['course']['code']}} - {{strtoupper($offerData['course_details'][0]['course']['name'])}}</h2>
						<div class="cleafix" style="height: 5px;"></div>
						<table width="100%" class="package-course">
							<tbody>
								<tr>
									<td class="blue-bg-color white-font-color text-center" width="15%">Date of Issue:</td>
									<td width="35%">{{\Carbon\Carbon::parse($offerData['issued_date'])->format('d/m/Y')}}</td>
									<td class="blue-bg-color white-font-color text-center" width="15%">Student ID:</td>
									<td width="35%">{{$offerData['student_id'] ? $offerData['student_id'] : '12321-'.$offerData['old_id']}}</td>
								</tr>
							</tbody>
						</table>
						<table width="100%" class="package-course">
							<tbody>
								<tr>
									<td class="blue-bg-color white-font-color text-center" width="15%">Student Name:</td>
									<td width="85%">{{$offerData['student']['party']['name']}}</td>
								</tr>
							</tbody>
						</table>
						<table width="100%" class="package-course">
							<tbody>
								<tr>
									<td class="blue-bg-color white-font-color text-center" width="15%">Date of Birth:</td>
									<td width="35%">{{\Carbon\Carbon::createFromFormat('Y-m-d', $offerData['student']['party']['person']['date_of_birth'])->format('d/m/Y')}}</td>
									<td class="blue-bg-color white-font-color text-center" width="15%">Email address:</td>
									<td width="35%">{{$offerData['student_details']['email_personal']}}</td>
								</tr>
							</tbody>
						</table>
						<table width="100%" class="package-course">
							<tbody>
								<tr>
									<td class="blue-bg-color white-font-color text-center" width="15%">Address:</td>
									<td width="85%">{{$offerData['student_details']['current_address']}}</td>
								</tr>
							</tbody>
						</table>
						<table width="100%" class="package-course">
							<tbody>
								<tr>
									<td class="blue-bg-color white-font-color text-center" width="15%">Name of the Agent’s company</td>
									<td class="blue-bg-color white-font-color text-center" width="15%">Email of the agent:</td>
								</tr>
							</tbody>
						</table>
						<div class="cleafix" style="height: 15px;"></div>


						<table width="100%" class="package-course">
							<thead>
								<tr>
									<th class="proximanova-bold line-height-1point2 text-center px-11-font" colspan="2" style="padding: 10px;">Balance due after the initial<br>payment: AUD {{number_format($offerData['fees']['balance_due'], 2)}}<br>(rest amount to be paid in monthly instalments after commencement of the first course)</th>
								</tr>
							</thead>
							<tbody>
								@foreach( $breakdowns[0] as $bd)
								<tr>
									<td class="text-center">{{$bd['due_date']}}</td>
									<td class="text-center">{{$bd['payable']}}</td>
								</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<td class="blue-bg-color white-font-color text-center px-11-font" colspan="2" style="padding: 3px;">Proposed Course End Date: {{\Carbon\Carbon::parse($offerData['course_details'][0]['course_end_date'])->format('d/m/Y')}}</td>
								</tr>
							</tfoot>
						</table>
						<p class="px-10-font text-justify line-height-1point2">Please be advised that the student will be provided with the installment plans before the commencement of the next course. </p>

						<div class="clearfix" style="height: 30px;"></div>
						@if($page == 1)
						<table width="100%">
							<tr>
								<td>
									<div>
										<h2 class="blue-font-color px-14-font">DECLARATION AND ACCEPTANCE BY APPLICANT: </h2>
										<div class="clearfix" style="height: 5px;"></div>
										<p class="px-11-font">• I, <span class="blue-font-color">{{$offerData['student']['party']['name']}}</span></p>
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
						@endif
					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p>© {{ $app_settings[0]->training_organisation_name }} - Offer Letter And Enrolment Acceptance Conditional Version 1.4 | RTO 0000 | CRICOS No. 0000</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page Student Payment Schedule Of Course Fees -->
@if($page != 1)
<!-- Additional Student Payment Schedule of Course Fees -->

<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="border-bottom: 5px solid #09455e; padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%">
						<tr>
							<td width="50%">
								<div class="eti-logo">
									{{-- @if(!in_array($app_settings[0]->logo_img, ['', null]))
											<img class="img-profile img-fluid w-75" src="{{ asset('/storage/config/images/'.$app_settings[0]->logo_img) }}">
										@else
											<img class="img-profile img-fluid w-75" src="{{ asset('/images/logo/vorx_logo-colored.png') }}">
										@endif --}}
								</div>
							</td>
							<td width="50%">
								<p class="blue-font-color px-16-font text-right line-height-1">OFFER LETTER AND ENROLMENT<br>ACCEPTANCE</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div class="pdf-wrapper">
					<div class="cleafix" style="height: 5px;"></div>
					<div class="content">
						<h2 class="blue-font-color px-16-font">STUDENT PAYMENT SCHEDULE OF COURSE FEES</h2>
						<div class="cleafix" style="height: 5px;"></div>
						<table width="100%" class="package-course">
							{{-- <!-- <thead>
								<tr>
									<th class="proximanova-bold line-height-1point2 text-center px-11-font" colspan="3" style="padding: 10px;"> Balance due<br>(rest amount to be paid in monthly instalments after commencement of the first course)</th>
									<th class="proximanova-bold line-height-1point2 text-center px-11-font" style="padding: 10px;">AUD {{number_format($offerData['course_package']['balance_due'],2)}}</th>
								</tr>
								<tr>
									<th class="proximanova-bold px-11-font text-center" width="25%">Due Date</th>
									<th class="proximanova-bold px-11-font text-center" width="25%">Payable	</th>
									<th class="proximanova-bold px-11-font text-center" width="25%">Paid Receipts/ Date</th>
									<th class="proximanova-bold px-11-font text-center" width="25%">Unpaid</th>
								</tr>
							</thead> --> --}}
							<tbody>
								@foreach( $breakdowns as $k => $v)
								@if( $k != 0 )
								@foreach( $v as $bd )
								<tr>
									<td class="text-center">lorem</td>
									<td class="text-center">lorem</td>
								</tr>
								@endforeach
								@endif
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<td class="blue-bg-color white-font-color text-center px-11-font" colspan="2" style="padding: 3px;">Proposed Course End Date: 19/08/2019</td>
								</tr>
							</tfoot>
						</table>
						<div class="clearfix" style="height: 30px;"></div>
						<table width="55%">
							<tr>
								<td>
									<div>
										<h2 class="blue-font-color px-14-font">DECLARATION AND ACCEPTANCE BY APPLICANT: </h2>
										<div class="clearfix" style="height: 5px;"></div>
										<p class="px-11-font">I, <span class="blue-font-color">{{$offerData['student']['party']['name']}}</span></p>
										<p class="px-11-font line-height-1point2"> agree that by signing this declaration, I am accepting the above payment terms and conditions as outlined within this Offer letter. </p>
										<div class="clearfix" style="height: 10px;"></div>
										<p class="px-11-font">Signed by Applicant:.........................................................................................................</p>
										<p class="px-11-font">Date: </p>
									</div>
								</td>
							</tr>
						</table>
					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p>© {{ $app_settings[0]->training_organisation_name }} - Offer Letter And Enrolment Acceptance Conditional Version 1.4 | RTO 0000 | CRICOS No. 0000</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- END of Additional Student Payment Schedule of Course Fees -->
@endif

<!-- Start Page 3 of 8 -->

<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="border-bottom: 5px solid #09455e; padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="50%">
								<div class="eti-logo">
									{{-- @if(!in_array($app_settings[0]->logo_img, ['', null]))
											<img class="img-profile img-fluid w-75" src="{{ asset('/storage/config/images/'.$app_settings[0]->logo_img) }}">
										@else
											<img class="img-profile img-fluid w-75" src="{{ asset('/images/logo/vorx_logo-colored.png') }}">
										@endif --}}
										<img src="{{public_path()}}/images/logo/vorx_logo.png"  class="img-profile img-fluid w-75" alt="">
								</div>
							</td>
							<td width="50%">
								<p class="blue-font-color px-16-font text-right line-height-1point2">OFFER LETTER AND ENROLMENT<br>ACCEPTANCE</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div class="pdf-wrapper">
					<div class="content">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tbody>
								<tr>
									<td width="50%" valign="top" style="padding-right: 7px;">
										<p class=" blue-font-color px-11-font line-height-1point2">FEE CHARGES AND REFUNDS POLICY</p>
										<p class="px-11-font text-justify line-height-1point2"><span class="blue-font-color ">Purpose</span>. This policy and procedure has been prepared to ensure that {{ $app_settings[0]->training_organisation_name }}operates a fair and equitable process for the management of both the collection of fees and the repayment of fees in the case of a student withdrawing from their course of study.</p>
										<p class="px-11-font text-justify line-height-1point2">This policy and procedure is in line with legislation from the national code 2018 and the ESOS Act specifications under section 46D(7) and 47E(4). </p>
										<div class="clearfix" style="height: 10px;"></div>
										<p class="px-11-font text-justify line-height-1point2"><span class="blue-font-color ">Scope</span>. This policy and procedure applies to all {{ $app_settings[0]->training_organisation_name }}International students.</p>
										<p class="px-11-font text-justify line-height-1point2"><span class="blue-font-color ">General Guidelines</span></p>
										<ul class="px-11-font text-justify no-margin paragraph-list">
											<li class="line-height-1point2">Refund application requests must be made in writing on the refund request form, the refund request form may be downloaded from the Vorx website.</li>
											<li class="line-height-1point2">Filled in form must be submitted with the administration department. </li>
											<li class="line-height-1point2">The Application fees of AUD250.00 are not refundable. The course fees will be refunded as per the table below.</li>
											<li class="line-height-1point2">The Accounts department will process and approve the refund amount (if applicable) based on the circumstances listed below.</li>
											<li class="line-height-1point2">Refund will be made directly to the account stated in the refund request form and the student will be informed about the same via an email. All refunds will be made in Australian Dollars.</li>
											<li class="line-height-1point2">If the student is not eligible for any refund, based on the circumstances as stated below, the student shall be informed of the same via an email/letter.</li>
											<li class="line-height-1point2">Any other circumstances which have not been listed below in the table, the management of {{ $app_settings[0]->training_organisation_name }}will decide the refund. In most of the cases, the students will be refunded after deducting the application fees.</li>
											<li class="line-height-1point2">Any refund given will be recorded in the Student Information System so that each student’s financial status is known.</li>
											<li class="line-height-1point2">The student has right to lodge an appeal with the institute if they are not satisfied with the decision /outcome of the refund request.</li>
										</ul>
										<p class="px-11-font text-justify"><span class="blue-font-color ">Definition</span></p>
										<p class="px-11-font text-justify line-height-1point2"><span class="blue-font-color ">Electronic Confirmation of Enrolment (eCoE):</span> An official document printed via the PRISMS systems on behalf of the Australian government confirming the enrolment of the student in the course. This form is required for a student to apply for a student visa.</p>
										<p class="px-11-font text-justify line-height-1point2"><span class="blue-font-color ">Course Commencement Date:</span> Refers to the start date indicated on the first eCoE issued by the Institute. This does not refer to the deferred or subsequent eCoE.</p>
										<p class="px-11-font text-justify line-height-1point2"><span class="blue-font-color ">Course Money:</span>The money received by the Institute for providing the course the course to the students which includes: tuition fees, any amount received that must be paid to a registered health provider on behalf of the student, airport pick-up, accommodation booking and board, and any other amount paid by the student to the Institute to undertake the course.</p>
										<p class="px-11-font text-justify line-height-1point2"><span class="blue-font-color">Direct International Student:</span> People who is enrolled at the Institute and includes both prospective and currently enrolled students who are overseas students as defined in the National Code of Practice for Providers of Education and Training to Overseas Students and hold a student visa.</p>
										<p class="px-11-font text-justify line-height-1point2"><span class="blue-font-color">Enrolment Fee (Non-academic):</span> The fee payable when an application is made to {{ $app_settings[0]->training_organisation_name }}for an enrolment to a course or qualification. This fee is normally non-refundable fee covering the cost of registration. The enrolment fee is subject to change.</p>
										<p class="px-11-font text-justify line-height-1point2"><span class="blue-font-color">Onshore Students:</span> Students who are applying for student visa within Australia.</p>
										<p class="px-11-font text-justify line-height-1point2"><span class="blue-font-color">Offshore Students:</span> Students who are applying for student visa outside Australia.</p>
										<p class="px-11-font text-justify line-height-1point2"><span class="blue-font-color">Local International Students:</span> A person granted an initial visa to attend another Australian education institute and wants to extend that visa by enrolling at the Institute.</p>
									</td>
									<td width="50%" valign="top" style="padding-left: 7px;">
										<p class="px-11-font text-justify line-height-1point2"><span class="blue-font-color ">Tuition Fees (Academic):</span> The amount paid to enable the student to undertake the course as indicated in the Student Agreement and the Letter of Offer under course fees.</p>
										<p class="px-11-font text-justify line-height-1point2"><span class="blue-font-color ">Incidental Fees (Non-academic):</span> All other fees that is not included in the Tuition Fees or Enrolment Fee. E.g. Materials Fees, Airport Pickup etc.</p>
										<p class="px-11-font text-justify line-height-1point2"><span class="blue-font-color ">Deposit Fees (Academic):</span> Fees paid in advance prior to commencement of the course or a study period.</p>
										<p class="px-11-font text-justify line-height-1point2"><span class="blue-font-color ">TPS:</span>Tuition Protection Scheme (enacted on 20th March 2012 as part of the Government’s second phase response to the Baird Review) replacing Tuition Assurance Scheme and ESOS Assurance Fund.</p>
										<p class="px-11-font text-justify line-height-1point2"><span class="blue-font-color ">Application Fees:</span>Fee paid by the student (or third party) to {{ $app_settings[0]->training_organisation_name }}for the cost of processing a student application. This fee is not part of course fee.</p>
										<p class="px-11-font text-justify line-height-1point2"><span class="blue-font-color ">Reassessment fee:</span>Students are permitted two attempts for each assessment task. The re-assessment fee is applied after the student has failed to demonstrate competence in an assessment task after two attempts.</p>
										<p class="px-11-font text-justify line-height-1point2"><span class="blue-font-color ">Provider default:</span>In the unlikely event that the College is unable to deliver your course in full, you will be offered a refund of all the unused tuition fees paid to date. The refund will be paid within 14 working days of the day on which the course ceased being provided.</p>
										<p class="px-11-font text-justify line-height-1point2">Alternatively, you may be offered enrolment in a suitable alternative course by the College at no extra cost to you. Students have the right to choose whether they prefer a full refund of course fees, or to accept a place in another course. If you choose placement in another suitable course, we will ask you to sign a document to indicate that you accept the placement. If the College is unable to provide a refund or place you in an alternative course our Tuition Protection Service (TPS) is provided.</p>
										<p class="px-11-font text-justify line-height-1point2"><span class="blue-font-color ">Student default:</span>If a student withdraws from a course or has their enrolment cancelled by the college (e.g. for not maintaining satisfactory course progress, breaching the {{ $app_settings[0]->training_organisation_name }}Code of conduct, not paying fees, any other conditions as per the ESOS Act).</p>
										<div class="clearfix" style="height: 10px;"></div>
										<p class="px-11-font text-justify line-height-1point2"><span class="blue-font-color ">Procedure</span></p>
										<ul class="px-11-font text-justify no-margin paragraph-list">
											<li class=""><span class="blue-font-color ">The student is required to complete a Refund Request Form:</span>
												<ul class="px-11-font text-justify no-margin paragraph-list">
													<li class="text-justify line-height-1point2">The completed form is then handed over to the Student Services/Administration Officer/Student Support officer</li>
													<li class="text-justify line-height-1point2">The Student Services/Administration Officer advises the applicant that the turnaround time is a maximum of 14 working days. </li>
													<li class="text-justify line-height-1point2">The Administration Officer then takes the completed application to the CEO / Compliance Manager</li>
													<li class="text-justify line-height-1point2">Authorised delegate for review.</li>
													<li class="text-justify line-height-1point2">The CEO / Compliance Manager (Director) then reviews the application and checks it against the eligibility of the refund.</li>
													<li class="text-justify line-height-1point2">If the applicant is eligible for a refund, then a cheque or bank transfer into nominated account is processed for the amount to be refunded.</li>
													<li class="text-justify line-height-1point2">The applicant is sent an outcome letter and is kept in the student file as well.</li>
													<li class="text-justify line-height-1point2">If the applicant is not onshore, then the amount would be refunded to either the student /nominated person (on consent of the applicant) and a record of the same is kept.</li>
												</ul>
											</li>
										</ul>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">© {{ $app_settings[0]->training_organisation_name }}- Offer Letter And Enrolment Acceptance Conditional Version 1.4 | RTO 0000 | CRICOS No. 0000</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 3 of 8 -->
<!-- Start Page 4 of 8 -->

<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="border-bottom: 5px solid #09455e; padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="50%">
								<div class="eti-logo">
									{{-- @if(!in_array($app_settings[0]->logo_img, ['', null]))
											<img class="img-profile img-fluid w-75" src="{{ asset('/storage/config/images/'.$app_settings[0]->logo_img) }}">
										@else
											<img class="img-profile img-fluid w-75" src="{{ asset('/images/logo/vorx_logo-colored.png') }}">
										@endif --}}
										<img src="{{public_path()}}/images/logo/vorx_logo.png"  class="img-profile img-fluid w-75" alt="">
								</div>
							</td>
							<td width="50%">
								<p class=" blue-font-color px-16-font text-right line-height-1point2">OFFER LETTER AND ENROLMENT<br>ACCEPTANCE</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div class="pdf-wrapper">
					<div class="content">
						<p class="px-11-font line-height-1point2">The various situations applicable for refund are highlighted in the table below.</p>
						<table width="100%" class="package-course px-11-font" cellpadding="0" cellspacing="0" border="0">
							<thead>
								<tr>
									<th width="40%" colspan="2" class="proximanova-bold px-12-font text-center no-border">FEE REFUND CONDITIONS</th>
									<th width="60%" class="proximanova-bold px-12-font text-center no-border">REFUND APPLICABLE</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td colspan="2" width="40%" valign="top">
										<div>
											<p class="blue-font-color">1.0 Provider Default</p>
											<div class="clearfix" style="height: 5px;"></div>
											<p class="px-11-font line-height-1">Provider default is applicable in the following situations.</p>
											<ul style="list-style-type: lower-roman; margin-left: 10px;" class="px-11-font text-justify no-margin paragraph-list">
												<li class="text-justify px-11-font line-height-1"> the course does not begin on the agreed commencement date, or</li>
												<li class="text-justify px-11-font line-height-1"> the course ceases to be provided at any time after it commences but before it is completed, or</li>
												<li class="text-justify px-11-font line-height-1"> the course is not provided in full to the student because a sanction has been imposed on the registered provider or any other reason.</li>
											</ul>
										</div>
									</td>
									<td width="60%" valign="top">
										<div class="px-11-font line-height-1">
											<p class="text-justify">This applies to all students at Vorx.</p>
											<div class="clearfix" style="height: 5px;"></div>
											<p class="text-justify">In the unlikely event that the college is unable to deliver your course in full, you will be offered a refund of any Tuition Fee paid in advance for the default course. The refund amount will be calculated as follows: </p>
											<p class="text-justify">The refund amount = <span class="text-italic">weekly tuition fee x the number of weeks in the default period</span></p>
											<p class="text-justify">a. The weekly tuition fee = total tuition fee for the course / number of calendar days in the course x 7. This amount is rounded up to the nearest whole dollar.</p>
											<p class="text-justify">b. <span class="text-italic">The number of weeks in the default period</span> = number of calendar days from the default day to the end of the period to which the payment relates / 7 </p>
											<p class="text-justify">The refund will be paid to you within 2 weeks of the day on which the course ceased being provided. Alternatively, you may be offered enrolment in an alternative course by the College at no extra cost. You have the right to choose whether you would prefer a refund of course fees, or to accept a place at another college. If you choose placement in another course, we will ask you to sign a document to indicate that you accept the placement. If the College is unable to provide a refund or place you in an alternative course the Tuition Protection Service will be responsible for providing refunds or providing assistance to locate an alternative. However, students are primarily responsible for finding another college which will accept them into an alternative course</p>
										</div>
									</td>
								</tr>
								<tr>
									<td width="20%" valign="top">
										<div>
											<p class="blue-font-color">2.0 Visa refused before course commencement</p>
										</div>
									</td>
									<td width="20%" valign="top">
										<div>
											<p class="blue-font-color">2.1 In the event where student’s initial visa is not granted.</p>
										</div>
									</td>
									<td width="60%" valign="top">
										<div>
											<p class="text-justify px-11-font line-height-1">In the event that the student’s visa has been refused, the refund amount shall be calculated as follows under section 9 of the refund specifications:</p>

											<p class="text-justify px-11-font line-height-1">The refund amount = the total course fee minus 5% of the course fee received up to a maximum of $500 (whichever is lesser the amount).</p>

											<p class="text-justify px-11-font line-height-1">The total course fee also includes any non-tuition fee paid.</p>
										</div>
									</td>
								</tr>
								<tr>
									<td width="20%" valign="top"></td>
									<td width="20%" valign="top">
										<div>
											<p class="text-justify blue-font-color line-height-1">2.2 In the event where a student enrols in a Package Program and the first course has commenced and the student visa is refused before the commencement of second course.</p>
										</div>
									</td>
									<td width="60%" valign="top">
										<div class="px-11-font line-height-1">
											<p class="text-justify">The refund amount will be calculated for the student for the commenced course as follows</p>
											<p class="text-justify">The refund amount = <span class="text-italic">weekly tuition fee x the number of weeks in the default period</span><br>where</p>
											<p class="text-justify">a. <span class="text-italic">The weekly tuition fee</span> = total tuition fee for the course / number of calendar days in the course x 7. This amount is rounded up to the nearest whole dollar.</p>
											<p class="text-justify">b. <span class="text-italic">The number of weeks in the default period</span> = number of calendar days from the default day to the end of the period to which the payment relates / 7 </p>
											<p class="text-justify">If the student has paid any tuition fee for the second course, the refund will be calculated as </p>
											<p class="text-justify">The refund amount = the total course fee minus 5% of the course fee received up to a maximum of $500</p>
										</div>
									</td>
								</tr>
								<tr>
									<td width="20%" valign="top"></td>
									<td width="20%" valign="top">
										<div>
											<p class="text-justify blue-font-color">2.3 No proof of refusal from the Australian Government.</p>
										</div>
									</td>
									<td width="60%" valign="top">
										<div>
											<p class="text-justify">Refund will not be granted</p>
										</div>
									</td>
								</tr>

								<tr>
									<td width="20%" valign="top">
										<div>
											<p class="blue-font-color">3.0 Visa refused after commencement date</p>
										</div>
									</td>
									<td width="20%" valign="top">
										<div>
											<p class="text-justify blue-font-color">3.1 In the event that a student’s visa is not granted and the course has commenced.</p>
										</div>
									</td>
									<td width="60%" valign="top">
										<div>
											<p class="text-justify px-11-font line-height-1">The refund amount = <span class="text-italic">weekly tuition fee x the number of weeks in the default period</span></p>
											<p class="text-justify px-11-font line-height-1">a. <span class="text-italic">The weekly tuition fee</span> = total tuition fee for the course / number of calendar days in the course x 7. This amount is rounded up to the nearest whole dollar.</p>
											<p class="text-justify px-11-font line-height-1">b. <span class="text-italic">The number of weeks in the default period </span> = number of calendar days from the default day to the end of the period to which the payment relates / 7 </p>
											<p class="text-justify px-11-font line-height-1">Tuition fee does not include any non-tuition fee that might have been paid by the student. </p>
										</div>
									</td>
								</tr>
								<tr>
									<td width="20%" valign="top">
										<div>
											<p class="blue-font-color px-11-font line-height-1">4.0 Cancellation before commencement date</p>
										</div>
									</td>
									<td width="20%" valign="top">
										<div>
											<p class="text-justify blue-font-color px-11-font line-height-1">4.1 In the event that the student cancels their enrolment and requests a refund in writing 10 weeks or more prior to the course commencement.</p>
										</div>
									</td>
									<td width="60%" valign="top">
										<div>
											<p class="text-justify px-11-font line-height-1">A 70% refund of Monies paid for tuition fees will be issued to the student.</p>
										</div>
									</td>
								</tr>
								<tr>
									<td width="20%" valign="top"></td>
									<td width="20%" valign="top">
										<div>
											<p class="text-justify blue-font-color px-11-font line-height-1">4.2 In the event that the student requests a refund in writing 6 weeks up to 9 full weeks prior to the course commencement.</p>
										</div>
									</td>
									<td width="60%" valign="top">
										<div>
											<p class="text-justify px-11-font line-height-1">A refund of 50% of monies paid for the tuition fees will be issued to the student.</p>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">© {{ $app_settings[0]->training_organisation_name }}- Offer Letter And Enrolment Acceptance Conditional Version 1.4 | RTO 0000 | CRICOS No. 0000</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 4 of 8 -->
<!-- Start Page 5 of 8 -->

<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="border-bottom: 5px solid #09455e; padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="50%">
								<div class="eti-logo">
									{{-- @if(!in_array($app_settings[0]->logo_img, ['', null]))
											<img class="img-profile img-fluid w-75" src="{{ asset('/storage/config/images/'.$app_settings[0]->logo_img) }}">
										@else
											<img class="img-profile img-fluid w-75" src="{{ asset('/images/logo/vorx_logo-colored.png') }}">
										@endif --}}
										<img src="{{public_path()}}/images/logo/vorx_logo.png"  class="img-profile img-fluid w-75" alt="">
								</div>
							</td>
							<td width="50%">
								<p class="blue-font-color px-16-font text-right line-height-1point2">OFFER LETTER AND ENROLMENT<br>ACCEPTANCE</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div class="pdf-wrapper">
					<div class="content">
						<table width="100%" class="package-course " cellpadding="0" cellspacing="0" border="0">
							<thead>
								<tr>
									<th width="40%" colspan="2" class="proximanova-bold px-12-font text-center no-border">FEE REFUND CONDITIONS</th>
									<th width="60%" class="proximanova-bold px-12-font text-center no-border">REFUND APPLICABLE</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="20%" valign="top"></td>
									<td width="20%" valign="top">
										<div>
											<p class="text-justify blue-font-color px-11-font line-height-1">4.3 In the event the student requests a refund in writing 5 full weeks or less prior to course commencement</p>
										</div>
									</td>
									<td width="60%" valign="top">
										<div>
											<p class="text-justify px-11-font line-height-1">No refund will be issued.</p>
										</div>
									</td>
								</tr>
								<tr>
									<td width="20%" valign="top"></td>
									<td width="20%" valign="top">
										<div>
											<p class="text-justify blue-font-color px-11-font line-height-1">4.4 If a student requests to defer to any following intake/s before the commencement of the course initially applied for due to personal reasons.</p>
										</div>
									</td>
									<td width="60%" valign="top">
										<div>
											<p class="text-justify px-11-font line-height-1">There will be no refund of monies paid towards initial deposit.</p>
										</div>
									</td>
								</tr>
								<tr>
									<td width="20%" valign="top">
										<div>
											<p class="blue-font-color px-11-font line-height-1">5.0 Cancellation on or after commencement date </p>
										</div>
									</td>
									<td width="20%" valign="top">
										<div>
											<p class="text-justify blue-font-color px-11-font line-height-1">5.1 Withdrawals notified in writing and received by the College on the commencement date or after the semester commences.</p>
										</div>
									</td>
									<td width="60%" valign="top">
										<div>
											<p class="text-justify px-11-font line-height-1">No refund will be issued which includes all monies paid to College for Overseas Student Health Cover (OSHC), airport pick up, accommodation booking and board.</p>
										</div>
									</td>
								</tr>
								<tr>
									<td width="20%" valign="top"></td>
									<td width="20%" valign="top">
										<div class="blue-font-color px-11-font line-height-1">
											<p class="text-justify">5.2 There is a student default due to any of the following reasons:</p>
											<p class="text-justify">• The student failed to pay an amount he or she is liable to pay in order to undertake the course</p>
											<p class="text-justify">• The student breached a condition of his or her student visa.</p>
											<p class="text-justify">• Misbehaviour by the student</p>
										</div>
									</td>
									<td width="60%" valign="top">
										<div>
											<p class="text-justify px-11-font line-height-1">No refund will be issued to a student either before or after commencement of course.</p>
										</div>
									</td>
								</tr>
								<tr>
									<td width="20%" valign="top"></td>
									<td width="20%" valign="top">
										<div>
											<p class="text-justify blue-font-color px-11-font line-height-1">5.3 If a student fails to attend a course after the start of the Course. (Non-Commencement)</p>
										</div>
									</td>
									<td width="60%" valign="top">
										<div>
											<p class="text-justify px-11-font line-height-1">No refund will be issued which includes all monies paid to College.</p>
										</div>
									</td>
								</tr>
								<tr>
									<td width="20%" valign="top"></td>
									<td width="20%" valign="top">
										<div>
											<p class="text-justify blue-font-color px-11-font line-height-1">5.4 In the event that the student seeks and is granted approval by College to transfer to another provider prior to completion of six months study of the principal course.</p>
										</div>
									</td>
									<td width="60%" valign="top">
										<div>
											<p class="text-justify px-11-font line-height-1">No refund will be issued of any course money paid in advance.</p>
										</div>
									</td>
								</tr>
								<tr>
									<td width="20%" valign="top"></td>
									<td width="20%" valign="top">
										<div>
											<p class="text-justify blue-font-color px-11-font line-height-1">5.5 If a Student chooses to pay Tuition Fees on an instalment basis on an agreed payment plan.</p>
										</div>
									</td>
									<td width="60%" valign="top">
										<div>
											<p class="text-justify px-11-font line-height-1">No refund will be issued for any course money (paid on instalment basis). Instalments paid will be for course fees due and payable to the college for services already rendered.</p>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="3" class="proximanova-bold blue-bg-color white-font-color text-center text-uppercase">Conditions</td>
								</tr>
								<tr>
									<td colspan="3" style="padding: 0 10px;">
										<ul class="text-justify px-10-font line-height-1point2" style="padding-left: 15px;">
											<li style="padding-bottom: 5px;">At the time of enrolment any Credit Transfer (CT)/ Recognition of Prior Learning (RPL) will be discussed & granted after the student provides sufficient evidence, If the Credit Transfer allows shortening of the duration of the course pro-rata fees will be worked out and offered to the student. Once the student accepts this offer, there will be no further reduction of the fee.</li>
											<li style="padding-bottom: 5px;">Fees not listed in this refund section are not refundable. Prior to a student enrolling fees may be altered without notice. Once a student has completed enrolment, fees will not be subject to change for the normal duration of the course. If a course length is extended by the student then any fee increases will be required to be paid for the extended component of the course.</li>
											<li style="padding-bottom: 5px;">Prior to a student enrolling fees may be altered without notice. Once a student has completed enrolment, fees will not be subject to change for the normal duration of the course. If a course length is extended by the student then any fee increases will be required to be paid for the extended component of the course.</li>
											<li style="padding-bottom: 5px;">If a student withdraws after any number of deferments The date on the original CoE will be considered for the purpose of determining the date of commencement of semester/course in relation to the college refund policy and other related polices.</li>
										</ul>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">© {{ $app_settings[0]->training_organisation_name }}- Offer Letter And Enrolment Acceptance Conditional Version 1.4 | RTO 0000 | CRICOS No. 0000</p>
						<!-- <p>Page 5 of 14</p> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 5 of 8 -->
<!-- Start Page 6 of 8 -->

<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="border-bottom: 5px solid #09455e; padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="50%">
								<div class="eti-logo">
									{{-- @if(!in_array($app_settings[0]->logo_img, ['', null]))
											<img class="img-profile img-fluid w-75" src="{{ asset('/storage/config/images/'.$app_settings[0]->logo_img) }}">
										@else
											<img class="img-profile img-fluid w-75" src="{{ asset('/images/logo/vorx_logo-colored.png') }}">
										@endif --}}
										<img src="{{public_path()}}/images/logo/vorx_logo.png"  class="img-profile img-fluid w-75" alt="">
								</div>
							</td>
							<td width="50%">
								<p class=" blue-font-color px-16-font text-right line-height-1point2">OFFER LETTER AND ENROLMENT<br>ACCEPTANCE</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div class="pdf-wrapper">
					<div class="content">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tbody>
								<tr>
									<td width="50%" valign="top" style="padding-right: 7px;">
										<p class="px-14-font text-justify"><span class="blue-font-color">ADDITIONAL NON-TUITION CHARGES</span></p>
										<p class="px-11-font text-justify line-height-1point2">Tuition fees do not include cost of any additional documents required for specific reasons. See charges below for additional documents:</p>
										<div class="clearfix" style="height: 10px;"></div>
										<table width="100%;" class="package-course" cellpadding="0" cellspacing="0" border="0">
											<tbody>
												<tr>
													<td valign="top" width="40%">Airport Pickup </td>
													<td valign="top" width="60%">$180 </td>
												</tr>
												<tr>
													<td valign="top">Accommodation Booking Assistance </td>
													<td valign="top">$180 </td>
												</tr>
												<tr>
													<td valign="top">RPL<br>1st consultation is free</td>
													<td valign="top">Total fee to be charged:<br>$1500 for Certificate III level course course(s)<br>$1800 for Diploma course(s) and Advanced Diploma Level<br>courses.</td>
												</tr>
												<tr>
													<td valign="top">Credit Transfer</td>
													<td valign="top">nil</td>
												</tr>
												<tr>
													<td class="blue-bg-color white-font-color" colspan="2">Other Fees</td>
												</tr>
												<tr>
													<td width="65%">Reassessment Fees</td>
													<td width="35%">$250</td>
												</tr>
												<tr>
													<td width="65%">Re-issuance of student ID</td>
													<td width="35%">$20</td>
												</tr>
												<tr>
													<td width="65%">Re-issuance of Testamur <br><span class="px-8-font">(Certificate or Statement of Attainment)</span></td>
													<td width="35%">$25</td>
												</tr>
												<tr>
													<td width="65%">Late payment of tuition feesq</td>
													<td width="35%">$50 per month</td>
												</tr>
												<tr>
													<td width="65%">Dishonour fee<br> <span class="px-8-font">(If payments are via direct debit and a payment has been dishonoured)</span></td>
													<td width="35%">$10</td>
												</tr>
											</tbody>
										</table>
										<div class="clearfix" style="height: 10px;"></div>
										<p class="px-14-font text-justify"><span class="blue-font-color text-uppercase">Tuition Protection Scheme</span></p>
										<p class="px-12-font text-justify line-height-1">International Students</p>
										<ol type="1" class="px-11-font text-justify no-margin paragraph-list" style="margin-left: 10px;">
											<li>{{ $app_settings[0]->training_organisation_name }} is a member of the Australian Government endorsed Tuition Protection Service.</li>
											<li>{{ $app_settings[0]->training_organisation_name }} will maintain membership of the Tuition Protection Service during its period of registration as a provider.</li>
											<li>{{ $app_settings[0]->training_organisation_name }} will pay all subscriptions to the TPS in accordance with TPS requirements.</li>
											<li>If due to unforeseen circumstances {{ $app_settings[0]->training_organisation_name }} is unable to complete the delivery of a course once commenced, and subsequently refund the student tuition fees unused and/ or offer them an acceptable place in another course at {{ $app_settings[0]->training_organisation_name }}, the Tuition Protection Service will attempt to secure a place for the student in a suitable course at another College.</li>
											<li>A maximum of 50% of the course tuition fee will be collected as a course deposit fee for courses longer than 24 weeks in duration.</li>
											<li>If the student pays more than 50% of tuition fees, the student will need to sign the form "Declaration by the student when they choose to pay more than 50% of tuition fees".</li>
										</ol>
										<div class="clearfix" style="height: 10px;"></div>
										<p class="px-11-font">Read the Fees Policy and Procedures in Vorx website.</p>
										<div class="clearfix" style="height: 10px;"></div>
										<p class="px-14-font text-justify line-height-1point2"><span class="blue-font-color ">COMPLAINTS AND APPEALS</span></p>
										<p class="px-11-font text-justify line-height-1point2">If students have concerns with any aspect of their training, they have the right to access the complaints and appeals process. The students should bring their concern/s to the attention of their trainer or any of our Student Support team. They will endeavour to resolve the matter in an informal manner to the student’s satisfaction. If the outcome of the informal complaint does not meetthe student’s expectations, they may lodge a formal complaint by completing the formal complaints and appeals form which can be requested from the Student Support team. This will be dealt with in accordance with the complaints and appeals policy and procedures, which can be viewed and downloaded from our website. A hard copy can be requested from our Student Support team if required.</p>
									</td>
									<td width="50%" valign="top" style="padding-left: 7px;">
										<p class="px-11-font text-justify line-height-1point2">Students have the right to appeal the outcome of a complaint or the outcome of assessment decisions if they are dissatisfied and feel they have been dealt with unjustly. Appeals can be made by completing the Complaints and Appeals Form. The appeal will be dealt with in accordance with the Complaints and Appeals Policy and Procedure. If submitting a formal Complaint or Appeal Form, students must provide reasons and supporting evidence justifying their grounds for the complaint or appeal.</p>
										<div class="clearfix" style="height:10px;"></div>
										<p class="px-11-font text-justify line-height-1point2">Students have the right to appeal the outcome of a complaint or the outcome of assessment decisions if they are dissatisfied and feel they have been dealt with unjustly. Appeals can be made by completing the Complaints and Appeals Form. The appeal will be dealt with in accordance with the Complaints and Appeals Policy and Procedure. If submitting a formal Complaint or Appeal Form, students must provide reasons and supporting evidence justifying their grounds for the complaint or appeal.</p>
										<div class="clearfix" style="height:10px;"></div>
										<p class="px-11-font text-justify line-height-1point2">If the student is still dissatisfied by the outcome of an internal appeal they have the right to the external complaints or appeals process. Our Student Support team may refer the student to an external welfare service. The student will be informed whether or not using an external welfare service will attract costs to the student. An external party may review the case to identify if the College has followed the correct process as stated in the Complaints and Appeals Policy and Procedure in managing the complaint or appeal. The external party does not review the outcome of the complaint or appeal.</p>
										<div class="clearfix" style="height:10px;"></div>
										<p class="px-11-font text-justify line-height-1point2"><span class=" blue-font-color">CHANGE OF ADDRESS</span>. Should a student change address during their course of study they must notify the College within 5 working days from the date they change their address. Students are required to provide the College with details of their current address for the whole period of their enrolment.</p>
										<div class="clearfix" style="height:10px;"></div>
										<p class="px-11-font text-justify line-height-1point2"><span class=" blue-font-color">CHANGE OF PERSONAL DETAILS/CIRCUMSTANCES</span>. During the student’s course of studies any change of personal details and/or circumstances must be informed to {{ $app_settings[0]->training_organisation_name }}in order to update the student’s records.</p>
										<div class="clearfix" style="height:10px;"></div>
										<p class="px-11-font text-justify line-height-1point2"><span class=" blue-font-color">ACCESS TO RECORDS</span>. Students are entitled to request and be provided with a formal Statement of Attainment on withdrawal, cancellation or transfer, prior to completing the qualification, provided the student has paid in full for the tuition related to the units of competency to be shown on the Statement of Attainment. This is free for cost to the student. Students are also entitled to access their student file free of cost upon request.</p>
										<div class="clearfix" style="height:10px;"></div>
										<p class="px-11-font text-justify line-height-1point2"><span class=" blue-font-color">INTERNATIONAL STUDENT ENROLMENT FORM:</span> Application forms may be obtained and submitted to the reception. ({{ $app_settings[0]->training_organisation_name }}, Level 7, 20 Otter Street, Collingwood, Victoria 3066 or e-mail at <span class="blue-font-color">info@sample.au</span>. The Administration officer/student support officer will arrange an appointment within 5 working days to view the records and ask the student to bring confirmation of identity.</p>
										<div class="clearfix" style="height:10px;"></div>
										<p class="px-11-font text-justify line-height-1point2"><span class=" blue-font-color">COMPLETION WITHIN EXPECTED DURATION</span>., The student’s course progress is monitored to ensure they complete the course within the duration specified in their CoE. {{ $app_settings[0]->training_organisation_name }}only enables a student to extend the duration of study through by issuing a new CoE in consideration of limited circumstances. Without such limited circumstances, the expected duration of study must not exceed the expected duration of study specified in the student’s eCoE. Please refer to Vorx Monitoring Course Progress and Intervention Strategy for International students policy and procedure on Vorx website.</p>
										<div class="clearfix" style="height:10px;"></div>
										<p class="px-11-font text-justify line-height-1point2"><span class=" blue-font-color">AMENDING/CHANGING YOUR ENROLMENT</span>. After completing the enrolment, a student might have the need to change his/her enrolment due to ‘change of mind’ or for other reasons. International students are precluded from suspending studies due to student visa conditions. Students must contact the Student Support team to discuss options. They will be able to advise students whether or not they are permitted to withdraw from their current course and switch to another course at {{ $app_settings[0]->training_organisation_name }}and how it will affect their visa, as this will affect the normal course duration and may require the student to obtain a new student visa to cover the remaining period before the current visa expires. The student’s OSHC may need to be extended as well to cover the extended course duration and new student visa.</p>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">© {{ $app_settings[0]->training_organisation_name }}- Offer Letter And Enrolment Acceptance Conditional Version 1.4 | RTO 0000 | CRICOS No. 0000</p>
						<!-- <p>Page 6 of 14</p> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 6 of 8 -->
<!-- Start Page 7 of 8 -->

<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="border-bottom: 5px solid #09455e; padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="50%">
								<div class="eti-logo">
									{{-- @if(!in_array($app_settings[0]->logo_img, ['', null]))
											<img class="img-profile img-fluid w-75" src="{{ asset('/storage/config/images/'.$app_settings[0]->logo_img) }}">
										@else
											<img class="img-profile img-fluid w-75" src="{{ asset('/images/logo/vorx_logo-colored.png') }}">
										@endif --}}
										<img src="{{public_path()}}/images/logo/vorx_logo.png"  class="img-profile img-fluid w-75" alt="">
								</div>
							</td>
							<td width="50%">
								<p class="blue-font-color px-16-font text-right line-height-1">OFFER LETTER AND ENROLMENT<br>ACCEPTANCE</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div class="pdf-wrapper">
					<div class="content">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="50%" valign="top" style="padding-right: 7px;">
									<p class="px-11-font line-height-1point2 text-justify"><span class="blue-font-color">DEFER, SUSPEND OR CANCEL YOUR ENROLMENT</span>. If students would like to apply to defer, suspend or cancel their enrolment by submitting an application to the College. Application forms may be obtained and submitted to the reception ({{ $app_settings[0]->training_organisation_name }}, Level 7, 20 Otter Street, Collingwood, VIC 3066) or e-mail at <span class="blue-font-color">info@sample.au</span>. The College may also initiate the deferral, suspension or cancellation a student’s enrolment.<br> In consideration of a student’s compassionate or compelling circumstances, {{ $app_settings[0]->training_organisation_name }} may defer, suspend or cancel a student’s enrolment. Compassionate or compelling circumstances are generally those beyond the control of the student and which have an impact upon the student’s course progress or wellbeing</p>
									<div class="clearfix" style="height: 5px;"></div>
									<div>
										<ul class="px-11-font text-justify no-margin paragraph-list" style="padding-left: 10px;">
											<li class="line-height-1point2 text-justify">When determining whether compassionate or compelling circumstances exist, the College considers documentary evidence provided to support the claim, and stores copies of these documents in the student’s file.</li>
											<li class="line-height-1point2 text-justify">Students may also have their enrolment suspended or cancelled by the College due to non-payment of fees, unsatisfactory course progress, misbehaviour or breaching the College Code of Conduct. The student will be advised that his/her student visa maybe affected if his/her enrolment is deferred, suspended or cancelled.</li>
										</ul>
									</div>
									<div class="clearfix" style="height: 6px;"></div>
									<p class="px-11-font line-height-1point2 text-justify"><span class="blue-font-color">TRANSFER BETWEEN PROVIDERS</span>. We acknowledge our international students as consumers and afford them the right to transfer under certain circumstances (unforeseen, exceptional circumstances that create significant personal hardship). As a part of the enrolment process and prior to enrolment, students are informed that there are restrictions to be employed from enrolling transferring students prior to completing six months of his or her principal course of study.</p>
									<div class="clearfix" style="height: 6px;"></div>
									<p class="px-11-font line-height-1point2 text-justify"><span class="blue-font-color">TRANSFER TO ANOTHER PROVIDER</span>. We are restricted from granting a student’s request to transfer to another provider prior to the completion of six months of their principal course of study except when certain circumstances occur. The student’s request will be granted where the transfer will not be to the detriment of the student. If approved and once all conditions are met, a release letter will be issued to the student. Students must contact the Student Support team for assistance.</p>
									<div class="clearfix" style="height: 6px;"></div>
									<p class="px-11-font line-height-1point2 text-justify"><span class="blue-font-color">TRANSFER FROM ANOTHER PROVIDER</span>. We are responsible for assessing student’s request to transfer from another training provider within the restricted period (completion of six months of the principal course). For a request to transfer from another provider be considered, a release letter will be required.<br>After the first six months of the principal course, no restrictions apply, provided the student has paid all outstanding fees. All applications are processed in compliance with the College Transfer between Providers policy and procedure. Contact the reception at {{ $app_settings[0]->training_organisation_name }} Level 7, 20 Otter Street, Collingwood, VIC 3066 or email info@sample.au for further information and application forms.</p>
									<div class="clearfix" style="height: 6px;"></div>
									<p class="px-11-font line-height-1point2 text-justify"><span class="blue-font-color">TRANSFERS FROM COURSE TO COURSE (WITHIN Vorx)</span>., It is our policy that students remain in the course that the student visa was granted on for a minimum of six months, or, on completion of a course if the course is shorter than six months, before a request for transfer between courses will be considered. This is also handled on case to case basis considering the student is not disadvantaged. {{ $app_settings[0]->training_organisation_name }}will charge a fee for all transfer requests. Students must contact the Student Support team for assistance.</p>
								</td>
								<td width="50%" valign="top" style="padding-left: 7px;">
									<p class="px-11-font line-height-1point2 text-justify"><span class="blue-font-color">ESOS FRAMEWORK – STUDENT’S RIGHTS AND RESPONSIBILITIES</span>. The Australian Government wants overseas students in Australia to have a safe, enjoyable and rewarding place to study. Australia’s laws promote quality education and consumer protection for overseas students. These laws are known as the ESOS framework and they include the Education Services for Overseas (ESOS) Act 2000 and the National Code 2018.<br><span class="blue-font-color">https://www.legislation.gov.au/Details/F2017L00403</span><br>Further information on the ESOS Framework is provided in the following link:<br><span class="blue-font-color">https://internationaleducation.gov.au/Regulatory-Information/Education-Services-for-Overseas-Students-ESOS-Legislative-Framework/ESOS-Regulations/Pages/default.aspx</span>.</p>
									<div class="clearfix" style="height: 6px;"></div>
									<p class="px-11-font line-height-1point2 text-justify"><span class="blue-font-color">PRIVACY</span>. {{ $app_settings[0]->training_organisation_name }} may require the collection of personal information from applicants to enable it to provide its training products and services. {{ $app_settings[0]->training_organisation_name }}takes its obligations under the Privacy Act seriously, and as such, will take all reasonable steps in order to comply with the Act and protect the privacy or personal information that it holds. This Policy supports Vorx commitment to the protection and non-disclosure of personal and sensitive information of its students and provides staff with a better understanding of the type of personal information that {{ $app_settings[0]->training_organisation_name }}holds on individuals.</p>
									<div class="clearfix" style="height: 6px;"></div>
									<p class="px-11-font line-height-1point2 text-justify"><span class="blue-font-color">ASSESSMENT</span>. {{ $app_settings[0]->training_organisation_name }}employs a competency-based training. Students are required to consistently and over time demonstrate the skills and knowledge that enable completion of all assessment tasks based on the required assessment methods and variety of situations. On successful completion of assessment tasks for each unit, a student is deemed ‘Competent” (C) or if not, ‘Not Yet Competent’ (NYC). If the student is not satisfied of the assessment outcomes, the student may access the Complaint and Appeals process. Please refer to the Complaints and Appeals Policy and Procedures. The Student Support team will advise the student on the effect of these circumstances of his/her student visa. The availability of the Complaints and Appeals processes to students does not remove their right to take action under Australia’s consumer protection laws. The student’s enrolment will be maintained while a complaints and appeals process is ongoing.</p>
									<div class="clearfix" style="height: 6px;"></div>
									<p class="px-11-font line-height-1point2 text-justify"><span class="blue-font-color">RE-ASSESSMENTS</span>. If a student is deemed as Not Yet Competent (NYC) in a course unit of competency, a re-assessment is provided within 5 working days at no extra cost. If the student is deemed NYC on the assessment or provide a valid reason for not taking the assessment, then the student will be granted the opportunity to take the re-assessment. {{ $app_settings[0]->training_organisation_name }}will determine the time at which the unit delivery will be available. The Student Support team will advise the student on the effect of these circumstances the student visa. Students are given two attempts for free of cost.</p>
								</td>
							</tr>
						</table>
					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p>© {{ $app_settings[0]->training_organisation_name }} - Offer Letter And Enrolment Acceptance Conditional Version 1.4 | RTO 0000 | CRICOS No. 0000</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 7 of 8 -->
<!-- Start Page 8 of 8 -->

<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="border-bottom: 5px solid #09455e; padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="50%">
								<div class="eti-logo">
									{{-- @if(!in_array($app_settings[0]->logo_img, ['', null]))
											<img class="img-profile img-fluid w-75" src="{{ asset('/storage/config/images/'.$app_settings[0]->logo_img) }}">
										@else
											<img class="img-profile img-fluid w-75" src="{{ asset('/images/logo/vorx_logo-colored.png') }}">
										@endif --}}
										<img src="{{public_path()}}/images/logo/vorx_logo.png"  class="img-profile img-fluid w-75" alt="">
								</div>
							</td>
							<td width="50%">
								<p class="blue-font-color px-16-font text-right line-height-1">OFFER LETTER AND ENROLMENT<br>ACCEPTANCE</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div class="pdf-wrapper">
					<div class="content">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="50%" valign="top" style="padding-right: 7px;">
									<p class="px-10-font line-height-1point2 text-justify"><span class="blue-font-color">COURSE PROGRESS</span>. {{ $app_settings[0]->training_organisation_name }} will monitor students course progress and provide assistance if the student is experiencing difficulties and not progressing through their course as per the course schedule. The {{ $app_settings[0]->training_organisation_name }}delegate will arrange a time to meet with students who are not progressing satisfactorily and ascertain the reasons for this. Access to appropriate supports services will then be provided to assist the student in successfully completing their course within the scheduled duration. {{ $app_settings[0]->training_organisation_name }} may refer students to external sources if they are unable to sufficiently provide support for students learning needs. {{ $app_settings[0]->training_organisation_name }} may refer students to external organisations if they are experiencing personal/welfare issues that are affecting their course progress. {{ $app_settings[0]->training_organisation_name }} takes all reasonable and feasible steps to assist students so they can successfully complete their course within the course schedule. It is a requirement of the National Code of Practice 2018 Standard 8 that the College reports students who do not achieve satisfactory course progress over study period. This can lead to your student visa may be cancelled. Please contact the college at info@sample.au or visit the website to see Student Support Policy and Procedure for further details on how your course progress may impact your student visa. Please refer to Vorx Monitoring Course Progress and Intervention Strategy for International students policy and procedure on Vorx website.</p>
									<div class="clearfix" style="height: 2px;"></div>
									<p class="px-10-font line-height-1point2">Note: Please be advised that student can find all the detailed policies and procedures from the reception or from the website.</p>
									<div class="clearfix" style="height: 2px;"></div>
									<p class="blue-font-color px-11-font line-height-1point2">OVERSEAS STUDENT HEALTH COVER (OSHC)</p>
									<p class="px-10-font line-height-1point2 text-justify">It is a requirement of the Department of Home Affairs (DHA) that all students studying on a student visa are covered by OSHC. Students accompanied by family must pay the OSHC family fee.</p>
									<div class="clearfix" style="height: 2px;"></div>
									<p class="blue-font-color px-11-font line-height-1point2">Declaration:</p>
									<p class="px-10-font line-height-1point2 text-justify">I, <span class="blue-font-color">{{$offerData['student']['party']['name']}}</span> agree that by signing this declaration, I am accepting an offer of a place in the course as outlined within this Letter of Offer.</p>
									<div class="clearfix" style="height: 2px;"></div>
									<p class="px-10-font line-height-1point2">I further acknowledge that:</p>
									<div>
										<ul class="px-10-font text-justify no-margin paragraph-list">
											<li class="line-height-1point2 text-justify">The information provided to {{ $app_settings[0]->training_organisation_name }} in application for study is to best of my knowledge true, correct and complete at the time of my enrolment/application.</li>
											<li class="line-height-1point2 text-justify">I acknowledge that providing any false information and/or failing to disclose any information relevant to my application for enrolment and/or failure to complete an international enrolment application form may result in the delay in processing my application.</li>

											<li class="line-height-1point2 text-justify">I have read the {{ $app_settings[0]->training_organisation_name }}’s Student Handbook that contains pre-enrolment information including the refund policy, information on credit transfer, recognition of prior learning (RPL), living in Melbourne and student work rights, among others and all other Vorx policies and procedures.</li>
											<li class="line-height-1point2 text-justify">I understand that I must maintain satisfactory course progress during my studies at {{ $app_settings[0]->training_organisation_name }} and the impact of not doing so may have on my enrolment and student visa.</li>
											<li class="line-height-1point2 text-justify">I agree to inform the College if I change my address during the period of enrolment. I also agree to maintain Overseas Student Health Cover for the period of my enrolment.</li>
											<li class="line-height-1point2 text-justify">I agree to inform the College of any changes on my personal details and/or circumstances during my course of study.</li>
											<li class="line-height-1point2 text-justify">I have disclosed to {{ $app_settings[0]->training_organisation_name }} any special needs which may affect my learning.</li>
											<li class="line-height-1point2 text-justify">I have read and understood the privacy statement above.</li>
											<li class="line-height-1point2 text-justify">This agreement, and the availability of the College complaints and appeals process, does not remove my right to action under Australia’s consumer protection laws.</li>
										</ul>
									</div>
								</td>
								<td width="50%" valign="top" style="padding-left: 7px;">
									<div>
										<ul class="px-10-font text-justify no-margin paragraph-list">
											<li class="line-height-1point2 text-justify">I agree to complete my studies in accordance with {{ $app_settings[0]->training_organisation_name }} policies and procedures and Code of Conduct when studying at {{ $app_settings[0]->training_organisation_name }}. I understand that if I do not comply with the College policies and procedures and Code of Conduct my enrolment and student visa may be affected. All information and documents relating to my personal, academic and employment history (if any) submitted to support this application are all true, complete, valid and genuine.</li>
											<li class="line-height-1point2 text-justify">I authorize {{ $app_settings[0]->training_organisation_name }}to seek verification of my personal, academic, professional qualifications, work experience and any information I have provided in my enrolment application.</li>
											<li class="line-height-1point2 text-justify">I understand that {{ $app_settings[0]->training_organisation_name }}reserves the right to inform other tertiary institutions and regulatory agencies if any of the material presented to support my application is found to be false.</li>
											<li class="line-height-1point2 text-justify">I understand the Privacy Statement provided in the enrolment application form. I understand that the personal and all information I have provided may be released by {{ $app_settings[0]->training_organisation_name }}to government agencies as required by law and that {{ $app_settings[0]->training_organisation_name }}may disclose to third parties for the purpose of this application.</li>
											<li class="line-height-1point2 text-justify">I authorize {{ $app_settings[0]->training_organisation_name }}to access the Australian immigration Visa Entitlements Verification Online (VEVO) system at anytime to obtain information on my visa status.</li>
											<li class="line-height-1point2 text-justify">I declare that I am a genuine temporary entrant and genuine student and that I have read and understood conditions relating to requirements outlined on <span class="blue-font-color">www.homeaffairs.gov.au</span></li>
											<li class="line-height-1point2 text-justify">I am aware of the tuition and living costs of my stay in Australia and have the financial capacity to meet such costs for the duration of my course.</li>
											<li class="line-height-1point2 text-justify">I understand that if I have any school-aged children or dependent accompanying me to Australia, they must attend school and I will be required to pay a full fee if they are enrolled either in a government or non- government school.</li>
											<li class="line-height-1point2 text-justify">I have read and understood the Vorx Pre-Enrolment information, course information, course fees and charges, entry/admission requirements and all information outlined in the International Student Handbook available in Vorx website.</li>
											<li class="line-height-1point2 text-justify">I have read and understand all relevant information and policy and procedures provided in Vorx website along with the policy related to Refund and information on RPL and Credit Transfer.</li>
											<li class="line-height-1point2 text-justify">I understand that I must maintain satisfactory course progress and the impact of not doing so may have on my enrolment and student visa.</li>
											<li class="line-height-1point2 text-justify">I understand the conditions to change provider during my studies and the impact this action may have on my student visa.</li>
											<li class="line-height-1point2 text-justify">I understand the conditions for deferring, suspending and cancelling my enrolment and the impact these actions may have on my student visa.</li>
											<li class="line-height-1point2 text-justify">I understand that I must maintain my Overseas Health Insurance Cover during the duration of my student visa and that I must always have a valid student visa and the subclass is relevant to my principal course. I have disclosed to Vorx my disability or special learning needs which may affect my learning.</li>
											<li class="line-height-1point2 text-justify">I understand that I will present originals of all documents used to support my application at the time of enrolment.</li>
											<li class="line-height-1point2 text-justify">I agree to complete my studies in accordance with Vorx policies and procedures and abide Vorx Code of Conduct.</li>
										</ul>
									</div>
									<table width="100%" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td>
												<div>
													<div class="clearfix" style="height: 20px;"></div>
													<h2 class="blue-font-color px-12-font no-margin">DECLARATION AND ACCEPTANCE BY APPLICANT: </h2>
													<div class="clearfix" style="height: 5px;"></div>
													<p class="px-11-font">I, <span class="blue-font-color">{{$offerData['student']['party']['name']}}</span></p>
													<p class="px-11-font line-height-1point2 "> agree that by signing this declaration, I am accepting the above payment terms and conditions as outlined within this Offer letter. </p>
													<div class="clearfix" style="height: 7px;"></div>
													<p class="px-11-font">Signed by Applicant:.....................................................................................</p>
													<p class="px-11-font">Date: </p>
												</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p>© {{ $app_settings[0]->training_organisation_name }} - Offer Letter And Enrolment Acceptance Conditional Version 1.4 | RTO 0000 | CRICOS No. 0000</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 8 of 8 -->

</html>