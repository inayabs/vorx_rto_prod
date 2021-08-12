<?php

namespace App\Models;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AgentEmailWarningTrail extends Model implements AuditableContract
{
    //
    use Auditable;
    use SoftDeletes;
    
    protected $table = 'agent_email_warnings';
    protected $fillable = ['agent_application_id', 'email_template_id', 'email_template_type', 'referees', 'date_sent', 'is_sent', 'user_id'];
    protected $dates = ['created_at', 'update_at', 'deleted_at'];
    protected $casts = ['referees' => 'array'];
    
    public function agent_application()
    {
        return $this->belongsTo(\App\Models\Student\AgentApplication::class, 'id', 'agent_application_id');
    }
    public function template()
    {
        return $this->hasOne(\App\Models\EmailTemplate::class, 'id', 'email_template_id');
    }
}
