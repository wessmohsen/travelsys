<?php

namespace App\Http\Controllers;

use App\Models\Boat;
use Illuminate\Http\Request;

class BoatController extends Controller
{
    public function index()
    {
        $items = Boat::latest()->paginate(10);
        return view('boats.index', compact('items'));
    }

    public function create()
    {
        return view('boats.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string', // Validate description
            'capacity' => 'nullable|integer',
        ]);

        Boat::create($validated);

        return redirect()->route('boats.index')->with('success', 'Boat created successfully.');
    }

    public function edit($id)
    {
        $boat = Boat::findOrFail($id); // Retrieve the boat by its ID
        return view('boats.edit', compact('boat')); // Pass the boat to the view
    }

    public function update(Request $request, Boat $boat)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string', // Validate description
            'capacity' => 'nullable|integer',
        ]);

        $boat->update($validated);

        return redirect()->route('boats.index')->with('success', 'Boat updated successfully.');
    }

    public function destroy(Boat $boat)
    {
        $boat->delete();
        return redirect()->route('boats.index')->with('success', 'Boat deleted successfully.');
    }
}
