<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignupFormsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\FillupFormsController;

//THESE ARE PUBLIC ROUTES 
// Log in Routes
Route::redirect('/', '/login');
Route::view('/login', 'login.index')->name('login');

Route::post('/signup', [SignupFormsController::class, 'store'])->name('loginForms.store');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//Forgot Password Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

// SignUp OTP Routes
Route::post('/signup/request-otp', [SignupFormsController::class, 'requestOtp'])->name('signup.requestOtp');
Route::get('/signup/verify', [SignupFormsController::class, 'showOtpForm'])->name('signup.showOtpForm');
Route::post('/signup/verify', [SignupFormsController::class, 'verifyOtpAndCreate'])->name('signup.verifyOtp');
Route::post('/signup/resend-otp', [SignupFormsController::class, 'resendOtp'])->name('signup.resendOtp');

//THIS IS FOR THE IMPORTANT ROUTES, THOSE THAT ARE NOT PUBLIC PUT IT IN THIS MIDDLEWARE BLOCK
Route::middleware(['auth'])->group(function () {

//index applicant to fillup forms
Route::get('/fillupforms', function () {
    return view('steps.fillupforms.fillupforms');
})->name('fillupforms');

// Display the fill-up form
Route::get('/fillupforms/create', [FillupFormsController::class, 'create'])->name('fillupforms.create');

// Handle form submission
Route::post('/fillupforms', [FillupFormsController::class, 'store'])->name('fillupforms.store');

//Redirect sa admission
Route::get('/dashboard', function () {
    return view('applicant.index');
})->name('applicantdashboard');

//payment page
Route::get('/applicant/payment/payment', function () {
    return view('applicant.payment.payment'); 
});

//routing from index to applicant
Route::get('/applicant/steps/forms/applicantforms', function () {
    return view('applicant.steps.forms.applicantforms'); 
});

//routing from applicant to guardian
Route::get('/applicant/steps/forms/guardianforms', function () {
    return view('applicant.steps.forms.guardianforms'); 
});

//routing from guardian to schoolinfo
Route::get('/applicant/steps/forms/schoolinfoforms', function () {
    return view('applicant.steps.forms.schoolinfoforms'); 
});


// Success route
Route::get('/applicant/payment/payment', function () {
    return view('applicant/payment/payment'); // A success view after form submission
})->name('applicant.payment.payment');

Route::get('/form/step1', [FillupFormsController::class, 'createStep1'])->name('form.step1');
Route::post('/form/step1', [FillupFormsController::class, 'postStep1']);

Route::get('/form/step2', [FillupFormsController::class, 'createStep2'])->name('form.step2');
Route::post('/form/step2', [FillupFormsController::class, 'postStep2']);

Route::get('/form/step3', [FillupFormsController::class, 'createStep3'])->name('form.step3');
Route::post('/form/step3', [FillupFormsController::class, 'postStep3']);

});