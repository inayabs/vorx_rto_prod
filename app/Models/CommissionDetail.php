<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionDetail extends Model
{
    //
    protected $fillable = [
        'serial_no',
        'payment_id',
        'payment_date',
        'agent_commission_settings_sub_id',
        'commission_payable',
        'computed_commission',
        'pre_deducted_comission',
        'comm_release_status',
        'actual_amount',
        'amount_received',
        'accumulated',
        'cutoff',
        'payment_sched_id'
    ];

    public function commission_sub(){
        return $this->hasOne(AgentCommissionSettingSub::class, 'id','agent_commission_settings_sub_id');
    }

    public function payment_detail(){
        return $this->hasOne(FundedStudentPaymentDetails::class,'id','payment_id');
    }


}
