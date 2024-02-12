<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EndTrip extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'id' => 'string',
        'trip_id' => 'string',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    protected $appends = ['diesel_meter_image', 'odometer_image'];

    public function getDieselMeterImageAttribute()
    {
        return asset('uploads/endTrip/meterImage/'. $this->attributes['diesel_meter_image']);
    }

    public function getOdoMeterImageAttribute()
    {
        return asset('uploads/endTrip/odometerImage/'. $this->attributes['odometer_image']);
    }
}
