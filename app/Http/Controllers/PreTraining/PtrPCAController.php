<?php

namespace App\Http\Controllers\PreTraining;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EnrolmentPack;
use App\Models\StudentAttachment;
use App\Models\Student\Type;
use App\Models\Student\Student;
use App\Models\User;
use Auth;
use Validator;
use PDF;
use Storage;
use File;
use DB;
use Carbon\Carbon;
use App\Models\TrainingOrganisation;
class PtrPCAController extends Controller
{
    public function index(){
        // $pages = EnrolmentPack::find(1);
        // dd(json_decode($pages->ptr,true));
        \JavaScript::put([
            'pages'=>$this->pages()
        ]);

        return view('pre-training.index');
    }

    public function pages($process_id){
        $enrolment_pack = EnrolmentPack::where('process_id',$process_id)->first();
        $training_program = $enrolment_pack->enrolment_form['course']['name'];

        // dd($training_program);
        if($enrolment_pack->student_type==1){//international ptr
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
                                            <li>Your obligation as an international student i.e. participation in surveys, interviews, questionnaires, etc.</li>
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
                                    'label'=>'The following information will ensure that you are aware of your rights and obligations as an international student at PCA. ',
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
                                    'label'=>'As an international student, are you aware of the fees and charges applicable to the course?  Ask PCA staff if you are unsure.',
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
        }else{//dopmestic ptr
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
                                            <li>Your obligation as a student i.e. participation in surveys, interviews, questionnaires, etc. </li>
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
                                    'label'=>'The following information will ensure that you are aware of your rights and obligations as a student at PCA. ',
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
                                    'label'=>'As a student, are you aware of the fees and charges applicable to the course?  Ask PCA staff if you are unsure.',
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
        }
        

        return $pages;
        // dd($pages);
    }

    public function save(Request $request,$process_id){
        $action = $request->action;
        $app_name = config('app.name');

        $enrolment_pack = EnrolmentPack::where('process_id',$process_id)->first();
        $enrolment_id = $enrolment_pack->id;
        $reqss = json_decode(json_encode($request->all()));
        if(!isset($enrolment_pack->student_id)){
            return response()->json(['error'=>'Student ID not found']);
        }   
        $pages = $reqss->pages;
        // dd($pages);
        $student = Student::where('student_id',$enrolment_pack->student_id)->first();
        
        if($enrolment_pack->ptr){
            $enrolment_pack->ptr = json_encode($request->all());
            $enrolment_pack->student_type = $student->student_type_id;
            $enrolment_pack->update();
        }else{
            $enrolment_pack->ptr = json_encode($request->all());
            $enrolment_pack->save();
        }
        
        $ptr = $enrolment_pack->ptr!=null?json_decode($enrolment_pack->ptr):$this->pages();
        // dd($ptr);
        $student_id = $enrolment_pack->student_id;
        $student_name = $enrolment_pack->student_name;
        
        // dd($student_id);        
        $student = Student::where('student_id',$student_id)->first();

        if(isset($enrolment_pack->student_type)){
            $enrolment_pack->stud_type = Type::where('id',$enrolment_pack->student_type)->first();
        }else{
            $enrolment_pack->stud_type = Type::where('id',1)->first(); //automatic International if enrolment pack student_type is null
        }
        // $enrolment_pack->stud_type = Type::where('id',$enrolment_pack->student_type)->first();
        

        $path = storage_path() . '/app/public/student/new/attachments/' . $student_id;

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        // dd($path);
        $hashFileName = $student_name.'-pre-training-review-'.$process_id;

        // dd($enrolment_pack);
        
        if($app_name == 'Phoenix'){
            $pdf = PDF::loadView('pre-training.pca.pca-ptr-pdf',compact('enrolment_pack','ptr'))->setPaper('A4')->save($path . '/' . $hashFileName . '.pdf');
        }else if($app_name == 'CEA'){
            $pdf = PDF::loadView('pre-training.ptr-pdf',compact('enrolment_pack','ptr'))->setPaper('A4')->save($path . '/' . $hashFileName . '.pdf');
        }
        // \PDF::loadView('enrolment.pca.offer-letter-enrolment-acceptance-agreement-pdf', compact('offerData', 'signed'))->setPaper('A4')->save($path . '/' . $hashFileName . '.pdf');

        
        $pdf = Storage::size('/public/student/new/attachments/' . $student_id . '/' . $hashFileName . '.pdf');

        $existattachment = StudentAttachment::where('student_id', $student_id)->where('_input', 'pre_training_review')->first();

        if ($existattachment != null) {
            // dd($existattachment);
            $file_name = explode('-',$existattachment->name);
            $file_proc_ex = explode('.',end($file_name));
            $file_proc_id = $file_proc_ex[0];
            if($file_proc_id==$process_id){
                $existattachment->size = $pdf;
                $existattachment->update();
                return "success update";
            }
            // $existattachment->delete();
        }

        $studentAttachment = new StudentAttachment([
            'name'      => $hashFileName.'.pdf',
            'hash_name' => $hashFileName,
            'size'      => $pdf,
            'mime_type' => 'application/pdf',
            'ext'       => 'pdf',
            '_input'       => 'pre_training_review',
        ]);

        // associated user
        $studentAttachment->user()->associate(\Auth::user());
        $studentAttachment->student()->associate($student_id);
        $studentAttachment->save();
        $studentAttachment->path_id = $student_id;
        $studentAttachment->update();

        return "success";
    }

