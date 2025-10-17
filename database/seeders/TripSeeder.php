<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trip;

class TripSeeder extends Seeder
{
    public function run(): void
    {
        $trips = [
            [
                'name' => 'Sharm Eluli',
                'location' => 'Red Sea',
                'price' => 150.00,
            ],
            [
                'name' => 'Sataya',
                'location' => 'Red Sea',
                'price' => 180.00,
            ],
            [
                'name' => 'Marsa Mobarak',
                'location' => 'Red Sea',
                'price' => 160.00,
            ],
            [
                'name' => 'Coral Garden',
                'location' => 'Red Sea',
                'price' => 140.00,
            ],
            [
                'name' => 'Dolphin House',
                'location' => 'Red Sea',
                'price' => 170.00,
            ],
            [
                'name' => 'Shore Dive',
                'location' => 'Red Sea',
                'price' => 100.00,
            ],
            [
                'name' => 'Hamata',
                'location' => 'Red Sea',
                'price' => 200.00,
            ],
        ];

        foreach ($trips as $trip) {
            Trip::firstOrCreate(
                ['name' => $trip['name']],
                $trip
            );
        }
    }
}
