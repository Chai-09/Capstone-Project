<?php

namespace App\Http\Controllers\API\ResetPassword;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Accounts;

class MobileResetController extends Controller
{
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|min:6|confirmed',
        ]);

        // Remove expired tokens (older than 10 mins)
        DB::table('password_resets')->where('created_at', '<', now()->subMinutes(10))->delete();

        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return response()->json(['message' => 'Invalid or expired token. Please request a new one.'], 400);
        }

        $account = Accounts::where('email', $request->email)->first();

        if (!$account) {
            return response()->json(['message' => 'Account not found.'], 404);
        }

        $account->password = Hash::make($request->password);
        $account->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Password has been reset successfully.']);
    }
}
