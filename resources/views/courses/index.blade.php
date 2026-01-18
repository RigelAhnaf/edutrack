@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Data Kursus</h4>
                    <a href="{{ route('courses.create') }}" class="btn btn-primary">
                        ➕ Tambah Kursus
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Kursus</th>
                                    <th>SKS</th>
                                    <th>Semester</th>
                                    <th>Jumlah Mahasiswa</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($courses as $course)
                                    <tr>
                                        <td><strong>{{ $course->code }}</strong></td>
                                        <td>{{ $course->name }}</td>
                                        <td>{{ $course->credits }}</td>
                                        <td>{{ $course->semester }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $course->students_count }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-info">Detail</a>
                                            <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('courses.destroy', $course) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada data kursus</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $courses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection