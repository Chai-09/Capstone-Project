<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FillupForms;

class EnsureFormSubmissionCompleted
{
    public function handle(Request $request, Closure $next)
    {
        $applicant = Auth::user();

        if ($applicant) {
            // Check if nakasubmit na si user ng form
            $hasFormSubmission = FillupForms::where('applicant_email', $applicant->email)->exists();

            if (!$hasFormSubmission) {
                return redirect()->route('applicantdashboard')->with('error', 'You must complete the application form first.');
            }
        }

        return $next($request);
    }
}
