<?php

namespace Database\Factories;

use App\Models\ProgramFamily;
use App\Models\TripProgram;
use App\Models\Customer;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramFamilyFactory extends Factory
{
    protected $model = ProgramFamily::class;

    public function definition(): array
    {
        $adults   = $this->faker->numberBetween(1, 6);
        $children = $this->faker->numberBetween(0, 3);
        $infants  = $this->faker->numberBetween(0, 1);

        return [
            'trip_program_id' => TripProgram::inRandomOrder()->value('id') ?? TripProgram::factory(),

            // 50% chance to assign a customer, otherwise use group name
            'customer_id'     => $this->faker->boolean(50)
                ? (Customer::inRandomOrder()->value('id') ?? Customer::factory())
                : null,
            'group_name'      => $this->faker->boolean(50) ? strtoupper($this->faker->lexify('GROUP??')) : null,

            'adults'          => $adults,
            'children'        => $children,
            'infants'         => $infants,
            'hotel_id'        => Hotel::inRandomOrder()->value('id') ?? Hotel::factory(),
            'room_number'     => $this->faker->optional()->numerify('###'),
            'pickup_time'     => $this->faker->optional()->time('H:i'),
            'activity'        => $this->faker->randomElement(['SNK','DP','INTRO','FUN']),
            'size'            => $this->faker->randomElement(['S','M','L','XL']),
            'nationality'     => $this->faker->country(),
            'boat_master'     => $this->faker->name(),
            'guide_name'      => $this->faker->name(),
            'transfer_name'   => $this->faker->name(),
            'transfer_phone'  => $this->faker->optional()->phoneNumber(),

            'collect_egp'     => $this->faker->randomFloat(2, 0, 3000),
            'collect_usd'     => $this->faker->randomFloat(2, 0, 200),
            'collect_eur'     => $this->faker->randomFloat(2, 0, 150),

            'remarks'         => $this->faker->optional()->sentence(),
        ];
    }
}
