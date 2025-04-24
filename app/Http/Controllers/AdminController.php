<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Accounts;

class AdminController extends Controller
{
    public function createAccount(Request $request)
    {
        $validated = $request->validate([
            'applicant_fname' => 'required|string|max:255',
            'applicant_mname' => 'nullable|string|max:255',
            'applicant_lname' => 'required|string|max:255',
            'applicant_email' => 'required|email|unique:accounts,email',
            'role' => 'required|in:Administrator,Admission,Accounting',
            'password' => 'required|min:6|confirmed',
        ]);

        Accounts::create([
            'name' => strtoupper($request->applicant_fname . ' ' . $request->applicant_mname . '.' . ' ' . $request->applicant_lname),
            'email' => $request->applicant_email,
            'password' => Hash::make($request->password),
            'role' => strtolower($request->role),
        ]);

        return redirect()->route('admindashboard')->with('success', 'Account created successfully.');

    }
}
