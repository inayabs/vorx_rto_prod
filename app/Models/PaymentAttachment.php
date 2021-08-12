<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
class PaymentAttachment extends Model implements AuditableContract
{
    //
    use Auditable;
    use SoftDeletes;

    protected $table = 'payment_detail_attachment';
    protected $fillable = ['path_id','name','hash_name','size','mime_type','ext','_input'];

    public function payment(){
        return $this->belongsTo(Collection::class,'collection_id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}

