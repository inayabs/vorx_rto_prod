<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class CoursePackage extends Model
{
    //
    // protected $table = 'offer_package';
    use SoftDeletes;

    protected $fillable = ['date_created', 'shore_type', 'location', 'name', 'description', 'is_active', 'delivery_location_id'];

    protected $dates = ['date_created'];

    public function detail()
    {
        return $this->hasMany(CoursePackageDetail::class)->orderBy('order');
    }

    public function dlvr_location(){
        return $this->belongsTo(TrainingDeliveryLoc::class,'delivery_location_id');
    }

    public function state() {
        return $this->belongsTo(AvtStateIdentifier::class, 'location', 'state_key');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($package) {
            $package->detail()->each(function ($detail) {
                $detail->delete();
            });
        });
    }
}
