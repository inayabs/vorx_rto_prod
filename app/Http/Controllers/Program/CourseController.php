<?php

namespace App\Http\Controllers\Program;

use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Unit;
use App\Http\Resources\CourseResource;
use App\Models\CourseAvtDetail;
use App\Models\AvtAnzscoIdentifier;
use App\Models\AvtPrgRecogIdentifier;
use App\Models\AvtPrgLvlOfEducIdentifier;
use App\Models\AvtQlfFieldOfEducIdentifier;
use App\Models\AvtStateIdentifier;
use App\Models\CourseAttachment;
use App\Models\CourseMatrix;
use App\Models\FundedCourseMatrices;
use App\Models\CourseProspectus;
use App\Models\FundedStudentCourse;
use App\Models\TrainingDeliveryLoc;
use App\Models\TrainingOrganisation;
use App\Models\QualificationClassification;
use App\Models\StudentCompletion;
use App\Models\UnitClassification;
use Carbon\Carbon;
use DB;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkModule:course');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('program.course.index');
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
        // dd($request->all());
        //

        $this->validate($request, [
            'course.qual_code' => 'required',
            'course.qual_title' => 'required',
        ]);
        $course = Course::updateOrCreate(
            [
                // 'id' => $request->id,
                'code' => $request->course['qual_code']
            ],
            [
                'code' => $request->course['qual_code'],
                'name' => $request->course['qual_title'],
                'tp_code' => $request->course['tp_code'],
                'is_active' => 1,
                'is_uc' => isset($request->course['is_uc']) && in_array($request->course['is_uc'], [true, 1]) ? 1 : null
            ]
        );
        $course->user()->associate(\Auth::user());
        $course->update();

        return new CourseResource($course);
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
        $course = Course::with(['courseProspectus'])->where('id', $id)->first();
        $matrixEdit = CourseMatrix::where('course_code', $course->code)->get();
        $fundedMatrix = FundedCourseMatrices::where('course_code', $course->code)->get();
        
        // $unitTypes = Unit::orderBy('unit_type', 'ASC')->groupBy('unit_type')->get();


        // dump($course->code);
        // $qual_class = QualificationClassification::where('qual_code', $course->code)->first();
        // $unit_class = UnitClassification::where('tp_code', $qual_class->tp_code)->get();
        if (\Auth::user()->hasRole('Demo')) {
            // $unitTypes = Unit::where('tp_code', $course->tp_code)->where('user_id', \Auth::user()->id)->get();
            $unitTypes = Unit::where('course_code', '<>', '[]')->where('user_id', \Auth::user()->id)->get();
            $slct_training_dlvr_loc = TrainingDeliveryLoc::where('user_id', \Auth::user()->id)->pluck('train_org_dlvr_loc_name', 'train_org_dlvr_loc_id');
        } else {
            // $unitTypes = Unit::where('tp_code', $course->tp_code)->get();
            $unitTypes = Unit::where('course_code', '<>', '[]')->get();
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

        // $unitArr = [];
        // foreach ($unitTypes as $key => $value) {
        //     $unitArr[$key]['unit-type'] = strtoupper($value->unit_type);
        //     $courseUnits = Unit::select(['code', 'description', 'unit_type'])->where('unit_type', $value->unit_type)->orderBy('id', 'DESC')->get();
        //     foreach ($courseUnits as $k => $v) {
        //         $unitArr[$key]['unit-details'][] = [
        //             'code' => $v->code,
        //             'description' => $v->description,
        //             'unit_type' => $v->unit_type,
        //         ];
        //     }
        //     // $unitArr[$value->unit_type][] = ['code' => $value->code, 'description' => $value->description];

        // }
        $unitArr = [];
        foreach ($unitTypes as $k => $v) {
            if(in_array($course->code,$v->course_code)){
                $unitArr[] = [
                    'code' => $v->code,
                    'description' => $v->description,
                    // 'usedByStudent' => $v->used_by_student,
                    // 'unit_type' => $v->unit_type,
                ];
            }
        }
        // dd($unitArr);

        $org_name = TrainingOrganisation::pluck('training_organisation_name');
        // dd($org_name);
        \JavaScript::put([
            'course_id'             => $id,
            'course_code'           => $course->code,
            'course_name'           => $course->name,
            'matrix_details'        => $matrixEdit,
            'course_units'          => $unitArr,
            'funded_course_matrix'  => $fundedMatrix,
            'slct_state'            => $arr_state,
            'slct_option_state'     => $slct_state,
            'slct_training_dlvr_loc' => $slct_training_dlvr_loc,
            'org_name'              => $org_name[0],
            // 'prospectus_id' => $course->courseProspectus[0]->id,
        ]);


        return view('program.course.show');
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
        $deleteCourse =  Course::find($id);

        if (isset($deleteCourse->course_avt_detail)) {
            $deleteCourse->course_avt_detail->delete();
        }

        if (isset($deleteCourse->courseprospectus[0])) {
            foreach ($deleteCourse->courseprospectus as $course_pros) {
                $course_pros->delete();
            }
        }

        $deleteCourse->delete();
    }

    public function course_list()
    {
        // dump('sulod');
        if (\Auth::user()->hasRole('Demo')) {
            return Course::select(['id', 'code', 'name'])->where('user_id', \Auth::user()->id)->orderBy('id', 'desc')->get();
        } else {
            return Course::select(['id', 'code', 'name'])->orderBy('id', 'desc')->get();
        }
        // dd($courseList);
        // return CourseResource::collection($courseList);
    }

    public function course_info($id)
    {

        $course = Course::with(['course_avt_detail.avt_anzsco', 'course_avt_detail.avt_qlf', 'course_avt_detail.avt_prg_lvl', 'course_avt_detail.avt_prg_recog'])->where('code', $id)->first();
        // dd($course->toArray());

        $anzsco = AvtAnzscoIdentifier::orderBy('description', 'ASC')->get();
        $prgLvl = AvtPrgLvlOfEducIdentifier::orderBy('description', 'ASC')->get();
        $prgRecog = AvtPrgRecogIdentifier::orderBy('description', 'ASC')->get();
        $qlf = AvtQlfFieldOfEducIdentifier::orderBy('description', 'ASC')->get();

        $data = [
            'course' => $course,
            'anzsco' => $anzsco,
            'prgRecog' => $prgRecog,
            'Qlf' => $qlf,
            'prgLvl' => $prgLvl
        ];

        return json_encode($data);
    }

    public function course_info_update(Request $request, $id)
    {

        $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
        ]);


        // dd($request->all());

        try {
            // start db transaction
            DB::beginTransaction();
            $course = Course::with(['course_avt_detail'])->where('id', $request->id)->first();
            // dd($course);
            $oldcourse = $course->code;
            $course->code = $request->code;
            $course->name = $request->name;
            $course->target_enrolee = $request->target_enrolee;
            $course->is_active = $request->is_active;
            $course->is_uc = isset($request->is_uc) && in_array($request->is_uc, [true, 1]) ? 1 : 0;
            $course->update();
            $this->update_relations($request->code, $oldcourse);
            // $course->update([
            //     $course->code => $request->code,
            //     $course->name => $request->name,
            //     $course->target_enrolee => $request->target_enrolee,
            //     $course->is_active => $request->is_active
            // ]);


            $courseAvtDet = CourseAvtDetail::updateOrCreate(
                [
                    'course_code' => $oldcourse
                ],
                [
                    'course_code' => $request->code,
                    'nominal_hours' => $request->nominal_hours,
                    'prg_recog_identifier_id' => $request->slct_prgRecog,
                    'prg_lvl_of_educ_identifier_id' => $request->slct_prgLvl,
                    'qlf_field_of_educ_identifier_id' => $request->slct_qlf,
                    'anzsco_identifier_id' => $request->slct_anzsco,
                    'vet_flag_status' => $request->vet_flag_status ? 1 : 0
                ]
            );

            $courseAvtDet->course_id = $course->id;
            $courseAvtDet->update();

            DB::commit();

            // return to index on success
            return json_encode(['data' => $request->all(), 'status' => 'updated']);
        } catch (\Exception $e) {
            // rollback db transactions
            DB::rollBack();
            throw $e;
            // return to previous page with errors
            // return json_encode(['message' => $e->getMessage(), 'status' => 'error']);
        }
    }

    public function update_relations($newcode, $oldcode)
    {
        // dump($oldcode);
        // dd($newcode);
        $fundedStudentCourses = FundedStudentCourse::where('course_code', $oldcode)->get();
        foreach ($fundedStudentCourses as $student) {
            try {
                DB::beginTransaction();
                FundedStudentCourse::where('id', $student->id)->update(['course_code' => $newcode]);
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }
        }

        $prospectuses = CourseProspectus::where('course_code', $oldcode)->get();
        foreach ($prospectuses as $prospectus) {
            $prospectus->course_code = $newcode;
            $prospectus->update();
        }

        $completions = StudentCompletion::where('course_code', $oldcode)->get();
        foreach ($completions as $completion) {
            $completion->course_code = $newcode;
            $completion->update();
        }

        // update course matrix
        $matrix = CourseMatrix::where('course_code', $oldcode)->get();
        foreach ($matrix as $item) {
            $item->course_code = $newcode;
            $item->update();
        }

        // update course attachment
        $attachment = CourseAttachment::where('course_code', $oldcode)->get();
        foreach ($attachment as $item) {
            $item->course_code = $newcode;
            $item->update();
        }
    }


    /* Course Matrix Controller Resource */
    // Course Matrix Store Update Function
    public function course_matrix_store_update(Request $request)
    {
        $course_code = $request->course_code;
        if (!isset($request->is_update)) {
            $this->validate($request, [
                'cricos_code' => 'required',
                // 'wk_duration' => 'required',
                // 'wk_duration_package' => 'required',
                'location' => [
                    'required',
                    Rule::unique('course_matrices')->where(function ($query) use ($course_code) {
                        $query->where('course_code', $course_code);
                        $query->where('deleted_at', null);
                    })
                ]
            ]);
        } else {
            $this->validate($request, [
                'cricos_code' => 'required',
                // 'wk_duration' => 'required',
                // 'wk_duration_package' => 'required',
                'location' => [
                    'required',
                ]
            ]);
        }


        CourseMatrix::updateOrCreate(
            [
                'course_code' => $request->course_code,
                'location' => $request->location
            ],
            [
                'course_code' => $request->course_code,
                'cricos_code' => $request->cricos_code,
                'wk_duration' => $request->wk_duration,
                'training_hours_weekly' => $request->training_hours_weekly,
                'wk_duration_package' => $request->wk_duration_package,
                'location' => $request->location,
                'material_fees' => $request->material_fees,
                'enrolment_fee' => $request->enrolment_fee,
                'concessional_fee' => $request->concessional_fee,
                'non_concessional_fee' => $request->non_concessional_fee,
                // Onshore
                'onshore_tuition_individual' => $request->onshore_tuition_individual,
                'onshore_tuition_package' => $request->onshore_tuition_package,
                // Offshore
                'offshore_tuition_individual' => $request->offshore_tuition_individual,
                'offshore_tuition_package' => $request->offshore_tuition_package,
                'tuition_fee_per_week' => $request->tuition_fee_per_week,
            ]
        );
    }
    // Course Matrix Delete Function
    public function course_matrix_destroy($id)
    {
        $getmatrix = CourseMatrix::find($id);
        $getmatrix->delete();
    }


    /* Course Prospectus Controller Resource */
    // Course Prospectus List
    public function course_prospectus_list($code)
    {
        $courseProspectus = CourseProspectus::where('course_code', $code)->get();
        // dd($courseProspectus);
        $cpArr = [];
        $num = 0;
        foreach ($courseProspectus as $k => $cp) {
            // dd($cp->course_units);
            // $course_subjects = json_decode($cp->course_units);
            // dd($course_subjects);
            $cpArr[] = [
                'id' => $cp->id,
                'course_code' => $cp->course_code,
                'name' => $cp->name,
                'date_implemented' => Carbon::parse($cp->date_implemented)->format('Y-m-d'),
                'location' => $cp->location,
                'course_units' => $cp->unit_selected,
                'is_active' => $cp->is_active,
            ];
        }

        return ($cpArr);
    }

    public function course_prospectus_info($id)
    {

        $course_prospectus = CourseProspectus::where('id', $id)->first();
        $course_subjects = json_decode($course_prospectus->course_units);
        
        $unitArr = [];
        if ($course_subjects != null) {
            foreach ($course_subjects as $key => $cs) {
                $courseUnits = Unit::select(['code', 'description', 'unit_type', 'course_code'])->where('code', $cs->code)->orderBy('id', 'DESC')->get();
                // dd($courseUnits);
                foreach ($courseUnits as $k => $v) {
                    if($v->course_code != null){
                        if(in_array($course_prospectus->course_code, $v->course_code)){
                            $unitArr[] = [
                                'code' => $v->code,
                                'description' => $v->description,
                                'unit_type' => $v->unit_type,
                            ];
                        }
                    }
                }
            }
        }

        $locations = explode(',', $course_prospectus->location);
        $arr_state_val = [];
        foreach ($locations as $key => $loc) {
            $state_val = AvtStateIdentifier::where('state_key', $loc)->first();

            $arr_state_val[] = [
                'state_key'     => $state_val->state_key,
                'state_name'    => $state_val->state_name . ' ' . '(' . $state_val->state_key . ')'
            ];
        }

        $arr_details = [];
        $arr_details = [
            "id"                    => $course_prospectus->id,
            "course_code"           => $course_prospectus->course_code,
            "name"                  => $course_prospectus->name,
            "date_implemented"      => Carbon::parse($course_prospectus->date_implemented)->format('Y-m-d'),
            "location"              => $arr_state_val,
            "train_org_dlvr_loc_id" => $course_prospectus->train_org_dlvr_loc_id,
            "course_units"          => $unitArr,
            'is_active'             => $course_prospectus->is_active,
        ];

        return $arr_details;
    }

    // Course Prospectus Store Update Function
    public function course_prospectus_store_update(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'location' => 'required',
            'course_units' => 'required',
        ]);

        $locations = [];
        foreach ($request->location as $key => $value) {
            array_push($locations, $value['state_key']);
        }
        $locations = implode(',', $locations);


        $units = [];
        foreach ($request->course_units as $key => $value) {
            $units[] = [
                'code' => $value['code'],
                'train_org_dlvr_loc_id' => $request->train_org_dlvr_loc_id
            ];
        }
        $units = json_encode($units);

        CourseProspectus::updateOrCreate(
            [
                'id' => isset($request->id) ? $request->id : null,
            ],
            [
                'course_code'           => $request->course_code,
                'name'                  => $request->name,
                'date_implemented'      => Carbon::now()->format('Y-m-d'),
                'location'              => $locations,
                'train_org_dlvr_loc_id' => $request->train_org_dlvr_loc_id,
                'course_units'          => $units,
                'is_active'             => $request->is_active ? 1 : 0
            ]
        );
    }

    // Course Prospectus Store Update Function
    public function course_prospectus_destroy($id)
    {
        $getprospectus = CourseProspectus::find($id);
        $getprospectus->delete();
    }


    /* FUNDED Course Matrix Controller Resource */
    // FUNDED Course Matrix Store Update Function
    public function funded_course_matrix_store_update(Request $request)
    {
        // dd($request);
        $course_code = $request->course_code;
        if (!isset($request->is_update)) {
            $this->validate($request, [
                'location' => [
                    'required',
                    // Rule::unique('course_matrices')->where(function ($query) use ($course_code) {
                    //     $query->where('course_code', $course_code);
                    // })
                ]
            ]);
        } else {
            $this->validate($request, [
                'location' => [
                    'required',
                ]
            ]);
        }


        FundedCourseMatrices::updateOrCreate(
            [
                'course_code'   => $request->course_code,
                'location'      => $request->location
            ],
            [
                'course_code'   => $request->course_code,
                'location'      => $request->location,
                'concessional_fee' => $request->concessional_fee,
                'non_concessional_fee' => $request->non_concessional_fee,
                'full_fee'      => $request->full_fee,
                'min_payment'   => $request->min_payment,
            ]
        );
    }
    // FUNDED Course Matrix Delete Function
    public function funded_course_matrix_destroy($id)
    {

        $matrix_id = FundedCourseMatrices::find($id);
        if ($matrix_id != null) {
            $matrix_id->delete();
            return json_encode(['id' => $id, 'status' => 'success']);
        }
    }

    public function get_training_dlvr_loc($state)
    {

        $state_info = AvtStateIdentifier::where('state_key', $state)->first();
        $training_dlvr_loc_list = TrainingDeliveryLoc::where('state_id', $state_info->value)->get();
        $training_dlvr_loc_list = $training_dlvr_loc_list->pluck('addr_location', 'id');

        if (count($training_dlvr_loc_list) > 0) {
            $data = $training_dlvr_loc_list;
        } else {
            $data = null;
        }
        // dd($data);
        return $data;
    }

    public function course_option_list($query)
    {
        return QualificationClassification::where('qual_title', 'like', '%' . $query . '%')->orWhere('qual_code', 'like', '%' . $query . '%')->limit(500)->get();
    }
}
