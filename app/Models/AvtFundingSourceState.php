<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvtFundingSourceState extends Model
{
    //
    protected $table = 'avt_funding_source_state';

    protected $fillable = ['location', 'value', 'description'];

    public function state()
    {
        return $this->belongsTo(AvtStateIdentifier::class, 'state_key');
    }
}
