<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert([
            [
                'event_id'  => 1,
                'name'      => 'Tavaszi kampányindító',
                'agency_id' => 1,
                'limit'     => 50,
                'date'      => '2026-03-15',
                'location'  => 'Budapest',
                'status'    => 1,
            ],
            [
                'event_id'  => 2,
                'name'      => 'Ügynökségi workshop',
                'agency_id' => 1,
                'limit'     => 30,
                'date'      => '2026-04-02',
                'location'  => 'Debrecen',
                'status'    => 1,
            ],
            [
                'event_id'  => 3,
                'name'      => 'Évértékelő meeting',
                'agency_id' => 2,
                'limit'     => 20,
                'date'      => '2026-01-20',
                'location'  => 'Szeged',
                'status'    => 0,
            ],
        ]);
    }
}