<?php

namespace App\Http\Controllers\Program;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Unit;
use App\Http\Resources\CourseResource;
use App\Models\CourseAvtDetail;
use App\Models\AvtAnzscoIdentifier;
use App\Models\AvtAssessmentMethod;
use App\Models\AvtPrgRecogIdentifier;
use App\Models\AvtPrgLvlOfEducIdentifier;
use App\Models\AvtQlfFieldOfEducIdentifier;
use App\Models\AvtStateIdentifier;
use App\Models\AvtTrainingMethod;
use App\Models\AvtUnitEducationField;
use App\Models\CourseMatrix;
use App\Models\CoursePackage;
use App\Models\CoursePackageDetail;
use App\Models\FundedCourseMatrices;
use App\Models\CourseProspectus;
use App\Models\FundedStudentCourse;
use App\Models\TrainingDeliveryLoc;
use App\Models\TrainingOrganisation;
use App\Models\QualificationClassification;
use App\Models\StudentClass;
use App\Models\StudentCompletion;
use App\Models\Trainer;
use App\Models\UnitClassification;
use Carbon\Carbon;
use DB;

class CourseSetupController extends Controller
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
        // $unitTypes = Unit::orderBy('unit_type', 'ASC')->groupBy('unit_type')->get();


        // dump($course->code);
        // $qual_class = QualificationClassification::where('qual_code', $course->code)->first();
        // $unit_class = UnitClassification::where('tp_code', $qual_class->tp_code)->get();
        if (\Auth::user()->hasRole('Demo')) {
            // $unitTypes = Unit::where('tp_code', $course->tp_code)->where('user_id', \Auth::user()->id)->get();
            // $unitTypes = Unit::where('course_code', '<>', '[]')->where('user_id', \Auth::user()->id)->get();
            $slct_training_dlvr_loc = TrainingDeliveryLoc::where('user_id', \Auth::user()->id)->pluck('train_org_dlvr_loc_name', 'train_org_dlvr_loc_id');
        } else {
            // $unitTypes = Unit::where('tp_code', $course->tp_code)->get();
            // $unitTypes = Unit::where('course_code', '<>', '[]')->get();
            $slct_training_dlvr_loc = TrainingDeliveryLoc::pluck('train_org_dlvr_loc_name', 'train_org_dlvr_loc_id');
        }
        // dump($qual_class);
        // dump($unit_class);

        $multiple_slct_state = AvtStateIdentifier::all();
        $slct_state = $multiple_slct_state->pluck('state_name', 'state_key');
        // dd($slct_state);


        $arr_state = [];
        foreach ($multiple_slct_state as $key => $value) {
            $arr_state[] = [
                'state_key'     => $value->state_key,
                'state_name'    => $value->state_name . ' ' . '(' . $value->state_key . ')'
            ];
        }

        // for course
        $anzsco = AvtAnzscoIdentifier::orderBy('description', 'ASC')->get();
        $prgLvl = AvtPrgLvlOfEducIdentifier::orderBy('description', 'ASC')->get();
        $prgRecog = AvtPrgRecogIdentifier::orderBy('description', 'ASC')->get();
        $qlf = AvtQlfFieldOfEducIdentifier::orderBy('description', 'ASC')->get();

        $org_name = TrainingOrganisation::pluck('training_organisation_name');

        // for units
        $am = AvtAssessmentMethod::all();
        $unit_educ_field = AvtUnitEducationField::orderBy('description', 'ASC')->get();
        $training_methods = AvtTrainingMethod::all();
        $delivery_location = TrainingDeliveryLoc::all();

        // for course package
        $course_package = CoursePackage::with(['detail.get_course'])->get();


        // for class
        $trainers = Trainer::all();


        \JavaScript::put([
            // for course
            'anzsco' => $anzsco,
            'prgLvl' => $prgLvl, 
            'prgRecog' => $prgRecog,
            'qlf' => $qlf,

            // for units
            'am' => $am,
            'unit_educ_field' => $unit_educ_field,
            'training_methods' => $training_methods,

            // for training delivery location
            'slct_state' => $arr_state,
            'slct_option_state' => $slct_state,
            'slct_training_dlvr_loc' => $slct_training_dlvr_loc,
            'org_name'  => $org_name[0],
            'delivery_loc' => $delivery_location,

            // for course package
            'course_package' => $course_package,

            // for class
            'trainers' => $trainers,
        ]);

        //
        return view('program.course-setup.index');
    }

    public function course_option_list($query)
    {
        return QualificationClassification::where('qual_title', 'like', '%' . $query . '%')->orWhere('qual_code', 'like', '%' . $query . '%')->limit(100)->get();
    }

    public function course_unit_option_list($search)
    {
        // dd($search);
        // $units = Unit::orderBy('code', 'asc')->get();
        // if (\Auth::user()->hasRole('Demo')) {
        //     $units = Unit::where('code', 'like', '%' . $search . '%')->where('user_id', \Auth::user()->id)->orWhere('description', 'LIKE', '%' . $search . '%')->where('user_id', \Auth::user()->id)->get();
        // } else {
        //     $units = Unit::where('code', 'like', '%' . $search . '%')->orWhere('description', 'LIKE', '%' . $search . '%')->get();
        // }

        $units = UnitClassification::where('unit_code', 'like', '%' . $search . '%')->orWhere('unit_title', 'LIKE', '%' . $search . '%')->limit(100)->get();

        $unitArr = [];
        if($units){
            foreach ($units as $k => $v) {
                // if(in_array($course_code, $v->course_code)){
                    $unitArr[] = $v->toArray();
                // }
            }
        }
        // dd($unitArr);
        return $unitArr;
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

    public function check($data){
        if(isset($data) && !in_array($data, ['', null, false])){
            return $data;
        }else{
            return null;
        }
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
        // dump($request->data['course']);
        // dd($request->all());

        try {

            DB::beginTransaction(); 

            // course
            $d_course = $request->data['course'];
            // dump($d_course);
            $course = Course::updateOrCreate(
                [
                    // 'id' => $request->id,
                    'code' => isset($d_course['code']) ? $d_course['code'] : null,
                ],
                [
                    'code' => isset($d_course['code']) ? $d_course['code'] : null,
                    'name' => isset($d_course['name']) ? $d_course['name'] : null,
                    'tp_code' => isset($d_course['tp_code']) ? $d_course['tp_code'] : null,
                    'is_active' => 1
                ]
            );

            $courseAvtDet = CourseAvtDetail::updateOrCreate(
                [
                    'course_code' => isset($d_course['code']) ? $d_course['code'] : null
                ],
                [
                    'course_code' => isset($d_course['code']) ? $d_course['code'] : null,
                    'nominal_hours' => isset($d_course['course_avt_detail']['nominal_hours']) ? $d_course['course_avt_detail']['nominal_hours'] : null,
                    'prg_recog_identifier_id' => isset($d_course['slct_prgRecog']['value']) ? $d_course['slct_prgRecog']['value'] : null,
                    'prg_lvl_of_educ_identifier_id' => isset($d_course['slct_prgLvl']['value']) ? $d_course['slct_prgLvl']['value'] : null,
                    'qlf_field_of_educ_identifier_id' => isset($d_course['slct_qlf']['value']) ? $d_course['slct_qlf']['value'] : null,
                    'anzsco_identifier_id' => isset($d_course['slct_anzsco']['value']) ? $d_course['slct_anzsco']['value'] : null,
                    'vet_flag_status' => isset($d_course['course_avt_detail']['vet_flag_status']) ? 1 : 0
                ]
            );

            // dump($course);
            // dump($courseAvtDet);
            
            // units
            $d_units = $request->data['units'];
            // dump($d_units);
            $all_units = [];

            foreach($d_units as $k => $v){
                $unit = new unit();

                $am = [];
                if(isset($v['assessment_method'])){
                    foreach($v['assessment_method'] as $a){
                        array_push($am, $a['id']);
                    }
                }
                $am = count($am) > 0 ? implode(',', $am) : null;

                $cc = [$d_course['code']];
                
                $data = [
                    'tp_code' => isset($d_course['tp_code']) ? $d_course['tp_code'] : null,
                    'code' => isset($v['unit_code']) ? $v['unit_code'] : null,
                    'description' => isset($v['unit_title']) ? $v['unit_title'] : null,
                    'unit_type' => isset($v['unit_type']) ? $v['unit_type'] : null,
                    'assessment_method' => $am,
                    'subject_educ_fld_identifier_id' => isset($v['subject_educ_fld_identifier_id']['value']) ? $v['subject_educ_fld_identifier_id']['value'] : null,
                    'nominal_hours' => isset($v['nominal_hours']) ? $v['nominal_hours'] : null,
                    'scheduled_hours' => isset($v['schedule_hours']) ? $v['schedule_hours'] : null,
                    'training_method_id' => isset($v['training_method_id']) ? $v['training_method_id'] : null,
                    'vet_flag' => isset($v['vet_flag']) ? 1 : 0,
                    'extra_unit' => isset($v['extra_unit']) ? 1 : 0,
                    'active' => 1,
                    'course_code' => $cc,
                ];

                $unit->fill($data);
                $unit->user()->associate(\Auth::user());
                $unit->save();

                $all_units[] = $unit;
            }

            // dump($all_units);
            
            // prospectus
            $d_prospectus = $request->data['course_prospectus'];
            // dump($d_prospectus);
            // dump($request->data['course_locations']);
            
            $locations = $this->check($request->data['course_locations']) ? implode(',', $request->data['course_locations']) : null;

            foreach($d_prospectus as $props){
                $units = [];
                foreach ($props['course_units'] as $u) {
                    $units[] = [
                        'code' => $u['unit_code'],
                        'train_org_dlvr_loc_id' => isset($props['delivery_loc_id']['train_org_dlvr_loc_id']) ? $props['delivery_loc_id']['train_org_dlvr_loc_id'] : null
                    ];
                }
                $units = json_encode($units);
                
                $course_prospectus = new CourseProspectus;
    
                $data = [
                    'course_code'           => isset($d_course['code']) ? $d_course['code'] : null,
                    'name'                  => isset($props['name']) ? $props['name'] :null,
                    'date_implemented'      => Carbon::now()->format('Y-m-d'),
                    'location'              => $locations,
                    'train_org_dlvr_loc_id' => isset($props['delivery_loc_id']['train_org_dlvr_loc_id']) ? $props['delivery_loc_id']['train_org_dlvr_loc_id'] : null,
                    'course_units'          => $units,
                    'is_active'             => 1
                ];
    
                $course_prospectus->fill($data);
                $course_prospectus->save();
    
                // dump($course_prospectus);
                

            }
            

            
            // matrix
            $d_matrix = $request->data['structure_fees'];

            // dd($d_matrix);
                $all_matrix = [];
                foreach($d_matrix as $km => $vm){
                    // dump($km);
                    // domestic
                    if(count($vm['domestic']) > 0){
                        $f_matrix = FundedCourseMatrices::updateOrCreate(
                            [
                                'course_code' =>$d_course['code'],
                                'location' => $km
                            ],
                            [
                                'course_code'   =>$d_course['code'],
                                'location'      => $km,
                                'concessional_fee' => isset($vm['domestic']['concessional_fee']) ? $vm['domestic']['concessional_fee'] : null,
                                'non_concessional_fee' => isset($vm['domestic']['non_concessional_fee']) ? $vm['domestic']['non_concessional_fee'] : null,
                                'full_fee'      => isset($vm['domestic']['full_fee']) ? $vm['domestic']['full_fee'] : null,
                                // 'min_payment'   => $request->min_payment,
                            ]
                        );
                        $all_matrix[$km]['domestic'] = $f_matrix;
                    }
                    // international
                    if(count($vm['international']) > 0){
                        $i_matrix = CourseMatrix::updateOrCreate(
                            [
                                'course_code' => $d_course['code'],
                                'location' => $km
                            ],
                            [
                                'course_code' => $d_course['code'],
                                'cricos_code' => isset($vm['international']['cricos_code']) ? $vm['international']['cricos_code'] : null,
                                'wk_duration' => isset($vm['international']['wk_duration']) ? $vm['international']['wk_duration'] : null,
                                // 'wk_duration_package' => isset($vm ['international']['']),
                                'location' => $km,
                                'material_fees' => isset($vm['international']['material_fees']) ? $vm['international']['material_fees'] : null,
                                'enrolment_fee' => isset($vm['international']['enrolment_fees']) ? $vm['international']['enrolment_fees'] : null,
                                // 'concessional_fee' => isset($vm),
                                // 'non_concessional_fee' => isset($vm),
                                // Onshore
                                'onshore_tuition_individual' => isset($vm['international']['onshore_tuition_individual']) ? $vm['international']['onshore_tuition_individual'] : null,
                                // 'onshore_tuition_package' => isset($vm),
                                // Offshore
                                'offshore_tuition_individual' => isset($vm['international']['offshore_tuition_individual']) ? $vm['international']['offshore_tuition_individual'] : null,
                                // 'offshore_tuition_package' => isset($vm),
                                // 'tuition_fee_per_week' => isset($vm),
                            ]
                        );
                        $all_matrix[$km]['international'] = $i_matrix;
                    }
                }

            // dd($all_matrix);
            
            
            // package
            
            $d_package = $request->data['course_package'];
            $all_package = [];
            $all_package_det = [];

            // dump($d_package);

            foreach($d_package as $pck){
                // store package
                $package = null;
                $del_loc_id = null;
                // dd($pck['delivery_location_id']);
                if(isset($pck['delivery_location_id']['id'])){
                    $del_loc_id = $pck['delivery_location_id']['id'];
                }elseif(isset($pck['delivery_location_id'])){
                    $del_loc_id = $pck['delivery_location_id'];
                }
                if(isset($pck['id'])){
                    $package = CoursePackage::where('id',$pck['id'])->first();

                    $loc = null;
                    if(isset($pck['location']['state_key'])){
                        $loc = $pck['location']['state_key'];
                    }elseif(isset($pck['location'])){
                        $loc = $pck['location'];
                    }

                    $data = [
                        'date_created' => Carbon::now()->format('Y-m-d'),
                        'shore_type' =>isset($pck['shore_type']) ? $pck['shore_type'] : null,
                        'location' => $loc,
                        'name' => isset($pck['name']) ? $pck['name'] : null,
                        'description' => isset($pck['description']) ? $pck['description'] : null,
                        'delivery_location_id' => $del_loc_id,
                        'is_active' => isset($pck['is_active']) ? 1 : 0
                    ];
                    $package->fill($data);
                    $package->update();
                    $all_package[] = $package;
                }else{
                    $package = new CoursePackage();
                    $data = [
                        'date_created' => Carbon::now()->format('Y-m-d'),
                        'shore_type' => isset($pck['shore_type']) ? $pck['shore_type'] : null,
                        'location' => isset($pck['location']['state_key']) ? $pck['location']['state_key'] : null,
                        'name' => isset($pck['name']) ? $pck['name'] : null,
                        'description' => isset($pck['description']) ? $pck['description'] : null,
                        'delivery_location_id' => $del_loc_id,
                        'is_active' => 1,
                    ];
                    // dump($data);
                    $package->fill($data);
                    $package->user()->associate(\Auth::user());
                    $package->save();
                    $all_package[] = $package;
                }

                // store package details
                foreach($pck['detail'] as $kpd => $vpd){

                    // get course matrix int
                    // $cm = CourseMatrix::where('course_code', $d_course['code'])->where('location', $this->check($pck['location']))->get();
                    // dd($all_matrix);
                    $loc = isset($pck['location']['state_key']) ? $pck['location']['state_key'] : $pck['location'];
                    $cm = $all_matrix[$loc]['international'];
                    // dd($cm->id);
                    $package_detail = null;
                    if(isset($vpd['id'])){
                       $package_detail =  CoursePackageDetail::where('id', $vpd['id'])->first();
                       $data = [
                            'order' => $kpd+1,
                            'course_matrix_id' => isset($vpd['course_matrix_id']) ? $vpd['course_matrix_id'] : null,
                            'course_code' => isset($vpd['course_code']) ? $vpd['course_code'] : null,
                            'wk_duration' => isset($vpd['wk_duration']) ? $vpd['wk_duration'] : null,
                            'tuition_fee' => isset($vpd['tuition_fee']) ? $vpd['tuition_fee'] : null,
                            'material_fee' => isset($vpd['material_fee']) ? $vpd['material_fee'] : null,
                        ];
                        $package_detail->fill($data);
                        $package_detail->update();
                        $all_package_det[] = $package_detail;
                    }else{
                        $package_detail = new CoursePackageDetail;
                        $data = [
                            'order' => $kpd+1,
                            'course_matrix_id' => $cm->id,
                            'course_package_id' => $package->id,
                            'course_code' => isset($d_course['code']) ? $d_course['code'] :null,
                            'wk_duration' => isset($vpd['wk_duration']) ? $vpd['wk_duration'] :null,
                            'tuition_fee' => isset($vpd['tuition_fee']) ? $vpd['tuition_fee'] :null,
                            'material_fee' => isset($vpd['material_fee']) ? $vpd['material_fee'] :null,
                        ];
                        $package_detail->fill($data);
                        $package_detail->save();
                        $all_package_det[] = $package_detail;
                    }

                    $cm->wk_duration_package = $package_detail->wk_duration;
                    if(isset($pck['shore_type']) && $this->check($pck['shore_type']) == 'ONSHORE'){
                        $cm->onshore_tuition_package = isset($vpd['tuition_fee']) ? $vpd['tuition_fee'] : null;
                    }else{
                        $cm->offshore_tuition_package = isset($vpd['tuition_fee']) ? $vpd['tuition_fee'] : null;
                    }
                    $cm->update();
                }

            }

            // dd($all_package_det);

            
            // class
            $d_classes = $request->data['classes'];
            $all_class = [];
            foreach($d_classes as $k => $v){
                // dump($v);
                if(count($d_classes[$k]) > 0){
                    $data = [
                        'desc' => isset($v['desc']) ? $v['desc'] : null,
                        'trainer_id' => isset($v['trainer']) ? $v['trainer'] : null,
                        'delivery_loc' => null,
                        'course_code' => isset($d_course['code']) ? $d_course['code'] : null,
                        'venue' => isset($v['venue']) ? $v['venue'] : null,
                        'start_date' => isset($v['start_date']) && !in_array($v['start_date'], ['', null, '0000-00-00']) ? Carbon::parse($v['start_date'])->timezone('Australia/Brisbane')->format('Y-m-d') : null,
                        'end_date' => isset($v['end_date']) && !in_array($v['end_date'], ['', null, '0000-00-00']) ? Carbon::parse($v['end_date'])->timezone('Australia/Brisbane')->format('Y-m-d') : null,
                        'class_start_time' => isset($v['start_time']) ? $v['start_time'] : null,
                        'class_end_time' => isset($v['end_time']) ? $v['end_time'] : null,
                        'location' => $k,
                    ];
                    // dump($data);
                    $class = new StudentClass;
                    $class->fill($data);
                    $class->save();
                    $all_class[] = $class;
                }
                
                
                
            }
            
            // dd($all_class);
            // dd('end');
            

        DB::commit();
            
        return ['status' => 'success', 'message' => 'Course Setup Finished!'];
            

        } catch (\Throwable $th) {
            DB::rollback();

            throw $th;
        }

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
}
