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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Validator;

class LLNTestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        \JavaScript::put([
            'pages'         => $this->pages(),
        ]);
        return view('lln-test.index');
    }

    public function pages($process_id = null) 
    {
        // dd($process_id);
        $lln_val = null;
        if($process_id != null) {
            $ep = EnrolmentPack::where('process_id', $process_id)->first();
            $lln_val = json_decode($ep->lln, true);
            // return json_decode($ep->lln, true);
        }
        // dd($lln_val);
        $ACSF_performance_table_text = url("cea-lln-test-form/images/lln/ACSF-performance-table-text.png");
        $q1_worksafe_img = url("cea-lln-test-form/images/lln/q1-worksafe-img.jpg");
        $q2_worksafe_img = url("cea-lln-test-form/images/lln/q2-worksafe-img.jpg");
        $partb_q5_c = url("cea-lln-test-form/images/lln/partb-q5-c.jpg");
        $partb_q6 = url("cea-lln-test-form/images/lln/partb-q6.jpg"); 
        // dd($ACSF_performance_table_text);
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
                                        'body' => '<p class="px-14-font text-justify line-height-1point2">This test includes a range of tasks designed to be used to identify an individual’s level in the core language, literacy and numeracy (LLN) skills of Learning, Reading, Writing, Oral Communication and Numeracy. The tasks in this test are adapted from tasks bank developed by Precision Group in collaboration with Commonwealth of Australia. </p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        <p class="px-14-font text-justify line-height-1point2">The assessment tasks align with the Australian Core Skills Framework (ACSF). The ACSF is a national framework that provides:</p>
                                        <ul class="px-14-font text-justify no-margin paragraph-list">
                                            <li class="line-height-1point2">a consistent national approach to the identification of the core LLN skills requirements in diverse work, training, personal and community contexts</li>
                                            <li class="line-height-1point2">a common reference point for describing and discussing performance in the five core LLN skill areas.</li>
                                        </ul>
                                        
                                        <h1 class="proximanova-bold primary-font-color px-14-font text-justify"><span>Why assess core LLN skill levels?</span></h1>
                                        <p class="px-14-font text-justify line-height-1point2">Assessment of core LLN skill levels identifies an individual’s skill levels. This individual assessment can then be compared with the LLN levels required of a training program (or unit or qualification), or workplace tasks. The person may be a new entrant to the training sector, or may be following a training pathway to a new course or qualification. </p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        <p class="px-14-font text-justify line-height-1point2">The purpose of the assessment should be to determine whether the person:</p>
                                        <ul class="px-14-font text-justify no-margin paragraph-list">
                                            <li class="line-height-1point2">should complete an LLN bridging program before commencing the training, or</li>
                                            <li class="line-height-1point2">requires LLN support throughout the training program (or unit or qualification) or workplace tasks.</li>
                                        </ul>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">Identified gaps can be addressed in various ways, for example bridging courses, specialist LLN practitioner support, or activities provided by a vocational trainer with knowledge of developing LLN skills. </p>
                                        
                                        <h1 class="proximanova-bold primary-font-color px-14-font text-justify"><span>The assessment tasks</span></h1>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">This test includes tasks that focus on ACSF Level 3. The following table notes information about each assessment task.</p>
                                        
                                        <table width="100%" class="table default-bordered-table no-margin px-14-font">
                                            <thead>
                                                <tr>
                                                    <th class=" px-14-font white-font-color text-center" width="25%">Assessment task</th>
                                                    <th class=" px-14-font white-font-color text-center" width="35%">ACSF skill and level coverage</th>
                                                    <th class=" px-14-font white-font-color text-center" width="40%">Description</th>
                                                </tr>
                                                <tr>
                                                    <th class=" px-14-font white-font-color text-center" colspan="3">Part A</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td width="15%" valign="top">Interview</td>
                                                    <td width="15%" valign="top">Learning 1-3, Oral communication 1-3</td>
                                                    <td width="70%" valign="top">Reflective question and answer <br> Particularly useful for new workers</td>
                                                </tr>
                                            </tbody>
                                            <thead>
                                                <tr>
                                                    <th class=" px-14-font white-font-color text-center" colspan="3">Part B</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td valign="top">Task 1: Reading and Writing</td>
                                                    <td valign="top">Reading 3, Writing 2-3 Writing 3-4</td>
                                                    <td valign="top">Read and interpret a poster <br> Write or deliver an opinion piece</td>
                                                </tr>
                                                <tr>
                                                    <td valign="top">Task 2: Numeracy</td>
                                                    <td valign="top">Numeracy 2-3</td>
                                                    <td valign="top">Complete various numeracy tasks</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p class="px-14-font text-justify line-height-1point2 text-italic proximanova-bold">Note: Levels of tasks can be influenced by the amount of support provided to the candidate throughout the test. </p>
                                        <h1 class="proximanova-bold primary-font-color px-14-font text-justify"><span>Coverage of tasks</span></h1>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">The following table maps the assessment tasks to ACSF skills and levels. Note that most tasks cover more than one skill, and more than one level – often depending on the response from the candidate. </p>
                                        <h1 class="proximanova-bold primary-font-color px-14-font text-justify"><span>ACSF skills and levels covered by assessment tasks </span></h1>
                                        <table width="100%" class="table default-bordered-table">
                                            <thead>
                                                <tr>
                                                    <th class="proximanova-bold px-14-font white-font-color text-center" width="25%">ACSF Level</th>
                                                    <th class="proximanova-bold px-14-font white-font-color text-center" width="35%">Learning</th>
                                                    <th class="proximanova-bold px-14-font white-font-color text-center" width="40%">Reading</th>
                                                    <th class="proximanova-bold px-14-font white-font-color text-center" width="40%">Writing</th>
                                                    <th class="proximanova-bold px-14-font white-font-color text-center" width="40%">Oral communication</th>
                                                    <th class="proximanova-bold px-14-font white-font-color text-center" width="40%">Numeracy</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center proximanova-bold">4</td>
                                                    <td valign="top"></td>
                                                    <td valign="top"></td>
                                                    <td valign="top">Part B - Task 1: Q.3</td>
                                                    <td valign="top">Part B - Task 1: Q.3</td>
                                                    <td valign="top"></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center proximanova-bold">3</td>
                                                    <td valign="top">Part A</td>
                                                    <td valign="top">Part B - Task 1: Q.1, Q.2</td>
                                                    <td valign="top">Part B - Task 1: Q.1, Q.2, Q.3</td>
                                                    <td valign="top">Part A <br> Part B - Task 1: Q.3</td>
                                                    <td valign="top">Part B – Task 2</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center proximanova-bold">2</td>
                                                    <td valign="top">Part A</td>
                                                    <td valign="top"></td>
                                                    <td valign="top"></td>
                                                    <td valign="top">Part A</td>
                                                    <td valign="top">Part B – Task 2</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center proximanova-bold">2</td>
                                                    <td>Part A</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>Part A</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center proximanova-bold">Pre-level 1</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                        <h1 class="proximanova-bold primary-font-color px-14-font text-justify"><span>Mapping of levels and indicators</span></h1>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">Each of the tasks included is mapped as given above. Each task is mapped to one or more skill level indicators, and the aspects of communication have also been identified.</p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">ACSF levels refer to exit levels; that is, the person is able to demonstrate what is required at that level. Users should always remember the factors that may influence a person’s performance at each level (in each core skill). These are:</p>
                                        <ul class="px-14-font text-justify no-margin paragraph-list">
                                            <li class="line-height-1point2">the degree and nature of <span class="proximanova-bold">support</span> available</li>
                                            <li class="line-height-1point2">he familiarity with the <span class="proximanova-bold">context</span></li>
                                            <li class="line-height-1point2">the complexity of <span class="proximanova-bold">text</span></li>
                                            <li class="line-height-1point2">the complexity of the <span class="proximanova-bold">task</span>.</li>
                                        </ul>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">The level of skill demonstrated by a candidate can be changed by the factors, for example, if significant support is given to a candidate completing a level 3 task, the outcome of the assessment could be that the candidate is at exit level 2. </p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">The table on the following page is from page 7 of the ACSF document, and shows how the levels of support, context, text and task complexity vary across the five levels of performance of the ACSF. It is critical that an assessor take in account this table when undertaking test and interpreting assessment results. </p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        <h1 class="proximanova-bold primary-font-color px-14-font 
                                        text-justify"><span>Support, context, text complexity, task complexity</span></h1>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        <table width="100%" class="default-bordered-table">
                                            <thead>
                                                <tr>
                                                    <th colspan="2" rowspan="2" class="no-border transparent-bg-color"></th>
                                                    <th colspan="4" class="proximanova-bold  px-14-font text-center">ACSF Performance</th>
                                                </tr>
                                                <tr>
                                                    <th width="22.5%" class="proximanova-bold  px-14-font text-center padding-y-10"><span>SUPPORT</span></th>
                                                    <th width="22.5%" class="proximanova-bold  px-14-font text-center padding-y-10"><span>CONTEXT</span></th>
                                                    <th width="22.5%" class="proximanova-bold  px-14-font text-center padding-y-10"><span>TEXT COMPLEXITY</span></th>
                                                    <th width="22.5%" class="proximanova-bold  px-14-font text-center padding-y-10"><span>TASK COMPLEXITY</span></th>
                                                </tr>
                                            </thead>
                                            <tbody class="px-14-font">
                                                <tr>
                                                    <td rowspan="5" width="3%"><div class="">
                                                    <img src="' . $ACSF_performance_table_text . '" alt="" class="img-responsive" style="width: 7px;">
                                                    </div></td>
                                                    <td width="3%"><span class="proximanova-bold text-center">1</span></td>
                                                    <td valign="top"><span>Works alongside an expert/ mentor where prompting and advice can be provided</span></td>
                                                    <td valign="top"><span>Highly familiar contexts Concrete and immediate Very restricted range of contexts</span></td>
                                                    <td valign="top"><span>Short and simple Highly explicit purpose Limited, highly familiar vocabulary</span></td>
                                                    <td valign="top"><span>Concrete tasks of 1 or 2 steps Processes include locating, recognising</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="proximanova-bold text-center"><span >2</span></td>
                                                    <td valign="top">May work with an expert/ mentor where support is available if requested</td>
                                                    <td valign="top">Familiar and predictable contexts Limited range of contexts</td>
                                                    <td valign="top">Simple familiar texts with clear purpose Familiar vocabulary</td>
                                                    <td valign="top">Explicit tasks involving a limited number of familiar steps Processes include identifying, simple interpreting, simple sequencing</td>
                                                </tr>

                                                <tr>
                                                    <td class="proximanova-bold text-center"><span >3</span></td>
                                                    <td valign="top">Works independently and uses own familiar support resources</td>
                                                    <td valign="top">Range of familiar contexts Some less familiar contexts Some specialisation in familiar/known contexts</td>
                                                    <td valign="top">Routine texts May include some unfamiliar elements, embedded information and abstraction Includes some specialised vocabulary</td>
                                                    <td valign="top">Tasks involving a number of steps Processes include sequencing, integrating, interpreting, simple extrapolating, simple inferencing, simple abstracting</td>
                                                </tr>
                                                <tr>
                                                    <td class="proximanova-bold text-center"><span>4</span></td>
                                                    <td valign="top">Works independently and initiates and uses support from a range of established resources</td>
                                                    <td valign="top">Range of contexts, including some that are unfamiliar and/or unpredictable Some specialisation in less familiar/known contexts</td>
                                                    <td valign="top">Complex texts Embedded information Includes specialised vocabulary Includes abstraction and symbolism</td>
                                                    <td valign="top">Complex task organisation and analysis involving application of a number of steps Processes include extracting, extrapolating, inferencing, reflecting, abstracting</td>
                                                </tr>
                                                <tr>
                                                    <td class="proximanova-bold text-center"><span>5</span></td>
                                                    <td valign="top">Autonomous learner who accesses and evaluates support from a broad range of sources</td>
                                                    <td valign="top">Broad range of contexts Adaptability within and across contexts Specialisation in one or more contexts</td>
                                                    <td valign="top">Highly complex texts Highly embedded information Includes highly specialised language and symbolism</td>
                                                    <td valign="top">Sophisticated task conceptualisation, organisation and analysis Processes include synthesising, critically reflecting, evaluating, recommending</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        <h1 class="proximanova-bold primary-font-color px-14-font text-justify"><span>Steps in the assessment process</span></h1>
                                        <p class="proximanova-bold px-14-font text-justify"><span>Step 1: The assessment interview</span></p>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">The assessment process should begin with an interview with the candidate. Use the PART A of test to guide the interview.</p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">The assessor should put the candidate at ease and explain that the purpose of the LLN test interview is to gather information about their educational background and LLN skill level to help determine future training support needs. They should also explain that the assessment will include a one-to-one chat and then some time will be given for the candidate to complete tasks of PART B. Assessors should encourage candidates to feel comfortable and ask questions at any time.</p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">The interview is an opportunity for the assessor to gather information about the candidate’s oral communication and learning skills. Assessors can also start thinking about which tasks may be appropriate, depending on the candidate’s background, interest areas and future training goals.</p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">PART A should be completed by the assessor in conversation with the candidate. Not all questions will be relevant. The form includes prompts for the assessor to flesh out questions where appropriate, but they could also use their own prompts.</p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">The self-reflection (included in PART A) is also designed to be completed through interview. It is a task to encourage candidates to talk about the skills they have and the skills they would like to develop.</p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">Because they are conducted orally, the assessment interview and the self-assessment are ways of specifically collecting information about the candidate’s oral communication skills. </p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">Ideally, an assessment interview would be conducted in a quiet place on a one-to-one basis.</p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                    
                                        <p class="proximanova-bold px-14-font text-justify"><span>Step 2: PART B Assessment tasks</span></p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">There are two assessment tasks in PART B. These are useful to get an idea of the candidate’s skill level. The tasks can provide valuable information about the candidate’s ability to cope with specific skills and language relevant to particular training.</p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">Remember to consider the support, context, text and task complexity factors when selecting the tasks. For example, a level 3 task given with a high level of support will deem the task level 2 in many cases.</p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        <p class="proximanova-bold px-14-font text-justify"><span>Step 3: Test by candidate</span></p>

                                        <p class="px-14-font text-justify line-height-1point2 text-justify">Ask the candidate to complete the first task and offer support if required. Remember that the level of support provided can change the level of skill noted in the task mapping. Ask the candidate to complete the tasks. </p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">Thank the candidate for completing the test and inform them about the process that will follow, which should include letting them know about any recommendations. </p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        
                                    
                                        <p class="proximanova-bold px-14-font text-justify"><span>Step 4: Make the assessment judgement</span></p>
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">Based on your knowledge of the ACSF skill levels, make a judgement about the candidate’s skill level. When making the judgement, remember to consider the support provided, the context, the task and the task complexity. For example, the candidate may have completed an ACSF level 3 task, but was only able to do it with support. The assessor will need to make a decision about whether this candidate is perhaps only performing at ACSF level 2 or lower. If the candidate’s performance indicates that they are not operating at the required ACSF level to complete the training successfully it might be necessary to recommend LLN support prior to, or during the training.  </p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        
                                        
                                        <p class="proximanova-bold px-14-font text-justify"><span>Step 5: Communicate the assessment decision to the candidate</span></p>

                                        <p class="px-14-font text-justify line-height-1point2 text-justify">It is good practice to ensure that candidates understand more about their LLN skill levels, having undertaken the assessment. Explain the results of the assessment to the candidate, what the levels mean, and how they may impact on and training that the candidate may undertake. Answer any questions that candidates may have.</p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        
                                        <p class="proximanova-bold px-14-font text-justify"><span>Step 6: Complete the report</span></p>
                                        
                                        <p class="px-14-font text-justify line-height-1point2 text-justify">Fill out the ACSF assessment record with details of the assessment.</p>
                                        ',
                                    ],
                                ],
                                'col_size' => 12
                            ],
                        ],
                    ],
                ] //end component
            ],
            [
                'component' => [ //start component
                    [
                        'title' => 'GETTING STARTED',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'info',
                                // 'label' => 'Information',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<p class="px-14-font text-justify line-height-1point2">Please read this information carefully before commencing the LLN Test. </p>

                                        <h1 class="proximanova-bold primary-font-color px-14-font text-justify"><span>1.0 WELCOME</span></h1>
                                        <p class="px-14-font text-justify line-height-1point2">Welcome to the Community Education Australia (CEA).</p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        <p class="px-14-font text-justify line-height-1point2">Before you are able to commence your course, you must successfully complete the LLN Test. Please note that if you are enrolled in more than one course with CEA, you will only need to complete the LLN Test once. </p>
                                        
                    
                                        <h1 class="proximanova-bold primary-font-color px-14-font text-justify"><span>2.0 ENTRY REQUIREMENTS</span></h1>
                                        <p class="px-14-font text-justify line-height-1point2">All students are required to undertake a Language Literacy and Numeracy (LLN) test prior to commencement of training. Outcomes from this test will be used by CEA to develop support strategies for students’ enrolment. It will also help CEA to decide whether or not it is able to provide required support services or referral to external agencies is required. </p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        <p class="px-14-font text-justify line-height-1point2">CEA requires ACSF level 3 in CPP20218 - Certificate II in Security Operations. </p>
                    
                    
                    
                                        <h1 class="proximanova-bold primary-font-color px-14-font text-justify"><span>3.0 LLN TEST</span></h1>
                                        <p class="proximanova-bold px-14-font text-justify"><span>Meeting Clause 1.7 of the Standards for RTOs 2015 </span></p>
                                        <p class="px-14-font text-justify line-height-1point2">The Standards for Registered Training Organisations (SRTOs) 2015 requires all RTOs to determine the support services necessary for individuals to meet the requirements of their desired training product, as outline in clause 1.7 (see clause below). As part of meeting this standard, we require that all prospective learners complete the LLN Test. </p>
                                        
                                        <p class="proximanova-bold px-14-font text-center"><span>Clause 1.7 from the Standards for Registered Training Organisations 2015:</span></p>
                                        
                                        <p class="px-14-font text-center line-height-1point2 text-italic">The RTO determines the support needs of individual learners and provides access to the educational and support services necessary for the individual learner to meet the requirements of the training product as specified in training packages or VET accredited courses.</p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        
                                        <p class="proximanova-bold px-14-font text-justify"><span>Format of LLN Test </span></p>
                                        <p class="px-14-font text-justify line-height-1point2">The LLN Test covers the five foundation skills (i.e. numeracy, learning, writing, reading and oral component). Please ensure you allocate time to complete the LLN Test in full. </p>
                    
                    
                                        <h1 class="proximanova-bold primary-font-color px-14-font text-justify"><span>4.0 STARTING THE LLN TEST</span></h1>
                                        <p class="px-14-font text-justify line-height-1point2">Be honest and complete this test without any external help although you can ask your trainer/assessor/staff for any questions about the requirements of this test and follow the instructions. </p>
                    
                                        <h1 class="proximanova-bold primary-font-color px-14-font text-justify"><span>5.0 COMMENCEMENT OF TRAINING</span></h1>
                                        <p class="px-14-font text-justify line-height-1point2">Once you have successfully completed the LLN Test, the outcome will be communicated to you and training will be commenced accordingly.</p>
                    
                                        <h1 class="proximanova-bold primary-font-color px-14-font text-justify"><span>6.0 SUPPORT SERVICES</span></h1>
                                        <p class="px-14-font text-justify line-height-1point2">CEA recognises the importance of adequate skills in English. LLN improving literacy skills will assist in ensuring education is available to all. LLN test has been designed to describe variations in arrangements for our clients who have specific language, literacy and numeracy needs and the support services available to these persons. Students with special needs in the areas of Language, Literacy and Numeracy will have access to assistance and support to fulfil their training needs. </p>
                                        <div class="clearfix" style="height: 10px;"></div>
                    
                                        <p class="px-14-font text-justify line-height-1point2">CEA endeavours to equip the participant to undertake the tasks of the profession. The Training Department will consult with the Trainers and Assessors to analyse necessary requirements to meet the participant’s individual needs. Where these needs cannot be met, a refund will be given to the participant. </p>
                                        <div class="clearfix" style="height: 10px;"></div>
                    
                                        <p class="px-14-font text-justify line-height-1point2">Where support needs to go beyond what can be met with reasonable adjustment during the training and assessment process, and additional support is required, CEA will direct participants to an external literacy specialist. </p>',
                                    ],
                                ],
                                'col_size' => 12
                            ],
                        ],
                        
                    ]
                ] //end component
            ],
            [
                'component' => [ //start component
                    [
                        'title' => 'GETTING STARTED',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'info',
                                // 'label' => 'Information',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<div class="clearfix" style="height: 300px;"></div>
                                        <p class=" text-center line-height-1point2">You are now ready to commence the LLN Test. We wish you all the best with your new studies.</p><div class="clearfix" style="height: 300px;"></div>',
                                    ],
                                ],
                                'col_size' => 12
                            ],
                        ],
                        
                    ]
                ] //end component
            ],
            [
                'component' => [ //start component
                    [
                        'title' => 'PART A',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'info',
                                // 'label' => 'Information',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<p class="proximanova-bold px-14-font text-justify"><span>Purpose of the documents: </span></p>
                                        <p class="px-14-font text-justify line-height-1point2">The purpose of this test is to ensure you have the language, literacy and numeracy skills needed to undertake your course of training. It will also show how we can assist you in any areas where you may need help to ensure your success to gain the qualification. </p>
                                        <br>
                                        <br>
                                        <p class="proximanova-bold px-14-font text-justify"><span class="text-underline">Personal details:</span> <span> Please provide the information required in the form below. </span></p>
                                        <div class="clearfix" style="height: 10px;"></div>
                                        <p class="px-14-font text-justify line-height-1point2">CEA respects your privacy and will not pass on your personal details to other organisations except as required by law. </p> 
                                        <br>
                                        <br>',
                                    ],
                                ],
                                'col_size' => 12
                            ],
                            [
                                'type' => 'text',
                                'name' => 'candidate_name',
                                'label'=> 'Candidate name',
                                // 'value' => 'asdsad',
                                // 'value' => isset($lln_val) ? $lln_val['candidate_name'] : '',
                                // 'required'=> true,
                                // 'col_size' => 12,
                            ],
                            // [
                            //     'type' => 'text',
                            //     'name' => 'student_id',
                            //     'label'=> 'Student ID',
                            //     // 'required'=> true,
                            //     // 'col_size' => 12,
                            // ],
                            [
                                'type' => 'date',
                                'name' => 'date_of_birth',
                                'label'=> 'Date of Birth',
                                // 'required'=> true,
                                // 'col_size' => 12,
                            ],
                            // [
                            //     'type' => 'text',
                            //     'name' => 'signature',
                            //     'label'=> 'Signature',
                            //     // 'required'=> true,
                            //     // 'col_size' => 12,
                            // ],
                            [
                                'type' => 'date',
                                'name' => 'date',
                                'label'=> 'Date',
                                // 'required'=> true,
                                // 'col_size' => 12,
                            ],
                            
                        ],
                        
                    ]
                ] //end component
            ],
            [
                'component' => [ //start component
                    [
                        'title' => 'PART A',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'info',
                                // 'label' => 'Assessor Instructions:',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<h1 class="proximanova-bold primary-font-color px-14-font text-justify"><span>Assessor Instructions:</span></h1>
                                        <ul class="px-14-font text-justify no-margin paragraph-list">
                                            <li class="line-height-1point2">This task covers ACSF Learning and Oral communication at Levels 1, 2 or 3</li>
                                            <li class="line-height-1point2">This part (Part A) has to be completed by Assessor</li>
                                            <li class="line-height-1point2">This task requires the candidate to:
                                                <ul>
                                                    <li>listen and respond to oral questions</li>
                                                    <li>reflect on his/her learning</li>
                                                </ul>
                                            </li>
                                            <li class="line-height-1point2">Put the candidate at ease and explain that the purpose of the LLN test interview is to gather information about the candidate’s LLN skill level to help determine if they have the skills for a particular course of training, or if support is required. It includes a series of questions followed by a self-reflection task.</li>
                                            <li class="line-height-1point2">Ask the questions orally and note the candidate’s answers in the space provided.</li>
                                            <li class="line-height-1point2">Encourage the candidate to feel comfortable and ask questions at any time. </li>
                                        </ul>
                                        <div class="clearfix" style="height: 30px;"></div>
                                        ',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<h1 class="proximanova-bold primary-font-color px-14-font text-justify"><span>Training goals:</span></h1>',
                                    ]
                                ],
                                'col_size' => 12
                            ],
                        ],
                    ],
                    [
                        'title' => '1. Can you tell me about something that you learned recently?',
                        'inputs' => [
                            [
                                'type' => 'textarea',
                                'name' => 'parta_prompt1',
                                'label'=> 'How did you learn it? People learn new skills every day, such as how to use the internet, how to record TV shows or how to drive a car. (NOTE: This question is to gather information about HOW the learning occurred, rather than WHAT the learning was about.)',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                        ]
                    ],
                    [
                        'title' => '2. What do you like about learning? Can you talk about how you think you like to learn? ',
                        'inputs' => [
                            [
                                'type' => 'textarea',
                                'name' => 'parta_prompt2',
                                'label'=> 'What helps you to learn? People learn in different ways. Some learn best by listening and writing, some from visual aids such as the
                                whiteboard or the TV, some learn by watching and doing. Others like to learn in a group, while some people prefer to learn one-on-one
                                with a support person.
                                ',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                        ]
                    ],
                    [
                        'title' => '3. What are you good at? ',
                        'inputs' => [
                            [
                                'type' => 'textarea',
                                'name' => 'parta_prompt3',
                                'label'=> 'This may include reading (newspapers, emails, websites, notice boards, manuals); writing (letters, emails, forms, lists, messages, reports);
                                numeracy (calculations, times tables, 24-hour clock, measurement, money and finance); speaking and listening (talking on the phone,
                                asking for information, giving instructions or presentations).',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                        ]
                    ],
                    [
                        'title' => '4. What would you like to learn? ',
                        'inputs' => [
                            [
                                'type' => 'textarea',
                                'name' => 'parta_prompt4',
                                'label'=> 'This might include specific vocational tasks, or it may be more general, such as reading novels or TV guides, writing letters, reading
                                maps, using a calculator or reading a bus timetable.',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                        ]
                    ],
                    [
                        'title' => '5. What helps you to learn? ',
                        'inputs' => [
                            [
                                'type' => 'textarea',
                                'name' => 'parta_prompt5_a',
                                'label'=> 'You could ask if there are barriers, for example the need for glasses; medication or family issues; unsuccessful previous schooling;English is second language. Some may be able to identify a preference for small groups, extra time, one-on-one support, a mentor, tape recorder, computer, dictionary, calculator, etc.',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'card',
                                'name' => 'info',
                                // 'label' => 'Assessor Instructions:',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<h1 class="proximanova-bold primary-font-color px-14-font text-justify"><span><b>Educational background</b></span></h1> ',
                                    ]
                                ]
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'parta_prompt5_b',
                                'label'=> 'Have you been enrolled in training (vocational training or tertiary studies) since you left school? If yes, which courses?',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'card',
                                'name' => 'info',
                                // 'label' => 'Assessor Instructions:',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<h1 class="proximanova-bold primary-font-color px-14-font text-justify"><span><b>Employment</b></span></h1>  ',
                                    ]
                                ]
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'parta_prompt5_c',
                                'label'=> 'In what sort of jobs have you worked?',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'parta_prompt5_d',
                                'label'=> 'Did you receive on-the-job training?',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'parta_prompt5_e',
                                'label'=> 'Did you do any writing at work? If so, what sort? What types of tasks involved writing? For example, taking telephone messages or filling in forms.',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'parta_prompt5_f',
                                'label'=> 'Which skills would you require to be able to work in industry related to desired job role?',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                        ]
                    ],
                    [
                        'title' => '6. What sorts of maths did you use at work?',
                        'inputs' => [
                            [
                                'type' => 'textarea',
                                'name' => 'parta_prompt6',
                                'label'=> 'Did you use a calculator, count stock and materials, or measure? Did you use calculations? Give directions? Read maps?',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                        ]
                    ],
                    [
                        'title' => '7. What work skills do you already have?',
                        'inputs' => [
                            [
                                'type' => 'textarea',
                                'name' => 'parta_prompt7_a',
                                'label'=> 'Team work, using technology, communication, self-management, problem solving, learning, initiative, planning',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'parta_prompt7_b',
                                'label'=> 'What skills would you like to develop from this course?',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                        ]
                    ],


                ] //end component
            ],
            [
                'component' => [ //start component
                    [
                        'title' => 'Self-reflection ( Tell us about your reading, writing and numeracy skills. You can … )',
                        'inputs' => [
                            [
                                'type' => 'radio',
                                'name' => 'parta_understand_signs',
                                'label' => '1. understand signs',
                                'col_size' => 4,
                                'content' => [
                                    [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'Sometimes',
                                        'description' => 'Sometimes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'parta_fill_in_time_sheet',
                                'label' => '2. fill in a time sheet',
                                'col_size' => 4,
                                'content' => [
                                     [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'Sometimes',
                                        'description' => 'Sometimes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'parta_count_and_check',
                                'label' => '3. count and check change when shopping',
                                'col_size' => 4,
                                'content' => [
                                     [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'Sometimes',
                                        'description' => 'Sometimes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'parta_send_text_msg',
                                'label' => '4. Send a text message',
                                'col_size' => 4,
                                'content' => [
                                     [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'Sometimes',
                                        'description' => 'Sometimes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'parta_use_the_internet',
                                'label' => '5. use the internet to get information like telephone numbers',
                                'col_size' => 4,
                                'content' => [
                                     [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'Sometimes',
                                        'description' => 'Sometimes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'parta_fill_in_leave_form',
                                'label' => '6. fill in a leave form',
                                'col_size' => 4,
                                'content' => [
                                     [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'Sometimes',
                                        'description' => 'Sometimes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'parta_read_staff_memo',
                                'label' => '7. read a staff memo',
                                'col_size' => 4,
                                'content' => [
                                     [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'Sometimes',
                                        'description' => 'Sometimes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'parta_use_computer',
                                'label' => '8. use a computer to email',
                                'col_size' => 4,
                                'content' => [
                                     [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'Sometimes',
                                        'description' => 'Sometimes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'parta_use_calculator',
                                'label' => '9. use a calculator for + – x ÷',
                                'col_size' => 4,
                                'content' => [
                                     [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'Sometimes',
                                        'description' => 'Sometimes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'parta_read_newspaper',
                                'label' => '10. read a newspaper',
                                'col_size' => 4,
                                'content' => [
                                     [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'Sometimes',
                                        'description' => 'Sometimes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'parta_read_work_roster',
                                'label' => '11. read a work roster',
                                'col_size' => 4,
                                'content' => [
                                     [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'Sometimes',
                                        'description' => 'Sometimes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'parta_follow_instructions',
                                'label' => '12. follow instructions for mixing a solution or to follow a recipe',
                                'col_size' => 4,
                                'content' => [
                                     [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'Sometimes',
                                        'description' => 'Sometimes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'parta_read_google',
                                'label' => '13. read a Google map or street directory',
                                'col_size' => 4,
                                'content' => [
                                     [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'Sometimes',
                                        'description' => 'Sometimes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'parta_read_and_understand',
                                'label' => '14. read and understand an MSDS',
                                'col_size' => 4,
                                'content' => [
                                     [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'Sometimes',
                                        'description' => 'Sometimes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'parta_use_equipment_manual',
                                'label' => '15. use an equipment manual',
                                'col_size' => 4,
                                'content' => [
                                     [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'Sometimes',
                                        'description' => 'Sometimes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'parta_complete_log_book',
                                'label' => '16. complete a log book',
                                'col_size' => 4,
                                'content' => [
                                     [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'Sometimes',
                                        'description' => 'Sometimes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'parta_write_incident_report',
                                'label' => '17. write an incident report',
                                'col_size' => 4,
                                'content' => [
                                     [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'Sometimes',
                                        'description' => 'Sometimes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                        ]
                    ],
                    [
                        'title' => 'Assessor notes',
                        'inputs' => [
                            [
                                'type' => 'textarea',
                                'name' => 'parta_assessor_notes',
                                'label'=> '',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                        ],
                        
                    ]
                ] //end component
            ],
            [
                'component' => [ //start component
                    [
                        'title' => 'PART B',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'info',
                                // 'label' => 'Information',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<h1 class="proximanova-bold primary-font-color px-14-font text-justify"><span>Student Instructions: </span></h1>
                                        <ul class="px-14-font text-justify no-margin paragraph-list">
                                            <li class="line-height-1point2">This part (Part B) has to be completed by prospective student (Tasks 1 – 2) </li>
                                            <li class="line-height-1point2">Provide answers to the following questions </li>
                                            <li class="line-height-1point2">Print Clearly </li>
                                            <li class="line-height-1point2">Answer all questions </li>
                                            <li class="line-height-1point2">Use a pen or type the answers in a word document. Answers written in pencil will not be accepted</li>
                                            <li class="line-height-1point2">Do not cheat. </li>
                                            <li class="line-height-1point2"> Your text may be in full sentences and may also include dot points. Use paragraphs and correct spelling and grammar. Check with your assessor if you need clarification. You may use the computer if you need to. Remember to plan your work before you start and to check your work before you finish. </li>
                                        </ul>',
                                    ],
                                ],
                                'col_size' => 12
                            ],
                            
                        ],
                        
                    ],
                    [
                        'title' => 'Task 1: Reading and Writing',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'info',
                                // 'label' => 'Information',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<p class="px-14-font text-justify line-height-1point2">This task covers: </p>
                                        <ul class="px-14-font text-justify no-margin paragraph-list">
                                            <li class="line-height-1point2">ACSF Reading Level 3 </li>
                                            <li class="line-height-1point2">ACSF Writing Levels 2 and 3 (Q.1 and Q.2)</li>
                                            <li class="line-height-1point2">ACSF Writing Levels 3 or 4, depending on response (Q.3)</li>
                                        </ul>',
                                    ]
                                ],
                            ],
                            [
                                'type' => 'card',
                                'name' => 'info',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<p class="px-14-font text-justify line-height-1point2"><span class="proximanova-bold">Q.1</span> Given below is a poster by WorkSafe at www.worksafe.vic.gov.au/forklift. In your own words explain what you think is meant by the following words that appear on poster – <span class="proximanova-bold">Forklifts and people don’t mix</span>.</p>
                                        ',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'card',
                                'name' => 'info',
                                'col_size' => 5,
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<center><img src="' . $q1_worksafe_img . '" alt="" class="img-responsive" style="width: 300px;"></center>',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'partb_task1_q1',
                                'label'=> '',
                                // 'required'=> true,
                                'col_size' => 7,
                            ],
                            [
                                'type' => 'card',
                                'name' => 'info',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<p class="px-14-font text-justify line-height-1point2"><span class="proximanova-bold">Q.2</span> Using the poster given below write a text that includes: </p>
                                        <ul class="px-14-font text-justify no-margin paragraph-list">
                                            <li class="line-height-1point2">an introduction</li>
                                            <li class="line-height-1point2">what is similar in this poster and poster in Q.1. </li>
                                            <li class="line-height-1point2"> a description about what is different about the two posters</li>
                                            <li class="line-height-1point2">an opinion with supporting reasons about which poster is more effective in communicating its message.</li>
                                        </ul>',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'card',
                                'name' => 'info',
                                'col_size' => 5,
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<center><img src="' . $q2_worksafe_img . '" alt="" class="img-responsive" style="width: 300px;"></center>',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'partb_task1_q2',
                                'label'=> '',
                                // 'required'=> true,
                                'col_size' => 7,
                            ],
                            [
                                'type' => 'card',
                                'name' => 'info',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<p class="px-14-font text-justify line-height-1point2"><span class="proximanova-bold">Q.3</span> Choose one of the following topics and write as much as you can. Add extra sheet if you need.  </p>
                                        <ul class="px-14-font text-justify no-margin paragraph-list">
                                            <li class="line-height-1point2">Smoking should be banned outside workplaces as well as inside </li>
                                            <li class="line-height-1point2">CEOs are overpaid</li>
                                            <li class="line-height-1point2">Two weeks paternity leave should be a right for all male workers</li>
                                            <li class="line-height-1point2">Women make better managers</li>
                                        </ul>
                                        <p class="px-14-font text-justify line-height-1point2">Use paragraphs and correct spelling and grammar. Check with your assessor if you need clarification. You may use the computer if you need to, but cannot copy. Remember to plan your work before you start and to check your work before you finish. </p>',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'partb_task1_q3',
                                'label'=> '',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                        ]
                    ],
                    [
                        'title' => 'Task 2: Numeracy',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'info',
                                // 'label' => 'Information',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<p class="px-14-font text-justify line-height-1point2">This task covers ACSF Numeracy Levels 2 and 3</p>',
                                    ]
                                ],
                            ],
                            [
                                'type' => 'text',
                                'name' => 'partb_task2_q1',
                                'label'=> 'Q.1 A box holds 15 lettuces. At the end of the day the farm crew had filled 86 boxes. How many lettuces is that in total? Show how you worked this out.',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'partb_task2_q2',
                                'label'=> 'Q.2 Diesel costs $1.86 per litre. The tractor’s fuel tank is empty. When full it holds 1200 litres. How much money
                                would it cost to fill up the tractor with fuel? Show how you worked this out. 
                                ',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'card',
                                'name' => 'info',
                                'label' => 'Q.3 The table below shows the average price of petrol per litre for the period July 2009 to June 2010. Read the information and then answer the questions that follow.',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<table width="70%" class="table default-bordered-table" style="    margin-left: 20%!important;
                                        width: 60%!important;">
                                            <thead>
                                                <tr>
                                                    <th class="proximanova-bold px-14-font white-font-color text-center" width="50%">Month </th>
                                                    <th class="proximanova-bold px-14-font white-font-color text-center" width="50%">Average price/litre</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>July 2009  </td>
                                                    <td>$1.14</td>
                                                </tr>
                                                <tr>
                                                    <td>August 2009  </td>
                                                    <td>$1.15</td>
                                                </tr>
                                                <tr>
                                                    <td>September 2009  </td>
                                                    <td>$1.13</td>
                                                </tr>
                                                <tr>
                                                    <td>October 2009 </td>
                                                    <td>$1.18</td>
                                                </tr>
                                                <tr>
                                                    <td>November 2009  </td>
                                                    <td>$1.20</td>
                                                </tr>
                                                <tr>
                                                    <td>December 2009 </td>
                                                    <td>$1.22 </td>
                                                </tr>
                                                <tr>
                                                    <td>January 2010  </td>
                                                    <td>$1.26</td>
                                                </tr>
                                                <tr>
                                                    <td>February 2010 </td>
                                                    <td>$1.23</td>
                                                </tr>
                                                <tr>
                                                    <td>March 2010  </td>
                                                    <td>$1.24</td>
                                                </tr>
                                                <tr>
                                                    <td>April 2010  </td>
                                                    <td>$1.23</td>
                                                </tr>
                                                <tr>
                                                    <td>May 2010  </td>
                                                    <td>$1.27</td>
                                                </tr>
                                                <tr>
                                                    <td>June 2010  </td>
                                                    <td>$1.30</td>
                                                </tr>
                                            </tbody>
                                        </table>',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'text',
                                'name' => 'partb_task2_q3_a',
                                'label'=> 'a) In which month was the petrol price the lowest?',
                                // 'required'=> true,
                                // 'col_size' => 12,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'partb_task2_q3_b',
                                'label'=> 'b) In which two months was the price of petrol the same?',
                                // 'required'=> true,
                                // 'col_size' => 12,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'partb_task2_q3_c',
                                'label'=> 'c) In which month was the price of petrol the highest?',
                                // 'required'=> true,
                                // 'col_size' => 12,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'partb_task2_q3_d',
                                'label'=> 'd) In which month did the price of petrol increase the most?',
                                // 'required'=> true,
                                // 'col_size' => 12,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'partb_task2_q3_e',
                                'label'=> 'e) What was the general trend in the price of petrol over this 12 month period?',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'card',
                                'name' => 'partb_task2_q4',
                                'label'=> 'Q.4 HandyStores is having a sale. All items have been reduced by 30%. Complete the table to show the sale price of the items. Show how you worked out your answers.',
                                'content' => [
                                    [
                                        'type' => 'table',
                                        'body' => [
                                            'column_width' => ['30%','30%','40%'],
                                            'thead' => [
                                                'Item',
                                                'Normal price ',
                                                'Sale price – 30% off',
                                            ],
                                            'text_type' => ['text-left','text-left','text-left'],
                                            'tbody' => [
                                                [
                                                    'Men’s woollen socks',
                                                    '2 pair pack for $20.00',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'partb_task2_q4_a',
                                                    ],
                                                ],
                                                [
                                                    'Children’s pyjamas ',
                                                    '$18.00',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'partb_task2_q4_b',
                                                    ],
                                                ],
                                                [
                                                    'Women’s jumpers',
                                                    '$35.00 ',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'partb_task2_q4_c',
                                                    ],
                                                ],
                                                [
                                                    'Sports shoes ',
                                                    '$50.00 ',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'partb_task2_q4_d',
                                                    ],
                                                ],
                                                [
                                                    'Football scarves ',
                                                    '$22.00 ',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'partb_task2_q4_e',
                                                    ],
                                                ]
                                            ]
                                        ]
                                    ]
                                    
                                ],
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'card',
                                'name' => 'info',
                                'label' => 'Q.5 A phone survey asked 300 people the following question:',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<br> <p class="px-14-font text-justify line-height-1point2"><i>Should Australia export live cattle? Answer: Yes or No.</i></p>
                                        <br>
                                        <p class="px-14-font text-justify line-height-1point2">The results of the survey were: Yes 45% No 55%</p>',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'partb_task2_q5_a',
                                'label'=> 'a) How many people voted yes? Show how you worked this out.',
                                // 'required'=> true,
                                // 'col_size' => 12,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'partb_task2_q5_b',
                                'label'=> 'b) How many people voted no? Show how you worked this out. ',
                                // 'required'=> true,
                                // 'col_size' => 12,
                            ],
                            [
                                'type' => 'card',
                                'name' => 'partb_task2_q5_c',
                                'label' => 'c) Plot a bar graph on the grid below to illustrate the poll results.',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<center><img src="' . $partb_q5_c . '" alt="" class="img-responsive" style="width: 200px;"></center>',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'card',
                                'name' => 'info',
                                'label' => 'Q.6 Use the information from the signs below to answer the questions that follow. Show how you worked out all your answers.',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<center><img src="' . $partb_q6 . '" alt="" class="img-responsive" style="width: 550px;"></center> ',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'text',
                                'name' => 'partb_task2_q6_a',
                                'label'=> 'a) What are the total hours that Café Relaxo is open in one full week?',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'partb_task2_q6_b',
                                'label'=> 'b) What are the total hours that Café Cino is open in one full week?',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'partb_task2_q6_c',
                                'label'=> 'c) Tony works in Café Relaxo on the following days – Monday, Wednesday, Thursday, Friday. Ramos works in Café Cino on Wednesday, Saturday, Sunday. Who works more hours in a week, Tony or Ramos? Show how you worked this out. (Ignore break times)',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'partb_task2_q6_d',
                                'label'=> 'd) Ramos is paid $18.00/hour. What is his total pay for one week (before tax)? Show how you worked this out. ',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'partb_task2_q6_e',
                                'label'=> 'e) Tony is paid 25%/hour more than Ramos. What is his total pay for one week (before tax)? Show how you worked this out. ',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'card',
                                'name' => 'task2_q7',
                                'label'=> 'Q.7 The perimeter of a rectangle is 64m. What are three possible measurements for the length and width? What is the area of these rectangles?',
                                'content' => [
                                    [
                                        'type' => 'table',
                                        'body' => [
                                            'column_width' => ['10%','30%','30%','30%'],
                                            'thead' => [
                                                'Answer number ',
                                                'Length',
                                                'Width',
                                                'Area',
                                            ],
                                            'text_type' => ['text-center','text-left','text-left','text-left'],
                                            'tbody' => [
                                                [
                                                    'a)',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'partb_task2_q7_a_length',
                                                    ],
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'partb_task2_q7_a_width',
                                                    ],
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'partb_task2_q7_a_area',
                                                    ],
                                                ],
                                                [
                                                    'b)',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'partb_task2_q7_b_length',
                                                    ],
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'partb_task2_q7_b_width',
                                                    ],
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'partb_task2_q7_b_area',
                                                    ],
                                                ],
                                                [
                                                    'c)',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'partb_task2_q7_c_length',
                                                    ],
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'partb_task2_q7_c_width',
                                                    ],
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'partb_task2_q7_c_area',
                                                    ],
                                                ],
                                            ]
                                        ]
                                    ]
                                    
                                ],
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'card',
                                'name' => 'task2_q8',
                                'label'=> 'Q.8 Fill in the gaps in the following table. Simplify the fraction in column one. The first one has been done for you. ',
                                'content' => [
                                    [
                                        'type' => 'table',
                                        'body' => [
                                            'column_width' => ['30%','30%','30%'],
                                            'thead' => [
                                                'Fraction',
                                                'Decimal',
                                                'Percentage',
                                            ],
                                            'text_type' => ['text-center','text-center','text-center'],
                                            'tbody' => [
                                                [
                                                    '1/10',
                                                    '0.1',
                                                    '10%',
                                                ],
                                                [
                                                    '1/5 ',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'partb_task2_q8_row2_decimal',
                                                    ],
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'partb_task2_q8_row2_percentage',
                                                    ],
                                                ],
                                                [
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'partb_task2_q8_row3_fraction',
                                                    ],
                                                    '0.7',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'partb_task2_q8_row3_percentage',
                                                    ],
                                                ],
                                                [
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'partb_task2_q8_row4_fraction',
                                                    ],
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'partb_task2_q8_row4_decimal',
                                                    ],
                                                    '65% ',
                                                ],
                                                [
                                                    '16/25',
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'partb_task2_q8_row5_decimal',
                                                    ],
                                                    [
                                                        'type' => 'text',
                                                        'name' => 'partb_task2_q8_row5_percentage',
                                                    ],
                                                ],
                                            ]
                                        ]
                                    ]
                                    
                                ],
                                'col_size' => 12,
                            ],
                        ],
                    ],
                ] //end component
            ],
            [
                'component' => [ //start component
                    [
                        'title' => 'Outcome',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'info',
                                // 'label' => 'Information',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<p class="px-14-font text-justify line-height-1point2"><i>The use of this test does not remove the need to consult with a Language, Literacy and Numeracy (LLN) specialist or external networks and agencies if and when required. Fill out the table below based on your observations and the conversations held.</i></p>',
                                    ],
                                ],
                                'col_size' => 12
                            ],
                            // [
                            //     'type' => 'check-description',
                            //     'name' => 'outcome_assessed1',
                            //     'label' => 'I have assessed the student’s performance of the test and based on the results obtained, the student:',
                            //     'col_size' => 12,
                            //     'content' => [
                            //         [
                            //             'value' => false,
                            //             'description' => '<b>Has demonstrated they have the required level of ACSF</b> to enable them to complete the course successfully with no support in this area required.',
                            //         ],
                            //         [
                            //             'value' => false,
                            //             'description' => '<b>Does not have a required level of ACSF</b> and may require extensive additional support to complete this course successfully. I am referring this student for support that can be offered with possible referral to external agencies if and when required.',
                            //         ],
                            //         [
                            //             'value' => false,
                            //             'description' => '<b>Has demonstrated they may require additional support for required ACSF level</b> and I am able to provide this. The student and I will develop an action plan to ensure they are given the opportunity to develop their language, literacy and/or numeracy skills to enable them to complete the course successfully.',
                            //         ],
                            //     ],
                            // ],
                            [
                                'type' => 'check-description',
                                'name' => 'outcome_assessed1',
                                'value' => false,
                                'label' => 'I have assessed the student’s performance of the test and based on the results obtained, the student:',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => false,
                                        'description' => 'Has demonstrated they have the required level of ACSF to enable them to complete the course successfully with no support in this area required.',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'outcome_assessed2',
                                // 'label' => 'I have assessed the student’s performance of the test and based on the results obtained, the student:',
                                'col_size' => 12,
                                'content' => [
                                   
                                    [
                                        'value' => false,
                                        'description' => 'Does not have a required level of ACSF and may require extensive additional support to complete this course successfully. I am referring this student for support that can be offered with possible referral to external agencies if and when required.',
                                    ],
                                   
                                ],
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'outcome_assessed3',
                                // 'label' => 'I have assessed the student’s performance of the test and based on the results obtained, the student:',
                                'col_size' => 12,
                                'content' => [
                                   
                                    [
                                        'value' => false,
                                        'description' => 'Has demonstrated they may require additional support for required ACSF level and I am able to provide this. The student and I will develop an action plan to ensure they are given the opportunity to develop their language, literacy and/or numeracy skills to enable them to complete the course successfully.',
                                    ],
                                   
                                ],
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'outcome_outline',
                                'label'=> '* Please outline the arrangements made for supporting the student through the course. ',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'outcome_assessor_name',
                                'label'=> 'Assessor name',
                                // 'required'=> true,
                                // 'col_size' => 12,
                            ],
                            // [
                            //     'type' => 'text',
                            //     'name' => 'outcome_signature',
                            //     'label'=> 'Assessor Signature',
                            //     // 'required'=> true,
                            //     // 'col_size' => 12,
                            // ],
                            [
                                'type' => 'date',
                                'name' => 'outcome_assessor_date',
                                'label'=> 'Date',
                                // 'required'=> true,
                                // 'col_size' => 12,
                            ],
                        ],
                        
                    ]
                ] //end component
            ]
        ];

        return $pages;
    }

    public function llntest_submit(Request $request, $process_id){
        // dump($request);
        $request = $request->inputs;
        // dd($request);
        // $data = [
        //     $pages = $request['savePages'],
        //     $inputs = $request['inputs']
        // ];
        // dump(json_encode($data));
        // dump($request);
        // dd($request['pages']);
        // $validator = Validator::make($request, [
        //     'candidate_name' => 'required',
        //     'date_of_birth'  => 'required',
        //     'student_id'     => 'required'
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['status' => 'errors', 'errors' => $validator->messages()]);
        // }
        
        // dd(json_encode($request));
        try {
            // start db transaction
            DB::beginTransaction();

            $enroll_pack = EnrolmentPack::where('process_id', $process_id)->first();
            $enroll_pack->fill([
                'lln'           => json_encode($request)
            ]);
            $enroll_pack->save();

            DB::commit();


            return json_encode(['data' => $request, 'status' => 'success']);
        } catch (\Exception $e) {
            // rollback db transactions
            DB::rollBack();

            // return to previous page with errors
            return  response()->json(['message' => $e->getMessage(), 'status' => 'errors']);
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
        $enroll_pack = EnrolmentPack::where('process_id', $process_id)->first();
        $e_form = $enroll_pack->enrolment_form; 
        $e_form = json_decode($e_form, true);
        $personal_details = [];
        $dob = null;

        foreach($e_form as $e){
            foreach($e as $f){
                // dd($f);
                foreach($f as $g){
                    if($g['title'] == "3. Personal Details"){
                        foreach($g['inputs'] as $h){
                            if($h['name'] == 'date_of_birth'){
                                $dob = $h['value'];
                            }
                            $personal_details[] = $h;
                        }
                    }
                }
            }
        }
        

        \JavaScript::put([
            'student_name'      => $enroll_pack->student_name,
            // 'student_dob'       => Carbon::parse($dob)->format('m/d/Y'),
            'lln_inputs'        => $enroll_pack->lln != null ? json_decode($enroll_pack->lln, true) : [],
            'student_dob'       => $dob,
            'personal_details'  => $personal_details,
            'process_id'        => $process_id,
            'pages'             => $this->pages(),
        ]);
        return view('lln-test.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($process_id)
    {
        //
        // dd($this->pages($process_id));
        $enroll_pack = EnrolmentPack::where('process_id', $process_id)->first();
        // dd($enroll_pack->lln);
         \JavaScript::put([
            'pages'      => $this->pages($process_id),
            'lln_inputs'      => $enroll_pack->lln != null ? json_decode($enroll_pack->lln, true) : [],
            'process_id' => $process_id,
        ]);

        return view('lln-test.index');
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

        $enroll_pack = EnrolmentPack::where('process_id', $process_id)->first();
        $lln_test = json_decode($enroll_pack->lln, true);
        $student_signature = $enroll_pack->student_signature;
        // dd($student_signature);
         // Company Details
         $com_setting = TrainingOrganisation::first();
         if ($com_setting->logo_img != null) {
             $logo = 'storage/config/images/' . $com_setting->logo_img;
         } else {
             $logo = 'images/logo/vorx_logo.png';
         }
         $logo_url = url('/' . $logo . '');
        //  dd($lln_test);
         $file_name = $enroll_pack->student_name. '.pdf';
         return \PDF::loadView('lln-test.cea_lln_test_pdf', compact('lln_test','student_signature','logo_url'))->setPaper(array(0, 0, 612, 936), 'portrait')->stream($file_name);
    }
}
