<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\PartyController;
use App\Http\Controllers\Api\TruckController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\TripController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::apiResource('drivers', DriverController::class);
Route::apiResource('parties', PartyController::class);
Route::apiResource('trucks', TruckController::class);
Route::apiResource('suppliers', SupplierController::class);
Route::apiResource('trips', TripController::class);
