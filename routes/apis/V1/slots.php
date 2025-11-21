<?php

use App\Http\Controllers\Api\V1\AvailabilityController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/slots/{userId}', [AvailabilityController::class, 'slotsForAdmin']);
    Route::get('/admins', [AvailabilityController::class, 'admins']);
});
