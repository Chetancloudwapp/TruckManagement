<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PagesApiController;
use App\Http\Controllers\Api\TripApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// UnAuthorized Route
Route::post('/login', [AuthController::class, 'UserLogin']);
Route::get('/privacy-policy', [PagesApiController::class, 'PrivacyPolicy']);
Route::get('/terms-and-conditions', [PagesApiController::class, 'TermsandConditions']);
Route::post('/send-verification-email', [AuthController::class, 'VerifyEmail']);

// Authorized Route
Route::group(['middleware'=>'auth:sanctum'], function(){
    
    Route::post('/logout', [AuthController::class, 'Logout']);
    Route::post('/profile-update', [AuthController::class, 'DriverProfileUpdate']);
    Route::get('/profile-detail', [AuthController::class, 'ProfileDetail']);
    Route::get('/my-trips', [TripApiController::class, 'MyTrips']);
    Route::get('/trip-details', [TripApiController::class, 'TripDetails']);
    Route::post('/trip-accept', [TripApiController::class, 'TripAccept']);
    Route::post('/trip-start', [TripApiController::class, 'TripStart']);
    Route::post('/add-on-diesel', [TripApiController::class, 'AddOnDiesel']);
    Route::post('/enroute-diesel', [TripApiController::class, 'enrouteDiesel']);
    Route::post('/enroute-repairs', [TripApiController::class, 'enrouteRepairs']);
    Route::post('/enroute-toll', [TripApiController::class, 'enrouteTolls']);
    Route::post('/road-accident', [TripApiController::class, 'roadAccident']);
    Route::post('/fines', [TripApiController::class, 'enrouteFines']);
    Route::post('/other-charges', [TripApiController::class, 'OtherCharges']);
    Route::post('/delivery-note', [TripApiController::class, 'deliveryNote']);
    Route::post('/end-trip', [TripApiController::class, 'endTrip']);
});

// Route::get('/email/verify', function () {
//     return view('auth.verify-email');
// })->middleware('auth')->name('verification.notice');

// Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');

// Route::post('/email/verification-notification', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();
 
//     return back()->with('message', 'Verification link sent!');
// })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

