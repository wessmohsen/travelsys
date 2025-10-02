<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    public function index()
    {
        $items = Agency::paginate(10);
        return view('agencies.index', compact('items'));
    }

    public function create()
    {
        return view('agencies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:agencies,email',
        ]);

        Agency::create($request->all());

        return redirect()->route('agencies.index')->with('success', 'Agency created successfully.');
    }

    public function show(Agency $agency)
    {
        return view('agencies.show', compact('agency'));
    }

    public function edit(Agency $agency)
    {
        return view('agencies.edit', compact('agency'));
    }

    public function update(Request $request, Agency $agency)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:agencies,email,' . $agency->id,
        ]);

        $agency->update($request->all());

        return redirect()->route('agencies.index')->with('success', 'Agency updated successfully.');
    }

    public function destroy(Agency $agency)
    {
        $agency->delete();
        return redirect()->route('agencies.index')->with('success', 'Agency deleted successfully.');
    }
}
