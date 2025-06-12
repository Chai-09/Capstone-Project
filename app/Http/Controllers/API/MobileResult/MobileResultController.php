<?php

namespace App\Http\Controllers\API\MobileResult;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\ExamResult;


class MobileResultController extends Controller
{
    public function getExamResult(Request $request)
    {
        $user = $request->user();

        $applicant = Applicant::where('account_id', $user->id)->first();

        if (!$applicant) {
            return response()->json(['message' => 'Applicant not found.'], 404);
        }

        $examResult = ExamResult::where('applicant_id', $applicant->id)->first();

        if (!$examResult) {
            return response()->json(['message' => 'No exam result found.'], 404);
        }

        if ($examResult->exam_status === 'no show' && $examResult->exam_result !== 'no_show') {
            $examResult->exam_result = 'no_show';
            $examResult->save();
        }

        return response()->json([
            'exam_status' => $examResult->exam_status,
            'exam_result' => $examResult->exam_result,
            'remarks' => $examResult->remarks,
            'updated_at' => $examResult->updated_at->toDateTimeString(),
        ]);
    }

    public function show(Request $request)
    {
        $user = $request->user();
    
        $applicant = \App\Models\Applicant::where('account_id', $user->id)->first();
        if (!$applicant) {
            return response()->json(['message' => 'Applicant not found.'], 404);
        }
    
        $examResult = \App\Models\ExamResult::where('applicant_id', $applicant->id)->first();
        $schedule = \App\Models\ApplicantSchedule::where('applicant_id', $applicant->id)->first();
    
        if (!$examResult) {
            return response()->json(['message' => 'No exam result found.'], 404);
        }
    
        if ($examResult->exam_status === 'no show' && $examResult->exam_result !== 'no_show') {
            $examResult->exam_result = 'no_show';
            $examResult->save();
        }
    
        return response()->json([
            'admission_number' => $schedule->admission_number,
            'applicant_name' => $schedule->applicant_name,
            'exam_date' => optional($schedule)->exam_date ? date('Y-m-d', strtotime($schedule->exam_date)) : null,
            'start_time' => optional($schedule)->start_time,
            'end_time' => optional($schedule)->end_time,
            'exam_result' => $examResult->exam_result,
        ]);
    }
    

}
