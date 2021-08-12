<?php

namespace App\Http\Controllers\AgentApplication;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Send\EmailSendingController;
use App\Models\EmailAutomation;
use App\Models\AgentApplication;
use App\Models\TrainingOrganisation;

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

class AgentReferenceCheckController extends Controller
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


    public function index($process_id)
    {
        //
        $app_setting = TrainingOrganisation::first();
        $aa = AgentApplication::where('process_id', $process_id)->first();
        $agent_details = $aa->application_form['inputs'];
        if($aa->ref_form_1 !== null && $aa->ref_form_2 !== null){
            abort(404);
        }

        \JavaScript::put([
            'app_settings'  => $app_setting,
            'pages'         => $this->pages($process_id),
            'logo_url'      => $this->get_logo(),
            'process_id'    => $process_id,
            // 'agent_reference' => $agent_reference,
            'agent_details' => $agent_details
        ]);

        return view('agent-application.reference-check');
    }

    public function pages($process_id = null, $agent_reference = null)
    {
        $agent_details = null;
        if ($process_id != null && $agent_reference != null) {
            $aa = AgentApplication::where('process_id', $process_id)->first();
            $application_form = Storage::get('/public/agent/' . $aa->process_id . '/agent-reference-check-'. $agent_reference .'.txt');
            return json_decode($application_form, true);
        }
        if ($process_id) {
            $agent_details = AgentApplication::where('process_id', $process_id)->first();
            $agent_details = $agent_details->application_form['inputs'];
            
            if(isset($agent_details['phone_no']) && $agent_details['phone_no'] !== null){
                $contact_no = $agent_details['phone_no'];
            }elseif(isset($agent_details['mobile_no']) && $agent_details['mobile_no'] !== null){
                $contact_no = $agent_details['mobile_no'];
            }else{
                $contact_no = '';
            }
        }
        // dd($agent_details);
        $pages = [
            [
                "component" => [ //start components
                    [
                        "title" => 'Agent’s Details:',
                        'inputs' => [
                            [
                                'type' => 'text',
                                'name' => 'agent_name',
                                'label' => 'Agent Name',
                                'required' => true,
                                'readOnly' => true,
                                'value' => $agent_details['name_of_contact_person'],
                            ],
                            [
                                'type' => 'text',
                                'name' => 'agent_address',
                                'label' => 'Agent Address',
                                // 'required' => true,
                                'readOnly' => true,
                                'value' => $agent_details['address']
                            ],
                            [
                                'type' => 'number',
                                'name' => 'contact_no',
                                'label' => 'Contact Number',
                                // 'required' => true,
                                'readOnly' => true,
                                'value' => $contact_no
                            ],
                            [
                                'type' => 'email',
                                'name' => 'agent_email',
                                'label' => 'Agent Email',
                                'required' => true,
                                'readOnly' => true,
                                'value' => $agent_details['agent_email']
                            ],
                        ]
                    ],
                    [
                        "title" => 'Referee Details (referee to complete):',
                        'inputs' => [
                            [
                                'type' => 'text',
                                'name' => 'ref_organization_name',
                                'label' => 'Organization Name',
                                // 'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'ref_contact_person',
                                'label' => 'Contact Person',
                                'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'ref_address',
                                'label' => 'Address',
                                // 'required' => true,
                            ],
                            [
                                'type' => 'number',
                                'name' => 'ref_phone_no',
                                'label' => 'Phone Number',
                                // 'required' => true,
                            ],
                            [
                                'type' => 'email',
                                'name' => 'ref_email',
                                'label' => 'Referee Email',
                                'required' => true,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'how_long',
                                'label' => 'How long has the agent been associated with your organisation for?',
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'how_many_student_enrolled',
                                'label' => 'How many students has the agent enrolled with your organisation (approx.)?',
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'how_many_student_cancelled',
                                'label' => 'How many students from these were cancelled with your organisation (approx.)?',
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'any_complaints',
                                'label' => 'Are there any complaints from students or other agents about this agent?',
                                'col_size' => 12,
                                'readOnly' => false,
                                'content' => [
                                    [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                        'readOnly' => false,
                                    ],
                                    // [
                                    //     'value' => 'Sometimes',
                                    //     'description' => 'Sometimes',
                                    //     'readOnly' => false,
                                    // ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No',
                                        'readOnly' => false,
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'accurate_and_ethical',
                                'label' => 'Accurate and ethical marketing information provided by the agent about courses offered, fees, refund policy etc.',
                                'col_size' => 12,
                                'readOnly' => false,
                                'content' => [
                                    [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                        'readOnly' => false,
                                    ],
                                    // [
                                    //     'value' => 'Sometimes',
                                    //     'description' => 'Sometimes',
                                    //     'readOnly' => false,
                                    // ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No',
                                        'readOnly' => false,
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'would_you_recommend',
                                'label' => 'Would you recommend us to collaborate with this agent?',
                                'col_size' => 12,
                                'readOnly' => false,
                                'content' => [
                                    [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                        'readOnly' => false,
                                    ],
                                    // [
                                    //     'value' => 'Sometimes',
                                    //     'description' => 'Sometimes',
                                    //     'readOnly' => false,
                                    // ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No',
                                        'readOnly' => false,
                                    ],
                                ]
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'comments',
                                'label' => 'Any additional Comments?',
                                'col_size' => 12,
                            ],
                        ],
                    ],

                ], // end components

            ],
            [
                "component" => [ //start components
                    [
                        "title" => 'DECLARATION',
                        'inputs' => [
                            [
                                'type' => 'text',
                                'name' => 'applicant_name',
                                'label' => 'Referee Name',
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

                ], // end components

            ],
            
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
        // dd($request);
        $org = TrainingOrganisation::first();
        $inputs = $request->inputs;
        // dd($inputs);
        $save = null;
        $validator = Validator::make($inputs['inputs'], [
            'agent_email' => 'required|email',
            'ref_email' => 'required|email',
        ]);
        $validator->setAttributeNames([
            'agent_email'    => 'Agent Email',
            'ref_email'     => 'Referee Email',
        ]);
        if ($validator->fails()) {
            // return response()->json(['status' => 'errors', 'errors' => $validator->messages()]);
            return ['status' => 'errors','errors' => $validator->messages()];
        }
        
        if ($request->process_id != null) {
            $save = AgentApplication::where('process_id', $request->process_id)->first();
            // dump($inputs['inputs']['ref_email']); // email submitted by reference (from ref check form)
            // dd($save->application_form['inputs']['ref1_email']); // email submitted by agent 
            // $save->ref_form_2 == null && $save->ref_form_1 == null 
            if($save->application_form['inputs']['ref1_email'] == $inputs['inputs']['ref_email']){
                $inputs['agent_reference'] = 1;
                $save->ref_form_1 = $inputs;
            }elseif($save->application_form['inputs']['ref2_email'] == $inputs['inputs']['ref_email']){
                $inputs['agent_reference'] = 2;
                $save->ref_form_2 = $inputs;
            }else{
                return ['status' => 'error', 'message' => 'Your email was invalid.'];
            }
            $save->update();

            $path ='/public/agent/' . $save->process_id . '/agent-reference-check-'. $inputs['agent_reference'] .'.txt';
            Storage::put($path, $request->pages);

            $emailsTo = [];
            if(isset($inputs['inputs']['ref_email']) && !in_array($inputs['inputs']['ref_email'], ['', null])){
                $emailsTo[] = $inputs['inputs']['ref_email'];
            }
            $admin_emails = EmailAutomation::where('addOn', 'agent_form')->pluck('email');
            $send = new EmailSendingController;
            $content = 'Dear '.$inputs['inputs']['ref_contact_person'].', <br><br>Thank you for providing the reference agent for '.$save->agent_name.'. <br><br>Thank you very much.<br><br>Regards,<br><br><b>Admin Team</b><br>'.$org->training_organisation_name.'<br>RTO NO '.$org->training_organisation_id.' | CRICOS CODE '.$org->cricos_code.'';
            
            if(\Auth::user() == null){
                $s = $send->send_automate('Education Agent Reference Check Form', $content, [$org->training_organisation_name => $org->email_address], $emailsTo, [], $admin_emails);
                if($s['status'] == 'success'){
                    return ['status' => 'success', 'process' => $save->process_id, 'site' => $org->site_url];
                }else{
                    return ['status' => 'error', 'message' => 'Something went wrong.'];
                }
            }
            return ['status' => 'success', 'process' => $save->process_id, 'site' => $org->site_url];
        } else {
            // no process id
            return ['status' => 'error'];
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
        // dd(\Auth::user());
        $ep = AgentApplication::where('process_id', $process_id)->first();
        $ef = $ep->enrolment_form;
        $mandatoryList = EnrolmentMandatoryDocument::all();
        $app_setting = TrainingOrganisation::first();
        if ($ep) {
            \JavaScript::put([
                'tests' => [
                    'lln' => $ep->lln ? 1 : 0,
                    'ptr' => $ep->ptr ? 1 : 0,
                ],
                'signature'         => $ep->student_signature,
                'type_signature'    => $ep->type_signature,
                'student_name'      => $ep->student_name,
                'process_id'        => $process_id,
                'sig_acceptance_agreement' => $ep->sig_acceptance_agreement,
                'concession_docs'   => isset($ef['valid_concession_card_yes']) ? $ef['valid_concession_card_yes'] : [],
                'logo_url'          => $this->get_logo(),
                'app_settings'      => $app_setting,
                'mandatoryList'     =>  $mandatoryList->count() > 0 ? $mandatoryList : [],
                'mandatory_docs' =>  json_decode($ep->mandatory_docs, true),
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
    public function edit($process_id, $agent_reference)
    {
        //
        // dd($agent_reference);
        $aa = AgentApplication::where('process_id', $process_id)->first();
        $application_form = [];
        if($agent_reference == 1){
            $application_form = $aa->ref_form_1; //json_decode($aa->ref_form_1, true);
        }elseif($agent_reference == 2){
            $application_form = $aa->ref_form_2; //json_decode($aa->ref_form_2, true);
        }

        $app_setting = TrainingOrganisation::first();
        \JavaScript::put([
            'pages'                     => $this->pages($process_id,$agent_reference),
            'process_id'                => $process_id,
            'app_settings'              => $app_setting,
            'logo_url'                  => $this->get_logo(),
            'application_form'          => $application_form['inputs'],
            'type_signature'            => $application_form['type_signature'],
            'sig_acceptance_agreement'  => $application_form['sig_acceptance_agreement'],
            'agent_reference'           => $agent_reference
        ]);

        return view('agent-application.reference-check');
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
        $ep = AgentApplication::where('process_id', $process_id)->first();

        $ep->student_signature = $request->signature;
        $ep->update();

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

    
    public function generate_pdf($process_id, $agent_reference)
    {
        $org = TrainingOrganisation::first();
        $aa = AgentApplication::where('process_id', $process_id)->first();
        if(!$aa){
            abort(404);
        }
        if($agent_reference == 1){
            $application_form = $aa->ref_form_1; //json_decode($aa->ref_form_1, true);
        }elseif($agent_reference == 2){
            $application_form = $aa->ref_form_2; //json_decode($aa->ref_form_2, true);
        }
        // $application_form = $aa->application_form;
        $application = $application_form['inputs'];
        $type_signature = $application_form['type_signature'];
        $logo_url = $this->get_logo();

        if(config('app.name') == 'CEA'){
            $pdf_template = 'custom.cea.educational-agent-reference-check-form';
        }elseif (config('app.name') == 'Phoenix') {
            $pdf_template = 'custom.pca.educational-agent-reference-check-form';
        }else{
            // vorx theme
            $pdf_template = 'agent-application.educational-agent-reference-check-form';
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


}
