<?php

namespace App\Http\Controllers\Automation;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Send\EmailSendingController;
use Illuminate\Http\Request;

use Validator;

use App\Models\EmailSending;
use App\Models\EmailTemplate;
use App\Models\EmailModule;
use App\Models\AgentApplication;
use App\Models\AgentEmailWarningTrail;
use App\Models\Student\Student;
use App\Models\Student\OfferLetter\OfferLetter;
use App\Models\OfferLetterCourseDetail;
use App\Models\PaymentScheduleTemplate;
use App\Models\OfferLetterFee;
use App\Models\CashPayment;
use App\Models\OnlinePayment;
use App\Models\PaymentScheduleDetail;

use App\Models\TrainingOrganisation;

use App\Models\Course;
use App\Models\FundedStudentDetails;
use App\Models\FundedStudentCourse;
use App\Models\FundedStudentCourseDetail;
use App\Models\FundedStudentPaymentDetails;

use Carbon\Carbon;
use DB;
use Storage;

use Mailer;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use App\Models\Automation;
use App\Models\AutomationAudit;

class AgentReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function fetch_email_reminder_templates()
    {
        $ew = EmailTemplate::with('email_module')->where('add_on', 'automation.agent-reminder')->get();
        $m = EmailModule::all()->pluck('module_name', 'id'); 

        return ['ew' => $ew, 'm' => $m, 'addOn' => 'automation.agent-reminder'];
    }


    public function save_email_reminder_template(Request $request)
    {
        // dd($request);

        if(isset($request['id'])){
            try {
                // start db transaction
                DB::beginTransaction();

                $email_template = EmailTemplate::where('id', $request['id'])->first();
                $email_template->update([
                    'name'                  => $request->name,
                    'email_subject'         => $request->email_subject,
                    'email_module_id'       => $request->email_module_id,
                    'email_content'         => $request->email_content,
                    'interval'              => isset($request->interval) && !in_array($request->interval, [null,'']) ? $request->interval : 0,
                    'succeeding_email_type' =>$request->succeeding_email_type,
                    'add_on'                =>'automation.agent-reminder',
                    'active'                => $request->active ? 1 : 0
                ]);

                $email_trail = AgentEmailWarningTrail::where('email_template_id', $request['id'])->get();
                foreach($email_trail as $et){
                    $et->update([
                        'email_template_type' => $request->name,
                    ]);
                }
                
                DB::commit();
    
                return json_encode(['data'=>$request->all(), 'status' => 'success']);
            } catch (\Exception $e) {
                // rollback db transactions
                DB::rollBack();
                
                // return to previous page with errors
                return  response()->json(['message' => $e->getMessage(), 'status' => 'errors']);
            }
        }else{
            
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email_subject' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'errors', 'errors' => $validator->messages()]);
            }
            try {
                // start db transaction
                DB::beginTransaction();

                $email_template = new EmailTemplate;
                $email_template->fill([
                    'name'                  => $request->name,
                    'email_subject'         => $request->email_subject,
                    'email_module_id'       => $request->email_module_id,
                    'email_content'         => $request->email_content,
                    'email_type'            => strtolower(str_replace(' ','-',$request->name)),
                    'interval'              => isset($request->interval) && !in_array($request->interval, [null,'']) ? $request->interval : 0,
                    'succeeding_email_type' =>$request->succeeding_email_type,
                    'add_on'                =>'automation.agent-reminder',
                    'active'                => $request->active ? 1 : 0
                ]);
                $email_template->save();

                DB::commit();


                return json_encode(['data' => $request->all(), 'status' => 'success']);
            } catch (\Exception $e) {
                // rollback db transactions
                DB::rollBack();

                // return to previous page with errors
                return  response()->json(['message' => $e->getMessage(), 'status' => 'errors']);
            }
        }

    }

    public function send_agent_reminder($sched = null){

        $now = Carbon::now()->setTimezone('Australia/Brisbane')->format('Y-m-d');
        $org = TrainingOrganisation::first();
        $send = new EmailSendingController;
        $agent_app = AgentApplication::where('status', 'complete')->get();
        $email_template = EmailTemplate::with('email_module')->where('add_on', 'automation.agent-reminder')->where('active',1)->orderBy('id','desc')->get();
        $ref_reminder = $email_template->where('email_type', 'referee-reminder')->first();

        dump($agent_app->count().' agent application with complete status');
        if($agent_app->count() > 0){
            
            foreach($agent_app as $key => $aa){

                $email_trail = AgentEmailWarningTrail::where('agent_application_id', $aa->id)->get();
                $app_form = $aa->application_form;
                // follow up referees only
                $remind_date = Carbon::parse($aa->created_at)->addDays(3)->format('Y-m-d'); // add 3days
                $referee_name = '';
                $referees = [];
                $referees_email = [];
                $agent_reminder = $email_template->where('email_type', 'agent-reminder')->first();
                $agent_content = $agent_reminder->email_content;
                $ref_check_form_url = url('/reference-check/' . $aa->process_id . '');

                // if email trail has 10 attempts set agent application status to inactive
                if(count($email_trail) >= 10){
                    $aa->status = 'inactive';
                    $aa->update(); 
                }else{
                    
                    $latest_sent = AgentEmailWarningTrail::where('agent_application_id', $aa->id)->latest('date_sent')->first();
                    if($latest_sent){
                        $remind_date = Carbon::parse($latest_sent->date_sent)->addDays(3)->format('Y-m-d');  // add 3days to latest email was sent
                    }
                    
                    // change email content for Agent to reference replacement reminder
                    if(count($email_trail) >= 2){
                        // recommend agent to find another referees
                        $agent_reminder = $email_template->where('email_type', 'reference-replacement-reminder')->first(); // change email content for reference replacement
                        $agent_content = $agent_reminder->email_content; 
                    }

                    //  date checker (add 3days)
                    if($now >= $remind_date){
                        // dump($aa->agent_name.' - sending reminder');
                        // send reminder to reference1 if null (haven't completed reference check form)
                        if($aa->ref_form_1 == null){
                            $emailsTo = [];
                            if(isset($app_form['inputs']['ref1_email']) && !in_array($app_form['inputs']['ref1_email'], ['', null])){
                                $emailsTo[] = $app_form['inputs']['ref1_email'];
                            }
                            $referee_name = $app_form['inputs']['ref1_contact_person']; 
                            $content = $ref_reminder->email_content;
                            $content = str_replace('%agentname%', $aa->agent_name, $content);
                            $content = str_replace('%refereename%', $referee_name, $content);
                            $content = str_replace('%ref_check_form_url%', $ref_check_form_url, $content);
                            $s = $send->send_automate($ref_reminder->email_subject, $content, [$org->training_organisation_name => $org->email_address], $emailsTo, [], []);
                            if(isset($s['status']) && $s['status'] == 'success') {
                                $referees[] = $referee_name; 
                                $referees_email[] = $app_form['inputs']['ref1_email'];
                            }else{
                                return ['status' => 'error', 'message' => 'Something went wrong.'];
                            }
                        }
    
                        // send reminder to reference2 if null (haven't completed reference check form)
                        if($aa->ref_form_2 == null){
                            $emailsTo = [];
                            if(isset($app_form['inputs']['ref2_email']) && !in_array($app_form['inputs']['ref2_email'], ['', null])){
                                $emailsTo[] = $app_form['inputs']['ref2_email'];
                            }
                            $referee_name = $app_form['inputs']['ref2_contact_person'];
                            $content = $ref_reminder->email_content;
                            $content = str_replace('%agentname%', $aa->agent_name, $content);
                            $content = str_replace('%refereename%', $referee_name, $content);
                            $content = str_replace('%ref_check_form_url%', $ref_check_form_url, $content);
                            $s = $send->send_automate($ref_reminder->email_subject, $content, [$org->training_organisation_name => $org->email_address], $emailsTo, [], []);
                            if(isset($s['status']) && $s['status'] == 'success') {
                                $referees[] = $referee_name; 
                                $referees_email[] = $app_form['inputs']['ref2_email'];
                            }else{
                                return ['status' => 'error', 'message' => 'Something went wrong.'];
                            }
                        }

                        // send reminder to agent if there is referee reminder was sent
                        if(count($referees_email) > 0){
    
                            if(count($referees) > 1){
                                $ref = implode(" and ", $referees);
                            }else{ 
                                $ref = $referees[0];
                            } 
    
                            $content = $agent_content;
                            $content = str_replace('%agentname%', $aa->agent_name, $content);
                            $content = str_replace('%refereename%', $ref, $content);
    
                            $s = $send->send_automate($agent_reminder->email_subject, $content, [$org->training_organisation_name => $org->email_address], [$app_form['inputs']['agent_email']], [], []);
                            if(isset($s['status']) && $s['status'] == 'success') {
                                $agent_trail = new AgentEmailWarningTrail;
                                $agent_trail->agent_application_id = $aa->id;
                                $agent_trail->email_template_id = $agent_reminder->id;
                                $agent_trail->email_template_type = $agent_reminder->email_type;
                                $agent_trail->referees = $referees_email;
                                $agent_trail->date_sent = Carbon::now()->setTimezone('Australia/Brisbane')->format('Y-m-d');
                                $agent_trail->user_id = 1;
                                $agent_trail->is_sent = 1;
                                $agent_trail->save();
    
                                dump('Agent: '.$aa->agent_name. ' (Referee: '.$ref.') - reminder was sent successfully');
                            }else{
                                return ['status' => 'error', 'message' => 'Something went wrong.'];
                            }
                        }
                    
    
                    }else{
                        dump($aa->agent_name.' - nothing to send today'); //date today and date schedule for sending reminder is not equal
                    } 
                }
                
            }
        }else{
            dump('nothing to send'); //no agent application with complete status
        }
        
        
    } 
}
