<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_login_successfully(): void
    {
        $response = $this->post('/register', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'phone' => '08123456789',
        ]);

        $response->assertRedirect('/member/dashboard');
        $this->assertAuthenticated();

        // Logout
        $this->post('/logout');
        $this->assertGuest();

        // Try logging in with the same password
        $loginResponse = $this->post('/login', [
            'email' => 'budi@example.com',
            'password' => 'secret123',
        ]);

        $loginResponse->assertRedirect('/member/dashboard');
        $this->assertAuthenticated();
    }
}
