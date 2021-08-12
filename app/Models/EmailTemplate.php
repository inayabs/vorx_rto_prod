<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplate extends Model implements AuditableContract
{
    //
    use Auditable;
    use SoftDeletes;

    protected $fillable = ['name', 'email_subject', 'email_module_id', 'email_content', 'email_type', 'active', 'interval', 'succeeding_email_type', 'add_on'];
    protected $dates = ['created_at', 'update_at', 'deleted_at'];

    public function email_module()
    {
        return $this->belongsTo(EmailModule::class, 'email_module_id', 'id');
        // return $this->belongsTo(EmailModule::class, 'email_module_id', 'id');
    }
}
