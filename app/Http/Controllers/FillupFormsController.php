<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FillupForms;

class FillupFormsController extends Controller
{
    public function create()
    {
        return view('fillupforms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'applicant_fname' => 'required|string|max:255',
            'applicant_mname' => 'nullable|max:255',
            'applicant_lname' => 'required|string|max:255',
            'applicant_contact_number' => 'required|string|max:20',
            'applicant_email' => 'required|email|max:255',
            'numstreet' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'cityormunicipality' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|numeric',
            'age' => 'required|numeric',
            'gender' => 'required|in:Male,Female',
            'nationality' => 'required|string|max:255',

            // guardian
            'guardian_fname' => 'required|string|max:255',
            'guardian_mname' => 'nullable|max:255',
            'guardian_lname' => 'required|string|max:255',
            'guardian_contact_number' => 'required|string|max:20',
            'guardian_email' => 'required|email|max:255',
            'relation' => 'required|in:Parents,Brother/Sister,Uncle/Aunt,Cousin,Grandparents',

            // school info
            'current_school' => 'required|string|max:255',
            'current_school_city' => 'required|string|max:255',
            'school_type' => 'required|in:Private,Public,Private Sectarian,Private Non-Sectarian',
            'education_level' => 'required|in:Grade School, Junior High School, Senior High School',
            'incoming_grlvl' => 'required|in:Kinder,Grade 1,Grade 2,Grade 3,Grade 4,Grade 5,Grade 6,Grade 7,Grade 8,Grade 9,Grade 10,Grade 11,Grade 12',
            'applicant_bday' => 'required|date',
            'lrn_no' => 'required|string|max:255',
            'strand' => 'required|in:STEM Health Allied,STEM Engineering,STEM Information Technology,ABM Accountancy,ABM Business Management,HUMSS,GAS,SPORTS',
            'source' => 'required|in:Career Fair/Career Orientation,Events,Social Media,Friends/Family/Relatives,Billboard,Website',
        ]);

        Applicant::create([
            // applicant
            'applicant_fname' => strtoupper($request->applicant_fname),
            'applicant_mname' => $request->$applicant_mname,
            'applicant_lname' => strtoupper($request->applicant_lname),
            'applicant_contact_number' => $request->applicant_contact_number,
            'applicant_email' => $request->applicant_email,
            'numstreet' => $request->numstreet,
            'barangay' => $request->barangay,
            'cityormunicipality' => $request->cityormunicipality,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'age' => $request->age,
            'gender' => $request->gender,
            'nationality' => $request->nationality,

            // guardian
            'guardian_fname' => strtoupper($request->guardian_fname),
            'guardian_mname' => $request->$guardian_mname,
            'guardian_lname' => strtoupper($request->guardian_lname),
            'guardian_contact_number' => $request->guardian_contact_number,
            'guardian_email' => $request->guardian_email,
            'relation' => $request->relation,

            // school information
            'current_school' => $request->current_school,
            'current_school_city' => $request->current_school_city,
            'school_type' => $request->school_type,
            'education_level' => $request->education_level,
            'incoming_grlvl' => $request->incoming_grlvl,
            'applicant_bday' => $request->applicant_bday,
            'lrn_no' => $request->lrn_no,
            'strand' => $request->strand,
            'source' => $request->source,
        ]);

        return redirect()->route('fillupforms.create')->with('success', 'Form submitted successfully!');
    }
}
