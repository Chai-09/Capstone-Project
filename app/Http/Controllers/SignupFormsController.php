<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use App\Models\Applicant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\SignupOtp;
use Carbon\Carbon;

class SignupFormsController extends Controller
{
    public function requestOtp(Request $request)
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
            // 'g-recaptcha-response' => 'required', comment out
        ], [
            'password.same' => 'Password do not match.',
        ]);

        #For verification of ReCaptcha from google  Comment out
        // $client = new \GuzzleHttp\Client();
        // $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
        //     'form_params' => [
        //         'secret' => config('services.recaptcha.secret_key'),
        //         'response' => $request->input('g-recaptcha-response'),
        //         'remoteip' => $request->ip(),


        //     ],
        // ]);
        // #JSON request to make sure the system parses the response
        // $body = json_decode((string) $response->getBody());

        // if (!$body->success) {
        //     return back()->withErrors(['g-recaptcha-response' => 'reCAPTCHA verification failed'])->withInput();
        // }


        // Generate ng random number for otp and store it
        $otp = rand(100000, 999999);
        SignupOtp::where('email', $request->guardian_email)->delete();

        SignupOtp::create([
            'email' => $request->guardian_email,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        // Sending otp via email (check blade emails for editing of view file pre)
        Mail::send('emails.email-signup-otp', ['otp' => $otp], function ($message) use ($request) {
            $message->to($request->guardian_email)->subject('Your ApplySmart OTP Code');
        });

        // Store form data in session
        $request->session()->put('signup_data', $request->except(['_token', 'g-recaptcha-response']));

        return redirect()->route('signup.showOtpForm');
    }

    public function showOtpForm(Request $request)
    {
        if (!$request->session()->has('signup_data')) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }

        return view('login.verify-otp');
    }

    //Split the two since dapat dipa muna masave sa db kahit tapos na mag verification, kasi may otp pa
    public function verifyOtpAndCreate(Request $request)
    {

        $data = $request->session()->get('signup_data');

        if (!$data) {
            return redirect()->route('login')->with('error', 'Session expired. Please try again.');
        }

        SignupOtp::where('expires_at', '<', now())->delete();

        $otpRecord = SignupOtp::where('email', $data['guardian_email'])
            ->where('otp', $request->otp)
            ->first();
            

        if (!$otpRecord) {
            return redirect()->back()->with('error', 'Invalid or expired OTP.');
        }

        $applicant = null;

        DB::transaction(function () use ($data, &$applicant) {
            // Format middle names with a period if not present
            $guardianMname = strtoupper($data['guardian_mname'] ?? '');
            if ($guardianMname && !str_ends_with($guardianMname, '.')) {
                $guardianMname .= '.';
            }

            $applicantMname = strtoupper($data['applicant_mname'] ?? '');
            if ($applicantMname && !str_ends_with($applicantMname, '.')) {
                $applicantMname .= '.';
            }

            // Create account for login
            $account = Accounts::create([
                'name' => strtoupper($data['guardian_fname']) . ' ' . $guardianMname . ' ' . strtoupper($data['guardian_lname']),
                'email' => $data['guardian_email'],
                'password' => Hash::make($data['password']),
                'role' => 'applicant',
            ]);

            // Create applicant details
            $applicant = Applicant::create([
                'account_id' => $account->id,
                'guardian_fname' => strtoupper($data['guardian_fname']),
                'guardian_mname' => $guardianMname,
                'guardian_lname' => strtoupper($data['guardian_lname']),
                'applicant_fname' => strtoupper($data['applicant_fname']),
                'applicant_mname' => $applicantMname,
                'applicant_lname' => strtoupper($data['applicant_lname']),
                'current_school' => strtoupper($data['current_school']),
                'incoming_grlvl' => strtoupper($data['incoming_grlvl']),
            ]);

            SignupOtp::where('email', $data['guardian_email'])->delete();
        });
        
        session(['applicant_id' => $applicant->id]);
        $request->session()->forget('signup_data');

        return redirect()->route('login')->with('success', 'Account created successfully!');
    }

    

    //resend otp logic
    //Hallo,ginawa ko nalang siyang error timer, instead of live countdown, para server mas secure since server side yung pag check niya
    public function resendOtp(Request $request)
    {
        $data = $request->session()->get('signup_data');

        if (!$data || !isset($data['guardian_email'])) {
            return redirect()->route('signup.showOtpForm')->withErrors(['Session expired. Please sign up again.']);
        }

        // Get the latest OTP sa server
        $lastOtp = SignupOtp::where('email', $data['guardian_email'])->latest()->first();

        // Check if less than 60s have passed if hindi babato siya ng error
        if ($lastOtp && Carbon::parse($lastOtp->created_at)->diffInSeconds(now()) < 60) {
            $secondsLeft = (int) max(0, 60 - Carbon::parse($lastOtp->created_at)->diffInSeconds(now()));
            return redirect()->back()->withErrors([
                "You're sending too fast. Try again in {$secondsLeft} second(s)."
            ]);
        }

        // Proceed to resend OTP
        SignupOtp::where('email', $data['guardian_email'])->delete();

        $otp = rand(100000, 999999);

        SignupOtp::create([
            'email' => $data['guardian_email'],
            'otp' => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        Mail::send('emails.email-signup-otp', ['otp' => $otp], function ($message) use ($data) {
            $message->to($data['guardian_email'])->subject('Your new ApplySmart OTP Code');
        });

        return redirect()->back()->with('success', 'A new OTP has been sent to your email.');
    }
}
