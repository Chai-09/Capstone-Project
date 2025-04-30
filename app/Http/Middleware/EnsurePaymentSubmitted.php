<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Applicant;

class EnsurePaymentSubmitted
{
    public function handle(Request $request, Closure $next)
    {
        $account = Auth::user();

        if ($account) {
            $applicant = Applicant::where('account_id', $account->id)->first();

            if (!$applicant || $applicant->current_step < 3) {
                return redirect()->route('applicant.steps.payment.payment')
                    ->with('error', 'Please submit your payment to access this page.');
            }
        }

        return $next($request);
    }
}
