@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Dashboard EduTrack</h3>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="alert alert-success">
                        Selamat datang, <strong>{{ Auth::user()->name }}</strong>! 🎉
                    </div>

                    <div class="row mt-4">
                        <!-- Card Mahasiswa -->
                        <div class="col-md-3 mb-3">
                            <div class="card text-white bg-primary">
                                <div class="card-body">
                                    <h5 class="card-title">Total Mahasiswa</h5>
                                    <h2>{{ \App\Models\Student::count() }}</h2>
                                    <a href="{{ route('students.index') }}" class="btn btn-light btn-sm mt-2">Lihat Detail</a>
                                </div>
                            </div>
                        </div>

                        <!-- Card Kursus -->
                        <div class="col-md-3 mb-3">
                            <div class="card text-white bg-success">
                                <div class="card-body">
                                    <h5 class="card-title">Total Kursus</h5>
                                    <h2>{{ \App\Models\Course::count() }}</h2>
                                    <a href="{{ route('courses.index') }}" class="btn btn-light btn-sm mt-2">Lihat Detail</a>
                                </div>
                            </div>
                        </div>

                        <!-- Card Enrollments -->
                        <div class="col-md-3 mb-3">
                            <div class="card text-white bg-warning">
                                <div class="card-body">
                                    <h5 class="card-title">Total Enrollment</h5>
                                    <h2>{{ \DB::table('course_student')->count() }}</h2>
                                    <a href="{{ route('enrollments.index') }}" class="btn btn-light btn-sm mt-2">Lihat Detail</a>
                                </div>
                            </div>
                        </div>

                        <!-- Card Tugas -->
                        <div class="col-md-3 mb-3">
                            <div class="card text-white bg-info">
                                <div class="card-body">
                                    <h5 class="card-title">Total Tugas</h5>
                                    <h2>{{ \App\Models\Assignment::count() }}</h2>
                                    <a href="{{ route('assignments.index') }}" class="btn btn-light btn-sm mt-2">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h4>Quick Actions</h4>
                            <div class="list-group">
                                <a href="{{ route('students.create') }}" class="list-group-item list-group-item-action">
                                    ➕ Tambah Mahasiswa Baru
                                </a>
                                <a href="{{ route('courses.create') }}" class="list-group-item list-group-item-action">
                                    ➕ Tambah Kursus Baru
                                </a>
                                <a href="{{ route('enrollments.create') }}" class="list-group-item list-group-item-action">
                                    📝 Daftarkan Mahasiswa ke Kursus
                                </a>
                                <a href="{{ route('assignments.create') }}" class="list-group-item list-group-item-action">
                                    📄 Upload Tugas Mahasiswa
                                </a>
                                <a href="{{ route('reports.students') }}" class="list-group-item list-group-item-action">
                                    📊 Lihat Laporan Performa Mahasiswa
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection