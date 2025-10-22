<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\SocialAuthController;
use Illuminate\Support\Facades\Route;

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

// Route::get('/redirect/{provider}', [SocialAuthController::class, 'redirect'])->name('auth.redirect');
// Route::get('/{provider}/callback', [SocialAuthController::class, 'callback']);
