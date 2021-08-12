<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class TrainingDeliveryLoc extends Model implements AuditableContract
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


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'training_delivery_locations';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'training_organisation_id',
        'train_org_dlvr_loc_id',
        'train_org_dlvr_loc_name',
        'postcode',
        'state_id',
        'addr_location',
        'country_id',
        'user_id',
        'addr_flat_unit_detail',
        'addr_building_property_name',
        'addr_street_name',
        'addr_street_num',
        'is_active'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];


    public function student_completion_detail()
    {
        return $this->hasMany(StudentCompletionDetail::class, 'train_org_loc_id', 'train_org_dlvr_loc_id');
    }

    public function classes()
    {
        return $this->hasMany(StudentClass::class, 'delivery_loc', 'id');
    }

    public function training_org()
    {
        return $this->belongsTo(TrainingOrganisation::class, 'training_organisation_id', 'training_organisation_id');
    }

    public function student_completion_detail_checker()
    {
        return $this->hasOne(StudentCompletionDetail::class, 'train_org_loc_id', 'train_org_dlvr_loc_id');
    }

    public function state()
    {
        return $this->belongsTo(AvtStateIdentifier::class, 'state_id', 'value');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