    public function show($process_id)
    {   
        $enrolment_pack = EnrolmentPack::where('process_id',$process_id)->first();
        $student = Student::where('student_id',$enrolment_pack->student_id)->first();
        
        if(!isset($student)){
            \JavaScript::put([
                'logo_url'          => $this->get_logo(),
                'error'=>'Student not found.'
            ]);
            return view('pre-training.pca.index');
        }
        $stud_type = $student->student_type_id;
        if($enrolment_pack){
            $ef = $enrolment_pack->enrolment_form;
            $egg = json_decode($enrolment_pack->ptr);
            if($enrolment_pack->ptr!=null){
                $pre = json_decode($enrolment_pack->ptr);
                $ptr = $pre->pages;
                // dd($pre->inputs);
                $inputs = $pre->inputs;
            }else{
                $ptr = $this->pages($process_id);
                $inputs = '';
            }

            if(isset($enrolment_pack->student_type)){
                $student_type = Type::where('id',$enrolment_pack->student_type)->first();
            }else{
                if(isset($stud_type)){
                    $student_type = Type::where('id',$stud_type)->first();
                }else{
                    \JavaScript::put([
                        'logo_url'          => $this->get_logo(),
                        'error'=>'Student type is not specified.'
                    ]);
                    return view('pre-training.pca.index');
                }
            }
            // dd($ptr);
            // dd($inputs);
            $app_setting = TrainingOrganisation::first();
            \JavaScript::put([
                'app_setting'=>$app_setting,
                'pages'=>$ptr,
                'process_id'=>$process_id,
                'signature'         => $enrolment_pack->student_signature,
                'type_signature'    => $enrolment_pack->type_signature,
                'student_name'      => $enrolment_pack->student_name,
                'student_type'      => $student_type,
                'process_id'        => $process_id,
                'sig_acceptance_agreement' => $enrolment_pack->sig_acceptance_agreement,
                'concession_docs'   => isset($ef['valid_concession_card_yes']) ? $ef['valid_concession_card_yes'] : [],
                'logo_url'          => $this->get_logo(),
                'app_settings'      => $app_setting,
                'action'            => $inputs !=null ? 'edit_student' :'',
                'inputs'            => $inputs,
            ]);
            
            
            return view('pre-training.pca.index');
        }
        
        return abort(404);
    }  
     
