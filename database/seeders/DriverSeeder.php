<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $driverNames = [
            'Mostafa El-Masry',
            'Hazem Mohamed',
            'Fady Magdy',
            'Ezzat Reda',
            'Mido Youssef',
            'Adel Fawzy',
            'Basel Hany',
            'Marwan Emad',
            'Ihab Nour',
            'Ahmed Galal',
            'Karim Lotfy',
            'Sherif Hany',
            'Osama Ragab',
        ];

        foreach ($driverNames as $driverName) {
            Driver::create([
                'name' => $driverName,
                'license_number' => strtoupper(fake()->bothify('???-####')),
                'phone' => fake()->optional(0.9)->phoneNumber(),
                'alternative_phone' => fake()->optional(0.5)->phoneNumber(),
                'address' => fake()->optional(0.8)->address(),
            ]);
        }
    }
}
