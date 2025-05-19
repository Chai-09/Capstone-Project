<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FillupForms;

class AdmissionChartController extends Controller
{
    public function index()
    {
        $gradeSchool = FillupForms::where('educational_level', 'Grade School')->count();
        $juniorHigh = FillupForms::where('educational_level', 'Junior High School')->count();
        $seniorHigh = FillupForms::where('educational_level', 'Senior High School')->count();

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

                
        $strand = FillupForms::selectRaw('strand, COUNT(*) as total')
            ->groupBy('strand')
            ->orderBy('strand')
            ->get();

        $examStatus = \App\Models\ExamResult::selectRaw('exam_status, COUNT(*) as total')
            ->groupBy('exam_status')
            ->orderBy('exam_status')
            ->get();

            $incomingGradeLevels = [
                'KINDER', 'GRADE 1', 'GRADE 2', 'GRADE 3', 'GRADE 4', 'GRADE 5', 'GRADE 6',
                'GRADE 7', 'GRADE 8', 'GRADE 9', 'GRADE 10',
                'GRADE 11', 'GRADE 12'
            ];
            
            $incomingGrades = \App\Models\FillupForms::selectRaw('incoming_grlvl, COUNT(*) as total')
    ->whereIn('incoming_grlvl', $incomingGradeLevels)
    ->groupBy('incoming_grlvl')
    ->orderByRaw("FIELD(incoming_grlvl, '" . implode("','", $incomingGradeLevels) . "')")
    ->get();

    return view('admission.reports.admission-reports', compact(
            'gradeSchool', 'juniorHigh', 'seniorHigh',
            'male', 'female', 'ageCounts', 'city', 'region', 'nationality', 'schoolType', 'source', 
            'strand', 'examStatus', 'incomingGrades'
        ));
    }

    public function getChartData(Request $request)
{
    $level = $request->query('level');

    $query = FillupForms::query();
    if ($level && $level !== 'all') {
        $query->where('educational_level', $level);
    }

    $data = [
        'gender' => $query->selectRaw('gender, COUNT(*) as total')->groupBy('gender')->get(),
        'age' => $query->selectRaw('age, COUNT(*) as total')->groupBy('age')->orderBy('age')->get(),
        'city' => $query->selectRaw('city, COUNT(*) as total')->groupBy('city')->get(),
        'region' => $query->selectRaw('region, COUNT(*) as total')->groupBy('region')->get(),
        'nationality' => $query->selectRaw('nationality, COUNT(*) as total')->groupBy('nationality')->get(),
        'schoolType' => $query->selectRaw('school_type, COUNT(*) as total')->groupBy('school_type')->get(),
        'source' => $query->selectRaw('source, COUNT(*) as total')->groupBy('source')->get(),
        'strand' => $query->selectRaw('strand, COUNT(*) as total')->groupBy('strand')->get(),
        'incomingGrades' => $query->selectRaw('incoming_grlvl, COUNT(*) as total')->groupBy('incoming_grlvl')->get(),
    ];

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
        'Results' => \App\Models\Applicant::where('current_step', 7)->count(),
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
