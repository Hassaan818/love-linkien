<?php

use App\Http\Controllers\Api\V1\MeetingController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/meeting/{slug}', [MeetingController::class, 'scheduleMeeting']);
});
