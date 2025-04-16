<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignupFormsController;
use App\Http\Controllers\AuthController;


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
