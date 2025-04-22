<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignupFormsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\FillupFormsController;


// Log in Routes
Route::redirect('/', '/login');
Route::view('/login', 'login.index')->name('login');

Route::post('/signup', [SignupFormsController::class, 'store'])->name('loginForms.store');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//Redirect sa admission
Route::get('/dashboard', function () {
    return view('applicant.index');
})->name('applicantdashboard');

//Forgot Password Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

//index applicant to fillup forms
Route::get('/fillupforms', function () {
    return view('steps.fillupforms.fillupforms');
})->name('fillupforms');

// Display the fill-up form
Route::get('/fillupforms/create', [FillupFormsController::class, 'create'])->name('fillupforms.create');

// Handle form submission
Route::post('/fillupforms', [FillupFormsController::class, 'store'])->name('fillupforms.store');

// SignUp OTP Routes
Route::post('/signup/request-otp', [SignupFormsController::class, 'requestOtp'])->name('signup.requestOtp');
Route::get('/signup/verify', [SignupFormsController::class, 'showOtpForm'])->name('signup.showOtpForm');
Route::post('/signup/verify', [SignupFormsController::class, 'verifyOtpAndCreate'])->name('signup.verifyOtp');
Route::post('/signup/resend-otp', [SignupFormsController::class, 'resendOtp'])->name('signup.resendOtp');

