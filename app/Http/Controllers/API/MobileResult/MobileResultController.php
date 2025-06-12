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
}
