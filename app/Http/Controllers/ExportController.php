<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\FormsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportForms()
    {
        return Excel::download(new FormsExport, 'Applicant_Forms.xlsx');
    }
}
