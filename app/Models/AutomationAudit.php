<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class AutomationAudit extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;

    protected $fillable = ['occurrence_type', 'month', 'day', 'time', 'type', 'date_triggered'];
    
    public function automation()
    {
        return $this->belongsTo(Automation::class);
    }
}
