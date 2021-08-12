<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseAttachment extends Model implements AuditableContract
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

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['course_code', 'path_id', 'name', 'hash_name', 'size', 'mime_type', 'ext', '_input'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_code', 'code');
    }

}
