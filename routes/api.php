<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/update-status', [AuthController::class, 'updateAccountStatus']);
Route::middleware('auth:sanctum')->get('/masyarakat', function (Request $request) {
    return $request->user();
});
