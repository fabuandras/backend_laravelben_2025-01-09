<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1️⃣ Felhasználók
        User::factory()->create([
            'id'    => 1,
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Ha kell több user (pl. participates miatt)
        User::factory()->create([
            'id'    => 2,
            'name'  => 'Second User',
            'email' => 'second@example.com',
        ]);

        User::factory()->create([
            'id'    => 3,
            'name'  => 'Third User',
            'email' => 'third@example.com',
        ]);

        User::factory()->create([
            'id'    => 5,
            'name'  => 'Fifth User',
            'email' => 'fifth@example.com',
        ]);

        // 2️⃣ Események
        $this->call(EventSeeder::class);

        // 3️⃣ Részvételek (pivot)
        $this->call(ParticipateSeeder::class);
    }
}