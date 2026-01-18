<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::withCount('students')->paginate(10);
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        //dd($request->all());

        $validated = $request->validate([
            'code' => 'nullable|unique:courses',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credits' => 'required|integer|min:1|max:6',
            'semester' => 'required|string'
        ]);

        Course::create($validated);
        
        return redirect()->route('courses.index')
            ->with('success', 'Kursus berhasil ditambahkan!');
    }

    public function show(Course $course)
    {
        $course->load('students');
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'code' => 'required|unique:courses,code,' . $course->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credits' => 'required|integer|min:1|max:6',
            'semester' => 'required|string'
        ]);

        $course->update($validated);
        
        return redirect()->route('courses.index')
            ->with('success', 'Kursus berhasil diupdate!');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')
            ->with('success', 'Kursus berhasil dihapus!');
    }
}