<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class FundedCourseMatrices extends Model implements AuditableContract
{
    //
    use Auditable;
    use SoftDeletes;
    protected $table = "funded_course_matrices";

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'course_code',
        'concessional_fee',
        'non_concessional_fee',
        'full_fee',
        'location',
        'min_payment',
    ];

    public function detail()
    {
        return $this->belongsTo(Course::class, 'course_code', 'code');
    }
}
