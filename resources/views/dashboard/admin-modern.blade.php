@extends('layouts.modern')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-4 sm:space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="mt-1 text-xs sm:text-sm text-gray-500">
                Welcome back, <span class="font-semibold">{{ auth()->user()->name }}</span>
            </p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
            @if($activeYear)
            <span class="inline-flex items-center justify-center px-3 sm:px-4 py-2 rounded-lg bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-xs sm:text-sm font-medium shadow-lg">
                <i class="fas fa-calendar-check mr-2"></i>
                {{ $activeYear->year }} - Semester {{ $activeYear->semester }}
            </span>
            @endif
            <button class="inline-flex items-center justify-center px-3 sm:px-4 py-2 rounded-lg bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors text-xs sm:text-sm font-medium shadow-sm">
                <i class="fas fa-plus mr-2"></i>
                Add New Members
            </button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <!-- Total Students -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm p-4 sm:p-6 card-hover border border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Total Students</p>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 flex items-center">
                        {{ number_format($totalStudents) }}
                        @if($studentGrowth > 0)
                        <span class="ml-2 inline-flex items-center text-green-600 text-xs sm:text-sm">
                            <i class="fas fa-arrow-up mr-1"></i>
                            {{ $studentGrowth }}%
                        </span>
                        @endif
                    </h3>
                    <div class="mt-3 sm:mt-4">
                        <svg class="w-full h-8 sm:h-12" viewBox="0 0 100 30" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="grad1" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" style="stop-color:#667eea;stop-opacity:0.3" />
                                    <stop offset="100%" style="stop-color:#667eea;stop-opacity:0" />
                                </linearGradient>
                            </defs>
                            <path d="M 0 20 Q 25 15, 50 18 T 100 15" 
                                  fill="none" 
                                  stroke="#667eea" 
                                  stroke-width="2"/>
                            <path d="M 0 20 Q 25 15, 50 18 T 100 15 L 100 30 L 0 30 Z" 
                                  fill="url(#grad1)"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-3 sm:ml-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg sm:rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-user-graduate text-white text-xl sm:text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Teachers -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm p-4 sm:p-6 card-hover border border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Total Teachers</p>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 flex items-center">
                        {{ number_format($totalTeachers) }}
                        @if($teacherGrowth > 0)
                        <span class="ml-2 inline-flex items-center text-green-600 text-xs sm:text-sm">
                            <i class="fas fa-arrow-up mr-1"></i>
                            {{ $teacherGrowth }}%
                        </span>
                        @else
                        <span class="ml-2 inline-flex items-center text-red-600 text-xs sm:text-sm">
                            <i class="fas fa-arrow-down mr-1"></i>
                            {{ abs($teacherGrowth) }}%
                        </span>
                        @endif
                    </h3>
                    <div class="mt-3 sm:mt-4">
                        <svg class="w-full h-8 sm:h-12" viewBox="0 0 100 30" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="grad2" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" style="stop-color:#f093fb;stop-opacity:0.3" />
                                    <stop offset="100%" style="stop-color:#f093fb;stop-opacity:0" />
                                </linearGradient>
                            </defs>
                            <path d="M 0 18 Q 25 22, 50 16 T 100 14" 
                                  fill="none" 
                                  stroke="#f093fb" 
                                  stroke-width="2"/>
                            <path d="M 0 18 Q 25 22, 50 16 T 100 14 L 100 30 L 0 30 Z" 
                                  fill="url(#grad2)"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-3 sm:ml-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-pink-400 to-red-500 rounded-lg sm:rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-chalkboard-teacher text-white text-xl sm:text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Today -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm p-4 sm:p-6 card-hover border border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Attendance Today</p>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 flex items-center">
                        {{ number_format($attendancePercentage, 1) }}%
                        <span class="ml-2 inline-flex items-center text-green-600 text-xs sm:text-sm">
                            <i class="fas fa-arrow-up mr-1"></i>
                            {{ number_format($attendancePercentage - 85, 1) }}%
                        </span>
                    </h3>
                    <div class="mt-3 sm:mt-4">
                        <div class="flex items-center space-x-2">
                            <div class="flex-1 bg-gray-200 rounded-full h-1.5 sm:h-2">
                                <div class="bg-gradient-to-r from-green-400 to-green-600 h-1.5 sm:h-2 rounded-full" 
                                     style="width: {{ $attendancePercentage }}%"></div>
                            </div>
                            <span class="text-[10px] sm:text-xs text-gray-500">{{ $totalPresentToday }}/{{ $totalStudents }}</span>
                        </div>
                    </div>
                </div>
                <div class="ml-3 sm:ml-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-green-400 to-green-600 rounded-lg sm:rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-check-circle text-white text-xl sm:text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Classes -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm p-4 sm:p-6 card-hover border border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Total Classes</p>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900">
                        {{ number_format($totalClasses) }}
                    </h3>
                    <div class="mt-3 sm:mt-4 flex items-center space-x-2 sm:space-x-4">
                        <div class="text-center">
                            <p class="text-[10px] sm:text-xs text-gray-500">Grade 7</p>
                            <p class="text-sm sm:text-lg font-semibold text-gray-900">{{ $classesByGrade->get(7, 0) }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-[10px] sm:text-xs text-gray-500">Grade 8</p>
                            <p class="text-sm sm:text-lg font-semibold text-gray-900">{{ $classesByGrade->get(8, 0) }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-[10px] sm:text-xs text-gray-500">Grade 9</p>
                            <p class="text-sm sm:text-lg font-semibold text-gray-900">{{ $classesByGrade->get(9, 0) }}</p>
                        </div>
                    </div>
                </div>
                <div class="ml-3 sm:ml-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg sm:rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-door-open text-white text-xl sm:text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Student Distribution Chart -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-3 sm:mb-4">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900">Student Distribution</h3>
                <button class="text-gray-400 hover:text-gray-600 text-sm sm:text-base">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
            </div>
            <div class="relative" style="height: 200px;">
                <canvas id="studentDistChart"></canvas>
            </div>
        </div>

        <!-- Weekly Attendance Chart -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm p-4 sm:p-6 border border-gray-100 lg:col-span-2">
            <div class="flex items-center justify-between mb-3 sm:mb-4">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900">Weekly Attendance</h3>
                <div class="flex items-center space-x-2">
                    <span class="text-[10px] sm:text-xs text-gray-500">Last 7 days</span>
                    <button class="text-gray-400 hover:text-gray-600 text-sm sm:text-base">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                </div>
            </div>
            <div class="relative" style="height: 200px;">
                <canvas id="weeklyAttendanceChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Recent Attendance Table -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 lg:col-span-2">
            <div class="p-4 sm:p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Recent Attendance</h3>
                    <a href="{{ route('attendances.index') }}" class="text-xs sm:text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                        View all →
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-[10px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-[10px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Check In</th>
                            <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-[10px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentAttendances->take(5) as $attendance)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center mr-2 sm:mr-3">
                                        <span class="text-white font-semibold text-xs sm:text-sm">
                                            {{ substr($attendance->student ? $attendance->student->name : $attendance->teacher->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-xs sm:text-sm font-medium text-gray-900">
                                            {{ $attendance->student ? $attendance->student->name : $attendance->teacher->name }}
                                        </p>
                                        <p class="text-[10px] sm:text-xs text-gray-500">
                                            {{ $attendance->student ? 'Student' : 'Teacher' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500 hidden sm:table-cell">
                                {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '-' }}
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'present' => 'bg-green-100 text-green-800',
                                        'late' => 'bg-yellow-100 text-yellow-800',
                                        'absent' => 'bg-red-100 text-red-800',
                                        'sick' => 'bg-blue-100 text-blue-800',
                                        'permission' => 'bg-purple-100 text-purple-800'
                                    ];
                                    $statusLabels = [
                                        'present' => 'Present',
                                        'late' => 'Late',
                                        'absent' => 'Absent',
                                        'sick' => 'Sick',
                                        'permission' => 'Permission'
                                    ];
                                @endphp
                                <span class="px-2 sm:px-3 py-0.5 sm:py-1 inline-flex text-[10px] sm:text-xs leading-5 font-semibold rounded-full {{ $statusColors[$attendance->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusLabels[$attendance->status] ?? ucfirst($attendance->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-3 sm:px-6 py-8 sm:py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-2xl sm:text-4xl mb-2"></i>
                                <p class="text-sm sm:text-base">No recent attendance</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Stats Cards -->
        <div class="space-y-3 sm:space-y-4">
            <!-- Monthly Summary -->
            <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 text-white">
                <h4 class="text-xs sm:text-sm font-medium mb-2 text-gray-300">Monthly Summary</h4>
                <div class="space-y-2 sm:space-y-3 mb-3 sm:mb-4">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] sm:text-xs text-gray-400">Attendance Rate</span>
                        <span class="text-base sm:text-lg font-bold">{{ number_format($monthlyAttendanceRate, 0) }}%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] sm:text-xs text-gray-400">Avg. Grade</span>
                        <span class="text-base sm:text-lg font-bold">{{ number_format($monthlyAvgGrade, 1) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] sm:text-xs text-gray-400">Completion</span>
                        <span class="text-base sm:text-lg font-bold">{{ number_format($monthlyCompletion, 0) }}%</span>
                    </div>
                </div>
            </div>

            <!-- New Students -->
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="text-xs sm:text-sm font-medium">New Students</h4>
                    <span class="text-[10px] sm:text-xs bg-white/20 px-2 py-1 rounded">This Month</span>
                </div>
                <p class="text-2xl sm:text-3xl font-bold mb-1">{{ $newStudentsThisMonth }}</p>
                <p class="text-[10px] sm:text-xs text-white/70">+{{ number_format(($newStudentsThisMonth / max($totalStudents, 1)) * 100, 1) }}% from last month</p>
            </div>

            <!-- Active Classes -->
            <div class="bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="text-xs sm:text-sm font-medium">Active Classes</h4>
                    <span class="text-[10px] sm:text-xs bg-white/20 px-2 py-1 rounded">Today</span>
                </div>
                <p class="text-2xl sm:text-3xl font-bold mb-1">{{ $activeClassesToday }}</p>
                <p class="text-[10px] sm:text-xs text-white/70">{{ number_format(($activeClassesToday / max($totalClasses, 1)) * 100, 0) }}% of total classes</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Student Distribution Chart
const studentCtx = document.getElementById('studentDistChart');
if (studentCtx) {
    new Chart(studentCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($studentsByGrade->pluck('grade')) !!},
            datasets: [{
                data: {!! json_encode($studentsByGrade->pluck('total')) !!},
                backgroundColor: [
                    'rgba(102, 126, 234, 0.8)',
                    'rgba(237, 100, 166, 0.8)',
                    'rgba(255, 159, 64, 0.8)'
                ],
                borderWidth: 0
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
                }
            }
        }
    });
}

// Weekly Attendance Chart
const weeklyCtx = document.getElementById('weeklyAttendanceChart');
if (weeklyCtx) {
    new Chart(weeklyCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($attendanceWeekly->pluck('date')) !!},
            datasets: [{
                label: 'Attendance',
                data: {!! json_encode($attendanceWeekly->pluck('count')) !!},
                borderColor: 'rgb(102, 126, 234)',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
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
}
</script>
@endpush
@endsection
