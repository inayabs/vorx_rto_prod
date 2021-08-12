<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Forms\ExtFormPagesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ExternalFormResource;

use App\Models\TrainingOrganisation;
use App\Models\ExternalForm;
use App\Models\FundedStudentCourse;
use App\Models\Student\Student;

class ExternalFormController extends Controller
{
    public function index(){
        return view('external-forms.index');
    }

        

    public function list(Request $request){
        $external_forms = collect();
        if($request->sort){
            if(isset($request->search)  && $request->search!=null){
                $external_forms = ExternalForm::where('student_id','like','%'.$request->search.'%')->orWhere('process_id','like','%'.$request->search.'%')
                ->orWhere('name','like','%'.$request->search.'%');
            }else{
                $external_forms = ExternalForm::orderBy('id','desc');
            }
        }else{
            $external_forms = ExternalForm::orderBy('id','desc');
        }

        return ExternalFormResource::collection($external_forms->paginate($request->limit));
    }

    public function show($id){
        $external_form = ExternalForm::where('id',$id)->first();
        // dd($external_form->form_json);
        if(isset($external_form)){
            \JavaScript::put([
                'external_form'=>$external_form
            ]);
            return view('external-forms.edit');
        }else{
            return abort(404);
        }
    }

    public function store(Request $request,$form){
        $student_id = isset($request['inputs']['student_id'])?$request['inputs']['student_id']:null;
        $name = isset($request['inputs']['student_name'])?$request['inputs']['student_name']:null;
        $funded_student_course = '';
        // dd($student_id);
        if(isset($request['inputs']['student_id'])){
            if(!isset($request['inputs']['course'])){
                return response()->json(['status'=>'error','message'=>'Course not found']);
            }
            $funded_student_course = FundedStudentCourse::where('student_id',$student_id)->where('course_code',$request['inputs']['course']['code'])->first();
            if(!isset($funded_student_course)){
                return response()->json(['status'=>'error','message'=>'Student/Course does not match']);
            }        
        }
        
        if($funded_student_course!=''){
            try{
                $external_form = new ExternalForm;
                $external_form->name = $name;
                $external_form->student_id = $funded_student_course->student_id;
                $external_form->process_id = isset($funded_student_course->process_id)?$funded_student_course->process_id:'';
                $external_form->form_type = $form;
                $external_form->form_json = $request->all();
                $external_form->status = 'complete';
                $external_form->date_created = now();
                $external_form->save();
                return response()->json(['status'=>'success']);
            }catch(Exception $e){
                DB::rollBack();
                return response()->json(['status'=>'error','message'=>$e->getMessage()]);
            }
        }else{
            try{
                $external_form = new ExternalForm;
                $external_form->name = $name;
                $external_form->form_type = $form;
                $external_form->form_json = $request->all();
                $external_form->status = 'complete';
                $external_form->date_created = now();
                $external_form->save();
    
                return response()->json(['status'=>'success']);
            }catch(Exception $e){
                DB::rollBack();
                return response()->json(['status'=>'error','message'=>$e->getMessage()]);
            }
        }
    }

    public function delete($id){
        // dd($id);
        try {
            // start db transaction
            DB::beginTransaction();

            $external_form = ExternalForm::where('id', $id)->first();
            // $external_form->org_details->delete();
            $external_form->delete();

            DB::commit();

            return ['status' => 'success'];
        } catch (\Exception $e) {
            DB::rollBack();

            // return to previous page with errors
            return json_encode(['message' => $e->getMessage(), 'status' => 'error']);
        }
    }

    public function update(Request $request,$id){
        // dd($request->pages);
        $student_id = isset($request['inputs']['student_id'])?$request['inputs']['student_id']:null;
        // $name = isset($request['inputs']['student_name'])?$request['inputs']['student_name']:null;
        $funded_student_course = '';
        // dd($student_id);
        if(isset($request['inputs']['student_id'])){
            if(!isset($request['inputs']['course'])){
                return response()->json(['status'=>'error','message'=>'Course not found']);
            }
            $funded_student_course = FundedStudentCourse::where('student_id',$student_id)->where('course_code',$request['inputs']['course']['code'])->first();
            if(!isset($funded_student_course)){
                return response()->json(['status'=>'error','message'=>'Student/Course does not match']);
            }        
        }

        $pages = array_merge($request->pages,$request->staff_page);
        // dd($pages);
        $external_form = ExternalForm::where('id',$id)->first();
        if(isset($external_form)){
            $inputs = $external_form->form_json['inputs'];
            // dd($form_json);
            $new_form_json = ['pages'=>$pages,'inputs'=>$inputs];
            // dd($form_json);
            try{
                DB::beginTransaction();
                $external_form->form_json = $new_form_json;
                $external_form->update();

                DB::commit();

                return response()->json(['status'=>'success']);
            }catch(Exception $e){
                return response()->json(['status'=>'error','message'=>$e->getMessage()]);
            }
        }
    }

