<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\FillupForms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Accounts;
use App\Models\Payment;
use App\Models\ExamSchedule;

class EditApplicantController extends Controller
{
    public function show($id)
    {
        $applicant = Applicant::findOrFail($id);
        $formData = FillupForms::where('applicant_id', $applicant->id)->first();
        $isEditable = false;
        if (!$formData) {
            return back()->with('error', 'Form submission not found.');
        }

        $educationalLevel = $formData->educational_level;

        // Fetch only relevant exam schedules based on applicant's educational level
        if (in_array($educationalLevel, ['Grade School', 'Junior High School'])) {
            $availableSchedules = ExamSchedule::whereIn('educational_level', ['Grade School', 'Junior High School'])->get();
        } elseif ($educationalLevel === 'Senior High School') {
            $availableSchedules = ExamSchedule::where('educational_level', 'Senior High School')->get();
        } else {
            $availableSchedules = collect(); // empty fallback
        }

        $existingPayment = Payment::where('applicant_id', $applicant->id)->latest()->first();
        $account = $applicant->account;
        $payment = Payment::where('applicant_id', $applicant->id)->first();
        $schedule = \App\Models\ApplicantSchedule::where('applicant_id', $applicant->id)->first();
        $examResult = \App\Models\ExamResult::where('applicant_id', $applicant->id)->first();

        $timestamps = [
            'account_created'   => optional($account)->created_at ?? '—',
            'form_submitted'    => optional($formData)->created_at ?? '—',
            'payment_sent'      => optional($payment)->created_at ?? '—',
            'payment_verified'  => optional($payment)->updated_at ?? '—',
            'exam_booked'       => optional($schedule)->created_at ?? '—',
            'exam_result'       => optional($examResult)->created_at ?? '—',
        ];

        $historyLogs = DB::table('form_change_logs')
            ->where('form_submission_id', $formData->id)
            ->orderByDesc('created_at')
            ->get();

        $limitedLogs = $historyLogs->take(5);

        return view('admission.applicant.edit-applicant-info', compact(
            'applicant',
            'formData',
            'historyLogs',
            'limitedLogs',
            'timestamps',
            'existingPayment',
            'schedule',
            'examResult',
            'availableSchedules', 
            'isEditable'
        ));
    }


