<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="{{ asset('css/offer_letter/pdf-stylez.css') }}" rel="stylesheet">
	<title>Student Payment Schedule Of Course Fees</title>
	<!-- Page 1 of 1 -->
    <!-- <style>
        .content table td{
            border:solid 1px;
            padding:5px;
        }
        .bg-blue{
            background-color:#9cc2e5;
            font-weight:bold;
        }
        #remove_border td{
            border:none;
        }
    </style> -->
</head>
<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="eti-logo">
									<img src="{{asset('images/logo/cea-logo.png')}}" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="secondary-font-color px-16-font text-right line-height-1point2">Pre-Training Review</p>
							</td>
						</tr>
					</table>
                </div>
                <br>
                <br>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 20 10px;">
					<div class="content">
                        <table class="default-bordered-table">
                            <tr>
                                <td class="primary-bg-color"><span class="proximanova-bold">Student Name</span></td><td>{{$enrolment_pack->student_name}}</td>
                            </tr>
                            <tr>
                                <td class="primary-bg-color" style="background-color:#00aeef;">
                                    <span class="proximanova-bold">
                                    Training Program
                                    </span>
                                </td>
                                <td>
                                    {{$ptr->inputs->training_program?$ptr->inputs->training_program:''}}
                                </td>
                            </tr>
                            <tr>
                                <td class="primary-bg-color">
                                    <span class="proximanova-bold">
                                    Pre-Training Review
                                    </span>
                                </td>
                                <td>
                                Community Education Australia (CEA) is required to conduct a Pre-Training
                                Review (PTR) of all students who would like to undertake training with
                                Community Education Australia.
                                </td>
                            </tr>
                            <tr>
                                <td class="primary-bg-color" style="background-color:#00aeef;">
                                    <span class="proximanova-bold">
                                    Purpose of PTR
                                    </span>
                                </td>
                                <td>
                                    Main objectives of the PTR are to:
                                    <ul>
                                       <li>
                                       Identify any competencies previously acquired (RPL) or credit transfer);
                                       </li>
                                       <li>
                                       Ascertain a suitable, and the most suitable qualification or that student
                                        to enrol in, based on the individual’s existing educational attainment,
                                        capabilities, aspirations and interests and with due consideration of the
                                        likely job outcomes from the development of new competencies and
                                        skills;
                                       </li> 
                                       <li>
                                       Ascertain that the proposed learning strategies and materials are
                                        appropriate for that individual;
                                       </li>
                                    </ul>
                                    All students are required to complete this PTR in order to gain entry into the
                                    desired course and service
                                </td>
                            </tr>
                            <tr>
                                <td class="primary-bg-color">
                                    <span class="proximanova-bold">
                                    Instructions for all students
                                    </span>
                                </td>
                                <td>
                                Prior to completing the PTR, make sure you have sufficient information
                                about the course. In particular, you must have access to the following:
                                    <ul>
                                        <li>
                                        Training and Assessment arrangements i.e. duration of the course,
                                        training & assessment modes, days of training, assessments to be
                                        completed and any practical placement arrangements, attendance
                                        requirements;
                                        </li>
                                        <li>
                                        Employment prospects – you should conduct your own research and
                                        have strong evidence of employability options on course completion;
                                        </li>
                                        <li>
                                        Recognition of prior learning and credit transfer application process;
                                        </li>
                                        <li>
                                        Fees and charges applicable for the training;
                                        </li>
                                        <li>
                                        Your obligation under the funded program i.e. participation in surveys,
                                        interviews, questionnaires, etc
                                        </li>
                                        <li>
                                        Government funding (for the state) eligibility criteria and how it will
                                        affect your future funding eligibility options.
                                        </li>
                                        <li>
                                        Your rights and obligations as a student at Community Education
                                        Australia;
                                        </li>
                                        <li>
                                        Entry requirements into the course.
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
                        <p>Warning - Uncontrolled when printed</p>
						<p style="margin-bottom: 2px;">McEvoy & Doust Pty Ltd trading as Community Education Australia | RTO No. 6074| V3.0</p>
						<p>Page 1</p>
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
                                    <img src="{{asset('images/logo/cea-logo.png')}}" alt="">
                                </div>
                            </td>
                            <td width="80%">
                                <p class="secondary-font-color px-16-font text-right line-height-1point2">Pre-Training Review</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <br>
                <br>
                <div class="clearfix"></div>
                <div style="padding-bottom: 10px;  margin: 20 10px;">
                    <div class="content">
                        <table class="default-bordered-table">
                            <tr>
                                <td class="primary-bg-color">
                                <span class="proximanova-bold">
                                    Instructions for completing the PTR 
                                </span>
                                </td>
                                <td>
                                Please ensure each question is answered as accurately as
                                possible. If you require more space to write your response
                                to a question, please attach a second sheet and number the
                                responses.

                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding-bottom:100px;">
                                <span class="proximanova-bold">
                                Tell us what you want to be in your life? It could be your short term or long-term goal.
                                </span><br><br>
                                <p>
                                    {{$ptr->inputs->student_goals?$ptr->inputs->student_goals:''}}
                                </p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding-bottom:60px;">
                                <span class="proximanova-bold">
                                What course(s) are you interested in? Write down the Code(s) and Title(s) you saw in our
                                Marketing Material.
                                </span>
                                <span>
                                    {{$ptr->inputs->student_interests?$ptr->inputs->student_interests:''}}
                                </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"  style="padding-bottom:50px;">
                                <p>
                                <span class="proximanova-bold">
                                Briefly explain why you have chosen this course?
                                </span>
                                </p>
                                <br>
                                <?php
                                    $wctc = [];
                                    if($ptr->inputs->why_chose_this_course){
                                        foreach($ptr->inputs->why_chose_this_course as $w){
                                            array_push($wctc,$w->id);
                                        }
                                    }
                                ?>
                                <p>@if(in_array(0,$wctc))<span class="checkbox checked">@else<span class="checkbox">@endif</span> To get a job</p><br>
                                <p>@if(in_array(1,$wctc))<span class="checkbox checked">@else<span class="checkbox">@endif</span> To develop or start my own business</p> <br>
                                <p>@if(in_array(2,$wctc))<span class="checkbox checked">@else<span class="checkbox">@endif</span> To try for a different career </p><br>
                                <p>@if(in_array(3,$wctc))<span class="checkbox checked">@else<span class="checkbox">@endif</span> To get a better job or promotion </p><br>
                                <p>@if(in_array(4,$wctc))<span class="checkbox checked">@else<span class="checkbox">@endif</span> It is a requirement of my job </p><br>
                                <p>@if(in_array(5,$wctc))<span class="checkbox checked">@else<span class="checkbox">@endif</span> I want extra skills for my job </p> <br>
                                <p>@if(in_array(6,$wctc))<span class="checkbox checked">@else<span class="checkbox">@endif</span> To improve my general educational skills </p> <br>
                                <p>@if(in_array(7,$wctc))<span class="checkbox checked">@else<span class="checkbox">@endif</span> To get skills for community/voluntary work </p><br>
                                <p>@if(in_array(8,$wctc))<span class="checkbox checked">@else<span class="checkbox">@endif</span> To increase my self-esteem </p><br>
                                Other reason (please specify)      <br><br><br>
                                {{$ptr->inputs->course_exp_specified?$ptr->inputs->course_exp_specified:''}}                         
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="footer bottom-placement px-10-font text-center blue-font-color">
                        <p>Warning - Uncontrolled when printed</p>
                        <p style="margin-bottom: 2px;">McEvoy & Doust Pty Ltd trading as Community Education Australia | RTO No. 6074| V3.0</p>
                        <p>Page 2</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!--end of page 2-->
<body class="exo2-regular position-relative">
    <div>
        <div class="col-lg-12 no-padding position-relative">
            <div class="pdf-wrapper">
                <div style="padding-bottom: 10px;  margin: 0 10px;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="20%">
                                <div class="eti-logo">
                                <img src="{{asset('images/logo/cea-logo.png')}}" alt="">
                                </div>
                            </td>
                            <td width="80%">
                                <p class="secondary-font-color px-16-font text-right line-height-1point2">Pre-Training Review</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <br><br>
                <div class="clearfix"></div>
                <div style="padding-bottom: 10px;  margin: 20 10px;">
                    <div class="content">
                        <table class="default-bordered-table">
                            <tr>
                                <td style="padding-bottom:40px;">
                                   <p><span class="proximanova-bold">What CEA Support Service are you most likely to use during your study?</span> </p><br>
                                   <?php
                                        $css = [];
                                        if($ptr->inputs->why_chose_this_course){
                                            foreach($ptr->inputs->why_chose_this_course as $c){
                                                array_push($css,$c->id);
                                            }
                                        }
                                    ?>
                                    @if(in_array(0,$css))<div class="checkbox checked">@else<div class="checkbox">@endif LLN Support</div><br>
                                    @if(in_array(1,$css))<div class="checkbox checked">@else<div class="checkbox">@endif Academic Support</div><br>
                                    @if(in_array(2,$css))<div class="checkbox checked">@else<div class="checkbox">@endif Employment Help</div><br>
                                    @if(in_array(3,$css))<div class="checkbox checked">@else<div class="checkbox">@endif Other support service (Please specify below)</div><br>
                                    @if(in_array(4,$css))<div class="checkbox checked">@else<div class="checkbox">@endif None</div><br>
                                    <span>
                                        {{$ptr->inputs->liked_cea_supp_spec?$ptr->inputs->liked_cea_supp_spec:''}}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">
                                <p><span class="proximanova-bold">
                                Are you aware of learning outcomes of this course?
                                </span></p>
                                <br>
                                <div>
                                    @if($ptr->inputs->outcome_awareness==true)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">YES </label></span>   
                                    @if($ptr->inputs->outcome_awareness==false)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">NO. </label></span>
                                </div>
                                <br>
                                Note:(Students will be explained the learning outcomes of the course by the CEA delegate and also
                                you will be handed over the student Handbook during the orientation and induction session)
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <p><span class="proximanova-bold">
                                Are you aware of skills required to work in the industry you have chosen?
                                </span></p>
                                <br>
                                <div>
                                    @if($ptr->inputs->req_skill_awareness==true)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">YES </label></span>   
                                    @if($ptr->inputs->req_skill_awareness==false)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">NO. </label></span>
                                </div>
                                <br>
                                Note: Students will be explained the skills required to work in the industry during the orientation
                                and induction session
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <p><span class="proximanova-bold">
                                Do you know about Credit transfer (CT) and Recognition of Prior Learning (RPL) process of CEA?
                                </span></p>
                                <br>
                                <div>
                                    @if($ptr->inputs->ct_rpl_awareness==true)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">YES </label></span>   
                                    @if($ptr->inputs->ct_rpl_awareness==false)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">NO. </label></span>
                                </div>
                                <br>
                                Note: Students will be explained the RPL and CT process of CEA during the enrolment.
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <p><span class="proximanova-bold">
                                Have you ever worked in the industry in which you are seeking training?
                                </span></p>
                                <br>
                                <div>
                                    @if($ptr->inputs->industry_experience==true)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">YES </label></span>   
                                    @if($ptr->inputs->industry_experience==false)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">NO. </label></span>
                                </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="footer bottom-placement px-10-font text-center blue-font-color">
                        <p style="margin-bottom: 2px;">McEvoy & Doust Pty Ltd trading as Community Education Australia | RTO No. 6074| V3.0</p>
                        <p>Page 3</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- End of page 3 -->
<body class="exo2-regular position-relative">
    <div>
        <div class="col-xs-12 no-padding position-relative">
            <div class="pdf-wrapper">
                <div style="padding-bottom: 10px;  margin: 0 10px;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="20%">
                                <div class="eti-logo">
                                    <img src="{{asset('images/logo/cea-logo.png')}}" alt="">
                                </div>
                            </td>
                            <td width="80%">
                                <p class="secondary-font-color px-16-font text-right line-height-1point2">Pre Training Review</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <br>
                <br>
                <div class="clearfix"></div>
                <div style="padding-bottom: 10px;  margin: 20 10px;">
                    <div class="content">
                        <table class="default-bordered-table">
                            <tr class="primary-bg-color">
                                <td>
                                The following information will help us to determine your learning styles and if we are able to deliver
                                courses that meet your learning styles. (Tick the most relevant)
                                </td>
                            </tr>
                            <?php
                                $dls = [];
                                if($ptr->inputs->determine_learning_style){
                                    foreach($ptr->inputs->determine_learning_style as $det){
                                        array_push($dls,$det->id);
                                    }
                                }
                            ?>
                            <tr>
                                <td>
                                <p>@if(in_array(0,$dls))<span class="checkbox checked">@else<span class="checkbox">@endif Textbooks that I can read and refer to in my own time;
                                </p><br>
                                <p>@if(in_array(1,$dls))<span class="checkbox checked">@else<span class="checkbox">@endif Power Points explained to me during classes;
                                </p><br>
                                <p>@if(in_array(2,$dls))<span class="checkbox checked">@else<span class="checkbox">@endif Pictures and diagrams;
                                </p><br>
                                <p>@if(in_array(3,$dls))<span class="checkbox checked">@else<span class="checkbox">@endif Group discussions with others;
                                </p><br>
                                <p>@if(in_array(4,$dls))<span class="checkbox checked">@else<span class="checkbox">@endif Conducting my own research;
                                </p><br>
                                <p>@if(in_array(5,$dls))<span class="checkbox checked">@else<span class="checkbox">@endif Listening to the lectures/ trainers;
                                </p><br>
                                <p>@if(in_array(6,$dls))<span class="checkbox checked">@else<span class="checkbox">@endif Practical application of skills and knowledge in a workplace or similar or watching videos;
                                </p><br>
                                <p>@if(in_array(7,$dls))<span class="checkbox checked">@else<span class="checkbox">@endif Working through real examples such as a case study or scenario;
                                </p><br>
                                <p>Other (please explain below):
                                </p><br>
                                <span>
                                    {{$ptr->inputs->learning_style_spec?$ptr->inputs->learning_style_spec:''}}
                                </span>
                                </td>
                            </tr>
                            <tr class="primary-bg-color">
                                <td>
                                What additional support do you think you will need in order to complete this course successfully?
                                </td>
                            </tr>
                            <?php
                                $actc = [];
                                if($ptr->inputs->additional_course_to_complete){
                                    foreach($ptr->inputs->additional_course_to_complete as $add){
                                        array_push($actc,$add->id);
                                    }
                                }
                            ?>
                            <tr>
                                <td>
                                <p>@if(in_array(0,$actc))<span class="checkbox checked">@else<span class="checkbox">@endif English language support;
                                </p><br>
                                <p>@if(in_array(1,$actc))<span class="checkbox checked">@else<span class="checkbox">@endif Reading support;
                                </P><br>
                                <p>@if(in_array(2,$actc))<span class="checkbox checked">@else<span class="checkbox">@endif Writing support;
                                </p><br>
                                <p>@if(in_array(3,$actc))<span class="checkbox checked">@else<span class="checkbox">@endif One-on-one guidance;
                                </p><br>
                                <p>@if(in_array(4,$actc))<span class="checkbox checked">@else<span class="checkbox">@endif Additional resources:
                                </p><br>
                                <p>@if(in_array(5,$actc))<span class="checkbox checked">@else<span class="checkbox">@endif None
                                </p><br>
                                <span>
                                    {{$ptr->inputs->add_course_spec?$ptr->inputs->add_course_spec:''}}
                                </span>
                                </td>
                            </tr>
                            <br>
                            <tr class="primary-bg-color">
                                <td>
                                The following information will ensure that you are aware of your rights and obligations under the
                                funding contract and being a student at CEA.
                                </td>
                            </tr>
                            <tr class="primary-bg-color">
                                <td>
                                If you are eligible for Government funding, do you understand how enrolment in this course/s will
                                affect your future eligibility for government-subsidised training? Ask CEA staff if you are unsure.
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <div>
                                    @if($ptr->inputs->course_enrolment_awareness->id==0)<span class="checkbox checked">@else <span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">YES </label></span>   
                                    @if($ptr->inputs->course_enrolment_awareness->id==1)<span class="checkbox checked">@else <span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">NO </label></span>
                                    @if($ptr->inputs->course_enrolment_awareness->id==2)<span class="checkbox checked">@else <span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">N/A </label></span>
                                </div>
                                </td>
                            </tr>
                            <tr class="primary-bg-color">
                                <td>
                                Are you aware that you may be required to participate in NCVER or funding department surveys or
                                interviews? Ask CEA staff if you are unsure.
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <div>
                                    @if($ptr->inputs->ncver_awareness->id==0)<span class="checkbox checked">@else <span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">YES </label></span>   
                                    @if($ptr->inputs->ncver_awareness->id==1)<span class="checkbox checked">@else <span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">NO </label></span>
                                    @if($ptr->inputs->ncver_awareness->id==2)<span class="checkbox checked">@else <span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">N/A </label></span>
                                </div> 
                                </td>
                            </tr>
                            <tr class="primary-bg-color">
                                <td>
                                Are you aware of any fees and charges applicable to your enrolment, including any refund policy?
                                Ask CEA staff if you are unsure
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <div>
                                    @if($ptr->inputs->enrolment_fees_awareness->id==1)<span class="checkbox checked">@else <span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">YES </label></span>   
                                    @if($ptr->inputs->enrolment_fees_awareness->id==2)<span class="checkbox checked">@else <span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">NO </label></span>
                                    @if($ptr->inputs->enrolment_fees_awareness->id==3)<span class="checkbox checked">@else <span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">N/A </label></span>
                                </div>
                                </td>
                            </tr>
                            <tr class="primary-bg-color">
                                <td>
                                Are you aware of complaints and appeals policy of CEA? Ask CEA staff if you are unsure.
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <div>
                                    @if($ptr->inputs->caap_awareness==true)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">YES </label></span>   
                                    @if($ptr->inputs->caap_awareness==false)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">NO </label></span>
                                </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="footer bottom-placement px-10-font text-center blue-font-color">
                        <p style="margin-bottom: 2px;">McEvoy & Doust Pty Ltd trading as Community Education Australia | RTO No. 6074| V3.0</p>
                        <p>Page 4</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- End of page 4 -->
<body class="exo2-regular position-relative">
    <div>
        <div class="col-xs-12 no-padding position-relative">
            <div class="pdf-wrapper">
                <div style="padding-bottom: 10px;  margin: 0 10px;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="20%">
                                <div class="eti-logo">
                                    <img src="{{asset('images/logo/cea-logo.png')}}" alt="">
                                </div>
                            </td>
                            <td width="80%">
                                <p class="secondary-font-color px-16-font text-right line-height-1point2">Pre Training Review</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <br><br>
                <div class="clearfix"></div>
                <div style="padding-bottom: 10px;  margin: 20 10px;">
                    <div class="content">
                        <table class="default-bordered-table width-100-percent">
                            <tr class="primary-bg-color">
                                <td>
                                Are you aware of course attendance requirements, and training and assessment arrangements? Ask
                                CEA staff if you are unsure
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <div>
                                    @if($ptr->inputs->attendance_requirements_awareness==true)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">YES </label></span>   
                                    @if($ptr->inputs->attendance_requirements_awareness==false)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">NO </label></span>
                                </div>
                                </td>
                            </tr>
                            <tr class="primary-bg-color">
                                <td>
                                If you are not eligible for funding, are you aware of the fees and charges applicable to the course?
                                Ask CEA staff if you are unsure.
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <div>
                                    @if($ptr->inputs->eligable_funding_awareness->id==0)<span class="checkbox checked">@else <span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">YES </label></span>   
                                    @if($ptr->inputs->eligable_funding_awareness->id==1)<span class="checkbox checked">@else <span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">NO </label></span>
                                    @if($ptr->inputs->eligable_funding_awareness->id==2)<span class="checkbox checked">@else <span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">N/A </label></span>
                                </div>
                                </td>
                            </tr>
                            <tr class="primary-bg-color">
                                <td>
                                    <table id="remove_border">
                                        <tr>
                                            <td width="90px;" class="no-border"><span class="proximanova-bold">Student Name:</span></td>
                                            <td class="no-border"><u>{{$enrolment_pack->student_name}}</u></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr class="primary-bg-color">
                                <td style="background-color:#00aeef;">
                                <table id="remove_border">
                                    <tr>
                                        <td width="90px;" class="transparent-bg-color no-border"><span class="proximanova-bold">Signature:</span></td>
                                        <td class="transparent-bg-color no-border"><u><img src="{{$enrolment_pack->student_signature}}" alt=""></u></td>
                                    </tr>
                                </table>
                                </td>
                            </tr>
                            <tr class="primary-bg-color">
                                <td>
                                    <table id="remove_border">
                                        <tr>
                                            <td width="90px;" class="no-border"><span class="proximanova-bold">Date:</span></td>
                                            <td class="no-border">{{date_format($enrolment_pack->created_at,'F d,Y')}}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="footer bottom-placement px-10-font text-center blue-font-color">
                        <p style="margin-bottom: 2px;">McEvoy & Doust Pty Ltd trading as Community Education Australia | RTO No. 6074| V3.0</p>
                        <p>Page 5</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- End of page 5 -->
<body class="exo2-regular position-relative">
    <div>
        <div class="col-xs-12 no-padding position-relative">
            <div class="pdf-wrapper">
                <div style="padding-bottom: 10px;  margin: 0 10px;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="20%">
                                <div class="eti-logo">
                                    <img src="{{asset('images/logo/cea-logo.png')}}" alt="">
                                </div>
                            </td>
                            <td width="80%">
                                <p class="secondary-font-color px-16-font text-right line-height-1point2">Pre Training Review</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <br><br>
                <div class="clearfix"></div>
                <div style="padding-bottom: 10px;  margin: 20 10px;">
                    <div class="content">
                        <table class="default-bordered-table">
                            <tr class="primary-bg-color">
                                <td colspan="3">
                                <span class="proximanova-bold">To be completed by an authorised delegate of CEA</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"> 
                                <u>
                                    Instructions:
                                </u>
                                <br><br>
                                Please review the information that student has provided on this form and if the information provided
                                is not clear enough, interview the student and ask to elaborate. The information provided through
                                the PTR is important to determine eligibility for the government funding in addition to evaluating
                                information provided on the government funding eligibility declaration.
                                <br><br>
                                Please note LLN test is conducted separately and students are required to meet minimum LLN level
                                requirements. Please refer to LLN test for details.
                                </td>
                            </tr>
                            <tr class="primary-bg-color">
                                <td width="80%">
                                <span class="proximanova-bold">Assessment requirements </span> 
                                </td>
                                <td width="10%">
                                    Yes
                                </td>
                                <td width="10%">
                                    No
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Is the course chosen aligned to the student’s employment history/ career
                                    objectives and aspirations?
                                </td>
                                <td>@if($ptr->inputs->req_skill_awareness==true) <img src="{{asset('cea-lln-test-form/images/checkmark-success.png')}}" alt=""
                                        class="img-responsive" style="width: 15px;"> @endif</td><td>@if($ptr->inputs->req_skill_awareness==false) <img src="{{asset('cea-lln-test-form/images/checkmark-success.png')}}" alt=""
                                        class="img-responsive" style="width: 15px;"> @endif</td>
                            </tr>
                            <tr>
                                <td>
                                    The student is fully aware of the course training and assessment arrangements
                                    i.e. attendance requirements, training and assessment methods, and any
                                    practical training requirements,if applicable?
                                </td>
                                <td>@if($ptr->inputs->course_training_awareness==true) <img src="{{asset('cea-lln-test-form/images/checkmark-success.png')}}" alt=""
                                        class="img-responsive" style="width: 15px;"> @endif</td><td>@if($ptr->inputs->course_training_awareness==false) <img src="{{asset('cea-lln-test-form/images/checkmark-success.png')}}" alt=""
                                        class="img-responsive" style="width: 15px;"> @endif</td>
                            </tr>
                            <tr>
                                <td>
                                   The student is fully aware of their rights and obligations under the funded training place? 
                                </td>
                                <td>@if($ptr->inputs->rights_and_obligation_awareness==true) <img src="{{asset('cea-lln-test-form/images/checkmark-success.png')}}" alt=""
                                        class="img-responsive" style="width: 15px;"> @endif</td><td>@if($ptr->inputs->rights_and_obligation_awareness==false) <img src="{{asset('cea-lln-test-form/images/checkmark-success.png')}}" alt=""
                                        class="img-responsive" style="width: 15px;"> @endif</td>
                            </tr>
                            <tr>
                                <td>
                                    Have you identified any support identified during the process?
                                </td>
                                <td>@if($ptr->inputs->identified_support==true) <img src="{{asset('cea-lln-test-form/images/checkmark-success.png')}}" alt=""
                                        class="img-responsive" style="width: 15px;"> @endif</td><td>@if($ptr->inputs->identified_support==false) <img src="{{asset('cea-lln-test-form/images/checkmark-success.png')}}" alt=""
                                        class="img-responsive" style="width: 15px;"> @endif</td>
                            </tr>
                            <tr>
                                <td>
                                    Training and assessment strategy is suitable and based on the student’s learning
                                    needs and learning styles?
                                </td>
                                <td>@if($ptr->inputs->is_suitable_based_on_learning_style==true) <img src="{{asset('cea-lln-test-form/images/checkmark-success.png')}}" alt=""
                                        class="img-responsive" style="width: 15px;"> @endif</td><td>@if($ptr->inputs->is_suitable_based_on_learning_style==false) <img src="{{asset('cea-lln-test-form/images/checkmark-success.png')}}" alt=""
                                        class="img-responsive" style="width: 15px;"> @endif</td>
                            </tr>
                            <tr>
                                <td>
                                    Is the training suitable and appropriate based on the student’s achievements,
                                    career history, experience, future goals, objectives, capabilities and career
                                    aspirations?
                                </td>
                                <td>@if($ptr->inputs->is_suitable_based_on_achievements==true) <img src="{{asset('cea-lln-test-form/images/checkmark-success.png')}}" alt=""
                                        class="img-responsive" style="width: 15px;"> @endif</td><td>@if($ptr->inputs->is_suitable_based_on_achievements==false) <img src="{{asset('cea-lln-test-form/images/checkmark-success.png')}}" alt=""
                                        class="img-responsive" style="width: 15px;"> @endif</td>
                            </tr>
                            <tr>
                                <td>
                                    The student is aware of RPL and CT arrangements and application process?
                                </td>
                                <td>@if($ptr->inputs->rpl_and_ct_aranagments_awareness==true) <img src="{{asset('cea-lln-test-form/images/checkmark-success.png')}}" alt=""
                                        class="img-responsive" style="width: 15px;"> @endif</td><td>@if($ptr->inputs->rpl_and_ct_aranagments_awareness==false) <img src="{{asset('cea-lln-test-form/images/checkmark-success.png')}}" alt=""
                                        class="img-responsive" style="width: 15px;"> @endif</td>
                            </tr>
                            <tr class="primary-bg-color">
                                <td colspan="3">
                                    <span class="proximanova-bold">Authorised Person’s declaration</span> 
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Based on the information provided on this form, the student meets the
                                    requirements for this course, subject to LLN and funding eligibility criteria. 
                                </td>
                                <td>@if($ptr->inputs->subject_to_lnn_and_funding==true) <img src="{{asset('cea-lln-test-form/images/checkmark-success.png')}}" alt=""
                                        class="img-responsive" style="width: 15px;"> @endif</td><td>@if($ptr->inputs->subject_to_lnn_and_funding==false) <img src="{{asset('cea-lln-test-form/images/checkmark-success.png')}}" alt=""
                                        class="img-responsive" style="width: 15px;"> @endif</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="padding-bottom:50px;">
                                    <span class="proximanova-bold">Comments:</span> <br><br>
                                    <span>{{$ptr->inputs->comments?$ptr->inputs->comments:''}} </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <span class="proximanova-bold">Authorised Person’s Name: {{$ptr->inputs->auth_person_name?$ptr->inputs->auth_person_name:''}}</span> 
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <span class="proximanova-bold">Authorised Person’s Signature:</span> 
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <span class="proximanova-bold">Date: {{$ptr->inputs->auth_person_date?date('F d,Y',strtotime($ptr->inputs->auth_person_date)):''}}</span> 
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="footer bottom-placement px-10-font text-center blue-font-color">
                        <p style="margin-bottom: 2px;">McEvoy & Doust Pty Ltd trading as Community Education Australia | RTO No. 6074| V3.0</p>
                        <p>Page 6</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- end of PTR -->
