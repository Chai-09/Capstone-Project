<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\FillupForms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EditApplicantController extends Controller
{
    public function show($id)
    {
        $applicant = Applicant::findOrFail($id);
        $formData = FillupForms::where('applicant_id', $applicant->id)->first();

        if (!$formData) {
            return back()->with('error', 'Form submission not found for this applicant.');
        }

        return view('admission.applicant.edit-applicant-info', compact('applicant', 'formData'));
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

        // Update the form
        $form->update($validated);

        $applicantId = $form->applicant_id;
        $fullName = strtoupper(trim(($validated['applicant_fname'] ?? $form->applicant_fname) . ' ' . ($validated['applicant_lname'] ?? $form->applicant_lname)));
        $email = strtolower($validated['applicant_email'] ?? $form->applicant_email);

        // Update related tables
        Applicant::where('id', $applicantId)->update([
            'applicant_fname' => $validated['applicant_fname'] ?? $form->applicant_fname,
            'applicant_mname' => $validated['applicant_mname'] ?? $form->applicant_mname,
            'applicant_lname' => $validated['applicant_lname'] ?? $form->applicant_lname,
     
        ]);
        
        DB::table('applicant_schedules')->where('applicant_id', $applicantId)->update([
            'applicant_name' => $fullName,
        ]);

        DB::table('exam_results')->where('applicant_id', $applicantId)->update([
            'applicant_name' => $fullName,
        ]);

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

        return redirect()->back()->with('success', 'Applicant information updated successfully.');
    }
}