    public function update(Request $request, $id)
    {
        $form = FillupForms::findOrFail($id);
        $original = $form->getOriginal(); 

        $rules = [
            'applicant_fname' => 'nullable|max:255',
            'applicant_mname' => 'nullable|max:255',
            'applicant_lname' => 'nullable|max:255',
            'applicant_contact_number' => 'nullable|max:20',
            'applicant_email' => 'nullable|email',
            'region' => 'nullable|max:255',
            'province' => 'nullable|max:255',
            'city' => 'nullable|max:255',
            'barangay' => 'nullable|max:255',
            'numstreet' => 'nullable|max:255',
            'postal_code' => 'nullable|max:255',
            'age' => 'nullable|numeric|min:0',
            'gender' => 'nullable|in:Male,Female',
            'nationality' => 'nullable|max:255',
            'guardian_fname' => 'nullable|max:255',
            'guardian_mname' => 'nullable|max:255',
            'guardian_lname' => 'nullable|max:255',
            'guardian_contact_number' => 'nullable|max:20',
            'guardian_email' => 'nullable|email',
            'relation' => 'nullable|in:Parents,Brother/Sister,Uncle/Aunt,Cousin,Grandparents',
            'current_school'=>'nullable|max:255',
            'current_school_city' => 'nullable|max:255',
            'school_type' => 'nullable|in:Private,Public,Private Sectarian,Private Non-Sectarian',
            'educational_level' => ['nullable', Rule::in(['Grade School', 'Junior High School', 'Senior High School'])],
            'incoming_grlvl' => 'nullable|max:255',
            'source' => ['nullable', Rule::in([
                'Career Fair/Career Orientation',
                'Events',
                'Social Media (Facebook, TikTok, Instagram, Youtube, etc)',
                'Friends/Family/Relatives',
                'Billboard',
                'Website',
            ])],
            'applicant_bday' => 'nullable|date|before_or_equal:' . now()->year . '-10-01',
            'lrn_no' => 'nullable|max:255',
            'strand' => ['nullable', Rule::in([
                'STEM Health Allied', 'STEM Engineering', 'STEM Information Technology',
                'ABM Accountancy', 'ABM Business Management',
                'HUMSS', 'GAS', 'SPORTS'
            ])],
           
        ];

        $validated = $request->validate($rules);

        $validated['applicant_fname'] = strtoupper($validated['applicant_fname'] ?? $form->applicant_fname);
        $validated['applicant_mname'] = strtoupper($validated['applicant_mname'] ?? $form->applicant_mname);
        $validated['applicant_lname'] = strtoupper($validated['applicant_lname'] ?? $form->applicant_lname);

        $validated['guardian_fname'] = strtoupper($validated['guardian_fname'] ?? $form->guardian_fname);
        $validated['guardian_mname'] = strtoupper($validated['guardian_mname'] ?? $form->guardian_mname);
        $validated['guardian_lname'] = strtoupper($validated['guardian_lname'] ?? $form->guardian_lname);

        $validated['current_school'] = strtoupper($validated['current_school'] ?? $form->current_school);
        
        // Format applicant middle name
        if (!empty($validated['applicant_mname'])) {
            $applicantMname = strtoupper($validated['applicant_mname']);
            $applicantMname = str_replace('.', '', $applicantMname); 

            if (strlen($applicantMname) <= 2) {
                $validated['applicant_mname'] = $applicantMname . '.';
            } else {
                $validated['applicant_mname'] = $applicantMname; 
            }
        }

        // Format guardian middle name
        if (!empty($validated['guardian_mname'])) {
            $guardianMname = strtoupper($validated['guardian_mname']);
            $guardianMname = str_replace('.', '', $guardianMname); 

            if (strlen($guardianMname) <= 2) {
                $validated['guardian_mname'] = $guardianMname . '.';
            } else {
                $validated['guardian_mname'] = $guardianMname;
            }
        }

        // Update the form
        $form->update($validated);

        $applicantId = $form->applicant_id;
        $fullName = strtoupper(trim(($validated['applicant_fname'] ?? $form->applicant_fname) . ' ' . ($validated['applicant_lname'] ?? $form->applicant_lname)));
        $email = strtolower($validated['applicant_email'] ?? $form->applicant_email);

        //  Save applicant schedule (Step 4)
        // Extract start_time and end_time from combined time_slot field
        if ($request->filled('exam_date') && $request->filled('time_slot')) {
            [$start_time, $end_time] = explode('|', $request->time_slot);

            DB::table('applicant_schedules')->updateOrInsert(
                ['applicant_id' => $form->applicant_id],
                [
                    'exam_date' => $request->exam_date,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'updated_at' => now()
                ]
            );
        }


        // ✅ Save exam result (Step 6)
        if ($request->filled('exam_status')) {
            $examStatus = $request->exam_status;
            $examResult = $examStatus === 'no show' ? 'no show' : ($request->input('exam_result') ?? 'pending'); // default to pending if none

            DB::table('exam_results')
                ->updateOrInsert(
                    ['applicant_id' => $form->applicant_id],
                    [
                        'exam_status' => $examStatus,
                        'exam_result' => $examResult,
                        'updated_at' => now()
                    ]
                );
            }

        if (isset($validated['applicant_fname'])) {
            $validated['applicant_fname'] = strtoupper($validated['applicant_fname']);
        }
        if (isset($validated['applicant_mname'])) {
            $validated['applicant_mname'] = strtoupper($validated['applicant_mname']);
        }
        if (isset($validated['applicant_lname'])) {
            $validated['applicant_lname'] = strtoupper($validated['applicant_lname']);
        }


        // Update related tables
        Applicant::where('id', $applicantId)->update([
            'applicant_fname' => $validated['applicant_fname'] ?? $form->applicant_fname,
            'applicant_mname' => $validated['applicant_mname'] ?? $form->applicant_mname,
            'applicant_lname' => $validated['applicant_lname'] ?? $form->applicant_lname,
     
        ]);
        
        if (isset($start_time, $end_time, $request->exam_date)) {
            DB::table('applicant_schedules')->where('applicant_id', $applicantId)->update([
                'applicant_name' => $fullName,
                'exam_date' => $request->exam_date,
                'start_time' => $start_time,
                'end_time' => $end_time,
            ]);
        } else {
            DB::table('applicant_schedules')->where('applicant_id', $applicantId)->update([
                'applicant_name' => $fullName,
            ]);
        }
        

        if ($request->filled(['exam_status', 'exam_result'])) {
            DB::table('exam_results')->where('applicant_id', $applicantId)->update([
                'applicant_name' => $fullName,
                'exam_date' => $request->exam_date,
                'exam_status' => $request->exam_status,
                'exam_result' => $request->exam_result,
            ]);
        } else {
            DB::table('exam_results')->where('applicant_id', $applicantId)->update([
                'applicant_name' => $fullName,
            ]);
        }
        

        DB::table('payment')->where('applicant_id', $applicantId)->update([
            'applicant_fname' => $validated['applicant_fname'] ?? $form->applicant_fname,
            'applicant_mname' => $validated['applicant_mname'] ?? $form->applicant_mname,
            'applicant_lname' => $validated['applicant_lname'] ?? $form->applicant_lname,
            'applicant_email' => $email,
        ]);

        // Log changes
        $changes = [];
        foreach ($validated as $field => $newValue) {
            $oldValue = $original[$field] ?? null;
            if ($oldValue != $newValue) {
                $changes[] = [
                    'form_submission_id' => $form->id,
                    'field_name' => $field,
                    'old_value' => $oldValue,
                    'new_value' => $newValue,
                    'changed_by' => Auth::user()->email,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (!empty($changes)) {
            DB::table('form_change_logs')->insert($changes);
        }

        return redirect()->back()->with([
            'success' => 'Applicant information updated successfully.',
            'changes' => $changes, // this will be passed to SweetAlert
        ]);
        
    }

    public function saveExamSchedule(Request $request)
{
    $request->validate([
        'exam_date' => 'required|date',
        'start_time' => 'required|date_format:H:i:s',
        'end_time' => 'required|date_format:H:i:s',
    ]);

    $applicant = Applicant::where('account_id', Auth::id())->firstOrFail();

    DB::table('applicant_schedules')->updateOrInsert(
        ['applicant_id' => $applicant->id],
        [
            'exam_date' => $request->exam_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'updated_at' => now()
        ]
    );

    return response()->json(['success' => true]);
}

public function getTimeSlots(Request $request)
{
    $date = $request->input('exam_date');
    $level = $request->input('educational_level');

    if (!$date || !$level) {
        return response()->json([]);
    }

    $query = ExamSchedule::whereDate('exam_date', $date);

    if (in_array($level, ['Grade School', 'Junior High School'])) {
        $query->whereIn('educational_level', ['Grade School', 'Junior High School']);
    } elseif ($level === 'Senior High School') {
        $query->where('educational_level', 'Senior High School');
    }

    $slots = $query->get(['start_time', 'end_time']);

    return response()->json($slots);
}

public function destroy($id)
{
    $form = FillupForms::findOrFail($id);
    $applicant = Applicant::findOrFail($form->applicant_id);
    $accountId = $applicant->account_id;

    // Delete related records
    DB::table('payment')->where('applicant_id', $applicant->id)->delete();
    DB::table('exam_results')->where('applicant_id', $applicant->id)->delete();
    DB::table('applicant_schedules')->where('applicant_id', $applicant->id)->delete();
    DB::table('form_change_logs')->where('form_submission_id', $form->id)->delete();

    // Delete main records
    $form->delete();
    $applicant->delete();

    // Optional: delete account if no other role/user is tied to it
    Accounts::where('id', $accountId)->delete();

    return redirect()->route('applicantlist')->with('success', 'Applicant and account deleted successfully.');
}

}


