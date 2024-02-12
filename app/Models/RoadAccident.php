<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoadAccident extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'accident_category',
        'cost',
        'description',
    ];

    protected $casts = [
        'id' => 'string',
        'trip_id' => 'string',
        'driver_id' => 'string',
        'cost' => 'string',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    // append accident image
    protected $appends = ['image'];

    public function getImageAttribute()
    {
        return asset('public/uploads/startTrip/roadAccident/'. $this->attributes['image']);
    }
}
