<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentAissAttachment extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;
    protected $table = 'student_aiss_attachments';
    protected $auditableEvents = [
        'deleted',
        'restored',
        'updated',
        'created'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['student_id', 'path_id', 'student_attachment_type_id', 'name', 'hash_name', 'size', 'mime_type', 'ext', '_input','user_id'];

    public function student()
    {
        return $this->belongsTo(Student\Student::class, 'student_id', 'student_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
