<?php

use App\Http\Controllers\V0\HealthCheckController;
use App\Http\Controllers\V0\SeedRankController;
use App\Http\Controllers\V0\SeedTestController;
use App\Http\Controllers\V0\TestQuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/')->uses([HealthCheckController::class, 'status']);

Route::get('/seed-ranks/')->uses([SeedRankController::class, 'index']);
Route::get('/seed-ranks/{rank}')->uses([SeedRankController::class, 'show']);

Route::get('/seed-tests/')->uses([SeedTestController::class, 'index']);
Route::get('/seed-tests/{test}')->uses([SeedTestController::class, 'show']);

Route::get('/test-questions/')->uses([TestQuestionController::class, 'index']);
Route::get('/test-questions/{id}')->uses([TestQuestionController::class, 'show']);

Route::get('/exception', function () {
    throw new \Exception('Exception');
});

Route::get('/request', function (Request $request) {
    $arr = [];

    $ip = $request->getClientIp();
    $userAgent = $request->userAgent();
    $apiVersion = $request->route()->getPrefix();
    $path = $request->getPathInfo();
    $queryString = $request->getQueryString();
    $fullPath = $request->getRequestUri();
    $fullUri = $request->getUri();
    $headers = $request->headers->all();
    $statusCode = $request->getStatusCode();

    dd($arr);

    // Ip
    // Headers
    // API Version
    // Endpoint
    // Query String
    // Success?
});
