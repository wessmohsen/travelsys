<?php
return [
    ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'fas fa-tachometer-alt'],

    // Master Data - Admin and Manager only
    ['name' => 'Hotels', 'route' => 'hotels.index', 'icon' => 'fas fa-hotel', 'roles' => ['admin', 'manager']],
    ['name' => 'Trips', 'route' => 'trips.index', 'icon' => 'fas fa-suitcase', 'roles' => ['admin', 'manager']],
    ['name' => 'Boats', 'route' => 'boats.index', 'icon' => 'fas fa-ship', 'roles' => ['admin', 'manager']],

    [
        'name' => 'Transportation',
        'icon' => 'fas fa-shuttle-van',
        'roles' => ['admin', 'manager'],
        'children' => [
            ['name' => 'Drivers', 'route' => 'drivers.index', 'icon' => 'fas fa-id-card'],
            ['name' => 'Vehicles', 'route' => 'vehicles.index', 'icon' => 'fas fa-car'],
            ['name' => 'Transfer Contracts', 'route' => 'transfercontracts.index', 'icon' => 'fas fa-bus'],
        ]
    ],

    ['name' => 'Diving Courses', 'route' => 'diving-courses.index', 'icon' => 'fas fa-water', 'roles' => ['admin', 'manager']],
    ['name' => 'Guides', 'route' => 'guides.index', 'icon' => 'fas fa-user-tie', 'roles' => ['admin', 'manager']],
    ['name' => 'Agencies', 'route' => 'agencies.index', 'icon' => 'fas fa-building', 'roles' => ['admin', 'manager']],

    // Customer Management - Admin and Manager only
    ['name' => 'Customers', 'route' => 'customers.index', 'icon' => 'fas fa-users', 'roles' => ['admin', 'manager']],
    ['name' => 'Bookings', 'route' => 'bookings.index', 'icon' => 'fas fa-calendar-check', 'roles' => ['admin', 'manager']],

    // Operation Programs - Admin, Manager, and Operation Manager
    [
        'name' => 'Operation Programs',
        'icon' => 'fa-solid fa-layer-group',
        'roles' => ['admin', 'manager', 'operation-manager'],
        'children' => [
                ['name' => 'Trip Programs', 'route' => 'trip-programs.index', 'icon' => 'fas fa-shuttle-van'],
        ]
    ],

    // Reports
    [
        'name' => 'System Reports',
        'icon' => 'fas fa-chart-line',
        'roles' => ['admin', 'manager', 'operation-manager'],
        'children' => [
            ['name' => 'Booking Reports', 'route' => 'reports.bookings', 'icon' => 'fas fa-tags'],
        ]
    ],


    //users
    [
        'name' => 'User Management',
        'icon' => 'fas fa-users-cog',
        'children' => [
            ['name' => 'Users', 'route' => 'users.index', 'icon' => 'fas fa-user-friends', 'roles' => ['admin', 'manager']],
            ['name' => 'Roles', 'route' => 'roles.index', 'icon' => 'fas fa-user-tag', 'roles' => ['admin']],
            ['name' => 'Permissions', 'route' => 'permissions.index', 'icon' => 'fas fa-user-shield', 'roles' => ['admin']],
            ['name' => 'My Profile', 'route' => 'profile', 'icon' => 'fas fa-user-circle'],
        ]
    ],

];
