<?php

namespace App\Http\Controllers\Program;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Course;
use App\Models\AvtAssessmentMethod;
use App\Models\AvtUnitEducationField;
use App\Models\AvtTrainingMethod;
use App\Models\QualificationClassification;
use App\Models\UnitClassification;

use Validator;
use Auth;
use DB;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // public function __construct() {
    //     $this->middleware('auth');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $am = AvtAssessmentMethod::all();
        $unit_educ_field = AvtUnitEducationField::orderBy('description', 'ASC')->get();
        $training_methods = AvtTrainingMethod::all();

        \JavaScript::put([
            'unit_field_educ' => $unit_educ_field,
            'training_methods' => $training_methods,
            'assessment_method' => $am
        ]);
        return view('program.unit.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // $am = AvtAssessmentMethod::all();
        // $unit_educ_field = AvtUnitEducationField::orderBy('description', 'ASC')->get();
        // $training_methods = AvtTrainingMethod::all();

        // \JavaScript::put([
        //     'unit_field_educ' => $unit_educ_field,
        //     'training_methods' => $training_methods,
        //     'assessment_method' => $am
        // ]);
        // return view('program.unit.create');
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

        if(isset($request->unit['unit_details']['id'])){
            // dd($request->unit['unit_details']);
            return $this->course_unit_update($request, $request->unit['unit_details']['id']);
        }
        //
        // dd($request->all());
        $this->validate($request, [
            'unit' => 'required',
            // 'unit_type' => 'required',
            // 'assessment_method' => 'required'
        ]);

        try {

            DB::beginTransaction();    

            $am = [];
            if(isset($request->assessment_method)){
                foreach ($request->assessment_method as $key => $value) {
                    array_push($am, $value['id']);
                }
            }
            $am = count($am) > 0 ? implode(',', $am) : null;
            
            // for course_code
            $cc = [];
            if(isset($request->course_code)){
                $u = Unit::where('code', $request->unit['unit_code'])->first();
                $cc =  isset($u->course_code)  && count($u->course_code) > 0 ? $u->course_code : [];
                if(!in_array($request->course_code, $cc)){
                    $cc = array_merge($cc, [$request->course_code]);
                }
                // dd($cc);
            }

            $unit = new unit();
            
            $data = [
                'tp_code' => isset($request->unit['tp_code']) ? $request->unit['tp_code'] : null,
                'code' => $request->unit['unit_code'],
                'description' => $request->unit['unit_title'],
                'unit_type' => isset($request->unit_type) ? $request->unit_type : null,
                'assessment_method' => $am,
                'subject_educ_fld_identifier_id' => $request->subject_educ_fld_identifier_id,
                'nominal_hours' => $request->nominal_hours,
                'scheduled_hours' => isset($request->scheduled_hours) ? $request->scheduled_hours : null,
                'training_method_id' => $request->training_method_id,
                'vet_flag' => $request->vet_flag == 1 ? $request->vet_flag : 0,
                'extra_unit' => $request->extra_unit == 1 ? $request->extra_unit : 0,
                'active' => $request->active == 1 ? $request->active : 0,
                'course_code' => $cc,
            ];
            $unit->fill($data);
            $unit->user()->associate(\Auth::user());
            $unit->save();

            $request->request->add(['status' => 'success']);
            
            DB::commit();
            
            return response()->json($request->all());
            

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
        $am = AvtAssessmentMethod::all();
        $unit_educ_field = AvtUnitEducationField::orderBy('description', 'ASC')->get();
        $training_methods = AvtTrainingMethod::all();
        $unitEdit = unit::find($id);
        $am_selected = AvtAssessmentMethod::whereIn('id', explode(',', $unitEdit->assessment_method))->get();
        \JavaScript::put([
            'unit_field_educ' => $unit_educ_field,
            'training_methods' => $training_methods,
            'assessment_method' => $am,
            'am_selected' => $am_selected,
            'post_id' => $id,
            'post_details' => $unitEdit
        ]);

        return view('program.unit.edit', compact('unitEdit'), ['unitEdit' => $unitEdit]);
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
        // dd('updates');
        $this->validate($request, [
            'code' => 'required',
            'description' => 'required',
            'unit_type' => 'required',
            'assessment_method' => 'required'
        ]);

        $am = [];
        foreach ($request->assessment_method as $key => $value) {
            array_push($am, $value['id']);
        }
        $am = implode(',', $am);

        // for course_code
        $cc = [];
        if(isset($request->unit['course_code'])){
            $u = Unit::where('code', $request->unit['unit_code'])->first();
            $cc =  isset($u->course_code)  && count($u->course_code) > 0 ? $u->course_code : [];
            $cc = array_merge($cc, [$request->unit['course_code']]);
        }

        $unit = unit::find($id);
        $unit->code = $request->code;
        $unit->description = $request->description;
        $unit->unit_type = $request->unit_type;
        $unit->assessment_method = $am;
        $unit->subject_educ_fld_identifier_id = $request->subject_educ_fld_identifier_id;
        $unit->nominal_hours = $request->nominal_hours;
        $unit->training_method_id = $request->training_method_id;
        $unit->vet_flag = $request->vet_flag == 1 ? $request->vet_flag : 0;
        $unit->extra_unit = $request->extra_unit == 1 ? $request->extra_unit : 0;
        $unit->active = $request->active == 1 ? 1 : 0;
        $unit->course_code = $cc;
        $unit->update();
    }

    public function course_unit_update(Request $request, $id)
    {
        //
        
        // dd($request->active);
        // $request->request->add($request->unit);
        $this->validate($request, [
            'unit.unit_code' => 'required',
            'unit.unit_title' => 'required',
            'unit.unit_type' => 'required',
        ]);
        // dd($request->unit);
        try {

            DB::beginTransaction();

            $am = [];
            if(isset($request->assessment_method)){
                foreach ($request->assessment_method as $key => $value) {
                    array_push($am, $value['id']);
                }
            }
            $am = count($am) > 0 ? implode(',', $am) : null;

            // for course_code
            $cc = [];
            if(isset($request->course_code)){
                $u = Unit::where('code', $request->unit['unit_code'])->first();
                $cc =  isset($u->course_code)  && count($u->course_code) > 0 ? $u->course_code : [];
                if(!in_array($request->course_code, $cc)){
                    $cc = array_merge($cc, [$request->course_code]);
                }
            }

            $unit = unit::find($id);
            
            $data = [
                'tp_code' => isset($request->unit['tp_code']) ? $request->unit['tp_code'] : null,
                // 'code' => $request->unit['used_by_student'] == 0 ? $request->unit['unit_code'] : $unit->code,
                // 'description' => $request->unit['used_by_student'] == 0 ? $request->unit['unit_title'] : $unit->description,
                'unit_type' => $request->unit_type,
                'assessment_method' => $am,
                'subject_educ_fld_identifier_id' => $request->subject_educ_fld_identifier_id,
                'nominal_hours' => $request->nominal_hours,
                'scheduled_hours' => isset($request->scheduled_hours) ? $request->scheduled_hours : null,
                'training_method_id' => $request->training_method_id,
                'vet_flag' => $request->vet_flag == 1 ? $request->vet_flag : 0,
                'extra_unit' => $request->extra_unit == 1 ? $request->extra_unit : 0,
                'active' => $request->active == 1 ? $request->active : 0,
                'course_code' => $cc,
            ];

            $unit->fill($data);
    
            $unit->update();

            $request->request->add(['status' => 'success']);
            
            DB::commit();
            
            return response()->json($request->all());
            

        } catch (\Throwable $th) {
            DB::rollback();

            throw $th;
        }
    }

    public function course_unit_remove(Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $unit = Unit::where('id', $request->row['id'])->first();
            $ucc = $unit->course_code;
            foreach($unit->course_code as $k => $v){
                if($v == $request->course_code){
                    unset($ucc[$k]);
                    // dd($ucc);
                }
            }
            $unit->course_code = $ucc;
            // dd($unit->course_code);
            $unit->update();
            
            DB::commit();

            return ['status' => 'success'];

        } catch (\Throwable $th) {
            DB::rollback();

            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unit = Unit::find($id);
        $unit->delete();
    }

    public function unitList(Request $request)
    {
        // dd($request->all());
        // if (\Auth::user()->hasRole('Demo')) {
        //     $course_tp_code = Unit::where('user_id', \Auth::user()->id)->groupBy('tp_code')->get()->pluck('tp_code');
        // } else {
        //     $course_tp_code = Unit::groupBy('tp_code')->get()->pluck('tp_code');
        // }

        if ($request->sort) {
            if (isset($request->search) && $request->search != null) {
                // dd($request->all());
                if (\Auth::user()->hasRole('Demo')) {
                    return Unit::select(['id', 'code', 'description', 'unit_type'])
                        ->where('user_id', \Auth::user()->id)
                        ->where('code', 'like', '%' . $request->search . '%')
                        ->orWhere('description', 'like', '%' . $request->search . '%')
                        ->where('user_id', \Auth::user()->id)
                        ->orderBy($request->sort, $request->direction)->paginate($request->limit);
                } else {
                    return Unit::select(['id', 'code', 'description', 'unit_type'])
                        // ->whereIn('user_id', \Auth::user()->id)
                        ->where('code', 'like', '%' . $request->search . '%')
                        ->orWhere('description', 'like', '%' . $request->search . '%')
                        ->orderBy($request->sort, $request->direction)->paginate($request->limit);
                }
            } else {
                if (\Auth::user()->hasRole('Demo')) {
                    return Unit::select(['id', 'code', 'description', 'unit_type'])->where('user_id', \Auth::user()->id)->orderBy($request->sort, $request->direction)->paginate($request->limit);
                } else {
                    return Unit::select(['id', 'code', 'description', 'unit_type'])->orderBy($request->sort, $request->direction)->paginate($request->limit);
                }
            }
        } else {
            if (\Auth::user()->hasRole('Demo')) {
                return Unit::select(['id', 'code', 'description', 'unit_type'])->where('user_id', \Auth::user()->id)->orderBy('created_at', 'DESC')->paginate($request->limit);
            } else {
                return Unit::select(['id', 'code', 'description', 'unit_type'])->orderBy('created_at', 'DESC')->paginate($request->limit);
            }
        }
    }

    public function addUnitList($query)
    {
        if (\Auth::user()->hasRole('Demo')) {
            $course_tp_code = Course::where('user_id', \Auth::user()->id)->groupBy('tp_code')->get()->pluck('tp_code');
        } else {
            $course_tp_code = Course::groupBy('tp_code')->get()->pluck('tp_code');
        }

        return UnitClassification::select(['tp_code', 'unit_code', 'unit_title'])->whereIn('tp_code', $course_tp_code->toArray())
            ->where('unit_code', 'LIKE', '%' . $query . '%')
            ->orWhere('unit_title', 'LIKE', '%' . $query . '%')
            ->limit(1000)
            ->get();
    }

    public function unit_option_list($search)
    {
        // dd($search);
        // $units = Unit::orderBy('code', 'asc')->get();
        if (\Auth::user()->hasRole('Demo')) {
            $units = Unit::where('code', 'like', '%' . $search . '%')->where('user_id', \Auth::user()->id)->orWhere('description', 'LIKE', '%' . $search . '%')->where('user_id', \Auth::user()->id)->get();
        } else {
            $units = Unit::where('code', 'like', '%' . $search . '%')->orWhere('description', 'LIKE', '%' . $search . '%')->get();
        }
        $unitArr = [];
        if($units){
            foreach ($units as $k => $v) {
                $unitArr[] = [
                    'subject_code' => $v->code,
                    'description' => $v->description,
                    'dates' => ['start' => null, 'end' => null],
                    'unit_details' => $v->toArray()
                    // 'unit_type' => $v->unit_type,
                ];
            }
        }else{
            $unitArr[] = ['subject_code' => $search, 'description' => '',];
        }
        // dd($unitArr);
        return $unitArr;
    }

    public function course_unit_option_list($search, $course_code)
    {
        // dd($search);
        // $units = Unit::orderBy('code', 'asc')->get();
        if (\Auth::user()->hasRole('Demo')) {
            $units = Unit::where('code', 'like', '%' . $search . '%')->where('user_id', \Auth::user()->id)->orWhere('description', 'LIKE', '%' . $search . '%')->where('user_id', \Auth::user()->id)->get();
        } else {
            $units = Unit::where('code', 'like', '%' . $search . '%')->orWhere('description', 'LIKE', '%' . $search . '%')->get();
        }
        $unitArr = [];
        if($units){
            foreach ($units as $k => $v) {
                if(in_array($course_code, $v->course_code)){
                    $unitArr[] = $v->toArray();
                }
            }
        }else{
            $unitArr[] = ['code' => $search, 'description' => '',];
        }
        // dd($unitArr);
        return $unitArr;
    }

    public function course_unit_show($course_code)
    {

        // dd($course_code);
        $am = AvtAssessmentMethod::all();
        $unit_educ_field = AvtUnitEducationField::orderBy('description', 'ASC')->get();
        $training_methods = AvtTrainingMethod::all();
        $units = Unit::where('course_code', '<>', '[]')->get();
        // $units = Unit::all();
        $u = [];

        foreach($units as $k => $v)
        {   
            if(in_array($course_code, $v->course_code)){
                $item = $v->toArray();
                $item['used_by_student'] = $v->used_by_student;
                // $item->push(['used_by_student' => $v->used_by_student]);
                // dd($item);
                $u[] = $item;
            }
        }
        // dd($u);
        // $unitEdit = unit::find($id);
        // $am_selected = AvtAssessmentMethod::whereIn('id', explode(',', $unitEdit->assessment_method))->get();

        return [
            'unit_field_educ' => $unit_educ_field,
            'training_methods' => $training_methods,
            'assessment_method' => $am,
            'course_units' => $u,
            // 'am_selected' => $am_selected,
            // 'post_id' => $id,
            // 'post_details' => $unitEdit
        ];
    }
}
