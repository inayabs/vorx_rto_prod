<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Course;
use \DB;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class TrainerCommissionSetting extends Model implements AuditableContract
{
    use Notifiable;
    use SoftDeletes;
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
    * Should the timestamps be audited?
    *
    * @var bool
    */
    protected $auditTimestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'user_id', 'trainer_id', 'course_codes', 'student_quota', 'trainer_collab', 'commission_type_id', 'commission_value'];

 
    protected $dates = ['deleted_at'];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    // public function course()
    // {
    //     return $this->belongsTo(Course::class, 'course_id', 'code');
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // MUTATORS
    public function getTrainerCollabsAttribute()
    {
        $data = explode(',', $this->trainer_collab);

        $trainers = Trainer::whereIn('id', $data)->get();

        return $trainers;
    }


    public function getCoursesAttribute()
    {
        $data = explode(',', $this->course_codes);

        $courses = Course::whereIn('code', $data)->get();

        return $courses;
    }
    

    public static function getEnumColumnValues() {
 
        $type = DB::select(DB::raw("SHOW COLUMNS FROM vrx_trainer_commission_settings WHERE Field = 'commission_type_id'"))[0]->Type ;

        preg_match('/^enum\((.*)\)$/', $type, $matches);
   
        $enum_values = [];
        $value = explode(',', $matches[1]);
        foreach( $value as $enum_v )
        {
            $v = trim( $enum_v, "'" );
            $enum_values[] = [
                'type' => $v
            ];
        }

        return $enum_values;
      }
}
