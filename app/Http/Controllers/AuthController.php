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
        ]);

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
