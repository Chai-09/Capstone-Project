<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplicantSchedule;
use App\Models\FillupForms;
use Illuminate\Support\Facades\Auth;
use App\Models\Applicant;
use App\Models\ExamResult;


class ApplicantScheduleController extends Controller
{

    public function showReminders()
    {
        $user = auth()->user();
        $applicant = Applicant::where('account_id', $user->id)->first();
        //Magpapakita lang si button if may exam_result sa table and step == 5
        $hasResult = ExamResult::where('applicant_id', $applicant->id)->exists();
        $showProceedButton = $hasResult && $applicant->current_step == 5;

        if (!$applicant) {
            abort(404);
        }

        $schedule = ApplicantSchedule::where('applicant_id', $applicant->id)->latest()->first();
        $examResult = ExamResult::where('applicant_id', $applicant->id)->first();



        return view('applicant.steps.reminders.reminders', compact('schedule', 'showProceedButton', 'examResult'))->with('currentStep', $applicant->current_step);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $applicant = Applicant::where('account_id', Auth::id())->first();

        if (!$applicant) {
            return response()->json(['success' => false, 'message' => 'Applicant not found.']);
        }

        //Ensures schedule can not be changed

        if ($applicant->current_step > 4) {
            return response()->json(['success' => false, 'message' => 'Schedule already selected. Cannot be changed.']);
        }

        // Delete any previous schedule by this applicant
        ApplicantSchedule::where('applicant_id', $applicant->id)->delete();



        // Find applicant info from form_submissions
        $form = FillupForms::where('applicant_id', $applicant->id)->first();

        if (!$form) {
            return response()->json(['success' => false, 'message' => 'Applicant info not found.']);
        }

        // Generate Admission Number
        $year = now()->year;
        $lastAdmission = ApplicantSchedule::whereYear('created_at', $year)
            ->orderByDesc('admission_number')
            ->first();

        if ($lastAdmission) {
            // Extract the last number (after the dash)
            $lastNumber = (int) substr($lastAdmission->admission_number, 5);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $admissionNumber = $year . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        $examSchedule = \App\Models\ExamSchedule::where('exam_date', $request->exam_date)->first();

        if (!$examSchedule) {
            return response()->json(['success' => false, 'message' => 'Exam schedule not found.']);
        }

        // Save schedule
        $schedule = ApplicantSchedule::create([
            'applicant_id' => $applicant->id,
            'admission_number' => $admissionNumber,
            'applicant_name' => strtoupper($form->applicant_fname . ' ' . $form->applicant_mname . ' ' . $form->applicant_lname),
            'applicant_contact_number' => $form->applicant_contact_number,
            'incoming_grade_level' => $form->incoming_grlvl,
            'exam_date' => $request->exam_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'venue' => $examSchedule ? $examSchedule->venue : 'N/A',
        ]);


        // Reset exam result only if it already exists
ExamResult::updateOrCreate(
    ['applicant_id' => $applicant->id],
    [
        'applicant_name' => strtoupper($form->applicant_fname . ' ' . $form->applicant_mname . ' ' . $form->applicant_lname),
        'incoming_grade_level' => $form->incoming_grlvl,
        'exam_date' => $request->exam_date,
        'exam_status' => null, // ← this clears "done" or "no show"
        'exam_result' => null,
        'admission_number' => $admissionNumber,
    ]
);

        //Update Current step to 5 (gawin mong == na din lahat ng update para no issues)
        if ($applicant->current_step == 4) {
            $applicant->update(['current_step' => 5]);
        }


        //SEND EMAIL TO GUARDIAN
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

    // SMS Notification to guardian about exam schedule
if ($form->guardian_contact_number) {
    $guardianNumber = $form->guardian_contact_number;
    $lname = strtoupper($form->applicant_lname ?? 'Applicant');

    $smsMessage = "Hi Ma'am/Sir $lname, your child's exam schedule is confirmed.\nAdmission No: $admissionNumber\nDate: $formattedDate\nTime: $formattedTime\nVenue: MPR Annex, FEU Diliman.";

    \App\Services\SmsService::send($guardianNumber, $smsMessage);
}

        return response()->json(['success' => true, 'redirect' => route('reminders.view')]);
    }
}
