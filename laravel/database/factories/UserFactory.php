<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Agency;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $agency = Agency::inRandomOrder()->first();

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'agency_id' => $agency ? $agency->agency_id : null,
        ];
    }
}
