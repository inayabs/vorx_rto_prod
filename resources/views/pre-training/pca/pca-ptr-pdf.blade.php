<!DOCTYPE html>
<?php
    $student_type = $enrolment_pack->stud_type->type;
?>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" href="{{public_path()}}/custom/pca-enrolment/pdf-style.css" rel="stylesheet" />
	<title>Pre-training Review({{$student_type}} Students)</title>
</head>
<!-- {{public_path().'/custom/pca-enrolment/pdf-style.css'}} -->
<!-- Page 1 of 9 -->
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
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">{{$student_type}}</p>
								<p class="primary-font-color proximanova-bold px-24-font text-right line-height-1">Pre-training Review</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">
                <table width="91%" class="form-table table-bordered" cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                        <tr>
                            <td valign="top" width="30%" class="peach-bg-color proximanova-bold table-bordered" style="padding: 2px 5px;">
                                <p class=" px-12-font">Student Name</p>
                            </td>
                            <td>
                                {{$enrolment_pack->student_name}}
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="30%" class="peach-bg-color proximanova-bold table-bordered" style="padding: 2px 5px;">
                                <p class=" px-12-font">Training Program</p>
                            </td>
                            <td>
                                {{$enrolment_pack->enrolment_form['course']['name']}}
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="30%" class="peach-bg-color proximanova-bold table-bordered" style="padding: 2px 5px;">
                                <p class=" px-12-font">Date of Review</p>
                            </td>
                            <td>
                                @if (isset($ptr->inputs->date->value))
                                    {{isset($ptr->inputs->date->value) ? Carbon\Carbon::parse($ptr->inputs->date->value)->timezone('Australia/Melbourne')->format('d/m/Y') : ''}}
                                @else
                                    {{isset($ptr->inputs->date) ? Carbon\Carbon::parse($ptr->inputs->date)->timezone('Australia/Melbourne')->format('d/m/Y') : ''}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="30%" class="peach-bg-color proximanova-bold table-bordered" style="padding: 2px 5px;">
                                <p class=" px-12-font">Pre-training Reivew(PTR)</p>
                            </td>
                            <td>
                                <p>Phoenix College of Australia (PCA) is required to conduct a Pre-Training Review (PTR) of all students who would like to undertake training with Phoenix College of Australia.</p>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="30%" class="peach-bg-color proximanova-bold table-bordered" style="padding: 2px 5px;">
                                <p class=" px-12-font">Purpose of PTR</p>
                            </td>
                            <td>
                            <p class="px-12-font" style="line-height: 12px;"><span class="proximanova">Main objectives of the PTR are to:</span></p>
                                <ul class="list">
                                    <li class="px-14-font">Ascertain the individual’s aspirations and interests with due consideration of the likely job outcomes from the development of new competencies and skills;</li>
                                    <li class="px-14-font">Consideration of Literacy and Numeracy skills through an LLN test or meeting the course entry requirements.</li>
                                    <li class="px-14-font">Identify any competencies previously acquired (RPL) or credit transfer);</li>
                                    <li class="px-14-font">Ascertain a suitable, and the most suitable qualification or that student to enrol in, based on the individual’s existing educational attainment, capabilities, aspirations and interests and with due consideration of the likely job outcomes from the development of new competencies and skills;</li>
                                    <li class="px-14-font">Ascertain that the proposed learning strategies and materials are appropriate for that individual;</li>
                                </ul>
                            <p class="px-12-font" style="line-height: 12px;"><span class="proximanova">All students are required to complete this PTR in order to gain entry into the desired course and service.</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="30%" class="peach-bg-color proximanova-bold table-bordered" style="padding: 2px 5px;">
                                <p class=" px-12-font">Instructions for all students</p>
                            </td>
                            <td>
                            <p class="px-12-font" style="line-height: 12px;"><span class="proximanova">Prior to completing the PTR, make sure you have sufficient information about the course. In particular, you must have access to the following:</span></p>
                                <ul class="list">
                                    <li class="px-14-font">Training and Assessment arrangements i.e. duration of the course, training & assessment modes, days of training, assessments to be completed, course progress and attendance requirements;</li>
                                    <li class="px-14-font">Employment prospects – you should conduct your own research and have strong evidence of employability options on course completion;</li>
                                    <li class="px-14-font">Recognition of prior learning and credit transfer application process;</li>
                                    <li class="px-14-font">Fees and charges applicable for the training;</li>
                                    <li class="px-14-font">{{$enrolment_pack->student_type==1?'Your obligation as an international student i.e. participation in surveys, interviews, questionnaires, etc.':'Your obligation as a student i.e. participation in surveys, interviews, questionnaires, etc.'}}</li>
                                    <li class="px-14-font">Your rights and obligations as a student at Phoenix College of Australia;</li>
                                    <li class="px-14-font">Entry requirements into the course.</li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
				</div>
                <div class="footer bottom-placement px-10-font text-center blue-font-color">
                    <p style="margin-bottom: 2px;">PCA V1.0 | Pre-training Review | RTO No: 45633 | CRICOS Code: 03871F</p>
                    <p style="margin-bottom: 0px;"> Page 1 of 9</p>
                </div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 1 of 9 -->

