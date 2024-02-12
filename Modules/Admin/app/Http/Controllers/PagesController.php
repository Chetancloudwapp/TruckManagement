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
    public function index()
    {
        $common = [];
        $common['title']         = "Privacy Policy";
        $common['button']        = "Submit";
        $get_privacy_policy = PrivacyPolicy::get();
        return view('admin::privacypolicy.index', compact('common','get_privacy_policy'));
    }

    /* -- edit privacy policy --*/
    public function editPrivacyPolicy(Request $request, $id)
    {
        $common = [];
        $common['title']         = "Privacy Policy";
        $common['heading_title'] = "Edit Privacy Policy";
        $common['button']        = "Update";
        $message = "Privacy Policy Update Successfully!";
        $id = decrypt($id);
        $privacy_policies = PrivacyPolicy::findOrFail($id);
        
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
            return redirect('admin/privacy-policy')->with('success_message', $message);
        }
        return view('admin::privacypolicy.editPrivacyPolicies', compact('common','privacy_policies'));
    }

    /* --- tnc index -- */
    public function tncIndex()
    {
        $common = [];
        $common['title']         = "Terms and Conditions";
        $common['button']        = "Submit";
        $get_tnc = TermsandCondition::get();
        return view('admin::termsandconditions.index', compact('common','get_tnc'));
    }

     /* -- edit tnc --*/
    public function editTnc(Request $request, $id)
    {
        $common = [];
        $common['title']         = "Terms and Conditions";
        $common['heading_title'] = "Edit Terms and Conditions";
        $common['button']        = "Update";
        $message = "Terms and Conditions Update Successfully!";
        $id = decrypt($id);
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
            return redirect('admin/terms-and-conditions')->with('success_message', $message);
        }
        return view('admin::termsandconditions.editTnc', compact('common','tnc'));
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
