<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $isRescheduling = false;
    
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required',
        ]);

        // reCAPTCHA 
        $client = new \GuzzleHttp\Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ],
        ]);

        $body = json_decode((string) $response->getBody());

        if (!$body->success) {
            return back()->withErrors(['g-recaptcha-response' => 'reCAPTCHA verification failed'])->withInput();
        }

        $account = Accounts::where('email', $request->email)->first();

        if ($account && Hash::check($request->password, $account->password)) {
            if ($account->is_archive === 'yes') {
                return back()->with('archive_error', 'Your account has been disabled.');
            }
        
            Auth::login($account);
            session()->regenerate();
            session([
                'name' => $account->name,
                'email' => $account->email,
                'role' => $account->role,
            ]);
        
            return match ($account->role) {
                'applicant' => $this->redirectApplicantBasedOnStep(),
                'admission' => redirect()->route('admissiondashboard'),
                'accounting' => redirect()->route('accountingdashboard'),
                'administrator' => redirect()->route('admindashboard'),
                default => redirect()->route('login'),
            };
        }
        

        return back()->withErrors(['Invalid email or password']);
    }

    //New function to control where applicant will go depending on stored step in fillupforms
    public function redirectApplicantBasedOnStep()
    {
        $applicant = \App\Models\Applicant::where('account_id', Auth::user()->id)->first();

        if ($applicant) {
            if ($applicant->current_step == 1) {
                return redirect()->route('applicantdashboard');
            } elseif ($applicant->current_step == 2) {
                return redirect()->route('applicant.steps.payment.payment');
            } elseif ($applicant->current_step == 3) {
                return redirect()->route('payment.verification');
            } elseif ($applicant->current_step == 4) {
                return redirect()->route('applicant.examdates');
            } elseif ($applicant->current_step == 5) {
                return redirect()->route('reminders.view');
            } elseif ($applicant->current_step == 6) {
                return redirect()->route('applicant.exam.result');              
            } elseif ($applicant->current_step == 7) {
                return redirect()->route('applicant.exam.result');
            }
    }

        return view('applicant.index', compact('formSubmission', 'readOnly'));

        // if wala pa form submission step 1 
        return redirect()->route('applicantdashboard');
    }

    public function logout()
    {
        session()->flush();

        // This flag tells login page to clear localStorage
        return redirect()->route('login')->with('just_logged_out', true);
    }



    public function showLoginPage()
    {
        session()->put('show_college_modal', true); // trigger the modal only initially
        return view('login.index');
    }

}
