<?php

use App\Http\Controllers\Api\V1\InspirationController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/inspirations', [InspirationController::class, 'index']);
    Route::get('/inspirations/{slug}', [InspirationController::class, 'getInspiration']);
    Route::post('/inspirations', [InspirationController::class, 'store']);
});
