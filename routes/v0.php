<?php

use App\Http\Controllers\V0\HealthCheckController;
use App\Http\Controllers\V0\SeedRankController;
use Illuminate\Support\Facades\Route;

Route::get('/')->uses([HealthCheckController::class, 'status']);
Route::get('/seed-ranks/')->uses([SeedRankController::class, 'index']);
Route::get('/seed-ranks/{rank}')->uses([SeedRankController::class, 'show']);
