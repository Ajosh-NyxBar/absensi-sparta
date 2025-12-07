@extends('layouts.modern')

@section('title', 'Tambah Kriteria SAW')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-plus-circle text-white text-xl"></i>
                    </div>
                    Tambah Kriteria SAW
                </h1>
                <p class="text-gray-600 mt-2">Tambahkan kriteria penilaian baru untuk siswa atau guru</p>
            </div>
            <a href="{{ route('criteria.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all duration-200 shadow-sm">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column - Form (2/3 width) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-edit text-purple-600"></i>
                        Form Tambah Kriteria
                    </h2>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('criteria.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Row 1: Kode Kriteria & Kategori -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kode Kriteria -->
                            <div>
                                <label for="code" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Kode Kriteria <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="code" 
                                       name="code" 
                                       value="{{ old('code') }}" 
                                       placeholder="Contoh: C1, C2, C3"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('code') border-red-500 @enderror" 
                                       required>
                                <p class="text-xs text-gray-500 mt-1">Kode unik untuk identifikasi kriteria</p>
                                @error('code')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label for="for" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select id="for" 
                                        name="for" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('for') border-red-500 @enderror" 
                                        required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="student" {{ old('for') === 'student' ? 'selected' : '' }}>
                                        Siswa
                                    </option>
                                    <option value="teacher" {{ old('for') === 'teacher' ? 'selected' : '' }}>
                                        Guru
                                    </option>
                                </select>
                                @error('for')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Nama Kriteria -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Kriteria <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Contoh: Nilai Akademik, Kehadiran, Kinerja Mengajar"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror" 
                                   required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Row 2: Tipe Kriteria & Bobot -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tipe Kriteria -->
                            <div>
                                <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tipe Kriteria <span class="text-red-500">*</span>
                                </label>
                                <select id="type" 
                                        name="type" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('type') border-red-500 @enderror" 
                                        required>
                                    <option value="">-- Pilih Tipe --</option>
                                    <option value="benefit" {{ old('type') === 'benefit' ? 'selected' : '' }}>
                                        Benefit (Semakin tinggi semakin baik)
                                    </option>
                                    <option value="cost" {{ old('type') === 'cost' ? 'selected' : '' }}>
                                        Cost (Semakin rendah semakin baik)
                                    </option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">
                                    <strong>Benefit:</strong> Nilai tinggi = baik<br>
                                    <strong>Cost:</strong> Nilai rendah = baik
                                </p>
                                @error('type')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Bobot -->
                            <div>
                                <label for="weight" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Bobot <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       id="weight" 
                                       name="weight" 
                                       value="{{ old('weight') }}" 
                                       step="0.01" 
                                       min="0" 
                                       max="1"
                                       placeholder="0.00 - 1.00"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('weight') border-red-500 @enderror" 
                                       required>
                                <p class="text-xs text-gray-500 mt-1">Nilai antara 0.00 - 1.00. Total semua bobot harus = 1.0</p>
                                @error('weight')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                Deskripsi
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="4"
                                      placeholder="Deskripsi lengkap kriteria (opsional)"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 resize-none @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-save"></i>
                                <span>Simpan Kriteria</span>
                            </button>
                            <a href="{{ route('criteria.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all duration-200 shadow-sm">
                                <i class="fas fa-times"></i>
                                <span>Batal</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column - Help (1/3 width) -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Panduan Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-cyan-500 to-blue-600">
                    <h3 class="text-base font-bold text-white flex items-center gap-2">
                        <i class="fas fa-question-circle"></i>
                        Panduan
                    </h3>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <p class="text-sm font-bold text-gray-900 mb-2">Tips Menambah Kriteria:</p>
                        <ul class="space-y-1.5">
                            <li class="flex items-start gap-2 text-xs text-gray-600">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span>Gunakan kode yang jelas (C1, C2, dst.)</span>
                            </li>
                            <li class="flex items-start gap-2 text-xs text-gray-600">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span>Pastikan total bobot = 1.0 (100%)</span>
                            </li>
                            <li class="flex items-start gap-2 text-xs text-gray-600">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span>Pilih tipe sesuai karakteristik</span>
                            </li>
                            <li class="flex items-start gap-2 text-xs text-gray-600">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span>Berikan deskripsi yang jelas</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Contoh Kriteria Siswa -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600">
                    <h3 class="text-sm font-bold text-white flex items-center gap-2">
                        <i class="fas fa-user-graduate"></i>
                        Contoh Kriteria Siswa
                    </h3>
                </div>
                <div class="p-5">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded font-bold text-xs">C1</span>
                                <div>
                                    <p class="text-xs font-semibold text-gray-900">Nilai Akademik</p>
                                    <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-xs font-semibold">Benefit</span>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-gray-900">0.40</span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded font-bold text-xs">C2</span>
                                <div>
                                    <p class="text-xs font-semibold text-gray-900">Kehadiran</p>
                                    <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-xs font-semibold">Benefit</span>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-gray-900">0.30</span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded font-bold text-xs">C3</span>
                                <div>
                                    <p class="text-xs font-semibold text-gray-900">Sikap</p>
                                    <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-xs font-semibold">Benefit</span>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-gray-900">0.20</span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded font-bold text-xs">C4</span>
                                <div>
                                    <p class="text-xs font-semibold text-gray-900">Pelanggaran</p>
                                    <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded text-xs font-semibold">Cost</span>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-gray-900">0.10</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contoh Kriteria Guru -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600">
                    <h3 class="text-sm font-bold text-white flex items-center gap-2">
                        <i class="fas fa-chalkboard-teacher"></i>
                        Contoh Kriteria Guru
                    </h3>
                </div>
                <div class="p-5">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded font-bold text-xs">G1</span>
                                <div>
                                    <p class="text-xs font-semibold text-gray-900">Kinerja Mengajar</p>
                                    <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-xs font-semibold">Benefit</span>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-gray-900">0.35</span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded font-bold text-xs">G2</span>
                                <div>
                                    <p class="text-xs font-semibold text-gray-900">Kehadiran</p>
                                    <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-xs font-semibold">Benefit</span>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-gray-900">0.25</span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded font-bold text-xs">G3</span>
                                <div>
                                    <p class="text-xs font-semibold text-gray-900">Pengabdian</p>
                                    <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-xs font-semibold">Benefit</span>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-gray-900">0.25</span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded font-bold text-xs">G4</span>
                                <div>
                                    <p class="text-xs font-semibold text-gray-900">Keterlambatan</p>
                                    <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded text-xs font-semibold">Cost</span>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-gray-900">0.15</span>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
</div>
@endsection
