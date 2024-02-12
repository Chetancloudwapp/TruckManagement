<?php

namespace Modules\Admin\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\app\Models\OfficeExpense;
use Modules\Admin\app\Models\Category;
use Validator;

class OfficeExpenseController extends Controller
{
    /* -- expense listing -- */
    public function index()
    {
        $common = [];
        $common['title'] = 'Office Expense';
        $common['button'] = 'Submit';
        $get_office_expense = OfficeExpense::orderBy('id','desc')->get();
        return view('admin::officeExpense.index', compact('common', 'get_office_expense'));
    }

    /* -- add office Expense -- */
    public function addOfficeExpense(Request $request)
    {
        $common = [];
        $common['title']         = "Office Expense";
        $common['heading_title'] = "Add Office Expense";
        $common['button']        = "Submit";
        $message = "Office Expense Added Successfully!";

        $get_categories = Category::get();

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $rules = [
                'expense_type'    => 'required',
                'expense_amount'  => 'required',
                'expense_detail' => 'required',
                'remark'          => 'required',
                'document'        => 'required|mimes:jpeg,jpg,png,pdf',
            ];

            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $get_office_expense = new OfficeExpense;

            if($request->has('document')){
                $image = $request->file('document');
                $name = time(). '.' .$image->getClientOriginalExtension();
                $path = public_path('uploads/officeExpense/');
                $image->move($path, $name);
                $get_office_expense->file = $name;
            }

            $get_office_expense->expense_type   = $data['expense_type'];
            $get_office_expense->expense_amount = $data['expense_amount'];
            $get_office_expense->expense_detail = $data['expense_detail'];
            $get_office_expense->remark = $data['remark'];
            // echo "<pre>"; print_r($get_office_expense->toArray()); die;
            $get_office_expense->save();
            return redirect('admin/office-expense')->with('success_message', $message);
        }
        return view('admin::officeExpense.addOfficeExpense', compact('common','get_categories'));
    }

    /* -- edit office Expense -- */
    public function editOfficeExpense(Request $request, $id)
    {
        $common = [];
        $common['title']         = "Office Expense";
        $common['heading_title'] = "Edit Office Expense";
        $common['button']        = "Submit";
        $id = decrypt($id);
        $get_office_expense = OfficeExpense::findOrFail($id);
        $message = "Office Expense Updated Successfully!";

        $get_categories = Category::get();

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $rules = [
                'expense_type'    => 'required',
                'expense_amount'  => 'required',
                'expense_detail'  => 'required',
                'remark'          => 'required',
                'document'        => 'mimes:jpeg,jpg,png,pdf',
            ];

            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            if(isset($request->document)){
                if($request->has('document')){
                    $image = $request->file('document');
                    $name = time(). '.' .$image->getClientOriginalExtension();
                    $path = public_path('uploads/officeExpense/');
                    $image->move($path, $name);
                    $get_office_expense->file = $name;
                }
            }

            $get_office_expense->expense_type   = $data['expense_type'];
            $get_office_expense->expense_amount = $data['expense_amount'];
            $get_office_expense->expense_detail = $data['expense_detail'];
            $get_office_expense->remark = $data['remark'];
            // echo "<pre>"; print_r($get_office_expense->toArray()); die;
            $get_office_expense->save();
            return redirect('admin/office-expense')->with('success_message', $message);
        }
        return view('admin::officeExpense.editOfficeExpense', compact('common','get_office_expense','get_categories'));
    }

    /* -- delete expense -- */
    public function destroy($id)
    {
        $get_office_expense = OfficeExpense::findOrFail($id);
        $get_office_expense->delete();
        return redirect()->back()->with('success_message', 'Office Expense Deleted Successfully!');
        
    }
}
