<?php
namespace App\Http\Trait;
trait ImageTrait
{
    

    public function getImageAttribute()
    {
        return asset('public/uploads/startTrip/deliveryNote/'. $this->attributes['image']);
    }

    public function getPetrolStationImageAttribute()
    {
        // Access the value of petrol_station_image attribute and return it with a prefix
        return asset('public/uploads/startTrip/enrouteDiesel/'. $this->attributes['petrol_station_image']);
    }

     public function getUploadBillAttribute(){
        return asset('public/uploads/startTrip/repairs/'. $this->attributes['upload_bill']);
    }
    
}


?>

