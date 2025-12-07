@extends('layouts.app')

@section('title', 'Dashboard Kepala Sekolah')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h2><i class="fas fa-tachometer-alt me-2"></i>Dashboard Kepala Sekolah</h2>
        <p class="text-muted">Monitoring dan Laporan Sekolah</p>
    </div>
</div>

<div class="row">
    <!-- Total Guru -->
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Guru</h6>
                        <h3 class="mb-0">{{ \App\Models\Teacher::count() }}</h3>
                    </div>
                    <div class="text-primary">
                        <i class="fas fa-chalkboard-teacher fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Total Siswa -->
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Siswa</h6>
                        <h3 class="mb-0">{{ \App\Models\Student::where('status', 'active')->count() }}</h3>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-user-graduate fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Kehadiran Guru Hari Ini -->
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Guru Hadir Hari Ini</h6>
                        <h3 class="mb-0">
                            {{ \App\Models\Attendance::where('attendable_type', 'App\Models\Teacher')
                                ->whereDate('date', today())
                                ->whereIn('status', ['present', 'late'])
                                ->count() }}
                        </h3>
                    </div>
                    <div class="text-info">
                        <i class="fas fa-user-check fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Rata-rata Nilai Siswa -->
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Rata-rata Nilai</h6>
                        <h3 class="mb-0">{{ number_format(\App\Models\Grade::avg('final_grade') ?? 0, 1) }}</h3>
                    </div>
                    <div class="text-warning">
                        <i class="fas fa-chart-line fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Top 10 Siswa Berprestasi -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-trophy me-2"></i>Top 10 Siswa Berprestasi</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Skor SAW</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\StudentAssessment::with('student.classRoom')
                                ->orderBy('rank')
                                ->take(10)
                                ->get() as $assessment)
                            <tr>
                                <td>
                                    @if($assessment->rank == 1)
                                        <i class="fas fa-medal text-warning"></i>
                                    @elseif($assessment->rank == 2)
                                        <i class="fas fa-medal text-secondary"></i>
                                    @elseif($assessment->rank == 3)
                                        <i class="fas fa-medal" style="color: #cd7f32;"></i>
                                    @else
                                        {{ $assessment->rank }}
                                    @endif
                                </td>
                                <td>{{ $assessment->student->name ?? '-' }}</td>
                                <td>{{ $assessment->student->classRoom->name ?? '-' }}</td>
                                <td>
                                    <strong>{{ number_format($assessment->saw_score, 4) }}</strong>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data penilaian</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Laporan dan Analisis</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('saw.students.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-trophy me-2"></i>Laporan Prestasi Siswa (SAW)
                    </a>
                    <a href="{{ route('saw.teachers.index') }}" class="btn btn-outline-success">
                        <i class="fas fa-award me-2"></i>Laporan Prestasi Guru (SAW)
                    </a>
                    <a href="{{ route('attendances.index') }}" class="btn btn-outline-info">
                        <i class="fas fa-clipboard-list me-2"></i>Laporan Presensi
                    </a>
                    <a href="{{ route('students.index') }}" class="btn btn-outline-warning">
                        <i class="fas fa-users me-2"></i>Data Siswa
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
