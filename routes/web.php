<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignupFormsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;


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
