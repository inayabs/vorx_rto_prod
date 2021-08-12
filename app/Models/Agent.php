<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Agent extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;
    
    protected $dates = ['created_at'];

    protected $fillable = [
        'username',
        'password',
        'is_active',
        'profile_image',
    ];

    public function party()
    {
        return $this->belongsTo(\App\Models\Student\Party::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detail()
    {
        return $this->hasOne(AgentDetail::class, 'agent_id', 'id');
    }

    public function commission_settings()
    {
        return $this->hasMany(AgentCommissionSetting::class, 'agent_id', 'id');
    }
}
