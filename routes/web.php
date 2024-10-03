<?php

use Illuminate\Support\Facades\Route;

/* Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*'); */
Route::get('/{any}', function () {
    if (request()->is('api/*')) {
        abort(404); // Return a 404 for API routes
    }
    return view('welcome');
})->where('any', '.*');