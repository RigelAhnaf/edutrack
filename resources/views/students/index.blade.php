@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Data Mahasiswa</h4>
                    <a href="{{ route('students.create') }}" class="btn btn-primary">
                        ➕ Tambah Mahasiswa
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
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Telepon</th>
                                    <th>Jumlah Kursus</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                    <tr>
                                        <td>{{ $student->nim }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->phone ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $student->courses->count() }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-info">Detail</a>
                                            <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada data mahasiswa</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection