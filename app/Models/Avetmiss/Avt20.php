<?php

namespace App\Models\Avetmiss;

use App\Models\StudentCompletion;
use Illuminate\Database\Eloquent\Model;
use DB;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

use App\Models\StudentCompletionDetail;
use App\Models\TrainingDeliveryLoc;
use App\Models\User;

class Avt20 extends Model implements AuditableContract
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

    protected $table = 'avt_20_training_org_dlvr_loc';

	 protected $fillable = [
	 	'training_organisation_id',
	 	'train_org_dlvr_loc_id',
	 	'train_org_dlvr_loc_name',
	 	'postcode',
	 	'state_id',
	 	'addr_location',
	 	'country_id',
	 	'avt_process_id',
	 	'error_code',
	 	'user_id'
     ];
     
     public function user()
     {
         return $this->belongsTo(User::class);
     }

	//  public function get_data_avt20($dateFrom,$dateTo, $reportTo)
	 public function get_data_avt20($studCom)
     {
     	// return DB::table('training_delivery_loc')->get();

        // return collect( json_decode( json_encode( DB::select(DB::raw("SELECT 
        //        vrx_training_delivery_loc.*
        //        -- (SELECT SUM( vrx_course_units.`nominal_hours`) FROM `vrx_course_units` WHERE `vrx_course_units`.course_id = vrx_courses.id) AS hours_attended
        //        -- *
        //        FROM vrx_training_schedule
        //         INNER JOIN vrx_training_delivery_loc ON (vrx_training_schedule.train_org_dlvr_loc_identifier = vrx_training_delivery_loc.dlvr_loc_identifier)
        //     WHERE
        //       vrx_training_schedule.start_date BETWEEN '{$dateFrom}' AND '{$dateTo}'
        //     GROUP BY vrx_training_delivery_loc.dlvr_loc_identifier")) ), true ) );
        // dump('wew');

        /*return DB::table('student_completion')
                ->join('training_delivery_loc', 'training_delivery_loc.dlvr_loc_identifier', '=', 'student_completion.train_org_dlvr_loc_identifier')
                ->join('student_completion_details', 'student_completion_details.student_completion_id', '=', 'student_completion.id')
                ->join('organisation_info', 'organisation_info.org_identifier', '=', 'training_delivery_loc.org_identifier')
                ->select('training_delivery_loc.*', 'organisation_info.org_identifier AS org_id')
                ->whereBetween('student_completion_details.start_date', [$dateFrom,$dateTo])
                // ->whereIn('training_schedule.status_id', [6,2,3])
                ->groupBy('student_completion.train_org_dlvr_loc_identifier')
                ->get();*/

        // return StudentCompletionDetail::where('start_date', '>=', $dateFrom)->where('end_date', '<=', $dateTo)->get();

        $tdl = null;

        // $sc = new StudentCompletion;

        // $studCom = $sc->avetmiss_compliant($dateFrom, $dateTo, $reportTo);

        $checker = [];
        foreach($studCom as $k => $v){
            foreach($v->details as $kk => $vv){
                // dd($vv->training_delivery_location);
                if(isset($vv->training_delivery_location->train_org_dlvr_loc_id) && !in_array($vv->training_delivery_location->train_org_dlvr_loc_id, $checker)){
                    $checker[] = $vv->training_delivery_location->train_org_dlvr_loc_id;
                    $x = $vv->training_delivery_location->toArray();
                    $x['training_org'] = $vv->training_delivery_location->training_org->toArray();
                    $tdl[] = $x;
                }
            }
        }

        // dd($tdl);

        // if($reportTo == '*'){
        //     $tdl = TrainingDeliveryLoc::with(['training_org'])->whereHas('student_completion_detail_checker', function($q) use($dateFrom, $dateTo){
        //         $q->whereIn('completion_status_id', [3,4,6]);
        //         $q->whereHas('completion', function($qq){
        //             $qq->where('partial_completion', 1);
        //             $qq->orWhere('completion_status_id', 3);
                    
        //             $qq->whereHas('student', function($qqq){
        //                 $qqq->where('student_type_id', 2);
        //                 $qqq->where('report_avetmiss', 1);
        //             });
        //         });
        //         $q->where('start_date', '>=', $dateFrom);
        //         $q->where('start_date', '<=', $dateTo);
        //     })->get()->toArray();
        // }else{
        //     // dump($reportTo->id);
        //     $tdl = TrainingDeliveryLoc::with(['training_org'])->where('state_id', $reportTo->id)->whereHas('student_completion_detail_checker', function($q) use($dateFrom, $dateTo){
        //         $q->whereIn('completion_status_id', [3,4,6]);
        //         $q->whereHas('completion', function($qq){
        //             $qq->where('partial_completion', 1);
                    
        //             $qq->whereHas('student', function($qqq){
        //                 $qqq->where('student_type_id', 2);
        //                 $qqq->where('report_avetmiss', 1);
        //             });

        //             $qq->orWhere('completion_status_id', 3);
                    
        //             $qq->whereHas('student', function($qqq){
        //                 $qqq->where('student_type_id', 2);
        //                 $qqq->where('report_avetmiss', 1);
        //             });
        //         });
        //         $q->where('end_date', '>=', $dateFrom);
        //         $q->where('start_date', '<=', $dateTo);
        //     })->get()->toArray();
        // }

        // // dump($reportTo);
        // dd($tdl);

        return $tdl;

        // return TrainingDeliveryLoc::whereHas('student_completion_detail_checker', function($q) use($dateFrom, $dateTo){
        //     $q->whereIn('completion_status_id', [3,4,6]);
        //     $q->whereHas('completion', function($qq){
        //         $qq->where('partial_completion', 1);
        //         $qq->orWhere('completion_status_id', 3);
                
        //         $qq->whereHas('student', function($qqq){
        //             $qqq->where('student_type_id', 2);
        //         });
        //     });
        //     $q->where('start_date', '>=', $dateFrom);
        //     $q->where('start_date', '<=', $dateTo);
        // })->get()->toArray();
        // return TrainingDeliveryLoc::join('student_completion_details', 'student_completion_details.train_org_loc_id', 'training_delivery_locations.train_org_dlvr_loc_id')->get();
        // return TrainingDeliveryLoc::with('student_completion_detail')->get();
        

        //  return DB::select(DB::raw("select `vrx_training_delivery_loc`.*, `vrx_organisation_info`.`org_identifier` as `org_id` from `vrx_student_completion`
        //                     inner join `vrx_training_delivery_loc` on `vrx_training_delivery_loc`.`dlvr_loc_identifier` = `vrx_student_completion`.`train_org_dlvr_loc_identifier`
        //                     inner join `vrx_student_completion_details` on `vrx_student_completion_details`.`student_completion_id` = `vrx_student_completion`.`id`
        //                     inner join `vrx_organisation_info` on `vrx_organisation_info`.`org_identifier` = `vrx_training_delivery_loc`.`org_identifier`
        //                     where `vrx_student_completion_details`.`end_date` between '".$dateFrom."' AND '".$dateTo."'
        //                     group by `vrx_student_completion`.`train_org_dlvr_loc_identifier`"));


     }
    
}
