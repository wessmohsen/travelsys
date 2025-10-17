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

        $data = $request->all();

        // Set default value for location_ordering if not provided or null
        if (!isset($data['location_ordering']) || $data['location_ordering'] === null || $data['location_ordering'] === '') {
            $data['location_ordering'] = 0;
        }

        Hotel::create($data);

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

        $data = $request->all();

        // Set default value for location_ordering if not provided or null
        if (!isset($data['location_ordering']) || $data['location_ordering'] === null || $data['location_ordering'] === '') {
            $data['location_ordering'] = 0;
        }

        $hotel->update($data);

        return redirect()->route('hotels.index')->with('success','Hotel updated successfully');
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return redirect()->route('hotels.index')->with('success','Hotel deleted successfully');
    }

    protected function validateHotel(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'location_url' => 'nullable|url|max:255',
            'location_ordering' => 'nullable|integer',
            'website' => 'nullable|url|max:255',
        ]);
    }
}
