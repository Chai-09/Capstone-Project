<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplicantSchedule;
use App\Models\FillupForms;
use Illuminate\Support\Facades\Auth;


class ApplicantScheduleController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        // Find applicant info from form_submissions
        $form = FillupForms::where('applicant_email', $user->email)->first();

        if (!$form) {
            return response()->json(['success' => false, 'message' => 'Applicant info not found.']);
        }

        // Save schedule
        ApplicantSchedule::create([
            'user_id' => $user->id,
            'applicant_name' => strtoupper($form->applicant_fname . ' ' . $form->applicant_mname . ' ' . $form->applicant_lname),
            'applicant_contact_number' => $form->applicant_contact_number,
            'incoming_grade_level' => $form->incoming_grlvl,
            'exam_date' => $request->exam_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return response()->json(['success' => true]);
    }
}
