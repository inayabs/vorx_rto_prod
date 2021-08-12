<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class TrainingOrgBankDetails extends Model implements AuditableContract
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
    protected $table = 'training_bank_details';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'training_organisation_id',
        'bank_name',
        'bsb',
        'account_name',
        'account_number'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

}
