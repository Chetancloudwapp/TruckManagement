<?php

namespace Modules\Admin\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Currency;
use Validator;

class CurrencyController extends Controller
{
    /* -- currency listing -- */
    public function index()
    {
        $common = [];
        $common['title'] = 'Currency';
        $common['button'] = 'Submit';
        $get_currency = Currency::orderBy('id','desc')->get();
        return view('admin::currency.index', compact('common', 'get_currency'));
    }

    /* -- add currency -- */
    public function addCurrency(Request $request)
    {
        $common = [];
        $common['title']         = "Currency";
        $common['heading_title'] = "Add Currency";
        $common['button']        = "Submit";
        $message = "Currency Added Successfully!";

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $rules = [
                'currency'  => 'required|regex:/^[^\d]+$/|min:2|max:255',
            ];

            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $currency = new Currency;
            $currency->name = $data['currency'];
            // echo "<pre>"; print_r($trips->toArray()); die;
            $currency->save();
            return redirect('admin/currency')->with('success_message', $message);
        }
        return view('admin::currency.addCurrency', compact('common'));
    }

    /* -- edit currency -- */
    public function editCurrency(Request $request, $id)
    {
        $common = [];
        $common['title']         = "Currency";
        $common['heading_title'] = "Edit Currency";
        $common['button']        = "Update";
        $id = decrypt($id);
        $currency = Currency::findOrFail($id);
        $message = "Currency Updated Successfully!";

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $rules = [
                'currency'  => 'required|regex:/^[^\d]+$/|min:2|max:255',
            ];

            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $currency->name = $data['currency'];
            // echo "<pre>"; print_r($trips->toArray()); die;
            $currency->save();
            return redirect('admin/currency')->with('success_message', $message);
        }
        return view('admin::currency.editCurrency', compact('common','currency'));
    }

    /* --- delete currency ---*/
    public function destroy($id)
    {
        $currency = Currency::findOrFail($id);
        $currency->delete();
        return redirect()->back()->with('success_message', 'Currency Deleted Successfully!');
    }
}
