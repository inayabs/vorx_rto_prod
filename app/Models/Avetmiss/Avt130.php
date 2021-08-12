<?php

namespace App\Models\Avetmiss;

use App\Models\StudentCompletion;
use App\Models\TrainingOrganisation;
use Illuminate\Database\Eloquent\Model;
use DB;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\StudentInfo;

class Avt130 extends Model implements AuditableContract
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

    protected $table = 'avt_130_program_completed_file';

     protected $fillable = [
     	'train_org_identifier',
     	'prg_identifier',
     	'client_identifier',
      'year_prg_completed',
     	'date_prg_completed',
     	'issued_flag',
     	'avt_process_id',
	    'isValid',
	    'user'
     ];

     public function avt80()
     {
        return $this->belongsTo(Avt80::class, 'client_identifier', 'client_identifier');
     }

     public function avt85()
     {
        return $this->belongsTo(Avt85::class, 'client_identifier', 'client_identifier');
     }

     public function avt100()
     {
        return $this->belongsTo(Avt100::class, 'client_identifier', 'client_identifier');
     }

     public function avt90()
     {
        return $this->belongsTo(Avt90::class, 'client_identifier', 'client_identifier');
     }

     public function avt120()
     {
        return $this->hasMany(Avt120::class, 'client_identifier', 'client_identifier');
     }

     public function getFullNameAttribute()
     {
        $usi = str_replace("2019","",$this->client_identifier);
        $data = StudentInfo::where('uniq_stud_identifier', 'like', '%'.$usi.'%')->first();
        return $data->person->lastname .', '. $data->person->firstname;
     }

   //   public function get_data_avt130($dateFrom,$dateTo, $reportTo)
     public function get_data_avt130($studCom)
     {

      $training_org = TrainingOrganisation::first();
        // dd($training_org);
      //   $sc = new StudentCompletion;
      //   $studCom = $sc->avetmiss_compliant($dateFrom, $dateTo, $reportTo);

        $data = [];

        foreach($studCom as $val){
           if($val->completion_status_id == 3){
              $data[$val->id] = $val->toArray();
              $data[$val->id]['certificate'] = isset($val->certificate->id) ? $val->certificate->toArray() : null;
              $data[$val->id]['organisation'] = $training_org->toArray();
           }
        }

         //  dd($data);
        return $data;
        
      //   return collect( json_decode( json_encode( DB::select(DB::raw("SELECT
      //   	   (SELECT `org_identifier` FROM `vrx_organisation_info`) AS train_org_identifier,
      //          CONCAT('2019', vrx_student_info.uniq_stud_identifier) AS client_identifier,
      //          vrx_courses.code prg_identifier,
      //          DATE_FORMAT(`vrx_student_completion_details`.end_date,'%d%m%Y') AS date_prg_completed,
      //          DATE_FORMAT(`vrx_student_completion_details`.end_date,'%Y') AS year_prg_completed,
      //          'Y' AS issued_flag
      //          -- vrx_party.name AS fullname
      //          FROM vrx_student_completion
      //          INNER JOIN vrx_student_completion_details ON vrx_student_completion_details.student_completion_id = vrx_student_completion.id
      //          -- INNER JOIN vrx_users ON (vrx_training_schedule.trainer_id = vrx_users.id)
      //          INNER JOIN vrx_courses ON vrx_courses.code = vrx_student_completion.course_code
      //          -- INNER JOIN vrx_stud_train_sched ON (vrx_training_schedule.id = vrx_stud_train_sched.schedule_id)
      //          -- INNER JOIN vrx_deals ON (vrx_deals.id = vrx_stud_train_sched.deal_id)
      //          INNER JOIN vrx_persons ON vrx_persons.id = vrx_student_completion.persons_id
      //          INNER JOIN vrx_party ON vrx_party.id = vrx_persons.party_id
      //          INNER JOIN vrx_deals ON vrx_deals.party_id = vrx_party.id
      //          INNER JOIN vrx_deal_details ON (vrx_deals.id = vrx_deal_details.deal_id)
      //          INNER JOIN vrx_enrolments ON (vrx_deals.id = vrx_enrolments.deal_id)
      //          INNER JOIN vrx_student_info ON (vrx_student_info.person_id = vrx_persons.id)
      //          -- INNER JOIN vrx_party ON (vrx_party.id = vrx_deals.party_id)
      //          -- INNER JOIN vrx_persons ON (vrx_persons.party_id = vrx_party.id)
      //          INNER JOIN vrx_address ON (vrx_address.party_id = vrx_party.id)
      //          -- INNER JOIN vrx_training_plan ON (vrx_training_plan.deal_id = vrx_deals.id)
      //          INNER JOIN vrx_opportunities ON (vrx_opportunities.deal_id = vrx_deals.id)
      //       WHERE
      //         vrx_student_completion_details.end_date BETWEEN '{$dateFrom}' AND '{$dateTo}'
      //         AND vrx_student_info.uniq_stud_identifier IS NOT NULL
      //         -- AND vrx_training_schedule.status_id = 6
      //         AND vrx_student_completion.completion_date IS NOT NULL
      //         AND vrx_student_completion.deleted_at IS NULL
      //         AND vrx_student_completion.completion_status_id = 3
      //         AND vrx_deals.deleted_at IS NULL
      //         AND vrx_courses.code != '1111'
      //         -- AND vrx_training_plan.deleted_at IS NULL
      //         -- AND vrx_stud_train_sched.stud_stat_id IN (3)
      //       GROUP BY
      //         vrx_deals.id
      //       ORDER BY
      //         vrx_student_completion_details.end_date")) ), true ) );
     }
    
}
