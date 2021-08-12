<?php

namespace App\Models\Avetmiss;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\TrainingOrganisation;
use App\Models\User;

class Avt10 extends Model implements AuditableContract
{
	use Auditable;
	use SoftDeletes;

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

     protected $table = 'avt_10_training_org';

     protected $fillable = ['training_organisation_id','training_organisation_name','org_type_identifier', 'addr_line1', 'addr_line2', 'addr_location', 'postcode', 'state_identifier', 'contact_name', 'telephone_number', 'facsimile_number', 'email_address', 'avt_process_id', 'isValid', 'user_id'];

     public function user()
     {
         return $this->belongsTo(User::class);
     }

     public function get_data_avt10()
     {
         // return DB::table('organisation_info')->get();
         return TrainingOrganisation::get()->toArray();
     }


}
