<?php

namespace App\Http\Controllers\AgentApplication;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Send\EmailSendingController;
use App\Models\EmailAutomation;
use App\Models\TrainingOrganisation;
use App\Models\AgentApplication;
use App\Models\AgentApplicationAttachment;
use App\Models\AgentDetail;
use App\Models\AgentAttachment;
use App\Models\Student\Party;
use App\Models\User;

use File;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class RepresentativeAgentController extends Controller
{
    public function __construct()
    {
        // $this->middleware('checkModule:representative-agent');
        // return $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // \JavaScript::put([
        //     'list' => AgentApplication::where('status', 'completed')->get(),
        // ]);
        // dd(TrainingDeliveryLoc::with('state')->get());
        return view('agent-application.list');
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    public function list(Request $request){
        
        if ($request->sort) {
            $sortBy = $request->sort;
            $dir = $request->direction;
        }else{
            $sortBy = 'id';
            $dir = 'desc';
        }

        if (isset($request->search)) {
            $search = $request->search;
            $aa = AgentApplication::with('application_attachments')->where('process_id', 'like', '%' . $search . '%')->orWhere('agent_name', 'like', '%' . $search . '%')->orderBy($sortBy, $dir)->paginate($request->limit);
            return $aa;
        } else {
            $aa = AgentApplication::with('application_attachments')->orderBy($sortBy, $dir)->paginate($request->limit);
            return $aa;
        }
    }

    public function verify_agent(Request $request){

        $request = $request->inputs;
        $validator = \Validator::make($request, [
            'company_name'  => 'required',
            'agent_name'    => 'required',
            'email'         => 'required|email',
            'phone'         => 'required',
        ]);

        // validator nice names
        $validator->setAttributeNames([
            'company_name'    => 'Company Name',
            'agent_name'      => 'Agent Name',
            'email'           => 'Email',
            'phone'           => 'Phone',
        ]);

        if ($validator->fails()) {
            // return response()->json(['status' => 'errors', 'errors' => $validator->messages()]);
            return ['status' => 'errors','errors' => $validator->messages()];
        }

        try {
            //code...
            \DB::beginTransaction();
            
            $user = new User;
            $party = new Party;
            $agent_detail = new AgentDetail;

            $party->name = $request['company_name'];
            $party->party_type_id = 2;
            $party->save();
            
            $user->username = $request['email'];
            $user->password = Hash::make('agent123!@#');
            $user->is_active = 0;
            $user->profile_image = 'default.png';
            // $user->user()->associate(\Auth::user());
            $user->party()->associate($party);
            $user->save();
            $user->assignRole('Agent');


            $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $agent_code = $this->generate_string($permitted_chars, 10);
            $agent_detail->fill([
                'agent_code'        => $agent_code,
                'agent_name'        => $request['agent_name'],
                'email'             => $request['email'],
                'email_2'           => $request['email_2'],
                'office_address'    => $request['office_address'],
                'company_name'      => $request['company_name'],
                'notes'             => $request['notes'],
                'position'          => $request['position'],
                'phone'             => $request['phone'],
                'mobile'            => $request['mobile'],
                'fax_number'        => $request['fax_number'],
                'website'           => $request['website'],
                'agent_type'        => $request['agent_type'],
                'bank_name'         => $request['bank_name'],
                'account_name'      => $request['account_name'],
                'bsb'               => $request['bsb'],
                'account_number'    => $request['account_number'],
            ]);
            $agent_detail->user()->associate($user);
            $agent_detail->user_reference()->associate(\Auth::user());
            $agent_detail->save();

            $agent_app = AgentApplication::where('id',$request['agent_app_id'])->first();
            if($agent_app->status == 'complete'){
                $agent_app->status = 'verified';
            }
            $agent_app->agent_detail()->associate($agent_detail);
            $agent_app->update();   

            \DB::commit();


            $emailsTo = [];
            if (isset($request['email']) && !in_array($request['email'], ['', null])) {
                $emailsTo[] = $request['email'];
            }
            if (isset($request['email_2']) && !in_array($request['email_2'], ['', null])) {
                $emailsTo[] = $request['email_2'];
            }
            $admin_emails = EmailAutomation::where('addOn', 'agent_form')->pluck('email');

            $paths = [];
            // Attachments along with the agent agreement
            $nc = storage_path('app/public/agent/national-codes');
            if(file_exists($nc)){
                // raw file contents
                $paths[] = [
                    'path' => $nc.'/Standard 1 of National code 2018.pdf', 
                    'name' => 'Standard 1 of National code 2018.pdf'
                ];
                $paths[] = [
                    'path' => $nc.'/Standard 2 of National code 2018.pdf', 
                    'name' => 'Standard 2 of National code 2018.pdf'
                ];
                $paths[] = [
                    'path' => $nc.'/Standard 3 of National code 2018.pdf', 
                    'name' => 'Standard 3 of National code 2018.pdf'
                ];
                $paths[] = [
                    'path' => $nc.'/Standard 4 of National code 2018.pdf', 
                    'name' => 'Standard 4 of National code 2018.pdf'
                ];
           }

            $agent_agreement = $this->generate_agreement($agent_detail->id);
            if(isset($agent_agreement['path'])){
                $paths[] = $agent_agreement;
            }

            $reviewLink = url('agent-agreement/review/' . $agent_app->process_id);
            $org = TrainingOrganisation::first();
            $send = new EmailSendingController;
            $content = 'Dear <b>'.$request['agent_name'].'</b>, <br><br>Greetings of the day. <br><br>We are pleased to inform you that we have received all the documents and reference checks in support of your application to become our representative to recruit students. Your agent/representative application has been approved. I am sending you a <a href="' . $reviewLink . '">link</a> of agent agreement in this email, please sign and send back to us and save a copy for your records. <br><br>Also, I have attached the fact sheets relevant to you as our representative, please go through them. We have to remain compliant to National code 2018 and Standards for Registered Training Organisations 2015 (SRTOs 2015).<br><br>Link for SRTOs 2015: <a href="https://www.asqa.gov.au/standards/marketing-recruitment">https://www.asqa.gov.au/standards/marketing-recruitment</a><br>Link for National code 2018: <a href="https://internationaleducation.gov.au/regulatory-information/Pages/National-Code-2018-Factsheets-.aspx">https://internationaleducation.gov.au/regulatory-information/Pages/National-Code-2018-Factsheets-.aspx</a><br><br>Please feel free to contact us if you have any questions in this regard.<br><br>Regards,<br><br><b>Admin Team</b><br>'.$org->training_organisation_name.'<br>RTO NO '.$org->training_organisation_id.' | CRICOS CODE '.$org->cricos_code.'';
                
            $s = $send->send_automate('Representative/Education Agent Application Form', $content, [$org->training_organisation_name => $org->email_address], $emailsTo, $paths, $admin_emails);

            if ($s['status'] == 'success') {
                $attachment = $this->link_attachment($request['process_id']);
                if ($attachment['status'] == 'success' || $attachment['status'] == 'attached') {
                    return response()->json(['status' => 'success', 'message' => 'Verified Successfully']);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong.']);
            }
        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
            return response()->json(['status' => 'errors', 'message' => 'Oopss.. Something went wrong.']);
        }
    }

    public function generate_string($input = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', $strength = 16)
    {
        $input_length = strlen($input);
        $random_string = '';

        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        $validate = AgentDetail::where('agent_code', $random_string)->first();

        if ($validate) {
            $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $this->generate_string($permitted_chars, 10);
        } else {
            return $random_string;
        }
    }

    public function link_attachment($process_id){

        $aa = AgentApplication::where('process_id', $process_id)->first();
        $agent_detail = AgentDetail::where('id', $aa->agent_id)->first();
        $linked_att = $aa->application_attachments()->where('linked', '1')->get();
        $attachments = $aa->application_attachments()->where('linked', '0')->get();

        if (!$attachments->isEmpty()) {
            foreach ($attachments as $attachment) {
                $agentAttachment = new AgentAttachment([
                    'name'      => $attachment->name,
                    'hash_name' => $attachment->hash_name,
                    'size'      => $attachment->size,
                    'mime_type' => $attachment->mime_type,
                    'ext'       => $attachment->ext,
                    '_input'       => $attachment->_input,
                ]);

                // associated user
                $agentAttachment->user()->associate(\Auth::user());
                $agentAttachment->agent()->associate($agent_detail->id);
                $agentAttachment->save();
                $agentAttachment->path_id = $agent_detail->id;
                $agentAttachment->update();
                $attachment->linked = 1;
                $attachment->update();
                \Storage::disk('public')->move('/agent/' . $process_id . '/' . $attachment->hash_name . '.' . $attachment->ext, '/agent/new/attachments/' . $agent_detail->id . '/' . $agentAttachment->hash_name . '.' . $agentAttachment->ext);
            }
            // return 'attachment_link';
            return ['status' => 'success', 'message' => 'Attachment linked successfully.'];

        } else if(!$linked_att->isEmpty()){
            return ['status' => 'attached', 'message' => 'Attachment is already linked.'];
        } else {
            // return 'no_attachment';
            return ['status' => 'error', 'message' => 'No Files Found.'];
        }
    }

    public function generate_agreement($id){

        $detail = AgentDetail::with('agent_application','commission_settings')->where('id', $id)->first();
        $app_form = $detail->agent_application->application_form;
        $app_form = $app_form['inputs'];
        if($detail->agent_application->agent_agreement_sig_agreement == 1){
            $signed = true;
        }else{
            $signed = false;
        }
        $org = TrainingOrganisation::first();
        $dated    = Carbon::now()->setTimezone('Australia/Melbourne')->format('Y-m-d');

        $path = storage_path('app/public/agent/new/attachments/'.$detail->id);

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if(config('app.name') == 'CEA'){
            $pdf_template = 'custom.cea.education-agent-agreement-pdf';
        }elseif (config('app.name') == 'Phoenix') {
            $pdf_template = 'custom.pca.education-agent-agreement-pdf';
        }else{
            // vorx theme and content
            // $pdf_template = 'agent-application.education-agent-agreement-pdf';
            abort(403, 'No File Found.'); 
        }

        \PDF::loadView($pdf_template, compact('detail','org','dated','app_form','signed'))->setPaper(array(0, 0, 612, 870), 'portrait')->save($path.'/education-agent-agreement.pdf')->stream($detail->agent_name .' - Education Agent Agreement.pdf');

                // save to agent attachments
                $agentAttachment = AgentAttachment::where('agent_id', $detail->id)->where('_input', 'agent-agreement')->first();
                if(!$agentAttachment) {
                    $agentAttachment = new AgentAttachment([
                        'name'      => 'education-agent-agreement.pdf',
                        'hash_name' => 'education-agent-agreement',
                        'size'      => null,
                        'mime_type' => 'application/pdf',
                        'ext'       => 'pdf',
                        '_input'       => 'agent-agreement',
                    ]);
                    // associated user
                    $agentAttachment->user()->associate(\Auth::user());
                    $agentAttachment->agent()->associate($detail->id);
                    $agentAttachment->save();
                    $agentAttachment->path_id = $detail->id;
                    $agentAttachment->update();
                }
        // return \PDF::loadView($pdf_template, compact('detail','org','dated','app_form'))->setPaper(array(0, 0, 612, 870), 'portrait')->stream('agent-agreement');
        return ['status' => 'success','path' => $path . '/education-agent-agreement.pdf', 'name' => $detail->agent_name.' - Education Agent Agreement.pdf'];
    }

    public function review_agent_agreement($process_id)
    {
        $app_setting = TrainingOrganisation::first();
        $aa = AgentApplication::where('process_id', $process_id)->first();
        \JavaScript::put([
            'agent_app' => $aa,
            'app_settings'  => $app_setting,
            'logo_url'      => $this->get_logo(),
        ]);
        return view('agent-application.agent-agreement-review');
    }

    public function agentAgreementView($process_id){

        $aa = AgentApplication::where('process_id', $process_id)->first();
        if($aa->agent_agreement_sig_agreement == 1){
            $signed = true;
        }else{
            $signed = false;
        }
        $app_form = $aa->application_form;
        $app_form = $app_form['inputs'];
        $detail = AgentDetail::with('agent_application','commission_settings')->where('id', $aa->agent_id)->first();
        // dd($app_form);
        $org = TrainingOrganisation::first();
        $dated    = Carbon::now()->setTimezone('Australia/Melbourne')->format('Y-m-d');

        $path = storage_path('app/public/agent/new/attachments/'.$detail->id);

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if(config('app.name') == 'CEA'){
            $pdf_template = 'custom.cea.education-agent-agreement-pdf';
        }elseif (config('app.name') == 'Phoenix') {
            $pdf_template = 'custom.pca.education-agent-agreement-pdf';
        }else{
            // vorx theme and content
            // $pdf_template = 'agent-application.education-agent-agreement-pdf';
            abort(403, 'No File Found.'); 
        }

        \PDF::loadView($pdf_template, compact('detail','org','dated','app_form','signed'))->setPaper(array(0, 0, 612, 870), 'portrait')->save($path.'/education-agent-agreement.pdf')->stream($detail->agent_name .'- Education Agent Agreement.pdf');

        return \PDF::loadView($pdf_template, compact('detail','org','dated','app_form','signed'))->setPaper(array(0, 0, 612, 870), 'portrait')->stream($detail->agent_name .'- Education Agent Agreement.pdf');
    }

    public function review_agree(Request $request)
    {

        $org = TrainingOrganisation::first();
        $aa = AgentApplication::where('process_id', $request->process_id)->first();
        $aa->agent_agreement_sig_agreement = 1;
        $aa->update();

        $agent_details = AgentDetail::where('id', $aa->agent_id)->first();
        $send = new EmailSendingController;
        $admin_emails = EmailAutomation::where('addOn', 'agent_form')->pluck('email');
        $emailsTo = []; 

        $content = '<b>Dear Admin Staff,</b><br><br>Please be informed that the agent with agent code <a href="' . url("agent/" . $agent_details->id) . '">' . $agent_details->agent_code . '</a> <b>'. $agent_details->agent_name .'</b> already signed the Education Agent Agreement.<br><br>Regards,<br><br><b>Admin Team</b><br>'.$org->training_organisation_name.'<br>RTO NO '.$org->training_organisation_id.' | CRICOS CODE '.$org->cricos_code.'';
        
        $agent_agreement = $this->generate_agreement($aa->agent_id);
        if($agent_agreement['status'] == 'success'){
            $s = $send->send_automate('Confirm Education Agent Agreement', $content, [$org->training_organisation_name => $org->email_address], $admin_emails, [], []);
            if ($s['status'] == 'success') {
                return response()->json(['status' => 'success', 'message' => 'Success', 'site' => $org->site_url]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong.']);
            }
            return response()->json(['status' => 'success', 'message' => 'Success', 'site' => $org->site_url]);
        }else{
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.']);
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
}
