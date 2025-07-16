<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\Accounts;


class AdmissionsAppListController extends Controller
{
    public function index(Request $request)
{
    $query = Applicant::with('formSubmission')->whereHas('account', function ($q) {
        $q->where('is_archive', 'no');
    });

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

    // Sort by name
    if ($request->filled('sort_name') && in_array($request->sort_name, ['asc', 'desc'])) {
        $query->orderBy('applicant_fname', $request->sort_name)
            ->orderBy('applicant_lname', $request->sort_name);
    }

    // Sort by current_step
    elseif ($request->filled('sort_step') && in_array($request->sort_step, ['asc', 'desc'])) {
        $query->orderBy('current_step', $request->sort_step);
    }

    // Sort by grade level
    // Sort by grade level (custom logic)
    elseif ($request->filled('sort_grade') && in_array($request->sort_grade, ['asc', 'desc'])) {
        $customOrder = [
            'KINDER', 'GRADE 1', 'GRADE 2', 'GRADE 3', 'GRADE 4',
            'GRADE 5', 'GRADE 6', 'GRADE 7', 'GRADE 8', 'GRADE 9',
            'GRADE 10', 'GRADE 11', 'GRADE 12'
        ];

        $direction = $request->sort_grade;

        $applicants = $query->get()->sortBy(function ($applicant) use ($customOrder) {
            $level = strtoupper(trim($applicant->incoming_grlvl));
            return array_search($level, $customOrder) !== false ? array_search($level, $customOrder) : 999;
        }, SORT_REGULAR, $direction === 'desc');

        // Reset pagination manually (if needed)
        $page = $request->get('page', 1);
        $perPage = 12;
        $paged = $applicants->slice(($page - 1) * $perPage, $perPage)->values();
        $applicants = new \Illuminate\Pagination\LengthAwarePaginator(
            $paged,
            $applicants->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admission.applicants-list', compact('applicants'));
    } else {
        $query->orderBy('created_at', 'desc');
    }

    // Paginate results
    $applicants = $query->paginate(12);

    return view('admission.applicants-list', compact('applicants'));

}

public function archive($id)
{
    $applicant = Applicant::findOrFail($id);
    $account = Accounts::find($applicant->account_id);

    if ($account) {
        $account->update(['is_archive' => 'yes']);
    }

    return redirect()->route('applicantlist')->with('success', 'Applicant archived successfully.');
}

public function archivedList(Request $request)
{
    $query = Applicant::with('formSubmission')->whereHas('account', function ($q) {
        $q->where('is_archive', 'yes');
    });

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
    
    if ($request->filled('grade_level')) {
        $query->where('incoming_grlvl', $request->grade_level);
    }
    

    $applicants = $query->orderBy('created_at', 'desc')->paginate(12);

    return view('admission.archived-list', compact('applicants'));
}


public function restore($id)
{
    $applicant = Applicant::findOrFail($id);
    $account = Accounts::find($applicant->account_id);

    if ($account) {
        $account->update(['is_archive' => 'no']);
    }

    return redirect()->route('admission.archivedList')->with('success', 'Applicant restored successfully.');
}



}