    public function ptr_edit($process_id,$action)
    {
        $enrolment_pack = EnrolmentPack::where('process_id',$process_id)->first();
        $student = Student::where('student_id',$enrolment_pack->student_id)->first();
        $stud_type = $student->student_type_id;
        // dd($enrolment_pack);
        if($enrolment_pack){
            $ef = $enrolment_pack->enrolment_form;
            $egg = json_decode($enrolment_pack->ptr);
            // dd($egg->inputs);
            if($enrolment_pack->ptr!=null){
                $pre = json_decode($enrolment_pack->ptr);
                $inputs = $pre->inputs;
                $ptr = $pre->pages;
            }else{
                $ptr = $this->pages($process_id);
            }

            if(isset($enrolment_pack->student_type)){
                $student_type = Type::where('id',$enrolment_pack->student_type)->first();
            }else{
                if(isset($stud_type)){
                    $student_type = Type::where('id',$stud_type)->first();
                }else{
                    \JavaScript::put([
                        'logo_url'          => $this->get_logo(),
                        'error'=>'Student type is not specified.'
                    ]);
                    return view('pre-training.pca.index');
                }
            }
            // dd($inputs);
            $app_setting = TrainingOrganisation::first();
            \JavaScript::put([
                'app_setting'=>$app_setting,
                'pages'=>$ptr,
                'process_id'=>$process_id,
                'signature'         => $enrolment_pack->student_signature,
                'type_signature'    => $enrolment_pack->type_signature,
                'student_name'      => $enrolment_pack->student_name,
                'student_type'      => $student_type,
                'process_id'        => $process_id,
                'sig_acceptance_agreement' => $enrolment_pack->sig_acceptance_agreement,
                'concession_docs'   => isset($ef['valid_concession_card_yes']) ? $ef['valid_concession_card_yes'] : [],
                'logo_url'          => $this->get_logo(),
                'app_settings'      => $app_setting,
                'action'            => 'edit',
                'inputs'            => $inputs,
                'student'           => $student
            ]);
            return view('pre-training.pca.index');
        }
        
        return abort(404);
    }  
    
    public function ptr_pdf($process_id){
        // dd($process_id);
        $enrolment_pack = EnrolmentPack::where('process_id',$process_id)->first();
        $ptr = $enrolment_pack->ptr!=null?json_decode($enrolment_pack->ptr):$this->pages();

        $enrolment_pack->stud_type = Type::where('id',$enrolment_pack->student_type)->first();
        // dd($ptr->inputs->intl_fees);
        $pdf = PDF::loadView('pre-training.pca.pca-ptr-pdf',compact('enrolment_pack','ptr'));
        return $pdf->stream();
        // return view('pre-training.pca.pca-ptr-pdf',compact('enrolment_pack','ptr'));
    }

    public function get_logo(){
        $app_setting = TrainingOrganisation::first();
        if($app_setting && in_array($app_setting->logo_img, ['', null])){
            $logo = 'images/logo/vorx_logo.png';
          }else{
            $logo = 'storage/config/images/'.$app_setting->logo_img;
          }
          $logo_url = url('/' . $logo . '');

          return $logo_url;
    }

    public function save_international(Request $request,$process_id){
        // dd($request->all());
        $ptrr = $request->ptr;
        $student_type = $request->student_type;
        // dd($admin_assessment);
        // dd($admin_assessment);
        // $admin_assessment['auth_date'] = Carbon::parse($request->auth_date)->timezone('Australia/Melbourne')->format('Y-m-d');
        // dd($admin_assessment);
        $epack = EnrolmentPack::where('process_id',$process_id)->first();

        // $ptrz = json_decode($epack->ptr);
        // $ptr_pages = $ptrz->pages;
        // $ptr_inputs = $admin_assessment;
        
        // $new_ptr = json_decode(json_encode(['pages'=>'ha']),false);
        // dd($new_ptr->pages);
        // $new_ptr = ['pages'=>$ptr_pages,'inputs'=>$ptr_inputs];
        // dd($ptr,$new_ptr);
        $epack->ptr = $ptrr;

        $epack->update();

        
        if(!isset($epack->student_type)){
            if(isset($student_type)){
                $epack->student_type = $student_type;
            }else{//if wala student type si student sa enrolment pack ug students table
                return "Student type is not specified.";
            }
        }

        $student_id = $epack->student_id;
        $student_name = $epack->student_name;

        // dd($epack->ptr->inputs);
        $ptr = $epack->ptr!=null?json_decode(json_encode($epack->ptr),false):$this->pages();
        $enrolment_pack = $epack;
        $enrolment_pack->stud_type = Type::where('id',$enrolment_pack->student_type)->first();

        $path = storage_path() . '/app/public/student/new/attachments/' . $student_id;
        // dd($enrolment_pack->student_id);
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        // dd($pdf);
        $hashFileName = $student_name.'-pre-training-review-'.$process_id;
        
        $pdf = PDF::loadView('pre-training.pca.pca-ptr-pdf',compact('enrolment_pack','ptr'))->setPaper('A4')->save($path . '/' . $hashFileName . '.pdf');
        // \PDF::loadView('enrolment.pca.offer-letter-enrolment-acceptance-agreement-pdf', compact('offerData', 'signed'))->setPaper('A4')->save($path . '/' . $hashFileName . '.pdf');


        $pdf = Storage::size('/public/student/new/attachments/' . $student_id . '/' . $hashFileName . '.pdf');

        $existattachment = StudentAttachment::where('student_id', $student_id)->where('_input', 'pre_training_review')->first();


        $ep = EnrolmentPack::where('process_id',$process_id)->first();
        
        if ($existattachment != null) {
            // dd($existattachment);
            $file_name = explode('-',$existattachment->name);
            $file_proc_ex = explode('.',end($file_name));
            $file_proc_id = $file_proc_ex[0];
            if($file_proc_id==$process_id){
                $existattachment->size = $pdf;
                $existattachment->update();
                
                return response()->json(['status'=>"success",'enrolment_pack'=>$ep]);
            }
            // $existattachment->delete();
        }

        return response()->json(['status'=>"success",'enrolment_pack'=>$ep]);
    }

