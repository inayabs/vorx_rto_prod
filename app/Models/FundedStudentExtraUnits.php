<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class FundedStudentExtraUnits extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;
    protected $table = "funded_student_extra_units";
    protected $dates = ['created_at'];

    protected $fillable = [
        'student_id',
        'funded_student_course_id',
        'extra_units'
    ];

    // protected $casts = [
    //     'extra_units' => 'array'
    // ];
}
