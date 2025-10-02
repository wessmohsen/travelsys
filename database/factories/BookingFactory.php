<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Trip;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'trip_id' => Trip::factory(),
            'date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'status' => $this->faker->randomElement(['pending','confirmed','cancelled']),
            'price' => $this->faker->randomFloat(2, 100, 2000),
        ];
    }
}
