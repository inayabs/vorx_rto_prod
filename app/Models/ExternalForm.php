<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class ExternalForm extends Model implements AuditableContract
{
    //
    use Auditable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'student_id',
        'process_id',
        'form_type',
        'form_json',
        'form_txt',
        'status',
        'date_created',
    ];

    protected $casts = ['form_json' => 'array'];

}
