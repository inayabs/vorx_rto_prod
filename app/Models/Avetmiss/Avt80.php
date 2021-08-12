<?php

namespace App\Models\Avetmiss;

use App\Models\StudentCompletion;
use Illuminate\Database\Eloquent\Model;
use DB;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Avt80 extends Model implements AuditableContract
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

    protected $table = 'avt_80_client_file';

    protected $fillable = [
      'client_id',
      'name_for_encryption',
      'highest_school_level_completed',
      'gender',
      'date_of_birth',
      'postcode',
      'indigenous_status_id',
      'language_id',
      'labour_force_status_id',
      'country_id',
      'disability_flag',
      'prior_educational_achievement_flag',
      'at_school_flag',
      'unique_student_id',
      'state_id',
      'address_location_suburb_locality_or_town',
      'address_street_number',
      'address_street_name',
      'learner_unique_identifier',
      'address_building_property_name',
      'address_flat_unit_details',
      'statistical_area_level_1_id',
      'statistical_area_level_2_id',
      'survey_contact_status',
     	'avt_process_id',
      'error_code',
    ];

    // public function get_data_avt80($dateFrom,$dateTo, $reportTo)
    public function get_data_avt80($studCom)
    {

      // $sc = new StudentCompletion;
      // $studCom = $sc->avetmiss_compliant($dateFrom, $dateTo, $reportTo);

      $data = [];
      // dump($studCom);
      foreach($studCom as $val){
        // dd($val->student_course);
        $data[$val->student_id] = $val->toArray();
        $data[$val->student_id]['student'] = $val->student->toArray(); 
        $data[$val->student_id]['student']['party'] = $val->student->party->toArray(); 
        $data[$val->student_id]['student']['party']['person'] = $val->student->party->person ? $val->student->party->person->toArray() : null;
        
        $data[$val->student_id]['student']['course_code'] = $val->course_code;
        $data[$val->student_id]['student']['funded_course'] = $val->student_course ? $val->student_course->toArray() : null;
        $data[$val->student_id]['student']['funded_detail'] = $val->student->funded_detail ? $val->student->funded_detail->toArray() : null;
        $data[$val->student_id]['student']['contact_detail'] = $val->student->contact_detail ? $val->student->contact_detail->toArray() : null;
        $data[$val->student_id]['student']['contact_detail']['state'] = $val->student->contact_detail->state ? $val->student->contact_detail->state->toArray() : null;
        
      }

      // dd($data);
      return $data;

        // return StudentCompletion::with(['student.party.person', 'student.funded_course', 'student.funded_detail', 'student.contact_detail.state'])->where('completion_status_id', 3)->orWhere('partial_completion', 1)->whereHas('student', function($q) use($dateFrom, $dateTo){
        //   $q->where('student_type_id', 2);
        //   $q->whereHas('funded_course', function($qq) use($dateFrom, $dateTo){
        //     $qq->where('start_date', '>=', $dateFrom);
        //     // $qq->where('end_date', '<=', $dateTo);
        //   });
        // })->get()->toArray();

    }
    
}
