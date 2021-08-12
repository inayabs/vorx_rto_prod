<?php

namespace App\Http\Controllers\Automation;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Send\EmailSendingController;
use Illuminate\Http\Request;

use Validator;

use App\Models\EmailSending;
use App\Models\EmailTemplate;
use App\Models\EmailModule;
use App\Models\EmailWarningTrail;
use App\Models\Student\Student;
use App\Models\Student\OfferLetter\OfferLetter;
use App\Models\OfferLetterCourseDetail;
use App\Models\PaymentScheduleTemplate;
use App\Models\OfferLetterFee;
use App\Models\CashPayment;
use App\Models\OnlinePayment;
use App\Models\PaymentScheduleDetail;
use App\Models\PdPlan;

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
use App\Models\EmailSegment;

class PDPlanController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function fetchVars(){
        $email_templates = EmailTemplate::with('email_module')->where('email_module_id', 4)->get();
        $email_modules = EmailModule::all()->pluck('module_name', 'id');
        $email_segments = EmailSegment::orderBy('id','desc')->get();
        $config = Automation::where('type','pd-plan')->first();
        $pd_plans = PdPlan::with('email_template')->orderBy('id','desc')->get();
        // dd($email_segments);
        // dd($pd_plans);
        // return json_decode($pd_plans);
        return [
            'email_templates' => $email_templates, 
            'email_modules' => $email_modules,
            'email_segments'=>$email_segments,
            'config'=>$config,
            'pd_plans'=>$pd_plans,
        ];
    }

    public function fetch_email_templates()
    {
        $ew = EmailTemplate::with('email_module')->where('email_module_id', 4)->get();
        $m = EmailModule::all()->pluck('module_name', 'id'); 
        return ['ew' => $ew, 'm' => $m, 'addOn' => 'automation.warning_letter_attendance'];
    }

    public function fetch_email_segments(){
        $email_segments = EmailSegment::orderBy('id','desc')->get();

        return $email_segments;
    }

    public function save_email_segment(Request $request){
        // return $request->emails;
        if(in_array($request->emails, ['', null])){
            return ['status' => 'error', 'msg' => 'Email is required!'];
        }

        $emails = explode(',', preg_replace('/\s+/', '', $request->emails));
        
        $invalid_emails = [];
        foreach ($emails as $v){
            if(!filter_var($v, FILTER_VALIDATE_EMAIL)){
                array_push($invalid_emails,$v);
            }
        }
        
        
        if(count($invalid_emails)>0){
            return ['status' => 'error', 'msg' => 'Invalid emails found: "'. implode(',',$invalid_emails) . '"'];
        }

        if(isset($request->id)){
            $email_segment = EmailSegment::findOrFail($request->id);

            // dd($email_segment);
            $email_segment->label = $request->label;
            $email_segment->emails = $request->emails;
            $email_segment->update();
            return response()->json(['status'=>'updated',]);
        }
        else{
            $email_segment = new EmailSegment;

            $email_segment->label = $request->label;
            $email_segment->emails = $request->emails;
            $email_segment->save();
            return response()->json(['status'=>'added',]);
        }
        

        // return response()->json(['message'=>'success',]);
    }

    public function save_configuration(Request $request){

        try {
            DB::beginTransaction();

            $data = Automation::updateOrCreate(
                [
                    'type' => $request->type,
                ],
                [
                    'type' => $request->type,
                    'config' => $request->config,
                    'emails' => null,
                    'occurrence_type' => $request->occurrence_type,
                    'month' => $request->month,
                    'day' => $request->day,
                    'time' => $request->time,
                ]
            );

            DB::commit();

            return ['status' => 'success'];

        } catch (\Throwable $th) {
            DB::rollback();
            return ['status' => 'error', 'msg' => $th];
            // throw $th;
        }
    }

    public function save_template(Request $request){
        // dd(json_encode($request->email_to));
        if(isset($request->id)){
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email_subject' => 'required',
                // 'email_to'=>'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'errors' => $validator->messages()]);
            }

            try {
                // start db transaction
                DB::beginTransaction();


                $email_template = EmailTemplate::find($request->id);
                $email_template->name                  = isset($request->name) ? $request->name : null;
                $email_template->email_subject         = isset($request->email_subject) ? $request->email_subject : null;
                $email_template->email_module_id       = isset($request->email_module_id) ? $request->email_module_id : null;
                $email_template->email_content         = isset($request->email_content) ? $request->email_content : null;
                $email_template->email_type            = null;
                $email_template->interval              = null;
                $email_template->succeeding_email_type = isset($request->succeeding_email_type) ? $request->succeeding_email_type : null;
                $email_template->add_on                ='automation.pd_plan';
                $email_template->active                = isset($request->active) ? $request->active : null;
                
                $email_template->update();
                DB::commit();

                return json_encode(['message'=>'updated', 'status' => 'success']);

            } catch (\Exception $e) {
                DB::rollBack();
                // dd($e);
                // return to previous page with errors
                return  response()->json(['message' => $e->getMessage(), 'status' => 'errors']);
            }
        }else{
            // dd('pang create');
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email_subject' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'errors' => $validator->messages()]);
            }

            try {
                // start db transaction
                DB::beginTransaction();

                $email_template = new EmailTemplate;
                $email_template->fill([
                    'name'                  => isset($request->name) ? $request->name : null,
                    'email_subject'         => isset($request->email_subject) ? $request->email_subject : null,
                    'email_module_id'       => isset($request->email_module_id) ? $request->email_module_id : null,
                    'email_content'         => isset($request->email_content) ? $request->email_content : null,
                    'email_type'            => null,
                    'interval'              => null,
                    'succeeding_email_type' => null,
                    'add_on'                =>'automation.pd_plan',
                    'active'                => isset($request->active) ? $request->active : null,
                ]);
                $email_template->save();
                

                

                DB::commit();

                return json_encode(['message'=>'added', 'status' => 'success']);

            } catch (\Exception $e) {
                DB::rollBack();
                dd($e);
                // return to previous page with errors
                return  response()->json(['message' => $e->getMessage(), 'status' => 'errors']);
            }
        }
    }

    public function pd_plan_save(Request $request){
        if(isset($request->id)){
            $validator = Validator::make($request->all(), [
                'email_to'=>'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'errors' => $validator->messages()]);
            }

            try {
                // start db transaction
                DB::beginTransaction();

                $pd_plan = PdPlan::find($request->id);
                // $pd_plan->email_template_id = $email_template->id;
                $pd_plan->activity_type = isset($request->activity_type) ? $request->activity_type : null;
                $pd_plan->activity_description = isset($request->activity_description) ? $request->activity_description : null;
                $pd_plan->email_to = isset($request->email_to) ? json_encode($request->email_to) : null;
                $pd_plan->email_date = isset($request->email_date) ? Carbon::parse($request->email_date)->timezone('Australia/Melbourne')->format('Y-m-d') : null;
                $pd_plan->activity_date = isset($request->activity_date) ? Carbon::parse($request->activity_date)->timezone('Australia/Melbourne')->format('Y-m-d') : null;
                $pd_plan->update();

                DB::commit();

                return json_encode(['message'=>'updated', 'status' => 'success']);

            } catch (\Exception $e) {
                DB::rollBack();
                // dd($e);
                // return to previous page with errors
                return  response()->json(['message' => $e->getMessage(), 'status' => 'errors']);
            }
        }else{
            // dd('pang create');
            $validator = Validator::make($request->all(), [
                'email_to'=>'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'errors' => $validator->messages()]);
            }

            try {
                // start db transaction
                DB::beginTransaction();

                $pd_plan = new PdPlan;
                $pd_plan->activity_type = isset($request->activity_type) ? $request->activity_type : null;
                $pd_plan->activity_description = isset($request->activity_description) ? $request->activity_description : null;
                $pd_plan->email_to = isset($request->email_to) ? json_encode($request->email_to) : null;
                $pd_plan->email_date = isset($request->email_date) ? Carbon::parse($request->email_date)->timezone('Australia/Melbourne')->format('Y-m-d') : null;
                $pd_plan->activity_date = isset($request->activity_date) ? Carbon::parse($request->activity_date)->timezone('Australia/Melbourne')->format('Y-m-d') : null;
                $pd_plan->save();

                DB::commit();

                return json_encode(['message'=>'added', 'status' => 'success']);

            } catch (\Exception $e) {
                DB::rollBack();
                dd($e);
                // return to previous page with errors
                return  response()->json(['message' => $e->getMessage(), 'status' => 'errors']);
            }
        }
    }

    public function pdplan_delete($id){
        $pd_plan = PdPlan::find($id);
        $pd_plan->delete();
    }
    public function segment_delete($id){
        $pd_segment = EmailSegment::find($id);
        $pd_segment->delete();
    }

    public function sendPdEmails(){
        $send = new EmailSendingController;

        $now = Carbon::now()->format('Y-m-d');
        
        $pd_plans = PdPlan::where('email_date',$now)->get();
        $email_template = EmailTemplate::where('email_module_id',4)->where('active',1)->orderBy('id','desc')->first();
        // dd($email_template);
        if(count($pd_plans)>0){
            foreach($pd_plans as $pp){
                $activity_date = Carbon::parse($pp->activity_date)->timezone('Australia/Melbourne')->format('d/m/Y');
                $subject = $pp->activity_type;
                $content = $email_template->email_content;
                $content = str_replace('%activityDescription%',$subject,$content);
                $content = str_replace('%activityDate%',$activity_date,$content);
    
                // dd($pp->email_to);
                $email_segments = json_decode($pp->email_to);
                $emails = [];
                foreach($email_segments as $es){
                    $email_segment = EmailSegment::where('id',$es->id)->first();
                    // dd(explode(',',$email_segment->emails));
                    $es_emails = explode(',',$email_segment->emails);
                    // dd($es_emails);
                    $emails = array_merge($emails,$es_emails);
                }
                // dd($emails);
                if(count($emails)>1){
                    $emails = array_unique($emails);
                }
                // dd($emails);
                
            }
            // dd($emails);
            $if_sent = $send->send_automate($subject, $content, ['Phoenix College Admin'=>'admin@phoenixcollege.edu.au'], $emails);
            
            if(isset($if_sent['status']) && $if_sent['status'] == 'success') {
                return 'email sent';
            }
        }else{
            return 'no emails for today';
        }
        
        
    }
}
