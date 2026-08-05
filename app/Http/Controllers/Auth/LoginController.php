<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            if (Auth::user()->status === 'suspended') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akun Anda sedang ditangguhkan. Silakan hubungi Pustakawan.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/dashboard')->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
            }

            return redirect()->intended('/member/dashboard')->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau Password yang anda masukan salah',
        ])->onlyInput('email');
    }

    public function logout(Request $request) {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil keluar (logout).');
    }
}