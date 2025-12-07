@extends('layouts.modern')

@section('title', 'Riwayat Presensi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                Riwayat Presensi
            </h1>
            <p class="text-gray-600 mt-1">Kelola dan lihat riwayat kehadiran Anda</p>
        </div>
        <div class="flex items-center gap-3">
            @if(Auth::user()->role->name === 'Admin' || Auth::user()->role->name === 'Kepala Sekolah')
            <a href="{{ route('attendances.admin-qr') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-pink-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                <i class="fas fa-qrcode"></i>
                <span>Tampilkan QR Code</span>
            </a>
            @endif
            
            @if(Auth::user()->role->name === 'Guru')
            <a href="{{ route('attendances.scanner') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                <i class="fas fa-camera"></i>
                <span>Scan QR Code</span>
            </a>
            @endif
        </div>
    </div>

    @php
        $teacher = Auth::user()->teacher;
        
        // Statistics
        $totalAttendances = 0;
        $presentCount = 0;
        $lateCount = 0;
        $absentCount = 0;
        $attendanceRate = 0;
        
        if ($teacher) {
            $startOfMonth = now()->startOfMonth();
            $endOfMonth = now()->endOfMonth();
            
            $monthlyAttendances = $teacher->attendances()
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->get();
            
            $totalAttendances = $monthlyAttendances->count();
            $presentCount = $monthlyAttendances->where('status', 'Hadir')->count();
            $lateCount = $monthlyAttendances->where('status', 'Terlambat')->count();
            $absentCount = $monthlyAttendances->whereIn('status', ['Sakit', 'Izin', 'Alpha'])->count();
            
            // Calculate attendance rate
            $workingDays = now()->diffInDaysFiltered(function($date) use ($startOfMonth, $endOfMonth) {
                return $date->isWeekday() && $date >= $startOfMonth && $date <= $endOfMonth;
            }, $startOfMonth);
            
            if ($workingDays > 0) {
                $attendanceRate = ($presentCount / $workingDays) * 100;
            }
        }
    @endphp

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Total Presensi -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg transition-all duration-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar-check text-white text-xl"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $totalAttendances }}</h3>
            <p class="text-sm text-gray-600">Total Presensi Bulan Ini</p>
        </div>

        <!-- Hadir -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg transition-all duration-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $presentCount }}</h3>
            <p class="text-sm text-gray-600">Hadir</p>
        </div>

        <!-- Terlambat -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg transition-all duration-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $lateCount }}</h3>
            <p class="text-sm text-gray-600">Terlambat</p>
        </div>

        <!-- Tidak Hadir -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg transition-all duration-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-times-circle text-white text-xl"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $absentCount }}</h3>
            <p class="text-sm text-gray-600">Sakit/Izin/Alpha</p>
        </div>
    </div>

    <!-- Attendance Rate -->
    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl shadow-sm p-6 border border-indigo-200">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Tingkat Kehadiran Bulan Ini</h3>
                <p class="text-sm text-gray-600">{{ now()->format('F Y') }}</p>
            </div>
            <div class="text-right">
                <p class="text-4xl font-bold text-indigo-600">{{ number_format($attendanceRate, 1) }}%</p>
            </div>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-3 rounded-full transition-all duration-500" style="width: {{ $attendanceRate }}%"></div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <form method="GET" action="{{ route('attendances.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Tanggal -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
                <input type="date" 
                       name="date" 
                       value="{{ request('date', today()->format('Y-m-d')) }}" 
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
            </div>

            <!-- Type (Untuk Admin) -->
            @if(Auth::user()->role->name !== 'Guru')
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe</label>
                <select name="type" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                    <option value="">Semua</option>
                    <option value="teacher" {{ request('type') == 'teacher' ? 'selected' : '' }}>Guru</option>
                    <option value="student" {{ request('type') == 'student' ? 'selected' : '' }}>Siswa</option>
                </select>
            </div>
            @endif

            <!-- Button -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-600 hover:to-purple-700 transition-all duration-200">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>
                <a href="{{ route('attendances.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-all duration-200">
                    <i class="fas fa-redo"></i>
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Attendance List -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
        <div class="px-6 py-5 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-list text-indigo-600"></i>
                    Daftar Presensi
                    @if(request('date'))
                        - {{ \Carbon\Carbon::parse(request('date'))->format('d M Y') }}
                    @else
                        - Hari Ini
                    @endif
                </h2>
            </div>
        </div>

        <div class="p-6">
            @if($attendances->isEmpty())
                <div class="text-center py-16">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-times text-gray-400 text-3xl"></i>
                    </div>
                    <p class="text-gray-500 mb-4">Tidak ada data presensi</p>
                    <a href="{{ route('attendances.qr-code') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-600 hover:to-purple-700 transition-all duration-200">
                        <i class="fas fa-qrcode"></i>
                        Scan QR Code
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($attendances as $attendance)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                            <div class="flex items-center gap-4">
                                <!-- Avatar/Icon -->
                                <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                                    @if($attendance->attendable_type === 'App\Models\Teacher')
                                        <i class="fas fa-chalkboard-teacher text-white text-xl"></i>
                                    @else
                                        <i class="fas fa-user-graduate text-white text-xl"></i>
                                    @endif
                                </div>

                                <!-- Info -->
                                <div>
                                    <h3 class="font-bold text-gray-900">
                                        {{ $attendance->attendable->name ?? '-' }}
                                    </h3>
                                    <div class="flex items-center gap-3 mt-1">
                                        <span class="text-xs text-gray-600">
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ $attendance->date->format('d M Y') }}
                                        </span>
                                        @if($attendance->attendable_type === 'App\Models\Teacher')
                                            <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-xs font-semibold">
                                                Guru
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 bg-purple-100 text-purple-700 rounded text-xs font-semibold">
                                                Siswa
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Time & Status -->
                            <div class="flex items-center gap-4">
                                <!-- Check In/Out -->
                                <div class="text-right">
                                    @if($attendance->check_in)
                                        <p class="text-sm font-semibold text-gray-900">
                                            <i class="fas fa-sign-in-alt text-green-600 mr-1"></i>
                                            {{ $attendance->check_in->format('H:i') }}
                                        </p>
                                    @endif
                                    @if($attendance->check_out)
                                        <p class="text-sm font-semibold text-gray-900">
                                            <i class="fas fa-sign-out-alt text-red-600 mr-1"></i>
                                            {{ $attendance->check_out->format('H:i') }}
                                        </p>
                                    @endif
                                    @if(!$attendance->check_in && !$attendance->check_out)
                                        <p class="text-sm text-gray-500">-</p>
                                    @endif
                                </div>

                                <!-- Status Badge -->
                                @php
                                    $statusColors = [
                                        'Hadir' => 'bg-green-100 text-green-700',
                                        'Terlambat' => 'bg-yellow-100 text-yellow-700',
                                        'Sakit' => 'bg-blue-100 text-blue-700',
                                        'Izin' => 'bg-purple-100 text-purple-700',
                                        'Alpha' => 'bg-red-100 text-red-700',
                                    ];
                                    $color = $statusColors[$attendance->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="px-3 py-1.5 {{ $color }} rounded-lg text-sm font-semibold min-w-[100px] text-center">
                                    {{ $attendance->status }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($attendances->hasPages())
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        {{ $attendances->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
