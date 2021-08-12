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
								<td>{{  Carbon\Carbon::parse($offerData['student']['party']['person']['date_of_birth'])->format('d/m/Y')}}</td>
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
						<p class="text-justify px-14-font" style="line-height: 14px;">Thank you for your application to study at {{ $org->training_organisation_name }}. Further to an assessment of your application, we are pleased to offer you a place as an international student in the course/s as outlined below.</p>
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
								<td width="50%">{{$offerData['course_details'][0]['week_duration']}}</td>
							</tr>
							<tr>
								<td class="px-14-font proximanova-bold">Application/enrolment Fees</td>
								{{-- <td>AUD 250.00 (Non-refundable)</td> --}}
								<td width="50%">AUD {{ number_format($offerData['fees']['application_fee'],2)}}  (Non-refundable)</td>
							</tr>
							<tr>
								<td class="px-14-font proximanova-bold">Tuition Fees</td>
								@if($offerData['fees']['discounted_amount']!= '0.00')
								<td width="50%">AUD {{number_format($offerData['fees']['course_tuition_fee'] - (float) $offerData['fees']['discounted_amount'],2)}}</td>

								@else	
								<td width="50%">AUD {{number_format($offerData['fees']['course_tuition_fee'],2)}}</td>
								@endif
							</tr>
							<tr>
								<td class="px-14-font proximanova-bold">Material Fees</td>
								<td width="50%">AUD {{number_format($offerData['fees']['materials_fee'],2)}}</td>
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
											$total = ($offerData['fees']['application_fee'] + $offerData['fees']['course_tuition_fee'] + $offerData['fees']['materials_fee'])
											- (float) $offerData['fees']['discounted_amount'];

										}else{
										$total = ($offerData['fees']['application_fee'] + $offerData['fees']['course_tuition_fee'] + $offerData['fees']['materials_fee']);
										}
									@endphp
									AUD {{ number_format($total,2)}}
								</td>
							</tr>
							<tr>
								<td class="px-14-font proximanova-bold">Course Start Date</td>
							<td>{{ Carbon\Carbon::parse($offerData['course_details'][0]['course_start_date'])->format('d/m/Y') }}</td>
							</tr>
							<tr>
								<td class="px-14-font proximanova-bold">Course End Date</td>
								<td>{{ Carbon\Carbon::parse($offerData['course_details'][0]['course_end_date'])->format('d/m/Y') }}</td>
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
							{{-- <tr>
								<td width="50%" class="px-14-font proximanova-bold">Application Fees</td>
								<td width="50%">AUD 250.00</td>
							</tr>
							<tr>
								<td class="px-14-font proximanova-bold">Material Fees</td>
								<td>AUD 250.00</td>
							</tr> --}}
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
						<p style="margin-bottom: 2px;">V1.0 | RTO No. {{ $org->training_organisation_id }} | CRICOS Code {{ $org->cricos_code }}</p>
						<p style="margin-bottom: 0px;"> Page 1 of 4</p>
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
										<li><p class="px-12-font">Initial Payment is the amount required for the issuance of Confirmation of Enrolment (CoE) which is payable in advance or as directed by the {{ $org->student_id_prefix }} and constitute tuition and non-tuition fees towards your course.</p></li>
										<li><p class="px-12-font">All fees are in Australian dollars and are subject to change without notice.</p></li>
										<li><p class="px-12-font">The balance due amount may be paid according to agreed payment plan, which can be found below in this document.</p></li>
										<li><p class="px-12-font">Late payment of fees may result in:</p></li>
										<li><p class="px-12-font">The possibility of {{ $org->student_id_prefix }} reporting you to the Department of Home Affairs (DHA) and cancelling your enrolment. Please keep {{ $org->student_id_prefix }} informed if payment is not going to be on time or you want extension.</p></li>
									</ul>
								</td>
							</tr>
						</table>

						<div class="clearfix" style="height: 20px;"></div>

						<p class="proximanova-bold">CONDITIONS</p>
						<div class="clearfix" style="height: 10px;"></div>
						<ul class="list no-margin text-justify">
							<li><p class="px-12-font">Please be advised that issuance of this offer letter does not guarantee the issuance of the eCOE until all the eligibility requirements are met.</p></li>
							<li><p class="px-12-font">PCA requires ACSF level 3 in LLN test or IELTS band score of 5.5 or equivalent in line with Department of Home Affairs regulations. Please speak to the {{ $org->student_id_prefix }}’s one of friendly team member for further information.</p></li>
							
							<li><p class="px-12-font">IELTS band 5.5 or equivalent. Candidate does not need to provide evidence of an English test score with application if one of the following applies (exemption): Candidate is a citizen and holds a passport from UK, USA, Canada, NZ or Republic of Ireland Candidate is enrolled in a principal course of study that is a registered school course, a standalone English Language Intensive Course for Overseas Students (ELICOS), a course registered to be delivered in a language other than English, or a registered post-graduate research course</p></li>
							<li><p class="px-12-font">Candidate has completed at least 5 years’ study in English in one or more of the following countries: Australia, UK, in the 2 years before applying for the student visa, candidate completed, in Australia and in the English language, either the Senior Secondary Certificate of Education or a substantial component of a course leading to a qualification from the Australian Qualifications Framework at the Certificate IV or higher level, while you held a student visa. In case student has not got valid IELTS test result and does not meet any exemption as listed above, the student will need to undertake LLN test conducted by {{ $org->student_id_prefix }} under supervision. ACSF level 3 is required to gain entry into the qualification. LLN test will be undertaken during the enrolment process before issuance of the confirmation of enrolment (COE). If learners do not meet English language / LLN requirements, learners will be asked to take further Language, literacy and numeracy training e.g. English Language Intensive Course for Overseas Learners (ELICOS) programs with institute at additional cost. {{ $org->student_id_prefix }} will not charge any referral fees.</p></li>
							

							<li><p class="px-12-font">Satisfactory completion of studies in applicant’s home country equivalent to an Australian Year 12 qualification is required for entry into this course.</p></li>
							<li><p class="px-12-font">All students must be of the age 18 years or over at the time of the scheduled course commencement.</p></li>
							<li><p class="px-12-font">You will be required to undertake the Pre-training review on the day you sign this acceptance agreement as part of your enrolment process. Please make yourself familiar with {{ $org->student_id_prefix }}’s policies and procedures, which can be found in {{ $org->student_id_prefix }}’s website.</p></li>
							<li><p class="px-12-font">Offer letter is subject to eligibility assessment by the international admission department/ {{ $org->student_id_prefix }} delegate/Student Support Officer of {{ $org->training_organisation_name }}.</p></li>
							<li><p class="px-12-font">This document is to be accepted/signed by international students at the same time or prior to payment of fees.</p></li>
							<li><p class="px-12-font">This agreement, and the right to make complaints and seek appeals of decisions and action under various processes, does not affect the rights of the student to take action under the Australian Consumer Law if the Australian Consumer Law Applies.   </p></li>
						</ul>
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No. {{ $org->training_organisation_id }} | CRICOS Code {{ $org->cricos_code }}</p>
						<p style="margin-bottom: 0px;"> Page 2 of 4</p>
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
						<p class="px-14-font text-justify" style="line-height: 14px;">This offer is only valid for 30 days from the date of issuance. A place in  this course(s) is not confirmed until {{ $org->student_id_prefix }} receives the requested payment, the signed Offer Letter and Enrolment Acceptance Agreement (as attached) and issues you with a Confirmation of Enrolment (COE).</p>
						<div class="clearfix" style="height: 20px;"></div>
						<p class="proximanova-bold px-14-font">PAYMENT REQUIRED FOR ACCEPTANCE</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">You can choose any from the following methods to make your payment to {{ $org->training_organisation_name }}.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<ol class="list">
							<li>
								<p class="px-14-font">Direct Deposit</p>
								<div class="clearfix" style="height: 5px;"></div>
								<table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="50%" class="px-14-font proximanova-bold">Name of Account</td>
										<td width="50%">{{ $org->org_bank->account_name }}</td>
									</tr>
									<tr>
										<td class="px-14-font proximanova-bold">Bank name</td>
										<td>{{ $org->org_bank->bank_name }}</td>
									</tr>
									<tr>
										<td class="px-14-font proximanova-bold">BSB</td>
										<td>{{ $org->org_bank->bsb }}</td>
									</tr>
									<tr>
										<td class="px-14-font proximanova-bold">Account Number</td>
										<td>{{ $org->org_bank->account_number }}</td>
									</tr>
									@if(env('app_name') == 'PCA')
									<tr>
										<td class="px-14-font proximanova-bold">Swift code</td>
										<td>WPACAU2S</td>
									</tr>
									@endif
								</table>
							</li>
							<li>
								<p class="px-14-font">Bank Transfer: Bank Details as above</p>
								<p class="px-14-font"><span class="proximanova-bold">Note:</span> For direct deposit of bank transfer, please provide your name (Student ID) as reference in order to easily track your payment.</p>
							</li>
							<li><p class="px-14-font">Credit Card</p></li>
							<li><p class="px-14-font">Bank Draft: Bank draft should be made payable to {{ $org->training_organisation_name }}.</p></li>
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
						<p class="px-14-font text-justify" style="line-height: 14px;">Please ensure that you have read and understand the {{ $org->student_id_prefix }} Fee Charges and refund policy and Procedure. In order to accept this offer, please sign the declaration below on both copies sent to you and return one copy to the College. Please retain the second copy for your records. We look forward to welcoming you to {{ $org->training_organisation_name }}, where you will be provided with high quality training and support, along with excellent career opportunities. Should you have any queries please do not hesitate to contact our Administration office.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="proximanova-bold px-14-font">COURSE DELIVERY</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">{{ $org->training_organisation_name }} delivers {{ $offerData['course_details'][0]['course']['code'] }} {{ $offerData['course_details'][0]['course']['name'] }} for {{ $offerData['course_details'][0]['week_duration'] }} weeks of duration. {{ $org->student_id_prefix }} has determined that {{ $offerData['course_details'][0]['course']['code'] }} consists of one study period of 3 weeks.  The students are required to attend all the classes and complete the assessment according to their schedule. The course will be delivered {{ $offerData['course_details'][0]['course_matrix']['training_hours_weekly'] }} hours per week in a classroom and the mode of delivery will be face to face. The students are required to attend classes according to time table. Failure to attend the class may result in unsatisfactory course progress, which will ultimately affect your date of completion.  {{ $org->student_id_prefix }} will be contacting you to inform you about the date of orientation and location. Every student needs to attend the orientation program; failure to attend this program may result in cancellation of the enrolment at {{ $org->student_id_prefix }}. 
                        <br>
                        Prior to signing and accepting this enrolment acceptance, please read and ensure you understand the Terms and Conditions of Enrolment. You must also read the Student Handbook, Policies and Procedures on {{ $org->student_id_prefix }}‘s website carefully. Please contact our office if you prefer that we send you these documents via email or post.
                        </p>

					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No. {{ $org->training_organisation_id }} | CRICOS Code {{ $org->cricos_code }}</p>
						<p style="margin-bottom: 0px;"> Page 3 of 4</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 3 of 16 -->
