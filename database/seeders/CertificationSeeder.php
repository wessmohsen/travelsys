<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Certification;

class CertificationSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Open Water', 'Advanced Open Water', 'Rescue', 'Divemaster'] as $name) {
            Certification::firstOrCreate(['name' => $name]);
        }
    }
}
