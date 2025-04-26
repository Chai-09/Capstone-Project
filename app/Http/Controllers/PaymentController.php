<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Applicant;
use App\Models\FillupForms;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'payment_mode' => 'required|string|max:255',
            'proof_of_payment' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Step 1: Get current authenticated applicant
        $applicant = Applicant::where('account_id', Auth::user()->id)->first();


        // Step 2: Get form submission using applicant's email
        $formSubmission = FillupForms::where('applicant_email', Auth::user()->email)->first();

        if (!$applicant || !$formSubmission) {
            return redirect()->back()->with('error', 'Applicant information not found.');
        }

        // Step 3: Upload proof of payment
        $path = $request->file('proof_of_payment')->store('payment_proofs', 'public');

        $now = Carbon::now()->setTimezone('Asia/Manila');

        // Step 4: Save to database
        Payment::create([
            'applicant_id' => $applicant->id,
            'applicant_fname' => $applicant->applicant_fname,
            'applicant_mname' => $applicant->applicant_mname,
            'applicant_lname' => $applicant->applicant_lname,
            'applicant_email' => $formSubmission->applicant_email,
            'applicant_contact_number' => $formSubmission->applicant_contact_number,
            'incoming_grlvl' => $formSubmission->incoming_grlvl,
            'payment_method' => $request->payment_mode,
            'proof_of_payment' => $path,
            'payment_date' => $now->toDateString(),
            'payment_time' => $now->toTimeString(),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return redirect()->route('payment.verification')->with('success', 'Payment submitted successfully!');
    }
}
