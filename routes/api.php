<?php

use Illuminate\Http\Request;

Route::get('/status')->uses('StatusController@healthCheck');

Route::resource('seed-ranks', 'SeedRankController')->only(['index', 'show']);
Route::resource('elements', 'ElementController')->only(['index', 'show']);
Route::resource('locations', 'LocationController')->only(['index', 'show']);
Route::resource('status-effects', 'StatusEffectController')->only(['index', 'show']);
Route::resource('seed-tests', 'SeedTestController')->only(['index', 'show']);
Route::resource('test-questions', 'TestQuestionController')->only(['index', 'show']);