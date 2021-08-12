<?php

namespace App\Models\Avetmiss;

use App\Models\StudentCompletion;
use Illuminate\Database\Eloquent\Model;
use DB;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Avt85 extends Model implements AuditableContract
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

    protected $table = 'avt_85_client_postal_details';

    protected $fillable = [
     	'client_id',
     	'client_title',
     	'client_first_given_name',
     	'client_last_name',
     	'address_building_property_name',
     	'address_flat_unit_details',
     	'address_street_number',
     	'address_street_name',
     	'address_postal_delivery_box',
     	'address_location_suburb_locality_or_town',
     	'postcode',
     	'state_id',
     	'telephone_number_home',
     	'telephone_number_work',
     	'telephone_number_mobile',
      'email_address',
     	'email_ad_alternative',
      'avt_process_id',
      'error_code',
    ];

    // public function get_data_avt85($dateFrom,$dateTo, $reportTo)
    public function get_data_avt85($studCom)
    {

      // $sc = new StudentCompletion;
      // $studCom = $sc->avetmiss_compliant($dateFrom, $dateTo, $reportTo);

      $data = [];
      // dump($studCom);
      foreach($studCom as $val){
        // dd($val->student->party->person);
        $data[$val->student_id] = $val->toArray();
        $data[$val->student_id]['student'] = $val->student->toArray(); 
        $data[$val->student_id]['student']['party'] = $val->student->party->toArray(); 
        $data[$val->student_id]['student']['party']['person'] = $val->student->party->person ? $val->student->party->person->toArray() : null;
        
        // $data[$val->student_id]['student']['funded_course'] = $val->student->funded_course ? $val->student->funded_course->toArray() : null;
        // $data[$val->student_id]['student']['funded_detail'] = $val->student->funded_detail ? $val->student->funded_detail->toArray() : null;
        $data[$val->student_id]['student']['contact_detail'] = $val->student->contact_detail ? $val->student->contact_detail->toArray() : null;
        $data[$val->student_id]['student']['contact_detail']['state'] = $val->student->contact_detail->state ? $val->student->contact_detail->state->toArray() : null;
        $data[$val->student_id]['student']['course_code'] = $val->course_code;
      }

      // dd($data);
      return $data;
    }
    
}
