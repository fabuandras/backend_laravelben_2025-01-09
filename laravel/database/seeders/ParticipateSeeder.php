<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Participate;

class ParticipateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('participates')->insert([
            [
                'event_id' => 1,
                'user_id'  => 1,
                'present'  => true,
            ],
            [
                'event_id' => 1,
                'user_id'  => 2,
                'present'  => false,
            ],
            [
                'event_id' => 2,
                'user_id'  => 1,
                'present'  => true,
            ],
            [
                'event_id' => 2,
                'user_id'  => 3,
                'present'  => true,
            ],
        ]);

        Participate::factory()->create([
            'event_id' => 2,
            'user_id'  => 5,
            'present'  => true,
        ]);
    }
}