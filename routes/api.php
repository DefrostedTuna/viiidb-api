<?php

use Illuminate\Http\Request;

Route::get('/status')->uses('StatusController@healthCheck');

Route::resource('seed-ranks', 'SeedRankController')->only(['index', 'show']);