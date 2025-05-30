<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplicantSchedule;
use Carbon\Carbon;

class ExamAttendanceController extends Controller
{
    /**
     * Show applicants scheduled on the selected date and optional time.
     */
    public function show(Request $request)
{
    $date = $request->query('date');
    $start = $request->query('start');
    $end = $request->query('end');

    if (!$date) {
        abort(404, 'Date parameter is required.');
    }

    $query = ApplicantSchedule::with(['applicant.formSubmission'])
        ->whereDate('exam_date', $date);

    if ($start && $end) {
        $query->whereTime('start_time', $start)
              ->whereTime('end_time', $end);
    }

    $applicants = $query->orderBy('start_time')->get();

    $timeFrame = ($start && $end)
        ? Carbon::parse($start)->format('g:i A') . ' – ' . Carbon::parse($end)->format('g:i A')
        : '';

    // Extract all unique educational levels from applicants
    $educLevels = $applicants->map(function ($app) {
        return optional(optional($app->applicant)->formSubmission)->educational_level;
    })->filter()->unique()->values();

    $educationalLevelText = $educLevels->isNotEmpty()
        ? $educLevels->implode(', ')
        : '';

    return view('admission.exam.exam-attendance', [
        'date' => $date,
        'applicants' => $applicants,
        'timeFrame' => $timeFrame,
        'educationalLevel' => $educationalLevelText,
    ]);
}


}
