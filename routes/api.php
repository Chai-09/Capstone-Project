<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MobileAuthController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/mobile/login', [MobileAuthController::class, 'login']);
Route::post('/mobile/request-otp', [MobileAuthController::class, 'requestOtp']);
Route::post('/mobile/verify-otp', [MobileAuthController::class, 'verifyOtpAndRegister']);


Route::middleware('auth:sanctum')->get('/mobile/profile', function (Request $request) {
    return $request->user();
});
