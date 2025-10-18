<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
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
        // Seed permissions and roles first
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('123123123'),
            ]
        );

        // Assign admin role to admin user
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $admin->roles()->syncWithoutDetaching([$adminRole->id]);
        }

        $this->call(UserSeeder::class);
        Customer::factory(20)->create();
        $this->call(TripSeeder::class);
        Booking::factory(20)->create();
        $this->call(HotelSeeder::class);
        $this->call(BoatSeeder::class);
        $this->call(DriverSeeder::class);
        Vehicle::factory(5)->create();
        DivingCourse::factory(5)->create();
        $this->call(GuideSeeder::class);
        $this->call(AgencySeeder::class);
        $this->call(TransferContractSeeder::class);
        // $this->call(AdminUserSeeder::class);
        $this->call(CertificationSeeder::class);
        $this->call([
        TripProgramSeeder::class,
        // ProgramFamilySeeder::class, // optional, only if you want extra families
        ]);
    }
}
