<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamSchedule;

class ExamDateController extends Controller
{
    public function create()
{
    return view('admission.add-exam-date');
}

public function store(Request $request) // << Add this function
    {
        // Validate the incoming form data
        $request->validate([
            'exam_date' => 'required|date',
            'start_time' => 'required|array',
            'end_time' => 'required|array',
            'venue' => 'required|array', // for venue
            'max_participants' => 'required|array',
            'educational_level' => 'required|array',
        ]);

        $examDate = $request->exam_date;

        // Save each timeframe
        for ($i = 0; $i < count($request->start_time); $i++) {
            ExamSchedule::create([
                'exam_date' => $examDate,
                'start_time' => $request->start_time[$i],
                'end_time' => $request->end_time[$i],
                'venue' => $request->venue[$i], // for venue
                'max_participants' => $request->max_participants[$i],
                'educational_level' => $request->educational_level[$i],
            ]);
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Exam schedule(s) added successfully!');
    }
}
