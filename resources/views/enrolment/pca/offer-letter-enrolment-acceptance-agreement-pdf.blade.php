<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" href="{{public_path()}}/custom/pca-offer-letter-and-enrolment-acceptance-agreement/pdf-style.css" rel="stylesheet" />
	<title>Offer Letter and Enrolment Acceptance Agreement</title>
	<style>
		@import url("{{public_path()}}/public/fonts/brush-script-mt/brush script mt kursiv.ttf");

		.type-signature {
			font-family: 'Brush Script MT', cursive;
			font-size:30px;
		}
	</style>
</head>
<!-- Page 1 of 16 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-offer-letter-and-enrolment-acceptance-agreement/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Offer Letter and Enrolment Acceptance Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content">
						<table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="30%" class="primary-bg-color white-font-color px-14-font proximanova-bold">Date of Issue</td>
								<td width="70%">
									{{-- @if($signed) --}}
									{{Carbon\Carbon::parse($offerData['issued_date'])->format('d/m/Y')}}
									{{-- @endif --}}
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-14-font proximanova-bold">Family Name of the Student</td>
							<td>{{ $offerData['student']['party']['person']['lastname'] }}</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-14-font proximanova-bold">Given Name of the Student</td>
								<td>{{ $offerData['student']['party']['person']['firstname'] }}</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-14-font proximanova-bold">Student ID</td>
								<td>{{ $offerData['student']['student_id'] }}</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-14-font proximanova-bold">Date of Birth</td>
								<td>{{  Carbon\Carbon::parse($offerData['student']['party']['person']['date_of_birth'])->timezone('Australia/Melbourne')->format('d/m/Y')}}</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-14-font proximanova-bold">Student Email ID</td>
								<td>{{ $offerData['student_details']['email_personal'] }}</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-14-font proximanova-bold">Student Address</td>
								<td>{{ $offerData['student_details']['current_address'] }}</td>
							</tr>
						</table>
						<div class="clearfix" style="height: 20px;"></div>
						<p class="text-justify px-14-font" style="line-height: 14px;">Dear Student,</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="text-justify px-14-font" style="line-height: 14px;">RE: Conditional Offer Letter and Enrolment Acceptance Agreement </p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="text-justify px-14-font" style="line-height: 14px;">Thank you for your application to study at Phoenix College of Australia. Further to an assessment of your application, we are pleased to offer you a place as an international student in the course/s as outlined below.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="text-justify px-14-font" style="line-height: 14px;">Prior to accepting this offer it is important that you read the pre-enrolment information in student handbook or available from our website.</p>
						<div class="clearfix" style="height: 20px;"></div>
						<table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td colspan="2" class="primary-bg-color white-font-color px-14-font proximanova-bold text-center">Course Information</td>
							</tr>
							<tr>
								<td width="50%" class="px-14-font proximanova-bold">CRICOS Course Code</td>
								<td width="50%">{{$offerData['course_details'][0]['course_matrix']['cricos_code']}}</td>
							</tr>
							<tr>
								<td class="px-14-font proximanova-bold">Course Code</td>
								<td width="50%">{{$offerData['course_details'][0]['course_matrix']['course_code']}}</td>
							</tr>
							<tr>
								<td class="px-14-font proximanova-bold">Course name</td>
								<td width="50%">{{$offerData['course_details'][0]['course']['name']}}</td>
							</tr>
							<tr>
								<td class="px-14-font proximanova-bold">Pre-requisite</td>
								<td>NIL</td>
							</tr>
							<tr>
								<td class="px-14-font proximanova-bold">Duration in Weeks</td>
								<td width="50%">{{$offerData['course_details'][0]['course_matrix']['wk_duration']}}</td>
							</tr>
							<tr>
								<td class="px-14-font proximanova-bold">Application/enrolment Fees</td>
								{{-- <td>AUD 250.00 (Non-refundable)</td> --}}
								<td width="50%">AUD {{ number_format($offerData['course_details'][0]['course_matrix']['enrolment_fee'],2)}}  (Non-refundable)</td>
							</tr>
							<tr>
								<td class="px-14-font proximanova-bold">Tuition Fees</td>
								@if($offerData['fees']['discounted_amount']!= '0.00')
								<td width="50%">AUD {{number_format($offerData['course_details'][0]['course_matrix']['onshore_tuition_individual'] - (float) $offerData['fees']['discounted_amount'],2)}}</td>

								@else	
								<td width="50%">AUD {{number_format($offerData['course_details'][0]['course_matrix']['onshore_tuition_individual'],2)}}</td>
								@endif
							</tr>
							<tr>
								<td class="px-14-font proximanova-bold">Material Fees</td>
								<td width="50%">AUD {{number_format($offerData['course_details'][0]['course_matrix']['material_fees'],2)}}</td>
							</tr>
							{{-- @if ($offerData['fees']['discount'] != null)
							<tr>
							<td class="px-14-font proximanova-bold">{{$offerData['fees']['discount']['name']}} </td>
								<td>
									AUD {{ number_format($offerData['fees']['discounted_amount'],2)}}
								</td>
							</tr>
							@endif --}}
							<tr>
								<td class="px-14-font proximanova-bold">Total Fees</td>
								<td>
									@php
										if($offerData['fees']['discounted_amount']!= '0.00'){
											$total = ($offerData['course_details'][0]['course_matrix']['enrolment_fee'] + $offerData['course_details'][0]['course_matrix']['onshore_tuition_individual'] + $offerData['course_details'][0]['course_matrix']['material_fees'])
											- (float) $offerData['fees']['discounted_amount'];

										}else{
											$total = $offerData['course_details'][0]['course_matrix']['enrolment_fee'] + $offerData['course_details'][0]['course_matrix']['onshore_tuition_individual'] + $offerData['course_details'][0]['course_matrix']['material_fees'];
										}
									@endphp
									AUD {{ number_format($total,2)}}
								</td>
							</tr>
							<tr>
								<td class="px-14-font proximanova-bold">Course Start Date</td>
							<td>{{ Carbon\Carbon::parse($offerData['course_details'][0]['course_start_date'])->timezone('Australia/Melbourne')->format('d/m/Y') }}</td>
							</tr>
							<tr>
								<td class="px-14-font proximanova-bold">Course End Date</td>
								<td>{{ Carbon\Carbon::parse($offerData['course_details'][0]['course_end_date'])->timezone('Australia/Melbourne')->format('d/m/Y') }}</td>
							</tr>
							<tr>
								<td class="px-14-font proximanova-bold">Cost for Overseas Student Health Cover</td>
								<td>AUD XXXXX</td>
							</tr>
							<tr>
								<td class="px-14-font proximanova-bold">Delivery location</td>
								<td>{{ $offerData['dlvr_loc']['addr_street_num'] }} {{ $offerData['dlvr_loc']['addr_street_name'] }} {{ $offerData['dlvr_loc']['addr_location'] }} {{ $offerData['dlvr_loc']['state']['state_key'] }} {{$offerData['dlvr_loc']['postcode'] }} </td>
							</tr>
							<tr>
								<td class="px-14-font proximanova-bold">Mode of Study</td>
								<td>Face to face</td>
							</tr>
							<tr>
								<td colspan="2" class="primary-bg-color white-font-color px-14-font proximanova-bold text-center">Initial Payment Required for Issuance of Confirmation of Enrolment (COE)</td>
							</tr>
							{{-- inital application fee --}}
							@if ($offerData['fees']['initial_application_fee'] != null)
								@php
									$iaf = $offerData['course_details'][0]['course_matrix']['enrolment_fee'] - $offerData['fees']['initial_application_fee'];
								@endphp
								<tr>
									<td width="50%" class="px-14-font proximanova-bold">Application Fees</td>
									<td width="50%">AUD {{number_format($offerData['fees']['initial_application_fee'],2)}}  {{$iaf == 0.00 ? '' : '('.number_format($iaf,2) .' Remaining)'}}</td>
								</tr>
							@endif
							
							{{-- initial material fee --}}
							@if ($offerData['fees']['initial_material_fee'] != null)
								@php
									$imf = $offerData['course_details'][0]['course_matrix']['material_fees'] - $offerData['fees']['initial_material_fee'];
								@endphp
								<tr>
									<td class="px-14-font proximanova-bold">Material Fees</td>
									<td>AUD {{number_format($offerData['fees']['initial_material_fee'],2)}} {{$imf == 0.00 ? '' : '(AUD '.number_format($imf,2) .' Remaining)'}}</td>
								</tr>
							@endif

							{{-- initial tuition fee --}}
							@if ($offerData['fees']['initial_tuition_fee'] != null)
								@php
									// $imf = $offerData['course_details'][0]['course_matrix']['material_fees'] - $offerData['fees']['initial_material_fee'];
								@endphp
							<tr>
								<td class="px-14-font proximanova-bold">Tuition Fees</td>
								<td>AUD {{number_format($offerData['fees']['initial_tuition_fee'],2)}} </td>
							</tr>
							@endif
							{{-- <tr>
								<td class="px-14-font proximanova-bold">Tuition Fees</td>
								<td>
									@if($signed)
										@if($offerData['fees']['initial_payment_amount'] == 0)
											AUD 1000.00
										@else
											AUD {{ $offerData['fees']['initial_payment_amount']}}
										@endif
									@else
									AUD 500.00
									@endif
								</td>
							</tr> --}}
							<tr>
								<td class="px-14-font proximanova-bold">Total</td>
								<td>
									@if($signed)
										@if($offerData['fees']['initial_payment_amount'] == '0.00')
										AUD {{ $offerData['fees']['payment_required'] }}
										@else
										AUD {{ $offerData['fees']['initial_payment_amount'] }}
										@endif
									@else
										AUD {{ $offerData['fees']['payment_required'] }}
									@endif

								</td>
							</tr>
							<tr>
								<td class="px-14-font proximanova-bold">Due Date</td>
								@if($offerData['fees']['payment_due'] == null)
								<td>{{ Carbon\Carbon::parse($offerData['course_details'][0]['course_start_date'])->subDay(3)->format('d/m/Y') }}</td>
								@else
								<td>{{ Carbon\Carbon::parse($offerData['fees']['payment_due'])->format('d/m/Y') }}</td>
								@endif
							</tr>
						</table>
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No. 45633 | CRICOS Code 03871F</p>
						<p style="margin-bottom: 0px;"> Page 1 of 16</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 1 of 16 -->
