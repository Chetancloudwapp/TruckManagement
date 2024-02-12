<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fine extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'name',
        'amount',
        'description',
    ];

    protected $casts = [
        'id'      => 'string',
        'trip_id' => 'string',
        'amount'  => 'string',
    ];

    // append fine image
    protected $appends = ['image'];

    public function getImageAttribute()
    {
        return asset('public/uploads/startTrip/fines/'. $this->attributes['image']);
    }

}
