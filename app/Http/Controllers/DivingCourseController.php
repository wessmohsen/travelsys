<?php

namespace App\Http\Controllers;

use App\Models\DivingCourse;
use Illuminate\Http\Request;

class DivingCourseController extends Controller
{
    public function index()
    {
        $items = DivingCourse::latest()->paginate(10);
        return view('diving_courses.index', compact('items'));
    }

    public function create()
    {
        return view('diving_courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'nullable|string|max:255',
        ]);

        DivingCourse::create($request->all());

        return redirect()->route('diving-courses.index')->with('success','Diving course created successfully');
    }

    public function edit(DivingCourse $diving_course)
    {
        return view('diving_courses.edit', ['item' => $diving_course]);
    }

    public function update(Request $request, DivingCourse $diving_course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'nullable|string|max:255',
        ]);

        $diving_course->update($request->all());

        return redirect()->route('diving-courses.index')->with('success','Diving course updated successfully');
    }

    public function destroy(DivingCourse $diving_course)
    {
        $diving_course->delete();
        return redirect()->route('diving-courses.index')->with('success','Diving course deleted successfully');
    }
}
