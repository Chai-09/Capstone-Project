<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamResult;
use App\Models\Applicant;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class ExamResultController extends Controller
{
    public function index()
    {
        $results = ExamResult::where('exam_status', 'done')->get();
        return view('admission.exam.exam-results', compact('results'));
    }

    public function markAttendance(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:applicants,id',
            'status' => 'required|in:done,no_show',
        ]);

        $applicant = \App\Models\Applicant::findOrFail($request->id);

        ExamResult::updateOrCreate(
            ['applicant_id' => $applicant->id],
            [
                'applicant_name' => $applicant->applicant_fname . ' ' . $applicant->applicant_lname,
                'incoming_grade_level' => $applicant->incoming_grlvl,
                'exam_date' => now()->toDateString(),
                'exam_status' => $request->status,
            ]
        );

        return redirect()->back()->with('success', 'Attendance marked successfully!');
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'exam_result' => ['required', Rule::in(['pending', 'passed', 'failed', 'scholarship', 'interview'])],
    ]);

    $examResult = ExamResult::findOrFail($id);
    $examResult->exam_result = $request->exam_result;
    $examResult->save();

    return redirect()->back()->with([
        'success' => 'Exam result updated successfully!',
        'updated_result' => [
            'name' => $examResult->applicant_name,
            'date' => \Carbon\Carbon::parse($examResult->exam_date)->format('F d, Y'),
            'result' => ucfirst($examResult->exam_result)
        ]
    ]);
}

public function showForApplicant()
{
    $accountId = auth()->user()->id;

    $applicant = Applicant::where('account_id', $accountId)->first();

    if (!$applicant) {
        return back()->withErrors(['applicant' => 'Applicant not found.']);
    }

    $examResult = ExamResult::where('applicant_id', $applicant->id)->first();

    return view('applicant.exam-result.exam-result', compact('examResult'));
}


    
}
