<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DivingCourse;

class DivingCourseFactory extends Factory
{
    protected $model = DivingCourse::class;

    public function definition(): array
    {
        return [
            'title' => 'Course ' . $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
