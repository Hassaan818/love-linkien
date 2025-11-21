<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AvailabilityController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InspirationController;
use App\Http\Controllers\Admin\MeetingController;
use App\Http\Controllers\Admin\VenueController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'index'])->name('login');
    Route::post('/admin/login', [AuthController::class, 'store'])->name('admin.login');
});

Route::group([
    'as' => 'admin.',
    'prefix' => 'admin',
    'middleware' => ['auth', 'role:admin'],
], function () {
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/categories', CategoryController::class);
    Route::resource('/inspirations', InspirationController::class);
    Route::resource('venues', VenueController::class);
    Route::resource('availability', AvailabilityController::class);
    Route::get('/meetings', [MeetingController::class, 'index'])->name('meetings.index');
    Route::get('/meeting/{id}', [MeetingController::class, 'show'])->name('meetings.show');
    Route::delete('/meeting/{id}', [MeetingController::class, 'destroy'])->name('meetings.destroy');

    Route::resource('users', AdminController::class)->except(['show']);
    Route::resource('availability', AvailabilityController::class);
});
