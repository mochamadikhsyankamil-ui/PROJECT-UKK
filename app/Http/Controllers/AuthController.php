<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'password.required' => 'password harus diisi',
            'email.required' => 'email harus diisi',
            'email.email' => 'format email tidak valid',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin');
            } elseif (in_array(Auth::user()->role, ['operator', 'staff'])) {
                return redirect()->route('operator');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'failed' => 'Gagal login, silahkan cek dan coba lagi!',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
