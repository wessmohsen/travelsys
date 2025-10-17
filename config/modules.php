<?php
return [
    ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'fas fa-tachometer-alt'],

    ['name' => 'Hotels', 'route' => 'hotels.index', 'icon' => 'fas fa-hotel'],
    ['name' => 'Trips', 'route' => 'trips.index', 'icon' => 'fas fa-suitcase'],
    ['name' => 'Boats', 'route' => 'boats.index', 'icon' => 'fas fa-ship'],

    [
        'name' => 'Transportation',
        'icon' => 'fas fa-shuttle-van',
        'children' => [
            ['name' => 'Drivers', 'route' => 'drivers.index', 'icon' => 'fas fa-id-card'],
            ['name' => 'Vehicles', 'route' => 'vehicles.index', 'icon' => 'fas fa-car'],
            ['name' => 'Transfer Contracts', 'route' => 'transfercontracts.index', 'icon' => 'fas fa-bus'],
        ]
    ],

    ['name' => 'Diving Courses', 'route' => 'diving-courses.index', 'icon' => 'fas fa-water'],
    ['name' => 'Guides', 'route' => 'guides.index', 'icon' => 'fas fa-user-tie'],
    ['name' => 'Customers', 'route' => 'customers.index', 'icon' => 'fas fa-users'],
    ['name' => 'Bookings', 'route' => 'bookings.index', 'icon' => 'fas fa-calendar-check'],
    ['name' => 'Agencies', 'route' => 'agencies.index', 'icon' => 'fas fa-building'],
    ['name' => 'Operation Programs', 'route' => 'trip-programs.index', 'icon' => 'fa-solid fa-layer-group'],


    // Reports
    [
        'name' => 'System Reports',
        'icon' => 'fas fa-chart-line',
        'children' => [
            ['name' => 'Booking Reports', 'route' => 'reports.bookings', 'icon' => 'fas fa-tags'],
        ]
    ],


    //users
    [
        'name' => 'User Management',
        'icon' => 'fas fa-users-cog',
        'children' => [
            ['name' => 'Users', 'route' => 'users.index', 'icon' => 'fas fa-user-friends' ],
            // ['name' => 'Roles', 'route' => 'roles.index', 'icon' => 'fas fa-user-tag' ],
            // ['name' => 'Permissions', 'route' => 'permissions.index', 'icon' => 'fas fa-user-shield' ],
            // ['name' => 'Profile', 'route' => 'profile.index', 'icon' => 'fas fa-user-circle' ],

        ]
    ],

];
