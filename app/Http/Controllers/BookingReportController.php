<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use Illuminate\Http\Request;

class BookingReportController extends Controller
{
    public function index(Request $request)
    {
        $baseQuery = Booking::with(['customer', 'trip']);

        if ($request->filled('from') && $request->filled('to')) {
            $baseQuery->whereBetween('date', [$request->from, $request->to]);
        }

        if ($request->filled('status')) {
            $baseQuery->where('status', $request->status);
        }

        // Clone queries
        $bookings = (clone $baseQuery)->orderBy('date', 'desc')->paginate(15);
        $revenue = (clone $baseQuery)->sum('price');

        return view('reports.bookings', compact('bookings', 'revenue'));
    }


    public function customers()
    {
        $topCustomers = Customer::withCount('bookings')
            ->orderByDesc('bookings_count')
            ->take(10)
            ->get();

        return view('reports.customers', compact('topCustomers'));
    }
}
