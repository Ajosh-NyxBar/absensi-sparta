@extends('layouts.modern')

@section('title', 'Detail Tahun Ajaran')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-sky-50 via-cyan-50 to-blue-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-sky-600 to-cyan-600 bg-clip-text text-transparent mb-2">
                        Detail Tahun Ajaran
                    </h1>
                    <p class="text-gray-600 flex items-center gap-2">
                        <i class="fas fa-calendar-alt"></i>
                        Informasi lengkap {{ $academicYear->full_name }}
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('academic-years.edit', $academicYear->id) }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-amber-600 to-orange-600 text-white rounded-lg hover:from-amber-700 hover:to-orange-700 transition-all duration-200 shadow-md">
                        <i class="fas fa-edit"></i>
                        <span>Edit</span>
                    </a>
                    <a href="{{ route('academic-years.index') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-sm border border-gray-200">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Info Tahun Ajaran Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-sky-100 overflow-hidden">
                    <div class="bg-gradient-to-br from-sky-600 to-cyan-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-info-circle"></i>
                            <span>Informasi Tahun Ajaran</span>
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <div class="bg-sky-50 rounded-lg p-3 border border-sky-100">
                                <p class="text-xs text-sky-600 font-semibold mb-1 flex items-center gap-2">
                                    <i class="fas fa-calendar"></i>
                                    Tahun Ajaran
                                </p>
                                <p class="text-gray-800 font-bold text-lg">{{ $academicYear->year }}</p>
                            </div>
                            
                            <div class="bg-cyan-50 rounded-lg p-3 border border-cyan-100">
                                <p class="text-xs text-cyan-600 font-semibold mb-1 flex items-center gap-2">
                                    <i class="fas fa-book-open"></i>
                                    Semester
                                </p>
                                @if($academicYear->semester == 'Ganjil')
                                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-cyan-100 text-cyan-700 rounded-lg font-semibold text-sm border border-cyan-200">
                                        <i class="fas fa-circle-notch"></i>
                                        Semester {{ $academicYear->semester }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 text-green-700 rounded-lg font-semibold text-sm border border-green-200">
                                        <i class="fas fa-circle-check"></i>
                                        Semester {{ $academicYear->semester }}
                                    </span>
                                @endif
                            </div>
                            
                            <div class="bg-sky-50 rounded-lg p-3 border border-sky-100">
                                <p class="text-xs text-sky-600 font-semibold mb-1 flex items-center gap-2">
                                    <i class="fas fa-calendar-day"></i>
                                    Tanggal Mulai
                                </p>
                                <p class="text-gray-800 font-medium">{{ $academicYear->start_date->format('d F Y') }}</p>
                            </div>
                            
                            <div class="bg-cyan-50 rounded-lg p-3 border border-cyan-100">
                                <p class="text-xs text-cyan-600 font-semibold mb-1 flex items-center gap-2">
                                    <i class="fas fa-calendar-check"></i>
                                    Tanggal Selesai
                                </p>
                                <p class="text-gray-800 font-medium">{{ $academicYear->end_date->format('d F Y') }}</p>
                            </div>
                            
                            <div class="bg-blue-50 rounded-lg p-3 border border-blue-100">
                                <p class="text-xs text-blue-600 font-semibold mb-1 flex items-center gap-2">
                                    <i class="fas fa-hourglass-half"></i>
                                    Durasi
                                </p>
                                <p class="text-gray-800 font-medium">{{ $academicYear->start_date->diffInDays($academicYear->end_date) }} hari</p>
                            </div>
                            
                            <div class="bg-sky-50 rounded-lg p-3 border border-sky-100">
                                <p class="text-xs text-sky-600 font-semibold mb-1 flex items-center gap-2">
                                    <i class="fas fa-toggle-on"></i>
                                    Status
                                </p>
                                @if($academicYear->is_active)
                                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 text-green-700 rounded-lg font-semibold text-sm border border-green-200">
                                        <i class="fas fa-check-circle"></i>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-gray-100 text-gray-700 rounded-lg font-semibold text-sm border border-gray-200">
                                        <i class="fas fa-times-circle"></i>
                                        Non-Aktif
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        @if($academicYear->description)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-xs text-gray-600 font-semibold mb-2 flex items-center gap-2">
                                <i class="fas fa-sticky-note"></i>
                                Keterangan
                            </p>
                            <p class="text-sm text-gray-700">{{ $academicYear->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Timeline Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-cyan-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-600 to-blue-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-clock"></i>
                            <span>Timeline</span>
                        </h3>
                    </div>
                    <div class="p-6">
                        @php
                            $now = now();
                            $total = $academicYear->start_date->diffInDays($academicYear->end_date);
                            $elapsed = $academicYear->start_date->diffInDays($now);
                            $percentage = $total > 0 ? min(100, max(0, ($elapsed / $total) * 100)) : 0;
                            
                            $isUpcoming = $now->lt($academicYear->start_date);
                            $isOngoing = $now->between($academicYear->start_date, $academicYear->end_date);
                            $isFinished = $now->gt($academicYear->end_date);
                        @endphp
                        
                        @if($isUpcoming)
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-3">
                                <p class="text-sm font-semibold text-blue-700 flex items-center gap-2">
                                    <i class="fas fa-clock"></i>
                                    Belum dimulai
                                </p>
                            </div>
                            <p class="text-sm text-gray-700">
                                <strong>Dimulai dalam:</strong><br>
                                <span class="text-blue-600">{{ $now->diffForHumans($academicYear->start_date) }}</span>
                            </p>
                        @elseif($isOngoing)
                            <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-3">
                                <p class="text-sm font-semibold text-green-700 flex items-center gap-2">
                                    <i class="fas fa-play-circle"></i>
                                    Sedang berjalan
                                </p>
                            </div>
                            <div class="mb-3">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-xs text-gray-600">Progress</span>
                                    <span class="text-xs font-bold text-green-600">{{ round($percentage) }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-5 overflow-hidden">
                                    <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-5 rounded-full flex items-center justify-center text-white text-xs font-bold transition-all duration-300" 
                                         style="width: {{ $percentage }}%;">
                                        @if($percentage > 15)
                                            {{ round($percentage) }}%
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-gray-700">
                                <strong>Berakhir dalam:</strong><br>
                                <span class="text-green-600">{{ $now->diffForHumans($academicYear->end_date) }}</span>
                            </p>
                        @else
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 mb-3">
                                <p class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                                    <i class="fas fa-check-circle"></i>
                                    Sudah selesai
                                </p>
                            </div>
                            <p class="text-sm text-gray-700">
                                <strong>Berakhir:</strong><br>
                                <span class="text-gray-600">{{ $academicYear->end_date->diffForHumans() }}</span>
                            </p>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2">
                
                <!-- Data Terkait Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-sky-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-sky-600 to-cyan-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-database"></i>
                            <span>Data Terkait</span>
                        </h3>
                    </div>
                    <div class="p-6">
                        @php
                            $relatedData = $academicYear->getRelatedDataInfo();
                        @endphp
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="bg-gradient-to-br from-sky-50 to-cyan-50 rounded-xl p-6 text-center border-2 border-sky-200">
                                <i class="fas fa-door-open text-5xl text-sky-600 mb-3"></i>
                                <h3 class="text-4xl font-bold text-sky-700 mb-1">{{ $relatedData['classes'] }}</h3>
                                <p class="text-gray-600 font-medium">Kelas</p>
                            </div>
                            <div class="bg-gradient-to-br from-cyan-50 to-blue-50 rounded-xl p-6 text-center border-2 border-cyan-200">
                                <i class="fas fa-chart-line text-5xl text-cyan-600 mb-3"></i>
                                <h3 class="text-4xl font-bold text-cyan-700 mb-1">{{ $relatedData['grades'] }}</h3>
                                <p class="text-gray-600 font-medium">Nilai</p>
                            </div>
                        </div>
                        
                        @if($relatedData['classes'] > 0)
                            <div class="border-t border-gray-200 pt-6">
                                <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                    <i class="fas fa-door-open text-sky-600"></i>
                                    Daftar Kelas
                                </h4>
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead class="bg-sky-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-sky-700 uppercase tracking-wider">No</th>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-sky-700 uppercase tracking-wider">Nama Kelas</th>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-sky-700 uppercase tracking-wider">Tingkat</th>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-sky-700 uppercase tracking-wider">Jumlah Siswa</th>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-sky-700 uppercase tracking-wider">Kapasitas</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-sky-100">
                                            @foreach(\App\Models\ClassRoom::where('academic_year', $academicYear->year)->get() as $index => $class)
                                            <tr class="hover:bg-sky-50/50 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">{{ $index + 1 }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <strong class="text-gray-800">{{ $class->name }}</strong>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-100 text-sky-700 rounded-lg font-semibold text-xs border border-sky-200">
                                                        <i class="fas fa-layer-group"></i>
                                                        Kelas {{ $class->grade }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                    <i class="fas fa-users mr-1 text-cyan-600"></i>
                                                    {{ $class->students()->count() }} siswa
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                    <i class="fas fa-chair mr-1 text-blue-600"></i>
                                                    {{ $class->capacity ?? 30 }} siswa
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                                <i class="fas fa-info-circle text-3xl text-blue-600 mb-2"></i>
                                <p class="text-blue-700 font-medium">Belum ada kelas yang menggunakan tahun ajaran ini.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
