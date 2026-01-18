@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add New Enrollment</div>

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

                    <form action="{{ route('enrollments.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student *</label>
                            <select class="form-control @error('student_id') is-invalid @enderror" 
                                    id="student_id" name="student_id" required>
                                <option value="">-- Select Student --</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" 
                                        {{ old('student_id') == $student->id ? 'selected' : '' }}>
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
                                        {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->code }} - {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="exam_scores" class="form-label">Exam Score (Optional)</label>
                            <input type="number" step="0.01" class="form-control @error('exam_scores') is-invalid @enderror" 
                                   id="exam_scores" name="exam_scores" value="{{ old('exam_scores') }}" 
                                   min="0" max="100">
                            @error('exam_scores')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="final_score" class="form-label">Final Score (Optional)</label>
                            <input type="number" step="0.01" class="form-control @error('final_score') is-invalid @enderror" 
                                   id="final_score" name="final_score" value="{{ old('final_score') }}" 
                                   min="0" max="100">
                            @error('final_score')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="grade" class="form-label">Grade (Optional)</label>
                            <select class="form-control @error('grade') is-invalid @enderror" 
                                    id="grade" name="grade">
                                <option value="">-- Not Graded Yet --</option>
                                <option value="A" {{ old('grade') == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('grade') == 'B' ? 'selected' : '' }}>B</option>
                                <option value="C" {{ old('grade') == 'C' ? 'selected' : '' }}>C</option>
                                <option value="D" {{ old('grade') == 'D' ? 'selected' : '' }}>D</option>
                                <option value="E" {{ old('grade') == 'E' ? 'selected' : '' }}>E</option>
                            </select>
                            @error('grade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="comments" class="form-label">Comments (Optional)</label>
                            <textarea class="form-control @error('comments') is-invalid @enderror" 
                                      id="comments" name="comments" rows="3">{{ old('comments') }}</textarea>
                            @error('comments')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('enrollments.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Add Enrollment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection