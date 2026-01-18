@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Tambah Kursus Baru</h4>
                </div>

                <div class="card-body">

                    {{-- Error Validation --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('courses.store') }}">
                        @csrf

                        {{-- Kode Kursus --}}
                        <div class="mb-3">
                            <label for="code" class="form-label">
                                Kode Kursus <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                class="form-control @error('code') is-invalid @enderror"
                                id="code"
                                name="code"
                                value="{{ old('code') }}"
                                required
                            >
                            @error('code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Nama Kursus --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Nama Kursus <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- SKS --}}
                        <div class="mb-3">
                            <label for="credits" class="form-label">
                                SKS <span class="text-danger">*</span>
                            </label>
                            <input
                                type="number"
                                class="form-control @error('credits') is-invalid @enderror"
                                id="credits"
                                name="credits"
                                value="{{ old('credits') }}"
                                min="1"
                                max="6"
                                required
                            >
                            @error('credits')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester *</label>
                            <select class="form-control @error('semester') is-invalid @enderror" 
                                    id="semester" name="semester" required>
                            <!--                ^^^^ PASTIKAN INI name="semester" -->
                                <option value="">-- Select Semester --</option>
                                <option value="1">Semester 1</option>
                                <option value="2">Semester 2</option>
                                <!-- dst -->
                            </select>
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('courses.index') }}" class="btn btn-secondary">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
