<?php

namespace App\Http\Controllers\PreTraining;

use App\Http\Controllers\Controller;
use App\Models\EnrolmentPack;
use Illuminate\Http\Request;

class PtrPagesController extends Controller
{
    public function get_pages($process_id){
        $app_name = config('app.name');

        if($app_name=='CEA'){
            return $this->cea($process_id);
        }else if($app_name=='Phoenix'){
            return $this->phx($process_id);
        }else{
            return abort(404);
        }
    }

    public function cea($process_id){//community education of australia    
        $enrolment_pack = EnrolmentPack::where('process_id',$process_id)->first();
        $training_program = $enrolment_pack->enrolment_form['course']['name'];
        $student_type = $enrolment_pack->student_type_id;

        $pages = [
            [
                'component'=>[//start component
                    [
                        'title' => '1.',
                        'inputs' => [
                            [
                                'type'=>'text',
                                'name'=>'training_program',
                                'label'=>'Training Program',
                                'required'=>true,
                                'value'=>$training_program,
                                'readOnly'=>true,
                                'col_size'=>12
                            ],
                            [
                                'type'=>'card',
                                'label'=>'Pre-Training Review(PTR)',
                                'content'=>[
                                    [
                                    'type'=>'paragraph',
                                    'body'=>'Community Education Australia (CEA) is required to conduct a Pre-Training Review (PTR) of all students who would like to undertake training with Community Education Australia. '
                                    ]
                                ],
                                'col_size'=>12
                            ],
                            [
                                'type'=>'card',
                                'label'=>'Purpose of PTR',
                                'content'=>[
                                    [
                                    'type'=>'paragraph',
                                    'body'=>'Main objectives of the PTR are to:
                                        <ul>
                                            <li>Identify any competencies previously acquired (RPL) or credit transfer);</li>
                                            <li>Ascertain a suitable, and the most suitable qualification or that student to enrol in, based on the individual’s existing educational attainment, capabilities, aspirations and interests and with due consideration of the likely job outcomes from the development of new competencies and skills; </li>
                                            <li>Ascertain that the proposed learning strategies and materials are appropriate for that individual</li>
                                        </ul>
                                        All students are required to complete this PTR in order to gain entry into the desired course and service. 
                                    '
                                    ]
                                ],
                                'col_size'=>12
                            ],
                            [
                            'type'=>'card',
                            'label'=>'Instructions for all students ',
                            'content'=>[
                                [
                                'type'=>'paragraph',
                                'body'=>'Prior to completing the PTR, make sure you have sufficient information about the course. In particular, you must have access to the following:
                                    <ul>
                                        <li>Training and Assessment arrangements i.e. duration of the course, training & assessment modes, days of training, assessments to be completed and any practical placement arrangements, attendance requirements; </li>
                                        <li>Employment prospects – you should conduct your own research and have strong evidence of employability options on course completion;</li>
                                        <li>Recognition of prior learning and credit transfer application process;</li>
                                        <li>Fees and charges applicable for the training;</li>
                                        <li>Your obligation under the funded program i.e. participation in surveys, interviews, questionnaires, etc. </li>
                                        <li>Government funding (for the state) eligibility criteria and how it will affect your future funding eligibility options. </li>
                                        <li>Your rights and obligations as a student at Community Education Australia; </li>
                                        <li>Entry requirements into the course</li>
                                    </ul>
                                '
                                ]
                            ],
                            'col_size'=>12
                            ]
                        ]
                    ]
                ]
            ],
            [
                'component'=>[//start
                    [
                        'title' => '2.',
                        'inputs' => [
                            [
                                'type'=>'card',
                                'label'=>'Instructions for completing the PTR  ',
                                'content'=>[
                                    [
                                        'type'=>'paragraph',
                                        'body'=>'Please ensure each question is answered as accurately as possible. If you require more space to write your response to a question, please attach a second sheet and number the responses. '
                                    ]
                                ],
                                'col_size'=>12
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'student_goals',
                                'rows'=>'8',
                                'label'=>'Tell us what you want to be in your life?  It could be your short term or long-term goal.',
                                'col_size'=>12,
                                'value'=>''
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'student_interests',
                                'rows'=>'3',
                                'label'=>'What course(s) are you interested in?  Write down the Code(s) and Title(s) you saw in our Marketing Material. ',
                                'col_size'=>12,
                                'value'=>''
                            ],
                            [
                                'type'=>'multiselect',
                                'name'=>'why_chose_this_course',
                                'label'=>'Briefly explain why you have chosen this course?',
                                'mTrackBy'=>'id',
                                'multiselect'=>true,
                                'col_size'=>12,
                                'value'=>'',
                                'selections'=>[
                                    [
                                        'id'=>0,
                                        'value'=>'To get a job'
                                    ],
                                    [
                                        'id'=>1,
                                        'value'=>'To develop or start my own business'
                                    ],
                                    [
                                        'id'=>2,
                                        'value'=>'To try for a different career'
                                    ],
                                    [
                                        'id'=>3,
                                        'value'=>' To get a better job or promotion'
                                    ],
                                    [
                                        'id'=>4,
                                        'value'=>'It is a requirement of my job'
                                    ],
                                    [
                                        'id'=>5,
                                        'value'=>'I want extra skills for my job'
                                    ],
                                    [
                                        'id'=>6,
                                        'value'=>'To improve my general educational skills'
                                    ],
                                    [
                                        'id'=>7,
                                        'value'=>'To get skills for community/voluntary work'
                                    ],
                                    [
                                        'id'=>8,
                                        'value'=>'To increase my self-esteem'
                                    ],
                                    
                                ]
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'course_exp_specified',
                                'rows'=>4,
                                'label'=>'Other reason (please specify)',
                                'col_size'=>12,
                                'value'=>''
                            ]
                        ]
                    ]
                ]//end
            ],
            [
                'component'=>[//start
                    [
                        'title'=>'3.',
                        'inputs'=>[
                            [
                                'type'=>'multiselect',
                                'name'=>'liked_cea_supp_service',
                                'label'=>'What CEA Support Service are you most likely to use during your study?',
                                'mTrackBy'=>'id',
                                'multiselect'=>true,
                                'col_size'=>12,
                                'value'=>'',
                                'selections'=>[
                                    [
                                        'id'=>0,
                                        'value'=>'LLN Support'
                                    ],
                                    [
                                        'id'=>1,
                                        'value'=>'Academic Support'
                                    ],
                                    [
                                        'id'=>2,
                                        'value'=>'Employment Help'
                                    ],
                                    [
                                        'id'=>3,
                                        'value'=>'None'
                                    ]
                                ]
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'liked_cea_supp_spec',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>'Other support service (Please specify below)',
                                'value'=>''
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'outcome_awareness',
                                'label'=>'Are you aware of learning outcomes of this course? ',
                                'value' => false,
                                'required'=> true,
                                'tooltip'=>'Note:(Students will be explained the learning outcomes of the course by the CEA delegate and also you will be handed over the student Handbook during the orientation and induction session) ',
                                'col_size'=>12
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'req_skill_awareness',
                                'label'=>'Are you aware of skills required to work in the industry you have chosen? ',
                                'value' => false,
                                'required'=> true,
                                'tooltip'=>'Note: Students will be explained the skills required to work in the industry during the orientation and induction session.',
                                'col_size'=>12
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'ct_rpl_awareness',
                                'label'=>'Do you know about Credit transfer (CT) and Recognition of Prior Learning (RPL) process of CEA?',
                                'value' => false,
                                'required'=> true,
                                'tooltip'=>'Note: Students will be explained the RPL and CT process of CEA during the enrolment. ',
                                'col_size'=>12
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'industry_experience',
                                'label'=>'Have you ever worked in the industry in which you are seeking training?',
                                'value' => false,
                                'required'=> true,
                                'col_size'=>12
                            ],
                        ]
                    ],
                    [
                        'title'=>'4.',
                        'inputs'=>[
                            [
                                'type'=>'multiselect',
                                'name'=>'determine_learning_style',
                                'label'=>'The following information will help us to determine your learning styles and if we are able to deliver courses that meet your learning styles.  (Tick the most relevant) ',
                                'mTrackBy'=>'id',
                                'multiselect'=>true,
                                'col_size'=>12,
                                'value'=>'',
                                'selections'=>[
                                    [
                                        'id'=>0,
                                        'value'=>'Textbooks that I can read and refer to in my own time;'
                                    ],
                                    [
                                        'id'=>1,
                                        'value'=>'Power Points explained to me during classes;'
                                    ],
                                    [
                                        'id'=>2,
                                        'value'=>'Pictures and diagrams;'
                                    ],
                                    [
                                        'id'=>3,
                                        'value'=>'Group discussions with others;'
                                    ],
                                    [
                                        'id'=>4,
                                        'value'=>'Conducting my own research'
                                    ],
                                    [
                                        'id'=>5,
                                        'value'=>'Listening to the lectures/ trainers;'
                                    ],
                                    [
                                        'id'=>6,
                                        'value'=>'Practical application of skills and knowledge in a workplace or similar or watching videos;'
                                    ]
                                ]
                            ],
                                [
                                    'type'=>'textarea',
                                    'name'=>'learning_style_spec',
                                    'rows'=>4,
                                    'value'=>'',
                                    'label'=>'Other reason (please specify)',
                                    'col_size'=>12
                                ]
                        ]   
                    ],
                ]
            ],
            [
                'component'=>[//start
                    [
                        'title'=>'5.',
                        'inputs'=>[
                            [
                                'type'=>'multiselect',
                                'name'=>'additional_course_to_complete',
                                'label'=>'What additional support do you think you will need in order to complete this course successfully?',
                                'mTrackBy'=>'id',
                                'multiselect'=>true,
                                'col_size'=>12,
                                'value'=>'',
                                'selections'=>[
                                    [
                                        'id'=>0,
                                        'value'=>'English language support; '
                                    ],
                                    [
                                        'id'=>1,
                                        'value'=>'Reading support; '
                                    ],
                                    [
                                        'id'=>2,
                                        'value'=>'Writing support;  '
                                    ],
                                    [
                                        'id'=>3,
                                        'value'=>'One-on-one guidance;  '
                                    ],
                                    [
                                        'id'=>4,
                                        'value'=>'Additional resources:'
                                    ],
                                    [
                                        'id'=>5,
                                        'value'=>'None'
                                    ]
                                ]
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'add_course_spec',
                                'rows'=>3,
                                'label'=>'Other reason (please specify)',
                                'col_size'=>12,
                                'value'=>''
                            ],
                            [
                                'type' => 'card',
                                'label' => '',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'The following information will ensure that you are aware of your rights and obligations under the funding contract and being a student at CEA. '
                                    ]
                                ]
                            ],
                            [
                                'type'=>'multiselect',
                                'name'=>'course_enrolment_awareness',
                                'label'=>'If you are eligible for Government funding, do you understand how enrolment in this course/s will affect your future eligibility for government-subsidised training?  Ask CEA staff if you are unsure.',
                                'mTrackBy'=>'id',
                                'multiselect'=>false,
                                'col_size'=>12,
                                'value'=>['id'=>2,'value'=>'N/A'],
                                'selections'=>[
                                    [
                                        'id'=>0,
                                        'value'=>'Yes'
                                    ],
                                    [
                                        'id'=>1,
                                        'value'=>'No'
                                    ],
                                    [
                                        'id'=>2,
                                        'value'=>'N/A'
                                    ],
                                ]
                            ],
                            [
                                'type'=>'multiselect',
                                'name'=>'ncver_awareness',
                                'label'=>'Are you aware that you may be required to participate in NCVER or funding department surveys or interviews?  Ask CEA staff if you are unsure. ',
                                'mTrackBy'=>'id',
                                'multiselect'=>false,
                                'col_size'=>12,
                                'value'=>['id'=>2,'value'=>'N/A'],
                                'selections'=>[
                                    [
                                        'id'=>0,
                                        'value'=>'Yes'
                                    ],
                                    [
                                        'id'=>1,
                                        'value'=>'No'
                                    ],
                                    [
                                        'id'=>2,
                                        'value'=>'N/A'
                                    ],
                                ]
                            ],
                            [
                                'type'=>'multiselect',
                                'name'=>'enrolment_fees_awareness',
                                'label'=>'Are you aware of any fees and charges applicable to your enrolment, including any refund policy?  Ask CEA staff if you are unsure.',
                                'mTrackBy'=>'id',
                                'multiselect'=>false,
                                'col_size'=>12,
                                'value'=>['id'=>2,'value'=>'N/A'],
                                'selections'=>[
                                    [
                                        'id'=>0,
                                        'value'=>'Yes'
                                    ],
                                    [
                                        'id'=>1,
                                        'value'=>'No'
                                    ],
                                    [
                                        'id'=>2,
                                        'value'=>'N/A'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'caap_awareness',//complaints and appeals policy awareness
                                'label'=>'Are you aware of complaints and appeals policy of CEA?  Ask CEA staff if you are unsure.',
                                'value' => false,
                                'required'=> true,
                                'col_size'=>12
                            ]
                        ]
                    ],
                    [
                        'title'=>'6.',
                        'inputs'=>[
                            [
                                'type' => 'checkbox',
                                'name'=>'attendance_requirements_awareness',
                                'label'=>'Are you aware of course attendance requirements, and training and assessment arrangements?  Ask CEA staff if you are unsure. ',
                                'value' => false,
                                'required'=> true,
                                'col_size'=>12
                            ],
                            [
                                'type'=>'multiselect',
                                'name'=>'eligable_funding_awareness',
                                'label'=>'If you are not eligible for Government funding, do you understand how enrolment in this course/s will affect your future eligibility for government-subsidised training?  Ask CEA staff if you are unsure.',
                                'mTrackBy'=>'id',
                                'multiselect'=>false,
                                'col_size'=>12,
                                'value'=>['id'=>2,'value'=>'N/A'],
                                'selections'=>[
                                    [
                                        'id'=>0,
                                        'value'=>'Yes'
                                    ],
                                    [
                                        'id'=>1,
                                        'value'=>'No'
                                    ],
                                    [
                                        'id'=>2,
                                        'value'=>'N/A'
                                    ],
                                ]
                            ],
                        ]
                    ],
                ]//end
            ],
            [
                'component'=>[//start
                    [
                        'title'=>'7.',
                        'inputs'=>[
                            [
                                'label'=>'To be completed by an authorised delegate of CEA ',
                                'type'=>'card',
                                'col_size'=>12,
                                'tooltip'=>'Please note LLN test is conducted separately and students are required to meet minimum LLN level requirements.  Please refer to LLN test for details. ',
                                'content'=>[
                                    [
                                        'type'=>'paragraph',
                                        'body'=>'<u>Instructions:</u>'
                                    ],
                                    [
                                        'type'=>'paragraph',
                                        'body'=>'Please review the information that student has provided on this form and if the information provided is not clear enough, interview the student and ask to elaborate.  The information provided through the PTR is important to determine eligibility for the government funding in addition to evaluating information provided on the government funding eligibility declaration. '
                                    ]
                                ]
                            ],
                            [
                                'type'=>'card',
                                'label'=>'Assesment requirements',
                                'col_size'=>12
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'course_aligned_to_employment',
                                'label'=> 'Is the course chosen aligned to the student’s employment history/ career objectives and aspirations?',
                                'value' => false,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'course_training_awareness',
                                'label'=> 'The student is fully aware of the course training and assessment arrangements i.e. attendance requirements, training and assessment methods, and any practical training requirements,if applicable?',
                                'value' => false,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'rights_and_obligation_awareness',
                                'label'=> 'The student is fully aware of their rights and obligations under the funded training place? ',
                                'value' => false,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'identified_support',
                                'label'=> 'Have you identified any support identified during the process?',
                                'value' => false,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'is_suitable_based_on_learning_style',
                                'label'=> 'Training and assessment strategy is suitable and based on the student’s learning needs and learning styles? ',
                                'value' => false,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'is_suitable_based_on_achievements',
                                'label'=> 'Is the training suitable and appropriate based on the student’s achievements, career history, experience, future goals, objectives, capabilities and career aspirations?',
                                'value' => false,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'rpl_and_ct_aranagments_awareness',
                                'label'=> 'The student is aware of RPL and CT arrangements and application process? ',
                                'value' => false,
                                'col_size' => 12,
                            ],
                            [
                                'type'=>'card',
                                'label'=>'Authorised Person’s declaration'
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'subject_to_lnn_and_funding',
                                'label'=> 'Based on the information provided on this form, the student meets the requirements for this course, subject to LLN and funding eligibility criteria.  ',
                                'value' => false,
                                'col_size' => 12,
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'comments',
                                'label'=>'Comments:',
                                'value'=>'',
                                'col_size'=>12,
                                'rows'=>8
                            ],
                            [
                                'type'=>'text',
                                'name'=>'auth_person_name',
                                'label'=>"Authorised Person's Name",
                                'value'=>''
                            ],
                            [
                                'type' => 'date',
                                'name' => 'auth_person_date',
                                'label' => 'Date',
                                'value'=>''
                            ],
                        ]
                    ]
                ]//end
            ],
            [
                'component'=>[//start
                    [
                        'title'=>'8',
                        'inputs'=>[
                            [
                                'label'=>'Acknowledgement of receipt of Student Handbook and Pre-enrolment information',
                                'type'=>'card',
                                'col_size'=>12,
                                'content'=>[
                                    [
                                        'type'=>'paragraph',
                                        'body'=>'Purpose of this Document: This document is to make sure that every student at Community Education Australia (CEA) has received the pre-enrolment information including the student handbook before the enrollment at the institute so that an informed decision can be made by the student.'
                                    ]
                                ]
                            ],
                            [
                                'label'=>'Marketing and recruitment',
                                'type'=>'card',
                                'col_size'=>12
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'information_confirmation',//
                                'label'=>'The information I received about my course before I enrolled (signed up) was true.',
                                'value' => false,
                                'required'=> true,
                                'col_size'=>12
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'training_provider_confirmation',//
                                'label'=>'I knew the name of my training provider before I enrolled (signed up).',
                                'value' => false,
                                'required'=> true,
                                'col_size'=>12
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'offered_by_cea',//
                                'label'=>'Did the CEA offer you any incentives to sign up to the course?',
                                'value' => false,
                                'required'=> true,
                                'col_size'=>12
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'is_promised_to_get_a_job',//
                                'label'=>'Did the CEA promise or guarantee you would get a job if you completed the course?',
                                'value' => false,
                                'required'=> true,
                                'col_size'=>12
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'diff_organization',//
                                'label'=>'Was there another organization (different to your training provider) involved in signing you up to this course?',
                                'value' => false,
                                'required'=> true,
                                'col_size'=>12
                            ],
                            [
                                'label'=>'Enrolment',
                                'type'=>'card',
                                'col_size'=>12
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'course_understood',//
                                'label'=>'I understood the length of the course before I enrolled (signed up).',
                                'value' => false,
                                'required'=> true,
                                'col_size'=>12
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'information_given_by_cea',//
                                'label'=>'CEA gave me information about how the course would meet my needs before I enrolled (signed up).',
                                'value' => false,
                                'required'=> true,
                                'col_size'=>12
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'requirements_understood',//
                                'label'=>'I understood the study requirements before I enrolled (signed up).',
                                'value' => false,
                                'required'=> true,
                                'col_size'=>12
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'requirements_explained',//
                                'label'=>'My rights and responsibilities as a student were explained to me before I enrolled (signed up).',
                                'value' => false,
                                'required'=> true,
                                'col_size'=>12
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'terms_and_cons_explained',//
                                'label'=>'The payment terms and conditions were clear to me when I enrolled (signed up).',
                                'value' => false,
                                'required'=> true,
                                'col_size'=>12
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'refund_policy_awareness',//
                                'label'=>'I was aware of CEA refund policy when I enrolled (signed up).',
                                'value' => false,
                                'required'=> true,
                                'col_size'=>12
                            ],
                        ]
                    ]
                ]//end
            ]
        ];

        return $pages;
    }

    public function phx($process_id){//phoenix 
        $enrolment_pack = EnrolmentPack::where('process_id',$process_id)->first();
        $training_program = $enrolment_pack->enrolment_form['course']['name'];
        $student_type = $enrolment_pack->student_type_id;
        $pages = [
            [
                'component'=>[//start component
                    [
                        'title' => '1.',
                        'inputs' => [
                            [
                                'type'=>'text',
                                'name'=>'student_name',
                                'label'=>'Student Name',
                                'required'=>true,
                                'readOnly'=>true,
                                'value'=>$enrolment_pack->student_name,
                                'col_size'=>12
                            ],
                            [
                                'type'=>'text',
                                'name'=>'training_program',
                                'label'=>'Training Program',
                                'required'=>true,
                                'readOnly'=>true,
                                'value'=>$training_program,
                                'col_size'=>12
                            ],
                            [
                                'type'=>'card',
                                'label'=>'Pre-Training Review(PTR)',
                                'content'=>[
                                    [
                                    'type'=>'paragraph',
                                    'body'=>'Phoenix College of Australia (PCA) is required to conduct a Pre-Training Review (PTR) of all students who would like to undertake training with Phoenix College of Australia.'
                                    ]
                                ],
                                'col_size'=>12
                            ],
                            [
                                'type'=>'card',
                                'label'=>'Purpose of PTR',
                                'content'=>[
                                    [
                                    'type'=>'paragraph',
                                    'body'=>'Main objectives of the PTR are to:
                                        <ul>
                                            <li>Ascertain the individual’s aspirations and interests with due consideration of the likely job outcomes from the development of new competencies and skills;</li>
                                            <li>Consideration of Literacy and Numeracy skills through an LLN test or meeting the course entry requirements.</li>
                                            <li>Identify any competencies previously acquired (RPL) or credit transfer);</li>
                                            <li>Ascertain a suitable, and the most suitable qualification or that student to enrol in, based on the individual’s existing educational attainment, capabilities, aspirations and interests and with due consideration of the likely job outcomes from the development of new competencies and skills;</li>
                                            <li>Ascertain that the proposed learning strategies and materials are appropriate for that individual;</li>   
                                        </ul>
                                        All students are required to complete this PTR in order to gain entry into the desired course and service.
                                    '
                                    ]
                                ],
                                'col_size'=>12
                            ],
                            [
                            'type'=>'card',
                            'label'=>'Instructions for all students ',
                            'content'=>[
                                [
                                'type'=>'paragraph',
                                'body'=>'Prior to completing the PTR, make sure you have sufficient information about the course. In particular, you must have access to the following:
                                    <ul>
                                        <li>Training and Assessment arrangements i.e. duration of the course, training & assessment modes, days of training, assessments to be completed and any practical placement arrangements, attendance requirements; </li>
                                        <li>Employment prospects – you should conduct your own research and have strong evidence of employability options on course completion;</li>
                                        <li>Recognition of prior learning and credit transfer application process;</li>
                                        <li>Fees and charges applicable for the training;</li>
                                        <li>Your obligation as '.$student_type==1?"an international":"a".' student i.e. participation in surveys, interviews, questionnaires, etc.</li>
                                        <li>Your rights and obligations as a student at Phoenix College of Australia; </li>
                                        <li>Entry requirements into the course</li>
                                    </ul>
                                '
                                ]
                            ],
                            'col_size'=>12
                            ]
                        ]
                    ]
                ]
            ],
            [
                'component'=>[//start
                    [
                        'title' => '2.',
                        'inputs' => [
                            [
                                'type'=>'card',
                                'label'=>'Instructions for completing the PTR  ',
                                'content'=>[
                                    [
                                        'type'=>'paragraph',
                                        'body'=>'Please ensure each question is answered as accurately as possible. If you require more space to write your response to a question, please attach a second sheet and number the responses. '
                                    ]
                                ],
                                'col_size'=>12
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'student_goals',
                                'rows'=>'8',
                                'label'=>'What are your aspirations and interests?',
                                'col_size'=>12,
                                'value'=>''
                            ],
                            [
                                'type'=>'card',
                                'label'=>'As applicable, consider and document:',
                                'col_size'=>12,
                                'content'=>[
                                    [
                                    'type'=>'paragraph',
                                    'body'=>'
                                        <ul>
                                            <li>Career aspirations</li>
                                            <li>Interests</li>
                                            <li>Strengths</li>
                                            <li>Weaknesses</li>
                                            <li>Reasons for enrolling in the course, including expectations and objectives</li>
                                            <li>The likely job or further study prospects resulting from the training </li>
                                        </ul>
                                    '
                                    ]
                                ]
                            ],
                            [
                                'type'=>'card',
                                'label'=>'Rationale:',
                                'col_size'=>12,
                                'content'=>[
                                    [
                                    'type'=>'paragraph',
                                    'body'=>'The student should not be enrolled in a training program they are not interested in.
                                    The chosen training program links to likely job, participation and/or further study opportunities and/or access to training for disadvantaged learners
                                    
                                    '
                                    ]
                                ]
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'student_interests',
                                'rows'=>'3',
                                'label'=>'What course(s) are you interested in? ',
                                'col_size'=>12,
                                'value'=>''
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'proposed_learning_stategies',
                                'label'=>'Are you familiar with the proposed learning strategies and materials to be used in the chosen course?',
                                'value' => false,
                                'required'=> true,
                                'col_size'=>12
                            ],
                        ]
                    ]
                ]//end
            ],
            [
                'component'=>[//start
                    [
                        'title'=>'3.',
                        'inputs'=>[
                            [
                                'type' => 'checkbox',
                                'name' => 'learning_strat_issues',
                                'label'=>'Do you think that proposed learning strategies and materials may pose potential issues/challenges/barriers for you? ',
                                'value' => false,
                                'required'=> true,
                                'col_size'=>12
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'learning_strat_issues_spec',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>'If yes, please specify:',
                                'value'=>''
                            ],
                            [
                                'type'=>'card',
                                'label'=>'Please consider and note:',
                                'content'=>[
                                    [
                                    'type'=>'paragraph',
                                    'body'=>"
                                        <ul>
                                            <li>Special needs</li>
                                            <li>Disability</li>
                                            <li>The student's personal circumstances</li>
                                            <li>Preferred learning style</li>
                                            <li>Adequacy/appropriateness of learning materials </li>   
                                            <li>Any additional support or adjustments the student may require, to also be documented in the Training Plan</li>
                                        </ul>
                                        All students are required to complete this PTR in order to gain entry into the desired course and service.
                                    "
                                    ]
                                ],
                                'col_size'=>12
                            ],
                            [
                                'type'=>'card',
                                'label'=>'Rationale:',
                                'col_size'=>12,
                                'content'=>[
                                    [
                                    'type'=>'paragraph',
                                    'body'=>'Proper consideration is given to whether the proposed learning strategies and materials in the TAS are appropriate for the student; and whether adjustments need to be made to suit the student’s individual needs.
                                    '
                                    ]
                                ]
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'relevant_comp',
                                'label'=>'Have you previously acquired any qualification or any relevant competencies? ',
                                'value' => false,
                                'required'=> true,
                                'col_size'=>12
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'relevant_comp_spec',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>'If yes, please specify:',
                                'value'=>''
                            ],
                            [
                                'type'=>'card',
                                'label'=>'As applicable, consider and document:',
                                'col_size'=>12,
                                'content'=>[
                                    [
                                    'type'=>'paragraph',
                                    'body'=>'
                                        <ul>
                                            <li>RPL</li>
                                            <li>Recognition of current competency (RCC)</li>
                                            <li>Credit transfer</li>
                                            <li>The options offered to the student for applying competencies to this training program</li>
                                        </ul>
                                    '
                                    ]
                                ]
                            ],
                            [
                                'type'=>'card',
                                'label'=>'Rationale:',
                                'col_size'=>12,
                                'content'=>[
                                    [
                                    'type'=>'paragraph',
                                    'body'=>'The student does not undertake any unnecessary training that duplicates competencies.<br><br>
                                    If you would like to apply for Credit Transfer, please provide certified copies of these qualifications and we will assess your application and get back to you as soon as possible.
                                    '
                                    ]
                                ]
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'familiar_entry_requirements',
                                'label'=>'Are you familiar with entry requirements to gain entry into the qualification?',
                                'value' => false,
                                'required'=> true,
                                'col_size'=>12
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'meeting_requirement',
                                'label'=>'Are you meeting the requirements to gain entry into the course?',
                                'value' => false,
                                'required'=> true,
                                'col_size'=>12
                            ],
                        ]
                    ],
                    
                ]
            ],
            [
                'component'=>[//start
                    [
                        'title'=>'4.',
                        'inputs'=>[
                            [
                                'type'=>'card',
                                'label'=>'As applicable, consider and document:',
                                'col_size'=>12,
                                'content'=>[
                                    [
                                    'type'=>'paragraph',
                                    'body'=>'
                                        <ul>
                                            <li>Results of LLN testing (if required) – as determined using the training provider’s business process for literacy and numeracy testing</li>
                                            <li>The AQF level of the proposed qualification </li>
                                            <li>Secondary school results </li>
                                            <li>Issues that may prevent the student from successfully completing the training</li>
                                            <li>Any additional LLN support the student may require, to also be documented in the Training Plan.</li>
                                            <li>Other documents submitted with the application, which meet the entry requirements of the course. </li>
                                        </ul>
                                    '
                                    ]
                                ]
                            ],
                            [
                                'type'=>'card',
                                'label'=>'Rationale:',
                                'col_size'=>12,
                                'content'=>[
                                    [
                                    'type'=>'paragraph',
                                    'body'=>'This will indicate that the student has the ability to successfully complete the training program, or can be provided with reasonable and accessible support to assist them to complete the training. 
                                    '
                                    ]
                                ]
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'why_chose',
                                'label' => 'Briefly explain why you have chosen this course?',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'description'=>'To get a job '
                                    ],
                                    [
                                        'description'=>'To develop or start my own business  '
                                    ],
                                    [
                                        'description'=>'To try for a different career   '
                                    ],
                                    [
                                        'description'=>'To get a better job or promotion   '
                                    ],
                                    [
                                        'description'=>'It is a requirement of my job '
                                    ],
                                    [
                                        'description'=>'I want extra skills for my job '
                                    ],
                                    [
                                        'description'=>'To improve my general educational skills '
                                    ],
                                    [
                                        'description'=>'To get skills for community/voluntary work  '
                                    ],
                                    [
                                        'description'=>'To increase my self-esteem  '
                                    ]
                                ]
                            ],
                            
                            //
                            [
                                'type'=>'textarea',
                                'name'=>'why_choose_spec',
                                'rows'=>3,
                                'label'=>'Other reason (please specify)',
                                'col_size'=>12,
                                'value'=>''
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'support_service',
                                'label' => 'What PCA Support Service are you most likely to use during your study? ',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'description'=>'LLN Support'
                                    ],
                                    [
                                        'description'=>'Academic Support'
                                    ],
                                    [
                                        'description'=>'Employment Help'
                                    ],
                                    [
                                        'description'=>'No support required'
                                    ],
                                ]
                            ],
                            
                            //
                            [
                                'type'=>'textarea',
                                'name'=>'support_service_spec',
                                'rows'=>3,
                                'label'=>'Other support service (Please specify below)',
                                'col_size'=>12,
                                'value'=>''
                            ],
                            
                        ]
                    ],
                ]//end
            ],
            [
                'component'=>[//start
                    [
                        'title'=>'5.',
                        'inputs'=>[
                            [
                                'type' => 'checkbox',
                                'name' => 'role_play',
                                'label'=> 'As you know, you may be required to participate in the role plays for your chosen course, is there anything that might prevent you from progressing through the training and assessment program? For example, physical injuries or language barrier etc.',
                                'value' => false,
                                'col_size' => 12,
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'role_play_spec',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>'If yes, please specify:',
                                'value'=>''
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'course_outcomes_awareness',
                                'tooltip'=>'Students will be explained the learning outcomes of the course by the PCA delegate and also you will be handed over the student Handbook during the orientation and induction session',
                                'label'=> 'Are you aware of learning outcomes of this course?',
                                'value' => false,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'skills_req_awareness',
                                'tooltip'=>'Students will be explained the skills required to work in the industry during the orientation and induction session.',
                                'label'=> 'Are you aware of skills required to work in the industry you have chosen?',
                                'value' => false,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'ct_awareness',
                                'tooltip'=>'Students will be explained the RPL and CT process of PCA during the orientation and induction session.',
                                'label'=> 'Do you know about Credit transfer (CT) and Recognition of Prior Learning (RPL) process of PCA?',
                                'value' => false,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'prev_attainments',
                                'label'=> 'Have you got any previous educational attainments and capabilities?',
                                'value' => false,
                                'col_size' => 12,
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'prev_attainments_spec',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>'If yes, please specify:',
                                'value'=>''
                            ],
                            [
                                'type'=>'card',
                                'label'=>'As applicable, consider and document:',
                                'col_size'=>12,
                                'content'=>[
                                    [
                                    'type'=>'paragraph',
                                    'body'=>'The student’s existing educational attainment and capabilities including
                                        <ul>
                                            <li>Prior learning</li>
                                            <li>Whether the course entry requirements and pre-requisites are met</li>
                                            <li>Employment experience</li>
                                            <li>Volunteering</li>
                                        </ul>
                                    '
                                    ]
                                ]
                            ],
                            [
                                'type'=>'card',
                                'label'=>'Rationale:',
                                'col_size'=>12,
                                'content'=>[
                                    [
                                    'type'=>'paragraph',
                                    'body'=>'The student is enrolled in a training program that is at the appropriate level for them.
                                    '
                                    ]
                                ]
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'currently_working',
                                'label'=> 'Are you currently working in the industry in which you are seeking training?',
                                'value' => false,
                                'col_size' => 12,
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'currently_working_spec',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>'Position/title',
                                'value'=>''
                            ],
                            [
                                'type'=>'card',
                                'col_size'=>12,
                                'content'=>[
                                    [
                                        'type'=>'paragraph',
                                        'body'=>'If you would like to apply for RPL, please provide the proven employment experience and we will assess your application and get back to you as soon as possible.'
                                    ]
                                ]
                            ],
                        ]
                    ]
                ]//end
            ],
            [
                'component'=>[//start
                    [
                        'title'=>'6',
                        'inputs'=>[
                            [
                                'type' => 'check-description',
                                'name' => 'learning_styles',
                                'label' => 'The following information will help us to determine your learning styles and if we are able to deliver courses that meet your learning styles.  (Tick the most relevant)',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'description'=>'Textbooks that I can read and refer to in my own time;'
                                    ],
                                    [
                                        'description'=>'Power Points explained to me during classes;'
                                    ],
                                    [
                                        'description'=>'Pictures and diagrams;'
                                    ],
                                    [
                                        'description'=>'Group discussions with others;'
                                    ],
                                    [
                                        'description'=>'Conducting my own research'
                                    ],
                                    [
                                        'description'=>'Listening to the lectures/ trainers;'
                                    ],
                                    [
                                        'description'=>'Practical application of skills and knowledge in a workplace or similar or watching videos;'
                                    ],
                                    [
                                        'description'=>'Working through real examples such as a case study or scenario'
                                    ]
                                ]
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'learning_styles_spec',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>'Other (please explain below)',
                                'value'=>''
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'add_support',
                                'label' => 'What additional support do you think you will need in order to complete this course successfully?',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'description'=>'English language support; '
                                    ],
                                    [
                                        'description'=>'Reading support; '
                                    ],
                                    [
                                        'description'=>'Writing support;  '
                                    ],
                                    [
                                        'description'=>'One-on-one guidance;  '
                                    ],
                                    [
                                        'description'=>'Additional resources:'
                                    ],
                                    [
                                        'description'=>'No support required'
                                    ]
                                ]
                            ],
                            [
                                'type'=>'textarea',
                                'name'=>'add_support_spec',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>'Other (please explain below)',
                                'value'=>''
                            ],
                            [
                                'label'=>'The following information will ensure that you are aware of your rights and obligations as '.$student_type==1?"an international":"a".' student at PCA. ',
                                'type'=>'card',
                                'col_size'=>12,
                                'content'=>[
                                    [
                                        'type'=>'paragraph',
                                     ]
                                ]
                            ],
                            [
                                'type'=>'multiselect',
                                'name'=>'ncver_participate_awareness',
                                'label'=>'Are you aware that you may be required to participate in NCVER or other surveys or interviews from different regulatory bodies?  Ask PCA staff if you are unsure.',
                                'mTrackBy'=>'id',
                                'multiselect'=>false,
                                'col_size'=>12,
                                'value'=>['id'=>2,'value'=>'N/A'],
                                'selections'=>[
                                    [
                                        'id'=>0,
                                        'value'=>'Yes'
                                    ],
                                    [
                                        'id'=>1,
                                        'value'=>'No'
                                    ],
                                    [
                                        'id'=>2,
                                        'value'=>'N/A'
                                    ],
                                ]
                            ],
                            [
                                'type'=>'multiselect',
                                'name'=>'fees_awareness',
                                'label'=>'Are you aware of any fees and charges applicable to your enrolment, including any refund policy?  Ask PCA staff if you are unsure.',
                                'mTrackBy'=>'id',
                                'multiselect'=>false,
                                'col_size'=>12,
                                'value'=>['id'=>2,'value'=>'N/A'],
                                'selections'=>[
                                    [
                                        'id'=>0,
                                        'value'=>'Yes'
                                    ],
                                    [
                                        'id'=>1,
                                        'value'=>'No'
                                    ],
                                    [
                                        'id'=>2,
                                        'value'=>'N/A'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'complaints_and_appeals',//
                                'label'=>'Are you aware of complaints and appeals policy of PCA?  Ask PCA staff if you are unsure.',
                                'value' => false,
                                'required'=> true,
                                'col_size'=>12
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'attendance_requirements',//
                                'label'=>'Are you aware of course attendance requirements, course progress requirements and training and assessment arrangements?  Ask PCA staff if you are unsure.',
                                'value' => false,
                                'required'=> true,
                                'col_size'=>12
                            ],
                            [
                                'type'=>'multiselect',
                                'name'=>'intl_fees',
                                'label'=>'As '.$student_type==1?"an international":"a".' student, are you aware of the fees and charges applicable to the course?  Ask PCA staff if you are unsure.',
                                'mTrackBy'=>'id',
                                'multiselect'=>false,
                                'col_size'=>12,
                                'value'=>['id'=>2,'value'=>'N/A'],
                                'selections'=>[
                                    [
                                        'id'=>0,
                                        'value'=>'Yes'
                                    ],
                                    [
                                        'id'=>1,
                                        'value'=>'No'
                                    ],
                                    [
                                        'id'=>2,
                                        'value'=>'N/A'
                                    ],
                                ]
                            ],
                            [
                                'type'=>'text',
                                'name'=>'student_name',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>"Student Name:",
                                'readOnly'=>true,
                                'value'=>$enrolment_pack->student_name
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'student_signature_check',
                                // 'label' => 'What additional support do you think you will need in order to complete this course successfully?',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value'=>true,
                                        'description'=>'Electronic Transactions (Queensland) Act 2001/Electronic Transactions (Victoria) Act 2000 establishes the regulatory framework for transactions to be completed electronically. This form requires you to tick the boxes and put your name as a electronic signature before submission. By ticking the box and putting the name in signature panel, you indicate your approval of the contents of this electronic offer letter and acceptance agreement. '
                                    ],
                                ]
                            ],
                            [
                                'required'=>true,
                                'type'=>'signature',
                                'name'=>'student_signature',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>"Signature:",
                                'value'=>''
                            ],
                            [
                                'type'=>'date',
                                'name'=>'date',
                                'col_size'=>3,
                                'label'=>"Date:",
                                'value'=>now()
                            ],
                        ]
                    ]
                ]//end
                        ],
            [
                'component'=>[//start
                    [
                        'title'=>"Authorised Person's declaration",
                        'inputs'=>[
                            [
                                'type'=>'textarea',
                                'name'=>'comments',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>'Comments:',
                                'value'=>''
                            ],
                            [
                                'type'=>'text',
                                'name'=>'auth_person_name',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>"Authorised Person's Name",
                                'value'=>''
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'auth_person_signature_check',
                                // 'label' => 'What additional support do you think you will need in order to complete this course successfully?',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value'=>true,
                                        'description'=>'Electronic Transactions (Queensland) Act 2001/Electronic Transactions (Victoria) Act 2000 establishes the regulatory framework for transactions to be completed electronically. This form requires you to tick the boxes and put your name as a electronic signature before submission. By ticking the box and putting the name in signature panel, you indicate your approval of the contents of this electronic offer letter and acceptance agreement.'
                                    ],
                                ]
                            ],
                            [
                                'type'=>'signature',
                                'name'=>'auth_person_signature',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>"Authorised Person's Signature:",
                                'value'=>''
                            ],
                            [
                                'type'=>'text',
                                'name'=>'auth_person_position',
                                'col_size'=>12,
                                'rows'=>4,
                                'label'=>"Authorised Person's Position:",
                                'value'=>''
                            ],
                            [
                                'type'=>'date',
                                'name'=>'auth_date',
                                'col_size'=>3,
                                'label'=>"Date:",
                                'value'=>''
                            ],
                        ]
                    ]
                ]//end
            ]
        ];  
        
        return $pages;
    }
}
