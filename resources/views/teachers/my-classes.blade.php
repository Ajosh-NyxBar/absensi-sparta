@extends('layouts.modern')

@section('title', 'Daftar Kelas yang Diajar')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-cyan-50 to-blue-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent mb-2">
                        Daftar Kelas yang Diajar
                    </h1>
                    <p class="text-gray-600 flex items-center gap-2">
                        <i class="fas fa-chalkboard-teacher"></i>
                        Kelola dan pantau kelas yang Anda ajar
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-sm border border-gray-200">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Teacher Info Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-blue-100">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-xl flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                    {{ substr($teacher->name, 0, 1) }}
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-gray-800">{{ $teacher->name }}</h2>
                    <div class="flex flex-wrap gap-4 mt-1 text-sm text-gray-600">
                        <span><i class="fas fa-id-card text-blue-600 mr-1"></i> NIP: {{ $teacher->nip }}</span>
                        @if($teacher->education_level)
                        <span><i class="fas fa-graduation-cap text-cyan-600 mr-1"></i> {{ $teacher->education_level }}</span>
                        @endif
                    </div>
                </div>
                <div class="text-center px-6 py-3 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl border border-blue-200">
                    <div class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                        {{ $teacherSubjects->count() }}
                    </div>
                    <div class="text-sm text-gray-600 mt-1">Total Kelas</div>
                </div>
            </div>
        </div>

        @if($teacherSubjects->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center border border-gray-200">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-chalkboard text-4xl text-blue-600"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Kelas</h3>
                <p class="text-gray-600 mb-6 max-w-md mx-auto">
                    Anda belum ditugaskan untuk mengajar kelas apapun. Silakan hubungi admin untuk penugasan kelas.
                </p>
                <a href="{{ route('dashboard') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg hover:from-blue-700 hover:to-cyan-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        @else
            <!-- Classes Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($teacherSubjects as $classId => $subjects)
                    @php
                        $class = $subjects->first()->classRoom;
                        $activeStudentCount = $class->students()->where('status', 'active')->count();
                    @endphp
                    
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-blue-100 group">
                        <!-- Card Header -->
                        <div class="bg-gradient-to-r from-blue-600 to-cyan-600 p-6 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-16 -mt-16"></div>
                            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white opacity-10 rounded-full -ml-12 -mb-12"></div>
                            
                            <div class="relative z-10">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <h3 class="text-2xl font-bold mb-1">{{ $class->name }}</h3>
                                        <p class="text-blue-100 text-sm flex items-center gap-2">
                                            <i class="fas fa-layer-group"></i>
                                            Tingkat {{ $class->grade_level }}
                                        </p>
                                    </div>
                                    <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-lg text-center">
                                        <div class="text-2xl font-bold">{{ $activeStudentCount }}</div>
                                        <div class="text-xs text-blue-100">Siswa</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6">
                            <!-- Subjects Section -->
                            <div class="mb-6">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                    <i class="fas fa-book text-blue-600"></i>
                                    Mata Pelajaran yang Diampu
                                </h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($subjects as $teacherSubject)
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-blue-50 to-cyan-50 text-blue-700 rounded-lg text-sm font-medium border border-blue-200">
                                            <i class="fas fa-graduation-cap text-xs"></i>
                                            {{ $teacherSubject->subject->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Stats Grid -->
                            <div class="grid grid-cols-2 gap-3 mb-6">
                                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-4 border border-blue-100">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-lg flex items-center justify-center text-white">
                                            <i class="fas fa-book-open"></i>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-bold text-gray-800">{{ $subjects->count() }}</div>
                                            <div class="text-xs text-gray-600">Mata Pelajaran</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-gradient-to-br from-cyan-50 to-blue-50 rounded-xl p-4 border border-cyan-100">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-cyan-600 to-blue-600 rounded-lg flex items-center justify-center text-white">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-bold text-gray-800">{{ $activeStudentCount }}</div>
                                            <div class="text-xs text-gray-600">Siswa Aktif</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="space-y-2">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                    <i class="fas fa-bolt text-cyan-600"></i>
                                    Aksi Cepat
                                </h4>
                                
                                <div class="grid grid-cols-2 gap-2">
                                    <a href="{{ route('grades.create', ['class_id' => $class->id]) }}" 
                                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg hover:from-blue-700 hover:to-cyan-700 transition-all duration-200 shadow-md hover:shadow-lg text-sm font-medium">
                                        <i class="fas fa-plus-circle"></i>
                                        <span>Input Nilai</span>
                                    </a>
                                    
                                    <a href="{{ route('grades.index', ['class_id' => $class->id]) }}" 
                                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white text-blue-700 rounded-lg hover:bg-blue-50 transition-all duration-200 shadow-md hover:shadow-lg text-sm font-medium border border-blue-200">
                                        <i class="fas fa-list-alt"></i>
                                        <span>Lihat Nilai</span>
                                    </a>
                                </div>

                                <a href="{{ route('classes.show', $class->id) }}" 
                                   class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-cyan-600 to-blue-600 text-white rounded-lg hover:from-cyan-700 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg text-sm font-medium">
                                    <i class="fas fa-eye"></i>
                                    <span>Detail Kelas</span>
                                </a>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="bg-gradient-to-r from-blue-50 to-cyan-50 px-6 py-3 border-t border-blue-100">
                            <div class="flex items-center justify-between text-xs text-gray-600">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-info-circle text-blue-600"></i>
                                    Kelas {{ $class->name }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-chart-line text-cyan-600"></i>
                                    {{ $subjects->count() }} Mapel
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Summary Card -->
            <div class="mt-8 bg-white rounded-2xl shadow-lg p-6 border border-blue-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-xl flex items-center justify-center text-white">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-800 mb-1">Ringkasan Tugas Mengajar</h3>
                        <p class="text-sm text-gray-600">
                            Anda mengajar <span class="font-bold text-blue-600">{{ $teacherSubjects->sum(fn($subjects) => $subjects->count()) }} mata pelajaran</span> 
                            di <span class="font-bold text-cyan-600">{{ $teacherSubjects->count() }} kelas</span> 
                            dengan total <span class="font-bold text-blue-600">{{ $teacherSubjects->sum(fn($subjects) => $subjects->first()->classRoom->students()->where('status', 'active')->count()) }} siswa aktif</span>.
                        </p>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
