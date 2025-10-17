<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // User Management
            ['name' => 'View Users', 'slug' => 'view-users', 'description' => 'Can view the list of users'],
            ['name' => 'Create Users', 'slug' => 'create-users', 'description' => 'Can create new users'],
            ['name' => 'Edit Users', 'slug' => 'edit-users', 'description' => 'Can edit existing users'],
            ['name' => 'Delete Users', 'slug' => 'delete-users', 'description' => 'Can delete users'],

            // Role Management
            ['name' => 'View Roles', 'slug' => 'view-roles', 'description' => 'Can view the list of roles'],
            ['name' => 'Create Roles', 'slug' => 'create-roles', 'description' => 'Can create new roles'],
            ['name' => 'Edit Roles', 'slug' => 'edit-roles', 'description' => 'Can edit existing roles'],
            ['name' => 'Delete Roles', 'slug' => 'delete-roles', 'description' => 'Can delete roles'],

            // Permission Management
            ['name' => 'View Permissions', 'slug' => 'view-permissions', 'description' => 'Can view the list of permissions'],
            ['name' => 'Create Permissions', 'slug' => 'create-permissions', 'description' => 'Can create new permissions'],
            ['name' => 'Edit Permissions', 'slug' => 'edit-permissions', 'description' => 'Can edit existing permissions'],
            ['name' => 'Delete Permissions', 'slug' => 'delete-permissions', 'description' => 'Can delete permissions'],

            // Customer Management
            ['name' => 'View Customers', 'slug' => 'view-customers', 'description' => 'Can view the list of customers'],
            ['name' => 'Create Customers', 'slug' => 'create-customers', 'description' => 'Can create new customers'],
            ['name' => 'Edit Customers', 'slug' => 'edit-customers', 'description' => 'Can edit existing customers'],
            ['name' => 'Delete Customers', 'slug' => 'delete-customers', 'description' => 'Can delete customers'],

            // Booking Management
            ['name' => 'View Bookings', 'slug' => 'view-bookings', 'description' => 'Can view the list of bookings'],
            ['name' => 'Create Bookings', 'slug' => 'create-bookings', 'description' => 'Can create new bookings'],
            ['name' => 'Edit Bookings', 'slug' => 'edit-bookings', 'description' => 'Can edit existing bookings'],
            ['name' => 'Delete Bookings', 'slug' => 'delete-bookings', 'description' => 'Can delete bookings'],

            // Reports
            ['name' => 'View Reports', 'slug' => 'view-reports', 'description' => 'Can view system reports'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }
    }
}
