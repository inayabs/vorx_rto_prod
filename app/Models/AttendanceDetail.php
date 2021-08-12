<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class AttendanceDetail extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'attendance_id',
        'unit_code',
        'date_taken',
        'preferred_hours',
        'actual_hours',
        'status'
    ];
    

    public function course_unit(){
        return $this->belongsTo(Unit::class,'unit_code','code');
    }

    public function attendance(){
        return $this->belongsTo(Attendance::class);
    }

    public function getTimeToHoursAttribute() {
        if(!in_array($this->time_start, [null, '', 0]) || !in_array($this->time_end, [null, '', 0])){
            $sTime = Carbon::parse($this->time_start);
            $eTime = Carbon::parse($this->time_end);
            $hours = $eTime->floatDiffInHours($sTime);
        }else{
            $hours = 0;
        }

        return $hours;  
    }
}
