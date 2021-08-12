<?php

namespace App\Http\Controllers\CertificateIssuance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Course;
use App\Models\CourseProspectus;
use App\Models\StudentCompletion;
use App\Models\StudentCompletionDetail;
use App\Models\StudentCertificateIssuance;
use App\Models\CertificateIssuanceDetail;
use App\Models\Student\Student;
use App\Models\TrainingOrganisation;
use App\Models\TrainingOrgBankDetails;
use App\Http\Resources\CertificateIssuanceQirResource;


class QualificationIssuanceRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $student_completion = Student::with('party.person', 'type', 'certificate_issuance.details','certificate_issuance.sentCert', 'completion.course', 'completion.completion_course.funded_course')->has('certificate_issuance.details')->whereHas('completion')->where('is_test', 0)->orderBy('id','DESC')->get();
        $arr_qir = $this->getQIRList($student_completion);

        $courses = [];
        $unit_com = [
            '@@@@' => 'Unit of Competency'
        ];
        if(count($arr_qir) > 0){
            foreach($arr_qir as $qir){
                array_push($courses, $qir['course_code']);
            }
        }
        $courses = array_unique($courses);
        $slct_course = Course::whereIn('code', $courses)->orderBy('name', 'asc')->pluck('name', 'code');
        if(count($courses) > 0){
            foreach($courses as $fc){
                if($fc == 'Unit of Competency'){
                    $slct_course = $slct_course->merge($unit_com);
                }
            }
        }
        
        \JavaScript::put([
            'slct_course' => $slct_course
        ]);

        return view('students.qualification-issuance-register.index');
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

    public function qir_info(){

        $qirList = Student::with('party.person', 'type', 'certificate_issuance.details','certificate_issuance.sentCert', 'completion.course', 'completion.completion_course.funded_course')->has('certificate_issuance.details')->where('is_test',0)->whereHas('completion')->orderBy('id','DESC')->paginate(10);

        return CertificateIssuanceQirResource::collection($qirList);

    }

    public function search($qir){
        $search = $qir;
        
        $qirList = Student::with(['party', 'party.person', 'completion.course', 'certificate_issuance.details'])->has('certificate_issuance')->whereHas('completion')->where('student_id', 'like', '%' . $search . '%')->orWhereHas('party.person', function ($q) use ($search) {
            $q->where('firstname', 'like', '%'.$search.'%'); // student name
        })->orWhereHas('party', function($q) use ($search) {
             $q->where('name', 'LIKE', '%'. $search . '%'); // student name
        })->orWhereHas('completion', function($q) use ($search){
            $q->where('course_code', 'LIKE', '%' . $search . '%'); //course code
        })->orWhereHas('completion.course', function($q) use ($search){
            $q->where('name', 'LIKE', '%' . $search . '%'); // course name
        })->orWhereHas('certificate_issuance', function($q) use ($search){
            $q->where('issued_date', 'LIKE', '%' . $search . '%'); //CERTIFICATE date issued
        })->orWhereHas('certificate_issuance.details', function($q) use ($search){
            $q->where('created_at', 'LIKE', '%' . $search . '%'); //SOA date issued
        })->where('is_test', 0)->orderBy('id', 'desc')->paginate(10);
        
        return CertificateIssuanceQirResource::collection($qirList);
    }

    public function qir_filter($filter){

        $filters = json_decode($filter);
        
        $course = $filters->course;
        if($filters->course != null && $filters->type != null){
            $qirList = $this->get_course($course);
            $qirList = $this->getCompletion($filters->type);
        }elseif($filters->type != null){
            $qirList = $this->getCompletion($filters->type);
        }elseif($filters->course != null){
            $qirList = $this->get_course($course);
        }

        return CertificateIssuanceQirResource::collection($qirList->paginate(10));
    }

    public function generate_qir($filter) {
        
        $filters = json_decode($filter);
        $qirList = '';
        $course = $filters->course;
        if($filters->course != null && $filters->type != null){
            $qirList = $this->get_course($course);
            $qirList = $this->getCompletion($filters->type)->get();
        }elseif($filters->type != null){
            $qirList = $this->getCompletion($filters->type)->get();
        }elseif($filters->course != null){
            $qirList = $this->get_course($course)->get();
        }
        
        if($qirList == null){
            // $student_completion = Student::with('party.person', 'type', 'certificate_issuance.details','certificate_issuance.sentCert', 'completion.course')->has('certificate_issuance')->whereHas('completion')->orderBy('id','DESC')->get();
            $student_completion = Student::with('party.person', 'type', 'certificate_issuance.details','certificate_issuance.sentCert', 'completion.course', 'completion.completion_course.funded_course')->has('certificate_issuance.details')->whereHas('completion')->where('is_test', 0)->orderBy('id','DESC')->get();

        }else{
            $student_completion = $qirList;
        }
        // dump($student_completion);
        
        // 
        $arr_qir = $this->getQIRList($student_completion);
        $student_completion_lists = [];
        $page = 0;
        if (count($arr_qir) > 10) {
            $student_completion_lists = array_chunk($arr_qir, 10);
            $page = count($student_completion_lists);
        } else {
            $student_completion_lists[0] = $arr_qir;
            $page = 1;
        }
        // dd($student_completion_lists);

        // Company Details
        $com_setting = TrainingOrganisation::first();
        //  $address = $com_setting->addr_line1 .', '. $com_setting->addr_location .', '. $com_setting->state_identifier . ' ' . $com_setting->postcode .', '. 'Australia';
        if ($com_setting->logo_img != null) {
            $logo = 'storage/config/images/' . $com_setting->logo_img;
        } else {
            $logo = 'images/logo/vorx_logo.png';
        }
        $logo_url = url('/' . $logo . '');
        // dd($logo_url);
        $bank_details = TrainingOrgBankDetails::where('training_organisation_id', $com_setting->training_organisation_id)->first();
       
        // $student_completion = ($student_completion->chunk(10));
        $file_name = "Qualification Issuance Register.pdf";
        return \PDF::loadView('students.qualification-issuance-register.qir_pdf', compact('student_completion', 'logo_url', 'student_completion_lists', 'page'))->setPaper(array(0, 0, 525, 900), 'landscape')->stream($file_name);
    }

    public function getCompletion($type){
        if($type == 'cert'){
            $completion = Student::with('party.person', 'type', 'certificate_issuance.details','certificate_issuance.sentCert', 'completion.course')->has('certificate_issuance')->whereHas('completion')->where('is_test', 0)->whereHas('certificate_issuance', function ($q) {
                $q->whereNotNull('expected_course_completion');
            })->whereHas('completion', function ($q) {
                $q->whereNotNull('completion_date');
            })->whereHas('completion.course', function ($q) {
                $q->whereIn('completion_status_id', [3, 4]);
            })->orderBy('id','DESC');
        }elseif($type == 'soa'){
            $completion = Student::with('party.person', 'type', 'certificate_issuance.details','certificate_issuance.sentCert', 'completion.course')->has('certificate_issuance')->whereHas('completion')->where('is_test', 0)->whereHas('completion', function ($q) {
                $q->whereNull('completion_date');
            })->orderBy('id','DESC');
        }

        return $completion;
    }

    public function get_course($course){
        
        $filter_course = Student::with('party.person', 'type', 'certificate_issuance.details','certificate_issuance.sentCert', 'completion.course', 'completion.completion_course.funded_course')->has('certificate_issuance.details')->whereHas('completion.course')->where('is_test', 0)->where('student_id', 'like', '%' . $course . '%')->orWhereHas('party.person', function ($q) use ($course) {
            $q->where('firstname', 'like', '%'.$course.'%'); // student name
        })->orWhereHas('party', function($q) use ($course) {
             $q->where('name', 'LIKE', '%'. $course . '%'); // student name
        })->orWhereHas('completion', function($q) use ($course){
            $q->where('course_code', 'LIKE', '%' . $course . '%'); //course code
        })->orderBy('id', 'desc');

        return $filter_course;
    }


    public function getQIRList($student_completion){
        $arr_qir = [];
        foreach($student_completion as $com){
                if(isset($com->completion)){
                    foreach($com->completion as $key => $qualification){
                        // dd($qualification);
                        if($qualification->certificate != null){
                            if($qualification->course_code == '@@@@'){
                                $course_code = 'Unit of Competency';
                                $course_name = $qualification->completion_course->funded_course->uc_description;
                            }else{
                                $course_code = $qualification->course->code;
                                $course_name = $qualification->course->name;
                            }
                             // CERTIFICATE
                            $units = $qualification->details;
                            if($qualification->completion_status_id == 3 || $qualification->certificate->expected_course_completion != null){
                                $cert_details = $qualification->certificate->details;
                                $release_date = "";
                                $cert_num = $qualification->certificate->manual_cert_num;
                                foreach($cert_details as $detail){
                                    if(count($detail->units) == $units->count()){
                                        $release_date = Carbon::parse($detail->release_date)->format('d/m/Y');
                                        $arr_qir[] = [
                                            'id'                => $com->id,
                                            'fullname'          => $com->party->name,
                                            'student_id'        => $com->student_id,
                                            'student_type'      => $com->type->type,
                                            'qualification'     => $course_name,
                                            'course_code'       => $course_code,
                                            'cert_no'           => $cert_num,
                                            'date_issued'       => $release_date,
                                            'rr_cert_no'        => $cert_num,
                                            'rr_date_issued'    => $release_date,
                                            'soa_no'            => '',
                                            'soa_date_issued'   => '',
                                            'status'           => 'cert',
                                        ];
                                    }
                                }
                                
                            }
                            // dump($arr_qir);
            
            
                                // SOA NUMBER AND ISSUED DATE
                                $soa_numbers = [];
                                $soa_dateIssued = [];
                                
                                if(!$qualification->certificate->details->isEmpty()){
                                    $details = $qualification->certificate->details;
                                    foreach($qualification->certificate->details as $detail){
                                        $soa_numbers[] = $detail->soa_number;
                                        $soa_dateIssued[] = Carbon::parse($detail->release_date)->format('d/m/Y');
                                        if(count($detail->units) !== $units->count()){
                                            $arr_qir[] = [
                                                'id'                => $com->id,
                                                'fullname'          => $com->party->name,
                                                'student_id'        => $com->student_id,
                                                'student_type'      => $com->type->type,
                                                'qualification'     => $course_name,
                                                'course_code'       => $course_code,
                                                'cert_no'           => '',
                                                'date_issued'       => '',
                                                'rr_cert_no'        => '',
                                                'rr_date_issued'    => '',
                                                'soa_no'            => implode(', ',$soa_numbers),
                                                'soa_date_issued'   => implode(', ',$soa_dateIssued),
                                                'status'           => 'soa',
                                            ];
                                        }
                                        
                                    }
            
                                    if($qualification->completion_date == null){
                                        $arr_qir[] = [
                                            'id'                => $com->id,
                                            'fullname'          => $com->party->name,
                                            'student_id'        => $com->student_id,
                                            'student_type'      => $com->type->type,
                                            'qualification'     => $course_name,
                                            'course_code'       => $course_code,
                                            'cert_no'           => '',
                                            'date_issued'       => '',
                                            'rr_cert_no'        => '',
                                            'rr_date_issued'    => '',
                                            'soa_no'            => implode(', ',$soa_numbers),
                                            'soa_date_issued'   => implode(', ',$soa_dateIssued),
                                            'status'           => 'soa',
                                        ];
                                    }elseif($qualification->completion_date != null){
                                          if($details->count()>1){
                                            $arr_qir[] = [
                                                'id'                => $com->id,
                                                'fullname'          => $com->party->name,
                                                'student_id'        => $com->student_id,
                                                'student_type'      => $com->type->type,
                                                'qualification'     => $course_name,
                                                'course_code'       => $course_code,
                                                'cert_no'           => '',
                                                'date_issued'       => '',
                                                'rr_cert_no'        => '',
                                                'rr_date_issued'    => '',
                                                'soa_no'            => implode(', ',$soa_numbers),
                                                'soa_date_issued'   => implode(', ',$soa_dateIssued),
                                                'status'           => 'both',
                                            ];
                                          }
                                            
                                    }
            
                                    
                                    
                                }
                        }
            
                    }
                }
        }

        return $arr_qir;

    }





}