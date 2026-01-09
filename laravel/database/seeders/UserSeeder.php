<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Alapértelmezett admin felhasználó létrehozása
        User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'password', // a model automatikusan hash-eli
            'profile_photo' => null,
            'bio' => 'Ez az admin felhasználó.',
            'is_admin' => true,
        ]);

        // Több teszt felhasználó generálása factory-val
        User::factory()->count(10)->create();
    }
}
