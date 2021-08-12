<?php

namespace App\Models;

use App\Models\Course\Course;
use App\Models\Student\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgentCommissionSettingSub extends Model
{
    //
    use SoftDeletes;

    public $fillable = [
        'agent_id',
        'student_id',
        'student_course_id',
        'gst_type',
        'gst_status',
        'registered_date',
        'course_id',
        'commision_value',
        'commission_limit',
        'commission_type',
        'commission_cutoff',
        'cut_off_period',
        'remarks',
    ];

    public function main(){
        return $this->belongsTo(AgentCommissionSettingMain::class, 'agent_commission_setting_main_id');
    }

    public function student(){
        return $this->belongsTo(Student::class,'student_id','student_id');
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function cutoff_period(){
        return $this->hasOne(CommissionCutoff::class,'id', 'commission_cutoff'); 
    }

    public function commission_details(){
        return $this->hasMany(CommissionDetail::class,'agent_commission_settings_sub_id');
    }

    public function student_course(){
        return $this->belongsTo(FundedStudentCourse::class,'student_course_id');
    }
}
