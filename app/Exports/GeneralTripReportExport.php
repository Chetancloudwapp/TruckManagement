<?php

namespace App\Exports;

use Modules\Admin\app\Models\Trip;
use Modules\Admin\app\Models\TruckDriver;
use Modules\Admin\app\Models\Truck;
use App\Models\{EndTrip,User,RoadAccident,TripStatusTracking};
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class GeneralTripReportExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    protected $fromDate;
    protected $toDate;

    public function __construct($fromDate, $toDate){
        $this->fromDate = $fromDate;
        $this->toDate   = $toDate;
    }
    
    public function collection(){
        
        $gettrip = Trip::with(['add_on_diesels','enroute_diesels','repairs','tolls','road_accidents','fines', 'other_charges','delivery_note','end_trip'])
        ->whereDate('start_date','>=',$this->fromDate)
        ->whereDate('end_date','<=',$this->toDate)
        ->where('status','Completed')
        ->get();
        $arraydata = [];
        $i=1;
        foreach($gettrip as $row){
            
            $total    = 0;
            $aodtotal = 0;
            $overallcost = 0;
            foreach($row->add_on_diesels  as $aod){
                $aodtotal+=$aod->unit_price;
                $total+=$aod->unit_price;
                $overallcost+=$aod->unit_price;
            }
            
            $enroute_diesels_price = 0;
            foreach($row->enroute_diesels  as $ed){
              $enroute_diesels_price+= $ed->unit_price; 
              $total+=$aod->unit_price;
              $overallcost+=$aod->unit_price;
            }
            
            $repair_total_amount = 0;
            $repairs = [];
            foreach($row->repairs  as $ed){
              $repair_total_amount+= $ed->total_amount; 
              $total+= $ed->total_amount; 
              $repairs[] = $ed->repair_name;
              $overallcost+=$ed->total_amount;
            }
            
            $total_tolls = 0;
            foreach($row->tolls  as $ed){
              $total_tolls+= $ed->amount; 
              $total+= $ed->amount; 
              $overallcost+=$ed->amount;
              
            }
            
            
            $total_fines = 0;
            $fines = [];
            foreach($row->fines  as $ed){
              $total_fines+= $ed->amount; 
              $total+= $ed->amount; 
              $overallcost+=$ed->amount;
              
              $fines[] = $ed->name;
            }
            
            $total_other_charges = 0;
            foreach($row->other_charges  as $ed){
              $total_other_charges+= $ed->amount; 
              $total+= $ed->amount; 
              $overallcost+=$ed->amount;
            }
            
            
            $total_road_accident = 0;
            foreach($row->road_accidents as $ed){
              $total_road_accident+=$ed->cost;
            }
          
          $gettruckdriver = TruckDriver::where('trip_id',$row->id)->first();
          if($gettruckdriver){
              
          $getdriver      = User::find($gettruckdriver->driver_id);
          $gettruck       = Truck::where('id',$gettruckdriver->truck_id)->first();
          
          
          $accept_trip    = TripStatusTracking::where('trip_id',$row->id)->where('status','Accepted')->first();
          $loading_trip   = TripStatusTracking::where('trip_id',$row->id)->where('status','Loading')->first();
          $start_trip     = TripStatusTracking::where('trip_id',$row->id)->where('status','Start')->first();
          $deliverd       = TripStatusTracking::where('trip_id',$row->id)->where('status','Delivered')->first();
          $end_trip       = TripStatusTracking::where('trip_id',$row->id)->where('status','Completed')->first();
          
          $overallcost = $row->movement_sheet ? $overallcost+$row->movement_sheet:$overallcost;
          $arraydata[] = [
            'No'       => $i++,
            'Trip ID'  => $row->trip_number,
            'Trip name'=> $row->name,
            'Client'   => $row->name,
            'Driver'   => $getdriver->first_name.' '.$getdriver->last_name,
            'Plate'    => $gettruck->plate_number,
            'Acceted'  => $accept_trip  ? $accept_trip->created_at->format('Y-m-d H:i'):'',
            'Loading'  => $loading_trip ? $loading_trip->created_at->format('Y-m-d H:i'):'',
            'Started'  => $start_trip   ? $start_trip->created_at->format('Y-m-d H:i'):'',
            'Initial diesel'=> $row->initial_diesel ? $row->initial_diesel:'0',
            'Onroute diesel'=> $enroute_diesels_price ? $enroute_diesels_price:'0',
            'Mileage'  => $row->mileage_allowance,
            'Mouvment' => $row->movement_sheet ? $row->movement_sheet:'0',
            'Road toll'=> $row->road_toll ? $row->road_toll:'0',
            'Repairs'  => implode(',',$repairs),
            'Repair cost'=>$repair_total_amount? $repair_total_amount:'0',
            'Fine'     => implode(',',$fines),
            'Fine cost'=> $total_fines ? $total_fines:'0',
            'Other'    => $total_other_charges ? $total_other_charges:'0',
            'Accident' => $total_road_accident ? $total_road_accident:'0',
            'Delivery' => $deliverd   ? $deliverd->created_at->format('Y-m-d H:i'):'',
            'Trip End' => $end_trip ? $end_trip->created_at->format('Y-m-d H:i'):'',
            'Trip Cost'=> $row->revenue,
            'Trip Expenses'=>$overallcost,
            'Revenue'  =>$row->revenue-$overallcost,
          ];  
          }
          
          
        }
        
        return collect($arraydata);
        
    }

    public function headings(): array
    {
        return [
            'No',
            'Trip ID',
            'Trip name',
            'Client',
            'Driver',
            'Plate',
            'Acceted',
            'Loading',
            'Started',
            'Initial diesel',
            'Onroute diesel',
            'Mileage',
            'Mouvment',
            'Toll',
            'Repairs',
            'Repair cost',
            'Fine',
            'Fine cost',
            'Other',
            'Accident',
            'Delivery',
            'Trip End',
            'Trip Cost',
            'Trip Expenses',
            'Revenue'
        ];
    }
}
