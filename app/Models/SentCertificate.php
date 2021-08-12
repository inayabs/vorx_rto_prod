<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SentCertificate extends Model
{
    //

    public function certificate()
    {
        return $this->belongsTo(StudentCertificateIssuance::class, 'certificate_issuance_id');
    }
}
