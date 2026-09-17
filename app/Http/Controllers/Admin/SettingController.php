<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {

        $settings = [
            'fine_per_day' => Setting::get('fine_per_day', 1000),
            'loan_duration_days' => Setting::get('loan_duration_days', 7),
            'max_active_loans' => Setting::get('max_active_loans', 3),
        ];

        return view('admin.setting.index', compact('settings'));
    }

    public function update(Request $request)
    {

        $request->validate([
            'fine_per_day' => 'required|integer|min:0',
            'loan_duration_days' => 'required|integer|min:1',
            'max_active_loans' => 'required|integer|min:1',
        ]);

        Setting::set('fine_per_day', $request->fine_per_day);
        Setting::set('loan_duration_days', $request->loan_duration_days);
        Setting::set('max_active_loans', $request->max_active_loans);

        return back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
