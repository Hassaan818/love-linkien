<?php

use App\Http\Controllers\Api\V1\ChecklistController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/checklist', [ChecklistController::class, 'getChecklist']);
    Route::post('/checklist/store', [ChecklistController::class, 'createCheckList']);
    Route::delete('/checklist/{id}', [ChecklistController::class, 'deleteCheckList']);
    Route::patch('/checklist/{id}', [ChecklistController::class, 'updateStatus']);
});
