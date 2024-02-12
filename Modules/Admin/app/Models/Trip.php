<?php

namespace Modules\Admin\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\factories\TripFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    
    protected $fillable = [
        'name',
        'loading_location',
        'offloading_location',
        'start_date',
        'end_date',
        'revenue',
        'type_of_cargo',
        'weight_of_cargo',
        'initial_diesel',
        'mileage_allowance_currency',
        'mileage_allowance',
        'movement_sheet_currency',
        'movement_sheet',
        'road_toll_currency',
        'road_toll',
        'status',
        'is_status',
    ];
    
    protected static function newFactory(): TripFactory
    {
        //return TripFactory::new();
    }

    protected $casts = [
        'id'  => 'string',
        'revenue' => 'string',
        'initial_diesel' => 'string',
       
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function getTrip(){
        return $this->hasMany('Modules\Admin\app\Models\TruckDriver');
    }

    /* -- mileage allow currency relation -- */
    public function mac(){
        return $this->belongsTo('App\Models\Currency', 'mileage_allowance_currency')->select('id','name');
    }

    /* -- movement_sheet_currency relation -- */
    public function msc(){
        return $this->belongsTo('App\Models\Currency', 'movement_sheet_currency')->select('id','name');
    }

    /* -- road toll currency relation --*/
    public function rtc(){
        return $this->belongsTo('App\Models\Currency', 'road_toll_currency')->select('id','name');
    }

    // public function driver(){
    //     return $this->belongsTo('App\Models\User', 'driver')->select('id','first_name','last_name');
    // }

    // public function truck(){
    //     return $this->belongsTo('Modules\Admin\app\Models\Truck', 'truck')->select('id','brand');
    // }


    public function add_on_diesels(){
        return $this->hasMany('App\Models\AddOnDiesel', 'trip_id','id');
    }
    
    public function enroute_diesels(){
        return $this->hasMany('App\Models\EnrouteDiesel', 'trip_id','id');
    }
    
    public function tolls(){
        return $this->hasMany('App\Models\Toll', 'trip_id','id');
    }
    
    public function repairs(){
        return $this->hasMany('App\Models\Repair', 'trip_id','id');
    }
    
    public function fines(){
        return $this->hasMany('App\Models\Fine', 'trip_id','id');
    }
    
    public function road_accidents(){
        return $this->hasMany('App\Models\RoadAccident', 'trip_id','id');
    }
    
    public function other_charges(){
        return $this->hasMany('App\Models\OtherCharge', 'trip_id','id');
    }

    public function delivery_note(){
        return $this->hasMany('App\Models\DeliveryNote', 'trip_id', 'id');
    }

    public function end_trip(){
        return $this->hasMany('App\Models\EndTrip', 'trip_id', 'id');
    }
    
    // public function truckdriver()
    // {
    //     return $this->belongsToMany('App\Models\User', 'truck_drivers','id','driver_i');
    // }

}
