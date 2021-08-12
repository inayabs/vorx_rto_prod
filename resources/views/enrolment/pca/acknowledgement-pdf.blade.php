<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" href="{{public_path()}}/custom/pca-enrolment/pdf-style.css" rel="stylesheet" />
	<title>Acknowledgement Form</title>
</head>
<!-- Page 1 of 2 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-enrolment/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<!-- <p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">International</p> -->
								<p class="primary-font-color proximanova-bold px-24-font text-right line-height-1">Acknowledgement of receipt of Student Handbook and Pre-enrolment information</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix" style="height:20px;"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content" style="position: relative; width: 100%; height: 180px;">
						<p><span class="primary-font-color proximanova-bold">Purpose of this Document:</span> This document is to make sure that every student at Phoenix College of Australia (PCA) has received the pre-enrolment information including the student handbook before the enrollment at the institute so that an informed decision can be made by the student.   </p>
						<div class="clearfix" style="height:20px;"></div>
						<p><span class="primary-font-color proximanova-bold">Marketing and recruitment</span></p>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td width="100%" valign="middle">
												<ol>
													<li>The information I received about my course before I enrolled (signed up) was true.
														<table width="30%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px; margin-bottom: 5px;">
															<tr>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['mar1_the_info']) && $inputs['mar1_the_info'] == 'Yes' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes</label></div>
																</td>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['mar1_the_info']) && $inputs['mar1_the_info'] == 'No' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
																</td>
															</tr>
														</table>
													</li>
													<li> I knew the name of my training provider before I enrolled (signed up).
														<table width="30%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px; margin-bottom: 5px;">
															<tr>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['mar2_I_knew']) && $inputs['mar2_I_knew'] == 'Yes' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes</label></div>
																</td>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['mar2_I_knew']) && $inputs['mar2_I_knew'] == 'No' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
																</td>
															</tr>
														</table>
													</li>
													<li> Did the PCA offer you any incentives to sign up to the course?
														<table width="30%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px; margin-bottom: 5px;">
															<tr>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['mar3_did_the_pca']) && $inputs['mar3_did_the_pca'] == 'Yes' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes</label></div>
																</td>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['mar3_did_the_pca']) && $inputs['mar3_did_the_pca'] == 'No' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
																</td>
															</tr>
														</table>
													</li>
													<li> Did the PCA promise or guarantee you would get a job if you completed the course?
														<table width="30%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px; margin-bottom: 5px;">
															<tr>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['mar4_pca_promise']) && $inputs['mar4_pca_promise'] == 'Yes' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes</label></div>
																</td>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['mar4_pca_promise']) && $inputs['mar4_pca_promise'] == 'No' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
																</td>
															</tr>
														</table>
													</li>
													<li> Were you referred by an Education Agent?
														<table width="45%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px; margin-bottom: 5px;">
															<tr>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['mar5_were_you_referred']) && $inputs['mar5_were_you_referred'] == 'Yes' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes</label></div>
																</td>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['mar5_were_you_referred']) && $inputs['mar5_were_you_referred'] == 'No' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
																</td>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['mar5_were_you_referred']) && $inputs['mar5_were_you_referred'] == 'NA' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> NA</label></div>
																</td>
															</tr>
														</table>
													</li>
													<li> Were you satisfied with the knowledge and information provided by the agent?
														<table width="45%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px; margin-bottom: 5px;">
															<tr>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['mar6_were_you_satisfied']) && $inputs['mar6_were_you_satisfied'] == 'Yes' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes</label></div>
																</td>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['mar6_were_you_satisfied']) && $inputs['mar6_were_you_satisfied'] == 'No' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
																</td>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['mar6_were_you_satisfied']) && $inputs['mar6_were_you_satisfied'] == 'NA' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> NA</label></div>
																</td>
															</tr>
														</table>
													</li>
												</ol>
											</td>
										</tr>
									</table>
									<div class="clearfix" style="height:20px;"></div>
									<p><span class="primary-font-color proximanova-bold">Enrolment</span></p>
									<table width="100%" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td width="100%" valign="middle">
												<ol>
													<li> I understood the length of the course before I enrolled (signed up).
														<table width="30%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px; margin-bottom: 5px;">
															<tr>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['enrolment1_understood_length']) && $inputs['enrolment1_understood_length'] == 'Yes' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes</label></div>
																</td>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['enrolment1_understood_length']) && $inputs['enrolment1_understood_length'] == 'No' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
																</td>
															</tr>
														</table>
													</li>
													<li> PCA gave me information about how the course would meet my needs before I enrolled (signed up).
														<table width="30%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px; margin-bottom: 5px;">
															<tr>
	 															<td width="50%">
																	<div class="checkbox {{isset($inputs['enrolment2_pca_gave_info']) && $inputs['enrolment2_pca_gave_info'] == 'Yes' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes</label></div>
																</td>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['enrolment2_pca_gave_info']) && $inputs['enrolment2_pca_gave_info'] == 'No' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
																</td>
															</tr>
														</table>
													</li>
													<li> I understood the study requirements before I enrolled (signed up).
														<table width="30%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px; margin-bottom: 5px;">
															<tr>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['enrolment3_understood_requirements']) && $inputs['enrolment3_understood_requirements'] == 'Yes' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes</label></div>
																</td>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['enrolment3_understood_requirements']) && $inputs['enrolment3_understood_requirements'] == 'No' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
																</td>
															</tr>
														</table>
													</li>
													<li> My rights and responsibilities as a student were explained to me before I enrolled (signed up).
														<table width="30%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px; margin-bottom: 5px;">
															<tr>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['enrolment4_rights']) && $inputs['enrolment4_rights'] == 'Yes' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes</label></div>
																</td>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['enrolment4_rights']) && $inputs['enrolment4_rights'] == 'No' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
																</td>
															</tr>
														</table>
													</li>
													<li> The payment terms and conditions were clear to me when I enrolled (signed up).
														<table width="30%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px; margin-bottom: 5px;">
															<tr>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['enrolment4_payment_terms']) && $inputs['enrolment4_payment_terms'] == 'Yes' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes</label></div>
																</td>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['enrolment4_payment_terms']) && $inputs['enrolment4_payment_terms'] == 'No' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
																</td>
															</tr>
														</table>
													</li>
													<li> I was aware of PCA refund policy when I enrolled (signed up).
														<table width="30%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px; margin-bottom: 5px;">
															<tr>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['enrolment6_refund_policy']) && $inputs['enrolment6_refund_policy'] == 'Yes' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes</label></div>
																</td>
																<td width="50%">
																	<div class="checkbox {{isset($inputs['enrolment6_refund_policy']) && $inputs['enrolment6_refund_policy'] == 'No' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
																</td>
															</tr>
														</table>
													</li>
												</ol>
											</td>
										</tr>
									</table>
					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No: 45633 | CRICOS Code: 03871F</p>
						<p style="margin-bottom: 0px;"> Page 1 of 2</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 1 of 2 -->
