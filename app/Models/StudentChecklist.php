<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class StudentChecklist extends Model
{
    //
    use SoftDeletes;
    
    protected $fillable = ['student_id','checklist'];

    protected $casts = [
        'array'
    ];

    public function student(){
        return $this->belongsTo(Student\Student::class,'student_id');
    }
}
