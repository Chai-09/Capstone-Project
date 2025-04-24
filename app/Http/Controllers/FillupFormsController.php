<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FillupForms;
use Illuminate\Validation\Rule;

class FillupFormsController extends Controller
{
    public function createStep3() // this now shows the full merged form
    {
        return view('applicant.index'); // or your layout file that includes @include('applicant.steps.step-1-forms')
    }

    public function postStep3(Request $request)
    {
        $rules = [
            // Applicant
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

            // Guardian
            'guardian_fname' => 'required|max:255',
            'guardian_mname' => 'nullable|max:255',
            'guardian_lname' => 'required|max:255',
            'guardian_contact_number' => 'required|max:20',
            'guardian_email' => 'required|email',
            'relation' => 'required|in:Parents,Brother/Sister,Uncle/Aunt,Cousin,Grandparents',

            // School Info
            'current_school' => 'required|max:255',
            'current_school_city' => 'required|max:255',
            'school_type' => 'required|in:Private,Public,Private Sectarian,Private Non-Sectarian',
            'educational_level' => ['required', Rule::in([
                'Grade School',
                'Junior High School',
                'Senior High School'
            ])],
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

        // Conditional fields
        $level = $request->educational_level;
        $grade = $request->incoming_grlvl;

        if ($level === 'Grade School') {
            $rules['lrn_no'] = 'required|max:255';
            if (in_array($grade, ['Kinder', 'Grade 1'])) {
                $rules['applicant_bday'] = 'required|date';
            }
        }

        if ($level === 'Junior High School') {
            $rules['lrn_no'] = 'required|max:255';
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

        // Optional values fallback
        $optionalDefaults = [
            'applicant_bday' => $request->has('applicant_bday') ? $request->applicant_bday : null,
            'lrn_no' => $request->has('lrn_no') ? $request->lrn_no : null,
            'strand' => $request->has('strand') ? $request->strand : null,
        ];

        $allData = array_merge($validated, $optionalDefaults);

        // Add applicant_id from session if you're tracking logged-in user
        if (session()->has('applicant_id')) {
            $allData['applicant_id'] = session('applicant_id');
        }

        FillupForms::create($allData);

        return redirect()->route('applicant.steps.forms.form-submitted');
    }
}
