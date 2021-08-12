<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CompletionStudentCourse extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['student_type'];

    public function completion()
    {
        return $this->belongsTo(StudentCompletion::class, 'completion_id');
    }

    public function funded_course()
    {
        return $this->belongsTo(FundedStudentCourse::class, 'student_course_id');
    }

    public function offer_details()
    {
        return $this->belongsTo(OfferLetterCourseDetail::class, 'student_course_id');
    }
    public static function boot()
    {
        parent::boot();
        self::deleting(function ($course) {
            $course->completion()->each(function ($student_completion) {
                $student_completion->delete();
            });
        });
    }
}
