<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Applicant;

class EnsurePaymentApprovedForExam
{
    public function handle(Request $request, Closure $next)
    {
        $applicant = Applicant::where('account_id', Auth::id())->first();

        if (!$applicant || $applicant->current_step < 4) {
            return redirect()->route('payment.verification')->with('error', 'You must wait for your payment to be approved before proceeding to the exam schedule.');
        }

        return $next($request);
    }
}
