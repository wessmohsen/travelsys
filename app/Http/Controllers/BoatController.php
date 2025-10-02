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
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'nullable|integer',
        ]);

        Boat::create($request->all());

        return redirect()->route('boats.index')->with('success', 'Boat created successfully');
    }

    public function edit(Boat $boat)
    {
        return view('boats.edit', ['item' => $boat]);
    }

    public function update(Request $request, Boat $boat)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'nullable|integer',
        ]);

        $boat->update($request->all());

        return redirect()->route('boats.index')->with('success', 'Boat updated successfully');
    }

    public function destroy(Boat $boat)
    {
        $boat->delete();
        return redirect()->route('boats.index')->with('success', 'Boat deleted successfully');
    }
}
