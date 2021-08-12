<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StripePayment extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'firstname',
        'lastname',
        'address',
        'postcode',
        'receipt_email',
        'contact_no',
        'currency',
        'amount',
        'name_on_card'
    ];
}
