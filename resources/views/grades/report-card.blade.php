@extends('layouts.modern')

@section('title', 'Rapor Siswa - ' . $student->name)

@section('content')
<div class="max-w-5xl mx-auto py-4 sm:py-8">
    <!-- Page Header -->
    <div class="mb-4 sm:mb-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
            <div>
                <h1 class="text-xl sm:text-3xl font-bold text-gray-900 flex items-center gap-2 sm:gap-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-file-alt text-white text-lg sm:text-xl"></i>
                    </div>
                    Rapor Siswa
                </h1>
                <p class="text-gray-600 mt-1 sm:mt-2 text-sm sm:text-base">Laporan hasil belajar siswa periode {{ $semester }} {{ $academicYear }}</p>
            </div>
            <div class="flex gap-2">
                <button onclick="window.print()" class="inline-flex items-center justify-center gap-2 px-3 sm:px-4 py-2 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white font-semibold rounded-lg sm:rounded-xl hover:from-indigo-600 hover:to-indigo-700 transition-all duration-200 text-sm sm:text-base flex-1 sm:flex-none">
                    <i class="fas fa-print"></i>
                    <span>Cetak</span>
                </button>
                <a href="{{ route('students.show', $student) }}" class="inline-flex items-center justify-center gap-2 px-3 sm:px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg sm:rounded-xl hover:bg-gray-200 transition-all duration-200 text-sm sm:text-base">
                    <i class="fas fa-arrow-left"></i>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 mb-4 sm:mb-8 print:hidden">
        <div class="p-4 sm:p-6">
            <form action="{{ route('students.report-card', $student) }}" method="GET" class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4">
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Semester</label>
                    <select name="semester" class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        <option value="Ganjil" {{ $semester == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="Genap" {{ $semester == 'Genap' ? 'selected' : '' }}>Genap</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Tahun Ajaran</label>
                    <select name="academic_year" class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        <option value="2023/2024" {{ $academicYear == '2023/2024' ? 'selected' : '' }}>2023/2024</option>
                        <option value="2024/2025" {{ $academicYear == '2024/2025' ? 'selected' : '' }}>2024/2025</option>
                        <option value="2025/2026" {{ $academicYear == '2025/2026' ? 'selected' : '' }}>2025/2026</option>
                    </select>
                </div>
                <div class="col-span-2 sm:col-span-1 flex items-end">
                    <button type="submit" class="w-full px-4 py-2 sm:py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white font-semibold rounded-lg sm:rounded-xl hover:from-indigo-600 hover:to-indigo-700 transition-all duration-200 text-sm">
                        <i class="fas fa-search mr-2"></i>Tampilkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Card -->
    <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 overflow-hidden print:shadow-none print:border-0" id="reportCard">
        <!-- Header Sekolah -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-4 sm:px-8 py-4 sm:py-6 print:bg-white print:text-black print:border-b-4 print:border-indigo-600">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="w-14 h-14 sm:w-20 sm:h-20 bg-white rounded-full flex items-center justify-center print:border-2 print:border-indigo-600 flex-shrink-0">
                        <i class="fas fa-school text-indigo-600 text-xl sm:text-3xl"></i>
                    </div>
                    <div class="text-white print:text-black">
                        <h2 class="text-lg sm:text-2xl font-bold">SMPN 4 PURWAKARTA</h2>
                        <p class="text-indigo-100 print:text-gray-600 text-xs sm:text-base">Jl. Veteran No. 1, Purwakarta</p>
                        <p class="text-indigo-100 print:text-gray-600 text-xs sm:text-base hidden sm:block">Telp: (0264) 123456 | Email: smpn4pwk@gmail.com</p>
                    </div>
                </div>
                <div class="text-left sm:text-right text-white print:text-black border-t sm:border-0 border-white/20 pt-3 sm:pt-0">
                    <h3 class="text-base sm:text-xl font-bold">LAPORAN HASIL BELAJAR</h3>
                    <p class="text-indigo-100 print:text-gray-600 text-xs sm:text-base">Semester {{ $semester }} - {{ $academicYear }}</p>
                </div>
            </div>
        </div>

        <!-- Student Info -->
        <div class="p-4 sm:p-8 border-b border-gray-200">
            <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-3 sm:mb-4 flex items-center gap-2">
                <i class="fas fa-user-graduate text-indigo-500"></i>
                Identitas Siswa
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                <div class="space-y-2 sm:space-y-3">
                    <div class="flex flex-col sm:flex-row">
                        <span class="text-xs sm:text-base text-gray-500 sm:w-40">Nama Lengkap</span>
                        <span class="font-semibold text-gray-900 text-sm sm:text-base"><span class="hidden sm:inline">: </span>{{ $student->name }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row">
                        <span class="text-xs sm:text-base text-gray-500 sm:w-40">NIS</span>
                        <span class="font-semibold text-gray-900 text-sm sm:text-base"><span class="hidden sm:inline">: </span>{{ $student->nis }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row">
                        <span class="text-xs sm:text-base text-gray-500 sm:w-40">NISN</span>
                        <span class="font-semibold text-gray-900 text-sm sm:text-base"><span class="hidden sm:inline">: </span>{{ $student->nisn ?? '-' }}</span>
                    </div>
                </div>
                <div class="space-y-2 sm:space-y-3">
                    <div class="flex flex-col sm:flex-row">
                        <span class="text-xs sm:text-base text-gray-500 sm:w-40">Kelas</span>
                        <span class="font-semibold text-gray-900 text-sm sm:text-base"><span class="hidden sm:inline">: </span>{{ $student->class->name ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row">
                        <span class="text-xs sm:text-base text-gray-500 sm:w-40">Jenis Kelamin</span>
                        <span class="font-semibold text-gray-900 text-sm sm:text-base"><span class="hidden sm:inline">: </span>{{ $student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row">
                        <span class="text-xs sm:text-base text-gray-500 sm:w-40">TTL</span>
                        <span class="font-semibold text-gray-900 text-sm sm:text-base"><span class="hidden sm:inline">: </span>{{ $student->place_of_birth ?? '-' }}, {{ $student->date_of_birth ? date('d/m/Y', strtotime($student->date_of_birth)) : '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nilai Akademik -->
        <div class="p-4 sm:p-8 border-b border-gray-200">
            <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-3 sm:mb-4 flex items-center gap-2">
                <i class="fas fa-book text-indigo-500"></i>
                Nilai Akademik
            </h3>
            @if($grades->isNotEmpty())
            <!-- Mobile Card View -->
            <div class="sm:hidden space-y-3">
                @foreach($grades as $index => $grade)
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-4 border border-indigo-100">
                    <div class="flex items-center justify-between mb-3">
                        <span class="font-bold text-gray-900">{{ $grade->subject->name ?? '-' }}</span>
                        @php
                            $final = $grade->final_grade ?? 0;
                            $predikat = $final >= 90 ? 'A' : ($final >= 80 ? 'B' : ($final >= 70 ? 'C' : 'D'));
                        @endphp
                        <span class="px-2 py-1 rounded-lg text-xs font-bold {{ $predikat == 'A' ? 'bg-green-100 text-green-700' : ($predikat == 'B' ? 'bg-blue-100 text-blue-700' : ($predikat == 'C' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')) }}">
                            {{ $predikat }}
                        </span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 text-center text-xs">
                        <div class="bg-white rounded-lg p-2">
                            <div class="text-gray-500">Tugas</div>
                            <div class="font-bold">{{ number_format($grade->assignment_score ?? 0, 0) }}</div>
                        </div>
                        <div class="bg-white rounded-lg p-2">
                            <div class="text-gray-500">UTS</div>
                            <div class="font-bold">{{ number_format($grade->mid_exam_score ?? 0, 0) }}</div>
                        </div>
                        <div class="bg-white rounded-lg p-2">
                            <div class="text-gray-500">UAS</div>
                            <div class="font-bold">{{ number_format($grade->final_exam_score ?? 0, 0) }}</div>
                        </div>
                    </div>
                    <div class="mt-2 flex items-center justify-between bg-indigo-100 rounded-lg p-2">
                        <span class="text-xs font-semibold text-indigo-700">Nilai Akhir</span>
                        <span class="text-lg font-bold {{ $grade->final_grade >= 75 ? 'text-green-600' : 'text-red-600' }}">{{ number_format($grade->final_grade ?? 0, 0) }}</span>
                    </div>
                </div>
                @endforeach
                <!-- Mobile Average -->
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-4 text-white">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold">Rata-rata Nilai Akhir</span>
                        <span class="text-2xl font-bold">{{ number_format($averageGrade ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>
            <!-- Desktop Table View -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-indigo-50 to-purple-50">
                            <th class="px-2 lg:px-4 py-3 text-left text-xs font-bold text-gray-700">No</th>
                            <th class="px-2 lg:px-4 py-3 text-left text-xs font-bold text-gray-700">Mata Pelajaran</th>
                            <th class="px-2 lg:px-4 py-3 text-center text-xs font-bold text-gray-700 hidden lg:table-cell">Tugas</th>
                            <th class="px-2 lg:px-4 py-3 text-center text-xs font-bold text-gray-700 hidden lg:table-cell">UTS</th>
                            <th class="px-2 lg:px-4 py-3 text-center text-xs font-bold text-gray-700 hidden lg:table-cell">UAS</th>
                            <th class="px-2 lg:px-4 py-3 text-center text-xs font-bold text-gray-700 hidden md:table-cell">Sikap</th>
                            <th class="px-2 lg:px-4 py-3 text-center text-xs font-bold text-gray-700 hidden md:table-cell">Skill</th>
                            <th class="px-2 lg:px-4 py-3 text-center text-xs font-bold text-gray-700 bg-indigo-100">NA</th>
                            <th class="px-2 lg:px-4 py-3 text-center text-xs font-bold text-gray-700">Predikat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($grades as $index => $grade)
                        <tr class="hover:bg-gray-50">
                            <td class="px-2 lg:px-4 py-3 text-gray-600 text-sm">{{ $index + 1 }}</td>
                            <td class="px-2 lg:px-4 py-3 font-semibold text-gray-900 text-sm">{{ $grade->subject->name ?? '-' }}</td>
                            <td class="px-2 lg:px-4 py-3 text-center text-sm hidden lg:table-cell">{{ number_format($grade->assignment_score ?? 0, 0) }}</td>
                            <td class="px-2 lg:px-4 py-3 text-center text-sm hidden lg:table-cell">{{ number_format($grade->mid_exam_score ?? 0, 0) }}</td>
                            <td class="px-2 lg:px-4 py-3 text-center text-sm hidden lg:table-cell">{{ number_format($grade->final_exam_score ?? 0, 0) }}</td>
                            <td class="px-2 lg:px-4 py-3 text-center hidden md:table-cell">
                                @php
                                    $behavior = $grade->behavior_score ?? 0;
                                    $behaviorGrade = $behavior >= 90 ? 'A' : ($behavior >= 80 ? 'B' : ($behavior >= 70 ? 'C' : 'D'));
                                @endphp
                                <span class="font-semibold text-sm {{ $behaviorGrade == 'A' ? 'text-green-600' : ($behaviorGrade == 'B' ? 'text-blue-600' : 'text-yellow-600') }}">
                                    {{ $behaviorGrade }}
                                </span>
                            </td>
                            <td class="px-2 lg:px-4 py-3 text-center hidden md:table-cell">
                                @php
                                    $skill = $grade->skill_score ?? 0;
                                    $skillGrade = $skill >= 90 ? 'A' : ($skill >= 80 ? 'B' : ($skill >= 70 ? 'C' : 'D'));
                                @endphp
                                <span class="font-semibold text-sm {{ $skillGrade == 'A' ? 'text-green-600' : ($skillGrade == 'B' ? 'text-blue-600' : 'text-yellow-600') }}">
                                    {{ $skillGrade }}
                                </span>
                            </td>
                            <td class="px-2 lg:px-4 py-3 text-center bg-indigo-50">
                                <span class="font-bold text-base lg:text-lg {{ $grade->final_grade >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($grade->final_grade ?? 0, 0) }}
                                </span>
                            </td>
                            <td class="px-2 lg:px-4 py-3 text-center">
                                @php
                                    $final = $grade->final_grade ?? 0;
                                    $predikat = $final >= 90 ? 'A' : ($final >= 80 ? 'B' : ($final >= 70 ? 'C' : 'D'));
                                @endphp
                                <span class="px-2 py-1 rounded-lg text-[10px] lg:text-xs font-semibold {{ $predikat == 'A' ? 'bg-green-100 text-green-700' : ($predikat == 'B' ? 'bg-blue-100 text-blue-700' : ($predikat == 'C' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')) }}">
                                    {{ $predikat }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t-2 border-gray-300">
                        <tr class="bg-gradient-to-r from-indigo-100 to-purple-100">
                            <td colspan="7" class="px-2 lg:px-4 py-3 text-right font-bold text-gray-900 text-sm hidden lg:table-cell">Rata-rata:</td>
                            <td colspan="5" class="px-2 lg:px-4 py-3 text-right font-bold text-gray-900 text-sm table-cell lg:hidden">Rata-rata:</td>
                            <td class="px-2 lg:px-4 py-3 text-center">
                                <span class="font-bold text-lg lg:text-xl {{ $averageGrade >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($averageGrade ?? 0, 2) }}
                                </span>
                            </td>
                            <td class="px-2 lg:px-4 py-3 text-center">
                                @php
                                    $avgPredikat = $averageGrade >= 90 ? 'A' : ($averageGrade >= 80 ? 'B' : ($averageGrade >= 70 ? 'C' : 'D'));
                                @endphp
                                <span class="font-bold text-base lg:text-lg {{ $avgPredikat == 'A' ? 'text-green-600' : ($avgPredikat == 'B' ? 'text-blue-600' : 'text-yellow-600') }}">
                                    {{ $avgPredikat }}
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-inbox text-4xl mb-4"></i>
                <p>Belum ada data nilai untuk periode ini.</p>
            </div>
            @endif
        </div>

        <!-- Kehadiran -->
        <div class="p-4 sm:p-8 border-b border-gray-200">
            <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-3 sm:mb-4 flex items-center gap-2">
                <i class="fas fa-calendar-check text-indigo-500"></i>
                Rekap Kehadiran
            </h3>
            <div class="grid grid-cols-3 sm:grid-cols-5 gap-2 sm:gap-4">
                <div class="bg-green-50 rounded-lg sm:rounded-xl p-2 sm:p-4 text-center border border-green-200">
                    <div class="text-lg sm:text-3xl font-bold text-green-600">{{ $student->attendances()->where('status', 'present')->count() }}</div>
                    <div class="text-[10px] sm:text-sm text-green-700 font-semibold">Hadir</div>
                </div>
                <div class="bg-yellow-50 rounded-lg sm:rounded-xl p-2 sm:p-4 text-center border border-yellow-200">
                    <div class="text-lg sm:text-3xl font-bold text-yellow-600">{{ $student->attendances()->where('status', 'late')->count() }}</div>
                    <div class="text-[10px] sm:text-sm text-yellow-700 font-semibold">Terlambat</div>
                </div>
                <div class="bg-blue-50 rounded-lg sm:rounded-xl p-2 sm:p-4 text-center border border-blue-200">
                    <div class="text-lg sm:text-3xl font-bold text-blue-600">{{ $student->attendances()->where('status', 'sick')->count() }}</div>
                    <div class="text-[10px] sm:text-sm text-blue-700 font-semibold">Sakit</div>
                </div>
                <div class="bg-purple-50 rounded-lg sm:rounded-xl p-2 sm:p-4 text-center border border-purple-200">
                    <div class="text-lg sm:text-3xl font-bold text-purple-600">{{ $student->attendances()->where('status', 'permit')->count() }}</div>
                    <div class="text-[10px] sm:text-sm text-purple-700 font-semibold">Izin</div>
                </div>
                <div class="bg-red-50 rounded-lg sm:rounded-xl p-2 sm:p-4 text-center border border-red-200">
                    <div class="text-lg sm:text-3xl font-bold text-red-600">{{ $student->attendances()->where('status', 'absent')->count() }}</div>
                    <div class="text-[10px] sm:text-sm text-red-700 font-semibold">Alpha</div>
                </div>
            </div>
        </div>

        <!-- Keterangan Predikat -->
        <div class="p-4 sm:p-8 border-b border-gray-200">
            <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-3 sm:mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-indigo-500"></i>
                Keterangan Predikat
            </h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-4 text-xs sm:text-sm">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 sm:w-8 sm:h-8 bg-green-100 text-green-700 rounded-lg flex items-center justify-center font-bold text-xs sm:text-base">A</span>
                    <span class="text-gray-700">90-100</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 sm:w-8 sm:h-8 bg-blue-100 text-blue-700 rounded-lg flex items-center justify-center font-bold text-xs sm:text-base">B</span>
                    <span class="text-gray-700">80-89</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 sm:w-8 sm:h-8 bg-yellow-100 text-yellow-700 rounded-lg flex items-center justify-center font-bold text-xs sm:text-base">C</span>
                    <span class="text-gray-700">70-79</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 sm:w-8 sm:h-8 bg-red-100 text-red-700 rounded-lg flex items-center justify-center font-bold text-xs sm:text-base">D</span>
                    <span class="text-gray-700">&lt;70</span>
                </div>
            </div>
        </div>

        <!-- Tanda Tangan -->
        <div class="p-4 sm:p-8">
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 sm:gap-8 text-center text-xs sm:text-base">
                <div class="hidden sm:block">
                    <p class="text-gray-600 mb-12 sm:mb-16">Orang Tua/Wali</p>
                    <div class="border-b border-gray-400 mx-4 sm:mx-8"></div>
                </div>
                <div>
                    <p class="text-gray-600 mb-12 sm:mb-16">Wali Kelas</p>
                    <div class="border-b border-gray-400 mx-2 sm:mx-8"></div>
                    <p class="text-gray-600 text-[10px] sm:text-sm mt-2 truncate px-1">{{ $student->class->teacher->name ?? '........' }}</p>
                </div>
                <div>
                    <p class="text-gray-600 mb-1 sm:mb-2 text-[10px] sm:text-base">Purwakarta, {{ date('d/m/Y') }}</p>
                    <p class="text-gray-600 mb-8 sm:mb-12">Kepala Sekolah</p>
                    <div class="border-b border-gray-400 mx-2 sm:mx-8"></div>
                    <p class="text-gray-600 text-[10px] sm:text-sm mt-2">NIP. ............</p>
                </div>
            </div>
        </div>
    </div>

    @if($grades->isNotEmpty())
    <!-- Chart Section - Hidden when printing -->
    <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 mt-4 sm:mt-8 print:hidden">
        <div class="p-4 sm:p-6 border-b border-gray-100">
            <h3 class="text-base sm:text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-chart-line text-indigo-500"></i>
                Grafik Nilai Per Mata Pelajaran
            </h3>
        </div>
        <div class="p-6">
            <canvas id="gradeChart" height="100"></canvas>
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
@media print {
    body * {
        visibility: hidden;
    }
    #reportCard, #reportCard * {
        visibility: visible;
    }
    #reportCard {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .print\:hidden {
        display: none !important;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@if($grades->isNotEmpty())
const ctx = document.getElementById('gradeChart').getContext('2d');
const gradeChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($grades->pluck('subject.name')) !!},
        datasets: [{
            label: 'Nilai Akhir',
            data: {!! json_encode($grades->pluck('final_grade')) !!},
            backgroundColor: function(context) {
                const value = context.raw;
                if (value >= 90) return 'rgba(34, 197, 94, 0.8)';
                if (value >= 80) return 'rgba(59, 130, 246, 0.8)';
                if (value >= 70) return 'rgba(234, 179, 8, 0.8)';
                return 'rgba(239, 68, 68, 0.8)';
            },
            borderColor: function(context) {
                const value = context.raw;
                if (value >= 90) return 'rgb(34, 197, 94)';
                if (value >= 80) return 'rgb(59, 130, 246)';
                if (value >= 70) return 'rgb(234, 179, 8)';
                return 'rgb(239, 68, 68)';
            },
            borderWidth: 2,
            borderRadius: 8,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Nilai: ' + context.raw;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 100,
                title: {
                    display: true,
                    text: 'Nilai'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Mata Pelajaran'
                }
            }
        }
    }
});
@endif
</script>
@endpush
@endsection
