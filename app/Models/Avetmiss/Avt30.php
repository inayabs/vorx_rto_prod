<?php

namespace App\Models\Avetmiss;

use Illuminate\Database\Eloquent\Model;
use DB;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\Course;
use App\Models\StudentCompletion;

class Avt30 extends Model implements AuditableContract
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

    protected $table = 'avt_30_program_file';

    protected $fillable = [
     	'program_id',
     	'program_name',
        'nominal_hours',
        'prg_recog_identifier',
        'prg_educ_lvl_identifier',
        'prg_educ_fld_identifier',
        'anzsco_identifier',
        'vet_flag',
        'error_code',
        'avt_process_id'
    ];

    // public function get_data_avt30($dateFrom,$dateTo, $reportTo)
    public function get_data_avt30($studCom)
     {
        // $sc = new StudentCompletion;

        // $studCom = $sc->avetmiss_compliant($dateFrom, $dateTo, $reportTo);
        
        $data = [];

        // dump($studCom->count());

        foreach($studCom as $val){
            // dump($val->course_code);
            foreach($val->student_course as $v){
                if($v->course_code == $val->course_code){
                    if(!in_array($v->course_code, ['@@@@', '1111'])){
                        $data[$v->course_code] = $v->course->toArray();
                        $data[$v->course_code]['course_avt_detail'] = $v->course->course_avt_detail->toArray();
                    }
                }
            }
        }
        // dd($data);
        return $data;


        // return Course::with(['course_avt_detail'])->whereHas('student_completion_checker', function($q) use($dateFrom, $dateTo){
        //     $q->where('partial_completion', 1);
        //     $q->orWhere('completion_status_id', 3);
        //     $q->whereHas('student', function($qq) use($dateFrom, $dateTo){
        //         $qq->where('student_type_id', 2);
        //         $qq->whereHas('funded_course', function($qqq) use($dateFrom, $dateTo){
        //             $qqq->where('start_date', '>=', $dateFrom);
        //         });
        //     });
        // })->get()->toArray();
        
    }
    
}
