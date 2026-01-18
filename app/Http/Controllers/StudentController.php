<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('courses')->paginate(10);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validator = $this->validateStudent($request);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Student::create($request->all());
        
        return redirect()->route('students.index')
            ->with('success', 'Mahasiswa berhasil ditambahkan!');
    }

    public function show(Student $student)
    {
        $student->load('courses', 'assignments');
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validator = $this->validateStudent($request, $student->id);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $student->update($request->all());
        
        return redirect()->route('students.index')
            ->with('success', 'Data mahasiswa berhasil diupdate!');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')
            ->with('success', 'Mahasiswa berhasil dihapus!');
    }

    private function validateStudent(Request $request, $id = null)
    {
        $rules = [
            'nim' => 'required|unique:students,nim,' . $id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'phone' => 'nullable|string|max:15',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string'
        ];

        return Validator::make($request->all(), $rules);
    }
}