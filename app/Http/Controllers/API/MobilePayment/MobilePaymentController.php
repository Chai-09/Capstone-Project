<?php

namespace App\Http\Controllers\API\MobilePayment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Applicant;
use App\Models\FillupForms;
use App\Models\Payment;
use Carbon\Carbon;

class MobilePaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'payment_mode' => 'required|string|max:255',
            'proof_of_payment' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);
        

        $user = $request->user();
        $applicant = Applicant::where('account_id', $user->id)->firstOrFail();

        $hasPreviousApproved = Payment::where('applicant_id', $applicant->id)
            ->where('payment_for', 'first-time')
            ->where('payment_status', 'approved')
            ->exists();

        $paymentPurpose = $hasPreviousApproved ? 'resched' : 'first-time';

        // Delete last denied payment (if exists)
        $latestDenied = Payment::where('applicant_id', $applicant->id)
        ->where('payment_status', 'denied')
        ->latest()
        ->first();

        if ($latestDenied) {
        if ($latestDenied->proof_of_payment && Storage::disk('public')->exists($latestDenied->proof_of_payment)) {
            Storage::disk('public')->delete($latestDenied->proof_of_payment);
        }
        $latestDenied->delete();
        }

        $formSubmission = FillupForms::where('applicant_id', $applicant->id)->first();


        if (!$formSubmission) {
            return response()->json(['message' => 'Form data not found.'], 404);
        }

        $file = $request->file('proof_of_payment');
        $filename = uniqid('proof_', true) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('payment_proofs', $filename, 'public');

        $now = Carbon::now('Asia/Manila');

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

        return response()->json(['message' => 'Payment submitted successfully!']);
    }

    public function viewPayment(Request $request)
    {
        $user = $request->user();
        $applicant = Applicant::where('account_id', $user->id)->firstOrFail();

        $payment = Payment::where('applicant_id', $applicant->id)
            ->orderByDesc('created_at')
            ->first();

        if (!$payment) {
            return response()->json(['message' => 'No payment found.'], 404);
        }

        return response()->json([
            'applicant_name' => $payment->applicant_fname . ' ' . $payment->applicant_mname . ' ' . $payment->applicant_lname,
            'incoming_grlvl' => $payment->incoming_grlvl,
            'applicant_email' => $payment->applicant_email,
            'applicant_contact_number' => $payment->applicant_contact_number,
            'payment_method' => $payment->payment_method,
            'proof_of_payment_url' => asset('storage/' . $payment->proof_of_payment),
            'payment_status' => $payment->payment_status,
            'payment_date' => $payment->payment_date,
            'payment_time' => $payment->payment_time,
            'remarks' => $payment->remarks,
            'ocr_number' => $payment->payment_status === 'approved' ? $payment->ocr_number : null,
            'receipt_url' => $payment->payment_status === 'approved' && $payment->receipt 
                ? asset('storage/' . $payment->receipt)
                : null,
        ]);
    }


}
