<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseProspectus extends Model implements AuditableContract
{
    //
    use Auditable;
    use SoftDeletes;

    protected $table = 'course_prospectuses';
    protected $dates = ['date_implemented', 'created_at', 'update_at', 'deleted_at'];

    protected $fillable = [
        'id',
        'course_code',
        'name',
        'date_implemented',
        'location',
        'course_units',
        'train_org_dlvr_loc_id',
        'is_active',
    ];

    public function getUnitSelectedAttribute()
    {
        // $getUnit = explode(',', $this->course_units);
        $getUnit = json_decode($this->course_units);
        
        $unitArr = [];
        // dd($getUnit[0]->code);
        foreach ($getUnit as $unit) {
            // $unitResult = Unit::select(['code', 'description', 'unit_type'])->where('code', $unit->code)->first();
            $unitResult = Unit::where('code', $unit->code)->first();
            // dd($unitResult);
            $unitArr[] = $unitResult;
        }

        return $unitArr;
    }

    // public function getActiveLabelAttribute() {
    //     $getStatus = $this->is_active? "Active" : "Not Active";
    //     return $getStatus;
    // }
}
