<?php

namespace App\Http\Controllers\API\MobileForms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Applicant;
use App\Models\FillupForms;

class MobileFormsController extends Controller
{
    public function submitForm(Request $request)
    {
        $request->validate([
            // Applicant Info
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
            'postal_code' => 'required|max:10',
            'age' => 'required|max:3',
            'gender' => 'required|in:Male,Female',
            'nationality' => 'required|max:255',

            // Guardian Info
            'guardian_fname' => 'required|max:255',
            'guardian_mname' => 'nullable|max:255',
            'guardian_lname' => 'required|max:255',
            'guardian_contact_number' => 'required|max:20',
            'guardian_email' => 'required|email',
            'relation' => 'required|in:Parents,Brother/Sister,Uncle/Aunt,Cousin,Grandparents',

            // Educational Background
            'current_school' => 'required|max:255',
            'current_school_city' => 'required|max:255',
            'school_type' => 'required|in:Public,Private Sectarian,Private Non-Sectarian',
            'educational_level' => ['required', Rule::in(['Grade School', 'Junior High School', 'Senior High School'])],
            'incoming_grlvl' => 'required',
            'source' => ['required', Rule::in([
                'Career Fair/Career Orientation',
                'Events',
                'Social Media',
                'Friends/Family/Relatives',
                'Billboard',
                'Website',
            ])],
            'lrn_no' => 'nullable|max:255',
            'strand' => 'nullable|max:255',
            //'applicant_bday' => 'nullable|date|before_or_equal:' . now()->year . '-10-01',
        ]);

        $user = $request->user(); // via Sanctum
        $applicant = Applicant::where('account_id', $user->id)->first();

        if (!$applicant) {
            return response()->json(['message' => 'Applicant record not found'], 404);
        }

        $data = $request->all();
        $data['applicant_id'] = $applicant->id;
        $data['nationality'] = strtoupper($data['nationality']);

        $form = FillupForms::updateOrCreate(
            ['applicant_id' => $applicant->id],
            $data
        );

        $applicant->current_step = 2;
        $applicant->save();

        return response()->json([
            'message' => 'Form successfully submitted.',
            'form_id' => $form->id
        ], 200);
    }
}
