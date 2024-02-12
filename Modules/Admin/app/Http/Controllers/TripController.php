<?php

namespace Modules\Admin\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\app\Models\TruckDriver;
use Modules\Admin\app\Models\Trip;
use Modules\Admin\app\Models\Truck;
use App\Models\{User, Currency};
use Validator;

class TripController extends Controller
{
    /* --- trip list --- */
    public function index()
    {
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

        $get_trucks   = Truck::select('id','brand')->get();
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
                // 'image'            => 'required|mimes:jpeg,jpg,png,gif',
                // 'license'          => 'required|unique:users',
                // 'national_id'      => 'required|unique:users',
            ];

            $customValidation = [
                'loading_location.required'     => 'Loading location is required',
                'offloading_location.required'  => 'Offloading location is required',
            ];

            $validator = Validator::make($data, $rules, $customValidation);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $trips = new Trip;
            $trips->name = $data['name'];
            $trips->loading_location = $data['loading_location'];
            $trips->offloading_location = $data['offloading_location'];
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

            /* -- update multiple truck and drivers --*/
            $truckDriverAttributes = array_map(function ($truckId, $driverId) use($trips){
                return [
                    'trip_id'   => $trips->id,
                    'truck_id'  => $truckId,
                    'driver_id' => $driverId,
                ];
            }, $request->truck, $request->driver);

            // Use createMany to insert multiple records at once
            TruckDriver::insert($truckDriverAttributes);

            // $trips->driver = $data['driver'];
            return redirect('admin/pending-trips')->with('success_message', $message);
        }
        return view('admin::trips.createTrips.addTrips', compact('common','get_trucks','get_drivers','get_currency'));
    }
    
    /* --- pending trip index --- */
    public function PendingTripIndex()
    {
        $common = [];
        $common['title'] = "Pending Trips";
        $get_pending_trips = Trip::select('trips.*', 'truck_drivers.truck_id', 'truck_drivers.driver_id')->join('truck_drivers','truck_drivers.trip_id','=','trips.id')->orderBy('trips.id','desc')->where('trips.status','Pending')->orWhere('trips.status','Accepted')->get();
        // echo "<pre>"; print_r($get_pending_trips->toArray()); die;
        return view('admin::trips.pendingTrips.index', compact('common', 'get_pending_trips'));
    }

    /* --- view pending trip --- */
    public function viewPendingTrip(Request $request, $id)
    {
        $id = decrypt($id);
        $get_trip = Trip::with(['mac','msc','rtc'])->findOrFail($id);
        // echo "<pre>"; print_r($get_trip->toArray()); die;
        return view('admin::trips.pendingTrips.viewPendingTrips', compact('get_trip'));
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
    public function viewOngoingTrip(Request $request, $id)
    {
        $id = decrypt($id);
        $get_trip = Trip::with(['mac','msc','rtc','add_on_diesels','enroute_diesels','tolls','repairs','fines','road_accidents','other_charges','delivery_note'])->findOrFail($id);
        // echo "<pre>"; print_r($get_trip->toArray()); die;
        return view('admin::trips.ongoingTrips.viewOngoingTrips', compact('get_trip'));
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
    
    /* --- edit trips --- */
    // public function editTrips(Request $request, $id)
    // {
    //     $common = [];
    //     $common['title']         = "Trip";
    //     $common['heading_title'] = "Edit Trip";
    //     $common['button']        = "Update";
    //     $id = decrypt($id);
    //     $trips = Trip::findOrFail($id);
    //     // echo "<pre>"; print_r($trips->toArray()); die;
    //     $message = "Trip Updated Successfully!";

    //     $get_trucks   = Truck::select('id','brand')->get();
    //     $get_drivers  = User::select('id','first_name','last_name')->get();
    //     // echo "<pre>"; print_r($get_drivers->toArray()); die;
    //     $get_currency = Currency::select('id','name')->get();

    //     if($request->isMethod('post')){
    //         $data = $request->all();
    //         // echo "<pre>"; print_r($data); die;

    //         $rules = [
    //             'name'                => 'required|regex:/^[^\d]+$/|min:2|max:255',
    //             'loading_location'    => 'required',
    //             'offloading_location' => 'required',
    //         ];

    //         $validator = Validator::make($data, $rules);
    //         if($validator->fails()){
    //             return back()->withErrors($validator)->withInput();
    //         }

    //         $trips->name = $data['name'];
    //         $trips->loading_location = $data['loading_location'];
    //         $trips->offloading_location = $data['offloading_location'];
    //         $trips->start_date = $data['start_date'];
    //         $trips->end_date = $data['end_date'];
    //         $trips->revenue = $data['revenue'];
    //         $trips->type_of_cargo = $data['type_of_cargo'];
    //         $trips->truck = $data['truck'];
    //         $trips->driver = $data['driver'];
    //         $trips->weight_of_cargo = $data['weight_of_cargo'];
    //         $trips->initial_diesel = $data['initial_diesel'];
    //         $trips->mileage_allowance_currency = $data['mileage_currency'];
    //         $trips->mileage_allowance = $data['mileage_allowance'];
    //         $trips->movement_sheet_currency = $data['movement_sheet_currency'];
    //         $trips->movement_sheet = $data['movement_sheet'];
    //         $trips->road_toll_currency = $data['road_toll_currency'];
    //         $trips->road_toll = $data['road_toll'];
    //         $trips->status = "Pending";
    //         echo "<pre>"; print_r($trips->toArray()); die;
    //         $trips->save();
    //         return redirect('admin/trips')->with('success_message', $message);
    //     }
    //     return view('admin::trips.editTrips', compact('common','trips','get_trucks','get_drivers','get_currency'));
    // }

    /* --- delete trip --- */
    public function destroy($id)
    {
        $trucks = Trip::findOrFail($id)->delete();
        return redirect()->back()->with('success_message', 'Trip Deleted Successfully!');
    }
}
