<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Trip;
use App\Models\Boat;
use App\Models\Agency;
use App\Models\Guide;
use App\Models\Hotel;
use App\Models\TripProgram;

class DashboardController extends Controller
{
    public function index()
    {
        $boatsCount = Boat::count();
        $agenciesCount = Agency::count();
        $guidesCount = Guide::count();
        $hotelsCount = Hotel::count();
        $tripProgramsCount = TripProgram::count();
        $tripsCount = Trip::count();

        $latestTripPrograms = TripProgram::with(['trip', 'organizer'])
            ->latest('date')
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'boatsCount',
            'agenciesCount',
            'guidesCount',
            'hotelsCount',
            'tripProgramsCount',
            'tripsCount',
            'latestTripPrograms'
        ));
    }
}