<!-- Page 2 of 9 -->
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
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">{{$student_type}}</p>
								<p class="primary-font-color proximanova-bold px-24-font text-right line-height-1">Pre-training Review</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">
                <table width="91%" class="form-table table-bordered" cellpadding="0" cellspacing="0" border="0" style="word-wrap:break-word">
                    <tbody>
                        <tr>
                            <td valign="top" width="30%" class="peach-bg-color proximanova-bold table-bordered" style="padding: 2px 5px;">
                                <p class=" px-12-font">Instructions for completing the PTR</p>
                            </td>
                            <td>
                                Please ensure each question is answered as accurately as possible. If you require more space to write your response to a question, please attach a second sheet and number the responses.
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" colspan="2" height="200px">
                                <p class=" px-14-font proximanova-bold">What are your aspirations and interests?</p>
                                <p style="height:150px;">
                                    {{isset($ptr->inputs->student_goals) ? $ptr->inputs->student_goals : ''}}
                                </p>
                                <p class="px-14-font proximanova-bold" style="line-height: 12px;"><span class="proximanova">As applicable, consider and document:</span></p>
                                <ul class="list">
                                    <li class="px-14-font">Career aspirations</li>
                                    <li class="px-14-font">Interests</li>
                                    <li class="px-14-font">Strengths</li>
                                    <li class="px-14-font">Weaknesses</li>
                                    <li class="px-14-font">Reasons for enrolling in the course, including expectations and objectives</li>
                                    <li class="px-14-font">The likely job or further study prospects resulting from the training</li>
                                </ul><br>
                                <p class="px-14-font proximanova-bold" style="line-height: 12px;"><span class="proximanova">Rationale:</span></p><br>
                                <p>
                                The student should not be enrolled in a training program they are not interested in.
                                </p> <br>
                                <p>
                                The chosen training program links to likely job, participation and/or further study opportunities and/or access to training for disadvantaged learners.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" colspan="2">
                                <p class=" px-14-font proximanova-bold">What course are you interested in? </p>
                                <p style="height:150px;">
                                    {{isset($ptr->inputs->student_interests) ? $ptr->inputs->student_interests : ''}}
                                </p>
                            </td>
                        </tr>
                        <tr>
                        <td valign="top" colspan="2">
                            <p class=" px-14-font proximanova-bold">
                                Are you familiar with the proposed learning strategies and materials to be used in the chosen course?
                            </p><br>
                            <p>
                            @if(isset($ptr->inputs->proposed_learning_stategies) && $ptr->inputs->proposed_learning_stategies==true)
                                <span class="checkbox checked"></span>Yes
                                <span class="checkbox"></span>No
                            @else
                                <span class="checkbox"></span>Yes
                                <span class="checkbox checked"></span>No 
                            @endif
                            </p>     
                        </td>
                        </tr>
                    </tbody>
                </table>
				</div>
                <div class="footer bottom-placement px-10-font text-center blue-font-color">
                    <p style="margin-bottom: 2px;">PCA V1.0 | Pre-training Review | RTO No: 45633 | CRICOS Code: 03871F</p>
                    <p style="margin-bottom: 0px;"> Page 2 of 9</p>
                </div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 2 of 9 -->
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
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">{{$student_type}}</p>
								<p class="primary-font-color proximanova-bold px-24-font text-right line-height-1">Pre-training Review</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">
                <table width="91%" class="form-table table-bordered" cellpadding="0" cellspacing="0" border="0" style="word-wrap:break-word"> 
                    <tbody>
                        <tr>
                            <td valign="top" colspan="2" height="200px">
                                <p class="px-14-font proximanova-bold">
                                Do you think that proposed learning strategies and materials may pose potential issues/challenges/barriers for you?
                                </p>
                                @if(isset($ptr->inputs->learning_strat_issues) && $ptr->inputs->learning_strat_issues==true)
                                    <p><span class="checkbox checked"></span>Yes
                                    <span class="checkbox"></span>No</p> 
                                @else
                                    <p><span class="checkbox "></span>Yes
                                    <span class="checkbox checked"></span>No</p> 
                                @endif
                                <p>If yes, please specify:</p>
                                <p style="height:60px;">
                                {{isset($ptr->inputs->learning_strat_issues_spec) ? $ptr->inputs->learning_strat_issues_spec : ''}}
                                </p>
                                <p class="px-14-font proximanova-bold">
                                Please consider and note:
                                </p>
                                <ul class="list">
                                    <li class="px-14-font">Special needs</li>
                                    <li class="px-14-font">Disability</li>
                                    <li class="px-14-font">The student’s personal circumstances</li>
                                    <li class="px-14-font">Preferred learning style</li>
                                    <li class="px-14-font">Previously used methods of learning</li>
                                    <li class="px-14-font">Adequacy/appropriateness of learning materials </li>
                                    <li class="px-14-font">Any additional support or adjustments the student may require, to also be documented in the Training Plan </li>
                                </ul>
                                <p class="px-14-font proximanova-bold" style="line-height: 12px;"><span class="proximanova">Rationale:</span></p>
                                <p>
                                Proper consideration is given to whether the proposed learning strategies and materials in the TAS are appropriate for the student; and whether adjustments need to be made to suit the student’s individual needs.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" colspan="2" height="200px">
                                <p class="px-14-font proximanova-bold">
                                Have you previously acquired any qualification or any relevant competencies? 
                                </p>
                                <p>
                                    @if(isset($ptr->inputs->relevant_comp) && $ptr->inputs->relevant_comp==true)
                                    <span class="checkbox checked"></span>Yes
                                    <span class="checkbox"></span>No
                                    @else
                                    <span class="checkbox "></span>Yes
                                    <span class="checkbox checked"></span>No
                                    @endif
                                </p>
                                <p>If yes, please specify:</p>
                                <p style="height:60px;">
                                {{$ptr->inputs->relevant_comp_spec?$ptr->inputs->relevant_comp_spec:''}}
                                </p>
                                <p class="px-14-font proximanova-bold">
                                As applicable, consider and document:
                                </p>
                                <ul class="list">
                                    <li class="px-14-font">Rpl</li>
                                    <li class="px-14-font">Recognition of current competency (RCC)</li>
                                    <li class="px-14-font">Credit transfer</li>
                                    <li class="px-14-font">The options offered to the student for applying competencies to this training program</li>
                                </ul>
                                <p class="px-14-font proximanova-bold" style="line-height: 12px;"><span class="proximanova">Rationale:</span></p>
                                <p>
                                The student does not undertake any unnecessary training that duplicates competencies.
                                </p>
                                <p>
                                If you would like to apply for Credit Transfer, please provide certified copies of these qualifications and we will assess your application and get back to you as soon as possible. 
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" colspan="2">
                                <p class="px-14-font proximanova-bold">
                                Are you familiar with entry requirements to gain entry into the qualification?
                                </p>
                                @if(isset($ptr->inputs->familiar_entry_requirements) && $ptr->inputs->familiar_entry_requirements==true)
                                    <span class="checkbox checked"></span>Yes
                                    <span class="checkbox"></span>No
                                    @else
                                    <span class="checkbox "></span>Yes
                                    <span class="checkbox checked"></span>No
                                @endif
                                <p class="px-14-font proximanova-bold">
                                Are you meeting the requirements to gain entry into the course?
                                </p>
                                @if(isset($ptr->inputs->meeting_requirement) && $ptr->inputs->meeting_requirement==true)
                                    <span class="checkbox checked"></span>Yes
                                    <span class="checkbox"></span>No
                                    @else
                                    <span class="checkbox "></span>Yes
                                    <span class="checkbox checked"></span>No
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
				</div>
                <div class="footer bottom-placement px-10-font text-center blue-font-color">
                    <p style="margin-bottom: 2px;">PCA V1.0 | Pre-training Review | RTO No: 45633 | CRICOS Code: 03871F</p>
                    <p style="margin-bottom: 0px;"> Page 3 of 9</p>
                </div>
			</div>
		</div>
	</div>
