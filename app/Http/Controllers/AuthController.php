<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required',
        ]);

        // reCAPTCHA check
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
            Auth::login($account);
            session()->regenerate();
            session([
                'name' => $account->name,
                'email' => $account->email,
            ]);


            return match ($account->role) {
                'applicant' => redirect()->route('applicantdashboard'),
                'admission' => redirect()->route('admissiondashboard'),
                'accounting' => redirect()->route('accountingdashboard'),
                'administrator' => redirect()->route('admindashboard'),
                default => redirect()->route('login'),
            };
        }

        return back()->withErrors(['Invalid email or password']);
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'Logged out successfully.'); //kingina ginawa na pala to
    }

    
}
