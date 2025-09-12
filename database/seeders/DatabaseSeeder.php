<?php

namespace Database\Seeders;

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

        // Admin 
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin1234#'),
            'role' => 'admin',
        ]);

        // User
        User::create([
            'name' => 'Edward Elric',
            'email' => 'edward@example.com',
            'password' => Hash::make('user1234#$'),
            'role' => 'user',
        ]);
    }
}
