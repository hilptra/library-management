<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::updateOrCreate(['key' => 'fine_per_day'], ['value' => '1000']);
        Setting::updateOrCreate(['key' => 'loan_duration_days'], ['value' => '7']);
        Setting::updateOrCreate(['key' => 'max_active_loans'], ['value' => '3']);
    }
}
