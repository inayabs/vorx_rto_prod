<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Send\EmailSendingController;
use App\Models\EmailAutomation;
use App\Models\EnrolmentPackAttachment;
use App\Models\FundedStudentCourse;
use App\Models\Student\OfferLetter\OfferLetter;
use App\Models\StudentAttachment;
use App\Models\Student\Student;
use App\Models\TrainingOrganisation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use File;
use Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class StudentAttachmentController extends Controller
{
    //
    public function __construct()
    {
        return $this->middleware('auth');
    }
    public function upload(Request $request, $student_id)
    {

        $path = '';
        $file = null;

        try {
            DB::beginTransaction();

            $file = $request->file('files');

            $path = $file->store('public/student/new/attachments/' . $student_id . '/');
            $hashFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->hashName());
            $ext = $file->guessClientExtension();
            if($file->getMimeType() == 'application/x-rar'){
                $ext = 'rar';
            }

            $studentAttachment = new StudentAttachment([
                'name'      => $file->getClientOriginalName(),
                'hash_name' => $hashFileName,
                'size'      => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'ext'       => $ext,
                '_input'       => 'attachment',
            ]);

            // associated user
            $studentAttachment->user()->associate(\Auth::user());
            $studentAttachment->student()->associate($student_id);
            $studentAttachment->save();
            $studentAttachment->path_id = $student_id;
            $studentAttachment->update();

            DB::commit();

            $file_path = '/storage/student/new/attachments/' . $studentAttachment->trainer_id . '/' . $studentAttachment->hash_name . '.' . $studentAttachment->ext;

            $file = [
                'id' => $studentAttachment->id,
                'lastModified' => $studentAttachment->updated_at->timestamp,
                'lastModifiedDate' => $studentAttachment->updated_at,
                'name' => $studentAttachment->name,
                'size' => $studentAttachment->size,
                'file_path' => $file_path,
                'file_ext' => $studentAttachment->ext,
                'file_type' => explode('/', $studentAttachment->mime_type)[0],
            ];

            // return response(['status' => 'success', 'attID' => $attID, 'preview' => $preview], 200)->header('Content-Type', 'text/json');
            return response(['status' => 'success', 'file' => $file], 200)->header('Content-Type', 'text/json');
            // return response(['status' => 'success', 'attID' => 0], 200)->header('Content-Type', 'text/json');
        } catch (\Exception $e) {
            DB::rollBack();

            // remove file
            Storage::delete($path);
            dd($e->getMessage());
        }
    }
    public function preview($id)
    {
        $file = StudentAttachment::find($id);
        $path_old = null;
        $path_new = null;
        $path = null;
        // file path
        // if ($file->path_id == $file->student_id) {
            $path_new = storage_path() . '/app/public/student/new/attachments/' . $file->student_id . '/' . $file->hash_name . '.' . $file->ext;
        // } else {
            $path_old = storage_path() . '/app/public/student/old/attachments/' . $file->path_id . '/' . $file->hash_name . '.' . $file->ext;
        // }

        $path = file_exists($path_old) ? $path_old : $path_new;

        // raw file contents
        $fileContent = File::get($path);

        if(in_array($file->ext, ['zip', 'rar'])) {
            $filetype=filetype($path);
            // $filename=basename($path);
            header ("Content-Type: ".$filetype);
            header ("Content-Length: ".filesize($path));
            header ("Content-Disposition: attachment; filename=".$file->name);
            readfile($path);
        }else{
            return response($fileContent)->header('Content-Type', $file->mime_type);
        }

    }
    public function fetch($student_id)
    {
        $studentAttachment = StudentAttachment::where('student_id', $student_id)->get();

        // dd($trainerAttachments->toArray());

        $attchments = [];
        foreach ($studentAttachment as $key => $value) { 
            // dd($value->updated_at->timestamp);
            $file_path = '';
            $path_old = null;
            $path_new = null;

            // if ($value->path_id == $value->student_id) {
                $path_new = '/storage/student/new/attachments/' . $value->student_id . '/' . $value->hash_name . '.' . $value->ext;
            // } else {
                $path_old = '/storage/student/old/attachments/' . $value->path_id . '/' . $value->hash_name . '.' . $value->ext;
            // }

            $file_path = file_exists($path_old) ? $path_old : $path_new;

            array_push($attchments, [
                'id' => $value->id,
                'lastModified' => $value->updated_at->timestamp,
                'lastModifiedDate' => $value->updated_at,
                'name' => $value->name,
                'size' => $value->size,
                'file_path' => $file_path,
                'file_ext' => $value->ext,
                'file_type' => explode('/', $value->mime_type)[0],
            ]);
        }

        return $attchments;
    }
    
    public function destroy($id)
    {

        if(\Auth::user()->roles->first()->name != 'Staff'){
            $studentAttachment = StudentAttachment::where('id', $id)->first();
    
            if ($studentAttachment->path_id == $studentAttachment->student_id) {
                $file_path = '/storage/student/new/attachments/' . $studentAttachment->student_id . '/' . $studentAttachment->hash_name . '.' . $studentAttachment->ext;
            } else {
                $file_path = '/storage/student/old/attachments/' . $studentAttachment->path_id . '/' . $studentAttachment->hash_name . '.' . $studentAttachment->ext;
            }
            
            Storage::delete($file_path);
    
            if($studentAttachment){
                $studentAttachment->delete();
    
                return ['status' => 'success'];
    
            }else{
                return ['status' => 'error'];
            }
        }else{
            return ['status' => 'Access Denied'];
        }


        // dd($studentAttachment);
    }
    public function rename(Request $request, $id){
        try {
            DB::beginTransaction();

            $studentAttachment = StudentAttachment::where('id', $id)->first();
            $studentAttachment->name = $request->rename;
            $studentAttachment->update();

            DB::commit();
            return json_encode(['status' => 'updated']);
        } catch (\Exception $e) {
            DB::rollBack();

            // remove file
            // Storage::delete($path);
            dd($e->getMessage());
        }
    }

    // ---------------------------------
    //          COE Functions
    // ---------------------------------

    public function fetch_coe($ol_id)
    {
        
        $ol = OfferLetter::with(['course_details', 'student'])->where('id', $ol_id)->first();

        $coe = StudentAttachment::where('path_id', $ol_id)->where('_input', 'confirmation_of_enrolment')->first();
        
        if($ol){
            $orientation_date = isset($ol->course_details[0]->course_start_date) ? Carbon::createFromFormat('Y-m-d', $ol->course_details[0]->course_start_date)->subDays(3)->format('Y-m-d') : null;
            $orientation_date = $ol->orientation_date != null ? $ol->orientation_date : $orientation_date;
        }
        
        $coe = $coe ? $coe->toArray() : null;
        
        $ol = $ol ? $ol->toArray() : null;

        return ['coe' => $coe, 'od' => $orientation_date, 'student' => $ol['student']];
    }

    public function remove_coe($id)
    {
        $coe = StudentAttachment::where('id', $id)->first();

        if($coe){
            $coe->delete();
            return ['status'=>'success'];
        }else{
            return ['status' => 'error', 'message' => 'No COE attachment found.'];
        }
    }

    public function send_coe(Request $request)
    {
        // dd($request->all());

        $ol = OfferLetter::with('student.party.person', 'student.contact_detail', 'student_details', 'course_details')->where('id', $request->coe['path_id'])->first();

        // dd($ol->course_details[0]);

        // CREATE LOGINS
        $user = User::where('username', $request->student_id)->first();

        if(!$user){
            $user = new User;
            $user->username = $request->student_id;

            $password = trim($ol->student->party->person->lastname);
            $password .= substr_replace($ol->student->party->person->date_of_birth,"",4);

            $user->password = Hash::make($password);
            $user->is_active = 1;
            $user->profile_image = 'default-profile.png';
            $user->party()->associate($ol->student->party);
            $user->save();
            $user->assignRole('Student');
        }else{
            $password = trim($ol->student->party->person->lastname);
            $password .= substr_replace($ol->student->party->person->date_of_birth,"",4);
            $user->password = Hash::make($password);
            $user->update();
        }

        // SEND COE
        $org = TrainingOrganisation::first();

        $email = [];
        if(isset($ol->student->contact_detail->email) && !in_array($ol->student->contact_detail->email, ['', null])){
            $email[] = $ol->student->contact_detail->email; 
        }
        if(isset($ol->student->contact_detail->email_at) && !in_array($ol->student->contact_detail->email_at, ['', null])){
            $email[] = $ol->student->contact_detail->email_at; 
        }

        if(count($email) < 1){
            return ['status' => 'error', 'message' => 'Please provide student email'];
        }

        $send = new EmailSendingController;

        $admin_emails = EmailAutomation::where('addOn', 'coe')->pluck('email');

        if($request->orientation_date == null){
            $orientation = Carbon::createFromFormat('Y-m-d', $ol->course_details[0]->course_start_date)->subDays(3);
        }else{
            $orientation = Carbon::parse($request->orientation_date)->setTimezone('Australia/Melbourne');
        }

        $paths[] = [
            // 'path' => storage_path('app/public/student/new/offer-letter/coe/'.$request->student_id.'/'.$ol->id.'/'.$request->coe['hash_name'].'.'.$request->coe['ext']), 
            'path' => storage_path('app/public/student/new/attachments/'.$request->student_id.'/'.$request->coe['hash_name'].'.'.$request->coe['ext']), 
            'name' => $request->coe['name']
        ];

        // offer letter attachment
        $ola = StudentAttachment::where('student_id', $request->student_id)->where('_input','offer_letter')->first();
        if($ola){
            $paths[] = [
                'path' => storage_path('app/public/student/new/attachments/'.$request->student_id.'/'.$ola->hash_name.'.'.$ola->ext), 
                'name' => $ola->name
            ];
        }

        $receipt = $this->generate_reciept($ol->id, Carbon::now()->setTimezone('Australia/Melbourne')->format('Y-m-d'));

        if(isset($receipt['path'])){
            $paths[] = $receipt;
        }

        // dump($orientation->format('Y-m-d'));
        // dd($orientation->format('d/m/Y'));

        $ol->orientation_date = $orientation->format('Y-m-d');
        $ol->status_id = 2;

        if($ol->student->student_type == 1){
            $content = 'Dear '.$ol->student->party->name.',<br><br>Greetings of the day from Phoenix College of Australia (PCA).<br><br>I would like to confirm your enrolment at PCA. Please find the attached Confirmation of Enrolment and Offer letter and Enrolment Acceptance Agreement. Please review the acceptance agreement for the due date of installments, as the installment dates may vary according to the initial payment you made to PCA.<br><br>Also, please be advised that you will be required to attend 20 hours per week and maintain the course progress requirements according to the Monitoring Course Progress and intervention strategy for international students Policy and Procedure, which can be found in the student handbook <a href="http://phoenixcollege.edu.au/files/policies/Student%20Handbook%20and%20Policies%20and%20Procedure.pdf">(http://phoenixcollege.edu.au/files/policies/Student%20Handbook%20and%20Policies%20and%20Procedure.pdf).</a><br><br>You will be required to attend the orientation session on '.$orientation->format('jS \of F Y').', before the commencement of the course.<br><br>This will be your Access to our <b>Student Portal</b>:<br><b>URL:</b> <a href="'.$org->student_url.'">'.$org->student_url.'</a><br><b>Username:</b> '.$user->username.' <br><b>Password:</b> '.$password.' <br><br>We wish you good luck for your study at PCA.<br><br>Thank you very much.<br><br>Regards<br><b>Admin Team</b><br>Phoenix College of Australia<br>RTO NO 45633 CRICOS CODE 03871F <br><a href="http://phoenixcollege.edu.au/">http://phoenixcollege.edu.au/</a>';
        }else{
            $content = 'Dear '.$ol->student->party->name.',<br><br>Greetings of the day from Phoenix College of Australia (PCA).<br><br>I would like to confirm your enrolment at PCA. Please find the attached Confirmation of Enrolment and Offer letter and Enrolment Acceptance Agreement.<br><br>Also, please be advised that you will be required to attend 20 hours per week and submit the assessment on time in order to complete the course in the expected duration of time. Please find the link of the student handbook. <br><a href="http://phoenixcollege.edu.au/files/policies/Student%20Handbook%20and%20Policies%20and%20Procedure.pdf">(http://phoenixcollege.edu.au/files/policies/Student%20Handbook%20and%20Policies%20and%20Procedure.pdf).</a><br><br>You will be required to attend the orientation session on '.$orientation->format('jS \of F Y').', before the commencement of the course.<br><br>This will be your Access to our <b>Student Portal</b>:<br><b>URL:</b> <a href="'.$org->student_url.'">'.$org->student_url.'</a><br><b>Username:</b> '.$user->username.' <br><b>Password:</b> '.$password.' <br><br>We wish you good luck for your study at PCA.<br><br>Thank you very much.<br><br>Regards<br><b>Admin Team</b><br>Phoenix College of Australia<br>RTO NO 45633 CRICOS CODE 03871F <br><a href="http://phoenixcollege.edu.au/">http://phoenixcollege.edu.au/</a>';
        }

        // get agent email in enrolment form
        if(isset($ol->enrolment_pack->id)) {
            $enrolFromAgentEmail = new StudentController;
            $agentEmail = $enrolFromAgentEmail->check_enrolment($ol->process_id, 'agent_email');
            if($agentEmail) {
                $admin_emails[] = $agentEmail;
            }
        }
        
        // dd($admin_emails);
        $s = $send->send_automate('Notification of Confirmation of Enrolment', $content, [$org->training_organisation_name => $org->email_address], $email, $paths, $admin_emails);
        //     // $s = $send->send_automate('CEA Enrolment Application', $content, ['Community Education Australia' => 'constant.claro@gmail.com'], ['konstant.claro@gmail.com']);

        if($s['status'] == 'success'){
            
            $ol->update();
            $student_course = FundedStudentCourse::where('student_id', $request->student_id)->where('course_code', $ol->course_details[0]->course_code)->first();
            if($student_course){
                $student_course->status_id = 2;
                $student_course->update();
                
                if($student_course->detail){
                    $student_course->detail->commence_prg_identifier = in_array($student_course->detail->commence_prg_identifier, ['', null, 0]) ? 2 : $student_course->detail->commence_prg_identifier;
                    $student_course->detail->update();
                }
            }

            return ['status' => 'success'];
        }else{
            return ['status' => 'error', 'message' => 'Something went wrong.'];
        }

        
    }

    public function upload_coe(Request $request)
    {
        // dd($request->all());

        $ol = OfferLetter::where('id', $request->offer_letter_id)->first();

        // dd($ol);
        
        //
        // dd($request->file('files'));
        // $student_course = FundedStudentCourse::with(['course', 'student.party'])->where('id', $request->student_course_id)->first();

        // dd($student_course);

        $path = '';
        $file = null;
        
        if(!$ol){
            return ['status' => 'error', 'message' => 'No path found'];
        }

        // if(isset($student_course->student_workbook_attachment[0])){
        //     foreach($student_course->student_workbook_attachment as $v){
        //         $v->delete();
        //     }
        // }
        // dd($ol->student_id);

        try {
            DB::beginTransaction();

            $file = $request->file('files');

            // $path = $file->store('public/student/new/offer-letter/coe/' . $ol->student_id . '/' . $ol->id . '/');
            $path = $file->store('public/student/new/attachments/' . $ol->student_id . '/');;
            $hashFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->hashName());

            if($file->getClientSize() > 10000000){
                return ['status' => 'error', 'message' => 'File is to big. Max file size is 10mb.'];
            }
            
            $studentAttachment = new StudentAttachment([
                'name'      => $file->getClientOriginalName(),
                'student_id'   => $ol->student_id,
                'path_id'      => $ol->id,
                'hash_name' => $hashFileName,
                'size'      => $file->getClientSize(),
                'mime_type' => $file->getMimeType(),
                'ext'       => $file->guessClientExtension(),
                '_input'       => 'confirmation_of_enrolment',
            ]);

            // associated user
            $studentAttachment->user()->associate(\Auth::user());
            $studentAttachment->student()->associate($ol->student_id);
            $studentAttachment->save();
            $studentAttachment->path_id = $ol->id;
            $studentAttachment->update();

            DB::commit();

            // $file_path = '/student/new/offer-letter/coe/' . $studentAttachment->student_id . '/' . $ol->id . '/' . $studentAttachment->hash_name . '.' . $studentAttachment->ext;
            $file_path = '/student/new/attachment/' . $studentAttachment->student_id . '/' . $studentAttachment->hash_name . '.' . $studentAttachment->ext;

            $file = [
                'id' => $studentAttachment->id,
                'lastModified' => $studentAttachment->updated_at->timestamp,
                'lastModifiedDate' => $studentAttachment->updated_at,
                'name' => $studentAttachment->name,
                'size' => $studentAttachment->size,
                'file_path' => $file_path,
                'file_ext' => $studentAttachment->ext,
                'file_type' => explode('/', $studentAttachment->mime_type)[0],
            ];

            // $auto = EmailAutomation::where('addOn', 'workbook')->get();

            // if($auto){
            //     $this->send_workbook($student_course, $studentAttachment, $auto);
            // }

            // return response(['status' => 'success', 'attID' => $attID, 'preview' => $preview], 200)->header('Content-Type', 'text/json');
            return response(['status' => 'success', 'file' => $studentAttachment], 200)->header('Content-Type', 'text/json');
            // return response(['status' => 'success', 'attID' => 0], 200)->header('Content-Type', 'text/json');
        } catch (\Exception $e) {
            DB::rollBack();

            // remove file
            Storage::delete($path);
            dd($e->getMessage());
        }

    }

    public function generate_coe($id = 24)
    {

        $ol = OfferLetter::with(['fees', 'student.party.person', 'student.contact_detail', 'student.funded_course.course'])->where('id', $id)->first();
        $to = TrainingOrganisation::first();
        // dd($ol->student->party);
        // return \PDF::loadView('custom.pca.initial-payment-receipt-pdf', compact('ol', 'to', 'receiptDate'))->setPaper('A5', 'portrate')->stream('initial-payment-receipt');
        $path = storage_path('app/public/student/new/attachments/'.$ol->student->student_id);
        
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        
        if(isset($ol->student->funded_course[0]->detail) && !$ol->student->funded_course[0]->detail->delivery_mode){
            $ol->student->funded_course[0]->detail->predominant_delivery_mode = 'I';
            $ol->student->funded_course[0]->detail->update();
            $ol = OfferLetter::with(['fees', 'student.party.person', 'student.contact_detail', 'student.funded_course.course'])->where('id', $id)->first();
        }
        // dd($ol->fees);
        // dump('wew');

        

        // \PDF::loadView('custom.pca.initial-payment-receipt-pdf', compact('ol', 'to', 'receiptDate'))->setPaper('A5', 'portrate')->save($path.'/initial-payment-receipt.pdf')->stream('initial-payment-receipt');
        \PDF::loadView('custom.pca.confirmation-of-enrolment', compact('ol', 'to'))->setPaper('A4', 'portrate')->save($path.'/confirmation-of-enrolment.pdf');
        
        $exist = StudentAttachment::where('_input', 'confirmation_of_enrolment')->first();

        if(!$exist){
            $studentAttachment = new StudentAttachment([
                'name'      => 'confirmation-of-enrolment.pdf',
                'student_id'   => $ol->student_id,
                'path_id'      => $ol->id,
                'hash_name' => 'confirmation-of-enrolment',
                'size'      => filesize( $path.'/confirmation-of-enrolment.pdf'),
                'mime_type' => mime_content_type( $path.'/confirmation-of-enrolment.pdf'),
                'ext'       => 'pdf',
                '_input'       => 'confirmation_of_enrolment',
            ]);
    
            // associated user
            $studentAttachment->user()->associate(\Auth::user());
            $studentAttachment->student()->associate($ol->student_id);
            $studentAttachment->save();
            $studentAttachment->path_id = $ol->id;
            $studentAttachment->update();
        }

        

        // return ['path' => $path . '/initial-payment-receipt.pdf', 'name' => 'initial-payment-receipt.pdf'];


    }

    public function upload_initial_payment(Request $request)
    {
        // dd($request->all());

        $ol = OfferLetter::with(['enrolment_pack'])->where('id', $request->offer_letter_id)->first();

        // dd($ol);
        
        //
        // dd($request->file('files'));
        // $student_course = FundedStudentCourse::with(['course', 'student.party'])->where('id', $request->student_course_id)->first();

        // dd($student_course);

        $path = '';
        $file = null;
        
        if(!$ol){
            return ['status' => 'error', 'message' => 'No path found'];
        }

        // if(isset($student_course->student_workbook_attachment[0])){
        //     foreach($student_course->student_workbook_attachment as $v){
        //         $v->delete();
        //     }
        // }
        // dd($ol->student_id);

        try {
            DB::beginTransaction();

            $file = $request->file('files');

            // $path = $file->store('public/student/new/offer-letter/coe/' . $ol->student_id . '/' . $ol->id . '/');
            $path = $file->store('public/enrolment/' . $ol->enrolment_pack->process_id . '/');;
            $hashFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->hashName());

            if($file->getClientSize() > 10000000){
                return ['status' => 'error', 'message' => 'File is to big. Max file size is 10mb.'];
            }
            
            $paymentAttachment = new EnrolmentPackAttachment([
                'name'      => $file->getClientOriginalName(),
                'process_id'   => $ol->enrolment_pack->process_id,
                'path_id'      => $ol->id,
                'hash_name' => $hashFileName,
                'size'      => $file->getClientSize(),
                'mime_type' => $file->getMimeType(),
                'ext'       => $file->guessClientExtension(),
                '_input'       => 'initial_payment_receipt',
            ]);

            // associated user
            $paymentAttachment->user()->associate(\Auth::user());
            $paymentAttachment->enrolment_pack()->associate($ol->enrolment_pack);
            $paymentAttachment->save();

            DB::commit();

            // $file_path = '/student/new/offer-letter/coe/' . $studentAttachment->student_id . '/' . $ol->id . '/' . $studentAttachment->hash_name . '.' . $studentAttachment->ext;
            // $file_path = '/student/new/attachment/' . $studentAttachment->student_id . '/' . $studentAttachment->hash_name . '.' . $studentAttachment->ext;

            // $file = [
            //     'id' => $studentAttachment->id,
            //     'lastModified' => $studentAttachment->updated_at->timestamp,
            //     'lastModifiedDate' => $studentAttachment->updated_at,
            //     'name' => $studentAttachment->name,
            //     'size' => $studentAttachment->size,
            //     'file_path' => $file_path,
            //     'file_ext' => $studentAttachment->ext,
            //     'file_type' => explode('/', $studentAttachment->mime_type)[0],
            // ];

            // $auto = EmailAutomation::where('addOn', 'workbook')->get();

            // if($auto){
            //     $this->send_workbook($student_course, $studentAttachment, $auto);
            // }

            // return response(['status' => 'success', 'attID' => $attID, 'preview' => $preview], 200)->header('Content-Type', 'text/json');
            return response(['status' => 'success', 'file' => $paymentAttachment], 200)->header('Content-Type', 'text/json');
            // return response(['status' => 'success', 'attID' => 0], 200)->header('Content-Type', 'text/json');
        } catch (\Exception $e) {
            DB::rollBack();

            // remove file
            Storage::delete($path);
            dd($e->getMessage());
        }

    }

    public function fetch_initial_payment($id)
    {
        $ol = OfferLetter::with(['enrolment_pack.ep_attachment_initial_payment'])->where('id', $id)->first();
        $ipr = null;

        if(isset($ol->enrolment_pack->ep_attachment_initial_payment[0]->id)){
            $ipr = $ol->enrolment_pack->ep_attachment_initial_payment[0];
        }
        return $ipr;
    }

    public function generate_reciept($id = 25, $receiptDate = null)
    {
        $ol = OfferLetter::with(['fees', 'student.party.person', 'course_details.course'])->where('id', $id)->first();
        $to = TrainingOrganisation::first();
        $receiptDate = $receiptDate == null ? Carbon::now()->setTimezone('Australia/Melbourne')->format('d/m/Y') : Carbon::createFromFormat('Y-m-d', $receiptDate)->format('d/m/Y');
        // dd($ol->student->party);
        // return \PDF::loadView('custom.pca.initial-payment-receipt-pdf', compact('ol', 'to', 'receiptDate'))->setPaper('A5', 'portrate')->stream('initial-payment-receipt');
        $path = storage_path('app/public/student/receipt/'.$ol->student->student_id);

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $course = isset($ol->course_details[0]->course->id) ? $ol->course_details[0]->course->code . ' - ' .$ol->course_details[0]->course->name : '';
        \PDF::loadView('custom.pca.initial-payment-receipt-pdf', compact('ol', 'to', 'receiptDate', 'course'))->setPaper('A5', 'portrate')->save($path.'/initial-payment-receipt.pdf')->stream('initial-payment-receipt');

        
        // save to student attachments
        $path2 = storage_path('app/public/student/new/attachments/'.$ol->student->student_id);
        \PDF::loadView('custom.pca.initial-payment-receipt-pdf', compact('ol', 'to', 'receiptDate'))->setPaper('A5', 'portrate')->save($path2.'/initial-payment-receipt.pdf')->stream('initial-payment-receipt');

        $studentAttachment = StudentAttachment::where('student_id', $ol->student->student_id)->where('name', 'initial-payment-receipt.pdf')->first();
        if(!$studentAttachment) {
            $studentAttachment = new StudentAttachment([
                'name'      => 'initial-payment-receipt.pdf',
                'hash_name' => 'initial-payment-receipt',
                'size'      => null,
                'mime_type' => 'application/pdf',
                'ext'       => 'pdf',
                '_input'       => 'initial_payment_receipt',
            ]);
            // associated user
            $studentAttachment->user()->associate(\Auth::user());
            $studentAttachment->student()->associate($ol->student);
            $studentAttachment->save();
            $studentAttachment->path_id = $ol->student->student_id;
            $studentAttachment->update();
        }

        

        return ['path' => $path . '/initial-payment-receipt.pdf', 'name' => 'initial-payment-receipt.pdf'];
    } 
}
