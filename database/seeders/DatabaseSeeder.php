<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Customer;
use App\Models\Trip;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Boat;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\DivingCourse;
use App\Models\Guide;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );

        Customer::factory(20)->create();
        Trip::factory(5)->create();
        Booking::factory(20)->create();
        Hotel::factory(5)->create();
        Boat::factory(3)->create();
        Driver::factory(5)->create();
        Vehicle::factory(5)->create();
        DivingCourse::factory(5)->create();
        Guide::factory(5)->create();
        $this->call(AgencySeeder::class);
        $this->call(TransferContractSeeder::class);
        // $this->call(AdminUserSeeder::class);
    }
}
