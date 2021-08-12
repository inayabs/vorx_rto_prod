<?php

namespace App\Http\Controllers\LLNTest;

use App\Http\Controllers\Controller;
use App\Models\AvtCountryIdentifier;
use App\Models\AvtDeliveryMode;
use App\Models\AvtDisabilityTypes;
use App\Models\AvtHighestSchlLvlCompleted;
use App\Models\AvtLabourForceStatus;
use App\Models\AvtPostcode;
use App\Models\AvtPriorEducationAchievement;
use App\Models\AvtStudyReason;
use App\Models\Course\Course;
use App\Models\VisaStatus;
use App\Models\EnrolmentPack;
use App\Models\TrainingOrganisation;
use App\Models\Student\Type;
use App\Models\Student\Party;
use App\Models\Student\Person;
use App\Models\Student\Student;
use App\Models\StudentAttachment;
use App\Models\ExternalForm;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Validator;
use File;
use Illuminate\Support\Facades\Redirect;

class UnitOfCompetencyLLNTestController extends Controller
{
    // public function __construct() {
    //     // dd(config('app.name'));
    //     $this->middleware('auth');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // dd('yoooooooooooooooooo');

        $app_setting = TrainingOrganisation::first();
        \JavaScript::put([
            'pages'         => $this->pages(),
            'app_settings'  => $app_setting,
            'logo_url'      => $this->get_logo()
        ]);
        return view('lln-test.unit-of-competency-lln-test');
    }

    public function pages($process_id = null) 
    {
        // dd(\Auth::user());
        $lln_val = null;
        if($process_id != null) {
            $ef = ExternalForm::where('process_id', $process_id)->first();
            // $lln_val = json_decode($ep->lln, true);
            $lln_form = Storage::get('/public/external-form/' . $ef->process_id . '/lln-form.txt');
            // dd($enrolment_form);
            return json_decode($lln_form,true);
        }
        

        $question5 = url("custom/unit-of-competency-lln-test/images/question5.png");
        $pages = [
            [
                'component' => [ //start component
                    [
                        'title' => 'INTRODUCTION',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'info',
                                // 'label' => 'Information',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<h1 class="proximanova-bold primary-font-color px-14-font text-justify"><span>Language, Literacy and Numeracy Indicator – What is it?</span></h1>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">The purpose  of  a  Language,  Literacy  and  Numeracy  Indicator  is  to  give  an  idea  of  your language,  literacy  and  numeracy  skills  and  to  determine  if  you  have  the  appropriate  level to undertake the nominated course.</p>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">This is not an exam and the marks will not reflect on your outcome from your course. This is however, a tool that will ensure you receive the most appropriate learning strategies.</p>
                                        <br>
                                        <h1 class="proximanova-bold primary-font-color px-14-font text-justify"><span>So why do I have to sit an assessment?</span></h1>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">Learning a new skill is a complex and highly variable process for anyone. It involves drawing on  experiences and  skills  currently held  as  well  as  taking  on  some  entirely new  skills,  and applying the combination in an altered or even radically new environment.</p>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">In order to learn new vocational skills, a learner will draw on their current LL&N skills, and
                                        will be developing these skills within the context of their training, work and the chosen industry. In many case vocational learning will involve taking new LL&N skills to become competent. For this reason we try and evaluate your level of LL&N prior to you setting out to learn new LL&N skills.</p>
                                        <br>
                                        <h1 class="proximanova-bold primary-font-color px-14-font text-justify"><span>What happens if I don’t do well in the assessment?</span></h1>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">Don’t Panic!!! This is not the end of the world. If you do poorly in the LL&N assessment, we need to work out why. Was it nerves, you having a bad day, or is it a learning difficulty. Whatever  the  case,  we  will  evaluate  your  result  and  discuss  any  issues  raised  with  you. Depending  on  the  severity,  we  may  recommend  you  see  a  LL&N  specialist  councilor  or undertake  development  courses  to  build  your  LL&N  level  to  such  that  will  allow  you
                                        to undertake a career in your chosen field. The minimum required passing marks are 60.</p>
                                        <br>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">If you have any concerns, please speak to your trainer/assessor.</p>
                                        ',
                                    ],
                                ],
                                'col_size' => 12
                            ],
                           
                        ],
                        
                    ],
                    [
                        'title' => ' OFFICE USE ONLY:',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'info',
                                // 'col_size' => 12,
                                'label' => 'Student’s Assessment Marks:',
                                'content' => [
                                    [
                                        'type' => 'table',
                                        'body' => [
                                            'column_width' => ['30%','70%'],
                                            'text_type' => ['text-center','text-center'],
                                            'tbody' => [
                                                [
                                                    'Possible Mark',
                                                    '60'
                                                ],
                                                [
                                                    'Students Mark',
                                                    ' ',
                                                    // [
                                                    //     'type' => 'text',
                                                    //     'name' => 'student_mark',
                                                    // ],
                                                ],
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            [
                                'type' => 'text',
                                'name' => 'assessor_name',
                                'label'=> 'Assessor Name:',
                                // 'required'=> true,
                                // 'col_size' => 12,
                            ],
                        ],
                        
                    ],
                    
                ] //end component
            ],
            [
                'component' => [ //start component      
                    [
                        'title' => 'APPLICANT DETAILS (Please complete by printing all your details)',
                        'inputs' => [
                            [
                                'type' => 'text',
                                'name' => 'given_name',
                                'label'=> 'Given Name',
                                'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'last_name',
                                'label'=> 'Last Name',
                                'required' => true,
                            ],
                            [
                                'type' => 'date',
                                'name' => 'date_of_birth',
                                'label'=> 'Date of Birth',
                                'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'student_id',
                                'label'=> 'Student ID',
                                'required' => true,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'describe_reasons',
                                'label'=> 'Describe your reasons for undertaking this training program?',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                        ],
                        
                    ],
                    [
                        'title' => 'Question 1. (10 Marks)',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'question1',
                                'col_size' => 12,
                                'label' => 'Fill in the correct word from the brackets and complete the sentence.',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<p class="px-14-font text-justify line-height-1point2"><b>A.)</b> The ____________ <b>1. (personal/personnel)</b> officer made a habit of losing his __________ <b>2. (patience/patients)</b> when meetings didn’t proceed
                                        As __________ <b>3. (planned/planed)</b>.</p>',
                                    ]
                                ]
                            ],
                            [
                                'type' => 'text',
                                'name' => 'question1_a1',
                                'label'=> 'A.1.',
                                'col_size' => 4,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'question1_a2',
                                'label'=> 'A.2.',
                                'col_size' => 4,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'question1_a3',
                                'label'=> 'A.3.',
                                'col_size' => 4,
                            ],
                            [
                                'type' => 'card',
                                'name' => 'info',
                                'col_size' => 12,
                                // 'label' => 'Fill in the correct word from the brackets and complete the sentence.',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<p class="px-14-font text-justify line-height-1point2"><b>B.)</b> At __________ <b>1. (presence/ present)</b>, __________ <b>2. (preferable/preferential)</b> consideration is given to those who have held office in
                                        The __________ <b>3. (passed/past)</b></p>',
                                    ]
                                ]
                            ],
                            [
                                'type' => 'text',
                                'name' => 'question1_b1',
                                'label'=> 'B.1.',
                                'col_size' => 4,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'question1_b2',
                                'label'=> 'B.2.',
                                'col_size' => 4,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'question1_b3',
                                'label'=> 'B.3.',
                                'col_size' => 4,
                            ],
                        ],
                        
                    ],
                    [
                        'title' => 'Question 2. (10 Marks)',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'question2',
                                'label'=> 'Fill in the missing one or two letters in the following words:',
                                'content' => [
                                    [
                                        'type' => 'table',
                                        'body' => [
                                            'column_width' => ['30%','30%'],
                                            // 'thead' => [
                                            //     'Fraction',
                                            //     'Decimal',
                                            // ],
                                            'text_type' => ['text-center','text-center'],
                                            'tbody' => [
                                                [
                                                    'advanta_eous',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'question2_1',
                                                    ],
                                                ],
                                                [
                                                    'calend__r',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'question2_2',
                                                    ],
                                                ],
                                                [
                                                    'counc__l',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'question2_3',
                                                    ],
                                                ],
                                                [
                                                    'hurr___dly',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'question2_4',
                                                    ],
                                                ],
                                            ]
                                        ]
                                    ]
                                    
                                ],
                                // 'col_size' => 12,
                            ],
                        ],
                        
                    ],
                    [
                        'title' => 'Question 3. (10 Marks)',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'question3',
                                'label'=> 'Please read the following and answer the questions below:',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => ' <br><p class="px-14-font text-justify line-height-1point2">Telephone  inquiries  should  be  dealt  with  clearly  with  the  exact  nature  of  the  enquiry,  the  time, and return contact information recorded. Customer satisfaction may result if information regarding the products and services is given.These include security at special events, general crowd control, security within a shop and site monitoring.</p>
                                        <br>
                                        <p class="px-14-font text-justify line-height-1point2">Advertising and websites can instigate inquiries, and should be well presented, with details of the services available.  Telephone  inquiries  may  sometimes  be  best  resolved  by  sending  the  person some information via email or post.</p>',
                                    ]
                                ],
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'question3_1',
                                'label'=> '1. What 2 pieces of information should be recorded with every telephone enquiry?',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'question3_2',
                                'label'=> '2. State 2 services offered?',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                        ],
                        
                    ],
                    [
                        'title' => 'Question 4. (10 Marks)',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'question4',
                                'col_size' => 12,
                                'label' => 'Calculate the following:',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '',
                                    ]
                                ]
                            ],
                            [
                                'type' => 'card',
                                'name' => 'question4_a',
                                'col_size' => 12,
                                'label' => 'A.) Subtraction (with no calculator) ',
                                'content' => [
                                    [
                                        'type' => 'table',
                                        'body' => [
                                            'column_width' => ['30%','30%', '30%'],
                                            'thead' => [
                                                '1.',
                                                '2.',
                                                '3.',
                                            ],
                                            'text_type' => ['text-center','text-center','text-center'],
                                            'tbody' => [
                                                [
                                                    '476<br>- 250',
                                                    '578<br>- 400',
                                                    '14175<br>- 175',
                                                ],
                                                [
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'question4_a1',
                                                    ],
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'question4_a2',
                                                    ],
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'question4_a3',
                                                    ],
                                                ],
                                                
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            [
                                'type' => 'card',
                                'name' => 'question4_b',
                                'col_size' => 12,
                                'label' => 'B.) Subtraction of Percentages (with No calculator)',
                                'content' => [
                                    [
                                        'type' => 'table',
                                        'body' => [
                                            'column_width' => ['30%','30%','30%'],
                                            // 'thead' => [
                                            //     '1.',
                                            //     '2.',
                                            //     '3.',
                                            // ],
                                            'text_type' => ['text-center','text-center','text-center'],
                                            'tbody' => [
                                                [
                                                    '1.',
                                                    '$30.00 + 10% GST = ',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'question4_b1',
                                                    ],
                                                ], 
                                                [
                                                    '2.',
                                                    '$65.00 + 10% GST = ',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'question4_b2',
                                                    ],
                                                ], 
                                                [
                                                    '3.',
                                                    '$35.00 - 10% GST = ',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'question4_b3',
                                                    ],
                                                ], 
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            [
                                'type' => 'card',
                                'name' => 'question4_c',
                                'col_size' => 12,
                                'label' => 'C.) Addition (with No calculator)   ',
                                'content' => [
                                    [
                                        'type' => 'table',
                                        'body' => [
                                            'column_width' => ['30%','30%','30%'],
                                            // 'thead' => [
                                            //     '1.',
                                            //     '2.',
                                            //     '3.',
                                            // ],
                                            'text_type' => ['text-center','text-center','text-center'],
                                            'tbody' => [
                                                [
                                                    '1.',
                                                    '3 x 5 =',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'question4_c1',
                                                    ],
                                                ],
                                                [
                                                    '2.',
                                                    '12 x 3 =',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'question4_c2',
                                                    ],
                                                ],
                                                [
                                                    '3.',
                                                    '8 x 5 =',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'question4_c3',
                                                    ],
                                                ],
                                                
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                        ],
                        
                    ],
                    [
                        'title' => 'Question 5. (10 Marks)',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'question5',
                                'label'=> 'Please answer the following questions; regarding the Australian Passport of Simon Antony Roberts:',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<center><img src="' . $question5 . '" alt="" class="img-responsive" style="width: 500px;"></center>',
                                    ]
                                ],
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'date',
                                'name' => 'question5_a',
                                'label'=> 'A.) What is the Date of Expiry?',
                                // 'required'=> true,
                                // 'col_size' => 12,
                            ],
                            [
                                'type' => 'date',
                                'name' => 'question5_b',
                                'label'=> 'B.) Date of Birth?',
                                // 'required'=> true,
                                // 'col_size' => 12,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'question5_c',
                                'label'=> 'C.) What is the Document No.?',
                                // 'required'=> true,
                                // 'col_size' => 12,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'question5_d',
                                'label'=> 'D.) What is Place of Birth?',
                                // 'required'=> true,
                                // 'col_size' => 12,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'question5_e',
                                'label'=> 'E.) What is the Nationality?',
                                // 'required'=> true,
                                // 'col_size' => 12,
                            ],
                        ],
                        
                    ],
                    [
                        'title' => 'Question 6. (10 Marks)',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'question6',
                                // 'label'=> 'Please answer the following questions; regarding the Australian Passport of Simon Antony Roberts:',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'Tick the correctly spelt words.',
                                    ]
                                ],
                                'col_size' => 12,
                            ],
                           [
                                'type' => 'check-description',
                                'name' => 'question6_1',
                                // 'label' => 'Tick the correctly spelt words.',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => false,
                                        'description' => '1. itinery',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'question6_2',
                                // 'label' => 'Tick the correctly spelt words.',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => false,
                                        'description' => '2. Pilat',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'question6_3',
                                // 'label' => 'Tick the correctly spelt words.',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => false,
                                        'description' => '3. Immediately',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'question6_4',
                                // 'label' => 'Tick the correctly spelt words.',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => false,
                                        'description' => '4. Arrangement',
                                    ],
                                ],
                            ],
                        ],
                        
                    ],
                ] //end component
            ],
            [
                'component' => [ //start component
                    [
                        'title' => ' OFFICE USE ONLY:',
                        'inputs' => [
                            [
                                'type' => 'check-description',
                                'name' => 'office_use_only_1',
                                // 'label' => 'Tick the correctly spelt words.',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => false,
                                        'description' => 'I have assessed this applicant/student.I find that the applicant/student has sufficient language, literacy and numeracy     skills. ',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'office_use_only_2',
                                // 'label' => 'Tick the correctly spelt words.',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => false,
                                        'description' => ' I find that the applicant/student does not have sufficient language, literacy and numeracy skills.',
                                    ],
                                ],
                            ],
                            // [
                            //     'type' => 'text',
                            //     'name' => 'assessor_signature',
                            //     'label'=> 'Assessor /RTO Representative’s Signature:',
                            // ],
                            
                            [
                                'type' => 'date',
                                'name' => 'assessor_date',
                                'label'=> 'Date',
                            ],
                        ],
                        
                    ],
                    [
                        'title' => 'Assessor /RTO Representative’s Signature:',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'card_signature',
                                'label' => '',
                                'col_size' => 12,
                                'content' => [
                                    // [
                                    //     'type' => 'paragraph',
                                    //     'body' => 'lorem',
                                    // ],
                                    [
                                        'type' => 'signature',
                                        'body' => '',
                                    ],
                                ],
                            ],
                        ]
                    ]
                ] //end component
            ],
        ];


        return $pages;
    }

    public function llntest_submit(Request $request){
        
        $inputs = $request->inputs['inputs'];
        $student_id = null;
        $student = Student::with('party.person')->where('student_id', $inputs['student_id'])->first();
        if(!isset($student)){
            return json_encode(['status' => 'error', 'message' =>'Student ID not found.']);
        }else{
            $student_id = $student->student_id;
        }

        $org = TrainingOrganisation::first();
        $save = null;
        if ($request->process_id == null) {

            $save = new ExternalForm;
            $save->process_id = $this->codeNumber();
            $save->student_id = $student_id;
            $save->form_json = $request->inputs;
            $save->form_type = 'unit-of-competency-llntest';
            $save->form_txt = '/public/external-form/' . $save->process_id . '/lln-form.txt';
            $save->save();

            $path ='/public/external-form/' . $save->process_id . '/lln-form.txt';
            Storage::put($path, $request->pages);

            $this->student_attachment($student_id);

            return ['status' => 'success', 'process' => $save->process_id, 'site' => $org->site_url];
        } else {

            // $jsonPages = json_decode($request->pages, true);
            $save = ExternalForm::where('process_id', $request->process_id)->first();
            $save->form_json = $request->inputs;
            $save->update();

            $path = '/public/external-form/' . $save->process_id . '/lln-form.txt';
            Storage::put($path, $request->pages);

            $this->student_attachment($student_id);

            return ['status' => 'success', 'process' => $save->process_id, 'site' => $org->site_url];
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($process_id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($process_id)
    {
        
        $app_setting = TrainingOrganisation::first();
        $external_form = ExternalForm::where('process_id', $process_id)->first();
        $lln_form = $external_form->form_json;
        // dd($lln_form['inputs']);
         \JavaScript::put([
            'logo_url'                  => $this->get_logo(),
            'pages'                     => $this->pages($process_id),
            'lln_inputs'                => $external_form->form_json != null ? $lln_form['inputs'] : [],
            'process_id'                => $process_id,
            'app_settings'              => $app_setting,
            'type_signature'            => $lln_form['type_signature'],
            'sig_acceptance_agreement'  => $lln_form['sig_acceptance_agreement']
        ]);

        return view('lln-test.unit-of-competency-lln-test');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function lln_preview($process_id){
        // dd($process_id);
        $external_form = ExternalForm::where('process_id', $process_id)->first();
        $lln = $external_form->form_json;
        $lln_test = $lln['inputs'];
        $student_signature = $lln['type_signature'];

        $app_setting = TrainingOrganisation::first();
        $logo_url = $this->get_logo();

         $file_name = $lln_test['given_name'].' '.$lln_test['last_name'].' - '.$external_form->process_id. '.pdf';
         return \PDF::loadView('lln-test.unit-of-competency-lln-test-pdf', compact('lln_test','student_signature','app_setting','logo_url'))->setPaper(array(0, 0, 612, 936), 'portrait')->stream($file_name);
    }

    public function student_attachment($student_id){

        $file_path = '';
        $pdf_file = null;
        $app_setting = TrainingOrganisation::first();
        $external_form = ExternalForm::where('student_id', $student_id)->first();
        if(!$external_form){
            abort(404);
        }
        $lln = $external_form->form_json;
        $lln_test = $lln['inputs'];
        $student_signature = $lln['type_signature'];
        $logo_url = $this->get_logo();

        try {
            DB::beginTransaction();
            
            $file_path = storage_path() . '/app/public/student/new/attachments/' . $student_id;

            if (!File::isDirectory($file_path)) {
                File::makeDirectory($file_path, 0777, true, true);
            }

            $hashFileName = 'unit-of-competency-lln-test';
            $pdf_file = \PDF::loadView('lln-test.unit-of-competency-lln-test-pdf', compact('lln_test','external_form', 'student_signature','logo_url','app_setting'))->setPaper(array(0, 0, 612, 936), 'portrait')->save($file_path.'/'. $hashFileName . '.pdf');

            $pdf = Storage::size('/public/student/new/attachments/' . $student_id . '/' . $hashFileName . '.pdf');
            $file = StudentAttachment::where('student_id', $student_id)->where('_input', 'unit-of-competency-lln-test')->first();
            if($file == null){
                $studentAttachment = new StudentAttachment([
                    'name'          => 'unit-of-competency-lln-test.pdf',
                    'hash_name'     => $hashFileName,
                    'size'          => $pdf,
                    'mime_type'     => 'application/pdf',
                    'ext'           => 'pdf',
                    '_input'        => 'unit-of-competency-lln-test',
                    // 'student_id'    => $student_id, 
                ]);
    
                // associated user
                $studentAttachment->user()->associate(\Auth::user());
                $studentAttachment->student()->associate($student_id);
                $studentAttachment->save();
                $studentAttachment->path_id = $student_id;
                $studentAttachment->update();
            }
            
            DB::commit();


            // return response(['status' => 'success', 'attID' => $attID, 'preview' => $preview], 200)->header('Content-Type', 'text/json');
            return response(['status' => 'success', 'file' => $pdf_file], 200)->header('Content-Type', 'text/json');
            // return response(['status' => 'success', 'attID' => 0], 200)->header('Content-Type', 'text/json');
        } catch (\Exception $e) {
            DB::rollBack();

            // remove file
            Storage::delete($file_path);
            dd($e->getMessage());
        }
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

    public function codeNumber()
    {
        $number = mt_rand(000000001, 999999999);

        $number = sprintf("%09d", $number);

        if (count($this->codeNumberExist($number))) {
            return $this->codeNumber();
        }

        return $number;
    }

    public function codeNumberExist($number)
    {
        return EnrolmentPack::where('process_id', $number)->get();
    }
}
