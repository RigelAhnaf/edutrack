@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Enrollment</div>

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

                    <form action="{{ route('enrollments.update', [$student->id, $course->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Student</label>
                            <input type="text" class="form-control" value="{{ $student->nim }} - {{ $student->name }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Course</label>
                            <input type="text" class="form-control" value="{{ $course->code }} - {{ $course->name }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="exam_scores" class="form-label">Exam Score</label>
                            <input type="number" step="0.01" class="form-control @error('exam_scores') is-invalid @enderror" 
                                   id="exam_scores" name="exam_scores" 
                                   value="{{ old('exam_scores', $enrollment->pivot->exam_scores) }}" 
                                   min="0" max="100">
                            @error('exam_scores')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="final_score" class="form-label">Final Score</label>
                            <input type="number" step="0.01" class="form-control @error('final_score') is-invalid @enderror" 
                                   id="final_score" name="final_score" 
                                   value="{{ old('final_score', $enrollment->pivot->final_score) }}" 
                                   min="0" max="100">
                            @error('final_score')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="grade" class="form-label">Grade</label>
                            <select class="form-control @error('grade') is-invalid @enderror" 
                                    id="grade" name="grade">
                                <option value="">-- Not Graded Yet --</option>
                                <option value="A" {{ old('grade', $enrollment->pivot->grade) == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('grade', $enrollment->pivot->grade) == 'B' ? 'selected' : '' }}>B</option>
                                <option value="C" {{ old('grade', $enrollment->pivot->grade) == 'C' ? 'selected' : '' }}>C</option>
                                <option value="D" {{ old('grade', $enrollment->pivot->grade) == 'D' ? 'selected' : '' }}>D</option>
                                <option value="E" {{ old('grade', $enrollment->pivot->grade) == 'E' ? 'selected' : '' }}>E</option>
                            </select>
                            @error('grade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="comments" class="form-label">Comments</label>
                            <textarea class="form-control @error('comments') is-invalid @enderror" 
                                      id="comments" name="comments" rows="3">{{ old('comments', $enrollment->pivot->comments) }}</textarea>
                            @error('comments')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('enrollments.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Enrollment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection