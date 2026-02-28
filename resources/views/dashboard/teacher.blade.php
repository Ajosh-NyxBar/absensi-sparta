@extends('layouts.modern')

@section('title', 'Dashboard Guru')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-teal-600 bg-clip-text text-transparent">
                Dashboard Guru
            </h1>
            <p class="text-gray-600 mt-1">Selamat datang, <span class="font-semibold">{{ Auth::user()->name }}</span></p>
        </div>
        @php
            $activeYear = \App\Models\AcademicYear::getActive();
        @endphp
        @if($activeYear)
            <div class="px-4 py-2.5 bg-gradient-to-r from-green-500 to-teal-600 text-white rounded-xl shadow-lg flex items-center gap-2">
                <i class="fas fa-calendar-check"></i>
                <span class="font-semibold">{{ $activeYear->full_name }}</span>
            </div>
        @endif
    </div>

    @php
        $teacher = Auth::user()->teacher;
        $todayAttendance = $teacher ? $teacher->attendances()->whereDate('date', today())->first() : null;
        
        // Statistik
        $totalClasses = $teacher ? $teacher->teacherSubjects()->distinct('class_id')->count('class_id') : 0;
        $totalGrades = $teacher ? \App\Models\Grade::where('teacher_id', $teacher->id)->count() : 0;
        $totalStudents = $teacher ? \App\Models\Student::whereIn('class_id', 
            $teacher->teacherSubjects()->pluck('class_id')
        )->distinct()->count() : 0;
        
        // Attendance rate this month
        $attendanceRate = 0;
        if ($teacher) {
            $startOfMonth = now()->startOfMonth();
            $endOfMonth = now()->endOfMonth();
            $attendanceRate = $teacher->getAttendancePercentage($startOfMonth, $endOfMonth);
        }
    @endphp

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Presensi Hari Ini -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg transition-all duration-200">
            @if($todayAttendance && $todayAttendance->check_in)
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">Hadir</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-1">Sudah Presensi</h3>
                <p class="text-sm text-gray-600">
                    Check-in: <span class="font-semibold text-green-600">{{ $todayAttendance->check_in->format('H:i') }}</span>
                </p>
                @if($todayAttendance->check_out)
                    <p class="text-sm text-gray-600">
                        Check-out: <span class="font-semibold text-green-600">{{ $todayAttendance->check_out->format('H:i') }}</span>
                    </p>
                @endif
            @else
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-exclamation-circle text-white text-xl"></i>
                    </div>
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-semibold">Belum</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum Presensi</h3>
                <a href="{{ route('attendances.scanner') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-500 to-teal-600 text-white rounded-lg hover:from-green-600 hover:to-teal-700 transition-all text-sm font-semibold">
                    <i class="fas fa-camera"></i>
                    Scan QR Code
                </a>
            @endif
        </div>

        <!-- Kehadiran Bulan Ini -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg transition-all duration-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar-check text-white text-xl"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($attendanceRate, 1) }}%</h3>
            <p class="text-sm text-gray-600 mb-3">Tingkat Kehadiran Bulan Ini</p>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-500" style="width: {{ $attendanceRate }}%"></div>
            </div>
        </div>

        <!-- Kelas Diampu -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg transition-all duration-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chalkboard text-white text-xl"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $totalClasses }}</h3>
            <p class="text-sm text-gray-600">Kelas Diampu</p>
        </div>

        <!-- Total Siswa -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg transition-all duration-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-rose-500 to-pink-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $totalStudents }}</h3>
            <p class="text-sm text-gray-600">Total Siswa</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
        <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-teal-50 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-bolt text-green-600"></i>
                Aksi Cepat
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('grades.create') }}" class="flex items-center gap-4 p-4 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl border border-blue-200 hover:shadow-md transition-all duration-200 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-edit text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Input Nilai</h3>
                        <p class="text-xs text-gray-600">Input nilai siswa</p>
                    </div>
                </a>

                <a href="{{ route('attendances.index') }}" class="flex items-center gap-4 p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl border border-purple-200 hover:shadow-md transition-all duration-200 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-history text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Riwayat Presensi</h3>
                        <p class="text-xs text-gray-600">Lihat kehadiran Anda</p>
                    </div>
                </a>

                <a href="{{ route('grades.index') }}" class="flex items-center gap-4 p-4 bg-gradient-to-br from-green-50 to-teal-50 rounded-xl border border-green-200 hover:shadow-md transition-all duration-200 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-teal-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Lihat Nilai</h3>
                        <p class="text-xs text-gray-600">Kelola nilai siswa</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    @if($teacher)
    <!-- Kelas yang Diampu & Jadwal Mengajar -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Kelas yang Diampu -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
            <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-purple-100 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-chalkboard-teacher text-purple-600"></i>
                    Kelas yang Diampu
                </h2>
            </div>
            <div class="p-6">
                @php
                    $teacherSubjects = $teacher->teacherSubjects()
                        ->with(['classRoom', 'subject'])
                        ->get()
                        ->groupBy('class_id');
                @endphp

                @if($teacherSubjects->isEmpty())
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500">Belum ada kelas yang diampu</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($teacherSubjects as $classId => $subjects)
                            @php
                                $class = $subjects->first()->classRoom;
                                $studentCount = $class ? $class->students()->where('status', 'active')->count() : 0;
                            @endphp
                            <div class="p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl border border-purple-200">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="font-bold text-gray-900">{{ $class->name ?? '-' }}</h3>
                                    <span class="px-2.5 py-1 bg-purple-200 text-purple-700 rounded-lg text-xs font-semibold">
                                        {{ $studentCount }} siswa
                                    </span>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($subjects as $ts)
                                        <span class="px-2.5 py-1 bg-white text-purple-700 rounded-lg text-xs font-semibold border border-purple-200">
                                            {{ $ts->subject->name ?? '-' }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Presensi Terakhir -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
            <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-teal-50 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-clock text-green-600"></i>
                    Presensi Terakhir
                </h2>
            </div>
            <div class="p-6">
                @php
                    $recentAttendances = $teacher->attendances()
                        ->orderBy('date', 'desc')
                        ->limit(5)
                        ->get();
                @endphp

                @if($recentAttendances->isEmpty())
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500">Belum ada riwayat presensi</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($recentAttendances as $attendance)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-teal-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-calendar-day text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">
                                            {{ $attendance->date->format('d M Y') }}
                                        </p>
                                        <p class="text-xs text-gray-600">
                                            {{ $attendance->check_in ? $attendance->check_in->format('H:i') : '-' }}
                                            @if($attendance->check_out)
                                                - {{ $attendance->check_out->format('H:i') }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">
                                    {{ $attendance->status }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Info Profil Guru -->
    @if($teacher)
    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl shadow-sm p-6 border border-blue-200">
        <div class="flex items-start gap-4">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-full flex items-center justify-center text-white font-bold text-2xl">
                {{ strtoupper(substr($teacher->name, 0, 1)) }}
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $teacher->name }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3">
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <i class="fas fa-id-card text-blue-600"></i>
                        <span>NIP: <span class="font-semibold">{{ $teacher->nip }}</span></span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <i class="fas fa-phone text-blue-600"></i>
                        <span>{{ $teacher->phone ?? '-' }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <i class="fas fa-graduation-cap text-blue-600"></i>
                        <span>{{ $teacher->education_level ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
