<?php

namespace Database\Factories;

use App\Models\TripProgram;
use App\Models\Trip;
use App\Models\Agency;
use App\Models\Guide;
use App\Models\Boat;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripProgramFactory extends Factory
{
    protected $model = TripProgram::class;

    public function definition(): array
    {
        return [
            'trip_id' => Trip::inRandomOrder()->first()?->id ?? Trip::factory(),
            'date' => $this->faker->date(),
            'organizer_id' => \App\Models\User::factory(),
            'remarks' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['draft', 'confirmed', 'done']),
        ];
    }
}
