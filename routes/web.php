<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\AdminDriverController;


Route::get('/', [DriverController::class, 'index'])->name('index');

// Form to register a new driver (same as index in this case)
Route::post('/register-driver', [DriverController::class, 'store'])->name('drivers.store');

// Form view to check driver status
Route::get('/check-status', [DriverController::class, 'showCheckForm'])->name('drivers.check.form');

// POST route to process check status form
Route::post('/check-status', [DriverController::class, 'checkStatus'])->name('drivers.check.status');

// Driver dashboard route (after successful registration or lookup)
Route::get('/driver-dashboard/{driver}', [DriverController::class, 'driversDashboard'])->name('drivers.dashboard');





// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Authentication Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Dashboard
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth:admin')->name('index');

    // Driver Management Routes
    Route::prefix('drivers')->name('drivers.')->group(function () {
        Route::get('/', [AdminDriverController::class, 'index'])->name('index');
        Route::get('/filter/{status}', [AdminDriverController::class, 'filter'])->name('filter');
        Route::get('/{driver}/edit', [AdminDriverController::class, 'edit'])->name('edit');
        Route::put('/{driver}', [AdminDriverController::class, 'update'])->name('update');
        Route::get('/create', [AdminDriverController::class, 'add'])->name('create');
        Route::post('/', [AdminDriverController::class, 'store'])->name('store');
        Route::delete('/{id}', [AdminDriverController::class, 'destroy'])->name('destroy');
        Route::patch('/{driver}/status', [AdminDriverController::class, 'updateStatus'])->name('updateStatus');
    });

    // PDF Export
    Route::get('/export-pdf', [AuthController::class, 'exportPdf'])->middleware('auth:admin')->name('export-pdf');
});
