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
            'proof_of_payment'
        )->get();

        return view('applicant.steps.payment.payment-verification', compact('payments'));
    }
}
