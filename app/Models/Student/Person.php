<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Person extends Model implements AuditableContract
{
    //
    use Auditable;
    use SoftDeletes;
    protected $auditableEvents = [
        'deleted',
        'restored',
        'updated',
        'created'
    ];

    protected $table = 'persons';
    protected $dates =  ['created_at', 'deleted_at'];

    protected $fillable = ['person_type_id', 'gender', 'firstname', 'lastname', 'middlename', 'date_of_birth', 'prefix'];


    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    // gets persons full name
    public function getFullNameAttribute()
    {
        return preg_replace('/\s+/', ' ', $this->firstname . ' ' . $this->middlename . ' ' . $this->lastname);
    }
}
