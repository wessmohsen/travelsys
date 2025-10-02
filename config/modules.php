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

    // Reports
    ['name' => 'Booking Reports', 'route' => 'reports.bookings', 'icon' => 'fas fa-chart-line'],
    ['name' => 'Customer Reports', 'route' => 'reports.customers', 'icon' => 'fas fa-user-chart'],
];
