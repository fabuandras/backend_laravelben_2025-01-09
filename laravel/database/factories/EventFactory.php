<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'      => fake()->sentence(3),
            'agency_id' => fake()->numberBetween(1, 3),
            'limit'     => fake()->numberBetween(10, 100),
            'date'      => fake()->date(),
            'location'  => fake()->city(),
            'status'    => fake()->numberBetween(0, 1),
        ];
    }
}