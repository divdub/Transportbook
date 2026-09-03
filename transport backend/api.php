<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\PartyController;
use App\Http\Controllers\Api\TruckController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\TripController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\StateController;
use App\Http\Controllers\Api\CompanyController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/company/send-otp', [CompanyController::class, 'sendOtp']);
Route::post('/company/verify-otp', [CompanyController::class, 'verifyOtp']);

Route::middleware('auth:sanctum')->group(function () {
Route::apiResource('drivers', DriverController::class);
Route::apiResource('parties', PartyController::class);
Route::apiResource('trucks', TruckController::class);
Route::apiResource('suppliers', SupplierController::class);
Route::apiResource('trips', TripController::class);
Route::apiResource('cities', CityController::class);
Route::apiResource('expenses', ExpenseController::class);
Route::apiResource('states', StateController::class);
Route::apiResource('companies', CompanyController::class);
Route::patch('/trips/{tripid}/status', [TripController::class, 'updateStatus']);

});