</body>
<!-- Page 3 of 9 -->
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
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">{{$student_type}}</p>
								<p class="primary-font-color proximanova-bold px-24-font text-right line-height-1">Pre-training Review</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">
                <table width="91%" class="form-table table-bordered" cellpadding="0" cellspacing="0" border="0" style="word-wrap:break-word">
                    <tbody>
                        <tr>
                            <td valign="top" colspan="2" height="200px">
                                <p class="px-14-font proximanova-bold">
                                As applicable, consider and document:
                                </p>
                                <ul class="list">
                                    <li class="px-14-font">Results of LLN testing (if required) – as determined using the training provider’s business process for literacy and numeracy testing</li>
                                    <li class="px-14-font">The AQF level of the proposed qualification </li>
                                    <li class="px-14-font">Secondary school results </li>
                                    <li class="px-14-font">Issues that may prevent the student from successfully completing the training</li>
                                    <li class="px-14-font">Any additional LLN support the student may require, to also be documented in the Training Plan.</li>
                                    <li class="px-14-font">Other documents submitted with the application, which meet the entry requirements of the course.</li>
                                </ul>
                                <p class="px-14-font proximanova-bold" style="line-height: 12px;"><span class="proximanova">Rationale:</span></p>
                                <p>
                                The student does not undertake any unnecessary training that duplicates competencies.
                                </p>
                                <p>
                                This will indicate that the student has the ability to successfully complete the training program, or can be provided with reasonable and accessible support to assist them to complete the training 
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" colspan="2">
                                <?php
                                    $why_chose_0 = 'why_chose-0';//get a job
                                    $why_chose_1 = 'why_chose-1';//develop or start
                                    $why_chose_2 = 'why_chose-2';//try diff career
                                    $why_chose_3 = 'why_chose-3';//get better job
                                    $why_chose_4 = 'why_chose-4';//requirement
                                    $why_chose_5 = 'why_chose-5';//extra skills
                                    $why_chose_6 = 'why_chose-6';//improve gen ed
                                    $why_chose_7 = 'why_chose-7';//skills for community/voluntary
                                    $why_chose_8 = 'why_chose-8';//increase self-esteem
                                ?>
                                <p class="px-14-font proximanova-bold">
                                Briefly explain why you have chosen this course?
                                </p>
                                <p>@if(isset($ptr->inputs->$why_chose_0)&&$ptr->inputs->$why_chose_0==true)<span class="checkbox checked"></span> @else <span class="checkbox"> @endif To get a job</p>
                                <p>@if(isset($ptr->inputs->$why_chose_1))<span class="checkbox checked"></span> @else <span class="checkbox"> @endif To develop or start my own business </p>
                                <p>@if(isset($ptr->inputs->$why_chose_2))<span class="checkbox checked"></span> @else <span class="checkbox"> @endif To try for a different career </p>
                                <p>@if(isset($ptr->inputs->$why_chose_3))<span class="checkbox checked"></span> @else <span class="checkbox"> @endif To get a better job or promotion </p>
                                <p>@if(isset($ptr->inputs->$why_chose_4))<span class="checkbox checked"></span> @else <span class="checkbox"> @endif It is a requirement of my job </p>
                                <p>@if(isset($ptr->inputs->$why_chose_5))<span class="checkbox checked"></span> @else <span class="checkbox"> @endif I want extra skills for my job </p>
                                <p>@if(isset($ptr->inputs->$why_chose_6))<span class="checkbox checked"></span> @else <span class="checkbox"> @endif To improve my general educational skills </p>
                                <p>@if(isset($ptr->inputs->$why_chose_7))<span class="checkbox checked"></span> @else <span class="checkbox"> @endif To get skills for community/voluntary work </p>
                                <p>@if(isset($ptr->inputs->$why_chose_8))<span class="checkbox checked"></span> @else <span class="checkbox"> @endif To increase my self-esteem </p>
                                <br>
                                <p>Other reason (please specify)</p>
                                <p style="height:100px;">
                                    {{$ptr->inputs->why_choose_spec?$ptr->inputs->why_choose_spec:''}}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" colspan="2">
                                <?php
                                    $support_service_0 = 'support_service-0';//'LLN Support
                                    $support_service_1 = 'support_service-1';//Academic Support
                                    $support_service_2 = 'support_service-2';//Employment Help
                                    $support_service_3 = 'support_service-3';//No support required'
                                ?>
                                <p class="px-14-font proximanova-bold">
                                What PCA Support Service are you most likely to use during your study? 
                                </p>
                                <p>@if(isset($ptr->inputs->$support_service_0)&&$ptr->inputs->$support_service_0==true)<span class="checkbox checked"></span> @else <span class="checkbox"> @endif LLN Support</p>
                                <p>@if(isset($ptr->inputs->$support_service_1))<span class="checkbox checked"></span> @else <span class="checkbox"> @endif Academic Support </p>
                                <p>@if(isset($ptr->inputs->$support_service_2))<span class="checkbox checked"></span> @else <span class="checkbox"> @endif Employment Help</p>
                                <p>@if(isset($ptr->inputs->$support_service_3))<span class="checkbox checked"></span> @else <span class="checkbox"> @endif No support required</p>
                                <p>Other reason (please specify)</p><br>
                                <p style="height:100px;">
                                    {{$ptr->inputs->support_service_spec?$ptr->inputs->support_service_spec:''}}
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
				</div>
                <div class="footer bottom-placement px-10-font text-center blue-font-color">
                    <p style="margin-bottom: 2px;">PCA V1.0 | Pre-training Review | RTO No: 45633 | CRICOS Code: 03871F</p>
                    <p style="margin-bottom: 0px;"> Page 4 of 9</p>
                </div>
			</div>
		</div>
	</div>
