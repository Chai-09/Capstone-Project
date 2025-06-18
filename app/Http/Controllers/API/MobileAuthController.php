<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Accounts;
use App\Models\Applicant;
use App\Models\SignupOtp;
use Carbon\Carbon;

class MobileAuthController extends Controller
{
    public function login(Request $request)
    {

        // Add this at the start of login method
\Log::info('Login Request:', [
    'email' => $request->email,
    'has_recaptcha_token' => !empty($request->input('g-recaptcha-response')),
    'token_length' => strlen($request->input('g-recaptcha-response') ?? '')
]);
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required|string',
        ]);
    
        // reCAPTCHA validation
        $client = new \GuzzleHttp\Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ],
        ]);
    
        
        $body = json_decode((string) $response->getBody(), true);

        // Add this right after the Google API call
\Log::info('reCAPTCHA Response:', [
    'success' => $body['success'] ?? 'missing',
    'error-codes' => $body['error-codes'] ?? 'none',
    'full_body' => $body
]);
    
        if (!$body['success']) {
            return response()->json(['message' => 'reCAPTCHA verification failed'], 400);
        }
    
        $user = Accounts::where('email', $request->email)->first();
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    
        if ($user->role !== 'applicant') {
            return response()->json(['message' => 'Unauthorized role'], 403);
        }
    
        $token = $user->createToken('mobile-token')->plainTextToken;
        $applicant = Applicant::where('account_id', $user->id)->first();
    
        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'step' => $applicant?->current_step ?? 1
        ]);
    }
    
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
        ], [
            'password.same' => 'Passwords do not match.',
        ]);

        $otp = rand(100000, 999999);

        SignupOtp::where('email', $request->guardian_email)->delete();

        SignupOtp::create([
            'email' => $request->guardian_email,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        Mail::send('emails.email-signup-otp', ['otp' => $otp], function ($message) use ($request) {
            $message->to($request->guardian_email)->subject('Your ApplySmart OTP Code');
        });

        return response()->json(['message' => 'OTP sent to email']);
    }

    public function verifyOtpAndRegister(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
            'guardian_email' => 'required|email',
            'guardian_fname' => 'required|max:64',
            'guardian_mname' => 'nullable|max:64',
            'guardian_lname' => 'required|max:64',
            'password' => 'required|min:6',
            'applicant_fname' => 'required|max:64',
            'applicant_mname' => 'nullable|max:64',
            'applicant_lname' => 'required|max:64',
            'current_school' => 'required|max:255',
            'incoming_grlvl' => 'required|in:Kinder,Grade 1,Grade 2,Grade 3,Grade 4,Grade 5,Grade 6,Grade 7,Grade 8,Grade 9,Grade 10,Grade 11,Grade 12',
        ]);

        SignupOtp::where('expires_at', '<', now())->delete();

        $otpRecord = SignupOtp::where('email', $request->guardian_email)
            ->where('otp', $request->otp)
            ->first();

        if (!$otpRecord) {
            return response()->json(['message' => 'Invalid or expired OTP'], 401);
        }

        $guardianMname = strtoupper($request->guardian_mname ?? '');
        if ($guardianMname && !str_ends_with($guardianMname, '.')) {
            $guardianMname .= '.';
        }

        $applicantMname = strtoupper($request->applicant_mname ?? '');
        if ($applicantMname && !str_ends_with($applicantMname, '.')) {
            $applicantMname .= '.';
        }

        $account = Accounts::create([
            'name' => strtoupper($request->guardian_fname) . ' ' . $guardianMname . ' ' . strtoupper($request->guardian_lname),
            'email' => $request->guardian_email,
            'password' => \Hash::make($request->password),
            'role' => 'applicant',
        ]);

        $applicant = Applicant::create([
            'account_id' => $account->id,
            'guardian_fname' => strtoupper($request->guardian_fname),
            'guardian_mname' => $guardianMname,
            'guardian_lname' => strtoupper($request->guardian_lname),
            'applicant_fname' => strtoupper($request->applicant_fname),
            'applicant_mname' => $applicantMname,
            'applicant_lname' => strtoupper($request->applicant_lname),
            'current_school' => strtoupper($request->current_school),
            'incoming_grlvl' => strtoupper($request->incoming_grlvl),
        ]);

        SignupOtp::where('email', $request->guardian_email)->delete();

        return response()->json([
            'message' => 'Account created successfully!',
            'user' => [
                'id' => $account->id,
                'name' => $account->name,
                'email' => $account->email,
                'role' => $account->role,
            ],
            'step' => 1
        ]);
    }

  


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

      public function resendOtpMobile(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $email = $request->email;

    $lastOtp = SignupOtp::where('email', $email)->latest()->first();

    if ($lastOtp && Carbon::parse($lastOtp->created_at)->diffInSeconds(now()) < 60) {
        $secondsLeft = 60 - Carbon::parse($lastOtp->created_at)->diffInSeconds(now());
        return response()->json([
            'status' => 'error',
            'message' => "Please wait {$secondsLeft} second(s) before requesting a new OTP."
        ], 429);
    }

    SignupOtp::where('email', $email)->delete();

    $otp = rand(100000, 999999);

    SignupOtp::create([
        'email' => $email,
        'otp' => $otp,
        'expires_at' => now()->addMinutes(5),
    ]);

    Mail::send('emails.email-signup-otp', ['otp' => $otp], function ($message) use ($email) {
        $message->to($email)->subject('Your new ApplySmart OTP Code');
    });

    return response()->json([
        'status' => 'success',
        'message' => 'A new OTP has been sent to your email.'
    ]);
}
}
