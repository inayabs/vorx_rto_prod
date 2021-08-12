<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Models\Course\Course;

class Trainer extends Model implements AuditableContract
{
	use Auditable;

    /**
     * Auditable events.
     *
     * @var array
     */
    protected $auditableEvents = [
        'deleted',
        'restored',
        'updated',
        'created'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [ 
        'id',
        'user_id',
        'firstname',
        'middlename',
        'lastname',
        'email',
        'phone_number',
        'course_taught',
        'course_location',
        'receive_email'
    ];

    protected $casts = ['course_taught' => 'array'];

    /**
    * Should the timestamps be audited?
    *
    * @var bool
    */
    protected $auditTimestamps = true;

    //

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    // public function trainer_course()
    // {
    //     return $this->hasMany(TrainerCourse::class);
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function has_login()
    {
        return $this->belongsTo(User::class, 'hasLogins', 'id');
    }

    public function commission_settings()
    {
        return $this->hasMany(TrainerCommissionSetting::class);
    }

    public function release_commission()
    {
        return $this->hasMany(TrainerReleaseCommission::class, 'trainer_id', 'id');
    }

    public function getFullNameAttribute()
    {
        return $this->firstname .' '. $this->lastname;
    }

    public function getCoursesAttribute()
    {

        $codes = explode(',', $this->course_taught);

        $courses = [];

        foreach ($codes as $key => $value) {
            $courses[] = [
                'code' => $value,
                'name' => Course::where('code', $value)->first()->name
            ];
        }
        return $courses;
    }
    public function getFullCoursesAttribute()
    {
        $courses = [];
        if($this->course_taught != null){
            $codes = explode(',', $this->course_taught);
            foreach ($codes as $key => $value) {
                $courses[] =  $value.' - '.Course::where('code', $value)->first()->name;
            }
      
        }
        return $courses;
    }
    
}
