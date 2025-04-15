<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guardian;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required',
        ]);
            #For verification of ReCaptcha from google
        $client = new \GuzzleHttp\Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                    'secret' => config('services.recaptcha.secret_key'),
                    'response' => $request ->input('g-recaptcha-response'),
                    'remoteip' => $request->ip(),


                ],
            ]);
                #JSON request to make sure the system parses the response
            $body = json_decode((string) $response->getBody());

            if (!$body->success) {

                return back()->withErrors(['g-recaptcha-response' => 'reCAPTCHA verification failed'])->withInput();

            }

        $guardian = Guardian::where('guardian_email', $request->email)->first();

        if ($guardian && Hash::check($request->password, $guardian->password)) {
            session(['guardian_id' => $guardian->id]);
            return redirect()->route('applicantdashboard')->with('success', 'Login successful!');
        } else {
            return back()->withErrors(['Invalid email or password']);
        }
    }

    public function logout()
    {
        session()->forget('guardian_id');
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }


}