<!-- Page 2 of 16 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-offer-letter-and-enrolment-acceptance-agreement/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Offer Letter and Enrolment Acceptance Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content">
						<table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%">
									<p class="proximanova-bold primary-font-color">Notes:</p>
									<div class="clearfix" style="height: 10px;"></div>
									<ul class="list no-margin text-justify">
										<li><p class="px-12-font">Initial Payment is the amount required for the issuance of Confirmation of Enrolment (CoE) which is payable in advance or as directed by the PCA and constitute tuition and non-tuition fees towards your course.</p></li>
										<li><p class="px-12-font">All fees are in Australian dollars and are subject to change without notice.</p></li>
										<li><p class="px-12-font">The balance due amount may be paid according to agreed payment plan, which can be found below in this document.</p></li>
										<li><p class="px-12-font">Late payment of fees may result in:</p></li>
										<li><p class="px-12-font">The possibility of PCA reporting you to the Department of Home Affairs (DHA) and cancelling your enrolment. Please keep PCA informed if payment is not going to be on time or you want extension.</p></li>
									</ul>
								</td>
							</tr>
						</table>

						<div class="clearfix" style="height: 20px;"></div>

						<p class="proximanova-bold">CONDITIONS</p>
						<div class="clearfix" style="height: 10px;"></div>
						<ul class="list no-margin text-justify">
							<li><p class="px-12-font">Please be advised that issuance of this offer letter does not guarantee the issuance of the eCOE until all the eligibility requirements are met.</p></li>
							<li><p class="px-12-font">PCA requires IELTS band score of 5.5 or equivalent in line with Department of Home Affairs regulations. Please speak to the PCA’s one of friendly team member for further information.</p></li>
							<li><p class="px-12-font">IELTS band 5.5 or equivalent. Candidate does not need to provide evidence of an English test score with application if one of the following applies (exemption): Candidate is a citizen and holds a passport from UK, USA, Canada, NZ or Republic of Ireland Candidate is enrolled in a principal course of study that is a registered school course, a standalone English Language Intensive Course for Overseas Students (ELICOS), a course registered to be delivered in a language other than English, or a registered post-graduate research course</p></li>
							<li><p class="px-12-font">Candidate has completed at least 5 years’ study in English in one or more of the following countries: Australia, UK, in the 2 years before applying for the student visa, candidate completed, in Australia and in the English language, either the Senior Secondary Certificate of Education or a substantial component of a course leading to a qualification from the Australian Qualifications Framework at the Certificate IV or higher level, while you held a student visa. In case student has not got valid IELTS test result and does not meet any exemption as listed above, the student will need to undertake LLN test conducted by PCA under supervision. ACSF level 3 is required to gain entry into the qualification. LLN test will be undertaken during the enrolment process before issuance of the confirmation of enrolment (COE). If learners do not meet English language / LLN requirements, learners will be asked to take further Language, literacy and numeracy training e.g. English Language Intensive Course for Overseas Learners (ELICOS) programs with institute at additional cost. PCA will not charge any referral fees.</p></li>
							<li><p class="px-12-font">Satisfactory completion of studies in applicant’s home country equivalent to an Australian Year 12 qualification is required for entry into this course.</p></li>
							<li><p class="px-12-font">All students must be of the age 18 years or over at the time of the scheduled course commencement.</p></li>
							<li><p class="px-12-font">If you are currently studying at another provider and have completed less than 6 months of the principal course, a Letter of Release must be obtained from your current provider and submitted to PCA with the acceptance of this offer prior to issuance of COE(s), or Confirmation those 6 months of your principal course has passed or will pass before the commencement date of this course (or your first course for packaged courses),or</p></li>
							<li><p class="px-12-font">You want to study a concurrent course at PCA along with your current principal course. Please see our one of the student support officers for further information in this regard.</p></li>
							<li><p class="px-12-font">You will be required to undertake the Pre-training review on the day you sign this acceptance agreement as part of your enrolment process. Please make yourself familiar with PCA’s policies and procedures, which can be found in PCA’s website.</p></li>
							<li><p class="px-12-font">Offer letter is subject to eligibility assessment by the international admission department/ PCA delegate/Student Support Officer of Phoenix College of Australia.</p></li>
							<li><p class="px-12-font">This document is to be accepted/signed by international students at the same time or prior to payment of fees.</p></li>
							<li><p class="px-12-font">This agreement, and the right to make complaints and seek appeals of decisions and action under various processes, does not affect the rights of the student to take action under the Australian Consumer Law if the Australian Consumer Law Applies.   </p></li>
						</ul>
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No. 45633 | CRICOS Code 03871F</p>
						<p style="margin-bottom: 0px;"> Page 2 of 16</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 2 of 16 -->
<!-- Page 3 of 16 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-offer-letter-and-enrolment-acceptance-agreement/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Offer Letter and Enrolment Acceptance Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content">

						<p class="proximanova-bold px-14-font">VALIDITY OF OFFER</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">This offer is only valid for 30 days from the date of issuance. A place in  this course(s) is not confirmed until PCA receives the requested payment, the signed Offer Letter and Enrolment Acceptance Agreement (as attached) and issues you with a Confirmation of Enrolment (COE).</p>
						<div class="clearfix" style="height: 20px;"></div>
						<p class="proximanova-bold px-14-font">PAYMENT REQUIRED FOR ACCEPTANCE</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">You can choose any from the following methods to make your payment to Phoenix College of Australia.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<ol class="list">
							<li>
								<p class="px-14-font">Direct Deposit</p>
								<div class="clearfix" style="height: 5px;"></div>
								<table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="50%" class="px-14-font proximanova-bold">Name of Account</td>
										<td width="50%">Phoenix College of Australia</td>
									</tr>
									<tr>
										<td class="px-14-font proximanova-bold">Bank name</td>
										<td>Westpac</td>
									</tr>
									<tr>
										<td class="px-14-font proximanova-bold">BSB</td>
										<td>033-501</td>
									</tr>
									<tr>
										<td class="px-14-font proximanova-bold">Account Number</td>
										<td>289843</td>
									</tr>
									<tr>
										<td class="px-14-font proximanova-bold">Swift code</td>
										<td>WPACAU2S</td>
									</tr>
								</table>
							</li>
							<li>
								<p class="px-14-font">Bank Transfer: Bank Details as above</p>
								<p class="px-14-font"><span class="proximanova-bold">Note:</span> For direct deposit of bank transfer, please provide your name (Student ID) as reference in order to easily track your payment.</p>
							</li>
							<li><p class="px-14-font">Credit Card</p></li>
							<li><p class="px-14-font">Bank Draft: Bank draft should be made payable to Phoenix College of Australia.</p></li>
							<li>
								<p class="px-14-font">Please provide the details of the person who can receive a refund on behalf of the student:</p>
								<div class="clearfix" style="height: 5px;"></div>
								<table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="50%" class="px-14-font proximanova-bold">Name of person</td>
										<td width="50%"></td>
									</tr>
									<tr>
										<td class="px-14-font proximanova-bold">Date of Birth</td>
										<td></td>
									</tr>
									<tr>
										<td class="px-14-font proximanova-bold">Address</td>
										<td></td>
									</tr>
									<tr>
										<td class="px-14-font proximanova-bold">Relationship</td>
										<td></td>
									</tr>
								</table>
							</li>
						</ol>
						<p class="px-14-font"><span class="proximanova-bold">Note:</span> The Student will start paying the remaining balance according to student payment schedule.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">Please ensure that you have read and understand the PCA Fee Charges and refund policy and Procedure. In order to accept this offer, please sign the declaration below on both copies sent to you and return one copy to the College. Please retain the second copy for your records. We look forward to welcoming you to Phoenix College of Australia, where you will be provided with high quality training and support, along with excellent career opportunities. Should you have any queries please do not hesitate to contact our Administration office.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="proximanova-bold px-14-font">Course Delivery</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">Phoenix College of Australia delivers all its courses via face to face mode of delivery. PCA has determined that CPP20218 consists of one study period of 3 weeks and 24 weeks for CPC31320 Certificate III in wall and floor tiling.  PCA will be monitoring course progress of the students according to the Monitoring Course Progress and intervention strategy for International students Policy and Procedure. Every course will be delivered 20 hours per week in a classroom and the mode of delivery will be face to face. The students are required to attend classes according to time table. Failure to attend the class may result in unsatisfactory course progress, which may result the cancellation of enrolment at PCA (Please refer to Monitoring Course Progress and intervention strategy for International Students Policy and Procedure on website or student handbook).  PCA will be contacting you to inform you about the date of orientation and location. Every student needs to attend the orientation program; failure to attend this program may result in cancellation of the enrolment at PCA. </p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">
						Prior to signing and accepting this enrolment acceptance, please read and ensure you understand the Terms and Conditions of Enrolment. You must also read the Student Handbook, Policies and Procedures on PCA‘s website carefully. Please contact our office if you prefer that we send you these documents via email or post.</p>

					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No. 45633 | CRICOS Code 03871F</p>
						<p style="margin-bottom: 0px;"> Page 3 of 16</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 3 of 16 -->
