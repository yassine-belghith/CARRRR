<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Using web routes for authentication instead of API routes
// Login is handled by UserController@login in web.php


use App\Http\Controllers\LocationController;
use App\Http\Controllers\Api\DriverController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Driver authentication routes
Route::post('/driver/login', [DriverController::class, 'login']);

// Driver API routes
Route::middleware(['auth:sanctum', 'driver'])->prefix('driver')->group(function () {
    Route::get('/dashboard', [DriverController::class, 'dashboard']);
    Route::get('/transfers', [DriverController::class, 'transfers']);
    Route::get('/rentals', [DriverController::class, 'rentals']);
    Route::get('/transfers/{transfer}', [DriverController::class, 'transferDetail']);
    Route::get('/rentals/{rental}', [DriverController::class, 'rentalDetail']);
    Route::post('/transfers/{transfer}/confirm', [DriverController::class, 'confirmTransfer']);
    Route::post('/transfers/{transfer}/decline', [DriverController::class, 'declineTransfer']);
    Route::post('/transfers/{transfer}/start', [DriverController::class, 'startJob']);
    Route::post('/transfers/{transfer}/end', [DriverController::class, 'endJob']);
    Route::get('/profile', [DriverController::class, 'profile']);
    Route::put('/profile', [DriverController::class, 'updateProfile']);
    Route::post('/logout', [DriverController::class, 'logout']);
});

Route::get('/locations/search', [LocationController::class, 'search'])->name('locations.search');
Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
