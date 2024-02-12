<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Admin\app\Models\TruckDriver;
use Modules\Admin\app\Models\{Trip, Truck};
use App\Models\{User, Currency, Repair,Toll, EndTrip};
use App\Models\{RoadAccident,Fine, OtherCharge, DeliveryNote};
use App\Models\{TripStart,AddOnDiesel,EnrouteDiesel};
use Validator;
use Hash;
use Auth;

class TripApiController extends Controller
{
    // Recursive function to handle nested arrays
    function replaceNullsWithEmptyStrings($data)
    {
        return collect($data)->map(function ($item) {
            // If the item is an array or collection, recursively process it
            if (is_array($item) || $item instanceof Collection) {
                return $this->replaceNullsWithEmptyStrings($item);
            }
            // If the item is null, replace it with an empty string
            return $item ?? '';
        })->all();
    }

    /* -- my trips api -- */
    public function MyTrips(Request $request)
    {
        try{
            $user = auth()->user();
            $get_trips = Trip::select('trips.*', 'truck_drivers.truck_id', 'truck_drivers.driver_id', 'truck_drivers.trip_id', 'trucks.plate_number')->join('truck_drivers','truck_drivers.trip_id','=','trips.id')->join('trucks', 'trucks.id', '=', 'truck_drivers.truck_id')
            ->where('trips.status',$request->type ?? 'Pending') 
            ->where('driver_id', $user->id)
            ->get();
            // return $get_trips;
            if(!$get_trips->isEmpty()){
                return response()->json([
                    'status'      => true,
                    'status_code' => 200,
                    'message'     => 'Data Retrieve Successfully!',
                    'data'        => $get_trips,
                ],200);
            }else{
                return response()->json([
                    'status'      => false,
                    'status_code' => 422,
                    'message'     => 'Trips not Found!',
                ],422);
            }
            // return $get_trips;
        }catch(\Exception $e){
            return response()->json([
                'status'  => false,
                'status_code' => 422,
                'message'     => $e->getMessage(),
            ],422);
        }
    }

    /* --- Trip Details Api --- */
    public function TripDetails(Request $request)
    {
        try{
            $user = auth()->user();
            $data = [];
            $get_trip_details = Trip::with(['add_on_diesels','enroute_diesels','repairs','tolls','road_accidents','fines', 'other_charges','delivery_note','end_trip'])->select('trips.*','truck_drivers.driver_id', 'truck_drivers.trip_id')->join('truck_drivers','truck_drivers.trip_id','=','trips.id')
            ->where('driver_id', $user->id)
            ->where('trip_id' , $request->trip_id)
            ->first();
           
            // return $get_trip_details;
            if(!empty($get_trip_details)){


                /* --- get truck name --- */
                $get_trip_details['driver'] = "";
                $get_driver_name = User::where('id', $get_trip_details->driver_id)->first();
                if(!empty($get_driver_name)){
                    $get_trip_details['driver'] = $get_driver_name->first_name .' '.$get_driver_name->last_name;
                }

                /* --- get driver name --- */
                $get_trip_details['truck'] = "";
                $get_truck_name = Truck::where('id', $get_trip_details->truck_id)->first();
                if(!empty($get_truck_name)){
                    $get_trip_details['truck'] = $get_truck_name->brand;
                }

                /* --- get mileage allowance currency --- */
                $get_trip_details['mileage_allowance_cur'] = "";
                $get_mac = Currency::where('id', $get_trip_details->mileage_allowance_currency)->first();
                if(!empty($get_mac)){
                    $get_trip_details['mileage_allowance_cur'] = $get_mac->name;
                }

                /* --- get movement sheet currency --- */
                $get_trip_details['movement_sheet_curr'] = "";
                $get_msc = Currency::where('id', $get_trip_details->movement_sheet_currency)->first();
                if(!empty($get_msc)){
                    $get_trip_details['movement_sheet_curr'] = $get_msc->name;
                }

                /* --- get movement sheet currency --- */
                $get_trip_details['road_toll_curr'] = "";
                $get_rtc = Currency::where('id', $get_trip_details->road_toll_currency)->first();
                if(!empty($get_rtc)){
                    $get_trip_details['road_toll_curr'] = $get_rtc->name;
                }

                $data = $get_trip_details;
                return response()->json([
                    'status'      => true,
                    'status_code' => 200,
                    'message'     => 'Trip Details Retrieve Successfully!',
                    'data'        => $data,
                ],200);
            }else{
                return response()->json([
                    'status'     => true,
                    'status_code' => 422,
                    'message'     => "Trip not found!",
                    'data'        => [],
                ],422);
            }
        }catch(\Exception $e){
            return response()->json([
                'status'      => false,
                'status_code' => 422,
                'message'     => $e->getMessage(),
            ],422);
        }
    }

    /* --- trip accept api --- */
    public function TripAccept(Request $request)
    {
        try{
            $rules = [
                'trip_id' => 'required',   
                'status'  => 'required|in:Accepted',
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(), 
                ],422);
            }

            $user = auth()->user();
            // return $user;

            $trips = Trip::select('trips.*')->join('truck_drivers','truck_drivers.trip_id','=', 'trips.id')
            ->where('driver_id', $user->id)
            ->where('trip_id', $request->trip_id)
            ->first();
            // return $trips;
            if(!empty($trips)){
                $trips->update(['status' => $request->status]);
                return response()->json([
                    'status'      => true,
                    'status_code' => 200,
                    'message'     => 'Trip Accepted Successfully!',
                    'data'        => $trips,
                ],200);
            }else{
                return response()->json([
                    'status'     => true,
                    'status_code' => 422,
                    'message'     => 'Trip Not Found!',
                    'data'        => [],
                ],422);
            }
        }catch(\Exception $e){
            return response()->json([
                'status'      => false,
                'status_code' => 422,
                'message'     => $e->getMessage(),
            ],422);
        }
    }

    /* --- trip start api --- */
    public function TripStart(Request $request)
    {
        try{
            $data = $request->all();
 
            $rules = [
                'exact_km_driven'       => 'required',
                'existing_diesel_image' => 'required|mimes:jpeg,jpg,png|max:2048',
                'odometer_image'        => 'required|mimes:jpeg,jpg,png|max:2048',
                'trip_id'               => 'required',
                'status'                => 'required|in:On the way',
            ];

            $validator = Validator::make($data,$rules);
            if($validator->fails()){
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ],422);
            }

            $user = auth()->user();

            $get_trips = TruckDriver::where(['driver_id' => $user->id, 'trip_id' => $request->trip_id])->first();
            if(!empty($get_trips)){
                Trip::where('id', $request->trip_id)->update(['is_status' => $request->status]);

                $trip_starts = new TripStart;
                if($request->has('existing_diesel_image')){
                    $image = $request->file('existing_diesel_image');
                    $name = time(). "." .$image->getClientOriginalExtension();
                    $path = public_path('uploads/startTrip/existingDiesel/');
                    $image->move($path, $name);
                    $trip_starts->existing_diesel_image = $name;
                }
                if($request->has('odometer_image')){
                    $image = $request->file('odometer_image');
                    $name = time(). "." .$image->getClientOriginalExtension();
                    $path = public_path('uploads/startTrip/odometer/');
                    $image->move($path, $name);
                    $trip_starts->odometer_image = $name;
                }
                $trip_starts->trip_id   = $request->trip_id;
                $trip_starts->driver_id = $user->id;
                $trip_starts->exact_km_driven = $data['exact_km_driven'];
                $trip_starts->save();
    
                /* -- get images path -- */
                $trip_starts['existing_diesel_image'] = asset('uploads/startTrip/existingDiesel/'. $trip_starts['existing_diesel_image']);
                $trip_starts['odometer_image'] = asset('uploads/startTrip/odometer/'. $trip_starts['odometer_image']);
                return response()->json([
                    'status'      => true,
                    'status_code' => 200,
                    'message'     => 'Data Sent Successfully!',
                    'data'        => $trip_starts,
                ],200);
            }else{
                return response()->json([
                    'status'      => true,
                    'status_code' => 422,
                    'message'     => 'Trip not found!',
                    'data'        => [],
                ],422);
            }  
        }catch(\Exception $e){
            return response()->json([
                'status'      =>  false,
                'status_code' => 422,
                'message'     => $e->getMessage(),
            ],422);
        }
    }

    /* --- AddOn Diesel api --- */
    public function AddOnDiesel(Request $request)
    {
        try{
            $data = $request->all();
            
            $rules = [
                'quantity_in_litres'   => 'required',
                'unit_price'           => 'required',
                'petrol_station'       => 'required',
                'petrol_station_image' => 'required|mimes:jpeg,jpg,png',
                'trip_id'              => 'required',
            ];

            $validator = Validator::make($data,$rules);
            if($validator->fails()){
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ],422);
            }

            $user = auth()->user();

            $get_trip = TruckDriver::where(['driver_id'=>$user->id, 'trip_id' =>$request->trip_id])->first();
            if(!empty($get_trip)){
                
                $addOn_diesels = new AddOnDiesel;
                
                // upload image
                if($request->has('petrol_station_image')){
                    $image = $request->file('petrol_station_image');
                    $name = time(). "." .$image->getClientOriginalExtension();
                    $path = public_path('uploads/startTrip/addonDiesel/');
                    $image->move($path, $name);
                    $addOn_diesels->petrol_station_image = $name;
                }
                $addOn_diesels->trip_id = $request->trip_id;
                $addOn_diesels->driver_id = $user->id;
                $addOn_diesels->quantity_in_litres = $data['quantity_in_litres'];
                $addOn_diesels->unit_price = $data['unit_price'];
                $addOn_diesels->petrol_station = $data['petrol_station'];
                // return $addOn_diesels;
                $addOn_diesels->save();

                /* -- get images path -- */
                $addOn_diesels['petrol_station_image'] = asset('uploads/startTrip/addonDiesel/'. $addOn_diesels['petrol_station_image']);
                // ?? asset('uploads/placeholder/default_user.png');
                return response()->json([
                    'status'      => true,
                    'status_code' => 200,
                    'message'     => 'Data Sent Successfully!',
                    'data'        => $addOn_diesels,
                ],200);
            }else{
                return response()->json([
                    'status'      => true,
                    'status_code' => 422,
                    'message'     => 'Trip not found!',
                    'data'        => [],
                ],422);
            }
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'status_code' => 422,
                'message'     => $e->getMessage(),
            ],422);
        }
    }

    /* --- enroute diesel --- */
    public function enrouteDiesel(Request $request)
    {
        try{
            $data = $request->all();

            $rules = [
                'quantity_in_litres'   => 'required',
                'unit_price'           => 'required',
                'petrol_station'       => 'required',
                'petrol_station_image' => 'required|mimes:jpeg,jpg,png',
                'trip_id'              => 'required',
            ];

            $validator = Validator::make($data,$rules);
            if($validator->fails()){
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ],422);
            }

            $user = auth()->user();
            
            // check for the trips
            $get_trip = TruckDriver::where(['driver_id'=>$user->id, 'trip_id'=>$request->trip_id])->first();
            if(!empty($get_trip)){

                $enroute_diesel = new EnrouteDiesel;
                
                // upload image
                if($request->has('petrol_station_image')){
                    $image = $request->file('petrol_station_image');
                    $name = time(). "." .$image->getClientOriginalExtension();
                    $path = public_path('uploads/startTrip/enrouteDiesel/');
                    $image->move($path, $name);
                    $enroute_diesel->petrol_station_image = $name;
                }
                $enroute_diesel->trip_id = $request->trip_id;
                $enroute_diesel->driver_id = $user->id;
                $enroute_diesel->quantity = $data['quantity_in_litres'];
                $enroute_diesel->unit_price = $data['unit_price'];
                $enroute_diesel->petrol_station = $data['petrol_station'];
                // return $enroute_diesel;
                $enroute_diesel->save();

                /* -- get images path -- */
                $enroute_diesel['petrol_station_image'] = asset('uploads/startTrip/enrouteDiesel/'. $enroute_diesel['petrol_station_image']);
                // ?? asset('uploads/placeholder/default_user.png');
                return response()->json([
                    'status'      => true,
                    'status_code' => 200,
                    'message'     => 'Data Sent Successfully!',
                    'data'        => $enroute_diesel,
                ],200);
            }else{
                return response()->json([
                    'status' =>  true,
                    'status_code' => 422,
                    'message'     => 'Trip not found!',
                    'data'        => [],
                ],422);
            }
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'status_code' => 422,
                'message'     => $e->getMessage(),
            ],422);
        }
    }

    /* --- enroute Tolls --- */
    public function enrouteTolls(Request $request)
    {
        try{
            $data = $request->all();

            $rules = [
                'trip_id'     => 'required',
                'toll_name'   => 'required',
                'amount'      => 'required',
                'toll_image'  => 'required|mimes:jpeg,jpg,png',
            ];

            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ],422);
            }

            $user = auth()->user();
            
            // check for the trips
            $get_trip = TruckDriver::where(['driver_id'=>$user->id, 'trip_id'=>$request->trip_id])->first();
            if(!empty($get_trip)){

                $tolls = new Toll;
                
                // upload image
                if($request->has('toll_image')){
                    $image = $request->file('toll_image');
                    $name = time(). "." .$image->getClientOriginalExtension();
                    $path = public_path('uploads/startTrip/tolls/');
                    $image->move($path, $name);
                    $tolls->toll_image = $name;
                }
                $tolls->trip_id = $request->trip_id;
                $tolls->driver_id = $user->id;
                $tolls->toll_name = $data['toll_name'];
                $tolls->amount = $data['amount'];
                $tolls->save();

                return response()->json([
                    'status'      => true,
                    'status_code' => 200,
                    'message'     => 'Data Sent Successfully!',
                    'data'        => $tolls,
                ],200);
            }else{
                return response()->json([
                    'status' =>  true,
                    'status_code' => 422,
                    'message'     => 'Trip not found!',
                    'data'        => [],
                ],422);
            }

        }catch(\Exception $e){
            return response()->json([
                'status'      => false,
                'status_code' => 422,
                'message'     => $e->getMessage(),
            ],422);
        }
    }
 
    /* --- enroute repairs --- */
    public function enrouteRepairs(Request $request)
    {
        try{
            $data = $request->all();

            $rules = [
                'shop_name'     => 'required',
                'repair_name'   => 'required',
                'repair_cost'   => 'required',
                'spare_name'    => 'required',
                'spare_cost'    => 'required',
                'total_amount'  => 'required',
                'upload_bill'   => 'required|mimes:jpeg,jpg,png',
                'trip_id'       => 'required',
            ];

            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ],422);
            }

            $user = auth()->user();
            
            // check for the trips
            $get_trip = TruckDriver::where(['driver_id'=>$user->id, 'trip_id'=>$request->trip_id])->first();
            if(!empty($get_trip)){

                $repairs = new Repair;
                
                // upload image
                if($request->has('upload_bill')){
                    $image = $request->file('upload_bill');
                    $name = time(). "." .$image->getClientOriginalExtension();
                    $path = public_path('uploads/startTrip/repairs/');
                    $image->move($path, $name);
                    $repairs->upload_bill = $name;
                }
                $repairs->trip_id = $request->trip_id;
                $repairs->driver_id = $user->id;
                $repairs->shop_name = $data['shop_name'];
                $repairs->repair_name = $data['repair_name'];
                $repairs->repair_cost = $data['repair_cost'];
                $repairs->spare_name = $data['spare_name'];
                $repairs->spare_cost = $data['spare_cost'];
                $repairs->total_amount = $data['total_amount'];
                // return $enroute_diesel;
                $repairs->save();

                return response()->json([
                    'status'      => true,
                    'status_code' => 200,
                    'message'     => 'Data Sent Successfully!',
                    'data'        => $repairs,
                ],200);
            }else{
                return response()->json([
                    'status' =>  true,
                    'status_code' => 422,
                    'message'     => 'Trip not found!',
                    'data'        => [],
                ],422);
            }

        }catch(\Exception $e){
            return response()->json([
                'status'  => false,
                'status_code' => 422,
                'message'     => $e->getMessage(),
            ],422);
        }
    }

    /* --- Road Accident --- */
    public function roadAccident(Request $request)
    {
        try{
            $data = $request->all();

            $rules = [
                'trip_id'          => 'required',
                'accident_category'=> 'required|in:Major,Minor',
                'cost'             => 'required',
                'description'      => 'required',
                'image'            => 'required|mimes:jpeg,jpg,png',
            ];

            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ],422);
            }

            $user = auth()->user();
           
            // check for the trips
            $get_trip = TruckDriver::where(['driver_id'=>$user->id, 'trip_id'=>$request->trip_id])->first();
            if(!empty($get_trip)){

                $road_accident = new RoadAccident;
                
                // upload image
                if($request->has('image')){
                    $image = $request->file('image');
                    $name = time(). "." .$image->getClientOriginalExtension();
                    $path = public_path('uploads/startTrip/roadAccident/');
                    $image->move($path, $name);
                    $road_accident->image = $name;
                }
                $road_accident->trip_id = $request->trip_id;
                $road_accident->driver_id = $user->id;
                $road_accident->accident_category = $data['accident_category'];
                $road_accident->cost = $data['cost'];
                $road_accident->description = $data['description'];
                $road_accident->save();

                return response()->json([
                    'status'      => true,
                    'status_code' => 200,
                    'message'     => 'Data Sent Successfully!',
                    'data'        => $road_accident,
                ],200);
            }else{
                return response()->json([
                    'status'      =>  true,
                    'status_code' => 422,
                    'message'     => 'Trip not found!',
                    'data'        => [],
                ],422);
            }
        }catch(\Exception $e){
            return response()->json([
                'status'      => false,
                'status_code' => 422,
                'message'     => $e->getMessage(),
            ],422);
        }
    }

    /* --- fines api --- */
    public function enrouteFines(Request $request)
    {
        try{
            $data = $request->all();

            $rules = [
                'trip_id'     => 'required',
                'name'        => 'required',
                'amount'      => 'required',
                'description' => 'required',
                'image'       => 'required|mimes:jpeg,jpg,png,gif',
            ];

            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ],422);
            }

            $user = auth()->user();
            // return $user;
            
            $get_trips = TruckDriver::where(['trip_id'=>$request->trip_id, 'driver_id'=>$user->id])->first();
            if(!empty($get_trips)){

                $fines = new Fine;
                
                // upload image
                if($request->has('image')){
                    $image = $request->file('image');
                    $name = time(). "." .$image->getClientOriginalExtension();
                    $path = public_path('uploads/startTrip/fines/');
                    $image->move($path, $name);
                    $fines->image = $name;
                }
                $fines->trip_id = $request->trip_id;
                $fines->name = $data['name'];
                $fines->amount = $data['amount'];
                $fines->description = $data['description'];
                $fines->save();

                return response()->json([
                    'status'      => true,
                    'status_code' => 200,
                    'message'     => 'Data Sent Successfully!',
                    'data'        => $fines,
                ],200);
            }else{
                return response()->json([
                    'status'      => true,
                    'status_code' => 422,
                    'message'     => 'Trip not found!',
                    'data'        => [],
                ],422);
            }
        }catch(\Exception $e){
            return response()->json([
                'status'      => false,
                'status_code' => 422,
                'message'     => $e->getMessage(),
            ],422);
        }
    }

    /* --- other charges api --- */
    public function OtherCharges(Request $request)
    {
        try{
            $data = $request->all();

            $rules = [
                'trip_id'     => 'required',
                'name'        => 'required',
                'amount'      => 'required',
                'description' => 'required',
                'image'       => 'required|mimes:jpeg,jpg,png,gif',
            ];

            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ],422);
            }

            $user = auth()->user();
            // return $user;
            
            $get_trips = TruckDriver::where(['trip_id'=>$request->trip_id, 'driver_id'=>$user->id])->first();
            if(!empty($get_trips)){

                $other_charges = new OtherCharge;
                
                // upload image
                if($request->has('image')){
                    $image = $request->file('image');
                    $name = time(). "." .$image->getClientOriginalExtension();
                    $path = public_path('uploads/startTrip/otherCharges/');
                    $image->move($path, $name);
                    $other_charges->image = $name;
                }
                $other_charges->trip_id = $request->trip_id;
                $other_charges->name = $data['name'];
                $other_charges->amount = $data['amount'];
                $other_charges->description = $data['description'];
                $other_charges->save();

                return response()->json([
                    'status'      => true,
                    'status_code' => 200,
                    'message'     => 'Data Sent Successfully!',
                    'data'        => $other_charges,
                ],200);
            }else{
                return response()->json([
                    'status'      => true,
                    'status_code' => 422,
                    'message'     => 'Trip not found!',
                    'data'        => [],
                ],422);
            }
        }catch(\Exception $e){
            return response()->json([
                'status'      => false,
                'status_code' => 422,
                'message'     => $e->getMessage(),
            ],422);
        }
    }

    /* --- delivery note api --- */
    public function deliveryNote(Request $request)
    {
        try{
            $data = $request->all();

            $rules = [
                'trip_id'       => 'required',
                'delivery_note' => 'required',
                'image'         => 'required|mimes:jpeg,jpg,png',
                'status'        => 'required|in:Delivered',
            ];

            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ],422);
            }

            $user = auth()->user();

            $get_trips = TruckDriver::where(['trip_id'=>$request->trip_id, 'driver_id'=>$user->id])->first();
            if(!empty($get_trips)){

                Trip::where(['id'=> $request->trip_id])->update(['is_status' => $request->status]);

                $delivery_note = new DeliveryNote;
                
                // upload image
                if($request->has('image')){
                    $image = $request->file('image');
                    $name = time(). "." .$image->getClientOriginalExtension();
                    $path = public_path('uploads/startTrip/deliveryNote/');
                    $image->move($path, $name);
                    $delivery_note->image = $name;
                }
                $delivery_note->trip_id = $request->trip_id;
                $delivery_note->delivery_note = $data['delivery_note'];
                $delivery_note->save();

                return response()->json([
                    'status'      => true,
                    'status_code' => 200,
                    'message'     => 'Delivery Note Sent Successfully!',
                    'data'        => $delivery_note,
                ],200);
            }else{
                return response()->json([
                    'status'      => true,
                    'status_code' => 422,
                    'message'     => 'Trip not found!',
                    'data'        => [],
                ],422);
            }
        }catch(\Exception $e){
            return response()->json([
                'status'      => false,
                'status_code' => 422,
                'message'     => $e->getMessage(),
            ],422);
        }
    }

    /* --- end trip api --- */
    public function endTrip(Request $request)
    {
        try{
            $data = $request->all();

            $rules = [
                'trip_id'            => 'required',
                'diesel_meter_image' => 'required|mimes:jpeg,jpg,png',
                'odometer_image'     => 'required|mimes:jpeg,jpg,png',
                'status'             => 'required|in:Completed',
            ];

            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ],422);
            }

            $user = auth()->user();
            
            $get_trips = TruckDriver::where(['trip_id'=>$request->trip_id, 'driver_id' => $user->id])->first();
            if(!empty($get_trips)){

                Trip::where('id', $request->trip_id)->update(['status' => $request->status]);

                $end_trips = new EndTrip;

                // upload diesel meter image
                if($request->has('diesel_meter_image')){
                    $image = $request->file('diesel_meter_image');
                    $name  = time(). "." .$image->getClientOriginalExtension();
                    $path  = public_path('uploads/endTrip/meterImage/');
                    $image->move($path, $name);
                    $end_trips->diesel_meter_image = $name;
                }

                // upload odometer image
                if($request->has('odometer_image')){
                    $image = $request->file('odometer_image');
                    $name = time().'.'.$image->getClientOriginalExtension();
                    $path = public_path('uploads/endTrip/odometerImage/');
                    $image->move($path, $name);
                    $end_trips->odometer_image = $name;
                }

                $end_trips->trip_id = $request->trip_id;
                $end_trips->save();

                 /* -- get images path -- */
                 $end_trips['diesel_meter_image'] = asset('uploads/endTrip/meterImage/'. $end_trips['diesel_meter_image']);
                 $end_trips['odometer_image'] = asset('uploads/endTrip/odometerImage/'. $end_trips['odometerImage']);
                 return response()->json([
                     'status'      => true,
                     'status_code' => 200,
                     'message'     => 'Data Sent Successfully!',
                     'data'        => $end_trips,
                 ],200);
            }else{
                return response()->json([
                    'status'      => true,
                    'status_code' => 422,
                    'message'     => 'Trip not found!',
                    'data'        => [],
                ],422);
            }

        }catch(\Exception $e){
            return response()->json([
                'status'      => false,
                'status_code' => 422,
                'message'     => $e->getMessage(),
            ],422);
        }
    }
}