<!-- Acknowledgement of receipt of Student Handbook and Pre-enrolment information -->
<body class="exo2-regular position-relative">
    <div>
        <div class="col-xs-12 no-padding position-relative">
            <div class="pdf-wrapper">
                <div style="padding-bottom: 10px;  margin: 0 10px;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="20%">
                                <div class="eti-logo">
                                    <img src="{{asset('images/logo/cea-logo.png')}}" alt="">
                                </div>
                            </td>
                            <td width="80%">
                                <p class="secondary-font-color px-16-font text-right line-height-1point2">Pre Training Review</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <br>
                <div class="clearfix"></div>
                <div style="padding-bottom: 10px;  margin: 20 10px;">
                    <div class="content">
                        <div class="width-100-percent">
                        <span class="primary-font-color text-center">
                        Acknowledgement of receipt of Student Handbook and Pre-enrolment information
                        </span>
                        </div>
                        <p>
                            <span class="proximanova-bold">Purpose of this Document:</span>
                            This document is to make sure that every student at Community Education
                            Australia (CEA) has received the pre-enrolment information including the student handbook before the
                            enrollment at the institute so that an informed decision can be made by the student. 
                        </p>
                        <p class="primary-font-color">Marketing and recruitment</p>
                        The information I received about my course before I enrolled (signed up) was true. <br>
                        @if($ptr->inputs->information_confirmation==true)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">YES </label></span>   
                        @if($ptr->inputs->information_confirmation==false)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">NO. </label></span> <br>
                        I knew the name of my training provider before I enrolled (signed up). <br>
                        @if($ptr->inputs->training_provider_confirmation==true)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">YES </label></span>   
                        @if($ptr->inputs->training_provider_confirmation==false)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">NO. </label></span> <br>
                        Did the CEA offer you any incentives to sign up to the course? <br>
                        @if($ptr->inputs->offered_by_cea==true)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">YES </label></span>   
                        @if($ptr->inputs->offered_by_cea==false)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">NO. </label></span> <br>
                        Did the CEA promise or guarantee you would get a job if you completed the course? <br>
                        @if($ptr->inputs->is_promised_to_get_a_job==true)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">YES </label></span>   
                        @if($ptr->inputs->is_promised_to_get_a_job==false)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">NO. </label></span> <br>
                        Was there another organization (different to your training provider) involved in signing you up to
                        this course? <br>
                        @if($ptr->inputs->diff_organization==true)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">YES </label></span>   
                        @if($ptr->inputs->diff_organization==false)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">NO. </label></span> <br>
                        <br>
                        <span class="primary-font-color">Enrolment</span> <br>
                        I understood the length of the course before I enrolled (signed up). <br>
                        @if($ptr->inputs->course_understood==true)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">YES </label></span>   
                        @if($ptr->inputs->course_understood==false)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">NO. </label></span> <br>
                        CEA gave me information about how the course would meet my needs before I
                        enrolled (signed up). <br>
                        @if($ptr->inputs->information_given_by_cea==true)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">YES </label></span>   
                        @if($ptr->inputs->information_given_by_cea==false)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">NO. </label></span> <br>
                        I understood the study requirements before I enrolled (signed up). <br>
                        @if($ptr->inputs->requirements_understood==true)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">YES </label></span>   
                        @if($ptr->inputs->requirements_understood==false)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">NO. </label></span> <br>
                        My rights and responsibilities as a student were explained to me before I enrolled (signed up). <br>
                        @if($ptr->inputs->requirements_explained==true)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">YES </label></span>   
                        @if($ptr->inputs->requirements_explained==false)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">NO. </label></span> <br>
                        The payment terms and conditions were clear to me when I enrolled (signed up). <br>
                        @if($ptr->inputs->terms_and_cons_explained==true)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">YES </label></span>   
                        @if($ptr->inputs->terms_and_cons_explained==false)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">NO. </label></span> <br>
                        I was aware of CEA refund policy when I enrolled (signed up). <br>
                        @if($ptr->inputs->refund_policy_awareness==true)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">YES </label></span>   
                        @if($ptr->inputs->refund_policy_awareness==false)<span class="checkbox checked">@else<span class="checkbox">@endif<label class="label label-checkbox dark-grey-font-color">NO. </label></span> <br>
                        <br>
                        I herewith confirm that I have received the Student Handbook and Pre-enrolment
                        information prior to enrolment and understand the contents. I agree with the
                        information provided by the CEA. <br>
                        <br>
                        <p>
                        <span class="proximanova-bold">Name: {{$enrolment_pack->student_name}}</span>
                        <p>
                        <span class="proximanova-bold">Signature: <img src="{{$enrolment_pack->student_signature}}" alt=""></span>
                        </p>
                        <p>
                        <span class="proximanova-bold">Date: {{date_format($enrolment_pack->created_at,'F d,Y')}}</span>
                        </p>
                    </div>
                    <div class="footer bottom-placement px-10-font text-center blue-font-color">
                        <p style="margin-bottom: 2px;">McEvoy & Doust Pty Ltd trading as Community Education Australia | RTO No. 6074| V3.0</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<body class="exo2-regular position-relative">
    <div>
        <div class="col-xs-12 no-padding position-relative">
            <div class="pdf-wrapper">
                <div style="padding-bottom: 10px;  margin: 0 10px;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="20%">
                                <div class="eti-logo">
                                    <img src="{{asset('images/logo/cea-logo.png')}}" alt="">
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <br>
                <div class="clearfix"></div>
                <div style="padding-bottom: 10px;  margin: 20 10px;">
                    <div class="content">
                    <div class="text-center">
                    <span class="proximanova-bold">Institute’s General Information</span>
                    </div>
                    <br>
                        <table class="default-bordered-table">
                            <tr>
                                <td width="50%"><span class="proximanova-bold">Operation Hours</span></td>
                                <td width="50%">9:30 Am to 5:30 PM</td>
                            </tr>
                            <tr>
                                <td valign="top"><span class="proximanova-bold">Training Hours</span></td>
                                <td>
                                Classes will be running according to the time
                                table/training plan provided to you. Classes hours may
                                be different than normal operating hours. The CEA
                                delegate will tell you the timing of your class.
                                </td>
                            </tr>
                            <tr>
                                <td valign="top"><span class="proximanova-bold">Common Areas</span></td>
                                <td>
                                Lunch, toilet are for your convenience.
                                Please respect others in maintaining hygiene and
                                cleanliness. (please note that no food or drink or
                                chewing gum in the class rooms allowed)
                                </td>
                            </tr>
                            <tr>
                                <td><span class="proximanova-bold">Client Reception</span></td>
                                <td>
                                This area is for clients waiting for services only. It is not
                                a resting place or meeting place for students
                                </td>
                            </tr>
                            <tr>
                                <td><span class="proximanova-bold">Smoking</span></td>
                                <td>
                                The building is a smoke free environment.
                                </td>
                            </tr>
                            <tr>
                                <td valign="top"><span class="proximanova-bold">Dressing</span></td>
                                <td>
                                Students are required to present a professional image,
                                just as you would in a Job.
                                </td>
                            </tr>
                            <tr>
                                <td valign="top"><span class="proximanova-bold">Vulgar Language</span></td>
                                <td>
                                Vulgar language or obscene talk will not be tolerated
                                under any circumstances
                                </td>
                            </tr>
                            <tr>
                                <td valign="top"><span class="proximanova-bold">College Property</span></td>
                                <td>
                                Payment for damage or breakages of college property
                                will be the responsibility of the student
                                </td>
                            </tr>
                            <tr>
                                <td><span class="proximanova-bold">Emergency Contact Person</span></td>
                                <td>
                                Your trainer will be the first point of contact.
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="footer bottom-placement px-10-font text-center blue-font-color">
                        <p style="margin-bottom: 2px;">© CEA Version 1.0 | RTO No. 6074 </p>
                        <p>Page 1</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- end of institutes general info -->
</html>

