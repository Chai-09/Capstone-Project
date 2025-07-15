<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FillupForms;
use Illuminate\Support\Facades\DB;

class AdmissionChartController extends Controller
{
    public function index()
    {
        $educationalLevel = FillupForms::selectRaw('educational_level, COUNT(*) as total')
            ->groupBy('educational_level')
            ->orderBy('educational_level')
            ->get();

        $male = FillupForms::where('gender', 'Male')->count();
        $female = FillupForms::where('gender', 'Female')->count();
        $ageCounts = FillupForms::selectRaw('age, COUNT(*) as total')
            ->groupBy('age')
            ->orderBy('age')
            ->get();

        $city = FillupForms::selectRaw('city, COUNT(*) as total')
            ->groupBy('city')
            ->orderBy('city')
            ->get();

        $region = FillupForms::selectRaw('region, COUNT(*) as total')
            ->groupBy('region')
            ->orderBy('region')
            ->get();

        $nationality = FillupForms::selectRaw('nationality, COUNT(*) as total')
            ->groupBy('nationality')
            ->orderBy('nationality')
            ->get();

        $schoolType = \App\Models\FillupForms::selectRaw('school_type, COUNT(*) as total')
            ->groupBy('school_type')
            ->orderBy('school_type')
            ->get();

        $source = \App\Models\FillupForms::selectRaw('source, COUNT(*) as total')
            ->groupBy('source')
            ->orderBy('source')
            ->get();


        $strand = FillupForms::where('educational_level', 'Senior High School')
            ->whereNotNull('strand')
            ->selectRaw('strand, COUNT(*) as total')
            ->groupBy('strand')
            ->orderBy('strand')
            ->get();

        $recommendedStrand = \App\Models\Applicant::whereNotNull('recommended_strand')
            ->selectRaw('recommended_strand, COUNT(*) as total')
            ->groupBy('recommended_strand')
            ->orderBy('recommended_strand')
            ->get();

        $examResult = \App\Models\ExamResult::whereNotNull('exam_result')
            ->selectRaw('exam_result, COUNT(*) as total')
            ->groupBy('exam_result')
            ->orderBy('exam_result')
            ->get();

        $incomingGradeLevels = [
            'KINDER',
            'GRADE 1',
            'GRADE 2',
            'GRADE 3',
            'GRADE 4',
            'GRADE 5',
            'GRADE 6',
            'GRADE 7',
            'GRADE 8',
            'GRADE 9',
            'GRADE 10',
            'GRADE 11',
            'GRADE 12'
        ];

        $incomingGrades = \App\Models\FillupForms::selectRaw('incoming_grlvl, COUNT(*) as total')
            ->whereIn('incoming_grlvl', $incomingGradeLevels)
            ->groupBy('incoming_grlvl')
            ->orderByRaw("FIELD(incoming_grlvl, '" . implode("','", $incomingGradeLevels) . "')")
            ->get();

        $months = DB::table('form_submissions')
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month')
            ->groupBy('year', 'month')
            ->whereNotNull('created_at')
            ->orderByRaw('year DESC, month DESC')
            ->paginate(6);

        if ($months->currentPage() > $months->lastPage()) {
            return redirect()->route('admission.reports', ['page' => 1]);
        }

        $yearlyApplicants = DB::table('form_submissions')
            ->selectRaw('YEAR(created_at) as year, COUNT(*) as total')
            ->whereNotNull('created_at')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        return view('admission.reports.admission-reports', compact(
            'educationalLevel',
            'male',
            'female',
            'ageCounts',
            'city',
            'region',
            'nationality',
            'schoolType',
            'source',
            'strand',
            'examResult',
            'incomingGrades',
            'recommendedStrand',
            'months',
            'yearlyApplicants'
        ));
    }

