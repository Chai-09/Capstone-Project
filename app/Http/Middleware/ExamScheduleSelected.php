<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\ApplicantSchedule;
use Illuminate\Support\Facades\Auth;

class ExamScheduleSelected
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $applicant = Applicant::where('account_id', $user->id)->first();

        if (!$applicant) {
            abort(404, 'Applicant not found');
        }

        $hasSchedule = ApplicantSchedule::where('applicant_id', $applicant->id)->exists();

        if (!$hasSchedule) {
            return redirect()->route('applicant.examdates')
                ->with('alert_type', 'error')
                ->with('alert_message', 'Please select an exam schedule first.');
        }

        return $next($request);
    }
}
