<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class AccountingPaymentController extends Controller
{
    // Show all payments
    public function index(Request $request)
{
    $query = Payment::query();

    if ($request->filled('educational_level')) {
        $query->where('incoming_grlvl', $request->input('educational_level'));
    }

    if ($request->filled('payment_status')) {
        $query->where('payment_status', $request->input('payment_status'));
    }

    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function($q) use ($search) {
            $q->where('applicant_fname', 'like', "%$search%")
              ->orWhere('applicant_mname', 'like', "%$search%")
              ->orWhere('applicant_lname', 'like', "%$search%");
        });
    }

    $payments = $query->get();

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
