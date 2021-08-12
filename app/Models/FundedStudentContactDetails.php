<?php

namespace App\Models;

use App\Models\Student\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class FundedStudentContactDetails extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;
    protected $table = "funded_student_contact_details";
    protected $dates = ['created_at'];

    protected $fillable = [
        'student_id',
        'addr_suburb',
        'addr_postal_delivery_box',
        'addr_street_name',
        'addr_street_num',
        'addr_flat_unit_detail',
        'addr_building_property_name',
        'postcode',
        'state_id',
        'phone_home',
        'phone_work',
        'phone_mobile',
        'email',
        'email_at',
        "emer_name",
        "emer_address",
        "emer_telephone",
        "emer_relationship"
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function party()
    {
        return $this->belongsTo(Party::class, 'student_id');
    }
    public function type()
    {
        return $this->belongsTo(Type::class, 'student_type_id');
    }

    public function state()
    {
        return $this->belongsTo(StateIdentifier::class, 'state_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    public function postcode(){
        return $this->belongsTo(AvtPostcode::class,'postcode','postcode');
    }

    public function getAddressAttribute()
    {
        $address = '';
        $address .= !in_array($this->addr_flat_unit_detail, ['', null]) ? ''. $this->addr_flat_unit_detail : $address;
        $address .= !in_array($this->addr_building_property_name, ['', null]) ? ' '. $this->addr_building_property_name : $address;
        $address .= !in_array($this->addr_street_num, ['', null]) ? ' '. $this->addr_street_num : $address;
        $address .= !in_array($this->addr_street_name, ['', null]) ? ' '. $this->addr_street_name : $address;
        $address .= !in_array($this->addr_suburb, ['', null]) ? ' '. $this->addr_suburb : $address;
        $address .= isset($this->state->state_key) ? ' '. $this->state->state_key : $address;
        $address .= !in_array($this->postcode, ['', null]) ? ' '. $this->postcode : $address;
        $address = ltrim($address);
        // dd($address);
        return $address;

    }

    public function getSuburbAttribute(){
        $lang = AvtPostcode::where('postcode',$this->postcode)->where('suburb',$this->addr_suburb)->select(DB::raw("CONCAT(postcode ,' - ',suburb,', ',state) AS label"), 'id as value')->first();
        return $lang;
    }
}
