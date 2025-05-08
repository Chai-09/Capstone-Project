<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamResult;
use App\Models\Applicant;//
use App\Models\ApplicantSchedule;


class ExamResultController extends Controller
{
    public function index()
    {
        // Fetch all exam results, ordered by most recent exam date
        $results = ExamResult::orderBy('exam_date', 'desc')->get();

        // Pass to the Blade view
        return view('admission.exam.exam-results', compact('results'));
    }
    public function markAttendance(Request $request)
{
    $schedule = \App\Models\ApplicantSchedule::findOrFail($request->schedule_id);
    $applicant = \App\Models\Applicant::where('id', $schedule->applicant_id)->first(); // Corrected

    if (!$applicant) {
        return back()->with('alert_type', 'error')->with('alert_message', 'Applicant not found.');
    }

    \App\Models\ExamResult::updateOrCreate(
        ['applicant_id' => $applicant->id],
        [
            'applicant_name' => $applicant->applicant_fname . ' ' . $applicant->applicant_lname,
            'incoming_grade_level' => $applicant->incoming_grlvl,
            'exam_date' => $schedule->exam_date,
            'exam_status' => $request->status,
            'exam_result' => 'pending',
        ]
    );

    return back()->with('alert_type', 'success')->with('alert_message', 'Applicant marked as ' . strtoupper($request->status));
}

public function update(Request $request)
{
    $request->validate([
        'applicant_id' => 'required|exists:exam_results,applicant_id',
        'exam_result' => 'required|string|in:pending,passed,failed,scholarship,interview'
    ]);

    $result = \App\Models\ExamResult::where('applicant_id', $request->applicant_id)->first();

    if ($result) {
        $result->exam_result = $request->exam_result;
        $result->save();
    }

    return redirect()->back()->with('success', 'Exam result updated successfully.');
}





    
}
