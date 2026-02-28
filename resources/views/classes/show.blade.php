@extends('layouts.modern')

@section('title', 'Detail Kelas')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-door-open text-white text-xl"></i>
                    </div>
                    Detail Kelas
                </h1>
                <p class="text-gray-600 mt-2">Informasi lengkap kelas <strong>{{ $class->name }}</strong></p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('attendances.class', $class->id) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transition-all duration-200 shadow-sm">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Input Presensi</span>
                </a>
                <a href="{{ route('classes.edit', $class->id) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-500 text-white font-semibold rounded-xl hover:bg-amber-600 transition-all duration-200 shadow-sm">
                    <i class="fas fa-edit"></i>
                    <span>Edit</span>
                </a>
                <a href="{{ route('classes.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all duration-200 shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column - Info & Stats -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Info Kelas Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-indigo-500 to-purple-600">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="fas fa-info-circle"></i>
                        Informasi Kelas
                    </h2>
                </div>
                
                <div class="p-6 space-y-4">
                    <div class="flex items-start justify-between pb-4 border-b border-gray-100">
                        <div class="flex items-center gap-3 text-gray-600">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-door-closed text-gray-600"></i>
                            </div>
                            <span class="text-sm font-medium">Nama Kelas</span>
                        </div>
                        <span class="text-gray-900 font-bold text-lg">{{ $class->name }}</span>
                    </div>
                    
                    <div class="flex items-start justify-between pb-4 border-b border-gray-100">
                        <div class="flex items-center gap-3 text-gray-600">
                            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                                <i class="fas fa-layer-group text-blue-600"></i>
                            </div>
                            <span class="text-sm font-medium">Tingkat</span>
                        </div>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg font-semibold text-sm">Kelas {{ $class->grade }}</span>
                    </div>
                    
                    <div class="flex items-start justify-between pb-4 border-b border-gray-100">
                        <div class="flex items-center gap-3 text-gray-600">
                            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-green-600"></i>
                            </div>
                            <span class="text-sm font-medium">Tahun Ajaran</span>
                        </div>
                        <span class="text-gray-900 font-semibold">{{ $class->academic_year }}</span>
                    </div>
                    
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3 text-gray-600">
                            <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                                <i class="fas fa-chair text-purple-600"></i>
                            </div>
                            <span class="text-sm font-medium">Kapasitas</span>
                        </div>
                        <span class="text-gray-900 font-semibold">{{ $class->capacity ?? 30 }} siswa</span>
                    </div>
                </div>
            </div>
            
            <!-- Statistik Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-cyan-500 to-blue-600">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="fas fa-chart-pie"></i>
                        Statistik
                    </h2>
                </div>
                
                <div class="p-6 space-y-6">
                    @php
                        $studentsCount = $class->students()->count();
                        $subjectsCount = $class->teacherSubjects()->count();
                        $capacity = $class->capacity ?? 30;
                        $percentage = $capacity > 0 ? ($studentsCount / $capacity) * 100 : 0;
                    @endphp
                    
                    <!-- Jumlah Siswa -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                                <i class="fas fa-users text-blue-600"></i>
                                Jumlah Siswa
                            </span>
                            <span class="font-bold text-gray-900">{{ $studentsCount }}/{{ $capacity }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500 {{ $percentage >= 90 ? 'bg-gradient-to-r from-red-500 to-red-600' : ($percentage >= 70 ? 'bg-gradient-to-r from-yellow-400 to-amber-500' : 'bg-gradient-to-r from-green-400 to-green-500') }}" 
                                 style="width: {{ min($percentage, 100) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ number_format($percentage, 1) }}% terisi</p>
                    </div>
                    
                    <!-- Jumlah Mata Pelajaran -->
                    <div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                                <i class="fas fa-book text-purple-600"></i>
                                Mata Pelajaran
                            </span>
                            <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-lg font-bold">{{ $subjectsCount }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Right Column - Students List -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-users text-indigo-600"></i>
                        Daftar Siswa
                    </h2>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-lg font-bold text-sm">
                        {{ $studentsCount }} siswa
                    </span>
                </div>
                
                <div class="p-6">
                    @if($class->students()->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider rounded-tl-lg">No</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NIS</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Siswa</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jenis Kelamin</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider rounded-tr-lg">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($class->students as $index => $student)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <code class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-sm font-mono">{{ $student->nis }}</code>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                                </div>
                                                <span class="text-sm font-semibold text-gray-900">{{ $student->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            @if($student->gender == 'L')
                                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-semibold inline-flex items-center gap-1">
                                                    <i class="fas fa-mars"></i>
                                                    Laki-laki
                                                </span>
                                            @else
                                                <span class="px-3 py-1 bg-pink-100 text-pink-700 rounded-lg text-xs font-semibold inline-flex items-center gap-1">
                                                    <i class="fas fa-venus"></i>
                                                    Perempuan
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold inline-flex items-center gap-1">
                                                <i class="fas fa-check-circle"></i>
                                                Aktif
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                                <i class="fas fa-users text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Siswa</h3>
                            <p class="text-gray-600">Belum ada siswa terdaftar di kelas ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
