<?php

namespace App\Models\Student\OfferLetter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class OfferLetter extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'is_sent_date', 'deferred_date_from', 'deferred_date_to', 'refund_date'];
    protected $fillable = [
        'reference_id',
        'agent_id',
        'issued_date',
        'process_id',
        'is_sent', 'is_sent_date', 'remarks', 'shore_type', 'package_type', 'checklist',
        'status_id', 'deferred_date_from', 'deferred_date_to', 'refund_date'
    ];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    public function enrolment_pack()
    {
        return $this->belongsTo(\App\Models\EnrolmentPack::class, 'process_id', 'process_id');
    }

    public function agent()
    {
        return $this->belongsTo(\App\Models\Agent::class);
    }
    public function student()
    {
        return $this->belongsTo(\App\Models\Student\Student::class, 'student_id', 'student_id');
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function student_details()
    {
        return $this->hasOne(\App\Models\OfferLetterStudentDetail::class);
    }
    public function course_details()
    {
        return $this->hasMany(\App\Models\OfferLetterCourseDetail::class);
    }
    public function fees()
    {
        return $this->hasOne(\App\Models\OfferLetterFee::class);
    }
    public function status()
    {
        return $this->belongsTo(\App\Models\OfferLetterStatus::class);
    }
    public function offer_course()
    {
        return $this->hasOne(\App\Models\OfferLetterCourseDetail::class)->whereIn('status_id', [2, 3, 4])->orWhere('order', 1);
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($offer_letter) {
            $offer_letter->student_details()->each(function ($student_details) {
                $student_details->delete();
            });

            $offer_letter->course_details()->each(function ($course_details) {
                $course_details->delete();
            });

            $offer_letter->fees()->each(function ($fees) {
                $fees->delete();
            });
        });
    }
}
