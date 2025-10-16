<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index()
    {
        $items = Trip::paginate(10);
        return view('trips.index', compact('items'));
    }

    public function create()
    {
        return view('trips.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'price' => 'required|numeric',
            'description' => 'nullable|string', // Validate description
        ]);

        Trip::create($validated);

        return redirect()->route('trips.index')->with('success', 'Trip created successfully.');
    }

    public function edit($id)
    {
        $trip = Trip::findOrFail($id); // Retrieve the trip by its ID
        return view('trips.edit', compact('trip')); // Pass the trip to the view
    }

    public function update(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'price' => 'required|numeric',
            'description' => 'nullable|string', // Validate description
        ]);

        $trip->update($validated);

        return redirect()->route('trips.index')->with('success', 'Trip updated successfully.');
    }

    public function destroy($id)
    {
        $trip = Trip::findOrFail($id);
        $trip->delete();

        return redirect()->route('trips.index')->with('success', 'Trip deleted successfully.');
    }
}
