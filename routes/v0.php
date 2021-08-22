<?php

use App\Http\Controllers\V0\HealthCheckController;
use App\Http\Controllers\V0\SeedRankController;
use Illuminate\Support\Facades\Route;

Route::get('/')->uses([HealthCheckController::class, 'status']);
Route::resource('seed-ranks', SeedRankController::class)->only(['index', 'show']);
