<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Trait\ImageTrait;
class Repair extends Model
{
    use HasFactory,SoftDeletes,ImageTrait;

    protected $fillable = [
        'shop_name',
        'repair_name',
        'repair_cost',
        'spare_name',
        'spare_cost',
        'total_amount'
    ];

    protected $casts = [
        'id' => 'string',
        'trip_id' => 'string',
        'driver_id' => 'string',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    // append bill image 
    protected $appends = ['upload_bill'];

    public function getUploadBillAttribute(){
        return asset('public/uploads/startTrip/repairs/'. $this->attributes['upload_bill']);
    }
   
}
