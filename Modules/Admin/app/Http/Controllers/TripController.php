<?php

namespace Modules\Admin\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\app\Models\TruckDriver;
use Modules\Admin\app\Models\Trip;
use Modules\Admin\app\Models\Truck;
use App\Models\{User,Currency,Tracking,FcmToken,Notification};
use Validator,Auth;
use App\Helpers\Helper;

class TripController extends Controller
{
    /* --- trip list --- */
    public function index(){
        $common = [];
        $common['title'] = "Trips";
        $get_trips = Trip::orderBy('id','desc')->get();
        return view('admin::trips.createTrips.index', compact('common', 'get_trips'));
    }
    
     /* --- add trips --- */
    public function addTrips(Request $request)
    {
        $common = [];
        $common['title']         = "Trip";
        $common['heading_title'] = "Trip";
        $common['button']        = "Submit";
        $message = "Trip Added Successfully!";

        $get_trucks   = Truck::select('id','brand','plate_number')->get();
        $get_drivers  = User::select('id','first_name','last_name')->get();

        $get_currency = Currency::select('id','name')->get();

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $rules = [
                'name'                => 'required|regex:/^[^\d]+$/|min:2|max:255',
                'loading_location'    => 'required',
                'offloading_location' => 'required',
            ];

            $customValidation = [
                'loading_location.required'     => 'Loading location is required',
                'offloading_location.required'  => 'Offloading location is required',
            ];

            $validator = Validator::make($data, $rules, $customValidation);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
        
            for($i=0; $i<count($request->truck); $i++){
                
                // extract the last trip id 
                $getlasttrip                =  Trip::orderBy('id','desc')->first();  
                $oid                        =  $getlasttrip ? $getlasttrip->id:0;
                $trip_id                    =  '#'.str_pad($oid+ 1, 8, "0", STR_PAD_LEFT);
            
                $trips                      = new Trip;
                $trips->trip_number         = $trip_id;
                $trips->name                = $data['name'];
                $trips->loading_location    = $data['loading_location'];
                $trips->latitude            = $data['lat'];
                $trips->longitude           = $data['lng'];
                $trips->offloading_location = $data['offloading_location'];
                $trips->offloading_location_lat = $data['offloading_location_lat'];
                $trips->offloading_location_lng = $data['offloading_location_lng'];
                $trips->start_date          = $data['start_date'];
                $trips->end_date            = $data['end_date'];
                $trips->revenue             = $data['revenue'];
                $trips->type_of_cargo       = $data['type_of_cargo'];
                $trips->weight_of_cargo     = $data['weight_of_cargo'];
                $trips->initial_diesel      = $data['initial_diesel'];
                $trips->mileage_allowance_currency = $data['mileage_currency'];
                $trips->mileage_allowance   = $data['mileage_allowance'];
                $trips->movement_sheet_currency = $data['movement_sheet_currency'];
                $trips->movement_sheet      = $data['movement_sheet'];
                $trips->road_toll_currency  = $data['road_toll_currency'];
                $trips->road_toll           = $data['road_toll'];
                $trips->status              = "Pending";
                $trips->save();
                
                $truckdriver           = new TruckDriver;
                $truckdriver->trip_id  = $trips->id;
                $truckdriver->truck_id = $request->truck[$i];
                $truckdriver->driver_id= $request->driver[$i];
                $truckdriver->save();
                
                // $msg = [
                // 'body' 	      => 'Senotrack has assigned you a trip.',
                // 'title'	      => 'SENOTRACK',
                // 'isBackground'=> true,
                // 'sound'       => 'default',
                // 'click_action'=> 'custom'
                // ];
                
                // $notification = new Notification;
                // $notification->user_id     = $request->driver[$i];
                // $notification->title       = 'SENOTRACK';
                // $notification->description = $request->description;
                // $notification->save();
                
                // $receiver  = FcmToken::where('user_id',$request->driver[$i])->pluck('fcm_token')->toArray();
                // $fcmTokens = $receiver;
                // if($fcmTokens && count($fcmTokens) > 0){
                // Helper::PushNotification($fcmTokens,$msg);  
                // }
            }
          
            return redirect('admin/pending-trips')->with('success_message', $message);
        }
        return view('admin::trips.createTrips.addTrips', compact('common','get_trucks','get_drivers','get_currency'));
    }
    
    /* --- pending trip index --- */
    public function PendingTripIndex()
    {
        $common = [];
        $common['title'] = "Pending Trips";
        $get_pending_trips = Trip::select('trips.*', 'truck_drivers.truck_id', 'truck_drivers.driver_id')->join('truck_drivers','truck_drivers.trip_id','=','trips.id')->orderBy('trips.id','desc')->where('trips.status','Pending')->orWhere('trips.status','Accepted')->orWhere('trips.status','Loading')->get();
        // echo "<pre>"; print_r($get_pending_trips->toArray()); die;
        return view('admin::trips.pendingTrips.index', compact('common', 'get_pending_trips'));
    }
    
    /* --- edit trips --- */
    public function editPendingTrip(Request $request, $id)
    {
        $common = [];
        $common['title']         = "Trip";
        $common['heading_title'] = "Edit Trip";
        $common['button']        = "Update";
        $id = decrypt($id);
        $trips = Trip::select('trips.*', 'truck_drivers.truck_id', 'truck_drivers.driver_id')->join('truck_drivers', 'truck_drivers.trip_id', '=', 'trips.id')->findOrFail($id);
        // echo "<pre>"; print_r($trips->toArray()); die;
        $message = "Trip Updated Successfully!";

        $get_trucks   = Truck::select('id','brand', 'plate_number')->get();
        $get_drivers  = User::select('id','first_name','last_name')->get();
        // echo "<pre>"; print_r($get_drivers->toArray()); die;
        $get_currency = Currency::select('id','name')->get();

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $rules = [
                'name'                => 'required|regex:/^[^\d]+$/|min:2|max:255',
                'loading_location'    => 'required',
                'offloading_location' => 'required',
                'license'             => 'required|unique:users',
                'national_id'         => 'required|unique:users',
            ];

            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
            
            $trips->name = $data['name'];
            $trips->loading_location = $data['loading_location'];
            if(isset($trips->latitude)){
                $trips->latitude = $data['lat'];
            }
            if(isset($trips->latitude)){
                $trips->longitude = $data['lng'];
            }
            $trips->offloading_location = $data['offloading_location'];
            $trips->offloading_location_lat = $data['offloading_location_lat'];
            $trips->offloading_location_lng = $data['offloading_location_lng'];
            $trips->start_date = $data['start_date'];
            $trips->end_date = $data['end_date'];
            $trips->revenue = $data['revenue'];
            $trips->type_of_cargo = $data['type_of_cargo'];
            $trips->weight_of_cargo = $data['weight_of_cargo'];
            $trips->initial_diesel = $data['initial_diesel'];
            $trips->mileage_allowance_currency = $data['mileage_currency'];
            $trips->mileage_allowance = $data['mileage_allowance'];
            $trips->movement_sheet_currency = $data['movement_sheet_currency'];
            $trips->movement_sheet = $data['movement_sheet'];
            $trips->road_toll_currency = $data['road_toll_currency'];
            $trips->road_toll = $data['road_toll'];
            $trips->status = "Pending";
            // echo "<pre>"; print_r($trips->toArray()); die;
            $trips->save();

            $truckdriver    = TruckDriver::where('trip_id', $id)->first();
            $truckdriver->trip_id  = $trips->id;
            $truckdriver->truck_id = $data['truck'];
            $truckdriver->driver_id= $data['driver'];
            $truckdriver->save();
            return redirect('admin/pending-trips')->with('success_message', $message);
        }
        return view('admin::trips.pendingTrips.editPendingTrips', compact('common','trips','get_trucks','get_drivers','get_currency'));
    }
    
    /* --- view pending trip --- */
    public function viewPendingTrip(Request $request, $id){
        $id = decrypt($id);
        $get_trip      = Trip::with(['mac','msc','rtc'])->findOrFail($id);

        $truck_drivers = \DB::table('truck_drivers')->where('trip_id',$id)->first();
        // $get_trip->latitude = (double) $get_trip->latitude;
        // $get_trip->longitude = (double) $get_trip->longitude;
        // $get_trip->offloading_location_lat = (double) $get_trip->offloading_location_lat;
        // $get_trip->offloading_location_lng = (double) $get_trip->offloading_location_lng;
       
        $truck         = \DB::table('trucks')->where('id',$truck_drivers->truck_id)->first();
        $drivers       = User::select('id','first_name','last_name')->where('id',$truck_drivers->driver_id)->first();
        $tracking      = Tracking::where('trip_id',$get_trip->id)->orderBy('id','desc')->first();
        $tracklat      = $tracking ? $tracking->lat:$get_trip->latitude;
        $tracklng      = $tracking ? $tracking->lng:$get_trip->longitude;
        // echo "<pre>"; print_r($get_trip->toArray()); die;
        return view('admin::trips.pendingTrips.viewPendingTrips', compact('get_trip','truck','drivers','tracking','tracklat','tracklng'));
    }
    
    /* --- Ongoing trip index --- */
    public function OngoingTripIndex()
    {
        $common = [];
        $common['title'] = "Ongoing Trips";
        $get_ongoing_trips = Trip::select('trips.*', 'truck_drivers.truck_id', 'truck_drivers.driver_id' )->join('truck_drivers', 'truck_drivers.trip_id', '=', 'trips.id')->orderBy('trips.id','desc')->where('trips.is_status', 'On the way')->orWhere('trips.is_status', 'Delivered')->where('trips.status', '!=', 'Completed')->get();
        // echo "<pre>"; print_r($get_ongoing_trips->toArray()); die;
        return view('admin::trips.ongoingTrips.index', compact('common', 'get_ongoing_trips'));
    }
    
     /* --- view ongoing trip --- */
    public function viewOngoingTrip(Request $request, $id){
        $id       = decrypt($id);
        $get_trip = Trip::with(['mac','msc','rtc','add_on_diesels','enroute_diesels','tolls','repairs','fines','road_accidents','other_charges','delivery_note'])->findOrFail($id);
        
        $truck_drivers = \DB::table('truck_drivers')->where('trip_id',$id)->first();
        $truck         = \DB::table('trucks')->where('id',$truck_drivers->truck_id)->first();
        $drivers       = User::select('id','first_name','last_name')->where('id',$truck_drivers->driver_id)->first();
        
        
        $totalamount = [];
        
        $addunit_price = [];
        foreach($get_trip->add_on_diesels as $row){
            $addunit_price[] = $row->unit_price;
            $totalamount[] = $row->unit_price;
        }
        $addunit_price = array_sum($addunit_price);
        
        
        $enunit_price = [];
        foreach($get_trip->enroute_diesels as $row){
          $enunit_price[] = $row->unit_price;  
          $totalamount[]  = $row->unit_price;
        }
        
        $enunit_price = array_sum($enunit_price);
         
        $tollsamount    = [];
        foreach($get_trip->tolls as $row){
           $tollsamount[] = $row->amount; 
           $totalamount[] = $row->amount;
        }
        $tollsamount = array_sum($tollsamount);
        
        $repairs_total_amount = [];
        foreach($get_trip->repairs as $row){
           $repairs_total_amount[] = $row->total_amount;   
           $totalamount[] = $row->total_amount;
        }
        
        $repairs_total_amount = array_sum($repairs_total_amount);
        
        
        $finesamount = [];
        foreach($get_trip->fines as $row){
           $finesamount[] = $row->amount;  
           $totalamount[] = $row->amount;
        }
        
        $finesamount = array_sum($finesamount);
        
        
        $cost = [];
        foreach($get_trip->road_accidents as $row){
            $cost[] = $row->cost;  
            $totalamount[] = $row->cost;
        }
        $cost = array_sum($cost);
        
        $otherchargeamount = []; 
        foreach($get_trip->other_charges as $row){
            $otherchargeamount[] = $row->amount;  
            $totalamount[] = $row->amount;
        }
        
        $otherchargeamount = array_sum($otherchargeamount);
         
        $totalamounts = array_sum($totalamount);
        return view('admin::trips.ongoingTrips.viewOngoingTrips', compact('truck','drivers','get_trip','totalamounts','otherchargeamount','cost','finesamount','repairs_total_amount','tollsamount','enunit_price','addunit_price'));
    }
    
   /* --- completed trip index --- */
    public function CompletedTripIndex()
    {
        $common = [];
        $common['title'] = "Completed Trips";
        $get_completed_trips = Trip::select('trips.*', 'truck_drivers.truck_id', 'truck_drivers.driver_id')->join('truck_drivers', 'truck_drivers.trip_id', '=', 'trips.id')->orderBy('id','desc')->where('status', 'Completed')->get();
        // echo "<pre>"; print_r($get_completed_trips->toArray()); die;
        return view('admin::trips.completedTrips.index', compact('common', 'get_completed_trips'));
    }
    
    /* -- view completed trips -- */
    public function viewCompletedTrip(Request $request, $id)
    {
        $id = decrypt($id);
        $get_trip = Trip::with(['mac','msc','rtc','add_on_diesels','enroute_diesels','tolls','repairs','fines','road_accidents','other_charges','delivery_note', 'end_trip'])->findOrFail($id);
        // echo "<pre>"; print_r($get_trip->toArray()); die;
        return view('admin::trips.completedTrips.viewCompletedTrips', compact('get_trip'));
    }
    

    /* --- delete trip --- */
    public function destroy($id)
    {
        $trucks = Trip::findOrFail($id)->delete();
        return redirect()->back()->with('success_message', 'Trip Deleted Successfully!');
    }
}
