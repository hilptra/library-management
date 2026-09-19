<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function index() {
        return view('member.profile.index');
    }

    public function edit() {
        return view('member.profile.edit');
    }

    public function update(Request $request) {

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);
        
        Auth::user()->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        return redirect()->route('member.profile.index')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request) {
        
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed'
        ]);

        Auth::user()->update([
            'password' => bcrypt($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah');
    }
}
