<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;

class AdmissionsAppListController extends Controller
{
    public function index()
    {
        //finefetch mga applicants then dinidisplay info
        $applicants = Applicant::with('formSubmission')->paginate(12);

        return view('admission.applicants-list', compact('applicants'));
    }
    
}
