<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class AgentCommissionSetting extends Model implements AuditableContract
{
    use SoftDeletes;
    use Auditable;

    protected $fillable = [
        'commission_type_id',
        'commission_value',
        'course_code',
        'agent_id',
        'gst_type',
        'remarks',
        'registered_gst',
        'registered_gst_date',
        'starting_student_count',
        'starting_commission_value',

    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'registered_gst_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function getRealCommissionValueAttribute()
    {
        $value = 0;
        if($this->gst_type == 'Including'){
            $value = round(($this->commission_value / 10) + $this->commission_value);
        }else{
            $value = $this->commission_value;
        }
        return $value;
    }
}
