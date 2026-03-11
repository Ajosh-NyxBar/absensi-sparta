@extends('layouts.modern')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent">
                Input Nilai Siswa
            </h1>
            <p class="text-gray-600 mt-1">Pilih kelas dan mata pelajaran untuk input nilai</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('grades.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-300 hover:bg-gray-50 transition-all duration-200 shadow-sm">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                <div class="px-6 py-5 bg-gradient-to-r from-rose-50 to-pink-50 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-clipboard-list text-rose-600"></i>
                        Pilih Kelas & Mata Pelajaran
                    </h2>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('grades.input-by-class') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Kelas -->
                        <div>
                            <label for="class_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Kelas <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-school text-gray-400"></i>
                                </div>
                                <select id="class_id" 
                                        name="class_id" 
                                        class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all duration-200 @error('class_id') border-red-500 @enderror" 
                                        required>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }} ({{ $class->students()->where('status', 'active')->count() }} siswa)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('class_id')
                                <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mata Pelajaran -->
                        <div>
                            <label for="subject_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Mata Pelajaran <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-book text-gray-400"></i>
                                </div>
                                <select id="subject_id" 
                                        name="subject_id" 
                                        class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all duration-200 @error('subject_id') border-red-500 @enderror" 
                                        required>
                                    <option value="">-- Pilih Mata Pelajaran --</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->code }} - {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('subject_id')
                                <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Semester -->
                            <div>
                                <label for="semester" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Semester <span class="text-red-500">*</span>
                                </label>
                                <select id="semester" 
                                        name="semester" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all duration-200 @error('semester') border-red-500 @enderror" 
                                        required>
                                    <option value="">-- Pilih Semester --</option>
                                    <option value="Ganjil" {{ old('semester', $defaultSemester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="Genap" {{ old('semester', $defaultSemester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                                </select>
                                @error('semester')
                                    <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tahun Ajaran -->
                            <div>
                                <label for="academic_year" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tahun Ajaran <span class="text-red-500">*</span>
                                </label>
                                <select id="academic_year" 
                                       name="academic_year" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all duration-200 @error('academic_year') border-red-500 @enderror" 
                                       required>
                                    @foreach($academicYears as $year)
                                        <option value="{{ $year }}" {{ old('academic_year', $defaultAcademicYear) == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endforeach
                                </select>
                                @error('academic_year')
                                    <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-6 border-t border-gray-100">
                            <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-rose-500 to-pink-600 text-white font-semibold rounded-xl hover:from-rose-600 hover:to-pink-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <i class="fas fa-arrow-right"></i>
                                Lanjutkan Input Nilai
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Sidebar -->
        <div class="lg:col-span-1">
            <div class="space-y-6">
                <!-- Info Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-rose-500 to-pink-600">
                        <h3 class="text-sm font-bold text-white flex items-center gap-2">
                            <i class="fas fa-info-circle"></i>
                            Informasi
                        </h3>
                    </div>
                    <div class="p-5">
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-rose-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-1 text-rose-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 mb-1">Pilih Kelas</p>
                                    <p class="text-xs text-gray-600">Tentukan kelas yang akan diinput nilai</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-rose-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-2 text-rose-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 mb-1">Pilih Mata Pelajaran</p>
                                    <p class="text-xs text-gray-600">Tentukan mata pelajaran</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-rose-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-3 text-rose-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 mb-1">Input Nilai</p>
                                    <p class="text-xs text-gray-600">Masukkan nilai untuk setiap siswa</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Komponen Nilai -->
                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl shadow-sm border border-blue-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-cyan-600">
                        <h3 class="text-sm font-bold text-white flex items-center gap-2">
                            <i class="fas fa-calculator"></i>
                            Komponen Nilai
                        </h3>
                    </div>
                    <div class="p-5">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-edit text-blue-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-900">Tugas Harian</p>
                                        <p class="text-xs text-gray-500">Bobot 30%</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-book-open text-purple-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-900">Ujian Tengah Semester</p>
                                        <p class="text-xs text-gray-500">Bobot 30%</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file-alt text-green-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-900">Ujian Akhir Semester</p>
                                        <p class="text-xs text-gray-500">Bobot 40%</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 p-3 bg-blue-100 rounded-lg">
                            <p class="text-xs text-blue-900 text-center">
                                <i class="fas fa-info-circle mr-1"></i>
                                Nilai akhir dihitung otomatis
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tips -->
                <div class="bg-gradient-to-br from-amber-50 to-yellow-50 rounded-2xl shadow-sm border border-amber-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-amber-500 to-yellow-600">
                        <h3 class="text-sm font-bold text-white flex items-center gap-2">
                            <i class="fas fa-lightbulb"></i>
                            Tips
                        </h3>
                    </div>
                    <div class="p-5">
                        <ul class="space-y-2">
                            <li class="flex items-start gap-2 text-xs text-gray-600">
                                <i class="fas fa-check-circle text-amber-500 mt-0.5"></i>
                                <span>Pastikan semua siswa aktif</span>
                            </li>
                            <li class="flex items-start gap-2 text-xs text-gray-600">
                                <i class="fas fa-check-circle text-amber-500 mt-0.5"></i>
                                <span>Nilai antara 0-100</span>
                            </li>
                            <li class="flex items-start gap-2 text-xs text-gray-600">
                                <i class="fas fa-check-circle text-amber-500 mt-0.5"></i>
                                <span>Data dapat diubah kemudian</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
