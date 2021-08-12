<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class OfferLetterCourseDetail extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;

    protected $auditableEvents = [
        'deleted',
        'restored',
        'updated',
        'created'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];


    // protected $dates = ['created_at', 'deleted_at', 'updated_at'];

    protected $fillable = ['package_id', 'package_batch', 'course_code', 'cricos_code', 'week_duration', 'max_week_duration', 'tuition_fees', 'max_tuition_fee', 'material_fees', 'commission_limit', 'course_start_date', 'course_end_date', 'order', 'finish_date', 'status_id', 'course_location', 'weekly_payment'];

    public function offer_letter()
    {
        return $this->belongsTo(\App\Models\Student\OfferLetter\OfferLetter::class);
    }

    public function package()
    {
        return $this->belongsTo(CoursePackage::class);
    }
    public function course_matrix()
    {
        return $this->belongsTo(CourseMatrix::class);
    }

    public function payment_template()
    {
        return $this->hasMany(PaymentScheduleTemplate::class);
    }

    public function status()
    {
        return $this->belongsTo(OfferLetterStatus::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_code', 'code');
    }

    public function payments()
    {
        return $this->hasMany(FundedStudentPaymentDetails::class);
    }

    public function funded_course()
    {
        return $this->hasOne(FundedStudentCourse::class, 'offer_letter_course_detail_id');
    }

    public function enrolment()
    {
        return $this->hasOne(OfferLetterCourseEnrolmentDetail::class);
    }

    public function course_completion()
    {
        return $this->hasOne(CompletionStudentCourse::class, 'student_course_id');
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($course_detail) {
            $course_detail->payment_template()->each(function ($payment_template) {
                $payment_template->delete();
            });

            $course_detail->enrolment()->each(function ($enrolment) {
                $enrolment->delete();
            });

            $course_detail->payments()->each(function ($payments) {
                $payments->delete();
            });

            $course_detail->funded_course()->each(function ($enrolment) {
                $enrolment->delete();
            });
        });
    }
}
