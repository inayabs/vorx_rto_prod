<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentCourseWorkbookAttachment extends Model implements AuditableContract
{
    //
    use Auditable;
    use SoftDeletes;

    protected $auditableEvents = [
        'deleted',
        'restored',
        'updated',
        'created'
    ];

    protected $fillable = [
        'course_code',
        'student_id',
        'name',
        'path',
        'hash_name',
        'size',
        'mime_type',
        'ext',
        '_input',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_code', 'code');
    }

    public function funded_student_course()
    {
        return $this->belongsTo(FundedStudentCourse::class);
    }
}
