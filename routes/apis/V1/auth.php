<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\SocialAuthController;
use Illuminate\Support\Facades\Route;

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::delete('/user/delete',[AuthController::class, 'deleteAccount'])->middleware(['auth:sanctum']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Route::get('/redirect/{provider}', [SocialAuthController::class, 'redirect'])->name('auth.redirect');
// Route::get('/{provider}/callback', [SocialAuthController::class, 'callback']);
