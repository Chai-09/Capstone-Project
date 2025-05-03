<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\FillupForms;
use Illuminate\Support\Facades\Auth;
use App\Models\Applicant;

class ViewPaymentController extends Controller
{
    public function index()
    {
        $applicant = Applicant::where('account_id', Auth::id())->first();

        $formSubmission = FillupForms::where('applicant_id', $applicant->id)->first();

        if (!$applicant) {
            return redirect()->back()->with('error', 'No applicant found.');
        }

        $payments = Payment::select(
            'id',
            'applicant_fname',
            'applicant_mname',
            'applicant_lname',
            'incoming_grlvl',
            'applicant_email',
            'applicant_contact_number',
            'payment_method',
            'proof_of_payment',
            'payment_status',
            'remarks', //dinagdagan ko lang to para sa applicants.
            'ocr_number' //
        )
            ->where('applicant_id', $applicant->id)
            ->get();

        $currentStep = $applicant->current_step ?? 1;

        return view('applicant.steps.payment.payment-verification', compact('currentStep', 'payments', 'applicant'));
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
            $applicant->current_step = 4;
            $applicant->save();
        }

        return redirect()->route('applicant.examdates');
    }
}
