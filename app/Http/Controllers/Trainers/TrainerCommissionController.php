<?php

namespace App\Http\Controllers\Trainers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use \DB;
use App\Models\Trainer;
use App\Models\User;
use App\Models\Course;
use App\Models\TrainerCommissionSetting;
use Illuminate\Validation\Rule;
use App\Http\Resources\ComSettingResource;
use Validator;

class TrainerCommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('trainer.commission-setting.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $comset = TrainerCommissionSetting::with(['trainer'])->where('trainer_id', $id)->first();

        // COURSE TAUGHT LIST
        $trainer = Trainer::where('id', $id)->first();
        $ct = $trainer->course_taught;
        $ct_list = [];

        if($ct != null){
            $course_taught = explode(',',$ct);
            foreach ($course_taught as $key => $value) {
                $ct_list[] = [
                    'id'   => Course::where('code', $value)->first()['id'],
                    'code' => $value,
                    'name' => $value.' '.'-'.' '.Course::where('code', $value)->first()['name'] 
                ];
            }
            $count_ct_list = count($ct_list);
            if($count_ct_list != 0){
                $ct = $ct_list;
            }
        }

        // TRAINER COLLAB
        $trainer_collab = Trainer::where('id', '!=', $id)->get();
        $tc_arr = [];

        foreach($trainer_collab as $key => $tc){
            $code = explode(',',$tc->course_taught);
            // Check course codes to other trainer 
            $checkCode = array_intersect($course_taught,$code);
            if($checkCode == true){
                // dd('with the same course codes');
                $tc_arr[] = [
                    'trainer_id' => $tc->id,
                    'name' => $tc->firstname.' '.$tc->lastname,
                    'intersect_course_taught' => implode(',',$checkCode)
                ];
            }
        }

        $data = [
            'trainer_id' => $id,
            'slct_courses'  => $ct,
            'slct_trainer_collab' => $tc_arr, 
            'slct_comtype' => TrainerCommissionSetting::getEnumColumnValues(),
        ];

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
        //
        
        $trainer = Trainer::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            'course_codes'          => 'required',
            'student_quota'         => 'required',
            // 'trainer_collab'        => 'required',
            'commission_type_id'    => 'required',
            'commission_value'      => 'required'
            
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'errors', 'errors' => $validator->messages()]);
        }

        try {
            // start db transaction
            DB::beginTransaction();

            $cc = $request->course_codes;
            if($cc != null){
                $cc = array_column($cc, 'code');
                $cc = implode(', ', $cc);
            }
            $tc = $request->trainer_collab;
            if($tc != null){
                $tc = array_column($tc, 'trainer_id');
                $tc = implode(', ', $tc);
            }

            $comset = new TrainerCommissionSetting;

            $comset->fill([
                'user_id'               => $trainer->user_id,
                'trainer_id'            => $id,
                'course_codes'          => $cc,
                'student_quota'         => $request->student_quota,
                'trainer_collab'        => $tc,
                'commission_type_id'    => implode(',', $request->commission_type_id),
                'commission_value'      => $request->commission_value
            ]);
            $comset->save();

            DB::commit();

            // return response()->json(['data'=>$request->all(), 'status' => 'success']);
            // return response()->json(['success'=>'Done!']);
            return json_encode(['data'=>$request->all(), 'status' => 'success']);
        } catch (\Exception $e) {
            // rollback db transactions
            DB::rollBack();
            
            // return to previous page with errors
            return  response()->json(['message' => $e->getMessage(), 'status' => 'error']);
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
        \JavaScript::put([
            'trainer_id' => $id
        ]);

        return view('trainer.commission-setting.index');
    }
    


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $comset_id)
    {
        $data = [
            'trainer_id' => $id,
            'comset_id' => $comset_id,
        ];
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $comset_id)
    {
        //
        // dump($request->all());
        try {
            DB::beginTransaction();
            $cc = $request->course_codes;
            if($cc != null){
                $cc = array_column($cc, 'code');
                $cc = implode(',',$cc);
            }
            $tc = $request->trainer_collab;
            if($tc != null){
                $tc = array_column($tc, 'trainer_id');
                $tc = implode(',',$tc);
            }
            $com_type = $request->commission_type_id;
            if($com_type != null){
                $com_type = array_column($com_type, 'type');
                $com_type = implode(',',$com_type);
            }

            $trainer_cs = TrainerCommissionSetting::where('id', $comset_id)->first();
            $trainer_cs->update([
                'trainer_id'            => $id,
                'course_codes'          => $cc,
                'student_quota'         => $request->student_quota,
                'trainer_collab'       => $tc,
                'commission_type_id'    => $com_type,
                'commission_value'      => $request->commission_value
            ]);

            DB::commit();

            // return to users index page
            return json_encode(['data'=>$request->all(), 'status' => 'updated']);
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();
            exit();

            // return to previous page with errors
            return json_encode(['message'=>$e->getMessage(), 'status' => 'error']);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $comset_id)
    {
        //
        $trainer_cs = TrainerCommissionSetting::find($comset_id);
        if ($trainer_cs != null) {
            $trainer_cs->delete();
            return json_encode(['id'=>$trainer_cs, 'status' => 'success']);
        }
    }



    public function comset_list($id){
        // Commission Settings LIST
        $trainer = Trainer::where('id', $id)->first();
        $com_set = TrainerCommissionSetting::with(['trainer'])->where('trainer_id', $id)->orderBy('id', 'desc')->get();

        $comsetList = [];
        if(count($com_set) > 0){
            foreach($com_set as $cs){

                $cs_id = $cs->id;
                $trainer_collabs = $cs->trainer_collabs;
                $tc = [];

                if(count($trainer_collabs) > 0){
                    foreach($trainer_collabs as $collab){
                        $tc[] = [
                            'name' => $collab->firstname.' '.$collab->lastname
                        ];
                    } 
                    $tc = array_column($tc, 'name');
                    $tc = implode(',',$tc);
                }else{
                    $tc = 'N/A';
                }
                
                $courses = $cs->courses;
                $comsetList[] = [
                    'id'                => $cs->id,
                    'course_codes'      => $cs->course_codes,
                    'student_quota'     => $cs->student_quota,
                    'trainer_collab'    => $tc,
                    'commission_value'  => $cs->commission_type_id.''.$cs->commission_value
                ];
            }
        }
        
        $data = [
            'trainerInfo' => $trainer,
            'comsetList' => $comsetList,
        ];

        return $data;
    }


    public function comset_info($id, $comset_id){
        // Commission Settings INFO
        $trainer_cs = TrainerCommissionSetting::with(['trainer'])->where('id', $comset_id)->first();
        $cc = $trainer_cs->course_codes;
        $cc_list = [];
        
        if($cc != null){
            $course_codes = explode(',',$cc);
            foreach ($course_codes as $key => $value) {
                $cc_list[] = [
                    'id'   => Course::where('code', $value)->first()['id'],
                    'code' => $value,
                    'name' => $value.' '.'-'.' '.Course::where('code', $value)->first()['name'] 
                ];
            }
            $count_cc_list = count($cc_list);
            if($count_cc_list != 0){
                $cc = $cc_list;
            }
        }

        // COURSE TAUGHT LIST
        $trainer = Trainer::where('id', $id)->first();
        $ct = $trainer->course_taught;
        $ct_list = [];
        
        if($ct != null){
            $course_taught = explode(',',$ct);
            foreach ($course_taught as $key => $value) {
                $ct_list[] = [
                    'id'   => Course::where('code', $value)->first()['id'],
                    'code' => $value,
                    'name' => $value.' '.'-'.' '.Course::where('code', $value)->first()['name'] 
                ];
            }
            $count_ct_list = count($ct_list);
            if($count_ct_list != 0){
                $ct = $ct_list;
            }
        }

        // TRAINER COLLAB LIST
        $trainer_collab = Trainer::where('id', '!=', $id)->get();
        $tc_arr = [];
        // dump($trainer_collab);
        foreach($trainer_collab as $key => $tc){
            $code = explode(',',$tc->course_taught);
            // Check course codes to other trainer 
            $checkCode = array_intersect($course_taught,$code);
            if($checkCode == true){
                // dd('with the same course codes');
                $tc_arr[] = [
                    'trainer_id' => $tc->id,
                    'name' => $tc->firstname.' '.$tc->lastname,
                    'intersect_course_taught' => implode(',',$checkCode)
                ];
            }
        }

        // TRAINER COLLAB VALUE
        $trainer_collab_val = $trainer_cs->trainer_collabs;
        $tcv_arr = [];
        foreach($trainer_collab_val as $key =>$tcv){
            $tcv_arr[] = [
                'trainer_id' => $tcv->id,
                'name' => $tcv->firstname.' '.$tcv->lastname,
            ];
        }

        // Commission Mode
        $com_type = TrainerCommissionSetting::getEnumColumnValues();
        $com_type_val = [];
        $com_type_val[] = ['type' => $trainer_cs->commission_type_id];

        $data = [
            'comset_info' => $trainer_cs,
            'slct_course_codes' => $ct_list, 
            'course_codes' => $cc_list,
            'slct_trainer_collab' => $tc_arr,
            'trainer_collab' => $tcv_arr,
            'slct_com_type' => $com_type,
            'commission_type_id' => $com_type_val,
        ];
        return $data;
    }
}
