<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            ['name' => 'Fiksi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Non-Fiksi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sains', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Teknologi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sejarah', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Biografi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sastra', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Anak-anak', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Remaja', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pendidikan', 'created_at' => now(), 'updated_at' => now()],
        ]);
        // Category::create(['name' => 'Fiksi']);
        // Category::create(['name' => 'Non-Fiksi']);
        // Category::create(['name' => 'Sains']);
        // Category::create(['name' => 'Teknologi']);
        // Category::create(['name' => 'Sejarah']);
        // Category::create(['name' => 'Biografi']);
        // Category::create(['name' => 'Sastra']);
        // Category::create(['name' => 'Anak-anak']);
        // Category::create(['name' => 'Remaja']);
        // Category::create(['name' => 'Pendidikan']);
    }
}
