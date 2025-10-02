<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vehicle;

class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['Car','Bus','Van']),
            'plate_number' => strtoupper($this->faker->bothify('??-####')),
            'capacity' => $this->faker->numberBetween(4,50),
        ];
    }
}