<!-- Page 4 of 16 -->
@if(count($offerData['course_details'][0]['payment_template']) < 8)
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-offer-letter-and-enrolment-acceptance-agreement/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Offer Letter and Enrolment Acceptance Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content">

						<p class="proximanova-bold px-14-font">ACADEMIC MISCONDUCT</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">Students are also required to adhere to the Code of Conduct. If a student is found to have acted in a way that Phoenix College of Australia (PCA) deems to be misconduct, it may impair their successful completion of the course.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">As outlined in the Code of Conduct, students are expected to approach training and assessment activities in an ethical manner. At PCA, our students strive to conduct themselves with integrity and do not engage in plagiarism or cheating. Confusion in relation to the definitions of both plagiarism and cheating can often occur and have been detailed below to avoid this occurrence and to eliminate their happening due to claims of confusion.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">CHEATING:</span> Cheating is the use of any means to gain an unfair advantage during the assessment process. Cheating may be (but not limited too) copying a friends answers, using mobile phones or other electronic devises during closed book assessments, bringing in and referring to pre prepared written answers in a closed book assessment and referring to texts during closed book assessments amongst others. Cheating in any form during assessments will result in the student’s assessment submission being invalidated.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">PLAGIARISM:</span> Plagiarism is the wrongful close imitation, or copying and publication of another person’s language, thoughts, ideas, or expressions, and the representation of them as one's own work. This includes copying all or pieces of another student work and representing it as your own. Plagiarism will also lead to the student’s submission of the applicable work being invalidated. If students are including other people’s work in submissions e.g. passages from books or websites, then reference should be made to the source. For further information on what constitutes plagiarism please refer to: <a href="http://www.plagiarism.org/">http://www.plagiarism.org/</a> and refer to the Plagiarism policy of PCA. Submitting plagiarised work during assessments will result in the student’s assessment submission being invalidated.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">Cheating and or plagiarism during assessments will be treated as a breach of the Code of Conduct and is deemed to be ‘Academic Misconduct’ and may lead to the student being removed from the course. No refund is applicable to the student in such circumstances</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify proximanova-bold" style="line-height: 14px;">AGREED PAYMENT PLAN OF COURSE FEES {{$offerData['course_details'][0]['course']['code']}} - {{$offerData['course_details'][0]['course']['name']}}</p>
						<div class="clearfix" style="height: 10px;"></div>
						<table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="35%" class="px-12-font proximanova-bold">Installment</td>
								<td width="30%" class="px-12-font proximanova-bold">Due Date</td>
								<td width="35%" class="px-12-font proximanova-bold">Amount (AUD)</td>
							</tr>
							@if($offerData['fees']['initial_payment_amount'] == '0')
							@php
								// computation
								$initial = $offerData['fees']['payment_required'];
								$nonTuition  = $offerData['course_details'][0]['course_matrix']['material_fees'] + $offerData['course_details'][0]['course_matrix']['enrolment_fee'];
								$tuition = $offerData['course_details'][0]['course_matrix']['onshore_tuition_individual'] - $offerData['fees']['discounted_amount'];
								$balance = $initial - $nonTuition;
								$totalTuition = $offerData['course_details'][0]['course_matrix']['onshore_tuition_individual'] / $offerData['course_details'][0]['course_matrix']['wk_duration'];
								$week = round($balance / $totalTuition);
								$balance = $tuition - $balance;
								$bduration = $offerData['course_details'][0]['course_matrix']['wk_duration'];
								$duration = $bduration - $week;
								$startdate = Carbon\Carbon::parse($offerData['course_details'][0]['course_start_date'])->addWeek($week);
								$ctr = 1;
								// echo '<tr>';
								// echo '<td>Installment 1 ( initial payment )</td>';
								// echo '<td>'. Carbon\Carbon::parse($offerData['course_details'][0]['course_start_date'])->subDay(3)->format('d/m/Y') .'</td>';
								// echo '<td>AUD 1,000.00 </td>';
								// echo '</tr>';
								echo '<tr>';
								echo '<td>Installment 1</td>';
								echo '<td>'.$startdate->format('d/m/Y') .'</td>';
								echo '<td>AUD '. number_format($balance,2).'</td>';
								echo '</tr>';

								// for ($i = 0; $i < $duration; $i++) {
								// 	echo '<tr>';
								// 	echo '<td class="px-10-font">Installment '.$ctr.'</td>';
								// 	if($i == 0){
								// 			echo '<td class="px-10-font">'. $startdate->format('d/m/Y').'</td>';
								// 	}else{
								// 		echo '<td class="px-10-font">'. $startdate->addWeek()->format("d/m/Y").'</td>';
								// 	}
								// 	echo '<td class="px-10-font">'.$totalTuition.'</td>';
								// 	echo '</tr>';
								// 	// echo '<tr>';
								// 	// echo '<td class="px-10-font">Installment '.$i+1.'</td>';
								// 	// echo '<td class="px-10-font">'.$totalTuition.'</td>';
								// 	// echo '<td class="px-10-font">'.$startdate->addWeek()->format("d/m/Y").'</td>';
								// 	// echo '</tr>';
								// 	$ctr++;
								// }
							@endphp
							@else
								@foreach ($offerData['course_details'][0]['payment_template'] as $key =>$payment_template)
									@if($key != 0) 
									<tr>
										<td class="px-10-font">Installment {{$loop->index}}</td>
										<td class="px-10-font">{{Carbon\Carbon::parse($payment_template['due_date'])->format('d/m/Y')}}</td>
										<td class="px-10-font">AUD {{ number_format($payment_template['payable_amount'],2) }}</td>
										{{-- <td class="px-10-font">AUD {{ number_format(125,1) }}</td> --}}
									</tr>
									@endif 
								@endforeach
							@endif
							{{-- <tr>
								<td class="px-10-font">Installment 1</td>
								<td class="px-10-font">1500</td>
								<td class="px-10-font"></td>
							</tr>
							<tr>
								<td class="px-10-font">Installment 2</td>
								<td class="px-10-font"></td>
								<td class="px-10-font"></td>
							</tr> --}}
							{{-- <tr>
								<td class="px-10-font" style="height: 15px;"></td>
								<td class="px-10-font"></td>
								<td class="px-10-font"></td>
							</tr>
							<tr>
								<td class="px-10-font" style="height: 15px;"></td>
								<td class="px-10-font"></td>
								<td class="px-10-font"></td>
							</tr>
							<tr>
								<td class="px-10-font" style="height: 15px;"></td>
								<td class="px-10-font"></td>
								<td class="px-10-font"></td>
							</tr>
							<tr>
								<td class="px-10-font" style="height: 15px;"></td>
								<td class="px-10-font"></td>
								<td class="px-10-font"></td>
							</tr>
							<tr>
								<td class="px-10-font" style="height: 15px;"></td>
								<td class="px-10-font"></td>
								<td class="px-10-font"></td>
							</tr> --}}
						</table>
						<div class="clearfix" style="height: 10px;"></div>
						@if($offerData['fees']['initial_payment_amount'] == null)
						<p class="px-12-font text-justify" style="line-height: 12px;">Please be advised that the instalment plan will defer on initial payment.</p>
						@endif
						<p class="px-12-font text-justify" style="line-height: 12px;">Please be advised that the student will be provided with the instalment plan before the commencement of the next course.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify proximanova-bold" style="line-height: 14px;">DECLARATION AND ACCEPTANCE BY APPLICANT:</p>
					<p class="px-12-font text-justify display-inlineblock">I,</p> <div class="textbox display-inlineblock line-textbox" style="width: 690px; margin-top: 3px;">{{ $offerData['student']['party']['name'] }}</div>
						<p class="px-12-font text-justify" style="line-height: 12px;">agree that by signing this declaration, I am accepting the above payment terms and conditions as outlined within this Offer letter.</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-12-font text-justify" style="line-height: 12px;">• I understand that my week payable tuition fees for the study period are calculated as:</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-12-font text-justify" style="line-height: 12px;">Total Tuition Fees</p>
						
						@if( $offerData['course_details'][0]['weekly_payment'] == '0' || $offerData['fees']['discounted_amount'] == '0.00')
						<div class="textbox display-inlineblock line-textbox" style="width: 100px; margin-top: 3px;">-----------------------------</div><p class="px-12-font text-justify display-inlineblock proximanova-bold"> * 7 </p>
						@else
					<div class="textbox display-inlineblock line-textbox" style="width: 100px; margin-top: 3px;">-----------------------------</div><p class="px-12-font text-justify display-inlineblock proximanova-bold">  *  7
						{{-- @if ($offerData['course_details'][0]['payment_template'][1]['payable_amount'] !=  end($offerData['course_details'][0]['payment_template'])['payable_amount'])
						 {{ count($offerData['course_details'][0]['payment_template']) - 2}}  + {{ end($offerData['course_details'][0]['payment_template'])['payable_amount'] }} </p>
                        @else
                        {{ count($offerData['course_details'][0]['payment_template']) - 1 }} 
						@endif	 --}}
						 --------------------------------------------
						@endif
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-12-font text-justify" style="line-height: 12px;">Number of Calendar days in duration </p>
						<p class="px-12-font text-justify" style="line-height: 12px;">I understand that I have to keep paying the agreed amount according to the student instalment plans. Failure to pay the fees on the agreed date may result in cancellation of enrolment at PCA. (Please refer to Student handbook for policy and procedures).</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-12-font text-justify display-inlineblock ">Signed by Applicant: </p> <div class="textbox display-inlineblock line-textbox " style="width: 390px;">
							@if($signed)
								<div class="type-signature">
								{{ $offerData['student']['party']['name'] }}
								</div>
							@endif
							
						</div>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-12-font text-justify display-inlineblock">Date: </p> <div class="textbox display-inlineblock line-textbox" style="width: 190px;">
						@if($signed)
									{{Carbon\Carbon::parse($offerData['issued_date'])->format('d/m/Y')}}
									@endif</div>
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No. 45633 | CRICOS Code 03871F</p>
						<p style="margin-bottom: 0px;"> Page 4 of 16</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
@else 
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-offer-letter-and-enrolment-acceptance-agreement/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Offer Letter and Enrolment Acceptance Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content">

						<p class="proximanova-bold px-14-font">ACADEMIC MISCONDUCT</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">Students are also required to adhere to the Code of Conduct. If a student is found to have acted in a way that Phoenix College of Australia (PCA) deems to be misconduct, it may impair their successful completion of the course.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">As outlined in the Code of Conduct, students are expected to approach training and assessment activities in an ethical manner. At PCA, our students strive to conduct themselves with integrity and do not engage in plagiarism or cheating. Confusion in relation to the definitions of both plagiarism and cheating can often occur and have been detailed below to avoid this occurrence and to eliminate their happening due to claims of confusion.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">CHEATING:</span> Cheating is the use of any means to gain an unfair advantage during the assessment process. Cheating may be (but not limited too) copying a friends answers, using mobile phones or other electronic devises during closed book assessments, bringing in and referring to pre prepared written answers in a closed book assessment and referring to texts during closed book assessments amongst others. Cheating in any form during assessments will result in the student’s assessment submission being invalidated.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">PLAGIARISM:</span> Plagiarism is the wrongful close imitation, or copying and publication of another person’s language, thoughts, ideas, or expressions, and the representation of them as one's own work. This includes copying all or pieces of another student work and representing it as your own. Plagiarism will also lead to the student’s submission of the applicable work being invalidated. If students are including other people’s work in submissions e.g. passages from books or websites, then reference should be made to the source. For further information on what constitutes plagiarism please refer to: <a href="http://www.plagiarism.org/">http://www.plagiarism.org/</a> and refer to the Plagiarism policy of PCA. Submitting plagiarised work during assessments will result in the student’s assessment submission being invalidated.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">Cheating and or plagiarism during assessments will be treated as a breach of the Code of Conduct and is deemed to be ‘Academic Misconduct’ and may lead to the student being removed from the course. No refund is applicable to the student in such circumstances</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify proximanova-bold" style="line-height: 14px;">AGREED PAYMENT PLAN OF COURSE FEES {{$offerData['course_details'][0]['course']['code']}} - {{$offerData['course_details'][0]['course']['name']}}</p>
						<div class="clearfix" style="height: 10px;"></div>
						<table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="35%" class="px-12-font proximanova-bold">Installment</td>
								<td width="30%" class="px-12-font proximanova-bold">Due Date</td>
								<td width="35%" class="px-12-font proximanova-bold">Amount (AUD)</td>
							</tr>
							@if($offerData['fees']['initial_payment_amount'] == '0')
							@php
								// computation
								$initial = $offerData['fees']['payment_required'];
								$nonTuition  = $offerData['course_details'][0]['course_matrix']['material_fees'] + $offerData['course_details'][0]['course_matrix']['enrolment_fee'];
								$tuition = $offerData['course_details'][0]['course_matrix']['onshore_tuition_individual'] - $offerData['fees']['discounted_amount'];
								$balance = $initial - $nonTuition;
								$totalTuition = $offerData['course_details'][0]['course_matrix']['onshore_tuition_individual'] / $offerData['course_details'][0]['course_matrix']['wk_duration'];
								$week = round($balance / $totalTuition);
								$balance = $tuition - $balance;
								$bduration = $offerData['course_details'][0]['course_matrix']['wk_duration'];
								$duration = $bduration - $week;
								$startdate = Carbon\Carbon::parse($offerData['course_details'][0]['course_start_date'])->addWeek($week);
								$ctr = 1;
								// echo '<tr>';
								// echo '<td>Installment 1 ( initial payment )</td>';
								// echo '<td>'. Carbon\Carbon::parse($offerData['course_details'][0]['course_start_date'])->subDay(3)->format('d/m/Y') .'</td>';
								// echo '<td>AUD 1,000.00 </td>';
								// echo '</tr>';
								echo '<tr>';
								echo '<td>Installment 1</td>';
								echo '<td>'.$startdate->format('d/m/Y') .'</td>';
								echo '<td>AUD '. number_format($balance,2).'</td>';
								echo '</tr>';

								// for ($i = 0; $i < $duration; $i++) {
								// 	echo '<tr>';
								// 	echo '<td class="px-10-font">Installment '.$ctr.'</td>';
								// 	if($i == 0){
								// 			echo '<td class="px-10-font">'. $startdate->format('d/m/Y').'</td>';
								// 	}else{
								// 		echo '<td class="px-10-font">'. $startdate->addWeek()->format("d/m/Y").'</td>';
								// 	}
								// 	echo '<td class="px-10-font">'.$totalTuition.'</td>';
								// 	echo '</tr>';
								// 	// echo '<tr>';
								// 	// echo '<td class="px-10-font">Installment '.$i+1.'</td>';
								// 	// echo '<td class="px-10-font">'.$totalTuition.'</td>';
								// 	// echo '<td class="px-10-font">'.$startdate->addWeek()->format("d/m/Y").'</td>';
								// 	// echo '</tr>';
								// 	$ctr++;
								// }
							@endphp
							@else
								@foreach ($offerData['course_details'][0]['payment_template'] as $key =>$payment_template)
									@if($key != 0) 
									<tr>
										<td class="px-10-font">Installment {{$loop->index}}</td>
										<td class="px-10-font">{{Carbon\Carbon::parse($payment_template['due_date'])->format('d/m/Y')}}</td>
										<td class="px-10-font">AUD {{ number_format($payment_template['payable_amount'],2) }}</td>
										{{-- <td class="px-10-font">AUD {{ number_format(125,1) }}</td> --}}
									</tr>
									@endif 
								@endforeach
							@endif
							{{-- <tr>
								<td class="px-10-font">Installment 1</td>
								<td class="px-10-font">1500</td>
								<td class="px-10-font"></td>
							</tr>
							<tr>
								<td class="px-10-font">Installment 2</td>
								<td class="px-10-font"></td>
								<td class="px-10-font"></td>
							</tr> --}}
							{{-- <tr>
								<td class="px-10-font" style="height: 15px;"></td>
								<td class="px-10-font"></td>
								<td class="px-10-font"></td>
							</tr>
							<tr>
								<td class="px-10-font" style="height: 15px;"></td>
								<td class="px-10-font"></td>
								<td class="px-10-font"></td>
							</tr>
							<tr>
								<td class="px-10-font" style="height: 15px;"></td>
								<td class="px-10-font"></td>
								<td class="px-10-font"></td>
							</tr>
							<tr>
								<td class="px-10-font" style="height: 15px;"></td>
								<td class="px-10-font"></td>
								<td class="px-10-font"></td>
							</tr>
							<tr>
								<td class="px-10-font" style="height: 15px;"></td>
								<td class="px-10-font"></td>
								<td class="px-10-font"></td>
							</tr> --}}
						</table>
						<div class="clearfix" style="height: 10px;"></div>
						@if($offerData['fees']['initial_payment_amount'] == null)
						<p class="px-12-font text-justify" style="line-height: 12px;">Please be advised that the instalment plan will defer on initial payment.</p>
						@endif
						
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No. 45633 | CRICOS Code 03871F</p>
						<p style="margin-bottom: 0px;"> Page 4 of 16</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-offer-letter-and-enrolment-acceptance-agreement/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Offer Letter and Enrolment Acceptance Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content">
						<p class="px-12-font text-justify" style="line-height: 12px;">Please be advised that the student will be provided with the instalment plan before the commencement of the next course.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify proximanova-bold" style="line-height: 14px;">DECLARATION AND ACCEPTANCE BY APPLICANT:</p>
					<p class="px-12-font text-justify display-inlineblock">I,</p> <div class="textbox display-inlineblock line-textbox" style="width: 690px; margin-top: 3px;">{{ $offerData['student']['party']['name'] }}</div>
						<p class="px-12-font text-justify" style="line-height: 12px;">agree that by signing this declaration, I am accepting the above payment terms and conditions as outlined within this Offer letter.</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-12-font text-justify" style="line-height: 12px;">• I understand that my week payable tuition fees for the study period are calculated as:</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-12-font text-justify" style="line-height: 12px;">Total Tuition Fees</p>
						
						@if( $offerData['course_details'][0]['weekly_payment'] == '0' || $offerData['fees']['discounted_amount'] == '0.00')
						<div class="textbox display-inlineblock line-textbox" style="width: 100px; margin-top: 3px;">-----------------------------</div><p class="px-12-font text-justify display-inlineblock proximanova-bold"> * 7 </p>
						@else
					<div class="textbox display-inlineblock line-textbox" style="width: 100px; margin-top: 3px;">-----------------------------</div><p class="px-12-font text-justify display-inlineblock proximanova-bold">  *  7
						{{-- @if ($offerData['course_details'][0]['payment_template'][1]['payable_amount'] !=  end($offerData['course_details'][0]['payment_template'])['payable_amount'])
						 {{ count($offerData['course_details'][0]['payment_template']) - 2}}  + {{ end($offerData['course_details'][0]['payment_template'])['payable_amount'] }} </p>
                        @else
                        {{ count($offerData['course_details'][0]['payment_template']) - 1 }} 
						@endif	 --}}
						 --------------------------------------------
						@endif
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-12-font text-justify" style="line-height: 12px;">Number of Calendar days in duration </p>
						<p class="px-12-font text-justify" style="line-height: 12px;">I understand that I have to keep paying the agreed amount according to the student instalment plans. Failure to pay the fees on the agreed date may result in cancellation of enrolment at PCA. (Please refer to Student handbook for policy and procedures).</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-12-font text-justify display-inlineblock ">Signed by Applicant: </p> <div class="textbox display-inlineblock line-textbox " style="width: 390px;">
							@if($signed)
								<div class="type-signature">
								{{ $offerData['student']['party']['name'] }}
								</div>
							@endif
							
						</div>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-12-font text-justify display-inlineblock">Date: </p> <div class="textbox display-inlineblock line-textbox" style="width: 190px;">
						@if($signed)
									{{Carbon\Carbon::parse($offerData['issued_date'])->format('d/m/Y')}}
									@endif</div>
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No. 45633 | CRICOS Code 03871F</p>
						<p style="margin-bottom: 0px;"> Page 4.5 of 16</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
