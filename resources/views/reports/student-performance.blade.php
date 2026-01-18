@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Student Performance Report</h5>
                </div>

                <div class="card-body">
                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h6>Total Students</h6>
                                    <h3>{{ $studentData->count() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h6>Excellent (GPA ≥ 3.5)</h6>
                                    <h3>{{ $studentData->where('status', 'Excellent')->count() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h6>Good (GPA ≥ 3.0)</h6>
                                    <h3>{{ $studentData->where('status', 'Good')->count() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h6>Average GPA</h6>
                                    <h3>{{ $studentData->avg('gpa') > 0 ? number_format($studentData->avg('gpa'), 2) : '0.00' }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Name</th>
                                    <th>Total Courses</th>
                                    <th>Average Score</th>
                                    <th>GPA</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($studentData->sortByDesc('gpa') as $student)
                                <tr>
                                    <td>{{ $student['nim'] }}</td>
                                    <td>{{ $student['name'] }}</td>
                                    <td>{{ $student['total_courses'] }}</td>
                                    <td>{{ number_format($student['average_score'], 2) }}</td>
                                    <td><strong>{{ number_format($student['gpa'], 2) }}</strong></td>
                                    <td>
                                        @if($student['status'] == 'Excellent')
                                            <span class="badge bg-success">{{ $student['status'] }}</span>
                                        @elseif($student['status'] == 'Good')
                                            <span class="badge bg-info">{{ $student['status'] }}</span>
                                        @elseif($student['status'] == 'Average')
                                            <span class="badge bg-warning">{{ $student['status'] }}</span>
                                        @elseif($student['status'] == 'Below Average')
                                            <span class="badge bg-secondary">{{ $student['status'] }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $student['status'] }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No data available.</td>
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
        .btn, .card-header { display: none; }
    }
</style>
@endsection