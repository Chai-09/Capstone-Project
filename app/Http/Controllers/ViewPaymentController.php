<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class ViewPaymentController extends Controller
{
    public function index()
    {
        // Select only the fields needed for the view
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
        )->get();

        return view('applicant.steps.payment.payment-verification', compact('payments'));
    }

    public function delete($id)
    {
        $payment = Payment::find($id);

        if ($payment && $payment->payment_status === 'denied') {
            $payment->delete();
        }

        return redirect('/applicant/steps/payment/payment')->with('success', 'Old denied payment removed. You can now submit a new payment.');
    }

}
