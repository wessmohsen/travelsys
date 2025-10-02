<?php

namespace Database\Factories;

use App\Models\TransferContract;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Agency;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransferContractFactory extends Factory
{
    protected $model = TransferContract::class;

    public function definition(): array
    {
        return [
            'driver_id' => Driver::inRandomOrder()->value('id'),
            'vehicle_id' => Vehicle::inRandomOrder()->value('id'),
            'company_name' => $this->faker->companyName(),
            'from' => $this->faker->city(),
            'to' => $this->faker->city(),
            'contract_type' => $this->faker->randomElement(['driver', 'company']),
            'contract_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'notes' => $this->faker->sentence(),
        ];
    }
}
