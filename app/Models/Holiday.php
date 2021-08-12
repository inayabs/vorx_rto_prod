<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class Holiday extends Model implements AuditableContract
{
    //
    use Auditable;
    use SoftDeletes;

    protected $fillable = ['name','location','month','day','type','week','weekday'];
    protected $dates = ['created_at', 'update_at', 'deleted_at'];


}
