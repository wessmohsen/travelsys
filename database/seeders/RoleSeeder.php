<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin Role
        $admin = Role::firstOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Admin',
                'description' => 'Administrator with full system access'
            ]
        );

        // Admin gets all permissions
        $admin->permissions()->sync(Permission::all());

        // Create Manager Role
        $manager = Role::firstOrCreate(
            ['slug' => 'manager'],
            [
                'name' => 'Manager',
                'description' => 'Manager with limited administrative access'
            ]
        );

        // Manager gets specific permissions
        $managerPermissions = Permission::whereIn('slug', [
            'view-users',
            'view-customers', 'create-customers', 'edit-customers',
            'view-bookings', 'create-bookings', 'edit-bookings',
            'view-trip-programs', 'create-trip-programs', 'edit-trip-programs', 'delete-trip-programs',
            'view-program-families', 'create-program-families', 'edit-program-families', 'delete-program-families',
            'view-reports',
        ])->get();
        $manager->permissions()->sync($managerPermissions);

        // Create Operation Manager Role
        $operationManager = Role::firstOrCreate(
            ['slug' => 'operation-manager'],
            [
                'name' => 'Operation Manager',
                'description' => 'Operations manager with access to trip programs only'
            ]
        );

        // Operation Manager gets ONLY trip program permissions (NO customers or bookings)
        $operationManagerPermissions = Permission::whereIn('slug', [
            'view-trip-programs', 'create-trip-programs', 'edit-trip-programs', 'delete-trip-programs',
            'view-program-families', 'create-program-families', 'edit-program-families', 'delete-program-families',
            'view-reports',
        ])->get();
        $operationManager->permissions()->sync($operationManagerPermissions);

        // Create User Role
        $user = Role::firstOrCreate(
            ['slug' => 'user'],
            [
                'name' => 'User',
                'description' => 'Regular user with basic access'
            ]
        );

        // User gets view permissions
        $userPermissions = Permission::whereIn('slug', [
            'view-customers',
            'view-bookings',
        ])->get();
        $user->permissions()->sync($userPermissions);
    }
}
