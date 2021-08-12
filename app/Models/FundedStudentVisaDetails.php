<?php

namespace App\Models;

use App\Models\Student\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class FundedStudentVisaDetails extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;
    protected $table = "funded_student_visa_details";
    protected $dates = ['created_at'];

    protected $fillable = [
        'student_id',
        'nationality',
        'passport_number',
        'issue_date',
        'expiry_date',
        'visa_type',
        'subclass',
        'expiry_date_visa_type',
        'applied_for_au_residency',
        'study_rights'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function party()
    {
        return $this->belongsTo(Party::class, 'student_id');
    }
    public function type()
    {
        return $this->belongsTo(VisaStatus::class, 'visa_type');
    }

    public function state()
    {
        return $this->belongsTo(StateIdentifier::class, 'state_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function getVisaValueAttribute(){
        $lang = VisaStatus::where('id',$this->visa_type)->select(DB::raw('id as value, IF(id=1, "Not Applicable", concat(type, " - ", visa)) AS label'))->first();
        return $lang;
    }
}
