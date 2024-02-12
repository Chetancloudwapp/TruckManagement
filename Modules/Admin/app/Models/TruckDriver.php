<?php

namespace Modules\Admin\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\factories\TruckDriverFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class TruckDriver extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'truck_id',
        'driver_id',
    ];

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];
    
    protected static function newFactory(): TruckDriverFactory
    {
        //return TruckDriverFactory::new();
    }

    public function trip(){
        return $this->belongsTo('Modules\Admin\app\Models\Trip', 'trip_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'driver_id');
    }
}
