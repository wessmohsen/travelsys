<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $items = Driver::latest()->paginate(10);
        return view('drivers.index', compact('items'));
    }

    public function create()
    {
        return view('drivers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'nullable|string|max:255',
        ]);

        Driver::create($request->all());

        return redirect()->route('drivers.index')->with('success','Driver created successfully');
    }

    public function edit(Driver $driver)
    {
        return view('drivers.edit', ['item' => $driver]);
    }

    public function update(Request $request, Driver $driver)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'nullable|string|max:255',
        ]);

        $driver->update($request->all());

        return redirect()->route('drivers.index')->with('success','Driver updated successfully');
    }

    public function destroy(Driver $driver)
    {
        $driver->delete();
        return redirect()->route('drivers.index')->with('success','Driver deleted successfully');
    }
}
