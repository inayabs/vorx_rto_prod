<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingOrganisation extends Model implements AuditableContract
{
	use Auditable;
    use SoftDeletes;
    protected $table = "training_organisations";
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
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [ 
        'training_organisation_id',
        'avetmiss_organisation_id',
        'training_organisation_name',
        'addr_line1',
        'addr_line2',
        'addr_location',
        'state_identifier',
        'postcode',
        'org_type_identifier',
        'contact_name',
        'telephone_number',
        'facsimile_number',
        'email_address',
        'logo_img',
        'app_color',
        'person_incharge',
        'incharge_position',
        'incharge_signature',
        'student_id_prefix',
        'is_setup',
    ];

    /**
    * Should the timestamps be audited?
    *
    * @var bool
    */
    protected $auditTimestamps = true;

    //
    public function party()
    {
    	return $this->belongsTo(Party::class);
    }

    public function org_type()
    {
    	return $this->hasOne(OrganisationType::class);
    }

    public function org_bank(){
        return $this->hasOne(TrainingOrgBankDetails::class,'training_organisation_id', 'training_organisation_id');
    }

    public function add_on($addOn)
    {
        $data = explode(',', $this->add_on);
        
        if(in_array($addOn, $data)){
            return 1;
        }else{
            return 0;
        }
    }

}
