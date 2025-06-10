<?php

namespace App\Http\Controllers\API\ForgotPassword;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Accounts;

class MobileFPController extends Controller
{
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $account = Accounts::where('email', $request->email)->first();

        if (!$account) {
            return response()->json(['message' => 'No account found for that email.'], 404);
        }

        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        $resetLink = "http://localhost:8081/auth/resetpassword?email={$request->email}&token={$token}";



        try {
            Mail::send('emails.mobile-reset-password', ['link' => $resetLink], function ($message) use ($request) {

                $message->to($request->email)->subject('Reset your ApplySmart Password');
            });
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send email.', 'error' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Reset link has been sent to your email.']);
    }
}
