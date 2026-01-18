<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Report Student Performance
    public function studentPerformance(Request $request)
    {
        $students = Student::with('courses')->get();

        $studentData = $students->map(function($student) {
            $courses = $student->courses;
            $totalCourses = $courses->count();
            
            // Hitung GPA dari final_score
            $scores = $courses->whereNotNull('pivot.final_score');
            $averageScore = $scores->avg('pivot.final_score') ?? 0;
            
            // Convert score to GPA (asumsi: score 0-100)
            $gpa = $averageScore / 25; // 100 point scale to 4.0 scale
            
            return [
                'id' => $student->id,
                'nim' => $student->nim,
                'name' => $student->name,
                'total_courses' => $totalCourses,
                'average_score' => round($averageScore, 2),
                'gpa' => round($gpa, 2),
                'status' => $this->getStatus($gpa)
            ];
        });

        return view('reports.student-performance', compact('studentData'));
    }

    // Report Course Performance
    public function coursePerformance(Request $request)
    {
        // Query courses dengan relasi students
        $courses = Course::query();

        // Filter by semester jika dipilih
        if ($request->has('semester') && $request->semester != '') {
            $courses->where('semester', $request->semester);
        }

        $courses = $courses->with('students')->get();

        $courseData = $courses->map(function($course) {
            $students = $course->students;
            $totalStudents = $students->count();
            
            // Filter hanya yang sudah ada grade
            $gradedStudents = $students->whereNotNull('pivot.grade');
            $gradedCount = $gradedStudents->count();

            // Hitung distribusi grade
            $gradeDistribution = [
                'A' => $gradedStudents->where('pivot.grade', 'A')->count(),
                'B' => $gradedStudents->where('pivot.grade', 'B')->count(),
                'C' => $gradedStudents->where('pivot.grade', 'C')->count(),
                'D' => $gradedStudents->where('pivot.grade', 'D')->count(),
                'E' => $gradedStudents->where('pivot.grade', 'E')->count(),
            ];

            // Hitung rata-rata nilai dari final_score
            $averageScore = $students->whereNotNull('pivot.final_score')
                ->avg('pivot.final_score') ?? 0;

            // Hitung average grade point
            $totalPoints = 0;
            foreach($gradedStudents as $student) {
                $totalPoints += $this->getGradePoint($student->pivot->grade);
            }
            $averageGrade = $gradedCount > 0 ? round($totalPoints / $gradedCount, 2) : 0;

            // Hitung pass rate (A, B, C dianggap lulus)
            $passCount = $gradeDistribution['A'] + $gradeDistribution['B'] + $gradeDistribution['C'];
            $passRate = $gradedCount > 0 ? round(($passCount / $gradedCount) * 100, 1) : 0;

            return [
                'id' => $course->id,
                'code' => $course->code,
                'name' => $course->name,
                'semester' => $course->semester,
                'credits' => $course->credits ?? 3,
                'total_students' => $totalStudents,
                'graded_students' => $gradedCount,
                'average_score' => round($averageScore, 2),
                'average_grade' => $averageGrade,
                'pass_rate' => $passRate,
                'grade_distribution' => $gradeDistribution
            ];
        });

        return view('reports.course-performance', compact('courseData'));
    }

    // Helper: Convert grade to point
    private function getGradePoint($grade)
    {
        $gradePoints = [
            'A' => 4.0,
            'B' => 3.0,
            'C' => 2.0,
            'D' => 1.0,
            'E' => 0.0,
        ];

        return $gradePoints[$grade] ?? 0;
    }

    // Helper: Get status based on GPA
    private function getStatus($gpa)
    {
        if ($gpa >= 3.5) return 'Excellent';
        if ($gpa >= 3.0) return 'Good';
        if ($gpa >= 2.5) return 'Average';
        if ($gpa >= 2.0) return 'Below Average';
        return 'Poor';
    }
}