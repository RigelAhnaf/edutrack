<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function index()
    {
        $assignments = Assignment::with(['course', 'student'])
            ->latest()
            ->paginate(15);
        return view('assignments.index', compact('assignments'));
    }

    public function create()
    {
        $courses = Course::orderBy('name')->get();
        $students = Student::orderBy('name')->get();
        return view('assignments.create', compact('courses', 'students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt,zip|max:10240', // max 10MB
            'score' => 'nullable|numeric|min:0|max:100'
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('assignments', $fileName, 'public');
            
            $validated['file_name'] = $fileName;
            $validated['file_path'] = $filePath;
        }

        Assignment::create($validated);
        
        return redirect()->route('assignments.index')
            ->with('success', 'Assignment berhasil ditambahkan!');
    }

    public function edit(Assignment $assignment)
    {
        $courses = Course::orderBy('name')->get();
        $students = Student::orderBy('name')->get();
        return view('assignments.edit', compact('assignment', 'courses', 'students'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt,zip|max:10240',
            'score' => 'nullable|numeric|min:0|max:100'
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($assignment->file_path && Storage::disk('public')->exists($assignment->file_path)) {
                Storage::disk('public')->delete($assignment->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('assignments', $fileName, 'public');
            
            $validated['file_name'] = $fileName;
            $validated['file_path'] = $filePath;
        }

        $assignment->update($validated);
        
        return redirect()->route('assignments.index')
            ->with('success', 'Assignment berhasil diupdate!');
    }

    public function destroy(Assignment $assignment)
    {
        // Delete file if exists
        if ($assignment->file_path && Storage::disk('public')->exists($assignment->file_path)) {
            Storage::disk('public')->delete($assignment->file_path);
        }

        $assignment->delete();
        
        return redirect()->route('assignments.index')
            ->with('success', 'Assignment berhasil dihapus!');
    }
}