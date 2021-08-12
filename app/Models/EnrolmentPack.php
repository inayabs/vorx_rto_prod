<?php

namespace App\Models;

use App\Models\Student\OfferLetter\OfferLetter;
use App\Models\Student\Student;
use App\Models\Student\Type;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class EnrolmentPack extends Model implements AuditableContract
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
    //
    protected $table = "enrolment_pack";

    protected $fillable = [
        'process_id',
        'student_name',
        'enrolment_form',
        'lln',
        'ptr',
        'student_signature',
        'type_signature',
        'sig_acceptance_agreement',
        'status',
        'student_id',
        'enrolment_type'
    ];

    protected $casts = ['enrolment_form' => 'array'];


    public function ep_attachments()
    {
        return $this->hasMany(EnrolmentPackAttachment::class);
    }

    public function ep_attachment_initial_payment()
    {
        return $this->hasMany(EnrolmentPackAttachment::class)->where('_input', 'initial_payment_receipt')->orderBy('id', 'desc');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function offer_letter(){
        return $this->belongsTo(OfferLetter::class,'process_id','process_id');
    }

    public function funded_course(){
        return $this->hasMany(FundedStudentCourse::class,'process_id','process_id');
    }
        
}
