<?php

namespace Modules\Admin\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Admin\app\Models\OfficeExpense;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::create');
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
