<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class CourseAvtDetail extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;

    protected $table = 'course_avt_details';

    protected $fillable = [
        'course_code',
        'nominal_hours',
        'prg_recog_identifier_id',
        'prg_lvl_of_educ_identifier_id',
        'qlf_field_of_educ_identifier_id',
        'anzsco_identifier_id',
        'vet_flag_status'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function avt_anzsco()
    {
        return $this->belongsTo(AvtAnzscoIdentifier::class, 'anzsco_identifier_id', 'id');
    }

    public function avt_qlf()
    {
        return $this->belongsTo(AvtQlfFieldOfEducIdentifier::class, 'qlf_field_of_educ_identifier_id', 'id');
    }

    public function avt_prg_lvl()
    {
        return $this->belongsTo(AvtPrgLvlOfEducIdentifier::class, 'prg_lvl_of_educ_identifier_id', 'id');
    }

    public function avt_prg_recog()
    {
        return $this->belongsTo(AvtPrgRecogIdentifier::class, 'prg_recog_identifier_id', 'id');
    }

}
