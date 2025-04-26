<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class AccountingPaymentController extends Controller
{
    // Show all payments
    public function index()
    {
        $payments = Payment::all();
        return view('accounting.payments', compact('payments'));
    }

    // Approve payment
    public function approve($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->payment_status = 'approved';
        $payment->save();

        return redirect()->back()->with('success', 'Payment approved successfully!');
    }

    // Deny payment
    public function deny($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->payment_status = 'denied';
        $payment->save();

        return redirect()->back()->with('success', 'Payment denied successfully!');
    }
}
