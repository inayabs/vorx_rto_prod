<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class FundedStudentCourseDetail extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;
    protected $table = "funded_student_course_details";
    protected $dates = ['created_at'];

    protected $fillable = [
        'outcome_id_national',
        'funding_source_national',
        'commence_prg_identifier',
        'training_contract_id',
        'client_id_apprenticeships',
        'study_reason_id',
        'funding_type',
        'specific_funding_id',
        'funding_source_state_training_authority',
        'purchasing_contract_id',
        'purchasing_contract_schedule_id',
        'associated_course_id',
        'predominant_delivery_mode',
        'full_time_leaning_option',
    ];

    public function funded_student_course()
    {
        return $this->belongsTo(FundedStudentCourse::class, 'funded_student_course_id');
    }

    public function fund_national()
    {
        return $this->belongsTo(AvtFundingSourceNational::class, 'funding_source_national', 'value');
    }

    public function study_reason(){
        return $this->belongsTo(AvtStudyReason::class,'study_reason_id','value');
    }

    public function fund_state()
    {
        return $this->belongsTo(AvtFundingSourceState::class, 'funding_source_state_training_authority', 'value');
    }
    public function delivery_mode()
    {
        return $this->belongsTo(AvtPredominantDlvrMode::class, 'predominant_delivery_mode', 'value');
    }
    public function fundingtype()
    {
        return $this->belongsTo(AvtFundingType::class, 'funding_type');
    }
    public function specficit_funding()
    {
        return $this->belongsTo(AvtSpecificFunding::class, 'specific_funding_id');
    }

    public function commencing_course(){
        return $this->belongsTo(AvtCommencingCourse::class,'commence_prg_identifier','value');
    }

}
