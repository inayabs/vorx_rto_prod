<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubMenu extends Model
{
    //
    use SoftDeletes;

    protected $casts = ['role_access' => 'array'];
}
