<?php

namespace App\Http\Controllers\API\MobileSchedule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamSchedule;
use App\Models\Applicant;
use App\Models\FillupForms;
use App\Models\ApplicantSchedule;
use Carbon\Carbon;

class MobileScheduleController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $applicant = Applicant::where('account_id', $user->id)->first();
        if (!$applicant) {
            return response()->json(['error' => 'Applicant not found.'], 404);
        }

        $form = FillupForms::where('applicant_id', $applicant->id)->first();
        if (!$form) {
            return response()->json(['error' => 'Applicant form not found.'], 404);
        }

        $grade = ucwords(strtolower(trim($form->incoming_grlvl)));
        $gs_jhs = ['Kinder', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10'];
        $shs = ['Grade 11', 'Grade 12'];

        if (in_array($grade, $gs_jhs)) {
            $level = 'GRADE SCHOOL AND JUNIOR HIGH SCHOOL';
        } elseif (in_array($grade, $shs)) {
            $level = 'SENIOR HIGH SCHOOL';
        } else {
            return response()->json(['error' => 'Unrecognized grade level.'], 400);
        }

        $schedules = ExamSchedule::whereRaw('UPPER(educational_level) = ?', [strtoupper($level)])
            ->whereDate('exam_date', '>=', Carbon::today())
            ->orderBy('exam_date')
            ->get()
            ->map(function ($schedule) {
                $booked = ApplicantSchedule::where('exam_date', $schedule->exam_date)
                    ->where('start_time', $schedule->start_time)
                    ->where('end_time', $schedule->end_time)
                    ->count();

                return [
                    'id' => $schedule->id,
                    'exam_date' => $schedule->exam_date,
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'remaining' => max(0, $schedule->max_participants - $booked),
                ];
            });

        return response()->json([
            'educational_level' => $level,
            'schedules' => $schedules,
        ]);
    }

    public function book(Request $request)
{
    $user = $request->user();
    $applicant = Applicant::where('account_id', $user->id)->first();
    if (!$applicant) {
        return response()->json(['success' => false, 'message' => 'Applicant not found.']);
    }

    if ($applicant->current_step > 4) {
        return response()->json(['success' => false, 'message' => 'You have already selected a schedule.']);
    }

    $form = FillupForms::where('applicant_id', $applicant->id)->first();
    if (!$form) {
        return response()->json(['success' => false, 'message' => 'Form info not found.']);
    }

    $request->validate([
        'exam_date' => 'required|date',
        'start_time' => 'required',
        'end_time' => 'required',
    ]);

    // Check if schedule has available slots
    $examCount = \App\Models\ApplicantSchedule::where('exam_date', $request->exam_date)
        ->where('start_time', $request->start_time)
        ->where('end_time', $request->end_time)
        ->count();

    $max = \App\Models\ExamSchedule::where('exam_date', $request->exam_date)
        ->where('start_time', $request->start_time)
        ->where('end_time', $request->end_time)
        ->first();

    if (!$max || $examCount >= $max->max_participants) {
        return response()->json(['success' => false, 'message' => 'This slot is already full.']);
    }

    // Clear previous schedule
    \App\Models\ApplicantSchedule::where('applicant_id', $applicant->id)->delete();

    // Generate admission number
    $year = now()->year;
    $last = \App\Models\ApplicantSchedule::whereYear('created_at', $year)
        ->orderByDesc('admission_number')
        ->first();
    $nextNumber = $last ? ((int) substr($last->admission_number, 5)) + 1 : 1;
    $admissionNumber = $year . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

    // Save schedule
    \App\Models\ApplicantSchedule::create([
        'applicant_id' => $applicant->id,
        'admission_number' => $admissionNumber,
        'applicant_name' => strtoupper($form->applicant_fname . ' ' . $form->applicant_mname . ' ' . $form->applicant_lname),
        'applicant_contact_number' => $form->applicant_contact_number,
        'incoming_grade_level' => $form->incoming_grlvl,
        'exam_date' => $request->exam_date,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'venue' => 'MPR Annex',
    ]);

    // Reset exam result
    \App\Models\ExamResult::updateOrCreate(
        ['applicant_id' => $applicant->id],
        [
            'applicant_name' => strtoupper($form->applicant_fname . ' ' . $form->applicant_mname . ' ' . $form->applicant_lname),
            'incoming_grade_level' => $form->incoming_grlvl,
            'exam_date' => $request->exam_date,
            'exam_status' => null,
            'exam_result' => null,
            'admission_number' => $admissionNumber,
        ]
    );

    // Update step
    if ($applicant->current_step == 4) {
        $applicant->update(['current_step' => 5]);
    }

    // Send email to guardian
    $guardianEmail = $form->guardian_email;
    if ($guardianEmail) {
        $formattedDate = \Carbon\Carbon::parse($request->exam_date)->format('F d, Y');
        $formattedTime = \Carbon\Carbon::parse($request->start_time)->format('h:i A') . ' to ' . \Carbon\Carbon::parse($request->end_time)->format('h:i A');

        \Mail::send('emails.exam-schedule-confirmation', [
            'applicant' => $applicant,
            'admissionNumber' => $admissionNumber,
            'date' => $formattedDate,
            'time' => $formattedTime,
        ], function ($message) use ($guardianEmail) {
            $message->to($guardianEmail)
                ->subject('Your Exam Schedule Has Been Confirmed');
        });
    }

    return response()->json(['success' => true, 'message' => 'Schedule booked successfully.']);
}

}
