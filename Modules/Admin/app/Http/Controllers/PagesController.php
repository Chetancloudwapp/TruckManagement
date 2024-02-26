<?php

namespace Modules\Admin\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\app\Models\TermsandCondition;
use Modules\Admin\app\Models\PrivacyPolicy;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    /* -- privacy index -- */
    public function index(Request $request)
    {
        
        $common             = [];
        $common['title']    = "Privacy Policy";
        $common['button']   = "Update";
        $privacy_policies = PrivacyPolicy::first();
        // return view('admin::privacypolicy.index', compact('common','get_privacy_policy'));
        return view('admin::privacypolicy.editPrivacyPolicies', compact('common','privacy_policies'));

    }

    /* -- edit privacy policy --*/
    public function editPrivacyPolicy(Request $request, $id)
    {
        // decrypt the id 
        $id = base64_decode($id);

        // find the privacy policy and then update it 
        $privacy_policies  = PrivacyPolicy::findOrFail($id);
        if($request->isMethod('post')){
            $data = $request->all();
            
            $rules = [
                'title'        => 'required|regex:/^[^\d]+$/|min:2|max:255',
                'description'   => 'required'
            ];
            
            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $privacy_policies->title = $data['title'];
            $privacy_policies->description = $data['description'];
            $privacy_policies->save();
            return redirect('admin/privacy-policy')->with('success_message', 'Privacy Policy Updated Successfully!');
        }
    }

    /* --- tnc index -- */
    public function tncIndex()
    {
        $common           = [];
        $common['title']  = "Terms and Conditions";
        $common['button'] = "Update";
        $tnc = TermsandCondition::first();
        // return view('admin::termsandconditions.index', compact('common','get_tnc'));
        return view('admin::termsandconditions.editTnc', compact('common','tnc'));
    }

     /* -- edit tnc --*/
    public function editTnc(Request $request, $id)
    {
        // decrypt the id 
        $id = base64_decode($id);

        // find tnc and then edit it 
        $tnc = TermsandCondition::findOrFail($id);
        
        if($request->isMethod('post')){
            $data = $request->all();
            
            $rules = [
                'title'        => 'required|regex:/^[^\d]+$/|min:2|max:255',
                'description'   => 'required'
            ];
            
            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
            
            $tnc->title = $data['title'];
            $tnc->description = $data['description'];
            $tnc->save();
            return redirect('admin/terms-and-conditions')->with('success_message', 'Terms and Conditions Updated Successfully!');
        }
    }

}
