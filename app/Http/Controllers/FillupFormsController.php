<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FillupForms;
use Illuminate\Validation\Rule;
use App\Models\Applicant;

class FillupFormsController extends Controller
{
    public function createStep3()
    {
        $applicant = Applicant::where('account_id', auth()->user()->id)->first();
        $formSubmission = FillupForms::where('applicant_id', $applicant->id)->first();

        if (!$formSubmission) {
            $formSubmission = new \stdClass();

            // Prefill mga nasa signup na fields
            $formSubmission->applicant_fname = $applicant->applicant_fname ?? '';
            $formSubmission->applicant_mname = $applicant->applicant_mname ?? '';
            $formSubmission->applicant_lname = $applicant->applicant_lname ?? '';
            $formSubmission->applicant_contact_number = '';
            $formSubmission->applicant_email =  '';

            $formSubmission->guardian_fname = $applicant->guardian_fname ?? '';
            $formSubmission->guardian_mname = $applicant->guardian_mname ?? '';
            $formSubmission->guardian_lname = $applicant->guardian_lname ?? '';
            $formSubmission->guardian_contact_number = '';
            $formSubmission->guardian_email = auth()->user()->email ?? '';

            $formSubmission->current_school = $applicant->current_school ?? '';
            $formSubmission->incoming_grlvl = '';

            // Manual Input
            $formSubmission->region = '';
            $formSubmission->province = '';
            $formSubmission->city = '';
            $formSubmission->barangay = '';
            $formSubmission->numstreet = '';
            $formSubmission->postal_code = '';
            $formSubmission->age = '';
            $formSubmission->gender = '';
            $formSubmission->nationality = '';
            $formSubmission->relation = '';
            $formSubmission->current_school_city = '';
            $formSubmission->school_type = '';
            $formSubmission->educational_level = '';
            $formSubmission->applicant_bday = '';
            $formSubmission->lrn_no = '';
            $formSubmission->strand = '';
            $formSubmission->source = '';
        }
        //logic para alam ano educ level from signup
        $formSubmission->incoming_grlvl = $applicant->incoming_grlvl ?? '';
        $grlvl = $formSubmission->incoming_grlvl;
        $formSubmission->educational_level = match (true) {
        in_array($grlvl, ['KINDER', 'GRADE 1', 'GRADE 2', 'GRADE 3', 'GRADE 4', 'GRADE 5', 'GRADE 6']) => 'Grade School',
        in_array($grlvl, ['GRADE 7', 'GRADE 8', 'GRADE 9', 'GRADE 10']) => 'Junior High School',
        in_array($grlvl, ['GRADE 11', 'GRADE 12']) => 'Senior High School',
        default => '',
    };

        //readonlyfields during fillup lang
        $readOnlyFields = [
            'applicant_fname',
            'applicant_mname',
            'applicant_lname',
            'guardian_fname',
            'guardian_mname',
            'guardian_lname',
            'guardian_email',
            'current_school',
        ];

        //logic para ipakita lang ang modal if senior high
        $showStrandModal = false;

        if ($formSubmission->educational_level === 'Senior High School' && empty($formSubmission->strand)) {
            $showStrandModal = true;
}

        //prefill recommended_strand (based lang sa session feel ko kasi di na need isave sa db ito taena recommended lang naman eh)
        if (session('recommended_strand') && empty($formSubmission->strand)) {
            $formSubmission->strand = session('recommended_strand');
            session()->forget('recommended_strand');
        }

        return view('applicant.steps.forms.step-1-forms', compact('applicant', 'formSubmission', 'readOnlyFields', 'showStrandModal'))->with('currentStep', $applicant->current_step);
    }

