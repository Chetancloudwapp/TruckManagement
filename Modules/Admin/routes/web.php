<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\app\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::prefix('admin')->group(function(){
    Route::match(['get','post'], '/login', 'AdminController@login');
    
    /* -- middleware -- */
    Route::group(['middleware' => ['admin_auth']], function(){
        Route::get('dashboard', 'AdminController@dashboard');
        Route::get('/logout', 'AdminController@logout');
        Route::match(['get','post'], '/dashboard', 'DashboardController@index');
        
        // subadmins
        Route::get('/subadmins', 'AdminController@index');
        Route::match(['get','post'], '/subadmins/add', 'AdminController@addSubadmin');
        Route::match(['get','post'], '/subadmins/edit/{id}', 'AdminController@editSubadmin');
        Route::match(['get','post'], '/subadmins/delete/{id}', 'AdminController@destroy');
        Route::post('/update-subadmin-status', 'AdminController@UpdateSubadminStatus');
        Route::match(['get', 'post'], '/update-role/{id}', 'AdminController@updateRole');
        Route::post('/roles-and-permission', 'AdminController@UpdateRolesAndPermission');
        
        // trucks
        Route::get('/truck', 'TruckController@index');
        Route::match(['get','post'], '/truck/add', 'TruckController@addTruck');
        Route::match(['get','post'], '/truck/edit/{id}', 'TruckController@editTruck');
        Route::match(['get','post'], '/truck/view/{id}', 'TruckController@viewTruck');
        Route::match(['get','post'], '/truck/delete/{id}', 'TruckController@destroy');

        // drivers
        Route::get('/drivers', 'DriverController@index');
        Route::match(['get','post'], '/drivers/add', 'DriverController@addDriver');
        Route::match(['get','post'], '/drivers/edit/{id}','DriverController@editDriver');
        Route::match(['get','post'], '/drivers/view/{id}', 'DriverController@viewDriver');
        Route::match(['get','post'], '/drivers/delete/{id}', 'DriverController@destroy');

        // currency
        Route::get('/currency', 'CurrencyController@index');
        Route::match(['get','post'], '/currency/add', 'CurrencyController@addCurrency');
        Route::match(['get','post'], '/currency/edit/{id}', 'CurrencyController@editCurrency');
        Route::get('/currency/delete/{id}', 'CurrencyController@destroy');
        
        // Category
        Route::get('/category', 'CategoryController@index');
        Route::match(['get','post'], '/category/add', 'CategoryController@addCategory');
        Route::match(['get','post'], '/category/edit/{id}', 'CategoryController@editCategory');
        Route::get('/category/delete/{id}', 'CategoryController@destroy');
        
        // office-expense
        Route::get('/office-expense', 'OfficeExpenseController@index');
        Route::match(['get','post'], '/office-expense-add', 'OfficeExpenseController@addOfficeExpense');
        Route::match(['get','post'], '/office-expense-edit/{id}', 'OfficeExpenseController@editOfficeExpense');
        Route::get('/office-expense/delete/{id}', 'OfficeExpenseController@destroy');
        
        // Reports
        Route::get('/office-expense-report-index', 'ReportsController@OfficeExpIndex');
        Route::get('/office-expense-report-view/{id}', 'ReportsController@ViewOfficeExpense');

        Route::get('/reports', 'ReportsController@MainReports');
        Route::match(['get','post'], '/trip-expense-export', 'ReportsController@TripExpenseExport');
        
        // privay-policy
        Route::match(['get','post'], '/privacy-policy', 'PagesController@index');
        Route::match(['get','post'], '/privacy-policy/edit/{id}', 'PagesController@editPrivacyPolicy');

        // terms-n-conditions
        Route::get('/terms-and-conditions', 'PagesController@tncIndex');
        Route::match(['get','post'], '/terms-and-conditions/edit/{id}', 'PagesController@editTnc');

        // trips
        Route::get('/trips', 'TripController@index');
        Route::match(['get','post'], '/trips/add', 'TripController@addTrips');
        Route::match(['get','post'], '/trips/edit/{id}', 'TripController@editTrips');
        Route::match(['get','post'], '/trips/delete/{id}','TripController@destroy');
        
        // pending trips
        Route::match(['get','post'], '/pending-trips', 'TripController@PendingTripIndex');
        Route::match(['get','post'], '/pending-trips/view/{id}', 'TripController@viewPendingTrip');
        Route::match(['get','post'], '/pending-trips/edit/{id}', 'TripController@editPendingTrip');
        
        // Ongoing trips
        Route::match(['get','post'], '/ongoing-trips', 'TripController@OngoingTripIndex');
        Route::match(['get','post'], '/ongoing-trips-view/{id}', 'TripController@viewOngoingTrip');
        
        // completed trips
        Route::match(['get','post'], '/completed-trips', 'TripController@CompletedTripIndex');
        Route::match(['get','post'], '/completed-trips-view/{id}', 'TripController@viewCompletedTrip');

    });
});



