@extends('layouts.modern')

@section('title', 'Tambah Tahun Ajaran')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-plus-circle text-white text-xl"></i>
                    </div>
                    Tambah Tahun Ajaran
                </h1>
                <p class="text-gray-600 mt-2">Tambah tahun ajaran dan semester baru</p>
            </div>
            <a href="{{ route('academic-years.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all duration-200 shadow-sm">
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
                        <i class="fas fa-edit text-green-600"></i>
                        Form Tambah Tahun Ajaran
                    </h2>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('academic-years.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Row 1: Tahun Ajaran & Semester -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tahun Ajaran -->
                            <div>
                                <label for="year" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tahun Ajaran <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="year" 
                                       name="year" 
                                       value="{{ old('year', '2024/2025') }}" 
                                       placeholder="2024/2025"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('year') border-red-500 @enderror" 
                                       required>
                                <p class="text-xs text-gray-500 mt-1">Format: YYYY/YYYY</p>
                                @error('year')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Semester -->
                            <div>
                                <label for="semester" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Semester <span class="text-red-500">*</span>
                                </label>
                                <select id="semester" 
                                        name="semester" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('semester') border-red-500 @enderror" 
                                        required>
                                    <option value="">-- Pilih Semester --</option>
                                    <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Semester Ganjil</option>
                                    <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Semester Genap</option>
                                </select>
                                @error('semester')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Row 2: Tanggal Mulai & Selesai -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tanggal Mulai -->
                            <div>
                                <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tanggal Mulai <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-day text-gray-400"></i>
                                    </div>
                                    <input type="date" 
                                           id="start_date" 
                                           name="start_date" 
                                           value="{{ old('start_date') }}"
                                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('start_date') border-red-500 @enderror" 
                                           required>
                                </div>
                                @error('start_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Tanggal Selesai -->
                            <div>
                                <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tanggal Selesai <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-check text-gray-400"></i>
                                    </div>
                                    <input type="date" 
                                           id="end_date" 
                                           name="end_date" 
                                           value="{{ old('end_date') }}"
                                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('end_date') border-red-500 @enderror" 
                                           required>
                                </div>
                                @error('end_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Keterangan -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                Keterangan
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="4"
                                      placeholder="Keterangan tambahan (opsional)"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 resize-none @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Maksimal 500 karakter</p>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Set Aktif Toggle -->
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <div class="flex items-center h-6">
                                    <input type="checkbox" 
                                           id="is_active" 
                                           name="is_active" 
                                           value="1"
                                           {{ old('is_active') ? 'checked' : '' }}
                                           class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                </div>
                                <div class="flex-1">
                                    <span class="text-sm font-bold text-gray-900">Set sebagai Tahun Ajaran Aktif</span>
                                    <p class="text-xs text-gray-600 mt-1">
                                        <i class="fas fa-info-circle text-green-600"></i>
                                        Jika dicentang, tahun ajaran lain akan otomatis dinonaktifkan
                                    </p>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-emerald-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-save"></i>
                                <span>Simpan Tahun Ajaran</span>
                            </button>
                            <a href="{{ route('academic-years.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all duration-200 shadow-sm">
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
            
            <!-- Info Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-cyan-600">
                    <h3 class="text-base font-bold text-white flex items-center gap-2">
                        <i class="fas fa-info-circle"></i>
                        Informasi
                    </h3>
                </div>
                <div class="p-5 space-y-4">
                    <!-- Contoh Format -->
                    <div>
                        <p class="text-sm font-bold text-gray-900 mb-2">Contoh Format Tahun Ajaran:</p>
                        <ul class="space-y-1.5">
                            <li class="flex items-center gap-2 text-sm text-gray-700">
                                <i class="fas fa-check text-green-500 text-xs"></i>
                                <code class="px-2 py-0.5 bg-gray-100 rounded text-xs">2024/2025</code>
                                <span class="text-xs">- Format standar</span>
                            </li>
                            <li class="flex items-center gap-2 text-sm text-gray-700">
                                <i class="fas fa-check text-green-500 text-xs"></i>
                                <code class="px-2 py-0.5 bg-gray-100 rounded text-xs">2025/2026</code>
                                <span class="text-xs">- Tahun berikutnya</span>
                            </li>
                        </ul>
                    </div>
                    
                    <hr class="border-gray-200">
                    
                    <!-- Periode Semester -->
                    <div>
                        <p class="text-sm font-bold text-gray-900 mb-2">Periode Semester:</p>
                        <ul class="space-y-1.5">
                            <li class="flex items-start gap-2 text-sm">
                                <i class="fas fa-calendar text-blue-500 mt-0.5"></i>
                                <div>
                                    <span class="font-semibold text-gray-900">Ganjil:</span>
                                    <span class="text-gray-600">Juli - Desember</span>
                                </div>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <i class="fas fa-calendar text-purple-500 mt-0.5"></i>
                                <div>
                                    <span class="font-semibold text-gray-900">Genap:</span>
                                    <span class="text-gray-600">Januari - Juni</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                    <hr class="border-gray-200">
                    
                    <!-- Catatan Penting -->
                    <div>
                        <p class="text-sm font-bold text-gray-900 mb-2">Catatan Penting:</p>
                        <ul class="space-y-1.5">
                            <li class="flex items-start gap-2 text-xs text-gray-600">
                                <i class="fas fa-dot-circle text-gray-400 mt-1"></i>
                                <span>Tahun ajaran harus unik</span>
                            </li>
                            <li class="flex items-start gap-2 text-xs text-gray-600">
                                <i class="fas fa-dot-circle text-gray-400 mt-1"></i>
                                <span>Tanggal selesai harus setelah tanggal mulai</span>
                            </li>
                            <li class="flex items-start gap-2 text-xs text-gray-600">
                                <i class="fas fa-dot-circle text-gray-400 mt-1"></i>
                                <span>Hanya 1 tahun ajaran yang boleh aktif</span>
                            </li>
                            <li class="flex items-start gap-2 text-xs text-gray-600">
                                <i class="fas fa-dot-circle text-gray-400 mt-1"></i>
                                <span>Tahun ajaran aktif akan digunakan sebagai default</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Tips Card -->
            <div class="bg-gradient-to-br from-amber-50 to-yellow-50 border border-amber-200 rounded-2xl p-5">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-lightbulb text-amber-600 text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-amber-900 mb-1">Tips</h4>
                        <p class="text-xs text-amber-800 leading-relaxed">
                            Set tahun ajaran baru sebagai aktif untuk mulai menggunakannya di seluruh sistem.
                        </p>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-calculate semester based on dates
    const startDate = document.getElementById('start_date');
    const semesterSelect = document.getElementById('semester');
    
    startDate.addEventListener('change', function() {
        const date = new Date(this.value);
        const month = date.getMonth() + 1; // 0-indexed
        
        // Semester Ganjil: Juli (7) - Desember (12)
        // Semester Genap: Januari (1) - Juni (6)
        if (month >= 7 && month <= 12) {
            semesterSelect.value = 'Ganjil';
        } else if (month >= 1 && month <= 6) {
            semesterSelect.value = 'Genap';
        }
    });
});
</script>
@endpush
