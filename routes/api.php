<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MobileAuthController;
use App\Http\Controllers\API\ForgotPassword\MobileFPController;
use App\Http\Controllers\API\ResetPassword\MobileResetController;
use App\Http\Controllers\API\MobileFormsController;
use App\Http\Controllers\API\MobileProfileController;
use App\Http\Controllers\API\MobilePayment\MobilePaymentController;
use App\Http\Controllers\API\MobileSchedule\MobileScheduleController;
use App\Http\Controllers\API\ApplicantScheduleController;
use App\Http\Controllers\API\MobileResult\MobileResultController;

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


// Step 2 and 3
Route::middleware('auth:sanctum')->post('/mobile/payment', [MobilePaymentController::class, 'store']);

Route::middleware('auth:sanctum')->get('/mobile/payment/view', [MobilePaymentController::class, 'viewPayment']);

Route::middleware('auth:sanctum')->post('/mobile/payment/revert', [MobilePaymentController::class, 'revertStep']);

Route::middleware('auth:sanctum')->post('/mobile/payment/advance-step', [MobilePaymentController::class, 'advanceStep']);



// Step 4 
Route::middleware('auth:sanctum')->get('/mobile/exam-schedules', [MobileScheduleController::class, 'index']);

Route::middleware('auth:sanctum')->post('/mobile/book-exam', [MobileScheduleController::class, 'book']);


// Step 5
Route::middleware('auth:sanctum')->get('/mobile/take-exam-info', [MobileScheduleController::class, 'getSchedule']);
Route::middleware('auth:sanctum')->post('/mobile/advance-step-6', [MobileResultController::class, 'advanceToStep6']);

Route::middleware('auth:sanctum')->get('/mobile/exam-result', [MobileResultController::class, 'getExamResult']);

Route::middleware('auth:sanctum')->get('/mobile/show-exam-result', [MobileResultController::class, 'show']);