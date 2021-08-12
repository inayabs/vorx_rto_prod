<?php

namespace App\Models\Avetmiss;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class AvtProcess extends Model implements AuditableContract
{
    use Auditable;
    use SoftDeletes;

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

    //
    protected $table = 'avt_process';

    protected $fillable = ['process', 'dateFrom', 'dateTo', 'user', 'status_id', 'report_to', 'is_locked'];

    public function avt_status()
    {
    	return $this->belongsTo(AvtStatus::class, 'status_id');
    }

    public function nat10()
    {
        return $this->hasMany(Avt10::class, 'avt_process_id', 'process');
    }
    public function nat20()
    {
        return $this->hasMany(Avt20::class, 'avt_process_id', 'process');
    }
    public function nat30()
    {
        return $this->hasMany(Avt30::class, 'avt_process_id', 'process');
    }
    public function nat60()
    {
        return $this->hasMany(Avt60::class, 'avt_process_id', 'process');
    }
    public function nat80()
    {
        return $this->hasMany(Avt80::class, 'avt_process_id', 'process');
    }
    public function nat85()
    {
        return $this->hasMany(Avt85::class, 'avt_process_id', 'process');
    }
    public function nat90()
    {
        return $this->hasMany(Avt90::class, 'avt_process_id', 'process');
    }
    public function nat100()
    {
        return $this->hasMany(Avt100::class, 'avt_process_id', 'process');
    }
    public function nat120()
    {
        return $this->hasMany(Avt120::class, 'avt_process_id', 'process');
    }
    public function nat130()
    {
        return $this->hasMany(Avt130::class, 'avt_process_id', 'process');
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

}
