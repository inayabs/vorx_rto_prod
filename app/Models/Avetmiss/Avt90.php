<?php

namespace App\Models\Avetmiss;

use App\Models\StudentCompletion;
use Illuminate\Database\Eloquent\Model;
use DB;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Avt90 extends Model implements AuditableContract
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

    protected $table = 'avt_90_client_disablility';

    protected $fillable = [
     	'client_identifier',
     	'disability_type',
     	'avt_process_id',
      'error_code',
    ];

    // public function get_data_avt90($dateFrom,$dateTo, $reportTo)
    public function get_data_avt90($studCom)
    {
      // $sc = new StudentCompletion;
      // $studCom = $sc->avetmiss_compliant($dateFrom, $dateTo, $reportTo);
      $data = [];
      foreach($studCom as $val){
        if(isset($val->student->funded_detail->disability_flag) && $val->student->funded_detail->disability_flag == 'Y'){
          $disabilities = explode(',', $val->student->funded_detail->disability_ids);
          foreach($disabilities as $v){
            $data[] = [
              'client_id' => $val->student_id,
              'disability_type' => $v,
            ];
          }
        }
      }
      // dd($data);
      return $data;
    }
    
}
