<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class AvtFundingType extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;

    protected $fillable = [
        'name',
        'state_key',
        'state_funding_code',
        'national_funding_code',
        'specific_funding_code',
        'traineeship_apprenticeship',
        'funding_disclosed',
        'vet_student_loan',
        'purchasing_contract',
        'purchasing_schedule',
        'intake_number',
        'acquitted',
        'training_contract',
        'funding_removed',
        'course_site_id',
        'booking_id',
        'avetmiss',
        'created_at',
        'updated_at',
        'deleted_at',
        'user_id'
    ];
}
