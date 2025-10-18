<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Boat;

class BoatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $boats = [
            ['name' => 'SAN JO', 'capacity' => 20],
            ['name' => 'SAMBO', 'capacity' => 18],
            ['name' => 'NONA', 'capacity' => 22],
            ['name' => 'SEA BRISE', 'capacity' => 25],
            ['name' => 'SEA STAR', 'capacity' => 20],
            ['name' => 'SOUTH', 'capacity' => 18],
            ['name' => 'SHANS', 'capacity' => 20],
            ['name' => 'ISSA', 'capacity' => 15],
            ['name' => 'EGEL RAY', 'capacity' => 24],
            ['name' => 'AQUIE1', 'capacity' => 20],
        ];

        foreach ($boats as $boat) {
            Boat::create([
                'name' => $boat['name'],
                'capacity' => $boat['capacity'],
                'description' => 'Diving boat - ' . $boat['name'],
            ]);
        }
    }
}
