<?php

namespace Modules\Admin\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\app\Models\Admin;
use Validator;
use Auth;
use Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        return view('admin::dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            
            $rules = [
                'email'    => 'required|email',
                'password' => 'required|max:30',
            ];

            $customValidation = [
                'email.required'    => 'Email is required',
                'password.required' => 'Password is required', 
            ];

            $this->Validate($request, $rules, $customValidation);
            if(Auth::guard('admin')->attempt(['email'=> $data['email'], 'password'=> $data['password']])){

                //  Remember Admin Email and password with Cookies
                if(isset($data['remember']) &&!empty($data['remember'])){
                    setcookie("email",$data['email'], time()+86400);
                    // cookie set for one day
                    setcookie("password",$data['password'],time()+86400);
                }else{
                    setcookie("email", "");
                    setcookie("password","");
                }
                return redirect('admin/dashboard');
            }else{
                return redirect()->back()->with('error_message', 'Invalid email or password');
            }
        }
        return view('admin::login');
    }

    /* --- logout user --- */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }

    /* --- subadmin index --- */
    public function index(Request $request)
    {
        $common = [];
        $common['title'] = "SubAdmin";
        $subadmins = Admin::where('type','subadmin')->get();
        return view('admin::subadmins.index')->with(compact('common','subadmins'));
    }

    /* --- add subadmin --- */
    public function addSubadmin(Request $request)
    {
        $common = [];
        $common['title']         = "SubAdmin";
        $common['heading_title'] = "Add SubAdmin";
        $common['button']        = "Submit";
        $message = "SubAdmin added Successfully!";

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $rules = [
                'name'     => 'required|regex:/^[^\d]+$/|min:2|max:255',
                'email'    => 'required|email|unique:users',
                'password' => 'required',
            ];

            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $subadmins = new Admin();
            $subadmins->name = $data['name'];
            $subadmins->type = 'subadmin';
            $subadmins->email = $data['email'];
            $subadmins->password = Hash::make($data['password']);
            $subadmins->status = 0;
            // echo "<pre>"; print_r($subadmins->toArray()); die;
            $subadmins->save();
            return redirect('admin/subadmins')->with('success_message', $message);
        }
        return view('admin::subadmins.addsubadmin', compact('common'));
    }

    /* --- edit subadmin --- */
    public function editSubadmin(Request $request, $id)
    {
        $common = [];
        $common['title']         = "SubAdmin";
        $common['heading_title'] = "Edit SubAdmin";
        $common['button']        = "Update";
        $id = decrypt($id);
        $subadmins = Admin::findOrFail($id);
        $message = "SubAdmin Updated Successfully!";

        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'name'  => 'required|regex:/^[^\d]+$/|min:2|max:255',
                'email' => 'required|email'
            ];

            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $subadmins->name = $data['name'];
            $subadmins->type = 'subadmin';
            $subadmins->email = $data['email'];
            // $subadmins->password = Hash::make($data['password']);
            $subadmins->status = 0;
            // echo "<pre>"; print_r($subadmins->toArray()); die;
            $subadmins->save();
            return redirect('admin/subadmins')->with('success_message', $message);
        }
        return view('admin::subadmins.editsubadmin', compact('common','subadmins'));
    }

    /* --- update subadmin status --- */
    public function UpdateSubadminStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if($data['status'] == "Active"){
                $status = 0;
            }else{
                $status = 1;
            }

            Admin::where('id', $data['subadmin_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'subadmin'=>$data['subadmin_id']]);
        }
    }

    /* --- delete driver --- */
    public function destroy($id)
    {
        $subadmins = Admin::findOrFail($id)->delete();
        return redirect()->back()->with('success_message', 'Subadmin Deleted Successfully!');
    }
}
