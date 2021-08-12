<?php

namespace App\Models;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class StudentCompletionDetail extends Model implements AuditableContract
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

    protected $fillable = [
        'course_unit_code',
        'start_date',
        'actual_start',
        'end_date',
        'actual_end',
        'extra_unit',
        'completion_status_id',
        'completion_date',
        'unit_fee',
        'commission_fee',
        'redeem',
        'redeem_date',
        'request_date',
        'redeem_status',
        'delivery_mode_id',
        'train_org_loc_id',
        'trainer_id',
        'training_hours',
        'holidays',
        'order'
    ];

    public function completion()
    {
        return $this->belongsTo(StudentCompletion::class, 'student_completion_id', 'id');
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'course_unit_code', 'code');
    }
    public function status()
    {
        return $this->belongsTo(AvtCompletionStatus::class, 'completion_status_id');
    }
    public function training_delivery_location()
    {
        return $this->belongsTo(TrainingDeliveryLoc::class, 'train_org_loc_id', 'train_org_dlvr_loc_id');
    }

    public function delivery_mode()
    {
        return $this->belongsTo(AvtDeliveryMode::class, 'delivery_mode_id', 'value');
    }
}
