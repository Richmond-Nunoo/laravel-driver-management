<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\AdminDriverController;


Route::get('/', [DriverController::class, 'index'])->name('index');

// Form to register a new driver (same as index in this case)
Route::post('/register-driver', [DriverController::class, 'store'])->name('drivers.store');

// Form to check driver status
Route::get('/check-status', [DriverController::class, 'showCheckForm'])->name('drivers.check.form');

// POST route to process check status form
Route::post('/check-status', [DriverController::class, 'checkStatus'])->name('drivers.check.status');

// Driver dashboard route (after successful registration or lookup)
Route::get('/driver-dashboard/{driver}', [DriverController::class, 'driversDashboard'])->name('drivers.dashboard');
