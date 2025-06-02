<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Accounts;
use Illuminate\Support\Facades\Hash;

class AdminAccountController extends Controller
{
    public function index(Request $request)
    {
        $query = Accounts::query();

        if ($request->filled('role')) {
            $query->where('role', strtolower($request->role));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Sorting logic
        $sort = $request->input('sort', 'created_at'); // default sort by created_at
        $direction = $request->input('direction', 'desc'); // default direction

        if (in_array($sort, ['name', 'created_at']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        $accounts = $query->paginate(15)->appends($request->all());

        return view('administrator.dashboard', compact('accounts'));
    }

    public function edit($id)
    {
        $account = Accounts::findOrFail($id);

        // Split the name into first, middle, last
        $nameParts = explode(' ', $account->name);
        $first = $nameParts[0] ?? '';
        $middle = '';
        $last = '';

        if (count($nameParts) === 3) {
            $middle = $nameParts[1];
            $last = $nameParts[2];
        } elseif (count($nameParts) >= 2) {
            // No middle name
            $last = $nameParts[count($nameParts) - 1];
            $first = implode(' ', array_slice($nameParts, 0, -1));
        }

        return view('administrator.edit-account', compact('account', 'first', 'middle', 'last'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'applicant_fname' => 'nullable|string|max:255',
            'applicant_mname' => 'nullable|string|max:3',
            'applicant_lname' => 'nullable|string|max:255',
            'applicant_email' => 'nullable|email|unique:accounts,email,' . $id,
            'role' => 'nullable|string',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $account = Accounts::findOrFail($id);

        // Step 1: Normalize and uppercase individual names
        $first = strtoupper(trim($request->input('applicant_fname')));
        $middle = strtoupper(trim($request->input('applicant_mname')));
        $last = strtoupper(trim($request->input('applicant_lname')));

        // Step 2: Format middle name
        $middleFormatted = '';
        if ($middle) {
            if (strlen($middle) <= 2 && !str_ends_with($middle, '.')) {
                $middleFormatted = $middle . '.';
            } else {
                $middleFormatted = $middle;
            }
        }

        // Step 3: Combine full name for the `name` field
        $fullName = trim("{$first} {$middleFormatted} {$last}");
        $account->name = $fullName;

        // Step 4: Update email if provided
        if ($request->filled('applicant_email')) {
            $account->email = $request->applicant_email;
        }

        // Step 5: Handle role logic
        $originalRole = $account->role;
        if (strtolower($originalRole) === 'applicant') {
            $account->role = 'applicant';
        } else {
            $account->role = strtolower($request->role);
        }

        // Step 6: Hash password if provided
        if ($request->filled('password')) {
            $account->password = Hash::make($request->password);
        }

        $account->save();

        return redirect()->route('admindashboard')->with('success', 'Account updated successfully.');
    }

    public function destroy($id)
    {
        $account = Accounts::findOrFail($id);
        $account->delete();

        return redirect()->route('admindashboard')->with('success', 'Account deleted successfully.');
    }
}
