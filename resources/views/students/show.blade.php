@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Detail Mahasiswa</h4>
                    <a href="{{ route('students.index') }}" class="btn btn-secondary">Kembali</a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Informasi Pribadi</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">NIM</th>
                                    <td>{{ $student->nim }}</td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $student->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $student->email }}</td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td>{{ $student->phone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir</th>
                                    <td>{{ $student->birth_date ? $student->birth_date->format('d/m/Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $student->address ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h5>Statistik</h5>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p><strong>Total Kursus:</strong> {{ $student->courses->count() }}</p>
                                    <p><strong>Total Tugas:</strong> {{ $student->assignments->count() }}</p>
                                    <p><strong>Rata-rata Nilai:</strong> 
                                        <span class="badge bg-success">{{ number_format($student->getAverageScore(), 2) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h5>Kursus yang Diambil</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Kursus</th>
                                    <th>SKS</th>
                                    <th>Nilai Akhir</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($student->courses as $course)
                                    <tr>
                                        <td>{{ $course->code }}</td>
                                        <td>{{ $course->name }}</td>
                                        <td>{{ $course->credits }}</td>
                                        <td>{{ $course->pivot->final_score ?? '-' }}</td>
                                        <td>
                                            @if($course->pivot->grade)
                                                <span class="badge bg-primary">{{ $course->pivot->grade }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum mengambil kursus</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    <h5>Tugas yang Dikumpulkan</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Kursus</th>
                                    <th>File</th>
                                    <th>Nilai</th>
                                    <th>Tanggal Submit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($student->assignments as $assignment)
                                    <tr>
                                        <td>{{ $assignment->title }}</td>
                                        <td>{{ $assignment->course->name }}</td>
                                        <td>
                                            <a href="{{ route('assignments.download', $assignment) }}" class="btn btn-sm btn-info">
                                                Download
                                            </a>
                                        </td>
                                        <td>{{ $assignment->score ?? 'Belum dinilai' }}</td>
                                        <td>{{ $assignment->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada tugas yang dikumpulkan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection