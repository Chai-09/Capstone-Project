<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamSchedule;

class AdmissionDateController extends Controller
{
    public function index(Request $request)
{
    $query = ExamSchedule::query();

    if ($request->filled('exam_date')) {
        $query->where('exam_date', $request->exam_date);
    }

    if ($request->filled('educational_level')) {
        $query->where('educational_level', $request->educational_level);
    }

    $examSchedules = $query->orderBy('exam_date')->paginate(5); // << make sure it is paginate(5) here

    return view('admission.exam-schedule', compact('examSchedules'));
}

}
