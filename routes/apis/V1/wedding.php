<?php

use App\Http\Controllers\Api\V1\BridalController;
use App\Http\Controllers\Api\V1\InspirationController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/weddings', [BridalController::class, 'getWeddingInfo']);
    Route::post('/weddings', [BridalController::class, 'store']);
});
