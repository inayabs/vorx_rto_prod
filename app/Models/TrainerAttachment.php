<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class TrainerAttachment extends Model implements AuditableContract
{
    //

    use SoftDeletes;
    use Auditable;
    
    protected $fillable = [
        'path_id',
        'name',
        'hash_name',
        'size',
        'mime_type',
        'ext',
        '_input',

    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
}
