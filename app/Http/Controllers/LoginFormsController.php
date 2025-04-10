<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SignupForms;
use Illuminate\Support\Facades\Hash;

class LoginFormsController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'email'=>'required|email|unique:accounts,email',
            'password'=>'required|min:6',
        ]);

        SignupForms::create([
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);

        return redirect()->route('accounts.list');
    }
}
