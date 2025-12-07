@extends('layouts.modern')

@section('title', 'Edit Mata Pelajaran')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-100 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent mb-2">
                        Edit Mata Pelajaran
                    </h1>
                    <p class="text-gray-600 flex items-center gap-2">
                        <i class="fas fa-book-reader"></i>
                        Edit data mata pelajaran {{ $subject->name }}
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('subjects.index') }}" 
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
                <div class="bg-white rounded-2xl shadow-lg border border-emerald-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-edit text-white"></i>
                            </div>
                            <span>Form Edit Mata Pelajaran</span>
                        </h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('subjects.update', $subject) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <!-- Kode Mata Pelajaran -->
                            <div class="mb-6">
                                <label for="code" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Kode Mata Pelajaran <span class="text-red-600">*</span>
                                </label>
                                <input type="text" 
                                       class="w-full px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 @error('code') border-red-500 bg-red-50 @enderror" 
                                       id="code" 
                                       name="code" 
                                       value="{{ old('code', $subject->code) }}" 
                                       placeholder="MTK, IPA, IPS, dll" 
                                       required>
                                <p class="mt-1 text-xs text-gray-500">Kode unik untuk mata pelajaran (contoh: MTK, IPA, B.IND)</p>
                                @error('code')
                                    <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            
                            <!-- Nama Mata Pelajaran -->
                            <div class="mb-6">
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Mata Pelajaran <span class="text-red-600">*</span>
                                </label>
                                <input type="text" 
                                       class="w-full px-4 py-3 bg-teal-50 border border-teal-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 @error('name') border-red-500 bg-red-50 @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $subject->name) }}" 
                                       placeholder="Matematika, Ilmu Pengetahuan Alam, dll" 
                                       required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            
                            <!-- Deskripsi -->
                            <div class="mb-6">
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Deskripsi
                                </label>
                                <textarea 
                                    class="w-full px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 @error('description') border-red-500 bg-red-50 @enderror" 
                                    id="description" 
                                    name="description" 
                                    rows="4" 
                                    placeholder="Deskripsi singkat tentang mata pelajaran ini...">{{ old('description', $subject->description) }}</textarea>
                                <p class="mt-1 text-xs text-gray-500">Opsional: Deskripsi atau keterangan tambahan</p>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            
                            <!-- Submit Buttons -->
                            <div class="flex flex-col gap-3 mt-8">
                                <button type="submit" 
                                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-lg hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-md hover:shadow-lg font-medium">
                                    <i class="fas fa-save"></i>
                                    <span>Update Mata Pelajaran</span>
                                </button>
                                <a href="{{ route('subjects.index') }}" 
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
                
                <!-- Info Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-emerald-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-teal-600 to-emerald-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-info-circle"></i>
                            <span>Informasi</span>
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <div class="bg-emerald-50 rounded-lg p-3 border border-emerald-100">
                                <p class="text-xs text-emerald-600 font-semibold mb-1">Dibuat</p>
                                <p class="text-gray-800 font-medium text-sm">{{ $subject->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="bg-teal-50 rounded-lg p-3 border border-teal-100">
                                <p class="text-xs text-teal-600 font-semibold mb-1">Terakhir Diupdate</p>
                                <p class="text-gray-800 font-medium text-sm">{{ $subject->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl shadow-lg border border-amber-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-600 to-orange-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-lightbulb"></i>
                            <span>Catatan Penting</span>
                        </h3>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-amber-600 mt-0.5"></i>
                                <span>Kode mata pelajaran harus unik</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-exclamation-triangle text-orange-600 mt-0.5"></i>
                                <span>Perubahan akan mempengaruhi semua data terkait</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-shield-alt text-amber-600 mt-0.5"></i>
                                <span>Hati-hati saat mengubah kode</span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