</body>
<!-- End of Page 4 of 9 -->
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
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">{{$student_type}}</p>
								<p class="primary-font-color proximanova-bold px-24-font text-right line-height-1">Pre-training Review</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">
                <table width="91%" class="form-table table-bordered" cellpadding="0" cellspacing="0" border="0" style="word-wrap:break-word">
                    <tbody>
                    <tr>
                            <td valign="top" colspan="2">
                                <p class="px-14-font proximanova-bold">
                                As you know, you may be required to participate in the role plays for your chosen course, is there anything that might prevent you from progressing through the training and assessment program? For example, physical injuries or language barrier etc.
                                </p>
                                <p>
                                    @if($ptr->inputs->role_play==true)
                                    <span class="checkbox checked"></span>Yes
                                    <span class="checkbox"></span>No
                                    @else
                                    <span class="checkbox "></span>Yes
                                    <span class="checkbox checked"></span>No
                                    @endif
                                </p>
                                <p>
                                    If yes, please specify
                                </p><br>
                                <p>
                                    {{$ptr->inputs->role_play_spec?$ptr->inputs->role_play_spec:''}}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" colspan="2">
                                <p class="px-14-font proximanova-bold">
                                Are you aware of learning outcomes of this course?
                                </p>
                                <p>
                                @if($ptr->inputs->course_outcomes_awareness==true)    
                                <span class="checkbox checked"></span>Yes
                                <span class="checkbox"></span>No
                                @else
                                <span class="checkbox"></span>Yes
                                <span class="checkbox checked"></span>No
                                @endif
                                </p>
                                <p><br>
                                Note:(Students will be explained the learning outcomes of the course by the PCA delegate and also you will be handed over the student Handbook during the orientation and induction session)
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" colspan="2">
                                <p class="px-14-font proximanova-bold">
                                Are you aware of skills required to work in the industry you have chosen?
                                </p>
                                <p>
                                @if($ptr->inputs->skills_req_awareness==true)    
                                <span class="checkbox checked"></span>Yes
                                <span class="checkbox"></span>No
                                @else
                                <span class="checkbox"></span>Yes
                                <span class="checkbox checked"></span>No
                                @endif
                                </p>
                                <p><br>
                                Note: Students will be explained the skills required to work in the industry during the orientation and induction session. 
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" colspan="2">
                                <p class="px-14-font proximanova-bold">
                                Do you know about Credit transfer (CT) and Recognition of Prior Learning (RPL) process of PCA?
                                </p>
                                <p>
                                @if($ptr->inputs->ct_awareness==true)    
                                <span class="checkbox checked"></span>Yes
                                <span class="checkbox"></span>No
                                @else
                                <span class="checkbox"></span>Yes
                                <span class="checkbox checked"></span>No
                                @endif
                                </p>
                                <p><br>
                                Note: Students will be explained the RPL and CT process of PCA during the orientation and induction session.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" colspan="2">
                                <p class="px-14-font proximanova-bold">
                                Have you got any previous educational attainments and capabilities?
                                </p>
                                <p>
                                @if($ptr->inputs->prev_attainments==true)    
                                <span class="checkbox checked"></span>Yes
                                <span class="checkbox"></span>No
                                @else
                                <span class="checkbox"></span>Yes
                                <span class="checkbox checked"></span>No
                                @endif
                                </p>
                                <p>
                                If Yes, please specify below
                                </p><br>
                                <p>
                                    {{$ptr->inputs->prev_attainments_spec?$ptr->inputs->prev_attainments_spec:''}}
                                </p>
                                <p class="px-14-font proximanova-bold" style="line-height: 12px;"><span class="proximanova">As applicable, consider and document:</span></p>
                                <p>The student’s existing educational attainment and capabilities including</p>
                                <ul class="list">
                                    <li class="px-14-font">Prior learning</li>
                                    <li class="px-14-font">Whether the course entry requirements and pre-requisites are met</li>
                                    <li class="px-14-font">Employment experience</li>
                                    <li class="px-14-font">Volunteering</li>
                                </ul><br>
                                <p class="px-14-font proximanova-bold" style="line-height: 12px;"><span class="proximanova">Rationale:</span></p><br>
                                <p>
                                The student is enrolled in a training program that is at the appropriate level for them.
                                </p> 
                            </td>
                        </tr>
                        <tr>    
                            <td valign="top" colspan="2">
                                <p class="px-14-font proximanova-bold">
                                Are you currently working in the industry in which you are seeking training?
                                </p>
                                <p>
                                @if($ptr->inputs->currently_working==true)    
                                <span class="checkbox checked"></span>Yes
                                <span class="checkbox"></span>No
                                @else
                                <span class="checkbox"></span>Yes
                                <span class="checkbox checked"></span>No
                                @endif
                                </p><br>
                                <p>Position/title:<u>{{$ptr->inputs->currently_working_spec?$ptr->inputs->currently_working_spec:''}}</u></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
				</div>
                <div class="footer bottom-placement px-10-font text-center blue-font-color">
                    <p style="margin-bottom: 2px;">PCA V1.0 | Pre-training Review | RTO No: 45633 | CRICOS Code: 03871F</p>
                    <p style="margin-bottom: 0px;"> Page 5 of 9</p>
                </div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 5 of 9 -->
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
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">{{$student_type}}</p>
								<p class="primary-font-color proximanova-bold px-24-font text-right line-height-1">Pre-training Review</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">
                <table width="91%" class="form-table table-bordered" cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                        <tr>    
                            <td valign="top" colspan="2">
                                <p style="height:80px;">
                                If you would like to apply for RPL, please provide the proven employment experience and we will assess your application and get back to you as soon as possible.
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
				</div>
                <div class="footer bottom-placement px-10-font text-center blue-font-color">
                    <p style="margin-bottom: 2px;">PCA V1.0 | Pre-training Review | RTO No: 45633 | CRICOS Code: 03871F</p>
                    <p style="margin-bottom: 0px;"> Page 6 of 9</p>
                </div>
			</div>
		</div>
	</div>
