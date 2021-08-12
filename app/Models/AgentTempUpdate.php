<?php

namespace App\Models;

use App\Models\Student\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class AgentTempUpdate extends Model implements AuditableContract
{
    //
    use Auditable;
    use SoftDeletes;

    protected $casts = ['inputs' => 'array'];

    protected $fillable = ['student_id','inputs','module','agent_id'];


    public function student(){
        return $this->belongsTo(Student::class,'student_id','student_id');
    }

    public function agent(){
        return $this->belongsTo(AgentDetail::class,'agent_id');
    }
}
