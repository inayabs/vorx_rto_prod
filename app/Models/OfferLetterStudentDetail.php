<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class OfferLetterStudentDetail extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;
       
    // protected $dates = ['created_at','updated_at','deleted_at','passport_exp_date'];

    protected $fillable  = ['current_address','home_address','country','state_province','postcode','mobile','telephone','email_personal','country_birth','visa_no','passport_no','passport_exp_date'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    public function offer_letter(){
        return $this->belongsTo(\App\Models\Student\OfferLetter\OfferLetter::class);
    }
}
