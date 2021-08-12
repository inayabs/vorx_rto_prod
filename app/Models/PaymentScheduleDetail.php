<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class PaymentScheduleDetail extends Model implements AuditableContract
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
    protected $fillable = ['amount', 'date_paid', 'notes', 'payment_status_id', 'pre_deducted_amount', 'agent_comm_status_id', 'agent_comm_release_date', 'trainer_comm_status_id', 'trainer_release_date'];
    protected $dates = ['created_at', 'deleted_at', 'updated_at', 'date_paid'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDatePaidAttribute($value)
    {
        return  $this->$value = Carbon::parse($value)->format('d/m/Y');
    }

    public function commission_status()
    {
        return $this->belongsTo(CommissionStatus::class, 'agent_comm_status_id');
    }

    public function getTotalPaidAttribute()
    {

        $amount =  $this->where('payment_schedule_template_id', $this->payment_schedule_template_id)->where('payment_status_id', 1)->sum('amount');
        $t = 0;
        foreach ($amount as $v) {
            if ($v->payment_status_id == 1) {
                $t = $t - $v->amount;
            } else {
                $t = $t + $v->amount;
            }
        }
    }

    public function payment_schedule_template()
    {
        return $this->belongsTo(PaymentScheduleTemplate::class);
    }
}
