<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class CertificateIssuanceDetail extends Model implements AuditableContract
{
    //
    use SoftDeletes;
    use Auditable;

    protected $auditableEvents = [
        'deleted',
        'restored',
        'updated',
        'created'
    ];

    protected $casts = [
        'units' => 'array'
    ];

    protected $dates = ['created_at', 'deleted_at', 'updated_at'];

    protected $fillable = ['units', 'release_date','sent', 'reissued_date', 'reissue', 'release', 'soa_number', 'extra_unit_id'];

    public function certificte_issuance()
    {
        return $this->belongsTo(StudentCertificateIssuance::class, 'student_certificate_issuance_id');
    }
}