    public function external_form($form_name,$id=null){
        $app_name = config('app.name');
        $external_form = ExternalForm::where('id',$id)->first();
        if(isset($external_form)){
            $external_form_json = json_decode(json_encode($external_form->form_json),true);
            $pages = $external_form_json['pages'];
            $inputs = $external_form_json['inputs'];

            \JavaScript::put([
                'pages'=>$pages,
                'inputs'=>$inputs,
                'app_settings'=>TrainingOrganisation::first(),
                // 'form_name'=>$external_form->form_type,
                'form'=>$external_form->form_type,
                'has_staff_checking'=>1
            ]);
        }else{
            if($app_name == 'Phoenix'){
                $extForm = new ExtFormPagesController;
                switch($form_name){
                    case 'complaints-and-appeals':
                        // dd('this is complaints');
                        $pages = $extForm->complaints_and_appeals_pca();

                        \JavaScript::put([
                            'pages'=>$pages,
                            'app_settings'=>TrainingOrganisation::first(),
                            'form_name'=>'Complaints and appeals form',
                            'form'=>'complaints_and_appeals',
                            'has_staff_checking'=>1
                        ]);
                    break;
                    case 'application-for-release-letter':
                        $pages = $extForm->application_for_release_letter_pca();
                        
                        \JavaScript::put([
                            'pages'=>$pages,
                            'app_settings'=>TrainingOrganisation::first(),
                            'form_name'=>'Application for Release Letter',
                            'form'=>'application_for_release_letter',
                            'has_staff_checking'=>1
                        ]);
                    break;
                    case 'application-for-deferment':
                        $pages = $extForm->application_for_deferment_pca();
                        
                        \JavaScript::put([
                            'pages'=>$pages,
                            'app_settings'=>TrainingOrganisation::first(),
                            'form_name'=>'Application for deferment suspension cancellation withdrawal',
                            'form'=>'application_for_deferment',
                            'has_staff_checking'=>1
                        ]);
                    break;
                    case 'student-general-request-form':
                        $pages = $extForm->student_general_form_pca();
                        
                        \JavaScript::put([
                            'pages'=>$pages,
                            'app_settings'=>TrainingOrganisation::first(),
                            'form_name'=>'Student general request form',
                            'form'=>'student_general_request_form',
                            'has_staff_checking'=>1
                        ]);
                    break;
                    case 'qualification-request-form':
                        $pages = $extForm->qualification_request_form_pca();
                        
                        \JavaScript::put([
                            'pages'=>$pages,
                            'app_settings'=>TrainingOrganisation::first(),
                            'form_name'=>'Qualification request form',
                            'form'=>'qualification_request_form',
                            'has_staff_checking'=>1
                        ]);
                    break;
                    case 'refund-request-form':
                        $pages = $extForm->refund_request_form_pca();
                        
                        \JavaScript::put([
                            'pages'=>$pages,
                            'app_settings'=>TrainingOrganisation::first(),
                            'form_name'=>'Refund request form',
                            'form'=>'refund_request_form',
                            'has_staff_checking'=>1
                        ]);
                    break;
                    case 'critical-incident-report-form':
                        $pages = $extForm->critical_incident_report_form_pca();
                        
                        \JavaScript::put([
                            'pages'=>$pages,
                            'app_settings'=>TrainingOrganisation::first(),
                            'form_name'=>'Critical incident report form',
                            'form'=>'critical_incident_report_form',
                            'has_staff_checking'=>0
                        ]);
                    break;
                    default:
                        return abort(404);
                }
            }else{
                return abort(404);
            }
        }

        return view('external-forms.external-form');
    }

    public function complaints_and_appeals($id){
        // dd($id);
        $app_name = config('app.name');
        $external_form = ExternalForm::where('id',$id)->first();
        if(isset($external_form)){
            $external_form_json = json_decode(json_encode($external_form->form_json),true);
            $pages = $external_form_json['pages'];
            // dd($pages);
        }else{
            $extForm = new ExtFormPagesController;
            if($app_name == 'Phoenix'){
                $pages = $extForm->complaints_and_appeals_pca();
            }else{
                $pages = '';
            }
        }
        \JavaScript::put([
            'pages'=>$pages,
            'app_settings'=>TrainingOrganisation::first(),
            'form_name'=>'Complaints and appeals form',
            'form'=>'complaints_and_appeals',
            'has_staff_checking'=>1
        ]);
        return view('external-forms.external-form');
    }
    
    public function save_complaints_and_appeals($request){
        // dd($request->all());
        $student_id = $request['inputs']['student_id'];
        $name = $request['inputs']['full_name'];
        $funded_student_course = '';
        if(isset($student_id) || isset($request['inputs']['course'])){
            $funded_student_course = FundedStudentCourse::where('student_id',$student_id)->where('course_code',$request['inputs']['course']['code'])->first();
            
            if(!isset($funded_student_course)){
                return response()->json(['status'=>'error','message'=>'Student/Course not found']);
            }        
        }
        if($funded_student_course!=''){//existing studnet
            try{
                $external_form = new ExternalForm;
                $external_form->name = $name;
                $external_form->student_id = $funded_student_course->student_id;
                $external_form->process_id = isset($funded_student_course->process_id)?$funded_student_course->process_id:'';
                $external_form->form_type = 'complaints_and_appeals';
                $external_form->form_json = $request->all();
                $external_form->status = 'complete';
                $external_form->date_created = now();
                $external_form->save();
    
                return response()->json(['status'=>'success']);
            }catch(Exception $e){
                DB::rollBack();
                return response()->json(['status'=>'error','message'=>$e->getMessage()]);
            }
        }else{// guest complainant
            try{
                $external_form = new ExternalForm;
                $external_form->name = $name;
                $external_form->form_type = 'complaints_and_appeals';
                $external_form->form_json = $request->all();
                $external_form->status = 'complete';
                $external_form->date_created = now();
                $external_form->save();
                
                return response()->json(['status'=>'success']);
            }catch(Exception $e){
                DB::rollBack();
                return response()->json(['status'=>'error','message'=>$e->getMessage()]);
            }
        }   
    }
    
    public function get_student($id){
        $student = Student::with('party.person','contact_detail')->where('student_id',$id)->first();
        
        if(isset($student)){
            return response()->json(['status'=>'success','student_details'=>$student]);
        }else{
            return response()->json(['status'=>'error','message'=>'Student ID not found']);
        }
    }
    
}