<!-- Page 2 of 2 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-enrolment/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<!-- <p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">International</p> -->
								<p class="primary-font-color proximanova-bold px-24-font text-right line-height-1">Acknowledgement of receipt of Student Handbook and Pre-enrolment information</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix" style="height:20px;"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content" style="position: relative; width: 100%; height: 180px;">
						<p><span class="primary-font-color proximanova-bold">Useful Links:</span></p>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" valign="middle">
									<ul>
										<li> Study in Australia <br>
											<a href="https://www.studyinaustralia.gov.au/english/australian-education/education-system/esos-act">https://www.studyinaustralia.gov.au/english/australian-education/education-system/esos-act</a>
										</li>
										<li> National Code 2018 Factsheets <br>
											<a href="https://internationaleducation.gov.au/Regulatory-Information/Pages/National-Code-2018-Factsheets-.aspx">https://internationaleducation.gov.au/Regulatory-Information/Pages/National-Code-2018-Factsheets-.aspx</a>
										</li>
										<li> Study in Australia <br>
											<a href="https://www.studyinaustralia.gov.au/English/Live-in-Australia/Accommodation">https://www.studyinaustralia.gov.au/English/Live-in-Australia/Accommodation</a>
										</li>
										<li> Department of Home affairs <br>
											<a href="https://immi.homeaffairs.gov.au/visas/getting-a-visa/visa-listing/student-500">https://immi.homeaffairs.gov.au/visas/getting-a-visa/visa-listing/student-500</a>
										</li>
										<li> Australian Taxation Office <br>
											<a href="https://www.ato.gov.au/">https://www.ato.gov.au/</a>
										</li>
										<li> Legal Aid Queensland <br>
											<a href="https://www.legalaid.qld.gov.au/Home">https://www.legalaid.qld.gov.au/Home</a>
										</li>
										<li> Work safe Queensland <br>
											<a href="https://www.worksafe.qld.gov.au/">https://www.worksafe.qld.gov.au/</a>
										</li>
										<li> Fair work Australia <br>
											<a href="https://www.fairwork.gov.au/">https://www.fairwork.gov.au/</a>
										</li>
										<li> Ombudsman website  <br>
											<a href="https://www.ombudsman.gov.au/">https://www.ombudsman.gov.au/</a>
										</li>
										<li> National Register of VET <br>
											<a href="https://training.gov.au/Organisation/Details/45633">https://training.gov.au/Organisation/Details/45633</a>
										</li>
										<li> Commonwealth Register of Institutions and courses for overseas Students  <br>
											<a href="https://cricos.education.gov.au/Institution/InstitutionDetails.aspx?ProviderCode=03871F">https://cricos.education.gov.au/Institution/InstitutionDetails.aspx?ProviderCode=03871F</a>
										</li>
										<li> College Website <br>
											<a href="http://phoenixcollege.edu.au/courses/certificate-ii-in-security-operations/">http://phoenixcollege.edu.au/courses/certificate-ii-in-security-operations/</a>
										</li>
										<li> USI Factsheet <br>
											<a href="https://www.usi.gov.au/documents/factsheet-student-information-rtos">https://www.usi.gov.au/documents/factsheet-student-information-rtos</a>
										</li>
									</ul>
								</td>
							</tr>
						</table>
						<p><span class="primary-font-color proximanova-bold">Declaration:</span></p>
						<p>I herewith confirm that I have received the Student Handbook and Pre-enrolment information prior to enrolment and understand the contents. I agree with the information provided by the PCA.</p>
						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" valign="top" style="padding: 20px 0;">
									<table width="100%" class="form-table">
										<tr>
											<td width="100%">
												<p class="px-12-font display-inlineblock"><span class="proximanova-bold">Name</span></p>
												<div class="textbox display-inlineblock" style="width: 655px; margin-left: 5px;">{{isset($inputs['student_name']) ? $inputs['student_name'] : ''}}</div>
											</td>
										</tr>
										<tr>
											<td width="100%">
												<p class="px-12-font display-inlineblock"><span class="proximanova-bold">PCA ID</span></p>
												<div class="textbox display-inlineblock" style="width: 650px; margin-left: 5px; margin-right: 10px;">{{isset($inputs['student_id']) ? $inputs['student_id'] : ''}}</div>
											</td>
										</tr>
										<tr>
											<td width="100%">
												<p class="px-12-font display-inlineblock"><span class="proximanova-bold">Signature</span></p>
												<div class="textbox display-inlineblock" style="width: 380px; margin-left: 5px; margin-right: 10px;"><div class="type-signature">{{isset($signature) ? $signature : ''}}</div></div>
												<p class="px-12-font display-inlineblock"><span class="proximanova-bold">Date</span></p>
												{{-- <div class="textbox display-inlineblock" style="width: 195px; margin-left: 5px;">{{ \Carbon\Carbon::parse($inputs['declaration_date'])->timezone('Australia/Melbourne')->format('d / m / Y') }}</div> --}}
												<div class="textbox display-inlineblock" style="width: 195px; margin-left: 5px;">{{ \Carbon\Carbon::parse($inputs['declaration_date'])->format('d / m / Y') }}</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No: 45633 | CRICOS Code: 03871F</p>
						<p style="margin-bottom: 0px;"> Page 2 of 2</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 2 of 2 -->
</html>