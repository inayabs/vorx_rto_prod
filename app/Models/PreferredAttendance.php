<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PreferredAttendance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'class_id',
        'unit_code',
        'date_taken',
        'pref_time_start',
        'pref_time_end',
    ];
}
