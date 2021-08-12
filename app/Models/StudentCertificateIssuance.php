<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentCertificateIssuance extends Model implements AuditableContract
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

    protected $fillable = ['student_id', 'student_completion_id', 'generated_cert_num', 'manual_cert_num', 'issued_date', 'released_date', 'enrolment_date', 'expected_course_completion'];

    public function details()
    {
        return $this->hasMany(CertificateIssuanceDetail::class);
    }

    public function student()
    {
        return $this->belongsTo(Student\Student::class, 'student_id', 'student_id');
    }
    public function completion()
    {
        return $this->belongsTo(StudentCompletion::class, 'student_completion_id');
    }

    public function sentCert()
    {
        return $this->hasMany(SentCertificate::class, 'certificate_issuance_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($certificate) {
            $certificate->details()->each(function ($details) {
                $details->delete();
            });
        });
    }
}
