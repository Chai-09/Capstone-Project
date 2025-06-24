<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamSchedule;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ExamDateController extends Controller
{
    public function create()
{
    return view('admission.add-exam-date');
}

public function store(Request $request)
{
    $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'venue' => 'required|string',
        'max_participants' => 'required|integer|min:1',
        'educational_level' => 'required|string',
        'time_slots' => 'required|array|min:1',
        'time_slots.*' => 'regex:/^\d{2}:\d{2}-\d{2}:\d{2}$/',
    ]);

    $startDate = Carbon::parse($request->start_date);
    $endDate = Carbon::parse($request->end_date);
    $dateRange = CarbonPeriod::create($startDate, $endDate);

    foreach ($dateRange as $date) {
        foreach ($request->time_slots as $slot) {
            [$startTime, $endTime] = explode('-', $slot);

            ExamSchedule::create([
                'exam_date' => $date->format('Y-m-d'),
                'start_time' => $startTime . ':00',
                'end_time' => $endTime . ':00',
                'venue' => $request->venue,
                'max_participants' => $request->max_participants,
                'educational_level' => $request->educational_level,
            ]);
        }
    }

    return redirect()->back()->with('success', 'Exam schedule(s) added successfully!');
}


}
