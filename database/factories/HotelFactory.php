<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Hotel;

class HotelFactory extends Factory
{
    protected $model = Hotel::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . ' Hotel',
            'location' => $this->faker->city(),
            'stars' => $this->faker->numberBetween(3,5),
        ];
    }
}
