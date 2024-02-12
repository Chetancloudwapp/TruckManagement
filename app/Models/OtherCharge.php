<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherCharge extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'name',
        'amount',
        'description',
    ];

    protected $casts = [
        'id' => 'string',
        'trip_id' => 'string',
        'amount'  => 'string',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    // append other charge image
    protected $appends = ['image'];

    /* -- get image path -- */
    public function getImageAttribute()
    {
        return asset('public/uploads/startTrip/otherCharges/'. $this->attributes['image']);
    }
}
