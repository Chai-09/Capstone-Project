<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplicantSchedule; // Your table where applicants schedules are stored
use Carbon\Carbon;

class ExamAttendanceController extends Controller
{
    public function show(Request $request)
    {
        $date = $request->query('date');

        if (!$date) {
            abort(404); // No date provided
        }

        $applicants = ApplicantSchedule::whereDate('exam_date', $date)->get();


        return view('admission.exam-attendance', compact('applicants', 'date'));
    }

    public function markAttendance(Request $request)
    {
        $applicant = ApplicantSchedule::findOrFail($request->id);

        $applicant->status = $request->status; // "done" or "no_show"
        $applicant->save();

        return back()->with('success', 'Attendance updated successfully.');
    }
}
