<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentCommissionSettingMain extends Model
{
    //
    protected $fillable = [
        'agent_id',
        'user_id',
        'gst_type',
        'gst_status',
        'registered_date',
        'course_id',
        'commision_value',
        'commission_type',
        'commission_cutoff',
        'remarks',
    ];

    public function sub_settings(){
        return $this->hasMany(AgentCommissionSettingSub::class);
    }

    public function cutoff_period()
    {
        return $this->hasOne(CommissionCutoff::class, 'id', 'commission_cutoff');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
