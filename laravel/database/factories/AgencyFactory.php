<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Agency;

class AgencyFactory extends Factory
{
    protected $model = Agency::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'country' => $this->faker->country,
            'type' => $this->faker->randomElement(['A','B','C']),
        ];
    }
}
