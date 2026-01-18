@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Assignments</span>
                    <a href="{{ route('assignments.create') }}" class="btn btn-primary btn-sm">
                        + Add Assignment
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Student</th>
                                    <th>Course</th>
                                    <th>Title</th>
                                    <th>File</th>
                                    <th>Score</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($assignments as $assignment)
                                <tr>
                                    <td>{{ $assignment->id }}</td>
                                    <td>{{ $assignment->student->name ?? '-' }}</td>
                                    <td>{{ $assignment->course->name ?? '-' }}</td>
                                    <td>{{ $assignment->title }}</td>
                                    <td>
                                        @if($assignment->hasFile())
                                            <a href="{{ $assignment->getFileUrl() }}" target="_blank" class="btn btn-sm btn-info">
                                                📄 {{ $assignment->file_name }}
                                            </a>
                                        @else
                                            <span class="text-muted">No file</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($assignment->score !== null)
                                            <span class="badge bg-success">{{ $assignment->score }}</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('assignments.edit', $assignment) }}" 
                                           class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('assignments.destroy', $assignment) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No assignments found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $assignments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection