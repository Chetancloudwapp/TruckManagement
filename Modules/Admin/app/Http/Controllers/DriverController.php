<?php

namespace Modules\Admin\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\{User, Countries};
use Hash;

class DriverController extends Controller
{
    /* -- drivers listing -- */
    public function index()
    {
        $common = [];
        $common['title'] = "Driver";
        $get_drivers = User::orderBy('id','desc')->get();
        return view('admin::drivers.index', compact('common', 'get_drivers'));
    }

    /* --- add drivers --- */
    public function addDriver(Request $request)
    {
        $common = [];
        $common['title'] = "Driver";
        $common['heading_title'] = "Driver";
        $common['button'] = "Submit";
        $message = "Driver Added Successfully!";
        $get_countries = Countries::select('id','phonecode')->get();

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $rules = [
                'first_name'   => 'required|regex:/^[^\d]+$/|min:2|max:255',
                'last_name'    => 'required|regex:/^[^\d]+$/|min:2|max:255',
                'email'        => 'required|email|unique:users',
                'image'        => 'required|mimes:jpeg,jpg,png,gif',
                'license'      => 'required|unique:users',
                'national_id'  => 'required|unique:users',
            ];

            $customValidation = [
                'license.required'     => 'License is required',
                'national_id.required' => 'National Id is required',
            ];

            $validator = Validator::make($data, $rules, $customValidation);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $drivers = new User();
            if($request->has('image')){
                $image = $request->file('image');
                $name = time(). '.' .$image->getClientOriginalExtension();
                $path = public_path('uploads/drivers/');
                $image->move($path, $name);
                $drivers->image = $name;
            }
            $drivers->first_name = $data['first_name'];
            $drivers->last_name = $data['last_name'];
            $drivers->email = $data['email'];
            // $drivers->country_code = $data['country_code'];
            $drivers->phone_number = $data['phone_number'];
            $drivers->license = $data['license'];
            $drivers->password = Hash::make($data['password']);
            $drivers->national_id = $data['national_id'];
            $drivers->status = $data['status'];
            // echo "<pre>"; print_r($drivers->toArray()); die;
            $drivers->save();
            return redirect('admin/drivers')->with('success_message', $message);
        }
        return view('admin::drivers.addDrivers', compact('common','get_countries'));
    }

    /* --- edit driver --- */
    public function editDriver(Request $request, $id)
    {
        $common = [];
        $common['title'] = 'Drivers';
        $common['heading_title'] = "Edit Drivers";
        $common['button'] = "Update";
        $id = decrypt($id);
        $drivers = User::findOrFail($id);
        $message = "Driver Updated Successfully!";

        $get_countries = Countries::select('id','phonecode')->get();
        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'first_name'   => 'required|regex:/^[^\d]+$/|min:2|max:255',
                'last_name'    => 'required|regex:/^[^\d]+$/|min:2|max:255',
                'email'        => 'required|email',
                'image'        => 'mimes:jpeg,jpg,png,gif',
                'license'      => 'required',
                'national_id'  => 'required',
            ];

            $customValidation = [
                'license.required'     => 'License is required',
                'national_id.required' => 'National Id is required',
            ];

            $validator = Validator::make($data, $rules, $customValidation);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            if(isset($request->image)){
                if($request->has('image')){
                    $image = $request->file('image');
                    $name = time(). '.' .$image->getClientOriginalExtension();
                    $path = public_path('uploads/drivers/');
                    $image->move($path, $name);
                    $drivers->image = $name;
                }
            }
            $drivers->first_name = $data['first_name'];
            $drivers->last_name = $data['last_name'];
            $drivers->email = $data['email'];
            // $drivers->country_code = $data['country_code'];
            $drivers->phone_number = $data['phone_number'];
            $drivers->license = $data['license'];
            // $drivers->password = Hash::make($data['password']);
            $drivers->national_id = $data['national_id'];
            $drivers->status = $data['status'];
            $drivers->save();
            return redirect('admin/drivers')->with('success_message', $message);
        }
        return view('admin::drivers.editDrivers', compact('common','get_countries','drivers'));
    }
    
    /* --- view driver --- */
    public function viewDriver(Request $request, $id)
    {
        $id = decrypt($id);
        $get_users = User::findOrFail($id);
        // echo "<pre>"; print_r($get_users->toArray()); die;
        return view('admin::drivers.viewDrivers', compact('get_users'));
    }

  

    /* --- delete driver --- */
    public function destroy($id)
    {
        $get_drivers = User::findOrFail($id);
        
        // get image path
        $driver_image_path = public_path('uploads/drivers/');

        // delete driver image if exists
        if(file_exists($driver_image_path.$get_drivers->image)){
            unlink($driver_image_path.$get_drivers->image);
        }

        $get_drivers->delete();
        return redirect()->back()->with('success_message', 'Driver Deleted Successfully!');
    }
}
