<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'table_name',
        'reference_id',
        'action',
        'date_recorded',
        'message',
        'is_seen',
        'link',
        'table_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
