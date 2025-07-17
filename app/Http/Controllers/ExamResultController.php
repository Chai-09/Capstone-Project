<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamResult;
use App\Models\Applicant;
use App\Models\ApplicantSchedule;
use Illuminate\Support\Facades\Auth;
use App\Models\FillupForms;
use Illuminate\Support\Facades\Mail;

class ExamResultController extends Controller
{
    // public function index()
    // {
    //     $results = ExamResult::orderBy('exam_date', 'desc')->get();
    //     return view('admission.exam.exam-results', compact('results'));
    // }

    public function index(Request $request)
    {
        $query = ExamResult::query()
            ->whereNotNull('exam_status');

        // Search by name or grade
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('applicant_name', 'like', "%$search%")
                ->orWhere('incoming_grade_level', 'like', "%$search%");
            });
        }

        // Filter by exam result
        if ($request->filled('result')) {
            $query->where('exam_result', $request->result);
        }

        // Filter by exam status
        if ($request->filled('status')) {
            $query->where('exam_status', $request->status);
        }

        // Sort by name
        if ($request->filled('sort_name') && in_array($request->sort_name, ['asc', 'desc'])) {
            $query->orderBy('applicant_name', $request->sort_name);
        }

        // Sort by date
        elseif ($request->filled('sort_date') && in_array($request->sort_date, ['asc', 'desc'])) {
            $query->orderBy('exam_date', $request->sort_date);
        }

        // Sort by grade level (custom)
        elseif ($request->filled('sort_grade') && in_array($request->sort_grade, ['asc', 'desc'])) {
            $customOrder = [
                'KINDER', 'GRADE 1', 'GRADE 2', 'GRADE 3', 'GRADE 4',
                'GRADE 5', 'GRADE 6', 'GRADE 7', 'GRADE 8', 'GRADE 9',
                'GRADE 10', 'GRADE 11', 'GRADE 12'
            ];

            $direction = $request->sort_grade;

            $results = $query->get()->sortBy(function ($item) use ($customOrder) {
                $level = strtoupper(trim($item->incoming_grade_level));
                return array_search($level, $customOrder) !== false ? array_search($level, $customOrder) : 999;
            }, SORT_REGULAR, $direction === 'desc');

            // Manual pagination
            $page = $request->get('page', 1);
            $perPage = 10;
            $paged = $results->slice(($page - 1) * $perPage, $perPage)->values();

            $results = new \Illuminate\Pagination\LengthAwarePaginator(
                $paged,
                $results->count(),
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            return view('admission.exam.exam-results', compact('results'));
        }

        // Default: latest first
        $query->orderBy('exam_date', 'desc');
        $results = $query->paginate(12)->withQueryString();

        return view('admission.exam.exam-results', compact('results'));
    }


    public function markAttendance(Request $request)
    {
        $schedule = ApplicantSchedule::findOrFail($request->schedule_id);
        $applicant = Applicant::where('id', $schedule->applicant_id)->first();

        if (!$applicant) {
            return back()->with('alert_type', 'error')->with('alert_message', 'Applicant not found.');
        }

        $status = $request->status;
        $examResultValue = ($status === 'no show') ? 'no_show' : 'pending';


        // Always update both status and result
        $existing = ExamResult::where('applicant_id', $applicant->id)->first();
        $admissionNumber = $schedule->admission_number;

        if ($existing) {
            $existing->applicant_name = $applicant->applicant_fname . ' ' . $applicant->applicant_lname;
            $existing->incoming_grade_level = $applicant->incoming_grlvl;
            $existing->exam_date = $schedule->exam_date;
            $existing->exam_status = $status;
            $existing->exam_result = $examResultValue;
            $existing->admission_number = $admissionNumber;

            // only overwrite result if status is no_show
            if ($existing->exam_status === 'no show') {

                $existing->exam_result = 'no show';
            }

            $existing->save();
        } else {
            ExamResult::create([
                'applicant_id' => $applicant->id,
                'applicant_name' => $applicant->applicant_fname . ' ' . $applicant->applicant_lname,
                'incoming_grade_level' => $applicant->incoming_grlvl,
                'exam_date' => $schedule->exam_date,
                'exam_status' => $status,
                'exam_result' => $examResultValue,
                'admission_number' => $admissionNumber,
            ]);
        }


        //Email to send exam status to applicant
         Mail::send('emails.exam-status', [
        'applicant' => $applicant,
        'status' => ucfirst($status),
    ], function ($message) use ($applicant) {
        $message->to($applicant->formSubmission->guardian_email)
                ->subject('Your Exam Status Has Been Updated');
    });

    // SMS Notification for Exam Status
if ($applicant->formSubmission && $applicant->formSubmission->guardian_contact_number) {
    $guardianNumber = $applicant->formSubmission->guardian_contact_number;
    $lname = strtoupper($applicant->applicant_lname ?? 'Applicant');

    $smsMessage = "Hi Ma'am/Sir $lname, your exam status is now marked as: " . strtoupper($status) . ". ";
    
    if ($status === 'no show') {
        $smsMessage .= "Please contact Admissions to reschedule.";
    } else {
        $smsMessage .= "We will notify you once the result is available.";
    }

    \App\Services\SmsService::send($guardianNumber, $smsMessage);
}

        return back()->with('alert_type', 'success')->with('alert_message', 'Applicant marked as ' . strtoupper($status));

    }

    public function update(Request $request)
    {
        $request->validate([
            'applicant_id' => 'required|exists:exam_results,applicant_id',
            'exam_result' => 'required|string|in:pending,passed,failed,scholarship,interview'
        ]);

        $result = ExamResult::where('applicant_id', $request->applicant_id)->first();

        if ($result && $result->exam_status !== 'no_show') {
            // only allow manual update if not marked as no_show
            $result->exam_result = $request->exam_result;
            $result->save();
        }

        $applicant = Applicant::find($result->applicant_id);

        if (!$result || $result->exam_status === 'no show') {
            return redirect()->back()->with('error', 'Cannot update this exam result.');
        }

        // new statement, makes sure na if nag change na yung exam_result from pending to any status it increments current_step to 7 (COMPLETE)
        if ($request->exam_result !== 'pending') {

            if ($applicant && $applicant->current_step < 7) {
                $applicant->update(['current_step' => 7]);
            }
        }

           //Send email to guardian about exam result
    $email = optional($applicant->formSubmission)->guardian_email;

    if ($email) {
        Mail::send('emails.exam-result', [
            'applicant' => $applicant,
            'result' => ucfirst($request->exam_result),
        ], function ($message) use ($email) {
            $message->to($email)
                    ->subject('Your Exam Result Is Now Available');
        });
    }

        // SMS Notification for Exam Result
    if ($applicant->formSubmission && $applicant->formSubmission->guardian_contact_number) {
        $guardianNumber = $applicant->formSubmission->guardian_contact_number;
        $lname = strtoupper($applicant->applicant_lname ?? 'Applicant');
        $resultReadable = strtoupper($request->exam_result);

        $smsMessage = "Hi Ma'am/Sir $lname, your exam result is now available: $resultReadable. ";
        $smsMessage .= "Please check your ApplySmart account for full details.";

        \App\Services\SmsService::send($guardianNumber, $smsMessage);
    }

        return redirect()->back()->with('success', 'Exam result updated successfully.');
    }

    public function showForApplicant()
    {
        $user = Auth::user();
        $applicant = Applicant::where('account_id', $user->id)->first();

        if (!$applicant) {
            return view('applicant.exam-result.exam-result')->with('examResult', null);
        }

        $examResult = ExamResult::where('applicant_id', $applicant->id)->first();

        // Enforce data integrity if record was corrupted or edited
        if ($examResult && $examResult->exam_status === 'no show' && $examResult->exam_result !== 'no_show') {
            $examResult->exam_result = 'no_show';
            $examResult->save();
        }

        return view('applicant.exam-result.exam-result', compact('examResult'))->with('currentStep', $applicant->current_step);
    }

    public function autoArchiveFailedApplicants()
    {
        $cutoffDate = \Carbon\Carbon::now()->subMinutes(2);

    
        $results = \App\Models\ExamResult::where('exam_result', 'failed')
            ->where('updated_at', '<=', $cutoffDate)
            ->get();
    
        $archivedCount = 0;
    
        foreach ($results as $result) {
            $applicant = $result->applicant;
            if ($applicant && $applicant->account && $applicant->account->is_archive === 'no') {
                $applicant->account->update(['is_archive' => 'yes']);
                $archivedCount++;
            }
        }
    
        return response()->json(['message' => "Auto-archived $archivedCount applicant(s)."]);
    }
    

}