</body>
<!-- End of page 6 of 9  -->
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
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">{{$student_type}}</p>
								<p class="primary-font-color proximanova-bold px-24-font text-right line-height-1">Pre-training Review</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">
                <table width="91%" class="form-table table-bordered" cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                    <tr>
                        <td valign="top" width="30%" class="peach-bg-color proximanova-bold" style="padding: 2px 5px;" colspan="2">
                                <p class="px-14-font proximanova-bold">
                                The following information will help us to determine your learning styles and if we are able to deliver courses that meet your learning styles.  (Tick the most relevant)
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <?php
                                $learning_styles_0 = 'learning_styles-0';
                                $learning_styles_1 = 'learning_styles-1';
                                $learning_styles_2 = 'learning_styles-2';
                                $learning_styles_3 = 'learning_styles-3';
                                $learning_styles_4 = 'learning_styles-4';
                                $learning_styles_5 = 'learning_styles-5';
                                $learning_styles_6 = 'learning_styles-6';
                                $learning_styles_7 = 'learning_styles-7';
                            ?>
                            <td v-align="top" colspan="2">
                                <p>@if(isset($ptr->inputs->$learning_styles_0))<span class="checkbox checked"></span> @else <span class="checkbox"> @endif Textbooks that I can read and refer to in my own time;</p>
                                <p>@if(isset($ptr->inputs->$learning_styles_1))<span class="checkbox checked"></span>@else <span class="checkbox"></span> @endif Power Points explained to me during classes;</p>
                                <p>@if(isset($ptr->inputs->$learning_styles_2))<span class="checkbox checked"></span>@else <span class="checkbox"></span> @endif Pictures and diagrams;</p>
                                <p>@if(isset($ptr->inputs->$learning_styles_3))<span class="checkbox checked"></span>@else <span class="checkbox"></span> @endif Group discussions with others;</p>
                                <p>@if(isset($ptr->inputs->$learning_styles_4))<span class="checkbox checked"></span>@else <span class="checkbox"></span> @endif Conducting my own research;</p>
                                <p>@if(isset($ptr->inputs->$learning_styles_5))<span class="checkbox checked"></span>@else <span class="checkbox"></span> @endif Listening to the lectures/ trainers;</p>
                                <p>@if(isset($ptr->inputs->$learning_styles_6))<span class="checkbox checked"></span>@else <span class="checkbox"></span> @endif Practical application of skills and knowledge in a workplace or similar or watching videos;</p>
                                <p>@if(isset($ptr->inputs->$learning_styles_7))<span class="checkbox checked"></span>@else <span class="checkbox"></span> @endif Working through real examples such as a case study or scenario;</p>
                                <p>
                                    Other (please explain below):
                                </p><br>
                                <p>
                                    {{$ptr->inputs->learning_styles_spec?$ptr->inputs->learning_styles_spec:''}}
                                </p>
                            </td>
                        </tr>
                        <tr>
                        <td valign="top" width="30%" class="peach-bg-color proximanova-bold" style="padding: 2px 5px;" colspan="2">
                                <p class="px-14-font proximanova-bold">
                                What additional support do you think you will need in order to complete this course successfully?
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td v-align="top" colspan="2">
                                <?php
                                    $add_support_0 = 'add_support';
                                    $add_support_1 = 'add_support-1';
                                    $add_support_2 = 'add_support-2';
                                    $add_support_3 = 'add_support-3';
                                    $add_support_4 = 'add_support-4';
                                    $add_support_5 = 'add_support-5';
                                ?>
                                <p>@if(isset($ptr->inputs->$add_support_0))<span class="checkbox checked"></span> @else <span class="checkbox"> @endif English language support;</p>
                                <p>@if(isset($ptr->inputs->$add_support_1))<span class="checkbox checked"></span> @else <span class="checkbox"> @endif Reading support;</p>
                                <p>@if(isset($ptr->inputs->$add_support_2))<span class="checkbox checked"></span> @else <span class="checkbox"> @endif Writing support;</p>
                                <p>@if(isset($ptr->inputs->$add_support_3))<span class="checkbox checked"></span> @else <span class="checkbox"> @endif One-on-one guidance;</p>
                                <p>@if(isset($ptr->inputs->$add_support_4))<span class="checkbox checked"></span> @else <span class="checkbox"> @endif Additional resources:</p>
                                <p>@if(isset($ptr->inputs->$add_support_5))<span class="checkbox checked"></span> @else <span class="checkbox"> @endif No support required</p>
                                <p>
                                    Other (please explain below):
                                </p><br>
                                <p>
                                    {{$ptr->inputs->add_support_spec?$ptr->inputs->add_support_spec:''}}
                                </p>
                            </td>
                        </tr>
                        <tr>
                        <td valign="top" width="30%" class="peach-bg-color proximanova-bold" style="padding: 2px 5px;" colspan="2">
                                <p class="px-14-font proximanova-bold">
                                {{$enrolment_pack->student_type==1?'The following information will ensure that you are aware of your rights and obligations as an international student at PCA. ':'The following information will ensure that you are aware of your rights and obligations as a student at PCA. '}}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="30%" class="peach-bg-color proximanova" style="padding: 2px 5px;" colspan="2">
                                <p class="px-14-font proximanova">
                                Are you aware that you may be required to participate in NCVER or other surveys or interviews from different regulatory bodies?  Ask PCA staff if you are unsure.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="30%" class="proximanova" style="padding: 2px 5px;" colspan="2">
                                <p class="px-14-font proximanova">
                                <p>
                                @if($ptr->inputs->ncver_participate_awareness->value=='Yes')
                                    <span class="checkbox checked"></span>Yes
                                    <span class="checkbox"></span>No
                                    <span class="checkbox"></span>N/A
                                @elseif($ptr->inputs->ncver_participate_awareness->value=='No')
                                    <span class="checkbox "></span>Yes
                                    <span class="checkbox checked"></span>No
                                    <span class="checkbox"></span>N/A
                                @else
                                    <span class="checkbox "></span>Yes
                                    <span class="checkbox "></span>No
                                    <span class="checkbox checked"></span>N/A
                                @endif
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="30%" class="peach-bg-color proximanova" style="padding: 2px 5px;" colspan="2">
                                <p class="px-14-font proximanova">
                                Are you aware of any fees and charges applicable to your enrolment, including any refund policy?  Ask PCA staff if you are unsure.</p>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="30%" class="proximanova" style="padding: 2px 5px;" colspan="2">
                                <p class="px-14-font proximanova">
                                <p>
                                @if($ptr->inputs->fees_awareness->value=='Yes')
                                    <span class="checkbox checked"></span>Yes
                                    <span class="checkbox"></span>No
                                    <span class="checkbox"></span>N/A
                                @elseif($ptr->inputs->fees_awareness->value=='No')
                                    <span class="checkbox "></span>Yes
                                    <span class="checkbox checked"></span>No
                                    <span class="checkbox"></span>N/A
                                @else
                                    <span class="checkbox "></span>Yes
                                    <span class="checkbox "></span>No
                                    <span class="checkbox checked"></span>N/A
                                @endif
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="30%" class="peach-bg-color proximanova" style="padding: 2px 5px;" colspan="2">
                                <p class="px-14-font proximanova">
                                Are you aware of complaints and appeals policy of PCA?  Ask PCA staff if you are unsure.</p>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="30%" class="proximanova" style="padding: 2px 5px;" colspan="2">
                                <p class="px-14-font proximanova">
                                <p>
                                    @if($ptr->inputs->complaints_and_appeals==true)
                                    <span class="checkbox checked"></span>Yes
                                    <span class="checkbox"></span>No
                                    @else
                                    <span class="checkbox "></span>Yes
                                    <span class="checkbox checked"></span>No
                                    @endif
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="30%" class="peach-bg-color proximanova" style="padding: 2px 5px;" colspan="2">
                                <p class="px-14-font proximanova">
                                    Are you aware of course attendance requirements, course progress requirements and training and assessment arrangements?  Ask PCA staff if you are unsure.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="30%" class="proximanova" style="padding: 2px 5px;" colspan="2">
                                <p class="px-14-font proximanova">
                                <p>
                                @if($ptr->inputs->attendance_requirements==true)
                                <span class="checkbox checked"></span>Yes
                                <span class="checkbox"></span>No
                                @else
                                <span class="checkbox "></span>Yes
                                <span class="checkbox checked"></span>No
                                @endif
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
				</div>
                <div class="footer bottom-placement px-10-font text-center blue-font-color">
                    <p style="margin-bottom: 2px;">PCA V1.0 | Pre-training Review | RTO No: 45633 | CRICOS Code: 03871F</p>
                    <p style="margin-bottom: 0px;"> Page 7 of 9</p>
                </div>
			</div>
		</div>
	</div>
