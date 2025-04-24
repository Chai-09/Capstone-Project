<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $role = $user->role;

        switch ($role) {
            case 'administrator':
                return view('administrator.index');

            case 'applicant':
                return view('applicant.dashboard');

            case 'accounting':
                return view('accounting.dashboard');

            default:
                abort(403, 'Unauthorized role.');
        }
    }
}