    public function student_ptr(){
        $username = Auth::user()->username;
        // dd($username);
        $enrolment_pack = EnrolmentPack::where('student_id',$username)->get();
        
        $epack = [];
        foreach($enrolment_pack as $ep){
            $ojb = new \stdClass;

            $ojb->ep = $ep;
            $ojb->ptr = json_decode($ep->ptr);
            array_push($epack,$ojb);
        }
        // dd($ptr);
        // dd($epack);
        \JavaScript::put([
            'epack'=>$epack
        ]);
        return view('student_portal.student-ptr');
        // $enrolment_pack = EnrolmentPack
    }

    public function student_ptr_pdf(Request $request){
        $process_id = $request->process_id;
        $student_id = Auth::user()->username;
        // $student    = Student::
        $link = '/pca/pre-training-review';
        $enrolment_pack = EnrolmentPack::where('process_id',$process_id)->where('student_id',$student_id)->first();
        
        if(!isset($enrolment_pack->student_type)){

        }
        $student_type = Type::where('id',$enrolment_pack->student_type)->first();
        // dd($enrolment_pack);
        if($enrolment_pack){
            $ef = $enrolment_pack->enrolment_form;
            $egg = json_decode($enrolment_pack->ptr);
            // dd($egg->inputs);
            if($enrolment_pack->ptr!=null){
                $pre = json_decode($enrolment_pack->ptr);
                $ptr = $pre->pages;
            }else{
                $ptr = $this->pages($process_id);
            }
            $app_setting = TrainingOrganisation::first();
            if($enrolment_pack){
                \JavaScript::put([
                    'app_setting'=>$app_setting,
                    'pages'=>$ptr,
                    'process_id'=>$process_id,
                    'signature'         => $enrolment_pack->student_signature,
                    'type_signature'    => $enrolment_pack->type_signature,
                    'student_name'      => $enrolment_pack->student_name,
                    'student_type'      => $student_type,
                    'process_id'        => $process_id,
                    'sig_acceptance_agreement' => $enrolment_pack->sig_acceptance_agreement,
                    'concession_docs'   => isset($ef['valid_concession_card_yes']) ? $ef['valid_concession_card_yes'] : [],
                    'logo_url'          => $this->get_logo(),
                    'app_settings'      => $app_setting,
                    'link'              => $link
                ]);
                return view('pre-training.pca.index');
            }
        }else{
            return abort(404);
        }
    }

    public function getpdflink($id,$student_id){
        // dd($id,$student_id);
        $student_attachment = StudentAttachment::where('student_id',$student_id)->get();
        // dd($student_attachment);
        $pdf_link = '#';
        foreach($student_attachment as $sa){
            // dd($filename);
            if($sa->_input == 'pre_training_review'){
                $filename = $sa->hash_name;
                $splitted = explode('-',$filename);
                $attachment_proc_id = last($splitted);
                if($attachment_proc_id == $id){
                    // dd('ara ka owh');
                    // dd($sa);
                    $pdf_link = $sa->id;
                    // dd($pdf_link);
                }
            }
        }
        return $pdf_link;
    }
}