</body>
<!-- End page 7 of 9 -->
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
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">{{$student_type}}</p>
								<p class="primary-font-color proximanova-bold px-24-font text-right line-height-1">Pre-training Review</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">
                <table width="91%" class="form-table table-bordered" cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                    <tr>
                        <td valign="top" width="30%" class="peach-bg-color proximanova-bold" style="padding: 2px 5px;" colspan="2">
                            <p class="px-14-font proximanova-bold">
                            {{$enrolment_pack->student_type==1?'As an international student, are you aware of the fees and charges applicable to the course?  Ask PCA staff if you are unsure.':'As a student, are you aware of the fees and charges applicable to the course?  Ask PCA staff if you are unsure.'}}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td v-align="top" colspan="2">
                            <p>
                            @if($ptr->inputs->intl_fees->value=='Yes')
                                <span class="checkbox checked"></span>Yes
                                <span class="checkbox"></span>No
                                <span class="checkbox"></span>N/A
                            @elseif($ptr->inputs->intl_fees->value=='No')
                                <span class="checkbox "></span>Yes
                                <span class="checkbox checked"></span>No
                                <span class="checkbox"></span>N/A
                            @else
                                <span class="checkbox "></span>Yes
                                <span class="checkbox "></span>No
                                <span class="checkbox checked"></span>N/A
                            @endif
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="30%" class="peach-bg-color proximanova-bold" style="padding: 2px 5px;" colspan="2">
                            <p class="px-14-font proximanova-bold">
                            Student Name: <u>{{$enrolment_pack->student_name}}</u>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="30%" class="peach-bg-color proximanova-bold" style="padding: 2px 5px;" colspan="2">
                            <p class="px-14-font proximanova-bold">
                            Signature: <u><span class="type-signature">{{$ptr->inputs->student_signature?$ptr->inputs->student_signature:''}}</span></u>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="30%" class="peach-bg-color proximanova-bold" style="padding: 2px 5px;" colspan="2">
                            <p class="px-14-font proximanova-bold">
                                Date: <u>@if (isset($ptr->inputs->date->value))
                                    {{isset($ptr->inputs->date->value) ? Carbon\Carbon::parse($ptr->inputs->date->value)->timezone('Australia/Melbourne')->format('d/m/Y') : ''}}
                                @else
                                    {{isset($ptr->inputs->date) ? Carbon\Carbon::parse($ptr->inputs->date)->timezone('Australia/Melbourne')->format('d/m/Y') : ''}}
                                @endif</u>
                            </p>
                        </td>
                    </tr>
                    </tbody>
                </table>
				</div>
                <div class="footer bottom-placement px-10-font text-center blue-font-color">
                    <p style="margin-bottom: 2px;">PCA V1.0 | Pre-training Review | RTO No: 45633 | CRICOS Code: 03871F</p>
                    <p style="margin-bottom: 0px;"> Page 8 of 9</p>
                </div>
			</div>
		</div>
	</div>
