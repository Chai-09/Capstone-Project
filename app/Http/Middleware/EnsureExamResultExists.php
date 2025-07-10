<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Applicant;
use App\Models\ExamResult;

class EnsureExamResultExists
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $applicant = Applicant::where('account_id', $user->id)->first();

        if (!$applicant) {
            abort(404);
        }

        $examResult = ExamResult::where('applicant_id', $applicant->id)->first();

        if (
            !$examResult ||
            empty($examResult->exam_status) ||
            empty($examResult->exam_result)
        ) {
            return redirect()->route('reminders.view')
                ->with('alert_type', 'error')
                ->with('alert_message', 'You cannot view your exam result yet.');
        }

        //  increment step if exactly at step 5
        if ($applicant->current_step == 5) {
            $applicant->update(['current_step' => 6]);
        }

        return $next($request);
    }
}
