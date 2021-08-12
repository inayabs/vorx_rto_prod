<?php

namespace App\Http\Controllers\Holidays;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

use App\Models\Holiday;
use App\Models\AvtStateIdentifier;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $slct_state = AvtStateIdentifier::whereIn('id', [1,2,3,4,5,6,7,8])->orderBy('state_name')->get();
        $arr_slct_state = [];
        foreach ($slct_state as $key => $x) {
            $arr_slct_state[] = [
                'id'          => $x->state_key,
                'value'       => $x->state_name
            ];
        }
        \JavaScript::put([
            'slct_state' => $arr_slct_state,
        ]);
        return view('holidays.index');
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
        $request = $request->inputs;
        $validator = Validator::make($request, [
            'name' => 'required',
            'month' => 'required',
            // 'day' => 'required',
            'type' => 'required',
            'location' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'errors', 'errors' => $validator->messages()]);
        }
        if(isset($request['id'])){
            try {
                DB::beginTransaction();
    
                $holiday = Holiday::where('id', $request['id'])->first();
                $holiday->update([
                    'name'      => $request['name'],
                    'month'     => $request['month'],
                    'day'       => $request['day'],
                    'type'      => $request['type'],
                    'weekday'   => $request['weekday'],
                    'week'      => $request['week'],
                    'location'  => json_encode($request['location']),
                ]);
                DB::commit();
    
                return json_encode(['data' => $request, 'status' => 'success']);
            } catch (\Throwable $e) {
                DB::rollback();
                return  response()->json(['message' => $e->getMessage(), 'status' => 'errors']);
                // throw $th;
            }
        }else{
            try {
                DB::beginTransaction();
    
                $holiday = new Holiday;
                $holiday->fill([
                    'name'      => $request['name'],
                    'month'     => $request['month'],
                    'day'       => $request['day'],
                    'type'      => $request['type'],
                    'weekday'   => $request['weekday'],
                    'week'      => $request['week'],
                    'location'  => json_encode($request['location']),
                ]);
                $holiday->save(); 
                DB::commit();
    
                return json_encode(['data' => $request, 'status' => 'success']);
            } catch (\Throwable $e) {
                DB::rollback();
                return  response()->json(['message' => $e->getMessage(), 'status' => 'errors']);
                // throw $th;
            }
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
        $holi = Holiday::find($id);
        if ($holi != null) {
            $holi->delete();
            return json_encode(['id' => $id, 'status' => 'success']);
        }
    }

    public function holiday_info($id){
        $holi = Holiday::where('id', $id)->first();
        $holiday = [
            'id'        => $holi->id,
            'name'      => $holi->name,
            'day'       => $holi->day,
            'month'     => $holi->month,
            'type'      => $holi->type,
            'weekday'   => $holi->weekday,
            'week'      => $holi->week,
            'location'  => json_decode($holi->location, true),
        ]; 
        return $holiday;

    }

    public function holiday_list(){

        $holidays = Holiday::orderBy('month', 'asc')->get();
        $arr_holidays = [];
       
        foreach($holidays as $value){
            $loc = json_decode($value->location, true);
            $arr_loc = [];
            if(isset($loc)){
                foreach ($loc as $key => $x) {
                    array_push($arr_loc, $x['id']);
                }
            }
            $arr_loc = count($arr_loc) > 0 ? implode(', ', $arr_loc) : null;
            if(isset($value->type)){
                if($value->type == 'day'){
                    $date = Carbon::createFromFormat('d', $value->day)->format('j'). ' ' .Carbon::createFromFormat('m', $value->month)->format('F');
                }else{
                    $str_month = Carbon::createFromFormat('m', $value->month)->startOfMonth();
                    $weekday = $str_month->nthOfMonth($value->week, $value->weekday);

                    $date = $this->addOrdinalNumberSuffix($value->week). ' ' .$weekday->format('l'). ' '.'in'. ' '.Carbon::createFromFormat('m', $value->month)->format('F');
                }
            }else{
                $date = null;
            }

            $arr_holidays[] = [
                'id'        => $value->id,
                'name'      => $value->name,
                'date'      => $date,
                'location'  => $arr_loc,
            ];
        }

        $data = [
            'holidayList' => $arr_holidays,
        ];
        
        return $data;
    }


    private  function addOrdinalNumberSuffix($num) {
        if (!in_array(($num % 100),array(11,12,13))){
          switch ($num % 10) {
            // Handle 1st, 2nd, 3rd
            case 1:  return $num.'st';
            case 2:  return $num.'nd';
            case 3:  return $num.'rd';
          }
        }
        return $num.'th';
      }
}
