<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class OrganisationType extends Model implements AuditableContract
{
	use Auditable;
    //
    protected $table = "avt_org_type";
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
    public function organisation()
    {
    	return $this->belongsTo(Organisations::class, 'org_type_id');
    }
}
