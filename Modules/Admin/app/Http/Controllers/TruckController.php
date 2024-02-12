<?php

namespace Modules\Admin\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\app\Models\Truck;
use Illuminate\Support\Facades\Validator;

class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $common = [];
        $common['title'] = "Truck";
        $common['button']= "Submit";
        $trucks = Truck::orderBy('id','desc')->get();
        return view('admin::trucks.index', compact('common', 'trucks'));
    }

    /* --- add truck --- */
    public function addTruck(Request $request)
    {
        $common = [];
        $common['title']         = "Truck";
        $common['heading_title'] = "Add Truck";
        $common['button']        = "Submit";
        $message = "Truck Added Successfully!";
        
        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                "brand"        => "required|regex:/^[^\d]+$/|min:2|max:255",
                "modal"        => "required",
                "year"         => "required",
                "plate_number" => "required",
            ];

            $customValidation = [
                "brand.required"        => "Brand name is required",
                "modal.required"        => "Modal number is required",
                "plate_number.required" => "Plate number is required",
            ];
            
            $validator = Validator::make($request->all(), $rules, $customValidation);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
            
            $trucks = new Truck;
            $trucks->brand  = $data['brand'];
            $trucks->modal = $data['modal'];
            $trucks->year  = $data['year'];
            $trucks->plate_number = $data['plate_number'];
            $trucks->km_driven = $data['km_driven'];
            $trucks->next_oil_change = $data['next_oil_change'];
            $trucks->status  = $data['status'];
            // echo "<pre>"; print_r($trucks->toArray()); die;
            $trucks->save();
            return redirect('admin/truck')->with('success_message', $message);
        }
        return view('admin::trucks.addTrucks')->with(compact('common'));
    }

    /* --- edit truck --- */
    public function editTruck(Request $request, $id)
    {
        $common = [];
        $common['title']         = "Truck";
        $common['heading_title'] = "Edit Truck";
        $common['button']        = "Update";
        $id = decrypt($id);
        $trucks = Truck::find($id);
        $message = "Truck Updated Successfully!";
        
        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                "brand"        => "required|regex:/^[^\d]+$/|min:2|max:255",
                "modal"        => "required",
                "year"         => "required",
                "plate_number" => "required",
            ];

            $customValidation = [
                "brand.required"        => "Brand name is required",
                "modal.required"        => "Modal number is required",
                "plate_number.required" => "Plate number is required",
            ];
            
            $validator = Validator::make($request->all(), $rules, $customValidation);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
            
            $trucks->brand  = $data['brand'];
            $trucks->modal  = $data['modal'];
            $trucks->km_driven  = $data['km_driven'];
            $trucks->next_oil_change_km  = $data['next_oil_change'];
            $trucks->year  = $data['year'];
            $trucks->plate_number = $data['plate_number'];
            $trucks->status  = $data['status'];
            // echo "<pre>"; print_r($trucks->toArray()); die;
            $trucks->save();
            return redirect('admin/truck')->with('success_message', $message);
        }
        return view('admin::trucks.editTrucks')->with(compact('common','trucks'));
    }

    /* --- view Truck --- */
    public function viewTruck(Request $request, $id)
    {
        $id = decrypt($id);
        $get_truck = Truck::findOrFail($id);
        // echo "<pre>"; print_r($get_truck->toArray()); die;
        return view('admin::trucks.viewTrucks', compact('get_truck'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /* --- delete truck --- */
    public function destroy($id)
    {
        // return $id;
        $trucks = Truck::findOrFail($id)->delete();
        return redirect()->back()->with('success_message', 'Truck Deleted Successfully!');
    }
}
