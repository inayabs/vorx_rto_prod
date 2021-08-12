<?php

namespace App\Models\Avetmiss;

use Illuminate\Database\Eloquent\Model;
use DB;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Avetmiss extends Model implements AuditableContract
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

     protected $table = 'avetmiss';

     protected $fillable = [
        'nat_result',
        'month',
        'year', 
        'user_id', 
        'status_id'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    public function status()
    {
        return $this->belongsTo(\App\Models\Avetmiss\AvtStatus::class, 'id', 'status_id');
    }
}
