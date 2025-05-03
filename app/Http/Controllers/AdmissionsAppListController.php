<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;

class AdmissionsAppListController extends Controller
{
    public function index(Request $request)
{
    $query = Applicant::with('formSubmission');

    // Search by name or email
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('applicant_fname', 'like', "%$search%")
              ->orWhere('applicant_lname', 'like', "%$search%")
              ->orWhereHas('formSubmission', function ($q2) use ($search) {
                  $q2->where('applicant_email', 'like', "%$search%");
              });
        });
    }

    // Filter by grade level
    if ($request->filled('grade_level')) {
        $query->where('incoming_grlvl', $request->grade_level);
    }

    // Filter by current step/stage
    if ($request->filled('stage')) {
        $query->where('current_step', $request->stage);
    }

    // Paginate results
    $applicants = $query->paginate(12);

    return view('admission.applicants-list', compact('applicants'));
}

    
}
