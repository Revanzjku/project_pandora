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
            'first_name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin1234#'),
            'role' => 'admin',
        ]);

        // User
        User::create([
            'first_name' => 'Edward',
            'last_name' => 'Erlic',
            'username' => 'mank_edward',
            'bio' => 'Alchemy Star',
            'email' => 'edward@example.com',
            'password' => Hash::make('user1234#$'),
            'role' => 'user',
        ]);
    }
}
