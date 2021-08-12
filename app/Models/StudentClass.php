<?php

namespace App\Models;

use App\Models\SIA\TimeTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class StudentClass extends Model
{
    use SoftDeletes;
    protected $table = 'classes';
    protected $fillable = [
        'desc',
        'trainer_id',
        'delivery_loc',
        'delivery_mode',
        'venue',
        'course_code',
        'start_date',
        'end_date',
        'location',
        'time_table_type',
        'class_status'
    ];


    // public function class_trainer(){
    //     return $this->hasMany(ClassTrainer::class,'class_id','id');
    // }
    public function getTrainerSelectedAttribute()
    {
        // $getUnit = explode(',', $this->course_units);
        $getTrainer = explode(',',$this->trainer_id);
        $unitArr = [];
        // dd($getUnit[0]->code);
        foreach ($getTrainer as $unit) {
            $unitResult = Trainer::where('id', $unit)->first();
            // dd($unitResult);
            $unitArr[] = $unitResult;
        }

        return $unitArr;
    }



    public function delivery_location(){
        return $this->belongsTo(TrainingDeliveryLoc::class,'delivery_loc','id');
    }

    public function course(){
        return $this->belongsTo(Course::class,'course_code','code');
    }

    public function time_table() {
        return $this->hasOne(ClassTimeTable::class, 'class_id');
    }

    public function attendance(){
        return $this->hasMany(Attendance::class,'class_id','id');
    }
}
