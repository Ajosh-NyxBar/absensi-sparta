@extends('layouts.modern')

@section('title', 'Edit Kelas')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-edit text-white text-xl"></i>
                    </div>
                    Edit Kelas
                </h1>
                <p class="text-gray-600 mt-2">Edit data kelas <strong>{{ $class->name }}</strong></p>
            </div>
            <a href="{{ route('classes.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all duration-200 shadow-sm">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Form Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-edit text-amber-600"></i>
                Form Edit Kelas
            </h2>
        </div>
        
        <div class="p-6">
            <form action="{{ route('classes.update', $class->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Nama Kelas -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Kelas <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $class->name) }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror" 
                           placeholder="Contoh: VII-A, VIII-B, IX-C"
                           required>
                    <p class="mt-1 text-sm text-gray-500">Format: Tingkat-Kelompok (VII-A, VIII-1, IX-Unggulan)</p>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tingkat Kelas -->
                    <div>
                        <label for="grade" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tingkat Kelas <span class="text-red-500">*</span>
                        </label>
                        <select id="grade" 
                                name="grade" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 @error('grade') border-red-500 @enderror" 
                                required>
                            <option value="">-- Pilih Tingkat --</option>
                            <option value="7" {{ old('grade', $class->grade) == '7' ? 'selected' : '' }}>Kelas 7 (VII)</option>
                            <option value="8" {{ old('grade', $class->grade) == '8' ? 'selected' : '' }}>Kelas 8 (VIII)</option>
                            <option value="9" {{ old('grade', $class->grade) == '9' ? 'selected' : '' }}>Kelas 9 (IX)</option>
                        </select>
                        @error('grade')
                            <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Tahun Ajaran -->
                    <div>
                        <label for="academic_year" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tahun Ajaran <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="academic_year" 
                               name="academic_year" 
                               value="{{ old('academic_year', $class->academic_year) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 @error('academic_year') border-red-500 @enderror" 
                               placeholder="2024/2025"
                               required>
                        <p class="mt-1 text-sm text-gray-500">Format: YYYY/YYYY</p>
                        @error('academic_year')
                            <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Kapasitas -->
                <div>
                    <label for="capacity" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kapasitas Siswa
                    </label>
                    <input type="number" 
                           id="capacity" 
                           name="capacity" 
                           value="{{ old('capacity', $class->capacity) }}" 
                           min="1" 
                           max="50"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 @error('capacity') border-red-500 @enderror" 
                           placeholder="30">
                    <p class="mt-1 text-sm text-gray-500">Jumlah maksimal siswa dalam kelas (1-50 siswa)</p>
                    @error('capacity')
                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Wali Kelas -->
                <div>
                    <label for="homeroom_teacher_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user-tie text-amber-600 mr-1"></i> Wali Kelas
                    </label>
                    <select id="homeroom_teacher_id" 
                            name="homeroom_teacher_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 @error('homeroom_teacher_id') border-red-500 @enderror">
                        <option value="">-- Belum Ditentukan --</option>
                        @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('homeroom_teacher_id', $class->homeroom_teacher_id) == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }} ({{ $teacher->nip }})
                        </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-sm text-gray-500">Pilih guru yang ditugaskan sebagai wali kelas</p>
                    @error('homeroom_teacher_id')
                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Action Buttons -->
                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold rounded-xl hover:from-amber-600 hover:to-amber-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <i class="fas fa-save"></i>
                        <span>Update Kelas</span>
                    </button>
                    <a href="{{ route('classes.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all duration-200">
                        <i class="fas fa-times"></i>
                        <span>Batal</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
