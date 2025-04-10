<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\SignupFormsController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('login');
});


Route::get('/login', [AccountController::class, 'showForm'])->name('loginforms.form');
Route::post('/login', [AccountController::class, 'store'])->name('login.store');
Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.list');
//Route::get('/login', function(){ return view('login'); })->name('login');
//Route::post('/register', [LoginFormsController::class, 'store'])->name('loginForms.store');

//Route::post('/login#formsModal', [LoginFormsController::class, 'store'])->name('/login#loginForms.store');



//Route::get('/login#formsModal', [SignupFormsController::class, 'store'])->name('formsModal.store');
Route::post('/loginForms/store', [SignupFormsController::class, 'store'])->name('loginForms.store');
Route::get('/login', function () {
    return view('login');  // Or point to your login view
})->name('login');


Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::get('/dashboard', function () {
    return view('applicantdashboard');
})->name('applicantdashboard');