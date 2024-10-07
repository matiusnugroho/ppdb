<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DocumentTypeController;
use App\Http\Controllers\API\KecamatanController;
use App\Http\Controllers\API\PendaftaranController;
use App\Http\Controllers\API\SchoolController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\FileUploadTestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie set.']);
});
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
    Route::post('/upload', [FileUploadTestController::class, 'upload']);
    Route::post('/update-foto', [StudentController::class, 'updatePhoto']);
});
Route::group(['prefix' => 'admin', 'middleware' => 'auth:sanctum'], function () {
    //Registration
    Route::post('/pendaftaran/buka-pendaftaran', [PendaftaranController::class, 'bukaPendaftaran']);
    Route::resource('/sekolah', SchoolController::class)->only(['create', 'update', 'destroy']);
});
Route::group(['middleware' => 'auth:sanctum'], function () {
    route::post('/pendaftaran/daftar', [PendaftaranController::class, 'daftar']);
    route::get('/pendaftaran/cek-pendaftaran', [PendaftaranController::class, 'cekPendaftaran']);
    route::get('/pendaftaran/dokumen', [PendaftaranController::class, 'dokumen']);
    route::post('/pendaftaran/upload_dokumen/{registration}', [PendaftaranController::class, 'uploadDokumen']);
    route::post('/pendaftaran/revisi_dokumen/{document}', [PendaftaranController::class, 'revisiDokumen']);
});
Route::resource('/siswa', StudentController::class);
Route::post('/siswa/register', [StudentController::class, 'store']);
Route::post('/sekolah/register', [SchoolController::class, 'store']);
Route::get('/kecamatan/', [KecamatanController::class, 'index']);
Route::get('/sekolah/', [SchoolController::class, 'index']);
Route::get('/sekolah/kecamatan/{kecamatanId}', [SchoolController::class, 'getByKecamatan']);
Route::get('/sekolah/kecamatan/{kecamatanId}/{jenjang}', [SchoolController::class, 'getByKecamatan']);
Route::get('/registration/get-opened', [PendaftaranController::class, 'getOpenPeriods']);
Route::get('/registration/cek-pendaftaran-hari-ini', [PendaftaranController::class, 'isTodayOpened']);
Route::resource('/document-type', DocumentTypeController::class);
