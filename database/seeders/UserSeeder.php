<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'phone' => '08123456789',
            ]
        );

        User::firstOrCreate(
            ['email' => 'member@gmail.com'],
            [
                'name' => 'Member',
                'password' => Hash::make('password'),
                'role' => 'member',
                'phone' => '089123456789',
            ]
        );
    }
}