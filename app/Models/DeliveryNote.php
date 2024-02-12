<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Trait\ImageTrait;

class DeliveryNote extends Model
{
    use ImageTrait;
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'trip_id',
        'delivery_note',
    ];

    protected $casts = [
        'id' => 'string',
        'trip_id' => 'string',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    // append delivery note
    protected $appends = ['image'];

    /* -- get image path -- */
    public function getImageAttribute()
    {
        return asset('public/uploads/startTrip/deliveryNote/'. $this->attributes['image']);
    }



}
