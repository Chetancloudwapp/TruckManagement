<?php

namespace App\Exports;

use Modules\Admin\app\Models\Trip;
use Modules\Admin\app\Models\TruckDriver;
use Modules\Admin\app\Models\Truck;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TripExpensesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    protected $fromDate;
    protected $toDate;

    public function __construct($fromDate, $toDate)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }
    
    public function collection()
    {
        // return Trip::select('trip_number','loading_location','offloading_location','start_date')->get();
        $gettrip = Trip::with(['add_on_diesels','enroute_diesels','repairs','tolls','road_accidents','fines', 'other_charges','delivery_note','end_trip'])
        ->whereDate('start_date','>=',$this->fromDate)
        ->whereDate('end_date','<=',$this->toDate)
        ->where('status','Completed')
        ->get();
        $arraydata = [];
        foreach($gettrip as $row){
            
            $total = 0;
            $aodtotal = 0;
            foreach($row->add_on_diesels  as $aod){
                $aodtotal+=$aod->unit_price;
                $total+=$aod->unit_price;
            }
        
            foreach($row->enroute_diesels  as $ed){
              $aodtotal+= $ed->unit_price; 
            }
            
            $repair_total_amount = 0;
            foreach($row->repairs  as $ed){
              $repair_total_amount+= $ed->total_amount; 
              $total+= $ed->total_amount; 
            }
            
            $total_tolls = 0;
            foreach($row->tolls  as $ed){
              $total_tolls+= $ed->amount; 
              $total+= $ed->amount; 
            }
            
            
            $total_fines = 0;
            foreach($row->fines  as $ed){
              $total_fines+= $ed->amount; 
              $total+= $ed->amount; 
            }
            
            $total_other_charges = 0;
            foreach($row->other_charges  as $ed){
              $total_other_charges+= $ed->amount; 
              $total+= $ed->amount; 
            }
            
          $gettruckdriver = TruckDriver::where('trip_id',$row->id)->first();
          $getdriver      = User::find($gettruckdriver->driver_id);
          $gettruck       = Truck::where('id',$gettruckdriver->truck_id)->first();
          
          $arraydata[] = [
            'Trip ID'=>$row->trip_number,
            'Trip name'=>$row->name,
            'Truck Plate'=>$gettruck->plate_number,
            'Driver'=>$getdriver->first_name.' '.$getdriver->last_name,
            'Start Date'=>$row->start_date,
            'Diesel'=>$aodtotal? $aodtotal:'0',
            'Mileage'=>$row->mileage_allowance,
            'Road toll'=>$row->road_toll, 
            'Toll'=>$total_tolls ? $total_tolls:'0',
            'Movement sheet'=>$row->movement_sheet ? $row->movement_sheet:'0',
            'Repairs'=>$repair_total_amount? $repair_total_amount:'0',
            'Fine'=>$total_fines? $total_fines:'0',
            'Other'=>$total_other_charges ? $total_other_charges:'0',
            'Total' =>$total
          ];  
          
          
        }
        
        return collect($arraydata);
        
    }

    public function headings(): array
    {
        return [
            'Trip ID',
            'Trip name',
            'Truck Plate',
            'Driver',
            'Start Date',
            'Diesel',
            'Mileage',
            'Road toll',
            'Toll',
            'Movement sheet',
            'Repairs',
            'Fine',
            'Other',
            'Total'
        ];
    }
}
