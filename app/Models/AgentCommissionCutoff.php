<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentCommissionCutoff extends Model
{
    //

    protected $fillable = [
        'agent_id',
        'serial_no',
        'total_amount_received',
        'total_commission_paid',
        'total_payable_gst',
        'cutoff',
        'total_actual_amount_received' ,
        'total_computed_commission',
        'due_comission' ,
        'total_pre_deducted_comission' ,
        'total_over_payment'
    ];


    public function commission_details(){
        return $this->hasMany(CommissionDetail::class,'serial_no','serial_no');
    }

    public function agent_detail(){
        return $this->belongsTo(AgentDetail::class,'agent_id');
    }
}
