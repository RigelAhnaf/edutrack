<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    StudentController,
    CourseController,
    EnrollmentController,
    AssignmentController,
    ReportController
};

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/home', function () {
    return redirect('/dashboard');
})->middleware('auth');

// Enrollments - custom routes karena menggunakan pivot table
Route::get('/enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
Route::get('/enrollments/create', [EnrollmentController::class, 'create'])->name('enrollments.create');
Route::post('/enrollments', [EnrollmentController::class, 'store'])->name('enrollments.store');
Route::get('/enrollments/{student}/{course}/edit', [EnrollmentController::class, 'edit'])->name('enrollments.edit');
Route::put('/enrollments/{student}/{course}', [EnrollmentController::class, 'update'])->name('enrollments.update');
Route::delete('/enrollments/{student}/{course}', [EnrollmentController::class, 'destroy'])->name('enrollments.destroy');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Students
    Route::resource('students', StudentController::class);
    
    // Courses
    Route::resource('courses', CourseController::class);
    
    // Enrollments
    Route::resource('enrollments', EnrollmentController::class)->except(['show']);
    
    // Assignments
    Route::resource('assignments', AssignmentController::class)->except(['show']);
    
    // Reports
    Route::get('/reports/student-performance', [ReportController::class, 'studentPerformance'])
        ->name('reports.student-performance');
    Route::get('/reports/course-performance', [ReportController::class, 'coursePerformance'])
        ->name('reports.course-performance');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('dashboard');
    
    Route::resource('students', StudentController::class);
    Route::resource('courses', CourseController::class);
    
    Route::prefix('enrollments')->name('enrollments.')->group(function () {
        Route::get('/', [EnrollmentController::class, 'index'])->name('index');
        Route::get('/create', [EnrollmentController::class, 'create'])->name('create');
        Route::post('/', [EnrollmentController::class, 'store'])->name('store');
        Route::get('/{student}/{course}/edit', [EnrollmentController::class, 'edit'])->name('edit');
        Route::put('/{student}/{course}', [EnrollmentController::class, 'update'])->name('update');
    });
    
    Route::resource('assignments', AssignmentController::class);
    Route::get('/assignments/{assignment}/download', [AssignmentController::class, 'download'])
        ->name('assignments.download');
    
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/students', [ReportController::class, 'studentPerformance'])->name('students');
        Route::get('/courses', [ReportController::class, 'coursePerformance'])->name('courses');
    });
});