<?php

use App\Http\Controllers\Api\V1\VenueController;
use Illuminate\Support\Facades\Route;

Route::get('/venues', [VenueController::class, 'getVenues']);