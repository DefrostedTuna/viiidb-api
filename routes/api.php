<?php

use Illuminate\Http\Request;

Route::get('/status')->uses('StatusController@healthCheck');