</body>
<!-- End of page 8 of 9 -->
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
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">{{$student_type}}</p>
								<p class="primary-font-color proximanova-bold px-24-font text-right line-height-1">Pre-training Review</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">
                <table width="91%" class="form-table table-bordered" cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                    <tr>
                        <td valign="top" width="30%" class="peach-bg-color proximanova-bold" style="padding: 2px 5px;" colspan="3">
                            <p class="px-14-font proximanova-bold">
                            To be completed by an authorised delegate of PCA
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td v-align="top" colspan="3">
                            <p>
                            <u>Instructions:</u>
                            </p><br>
                            <p>
                            Please review the information that student has provided on this form and if the information provided is not clear enough, interview the student and ask to elaborate.  The information provided through the PTR is important to determine eligibility and applicability for the training.
                            </p><br>
                            <p>
                            Please make sure that you consider all the documents submitted by the student along with the application and other documents.
                            </p>
                        </td>
                    </tr>
                        <tr>
                        <td valign="top" width="80%" class="peach-bg-color proximanova-bold table-bordered" style="padding: 2px 5px;">
                            <p class="px-14-font proximanova-bold">
                            Assessment requirements
                            </p>
                        </td>
                        <td valign="top" width="10%" class="peach-bg-color proximanova-bold table-bordered" style="padding: 2px 5px;">
                            <p class="px-14-font proximanova-bold">
                            Yes
                            </p>
                        </td>
                        <td valign="top" width="10%" class="peach-bg-color proximanova-bold table-bordered" style="padding: 2px 5px;">
                            <p class="px-14-font proximanova-bold">
                            No
                            </p>
                        </td>
                    </tr>
                    <tr>
                       <td class="table-bordered">
                       Is the course chosen aligned to the student’s employment history/ career objectives and aspirations?
                       </td> 
                       @if(isset($ptr->inputs->course_align_student))
                       @if($ptr->inputs->course_align_student->yes==true)
                       <td class="table-bordered">
                       <img src="{{asset('custom/pca-enrolment/images/checkmark-success.png')}}" alt="" class="img-responsive" style="width: 15px;">
                       </td>
                       @else
                       <td class="table-bordered">

                       </td>
                       @endif
                       @if($ptr->inputs->course_align_student->no==true)
                       <td class="table-bordered">
                       <img src="{{asset('custom/pca-enrolment/images/checkmark-success.png')}}" alt="" class="img-responsive" style="width: 15px;">
                       </td>
                       @else
                       <td class="table-bordered">

                       </td>
                       @endif
                       @else
                       <td class="table-bordered">
                        </td>
                        <td class="table-bordered">
                        </td>
                       @endif
                    </tr>
                    <tr>
                       <td class="table-bordered">
                       The student is fully aware of the course training and assessment arrangements i.e. attendance requirements, course progress requirements training and assessment methods, and any practical training requirements?
                       </td> 
                       @if(isset($ptr->inputs->training_and_assessment_awareness))
                       @if($ptr->inputs->training_and_assessment_awareness->yes==true)
                       <td class="table-bordered">
                       <img src="{{asset('custom/pca-enrolment/images/checkmark-success.png')}}" alt="" class="img-responsive" style="width: 15px;">
                       </td>
                       @else
                       <td class="table-bordered">
                       
                       </td>
                       @endif
                       @if($ptr->inputs->training_and_assessment_awareness->no==true)
                       <td class="table-bordered">
                       <img src="{{asset('custom/pca-enrolment/images/checkmark-success.png')}}" alt="" class="img-responsive" style="width: 15px;">
                       </td>
                       @else
                       <td class="table-bordered">
                       
                       </td>
                        @endif
                        @else
                        <td class="table-bordered">
                        </td>
                        <td class="table-bordered">
                        </td>
                       @endif
                    </tr>
                    <tr>
                       <td class="table-bordered">
                       {{$enrolment_pack->student_type==1?'The student is fully aware of their rights and obligations as an international student?':'The student is fully aware of their rights and obligations as a student?'}}
                       </td> 
                       @if(isset($ptr->inputs->rights_and_obligation_awareness))
                       @if($ptr->inputs->rights_and_obligation_awareness->yes==true)
                       <td class="table-bordered">
                       <img src="{{asset('custom/pca-enrolment/images/checkmark-success.png')}}" alt="" class="img-responsive" style="width: 15px;">
                       </td>
                       @else
                       <td class="table-bordered">
                       
                       </td>
                       @endif
                       @if($ptr->inputs->rights_and_obligation_awareness->no==true)
                       <td class="table-bordered">
                       <img src="{{asset('custom/pca-enrolment/images/checkmark-success.png')}}" alt="" class="img-responsive" style="width: 15px;">
                       </td>
                       @else
                       <td class="table-bordered">
                       
                       </td>
                        @endif
                        @else
                        <td class="table-bordered">
                        </td>
                        <td class="table-bordered">
                        </td>
                       @endif
                    </tr>
                    <tr>
                       <td class="table-bordered">
                       Have you identified any support identified during the process?
                       </td> 
                       @if(isset($ptr->inputs->support_identified))
                       @if($ptr->inputs->support_identified->yes==true)
                       <td class="table-bordered">
                       <img src="{{asset('custom/pca-enrolment/images/checkmark-success.png')}}" alt="" class="img-responsive" style="width: 15px;">
                       </td>
                       @else
                       <td class="table-bordered">
                       
                       </td>
                       @endif
                       @if($ptr->inputs->support_identified->no==true)
                       <td class="table-bordered">
                       <img src="{{asset('custom/pca-enrolment/images/checkmark-success.png')}}" alt="" class="img-responsive" style="width: 15px;">
                       </td>
                       @else
                       <td class="table-bordered">
                       
                       </td>
                        @endif
                        @else
                        <td class="table-bordered">
                        </td>
                        <td class="table-bordered">
                        </td>
                       @endif
                    </tr>
                    <tr>
                       <td class="table-bordered">
                       Training and assessment strategy is suitable and based on the student’s learning needs and learning styles?
                       </td> 
                       @if(isset($ptr->inputs->training_and_asses_strat))
                       @if($ptr->inputs->training_and_asses_strat->yes==true)
                       <td class="table-bordered">
                       <img src="{{asset('custom/pca-enrolment/images/checkmark-success.png')}}" alt="" class="img-responsive" style="width: 15px;">
                       </td>
                       @else
                       <td class="table-bordered">
                       
                       </td>
                       @endif
                       @if($ptr->inputs->training_and_asses_strat->no==true)
                       <td class="table-bordered">
                       <img src="{{asset('custom/pca-enrolment/images/checkmark-success.png')}}" alt="" class="img-responsive" style="width: 15px;">
                       </td>
                       @else
                       <td class="table-bordered">
                       
                       </td>
                        @endif
                        @else
                        <td class="table-bordered">
                        </td>
                        <td class="table-bordered">
                        </td>
                       @endif
                    </tr>
                    <tr>
                       <td class="table-bordered">
                       Is the training suitable and appropriate based on the student’s achievements, career history, experience, future goals, objectives, capabilities and career aspirations?
                       </td> 
                       @if(isset($ptr->inputs->suitable_and_appropriate))
                       @if($ptr->inputs->suitable_and_appropriate->yes==true)
                       <td class="table-bordered">
                       <img src="{{asset('custom/pca-enrolment/images/checkmark-success.png')}}" alt="" class="img-responsive" style="width: 15px;">
                       </td>
                       @else
                       <td class="table-bordered">
                       
                       </td>
                       @endif
                       @if($ptr->inputs->suitable_and_appropriate->no==true)
                       <td class="table-bordered">
                       <img src="{{asset('custom/pca-enrolment/images/checkmark-success.png')}}" alt="" class="img-responsive" style="width: 15px;">
                       </td>
                       @else
                       <td class="table-bordered">
                       
                       </td>
                        @endif
                        @else
                        <td class="table-bordered">
                        </td>
                        <td class="table-bordered">
                        </td>
                       @endif
                    </tr>
                    <tr>
                       <td class="table-bordered">
                       The student is aware of RPL and CT arrangements and application process?
                       </td> 
                       @if(isset($ptr->inputs->arrangment_awareness))
                       @if($ptr->inputs->arrangment_awareness->yes==true)
                       <td class="table-bordered">
                       <img src="{{asset('custom/pca-enrolment/images/checkmark-success.png')}}" alt="" class="img-responsive" style="width: 15px;">
                       </td>
                       @else
                       <td class="table-bordered">
                       
                       </td>
                       @endif
                       @if($ptr->inputs->arrangment_awareness->no==true)
                       <td class="table-bordered">
                       <img src="{{asset('custom/pca-enrolment/images/checkmark-success.png')}}" alt="" class="img-responsive" style="width: 15px;">
                       </td>
                       @else
                       <td class="table-bordered">
                       
                       </td>
                        @endif
                        @else
                        <td class="table-bordered">
                        </td>
                        <td class="table-bordered">
                        </td>
                       @endif
                    </tr>
                    <tr>
                        <td valign="top" width="80%" class="peach-bg-color proximanova-bold" style="padding: 2px 5px;" colspan="3">
                            <p class="px-14-font proximanova-bold">
                            Authorised Person’s declaration
                            </p>
                        </td>
                    </tr>
                    <tr>
                       <td class="table-bordered">
                       Based on the information provided on this form, the student meets the requirements for this course.
                       </td> 
                       @if(isset($ptr->inputs->student_meets_requirements))
                       @if($ptr->inputs->student_meets_requirements->yes==true)
                       <td class="table-bordered">
                       <img src="{{asset('custom/pca-enrolment/images/checkmark-success.png')}}" alt="" class="img-responsive" style="width: 15px;">
                       </td>
                       @else
                       <td class="table-bordered">
                       
                       </td>
                       @endif
                       @if($ptr->inputs->student_meets_requirements->no==true)
                       <td class="table-bordered">
                       <img src="{{asset('custom/pca-enrolment/images/checkmark-success.png')}}" alt="" class="img-responsive" style="width: 15px;">
                       </td>
                       @else
                       <td class="table-bordered">
                       
                       </td>
                       @endif
                        @else
                        <td class="table-bordered">
                        </td>
                        <td class="table-bordered">
                        </td>
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="80%" class="proximanova-bold" style="padding: 2px 5px;" colspan="3">
                            <p class="px-14-font proximanova-bold">
                            Comments:
                            {{isset($ptr->inputs->comments) ? $ptr->inputs->comments : ''}}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="80%" class="proximanova-bold" style="padding: 2px 5px;" colspan="3">
                            <p class="px-14-font proximanova-bold">
                            Authorised Person’s Name:
                            {{isset($ptr->inputs->auth_person_name) ? $ptr->inputs->auth_person_name : ''}}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="80%" class="proximanova-bold" style="padding: 2px 5px;" colspan="3">
                            <p class="px-14-font proximanova-bold">
                            Authorised Person’s Signature:
                            <span class="type-signature">
                            {{isset($ptr->inputs->auth_person_signature) ? $ptr->inputs->auth_person_signature : ''}}
                            </span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="80%" class="proximanova-bold" style="padding: 2px 5px;" colspan="3">
                            <p class="px-14-font proximanova-bold">
                            Authorised Person’s Position:
                            {{isset($ptr->inputs->auth_person_position) ? $ptr->inputs->auth_person_position : ''}}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="80%" class="proximanova-bold" style="padding: 2px 5px;" colspan="3">
                            <p class="px-14-font proximanova-bold">
                            @if (isset($ptr->inputs->auth_date))
                            Date: <u>{{Carbon\Carbon::parse($ptr->inputs->auth_date)->timezone('Australia/Melbourne')->format('d/m/Y')}}</u>
                            @else
                            Date: 
                            @endif
                            </p>
                        </td>
                    </tr>
                    </tbody>
                </table>
				</div>
                <div class="footer bottom-placement px-10-font text-center blue-font-color">
                    <p style="margin-bottom: 2px;">PCA V1.0 | Pre-training Review | RTO No: 45633 | CRICOS Code: 03871F</p>
                    <p style="margin-bottom: 0px;"> Page 9 of 9</p>
                </div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 9 of 9 -->
</html>