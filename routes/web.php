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
use App\Http\Controllers\AdmissionsAppListController;
use App\Http\Controllers\ExamResultController;
use App\Http\Controllers\EditApplicantController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\AdmissionChartController;

//THESE ARE PUBLIC ROUTES ACCESIBLE VIA URL
// Log in Routes
Route::redirect('/', '/login');
Route::get('/login', [AuthController::class, 'showLoginPage'])->middleware('guest')->name('login');

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

//-----------------------------------------------------------------------------------------------------------------------------//

//THIS IS FOR THE IMPORTANT ROUTES, THOSE THAT ARE NOT PUBLIC PUT IT IN THESE MIDDLEWARE BLOCKS (NOT ACCESIBILE VIA URL)

//APPLICANT ROUTES

//Fillupforms middleware (parent middleware)
Route::middleware(['auth', 'role:applicant'])->group(function () {

    // Submitting of Forms (Step 1 default)
    Route::get('/step-1', [FillupFormsController::class, 'createStep3'])->name('applicantdashboard');
    Route::post('/step-1', [FillupFormsController::class, 'postStep3']);
    Route::get('/strand-recommender', [FillupFormsController::class, 'showRecommender'])->name('strand.recommender');
    Route::post('/strand-recommender', [FillupFormsController::class, 'submitRecommender'])->name('strand.recommender.submit');


    //-----------------------------------------------------------------------------------------------------------------------------//

    //if form has submitted they can go to payment so they cant skip to step 2 (middleware nest 1)
    Route::middleware(['form.submitted'])->group(function () {

        //payment page
        Route::get('/step-2', [
            PaymentController::class,
            'showPaymentForm'
        ])->name('applicant.steps.payment.payment');

        //storing into payment
        Route::post('/payment/store', [PaymentController::class, 'store'])->name('payment.store');

        Route::delete('/payment/delete/{id}', [ViewPaymentController::class, 'delete'])->name('payment.delete');

        //-----------------------------------------------------------------------------------------------------------------------------//

        //if payment has submitted they can go to payment verification so they cant skip to step 3 (middleware nest 2)
        Route::middleware(['payment.submitted'])->group(function () {

            //payment verification
            Route::get('/step-3', [ViewPaymentController::class, 'index'])->name('payment.verification');

            //Proceed Button route, for incrementing current_step and routing to step 4
            Route::post('/proceed-to-exam', [ViewPaymentController::class, 'proceedToExam'])->name('proceed.to.exam');


            //-----------------------------------------------------------------------------------------------------------------------------//

            //if payment has submitted they can go to payment verification so they cant skip step to step 4 (middleware nest 3)
            Route::middleware(['payment.verified'])->group(function () {

                // Route for proceeding to exam date form (when Approved)
                Route::get('/step-4', [ExamScheduleController::class, 'showExamDatesForApplicants'])->name('applicant.examdates');
                Route::post('/save-exam-schedule', [ApplicantScheduleController::class, 'store'])->name('applicant.saveExamSchedule');

                //-----------------------------------------------------------------------------------------------------------------------------//    

                //if schedule has been selected they can go to step 5 (middleware nest 4)
                Route::middleware(['exam.schedule.selected'])->group(function () {

                    Route::get('/step-5', [ApplicantScheduleController::class, 'showReminders'])->name('reminders.view');
                });

                //-----------------------------------------------------------------------------------------------------------------------------//  
                //if exam result exists in database been selected they can go to step 6 (middleware nest 5 FINAL)
                Route::middleware(['exam.result.exists'])->group(function () {

                    Route::get('/step-6', [ExamResultController::class, 'showForApplicant'])->name('applicant.exam.result'); //nilagay ko siya sa may form.submitted pero di ko sure kung san to
                    
                    //If No Show, Resched Automatic then current_step = 2
                    Route::post('/trigger-resched', [PaymentController::class, 'triggerResched'])->name('payment.resched.trigger');

                });
            });
        });
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
Route::middleware(['auth', 'role:admission,administrator'])->group(function () {
    //Route::get('/applicant/steps/exam_date/exam-date', [ExamScheduleController::class, 'showExamDates'])->name('exam.dates');
    Route::get('/admission/dashboard', [App\Http\Controllers\AdmissionChartController::class, 'showAdmissionDashboard'])->name('admissiondashboard'); //tanggalin ko to

    Route::get('/add-exam-date', [ExamDateController::class, 'create'])->name('examdate.create');
    Route::post('/store-exam-date', [ExamDateController::class, 'store'])->name('examdate.store');
    Route::get('/exam-schedule', [AdmissionDateController::class, 'index'])->name('examschedule');


    /*Route::get('/admission-home ', function () {
        return view('admission.admission-home'); //use for aero home
    })->name('admissionhome');*/

    Route::get('/admission/applicants-list', [AdmissionsAppListController::class, 'index'])->name('applicantlist');
    Route::delete('/admission/applicants-list/{id}', [AdmissionsAppListController::class, 'destroy'])->name('admission.applicants.destroy');

    //displays exam schedule
    Route::get('/admission/exam/exam-schedule', [ExamScheduleController::class, 'index'])
        ->name('admission.exam.schedule');

    Route::delete('/admission/exam/exam-schedule/{id}', [ExamScheduleController::class, 'destroy'])
        ->name('exam-schedule.destroy'); //delete schedule 

    Route::post('/admission/exam/exam-schedule/delete-date', [ExamScheduleController::class, 'deleteDate'])
        ->name('exam-schedule.deleteDate'); //delete exam date

    Route::get('/admission/exam/exam-schedule/applicants', [ExamScheduleController::class, 'fetchApplicants'])
        ->name('exam-schedule.fetchApplicants'); //fetch applicants per grade level

    Route::get('/admission/exam/exam-schedule/applicants/by-date', [ExamScheduleController::class, 'fetchByDate']);

    Route::get('/admission/exam/exam-schedule/applicants/by-time', [ExamScheduleController::class, 'fetchByTimeSlot']);

    Route::get('/admission/exam/exam-attendance', [ExamAttendanceController::class, 'show'])->name('exam.attendance');

    Route::post('/admission/exam-results/mark', [ExamResultController::class, 'markAttendance'])->name('exam-results.mark');


    Route::post('/exam/mark-attendance', [App\Http\Controllers\ExamResultController::class, 'markAttendance'])->name('exam.markAttendance');

    Route::get('/admission/exam/exam-result', [ExamResultController::class, 'index'])->name('admission.exam.exam-results');
    Route::post('/exam-results/update', [ExamResultController::class, 'update'])->name('exam.results.update');
    Route::get('/admission/exam/exam-result', [ExamResultController::class, 'index'])->name('admission.exam.result');

    Route::get('/admission/edit-applicant/{id}', [EditApplicantController::class, 'show'])->name('admission.editApplicant');
    Route::put('/applicants/{id}', [EditApplicantController::class, 'update'])->name('applicant.update');
Route::delete('/applicants/{id}', [EditApplicantController::class, 'destroy'])->name('applicant.delete');

Route::get('/export/forms', [ExportController::class, 'exportForms'])->name('export.forms');
    //Route::get('/admission/edit-applicant/{id}', [EditApplicantController::class, 'show'])->name('admission.editApplicant');

Route::get('/admission/reports/admission-reports', [AdmissionChartController::class, 'index'])->name('admission.reports');

//forfiltering:
    Route::get('/chart-data', [AdmissionChartController::class, 'getChartData'])->name('chart.data');

    /*Route::get('/admission/dashboard', [App\Http\Controllers\AdmissionChartController::class, 'showAdmissionDashboard'])
    ->name('admission.dashboard');*/
    Route::post('/applicant/save-exam-schedule', [EditApplicantController::class, 'saveExamSchedule'])->name('applicant.saveExamSchedule');
    Route::get('/get-time-slots', [EditApplicantController::class, 'getTimeSlots'])->name('get.time.slots');
});

//ACCOUNTING ROUTES
Route::middleware(['auth', 'role:accounting,administrator'])->group(function () {
    Route::get('/accounting/dashboard', [AccountingPaymentController::class, 'index'])->name('accountingdashboard');

    Route::get('/accountant/payments', [AccountingPaymentController::class, 'index'])->name('accountant.payments');
    Route::post('/accountant/payments/approve/{id}', [AccountingPaymentController::class, 'approve'])->name('accountant.payments.approve');
    Route::post('/accountant/payments/deny/{id}', [AccountingPaymentController::class, 'deny'])->name('accountant.payments.deny');

    Route::put('/accountant/payments/{id}', [PaymentController::class, 'updateRemarks'])->name('accountant.payments.update');

    //for uploading of receipt 
    Route::post('/upload-receipt', [AccountingPaymentController::class, 'uploadReceipt'])->name('upload.receipt');

    //for uploading everything as well as to email
    Route::put('/accountant/payment-decision/{id}', [AccountingPaymentController::class, 'update'])->name('accountant.payment.decision');

    Route::post('/delete-receipt', [AccountingPaymentController::class, 'deleteReceipt'])->name('delete.receipt');

    //cards
    // Route::get('/accounting-dashboard', [AccountReportController::class, 'showAccountingDashboard'])->name('accountingdashboard');


});

//Sidebar
Route::view('/sidebar', 'partials.sidebar')->name('sidebar');

//Accountant Dashboard
Route::view('/accountant-dashboard', 'accounting.index')->name('accounting');
