<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FillupForms;
use App\Models\Applicant;

class EnsureFormSubmissionCompleted
{
    public function handle(Request $request, Closure $next)
    {
        $account = Auth::user();
        
        if ($account) {
            // Check if nakasubmit na si user ng form
            $applicant = Applicant::where('account_id', $account->id)->first();
            

            if (!$applicant || !FillupForms::where('applicant_id', $applicant->id)->exists()) {
                return redirect()->route('applicantdashboard')->with('error', 'You must complete the application form first.');
            }
        }

        return $next($request);
    }
}
