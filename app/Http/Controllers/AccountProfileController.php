<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Accounts;

class AccountProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $nameParts = explode(' ', $user->name);

        $first = $nameParts[0] ?? '';
        $middle = '';
        $last = '';

        if (count($nameParts) === 3) {
            $middle = $nameParts[1];
            $last = $nameParts[2];
        } elseif (count($nameParts) >= 2) {
            $last = array_pop($nameParts);
            $first = implode(' ', $nameParts);
        }

        return view('partials.account-profile', compact('user', 'first', 'middle', 'last'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:3',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:accounts,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Normalize
        $first = strtoupper(trim($request->input('first_name')));
        $middle = strtoupper(trim($request->input('middle_name')));
        $last = strtoupper(trim($request->input('last_name')));

        // Format middle name
        $middleFormatted = '';
        if ($middle) {
            if (strlen($middle) <= 2 && !str_ends_with($middle, '.')) {
                $middleFormatted = $middle . '.';
            } else {
                $middleFormatted = $middle;
            }
        }

        // Full name format
        $fullName = trim("{$first} {$middleFormatted} {$last}");

        // Update user
        $user->name = $fullName;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
