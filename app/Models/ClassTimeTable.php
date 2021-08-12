<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class ClassTimeTable extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;
    
    protected $fillable = ['total_training_hours', 'total_weeks', 'time_table', 'training_days_weekly', 'training_hours_daily', 'duration_month', 'duration_year', 'training_hours_weekly', 'duration_start_date'];

    protected $casts = ['time_table' => 'array', 'training_days_weekly' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function class()
    {
        return $this->belongsTo(StudentClass::class);
    }
}
