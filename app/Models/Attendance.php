<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Attendance extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'class_id',
        'student_id',
        'funded_student_course_id',
        'course_code'
    ];

    public function student(){
        return $this->belongsTo(Student\Student::class, 'student_id', 'student_id');
    }

    public function attendance_details(){
        return $this->hasMany(AttendanceDetail::class, 'attendance_id', 'id');
    }

    public function course(){
        return $this->belongsTo(Course::class, 'course_code', 'code');
    }

    public function student_class(){
        return $this->belongsTo(StudentClass::class,'class_id','id');
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($attendance) {
            $attendance->attendance_details()->each(function($ad){
                $ad->delete();
            });
        });
    }

}
