<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;
use Illuminate\Support\Facades\DB;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hotelNames = [
            'Utopia Beach Club',
            'Sataya Resort Marsa Alam',
            'Malikia Resort Abu Dabbab',
            'Royal Brayka Beach Resort',
            'Gemma Resort Marsa Alam',
            'Fantazia Resort Marsa Alam',
            'Elphistone Resort Marsa Alam',
            'Coraya Bay Resorts',
            'Jaz Grand Marsa',
            'Beach Safari Nubian Resort',
            'Dream Lagoon Resort & Aqua Park',
            'Royal Tulip Beach Resort',
            'Three Corners Fayrouz Plaza Beach Resort',
            'Hilton Marsa Alam Nubian Resort',
            'The Palace Port Ghalib Resort',
            'Portofino Resort Marsa Alam',
            'Alexander the Great Hotel – Marsa Alam',
            'Utopia Blue Resort ( El Quseir Area )',
            'Gorgonia Beach Resort',
            'Wadi Lahmy Azul Resort',
            'Pickalbatros Sea World Resort Marsa Alam',
            'Concorde Moreen Beach Resort & Spa',
            'LTI Akassia Beach Resort',
            'Brayka Bay Resort',
            'Sentido Akassia Beach Resort',
            'Resta Reef Resort Marsa Alam',
            'Novotel Marsa Alam Resort',
            'Shams Alam Beach Resort',
            'Marina Resort Port Ghalib',
            'Steigenberger Coraya Beach',
            'Sea Beach Resort',
            'Resta Grand',
            'Equinox Resort',
            'Onatti Resort',
            'Royal Breaka',
            'Oasis Porto',
            'Radisson Blue',
            'Radisson Porto',
            'Shoni Bay Resort',
            'Flamenco Beach Resort',
            'Future Hotel',
            'Alxander',
            'Portophino',
            'Marina View',
            'Out Sied Hotel',
        ];

        $locations = [
            'Marsa Alam',
            'Port Ghalib',
            'El Quseir',
            'Abu Dabbab',
            'Coraya Bay',
        ];

        $statuses = ['active', 'inactive'];

        foreach ($hotelNames as $hotelName) {
            Hotel::create([
                'name' => $hotelName,
                'status' => fake()->randomElement($statuses),
                'description' => fake()->optional(0.7)->paragraph(),
                'phone' => fake()->optional(0.8)->phoneNumber(),
                'address' => fake()->optional(0.9)->streetAddress(),
                'location_url' => fake()->optional(0.6)->url(),
                'location_ordering' => fake()->numberBetween(1, 100),
                'website' => fake()->optional(0.7)->url(),
            ]);
        }
    }
}
