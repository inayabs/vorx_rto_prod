<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements AuditableContract
{
    use Notifiable;
    use SoftDeletes;
    use Auditable;
    use HasRoles;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'department_type', 'is_active', 'email_password', 'profile_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_tokent',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     *
     * Person Model Relation
     *
     */
    public function party(){
        return $this->belongsTo(Student\Party::class);
    }

    /**
     *
     * Get department
     *
     */
    public function department(){
        return $this->belongsTo(Departments::class);
    }
    /**
     *
     * Get User email
     *
     */
    // public function email()
    // {
    //     return $this->hasOne(Email::class);
    // }

    public function getNoDemoAttribute(){
        return implode('|', Role::where('name', '!=', 'Demo')->pluck('name')->toArray());
    }

    
    public function trainer(){
        return $this->hasOne(Trainer::class, 'hasLogins');
    }

    public function agent_details(){
        return $this->hasOne(AgentDetail::class);
    }

    

}
