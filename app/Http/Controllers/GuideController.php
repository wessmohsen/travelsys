<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    public function index()
    {
        $items = Guide::latest()->paginate(10);
        return view('guides.index', compact('items'));
    }

    public function create()
    {
        return view('guides.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'speciality' => 'nullable|string|max:255',
        ]);

        Guide::create($request->all());

        return redirect()->route('guides.index')->with('success','Guide created successfully');
    }

    public function edit(Guide $guide)
    {
        return view('guides.edit', ['item' => $guide]);
    }

    public function update(Request $request, Guide $guide)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'speciality' => 'nullable|string|max:255',
        ]);

        $guide->update($request->all());

        return redirect()->route('guides.index')->with('success','Guide updated successfully');
    }

    public function destroy(Guide $guide)
    {
        $guide->delete();
        return redirect()->route('guides.index')->with('success','Guide deleted successfully');
    }
}
