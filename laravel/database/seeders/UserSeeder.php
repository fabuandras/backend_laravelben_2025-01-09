<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Agency;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $agency = Agency::first();

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'agency_id' => $agency ? $agency->agency_id : null,
        ]);

        User::factory()->count(5)->create([
            'agency_id' => $agency ? $agency->agency_id : null,
        ]);
    }
}
