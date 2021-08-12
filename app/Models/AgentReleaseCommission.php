<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class AgentReleaseCommission extends Model implements AuditableContract
{
     //
     use SoftDeletes;
     use Auditable;
 
     protected $dates = ['created_at', 'updated_at', 'deleted_at'];
 
     public function user()
     {
         return $this->belongsTo(User::class);
     }
 
     public function agent()
     {
         return $this->belongsTo(Agent::class);
     }
     public function comm_status()
     {
         return $this->belongsTo(CommissionStatus::class, 'status_id', 'id');
     }
}
