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

    public function showPaymentForm()
{
    $applicant = Applicant::where('account_id', Auth::id())->firstOrFail();
    $formSubmission = FillupForms::where('applicant_id', $applicant->id)->first();

    if (!$formSubmission) {
        return redirect()->route('applicantdashboard');
    }

    $currentStep = $applicant->current_step ?? 1;

    // STEP 1: Check if resched payment exists
    $reschedPayment = Payment::where('applicant_id', $applicant->id)
        ->where('payment_for', 'resched')
        ->whereIn('payment_status', ['pending', 'approved'])
        ->latest()
        ->first();

    // STEP 2: If none, check first-time payment
    $firstTimePayment = Payment::where('applicant_id', $applicant->id)
        ->where('payment_for', 'first-time')
        ->whereIn('payment_status', ['pending', 'approved'])
        ->latest()
        ->first();

    // Use resched if it exists, else fallback
    $existingPayment = $reschedPayment ?? $firstTimePayment;
    $isReschedPayment = $existingPayment && $existingPayment->payment_for === 'resched';

    $isPaymentSubmitted = !$applicant->is_reschedule_active && $existingPayment;

    return view('applicant.steps.payment.payment', [
        'formSubmission' => $formSubmission,
        'existingPayment' => $existingPayment,
        'currentStep' => $currentStep,
        'isReschedPayment' => $isReschedPayment,
        'isPaymentSubmitted' => $isPaymentSubmitted,
    ]);

}


    public function store(Request $request)
    {

        $request->validate([
            'payment_mode' => 'required|string|max:255',
            'proof_of_payment' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ], [
            'proof_of_payment.max' => 'The file size must not exceed 2MB or 2048KB',
        ]);

        $applicant = Applicant::where('account_id', Auth::user()->id)->firstOrFail();

        
        $hasPreviousApproved = Payment::where('applicant_id', $applicant->id)
            ->where('payment_for', 'first-time')
            ->where('payment_status', 'approved')
            ->exists();

        $paymentPurpose = $hasPreviousApproved ? 'resched' : 'first-time';

        $formSubmission = FillupForms::where('applicant_id', $applicant->id)->first();

        if (!$applicant || !$formSubmission) {
            return redirect()->back()->with('error', 'Applicant information not found.');
        }

        $file = $request->file('proof_of_payment');
        $filename = uniqid('proof_', true) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('payment_proofs', $filename, 'public');

        $now = Carbon::now()->setTimezone('Asia/Manila');

        Payment::create([
            'applicant_id' => $applicant->id,
            'applicant_fname' => $applicant->applicant_fname,
            'applicant_mname' => $applicant->applicant_mname,
            'applicant_lname' => $applicant->applicant_lname,
            'applicant_email' => $formSubmission->applicant_email,
            'applicant_contact_number' => $formSubmission->applicant_contact_number,
            'guardian_fname' => $applicant->guardian_fname,
            'guardian_mname' => $applicant->guardian_mname,
            'guardian_lname' => $applicant->guardian_lname,
            'incoming_grlvl' => $formSubmission->incoming_grlvl,
            'payment_method' => $request->payment_mode,
            'proof_of_payment' => $path,
            'payment_date' => $now->toDateString(),
            'payment_time' => $now->toTimeString(),
            'created_at' => $now,
            'updated_at' => $now,
            'payment_for' => $paymentPurpose,
        ]);

        $applicant->current_step = 3;
        $applicant->is_reschedule_active = false; 
        $applicant->save();



        return redirect()->route('payment.verification')->with('success', 'Payment submitted successfully!');
    }

    public function updateRemarks(Request $request, $id) // itong buong function para lang magpakita yung remarks sa applicant side
    {
        $payment = Payment::findOrFail($id);
        $payment->payment_status = $request->payment_status;
        $payment->remarks = $request->remarks;
        $payment->ocr_number = $request->ocr_number;
        $payment->save();

        return redirect()->back()->with('success', 'Payment updated successfully.');
    }

    // Reschedule Button in Step 6
  public function triggerResched()
{
    $applicant = Applicant::where('account_id', Auth::id())->firstOrFail();

    // Activate reschedule mode and send back to payment page
    $applicant->is_reschedule_active = true;
    $applicant->current_step = 2;
    $applicant->save();

    return redirect()->route('applicant.steps.payment.payment');
}

    
}
