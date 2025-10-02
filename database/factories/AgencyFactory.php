<?php

namespace Database\Factories;

use App\Models\Agency;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgencyFactory extends Factory
{
    protected $model = Agency::class;

    public function definition(): array
    {
        return [
            'name'       => $this->faker->company(),
            'email'      => $this->faker->unique()->companyEmail(),
            'phone'      => $this->faker->phoneNumber(),
            'tax_number' => $this->faker->bothify('TAX-####'),
            'is_partner' => $this->faker->boolean(50),

            // Address
            'street'  => $this->faker->streetName(),
            'number'  => $this->faker->buildingNumber(),
            'zipcode' => $this->faker->postcode(),
            'city'    => $this->faker->city(),
            'state'   => $this->faker->state(),
            'country' => $this->faker->country(),

            'notes' => $this->faker->sentence(10),
        ];
    }
}
