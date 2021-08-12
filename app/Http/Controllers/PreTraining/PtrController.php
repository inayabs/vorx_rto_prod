<?php

namespace App\Http\Controllers\PreTraining;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student\Type;
use App\Models\EnrolmentPack;
use App\Http\Controllers\PreTraining\PtrPCAController;
use App\Http\Controllers\PreTraining\PtrPagesController;
use App\Models\TrainingOrganisation;
use Validator;
use PDF;
use DB;
class PtrController extends Controller
{
    public function index(){
        // $pages = EnrolmentPack::find(1);
        // dd(json_decode($pages->ptr,true));
        $ptrPages = new PtrPagesController;
        $pages = $ptrPages->get_pages();
        // dd($pages);
        \JavaScript::put([
            'pages'=>$pages
        ]);
        
        return view('pre-training.index');
    }
    

    public function save(Request $request,$process_id){
        // dd(json_encode($request->all()));
        $enrolment_pack = EnrolmentPack::where('process_id',$process_id)->first();
        $enrolment_id = $enrolment_pack->id;
        // dd($enrolment_pack->id);
        $enrolment_pack = EnrolmentPack::find($enrolment_id);
        $enrolment_pack->ptr = json_encode($request->all());
        // dd($enrolment_pack);
        if($enrolment_pack->save()){
            return "success";
        }
    }

    public function show($process_id){
        $app_name = config('app.name');
        
        $enrolment_pack = EnrolmentPack::where('process_id',$process_id)->first();
        $app_setting = TrainingOrganisation::first();
        if(!isset($enrolment_pack)){
            return abort(404);
        }

        if(isset($enrolment_pack->student_type)){
            $student_type = Type::where('id',$enrolment_pack->student_type)->first();
        }else{
            if(isset($stud_type)){
                $student_type = Type::where('id',$stud_type)->first();
            }else{
                \JavaScript::put([
                    'logo_url'          => $this->get_logo(),
                    'error'=>'Student type is not specified.'
                ]);
                return view('pre-training.index');
            }
        }


        if($enrolment_pack->ptr!=null){
            $pre = json_decode($enrolment_pack->ptr);
            $ptr = $pre->pages;
            
            $inputs = $pre->inputs;
        }else{
            $ptrPages = new PtrPagesController;
            $pages = $ptrPages->get_pages($process_id);

            $ptr = $pages;
            $inputs = '';
        }
        

        if($app_name=='CEA'){
            $link = '/online-enrolment/process/'.$process_id;
        }else if($app_name =='Phoenix'){
            $link = '/pca/enrolment-process/'.$process_id;
        }else{
            $link = '#';
        }

        \JavaScript::put([
            'pages'                     => $ptr,
            'process_id'                => $process_id,
            'signature'                 => $enrolment_pack->student_signature,
            'type_signature'            => $enrolment_pack->type_signature,
            'student_name'              => $enrolment_pack->student_name,
            'student_type'              => $student_type,
            'sig_acceptance_agreement'  => $enrolment_pack->sig_acceptance_agreement,
            // 'concession_docs'           => isset($ef['valid_concession_card_yes']) ? $ef['valid_concession_card_yes'] : [],
            'logo_url'                  => $this->get_logo(),
            'app_settings'              => $app_setting,
            'action'                    => $inputs !=null ? 'edit_student' :'',
            'inputs'                    => $inputs,
            'link'                      => $link
        ]);

        return view('pre-training.index');
    }

    public function ptr_pdf($process_id){
        $enrolment_pack = EnrolmentPack::where('process_id',$process_id)->first();
        $ptrPages = new PtrPagesController;
        if(!$enrolment_pack){
           abort(404);
        }
        
        $ptr = $enrolment_pack->ptr!=null?json_decode($enrolment_pack->ptr):$ptrPages->get_pages($process_id);
        // dd($ptr);
        $app_name = config('app.name');
        if($app_name == 'CEA'){           
            $pdf = PDF::loadView('pre-training.pdf.cea',compact('enrolment_pack','ptr'));
        }else if($app_name == 'Phoenix'){
            $enrolment_pack->stud_type = Type::where('id',$enrolment_pack->student_type)->first();
            // dd('naa diri');
            // dd($ptr,$enrolment_pack);
            $pdf = PDF::loadView('pre-training.pdf.pca',compact('enrolment_pack','ptr'));
        }else{
            return abort(404);
        }     
        
        return $pdf->stream();
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
