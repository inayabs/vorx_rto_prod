<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class StateIdentifier extends Model
{
	protected $table = 'avt_state_identifier';

	public function training_locations(){
		return $this->hasMany(TrainingDeliveryLoc::class,'value','state_id');
	}
}
