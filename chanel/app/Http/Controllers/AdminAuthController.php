<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.index');
        }
        return view('admin.login');
    }

    public function login(Request $req)
    {
        $creds = $req->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($creds)) {
            if (Auth::user()->role === 'admin') {
                $req->session()->regenerate();
                return redirect()->route('admin.index');
            } else {
                Auth::logout();
                return back()->with('error', 'You are not authorized to access admin panel.');
            }
        }

        return back()->with('error', 'Invalid credentials.');
    }

    public function logout(Request $req)
    {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
