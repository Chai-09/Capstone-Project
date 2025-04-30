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
    // Check if nakasubmit na si applicant ng step 1 forms if di pa 403 type shi
    //might have to change this to applicant_id since its more secure'
      $applicant = Applicant::where('account_id', Auth::user()->id)->first();
     $formSubmission = FillupForms::where('applicant_id', $applicant->id)->first();

    if (!$formSubmission) {
        return redirect()->route('applicantdashboard');
    }

     
     $deniedPayment = Payment::where('applicant_id', $applicant->id)
     ->where('payment_status', 'denied')
     ->latest()
     ->first();

     //similar code to the one in ViewPaymentController this is here to ensure that if the user clicks the sidebar button instead of the back button the image still gets deleted either way
     if ($deniedPayment) {
        if ($deniedPayment->proof_of_payment && \Storage::disk('public')->exists($deniedPayment->proof_of_payment)) {
            \Storage::disk('public')->delete($deniedPayment->proof_of_payment);
        }

     $deniedPayment->delete();

     // Make sure step is reset to 2 if di na click back button
     $applicant->current_step = 2;
     $applicant->save();
 }


    // Check if may payment if and if dendied si applicant
    $existingPayment = Payment::where('applicant_id', $applicant->id)
        ->whereIn('payment_status', ['pending', 'approved'])
        ->latest()
        ->first();

        return view('applicant.steps.payment.payment', [
            'formSubmission' => $formSubmission,
            'existingPayment' => $existingPayment
        ]);
}

    public function store(Request $request)
    {
        
        $request->validate([
            'payment_mode' => 'required|string|max:255',
            'proof_of_payment' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Step 1: Get current authenticated applicant
        $applicant = Applicant::where('account_id', Auth::user()->id)->first();


        // Step 2: Get form submission using applicant id
        $formSubmission = FillupForms::where('applicant_id', $applicant->id)->first();

        if (!$applicant || !$formSubmission) {
            return redirect()->back()->with('error', 'Applicant information not found.');
        }

        // Step 3: Upload proof of payment
        $file = $request->file('proof_of_payment');
        $filename = uniqid('proof_', true) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('payment_proofs', $filename, 'public');

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

        $applicant->current_step = 3;
        $applicant->save();


        return redirect()->route('payment.verification')->with('success', 'Payment submitted successfully!');
    }
}
