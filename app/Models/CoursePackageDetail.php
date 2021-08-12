<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CoursePackageDetail extends Model
{
    //
    // protected $table = 'offer_package_details';
    use SoftDeletes;

    protected $fillable = ['course_package_id', 'order', 'course_matrix_id', 'course_start_date', 'course_end_date', 'course_code', 'wk_duration', 'tuition_fee', 'material_fee'];

    protected $dates = ['course_start_date', 'course_end_date'];

    public function course()
    {
        return $this->belongsTo(CourseMatrix::class, 'course_matrix_id', 'id');
    }

    public function get_course()
    {
        return $this->belongsTo(Course::class, 'course_code', 'code');
    }
}
