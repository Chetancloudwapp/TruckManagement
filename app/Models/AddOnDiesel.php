<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Trait\ImageTrait;
class AddOnDiesel extends Model
{
    use HasFactory,ImageTrait;
    
    protected $fillable = [
        'quantity_in_litres',
        'unit_price',
        'petrol_station',
    ];
    
    protected $hidden = [
        'deleted_at',
    ];
    
    protected $casts = [
        'id' => 'string',
        'trip_id' => 'string',
        'driver_id' => 'string',
    ];
    
    protected $appends = ['petrol_station_image'];
    
    public function getPetrolStationImageAttribute()
    {
        // Access the value of petrol_station_image attribute and return it with a prefix
        return asset('public/uploads/startTrip/addonDiesel/'. $this->attributes['petrol_station_image']);
    }

}
