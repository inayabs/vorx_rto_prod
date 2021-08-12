<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class OnlinePayment extends Model implements AuditableContract
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

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = [
        'student_id',
        'trxn_code',
        'firstname',
        'lastname',
        'email_ad',
        'amount',
        'card_number',
        'name_on_card',
        'card_expiry_month',
        'card_expiry_year',
        'card_type',
        'cvv',
        'response',
        'site_source',
        'user_id',
        'remarks'
    ];
}
