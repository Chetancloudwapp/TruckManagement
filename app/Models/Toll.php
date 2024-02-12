<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Toll extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'trip_id',
        'driver_id',
        'toll_name',
        'amount'
    ];

    protected $casts = [
        'id'        => 'string',
        'trip_id'   => 'string',
        'driver_id' => 'string',
    ];

    protected $appends = ['toll_image'];

    public function getTollImageAttribute()
    {
        return asset('public/uploads/startTrip/tolls/'. $this->attributes['toll_image']) ?? asset('public/uploads/placeholder/default_user.png');
    }

}
