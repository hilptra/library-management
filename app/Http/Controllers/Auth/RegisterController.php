<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20'
        ]); 

        $user = User::create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => Hash::make($validate['password']),
            'phone'=> $validate['phone'] ?? null,
            'role' => 'member',
        ]);

        Auth::login($user);

        return redirect('/member/dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang, ' . $user->name . '!');
    }
}
