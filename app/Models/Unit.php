<?php

namespace App\Models;

use App\Models\Course\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Unit extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;

    protected $table = 'course_units';
    protected $casts = ['course_code' => 'array'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = [
        'id',
        'tp_code',
        'code',
        'description',
        'unit_type',
        'assessment_method',
        'nominal_hours',
        'training_method_id',
        'subject_educ_fld_identifier_id',
        'vet_flag',
        'extra_unit',
        'unit_fee',
        'active',
        'course_code',
        'scheduled_hours'
    ];

    protected $appends = ['used_by_student'];

    

    public function student_completion_detail_checker()
    {
        return $this->hasOne(StudentCompletionDetail::class, 'course_unit_code', 'code');
    }

    public function getUsedByStudentAttribute()
    {
        $check = StudentCompletionDetail::where('course_unit_code', $this->code)->get();
        
        return $check->count() > 0 ? 1 : 0;
    }

    // public function student_completion_checker()
    // {
    //     return $this->hasOne(StudentCompletion::class, 'course_code', 'code');
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
