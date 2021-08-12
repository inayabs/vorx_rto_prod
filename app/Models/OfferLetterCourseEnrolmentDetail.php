<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class OfferLetterCourseEnrolmentDetail extends Model
{
    //
    use SoftDeletes;

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
        'offer_letter_course_detail_id',
    ];

    public function course_detail()
    {
        return $this->belongsTo(OfferLetterCourseDetail::class, 'offer_letter_course_detail_id');
    }
}
