<?php

namespace App\Models;

use App\Models\Student\Student;
use App\Models\Student\Type;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class AgentApplication extends Model implements AuditableContract
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
    //
    protected $table = "agent_application";

    protected $fillable = [
        'process_id',
        'agent_name',
        'application_form',
        'ref_form_1',
        'ref_form_2',
        'agent_signature',
        'type_signature',
        'sig_acceptance_agreement',
        'status',
        'agent_id'
    ];

    protected $casts = ['application_form' => 'array','ref_form_1' => 'array','ref_form_2' => 'array'];

    public function application_attachments()
    {
        return $this->hasMany(AgentApplicationAttachment::class);
    }
    public function agent_detail()
    {
        return $this->belongsTo(AgentDetail::class, 'agent_id');
    }
}