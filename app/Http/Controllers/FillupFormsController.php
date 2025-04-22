<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FillupForms;
use Illuminate\Validation\Rule;

class FillupFormsController extends Controller
{
    public function createStep1()
    {
        return view('applicant.steps.forms.applicantforms');
    }

    public function postStep1(Request $request)
    {
        $validated = $request->validate([
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
        ]);

        session(['form_data' => array_merge(session('form_data', []), $validated)]);
        return redirect()->route('form.step2');
    }

    public function createStep2()
    {
        return view('applicant.steps.forms.guardianforms');
    }

    public function postStep2(Request $request)
    {
        $validated = $request->validate([
            'guardian_fname' => 'required|max:255',
            'guardian_mname' => 'nullable|max:255',
            'guardian_lname' => 'required|max:255',
            'guardian_contact_number' => 'required|max:20',
            'guardian_email' => 'required|email',
            'relation' => 'required|in:Parents,Brother/Sister,Uncle/Aunt,Cousin,Grandparents',
        ]);

        session(['form_data' => array_merge(session('form_data', []), $validated)]);
        return redirect()->route('form.step3');
    }

    public function createStep3()
    {
        return view('applicant.steps.forms.schoolinfoforms');
    }

    public function postStep3(Request $request)
{
    if (!session()->has('form_data')) {
        return redirect()->route('form.step1')->with('error', 'Please complete the previous steps.');
    }


    $rules = [
        'current_school' => 'required|max:255',
        'current_school_city' => 'required|max:255',
        'school_type' => 'required|in:Private,Public,Private Sectarian,Private Non-Sectarian',
        'educational_level' => Rule::in([
        'Grade School',
        'Junior High School',
        'Senior High School'
    ]),

        'incoming_grlvl' => 'required',
        'source' => [
    'required',
    Rule::in([
        'Career Fair/Career Orientation',
        'Events',
        'Social Media (Facebook, TikTok, Instagram, Youtube, etc)',
        'Friends/Family/Relatives',
        'Billboard',
        'Website',
        ]),
    ],

     ];
    
    $level = $request->educational_level;
    $grade = $request->incoming_grlvl;
    
    // Grade School Logic
    if ($level === 'Grade School') {
        $rules['lrn_no'] = 'required|max:255';
    
        if (in_array($grade, ['Kinder', 'Grade 1'])) {
            $rules['applicant_bday'] = 'required|date';
        }
    }
    
    // Junior High
    if ($level === 'Junior High School') {
        $rules['lrn_no'] = 'required|max:255';
        // no birthday, no strand
    }
    
    // Senior High
    if ($level === 'Senior High School') {
        $rules['strand'] = 'required|in:STEM Health Allied,STEM Engineering,STEM Information Technology,ABM Accountancy,ABM Business Management,HUMSS,GAS,SPORTS';
        // no lrn, no bday
    }
    


    $validated = $request->validate($rules);


    $optionalDefaults = [
        'applicant_bday' => $request->has('applicant_bday') ? $request->applicant_bday : null,
        'lrn_no' => $request->has('lrn_no') ? $request->lrn_no : null,
        'strand' => $request->has('strand') ? $request->strand : null,
    ];

    $allData = array_merge(session('form_data', []), $validated, $optionalDefaults);

            // Force-null optional fields if not present
        $allData['applicant_bday'] = $allData['applicant_bday'] ?? null;
        $allData['lrn_no'] = $allData['lrn_no'] ?? null;
        $allData['strand'] = $allData['strand'] ?? null;


    session()->forget('form_data');

    return redirect()->route('applicant.payment.payment');
}
}