<!-- Page 4 of 16 -->
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
						<p class="px-14-font text-justify" style="line-height: 14px;">Students are also required to adhere to the Code of Conduct. If a student is found to have acted in a way that {{ $org->training_organisation_name }} ({{ $org->student_id_prefix }}) deems to be misconduct, it may impair their successful completion of the course.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">As outlined in the Code of Conduct, students are expected to approach training and assessment activities in an ethical manner. At {{ $org->student_id_prefix }}, our students strive to conduct themselves with integrity and do not engage in plagiarism or cheating. Confusion in relation to the definitions of both plagiarism and cheating can often occur and have been detailed below to avoid this occurrence and to eliminate their happening due to claims of confusion.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">CHEATING:</span> Cheating is the use of any means to gain an unfair advantage during the assessment process. Cheating may be (but not limited too) copying a friends answers, using mobile phones or other electronic devises during closed book assessments, bringing in and referring to pre prepared written answers in a closed book assessment and referring to texts during closed book assessments amongst others. Cheating in any form during assessments will result in the student’s assessment submission being invalidated.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;"><span class="proximanova-bold">PLAGIARISM:</span> Plagiarism is the wrongful close imitation, or copying and publication of another person’s language, thoughts, ideas, or expressions, and the representation of them as one's own work. This includes copying all or pieces of another student work and representing it as your own. Plagiarism will also lead to the student’s submission of the applicable work being invalidated. If students are including other people’s work in submissions e.g. passages from books or websites, then reference should be made to the source. For further information on what constitutes plagiarism please refer to: <a href="http://www.plagiarism.org/">http://www.plagiarism.org/</a> and refer to the Plagiarism policy of PCA. Submitting plagiarised work during assessments will result in the student’s assessment submission being invalidated.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify" style="line-height: 14px;">Cheating and or plagiarism during assessments will be treated as a breach of the Code of Conduct and is deemed to be ‘Academic Misconduct’ and may lead to the student being removed from the course. No refund is applicable to the student in such circumstances</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-14-font text-justify proximanova-bold" style="line-height: 14px;">AGREED PAYMENT PLAN OF COURSE FEES {{ $offerData['course_details'][0]['course']['code']  }} - {{ $offerData['course_details'][0]['course']['name'] }}</p>
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
								$nonTuition  = $offerData['fees']['materials_fee'] + $offerData['fees']['application_fee'];
								$tuition = $offerData['fees']['course_tuition_fee'] - $offerData['fees']['discounted_amount'];
								$balance = $initial - $nonTuition;
								$totalTuition = $offerData['fees']['course_tuition_fee'] / $offerData['course_details'][0]['week_duration'];
								$week = round($balance / $totalTuition);
								$balance = $tuition - $balance;
								$bduration = $offerData['course_details'][0]['week_duration'];
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
						<p style="margin-bottom: 2px;">V1.0 | RTO No. {{ $org->training_organisation_id }} | CRICOS Code {{ $org->cricos_code }}</p>
						<p style="margin-bottom: 0px;"> Page 4 of 4</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>