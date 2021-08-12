<?php

namespace App\Models;

use App\Models\Student\Student;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class StudentCompletion extends Model implements AuditableContract
{
    //

    use Auditable;
    use SoftDeletes;
    /**
     * Auditable events.
     *
     * @var array
     */
    protected $auditableEvents = [
        'deleted',
        'restored',
        'updated',
        'created'
    ];

    protected $fillable = ['student_id', 'course_code', 'completion_status_id', 'completion_date', 'user_id', 'partial_completion', 'train_org_loc_id'];

    public function details()
    {
        return $this->hasMany(StudentCompletionDetail::class)->orderBy('order');
    }
    public function status()
    {
        return $this->belongsTo(AvtCompletionStatus::class, 'completion_status_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function certificate()
    {
        return $this->hasOne(StudentCertificateIssuance::class);
    }
    public function course()
    {
        return $this->hasOne(Course::class, 'code', 'course_code');
    }
    public function completion_course()
    {
        return $this->hasOne(CompletionStudentCourse::class, 'completion_id');
    }

    public function student_course()
    {
        return $this->hasMany(FundedStudentCourse::class, 'student_id', 'student_id')->where('course_code', '!=', '1111');
    }

    // for domestic only
    public function avetmiss_compliant($dateFrom, $dateTo, $reportTo)
    {
        // dump($dateFrom);
        // dd($dateTo);
        // dd($this::all());
        // dd($data->toArray());

        if($reportTo == '*'){
            return $this->with('student_course.detail', 'student_course.offer_detail.offer_letter', 'student', 'details')->whereIn('completion_status_id', [5, 3])->where('partial_completion', 1)->whereHas('student', function ($qq) {
                // $qq->where('student_type_id', 2);
                $qq->where('report_avetmiss', 1);
            })->whereHas('student_course', function ($q) use ($dateFrom, $dateTo, $reportTo) {
                $q->where('start_date', '>=', $dateFrom);
                $q->where('start_date', '<=', $dateTo);
                // $q->where('end_date', '<=', $dateTo);
                $q->where('course_code', '!=', '1111');
                $q->where('course_fee_type', '=', 'FF');
            })->get();
        }else{
            return $this->with('student_course.detail', 'student', 'details')->whereIn('completion_status_id', [5, 3])->where('partial_completion', 1)->whereHas('student', function ($qq) {
                $qq->where('student_type_id', 2);
                $qq->where('report_avetmiss', 1);
            })->whereHas('student_course', function ($q) use ($dateFrom, $dateTo, $reportTo) {
                $q->where('start_date', '>=', $dateFrom);
                $q->where('end_date', '<=', $dateTo);
                $q->where('course_code', '!=', '1111');
                $q->where('location', $reportTo->state_key);
            })->get();
        }

    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($completion) {
            $completion->details()->each(function ($details) {
                $details->delete();
            });
        });
    }
}
