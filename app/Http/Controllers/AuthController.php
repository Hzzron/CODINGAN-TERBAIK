<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    //
    public function showLogin()
    {

        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth::attempt($credentials)) {
            $user=auth::user();

            if($user->role==='admin'){
                return redirect()->intended('/admin/dashboard');
            }else{
                return redirect()->intended('/customer/dashboard');
            }
        }
        return back()->withErrors([
            'email' => 'Do not match our record, Ngaco Ah.',
        ])->onlyInput('email');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
