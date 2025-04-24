<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignupFormsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\FillupFormsController;
use App\Http\Controllers\RoleController;

//THESE ARE PUBLIC ROUTES 
// Log in Routes
Route::redirect('/', '/login');
Route::view('/login', 'login.index')->name('login');

Route::post('/signup', [SignupFormsController::class, 'store'])->name('loginForms.store');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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

    //Redirect sa admission
    Route::get('/dashboard', function () {
        return view('applicant.index');
    })->name('applicantdashboard');

    //payment page
    Route::get('/applicant/payment/payment', function () {
        return view('applicant.payment.payment');
    })->name('applicant.payment.payment');

    //educational background to 'form has been submitted' page
    Route::get('/applicant/steps/forms/form-submitted', function () {
        return view('applicant.steps.forms.form-submitted');
    })->name('applicant.steps.forms.form-submitted');

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

    // Submitting of Forms (Step 1)
    Route::get('/form/step3', [FillupFormsController::class, 'createStep3'])->name('form.step3');
    Route::post('/form/step3', [FillupFormsController::class, 'postStep3']);

    // Success route
    Route::get('/applicant/payment/payment', function () {
        return view('applicant/payment/payment'); // A success view after form submission
    })->name('applicant.payment.payment');

    //routes for sidebar
    Route::get('/applicant/steps/forms/applicantforms', function () {
        return view('applicant.steps.forms.applicantforms');
    })->name('fillupforms');

    //if role == admin, edi ipapakita yung dashboard ng admin
    Route::get('/administrator/dashboard', [App\Http\Controllers\AdminAccountController::class, 'index'])->name('admindashboard');

    Route::get('/administrator/create-accounts', function () {
        return view('administrator.create-accounts');
    })->name('admin.createaccounts');

    Route::post('/administrator/create-account', [App\Http\Controllers\AdminController::class, 'createAccount'])->name('admin.createAccount');
});
