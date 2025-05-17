<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\FillupForms;
use App\Models\FormChangeLog;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    public function show($id)
{
    $applicant = Applicant::findOrFail($id);
    $formData = FillupForms::where('applicant_id', $applicant->id)->first();

    if (!$formData) {
        return back()->with('error', 'Form submission not found.');
    }

    $historyLogs = DB::table('form_change_logs')
        ->where('form_submission_id', $formData->id)
        ->orderByDesc('created_at')
        ->get();

    return view('admission.applicant.edit-applicant-info', compact('applicant', 'formData', 'historyLogs'));
}
}
