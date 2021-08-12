<?php

namespace App\Models\WP;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RTO extends Model
{
    //
    protected $connection = 'WP';
    protected $table = 'rto';

    protected $fillable = [
        'vorx_url', 'organisation_id',
    ];
}
