<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Accounts;

class AdminAccountController extends Controller
{
    public function index()
    {
        $accounts = Accounts::select('id', 'name', 'email', 'role')->get();
        return view('administrator.index', compact('accounts'));
    }


}
