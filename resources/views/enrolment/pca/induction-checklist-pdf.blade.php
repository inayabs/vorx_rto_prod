<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" href="{{public_path()}}/custom/pca-enrolment/pdf-style.css" rel="stylesheet" />
	<title>Student Induction Checklist</title>
	<style>
		.table-bordered tbody tr td{padding:3px 5px;}
	</style>
</head>
<!-- Page 1 of 1 -->
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
								<p class="primary-font-color proximanova-bold px-24-font text-right line-height-1">Student Induction Checklist <br> (International Students)</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix" style="height:20px;"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content" style="position: relative; width: 100%; height: 180px;">
						<table width="100%" cellpadding="0" cellspacing="0" border="0" class="table-bordered table">
							<tbody>
								<tr>
									<td colspan="4" class="peach-bg-color ">
										Student’s Details
									</td>
								</tr>
								<tr>
									<td class="peach-bg-color right-border" width="20%" valign="middle">
										Student Name
									</td>
									<td colspan="3">
										{{ isset($inputs['student_name']) ? $inputs['student_name'] : '' }}
									</td>
								</tr>
								<tr>
									<td width="20%" valign="middle" class="peach-bg-color right-border">
										Student ID
									</td>
									<td width="30%" valign="middle" class="right-border">
									{{ isset($inputs['student_id']) ? $inputs['student_id'] : '' }}
									</td>
									<td width="20%" valign="middle" class="peach-bg-color right-border">
										Date of Birth
									</td>
									<td width="30%" valign="middle">
									{{ isset($inputs['date_of_birth']) ? \Carbon\Carbon::parse($inputs['date_of_birth'])->timezone('Australia/Melbourne')->format('d / m / Y') : '' }}
									</td>
								</tr>
								<tr>
									<td class="peach-bg-color right-border" width="20%" valign="middle">
										Course code and Name
									</td>
									<td colspan="3">
									{{ isset($inputs['course']['name']) ? $inputs['course']['name'] : '' }}
									</td>
								</tr>
							</tbody>
						</table>
						<div class="clearfix" style="height:10px;"></div>
						<table width="100%" cellpadding="0" cellspacing="0" border="0" class="table-bordered table">
							<tbody>
							<tr>
								<td width="40%" class="peach-bg-color right-border">Information</td>
								<td width="10%" class="peach-bg-color right-border">Student Initials</td>
								<td width="40%" class="peach-bg-color right-border">Information</td>
								<td width="10%" class="peach-bg-color">Student Initials</td>
							</tr>
							<tr>
								<td valign="top" class="right-border">
								Course/module information
                                        <ul>
                                            <li>Introduction   of   key   teaching   and support staff</li>
                                            <li>Course outline</li>
                                            <li>Training and Assessment Strategies Competency based training and assessment</li>
                                            <li>Duration and Timetables provided</li>
                                            <li>Assessment outcomes and student certificates upon completion</li>
                                        </ul>
								</td>
								<td valign="middle" class="right-border" style="padding-left:40%;">
									<div class="checkbox {{isset($inputs['information-0']) && in_array($inputs['information-0'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> </label></div>
								</td>
								<td valign="top" class="right-border"> Work Health and Safety Procedures 
                                        <ul>
                                            <li>Evacuation procedures explained</li>
                                            <li>Emergency exits clear</li>
                                            <li>Location/access to First Aid Kit</li>
										</ul>
								</td>
								<td valign="middle" style="padding-left:40%;">
									<div class="checkbox {{isset($inputs['information-1']) && in_array($inputs['information-1'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> </label></div>
								</td>
							</tr>
							<tr>
								<td valign="top" class="right-border">
								Location of
                                        <ul>
                                            <li>Classrooms</li>
                                            <li>Kitchen and Break out areas</li>
                                            <li>Toilets</li>
                                            <li>Public transport</li>
                                        </ul>
								</td>
								<td valign="middle" class="right-border" style="padding-left:40%;">
									<div class="checkbox {{isset($inputs['information-2']) && in_array($inputs['information-2'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> </label></div>
								</td>
								<td valign="top" class="right-border">
								Ethics and standards of PCA
                                        <ul>
                                            <li>Access and Equity</li>
                                            <li>Student Code of Conduct</li>
                                            <li>Plagiarism & cheating</li>
                                            <li>Student Handbook</li>
                                        </ul>
								</td>
								<td valign="middle" style="padding-left:40%;">
									<div class="checkbox {{isset($inputs['information-3']) && in_array($inputs['information-3'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> </label></div>
								</td>
							</tr>
							<tr>
								<td valign="top" class="right-border">
								Information on resources / Course material / textbooks Learning outcomes.
								</td>
								<td valign="middle" class="right-border" style="padding-left:40%;">
									<div class="checkbox {{isset($inputs['information-4']) && in_array($inputs['information-4'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> </label></div>
								</td>
								<td valign="top" class="right-border">
								Complaints and Appeals Access to policies and procedures of PCA 
								</td>
								<td valign="middle" style="padding-left:40%;">
									<div class="checkbox {{isset($inputs['information-5']) && in_array($inputs['information-5'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> </label></div>
								</td>
							</tr>
							<tr>
								<td valign="top" class="right-border">
								Unique Student Identifier (USI)
								</td>
								<td valign="middle" class="right-border" style="padding-left:40%;">
									<div class="checkbox {{isset($inputs['information-6']) && in_array($inputs['information-6'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> </label></div>
								</td>
								<td valign="top" class="right-border">
								ESOS framework
								</td>
								<td valign="middle" style="padding-left:40%;">
									<div class="checkbox {{isset($inputs['information-7']) && in_array($inputs['information-7'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> </label></div>
								</td>
							</tr>
							<tr>
								<td valign="top" class="right-border">
								Language, Literacy and Numeracy/Entry requirements
								</td>
								<td valign="middle" class="right-border" style="padding-left:40%;">
									<div class="checkbox {{isset($inputs['information-8']) && in_array($inputs['information-8'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> </label></div>
								</td>
								<td valign="top" class="right-border">
								Record Keeping
								</td>
								<td valign="middle" style="padding-left:40%;">
									<div class="checkbox {{isset($inputs['information-9']) && in_array($inputs['information-9'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> </label></div>
								</td>
							</tr>
							<tr>
								<td valign="top" class="right-border">
								Attendance importance
								</td>
								<td valign="middle" class="right-border" style="padding-left:40%;">
									<div class="checkbox {{isset($inputs['information-10']) && in_array($inputs['information-10'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> </label></div>
								</td>
								<td valign="top" class="right-border">
								Deferment, Suspension and Cancellation Policy
								</td>
								<td valign="middle" style="padding-left:40%;">
									<div class="checkbox {{isset($inputs['information-11']) && in_array($inputs['information-11'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> </label></div>
								</td>
							</tr>
							<tr>
								<td valign="top" class="right-border">
								Refund Policy
								</td>
								<td valign="middle" class="right-border" style="padding-left:40%;">
									<div class="checkbox {{isset($inputs['information-12']) && in_array($inputs['information-12'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> </label></div>
								</td>
								<td valign="top" class="right-border">
								Credit Transfer and RPL Policy
								</td>
								<td valign="middle" style="padding-left:40%;">
									<div class="checkbox {{isset($inputs['information-13']) && in_array($inputs['information-13'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> </label></div>
								</td>
							</tr>
							<tr>
								<td valign="top" class="right-border">
								Course Progress and Intervention
								</td>
								<td valign="middle" class="right-border" style="padding-left:40%;">
									<div class="checkbox {{isset($inputs['information-14']) && in_array($inputs['information-14'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> </label></div>
								</td>
								<td valign="top" class="right-border">
								Transfer between Providers Policy
								</td>
								<td valign="middle" style="padding-left:40%;">
									<div class="checkbox {{isset($inputs['information-15']) && in_array($inputs['information-15'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> </label></div>
								</td>
							</tr>
							<tr>
								<td valign="top" class="right-border">
								Student Support Services offered
								</td>
								<td valign="middle" class="right-border" style="padding-left:40%;">
									<div class="checkbox {{isset($inputs['information-16']) && in_array($inputs['information-16'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> </label></div>
								</td>
								<td valign="top" class="right-border">
								Fees and Charges, refund policy and procedure
								</td>
								<td valign="middle" style="padding-left:40%;">
									<div class="checkbox {{isset($inputs['information-17']) && in_array($inputs['information-17'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> </label></div>
								</td>
							</tr>
							<tr>
								<td valign="top" class="right-border">
								Adjusting to Life in Melbourne/Brisbane
								</td>
								<td valign="middle" class="right-border" style="padding-left:40%;">
									<div class="checkbox {{isset($inputs['information-18']) && in_array($inputs['information-18'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> </label></div>
								</td>
								<td valign="top" class="right-border">
								Student Visa Conditions
								</td>
								<td valign="middle" style="padding-left:40%;">
									<div class="checkbox {{isset($inputs['information-19']) && in_array($inputs['information-19'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> </label></div>
								</td>
							</tr>
							</tbody>
						</table>
						<div class="clearfix" style="height:10px;"></div>
						<table width="100%" cellpadding="0" cellspacing="0" border="0" class="table-bordered table">
							<tbody>
								<tr>
									<td colspan="4" class="peach-bg-color ">
										STUDENT DECLARATION
									</td>
								</tr>
								<tr>
									<td colspan="4" valign="middle">
										I have attended the Induction Program at Phoenix College of Australia. I acknowledge that I have been Provided with the Student Handbook and I have understood the information mentioned above. 
										<div class="clearfix" style="height:10px;"></div>
										<p class="px-12-font display-inlineblock"><span class="proximanova-bold">Signature</span></p>
										<div class="textbox display-inlineblock" style="width: 380px; margin-left: 5px; margin-right: 10px;">
										<div class="type-signature">
											{{ isset($signature) ? $signature : '' }}
										</div></div>
										<p class="px-12-font display-inlineblock"><span class="proximanova-bold">Date</span></p>
										{{-- <div class="textbox display-inlineblock" style="width: 180px; margin-left: 5px;"> {{ isset($inputs['student_declaration_date']) ? \Carbon\Carbon::parse($inputs['student_declaration_date'])->timezone('Australia/Melbourne')->format('d / m / Y') : '' }}</div> --}}
										<div class="textbox display-inlineblock" style="width: 180px; margin-left: 5px;"> {{ isset($inputs['student_declaration_date']) ? \Carbon\Carbon::parse($inputs['student_declaration_date'])->format('d / m / Y') : '' }}</div>
										<div class="clearfix" style="height:10px;"></div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No: 45633 | CRICOS Code: 03871F</p>
						<p style="margin-bottom: 0px;"> Page 1 of 1</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 1 of 1 -->

</html>