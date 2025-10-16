<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TripProgram;
use App\Models\ProgramFamily;

class TripProgramSeeder extends Seeder
{
    public function run(): void
    {
        // Create 10 trip programs
        TripProgram::factory()
            ->count(10)
            ->create()
            ->each(function ($program) {
                // For each program, create 3–8 families
                ProgramFamily::factory()
                    ->count(rand(3, 8))
                    ->create(['trip_program_id' => $program->id]);
            });
    }
}
