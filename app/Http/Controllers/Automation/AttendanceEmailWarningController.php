<?php

namespace App\Http\Controllers\Automation;

use App\Http\Controllers\Controller;
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

class AttendanceEmailWarningController extends Controller
{
    //
    public function fetch_email_warning_templates()
    {
        $ew = EmailTemplate::where('add_on', 'automation.warning_letter_attendance')->get();
        $m = EmailModule::all()->pluck('module_name', 'id'); 

        return ['ew' => $ew, 'm' => $m, 'addOn' => 'automation.warning_letter_attendance'];
    }


    public function save_email_warning_temnplate(Request $request)
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
                    'add_on'                =>'automation.warning_letter_attendance',
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
                    'interval'              => isset($request->interval) && !in_array($request->interval, [null,'']) ? $request->interval : 0,
                    'succeeding_email_type' =>$request->succeeding_email_type,
                    'add_on'                =>'automation.warning_letter_attendance',
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

}
