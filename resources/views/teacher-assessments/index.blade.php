@extends('layouts.modern')

@section('title', 'Input Penilaian Guru')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clipboard-check text-white text-xl"></i>
                    </div>
                    Input Penilaian Guru
                </h1>
                <p class="text-gray-600 mt-2">Input nilai Kualitas Mengajar (K2) dan Kedisiplinan (K4). Nilai Kehadiran (K1) dan Prestasi Siswa (K3) dihitung otomatis.</p>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 flex items-start gap-3">
        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
        <p class="text-green-800 flex-1">{{ session('success') }}</p>
        <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <!-- Filter -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-filter text-emerald-500"></i>
                Filter Periode
            </h3>
        </div>
        <div class="p-6">
            <form method="GET" action="{{ route('teacher-assessments.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Ajaran</label>
                    <select name="academic_year" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="2024/2025" {{ $academicYear == '2024/2025' ? 'selected' : '' }}>2024/2025</option>
                        <option value="2025/2026" {{ $academicYear == '2025/2026' ? 'selected' : '' }}>2025/2026</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Semester</label>
                    <select name="semester" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="Ganjil" {{ $semester == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="Genap" {{ $semester == 'Genap' ? 'selected' : '' }}>Genap</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-xl hover:from-emerald-600 hover:to-teal-700 transition-all">
                        <i class="fas fa-search mr-2"></i>Tampilkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Criteria Info -->
    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl border border-emerald-200 mb-8">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-emerald-500"></i>
                Kriteria Penilaian Guru (SAW)
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl p-4 border border-emerald-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-mono font-bold text-emerald-600">K1</span>
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-semibold">Otomatis</span>
                    </div>
                    <div class="font-semibold text-gray-900">Kehadiran</div>
                    <div class="text-sm text-gray-500 mt-1">Bobot: 30% | Benefit</div>
                    <div class="text-xs text-blue-600 mt-1"><i class="fas fa-robot mr-1"></i>Dari data presensi</div>
                </div>
                <div class="bg-white rounded-xl p-4 border border-orange-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-mono font-bold text-orange-600">K2</span>
                        <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded-lg text-xs font-semibold">Manual</span>
                    </div>
                    <div class="font-semibold text-gray-900">Kualitas Mengajar</div>
                    <div class="text-sm text-gray-500 mt-1">Bobot: 25% | Benefit</div>
                    <div class="text-xs text-orange-600 mt-1"><i class="fas fa-pen mr-1"></i>Input oleh Kepsek/Admin</div>
                </div>
                <div class="bg-white rounded-xl p-4 border border-emerald-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-mono font-bold text-emerald-600">K3</span>
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-semibold">Otomatis</span>
                    </div>
                    <div class="font-semibold text-gray-900">Prestasi Siswa</div>
                    <div class="text-sm text-gray-500 mt-1">Bobot: 25% | Benefit</div>
                    <div class="text-xs text-blue-600 mt-1"><i class="fas fa-robot mr-1"></i>Rata-rata nilai siswa yang diampu</div>
                </div>
                <div class="bg-white rounded-xl p-4 border border-orange-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-mono font-bold text-orange-600">K4</span>
                        <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded-lg text-xs font-semibold">Manual</span>
                    </div>
                    <div class="font-semibold text-gray-900">Kedisiplinan</div>
                    <div class="text-sm text-gray-500 mt-1">Bobot: 20% | Benefit</div>
                    <div class="text-xs text-orange-600 mt-1"><i class="fas fa-pen mr-1"></i>Input oleh Kepsek/Admin</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Note about Wali Kelas -->
    <div class="bg-gradient-to-br from-amber-50 to-yellow-50 rounded-2xl border border-amber-200 mb-8 p-5">
        <div class="flex items-start gap-3">
            <i class="fas fa-lightbulb text-amber-600 text-xl mt-0.5"></i>
            <div>
                <h4 class="text-sm font-bold text-amber-900 mb-1">Catatan: Wali Kelas &amp; Guru Mata Pelajaran</h4>
                <p class="text-sm text-amber-800">
                    Guru yang juga menjadi <strong>Wali Kelas</strong> memiliki dua peran: sebagai pengajar mata pelajaran dan sebagai wali kelas. 
                    Penilaian K3 (Prestasi Siswa) dihitung dari rata-rata nilai siswa pada <strong>mata pelajaran yang guru tersebut ampu</strong>, 
                    sehingga mencerminkan kinerja mengajar, bukan peran wali kelas. Wali kelas tetap dinilai sama seperti guru lainnya.
                </p>
            </div>
        </div>
    </div>

    <!-- Input Form -->
    <form action="{{ route('teacher-assessments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="academic_year" value="{{ $academicYear }}">
        <input type="hidden" name="semester" value="{{ $semester }}">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-table text-emerald-600"></i>
                        Daftar Guru ({{ $teachers->count() }} guru)
                    </h2>
                    <span class="px-3 py-1 bg-white rounded-lg font-semibold text-gray-700 border border-gray-200 text-sm">
                        {{ $semester }} {{ $academicYear }}
                    </span>
                </div>
            </div>

            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase bg-gray-50">No</th>
                                <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase bg-gray-50">Guru</th>
                                <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase bg-gray-50">Mapel & Kelas</th>
                                <th class="px-4 py-4 text-center text-xs font-bold text-gray-700 uppercase bg-gray-50">
                                    <div class="flex flex-col">
                                        <span>K1: Kehadiran</span>
                                        <span class="text-xs text-blue-500 font-normal">(Otomatis)</span>
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-center text-xs font-bold text-gray-700 uppercase bg-gray-50">
                                    <div class="flex flex-col">
                                        <span>K2: Kualitas Mengajar</span>
                                        <span class="text-xs text-orange-500 font-normal">(0-100)</span>
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-center text-xs font-bold text-gray-700 uppercase bg-gray-50">
                                    <div class="flex flex-col">
                                        <span>K3: Prestasi Siswa</span>
                                        <span class="text-xs text-blue-500 font-normal">(Otomatis)</span>
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-center text-xs font-bold text-gray-700 uppercase bg-gray-50">
                                    <div class="flex flex-col">
                                        <span>K4: Kedisiplinan</span>
                                        <span class="text-xs text-orange-500 font-normal">(0-100)</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $index => $teacher)
                                @php
                                    $scores = $teacherScores[$teacher->id];
                                    $existing = $existingAssessments->get($teacher->id);
                                @endphp
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-4 text-sm font-semibold text-gray-700">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <input type="hidden" name="scores[{{ $index }}][teacher_id]" value="{{ $teacher->id }}">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                {{ strtoupper(substr($teacher->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $teacher->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $teacher->nip }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @forelse($teacher->teacherSubjects as $ts)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-700">
                                                    {{ $ts->subject->code ?? '-' }}-{{ $ts->classRoom->name ?? '-' }}
                                                </span>
                                            @empty
                                                <span class="text-xs text-gray-400 italic">Belum ada penugasan</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold {{ $scores['attendance_score'] >= 80 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ number_format($scores['attendance_score'], 1) }}%
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <input type="number" 
                                               name="scores[{{ $index }}][teaching_quality]" 
                                               value="{{ old("scores.{$index}.teaching_quality", $scores['teaching_quality'] ?? '') }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all text-center" 
                                               min="0" max="100" step="0.01" placeholder="0-100" required>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold {{ $scores['student_achievement'] >= 70 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ number_format($scores['student_achievement'], 1) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <input type="number" 
                                               name="scores[{{ $index }}][discipline_score]" 
                                               value="{{ old("scores.{$index}.discipline_score", $scores['discipline_score'] ?? '') }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all text-center" 
                                               min="0" max="100" step="0.01" placeholder="0-100" required>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-200">
                    <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-xl hover:from-emerald-600 hover:to-teal-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <i class="fas fa-save"></i>
                        Simpan Penilaian
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
