<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramFamily;

class ProgramFamilySeeder extends Seeder
{
    public function run(): void
    {
        ProgramFamily::factory(20)->create(); // Create 20 program families
    }
}
