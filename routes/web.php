<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignupFormsController;
use App\Http\Controllers\AuthController;

Route::redirect('/', '/login');  // Redirect sa log in
Route::view('/login', 'login')->name('login');

Route::post('/signup', [SignupFormsController::class, 'store'])->name('loginForms.store');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/applicantdashboard', function () {
    return view('applicantdashboard');
})->name('applicantdashboard');
