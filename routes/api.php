<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::get('/siswa/me', [StudentController::class, 'me'])->middleware('auth:sanctum');
Route::group(['prefix' => 'siswa', 'middleware' => 'auth:sanctum'], function () {
    Route::patch('/me', [StudentController::class, 'updateMyProfile']);
});
Route::resource('/siswa', StudentController::class);
