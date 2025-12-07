@extends('layouts.modern')

@section('title', 'Tambah Mata Pelajaran')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="bg-gradient-to-br from-emerald-600 to-teal-600 p-3 rounded-xl shadow-lg">
                    <i class="fas fa-book-medical text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Tambah Mata Pelajaran</h1>
                    <p class="text-gray-600 mt-1">Tambah mata pelajaran baru ke dalam sistem</p>
                </div>
            </div>
        </div>
        <a href="{{ route('subjects.index') }}" 
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 text-white font-medium rounded-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>
</div>

<!-- Error Alert (if any validation errors) -->
@if ($errors->any())
<div class="mb-8 bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 rounded-xl p-6 shadow-lg">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <i class="fas fa-exclamation-circle text-red-600 text-2xl"></i>
        </div>
        <div class="ml-4 flex-1">
            <h3 class="text-lg font-semibold text-red-900 mb-2">Terdapat Kesalahan Validasi</h3>
            <ul class="list-disc list-inside text-red-700 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Form Section -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-8 py-6">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 p-2.5 rounded-lg">
                        <i class="fas fa-edit text-white text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-white">Form Tambah Mata Pelajaran</h2>
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-8">
                <form action="{{ route('subjects.store') }}" method="POST">
                    @csrf

                    <!-- Kode Mata Pelajaran -->
                    <div class="mb-6">
                        <label for="code" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kode Mata Pelajaran <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               class="w-full px-4 py-3 bg-gradient-to-r from-emerald-50 to-teal-50 border-2 border-emerald-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition-all @error('code') border-red-500 bg-red-50 @enderror" 
                               id="code" 
                               name="code" 
                               value="{{ old('code') }}" 
                               placeholder="MTK, IPA, IPS, dll" 
                               required>
                        <p class="mt-2 text-sm text-gray-600">
                            <i class="fas fa-info-circle text-emerald-600 mr-1"></i>
                            Kode unik untuk mata pelajaran (contoh: MTK, IPA, B.IND)
                        </p>
                        @error('code')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Nama Mata Pelajaran -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Mata Pelajaran <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               class="w-full px-4 py-3 bg-gradient-to-r from-teal-50 to-emerald-50 border-2 border-teal-200 rounded-xl focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition-all @error('name') border-red-500 bg-red-50 @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               placeholder="Matematika, Ilmu Pengetahuan Alam, dll" 
                               required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-8">
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea 
                            class="w-full px-4 py-3 bg-gradient-to-br from-emerald-50 to-teal-50 border-2 border-emerald-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition-all @error('description') border-red-500 bg-red-50 @enderror" 
                            id="description" 
                            name="description" 
                            rows="5" 
                            placeholder="Deskripsi singkat tentang mata pelajaran ini...">{{ old('description') }}</textarea>
                        <p class="mt-2 text-sm text-gray-600">
                            <i class="fas fa-info-circle text-teal-600 mr-1"></i>
                            Opsional: Deskripsi atau keterangan tambahan
                        </p>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="submit" 
                                class="flex-1 inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold rounded-xl hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Mata Pelajaran
                        </button>
                        <a href="{{ route('subjects.index') }}" 
                           class="flex-1 inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold rounded-xl hover:from-gray-600 hover:to-gray-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar Section -->
    <div class="space-y-6">
        <!-- Informasi Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-br from-emerald-600 to-teal-600 px-6 py-4">
                <div class="flex items-center gap-2">
                    <div class="bg-white/20 p-2 rounded-lg">
                        <i class="fas fa-info-circle text-white"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Informasi</h3>
                </div>
            </div>
            <div class="p-6">
                <p class="text-sm font-semibold text-gray-700 mb-3">
                    <i class="fas fa-lightbulb text-emerald-600 mr-2"></i>Contoh Kode Mata Pelajaran:
                </p>
                <ul class="space-y-2 mb-5">
                    <li class="flex items-start text-sm text-gray-700">
                        <span class="inline-block bg-emerald-100 text-emerald-800 font-mono text-xs px-2 py-1 rounded mr-2 mt-0.5">MTK</span>
                        <span>Matematika</span>
                    </li>
                    <li class="flex items-start text-sm text-gray-700">
                        <span class="inline-block bg-teal-100 text-teal-800 font-mono text-xs px-2 py-1 rounded mr-2 mt-0.5">IPA</span>
                        <span>Ilmu Pengetahuan Alam</span>
                    </li>
                    <li class="flex items-start text-sm text-gray-700">
                        <span class="inline-block bg-emerald-100 text-emerald-800 font-mono text-xs px-2 py-1 rounded mr-2 mt-0.5">IPS</span>
                        <span>Ilmu Pengetahuan Sosial</span>
                    </li>
                    <li class="flex items-start text-sm text-gray-700">
                        <span class="inline-block bg-teal-100 text-teal-800 font-mono text-xs px-2 py-1 rounded mr-2 mt-0.5">B.IND</span>
                        <span>Bahasa Indonesia</span>
                    </li>
                    <li class="flex items-start text-sm text-gray-700">
                        <span class="inline-block bg-emerald-100 text-emerald-800 font-mono text-xs px-2 py-1 rounded mr-2 mt-0.5">B.ING</span>
                        <span>Bahasa Inggris</span>
                    </li>
                    <li class="flex items-start text-sm text-gray-700">
                        <span class="inline-block bg-teal-100 text-teal-800 font-mono text-xs px-2 py-1 rounded mr-2 mt-0.5">PJOK</span>
                        <span>Pendidikan Jasmani</span>
                    </li>
                    <li class="flex items-start text-sm text-gray-700">
                        <span class="inline-block bg-emerald-100 text-emerald-800 font-mono text-xs px-2 py-1 rounded mr-2 mt-0.5">SBK</span>
                        <span>Seni Budaya</span>
                    </li>
                </ul>

                <div class="border-t border-gray-200 pt-4">
                    <p class="text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-clipboard-check text-teal-600 mr-2"></i>Catatan:
                    </p>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-emerald-600 mr-2 mt-0.5"></i>
                            <span>Kode harus unik</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-emerald-600 mr-2 mt-0.5"></i>
                            <span>Nama harus jelas dan lengkap</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-emerald-600 mr-2 mt-0.5"></i>
                            <span>Deskripsi bersifat opsional</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tips Card -->
        <div class="bg-gradient-to-br from-teal-50 to-emerald-50 border-2 border-teal-200 rounded-2xl p-6 shadow-lg">
            <div class="flex items-start gap-3">
                <div class="bg-teal-600 p-2.5 rounded-lg mt-1">
                    <i class="fas fa-lightbulb text-white"></i>
                </div>
                <div>
                    <h4 class="font-bold text-teal-900 mb-2">Tips</h4>
                    <p class="text-sm text-teal-800 leading-relaxed">
                        Gunakan kode singkat yang mudah diingat dan dikenali. Pastikan nama mata pelajaran sesuai dengan kurikulum yang berlaku.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
