<?php

namespace App\Models;

use App\Models\Student\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class StudentNote extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;

    protected $dates =  ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'remarks',
        'date_notes',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
