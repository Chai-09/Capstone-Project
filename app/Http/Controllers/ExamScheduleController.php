<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamSchedule;
use App\Models\ApplicantSchedule;
use App\Models\ExamResult;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Applicant;



class ExamScheduleController extends Controller
{
    
    public function index(Request $request)
    {
        $selectedDate = $request->query('date');

        // Fetch all exam schedules, ordered and grouped by date
        $schedules = ExamSchedule::orderBy('exam_date')
        ->orderBy('start_time')
        ->get()
        ->map(function ($schedule) {
            // Get only applicants that match this schedule's level
            $usedSlots = ApplicantSchedule::with('applicant.formSubmission')
                ->whereDate('exam_date', $schedule->exam_date)
                ->whereTime('start_time', $schedule->start_time)
                ->whereTime('end_time', $schedule->end_time)
                ->get()
                ->filter(function ($app) use ($schedule) {
                    $level = $app->applicant->formSubmission->educational_level ?? null;

                    return match ($schedule->educational_level) {
                        'Grade School and Junior High School' => in_array($level, ['Grade School', 'Junior High School']),
                        'Senior High School' => $level === 'Senior High School',
                        default => false,
                    };
                })
                ->count();

            $schedule->remaining_slots = $schedule->max_participants - $usedSlots;

            return $schedule;
        })
        ->groupBy('exam_date');


        $applicants = collect(); 

        return view('admission.exam.exam-schedule', compact('schedules', 'selectedDate', 'applicants'));
    }


    // Delete specific time slot
    public function destroy($id)
    {
        $schedule = ExamSchedule::findOrFail($id);
        $schedule->delete();

        return redirect()->back()->with('success', 'Time slot deleted successfully.');
    }


    // Delete all schedules for a given date
    public function deleteDate(Request $request)
    {
        $request->validate([
            'exam_date' => 'required|date',
        ]);

        ExamSchedule::where('exam_date', $request->exam_date)->delete();

        return response()->json(['success' => true]);
    }


