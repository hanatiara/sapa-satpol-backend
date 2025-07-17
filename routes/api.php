<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/update-status', [AuthController::class, 'updateAccountStatus']);

Route::middleware('auth:sanctum')->get('/masyarakat', function (Request $request) {
    return $request->user();
});
Route::get('/show-laporan', [LaporanController::class, 'showAllLaporan']);
Route::get('/show-laporan-masuk', [LaporanController::class, 'showToday']);

# Using DP
Route::post('/create-laporan', [LaporanController::class, 'createLaporan']);
Route::post('/update-laporan', [LaporanController::class, 'updateLaporan']);
Route::delete('/delete-laporan', [LaporanController::class, 'deleteLaporan']);