    public function postStep3(Request $request)
    {

        $applicant = Applicant::where('account_id', auth()->user()->id)->first();

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
            if (in_array($grade, ['KINDER', 'GRADE 1'])) {
                $rules['applicant_bday'] = 'required|date|before_or_equal:' . now()->year . '-10-01';

                $bday = $request->applicant_bday;
                if ($bday) {
                    $cutoff = \Carbon\Carbon::create(now()->year, 10, 1);
                    $birthday = \Carbon\Carbon::parse($bday);
                    $age = $birthday->age;

                    // future bday validation
                    if ($birthday->isFuture()) {
                        return back()->withErrors([
                            'applicant_bday' => 'Applicant Birthday Invalid.'
                        ])->withInput();
                    }

                    // Must be at least 5 years old on or before October 1
                    if ($birthday->diffInYears($cutoff, false) < 5) {
                        return back()->withErrors([
                            'applicant_bday' => 'Kinder and Grade 1 applicants must be at least 5 years old on or before October ' . now()->year . '.'
                        ])->withInput();
                    }
                }
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

        // Set applicant_id if available
        if ($applicant) {
            $allData['applicant_id'] = $applicant->id;
        }

        // Check if the applicant already has a submission
        $formSubmission = FillupForms::where('applicant_id', $applicant->id)->first();

        if ($formSubmission) {
            $formSubmission->update($allData);
        } else {
            FillupForms::create($allData);
        }

        //Update the Applicant current_step separately
        $applicant = Applicant::where('account_id', auth()->user()->id)->first();
        if ($applicant) {
            $applicant->current_step = 2;
            $applicant->save();
        }

        return redirect()->route('applicant.steps.payment.payment');
    }

    //----------------------------------------------------------------------------------------------//

    //returns view for recommender
    public function showRecommender()
{
    
    $topStrand = session('topStrand');
    return view('applicant.strand-recommender', compact('topStrand'));
}

    //logic for recommender, points and sub strand questions
    public function submitRecommender(Request $request)
            {
                $answers = $request->all();
                $score = [
                    'stem' => 0,
                    'abm' => 0,
                    'humss' => 0,
                    'sports' => 0,
                    'gas' => 0,
                ];

                // Loop through questions 1–20
                for ($i = 1; $i <= 20; $i++) {
                    $key = 'q' . $i;
                    $value = $answers[$key] ?? null;

                    
                    if (!$value) continue;

                    switch ($value) {
                        case 'stem':
                            $score['stem'] += 3;
                            break;
                        case 'abm':
                            $score['abm'] += 3;
                            break;
                        case 'humss':
                            $score['humss'] += 3;
                            break;
                        case 'sports':
                            $score['sports'] += 3;
                            break;
                        case 'gas':
                        case 'gas1':
                        case 'gas2':
                            $score['gas'] += 3;
                            break;
                        case 'stem_abm': 
                            $score['stem'] += 3;
                            $score['abm'] += 3;
                            break;
                        case 'other': 
                            $score['stem'] += 1;
                            $score['abm'] += 1;
                            $score['humss'] += 1;
                            $score['gas'] += 1;
                            $score['sports'] += 1;
                            break;
                    }
                }

                // Find the highest scoring strand
                arsort($score);
                $top = array_keys($score, max($score));
                $topStrand = strtoupper($top[0]);
                $finalStrand = $topStrand;

                // If STEM or ABM but subquestions not yet answered, balikan
                if (in_array($topStrand, ['STEM', 'ABM']) && (!isset($answers['q21']) || !isset($answers['q22']))) {
                return redirect()->route('strand.recommender')->with([
                        'recommended_strand' => $topStrand,
                        'topStrand' => $topStrand
                    ]);
}


                // Finalize strand with subquestion answers
                if ($topStrand === 'STEM') {
                    if ($answers['q21'] === 'engineering' || $answers['q22'] === 'engineering') {
                        $finalStrand = 'STEM Engineering';
                    } elseif ($answers['q21'] === 'health' || $answers['q22'] === 'health') {
                        $finalStrand = 'STEM Health Allied';
                    } elseif ($answers['q21'] === 'it' || $answers['q22'] === 'it') {
                        $finalStrand = 'STEM Information Technology';
                    }
                }

                if ($topStrand === 'ABM') {
                    if ($answers['q21'] === 'accounting' || $answers['q22'] === 'accounting') {
                        $finalStrand = 'ABM Accountancy';
                    } elseif ($answers['q21'] === 'management' || $answers['q22'] === 'management') {
                        $finalStrand = 'ABM Business Management';
                    }
                }

                // Store temporarily in session to prefill later
                session(['recommended_strand' => $finalStrand]);

                 // save sa db
                $applicant = Applicant::where('account_id', auth()->user()->id)->first();
                if ($applicant) {
                    $applicant->recommended_strand = $finalStrand;
                    $applicant->save();
                
                }

                return redirect()->route('applicantdashboard')->with('strand_recommendation', $finalStrand);


            }


            }
