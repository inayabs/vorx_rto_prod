<?php

namespace App\Models;

use App\Models\Student\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class FundedStudentCourse extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;
    protected $table = "funded_student_course";
    protected $dates = ['created_at'];

    protected $fillable = [
        'student_id',
        'course_code',
        'eligibility',
        'location',
        'start_date',
        'end_date',
        'course_fee',
        'course_fee_type',
        'status_id',
        'aiss_date',
        'remarks',
        'uc_description',
        'user_id',
        'agent_id',
        'process_id',
    ];


    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id','student_id');
    }

    public function detail()
    {
        return $this->belongsTo(FundedStudentCourseDetail::class, 'id', 'funded_student_course_id');
    }

    public function offer_detail()
    {
        return $this->belongsTo(OfferLetterCourseDetail::class, 'offer_letter_course_detail_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_code', 'code');
    }

    public function course_completion()
    {
        return $this->hasOne(CompletionStudentCourse::class, 'student_course_id');
    }

    public function payment_details()
    {
        return $this->hasMany(\App\Models\FundedStudentPaymentDetails::class, 'student_course_id', 'id');
    }
    public function status()
    {
        return $this->belongsTo(\App\Models\OfferLetterStatus::class);
    }

    public function completion()
    {
        return $this->hasMany(\App\Models\StudentCompletion::class, 'student_id', 'student_id');
    }

    public function course_details()
    {
        return $this->belongsTo(\App\Models\FundedStudentCourseDetail::class, 'id', 'funded_student_course_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function matrices()
    {
        return $this->belongsTo(\App\Models\FundedCourseMatrices::class, 'course_code', 'course_code');
    }

    public function payment_sched()
    {
        return $this->hasMany(\App\Models\PaymentScheduleTemplate::class, 'funded_student_course_id', 'id');
    }

    public function agent()
    {
        return $this->belongsTo(AgentDetail::class);
    }
    

    public function student_workbook_attachment()
    {
        return $this->hasMany(StudentCourseWorkbookAttachment::class);
    }

    public function course_completion_by_ol()
    {
        // student_course_id by offer_letter_course_detail_id (course_completion)
        return $this->hasOne(CompletionStudentCourse::class, 'student_course_id','offer_letter_course_detail_id');
    }

    public function attendance()
    {
        // student_course_id by offer_letter_course_detail_id (course_completion)
        return $this->hasOne(Attendance::class, 'course_code','course_code');
    }

    public function commission(){
        return $this->hasOne(AgentCommissionSettingSub::class,'student_course_id');
    }

    public function collection(){
        return $this->hasMany(Collection::class,'student_course_id');
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($course) {
            // $course->course_details()->each(function ($details) {
            //     $details->delete();
            // });

            $course->payment_sched()->each(function ($payment) {
                $payment->delete();
            });

            $course->commission()->each(function ($commission) {
                $commission->delete();
            });

            $course->payment_details()->each(function ($payment_details) {
                $payment_details->delete();
            });
        });
    }
}
