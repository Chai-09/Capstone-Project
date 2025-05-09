<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Storage;



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

    if ($request->filled('payment_method')) {
        $query->where('payment_method', $request->input('payment_method'));
    }

    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function($q) use ($search) {
            $q->where('applicant_fname', 'like', "%$search%")
              ->orWhere('applicant_mname', 'like', "%$search%")
              ->orWhere('applicant_lname', 'like', "%$search%");
        });
    }

    $payments = $query->latest()->paginate(10);

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

    public function uploadReceipt(Request $request)
{
    $request->validate([
        'file' => 'required|image|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $path = $request->file('file')->store('payment_receipts', 'public');

    return response()->json(['file_path' => $path]);
}

public function update(Request $request, $id)
{
    $request->validate([
        'payment_status' => 'required|in:approved,denied',
        'remarks' => 'nullable|string',
        'ocr_number' => 'nullable|string',
        'receipt' => 'nullable|string',
    ]);

    $payment = Payment::with('formSubmission')->findOrFail($id);
    $payment->payment_status = $request->payment_status;
    $payment->remarks = $request->remarks;
    $payment->ocr_number = $request->ocr_number;
    $payment->receipt = $request->receipt;
    $payment->save();

    if ($payment->formSubmission && $payment->formSubmission->guardian_email) {
        \Mail::to($payment->formSubmission->guardian_email)->send(new \App\Mail\PaymentStatusMail($payment));
    }
    

    return redirect()->back()->with('success', 'Payment updated and email sent.');
}

public function deleteReceipt(Request $request)
{
    if ($request->file_path) {
        Storage::disk('public')->delete($request->file_path);
        return response()->json(['status' => 'deleted']);
    }
    return response()->json(['status' => 'error'], 400);
}

}
