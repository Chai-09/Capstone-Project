<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FillupForms;
use App\Models\ExamSchedule;
use App\Models\ApplicantSchedule;
use Illuminate\Support\Facades\Auth;

class ExamScheduleController extends Controller
{
    public function showExamDates(Request $request)
{
    $query = ExamSchedule::query();

    if ($request->filled('exam_date')) {
        $query->where('exam_date', $request->exam_date);
    }

    if ($request->filled('educational_level')) {
        if ($request->educational_level === 'gs_jhs') {
            $query->whereIn('educational_level', ['Grade School', 'Junior High School']);
        } else {
            $query->where('educational_level', $request->educational_level);
        }
    }

    $examSchedules = $query->orderBy('exam_date')->paginate(10);

    // 🔥 ADD calculation here properly
    foreach ($examSchedules as $examSchedule) {
        $currentApplicants = \App\Models\ApplicantSchedule::where('exam_date', $examSchedule->exam_date)
            ->where('start_time', $examSchedule->start_time)
            ->where('end_time', $examSchedule->end_time)
            ->count();

        $examSchedule->remaining_slots = $examSchedule->max_participants - $currentApplicants;
    }

    return view('admission.exam-schedule', compact('examSchedules'));
}

public function showExamDatesForApplicants(Request $request)
{
    $query = ExamSchedule::query();

    if ($request->filled('exam_date')) {
        $query->where('exam_date', $request->exam_date);
    }

    if ($request->filled('educational_level')) {
        if ($request->educational_level === 'gs_jhs') {
            $query->whereIn('educational_level', ['Grade School', 'Junior High School']);
        } else {
            $query->where('educational_level', $request->educational_level);
        }
    }

    $examSchedules = $query->orderBy('exam_date')->paginate(10);

    foreach ($examSchedules as $examSchedule) {
        $currentApplicants = ApplicantSchedule::where('exam_date', $examSchedule->exam_date)
            ->where('start_time', $examSchedule->start_time)
            ->where('end_time', $examSchedule->end_time)
            ->count();

        $examSchedule->remaining_slots = $examSchedule->max_participants - $currentApplicants;
    }

    return view('applicant.steps.exam_date.exam-date', compact('examSchedules'));
}




    public function destroy($id)
{
    $schedule = ExamSchedule::findOrFail($id);
    $schedule->delete();

    return redirect()->back()->with('success', 'Exam schedule deleted successfully.');
}

public function deleteDate(Request $request)
{
    $request->validate([
        'exam_date' => 'required|date',
    ]);

    ExamSchedule::where('exam_date', $request->exam_date)->delete();

    return response()->json(['success' => true]);
}



}