    public function getChartData(Request $request)
    {
        $level = $request->query('level');
        $range = $request->query('range', 'annually'); // default = annually
        $baseQuery = FillupForms::query();
        $filterYear = $request->query('year');

        if ($level && $level !== 'all') {
            $baseQuery->where('educational_level', $level);
        }

        if ($range === 'annually' && $filterYear) {
            $baseQuery->whereYear('created_at', $filterYear);
        }

        // Applicant Count Grouped by Selected Range
        switch ($range) {
            case 'daily':
                $applicantsPerRange = (clone $baseQuery)
                    ->selectRaw('DATE(created_at) as period, COUNT(*) as total')
                    ->groupBy('period')
                    ->orderBy('period')
                    ->get();

                $baseQuery->whereDate('created_at', now()->toDateString());
                break;

            case 'monthly':
                $applicantsPerRange = (clone $baseQuery)
                    ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as period, COUNT(*) as total')
                    ->groupBy('period')
                    ->orderBy('period')
                    ->get();

                $baseQuery->whereYear('created_at', now()->year)
                    ->whereMonth('created_at', now()->month);
                break;

            case 'annually':
            default:
                $applicantsPerRange = (clone $baseQuery)
                    ->selectRaw('YEAR(created_at) as period, COUNT(*) as total')
                    ->groupBy('period')
                    ->orderBy('period')
                    ->get();

                if ($filterYear) {
                    $baseQuery->whereYear('created_at', $filterYear);
                }
                break;
        }

        $data = [
            'educationalLevel' => (clone $baseQuery)->selectRaw('educational_level, COUNT(*) as total')->groupBy('educational_level')->get(),
            'gender' => (clone $baseQuery)->selectRaw('gender, COUNT(*) as total')->groupBy('gender')->get(),
            'age' => (clone $baseQuery)->selectRaw('age, COUNT(*) as total')->groupBy('age')->orderBy('age')->get(),
            'city' => (clone $baseQuery)->selectRaw('city, COUNT(*) as total')->groupBy('city')->get(),
            'region' => (clone $baseQuery)->selectRaw('region, COUNT(*) as total')->groupBy('region')->get(),
            'nationality' => (clone $baseQuery)->selectRaw('nationality, COUNT(*) as total')->groupBy('nationality')->get(),
            'schoolType' => (clone $baseQuery)->selectRaw('school_type, COUNT(*) as total')->groupBy('school_type')->get(),
            'source' => (clone $baseQuery)->selectRaw('source, COUNT(*) as total')->groupBy('source')->get(),
            'strand' => (clone $baseQuery)->whereNotNull('strand')->selectRaw('strand, COUNT(*) as total')->groupBy('strand')->get(),
            'incomingGrades' => (clone $baseQuery)->selectRaw('incoming_grlvl, COUNT(*) as total')->groupBy('incoming_grlvl')->get(),
            'examResult' => \App\Models\ExamResult::whereNotNull('exam_result')
                ->whereHas('applicant.formSubmission', function ($query) use ($level, $range, $filterYear) {
                    if ($level && $level !== 'all') {
                        $query->where('educational_level', $level);
                    }

                    switch ($range) {
                        case 'daily':
                            $query->whereDate('created_at', now()->toDateString());
                            break;
                        case 'monthly':
                            $query->whereYear('created_at', now()->year)
                                ->whereMonth('created_at', now()->month);
                            break;
                        case 'annually':
                            if ($filterYear) {
                                $query->whereYear('created_at', $filterYear);
                            }
                            break;
                    }
                })
                ->selectRaw('exam_result, COUNT(*) as total')
                ->groupBy('exam_result')
                ->orderBy('exam_result')
                ->get(),
            'recommendedStrand' => \App\Models\Applicant::whereNotNull('recommended_strand')
                ->when($level && $level !== 'all', function ($q) use ($level) {
                    $q->whereHas('formSubmission', function ($sub) use ($level) {
                        $sub->where('educational_level', $level);
                    });
                })
                ->when(true, function ($q) use ($range, $filterYear) {
                    switch ($range) {
                        case 'daily':
                            $q->whereDate('created_at', now()->toDateString());
                            break;
                        case 'monthly':
                            $q->whereYear('created_at', now()->year)
                                ->whereMonth('created_at', now()->month);
                            break;
                        case 'annually':
                            if ($filterYear) {
                                $q->whereYear('created_at', $filterYear);
                            }
                            break;
                    }
                })
                ->selectRaw('recommended_strand, COUNT(*) as total')
                ->groupBy('recommended_strand')
                ->orderBy('recommended_strand')
                ->get(),
        ];
        $data['applicantsPerRange'] = $applicantsPerRange;
        return response()->json($data);
    }



    public function showAdmissionDashboard()
    {
        $newApplicants = \App\Models\Applicant::whereDate('created_at', today())->count();
        $examinees = \App\Models\ApplicantSchedule::distinct('applicant_id')->count('applicant_id');
        $verifiedPayments = \App\Models\Payment::where('payment_status', 'approved')->count();
        $doneApplicants = \App\Models\Applicant::where('current_step', 7)->count();

        $stepCounts = [
            'Fill-up Forms' => \App\Models\Applicant::where('current_step', 1)->count(),
            'Send Payment' => \App\Models\Applicant::where('current_step', 2)->count(),
            'Payment Verification' => \App\Models\Applicant::where('current_step', 3)->count(),
            'Schedule Entrance Exam' => \App\Models\Applicant::where('current_step', 4)->count(),
            'Examination' => \App\Models\Applicant::where('current_step', 5)->count(),
            'Results' => \App\Models\Applicant::where('current_step', 6)->count(),
            'Completed' => \App\Models\Applicant::where('current_step', 7)->count(),
        ];

        return view('admission.reports.dashboard-cards', compact(
            'newApplicants',
            'examinees',
            'verifiedPayments',
            'doneApplicants',
            'stepCounts'
        ));
    }
}
