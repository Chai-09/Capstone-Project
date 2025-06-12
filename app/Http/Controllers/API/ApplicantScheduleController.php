<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\ApplicantSchedule;
use Illuminate\Support\Facades\Auth;

class ApplicantScheduleController extends Controller
{
    public function getSchedule(Request $request)
    {
        $user = $request->user(); // get logged-in mobile user
        $applicant = Applicant::where('account_id', $user->id)->first();

        if (!$applicant) {
            return response()->json(['message' => 'Applicant not found'], 404);
        }

        $schedule = ApplicantSchedule::where('applicant_id', $applicant->id)->latest()->first();

        if (!$schedule) {
            return response()->json(['message' => 'Schedule not found'], 404);
        }

        return response()->json([
            'admission_number' => $schedule->admission_number,
            'applicant_name' => $schedule->applicant_name,
            'exam_date' => $schedule->exam_date,
            'start_time' => $schedule->start_time,
            'end_time' => $schedule->end_time,
            'venue' => $schedule->venue,
        ]);
    }
}