    public function fetchApplicants(Request $request)
    {
        $date = $request->query('date');

        if (!$date) return 'Invalid date.';

        $applicants = \App\Models\ApplicantSchedule::whereDate('exam_date', Carbon::parse($date))->get();

        $groups = [
            'Grade School' => [],
            'Junior High School' => [],
            'Senior High School' => [],
        ];

        foreach ($applicants as $applicant) {
            $level = $applicant->incoming_grade_level;

            if (in_array($level, ['Kinder', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6'])) {
                $groups['Grade School'][] = $applicant;
            } elseif (in_array($level, ['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10'])) {
                $groups['Junior High School'][] = $applicant;
            } elseif (in_array($level, ['Grade 11', 'Grade 12'])) {
                $groups['Senior High School'][] = $applicant;
            }
        }

        if (empty($groups['Grade School']) && empty($groups['Junior High School']) && empty($groups['Senior High School'])) {
            return "<p class='text-muted'>No applicants for " . \Carbon\Carbon::parse($date)->format('F d, Y') . ".</p>";
        }

        $html = "";
        foreach ($groups as $groupName => $groupList) {
            $html .= "<h5 class='mt-3'>$groupName</h5>";

            if (count($groupList)) {
                $html .= "<table class='table table-bordered'><thead><tr>
                            <th>Name</th><th>Contact</th><th>Time</th><th>Grade Level</th>
                        </tr></thead><tbody>";
                foreach ($groupList as $a) {
                    $html .= "<tr>
                        <td>{$a->applicant_name}</td>
                        <td>{$a->applicant_contact_number}</td>
                        <td>" . \Carbon\Carbon::parse($a->start_time)->format('h:i A') . " - " . \Carbon\Carbon::parse($a->end_time)->format('h:i A') . "</td>
                        <td>{$a->incoming_grade_level}</td>
                    </tr>";
                }
                $html .= "</tbody></table>";
            } else {
                $html .= "<p class='text-muted'>No applicants in this level.</p>";
            }
        }

        return $html;
    }


    public function fetchByDate(Request $request)
    {
        $date = $request->query('date');

        if (!$date) return 'Invalid date.';

        $applicants = ApplicantSchedule::whereDate('exam_date', Carbon::parse($date))
            ->orderBy('start_time')->get()
            ->groupBy(function ($a) {
                return $a->start_time . ' - ' . $a->end_time;
            });

        if ($applicants->isEmpty()) {
            return "<p class='text-muted'>No applicants for " . Carbon::parse($date)->format('F d, Y') . ".</p>";
        }

        $html = "<h5>Applicants on " . Carbon::parse($date)->format('F d, Y') . " (Grouped by Time)</h5>";

        foreach ($applicants as $time => $group) {
            $html .= "<h6 class='mt-3'>$time</h6><table class='table table-bordered'><thead><tr>
                        <th>Name</th><th>Contact</th><th>Grade Level</th>
                    </tr></thead><tbody>";

            foreach ($group as $a) {
                $html .= "<tr><td>{$a->applicant_name}</td><td>{$a->applicant_contact_number}</td><td>{$a->incoming_grade_level}</td></tr>";
            }

            $html .= "</tbody></table>";
        }

        return $html;
    }


    public function fetchByTimeSlot(Request $request)
    {
        $date = $request->query('date');
        $start = $request->query('start');
        $end = $request->query('end');

        if (!$date || !$start || !$end) {
            return "<p class='text-danger'>Invalid schedule selection.</p>";
        }

        $startFormatted = Carbon::parse($start)->format('H:i:s');
        $endFormatted = Carbon::parse($end)->format('H:i:s');

        // Get the clicked schedule to determine time + level
        $schedule = ExamSchedule::whereDate('exam_date', $date)
            ->whereTime('start_time', $startFormatted)
            ->whereTime('end_time', $endFormatted)
            ->first();

        if (!$schedule) {
            return "<p class='text-danger'>No matching schedule found.</p>";
        }

        // Fetch all applicants scheduled at the same date and time
        $applicants = ApplicantSchedule::with('applicant.formSubmission')
            ->whereDate('exam_date', $date)
            ->whereTime('start_time', $startFormatted)
            ->whereTime('end_time', $endFormatted)
            ->get()
            ->filter(function ($app) use ($schedule) {
                $form = $app->applicant->formSubmission ?? null;

                if (!$form || !$form->educational_level) return false;

                $applicantLevel = $form->educational_level;
                $scheduleLevel = $schedule->educational_level;

                // Compare based on the logic you want
                if ($scheduleLevel === 'Grade School and Junior High School') {
                    return in_array($applicantLevel, ['Grade School', 'Junior High School']);
                }

                if ($scheduleLevel === 'Senior High School') {
                    return $applicantLevel === 'Senior High School';
                }

                return false;
            });

        if ($applicants->isEmpty()) {
            return "<p class='text-muted'>No applicants found for this time slot and educational level.</p>";
        }

        // Generate HTML table of matching applicants
        $html = "<h5>Applicants for " . Carbon::parse($date)->format('F d, Y') . " (" . Carbon::parse($start)->format('h:i A') . " - " . Carbon::parse($end)->format('h:i A') . ")</h5>";
        $html .= "<p class='text-muted'>Schedule Level: <strong>{$schedule->educational_level}</strong></p>";
        $html .= "<table class='table table-bordered mt-3'><thead><tr>
                    <th>Name</th><th>Contact</th><th>Grade Level</th>
                </tr></thead><tbody>";

        foreach ($applicants as $a) {
            $html .= "<tr>
                <td>{$a->applicant_name}</td>
                <td>{$a->applicant_contact_number}</td>
                <td>{$a->incoming_grade_level}</td>
            </tr>";
        }

        $html .= "</tbody></table>";

        return $html;
    }


    public function getApplicantsByDate(Request $request)
    {
        $date = $request->query('date');

        $applicants = ApplicantSchedule::with('applicant', 'examResult')
            ->whereDate('exam_date', $date)
            ->get();

        $results = ExamResult::all()->keyBy('applicant_id');

        return response()->json([
            'applicants' => $applicants,
            'results' => $results,
        ]);
    }

    public function showExamDatesForApplicants()
{
    $accountId = Auth::id();

    $applicant = \App\Models\Applicant::with('formSubmission')
        ->where('account_id', $accountId)
        ->first();

    $currentStep = $applicant->current_step;

    if (!$applicant || !$applicant->formSubmission) {
        abort(404, 'Applicant or form submission not found.');
    }

    $educationalLevel = $applicant->formSubmission->educational_level;

    $query = \App\Models\ExamSchedule::query()
        ->orderBy('exam_date')
        ->orderBy('start_time');

    if (in_array($educationalLevel, ['Grade School', 'Junior High School'])) {
        $query->where('educational_level', 'Grade School and Junior High School');
    } elseif ($educationalLevel === 'Senior High School') {
        $query->where('educational_level', 'Senior High School');
    }

    $examSchedules = $query->get()->filter(function ($schedule) {
        $usedSlots = \App\Models\ApplicantSchedule::with('applicant.formSubmission')
            ->whereDate('exam_date', $schedule->exam_date)
            ->whereTime('start_time', $schedule->start_time)
            ->whereTime('end_time', $schedule->end_time)
            ->get()
            ->filter(function ($app) use ($schedule) {
                $level = $app->applicant->formSubmission->educational_level ?? null;
                return match ($schedule->educational_level) {
                    'Grade School and Junior High School' => in_array($level, ['Grade School', 'Junior High School']),
                    'Senior High School' => $level === 'Senior High School',
                    default => false,
                };
            })
            ->count();

        $schedule->remaining_slots = $schedule->max_participants - $usedSlots;

        // Only include if slots remain
        return $schedule->remaining_slots > 0;
    });

    return view('applicant.steps.exam_date.exam-date', compact('examSchedules', 'currentStep'));
}

}
