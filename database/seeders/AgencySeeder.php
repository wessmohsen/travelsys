<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agency;

class AgencySeeder extends Seeder
{
    public function run(): void
    {
        // Generate 20 fake agencies
        Agency::factory()->count(20)->create();
    }
}
