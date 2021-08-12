<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Party extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;

    protected $auditableEvents = [
        'deleted',
        'restored',
        'updated',
        'created'
    ];
    protected $table = 'party';

    protected $dates = ['created_at', 'deleted_at'];

    protected $fillable = ['name', 'party_type_id', 'active', 'conversion_id'];

    public function person()
    {
        return $this->hasOne(Person::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }
    // public function contact(){
    //     return $this->hasOne(\App\Models\FundedStudentContactDetails::class);
    // }
    public function user()
    {
        return $this->hasOne(\App\Models\User::class);
    }
    public static function boot()
    {
        parent::boot();
        self::deleting(function ($party) {
            $party->person()->each(function ($person) {
                $person->delete();
            });
        });
    }
}
