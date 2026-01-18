@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Enrollments</span>
                    <a href="{{ route('enrollments.create') }}" class="btn btn-primary btn-sm">
                        + Add Enrollment
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Student NIM</th>
                                    <th>Student Name</th>
                                    <th>Course</th>
                                    <th>Exam Score</th>
                                    <th>Final Score</th>
                                    <th>Grade</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                    @foreach($student->courses as $course)
                                    <tr>
                                        <td>{{ $student->nim }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $course->code }} - {{ $course->name }}</td>
                                        <td>{{ $course->pivot->exam_scores ?? '-' }}</td>
                                        <td>{{ $course->pivot->final_score ?? '-' }}</td>
                                        <td>
                                            @if($course->pivot->grade)
                                                <span class="badge bg-success">{{ $course->pivot->grade }}</span>
                                            @else
                                                <span class="badge bg-secondary">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('enrollments.edit', [$student->id, $course->id]) }}" 
                                               class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('enrollments.destroy', [$student->id, $course->id]) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No enrollments found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection