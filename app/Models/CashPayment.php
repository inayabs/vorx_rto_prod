<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class CashPayment extends Model implements ccc
{
    //
    use SoftDeletes;
    use Auditable;

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'payment_date'];
    protected $fillable = ['payment_date', 'trxn_code', 'student_id', 'firstname', 'lastname', 'email_ad', 'address', 'remarks', 'is_initial_payment', 'payment_method_id', 'amount', 'amount_applied', 'fees_to_be_paid', 'status'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
