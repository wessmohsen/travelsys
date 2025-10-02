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
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'price' => 'nullable|numeric',
        ]);

        Trip::create($request->all());

        return redirect()->route('trips.index')->with('success', 'Trip created successfully.');
    }

    public function edit($id)
    {
        $item = Trip::findOrFail($id);
        return view('trips.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'price' => 'nullable|numeric',
        ]);

        $item = Trip::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('trips.index')->with('success', 'Trip updated successfully.');
    }

    public function destroy($id)
    {
        $item = Trip::findOrFail($id);
        $item->delete();

        return redirect()->route('trips.index')->with('success', 'Trip deleted successfully.');
    }
}
