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

        $formSubmission = FillupForms::where('applicant_id', $applicant->id)->first();
        if (!$formSubmission) {
            return response()->json(['message' => 'Form data not found.'], 404);
        }

        $hasApprovedFirstTime = Payment::where('applicant_id', $applicant->id)
            ->where('payment_for', 'first-time')
            ->where('payment_status', 'approved')
            ->exists();

        // Determine if this is a reschedule
        $isReschedule = $hasApprovedFirstTime && $applicant->is_reschedule_active;
        $paymentPurpose = $isReschedule ? 'resched' : 'first-time';

        if ($isReschedule) {
            // Delete exam result and schedule
            \App\Models\ExamResult::where('applicant_id', $applicant->id)->delete();
            \App\Models\ApplicantSchedule::where('applicant_id', $applicant->id)->delete();

            // Delete only DENIED payments
            $deniedPayments = Payment::where('applicant_id', $applicant->id)
                ->where('payment_status', 'denied')
                ->get();

            foreach ($deniedPayments as $denied) {
                if ($denied->proof_of_payment && Storage::disk('public')->exists($denied->proof_of_payment)) {
                    Storage::disk('public')->delete($denied->proof_of_payment);
                }
                if ($denied->receipt && Storage::disk('public')->exists($denied->receipt)) {
                    Storage::disk('public')->delete($denied->receipt);
                }
                $denied->delete();
            }
            // Reset step
            $applicant->current_step = 2;
            $applicant->is_reschedule_active = true; 
        }

        // Upload new file
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
        $applicant->save(); // is_reschedule_active is already set above

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

        public function revertStep(Request $request)
        {
            $user = $request->user();
            $applicant = $user->applicant;

            if (!$applicant) {
                return response()->json(['error' => 'Applicant not found'], 404);
            }

            // Find the latest denied payment
            $deniedPayment = \App\Models\Payment::where('applicant_id', $applicant->id)
                ->where('payment_status', 'denied')
                ->latest()
                ->first();

            if ($deniedPayment) {
                // Delete proof of payment if exists
                if ($deniedPayment->proof_of_payment && Storage::disk('public')->exists($deniedPayment->proof_of_payment)) {
                    Storage::disk('public')->delete($deniedPayment->proof_of_payment);
                }

                // Delete receipt if exists
                if ($deniedPayment->receipt && Storage::disk('public')->exists($deniedPayment->receipt)) {
                    Storage::disk('public')->delete($deniedPayment->receipt);
                }

                // Delete the denied payment record
                $deniedPayment->delete();
            }

            // Revert current step
            $applicant->current_step = 2;
            $applicant->save();

            return response()->json(['message' => 'Denied payment deleted and current step reverted to 2.']);
        }

       public function advanceStep(Request $request)
        {
            $user = $request->user();
            $applicant = $user->applicant;

            if (!$applicant) {
                return response()->json(['error' => 'Applicant not found.'], 404);
            }

            if ($applicant->current_step == 3) {
                $applicant->current_step = 4;
                $applicant->save();
                return response()->json(['message' => 'Step advanced to 4.']);
            }

            return response()->json(['message' => 'No step change needed.']);
        }

        public function revertToStepTwo(Request $request)
        {
            $user = $request->user();
            $applicant = Applicant::where('account_id', $user->id)->first();

            if (!$applicant) {
                return response()->json(['message' => 'Applicant not found.'], 404);
            }

            $applicant->current_step = 2;
            $applicant->is_reschedule_active = true; // Optional: if you're using this flag to allow reschedule
            $applicant->save();

            return response()->json(['message' => 'Applicant reverted to Step 2.']);
        }


}
