<?php

namespace App\Models;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class EmailWarningTrail extends Model implements AuditableContract
{
    //
    use Auditable;
    use SoftDeletes;
    
    protected $table = 'email_warnings';
    protected $fillable = ['student_id', 'email_template_id', 'email_template_type', 'amount_due', 'date_sent', 'course_code', 'user_id', 'status_id'];
    protected $dates = ['created_at', 'update_at', 'deleted_at'];

    public function student()
    {
        return $this->belongsTo(\App\Models\Student\Student::class, 'student_id', 'student_id');
    }
    public function template()
    {
        return $this->hasOne(\App\Models\EmailTemplate::class, 'id', 'email_template_id');
    }
}
