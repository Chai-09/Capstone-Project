<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplicantSchedule;
use Carbon\Carbon;

class ExamAttendanceController extends Controller
{
    /**
     * Show applicants scheduled on the selected date.
     */
    public function show(Request $request)
    {
        $date = $request->query('date');

        if (!$date) {
            abort(404, 'Date parameter is required.');
        }

        // Get all applicant schedules for this date, including applicant details
        $applicants = ApplicantSchedule::with('applicant')
            ->whereDate('exam_date', $date)
            ->orderBy('start_time')
            ->get();

        return view('admission.exam.exam-attendance', [
            'date' => $date,
            'applicants' => $applicants
        ]);
    }
}
