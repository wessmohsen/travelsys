<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Boat;

class BoatFactory extends Factory
{
    protected $model = Boat::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName() . ' Boat',
            'capacity' => $this->faker->numberBetween(10,100),
        ];
    }
}
