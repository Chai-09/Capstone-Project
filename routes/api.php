<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MobileAuthController;
use App\Http\Controllers\API\ForgotPassword\MobileFPController;
use App\Http\Controllers\API\ResetPassword\MobileResetController;
use App\Http\Controllers\API\MobileFormsController;
use App\Http\Controllers\API\MobileProfileController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) { 
    return $request->user();
});

Route::post('/mobile/login', [MobileAuthController::class, 'login']);
Route::post('/mobile/request-otp', [MobileAuthController::class, 'requestOtp']);
Route::post('/mobile/verify-otp', [MobileAuthController::class, 'verifyOtpAndRegister']);
Route::post('/mobile/resend-otp', [MobileAuthController::class, 'resendOtpMobile']);


Route::post('/mobile/forgot-password', [MobileFPController::class, 'sendResetLink']);
Route::post('/mobile/reset-password', [MobileResetController::class, 'reset']);

Route::middleware('auth:sanctum')->get('/mobile/profile', [MobileProfileController::class, 'show']);


Route::middleware('auth:sanctum')->post('/mobile/logout', [MobileAuthController::class, 'logout']);

// Step 1
Route::middleware('auth:sanctum')->post('/mobile/forms', [MobileFormsController::class, 'store']);


