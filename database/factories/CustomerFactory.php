<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'dob' => $this->faker->date('Y-m-d', '2005-01-01'), // عمر أقل من 20 سنة مش هيطلع
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'phone' => $this->faker->phoneNumber(),
            'passport_number' => strtoupper($this->faker->bothify('??######')),
            'passport_nationality' => $this->faker->country(),
            'passport_valid_until' => $this->faker->dateTimeBetween('now', '+10 years'),
            'languages' => implode(', ', $this->faker->randomElements(
                ['English', 'French', 'German', 'Spanish', 'Arabic'],
                rand(1, 3)
            )),
            'dive_center_checkin' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'dive_center_checkout' => $this->faker->dateTimeBetween('now', '+1 year'),
            'next_flight_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'vegetarian' => $this->faker->boolean(20), // 20% يكون vegetarian
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'zipcode' => $this->faker->postcode(),
            'country' => $this->faker->country(),
            'additional_info' => $this->faker->sentence(10),
        ];
    }
}
