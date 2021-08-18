<?php

use App\Http\Controllers\Api\V0\HealthCheckController;
use Illuminate\Support\Facades\Route;

Route::get('/')->uses([HealthCheckController::class, 'status']);