@endif

<!-- End Page 4 of 16 -->
<!-- Page 5 of 16 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-offer-letter-and-enrolment-acceptance-agreement/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Offer Letter and Enrolment Acceptance Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content">

						<p class="proximanova-bold px-14-font">Fee Charges and Refunds Policy and Procedure</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="proximanova-bold px-12-font">Purpose</p>
						<p class="px-14-font text-justify" style="line-height: 14px;">The purpose of this policy and procedure is to ensure that Phoenix College of Australia (PCA) operates a fair and equitable process for the management of both the collection of fees and the repayment of fees. This complies with Clauses 5.3, 7.3 and Schedule 6 of the Standards, as well as the ESOS Act and the National Code of Practice for Providers of Education and Training to Overseas Students 2018, Standard 2 and 3.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="proximanova-bold px-12-font">Scope</p>
						<p class="px-14-font text-justify" style="line-height: 14px;">It applies to international students studying Vocational Education and Training (VET) courses.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="proximanova-bold px-14-font">Process for claiming a refund</p>
						<ul class="list">
							<li><p class="px-12-font">Refund application requests must be made in writing on the Refund Request Form, the refund request form may be downloaded from the PCA’s website. </p></li>
							<li><p class="px-12-font">Filled in form must be submitted with the Administration. </p></li>
							<li><p class="px-12-font">The Application/enrolment fee of AUD250.00 is not refundable. The course fees will be refunded as per the table later in this policy document.</p></li>
							<li><p class="px-12-font">The Accounts department will process and approve the refund amount (if applicable) based on the circumstances listed below. </p></li>
							<li><p class="px-12-font">Refund will be made directly to the bank account stated in the Refund Request Form and the student will be informed about the same via an email. All refunds will be made in Australian Dollars. </p></li>
							<li><p class="px-12-font">Student can nominate a person in whose account the refund can be made. In case of death of the student, refund can be claimed by parents of the student. </p></li>
							<li><p class="px-12-font">If the student is not eligible for any refund, based on the circumstances as stated below, the student shall be informed of the same via an email/letter.</p></li>
							<li><p class="px-12-font">Any other circumstances which have not been listed below in the table, the management of PCA will decide the refund. In most of the cases, the students will be refunded after deducting the application fee.</p></li>
							<li><p class="px-12-font">Any refund given will be recorded in the Student Information System so that each student’s financial status is known.</p></li>
							<li><p class="px-12-font">The students have right to lodge an appeal with the institute if they are not satisfied with the decision /outcome of the refund request.</p></li>
							<li><p class="px-12-font">PCA cannot guarantee that students will successfully complete the course(s) in which they enrol regardless of whether all fees due have been paid.</p></li>
						</ul>
						<p class="proximanova-bold px-14-font">Definitions:</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Electronic Confirmation of Enrolment (eCoE):</span> An official document printed via the PRISMS system on behalf of the Australian government confirming the enrolment of the student in the course.  This document is required for a student to apply for a Student Visa.</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Course Commencement Date: </span>Refers to the start date indicated on the first eCoE issued by the Institute. This does not refer to the deferred or subsequent eCoE.</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Course Money: </span>The money received by the Institute for providing the course to the students which includes: tuition fees, any amount received that must be paid to a registered health provider on behalf of the student, airport pick-up, accommodation booking and board, and any other amount paid by the student to the Institute to undertake the course.</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Direct International Student: </span>People who are enrolled with the Institute and include both prospective and currently enrolled students who are overseas students as defined in the National Code of Practice for Providers of Education and Training to Overseas Students and hold a student visa.</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Application Fee (Non-academic): </span>The application fee payable when an application is made to PCA for an enrolment to a course or qualification. This fee is non-refundable fee covering the administration cost of PCA. The Application fee is subject to change.</p>
						
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No. 45633 | CRICOS Code 03871F</p>
						<p style="margin-bottom: 0px;"> Page 5 of 16</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 5 of 16 -->
<!-- Page 6 of 16 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-offer-letter-and-enrolment-acceptance-agreement/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Offer Letter and Enrolment Acceptance Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content">

						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Onshore Students: </span>Students who are applying for student visa within Australia.</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Offshore Students: </span>Students who are applying for student visa outside Australia.</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Local International Students: </span>A person granted an initial visa to attend another Australian education institute and wants to extend that visa by enrolling at the Institute.</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Tuition Fees (Academic): </span>The amount paid to enable the student to undertake the course as indicated in the OFFER LETTER AND ENROLMENT ACCEPTANCE under course fees.</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Incidental Fees (Non-academic): </span>All other fees that is not included in the Tuition Fees or Application Fee. E.g. Materials Fees, Airport Pickup etc.</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Deposit Fees (Academic): </span>Fees paid in advance prior to commencement of the course or a study period.</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">TPS: </span>Tuition Protection Scheme (enacted on 20th March 2012 as part of the Government’s second phase response to the Baird Review) replacing Tuition Assurance Scheme and ESOS Assurance Fund.</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Reassessment fee: </span>Once an assessment task has been officially submitted and the assessment is deemed unsatisfactory, the learner will be provided feedback by the Assessor and provided an opportunity to resubmit by an agreed due date at no cost with in the COE duration.  If the student does not resubmit the assessment on the agreed due date, student will need to pay the cost for the reassessment. Fees for the reassessment for each unit is $250. </p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">If the student does not submit the assessment on due date and hence deemed NYC student will need to pay the reassessment fees of $250.00. </p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">Only the CEO has authority to waive off or discount the reassessment fees. Student can ask the staff to request for waiver of the fees or discount. </p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Provider default: </span>In the unlikely event that the institute is unable to deliver the course in full, student will be offered a refund of all  the unused tuition fees paid to date. The refund will be paid within 14 working days of the day on which the course ceased being provided.</p>
						<p class="px-14-font text-justify" style="line-height: 14px;">Alternatively, student may be offered enrolment in a suitable alternative course by the institute at no extra cost to student. Students have the right to choose whether they prefer a full refund of course fees, or to accept a place in another course. If student chooses placement in another suitable course, institute will ask the student to sign a document to indicate the acceptance of the placement. If the institute is unable to provide a refund or place student in an alternative course, institute’s Tuition Protection Service (TPS) is provided.</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Student default: </span>Means that:</p>
						<ul class="list no-margin" style="padding-left: 12px;">
							<li>the course starts at the location on the agreed starting day, but the student does not start the course on that day (and has not previously withdrawn); or</li>
							<li>the student withdraws from the course at the location (either before or after the agreed starting day); or</li>
							<li>the registered provider of the course refuses to provide, or continue providing, the course to the student at the location because of one or more of the following:
								<div class="clearfix" style="height: 5px;"></div> 
								<ul class="list no-margin" style="padding-left: 12px;">
									<li>the student failed to pay an amount payable to the provider for the course; </li>
									<li>the student breached a condition of his/her student visa; </li>
									<li>misbehaviour by the student.</li>
								</ul>
							</li>
						</ul>
						<p class="px-14-font text-justify" style="line-height: 14px;">A student does not default for failing to start a course on the agreed starting day if he/she does not start that course because of provider default.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="proximanova-bold px-14-font">Fees and refund information</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">The fee information is always provided prior to enrolment or receipt of payment as per the requirements of the National Code 2018 Standard 2 and 3. The Offer Letter and Enrolment Acceptance and the International Student</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">Handbook which are provided prior to enrolment, includes this Fee Charges and Refunds Policy and Procedure and informs the students of their consumer rights. Students are required to sign the Offer Letter and Enrolment Acceptance in acknowledgement of the terms and conditions of the enrolment and this policy.</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="proximanova-bold px-14-font">Course fee inclusions</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">The Offer Letter and Enrolment Acceptance will clearly itemise all course fees, including both tuition and non-tuition fees.</p>
						
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No. 45633 | CRICOS Code 03871F</p>
						<p style="margin-bottom: 0px;"> Page 6 of 16</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 6 of 16 -->
