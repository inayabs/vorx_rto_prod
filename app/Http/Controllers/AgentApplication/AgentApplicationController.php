<?php

namespace App\Http\Controllers\AgentApplication;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Send\EmailSendingController;
use App\Models\EmailAutomation;
use App\Models\AgentApplication;
use App\Models\TrainingOrganisation;
use App\Models\AgentApplicationMandatoryDocument;
use App\Models\AgentApplicationAttachment;

use File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;
use Auth;
use Illuminate\Support\Str;

use function PHPSTORM_META\type;

class AgentApplicationController extends Controller
{

    // public function __construct() {
    //     // dd(config('app.name'));
    //     if(config('app.name') != 'Phoenix'){
    //         abort(403, 'Unauthorized action.');
    //     }
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {

        $app_setting = TrainingOrganisation::first();

        \JavaScript::put([
            'app_settings'  => $app_setting,
            'pages'         => $this->pages(),
            'logo_url'      => $this->get_logo(),
        ]);

        return view('agent-application.index');
    }

    public function pages($process_id = null)
    {
        if ($process_id != null) {
            $aa = AgentApplication::where('process_id', $process_id)->first();
            $application_form = Storage::get('/public/agent/' . $aa->process_id . '/agent-application-form.txt');
            return json_decode($application_form, true);
        }

        $pages = [
            [
                "component" => [ //start components
                    [
                        "title" => 'GETTING STARTED',
                        'inputs' => [
                            [
                                'type' => 'text',
                                'name' => 'name_of_company',
                                'label' => 'Name of the company',
                                // 'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'abn',
                                'label' => 'ABN',
                                // 'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'name_of_contact_person',
                                'label' => 'Name of the contact person',
                                'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'position',
                                'label' => 'Position',
                                // 'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'marn',
                                'label' => 'Migration Agent Registration Authority Number (MARN)/QEAC ( if applicable)',
                                'col_size' => 12,
                                // 'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'address',
                                'label' => 'Address',
                                'col_size' => 12,
                                'required' => true,
                            ],
                            [
                                'type' => 'number',
                                'name' => 'phone_no',
                                'label' => 'Phone No',
                                'required' => true,
                            ],
                            [
                                'type' => 'number',
                                'name' => 'mobile_no',
                                'label' => 'Mobile No',
                                // 'required' => true,
                            ],
                            [
                                'type' => 'email',
                                'name' => 'agent_email',
                                'label' => 'Agent' .''."'".'s Email',
                                'required' => true,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'how_long',
                                'label' => 'How long has been your business operating? ',
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'no_of_int_students',
                                'label' => 'Number of international students recruited for study in Australia each year',
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'list_of_institutions',
                                'label' => 'List of other institutions you are currently representing in Australia',
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'list_the_course',
                                'label' => 'List the courses you usually promote and enrol students into',
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'list_the_countries',
                                'label' => 'List of countries you operate from',
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'what_services',
                                'label' => 'What services do you provide to the international students?',
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'do_you_charge_students',
                                'label' => 'Do you charge students additional fees for the above services?	',
                                'col_size' => 12,
                            ],
                        ]
                    ],

                ], // end components

            ],
            [
                "component" => [ //start components
                    [
                        "title" => 'REFEREES: Please indicate two referees from Australian educational institutions that you represent.',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'reference_1',
                                'label' => '',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<h5><b>Reference 1</b><h5>',
                                    ]
                                ],
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'ref1_organization_name',
                                'label' => 'Organization Name',
                                // 'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'ref1_contact_person',
                                'label' => 'Contact Person',
                                // 'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'ref1_position',
                                'label' => 'Position',
                                // 'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'ref1_address',
                                'label' => 'Address',
                                // 'required' => true,
                            ],
                            [
                                'type' => 'number',
                                'name' => 'ref1_telephone',
                                'label' => 'Telephone',
                                // 'required' => true,
                            ],
                            [
                                'type' => 'email',
                                'name' => 'ref1_email',
                                'label' => 'Reference 1 Email',
                                'required' => true,
                            ],
                            [
                                'type' => 'card',
                                'name' => 'reference_2',
                                'label' => '',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<h5><b>Reference 2</b><h5>',
                                    ]
                                ],
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'ref2_organization_name',
                                'label' => 'Organization Name',
                                // 'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'ref2_contact_person',
                                'label' => 'Contact Person',
                                // 'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'ref2_position',
                                'label' => 'Position',
                                // 'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'ref2_address',
                                'label' => 'Address',
                                // 'required' => true,
                            ],
                            [
                                'type' => 'number',
                                'name' => 'ref2_telephone',
                                'label' => 'Telephone',
                                // 'required' => true,
                            ],
                            [
                                'type' => 'email',
                                'name' => 'ref2_email',
                                'label' => 'Reference 2 Email',
                                'required' => true,
                            ],
                        ]
                    ],

                ], // end components

            ],
            [
                "component" => [ //start components
                    [
                        "title" => 'Checklist and Declaration',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'info',
                                // 'label' => 'Information',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<p class="px-14-font text-justify line-height-1point2"><b>CHECKLIST:</b>  Your application will be assessed on the quality of the supporting documentation you provide, so please be as thorough as possible.</p>',
                                    ],
                                ],
                                'col_size' => 12
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'checklist1',
                                'value' => false,
                                // 'label' => 'I have assessed the student’s performance of the test and based on the results obtained, the student:',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => false,
                                        'description' => 'Have you completed all relevant sections of the application form?',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'checklist2',
                                'value' => false,
                                // 'label' => 'I have assessed the student’s performance of the test and based on the results obtained, the student:',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => false,
                                        'description' => 'Have you included in your application, a copy of your company profile?',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'checklist3',
                                'value' => false,
                                // 'label' => 'I have assessed the student’s performance of the test and based on the results obtained, the student:',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => false,
                                        'description' => 'Have you provided your ABN, and Business Registration Documentation?',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'checklist4',
                                'value' => false,
                                // 'label' => 'I have assessed the student’s performance of the test and based on the results obtained, the student:',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => false,
                                        'description' => 'Have you provided a copy of your professional or industry membership documentation?',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'checklist5',
                                'value' => false,
                                // 'label' => 'I have assessed the student’s performance of the test and based on the results obtained, the student:',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => false,
                                        'description' => 'And other supporting document',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'card',
                                'name' => 'info',
                                // 'label' => 'Information',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<p class="px-14-font text-justify line-height-1point2"><b>AGENT DECLARATION</b></p>',
                                    ],
                                ],
                                'col_size' => 12
                            ],
                            [
                                'type' => 'card',
                                'name' => 'info',
                                'label' => 'I agree to the personal information being:',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => 
                                        '<ul>
                                            <li>Recorded in PRISMS and sent to other regulatory bodies like ASQA. This may include my name, business email address, phone number and address;</li>
                                            <li>Accessed by the Australian Government Department of Education and Training, Department of Home Affairs and other Commonwealth agencies that access PRISMS;</li>
                                            <li>Used to administer or monitor compliance with the Commonwealth legislation e.g. Education Services for Overseas Students Act 2000, Migration Act 1958; and</li>
                                            <li>Disclosed by the Australian Government Department of Education and Training to other Australian Government entities (including, but not limited to ASQA), education institutions and publically. The Australian Government Department of Education and Training will share individual agents’ performance publically as aggregated data (but will not identify agent – provider relationships). Agent-provider relationships will only be identified when data is shared with education providers and other Australian Government entities.</li>
                                        </ul>
                                        <br>
                                        <p class="px-14-font text-justify line-height-1point2">I also agree to personal information that Australian Government Department of Education and Training currently hold in PRISMS regarding myself and any other personal information that the department may collect in future being disclosed as described above. </p>',
                                    ],
                                ],
                                'col_size' => 12
                            ],
                            [
                                'type' => 'text',
                                'name' => 'applicant_name',
                                'label' => 'Name of Representative/Education Agent:',
                                'required' => true,
                                // 'col_size' => 12,
                            ],
                            // [
                            //     'type' => 'text',
                            //     'name' => 'applicant_signature',
                            //     'label' => 'Applicant\'s Signature',
                            // ],
                            [
                                'type' => 'date',
                                'name' => 'applicant_date',
                                'label' => 'Date',
                            ],

                        ],
                    ],
                    [
                        'title' => 'Signature',
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
                                    ],
                                ],
                            ],
                        ],
                        
                    ]
                ],

            ], // end components

        ];

        return $pages;
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

        $org = TrainingOrganisation::first();
        $inputs = $request->inputs;
        $save = null;
        $validator = Validator::make($inputs['inputs'], [
            'agent_email' => 'required|email',
            'ref1_email' => 'required|email',
            'ref2_email' => 'required|email',
        ]);
        $validator->setAttributeNames([
            'agent_email'    => 'Agent Email',
            'ref1_email'     => 'Reference 1 Email',
            'ref2_email'     => 'Reference 2 Email',
        ]);
        if ($validator->fails()) {
            // return response()->json(['status' => 'errors', 'errors' => $validator->messages()]);
            return ['status' => 'errors','errors' => $validator->messages()];
        }

        if ($request->process_id == null) {
            $save = new AgentApplication;
            $save->process_id = $this->codeNumber();
            $save->agent_name = isset($inputs['inputs']['name_of_contact_person']) ? $inputs['inputs']['name_of_contact_person'] : null;
            $save->application_form = $request->inputs;
            $save->type_signature = $inputs['type_signature'] != '' || $inputs['type_signature'] != null ? $inputs['type_signature'] : null;
            $save->sig_acceptance_agreement = $inputs['sig_acceptance_agreement'] == true ? '1' : '0';
            $save->save();

            $path ='/public/agent/' . $save->process_id . '/agent-application-form.txt';
            Storage::put($path, $request->pages);

            return ['status' => 'success', 'process' => $save->process_id];
        } else {

            $save = AgentApplication::where('process_id', $request->process_id)->first();
            $save->agent_name = $inputs['inputs']['name_of_contact_person'];
            $save->application_form = $request->inputs;
            $save->type_signature = $inputs['type_signature'] != '' || $inputs['type_signature'] != null ? $inputs['type_signature'] : null;
            $save->sig_acceptance_agreement = $inputs['sig_acceptance_agreement'] == true ? '1' : '0';
            $save->update();

            $path = '/public/agent/' . $save->process_id . '/agent-application-form.txt';
            Storage::put($path, $request->pages);


            return ['status' => 'success', 'process' => $save->process_id, 'site' => $org->site_url];
        }
    }

    public function finish(Request $request, $process_id)
    {
        $aa = AgentApplication::where('process_id', $process_id)->first();
        $org = TrainingOrganisation::first();
        if($aa){
            if($aa->status == 'process'){
                $aa->status = 'complete';
            }
            $aa->type_signature = $request->type_signature != '' ? $request->type_signature : null;
            $aa->agent_signature = $request->signature != '' ? $request->signature : null;
            $aa->sig_acceptance_agreement = $request->sig_acceptance_agreement == true ? '1' : '0';
            $aa->mandatory_docs = isset($request->mandatory_docs) && $request->mandatory_docs != null ? json_encode($request->mandatory_docs) : null;
            $aa->update();

            $attach_aa_form = $this->agent_attachment($process_id);
            // send email if not loggedin in vorx
            if(\Auth::user() == null){
                if($attach_aa_form['status'] == 'success'){
                    $send = $this->sendToRef($aa);
                    if($send['status'] == 'success'){
                        $sendToAgent = $this->sendToAgent($aa);
                        if($sendToAgent['status'] == 'success'){
                            return ['status' => 'success', 'process' => $aa->process_id, 'site' => $org->site_url];
                        }else{
                            return ['status' => 'error', 'message' => 'Something went wrong.'];
                        }
                    }else{
                        return ['status' => 'error', 'message' => 'Something went wrong.'];
                    }
                }
            }
            return ['status' => 'success', 'site' => $org->site_url];
        }else{
            return ['status' => 'error', 'msg' => 'No agent application form found'];
        }  
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
        return AgentApplication::where('process_id', $number)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($process_id)
    {
        $aa = AgentApplication::where('process_id', $process_id)->first();
        $mandatoryList = AgentApplicationMandatoryDocument::all();
        $app_setting = TrainingOrganisation::first();
        if ($aa) {
            \JavaScript::put([
                'signature'         => $aa->agent_signature,
                'type_signature'    => $aa->type_signature,
                'agent_name'        => $aa->agent_name,
                'process_id'        => $process_id,
                'sig_acceptance_agreement' => $aa->sig_acceptance_agreement,
                'logo_url'          => $this->get_logo(),
                'app_settings'      => $app_setting,
                'mandatoryList'     =>  $mandatoryList->count() > 0 ? $mandatoryList : [],
                'mandatory_docs'    =>  json_decode($aa->mandatory_docs, true),
                'user'              => \Auth::user() != null ? true : false,
            ]);
            return view('agent-application.attachment-signature');
        }
        return abort(404);
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
        $aa = AgentApplication::where('process_id', $process_id)->first();
        $application_form = $aa->application_form;
        $app_setting = TrainingOrganisation::first();
        \JavaScript::put([
            'pages'                     => $this->pages($process_id),
            'process_id'                => $process_id,
            'app_settings'              => $app_setting,
            'logo_url'                  => $this->get_logo(),
            'application_form'          => $application_form['inputs'],
            'type_signature'            => $application_form['type_signature'],
            'sig_acceptance_agreement'  => $application_form['sig_acceptance_agreement'],
            'edit'                      => true
        ]);

        return view('agent-application.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $process_id)
    {
        //
        // dd($request->all());
        $aa = AgentApplication::where('process_id', $process_id)->first();

        $aa->agent_signature = $request->signature;
        $aa->update();

        return ['status' => 'success'];
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

    
    public function generate_pdf($process_id)
    {
        $org = TrainingOrganisation::first();
        $aa = AgentApplication::where('process_id', $process_id)->first();
        if(!$aa){
            abort(404);
        }

        $application_form = $aa->application_form;
        $application = $application_form['inputs'];
        $type_signature = $application_form['type_signature'];
        $logo_url = $this->get_logo();

        if(config('app.name') == 'CEA'){
            $pdf_template = 'custom.cea.representative-education-agent-application-form';
        }elseif (config('app.name') == 'Phoenix') {
            $pdf_template = 'custom.pca.representative-education-agent-application-form';
        }else{
            // vorx theme
            $pdf_template = 'agent-application.representative-education-agent-application-form';
        }

        return \PDF::loadView($pdf_template, compact('application','type_signature','logo_url','org'))->setPaper(array(0, 0, 595, 842), 'portrait')->stream('agent_application_form');

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

    public function sendToRef($agent_form)
    {
        $inputs = $agent_form->application_form['inputs'];
        $org = TrainingOrganisation::first();
        
        // $admin_emails = EmailAutomation::where('addOn', 'agent_form')->pluck('email');
        $ref_check_form_url = url('/reference-check/' . $agent_form->process_id . '');
        $contact_person = '';
        $emailsTo = [];
            if(isset($inputs['ref1_email']) && !in_array($inputs['ref1_email'], ['', null])){
                $emailsTo[] = $inputs['ref1_email'];
            }
            if(isset($inputs['ref2_email']) && !in_array($inputs['ref2_email'], ['', null])){
                $emailsTo[] = $inputs['ref2_email'];
            }

            // ref1_email
            // ref2_email
            $send = new EmailSendingController;
            $content = 'Dear Agent, <br><br>Mr./Ms. <b>'.$agent_form['agent_name'].'</b> has included you as one of his/her referees. Please click <a href="'.$ref_check_form_url.'">here</a> and fill in the Education Agent Reference Check Form. <br><br>Your coordination is highly appreciated. Thank you very much. <br><br>Regards,<br><br><b>Admin Team</b><br>'.$org->training_organisation_name.'<br>RTO NO '.$org->training_organisation_id.' | CRICOS CODE '.$org->cricos_code.'';
            
            $s = $send->send_automate('Representative/Education Agent Application Form', $content, [$org->training_organisation_name => $org->email_address], $emailsTo, [], []);

            if($s['status'] == 'success'){
                return ['status' => 'success'];
            }else{
                return ['status' => 'error', 'message' => 'Something went wrong.'];
            }
    }

    public function sendToAgent($agent_form)
    {
        $inputs = $agent_form->application_form['inputs'];
        $org = TrainingOrganisation::first();
        
        $admin_emails = EmailAutomation::where('addOn', 'agent_form')->pluck('email');
        // dd($admin_emails);
        $ref_check_form_url = url('/reference-check/' . $agent_form->process_id . '');
        $contact_person = '';
        $emailsTo = [];
            if(isset($inputs['agent_email']) && !in_array($inputs['agent_email'], ['', null])){
                $emailsTo[] = $inputs['agent_email'];
            }

            $send = new EmailSendingController;
            $content = 'Dear <b>'.$agent_form['agent_name'].'</b>, <br><br>Thank you for expressing your interest to become one of our representatives to recruit international students.<br><br>'.$org->training_organisation_name.' will be conducting reference check. The referees provided by you in the agent representative application form will be receiving an email as part of our reference check process. Please follow up with your referees to complete the reference check form. <br><br>Once we receive the reference check from both of your referees, we will be sending you the agent/representative agreement.<br><br>Regards,<br><br><b>Admin Team</b><br>'.$org->training_organisation_name.'<br>RTO NO '.$org->training_organisation_id.' | CRICOS CODE '.$org->cricos_code.'';
           
            $s = $send->send_automate('Representative/Education Agent Application Form', $content, [$org->training_organisation_name => $org->email_address], $emailsTo, [], $admin_emails);

            if($s['status'] == 'success'){
                return ['status' => 'success'];
            }else{
                return ['status' => 'error', 'message' => 'Something went wrong.'];
            }
    }

    public function agent_attachment($process_id){

        $file_path = '';
        $pdf_file = null;

        $aa = AgentApplication::where('process_id', $process_id)->first();
        $application_form = $aa->application_form;
        $application = $application_form['inputs'];
        $type_signature = $application_form['type_signature'];
        $logo_url = $this->get_logo();
        $org = TrainingOrganisation::first();

        if(!$aa){
            abort(404);
        }
        try {
            DB::beginTransaction();
            
            if(config('app.name') == 'CEA'){
                $pdf_template = 'custom.cea.representative-education-agent-application-form';
            }elseif (config('app.name') == 'Phoenix') {
                $pdf_template = 'custom.pca.representative-education-agent-application-form';
            }else{
                // vorx theme
                $pdf_template = 'agent-application.representative-education-agent-application-form';
            }

            $file_path = storage_path() . '/app/public/agent/' . $process_id;

            if (!File::isDirectory($file_path)) {
                File::makeDirectory($file_path, 0777, true, true);
            }

            $hashFileName = 'agent-application-form';
            $pdf_file = \PDF::loadView($pdf_template, compact('application','type_signature','logo_url','org'))->setPaper(array(0, 0, 595, 842), 'portrait')->save($file_path.'/'. $hashFileName . '.pdf');

            $pdf = Storage::size('/public/agent/' . $process_id . '/' . $hashFileName . '.pdf');
            $file = AgentApplicationAttachment::where('process_id', $process_id)->where('_input', 'agent-application-form')->first();
            
            if($file == null){
                $agentAttachment = new AgentApplicationAttachment([
                    'name'          => 'agent-application-form.pdf',
                    'hash_name'     => $hashFileName,
                    'size'          => $pdf,
                    'mime_type'     => 'application/pdf',
                    'ext'           => 'pdf',
                    '_input'        => 'agent-application-form',
                    'process_id'    => $process_id, 
                ]);
    
                // associated user
                $agentAttachment->user()->associate(\Auth::user());
                $agentAttachment->agent_application()->associate($aa->id);
                $agentAttachment->save();
                $agentAttachment->path_id = $process_id;
                $agentAttachment->update();
            }else{
                if($file->linked == 1){
                    //save it to agent attachments if done linked/sync/verified, pdf update only 
                    $file_path_ = storage_path() . '/app/public/agent/new/attachments/' . $aa->agent_id;
                    if (!File::isDirectory($file_path_)) {
                        File::makeDirectory($file_path_, 0777, true, true);
                    }
                    $pdf_file = \PDF::loadView($pdf_template, compact('application','type_signature','logo_url','org'))->setPaper(array(0, 0, 595, 842), 'portrait')->save($file_path_.'/'. $hashFileName . '.pdf');
                }   
            }
            
            DB::commit();

            return ['status' => 'success'];
            // return response(['status' => 'success', 'attID' => $attID, 'preview' => $preview], 200)->header('Content-Type', 'text/json');
            // return response(['status' => 'success', 'file' => $pdf_file], 200)->header('Content-Type', 'text/json');
            // return response(['status' => 'success', 'attID' => 0], 200)->header('Content-Type', 'text/json');
        } catch (\Exception $e) {
            DB::rollBack();

            // remove file
            Storage::delete($file_path);
            dd($e->getMessage());
        }
    }
    
}