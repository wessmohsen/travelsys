<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $items = Vehicle::latest()->paginate(10);
        return view('vehicles.index', compact('items'));
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
        ]);

        Vehicle::create($request->all());

        return redirect()->route('vehicles.index')->with('success','Vehicle created successfully');
    }

    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', ['item' => $vehicle]);
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'plate_number' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
        ]);

        $vehicle->update($request->all());

        return redirect()->route('vehicles.index')->with('success','Vehicle updated successfully');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success','Vehicle deleted successfully');
    }
}
