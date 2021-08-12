<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StripeCustomer extends Model
{
    use SoftDeletes;
    //

    protected $fillable = [
        'student_id',
        'customer_id'
    ];
}
