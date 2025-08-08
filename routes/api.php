<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

# logged users only
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/masyarakat', function (Request $request) {
//         return $request->user();
//     });

    Route::post('/update-status', [AuthController::class, 'updateAccountStatus']);
    // Get User status count
    Route::get('/get-status-count', [AuthController::class, 'getAccountStatusCount']);
    Route::get('/get-all-account', [AuthController::class, 'getAllAccount']);
    Route::post('/update-role', [AuthController::class, 'updateAccountRole']);
    Route::post('/get-user-nik', [AuthController::class, 'getAccountById']);
    Route::delete('/delete-user', [AuthController::class, 'deleteUser']);
    Route::post('/update-user', [AuthController::class, 'updateProfile']);

    Route::get('/show-all-laporan', [LaporanController::class, 'showAllLaporan']);
    Route::get('/show-laporan-masuk', [LaporanController::class, 'showToday']);
    Route::post('/create-laporan', [LaporanController::class, 'createLaporan']);
    Route::post('/update-laporan', [LaporanController::class, 'updateLaporan']);
    Route::delete('/delete-laporan', [LaporanController::class, 'deleteLaporan']);
    Route::post('/show-laporan', [LaporanController::class, 'showLaporanById']);

    Route::post('/logout', [AuthController::class, 'logout']);
// });





