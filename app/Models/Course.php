<?php

namespace App\Models;

use App\Models\Course\CourseUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Course extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;

    protected $fillable = ['id', 'code', 'name', 'tp_code', 'is_active', 'is_uc'];

    public function course_avt_detail()
    {
        return $this->hasOne(CourseAvtDetail::class, 'course_code', 'code');
    }

    public function courseprospectus()
    {
        return $this->hasMany(CourseProspectus::class, 'course_code', 'code');
    }

    public function student_completion()
    {
        return $this->hasMany(StudentCompletion::class, 'course_code', 'code');
    }

    public function student_completion_checker()
    {
        return $this->hasOne(StudentCompletion::class, 'course_code', 'code');
    }

    public function matrix()
    {
        return $this->hasMany(CourseMatrix::class, 'course_code', 'code');
    }

    public function get_units()
    {
        return $this->hasMany(CourseUnit::class, 'tp_code', 'tp_code');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function funded_student_courses()
    {
        return $this->hasMany(FundedStudentCourse::class, 'course_code', 'code');
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($course) {
            $course->course_avt_detail()->each(function ($course_avt_detail) {
                $course_avt_detail->delete();
            });

            $course->courseprospectus()->each(function ($prospectus) {
                $prospectus->delete();
            });

            $course->matrix()->each(function ($matrix) {
                $matrix->delete();
            });
        });
    }
}
