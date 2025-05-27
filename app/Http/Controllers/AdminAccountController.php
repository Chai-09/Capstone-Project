<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Accounts;

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

        return view('administrator.index', compact('accounts'));
    }


    public function edit($id)
    {
        $account = Accounts::findOrFail($id);
        return view('administrator.edit-account', compact('account'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'applicant_fname' => 'nullable|string|max:255',
        'applicant_mname' => 'nullable|string|max:255',
        'applicant_lname' => 'nullable|string|max:255',
        'applicant_email' => 'nullable|email|unique:accounts,email,' . $id,
        'role' => 'nullable|string',
        'password' => 'nullable|min:6|confirmed',
    ]);

    $account = Accounts::findOrFail($id);

    $fullName = strtoupper($request->applicant_fname . ' ' .
                ($request->applicant_mname ? $request->applicant_mname . '.' : '') . ' ' .
                $request->applicant_lname);

    $account->name = $fullName;

    if ($request->filled('applicant_email')) {
        $account->email = $request->applicant_email;
    }

    $originalRole = $account->role; // keep old role

    if (strtolower($originalRole) === 'applicant') {
        $account->role = 'applicant';
    } else {
        $account->role = strtolower($request->role);
    }

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
