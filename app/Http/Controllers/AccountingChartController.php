<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class AccountingChartController extends Controller
{
    public function index()
    {
        $gradeLevel = Payment::selectRaw('incoming_grlvl, COUNT(*) as total')
            ->groupBy('incoming_grlvl')->orderBy('incoming_grlvl')->get();

        $paymentStatus = Payment::selectRaw('payment_status, COUNT(*) as total')
            ->groupBy('payment_status')->orderBy('payment_status')->get();

        $paymentFor = Payment::selectRaw('payment_for, COUNT(*) as total')
            ->groupBy('payment_for')->orderBy('payment_for')->get();

        // Generate list of months that have at least 1 payment
        $months = Payment::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month')
            ->groupBy('year', 'month')
            ->orderByRaw('year DESC, month DESC')
            ->get()
            ->toArray();

        return view('accounting.reports.accounting-reports', compact('gradeLevel', 'paymentStatus', 'paymentFor', 'months'));
    }


    public function getChartData(Request $request)
    {
        $data = [
            'incoming_grlvl' => Payment::selectRaw('incoming_grlvl, COUNT(*) as total')
                ->groupBy('incoming_grlvl')
                ->orderBy('incoming_grlvl')
                ->get(),

            'payment_status' => Payment::selectRaw('payment_status, COUNT(*) as total')
            ->groupBy('payment_status')
            ->orderBy('payment_status')
            ->get(),

            'payment_for' => Payment::selectRaw('payment_for, COUNT(*) as total')
            ->groupBy('payment_for')
            ->orderBy('payment_for')
            ->get()
        ];

        return response()->json($data);
    }
}
