<?php

namespace Modules\Admin\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\app\Models\Admin;
use App\Models\AdminsRole;
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

    public function UpdateRolesAndPermission(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            echo "<pre>"; print_r($data); die;
        }
    }

    /* --- Update roles and permission for subadmins --- */
    public function updateRole(Request $request, $id)
    {
        if($request->isMethod('post')){
            // Admin::where('id', $data['subadmin_id'])->update(['status'=>$status]);
            $data = $request->all();
            echo "<pre>"; print_r($data); die;

            foreach($data as $key => $value){
               
                if(isset($value['view'])){
                    $view = $value['view'];
                    // return $view;
                }else{
                    $view = 0;
                }
                // return $view;
                
                if(isset($value['edit'])){
                    $edit = $value['edit'];
                }else{
                    $edit = 0;
                }
                if(isset($value['full'])){
                    $full = $value['full'];
                }else{
                    $full = 0;
                }
                
            }

            // Processing each key-value pair in the data
            foreach ($data as $key => $value) {
                // Check if the key corresponds to either 'trucks' or 'drivers'
                if ($key === 'trucks' || $key === 'drivers') {
                    // Initialize flag to track if a permission has been set to 1
                    $permissionSet = false;
                
                    // Iterate over the truck/driver properties
                    foreach ($value as $module => $permissions) {
                        if (in_array('view', $permissions) && in_array('edit', $permissions) && in_array('full', $permissions)) {
                            $role = new AdminsRole;
                            $role->subadmin_id = $id;
                            $role->module = $module;
                            $role->view_access = true; // Assuming 'view' permission exists
                            $role->edit_access = true; // Assuming 'edit' permission exists
                            $role->full_access = true; // Assuming 'full' permission exists
                            $role->save();
                        }
                    }
                    
                    
                }
                
            }

            
            AdminsRole::where('subadmin_id', $id)->delete();

            $role = new AdminsRole;
            $role->subadmin_id = $id;
            $role->module = $key;
            $role->view_access = $view;
            // return $role;
            $role->edit_access = $edit;
            $role->full_access = $full;
            // echo "<pre>"; print_r($role->toArray()); die;
            $role->save();

            // Delete all earlier roles for subadmins
            

            $message = "Subadmin Roles Updated Successfully!";
            return redirect()->back()->with('success_message', $message);
        }

        $subadminRoles = AdminsRole::where('subadmin_id', $id)->get()->toArray();
       // echo "<pre>"; print_r($subadminRoles); die;

        $subadminDetails = Admin::where('id', $id)->first();
        // return $subadminDetails;
        // $title = "Update ".$subadminDetails['name']." Subadmin Roles/Permission";
        // dd($subadminRoles);
        return view('admin::subadmins.update_roles')->with(compact('subadminDetails','subadminRoles'));
        // return view('admin::subadmins.update_roles');
    }

    /* --- delete subadmins --- */
    public function destroy($id)
    {
        $subadmins = Admin::findOrFail($id)->delete();
        return redirect()->back()->with('success_message', 'Subadmin Deleted Successfully!');
    }
}
