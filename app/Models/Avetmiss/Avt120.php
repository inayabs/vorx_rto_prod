<?php

namespace App\Models\Avetmiss;

use App\Models\StudentCompletion;
use App\Models\TrainingOrganisation;
use Illuminate\Database\Eloquent\Model;
use DB;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Avt120 extends Model implements AuditableContract
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

    protected $table = 'avt_120_enrolment_file';

     protected $fillable = [
     	'training_organisation_id',
     	'training_organisation_delivery_location_id',
     	'client_id',
     	'subject_id',
     	'program_id',
     	'activity_start_date',
     	'activity_end_date',
     	'delivery_mode_id',
     	'outcome_id_national',
     	'scheduled_hours',
     	'funding_source_national',
     	'commencing_program_id',
     	'training_contract_id',
     	'client_id_apprenticeships',
     	'study_reason_id',
     	'vet_in_schools_flag',
     	'specific_funding_id',
     	'school_type_identifier',
     	'outcome_id_training_organisation',
     	'funding_source_state_training_authority',
     	'client_tuition_fee',
     	'fee_exemption_concession_type_id',
     	'purchasing_contract_id',
     	'purchasing_contract_schedule_id',
     	'hours_attended',
     	'associated_course_id',
     	'predominant_delivery_mode',
     	'full_time_learning_option',
      'avt_process_id',
      'error_code',
     ];

    //  public function get_data_avt120($dateFrom,$dateTo, $reportTo)
     public function get_data_avt120($studCom, $dateFrom, $dateTo, $reportTo = '')
     {
        $training_org = TrainingOrganisation::first();
        // dd($training_org);
        // $sc = new StudentCompletion;
        // $studCom = $sc->avetmiss_compliant($dateFrom, $dateTo, $reportTo);
        // dd($reportTo);
        $data = [];
        // dd($studCom->count());
        foreach($studCom as $val){
          foreach($val->student->funded_course as $vv){
            if($vv->course_code == $val->course_code){
              // dd($val->toArray());
              foreach($val->details as $v){
                // dd($v);
                if($reportTo == '*') {
                  if( $dateFrom <= $v->start_date && $dateTo >= $v->end_date && in_array($v->completion_status_id, [3,4,6]) ){
                    // dd($val->student->funded_course);
                      // dump($v->toArray());
                      $data[$v->id] = $v->toArray();
                      $data[$v->id]['completion_status'] = isset($v->status->id) ? $v->status->toArray() : [];
                      $data[$v->id]['unit'] = isset($v->unit->id) ? $v->unit->toArray() : [];
                      $data[$v->id]['unit_count'] = $val->details->count();
                      $data[$v->id]['student_course'] = $vv ? $vv->toArray() : null;
                      $data[$v->id]['student_course']['course'] = isset($vv->course) && $vv->course != null ? $vv->course->toArray() : null;
                      $data[$v->id]['student_course']['detail'] = $vv->detail ? $vv->detail->toArray() : null;
                      $data[$v->id]['organisation'] = $training_org->toArray();
                      $data[$v->id]['offer_letter'] = isset($vv->offer_detail->offer_letter->id) ? $vv->offer_detail->offer_letter->toArray() : null;
                      // dump($v);1813
                  }
                }else{
                  if( $dateFrom <= $v->start_date && $dateTo >= $v->end_date && in_array($v->completion_status_id, [3,4,6]) ){
                    // dd($val->student->funded_course);
                      // dump($v->toArray());
                      $data[$v->id] = $v->toArray();
                      $data[$v->id]['completion_status'] = isset($v->status->id) ? $v->status->toArray() : [];
                      $data[$v->id]['unit'] = isset($v->unit->id) ? $v->unit->toArray() : [];
                      $data[$v->id]['unit_count'] = $val->details->count();
                      $data[$v->id]['student_course'] = $vv ? $vv->toArray() : null;
                      $data[$v->id]['student_course']['course'] = isset($vv->course) && $vv->course != null ? $vv->course->toArray() : null;
                      $data[$v->id]['student_course']['detail'] = $vv->detail ? $vv->detail->toArray() : null;
                      $data[$v->id]['organisation'] = $training_org->toArray();
                      // dump($v);1813
                  }

                }
              }
            }
          }
          

        }

        return $data;
        // dd($data);
        
        
     }

     public function get_enrolment($deal_id)
     {
        return collect( json_decode( json_encode( DB::select(DB::raw("SELECT 
               vrx_persons.id AS client_identifier,
               vrx_courses.code prg_identifier,
               trainer.name train_contact_identifier,
               avt_delivery_types.description dlvr_mode_identifier,
               IF(vrx_course_avt_details.vet_flag_status = 1, 'Y', 'N') AS vet_in_school_flag,
               vrx_training_schedule.train_org_dlvr_loc_identifier train_org_dlvr_loc_identifier,
               vrx_course_avt_details.nominal_hours sched_hours,
               (SELECT SUM( vrx_course_units.`nominal_hours`) FROM `vrx_course_units` WHERE `vrx_course_units`.course_id = vrx_courses.id) AS hours_attended

               FROM vrx_training_schedule
               INNER JOIN vrx_users ON (vrx_training_schedule.trainer_id = vrx_users.id)
               INNER JOIN vrx_party trainer ON (trainer.id = vrx_users.party_id)
               INNER JOIN vrx_courses ON (vrx_training_schedule.course_id = vrx_courses.id)
               -- INNER JOIN vrx_course_units ON (vrx_course_units.course_id = vrx_courses.id)
               INNER JOIN vrx_course_avt_details ON (vrx_course_avt_details.course_id = vrx_courses.id)
               -- INNER JOIN vrx_course_fee_types ON (vrx_course_fee_types.course_id = vrx_courses.id)
               INNER JOIN vrx_stud_train_sched ON (vrx_training_schedule.id = vrx_stud_train_sched.schedule_id)
               INNER JOIN vrx_deals ON (vrx_deals.id = vrx_stud_train_sched.deal_id)
               INNER JOIN vrx_deal_details ON (vrx_deals.id = vrx_deal_details.deal_id)
               INNER JOIN vrx_enrolments ON (vrx_enrolments.deal_id = vrx_deals.id)
               INNER JOIN avt_delivery_types ON (vrx_deal_details.training_mode_id = avt_delivery_types.id)
               INNER JOIN vrx_party ON (vrx_party.id = vrx_deals.party_id)
               INNER JOIN vrx_persons ON (vrx_persons.party_id = vrx_party.id)
               -- INNER JOIN vrx_student_info ON (vrx_student_info.person_id = vrx_persons.id)
               -- INNER JOIN vrx_country ON (vrx_address.party_id = vrx_country.id)
            WHERE
              vrx_deals.id = ".$deal_id."
              AND vrx_deals.deleted_at IS NULL
            ORDER BY
              vrx_training_schedule.end_date")) ), true ) );
     }
    
}