<!-- Page 7 of 16 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-offer-letter-and-enrolment-acceptance-agreement/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Offer Letter and Enrolment Acceptance Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content">

						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Tuition fees include:</span></p>
						<div class="clearfix" style="height: 5px;"></div>
						<ul class="list no-margin" style="padding-left: 12px;">
							<li>All of the training/teaching and assessment required for students to achieve the qualification or course in which they are enrolling within the attempts allowed. </li>
							<li>Issuance of one set of certification documents including the testamur (certificate) and record of results. A Statement of Attainment (in the case of withdrawal or partial completion).</li>
						</ul>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Non-Tuition fees on the Offer Letter and Enrolment Acceptance. See charges below for additional non-tuition fees:</span></p>
						<div class="clearfix" style="height: 10px;"></div>
						<table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="30%" class="px-12-font proximanova-bold primary-bg-color white-font-color">Airport Pickup </td>
								<td width="70%" class="px-12-font">$180</td>
							</tr>
							<tr>
								<td class="px-12-font proximanova-bold primary-bg-color white-font-color">Accommodation Booking Assistance</td>
								<td class="px-12-font">$180</td>
							</tr>
							<tr>
								<td class="px-12-font proximanova-bold primary-bg-color white-font-color">RPL (1st consultation is free)</td>
								<td class="px-12-font">$200 per unit</td>
							</tr>
							<tr>
								<td class="px-12-font proximanova-bold primary-bg-color white-font-color">Credit Transfer</td>
								<td class="px-12-font">Nil</td>
							</tr>

						</table>
						<table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0" style="border-top: 0;">

							<tr>
								<td colspan="2" class="primary-bg-color white-font-color px-14-font proximanova-bold" style="border-top: 0;">Other Fees</td>
							</tr>
							<tr>
								<td width="70%" class="px-12-font proximanova-bold primary-bg-color white-font-color">Re-assessment Fees</td>
								<td width="30%" class="px-12-font">$250 ( After one reassessment attempt )</td>
							</tr>
							<tr>
								<td class="px-12-font proximanova-bold primary-bg-color white-font-color">Re-issuance of student ID</td>
								<td class="px-12-font">$20</td>
							</tr>
							<tr>
								<td class="px-12-font proximanova-bold primary-bg-color white-font-color">Re-issuance of Testamur (Certificate or Statement of Attainment)</td>
								<td class="px-12-font">$25</td>
							</tr>
							<tr>
								<td class="px-12-font proximanova-bold primary-bg-color white-font-color">Late payment of tuition fees</td>
								<td class="px-12-font">$50 per month</td>
							</tr>
							<tr>
								<td class="px-12-font proximanova-bold primary-bg-color white-font-color">Deferral of Study</td>
								<td class="px-12-font">Nil</td>
							</tr>
							<tr>
								<td class="px-12-font proximanova-bold primary-bg-color white-font-color">
									Dishonour fee
									<div class="clearfix"></div>\
									(If payments are via direct debit and a payment has been dishonoured)
								</td>
								<td class="px-12-font">$10</td>
							</tr>
						</table>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Tuition Protection Scheme</span></p>
						<div class="clearfix" style="height: 5px;"></div>
						<ul class="list no-margin">
							<li>Phoenix College of Australia is a member of the Australian Government endorsed Tuition Protection Service (TPS).</li>
							<li>Phoenix College of Australia will maintain membership of the Tuition Protection Service during its period of registration as a provider.</li>
							<li>Phoenix College of Australia will pay all subscriptions to the TPS in accordance with TPS requirements.</li>
							<li>If due to unforeseen circumstances Phoenix College of Australia is unable to complete the delivery of a course once commenced, and subsequently refund the student tuition fees unused and/ or offer them an acceptable place in another course at Phoenix College of Australia, the Tuition Protection Service will attempt to secure a place for the student in a suitable course at another Institute.</li>
							<li>PCA will not charge more than 50% of tuition fees prior to enrolment. </li>
							<li>If the student pays more than 50% of tuition fees, the student will need to sign the form "Declaration by the student when they choose to pay more than 50% of tuition fees".</li>
							<li>PCA will be maintaining a specific bank account for the collection of student fees paid in advanced of training and assessment.</li>
						</ul>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Payments</span></p>
						<div class="clearfix" style="height: 5px;"></div>
						<ul class="list no-margin">
							<li>Payments can be accepted by electronic transfer, credit card, or cash.</li>
							<li>Credit card payments may incur a surcharge of 2% per transaction.</li>
							<li>Students who are experiencing difficulty in paying their fees are invited to call our office to make alternative arrangements for payment during their period of difficulty.</li>
							<li>Debts will be referred to a debt collection agency where fees are more than 40 days past due. </li>
						</ul>
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No. 45633 | CRICOS Code 03871F</p>
						<p style="margin-bottom: 0px;"> Page 7 of 16</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 7 of 16 -->
<!-- Page 8 of 16 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-offer-letter-and-enrolment-acceptance-agreement/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Offer Letter and Enrolment Acceptance Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content">

						<ul class="list no-margin">
							<li>PCA reserves the right to suspend the provision of training and/or other services until fees are brought up to date. Students with long term outstanding accounts may be withdrawn from their course if payments have not been received and no alternative arrangements for payment have been made. </li>
							<li>International students who do not pay their fees as agreed, will receive two warnings regarding non-payment of fees and thereafter will be reported to DET via PRISMS under student default. </li>
						</ul>

						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Recording and payment of refunds</span></p>
						<div class="clearfix" style="height: 5px;"></div>
						<ul class="list no-margin">
							<li>Refunds will be paid to the person or organisation that made the original payment and the account details must be mentioned in the Refund Request Form.</li>
							<li>Refund assessments can be appealed following our Complaints and Appeals Policy and Procedure.</li>
							<li>Records of refund assessments and issuance of refunds will be stored securely on the student’s file and in our accounts keeping system.</li>
						</ul>

						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Publication</span></p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">PCA will publish this Fee Charges and Refunds Policy and Procedure.</p>

						<div class="clearfix" style="height: 25px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Procedure</span></p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-12-font text-justify" style="line-height: 12px;"><span class="proximanova-bold">Student Fees</span></p>
						<div class="clearfix" style="height: 5px;"></div>
						<ul class="list no-margin" style="padding-left: 12px;">
							<li>All international students should pay their initial deposit/application fee upon enrolment. </li>
							<li>PCA will ensure that there is a signed written Offer Letter and Enrolment Acceptance agreement on file.</li>
							<li>Student will get the receipt for the payment. </li>
							<li>PCA will make a payment schedule for the remaining course fees, which will be reflecting in the Offer Letter and Enrolment Acceptance.</li>
							<li>PCA will ensure all payment terms, conditions and amounts are as indicated on the agreement unless a record of an agreed or advised change is in writing and the conditions of such a change were outlined on the agreement. </li>
							<li>Student is required to abide with the dates on payment schedule. It will be considered as student default if the student does not pay on the agreed date/or the date on the payment schedule.</li>
							<li>Payments may be made by cash, direct bank transfer, credit card.</li>
							<li>Fees for international students may not be collected until the Offer Letter and Enrolment Acceptance agreement has been signed. </li>
							<li>PCA will provide the student with a receipt and will be retained in student file.</li>
							<li>Receipts of payments made by international students will be kept for at least 2 years after the person ceases to be an accepted student.</li>
						</ul>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-12-font text-justify" style="line-height: 12px;"><span class="proximanova-bold">Overdue Fees</span></p>
						<div class="clearfix" style="height: 5px;"></div>
						<ul class="list no-margin" style="padding-left: 12px;">
							<li>PCA will contact students where payments are more than 10 days overdue.</li>
							<li>PCA will send out first warning letter regarding non-payment of fees when payment are more than 10 days overdue.</li>
							<li>Second warning letter regarding non-payment of fees will be sent out by PCA when payment are more than 20 days overdue.</li>
							<li>PCA will send notification of intention to cancel regarding non-payment of fees when payment are more than 30 days overdue. Please refer to PCA’s Deferment, Suspension and Cancellation of Enrolment Policy and Procedure for cancellation in case of non-payment of fees.</li>
							<li>Any student with an outstanding amount for more than 40 days past may be referred to the debt collection agency.</li>
						</ul>

					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No. 45633 | CRICOS Code 03871F</p>
						<p style="margin-bottom: 0px;"> Page 8 of 16</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 8 of 16 -->
<!-- Page 9 of 16 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-offer-letter-and-enrolment-acceptance-agreement/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Offer Letter and Enrolment Acceptance Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content">

						<p class="px-12-font text-justify" style="line-height: 12px;"><span class="proximanova-bold">Refunds</span></p>
						<div class="clearfix" style="height: 5px;"></div>
						<ul class="list no-margin" style="padding-left: 12px;">
							<li>PCA will automatically issue a refund within 14 days to students who have enrolled and paid their deposit/enrolment fee and the course is cancelled from the scope of registration, prior to commencement. </li>
							<li>PCA will also automatically issue a refund to students within 14 days where the course has commenced but is cancelled from the scope of registration.</li>
							<li>PCA will notify students to whom refunds are automatically issued in writing, will issue refund and will record on file.</li>
							<li>All other students who seek a refund are required to complete a Refund Request Form. </li>
							<li>The completed form is then handed over to the Student Support officer (SSO).</li>
							<li>The SSO advises the applicant that the turnaround time is a maximum of 14 working days. </li>
							<li>The application is forwarded  to the CEO  / Compliance Officer / Authorised delegate for assessment against the eligibility of the refund.</li>
							<li>If the applicant is eligible for a refund, calculation of refund is made, and a cheque or bank transfer into nominated account is processed for the amount to be refunded.</li>
							<li>In both cases (eligible or not), the applicant is sent an outcome letter and is kept in the student file as well. </li>
							<li>If the applicant is not onshore, then the amount would be refunded to either the student nominated person (on consent of the applicant) and a record of the same is kept.</li>
						</ul>
						<div class="clearfix" style="height: 25px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Tuition Protection Service steps in case of defaults</span></p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font" style="font-style: italic;">A. Provider Default</p>
						<p class="px-12-font">The following steps outline the TPS process if a provider default occurs:</p>
						<div class="clearfix" style="height: 15px;"></div>
						<p class="px-14-font">Step 1 - Provider default occurs</p>
						<p class="px-14-font" style="line-height: 14px;">A registered provider defaults, in relation to an overseas student or intending overseas student and a course at a location, if:</p>
						<div class="clearfix" style="height: 10px;"></div>
						<ul class="list no-margin" style="padding-left: 17px;">
							<li>the provider fails to start providing the course to the student at the location on the agreed starting day; or</li>
							<li>after the course starts but before it is completed, it ceases to be provided to the student at the location; and the student has not withdrawn from the course before the default day.</li>
						</ul>
						<p class="px-14-font"><span class="proximanova-bold">Note:</span> Section 46A of ESOS Act sets out further rules prescribing when a provider defaults.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font">Step 2 - Notifying the Secretary, the TPS Director and students</p>
						<div class="clearfix" style="height: 5px;"></div>
						<ul class="list no-margin" style="padding-left: 17px;">
							<li>PCA will notify the Secretary and the TPS Director of the default within 3 business days of the default occurring. PCA will also notify students in relation to whom PCA would default.</li>
							<li>The notices must be in writing and meet the requirements of section 46B of ESOS Act.</li>
						</ul>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font">Step 3 - Provider obligation period</p>
						<div class="clearfix" style="height: 5px;"></div>
						<ul class="list no-margin" style="padding-left: 17px;">
							<li>PCA will have 14 days after the day of the default (the provider obligation period) to satisfy the tuition protection obligations to the student.</li>
						</ul>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font">Step 4 - Notification of the outcome- discharge of obligations</p>
						<div class="clearfix" style="height: 5px;"></div>
						<ul class="list no-margin" style="padding-left: 17px;">
							<li>PCA will have 7 days after the end of the obligation period to give a notice to the Secretary and the TPS Director of the outcome of the discharge of the obligations. </li>
							<li>If PCA will not be able to the obligations affected students may be assisted by the TPS Director.</li>
						</ul>
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No. 45633 | CRICOS Code 03871F</p>
						<p style="margin-bottom: 0px;"> Page 9 of 16</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 9 of 16 -->
