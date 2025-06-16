<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FillupForms;
use App\Models\Applicant;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class MobileFormsController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user(); // Get the currently authenticated user
        $applicant = Applicant::where('account_id', $user->id)->first();

        if (!$applicant) {
            return response()->json(['error' => 'Applicant not found.'], 404);
        }

        // Dynamic validation
        $level = $request->educational_level;
        $grade = $request->incoming_grlvl;

        $rules = [
            'applicant_fname' => 'required|max:255',
            'applicant_mname' => 'nullable|max:255',
            'applicant_lname' => 'required|max:255',
            'applicant_contact_number' => 'required|max:20',
            'applicant_email' => 'required|email',
            'region' => 'required|max:255',
            'province' => 'required|max:255',
            'city' => 'required|max:255',
            'barangay' => 'required|max:255',
            'numstreet' => 'required|max:255',
            'postal_code' => 'required|max:255',
            'age' => 'required|max:255',
            'gender' => 'required|in:Male,Female',
            'nationality' => 'required|max:255',
            'guardian_fname' => 'required|max:255',
            'guardian_mname' => 'nullable|max:255',
            'guardian_lname' => 'required|max:255',
            'guardian_contact_number' => 'required|max:20',
            'guardian_email' => 'required|email',
            'relation' => 'required|in:Parents,Brother/Sister,Uncle/Aunt,Cousin,Grandparents',
            'current_school' => 'required|max:255',
            'current_school_city' => 'required|max:255',
            'school_type' => 'required|in:Private,Public,Private Sectarian,Private Non-Sectarian',
            'educational_level' => ['required', Rule::in(['Grade School', 'Junior High School', 'Senior High School'])],
            'incoming_grlvl' => 'required',
            'source' => ['required', Rule::in([
                'Career Fair/Career Orientation',
                'Events',
                'Social Media (Facebook, TikTok, Instagram, Youtube, etc)',
                'Friends/Family/Relatives',
                'Billboard',
                'Website',
            ])],
        ];

        $rules['lrn_no'] = 'nullable|max:255'; // Always allow

        if ($level === 'Grade School') {
            if (in_array($grade, ['KINDER', 'GRADE 1'])) {
                $rules['applicant_bday'] = 'required|date|before_or_equal:' . now()->year . '-10-01';
            }
        }


        if ($level === 'Senior High School') {
            $rules['strand'] = ['required', Rule::in([
                'STEM Health Allied',
                'STEM Engineering',
                'STEM Information Technology',
                'ABM Accountancy',
                'ABM Business Management',
                'HUMSS',
                'GAS',
                'SPORTS'
            ])];
        }

        $validated = $request->validate($rules);

        // Age / Bday validation for Grade 1/Kinder
        if (in_array($grade, ['KINDER', 'GRADE 1']) && $request->filled('applicant_bday')) {
            $cutoff = Carbon::create(now()->year, 10, 1);
            $birthday = Carbon::parse($request->applicant_bday);

            if ($birthday->isFuture() || $birthday->diffInYears($cutoff, false) < 5) {
                return response()->json([
                    'error' => 'Kinder and Grade 1 applicants must be at least 5 years old on or before October ' . now()->year . '.'
                ], 422);
            }

            $validated['applicant_bday'] = Carbon::parse($request->applicant_bday)->format('Y-m-d');
        }   

        $validated['nationality'] = strtoupper($validated['nationality']);
        $validated['applicant_id'] = $applicant->id;

        // Save to DB
        $form = FillupForms::updateOrCreate(
            ['applicant_id' => $applicant->id],
            $validated
        );

        // Advance step
        $applicant->current_step = 2;
        $applicant->save();

        return response()->json([
            'message' => 'Form submitted successfully.',
            'next_step' => 2,
        ]);
    }
}
