<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ebook;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // // Admin 
        // User::create([
        //     'name' => 'Administrator',
        //     'email' => 'admin@example.com',
        //     'password' => Hash::make('admin1234#'),
        //     'role' => 'admin',
        // ]);

        // User
        User::create([
            'name' => 'Edward Elric',
            'email' => 'edward@example.com',
            'password' => Hash::make('user1234#$'),
            'role' => 'user',
        ]);

        // Categories and Ebooks
        Category::create([
            'name' => 'Science Fiction',
        ]);

        Ebook::factory(10)->create([
            'category_id' => 1, // Assuming the first category has ID 1
        ]);
    }
}
