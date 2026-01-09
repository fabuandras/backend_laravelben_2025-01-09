<?php

namespace Database\Factories;

use App\Models\Participate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Participate>
 */
class ParticipateFactory extends Factory
{
    protected $model = Participate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => 1,
            'user_id'  => fake()->numberBetween(1, 10),
            'present'  => fake()->boolean(),
        ];
    }
}