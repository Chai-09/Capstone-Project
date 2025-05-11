<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamResult;
use App\Models\Applicant;
use App\Models\ApplicantSchedule;
use Illuminate\Support\Facades\Auth;
use App\Models\FillupForms;

class ExamResultController extends Controller
{
    public function index()
    {
        $results = ExamResult::orderBy('exam_date', 'desc')->get();
        return view('admission.exam.exam-results', compact('results'));
    }

    public function markAttendance(Request $request)
    {
        $schedule = ApplicantSchedule::findOrFail($request->schedule_id);
        $applicant = Applicant::where('id', $schedule->applicant_id)->first();

        if (!$applicant) {
            return back()->with('alert_type', 'error')->with('alert_message', 'Applicant not found.');
        }

        $status = $request->status;
        $examResultValue = ($status === 'no_show') ? 'no_show' : 'pending';

        // Always update both status and result
        $existing = ExamResult::where('applicant_id', $applicant->id)->first();
        $admissionNumber = $schedule->admission_number;
        if ($existing) {
            $existing->applicant_name = $applicant->applicant_fname . ' ' . $applicant->applicant_lname;
            $existing->incoming_grade_level = $applicant->incoming_grlvl;
            $existing->exam_date = $schedule->exam_date;
            $existing->exam_status = $status;
            $existing->admission_number = $admissionNumber;

            // only overwrite result if status is no_show
            if ($status === 'no_show') {
                $existing->exam_result = 'no_show';
            }

            $existing->save();
        } else {
            ExamResult::create([
                'applicant_id' => $applicant->id,
                'applicant_name' => $applicant->applicant_fname . ' ' . $applicant->applicant_lname,
                'incoming_grade_level' => $applicant->incoming_grlvl,
                'exam_date' => $schedule->exam_date,
                'exam_status' => $status,
                'exam_result' => $examResultValue,
                'admission_number' => $admissionNumber,
            ]);
        }

        return back()->with('alert_type', 'success')->with('alert_message', 'Applicant marked as ' . strtoupper($status));
    }

    public function update(Request $request)
    {
        $request->validate([
            'applicant_id' => 'required|exists:exam_results,applicant_id',
            'exam_result' => 'required|string|in:pending,passed,failed,scholarship,interview'
        ]);

        $result = ExamResult::where('applicant_id', $request->applicant_id)->first();

        if ($result && $result->exam_status !== 'no_show') {
            // only allow manual update if not marked as no_show
            $result->exam_result = $request->exam_result;
            $result->save();
        }

        return redirect()->back()->with('success', 'Exam result updated successfully.');
    }

    public function showForApplicant()
    {
        $user = Auth::user();
        $applicant = Applicant::where('account_id', $user->id)->first();

        if (!$applicant) {
            return view('applicant.exam-result.exam-result')->with('examResult', null);
        }

        $examResult = ExamResult::where('applicant_id', $applicant->id)->first();

        // Enforce data integrity if record was corrupted or edited
        if ($examResult && $examResult->exam_status === 'no_show' && $examResult->exam_result !== 'no_show') {
            $examResult->exam_result = 'no_show';
            $examResult->save();
        }

        return view('applicant.exam-result.exam-result', compact('examResult'))->with('currentStep', $applicant->current_step);
    }
}
