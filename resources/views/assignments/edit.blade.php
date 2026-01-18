@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Assignment</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('assignments.update', $assignment) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student *</label>
                            <select class="form-control @error('student_id') is-invalid @enderror" 
                                    id="student_id" name="student_id" required>
                                <option value="">-- Select Student --</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" 
                                        {{ old('student_id', $assignment->student_id) == $student->id ? 'selected' : '' }}>
                                        {{ $student->nim }} - {{ $student->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="course_id" class="form-label">Course *</label>
                            <select class="form-control @error('course_id') is-invalid @enderror" 
                                    id="course_id" name="course_id" required>
                                <option value="">-- Select Course --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" 
                                        {{ old('course_id', $assignment->course_id) == $course->id ? 'selected' : '' }}>
                                        {{ $course->code }} - {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Assignment Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $assignment->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description', $assignment->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($assignment->hasFile())
                        <div class="mb-3">
                            <label class="form-label">Current File</label>
                            <div>
                                <a href="{{ $assignment->getFileUrl() }}" target="_blank" class="btn btn-sm btn-info">
                                    📄 {{ $assignment->file_name }}
                                </a>
                            </div>
                        </div>
                        @endif

                        <div class="mb-3">
                            <label for="file" class="form-label">Upload New File (Optional)</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" 
                                   id="file" name="file" accept=".pdf,.doc,.docx,.txt,.zip">
                            <small class="text-muted">Leave empty to keep current file. Max: 10MB</small>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="score" class="form-label">Score (Optional)</label>
                            <input type="number" step="0.01" class="form-control @error('score') is-invalid @enderror" 
                                   id="score" name="score" value="{{ old('score', $assignment->score) }}" 
                                   min="0" max="100">
                            @error('score')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('assignments.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Assignment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection