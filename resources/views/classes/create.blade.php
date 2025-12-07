@extends('layouts.modern')

@section('title', 'Tambah Kelas')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-plus-circle text-white text-xl"></i>
                    </div>
                    Tambah Kelas
                </h1>
                <p class="text-gray-600 mt-2">Tambah kelas baru ke dalam sistem</p>
            </div>
            <a href="{{ route('classes.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all duration-200 shadow-sm">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Form Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-edit text-blue-600"></i>
                        Form Data Kelas
                    </h2>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('classes.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Nama Kelas -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Kelas <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror" 
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
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('grade') border-red-500 @enderror" 
                                        required>
                                    <option value="">-- Pilih Tingkat --</option>
                                    <option value="7" {{ old('grade') == '7' ? 'selected' : '' }}>Kelas 7 (VII)</option>
                                    <option value="8" {{ old('grade') == '8' ? 'selected' : '' }}>Kelas 8 (VIII)</option>
                                    <option value="9" {{ old('grade') == '9' ? 'selected' : '' }}>Kelas 9 (IX)</option>
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
                                       value="{{ old('academic_year', '2024/2025') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('academic_year') border-red-500 @enderror" 
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
                                   value="{{ old('capacity', 30) }}" 
                                   min="1" 
                                   max="50"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('capacity') border-red-500 @enderror" 
                                   placeholder="30">
                            <p class="mt-1 text-sm text-gray-500">Jumlah maksimal siswa dalam kelas (1-50 siswa)</p>
                            @error('capacity')
                                <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex gap-3 pt-6 border-t border-gray-200">
                            <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <i class="fas fa-save"></i>
                                <span>Simpan Kelas</span>
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
        
        <!-- Info Section -->
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl shadow-sm border border-blue-200 overflow-hidden sticky top-6">
                <div class="px-6 py-5 bg-gradient-to-r from-blue-500 to-indigo-500">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="fas fa-info-circle"></i>
                        Informasi
                    </h3>
                </div>
                
                <div class="p-6 space-y-4">
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2">Contoh Penamaan Kelas:</h4>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                <code class="px-2 py-1 bg-white rounded border border-blue-200">VII-A</code>
                                <span>- Kelas 7 grup A</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                <code class="px-2 py-1 bg-white rounded border border-blue-200">VIII-1</code>
                                <span>- Kelas 8 grup 1</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                <code class="px-2 py-1 bg-white rounded border border-blue-200">IX-Unggulan</code>
                                <span>- Kelas unggulan</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="pt-4 border-t border-blue-200">
                        <h4 class="font-semibold text-gray-900 mb-2">Catatan:</h4>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span>Nama kelas harus unik</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span>Kapasitas default 30 siswa</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <span>Semua field bertanda (*) wajib diisi</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
