<?php

namespace App\Http\Controllers\CertificateIssuance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

use App\Models\Course;
use App\Models\Unit;
use App\Models\CourseProspectus;
use App\Models\StudentCompletion;
use App\Models\StudentCompletionDetail;
use App\Models\StudentCertificateIssuance;
use App\Models\CertificateIssuanceDetail;
use App\Models\Student\Student;
use App\Models\TrainingOrganisation;
use App\Models\TrainingOrgBankDetails;
use App\Http\Resources\RRCIResource;

class RRCIController extends Controller
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
        $slct_course = Course::orderBy('name', 'asc')->pluck('name', 'code');

        \JavaScript::put([
            'slct_course' => $slct_course
        ]);

        return view('students.rrci-soa.index');
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
    public function rrci_info(){

        $completion = Student::with('party.person', 'type', 'certificate_issuance.details','certificate_issuance.sentCert', 'completion.course')->where('is_test', 0)->has('certificate_issuance.details')->whereHas('completion')->whereHas('completion', function ($q) {
            $q->whereNull('completion_date');
        })->get();

        $lists = [];
        foreach($completion as $com){
            
            if(isset($com->completion)){
                
                foreach($com->completion as $key => $qualification){
                    
                    if($qualification->certificate != null){
                         // get unit of competency only
                        if($qualification->course_code == '@@@@'){
                            $course_code = 'Unit of Competency';
                            $course_name = $qualification->completion_course->funded_course->uc_description;

                            // dump($qualification->course_code);
                            if(!$qualification->certificate->details->isEmpty()){
                                $details = $qualification->certificate->details;
                                
                                foreach($qualification->certificate->details as $detail){
                                    if($detail->release == 0 && $detail->release_date != null){
                                        foreach($detail->units as $c){
                                            if($c['code'] == 'CPCCWHS1001'){
                                                // dump($com);
                                                $lists[] = $com;
                                            }
                                        }
                                    }
                                    
                                }
                            }
                        }
                        
                    }
                }
            }
        }

        $x =  $this->paginate($lists);
        return RRCIResource::collection($x);

    }
    public function search($qir){
        $search = $qir;

        $qirList = Student::with(['party.person', 'type', 'completion.course', 'certificate_issuance.details','certificate_issuance.sentCert'])->where('is_test', 0)->has('certificate_issuance.details')->whereHas('completion')->where('student_id', 'like', '%' . $search . '%')->orWhereHas('party.person', function ($q) use ($search) {
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
        })->orderBy('id', 'desc')->paginate(10);

        return RRCIResource::collection($qirList);
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

            $student_completion = Student::with('party.person', 'type', 'certificate_issuance.details','certificate_issuance.sentCert', 'completion.course')->where('is_test', 0)->has('certificate_issuance.details')->whereHas('completion')->whereHas('completion', function ($q) {
                $q->whereNull('completion_date');
            })->get();
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
        return \PDF::loadView('custom.cea.register-for-recording-construction-induction', compact('student_completion', 'logo_url', 'student_completion_lists', 'page'))->setPaper(array(0, 0, 525, 900), 'landscape')->stream($file_name);
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
                            // dump($arr_qir);
            
            
                                // SOA NUMBER AND ISSUED DATE
                                $soa_numbers = [];
                                $soa_dateIssued = [];
                                $soa_created = [];
                                $unit_code = null;
                                $unit_description = null;

                                if(!$qualification->certificate->details->isEmpty()){
                                    $details = $qualification->certificate->details;
                                    foreach($qualification->certificate->details as $detail){
                                        if($detail->release == 0 && $detail->release_date != null){

                                            $soa_numbers[] = $detail->soa_number;
                                            $soa_dateIssued[] = Carbon::parse($detail->release_date)->format('d/m/Y');
                                            $soa_created[] = Carbon::parse($detail->created_at)->format('d/m/Y');

                                            foreach($detail->units as $c){
                                            $unit_code = $c['code'];
                                            $unit_description = $c['description'];

                                            if($unit_code != null && $unit_code == 'CPCCWHS1001'){
                                                if($qualification->completion_date == null){
                                                    $arr_qir[] = [
                                                        'id'                => $com->id,
                                                        'fullname'          => $com->party->name,
                                                        'student_id'        => $com->student_id,
                                                        'student_type'      => $com->type->type,
                                                        'dob'               => Carbon::parse($com->party->person->date_of_birth)->format('d/m/Y'),
                                                        'qualification'     => $course_name,
                                                        'course_code'       => $course_code,
                                                        'unit_code'         => $unit_code,
                                                        'unit_description'  => $unit_description,
                                                        'cert_no'           => '',
                                                        'date_issued'       => '',
                                                        'rr_cert_no'        => '',
                                                        'rr_date_issued'    => '',
                                                        'soa_no'            => implode(', ',$soa_numbers),
                                                        'soa_date_issued'   => implode(', ',$soa_dateIssued),
                                                        'soa_date_created'  => implode(', ',$soa_created), 
                                                        'status'           => 'soa',
                                                    ];
                                                }elseif($qualification->completion_date != null){
                    
                                                    if($details->count()>1){
                                                        $arr_qir[] = [
                                                            'id'                => $com->id,
                                                            'fullname'          => $com->party->name,
                                                            'student_id'        => $com->student_id,
                                                            'student_type'      => $com->type->type,
                                                            'dob'               => Carbon::parse($com->party->person->date_of_birth)->format('d/m/Y'),
                                                            'qualification'     => $course_name,
                                                            'course_code'       => $course_code,
                                                            'unit_code'         => $unit_code,
                                                            'unit_description'  => $unit_description,
                                                            'cert_no'           => '',
                                                            'date_issued'       => '',
                                                            'rr_cert_no'        => '',
                                                            'rr_date_issued'    => '',
                                                            'soa_no'            => implode(', ',$soa_numbers),
                                                            'soa_date_issued'   => implode(', ',$soa_dateIssued),
                                                            'soa_date_created'  => implode(', ',$soa_created), 
                                                            'status'           => 'both',
                                                        ];
                                                    }
                                                }
                                            }
                                    }
                                }   
                            }  
                                    
                            }
                        }
            
                    }
                }
        }

        return $arr_qir;

    }

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $paginate =  new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
        $path = url()->current();
        $paginate->setPath($path);
        return $paginate;
    }
}
