<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TripFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'location' => $this->faker->city(),
            'price' => $this->faker->randomFloat(2, 50, 1000),
        ];
    }
}
