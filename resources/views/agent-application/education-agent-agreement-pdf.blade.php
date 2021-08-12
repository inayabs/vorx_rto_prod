<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" href="{{public_path()}}/agent-agreement/pdf-style.css" rel="stylesheet" />
	<title>Education Agent Agreement</title>
</head>

<!-- Page 1 of 8 -->

<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 20px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/agent-agreement/images/vorx_logo.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Education Agent Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 20px;">

					<div class="content">
						<p class="proximanova-bold primary-font-color px-18-font text-center">Education Agent / Agent Agreement</p>
						<p class="proximanova-bold text-center px-12-font">Dated: <span class="proximanova-regular">{{ \Carbon\Carbon::parse($dated)->format('d/m/Y') }}</span></p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="proximanova-bold text-center px-12-font">BETWEEN</p>
						<p class="proximanova-bold primary-font-color px-14-font text-center">{{ $org->training_organisation_name }}</p>
						<p class="proximanova-bold text-center px-12-font">AND</p>
                        <p class="proximanova-bold text-center px-14-font primary-font-color">{{$detail->company_name}}</p>
                        <p class="proximanova-bold text-center px-14-font primary-font-color">{{$detail->office_address}}</p>
                       
						<!-- <table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="15%" class="primary-bg-color white-font-color px-12-font proximanova-bold">Agent Company:</td>
								<td width="85%" class="px-12-font"></td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Address:</td>
								<td class="px-12-font"></td>
							</tr>
						</table> -->
						<div class="clearfix" style="height: 10px;"></div>
						<p class="proximanova-bold primary-font-color px-14-font">PURPOSE OF THIS AGREEMENT:</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="text-justify px-12-font line-height-12px">The Education Agent is authorised by {{ $org->training_organisation_name }} to identify and facilitate the enrolment of prospective international students in courses delivered by {{ $org->training_organisation_name }}.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="text-justify px-12-font line-height-12px">In return for the Education Agent undertaking the Services described in Section 1 in the way required by this Agreement, {{ $org->training_organisation_name }} will pay the Education Agent the Commission, or other amount, described in Section 3 for each student introduced to {{ $org->training_organisation_name }} by the Education Agent who successfully enrolls in a course and pays the agreed tuition fees.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="proximanova-bold primary-font-color px-14-font">THIS DOCUMENT INCLUDES:</p>
						<ul class="section-list no-margin no-padding px-12-font">
							<li>Education Agent’s Services and Standards of Behaviour</li>
							<li>Services that {{ $org->training_organisation_name }} will provide to the Education Agent</li>
							<li>Terms of Commission and Payment</li>
							<li>GST</li>
							<li>Exclusivity</li>
							<li>Variation</li>
							<li>Intellectual Property</li>
							<li>Confidentiality</li>
							<li>Terms of Agreement</li>
							<li>Termination</li>
						</ul>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="text-justify px-12-font line-height-12px">This Agreement is governed by and construed in accordance with the law in force in the State of Victoria, Australia.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="text-justify px-12-font line-height-12px">The parties submit to the non-exclusive jurisdiction of the courts of the State of Victoria, Australia and the Federal Court of Australia.</p>
						<div class="clearfix" style="height: 10px;"></div>

						<ol class="no-margin no-padding">
							<li>
								<span class="proximanova-bold px-12-font">EDUCATION AGENT’S SERVICES and STANDARDS OF BEHAVIOUR</span>
								<ol class="no-padding">
									<li>
										<span class="proximanova-bold px-12-font">Ethical Behaviour</span>
										<p class="px-12-font">The Education Agent must advise prospective students that:</p>
										<div class="clearfix" style="height: 5px;"></div>
										<div class="bullet-list">
											<div>Students who come to Australia on a student visa must have a primary purpose of studying and are expected to complete the course within the expected duration; and</div>
											<div>Dependents and all accompanying school age dependants must pay any relevant fees if enrolling in either government or non-government schools.</div>
											<div>Agent must explain all the pre-enrollment information to the prospective students, given to him/her in regards to the course and the college.</div>
										</div>
									</li>
									<li>
										<span class="proximanova-bold px-12-font">Business Requirements</span>
										<p class="px-12-font line-height-14px">Education Agents are required to be registered as a business according to the law of the countries in which the Education Agent conducts business, with experience in education consulting a major part of the business.</p>
									</li>
									<li>
										<span class="proximanova-bold px-12-font">Education Agent’s Services :</span>
										<p class="px-12-font">The {{ $org->training_organisation_name }} expects the Education Agent to provide the following minimum services to the maximum benefit of prospective international students. Education Agents will:</p>
										<div class="clearfix" style="height: 5px;"></div>
										<div class="bullet-list">
											<div>Market {{ $org->training_organisation_name }}‘s courses to prospective students using {{ $org->training_organisation_name }} ‘s promotional materials;</div>
											<div>Assist prospective students to complete their application for enrolment in a {{ $org->training_organisation_name }} course;</div>
											<div>On behalf of {{ $org->training_organisation_name }}, verify the validity of documentation included in applications for enrolment;</div>
											<div>Only provide immigration advice where authorised to do so under the Migration Act 1958and Migration Regulations 1994;</div>
											<div>For persons whose applications for enrolment are accepted by {{ $org->training_organisation_name }}, facilitate the student’s completion of enrolment and other requirements.</div>
										</div>
									</li>
								</ol>
							</li>
						</ol>
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 0px;"> Page 1 of 8</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 1 of 8 -->


<!-- Page 2 of 8 -->

