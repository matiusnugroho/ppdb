<?php

use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DocumentTypeController;
use App\Http\Controllers\API\JalurController;
use App\Http\Controllers\API\KecamatanController;
use App\Http\Controllers\API\PendaftaranController;
use App\Http\Controllers\API\PersyaratanController;
use App\Http\Controllers\API\SchoolController;
use App\Http\Controllers\API\StatistikController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\FileUploadTestController;
use App\Http\Controllers\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie set.']);
});
Route::resource('/setting', SettingController::class);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'auth', 'middleware' => 'throttle:5,1'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('change-password', [AuthController::class, 'changePassword']);
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
    Route::post('/akun/update', [AdminController::class, 'updateAkun']);
    //Setup Persyaratan
    Route::resource('/persyaratan', DocumentTypeController::class)->only(['create', 'update', 'destroy']);
    Route::post('setting/update', [SettingController::class, 'update']);
    Route::get('/persyaratan-jalur', [PersyaratanController::class, 'index']);
});
Route::group(['middleware' => 'auth:sanctum'], function () {
    route::post('/pendaftaran/daftar', [PendaftaranController::class, 'daftar']);
    route::post('/pendaftaran/verifikasi/', [PendaftaranController::class, 'verifikasi']);
    Route::get('/pendaftaran/verified_by_me', [PendaftaranController::class, 'getPendaftarVerifiedByMe']);
    Route::get('/pendaftaran/detail/{registration}', [PendaftaranController::class, 'detail']);
    route::get('/pendaftaran/cek-pendaftaran', [PendaftaranController::class, 'cekPendaftaran']);
    route::get('/pendaftaran/get-pendaftar', [PendaftaranController::class, 'getPendaftarSekolah']);
    route::get('/pendaftaran/dokumen', [PendaftaranController::class, 'dokumen']);
    route::post('/pendaftaran/upload_dokumen/{document}', [PendaftaranController::class, 'uploadDokumen']);
    route::post('/pendaftaran/revisi_dokumen/{document}', [PendaftaranController::class, 'revisiDokumen']);
    route::post('/pendaftaran/verifikasi_dokumen/{document}', [PendaftaranController::class, 'verifikasiDokumen']);
    Route::post('/pendaftaran/reject_dokumen/{document}', [PendaftaranController::class, 'rejectDokumen']);
    route::post('/pendaftaran/luluskan/{registration}', [PendaftaranController::class, 'luluskan']);
    Route::get('/statistik/sekolah', [StatistikController::class, 'sekolah']);
    Route::get('/statistik/admin', [StatistikController::class, 'admin']);
});
Route::resource('/siswa', StudentController::class);
Route::get('/jalur', [JalurController::class, 'index']);
Route::get('/jalur/{registrationPath}/persyaratan', [JalurController::class, 'persyaratan']);
Route::get('/jalur/persyaratan', [JalurController::class, 'denganPersyaratan']);
Route::get('/statistik/', [StatistikController::class, 'admin']);
Route::post('/siswa/register', [StudentController::class, 'store']);
Route::post('/sekolah/register', [SchoolController::class, 'store']);
Route::get('/sekolah/excel', [SchoolController::class, 'excel']);
Route::get('/sekolah/excel-with-data', [SchoolController::class, 'excelWithData']);
Route::get('/kecamatan/', [KecamatanController::class, 'index']);
Route::get('/sekolah/', [SchoolController::class, 'index']);
Route::get('/sekolah/kecamatan/{kecamatanId}', [SchoolController::class, 'getByKecamatan']);
Route::get('/sekolah/kecamatan/{kecamatanId}/{jenjang}', [SchoolController::class, 'getByKecamatan']);
Route::get('/registration/get-opened', [PendaftaranController::class, 'getOpenPeriods']);
Route::get('/registration/cek-pendaftaran-hari-ini', [PendaftaranController::class, 'isTodayOpened']);
Route::resource('/document-type', DocumentTypeController::class);
