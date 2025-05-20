<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
           $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'form.submitted' => \App\Http\Middleware\EnsureFormSubmissionCompleted::class,
            'payment.submitted' => \App\Http\Middleware\EnsurePaymentSubmitted::class,
            'payment.verified' => \App\Http\Middleware\EnsurePaymentApprovedForExam::class,
            'exam.schedule.selected' => \App\Http\Middleware\ExamScheduleSelected::class,
            'exam.result.exists' => \App\Http\Middleware\EnsureExamResultExists::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
