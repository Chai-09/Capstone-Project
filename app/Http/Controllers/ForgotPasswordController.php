<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Accounts;

class ForgotPasswordController extends Controller
{
    public function showForm()
    {
        return view('login.forgot-password');
    }
        // sending of reset link to user
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $account = Accounts::where('email', $request->email)->first();
        //if gmail account is not found in database, an error will be given
        if (!$account) {
            return back()->withErrors(['email' => 'No account found for that email.']);
        }
        //random number for token
        $token = Str::random(64);
        //inserting the email and token into database
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        $resetLink = route('password.reset', $token);

        Mail::send('emails.email-reset-password', ['link' => $resetLink], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset your ApplySmart Password');
        });

        return back()->with('success', 'Reset link has been sent to your email.');
    }

    public function showResetForm($token)
{
    //remove expired tokens, older than 10 mins
    DB::table('password_resets')
        ->where('created_at', '<', now()->subMinutes(10))
        ->delete();
    
    //find token in database 
    $reset = DB::table('password_resets')->where('token', $token)->first();

    // if hindi nahanap so token/expired/already used
    if (!$reset) {
        return redirect()->route('password.request')
            ->with('error', 'This password reset link is invalid or has expired.');
    }

    return view('login.reset-password', [
        'token' => $token,
        'email' => $reset ? $reset->email : ''
    ]);
}


    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);
        
        //same lang remove expired tokens older than 10 mins
        DB::table('password_resets')
        ->where('created_at', '<', now()->subMinutes(10))
        ->delete();

        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->withErrors(['email' => 'Invalid or expired token. Please request a new reset link']);
        }
        //saving and hashing new password to database
        $account = Accounts::where('email', $request->email)->first();
        $account->password = Hash::make($request->password);
        $account->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password has been reset. You can now log in.');
    }
}

