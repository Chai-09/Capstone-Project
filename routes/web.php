<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignupFormsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\FillupFormsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminAccountController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ViewPaymentController;
use App\Http\Controllers\AccountingPaymentController;
use App\Models\FillupForms;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ExamDateController;
use App\Http\Controllers\AdmissionDateController;
use App\Http\Controllers\ExamScheduleController;
use App\Http\Controllers\ApplicantScheduleController;
use App\Models\ApplicantSchedule;
use App\Http\Controllers\ExamAttendanceController;

//THESE ARE PUBLIC ROUTES ACCESIBLE VIA URL
// Log in Routes
Route::redirect('/', '/login');
Route::view('/login', 'login.index')->middleware('guest')->name('login');

Route::post('/signup', [SignupFormsController::class, 'store'])->name('loginForms.store');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Forgot Password Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

// SignUp OTP Routes
Route::post('/signup/request-otp', [SignupFormsController::class, 'requestOtp'])->name('signup.requestOtp');
Route::get('/signup/verify', [SignupFormsController::class, 'showOtpForm'])->middleware('guest')->name('signup.showOtpForm');
Route::post('/signup/verify', [SignupFormsController::class, 'verifyOtpAndCreate'])->name('signup.verifyOtp');
Route::post('/signup/resend-otp', [SignupFormsController::class, 'resendOtp'])->name('signup.resendOtp');

//EROR 404 GET ROUTES FOR URL POST ATTEMPTS (Para kapag inenter nila sa url imbes na laravel error, error 404 pwede icustomize kung gusto niyo)
Route::get('/signup', function () {
    abort(code: 404);
});

Route::get('/signup/resend-otp', function () {
    abort(code: 404);
});

Route::get('/logout', function () {
    abort(code: 404);
});

Route::get('/signup/request-otp', function () {
    abort(code: 404);
});

//-------------------------------------------------------------------------------------------------------//

//THIS IS FOR THE IMPORTANT ROUTES, THOSE THAT ARE NOT PUBLIC PUT IT IN THESE MIDDLEWARE BLOCKS (NOT ACCESBILE VIA URL)

//APPLICANT ROUTES
//Fillupforms middleware (parent middleware)
Route::middleware(['auth', 'role:applicant'])->group(function () {

    // Submitting of Forms (Step 1)
    Route::get('/step-1', [FillupFormsController::class, 'createStep3'])->name('applicantdashboard');
    Route::post('/step-1', [FillupFormsController::class, 'postStep3']);


    //if form has submitted they can go to payment so they cant skip step 1 (middleware nest)
    Route::middleware(['form.submitted'])->group(function () {

        //payment page
        Route::get('/applicant/steps/payment/payment', [
            PaymentController::class,
            'showPaymentForm'
        ])->name('applicant.steps.payment.payment');

        //payment verification page - side bar
        Route::get('/payment-verification', function () {
            return view('applicant.steps.payment.payment-verification');
        })->name('payment.verification');

        //storing into payment
        Route::post('/payment/store', [PaymentController::class, 'store'])->name('payment.store');

        //payment verification
        Route::get('/payment-verification', [ViewPaymentController::class, 'index'])->name('payment.verification');

        // Route for proceeding to exam date form (when Approved)

        Route::get('/applicant/steps/exam_date/exam-date', [ExamScheduleController::class, 'showExamDates'])->name('exam-date');


        Route::get('/applicant/steps/reminders/reminders', function () {
            $schedule = ApplicantSchedule::where('user_id', auth()->id())->latest()->first();
            return view('applicant.steps.reminders.reminders', compact('schedule'));
        })->name('reminders.view');

        Route::post('/save-exam-schedule', [ApplicantScheduleController::class, 'store'])->name('applicant.saveExamSchedule');

    });
});


//-------------------------------------------------------------------------------------------------------//
//ADMIN ROUTES
Route::middleware(['auth', 'role:administrator'])->group(function () {
    Route::get('/administrator/dashboard', [AdminAccountController::class, 'index'])->name('admindashboard');

    Route::get('/administrator/create-accounts', function () {
        return view('administrator.create-accounts');
    })->name('admin.createaccounts');

    Route::post('/administrator/create-account', [App\Http\Controllers\AdminController::class, 'createAccount'])->name('admin.createAccount');

    Route::get('/administrator/account/{id}/edit', [AdminAccountController::class, 'edit'])->name('admin.editAccount');
    Route::put('/administrator/account/{id}', [AdminAccountController::class, 'update'])->name('admin.updateAccount');
    Route::delete('/administrator/account/{id}', [App\Http\Controllers\AdminAccountController::class, 'destroy'])->name('admin.deleteAccount');
});


//ADMISSION ROUTES
Route::middleware(['auth', 'role:admission'])->group(function () {
    //Route::get('/applicant/steps/exam_date/exam-date', [ExamScheduleController::class, 'showExamDates'])->name('exam.dates');
    Route::get('/admissiondashboard', function () {
        return view('admission.admission-home');
    })->name('admissiondashboard');

    Route::get('/exam-schedule', function () {
        return view('admission.exam-schedule');
    })->name('examschedule');

    Route::get('/add-exam-date', [ExamDateController::class, 'create'])->name('examdate.create');
    Route::post('/store-exam-date', [ExamDateController::class, 'store'])->name('examdate.store');
    Route::get('/exam-schedule', [AdmissionDateController::class, 'index'])->name('examschedule');

    Route::delete('/examdate/{id}', [ExamScheduleController::class, 'destroy'])->name('examdate.destroy');

    Route::post('/examdate/delete-date', [ExamScheduleController::class, 'deleteDate'])->name('examdate.deleteDate');

    // Show all applicants on that day
    Route::get('/admission/exam-attendance', [ExamAttendanceController::class, 'show'])->name('exam.attendance');

    // Mark attendance (Done / No Show) for an applicant
    Route::post('/admission/exam-attendance/mark', [ExamAttendanceController::class, 'markAttendance'])->name('exam.attendance.mark');
});

//ACCOUNTING ROUTES
Route::middleware(['auth', 'role:accounting'])->group(function () {
    Route::get('/accounting/dashboard', [AccountingPaymentController::class, 'index'])->name('accountingdashboard');

    Route::get('/accountant/payments', [AccountingPaymentController::class, 'index'])->name('accountant.payments');
    Route::post('/accountant/payments/approve/{id}', [AccountingPaymentController::class, 'approve'])->name('accountant.payments.approve');
    Route::post('/accountant/payments/deny/{id}', [AccountingPaymentController::class, 'deny'])->name('accountant.payments.deny');
});

//Sidebar
Route::view('/sidebar', 'partials.sidebar')->name('sidebar');
