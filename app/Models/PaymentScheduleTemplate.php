<?php

namespace App\Models;

use Carbon\Carbon;
use Faker\Provider\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class PaymentScheduleTemplate extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;

    protected $dates =  ['created_at', 'updated_at', 'deleted_at', 'due_date','adjusted_date'];
    protected $fillable = ['due_date', 'payable_amount', 'invoice_no','adjusted_date','commission'];

    public function offerLetter()
    {
        return $this->belongsTo(\App\Models\Student\OfferLetter\OfferLetter::class);
    }
    public function course_detail()
    {
        return $this->belongsTo(OfferLetterCourseDetail::class, 'offer_letter_course_detail_id');
    }
    public function funded_course_detail()
    {
        return $this->belongsTo(FundedStudentCourse::class, 'funded_student_course_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function payment_detail()
    {
        return $this->hasMany(FundedStudentPaymentDetails::class,'payment_schedule_template_id');
        // return $this->hasMany(PaymentScheduleDetail::class);
    }

    public function getApprovedAmountPaidAttribute(){
        $amount = FundedStudentPaymentDetails::where('payment_schedule_template_id', $this->id)->get();
        $t = 0;
        foreach ($amount as $v) {
            if ($v->verified == 1) {
                $t = $t + $v->amount;
            }
        }
        return number_format($t, 2,'.','');
    }

    public function getApprovedCommissionAttribute(){
        $amount = FundedStudentPaymentDetails::with('commission')->where('payment_schedule_template_id', $this->id)->get();
        $t = 0;
        foreach ($amount as $v) {
            if ($v->verified == 1) {
                $t = $t + $v->pre_deduc_comm;
            }
        }
        return number_format($t, 2,'.','');
    }
    public function getPredeductedComAttribute()
    {
        $amount = FundedStudentPaymentDetails::where('payment_schedule_template_id', $this->id)->get();
        $t = 0;
        foreach ($amount as $v) {
            if ($v->verified  == 1) {
                $t = $t + $v->pre_deduc_comm;
            }
        }
        return number_format($t, 2,'.','');
    }

    public function getAmountPaidAttribute()
    {
        $amount = FundedStudentPaymentDetails::where('payment_schedule_template_id', $this->id)->get();
        $t = 0;
        foreach ($amount as $v) {
            if ($v->payment_status_id == 1) {
                $t = $t - $v->amount;
            } else {
                $t = $t + $v->amount;
            }
        }
        return number_format($t, 2,'.','');
    }
   
    public function getLastPaymentDateAttribute()
    {
        $payment =  FundedStudentPaymentDetails::where('payment_schedule_template_id', $this->id)->where('verified', 1)->latest()->first();
        if ($payment != null) {
            // return $payment->date_paid;
            return Carbon::parse($payment->date_paid)->format('d/m/Y');
        } else {
            return null;
        }
    }

    public function commission(){
        return $this->hasOne(CommissionDetail::class,'payment_sched_id');
    }
    public function commission1(){
        return $this->hasMany(CommissionDetail::class,'payment_sched_id');
    }


    public function getCommissionPayableAttribute(){
        $commission = CommissionDetail::where('payment_sched_id',$this->id)->get();
        $t = 0;
        $c =0;
        foreach($commission as $c){
                $c = $c + $c->pre_deducted_commission;
                $t = $t + $c->commission_payable;
        }
        $res = $c - $t;
        // dd($res);
        if($res > 0){
            $t = 0;
        }
        return number_format($t, 2,'.','');
    }



    public function collection(){
        return $this->hasMany(Collection::class);
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($payment_template) {
            $payment_template->payment_detail()->each(function ($payment_detail) {
                $payment_detail->delete();
            });
        });
    }
}
