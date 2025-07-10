<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\FillupForms;
use Illuminate\Support\Facades\Auth;
use App\Models\Applicant;
use App\Models\ExamResult;
use App\Models\ApplicantSchedule;

class ViewPaymentController extends Controller
{
    public function index()
{
    $applicant = Applicant::where('account_id', Auth::id())->firstOrFail();
    $formSubmission = FillupForms::where('applicant_id', $applicant->id)->first();

    if (!$formSubmission) {
        return redirect()->back()->with('error', 'No form submission found.');
    }

    //  Always get latest payment regardless of type
    $existingPayment = Payment::where('applicant_id', $applicant->id)
        ->whereIn('payment_status', ['pending', 'approved', 'denied'])
        ->orderByDesc('created_at')
        ->first();

    $currentStep = $applicant->current_step ?? 1;

    return view('applicant.steps.payment.payment-verification', [
        'existingPayment' => $existingPayment,
        'applicant' => $applicant,
        'currentStep' => $currentStep,
    ]);
}


    public function delete($id)
    {
        $payment = Payment::find($id);

        if ($payment && $payment->payment_status === 'denied') {
            //Delete the image in the database if denied 
            if ($payment->proof_of_payment && \Storage::disk('public')->exists($payment->proof_of_payment)) {
                \Storage::disk('public')->delete($payment->proof_of_payment);
            }

            $payment->delete();

            // Reset step to 2
            $applicant = Applicant::where('account_id', Auth::id())->first();
            if ($applicant) {
                $applicant->current_step = 2;
                $applicant->save();
            }
        }

        return redirect()->route('applicant.steps.payment.payment')->with('success', 'Old denied payment removed. You can now submit a new payment.');
    }
    //logic for incrementing current_step to 4 
    public function proceedToExam()
    {
        $applicant = Applicant::where('account_id', Auth::id())->first();

        if ($applicant && $applicant->current_step < 4) {
            ExamResult::where('applicant_id', $applicant->id)->delete();
            ApplicantSchedule::where('applicant_id', $applicant->id)->delete();
            $applicant->current_step = 4;
            $applicant->save();
        }

        return redirect()->route('applicant.examdates');
    }
}