<!-- Page 10 of 16 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-offer-letter-and-enrolment-acceptance-agreement/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Offer Letter and Enrolment Acceptance Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content">

						<p class="px-14-font" style="font-style: italic;">B. Student Default</p>
						<p class="px-12-font">The following Steps outline the TPS process in a case of a student default:</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font">PCA enters into a written agreement with each overseas student or intending overseas student that:</p>
						<div class="clearfix" style="height: 5px;"></div>
						<ul class="list no-margin" style="padding-left: 17px;">
							<li>sets out the refund requirements that apply if the student defaults; and</li>
							<li>meets any requirements set out in the national code.</li>
						</ul>
						<p class="px-14-font">Step 1 -Student default occurs</p>
						<p class="px-14-font" style="line-height: 14px;">An overseas student or intending overseas student defaults, in relation to a course at a location, if:</p>
						<div class="clearfix" style="height: 10px;"></div>
						<ul class="list no-margin" style="padding-left: 17px; margin-bottom: -10px;">
							<li>the course starts at the location on the agreed starting day, but the student does not start the course on that day (and has not previously withdrawn); or</li>
							<li>the student withdraws from the course at the location (either before or after the agreed starting day); or</li>
							<li>the registered provider of the course refuses to provide, or continue providing, the course to the student at the location because of one or more of the following:
							<div class="clearfix" style="height: 5px;"></div>
								<ul class="list no-margin" style="padding-left: 17px;">
									<li>the student failed to pay an amount payable to the provider for the course;</li>
									<li>the student breached a condition of his/her student visa;</li>
									<li>misbehaviour by the student.</li>
								</ul>
							</li>
						</ul>
						<p class="px-14-font">Step 2 - Notifying the Secretary and the TPS Director</p>
						<p class="px-14-font" style="line-height: 14px;">To meet Tuition Protection Service (TPS) reporting obligations, PCA only needs to report on whether institute has provided a refund to a student in two cases of student default:</p>
						<div class="clearfix" style="height: 10px;"></div>
						<ul class="list no-margin" style="padding-left: 17px;">
							<li>where a student's visa is refused, even if there is a compliant written agreement in place</li>
							<li>where there is no compliant written agreement in place.</li>
						</ul>
						<p class="px-14-font">Step 3 - Provider obligation period</p>
						<div class="clearfix" style="height: 5px;"></div>
						<ul class="list no-margin" style="padding-left: 17px;">
							<li>If a student or intending student defaults, PCA will provide a refund in accordance with the requirements under sections of the ESOS Act, depending on which section applies to the circumstances of the default situation.</li>
							<li>PCA will pay the refund within the period (the provider obligation period) of 4 weeks after the day specified in sections, depending on which section applies to the circumstances of the default situation.</li>
						</ul>
						<p class="px-14-font">Step 4 - Notification of the outcome - discharge of obligations</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font" style="line-height: 14px;">PCA will have 7 days after the end of the obligation period to give a notice to the Secretary and the TPS Director of the outcome of the discharge of the obligations where PCA is required to provide a refund under (i.e. where there is no written agreement in place and also in cases of visa refusal, whether there is a written agreement in place or not).</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font" style="line-height: 14px;">The various fee refund conditions and refunds applicable are highlighted below.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="50%" class="px-12-font proximanova-bold primary-bg-color white-font-color">Description</td>
								<td width="50%" class="px-12-font proximanova-bold primary-bg-color white-font-color">Refund status</td>
							</tr>
							<tr>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">A course application is rejected by PCA</p></td>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">Full refund (this excludes an Application fee of $250)</p></td>
							</tr>
							<tr>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">If an offer of a place is withdrawn by PCA and this is due to incorrect or incomplete information being provided by the student</p></td>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">Full refund of course fees (this excludes the Application fee which is non-refundable).</p></td>
							</tr>
							<tr>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">Airport Pick-up (if applicable)</p></td>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">Full refund if service cancelled prior to flight arrival</p></td>
							</tr>
							<tr>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">Credit card payment surcharge and any transaction fees</p></td>
								<td><p class="px-12-font text-justify" style="line-height: 12px;"><span class="proximanova-bold">No refund</span></p></td>
							</tr>
							<tr>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">Visa cancelled due to actions of the student</p></td>
								<td><p class="px-12-font text-justify" style="line-height: 12px;"><span class="proximanova-bold">No refund</span></p></td>
							</tr>
							<tr>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">Where a student applies and is approved by PCA to transfer to another registered provider before the completion of six months of study of the principal course.</p></td>
								<td><p class="px-12-font text-justify" style="line-height: 12px;"><span class="proximanova-bold">No refund</span></p></td>
							</tr>
							<tr>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">If a Student chooses to pay Tuition Fees on an instalment basis on an agreed payment plan.</p></td>
								<td><p class="px-12-font text-justify" style="line-height: 12px;"><span class="proximanova-bold">No refund</span> will be issued for any course money (paid on instalment basis). Instalments paid will be for course fees due and payable to the institute for services already rendered.</p></td>
							</tr>
						</table>
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No. 45633 | CRICOS Code 03871F</p>
						<p style="margin-bottom: 0px;"> Page 10 of 16</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 10 of 16 -->
<!-- Page 11 of 16 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-offer-letter-and-enrolment-acceptance-agreement/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Offer Letter and Enrolment Acceptance Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content">

						<table width="100%" class="table-bordered table-padded" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td colspan="3" class="px-12-font proximanova-bold primary-bg-color white-font-color">Provider Default</td>
							</tr>
							<tr>
								<td width="40%"><p class="px-12-font text-justify" style="line-height: 12px;">Course is withdrawn by PCA (before the agreed start date). PCA is unable to start the delivery of a course at the location on the agreed starting day or ceases to deliver the course before it is completed.</p></td>
								<td rowspan="2" width="20%"><p class="px-12-font text-justify" style="line-height: 12px;"><span class="proximanova-bold">Full refund</span> excluding Application fee within 2 weeks of cancellation, or the agreed starting date, whichever is applicable</p></td>
								<td rowspan="4" width="40%">
									<p class="px-12-font text-justify" style="line-height: 12px;">In the unlikely event that the institute is unable to deliver your course before commencement or in full, you will be offered a full refund or after commencement of the course, refund of any Tuition Fee paid in advance for the default course. The refund amount will be calculated as follows: </p>
									<div class="clearfix" style="height: 5px;"></div>
									<p class="px-12-font text-justify" style="line-height: 12px;">The refund amount = weekly tuition fee x the number of weeks in the <span style="text-style: italic;">default period</span></p>
									<div class="clearfix" style="height: 25px;"></div>
									<ol  class="list no-margin" type="a" style="margin-bottom: -15px;">
										<li style="margin-bottom:10px;"><p class="px-12-font text-justify" style="line-height: 12px; margin-top: -13px;">The weekly tuition fee = total tuition fee for the course / number of calendar days in the course x 7. This amount is rounded up to the nearest whole dollar.</p></li>
										<li><p class="px-12-font text-justify" style="line-height: 12px; margin-top: -13px;">The number of weeks in the default period = number of calendar days from the default day to the end of the period to which the payment relates / 7 </p></li>
									</ol>
									<div class="clearfix" style="height: 10px;"></div>
									<p class="px-12-font text-justify" style="line-height: 12px;">The refund will be paid to you within 2 weeks of the day on which the course ceased being provided. Alternatively, student may be offered enrolment in an alternative course by the Institute at no extra cost. Students have the right to choose whether they would prefer a refund of course fees, or to accept a place at another institute. If student chooses placement in another course, PCA will ask the student to sign a document to indicate the acceptance of the placement. If the Institute is unable to provide a refund or place student in an alternative course, the TPS will be responsible for providing refunds or providing assistance to locate an alternative. However, students are primarily responsible for finding another institute which will accept them into an alternative course.</p>
									<div class="clearfix" style="height: 5px;"></div>
									<p class="px-12-font text-justify" style="line-height: 12px;">In these cases, there is no need for student to make a refund application.</p>
								</td>
							</tr>
							<tr>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">If PCA is required to cancel a course before it commences due to insufficient numbers or for other unforeseen circumstances</p></td>
							</tr>
							<tr>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">Course ceases to be provided to the student at the location after the course starts but before it is completed; and the student has not withdrawn from the course before the default day.</p></td>
								<td rowspan="2"><p class="px-12-font text-justify" style="line-height: 12px;"><span class="proximanova-bold">Refund</span> of unused tuition fees. Pre-paid fees may be transferred to an alternative enrolment where the student agrees.</p></td>
							</tr>
							<tr>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">The course is not provided in full to the student because a sanction has been imposed on the registered provider or any other reason.</p></td>
							</tr>
							<tr>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">The course is not provided fully to the student because PCA has a sanction imposed by a government regulator</p></td>
								<td colspan="2"><p class="px-12-font text-justify" style="line-height: 12px;"><span class="proximanova-bold">Refund</span> of unused tuition fees</p></td>
							</tr>
							<tr>
								<td colspan="3" class="px-12-font proximanova-bold primary-bg-color white-font-color">Student Default</td>
							</tr>
							<tr>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">If a student cannot commence the course because of illness, disability or where there is death of a close family member of the student (parent, sibling, spouse or child).</p></td>
								<td colspan="2"><p class="px-12-font text-justify" style="line-height: 12px;"><span class="proximanova-bold">Full refund</span> of course fees (this excludes the Application fee which is non-refundable).</p></td>
							</tr>
							<tr>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">At the discretion of PCA’s CEO or approved representative, when other special or extenuating circumstances have prevented the student from commencing their studies including political, civil or natural events.</p></td>
								<td colspan="2"><p class="px-12-font text-justify" style="line-height: 12px;"><span class="proximanova-bold">Full refund</span> of course fees (this excludes the Application fee which is non-refundable).</p></td>
							</tr>
							<tr>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">Visa refused prior to course commencement </p></td>
								<td colspan="2" rowspan="2" style="padding: 2px 5px; !important">
									<p class="px-12-font text-justify" style="line-height: 12px;">The amount of unspent pre-paid fees that PCA must refund the student for the purpose of subsection 47E (2) of the ESOS Act (section 9 of Education Services for Overseas Students (Calculation of Refund) Specification 2014) is the total amount of the pre-paid fees PCA received for the course in respect of the student less the following amount:the lesser of:</p>
									<div class="clearfix" style="height: 5px;"></div>
									<p class="px-12-font text-justify" style="line-height: 12px;">(a) 5% of the total amount of pre-paid fees that PCA received in respect of the student for the course before the default day; or</p>
									<div class="clearfix" style="height: 5px;"></div>
									<p class="px-12-font text-justify" style="line-height: 12px;">(b) the sum of $500.</p>
								</td>
							</tr>
							<tr>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">Withdrawal prior to the agreed start date</p></td>
							</tr>
						</table>
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No. 45633 | CRICOS Code 03871F</p>
						<p style="margin-bottom: 0px;"> Page 11 of 16</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 11 of 16 -->
