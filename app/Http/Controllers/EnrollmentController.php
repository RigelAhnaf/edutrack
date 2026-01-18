<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        // Ambil semua course dengan students yang terdaftar
        $courses = Course::with('students')->paginate(15);
        
        // Atau ambil dari sisi students
        $students = Student::with('courses')->paginate(15);
        
        return view('enrollments.index', compact('students'));
    }

    public function create()
    {
        $students = Student::orderBy('name')->get();
        $courses = Course::orderBy('name')->get();
        return view('enrollments.create', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'exam_scores' => 'nullable|numeric|min:0|max:100',
            'final_score' => 'nullable|numeric|min:0|max:100',
            'grade' => 'nullable|string|in:A,B,C,D,E',
            'comments' => 'nullable|string'
        ]);

        $student = Student::findOrFail($validated['student_id']);
        
        // Cek apakah sudah terdaftar
        if ($student->courses()->where('course_id', $validated['course_id'])->exists()) {
            return back()->withErrors(['error' => 'Mahasiswa sudah terdaftar di kursus ini!']);
        }

        // Attach dengan pivot data
        $student->courses()->attach($validated['course_id'], [
            'exam_scores' => $validated['exam_scores'] ?? null,
            'final_score' => $validated['final_score'] ?? null,
            'grade' => $validated['grade'] ?? null,
            'comments' => $validated['comments'] ?? null,
        ]);
        
        return redirect()->route('enrollments.index')
            ->with('success', 'Enrollment berhasil ditambahkan!');
    }

    public function edit($studentId, $courseId)
    {
        $student = Student::findOrFail($studentId);
        $course = Course::findOrFail($courseId);
        
        // Ambil data pivot
        $enrollment = $student->courses()
            ->where('course_id', $courseId)
            ->first();

        if (!$enrollment) {
            return redirect()->route('enrollments.index')
                ->withErrors(['error' => 'Enrollment tidak ditemukan!']);
        }

        $students = Student::orderBy('name')->get();
        $courses = Course::orderBy('name')->get();
        
        return view('enrollments.edit', compact('student', 'course', 'enrollment', 'students', 'courses'));
    }

    public function update(Request $request, $studentId, $courseId)
    {
        $validated = $request->validate([
            'exam_scores' => 'nullable|numeric|min:0|max:100',
            'final_score' => 'nullable|numeric|min:0|max:100',
            'grade' => 'nullable|string|in:A,B,C,D,E',
            'comments' => 'nullable|string'
        ]);

        $student = Student::findOrFail($studentId);
        
        // Update pivot data
        $student->courses()->updateExistingPivot($courseId, [
            'exam_scores' => $validated['exam_scores'] ?? null,
            'final_score' => $validated['final_score'] ?? null,
            'grade' => $validated['grade'] ?? null,
            'comments' => $validated['comments'] ?? null,
        ]);
        
        return redirect()->route('enrollments.index')
            ->with('success', 'Enrollment berhasil diupdate!');
    }

    public function destroy($studentId, $courseId)
    {
        $student = Student::findOrFail($studentId);
        $student->courses()->detach($courseId);
        
        return redirect()->route('enrollments.index')
            ->with('success', 'Enrollment berhasil dihapus!');
    }
}