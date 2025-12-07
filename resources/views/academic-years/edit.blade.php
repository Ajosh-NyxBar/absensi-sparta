@extends('layouts.modern')

@section('title', 'Edit Tahun Ajaran')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-sky-50 via-cyan-50 to-blue-100 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-sky-600 to-cyan-600 bg-clip-text text-transparent mb-2">
                        Edit Tahun Ajaran
                    </h1>
                    <p class="text-gray-600 flex items-center gap-2">
                        <i class="fas fa-edit"></i>
                        Edit data tahun ajaran {{ $academicYear->full_name }}
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('academic-years.index') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-sm border border-gray-200">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg border border-sky-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-sky-600 to-cyan-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-edit text-white"></i>
                            </div>
                            <span>Form Edit Tahun Ajaran</span>
                        </h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('academic-years.update', $academicYear->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <!-- Tahun Ajaran -->
                                <div>
                                    <label for="year" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Tahun Ajaran <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" 
                                           class="w-full px-4 py-3 bg-sky-50 border border-sky-200 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all duration-200 @error('year') border-red-500 bg-red-50 @enderror" 
                                           id="year" 
                                           name="year" 
                                           value="{{ old('year', $academicYear->year) }}" 
                                           placeholder="2024/2025" 
                                           required>
                                    <p class="mt-1 text-xs text-gray-500">Format: YYYY/YYYY</p>
                                    @error('year')
                                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                
                                <!-- Semester -->
                                <div>
                                    <label for="semester" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Semester <span class="text-red-600">*</span>
                                    </label>
                                    <select class="w-full px-4 py-3 bg-cyan-50 border border-cyan-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 @error('semester') border-red-500 bg-red-50 @enderror" 
                                            id="semester" 
                                            name="semester" 
                                            required>
                                        <option value="">-- Pilih Semester --</option>
                                        <option value="Ganjil" {{ old('semester', $academicYear->semester) == 'Ganjil' ? 'selected' : '' }}>Semester Ganjil</option>
                                        <option value="Genap" {{ old('semester', $academicYear->semester) == 'Genap' ? 'selected' : '' }}>Semester Genap</option>
                                    </select>
                                    @error('semester')
                                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <!-- Tanggal Mulai -->
                                <div>
                                    <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Tanggal Mulai <span class="text-red-600">*</span>
                                    </label>
                                    <input type="date" 
                                           class="w-full px-4 py-3 bg-sky-50 border border-sky-200 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all duration-200 @error('start_date') border-red-500 bg-red-50 @enderror" 
                                           id="start_date" 
                                           name="start_date" 
                                           value="{{ old('start_date', $academicYear->start_date->format('Y-m-d')) }}" 
                                           required>
                                    @error('start_date')
                                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                
                                <!-- Tanggal Selesai -->
                                <div>
                                    <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Tanggal Selesai <span class="text-red-600">*</span>
                                    </label>
                                    <input type="date" 
                                           class="w-full px-4 py-3 bg-cyan-50 border border-cyan-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 @error('end_date') border-red-500 bg-red-50 @enderror" 
                                           id="end_date" 
                                           name="end_date" 
                                           value="{{ old('end_date', $academicYear->end_date->format('Y-m-d')) }}" 
                                           required>
                                    @error('end_date')
                                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Keterangan -->
                            <div class="mb-6">
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Keterangan
                                </label>
                                <textarea 
                                    class="w-full px-4 py-3 bg-sky-50 border border-sky-200 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all duration-200 @error('description') border-red-500 bg-red-50 @enderror" 
                                    id="description" 
                                    name="description" 
                                    rows="3" 
                                    placeholder="Keterangan tambahan (opsional)">{{ old('description', $academicYear->description) }}</textarea>
                                <p class="mt-1 text-xs text-gray-500">Maksimal 500 karakter</p>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            
                            <!-- Status Aktif -->
                            <div class="mb-6">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <label class="flex items-start gap-3 cursor-pointer">
                                        <input type="checkbox" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1" 
                                               {{ old('is_active', $academicYear->is_active) ? 'checked' : '' }}
                                               class="mt-1 w-5 h-5 text-sky-600 bg-white border-gray-300 rounded focus:ring-sky-500 focus:ring-2">
                                        <div class="flex-1">
                                            <span class="font-semibold text-gray-800">Set sebagai Tahun Ajaran Aktif</span>
                                            <p class="text-xs text-gray-600 mt-1">Jika dicentang, tahun ajaran lain akan otomatis dinonaktifkan</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Submit Buttons -->
                            <div class="flex flex-col gap-3">
                                <button type="submit" 
                                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-sky-600 to-cyan-600 text-white rounded-lg hover:from-sky-700 hover:to-cyan-700 transition-all duration-200 shadow-md hover:shadow-lg font-medium">
                                    <i class="fas fa-save"></i>
                                    <span>Update Tahun Ajaran</span>
                                </button>
                                <a href="{{ route('academic-years.index') }}" 
                                   class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 border border-gray-300 font-medium">
                                    <i class="fas fa-times"></i>
                                    <span>Batal</span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Data Terkait Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-cyan-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-600 to-sky-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-chart-bar"></i>
                            <span>Data Terkait</span>
                        </h3>
                    </div>
                    <div class="p-6">
                        @php
                            $relatedData = $academicYear->getRelatedDataInfo();
                        @endphp
                        
                        <div class="space-y-3">
                            <div class="flex items-center justify-between bg-sky-50 rounded-lg p-3 border border-sky-100">
                                <span class="text-sm text-gray-700 flex items-center gap-2">
                                    <i class="fas fa-door-open text-sky-600"></i>
                                    Kelas
                                </span>
                                <span class="inline-flex items-center px-3 py-1 bg-sky-600 text-white rounded-lg font-bold text-sm">
                                    {{ $relatedData['classes'] }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between bg-cyan-50 rounded-lg p-3 border border-cyan-100">
                                <span class="text-sm text-gray-700 flex items-center gap-2">
                                    <i class="fas fa-chart-line text-cyan-600"></i>
                                    Nilai
                                </span>
                                <span class="inline-flex items-center px-3 py-1 bg-cyan-600 text-white rounded-lg font-bold text-sm">
                                    {{ $relatedData['grades'] }}
                                </span>
                            </div>
                        </div>
                        
                        @if($relatedData['classes'] > 0 || $relatedData['grades'] > 0)
                        <div class="mt-4 bg-amber-50 border border-amber-200 rounded-lg p-3">
                            <p class="text-xs text-amber-800 flex items-start gap-2">
                                <i class="fas fa-exclamation-triangle text-amber-600 mt-0.5"></i>
                                <span>Perubahan tahun ajaran akan mempengaruhi data terkait.</span>
                            </p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Status Aktif Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-sky-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-sky-600 to-cyan-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-toggle-on"></i>
                            <span>Status Aktif</span>
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="mb-3">
                            <p class="text-sm text-gray-600 mb-2">Status Saat Ini:</p>
                            @if($academicYear->is_active)
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-green-100 text-green-700 rounded-lg font-semibold text-sm border border-green-200">
                                    <i class="fas fa-check-circle"></i>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg font-semibold text-sm border border-gray-200">
                                    <i class="fas fa-times-circle"></i>
                                    Non-Aktif
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600">
                            @if($academicYear->is_active)
                                <i class="fas fa-info-circle text-green-600 mr-1"></i>
                                Tahun ajaran ini sedang digunakan di sistem.
                            @else
                                <i class="fas fa-info-circle text-gray-600 mr-1"></i>
                                Tahun ajaran ini tidak aktif.
                            @endif
                        </p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
