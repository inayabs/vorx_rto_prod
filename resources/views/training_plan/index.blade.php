<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	@if(config('app.name') != 'Phoenix')
	<link type="text/css" href="{{public_path()}}/cea-lln-test-form/pdf-style.css" rel="stylesheet" />
	@else
	<link type="text/css" href="{{public_path()}}/custom/pca-offer-letter-and-enrolment-acceptance-agreement/training-plan-pdf-style.css" rel="stylesheet" />
	@endif
	<title>Training Plan</title>
	<!-- Page 1 of 1 -->

<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="eti-logo">
									<img src="{{$logo_url}}" alt="">
								</div>
							</td>
							<td width="80%">
								<!-- <p class="primary-font-color px-12-font text-right line-height-1point2">Certificate 3 Guarantee Program</p> -->
								<p class="secondary-font-color px-16-font text-right line-height-1point2">Training Plan</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<div class="content">
						<h1 class="section-header proximanova-bold primary-font-color px-12-font text-justify text-uppercase"></h1>
                        <br>
                        <p class="px-11-font text-justify line-height-1point2"><span class="proximanova-bold primary-font-color">Information:</span> Please read and understand the following information before signing this document.</p>
                        <p class="px-11-font text-justify line-height-1point2"><span class="proximanova-bold primary-font-color">What is a Training Plan?</span> </p>
						<ul class="px-10-font text-justify no-margin paragraph-list">
							<li class="line-height-1point2">The Training Plan describes what training is to be undertaken and outlines who provides the training.</li>
							<li class="line-height-1point2">The Training Plan outlines how, when and where training will be delivered.</li>
							<li class="line-height-1point2">The Training Plan outlines how the assessments will occur and when the student is deemed competent.</li>
							<li class="line-height-1point2">The Training Plan is developed and maintained by the RTO and a copy is given to student.</li>
							<li class="line-height-1point2">The Training Plan is a working document to be used for the duration of the course and regularly updated.</li>
							<li class="line-height-1point2">The Training Plan is a living document that is intended to reflect the current status of the student’s training.</li>
							<li class="line-height-1point2">Student is to be provided with an updated copy of the Training Plan by the RTO.</li>
							<li class="line-height-1point2">The delivering RTO must comply with relevant national standards and relevant state training authority legislation, policies and procedures.</li>
							<li class="line-height-1point2">The RTO is to ensure the student understands the tasks that need to be undertaken to support the development and achievement of competency in the workplace/simulated environment for each unit within the Training Plan.</li>
							<li class="line-height-1point2">The Training Plan will be used as part of any review of training arrangements.</li>
                        </ul>
                        <br>
						<p class="px-11-font text-justify line-height-1point2"><span class="proximanova-bold primary-font-color">Responsibilities</span> </p>
						<table class="table default-bordered-table" cellspacing="0" cellpadding="0" width="100%">
							<thead>
								<tr>
									<th>Student responsibilities include, but are not limited to:</th>
									<th>The RTO’s responsibilities include, but are not limited to:</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="50%" valign="top">
                                        <ul class="px-10-font text-justify no-margin paragraph-list">
                                            <li class="line-height-1point2">Undertaking all training and assessment contained in this Training Plan</li>
                                            <li class="line-height-1point2">Working with the RTO to achieve competence in required skills.</li>
                                            <li class="line-height-1point2">Follow the policies and procedures of the RTO.</li>
                                        </ul>
                                    </td>
									<td width="50%" valign="top">
                                        <ul class="px-10-font text-justify no-margin paragraph-list">
                                            <li class="line-height-1point2">Providing training and assessment in accordance with this Training Plan</li>
                                            <li class="line-height-1point2">Ensuring that the student is updated on progress against the training plan</li>
                                            <li class="line-height-1point2">Notifying the student and the state training authority regarding any issues that may affect successful completion of the Training Contract.</li>
                                            <li class="line-height-1point2">Explaining and offering Recognition of Prior Learning (RPL) and credit transfer to the student.</li>
                                            <li class="line-height-1point2">Ensuring that in developing the training plan the assessment tasks and methods have been discussed and explained to the student.</li>
                                            <li class="line-height-1point2">Providing the student with details of how they access the RTO’s Complains and appeals policies and Procedures.</li>
                                            <li class="line-height-1point2">Make sure that students get quality of training and assessment. </li>
                                            <li class="line-height-1point2">Reasonable adjustment in training and assessment according to the policy and procedures.</li>
                                            <li class="line-height-1point2">Make sure that the students have got access to student handbook and other pre-enrolment information so that the student takes informed decision.</li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                            <thead>
                                <tr>
                                    <th class=" px-12-font white-font-color" colspan="2">Support Services</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
									<td colspan="2" valign="top">
                                        <ul class="px-10-font text-justify no-margin paragraph-list">
                                            <li class="line-height-1point2" style="padding:5px 0;">
                                                <label class="label-regular label-textbox dark-grey-font-color">Does the student has any special needs?
                                                    <span class="checkbox "><label class="label label-checkbox">YES </label></span>   
                                                    <span class="checkbox"><label class="label label-checkbox">NO. </label></span>
                                                    <label class="label-regular label-textbox">If yes, please specify <div class="text-input-line" style="width: 40%;margin-top:-5px;position:absolute;"> <span class="dark-grey-font-color line-height-1point2"></span></div></label>
												</label>
												<br>
                                            </li>
                                            <li class="line-height-1point2" style="padding:5px 0;">
                                                <label class="label-regular label-textbox dark-grey-font-color">Does the student require alternative methods of training and assessment?
                                                    <span class="checkbox "><label class="label label-checkbox">YES </label></span>   
                                                    <span class="checkbox"><label class="label label-checkbox">NO. </label></span>
                                                    <label class="label-regular label-textbox">If yes, please specify <div class="text-input-line" style="width: 40%;margin-top:-5px;position:absolute;"><span class="dark-grey-font-color line-height-1point2"></span></div></label>
												</label>
												<br>
                                            </li>
                                            <li class="line-height-1point2" style="padding:5px 0;">
                                                <label class="label-regular label-textbox dark-grey-font-color">What other support services are required by the Student?
                                                    <span class="checkbox "><label class="label label-checkbox">YES </label></span>   
                                                    <span class="checkbox"><label class="label label-checkbox">NO. </label></span>
                                                    <label class="label-regular label-textbox">If yes, please specify <div class="text-input-line" style="width: 40%;margin-top:-5px;position:absolute;"><span class="dark-grey-font-color line-height-1point2"></span></div></label>
												</label>
												<br>
                                            </li>
                                        </ul>
                                    </td>
								</tr>
                            </tbody>
						</table>

					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
                        <!-- <p>Warning - Uncontrolled when printed</p> -->
						<p style="margin-bottom: 2px;">© Phoenix College of Australia | Version 1.1 | RTO No. 45633 </p>
						<p class="">Page 1 of {{ count($data['program_details']) + 2 }}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 1 of 1 -->
