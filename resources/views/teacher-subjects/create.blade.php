@extends('layouts.modern')

@section('title', 'Tambah Penugasan Guru')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                Tambah Penugasan Guru
            </h1>
            <p class="text-gray-600 mt-1">Assign guru ke mata pelajaran dan kelas</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('teacher-subjects.index') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-300 hover:bg-gray-50 transition-all duration-200 shadow-sm">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <form action="{{ route('teacher-subjects.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Assignment Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-lg">
                        <i class="fas fa-clipboard-list text-white text-lg"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Informasi Penugasan</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Teacher -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-user-tie text-indigo-600 mr-1"></i>
                            Guru <span class="text-red-500">*</span>
                        </label>
                        <select name="teacher_id" 
                                id="teacher_id"
                                class="w-full px-4 py-3 bg-gradient-to-r from-indigo-50 to-purple-50 border-2 border-indigo-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all @error('teacher_id') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Guru</option>
                            @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }} ({{ $teacher->nip }})
                            </option>
                            @endforeach
                        </select>
                        @error('teacher_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Pilih guru yang akan ditugaskan</p>
                    </div>

                    <!-- Subject -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-book text-pink-600 mr-1"></i>
                            Mata Pelajaran <span class="text-red-500">*</span>
                        </label>
                        <select name="subject_id" 
                                id="subject_id"
                                class="w-full px-4 py-3 bg-gradient-to-r from-pink-50 to-rose-50 border-2 border-pink-200 rounded-xl focus:outline-none focus:border-pink-500 focus:ring-4 focus:ring-pink-100 transition-all @error('subject_id') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Mata Pelajaran</option>
                            @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }} ({{ $subject->code }})
                            </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Pilih mata pelajaran yang akan diajarkan</p>
                    </div>

                    <!-- Class -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-door-open text-blue-600 mr-1"></i>
                            Kelas <span class="text-gray-400 text-xs">(Opsional)</span>
                        </label>
                        <select name="class_id" 
                                id="class_id"
                                class="w-full px-4 py-3 bg-gradient-to-r from-blue-50 to-cyan-50 border-2 border-blue-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all @error('class_id') border-red-500 @enderror">
                            <option value="">Semua Kelas</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('class_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Kosongkan jika mengajar di semua kelas</p>
                    </div>

                    <!-- Academic Year -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-calendar-alt text-emerald-600 mr-1"></i>
                            Tahun Ajaran <span class="text-red-500">*</span>
                        </label>
                        <select name="academic_year" 
                                id="academic_year"
                                class="w-full px-4 py-3 bg-gradient-to-r from-emerald-50 to-teal-50 border-2 border-emerald-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition-all @error('academic_year') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach($academicYears as $year)
                            <option value="{{ $year->year }}" {{ old('academic_year', $academicYears->first()->year ?? '') == $year->year ? 'selected' : '' }}>
                                {{ $year->year }} {{ $year->is_active ? '(Aktif)' : '' }}
                            </option>
                            @endforeach
                        </select>
                        @error('academic_year')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Pilih tahun ajaran untuk penugasan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border-2 border-blue-200">
            <div class="flex items-start gap-4">
                <div class="bg-blue-100 p-3 rounded-xl">
                    <i class="fas fa-info-circle text-blue-600 text-2xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-2">Catatan Penting:</h4>
                    <ul class="space-y-1 text-sm text-gray-700">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-blue-600 mt-0.5"></i>
                            <span>Satu guru bisa mengajar beberapa mata pelajaran berbeda</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-blue-600 mt-0.5"></i>
                            <span>Satu mata pelajaran bisa diajarkan oleh beberapa guru (di kelas berbeda)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-blue-600 mt-0.5"></i>
                            <span>Jika kelas tidak dipilih, guru dianggap mengajar mata pelajaran tersebut di semua kelas</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-blue-600 mt-0.5"></i>
                            <span>Sistem akan mencegah duplikasi penugasan yang sama</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('teacher-subjects.index') }}" 
               class="px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-300 hover:bg-gray-50 transition-all duration-200">
                Batal
            </a>
            <button type="submit" 
                    class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-save"></i>
                <span>Simpan Penugasan</span>
            </button>
        </div>
    </form>
</div>
@endsection