<!-- Page 12 of 16 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-offer-letter-and-enrolment-acceptance-agreement/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Offer Letter and Enrolment Acceptance Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content">

						<table width="100%" class="table-bordered table-padded" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="40%" class="px-12-font proximanova-bold primary-bg-color white-font-color">Description</td>
								<td width="60%" class="px-12-font proximanova-bold primary-bg-color white-font-color">Refund status</td>
							</tr>
							<tr>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">If a student fails to commence a course after the start of the Course at location, has not previously withdrawn from the course, and the reason is not the visa refusal.</p></td>
								<td><p class="px-12-font text-justify" style="line-height: 12px;"><span class="proximanova-bold">No refund</span> – once the study starts, the fee is not refundable.</p></td>
							</tr>
							<tr>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">Withdrawal from the course at location after the agreed start date.</p></td>
								<td><p class="px-12-font text-justify" style="line-height: 12px;"><span class="proximanova-bold display-block">No refund</span> This includes all course fees, Application fees, cost of learning and assessment resources, OSHC, airport pick up (where applicable) and material fee (where applicable)</p></td>
							</tr>
							<tr>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">Student abandons the course without notice</p></td>
								<td><p class="px-12-font text-justify" style="line-height: 12px;"><span class="proximanova-bold">No refund</span> and the balance of all outstanding fees for the course to be invoiced to the student</p></td>
							</tr>
							<tr>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">Student Visa or Visa extension is refused after course is commenced</p></td>
								<td rowspan="2">
									<p class="px-12-font text-justify" style="line-height: 12px;">The refund amount = weekly tuition fee x the number of weeks in the default period</p>
									<div class="clearfix" style="height: 15px;"></div>
									<ol  class="list no-margin" type="a" style="margin-bottom: -15px;">
										<li><p class="px-12-font text-justify" style="line-height: 12px; margin-top: -2px;">The weekly tuition fee = total tuition fee for the course / number of calendar days in the course x 7. This amount is rounded up to the nearest whole dollar.</p></li>
										<li><p class="px-12-font text-justify" style="line-height: 12px; margin-top: -2px;">The number of weeks in the default period = number of calendar days from the default day to the end of the period to which the payment relates / 7 </p></li>
									</ol>
									<div class="clearfix" style="height: 15px;"></div>
									<p class="px-12-font text-justify" style="line-height: 12px;">Tuition fee does not include any non-tuition fee that might have been paid by the student. Non-tuition fees will not be refunded.</p>
								</td>
							</tr>
							<tr>
								<td><p class="px-12-font text-justify" style="line-height: 12px;">SStudent whose visa has been refused has withdrawn from the course after it commenced, or has failed to pay an amount he or she was liable to pay the provider in order to undertake the course.</p></td>
							</tr>
							<tr>
								<td>
									<p class="px-12-font text-justify" style="line-height: 12px;">There is a student default due to any of the following reasons:</p>
									<div class="clearfix" style="height: 10px;"></div>
									<ul class="list no-margin" style="padding-left: 15px;">
										<li><p class="px-12-font text-justify" style="line-height: 12px;">The student breached a condition of his or her student visa;</p></li>
										<li><p class="px-12-font text-justify" style="line-height: 12px;">Misbehaviour by the student;</p></li>
										<li><p class="px-12-font text-justify" style="line-height: 12px;">Failure to comply with PCA policies</p></li>
									</ul>
								</td>
								<td><p class="px-12-font text-justify" style="line-height: 12px;"><span class="proximanova-bold">No refund</span></p></td>
							</tr>
						</table>
						<div class="clearfix" style="height: 15px;"></div>
						<ul class="list no-margin" style="padding-left: 15px;">
							<li><p class="px-12-font text-justify" style="line-height: 12px;">At the time of enrolment any Credit Transfer (CT) / Recognition of Prior Learning (RPL) will be discussed and granted after the student provides sufficient evidence. If the CT allows shortening of the duration of the course, pro-rata fees will be worked out and offered to the student. Once the student accepts this offer, there will be no further reduction of the fee.</p></li>
							<li><p class="px-12-font text-justify" style="line-height: 12px;">Fees not listed in this refund section are not refundable. Prior to a student enrolment, fees may be altered without notice. Once a student has completed enrolment, fees will not be subject to change for the normal duration of the course. If a course length is extended by the student then any fee increases will be required to be paid for the extended component of the course.</p></li>
							<li><p class="px-12-font text-justify" style="line-height: 12px;">If a student withdraws after any number of deferments, the date on the original eCoE will be considered for the purpose of determining the date of commencement of semester / study period / course in relation to the institute refund policy and other related policies.</p></li>
						</ul>
						<div class="clearfix" style="height: 15px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">COMPLAINTS AND APPEALS</span></p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">If students have concerns with any aspect of their training, they have the right to access the complaints and appeals process. The students should bring their concern/s to the attention of their trainer or any of our Student Support team members. They will endeavour to resolve the matter in an informal manner to the student’s satisfaction. If  the  outcome  of  the  informal complaint does not meet the student’s expectations, they may lodge a formal complaint by completing the formal complaints and appeals form which can be requested from the Student Support team. This will be dealt with in accordance with the complaints and appeals policy and procedures, which can be viewed and downloaded from our website. A hard copy can be requested from our Student Support team if required.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">Students have the right to appeal the outcome of a complaint or the outcome of assessment decisions if they are dissatisfied and feel they have been dealt with unjustly. Appeals can be made by  completing  the Complaints and Appeals Form. The appeal will be dealt with in accordance with the Complaints and Appeals Policy and Procedure. If submitting  a formal Complaint or Appeal Form, students must provide reasons and supporting evidence justifying their grounds for the complaint or appeal.</p>

					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No. 45633 | CRICOS Code 03871F</p>
						<p style="margin-bottom: 0px;"> Page 12 of 16</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 12 of 16 -->
