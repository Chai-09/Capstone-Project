<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function showForm(){
        return view('login');
    }

    public function store(Request $request){
        $request->validate([
            'email'=>'required|email|unique:accounts,email',
            'password'=>'required|min:6',
        ]);

        Accounts::create([
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);

        return redirect()->route('accounts.list');
    }

    public function index(){
        $accounts = Accounts::all();
        return view('accounts',compact('accounts'));
    }
}
