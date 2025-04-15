<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use App\Models\Applicant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SignupFormsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'guardian_fname' => 'required|max:64',
            'guardian_mname' => 'nullable|max:64',
            'guardian_lname' => 'required|max:64',
            'guardian_email' => 'required|email|unique:accounts,email',
            'password' => 'required|min:6|same:repassword',
            'repassword' => 'required',
            'applicant_fname' => 'required|max:64',
            'applicant_mname' => 'nullable|max:64',
            'applicant_lname' => 'required|max:64',
            'current_school' => 'required|max:255',
            'incoming_grlvl' => 'required|in:Kinder,Grade 1,Grade 2,Grade 3,Grade 4,Grade 5,Grade 6,Grade 7,Grade 8,Grade 9,Grade 10,Grade 11,Grade 12',
            'g-recaptcha-response' => 'required',
        ]);

        #For verification of ReCaptcha from google
        $client = new \GuzzleHttp\Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),


            ],
        ]);
        #JSON request to make sure the system parses the response
        $body = json_decode((string) $response->getBody());

        if (!$body->success) {

            return back()->withErrors(['g-recaptcha-response' => 'reCAPTCHA verification failed'])->withInput();
        }


        DB::transaction(function () use ($request) {
            // Create account for login
            $account = Accounts::create([
                'name' => $request->guardian_fname . ' ' . $request->guardian_mname . ' ' . $request->guardian_lname,
                'email' => $request->guardian_email,
                'password' => Hash::make($request->password),
                'role' => 'applicant',
            ]);

            // Create applicant details
            Applicant::create([
                'account_id' => $account->id,
                'guardian_fname' => $request->guardian_fname,
                'guardian_mname' => $request->guardian_mname ?? '',
                'guardian_lname' => $request->guardian_lname,
                'applicant_fname' => $request->applicant_fname,
                'applicant_mname' => $request->applicant_mname ?? '',
                'applicant_lname' => $request->applicant_lname,
                'current_school' => $request->current_school,
                'incoming_grlvl' => $request->incoming_grlvl,
            ]);
        });

        return redirect()->route('login')->with('success', 'Account created successfully!');
    }
}
