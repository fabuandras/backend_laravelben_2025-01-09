<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agency;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 10 random agencies
        Agency::factory()->count(10)->create();

        // Példa konkrét agency
        Agency::create([
            'name' => 'Global Agency',
            'country' => 'Hungary',
            'type' => 'A',
        ]);
    }
}
