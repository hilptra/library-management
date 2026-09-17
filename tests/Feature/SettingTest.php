<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_and_update_settings(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
        ]);

        Setting::set('fine_per_day', 1000);
        Setting::set('loan_duration_days', 7);
        Setting::set('max_active_loans', 3);

        $response = $this->actingAs($admin)->get(route('admin.settings.index'));
        $response->assertStatus(200);
        $response->assertSee('Pengaturan Sistem');
        $response->assertSee('fine_per_day');

        $updateResponse = $this->actingAs($admin)->patch(route('admin.settings.update'), [
            'fine_per_day' => 2000,
            'loan_duration_days' => 14,
            'max_active_loans' => 5,
        ]);

        $updateResponse->assertRedirect();
        $updateResponse->assertSessionHas('success');

        $this->assertEquals('2000', Setting::get('fine_per_day'));
        $this->assertEquals('14', Setting::get('loan_duration_days'));
        $this->assertEquals('5', Setting::get('max_active_loans'));
    }
}
