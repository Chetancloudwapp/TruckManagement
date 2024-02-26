<?php

namespace Modules\Admin\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Admin\app\Models\{OfficeExpense, Trip, TruckDriver};
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exports\{GeneralTripReportExport,TripExpensesExport,OfficeExpensesExport,MonthlyExpensesExport};
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admin\app\Models\Category;
use Carbon\Carbon;

class ReportsController extends Controller
{
    /* -- office expense index -- */
    public function OfficeExpIndex()
    {
        $common = [];
        $common['title'] = 'Office Expense';
        $common['button'] = 'Submit';
        $get_office_expense = OfficeExpense::orderBy('id','desc')->get();
        return view('admin::reports.officeExpense.index', compact('common', 'get_office_expense'));
    }

    /* --- view office expense --- */
    public function ViewOfficeExpense(Request $request, $id)
    {
        $common = [];
        $common['title'] = "Office Expense";
        $id = decrypt($id);
        $get_office_expense = OfficeExpense::with('category')->findOrFail($id);
        // echo "<pre>"; print_r($get_office_expense->toArray()); die;
        return view('admin::officeExpense.viewOfficeExpense', compact('common','get_office_expense'));        
    }

    /* -- main reports -- */
    public function MainReports(Request $request)
    {
        return view('admin::reports.main_reports');
    }

    public function TripExpenseExport(Request $request)
    {
        $fromDate = $request->input('start_date');
        $toDate   = $request->input('end_date');
        
        if($request->general_report =='general_report'){
           return Excel::download(new GeneralTripReportExport($fromDate,$toDate), 'general_report.xlsx'); 
        }
      
        if($request->general_report =='trip_expenses'){
           return Excel::download(new TripExpensesExport($fromDate,$toDate), 'trip_expenses.xlsx'); 
        }
        
        
        if($request->general_report =='office_expenses'){
           return Excel::download(new OfficeExpensesExport($fromDate,$toDate), 'office_expenses.xlsx'); 
        }
        
        
        if($request->general_report =='monthly_expenses'){
           return Excel::download(new MonthlyExpensesExport($fromDate,$toDate), 'monthly_expenses.xlsx'); 
        }
        
    }
}
