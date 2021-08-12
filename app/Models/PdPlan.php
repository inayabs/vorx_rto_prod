<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PdPlan extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'activity_type',
        'activity_description',
        'email_template_id',
        'email_to',
        'email_date',
        'activity_date',
    ];

    public function email_template(){
        return $this->belongsTo(EmailTemplate::class);
    }
}
