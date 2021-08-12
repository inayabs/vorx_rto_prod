<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class CourseMatrix extends Model implements AuditableContract
{
    //
    use Auditable;
    use SoftDeletes;
    protected $table = "course_matrices";

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'course_code',
        'cricos_code',
        'wk_duration',
        'wk_duration_package',
        'location',
        'material_fees',
        'enrolment_fee',
        'concessional_fee',
        'non_concessional_fee',
        'tuition_fee_per_week',
        'training_hours_weekly',
        // Onshore
        'onshore_tuition_individual',
        'onshore_tuition_package',
        // Offshore
        'offshore_tuition_individual',
        'offshore_tuition_package',
    ];

    public function detail()
    {
        return $this->belongsTo(Course::class, 'course_code', 'code');
    }

    public function package_detail()
    {
        return $this->hasMany(CoursePackageDetail::class, 'course_matrix_id');
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($matrix) {
            $matrix->package_detail()->each(function ($package_detail) {
                $package_detail->delete();
            });
        });
    }
}
