<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

         if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
         } else {
            return redirect()->route('login')->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ]);
         }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
