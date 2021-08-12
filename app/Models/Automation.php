<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Automation extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;

    protected $fillable = ['id', 'occurrence_type', 'month', 'day', 'time', 'type', 'config', 'emails'];

    protected $casts = [
        'config' => 'array',
        // 'time' => 'timestamp',
    ];
    
}
