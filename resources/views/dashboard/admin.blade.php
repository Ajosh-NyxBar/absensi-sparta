@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin</h2>
                <p class="text-muted">Selamat datang di Sistem Informasi Presensi dan Penilaian SMPN 4 Purwakarta</p>
            </div>
            @php
                $activeYear = \App\Models\AcademicYear::getActive();
            @endphp
            @if($activeYear)
                <div class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); font-size: 14px;">
                    <i class="fas fa-calendar-check me-1"></i>{{ $activeYear->full_name }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    @php
        $teachersCount = \App\Models\Teacher::count();
        $studentsCount = \App\Models\Student::where('status', 'active')->count();
        $classesCount = \App\Models\ClassRoom::count();
        $subjectsCount = \App\Models\Subject::count();
        $attendanceToday = \App\Models\Attendance::where('date', today())->count();
        
        // Calculate percentages (compared to capacity or expected)
        $totalCapacity = \App\Models\ClassRoom::sum('capacity') ?: 1;
        $studentPercentage = round(($studentsCount / $totalCapacity) * 100);
        
        $expectedAttendance = $teachersCount + $studentsCount;
        $attendancePercentage = $expectedAttendance > 0 ? round(($attendanceToday / $expectedAttendance) * 100) : 0;
    @endphp
    
    <!-- Total Guru -->
    <div class="col-md-3 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1 small">Total Guru</p>
                        <h2 class="mb-0 fw-bold">{{ $teachersCount }}</h2>
                        <small class="text-success">
                            <i class="fas fa-user-check me-1"></i>{{ \App\Models\Teacher::whereHas('user')->count() }} aktif
                        </small>
                    </div>
                    <div class="rounded-circle p-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-chalkboard-teacher fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Total Siswa -->
    <div class="col-md-3 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1 small">Total Siswa</p>
                        <h2 class="mb-0 fw-bold text-success">{{ $studentsCount }}</h2>
                        <small class="text-muted">
                            <i class="fas fa-chart-pie me-1"></i>{{ $studentPercentage }}% kapasitas
                        </small>
                    </div>
                    <div class="rounded-circle p-3 bg-success">
                        <i class="fas fa-user-graduate fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Total Kelas -->
    <div class="col-md-3 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1 small">Total Kelas</p>
                        <h2 class="mb-0 fw-bold text-warning">{{ $classesCount }}</h2>
                        <small class="text-muted">
                            <i class="fas fa-book me-1"></i>{{ $subjectsCount }} mata pelajaran
                        </small>
                    </div>
                    <div class="rounded-circle p-3 bg-warning">
                        <i class="fas fa-door-open fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Presensi Hari Ini -->
    <div class="col-md-3 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1 small">Presensi Hari Ini</p>
                        <h2 class="mb-0 fw-bold text-info">{{ $attendanceToday }}</h2>
                        <small class="{{ $attendancePercentage >= 80 ? 'text-success' : 'text-warning' }}">
                            <i class="fas fa-chart-line me-1"></i>{{ $attendancePercentage }}% hadir
                        </small>
                    </div>
                    <div class="rounded-circle p-3 bg-info">
                        <i class="fas fa-clipboard-check fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats Row -->
<div class="row">
    <div class="col-md-3 col-sm-6 mb-4">
        <div class="card border-0 border-start border-primary border-4 shadow-sm">
            <div class="card-body py-3">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="small text-muted">User Aktif</div>
                        <div class="h5 mb-0">{{ \App\Models\User::count() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-4">
        <div class="card border-0 border-start border-success border-4 shadow-sm">
            <div class="card-body py-3">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-book fa-2x text-success"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="small text-muted">Mata Pelajaran</div>
                        <div class="h5 mb-0">{{ $subjectsCount }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-4">
        <div class="card border-0 border-start border-warning border-4 shadow-sm">
            <div class="card-body py-3">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-calendar-alt fa-2x text-warning"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="small text-muted">Tahun Ajaran</div>
                        <div class="h5 mb-0">{{ \App\Models\AcademicYear::count() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-4">
        <div class="card border-0 border-start border-info border-4 shadow-sm">
            <div class="card-body py-3">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-chart-line fa-2x text-info"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="small text-muted">Total Nilai</div>
                        <div class="h5 mb-0">{{ \App\Models\Grade::count() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row">
    <!-- Student Distribution by Grade -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Distribusi Siswa per Tingkat</h5>
            </div>
            <div class="card-body">
                <canvas id="studentsByGradeChart" height="250"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Attendance This Week -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Trend Presensi 7 Hari Terakhir</h5>
            </div>
            <div class="card-body">
                <canvas id="attendanceWeeklyChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Classes and Attendance Status Row -->
<div class="row">
    <!-- Top Classes by Students -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Kelas Terbanyak Siswa</h5>
            </div>
            <div class="card-body">
                <canvas id="topClassesChart" height="250"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Attendance by Status Today -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-chart-doughnut me-2"></i>Status Presensi Hari Ini</h5>
            </div>
            <div class="card-body">
                <canvas id="attendanceStatusChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Attendance -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Presensi Terakhir</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Waktu</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\Attendance::with('attendable')->latest()->take(5)->get() as $attendance)
                            <tr>
                                <td>
                                    <strong>{{ $attendance->attendable->name ?? '-' }}</strong>
                                </td>
                                <td>
                                    @if($attendance->attendable_type == 'App\Models\Teacher')
                                        <span class="badge bg-primary">Guru</span>
                                    @else
                                        <span class="badge bg-success">Siswa</span>
                                    @endif
                                </td>
                                <td>
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $attendance->check_in ? $attendance->check_in->format('H:i') : '-' }}
                                </td>
                                <td>
                                    @if($attendance->status == 'present')
                                        <span class="badge bg-success"><i class="fas fa-check me-1"></i>Hadir</span>
                                    @elseif($attendance->status == 'late')
                                        <span class="badge bg-warning"><i class="fas fa-exclamation me-1"></i>Terlambat</span>
                                    @elseif($attendance->status == 'sick')
                                        <span class="badge bg-info"><i class="fas fa-heartbeat me-1"></i>Sakit</span>
                                    @elseif($attendance->status == 'permission')
                                        <span class="badge bg-secondary"><i class="fas fa-envelope me-1"></i>Izin</span>
                                    @else
                                        <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Alpha</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    Belum ada data presensi
                                </td>
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
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('teachers.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-user-plus me-2"></i>Tambah Guru Baru
                    </a>
                    <a href="{{ route('students.create') }}" class="btn btn-outline-success">
                        <i class="fas fa-user-plus me-2"></i>Tambah Siswa Baru
                    </a>
                    <a href="{{ route('attendances.index') }}" class="btn btn-outline-info">
                        <i class="fas fa-clipboard-list me-2"></i>Lihat Daftar Presensi
                    </a>
                    <a href="{{ route('saw.students.index') }}" class="btn btn-outline-warning">
                        <i class="fas fa-chart-bar me-2"></i>Hitung SAW Siswa
                    </a>
                    <a href="{{ route('saw.teachers.index') }}" class="btn btn-outline-danger">
                        <i class="fas fa-chart-line me-2"></i>Hitung SAW Guru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart.js Global Configuration
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#6c757d';
    
    // Gradient Colors
    const primaryGradient = (ctx) => {
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(102, 126, 234, 0.8)');
        gradient.addColorStop(1, 'rgba(118, 75, 162, 0.8)');
        return gradient;
    };
    
    // 1. Students by Grade Chart (Pie)
    @php
        $studentsByGrade = \App\Models\Student::where('status', 'active')
            ->join('classes', 'students.class_id', '=', 'classes.id')
            ->select('classes.grade', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('classes.grade')
            ->orderBy('classes.grade')
            ->get();
    @endphp
    
    const studentsByGradeCtx = document.getElementById('studentsByGradeChart').getContext('2d');
    new Chart(studentsByGradeCtx, {
        type: 'doughnut',
        data: {
            labels: [@foreach($studentsByGrade as $item)'Kelas {{ $item->grade }}',@endforeach],
            datasets: [{
                data: [@foreach($studentsByGrade as $item){{ $item->total }},@endforeach],
                backgroundColor: [
                    'rgba(102, 126, 234, 0.8)',
                    'rgba(118, 75, 162, 0.8)',
                    'rgba(52, 211, 153, 0.8)',
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        font: { size: 12 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return label + ': ' + value + ' siswa (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
    
    // 2. Attendance Weekly Chart (Line)
    @php
        $attendanceWeekly = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::today()->subDays($i);
            $attendanceWeekly[] = [
                'date' => $date->format('D, d M'),
                'count' => \App\Models\Attendance::where('date', $date->format('Y-m-d'))->count(),
            ];
        }
    @endphp
    
    const attendanceWeeklyCtx = document.getElementById('attendanceWeeklyChart').getContext('2d');
    const weeklyGradient = attendanceWeeklyCtx.createLinearGradient(0, 0, 0, 300);
    weeklyGradient.addColorStop(0, 'rgba(102, 126, 234, 0.3)');
    weeklyGradient.addColorStop(1, 'rgba(102, 126, 234, 0.05)');
    
    new Chart(attendanceWeeklyCtx, {
        type: 'line',
        data: {
            labels: [@foreach($attendanceWeekly as $item)'{{ $item['date'] }}',@endforeach],
            datasets: [{
                label: 'Jumlah Presensi',
                data: [@foreach($attendanceWeekly as $item){{ $item['count'] }},@endforeach],
                borderColor: 'rgba(102, 126, 234, 1)',
                backgroundColor: weeklyGradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#fff',
                pointBorderColor: 'rgba(102, 126, 234, 1)',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: { size: 14 },
                    bodyFont: { size: 13 },
                    callbacks: {
                        label: function(context) {
                            return 'Presensi: ' + context.parsed.y + ' orang';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5,
                        callback: function(value) {
                            return value;
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
    
    // 3. Top Classes Chart (Horizontal Bar)
    @php
        $topClasses = \App\Models\ClassRoom::withCount('students')
            ->orderByDesc('students_count')
            ->take(5)
            ->get();
    @endphp
    
    const topClassesCtx = document.getElementById('topClassesChart').getContext('2d');
    new Chart(topClassesCtx, {
        type: 'bar',
        data: {
            labels: [@foreach($topClasses as $class)'{{ $class->name }}',@endforeach],
            datasets: [{
                label: 'Jumlah Siswa',
                data: [@foreach($topClasses as $class){{ $class->students_count }},@endforeach],
                backgroundColor: [
                    'rgba(102, 126, 234, 0.8)',
                    'rgba(118, 75, 162, 0.8)',
                    'rgba(52, 211, 153, 0.8)',
                    'rgba(251, 191, 36, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                ],
                borderWidth: 0,
                borderRadius: 8
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Siswa: ' + context.parsed.x + ' orang';
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                y: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
    
    // 4. Attendance Status Chart (Doughnut)
    @php
        $attendanceByStatus = \App\Models\Attendance::where('date', today()->format('Y-m-d'))
            ->select('status', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
        
        $statusData = [
            'present' => 0,
            'late' => 0,
            'sick' => 0,
            'permission' => 0,
            'absent' => 0,
        ];
        
        foreach($attendanceByStatus as $item) {
            $statusData[$item->status] = $item->total;
        }
    @endphp
    
    const attendanceStatusCtx = document.getElementById('attendanceStatusChart').getContext('2d');
    new Chart(attendanceStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Hadir', 'Terlambat', 'Sakit', 'Izin', 'Alpha'],
            datasets: [{
                data: [
                    {{ $statusData['present'] }},
                    {{ $statusData['late'] }},
                    {{ $statusData['sick'] }},
                    {{ $statusData['permission'] }},
                    {{ $statusData['absent'] }}
                ],
                backgroundColor: [
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(251, 191, 36, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(156, 163, 175, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        font: { size: 12 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
