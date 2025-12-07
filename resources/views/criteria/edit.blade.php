@extends('layouts.modern')

@section('title', 'Edit Kriteria SAW')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-edit text-white text-xl"></i>
                    </div>
                    Edit Kriteria SAW
                </h1>
                <p class="text-gray-600 mt-2">Ubah kriteria penilaian: <strong>{{ $criterion->code }} - {{ $criterion->name }}</strong></p>
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
                        <i class="fas fa-edit text-amber-600"></i>
                        Form Edit Kriteria
                    </h2>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('criteria.update', $criterion) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

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
                                       value="{{ old('code', $criterion->code) }}" 
                                       placeholder="Contoh: C1, C2, C3"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 @error('code') border-red-500 @enderror" 
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
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 @error('for') border-red-500 @enderror" 
                                        required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="student" {{ old('for', $criterion->for) === 'student' ? 'selected' : '' }}>
                                        Siswa
                                    </option>
                                    <option value="teacher" {{ old('for', $criterion->for) === 'teacher' ? 'selected' : '' }}>
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
                                   value="{{ old('name', $criterion->name) }}" 
                                   placeholder="Contoh: Nilai Akademik, Kehadiran, Kinerja Mengajar"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror" 
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
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 @error('type') border-red-500 @enderror" 
                                        required>
                                    <option value="">-- Pilih Tipe --</option>
                                    <option value="benefit" {{ old('type', $criterion->type) === 'benefit' ? 'selected' : '' }}>
                                        Benefit (Semakin tinggi semakin baik)
                                    </option>
                                    <option value="cost" {{ old('type', $criterion->type) === 'cost' ? 'selected' : '' }}>
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
                                       value="{{ old('weight', $criterion->weight) }}" 
                                       step="0.01" 
                                       min="0" 
                                       max="1"
                                       placeholder="0.00 - 1.00"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 @error('weight') border-red-500 @enderror" 
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
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 resize-none @error('description') border-red-500 @enderror">{{ old('description', $criterion->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-semibold rounded-xl hover:from-amber-600 hover:to-orange-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-save"></i>
                                <span>Perbarui Kriteria</span>
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

        <!-- Right Column - Info (1/3 width) -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Info Kriteria Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-amber-500 to-orange-600">
                    <h3 class="text-base font-bold text-white flex items-center gap-2">
                        <i class="fas fa-info-circle"></i>
                        Informasi Kriteria
                    </h3>
                </div>
                <div class="p-5 space-y-3">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Kode:</span>
                        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-lg font-bold text-sm">{{ $criterion->code }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Kategori:</span>
                        @if($criterion->for === 'student')
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg font-semibold text-xs">Siswa</span>
                        @else
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg font-semibold text-xs">Guru</span>
                        @endif
                    </div>
                    
                    <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Tipe:</span>
                        @if($criterion->type === 'benefit')
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg font-semibold text-xs">Benefit</span>
                        @else
                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg font-semibold text-xs">Cost</span>
                        @endif
                    </div>
                    
                    <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Bobot Saat Ini:</span>
                        <div class="text-right">
                            <span class="font-bold text-gray-900">{{ number_format($criterion->weight, 2) }}</span>
                            <span class="text-xs text-gray-500">({{ number_format($criterion->weight * 100, 0) }}%)</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Dibuat:</span>
                        <span class="text-xs text-gray-900">{{ $criterion->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Terakhir Diubah:</span>
                        <span class="text-xs text-gray-900">{{ $criterion->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Peringatan Card -->
            <div class="bg-gradient-to-br from-yellow-50 to-amber-50 border border-yellow-200 rounded-2xl p-5">
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-600 text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-yellow-900 mb-1">Peringatan</h4>
                    </div>
                </div>
                <ul class="space-y-1.5 text-xs text-yellow-800">
                    <li class="flex items-start gap-2">
                        <i class="fas fa-dot-circle text-yellow-600 mt-1"></i>
                        <span>Pastikan total bobot semua kriteria = 1.0</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-dot-circle text-yellow-600 mt-1"></i>
                        <span>Perubahan bobot akan mempengaruhi hasil perhitungan SAW</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-dot-circle text-yellow-600 mt-1"></i>
                        <span>Ubah tipe dengan hati-hati (benefit/cost)</span>
                    </li>
                </ul>
            </div>

            <!-- Tips Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-cyan-500 to-blue-600">
                    <h3 class="text-sm font-bold text-white flex items-center gap-2">
                        <i class="fas fa-lightbulb"></i>
                        Tips
                    </h3>
                </div>
                <div class="p-5 space-y-2 text-xs text-gray-600">
                    <p><strong class="text-gray-900">Benefit:</strong> Untuk kriteria yang nilainya semakin tinggi semakin baik</p>
                    <p><strong class="text-gray-900">Cost:</strong> Untuk kriteria yang nilainya semakin rendah semakin baik</p>
                    <p class="pt-2 border-t border-gray-100">Gunakan tombol <strong class="text-gray-900">Normalisasi</strong> di halaman utama untuk menyeimbangkan bobot otomatis.</p>
                </div>
            </div>
            
        </div>
        
    </div>
</div>
@endsection
