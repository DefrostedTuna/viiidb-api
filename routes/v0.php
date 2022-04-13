<?php

use App\Http\Controllers\V0\ElementController;
use App\Http\Controllers\V0\HealthCheckController;
use App\Http\Controllers\V0\SearchController;
use App\Http\Controllers\V0\SeedRankController;
use App\Http\Controllers\V0\SeedTestController;
use App\Http\Controllers\V0\StatusEffectController;
use App\Http\Controllers\V0\TestQuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/')->uses([HealthCheckController::class, 'status'])->withoutMiddleware([
    'throttle:api',
    'request.capture',
]);

Route::get('/search')->uses([SearchController::class, 'index'])->middleware('search.sanitize');

Route::group(['middleware' => 'relations.sanitize'], function () {
    Route::get('/seed-ranks/')->uses([SeedRankController::class, 'index']);
    Route::get('/seed-ranks/{rank}')->uses([SeedRankController::class, 'show']);

    Route::get('/seed-tests/')->uses([SeedTestController::class, 'index']);
    Route::get('/seed-tests/{test}')->uses([SeedTestController::class, 'show']);

    Route::get('/test-questions/')->uses([TestQuestionController::class, 'index']);
    Route::get('/test-questions/{id}')->uses([TestQuestionController::class, 'show']);

    Route::get('/status-effects/')->uses([StatusEffectController::class, 'index']);
    Route::get('/status-effects/{id}')->uses([StatusEffectController::class, 'show']);

    Route::get('/elements/')->uses([ElementController::class, 'index']);
    Route::get('/elements/{id}')->uses([ElementController::class, 'show']);
});
