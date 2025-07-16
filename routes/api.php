<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/update-status', [AuthController::class, 'updateAccountStatus']);

Route::post('/laporan-kransos', [LaporanController::class, 'createLaporanKransos']);
Route::post('/laporan-pamwal', [LaporanController::class, 'createLaporanPamwal']);
Route::post('/laporan-pengamanan', [LaporanController::class, 'createLaporanPengamanan']);
Route::post('/laporan-perizinan', [LaporanController::class, 'createLaporanPerizinan']);
Route::post('/laporan-piket', [LaporanController::class, 'createLaporanPiket']);
Route::post('/laporan-pkl', [LaporanController::class, 'createLaporanPkl']);
Route::post('/laporan-reklame', [LaporanController::class, 'createLaporanReklame']);

Route::middleware('auth:sanctum')->get('/masyarakat', function (Request $request) {
    return $request->user();
});
Route::get('/show-laporan', [LaporanController::class, 'showAllLaporan']);
Route::get('/show-laporan-masuk', [LaporanController::class, 'showToday']);



