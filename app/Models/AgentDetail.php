<?php

namespace App\Models;

use App\Models\Student\OfferLetter\OfferLetter;
use App\Models\FundedStudentCourse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class AgentDetail extends Model implements AuditableContract
{

    use SoftDeletes;
    use Auditable;
    //
    protected $fillable = [
        'email',
        'email_2',
        'office_address',
        'notes',
        'company_name',
        'agent_name',
        'position',
        'phone',
        'phone_2',
        'mobile',
        'mobile_2',
        'fax_number',
        'website',
        'agent_type',
        'bank_name',
        'account_name',
        'bsb',
        'account_number',
        'agent_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function user_reference()
    {
        return $this->belongsTo(User::class, 'user_reference_id');
    }

    public function commission_settings(){
        return $this->hasMany(AgentCommissionSettingMain::class,'agent_id');
    }

    public function agent_application()
    {
        return $this->hasOne(AgentApplication::class, 'agent_id');
    }

    public function attachments()
    {
       return $this->hasMany(AgentAttachment::class,'agent_id');
    }

    public function offer_letters(){
        return $this->hasMany(OfferLetter::class,'agent_id')->groupBy('student_id');
    }

    public function commissions(){
        return $this->hasMany(AgentCommissionCutoff::class,'agent_id')->orderBy('id','DESC');
    }

    public function funded_course(){
        return $this->hasMany(FundedStudentCourse::class,'agent_id');
    }
}