<!-- Page 13 of 16 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-offer-letter-and-enrolment-acceptance-agreement/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Offer Letter and Enrolment Acceptance Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content">

						<p class="px-14-font text-justify" style="line-height: 14px;">If the student is still dissatisfied by the outcome of an internal appeal they have the right to the external complaints or appeals process. Our Student Support team may refer the student to an external welfare service. The student will be informed whether or not using an external welfare service will attract costs to the student. An external party may review the case to identify if the College has followed the correct process as stated in the Complaints and Appeals Policy and Procedure in managing the complaint or appeal. The external party does not review the outcome of the complaint or appeal.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">CHANGE OF ADDRESS:</span> Should a student change address during their course of study they must notify the College within 5 working days from the date they change their address. Students are required to provide the College with details of their current address for the whole period of their enrolment.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">CHANGE OF PERSONAL DETAILS/CIRCUMSTANCES:</span> During the student’s course of studies any change of personal details and/or circumstances must be informed to PCA in order to update the student’s records. Students must provide PCA with the updated details of the person who can be contacted in case of an emergency, while in Australia and studying at PCA.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">ACCESS TO RECORDS:</span> Students are entitled to request and be provided with a formal Statement of Attainment on withdrawal, cancellation or transfer, prior to completing the qualification, provided the student has paid in full for the tuition related to the units of competency to be shown on the Statement of Attainment and has got no dues. This is free for cost to the student. Students are also entitled to access their student file free of cost upon request.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">PCA will retain records of all written agreements, as well as receipts of payment made under the written agreement, for at least two years after the overseas student ceases to be an accepted student. This is consistent with the record keeping requirements under section 21 of the ESOS Act and 3.04 of the Education Services for Overseas Students Regulations 2001.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">INTERNATIONAL STUDENT ENROLMENT FORM:</span> Application forms may be obtained from website or from reception. (Phoenix College of Australia, 2/11 Cordelia Street, South Brisbane 4101 or e-mail at phoenixcollegeaustralia@gmail.com. The Administration officer/student support officer will arrange an appointment within 5 working days and ask the student to bring confirmation of identity.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">COMPLETION WITHIN EXPECTED DURATION:</span> The   student’s   course progress is monitored to  ensure  they  complete  the  course  within  the duration specified in their CoE. PCA only enables a student to extend the duration of study through by issuing a new CoE in consideration of limited circumstances.  Without  such  limited  circumstances,  the  expected  duration of study must not exceed the expected duration of study specified in the student’s  eCoE.  Please  refer  to  PCA’s  Monitoring  Course  Progress  and Intervention  Strategy  for  International  students  policy  and  procedure  on PCA’s website.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">AMENDING/CHANGING YOUR ENROLMENT:</span> After    completing    the enrolment, a student might have the need to change his/her enrolment due to   ‘change   of   mind’   or   for   other   reasons.   International   students   are precluded from suspending studies due to student visa conditions. Students must contact the Student Support team to discuss options. They will be able to advise students whether or not they are permitted to withdraw from their current course and switch to another course and how it will affect their visa, as this will affect the normal course duration and may require the student to obtain a new student visa to cover the remaining period before the current visa expires. The student’s OSHC may need to be extended as well to cover the extended course duration and new student visa.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">DEFER, SUSPEND OR CANCEL YOUR ENROLMENT:</span> If students would like to apply to defer, suspend or cancel their enrolment by submitting an application to the College. Application forms may  be  obtained  and submitted to the reception (2/11 Cordelia Street, South Brisbane 4101 or e-mail at phoenixcollegeaustralia@gmail.com. The College may also initiate the deferral, suspension or cancellation a student’s enrolment.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">In consideration of a student’s compassionate or compelling circumstances, PCA may defer, suspend or cancel a student’s enrolment. Compassionate or compelling circumstances are  generally  those  beyond the control of the student and which have an impact upon  the  student’s course progress or wellbeing. When determining whether compassionate or compelling circumstances exist, the College considers documentary evidence provided to support the claim, and stores copies of these documents in the student’s file.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">Students may also have their enrolment suspended or cancelled by the College due to non-payment of fees, unsatisfactory course progress, misbehaviour or breaching the College Code of Conduct. The student will be advised that his/her student visa maybe affected if his/her enrolment is deferred, suspended or cancelled. Please refer to DEFERMENT, SUSPENSION AND CANCELLATION OF ENROLMENT POLICY AND PROCEDURE.</p>
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No. 45633 | CRICOS Code 03871F</p>
						<p style="margin-bottom: 0px;"> Page 13 of 16</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 13 of 16 -->
<!-- Page 14 of 16 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-offer-letter-and-enrolment-acceptance-agreement/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Offer Letter and Enrolment Acceptance Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content">

						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">TRANSFER BETWEEN PROVIDERS:</span> We   acknowledge   our   international students as consumers and afford them the right to transfer under certain circumstances     (unforeseen,     exceptional     circumstances     that     create significant personal hardship). As a part of the enrolment process and prior to  enrolment,  students  are  informed  that  there  are  restrictions  to  be employed   from   enrolling   transferring   students   prior   to   completing   six months of his or her principal course of study.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">TRANSFER TO ANOTHER PROVIDER:</span> We are restricted from granting a student’s request to transfer to another provider prior to the completion of six months of their principal course of study except when certain circumstances occur. The student’s request will be granted where the transfer will not be to the detriment of the student. If approved and once all conditions are met, a release letter will be issued to the student. Students must contact the Student Support team for assistance.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">TRANSFER FROM ANOTHER PROVIDER.</span> We are responsible for assessing student’s request to transfer from another training provider within the restricted period (completion of six months of the principal course). For a request to transfer from another provider be considered, a release letter will be required.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">After the first six months of the principal course, no restrictions apply, provided the student has paid all outstanding fees. All applications are processed in compliance with the College Transfer between Providers policy and procedure. Contact one of our friendly team members.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">TRANSFERS FROM COURSE TO COURSE (WITHIN PCA):</span> PCA only offers one course ({{$offerData['course_details'][0]['course']['code']}} : {{$offerData['course_details'][0]['course']['name']}}) to its international students.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">ESOS FRAMEWORK</span> – STUDENT’S RIGHTS AND RESPONSIBILITIES.  The Australian Government wants overseas students in Australia to have a safe, enjoyable  and  rewarding  place  to  study.  Australia’s  laws  promote  quality education and consumer protection for overseas students. These laws are known as the ESOS framework and they include the Education Services for Overseas (ESOS) Act 2000 and the National Code 2018. <a href="https://www.legislation.gov.au/Details/F2017L00403">https://www.legislation.gov.au/Details/F2017L00403</a>.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">Further information on the ESOS Framework is provided in the following link: <a href="https://internationaleducation.gov.au/Regulatory-Information/Education-Services-for-Overseas-Students-ESOS-Legislative-Framework/ESOS-Regulations/Pages/default.aspx">https://internationaleducation.gov.au/Regulatory-Information/Education-Services-for-Overseas-Students-ESOS-Legislative-Framework/ESOS-Regulations/Pages/default.aspx</a>.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">PRIVACY.</span> Phoenix College of Australia  may  require  the  collection  of  personal information from applicants to enable it to provide its training products and services. PCA takes its obligations under the Privacy Act seriously, and as such,  will  take  all  reasonable  steps  in  order  to  comply  with  the  Act  and protect the privacy or personal information that it holds. This Policy supports PCA’s  commitment  to  the  protection  and  non-disclosure  of  personal  and sensitive  information  of  its  students  and  provides  staff  with  a  better understanding  of  the  type  of  personal  information  that  PCA  holds  on individuals.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">ASSESSMENT.</span> PCA  employs  a  competency-based  training.  Students  are required   to   consistently   and   over   time   demonstrate   the   skills   and knowledge  that  enable  completion  of  all  assessment  tasks  based  on  the required  assessment  methods  and  variety  of  situations.  On  successful completion   of   assessment   tasks   for   each   unit,   a   student   is   deemed ‘Competent” (C) or if not, ‘Not Yet Competent’ (NYC). If the student is not satisfied   of   the   assessment   outcomes,   the   student   may   access   the Complaint   and   Appeals   process.   Please   refer   to   the   Complaints   and Appeals Policy and Procedures. The Student Support team will advise the student on  the effect  of these  circumstances of his/her  student visa.  The availability of the Complaints and Appeals processes to students does not remove  their  right  to  take  action  under  Australia’s  consumer  protection laws.  The  student’s  enrolment  will  be  maintained  while  a  complaints  and appeals process is ongoing.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">RE-ASSESSMENTS:</span>Once an assessment task has been officially submitted and the assessment is deemed unsatisfactory, the learner will be provided feedback by the Assessor and provided an opportunity to resubmit by an agreed due date at no cost with in the COE duration.  If the student does not resubmit the assessment on the agreed due date, student will need to pay the cost for the reassessment. Fees for the reassessment for each unit is $250. </p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">If the student does not submit the assessment on due date and hence deemed NYC student will need to pay the reassessment fees of $250.00. </p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">Only the CEO has authority to waive off or discount the reassessment fees. Student can ask the staff to request for waiver of the fees or discount. </p>
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No. 45633 | CRICOS Code 03871F</p>
						<p style="margin-bottom: 0px;"> Page 14 of 16</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 14 of 16 -->
<!-- Page 15 of 16 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-offer-letter-and-enrolment-acceptance-agreement/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Offer Letter and Enrolment Acceptance Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content">

						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">COURSE PROGRESS:</span> Phoenix College of Australia will monitor students course progress and provide assistance if the student is experiencing difficulties and not progressing through their course as per the course schedule. The PCA delegate will arrange a time to meet with students who are not progressing satisfactorily and ascertain the reasons for this. Access to appropriate supports services will then be provided to assist the student in successfully completing their course within the scheduled duration. Phoenix College of Australia may refer students to external sources if they are unable to sufficiently provide support for students learning needs. Phoenix College of Australia may refer students to external organisations if they are experiencing personal/welfare issues that are affecting their course progress. Phoenix College of Australia takes all reasonable and feasible steps to assist students so they can successfully complete their course within the course schedule. It is a requirement of the National Code of Practice 2018 Standard 8 that the College reports students who do not achieve satisfactory course progress over study period. This can lead to your student visa may be cancelled. Please contact the college at phoenixcollegeaustralia@gmail.com or visit the website to see Student Support Policy and Procedure for further details on how your course progress may impact your student visa. Please refer to PCA’s Monitoring Course Progress and Intervention Strategy for International students policy and procedure on PCA’s website.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">Note: Please be advised that student can find all the detailed policies and procedures from the reception or from the website.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">OVERSEAS STUDENT HEALTH COVER (OSHC)</span></p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">It is a requirement of the Department of Home Affairs (DHA) that all students studying on a student visa are covered by OSHC. Students accompanied by family must pay the OSHC family fee. Students can contact student support officers or PCA for any assistance in relation to OSHC. Information about OSHC will also be provided on the day of orientation and is also available on the PCA website.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">Declaration:</span></p>
						<p class="px-12-font text-justify display-inlineblock">I,</p> <div class="textbox display-inlineblock line-textbox" style="width: 300px; margin-top: 3px;"> {{ $offerData['student']['party']['name'] }} </div>
						<p class="px-12-font text-justify" style="text-indent: 330px; margin-top: -25px;">agree that by signing this declaration, I am accepting an offer of a place in the course as >outlined within this Letter of Offer.</p>
						<div class="clearfix" style="height: 15px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">I further acknowledge that:</p>
						<div class="clearfix" style="height: 5px;"></div>
						<ul class="list no-margin" style="padding-left: 12px;">
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">The information provided to Phoenix College of Australia in application for study is to best of my knowledge true, correct and complete at the time of my enrolment/application.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I acknowledge that providing any false information and/or failing to disclose any information relevant to my application for enrolment and/or failure to complete an international enrolment application form may result in the delay in processing my application.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I  have received the  PCA’s  Student  Handbook  that  contains  pre- enrolment information including the refund policy, information on credit transfer, recognition of prior learning (RPL), living in Australia and student work rights, among others and all other PCA’s policies and procedures.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I acknowledge that I have got access to the following policies and procedures and I have been referred to them:
								<ul class="list">
									<li style="margin-bottom: -7px !important;">Complaints and Appeals Policy and Procedure</li>
									<li style="margin-bottom: -7px !important;">Critical Incident Policy and Procedure</li>
									<li style="margin-bottom: -7px !important;">Pre-Enrolment Engagement Policy and Procedures</li>
									<li style="margin-bottom: -7px !important;">Entry Requirements for International Students Policy and procedure</li>
									<li style="margin-bottom: -7px !important;">Fee Charges and Refunds Policy and Procedure</li>
									<li style="margin-bottom: -7px !important;">Deferral suspension and cancellation policy and procedure</li>
									<li style="margin-bottom: -7px !important;">Recognition of Prior Learning and Credit Transfer policy and procedure</li>
									<li style="margin-bottom: -7px !important;">Student Support Services Policy and Procedure</li>
									<li style="margin-bottom: -7px !important;">Privacy and Personal Information Policy and Procedure</li>
									<li style="margin-bottom: -7px !important;">Certification, issuing and recognition of Qualifications Policy and Procedure</li>
									<li style="margin-bottom: -7px !important;">Monitoring Course Progress and Intervention Strategy for International Students Policy and Procedure</li>
									<li style="margin-bottom: -7px !important;">Attendance Monitoring Policy and Procedure</li>
									<li style="margin-bottom: -7px !important;">Overseas Students Transfer Policy and Procedure</li>
									<li style="margin-bottom: -7px !important;">Plagiarism, Academic Misconduct and non-academic Misconduct Policy and Procedure</li>
									<li style="margin-bottom: -7px !important;">Assessment and Reassessment Policy and Procedure</li>
								</ul>
							
							</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I understand that I must maintain satisfactory course progress during my studies at Phoenix College of Australia and the impact of not doing so may have on my enrolment and student visa.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I agree to inform the College if I change my address during the period of enrolment. I also agree to maintain Overseas Student Health Cover for the period of my enrolment.</li>
						</ul>
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No. 45633 | CRICOS Code 03871F</p>
						<p style="margin-bottom: 0px;"> Page 15 of 16</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 15 of 16 -->
<!-- Page 16 of 16 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-offer-letter-and-enrolment-acceptance-agreement/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Offer Letter and Enrolment Acceptance Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<div class="content">
						<ul class="list no-margin" style="padding-left: 12px;">

							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I will be attending 20 hours per week for the duration of the course.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I agree to inform the College of any changes on my personal details and/or circumstances during my course of study.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I have disclosed to Phoenix College of Australia any special needs which may affect my learning.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I have read and understood the privacy statement above.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">This agreement, and the right to make complaints and seek appeals of decisions and action under various processes, does not affect the rights of the student to take action under the Australian Consumer Law if the Australian Consumer Law Applies.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I agree to complete my studies in accordance with Phoenix College of Australia policies and procedures and Code of Conduct when studying at Phoenix College of Australia. I understand that if I do not comply with the College policies and procedures and Code of Conduct my enrolment and student visa may be affected. All information and documents relating to my personal, academic and employment history (if any) submitted to support this application are all true, complete, valid and genuine.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I authorize PCA to seek verification of my personal, academic, professional qualifications, work experience and any information I have provided in my enrolment application.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I understand that PCA reserves the right to inform other tertiary institutions and regulatory agencies if any of the material presented to support my application is found to be false.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I understand the Privacy Statement provided in the enrolment application form. I understand that the personal and all information I have provided may be released by PCA to government agencies as required by law and that PCA may disclose to third parties for the purpose of this application.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I authorize PCA to access the Australian immigration Visa Entitlements Verification Online (VEVO) system at anytime to obtain information on my visa status.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I declare that I am a genuine temporary entrant and genuine student and that I have read and understood conditions relating to requirements outlined on <a href="www.homeaffairs.gov.au">www.homeaffairs.gov.au</a></li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I am aware of the tuition and living costs of my stay in Australia and have the financial capacity to meet such costs for the duration of my course.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I understand that if I have any school-aged children or dependent accompanying me to Australia, they must attend school and I will be required to pay a full fee if they are enrolled either in a government or non- government school.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I have read and  understood  the PCA’s  Pre-Enrolment  information,  course information, course fees and charges, entry/admission requirements and all information outlined in the International Student Handbook available in PCA’s website.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I have read and understand all relevant information and policy and procedures provided in PCA’s website along with the policy related to Refund and information on RPL and Credit Transfer.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I understand that I must maintain satisfactory course progress and the impact of not doing so may have on my enrolment and student visa.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I understand the conditions to change provider during my studies and the impact this action may have on my student visa.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I understand the conditions for deferring, suspending and cancelling my enrolment and the impact these actions may have on my student visa.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I understand that I must maintain my Overseas Health Insurance Cover during the duration of my student visa and that I must always have a valid student visa and the subclass is relevant to my principal course. I have disclosed to PCA’s my disability or special learning needs which may affect my learning.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I understand that I will present originals of all documents used to support my application at the time of enrolment.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">I agree to complete my studies in accordance with PCA’s policies and procedures and abide PCA’s Code of Conduct.</li>
							<li class="px-14-font text-justify" style="line-height: 14px; margin-bottom: -7px !important;">PCA has advised me that I am responsible for keeping copies of the agreement, any work submitted to the college, any receipts and all payment receipts.</li>
						</ul>
						<div class="clearfix" style="height: 15px;"></div>
						<p class="px-14-font text-justify proximanova-bold" style="line-height: 14px;">DECLARATION AND ACCEPTANCE BY APPLICANT:</p>
						<p class="px-12-font text-justify display-inlineblock">I,</p> <div class="textbox display-inlineblock line-textbox" style="width: 300px; margin-top: 3px;"> {{ $offerData['student']['party']['name'] }} </div>
						<p class="px-12-font text-justify" style="text-indent: 330px; margin-top: -25px;">agree that by signing this declaration, I am accepting the above payment terms and conditions as outlined within this Offer letter.</p>
						<div class="clearfix" style="height: 15px;"></div>
						<p class="px-12-font text-justify display-inlineblock">Signed by Applicant:</p>
						<div class="textbox display-inlineblock line-textbox type-signature" style="width: 250px; margin-top: 3px; margin-right: 100px;"> @if($signed)
								<div class="type-signature">
								{{ $offerData['student']['party']['name'] }}
								</div>
							@endif</div>
						<p class="px-12-font text-justify display-inlineblock">Date:</p>
						<div class="textbox display-inlineblock line-textbox" style="width: 150px; margin-top: 3px;">@if($signed)
									{{Carbon\Carbon::parse($offerData['issued_date'])->format('d/m/Y')}}
									@endif</div></div>

					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No. 45633 | CRICOS Code 03871F</p>
						<p style="margin-bottom: 0px;"> Page 16 of 16</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 16 of 16 -->
</html>