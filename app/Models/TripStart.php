<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TripStart extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'exact_km_driven',
    ];

    protected $casts = [
        'id' => 'string',
    ];
}
