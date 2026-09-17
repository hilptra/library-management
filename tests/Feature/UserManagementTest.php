<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_and_search_members(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
        ]);

        $member1 = User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'phone' => '08123456789',
            'role' => 'member',
            'status' => 'active',
        ]);

        $member2 = User::factory()->create([
            'name' => 'Siti Aminah',
            'email' => 'siti@gmail.com',
            'phone' => '08987654321',
            'role' => 'member',
            'status' => 'suspended',
        ]);

        // Test searching by name
        $response = $this->actingAs($admin)->get(route('admin.users.index', ['search' => 'Budi']));
        $response->assertStatus(200);
        $response->assertSee('Budi Santoso');
        $response->assertDontSee('Siti Aminah');

        // Test filtering by status
        $responseFilter = $this->actingAs($admin)->get(route('admin.users.index', ['status' => 'suspended']));
        $responseFilter->assertStatus(200);
        $responseFilter->assertSee('Siti Aminah');
        $responseFilter->assertDontSee('Budi Santoso');
    }
}
