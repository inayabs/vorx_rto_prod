<?php

namespace App\Http\Controllers\EmailSending;

use Validator;
use Auth;
use DB;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Documents;
use App\Models\EmailSending;
use App\Models\EmailTemplate;
use App\Models\EmailModule;
use App\Models\EmailWarningTrail;
use App\Models\Student\Student;
use App\Models\Agent;
use App\Models\Course;

use Mail;
use App\Mail\EmailSendingMailer;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

use Carbon\Carbon;


class EmailSendingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $fetch_documents = Documents::select(['id', 'u_id', 'name', 'version', 'is_current', 'hash_name', 'ext', 'created_at'])->where('is_current', 1)->whereIn('ext', ['doc', 'docx', 'xls', 'xlsx', 'csv', 'pdf'])->get();
        $fetch_courses = Course::select(['code', 'name'])->get();
        $slct_module = EmailModule::pluck('module_name', 'id');
        
        \JavaScript::put([
            'fetchDocuments' => $fetch_documents,
            'fetchCourses' => $fetch_courses,
            'slct_module' => $slct_module,
        ]);
        return view('email-sending.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('email-sending.create');
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
        $requestTo = collect($request->to);
        $requestCc = collect($request->cc);
        $requestBcc = collect($request->bcc);
        $requestAttachments = collect($request->attachments);

        /* Email sending validator callback & delivery status variables */
        $validator = new EmailValidator();

        // To
        if (!$requestTo->isEmpty()) {
            $to = $email_to = $passed_to = $passed_to_id = $failed_to_id = [];
            foreach ($request->to as $key => $value) {
                array_push($to, $value['user_id']);
                array_push($email_to, $value['email']);
            }
            /* To email validation */
            for ($ctrTo = 0; $ctrTo < count($to); $ctrTo++) {
                if ($validator->isValid($email_to[$ctrTo], new RFCValidation()) === true) {
                    $passed_to[] = $email_to[$ctrTo];
                    $passed_to_id[] = $to[$ctrTo];
                } else {
                    $failed_to_id[] = $to[$ctrTo];
                }
            }
            $to = implode(',', $to);
        } else { $to = $passed_to = null; $passed_to_id = $failed_to_id = [];}

        // Cc
        if (!$requestCc->isEmpty()) {
            $cc = $email_cc = $passed_cc = $passed_cc_id = $failed_cc_id = [];
            foreach ($request->cc as $key => $value) {
                array_push($cc, $value['user_id']);
                array_push($email_cc, $value['email']);
            }
            /* Cc email validation */
            for ($ctrCc = 0; $ctrCc < count($cc); $ctrCc++) {
                if ($validator->isValid($email_cc[$ctrCc], new RFCValidation()) === true) {
                    $passed_cc[] = $email_cc[$ctrCc];
                    $passed_cc_id[] = $cc[$ctrCc];
                } else {
                    $failed_cc_id[] = $cc[$ctrCc];
                }
            }
            $cc = implode(',', $cc);
        } else { $cc = $passed_cc = null; $passed_cc_id = $failed_cc_id = [];}

        // Bcc
        if (!$requestBcc->isEmpty()) {
            $bcc = $email_bcc = $passed_bcc = $passed_bcc_id = $failed_bcc_id = [];
            foreach ($request->bcc as $key => $value) {
                array_push($bcc, $value['user_id']);
                array_push($email_bcc, $value['email']);
            }
            /* Bcc email validation */
            for ($ctrBcc = 0; $ctrBcc < count($bcc); $ctrBcc++) {
                if ($validator->isValid($email_bcc[$ctrBcc], new RFCValidation()) === true) {
                    $passed_bcc[] = $email_bcc[$ctrBcc];
                    $passed_bcc_id[] = $bcc[$ctrBcc];
                } else {
                    $failed_bcc_id[] = $bcc[$ctrBcc];
                }
            }
            $bcc = implode(',', $bcc);
        } else { $bcc = $passed_bcc =  null; $passed_bcc_id = $failed_bcc_id = [];}

        // Attachments 'id', 'u_id', 'name', 'version', 'is_current', 'hash_name', 'ext', 'created_at'
        if (!$requestAttachments->isEmpty()) {
            $attach_id = $local_url = $attach_name = [];
            foreach ($request->attachments as $key => $value) {
                array_push($attach_id, $value['id']);
                array_push($attach_name, $value['name']);
                array_push($local_url,  '/public/documents/'. Carbon::parse($value['created_at'])->format('Y-m') . '/' . $value['u_id'] . '/' . $value['hash_name'] . '.' . $value['ext']);
            }
            $attach_id = implode(',', $attach_id);
        } else { $attach_id = $local_url = $attach_name = null; }

        // Collect user id to be stored and tracked 
        $passed_email_id = implode(',', array_merge($passed_to_id, $passed_cc_id, $passed_bcc_id));
        $failed_email_id = implode(',', array_merge($failed_to_id, $failed_cc_id, $failed_bcc_id));

        /* Email Sending */
        $mail_from = env('MAIL_USERNAME');
        $mail_subject = $request->subject;
        $mail_body = $request->email_content;
        $mail_template = $request->email_template;

        /***************************************  Start sending ********************************/
        $mailable = new EmailSendingMailer;
        $mailable->from($mail_from, 'ETI');
        
        if($passed_to != null) { $mailable->to($passed_to); }  /* Validate if TO exist */
        if($passed_cc != null) { $mailable->cc($passed_cc); } /* Validate if CC exist */
        if($passed_bcc != null) { $mailable->bcc($passed_bcc); } /* Validate if BCC exist */
        $mailable->subject($mail_subject);
        $mailable->view('email-sending.templates.template')->with([
            'emailContent' => $mail_body,
        ]);
        if ($local_url != null) { /* Validate if attachments exist */
            $length = count($local_url);
            for ($i = 0; $i < $length; $i++) {
                $mailable->attachFromStorage($local_url[$i], $attach_name[$i]);
            }
        }
        Mail::queue($mailable);
        /***************************************  End sending ********************************/

        /* Storing Email details to database */
        echo "Email Sent. Check your inbox.";
        $saveEmailRecords = new EmailSending();
        $data = [
            'to' => $to,
            'cc' => $cc,
            'bcc' => $bcc,
            'subject' => $request->subject,
            'email_content' => $request->email_content,
            'attachments' => $attach_id,
            'success' => $passed_email_id,
            'failed' => $failed_email_id,
        ];
        $saveEmailRecords->fill($data);
        $saveEmailRecords->save();
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
        $findEmailSending = EmailSending::find($id);
        \JavaScript::put([
            'find_email_sending' => $findEmailSending,
        ]);
        return view('email-sending.details');
    }

    /* Fetch and display the email sending details list */
    public function email_send_list() {
        $email_listing = EmailSending::orderBy('id', 'DESC')->select(['id', 'subject', 'success', 'failed', 'created_at'])->get();
        return($email_listing);
    }

    /* Get the list of all Students, Agents and Others */
    public function get_persons_list() {
        $queryStudents = Student::with(['offer_letter.student_details', 'offer_letter.course_details'])->whereHas('offer_letter.course_details', function($q){
            $q->whereIn('status_id', ['2','3']);
        })->get();
        $queryAgents = Agent::with(['detail'])->get();

        $qa = $qs = [];

        foreach ($queryAgents as $a_key => $a_value) {
            $qa[] = [
                'user_id' => $a_value->detail['agent_id'],
                'person_type' => 'agent',
                'email' => $a_value->detail['email'],
            ];
        }

        foreach ($queryStudents as $s_key => $s_value) {
            foreach ($s_value->offer_letter as $sk => $sv) {
                foreach ($sv->course_details as $cdk => $cdv) {
                    if(in_array($cdv->status_id, ['2','3'])) {
                        $qs[] = [
                            'user_id' => $s_value->student_id,
                            'person_type' => 'student',
                            // 'status_id' => $cdv->status_id,
                            'student_type' => strval($s_value->student_type_id),
                            'course' => $cdv->course_code,
                            'email' => $sv->student_details['email_personal'],
                        ];  
                    }
                }
            }
        }

        $merge_persons = array_merge($qa, $qs);
        return($merge_persons);
    }

    public function get_templates_list() {
        $e_template = EmailTemplate::all();
        $slct_module = EmailModule::pluck('module_name', 'id');
        $templates = [];

        foreach($e_template as $key => $et){
            
            if($et->email_module_id != null){
                $module_val = $et->email_module_id;
                $module = EmailModule::where('id', $module_val)->first(); 
            }

            $templates[] = [
                'id'                => $et->id,
                'name'              => $et->name,
                'email_module_id'   => isset($module_val) ? $module_val : '',
                'module_name'       => isset($module->module_name) ? $module->module_name : '',
                'email_subject'     => $et->email_subject,
                'email_content'     => $et->email_content,
                'email_type'        => $et->email_type,
                'interval'          => $et->interval,
                'succeeding_email_type'        => $et->succeeding_email_type,
                'active'            => $et->active,
            ];
        }
        $data = [
            'moduleTypes'      => $slct_module,
            'emailTemplates'   => $templates
        ];
        return $data; 
    }

    public function template_store_update(Request $request)
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
                    'interval'              => $request->interval,
                    'succeeding_email_type' =>$request->succeeding_email_type,
                    'active'                => $request->active ? 1 : 0
                ]);

                $email_trail = EmailWarningTrail::where('email_template_id', $request['id'])->get();
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
                    'interval'              => $request->interval,
                    'succeeding_email_type' =>$request->succeeding_email_type,
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

    public function destroy_template($id) {
        $template = EmailTemplate::find($id);
        $template->delete();
    }

    public function get_module_fields($m_id) {
        $module = EmailModule::where('id', $m_id)->first();
        $m_fields = null;
        
        if($module && $module->fields != null){
            $m_fields = explode(',',$module->fields);
        }
        return $m_fields;
    }
}
