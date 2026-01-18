@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Course Performance Report</h5>
                </div>

                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('reports.course-performance') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <select name="semester" class="form-control">
                                    <option value="">-- All Semesters --</option>
                                    <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>Semester 1</option>
                                    <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>Semester 2</option>
                                    <option value="3" {{ request('semester') == '3' ? 'selected' : '' }}>Semester 3</option>
                                    <option value="4" {{ request('semester') == '4' ? 'selected' : '' }}>Semester 4</option>
                                    <option value="5" {{ request('semester') == '5' ? 'selected' : '' }}>Semester 5</option>
                                    <option value="6" {{ request('semester') == '6' ? 'selected' : '' }}>Semester 6</option>
                                    <option value="7" {{ request('semester') == '7' ? 'selected' : '' }}>Semester 7</option>
                                    <option value="8" {{ request('semester') == '8' ? 'selected' : '' }}>Semester 8</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('reports.course-performance') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </form>

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h6>Total Courses</h6>
                                    <h3>{{ $courseData->count() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h6>Total Students</h6>
                                    <h3>{{ $courseData->sum('total_students') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h6>Average Pass Rate</h6>
                                    <h3>{{ $courseData->count() > 0 ? number_format($courseData->avg('pass_rate'), 1) : '0.0' }}%</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h6>Average Grade</h6>
                                    <h3>{{ $courseData->count() > 0 ? number_format($courseData->avg('average_grade'), 2) : '0.00' }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Course Code</th>
                                    <th>Course Name</th>
                                    <th>Semester</th>
                                    <th>Students</th>
                                    <th>Graded</th>
                                    <th>Avg Grade</th>
                                    <th>Pass Rate</th>
                                    <th>Grade Distribution</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($courseData->sortByDesc('pass_rate') as $course)
                                <tr>
                                    <td>{{ $course['code'] }}</td>
                                    <td>{{ $course['name'] }}</td>
                                    <td>Semester {{ $course['semester'] }}</td>
                                    <td>{{ $course['total_students'] }}</td>
                                    <td>{{ $course['graded_students'] }}</td>
                                    <td><strong>{{ number_format($course['average_grade'], 2) }}</strong></td>
                                    <td>
                                        @if($course['pass_rate'] >= 80)
                                            <span class="badge bg-success">{{ $course['pass_rate'] }}%</span>
                                        @elseif($course['pass_rate'] >= 60)
                                            <span class="badge bg-info">{{ $course['pass_rate'] }}%</span>
                                        @elseif($course['pass_rate'] >= 40)
                                            <span class="badge bg-warning">{{ $course['pass_rate'] }}%</span>
                                        @else
                                            <span class="badge bg-danger">{{ $course['pass_rate'] }}%</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>
                                            A: {{ $course['grade_distribution']['A'] }} |
                                            B: {{ $course['grade_distribution']['B'] }} |
                                            C: {{ $course['grade_distribution']['C'] }} |
                                            D: {{ $course['grade_distribution']['D'] }} |
                                            E: {{ $course['grade_distribution']['E'] }}
                                        </small>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No data available.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Export Buttons -->
                    <div class="mt-3">
                        <button onclick="window.print()" class="btn btn-secondary">
                            <i class="bi bi-printer"></i> Print Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .btn, form, .card-header { display: none; }
    }
</style>
@endsection