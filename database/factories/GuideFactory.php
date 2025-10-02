<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Guide;

class GuideFactory extends Factory
{
    protected $model = Guide::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'language' => $this->faker->randomElement(['English','Arabic','French','German']),
        ];
    }
}
