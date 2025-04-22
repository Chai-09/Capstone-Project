<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FillupForms;

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
            'numstreet' => 'required|max:255',
            'barangay' => 'required|max:255',
            'cityormunicipality' => 'required|max:255',
            'province' => 'required|max:255',
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
        $validated = $request->validate([
            'current_school' => 'required|max:255',
            'current_school_city' => 'required|max:255',
            'school_type' => 'required|in:Private,Public,Private Sectarian,Private Non-Sectarian',
            'educational_level' => 'required|in:Grade School, Junior High School, Senior High School',
            'incoming_grlvl' => 'required|in:Kinder,Grade 1,Grade 2,Grade 3,Grade 4,Grade 5,Grade 6,Grade 7,Grade 8,Grade 9,Grade 10,Grade 11,Grade 12',
            'applicant_bday' => 'required|date',
            'lrn_no' => 'required|max:255',
            'strand' => 'required|in:STEM Health Allied,STEM Engineering,STEM Information Technology,ABM Accountancy,ABM Business Management,HUMSS,GAS,SPORTS',
            'source' => 'required|in:Career Fair/Career Orientation,Events,Social Media,Friends/Family/Relatives,Billboard,Website',
        ]);

        $allData = array_merge(session('form_data', []), $validated);

        FillupForms::create($allData);
        session()->forget('form_data');

        return redirect()->route('applicant.payment.payment');
    }
}
