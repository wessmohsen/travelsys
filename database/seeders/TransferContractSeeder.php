<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransferContract;

class TransferContractSeeder extends Seeder
{
    public function run(): void
    {
        TransferContract::factory()->count(20)->create();
    }
}
