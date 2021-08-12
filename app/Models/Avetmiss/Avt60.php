<?php

namespace App\Models\Avetmiss;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Model;
use DB;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\StudentCompletion;

class Avt60 extends Model implements AuditableContract
{
    use Auditable;

    /**
     * Auditable events.
     *
     * @var array
     */
    protected $auditableEvents = [
        'deleted',
        'restored',
        'updated',
        'created'
    ];

    /**
    * Should the timestamps be audited?
    *
    * @var bool
    */
    protected $auditTimestamps = true;

    //

    protected $table = 'avt_60_subject_file';

    protected $fillable = [
     	'subj_flag',
     	'unit_display_id',
     	'unit_name',
     	'module_field_of_education',
     	'vet_flag',
     	'nominal_hours',
        'avt_process_id',
        'error_code',
    ];

    // public function get_data_avt60($dateFrom,$dateTo, $reportTo)
    public function get_data_avt60($studCom, $dateFrom, $dateTo)
    {   
        // $unit = [];

        // return Unit::all()->toArray();

        // $sc = new StudentCompletion;
        // $studCom = $sc->avetmiss_compliant($dateFrom, $dateTo, $reportTo);

        // dd($studCom);

        $data = [];
        
        foreach($studCom as $val){
            // dump($val->details->toArray());
            foreach($val->details as $v){
                if($dateFrom <= $v->start_date && $dateTo >= $v->end_date && in_array($v->completion_status_id, [3,4,6])){
                    $data[$v->course_unit_code] = $v->unit->toArray();
                    // dump($v);
                }
            }
        }
        // dd($data);
        return $data;

        // return Unit::whereHas('student_completion_detail_checker', function($q) use($dateFrom, $dateTo){
        //     $q->whereIn('completion_status_id', [3,4,6]);
        //     $q->whereHas('completion', function($qq){
        //         $qq->where('partial_completion', 1);
        //         $qq->orWhere('completion_status_id', 3);

        //         $qq->whereHas('student', function($qqq){
        //             $qqq->where('student_type_id', 2);
        //         });
        //     });
        //     $q->where('start_date', '>=', $dateFrom);
        //     $q->where('end_date', '<=', $dateTo);
        // })->get()->toArray();


     }
    
}
