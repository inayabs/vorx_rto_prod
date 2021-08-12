<?php

namespace App\Models\Student;

use App\Models\FundedStudentContactDetails;
use App\Models\FundedStudentCourse;
use App\Models\FundedStudentDetails;
use App\Models\FundedStudentExtraUnits;
use App\Models\FundedStudentVisaDetails;
use App\Models\Attendance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Student extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;

    protected $auditableEvents = [
        'deleted',
        'restored',
        'updated',
        'id',
        'created'
    ];
    protected $dates = ['created_at'];

    protected $fillable = ['student_id', 'student_type_id', 'is_active','is_test'];

    public function party()
    {
        return $this->belongsTo(Party::class, 'party_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'student_type_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    public function offer_letter()
    {
        return $this->hasMany(\App\Models\Student\OfferLetter\OfferLetter::class, 'student_id', 'student_id');
    }
    public function latest_offer_letter()
    {
        return $this->hasOne(\App\Models\Student\OfferLetter\OfferLetter::class, 'student_id', 'student_id')->latest();
    }

    public function funded_course()
    {
        return $this->hasMany(FundedStudentCourse::class, 'student_id', 'student_id');
    }
    public function latest_funded_course()
    {
        return $this->hasOne(FundedStudentCourse::class, 'student_id', 'student_id')->latest();;
    }
    public function funded_detail()
    {
        return $this->hasOne(FundedStudentDetails::class, 'student_id', 'student_id');
    }
    public function contact_detail()
    {
        return $this->hasOne(FundedStudentContactDetails::class, 'student_id', 'student_id');
    }
    public function extra_units()
    {
        return $this->hasMany(FundedStudentExtraUnits::class, 'student_id', 'student_id');
    }

    public function checklist()
    {
        return $this->hasOne(\App\Models\StudentChecklist::class, 'student_id', 'student_id');
    }

    public function certificate_issuance()
    {
        return $this->hasMany(\App\Models\StudentCertificateIssuance::class, 'student_id', 'student_id');
    }

    public function completion()
    {
        return $this->hasMany(\App\Models\StudentCompletion::class, 'student_id', 'student_id');
    }
    public function english_test()
    {
        return $this->hasOne(\App\Models\StudentEnglishTest::class, 'student_id', 'student_id');
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = strtolower($value);
    }

    public function attachments()
    {
        return $this->hasMany(\App\Models\StudentAttachment::class, 'student_id', 'student_id');
    }

    public function notes()
    {
        return $this->hasMany(\App\Models\StudentNote::class, 'student_id', 'student_id');
    }
    public function visa_details()
    {
        return $this->hasOne(FundedStudentVisaDetails::class, 'student_id', 'student_id');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'student_id', 'student_id');
    }

    public function getRouteKeyName()
    {
        return 'student_id';
    }
    
    public function enrolment_pack()
    {
        return $this->hasMany(\App\Models\EnrolmentPack::class, 'student_id', 'student_id');
    }

    public function warning_history()
    {
        return $this->hasMany(\App\Models\EmailWarningTrail::class, 'student_id', 'student_id');
    }

    public function invoice()
    {
        return $this->hasMany(\App\Models\StudentInvoice::class, 'student_id', 'student_id');
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($student) {
            $student->party()->each(function ($party) {
                $party->delete();
            });

            $student->offer_letter()->each(function ($offer_letter) {
                $offer_letter->delete();
            });

            $student->completion()->each(function ($completion) {
                $completion->delete();
            });

            $student->english_test()->each(function ($eng) {
                $eng->delete();
            });

            $student->funded_course()->each(function ($funded_course) {
                $funded_course->delete();
            });

            $student->funded_detail()->each(function ($funded_detail) {
                $funded_detail->delete();
            });

            $student->contact_detail()->each(function ($contact_detail) {
                $contact_detail->delete();
            });

            $student->extra_units()->each(function ($extra_units) {
                $extra_units->delete();
            });

            $student->certificate_issuance()->each(function ($certificate_issuance) {
                $certificate_issuance->delete();
            });

            $student->attachments()->each(function ($attachments) {
                $attachments->delete();
            });

            $student->notes()->each(function ($notes) {
                $notes->delete();
            });

            $student->attendance()->each(function ($attendance) {
                $attendance->delete();
            });
        });
    }
}
