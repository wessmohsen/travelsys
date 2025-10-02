<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $items = Hotel::latest()->paginate(10);
        return view('hotels.index', compact('items'));
    }

    public function create()
    {
        return view('hotels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Hotel::create($request->all());

        return redirect()->route('hotels.index')->with('success','Hotel created successfully');
    }

    public function edit(Hotel $hotel)
    {
        return view('hotels.edit', ['item' => $hotel]);
    }

    public function update(Request $request, Hotel $hotel)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $hotel->update($request->all());

        return redirect()->route('hotels.index')->with('success','Hotel updated successfully');
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return redirect()->route('hotels.index')->with('success','Hotel deleted successfully');
    }
}