<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 20px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
                                    <img src="{{public_path()}}/agent-agreement/images/vorx_logo.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Education Agent Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 20px;">

					<div class="content">
						<p class="proximanova-bold px-14-font">In particular, the Education Agent will:</p>
						<ol class="no-padding">
							<li class="no-index">
								<ol class="no-padding">
									<li class="no-index no-padding"></li>
									<li class="no-index no-padding"></li>
									<li class="no-index no-padding">
										<ol class="long-index">
											<li>
												<p class="px-12-font line-height-14px">Use only {{ $org->training_organisation_name }}’s accurate and current promotional material (in print and referral to electronic format on the {{ $org->training_organisation_name }} website) and advice to prospective students on:</p>
												<div class="clearfix" style="height: 5px;"></div>
												<ol class="no-padding long-index">
													<li>study options;</li>
													<li>entry requirements (minimum level of English language proficiency, educational qualifications or work experience required, applicable course credit, student’s abilities and aspirations);</li>
													<li>CRICOS-registered courses (content and duration, qualification offered if applicable, modes of study and assessment methods, tools and re-assessment, educational outcomes for successful course completion, and whether the course needs to be accredited, registered, approved or otherwise recognised under a law);</li>
													<li>premises including campus locations and a general description of facilities, equipment, learning and library resources, student services and pastoral care available to students;</li>
													<li>course-related fees, fee changes, re-assessment fees, signed Student Agreement and {{ $org->training_organisation_name }}’s Refunds policy and procedure;</li>
													<li>Making sure that the prospective student understands {{ $org->training_organisation_name }}‘s ‘offer letter and agreement’ correctly and accurately.</li>
													<li>grounds where deferral, suspension and/or cancellation of a student’s enrolment may occur;</li>
													<li>transfers between Registered Providers when less than six months of his or her principal course is completed;</li>
													<li>legal obligations and other requirements for education and course providers and professional registration, for example, education and course provision (the Australian Quality Training Framework (AQTF), the ESOS Framework and The National Code of Practice for Registration Authorities and Providers of Education and Training to Overseas Students 2017; National English Language Teaching Accreditation Scheme);</li>
													<li>Living in Australia including indicative costs of living; accommodation options.</li>
													<li>Dependents and all accompanying school age dependents must pay any relevant fees if enrolling in either government or non-government schools.</li>
													<li>Terms and conditions regarding payment of fees, refund and cancellation policies.</li>
													<li>Before prospective students complete an enrolment application, the Education Agent must give them:
														<div class="bullet-list">
															<div>{{ $org->training_organisation_name }} Student handbook and policy and procedures</div>
															<div>PRE-DEPARTURE AND PRE-ARRIVAL GUIDE</div>
															<div>{{ $org->training_organisation_name }} website details</div>
														</div>
													</li>
												</ol>
											</li>
											<li>
												<p class="px-12-font line-height-14px">Where the prospective student is interested in accommodation, the Education Agent may refer prospective students to Home stay Providers. Agent can ask assistance from {{ $org->training_organisation_name }}’s admissions office. It will be provided as per prospective student's requirements.</p>
											</li>
											<li>
												<p class="px-12-font line-height-14px">Ensure they maintain sufficient stocks of {{ $org->training_organisation_name }}‘s current promotional materials to ensure the Education Agent has the capacity to supply all promotional material to potential clients. Assist prospective students with course applications, ensuring applications are fully completed and documentation is included before being presented to the {{ $org->training_organisation_name }}. If applications are not completed and signed, or supporting evidence is not supplied, there will be delays in processing applications.</p>
											</li>
											<li>
												<p class="px-12-font line-height-14px">Verify documentation supporting an application for enrolment such as English results (IELTS, TOEFL, etc), academic results and work references.</p>
											</li>
											<li>
												<p class="px-12-font line-height-14px">Advise students on visa and health care registration processes and policies.</p>
											</li>
											<li>
												<p class="px-12-font line-height-14px">Provide a pre-departure and arrival briefing for enrolled students.</p>
											</li>
											<li>
												<p class="px-12-font line-height-14px">Where {{ $org->training_organisation_name }} accepts an application for enrolment, ensure the student reads, understands, signs and returns the application to {{ $org->training_organisation_name }}‘s admissions office. Please note that an electronic Confirmation of Enrolment (E-COE) will only be issued if {{ $org->training_organisation_name }}’s Offer Letter and acceptance Agreement has been signed and returned with the initial deposit Payment.</p>
											</li>
											<li>
												<p class="px-12-font line-height-14px">{{ $org->training_organisation_name }} will not be liable to the prospective student, or any other person, in connection with the receipt of money by the Education Agent and the Education Agent indemnifies {{ $org->training_organisation_name }} (including its employees) in relation to all such claims (however described) made against {{ $org->training_organisation_name }}.</p>
											</li>
											<li>
												<p class="px-12-font line-height-14px">Education Agent shall play an active role to screen and recruit all prospective students seeking to complete studies at {{ $org->training_organisation_name }} for the period specified in this agreement, after which time this agreement will be reviewed by both parties.</p>
											</li>
											<li>
												<p class="px-12-font line-height-14px">Education Agent will ensure that only signed and completed applications are submitted to {{ $org->training_organisation_name }}.</p>
											</li>
											<li>
												<p class="px-12-font line-height-14px">{{ $org->training_organisation_name }} expects Education Agent to regularly visit official website of {{ $org->training_organisation_name }} (<a href="https://phoenixcollege.edu.au/student-support/#student_policies">https://phoenixcollege.edu.au/student-support/#student_policies</a>) for the most current course information.</p>
											</li>
										</ol>
									</li>
								</ol>
							</li>
						</ol>
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 0px;"> Page 2 of 8</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 2 of 8 -->


<!-- Page 3 of 8 -->

<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 20px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/agent-agreement/images/vorx_logo.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Education Agent Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 20px;">

					<div class="content">
						<ol class="no-margin no-padding">
							<li class="no-index">
								<ol>
									<li class="no-index no-padding"></li>
									<li class="no-index no-padding"></li>
									<li class="no-index no-padding">
										<ol class="no-padding long-index">
											<li class="no-index"></li>
											<li class="no-index"></li>
											<li class="no-index"></li>
											<li class="no-index"></li>
											<li class="no-index"></li>
											<li class="no-index"></li>
											<li class="no-index"></li>
											<li class="no-index"></li>
											<li class="no-index"></li>
											<li class="no-index"></li>
											<li class="no-index"></li>
											<li>
												Education Agent is expected to submit the following documentation to Student Admissions Department in order to be given a letter of offer:
												<div class="clearfix" style="height: 5px;"></div>
												<div class="bullet-list">
													<div>COMPLETE and SIGNED {{ $org->training_organisation_name }} application form or fill in online application form.</div>
													<div>Copy of the clients Passport (front and back pages)</div>
													<div>VISA details (if applicable).</div>
													<div>Certified copy of the Clients Year 12 and/or above qualifications (English translated).</div>
													<div>Certified copy of all academic qualifications completed overseas or in Australia.</div>
													<div>Evidence of IELTS 5.5 or equivalent.</div>
												</div>
											</li>
											<li>Education Agent is expected to provide {{ $org->training_organisation_name }} with all necessary and accurate documentation when called for at different stages of the enrolment process.</li>
											<li>Education Agent is expected to submit the following documentation to Student Admissions Department in order to receive a Confirmation of Enrolment:
												<div class="clearfix" style="height: 5px;"></div>
												<div class="bullet-list">
													<div>Copy of signed offer letter and acceptance Agreement </div>
													<div>Proof of Payment (Copy of Demand Draft or Bank Transfer Receipt)</div>
													<div>Copy of Client’s Passport (for verification)</div>
												</div>
											</li>
											<li>Education Agent will give all necessary documentation to {{ $org->training_organisation_name }} as English translated copy. {{ $org->training_organisation_name }} is reliant on Education Agent to check for authenticity and accuracy of documentation.</li>
											<li>Education Agent must display the Company name or stamp on each application.</li>
											<li>Education Agent must not assign this agreement or any right under this agreement to any other persons, Education Agents or sub-Education Agents without the written consent of {{ $org->training_organisation_name }} (which may be withheld at its discretion).</li>
											<li>Education Agent must not subcontract to any person the performance of any of its obligations under this Agreement without the prior written consent of {{ $org->training_organisation_name }} (which may be withheld at its discretion).</li>
											<li>Despite any subcontract, the Education Agent remains liable for performing its obligations under this Agreement.</li>
											<li>Education Agent will advise {{ $org->training_organisation_name }} on the students’ whereabouts, if the student does not or will not arrive in time for the course start date (according to COE); This information must be relayed to {{ $org->training_organisation_name }}’s Admissions Department within 14 days of COE commencement date in order for {{ $org->training_organisation_name }} to take further action in regards to the student’s enrolment.</li>
											<li>Education Agent is not authorised to collect fees in cash from the students; however the fees could be fully deposited through bank transfer and draft made in favor of the authorised {{ $org->training_organisation_name }} account.</li>
											<li>In the case of student and provider default, refunds of course money will be:
												<div class="clearfix" style="height: 5px;"></div>
												<div class="letters-list">
													<div>a. In the same currency as it was paid to protect the financial interests of students; and</div>
													<div>b. Paid directly only to the student.</div>
												</div>
											</li>
										</ol>
									</li>
								</ol>
							</li>
						</ol>

						<ol class="no-margin no-padding">
							<li class="no-index"></li>
							<li>
								<span class="proximanova-bold px-12-font">SERVICES THAT ETIWILL PROVIDE TO EDUCATION AGENT</span>
								<p class="px-12-font line-height-14px">{{ $org->training_organisation_name }} will provide following services to Education Agent:</p>
								<div class="clearfix" style="height: 2px;"></div>
								<ol class="no-margin no-padding">
									<li>
										<span class="proximanova-bold px-12-font">Prompt application processing:</span>
										<div class="clearfix" style="height: 2px;"></div>
										<p class="px-12-font line-height-14px">{{ $org->training_organisation_name }}’s admission office will process applications within two (2) working days of receipt of application, provided that applications are fully completed and all supporting documentation are supplied.</p>
									</li>
									<li>
										<span class="proximanova-bold px-12-font">Staff briefings</span>
										<div class="clearfix" style="height: 2px;"></div>
										<p class="px-12-font line-height-14px">{{ $org->training_organisation_name }}‘s representatives participate in overseas marketing and frequently visiting agent’s onshore offices. {{ $org->training_organisation_name }} will brief and update the Education Agent on {{ $org->training_organisation_name }}‘s promotional materials, courses and procedures on an ongoing basis when they visit the countries in which the Education Agent conducts business.</p>
									</li>
									<li>
										<span class="proximanova-bold px-12-font">Supply of promotional materials</span>
										<div class="clearfix" style="height: 2px;"></div>
										<p class="px-12-font line-height-14px">{{ $org->training_organisation_name }} will supply Education Agents with accurate and current promotional materials including entry requirements for CRICOS registered courses such as course outlines, flyers, study tour booklets, newsletters, posters, CD etc (where applicable). </p>
										<div class="clearfix" style="height: 5px;"></div>
										<p class="px-12-font line-height-14px">{{ $org->training_organisation_name }}’s website is and should be considered as the most current source of information.</p>
									</li>
									<li>
										<span class="proximanova-bold px-12-font">Review of performance and corrective actions</span>
										<div class="clearfix" style="height: 2px;"></div>
										<p class="px-12-font line-height-14px">The {{ $org->training_organisation_name }} will select, manage and monitor Education Agent practices to ensure Education Agent activities and ethics uphold Australia’s reputation as a desirable destination for students (The National Code, 2018). Several {{ $org->training_organisation_name }} documents shall be used in the performance review process, such as, Client Complaints; International Student Focus Group Agenda, Minutes and Travel Itinerary.</p>
										<div class="clearfix" style="height: 5px;"></div>
										<p class="px-12-font line-height-14px">The {{ $org->training_organisation_name }} will take immediate corrective and preventative actions including termination of a written Agreement, upon {{ $org->training_organisation_name }} becoming aware of the Education Agent or associate or high managerial Education Agent of being negligent, careless, incompetent, dishonest or unethical in its marketing and recruitment practices including the deliberate attempt to recruit a student who will not comply with their student visa conditions or where the Education Agent is in breach of Australian legislation and other requirements.</p>
										<div class="clearfix" style="height: 5px;"></div>
										<p class="px-12-font line-height-14px">Ensure a system for the interchange of information to enable the student recruitment to {{ $org->training_organisation_name }}. Any changes, amendments in the courses shall be communicated to Education Agent through e-mails, telephonic communications and updated websites. {{ $org->training_organisation_name }} shall give full assistance where Education Agent requires additional training for counseling students, following standard procedures and practices for the enrolment process.</p>
									</li>
								</ol>
							</li>
						</ol>

					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 0px;"> Page 3 of 8</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 3 of 8 -->


<!-- Page 4 of 8 -->

<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 20px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/agent-agreement/images/vorx_logo.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Education Agent Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 20px;">

					<div class="content">
						<ol class="no-margin no-padding">
							<li class="no-index"></li>
							<li class="no-index"></li>
							<li>
								<span class="proximanova-bold px-12-font">TERMS OF COMMISSION and PAYMENT</span>
								<div class="clearfix" style="height: 2px;"></div>
								<ol class="no-margin no-padding">
									<li>
										<span class="proximanova-bold px-12-font">To whom commission is paid</span>
										<div class="clearfix" style="height: 2px;"></div>
										<p class="px-12-font line-height-14px">Subject to this Agreement, commission will be paid to the Education Agent that provides the services as listed in Section 1 and is responsible for introducing a student to the {{ $org->training_organisation_name }} by sending to the {{ $org->training_organisation_name }} the relevant student’s completed application form with all attachments.</p>
										<div class="clearfix" style="height: 5px;"></div>
										<p class="px-12-font line-height-14px">All the application forms should have an Education Agent name or company stamp and may be faxed, mailed or emailed with attachment/s or hand delivered to the campus. </p>
										<div class="clearfix" style="height: 5px;"></div>
										<p class="px-12-font line-height-14px">If a student comes directly to the {{ $org->training_organisation_name }} and receives an Offer of Place, no claims can be made for the payment of commission on those applications.</p>
									</li>
									<li>
										<span class="proximanova-bold px-12-font">When is commission payable?</span>
										<div class="clearfix" style="height: 2px;"></div>
										<p class="px-12-font line-height-14px">Commission or part thereof, is payable to an Education Agent when a student introduced to {{ $org->training_organisation_name }} by the Education Agent commences a course delivered by {{ $org->training_organisation_name }}; namely when:</p>
										<div class="clearfix" style="height: 5px;"></div>
										<div class="bullet-list">
											<div>The Education agent will be paid the commission on the amount of the fees paid by the student and the student does not owe anything including books to the college.</div>
											<div>The required amount of tuition fees for the student have been received by {{ $org->training_organisation_name }}, and</div>
											<div>The student receives the student visa necessary for starting his/her course at {{ $org->training_organisation_name }}.</div>
										</div>
									</li>
									<li>
										<span class="proximanova-bold px-12-font">When commission will not be paid</span>
										<div class="clearfix" style="height: 2px;"></div>
										<p class="px-12-font line-height-14px">The {{ $org->training_organisation_name }} will not pay commission when:</p>
										<div class="clearfix" style="height: 5px;"></div>
										<div class="bullet-list">
											<div>The student withdraws for any reason before the course commences including if his/her visa application is rejected;</div>
											<div>The student has already been introduced by another Education Agent;</div>
											<div>SERVICES THAT {{ $org->training_organisation_name }}, WILL PROVIDE TO EDUCATION AGENT – The Education Agent has neither performed the services, nor met the standards, described in Section 1;</div>
											<div>The Education Agent does not submit an invoice for the commission.</div>
											<div>Where the student left the provider before completing the qualification and paid no fees</div>
											<div>The student changes the course at {{ $org->training_organisation_name }} for which he was not originally enrolled for.</div>
										</div>
									</li>
									<li>
										<span class="proximanova-bold px-12-font">Amount of commission</span>
										<div class="clearfix" style="height: 2px;"></div>
										<p class="px-12-font line-height-14px">Commission is calculated as the nominated percentage of the total of the tuition fees paid for the course (“Commission percentage”). Commission is calculated and paid in Australian dollars ($AUD).</p>
										<div class="clearfix" style="height: 5px;"></div>
										<ol class="no-margin no-padding">
											<li>
												<span class="proximanova-bold px-12-font">Commission percentages</span>
												<div class="clearfix" style="height: 2px;"></div>
												<p class="px-12-font line-height-14px">{{ $org->training_organisation_name }} will pay the Education Agent commission based on the courses tuition fees for both onshore and offshore students who enrolls and studies at {{ $org->training_organisation_name }}. A percentage of _30_% (including GST) of the enrolled program’s tuition fee will be paid to the agent.</p>
											</li>
										</ol>
									</li>
									<li>
										<span class="proximanova-bold px-12-font">Payment of Commission</span>
										<div class="clearfix" style="height: 2px;"></div>
										<p class="px-12-font line-height-14px">For enrolments in {{ $org->training_organisation_name }} courses, the agent will be getting the agreed percentage of commission on the amount of tuition fees paid by the student.</p>
										<div class="clearfix" style="height: 5px;"></div>
										<p class="px-12-font line-height-14px">The Education Agent must give the {{ $org->training_organisation_name }} a correctly rendered invoice in relation to each commission instalment.</p>
									</li>
									<li>
										<span class="proximanova-bold px-12-font">Invoices</span>
										<div class="clearfix" style="height: 2px;"></div>
										<p class="px-12-font line-height-14px">A correctly rendered invoice may include the following information but not limited to:</p>
										<div class="clearfix" style="height: 5px;"></div>
										<div class="bullet-list">
											<div>Student’s name and Date of Birth</div>
											<div>Course Name</div>
											<div>Course start Date</div>
											<div>Amount of tuition fees paid and the date paid</div>
											<div>Amount of commission claimed.</div>
										</div>
									</li>
									<li>
										<p class="px-12-font line-height-14px">A commission instalment will not be payable to the Education Agent for enrolment in units the student has previously enrolled in; for example, where the student repeats units he/she has failed in a previous semester. This also applies where the student re-enrols in the units as part of a new course.</p>
										<div class="clearfix" style="height: 5px;"></div>
										<p class="px-12-font line-height-14px">The {{ $org->training_organisation_name }} will process the invoice within fifteen (15) days of presentation of a correctly rendered invoice. If an invoice is presented prior to the commencement of the course, the invoice will be processed within fifteen days from the first day of training of the course.</p>
									</li>
									<li>
										<span class="proximanova-bold px-12-font">Financial arrangement details</span>
										<div class="clearfix" style="height: 2px;"></div>
										<ol class="no-margin no-padding">
											<li>
												<p class="px-12-font line-height-14px">Financial arrangements require that all fees collected by Education Agent on behalf of {{ $org->training_organisation_name }} shall be paid to:</p>
												<div class="clearfix" style="height: 10px;"></div>
												<table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
													<tr>
														<td width="18%" class="primary-bg-color white-font-color px-12-font proximanova-bold">Account Name:</td>
														<td width="32%" class="px-12-font">Phoenix College of Australia Pty Ltd</td>
													</tr>
													<tr>
														<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Bank Name:</td>
														<td class="px-12-font">Westpac</td>
													</tr>
													<tr>
														<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Branch Address:</td>
														<td class="px-12-font">Werribee Plaza</td>
													</tr>
                                                    <tr>
                                                        <td width="18%" class="primary-bg-color white-font-color px-12-font proximanova-bold">SWIFT Code:</td>
														<td width="32%" class="px-12-font">WPACAU2S</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="primary-bg-color white-font-color px-12-font proximanova-bold">BSB:</td>
														<td class="px-12-font">033501</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="primary-bg-color white-font-color px-12-font proximanova-bold">Account No:</td>
														<td class="px-12-font">289843</td>
                                                    </tr>
												</table>
											</li>
										</ol>
									</li>
								</ol>
							</li>
						</ol>

					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 0px;"> Page 4 of 8</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 4 of 8 -->

<!-- Page 5 of 8 -->

<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 20px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/agent-agreement/images/vorx_logo.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Education Agent Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 20px;">

					<div class="content">
						<ol class="no-margin no-padding">
							<li class="no-index"></li>
							<li class="no-index"></li>
							<li class="no-index">
								<ol class="no-padding">
									<li class="no-index"></li>
									<li class="no-index"></li>
									<li class="no-index"></li>
									<li class="no-index"></li>
									<li class="no-index"></li>
									<li class="no-index"></li>
									<li class="no-index"></li>
									<li class="no-index no-margin no-padding">
										<ol class="long-index">
											<li class="no-index"></li>
											<li>
												<p class="px-12-font line-height-14px">When making tuition fee payment to {{ $org->training_organisation_name }} Bank Account the student’s date of birth and initials must be specified. EG 01.05.79 E. Zappia. (where ‘E’ is the initial for their first name & ‘Zappia’ is the last name)</p>
											</li>
											<li>
												<p class="px-12-font line-height-14px">When making tuition fee payment to {{ $org->training_organisation_name }} by draft, the student’s date of birth, full name and Education Agent Company name must be specified.</p>
											</li>
											<li>
												<p class="px-12-font line-height-14px">If student has paid tuition fees, the agent will be getting the agreed percentage of commission on the amount of fees paid by the student. </p>
											</li>
											<li>
												<p class="px-12-font line-height-14px">If tuition deposit fee is not paid to {{ $org->training_organisation_name }} by the appropriate means stipulated in this agreement within 21 days of the CoE issuance then {{ $org->training_organisation_name }} has the right to cancel the Confirmation of Enrolment of the student.</p>
											</li>
											<li>
												<p class="px-12-font line-height-14px">Should a student elect to discontinue or withdraw from the course or cannot commence the applied course due to any of the circumstances as outlined in the refund policy, Education Agent shall be obligated to refund the total amount of commission paid to date for the student and/ or {{ $org->training_organisation_name }} will not be obligated to pay the commission for that student.</p>
											</li>
											<li>
												<p class="px-12-font line-height-14px">After receiving an invoice from {{ $org->training_organisation_name }} for the required refundable commission (if applicable), Education Agent will refund to within 14 days of the student discontinuing or withdrawing from {{ $org->training_organisation_name }}. Should a student/Education Agent request a refund, the following documentation must be provided to {{ $org->training_organisation_name }} to <a href="mailto:phoenixcollegeaustralia@gmail.com">phoenixcollegeaustralia@gmail.com</a></p>
												<div class="clearfix" style="height: 5px;"></div>
												<div class="bullet-list">
													<div>VISA refusal letter (if applicable)</div>
													<div>Refund Application Form</div>
													<div>Copy of issued CoE</div>
													<div>Copy of Proof of Payment (draft, receipt, cheque, etc)</div>
												</div>
											</li>
											<li>
												<p class="px-12-font line-height-14px">No Education Agent fee applies where a student applies to enroll directly to {{ $org->training_organisation_name }}.</p>
											</li>
											<li>
												<p class="px-12-font line-height-14px">No Education Agent fee is payable unless the Education Agent has submitted an invoice in a form approved by {{ $org->training_organisation_name }} containing all the information set out in standard 3.</p>
											</li>
										</ol>
									</li>
									<li>
										<span class="proximanova-bold px-12-font">Method of commission payment</span>
										<div class="clearfix" style="height: 2px;"></div>
										<p class="px-12-font line-height-14px">Commission can be paid either by:</p>
										<div class="clearfix" style="height: 5px;"></div>
										<div class="bullet-list">
											<div>Electronic Funds Transfer (EFT) to a nominated bank account.</div>
											<div>An Education Agent should indicate their preferred method of payment in their initial application.</div>
											<div>Education Agents who choose to electronically forward student fees will be liable for any bank charges incurred by their bank outside Australia and within Australia.</div>
											<div>Education Agent will be responsible for any bank fees incurred by {{ $org->training_organisation_name }}’s bank (Westpac Bank) for processing commission payment according to the terms advised in the Education Agent’s commission invoice.</div>
										</div>
										<div class="clearfix" style="height: 5px;"></div>
										<p class="px-12-font line-height-14px">All payments will be made only in Australian dollars.</p>
									</li>
									<li>
										<span class="proximanova-bold px-12-font">Payment Method</span>
										<div class="clearfix" style="height: 2px;"></div>
										<p class="px-12-font line-height-14px">All course fee payments will be done as Direct Deposit into {{ $org->training_organisation_name }}’s Bank Account.</p>
										<div class="clearfix" style="height: 5px;"></div>
										<span class="proximanova-bold px-12-font">Bank Details as Follows:</span>
										<div class="clearfix" style="height: 10px;"></div>
                                        <table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
													<tr>
														<td width="18%" class="primary-bg-color white-font-color px-12-font proximanova-bold">Account Name:</td>
														<td width="32%" class="px-12-font">Phoenix College of Australia Pty Ltd</td>
													</tr>
													<tr>
														<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Bank Name:</td>
														<td class="px-12-font">Westpac</td>
													</tr>
													<tr>
														<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Branch Address:</td>
														<td class="px-12-font">Werribee Plaza</td>
													</tr>
                                                    <tr>
                                                        <td width="18%" class="primary-bg-color white-font-color px-12-font proximanova-bold">SWIFT Code:</td>
														<td width="32%" class="px-12-font">WPACAU2S</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="primary-bg-color white-font-color px-12-font proximanova-bold">BSB:</td>
														<td class="px-12-font">033501</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="primary-bg-color white-font-color px-12-font proximanova-bold">Account No:</td>
														<td class="px-12-font">289843</td>
                                                    </tr>
										</table>
									</li>
								</ol>
								<div class="clearfix" style="height: 10px;"></div>
							</li>
							<li>
								<span class="proximanova-bold px-12-font">GST</span>
								<div class="clearfix" style="height: 2px;"></div>
								<ol class="no-padding">
									<li>
										<p class="px-12-font line-height-14px">In this clause “GST”, “supplier” and “tax invoice” have the same meaning as defined in A New Tax System (Goods and Services Tax) Act 1999 (Cth) (“the GST legislation”).</p>
									</li>
									<li>
										<p class="px-12-font line-height-14px">The Education Agent acknowledges that in terms of the GST legislation it will, under this Agreement, be a “supplier” and may be required to pay GST to the Commissioner of Taxation.</p>
									</li>
									<li>
										<p class="px-12-font line-height-14px">The parties agree that the agreed prices for the Goods or Services under the Agreement are GST inclusive prices, and that the amount payable under the Agreement shall not be varied by the amount of the GST.</p>
									</li>
									<li>
										<p class="px-12-font line-height-14px">The Education Agent will ensure that all invoices rendered to the {{ $org->training_organisation_name }} under the Agreement are in a format that identifies any GST paid, and which permits the {{ $org->training_organisation_name }} to claim an input tax credit.</p>
									</li>
									<li>
										<p class="px-12-font line-height-14px">{{ $org->training_organisation_name }} must pay to the Education Agent the amount of each invoice subject to the terms of the Agreement.</p>
									</li>
								</ol>
								<div class="clearfix" style="height: 10px;"></div>
							</li>
							<li>
								<span class="proximanova-bold px-12-font">NO EXCLUSIVITY</span>
								<div class="clearfix" style="height: 2px;"></div>
								<p class="px-12-font line-height-14px">The Education Agent does not have the exclusive right to enrol students in or from any one (1) region, area or country.</p>
							</li>
						</ol>

					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 0px;"> Page 5 of 8</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 5 of 8 -->

<!-- Page 6 of 8 -->

<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 20px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/agent-agreement/images/vorx_logo.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Education Agent Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 20px;">

					<div class="content">
						<ol class="no-margin no-padding">
							<li class="no-index"></li>
							<li class="no-index"></li>
							<li class="no-index"></li>
							<li class="no-index"></li>
							<li class="no-index"></li>
							<li>
								<span class="proximanova-bold px-12-font">VARIATION</span>
								<div class="clearfix" style="height: 2px;"></div>
								<ol class="no-padding">
									<li>
										<p class="px-12-font line-height-14px">{{ $org->training_organisation_name }} may by notice request the Education Agent to vary the services in nature, scope or timing.</p>
									</li>
									<li>
										<p class="px-12-font line-height-14px">Without limiting the generality of subsection 5 the {{ $org->training_organisation_name }} may request the Education Agent to:</p>
										<div class="clearfix" style="height: 5px;"></div>
										<div class="letters-list">
											<div>a. increase, decrease or omit any part of the services;</div>
											<div>b. change the character or content of any part of the services;</div>
											<div>c. perform additional work</div>
										</div>
									</li>
									<li>
										<p class="px-12-font line-height-14px">Where the {{ $org->training_organisation_name }} requests a variation to the services, the parties will negotiate in good faith a variation of the fees and the time for completion. The Education Agent will not commence work on the variation of the services without the {{ $org->training_organisation_name }}’s consent and the written agreement of both parties.</p>
									</li>
								</ol>
							</li>
							<li>
								<span class="proximanova-bold px-12-font">INTELLECTUAL PROPERTY</span>
								<div class="clearfix" style="height: 2px;"></div>
								<ol class="no-padding">
									<li>
										<p class="px-12-font line-height-14px">The Education Agent acknowledges that all Intellectual Property Rights of the {{ $org->training_organisation_name }} shall remain vested solely in {{ $org->training_organisation_name }}.</p>
									</li>
									<li>
										<p class="px-12-font line-height-14px">{{ $org->training_organisation_name }} acknowledges that all Intellectual Property Rights of the Education Agent shall remain vested solely in the Education Agent.</p>
									</li>
									<li>
										<p class="px-12-font line-height-14px">{{ $org->training_organisation_name }} grants to the Education Agent a non-exclusive licence to use, and distribute any literature only for the purposes of enabling the Education Agent to perform its obligations under this Agreement.</p>
									</li>
									<li>
										<p class="px-12-font line-height-14px">The Education Agent must not sub-licence the licence granted to them.</p>
									</li>
									<li>
										<p class="px-12-font line-height-14px">The Education Agent acknowledges that adaptations of the {{ $org->training_organisation_name }}’s materials are prohibited.</p>
									</li>
									<li>
										<p class="px-12-font line-height-14px">The Education Agent warrants that in performing the {{ $org->training_organisation_name }}’s obligations it will not infringe the Intellectual Property Rights of any person.</p>
									</li>
									<li>
										<p class="px-12-font line-height-14px">The Education Agent will indemnify {{ $org->training_organisation_name }} against all costs, expenses and liabilities arising out of a breach of the warranty.</p>
									</li>
									<li>
										<p class="px-12-font line-height-14px">The indemnities shall continue for a period of three years after the expiry or earlier termination of this Agreement.</p>
									</li>

								</ol>
							</li>
							<li>
								<span class="proximanova-bold px-12-font">CONFIDENTIALITY</span>
								<div class="clearfix" style="height: 2px;"></div>
								<ol class="no-padding">
									<li>
										<p class="px-12-font line-height-14px">The Education Agent shall not, without the written permission of {{ $org->training_organisation_name }}, at any time during or after the term of this Agreement disclose or reproduce any confidential matter or information supplied in respect of this Agreement by the State, and the Education Agent shall not deal with any personal information obtained in the course of performing this Agreement other than in accordance with the national Privacy Principles.</p>
									</li>
									<li>
										<p class="px-12-font line-height-14px">In this section “personal information” and “National Privacy Principles” have the same meaning as given to those terms of the Privacy Act 2000 (Commonwealth of Australia).</p>
									</li>
								</ol>
							</li>
							<li>
								<span class="proximanova-bold px-12-font">TERM OF AGREEMENT</span>
								<div class="clearfix" style="height: 2px;"></div>
								<ol class="no-padding">
									<li>
										<p class="px-12-font line-height-14px">This agreement will terminate itself on 30th June or 31st December in the following situations:-</p>
										<div class="clearfix" style="height: 5px;"></div>
										<div class="bullet-list">
											<div>When the agreement is signed between 1st January – 30th June in a year, it will automatically terminate itself on 31st December of the year the agreement is signed;</div>
											<div>When the agreement is signed between 1st July – 31st December in a year, it will automatically terminate itself on 30th June of the following year. </div>
										</div>
										<div class="clearfix" style="height: 5px;"></div>
										<p class="px-12-font line-height-14px">Education Agent agreements and authority to represent the {{ $org->training_organisation_name }} will be reviewed on an annual basis.</p>
									</li>
								</ol>
							</li>
							<li>
								<span class="proximanova-bold px-12-font">TERMINATION</span>
								<div class="clearfix" style="height: 2px;"></div>
								<p class="px-12-font line-height-14px">Except as provided in subsection 1.1, either party may terminate this Agreement by giving 14 days written notice to the other party.</p>
								<div class="clearfix" style="height: 5px;"></div>
								<ol class="no-padding">
									<li>
										<p class="px-12-font line-height-14px">{{ $org->training_organisation_name }} will immediately take corrective action, (by issuing warning notices), or may terminate the agreement with the Education Agent if it becomes aware of The Education Agent being negligent, careless or incompetent or being engaged in false, misleading or unethical advertising and recruitment practices, including practices that could harm the integrity of Australian education and training.</p>
									</li>
									<li>
										<p class="px-12-font line-height-14px">In representing {{ $org->training_organisation_name }}, appointed Education Agents are to abide by the highest ethical standards. It must be understood that any form of discounting or fee adjustments offered to students/clients, is strictly prohibited and would be considered as not being in the best interest of the Education Agent, the client or the {{ $org->training_organisation_name }}. Marketing material produced by a Education Agent such as brochures, web sites, flyers, etc.; listing prices for {{ $org->training_organisation_name }} courses, which have evidence of discounting, is strictly prohibited.</p>
										<div class="clearfix" style="height: 5px;"></div>
										<p class="px-12-font line-height-14px">In the event the Education Agent engages in any of the behaviour or related activities described above, {{ $org->training_organisation_name }} may decide to terminate this Agreement immediately and will cease the remittance of commissions for any enrolments received after the termination date.</p>
									</li>
									<li>
										<p class="px-12-font line-height-14px">{{ $org->training_organisation_name }} will terminate the agreement with The Education Agent if it becomes aware of, or reasonably suspects dishonest practices, including the deliberate attempt to recruit a student where this clearly conflicts with the obligations of registered providers under National Code Standard 7 (Transfer between registered providers, whereby a receiving registered provider must not knowingly enroll the student wishing to transfer from another registered provider’s course prior to the student completing six months of his or her principal course of study) or any of the other dishonest practices outlined above or in breach of the conditions of the ESOS Act 2000.</p>
									</li>
									<li>
										<p class="px-12-font line-height-14px">Upon termination the Education Agent will return to the {{ $org->training_organisation_name }} or destroy (at the direction of the {{ $org->training_organisation_name }}) all stocks of the {{ $org->training_organisation_name }}’s promotional material in the Education Agent’s possession at the end of the Agreement.</p>
									</li>
								</ol>
							</li>
						</ol>

					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 0px;"> Page 6 of 8</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 6 of 8 -->

<!-- Page 7 of 8 -->

<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 20px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/agent-agreement/images/vorx_logo.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Education Agent Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 20px;">

					<div class="content">
						<ol class="no-margin no-padding">
							<li class="no-index"></li>
							<li class="no-index"></li>
							<li class="no-index"></li>
							<li class="no-index"></li>
							<li class="no-index"></li>
							<li class="no-index"></li>
							<li class="no-index"></li>
							<li class="no-index"></li>
							<li class="no-index"></li>
							<li class="no-index">
								<ol class="no-padding">
									<li class="no-index"></li>
									<li class="no-index"></li>
									<li class="no-index"></li>
									<li class="no-index"></li>
									<li>
										<p class="px-12-font line-height-14px">Where Commission became payable prior to the end of the Agreement and has not been paid by {{ $org->training_organisation_name }}, the {{ $org->training_organisation_name }} will continue to pay the Education Agent any Commission or commission instalments payable after the termination of this Agreement as if the Agreement had not terminated. This does not apply where the {{ $org->training_organisation_name }} terminates the Agreement as provided in subsection 1.1 or where agreed by the parties in writing.</p>
									</li>
									<li>
										<p class="px-12-font line-height-14px">{{ $org->training_organisation_name }} will terminate this agreement immediately if any breach of this agreement occurs at any time and without written notice to Education Agent.</p>
									</li>
									<li>
										<p class="px-12-font line-height-14px">This Agreement shall expire after the stated termination date. The period of appointment shall be for 12 months, however, it may be renewed each year by signing a new document.</p>
									</li>
									<li>
										<p class="px-12-font line-height-14px">Both parties reserve the right to terminate the Agreement at any time by giving 30 days’ notice in writing, on the condition all monies to all parties are paid in full.</p>
									</li>
									<li>
										<p class="px-12-font line-height-14px">Upon termination of this agreement, the Education Agent must:.</p>
										<div class="clearfix" style="height: 5px;"></div>
										<div class="bullet-list">
											<div>Submit all applications and fees from prospective students received up to the termination date in which the Education Agent will not be entitled to receive any commission from {{ $org->training_organisation_name }}.</div>
											<div>Immediately cease using any advertising, promotional or other material supplied by {{ $org->training_organisation_name }} and return all material to {{ $org->training_organisation_name }} by registered mail or a reputable international courier.</div>
										</div>
									</li>
								</ol>
							</li>
							<li>
								<span class="proximanova-bold px-12-font">NOTICES</span>
								<div class="clearfix" style="height: 2px;"></div>
								<ol class="no-padding">
									<li>
										<p class="px-12-font line-height-14px">A notice under this Agreement must be in writing and sent by prepaid airmail, facsimile, or electronic mail to the party at the address set out below, or other changed / updated address notified under this clause.</p>
									</li>
									<li>
										<p class="px-12-font line-height-14px">A party changing its address, facsimile number or electronic mail address must give notice of that change to the other party.</p>
									</li>
									<li>
										<p class="px-12-font line-height-14px">Address for notices.</p>
									</li>
								</ol>
							</li>
						</ol>

						<div class="clearfix" style="height: 10px;"></div>
						<p class="proximanova-bold primary-font-color px-14-font">SCHEDULE 2</p>
						<p class="proximanova-bold px-12-font">Education Agent Monitoring</p>
						<div class="clearfix" style="height: 10px;"></div>
						<ol class="no-padding no-margin">
							<li>
								<p class="px-12-font line-height-14px">The performance of each Representative will be reviewed by annually using the Agent Performance Review Form.</p>
							</li>
							<li>
								<p class="px-12-font line-height-14px">The {{ $org->training_organisation_name }} will consider the performance of the Education Agent to decide whether to: </p>
								<div class="clearfix" style="height: 2px;"></div>
								<div class="bullet-list">
									<div>Maintain the Education Agent’s appointment;</div>
									<div>Appoint the Education Agent for a further term subject to certain conditions; or</div>
									<div>Terminate the Education Agent’s appointment.</div>
								</div>
							</li>
							<li>
								<p class="px-12-font line-height-14px">In considering the performance of the Education Agent under Item 2 {{ $org->training_organisation_name }} will consider: </p>
								<div class="clearfix" style="height: 2px;"></div>
								<div class="bullet-list">
									<div>the Education Agent's compliance with the Education Agent Agreement and any conditions placed on the Education Agent by {{ $org->training_organisation_name }};</div>
									<div>the Education Agent's compliance with the ESOS Act 2000 and National Code 2018;</div>
									<div>the number of Students the Education Agent has recruited and the conversion rate of:
										<div class="bullet-list unordered">
											<div>Student Applications to Offers; and </div>
											<div>Offers to actual enrolment of Students; </div>
										</div>
									</div>
									<div>the reasons why applications from potential Students did not proceed to Student enrolment status; </div>
									<div>the number of Student Visa refusals and Student Visa breaches for Students recruited by the Education Agent; </div>
									<div>any feedback or information from Students or third parties regarding the Education Agent; </div>
									<div>the quality, accuracy and currency of information and advice provided by the Education Agent to Students; and </div>
									<div>The quality of the appointment as assessed by {{ $org->training_organisation_name }}</div>
								</div>
							</li>
							<li>
								<p class="px-12-font line-height-14px">Education Agent survey will be done once every year by authorized office using the Education Agent appraisal form.</p>
							</li>
						</ol>

						<div class="clearfix" style="height: 10px;"></div>
						<p class="proximanova-bold primary-font-color px-14-font">AGENT DECLARATION:</p>
						<p class="px-12-font line-height-12px">I agree to the personal information being:</p>
						<div class="clearfix" style="height: 5px;"></div>
						<div class="bullet-list">
							<div>Recorded in PRISMS. This may include my name, business email address, phone number and address; accessed by the Australian Government Department of Education and Training, Department of Home Affairs (DHA) Protection and other Commonwealth agencies that access PRISMS;</div>
							<div>used to administer or monitor compliance with the Commonwealth legislation e.g. Education Services for Overseas Students Act 2000, Migration Act 1958; and</div>
							<div>Disclosed by the Australian Government Department of Education and Training to other Australian Government entities (including, but not limited to ASQA and TEQSA), education institutions and publically. The Australian Government Department of Education and Training will share individual agents’ performance publically as aggregated data (but will not identify agent – provider relationships). Agent-provider relationships will only be identified when data is shared with education providers and other Australian Government entities</div>
						</div>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-12-font line-height-14px">I also agree to personal information that Australian Government Department of Education and Training currently hold in PRISMS regarding myself and any other personal information that the department may collect in future being disclosed as described above. </p>

						<div class="clearfix" style="height: 10px;"></div>
						<p class="proximanova-bold primary-font-color px-14-font">PROVIDER DECLARATION:</p>
						<p class="px-12-font line-height-12px">I declare that {{ $org->training_organisation_name }} has taken reasonable steps to notify our education agents of the matters contained in Australian Privacy Principle.</p>
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 0px;"> Page 7 of 8</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 7 of 8 -->

<!-- Page 8 of 8-->

<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 20px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/agent-agreement/images/vorx_logo.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Education Agent Agreement</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 20px;">

					<div class="content">
						<p class="proximanova-bold primary-font-color px-14-font">{{ $org->training_organisation_name }} DETAILS</p>
						<div class="clearfix" style="height: 5px;"></div>
						<table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="25%" class="primary-bg-color white-font-color px-12-font proximanova-bold">Company Name:</td>
								<td width="75%" class="px-12-font">Phoenix College of Australia</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Address:</td>
								<td class="px-12-font">1/11-15 Rocklea Drive Port Melbourne, Victoria 3207.</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Phone Number:</td>
								<td class="px-12-font">0452209610</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">ABN:</td>
								<td class="px-12-font">75638913550</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">CRICOS Number:</td>
								<td class="px-12-font">03871F</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">RTO (TOID) Number:</td>
								<td class="px-12-font">45633</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Email:</td>
								<td class="px-12-font">phoenixcollegeaustralia@gmail.com</td>
							</tr>
						</table>
						<div class="clearfix" style="height: 15px;"></div>
						<p class="proximanova-bold primary-font-color px-14-font">EDUCATION AGENT DETAILS</p>
						<div class="clearfix" style="height: 5px;"></div>
						<table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="25%" class="primary-bg-color white-font-color px-12-font proximanova-bold">Name of the company:</td>
								<td width="75%" class="px-12-font">{{$detail->company_name}}</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">ABN:</td>
								<td class="px-12-font">
                                    @if(isset($app_form['abn']) && $app_form['abn'] != null)
                                        {{$app_form['abn']}}
                                    @endif
                                </td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Director/MD/CEO:</td>
								<td class="px-12-font">
                                    {{$detail->agent_name}}
                                </td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Address:</td>
								<td class="px-12-font">
                                    {{$detail->office_address}}
                                </td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Email (Director/MD/CEO):</td>
								<td class="px-12-font">
                                    {{$detail->email}}
                                </td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Facsimile Number:</td>
								<td class="px-12-font">
                                    {{$detail->fax_number}}
                                </td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Mobile No. (Director/MD/CEO):</td>
								<td class="px-12-font">
                                    {{$detail->mobile}}
                                </td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Phone Number:</td>
								<td class="px-12-font">
                                    {{$detail->phone}}
                                </td>
							</tr>
						</table>

						<div class="clearfix" style="height: 15px;"></div>
						<p class="proximanova-bold primary-font-color px-14-font">SIGNATORIES</p>
						<div class="clearfix" style="height: 5px;"></div>

						<table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td rowspan="6" width="50%" class="text-center"><span class="proximanova-bold">SIGNED</span> for {{ $org->training_organisation_name }} by an authorised officer</td>
								<td width="50%" class="px-12-font text-center" style="height: 50px;" >
                                    <div class="type-signature px-18-font" style="margin-top: -12px;">Karan Partap Singh Saini</div>
                                </td>
							</tr>
							<tr>
								<td class="text-center px-12-font">Signature of Officer</td>
							</tr>
							<tr>
								<td class="text-center" style="height: 50px;">
									<p class="proximanova-bold px-12-font">Karan Partap Singh Saini</p>
								</td>
							</tr>
							<tr>
								<td class="text-center px-12-font">Name of officer</td>
							</tr>
							<tr>
								<td class="text-center" style="height: 50px;">
									<p class="proximanova-bold px-12-font">Marketing Officer</p>
								</td>
							</tr>
							<tr>
								<td class="text-center px-12-font">Office held</td>
							</tr>
						</table>

						<div class="clearfix" style="height: 15px;"></div>

						<table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td rowspan="6" width="50%" class="text-center"><span class="proximanova-bold">SIGNED</span> for <span class="proximanova-bold">“EDUCATION AGENT”</span>. by an authorised officer</td>
								<td width="50%" class="px-12-font text-center" style="height: 50px;">
								<div class="type-signature px-18-font" style="margin-top: -12px;">
								@if($signed == true)
									{{$detail->agent_name}}
								@endif
								</div>
								</td>
							</tr>
							<tr>
								<td class="text-center px-12-font">Signature of Officer</td>
							</tr>
							<tr>
								<td class="text-center" style="height: 50px;">
									<p class="proximanova-bold px-12-font">
									@if($signed == true)
										{{$detail->agent_name}}
									@endif
									</p>
								</td>
							</tr>
							<tr>
								<td class="text-center px-12-font">Name of officer</td>
							</tr>
							<tr>
								<td class="text-center" style="height: 50px;">
									<p class="proximanova-bold px-12-font">
									@if($signed == true)
										Marketing Officer
									@endif
									</p>
								</td>
							</tr>
							<tr>
								<td class="text-center px-12-font">Office held</td>
							</tr>
						</table>

					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 0px;"> Page 8 of 8</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 8 of 8 -->

</html>