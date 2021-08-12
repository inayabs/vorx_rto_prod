<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class EnrolmentPackAttachment extends Model implements AuditableContract
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


    protected $fillable = ['path_id', 'name', 'hash_name', 'size', 'mime_type', 'ext', '_input', 'process_id', 'linked'];
    protected $dates = ['created_at'];

    public function enrolment_pack()
    {
        return $this->belongsTo(EnrolmentPack::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
