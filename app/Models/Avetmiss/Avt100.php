<?php

namespace App\Models\Avetmiss;

use App\Models\StudentCompletion;
use Illuminate\Database\Eloquent\Model;
use DB;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Avt100 extends Model implements AuditableContract
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

    protected $table = 'avt_100_client_prior_educ';

     protected $fillable = ['client_id', 'prior_education_achievement', 'avt_process_id', 'error_code'];

    //  public function get_data_avt100($dateFrom,$dateTo, $reportTo)
     public function get_data_avt100($studCom)
     {
      // $sc = new StudentCompletion;
      // $studCom = $sc->avetmiss_compliant($dateFrom, $dateTo, $reportTo);

      $data = [];
      $stud = [];
      $p_code = [];
      foreach($studCom as $val){
        // dump($val->student_id);
        if(isset($val->student->funded_detail->prior_educational_achievement_flag) && $val->student->funded_detail->prior_educational_achievement_flag == 'Y'){
          $achievements = explode(',', $val->student->funded_detail->prior_educational_achievement_ids);
          foreach($achievements as $v){
            if(!in_array($val->student_id, $stud) && !in_array($val->student_id, $p_code)){
              $data[] = [
                'client_id' => $val->student_id,
                'prior_education_achievement' => $v,
              ];
              $stud[] = $val->student_id;
              $p_code[] = $v;
            }
          }
        }
      }
      // dd($data);
      return $data;
     }

}