@foreach ($data['program_details'] as $key=>$item)
	<body class="exo2-regular position-relative">
		<div>
			<div class="col-xs-12 no-padding position-relative">
				<div class="pdf-wrapper">
					<div style="padding-bottom: 10px;  margin: 0 10px;">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="20%">
									<div class="eti-logo">
										<img src="{{$logo_url}}" alt="">
									</div>
								</td>
								<td width="80%">
									<!-- <p class="primary-font-color px-12-font text-right line-height-1point2">Certificate 3 Guarantee Program</p> -->
									<p class="secondary-font-color px-16-font text-right line-height-1point2">Training Plan</p>
								</td>
							</tr>
						</table>
					</div>
					<div class="clearfix"></div>
					<div style="padding-bottom: 10px;  margin: 0 10px;">
						<div class="content">
							<h1 class="section-header proximanova-bold primary-font-color px-12-font text-justify text-uppercase"></h1>
							<br>
							@if ($key == 0)
							<p class="px-11-font text-justify line-height-1point2"><span class="proximanova-bold primary-font-color">RTO Information</span> </p>
								<table width="100%" class="boxtype-form-table">
									<tbody>
										<tr>	
											<td class="text-left primary-bg-color text-left" width="15%"><span class=" white-font-color">RTO Code:</span></td>
											<td class="text-left" width="20%">{{ $com_setting->training_organisation_id }}  </td>
											<td class="text-left primary-bg-color text-left" width="15%"><span class=" white-font-color">RTO Name:</span></td>
										<td class="text-left" width="35%">{{ $com_setting->training_organisation_name }}</td>
											<td class="text-left primary-bg-color text-left" width="15%"><span class=" white-font-color">Phone Number:</span></td>
											<td class="text-left" width="25%">{{ $com_setting->telephone_number }}</td>
										</tr>
										<tr>	
											<td class="text-left primary-bg-color text-left" width="20%"><span class=" white-font-color">Name of contact person:</span></td>
											<td class="text-left" width="20%">{{ $com_setting->contact_name }} </td>
											<td class="text-left primary-bg-color text-left" width="20%"><span class=" white-font-color">Address:</span></td>
											<td class="text-left" width="30%">{{ $com_setting->addr_line1 }}</td>
											<td class="text-left primary-bg-color text-left" width="20%"><span class=" white-font-color">Email address:</span></td>
											<td class="text-left" width="35%">{{ $com_setting->email_address }}</td>
										</tr>
									</tbody>
								</table>
								<br>


								<p class="px-11-font text-justify line-height-1point2"><span class="proximanova-bold primary-font-color">PERSONAL INFORMATION AND STUDENT SUMMARY</span> <i>( Please review your training plan and sign on the following page. )</i></p>
								<table width="100%" class="boxtype-form-table">
									<tbody>
										<tr>	
											<td class="text-left primary-bg-color text-left" width="15%"><span class=" white-font-color">Student Name:</span></td>
											<td class="text-left"  width="25%">{{ $data['name'] }}  </td>
											<td class="text-left primary-bg-color text-left"  width="15%"><span class=" white-font-color">Phone No.:</span></td>
											<td class="text-left" width="25%">{{$data['phone_no']}}  </td>
											<td class="text-left primary-bg-color text-left"  width="15%"><span class=" white-font-color">Email Address:</span></td>
											<td class="text-left" width="25%">{{$data['email_ad']}} </td>
										</tr>
									</tbody>
								</table>
								<table width="100%" class="boxtype-form-table">
									<tbody>
										<tr>	
											<td class="text-left primary-bg-color text-left" width="15%"><span class=" white-font-color">Special needs identified:</span></td>
											<td class="text-left" width="12%"> 	
												<span class="checkbox "><label class="label label-checkbox dark-grey-font-color">YES </label></span>   
												<span class="checkbox"><label class="label label-checkbox dark-grey-font-color">NO </label></span> 
											</td>
											<td class="text-left primary-bg-color text-left" width="12%"><span class=" white-font-color">LLN test outcome:</span></td>
											<td class="text-left" width="45%">
												<span class="checkbox "><label class="label-regular label-checkbox dark-grey-font-color">Meets the entry requirements </label></span>   
												<span class="checkbox"><label class="label-regular label-checkbox dark-grey-font-color">Does not meet Entry requirement </label></span> 
											</td>
											<td class="text-left primary-bg-color text-left" width="15%"><span class=" white-font-color">RPL/Credit Transfer:</span></td>
											<td class="text-left" width="12%">
												<span class="checkbox "><label class="label label-checkbox dark-grey-font-color">YES </label></span>   
												<span class="checkbox"><label class="label label-checkbox dark-grey-font-color">NO </label></span> 
											</td>
										</tr>
									</tbody>
								</table>	
								<br>
								<p class="px-11-font text-justify line-height-1point2"><span class="proximanova-bold primary-font-color">COURSE INFORMATION</span></p>
								<table width="100%" class="boxtype-form-table">
									<tbody>
										<tr>	
											<td class="text-left primary-bg-color text-left" width="15%"><span class=" white-font-color">Course Code:</span></td>
										<td class="text-left"  width="15%">{{ $data['course_code'] }}</td>
											<td class="text-left primary-bg-color text-left"  width="15%"><span class=" white-font-color">Course Name:</span></td>
											<td class="text-left" width="40%">{{ $data['course_name'] }}  </td>
											<td class="text-left primary-bg-color text-left"  width="15%"><span class=" white-font-color">Delivery Mode:</span></td>
										<td class="text-left" width="15%">{{ $data['delivery_mode'] }}</td>
											<td class="text-left primary-bg-color text-left"  width="15%"><span class=" white-font-color">Location:</span></td>
										<td class="text-left" width="15%">{{ $data['location'] }}</td>
										</tr>
									</tbody>
								</table>
								<table width="100%" class="boxtype-form-table">
									<tbody>
										<tr>	
											<td class="text-left primary-bg-color text-left" width="15%"><span class=" white-font-color">Trainer/Assessor:</span></td>
											<td class="text-left"  width="25%"></td>
											<td class="text-left primary-bg-color text-left"  width="15%"><span class=" white-font-color">Proposed Commencement Date:</span></td>
										<td class="text-left" width="25%">{{ $data['start_date'] }}</td>
											<td class="text-left primary-bg-color text-left"  width="15%"><span class=" white-font-color">Proposed Completion on Date:</span></td>
											<td class="text-left" width="25%">{{ $data['end_date'] }}</td>
										</tr>
									</tbody>
								</table>
							@endif
							<br>
							<p class="px-11-font text-justify line-height-1point2"><span class="proximanova-bold primary-font-color">TRAINING SCHEDULE</span></p>
							<table class="table default-bordered-table" cellspacing="0" cellpadding="0" width="100%">
								<thead>
									<tr>
										<th class="text-center">Unit code and name (All core units)</th>
										<th class="text-center">Proposed Commencement date</th>
										<th class="text-center">Proposed completion date</th>
										<th class="text-center">Assessment method</th>
										<th class="text-center">Actual Commencement Date</th>
										<th class="text-center">Actual Completion  Date</th>
										<th class="text-center">Student status</th>
										<th class="text-center">Assessment Outcome</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($item as $details)
									<tr>
										<td> {{ $details['code'] }} - {{ $details['name'] }} </td>
										<td>{{ $details['start_date'] }}</td>
										<td>{{ $details['end_date'] }}</td>
										<td>{{ $details['assestment_method'] }}</td>
										<td>{{ $details['actual_start'] }}</td>
										<td>{{ $details['actual_end'] }}</td>
										<td> {{ $details['student_status'] }} </td>
										<td> {{ $details['assestment_status'] }}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="footer bottom-placement px-10-font text-center blue-font-color">
							<!-- <p>Warning - Uncontrolled when printed</p> -->
							<p style="margin-bottom: 2px;">© Phoenix College of Australia | Version 1.1 | RTO No. 45633 </p>
							<p class="">Page {{ $loop->iteration + 1 }} of {{ $loop->count + 2 }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
	@if ($loop->last)
	
<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="eti-logo">
									<img src="{{$logo_url}}" alt="">
								</div>
							</td>
							<td width="80%">
								<!-- <p class="primary-font-color px-12-font text-right line-height-1point2">Certificate 3 Guarantee Program</p> -->
								<p class="secondary-font-color px-16-font text-right line-height-1point2">Training Plan</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<div class="content">
						<h1 class="section-header proximanova-bold primary-font-color px-12-font text-justify text-uppercase"></h1>
                        <br>
						<table width="100%" class="boxtype-form-table">
							<tbody>
								<tr>	
									<td class="text-left primary-bg-color text-left" width="15%"><span class=" white-font-color">Student Full Name:</span></td>
									<td class="text-left" width="35%">{{ $data['name'] }} </td>
									<td class="text-left primary-bg-color text-left" width="15%"><span class=" white-font-color">CEA’s Representative Full Name:</span></td>
									<td class="text-left" width="35%">Community Education Australia   </td>
								</tr>
								<tr>	
									<td class="text-left primary-bg-color text-left" width="15%" height="60px"><span class=" white-font-color">Signature:</span></td>
									<td class="text-left" width="35%" height="60px"></td>
									<td class="text-left primary-bg-color text-left" width="15%" height="60px"><span class=" white-font-color">Signature:</span></td>
									<td class="text-left" width="35%" height="60px"></td>
								</tr>
								<tr>	
									<td class="text-left primary-bg-color text-left" width="15%"><span class=" white-font-color">Date:</span></td>
									<td class="text-left" width="35%">{{ Carbon\Carbon::now()->format('d/m/Y') }}</td>
									<td class="text-left primary-bg-color text-left" width="15%"><span class=" white-font-color">Date:</span></td>
									<td class="text-left" width="35%">{{ Carbon\Carbon::now()->format('d/m/Y') }}</td>
								</tr>
							</tbody>
						</table>
						<br>
						<p class="px-14-font text-justify line-height-1point2"><span class="proximanova-bold primary-font-color">LEGEND:</span></p>
						<table width="100%" class="boxtype-form-table">
							<tbody>
								<tr>	
									<td class="text-left secondary-bg-color text-center" width="15%"><span class=" white-font-color">Training Method</span></td>
									<td class="text-left" width="35%">
										<ul class="px-10-font text-justify no-margin list-unstyled">
											<li class="line-height-1point2">A: Face to face Classroom Based delivery with self-paced learning as instructed by Trainer/Assessor</li>
											<li class="line-height-1point2">B: Special needs support e.g. language, literacy and Numeracy</li>
											<li class="line-height-1point2">C:  Distance learning</li>
										</ul>
									</td>
									<td class="text-left secondary-bg-color text-center" width="15%"><span class=" white-font-color">Assessment Method</span></td>
									<td class="text-left" width="35%">
										<ul class="px-10-font text-justify no-margin list-unstyled">
											<li class="line-height-1point2">1. Written Questions</li>
											<li class="line-height-1point2">2. Practical tasks / Role-play/presentation/Report Writing</li>
											<li class="line-height-1point2">3. Credit Transfer</li>
											<li class="line-height-1point2">4. RPL</li>
											<li class="line-height-1point2">5. Other</li>
										</ul>	
									</td>
								</tr>
								<tr>	
									<td class="text-left secondary-bg-color text-center" width="15%"><span class=" white-font-color">Assessment Outcome </span></td>
									<td class="text-left" width="35%">
										<ul class="px-10-font text-justify no-margin list-unstyled">
											<li class="line-height-1point2">C: Competent </li>
											<li class="line-height-1point2">NYC: Not Yet Competent</li>
											<li class="line-height-1point2">“CT” or “RPL” Where Credit Transfer or RPL occurs</li>
										</ul>
									</td>
									<td class="text-left secondary-bg-color text-center" width="15%"><span class=" white-font-color">Student Status </span></td>
									<td class="text-left" width="35%">
										<ul class="px-10-font text-justify no-margin list-unstyled">
											<li class="line-height-1point2">D: Deferred</li>
											<li class="line-height-1point2">E: Extended	</li>
											<li class="line-height-1point2">CX: Cancelled</li>
											<li class="line-height-1point2">C: Completed</li>
											<li class="line-height-1point2">WD: Withdrawn</li>
										</ul>	 
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<!-- <p>Warning - Uncontrolled when printed</p> -->
						<p style="margin-bottom: 2px;">© Phoenix College of Australia | Version 1.1 | RTO No. 45633 </p>
					<p class="">Page {{ $loop->count + 2 }} of {{ $loop->count + 2 }}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
		
	@endif
@endforeach

<!-- End Page 1 of 1 -->
{{-- 
<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="eti-logo">
									<img src="{{$logo_url}}" alt="">
								</div>
							</td>
							<td width="80%">
								<!-- <p class="primary-font-color px-12-font text-right line-height-1point2">Certificate 3 Guarantee Program</p> -->
								<p class="secondary-font-color px-16-font text-right line-height-1point2">Training Plan</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<div class="content">
						<h1 class="section-header proximanova-bold primary-font-color px-12-font text-justify text-uppercase"></h1>
                        <br>
						<table class="table default-bordered-table" cellspacing="0" cellpadding="0" width="100%">
							<thead>
								<tr>
									<th class="text-center">Unit code and name (All core units)</th>
									<th class="text-center">Proposed Commencement date</th>
									<th class="text-center">Proposed completion date</th>
									<th class="text-center">Assessment method</th>
									<th class="text-center">Actual Commencement Date</th>
									<th class="text-center">Actual Completion  Date</th>
									<th class="text-center">Student status</th>
									<th class="text-center">Assessment Outcome</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="25%"> CPPSEC2101 Apply effective communication skills to maintain security</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center">1,2</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
								</tr>
								<tr>
									<td width="25%"> Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center">1,2</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
								</tr>
								<tr>
									<td width="25%"> Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center">1,2</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
								</tr>
								<tr>
									<td width="25%"> Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center">1,2</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
								</tr>
								<tr>
									<td width="25%"> Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center">1,2</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
								</tr>
								<tr>
									<td width="25%"> Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center">1,2</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
								</tr>
								<tr>
									<td width="25%"> Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center">1,2</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
								</tr>
								<tr>
									<td width="25%"> Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center">1,2</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
								</tr>
								<tr>
									<td width="25%"> Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center">1,2</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
								</tr>
								<tr>
									<td width="25%"> Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center">1,2</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
								</tr>
								<tr>
									<td width="25%"> Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center">1,2</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
								</tr>
								<tr>
									<td width="25%"> Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center">1,2</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
								</tr>
								<tr>
									<td width="25%"> Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center">1,2</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<!-- <p>Warning - Uncontrolled when printed</p> -->
						<p style="margin-bottom: 2px;">© Community Education Australia | Version 1.1 | RTO No. 6074 </p>
						<p class="">Page 3 of 5</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 1 of 1 -->

<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="eti-logo">
									<img src="{{$logo_url}}" alt="">
								</div>
							</td>
							<td width="80%">
								<!-- <p class="primary-font-color px-12-font text-right line-height-1point2">Certificate 3 Guarantee Program</p> -->
								<p class="secondary-font-color px-16-font text-right line-height-1point2">Training Plan</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<div class="content">
						<h1 class="section-header proximanova-bold primary-font-color px-12-font text-justify text-uppercase"></h1>
                        <br>
						<table class="table default-bordered-table" cellspacing="0" cellpadding="0" width="100%">
							<thead>
								<tr>
									<th class="text-center">Unit code and name (All core units)</th>
									<th class="text-center">Proposed Commencement date</th>
									<th class="text-center">Proposed completion date</th>
									<th class="text-center">Assessment method</th>
									<th class="text-center">Actual Commencement Date</th>
									<th class="text-center">Actual Completion  Date</th>
									<th class="text-center">Student status</th>
									<th class="text-center">Assessment Outcome</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="25%"> CPPSEC2101 Apply effective communication skills to maintain security</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center">1,2</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
								</tr>
								<tr>
									<td width="25%"> Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center">1,2</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
								</tr>
								<tr>
									<td width="25%"> Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center">1,2</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
								</tr>
								<tr>
									<td width="25%"> Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center">1,2</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
								</tr>
								<tr>
									<td width="25%"> Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center">1,2</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
								</tr>
							</tbody>
						</table>
						<table>
							<tr>
								<td width="50" style="padding:0 30px" valign="top">
									<p class="px-11-font text-justify line-height-1point2">TRAINING PLAN AGREEMENT AND DECLARATION</p>
									<div class="clearfix" style="height:10px"></div>
									<p class="px-11-font text-justify line-height-1point2">This document forms a legally binding agreement between the Student and Community Education Australia leading to a nationally recognized qualification, i.e. Certificate II in Security Operations (CPP20218). In signing this Agreement both parties are bound by the obligations detailed in this document and the legislation of the State or Territory in which this Agreement is to be registered.</p>
									<div class="clearfix" style="height:10px"></div>
									<p class="px-11-font text-justify line-height-1point2">I/We declare that to the best of our knowledge the details entered on this Training Plan are true and correct. We understand that giving of false or misleading information is a serious offence. We, the undersigned, have participated in the negotiation and development of the training plan discussed, understand and are satisfied with the Training Plan arrangements to support and deliver the </p>

								</td>
								<td width="50" style="padding:0 30px" valign="top">
									<div class="clearfix" style="height:23px"></div>
									<p class="px-11-font text-justify line-height-1point2">required training. RPL and credit transfer arrangements have been explained to the student, the RTO, and, where applicable, offered to the student. We understand and support how the training and assessment will happen. We are also aware of the relevant state training legislation and RTO compliance requirements. All parties agree that the RTO has provided full details of how to access the RTO training and assessment dispute mechanism. This document is effective only when all required signatures have been collected.</p>
								</td>
							</tr>
						</table>
					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<!-- <p>Warning - Uncontrolled when printed</p> -->
						<p style="margin-bottom: 2px;">© Community Education Australia | Version 1.1 | RTO No. 6074 </p>
						<p class="">Page 4 of 5</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 1 of 1 -->

<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="eti-logo">
									<img src="{{$logo_url}}" alt="">
								</div>
							</td>
							<td width="80%">
								<!-- <p class="primary-font-color px-12-font text-right line-height-1point2">Certificate 3 Guarantee Program</p> -->
								<p class="secondary-font-color px-16-font text-right line-height-1point2">Training Plan</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<div class="content">
						<h1 class="section-header proximanova-bold primary-font-color px-12-font text-justify text-uppercase"></h1>
                        <br>
						<table width="100%" class="boxtype-form-table">
							<tbody>
								<tr>	
									<td class="text-left primary-bg-color text-left" width="15%"><span class=" white-font-color">Student Full Name:</span></td>
									<td class="text-left" width="35%"> </td>
									<td class="text-left primary-bg-color text-left" width="15%"><span class=" white-font-color">CEA’s Representative Full Name:</span></td>
									<td class="text-left" width="35%">Community Education Australia   </td>
								</tr>
								<tr>	
									<td class="text-left primary-bg-color text-left" width="15%" height="60px"><span class=" white-font-color">Signature:</span></td>
									<td class="text-left" width="35%" height="60px"></td>
									<td class="text-left primary-bg-color text-left" width="15%" height="60px"><span class=" white-font-color">Signature:</span></td>
									<td class="text-left" width="35%" height="60px"></td>
								</tr>
								<tr>	
									<td class="text-left primary-bg-color text-left" width="15%"><span class=" white-font-color">Date:</span></td>
									<td class="text-left" width="35%"></td>
									<td class="text-left primary-bg-color text-left" width="15%"><span class=" white-font-color">Date:</span></td>
									<td class="text-left" width="35%"></td>
								</tr>
							</tbody>
						</table>
						<br>
						<p class="px-14-font text-justify line-height-1point2"><span class="proximanova-bold primary-font-color">LEGEND:</span></p>
						<table width="100%" class="boxtype-form-table">
							<tbody>
								<tr>	
									<td class="text-left secondary-bg-color text-center" width="15%"><span class=" white-font-color">Training Method</span></td>
									<td class="text-left" width="35%">
										<ul class="px-10-font text-justify no-margin list-unstyled">
											<li class="line-height-1point2">A: Face to face Classroom Based delivery with self-paced learning as instructed by Trainer/Assessor</li>
											<li class="line-height-1point2">B: Special needs support e.g. language, literacy and Numeracy</li>
											<li class="line-height-1point2">C:  Distance learning</li>
										</ul>
									</td>
									<td class="text-left secondary-bg-color text-center" width="15%"><span class=" white-font-color">Assessment Method</span></td>
									<td class="text-left" width="35%">
										<ul class="px-10-font text-justify no-margin list-unstyled">
											<li class="line-height-1point2">1. Written Questions</li>
											<li class="line-height-1point2">2. Practical tasks / Role-play/presentation/Report Writing</li>
											<li class="line-height-1point2">3. Credit Transfer</li>
											<li class="line-height-1point2">4. RPL</li>
											<li class="line-height-1point2">5. Other</li>
										</ul>	
									</td>
								</tr>
								<tr>	
									<td class="text-left secondary-bg-color text-center" width="15%"><span class=" white-font-color">Assessment Outcome </span></td>
									<td class="text-left" width="35%">
										<ul class="px-10-font text-justify no-margin list-unstyled">
											<li class="line-height-1point2">C: Competent </li>
											<li class="line-height-1point2">NYC: Not Yet Competent</li>
											<li class="line-height-1point2">“CT” or “RPL” Where Credit Transfer or RPL occurs</li>
										</ul>
									</td>
									<td class="text-left secondary-bg-color text-center" width="15%"><span class=" white-font-color">Student Status </span></td>
									<td class="text-left" width="35%">
										<ul class="px-10-font text-justify no-margin list-unstyled">
											<li class="line-height-1point2">D: Deferred</li>
											<li class="line-height-1point2">E: Extended	</li>
											<li class="line-height-1point2">CX: Cancelled</li>
											<li class="line-height-1point2">C: Completed</li>
											<li class="line-height-1point2">WD: Withdrawn</li>
										</ul>	
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<!-- <p>Warning - Uncontrolled when printed</p> -->
						<p style="margin-bottom: 2px;">© Community Education Australia | Version 1.1 | RTO No. 6074 </p>
						<p class="">Page 5 of 5</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 1 of 1 --> --}}
</html>