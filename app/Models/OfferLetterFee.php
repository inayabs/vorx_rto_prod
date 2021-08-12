<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class OfferLetterFee extends Model implements AuditableContract
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

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'initial_payment_date_paid', 'initial_payment_commission_release_date','installment_start_date'];

    protected $fillable = ['course_tuition_fee', 'application_fee', 'materials_fee', 'total_course_fee', 'oshc', 'total_course_fee_due', 'payment_required','payment_due', 'balance_due', 'initial_payment_amount', 'initial_payment_ddate_paid', 'initial_payment_commission_payable_amount', 'initial_payment_commission_amount', 'installment_start_date','initial_payment_commission_pre_deducted_amount', 'initial_payment_commission_release_status_id', 'initial_payment_commission_release_date', 'discounted_amount','installment_desired_amount','installment_interval'];


    public function offer_letter()
    {
        return $this->belongsTo(\App\Models\Student\OfferLetter\OfferLetter::class);
    }

    public function discount()
    {
        return $this->belongsTo(OfferLetterDiscount::class, 'discount_id');
    }
}
