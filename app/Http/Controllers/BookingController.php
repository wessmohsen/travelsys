<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Trip;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // نوحّد الاسم: $items
        $items = Booking::with(['customer', 'trip'])->latest()->paginate(10);
        return view('bookings.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // create view لا تحتاج $item
        return view('bookings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'trip_id' => 'required|exists:trips,id',
            'date' => 'required|date',
            'status' => 'required|in:pending,confirmed,cancelled',
            'price' => 'required|numeric|min:0',
        ]);

        Booking::create($request->all());

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     * نمرّر المتغير باسم $item عشان يتوافق مع الـ view
     */
    public function edit(Booking $booking)
    {
        $booking->load(['customer', 'trip']); // للـ preload في Select2
        return view('bookings.edit', ['item' => $booking]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'trip_id' => 'required|exists:trips,id',
            'date' => 'required|date',
            'status' => 'required|in:pending,confirmed,cancelled',
            'price' => 'required|numeric|min:0',
        ]);

        $booking->update($request->all());

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully.');
    }


    public function ajaxCustomers(Request $request)
    {
        $q = $request->get('q', '');
        $customers = Customer::where('name', 'like', "%{$q}%")
            ->select('id', 'name as text') // مهم جدًا alias باسم text
            ->limit(10)
            ->get();

        return response()->json(['results' => $customers]);
    }

    public function ajaxTrips(Request $request)
    {
        $q = $request->get('q', '');
        $trips = Trip::where('name', 'like', "%{$q}%")
            ->select('id', 'name as text') // مهم جدًا alias باسم text
            ->limit(10)
            ->get();

        return response()->json(['results' => $trips]);
    }
}
