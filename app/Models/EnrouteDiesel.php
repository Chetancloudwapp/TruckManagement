<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Trait\ImageTrait;
class EnrouteDiesel extends Model
{
    use HasFactory,SoftDeletes,ImageTrait;

    protected $fillable = [
        'quantity_in_litres',
        'unit_price',
        'petrol_station',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    protected $casts = [
        'id'        => 'string',
        'trip_id'   => 'string',
        'driver_id' => 'string',
    ];

    protected $appends = ['petrol_station_image'];
  
    public function getPetrolStationImageAttribute()
    {
        // Access the value of petrol_station_image attribute and return it with a prefix
        return asset('public/uploads/startTrip/enrouteDiesel/'. $this->attributes['petrol_station_image']);
    }
   
}

