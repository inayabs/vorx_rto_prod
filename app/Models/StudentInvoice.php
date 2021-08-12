<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;


class StudentInvoice extends Model implements AuditableContract
{
    
    use SoftDeletes;
    use Auditable;

    protected $table = "student_invoice";
    protected $dates = ['created_at'];

    protected $fillable = [
        'student_id',
        'course_code',
        'invoice_number',
        'transaction_number',
        'amount',
        'items',
        'date',
        'due_date',
        'user_id',
        'payment_schedule_template_id',
        'description'
    ];

    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function payment_template()
    {
        return $this->belongsTo(PaymentScheduleTemplate::class, 'payment_schedule_template_id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_code', 'code');
    }
}
