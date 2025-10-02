<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Trip;

class DashboardController extends Controller
{
    public function index()
    {
        $bookingsCount = Booking::count();
        $customersCount = Customer::count();
        $tripsCount     = Trip::count();
        $revenue        = Booking::sum('price');

        $latestBookings = Booking::with(['customer', 'trip'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'bookingsCount',
            'customersCount',
            'tripsCount',
            'revenue',
            'latestBookings'
        ));
    }
}
