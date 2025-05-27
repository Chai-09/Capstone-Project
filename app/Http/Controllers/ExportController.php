<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\FormsExport;
use App\Models\Payment;
use App\Models\FillupForms;
use App\Exports\AccountingExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportForms()
    {
        return Excel::download(new FormsExport, 'Applicant_Forms.xlsx');
        
    }

    public function exportAccounting()
    {
        return Excel::download(new AccountingExport, 'Accounting_File.xlsx');
    }

    public function exportAccountingByMonth($year, $month)
    {
        $data = Payment::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->get();

        $monthName = \Carbon\Carbon::create($year, $month)->format('F_Y');
        return Excel::download(new AccountingExport($data), "Accounting_Report_{$monthName}.xlsx");
    }

    public function exportFormsByMonth($year, $month)
    {
        $data = FillupForms::with(['payment', 'schedule'])
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->get();

        $monthName = \Carbon\Carbon::create($year, $month)->format('F_Y');
        return Excel::download(new FormsExport($data), "Applicant_Forms_{$monthName}.xlsx");
    }


}
