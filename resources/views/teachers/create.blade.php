@extends('layouts.modern')

@section('title', 'Tambah Guru')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user-plus text-white text-xl"></i>
                    </div>
                    Tambah Guru
                </h1>
                <p class="text-gray-600 mt-2">Tambah data guru baru ke dalam sistem</p>
            </div>
            <a href="{{ route('teachers.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all duration-200 shadow-sm">
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
                        <i class="fas fa-edit text-teal-600"></i>
                        Form Tambah Guru
                    </h2>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        
                        <!-- Data Pribadi Section -->
                        <div>
                            <div class="flex items-center gap-2 mb-4 pb-2 border-b-2 border-teal-500">
                                <i class="fas fa-user text-teal-600"></i>
                                <h3 class="text-lg font-bold text-gray-900">Data Pribadi</h3>
                            </div>
                            
                            <div class="space-y-6">
                                <!-- Row 1: NIP & Nama -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="nip" class="block text-sm font-semibold text-gray-700 mb-2">
                                            NIP <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" 
                                               id="nip" 
                                               name="nip" 
                                               value="{{ old('nip') }}"
                                               placeholder="Nomor Induk Pegawai"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 @error('nip') border-red-500 @enderror" 
                                               required>
                                        @error('nip')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Nama Lengkap <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name') }}"
                                               placeholder="Nama lengkap guru"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror" 
                                               required>
                                        @error('name')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Row 2: Gender & Birth Date -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="gender" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Jenis Kelamin <span class="text-red-500">*</span>
                                        </label>
                                        <select id="gender" 
                                                name="gender" 
                                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 @error('gender') border-red-500 @enderror" 
                                                required>
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('gender')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="birth_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Tanggal Lahir
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-calendar text-gray-400"></i>
                                            </div>
                                            <input type="date" 
                                                   id="birth_date" 
                                                   name="birth_date" 
                                                   value="{{ old('birth_date') }}"
                                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 @error('birth_date') border-red-500 @enderror">
                                        </div>
                                        @error('birth_date')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Row 3: Phone & Photo -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                            No. HP
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-phone text-gray-400"></i>
                                            </div>
                                            <input type="text" 
                                                   id="phone" 
                                                   name="phone" 
                                                   value="{{ old('phone') }}"
                                                   placeholder="081234567890"
                                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 @error('phone') border-red-500 @enderror">
                                        </div>
                                        @error('phone')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="photo" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Foto
                                        </label>
                                        <input type="file" 
                                               id="photo" 
                                               name="photo" 
                                               accept="image/*"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 @error('photo') border-red-500 @enderror">
                                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (Max: 2MB)</p>
                                        @error('photo')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Address -->
                                <div>
                                    <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Alamat
                                    </label>
                                    <textarea id="address" 
                                              name="address" 
                                              rows="3"
                                              placeholder="Alamat lengkap guru"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 resize-none @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                                    @error('address')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Data Pendidikan & Jabatan Section -->
                        <div>
                            <div class="flex items-center gap-2 mb-4 pb-2 border-b-2 border-blue-500">
                                <i class="fas fa-graduation-cap text-blue-600"></i>
                                <h3 class="text-lg font-bold text-gray-900">Data Pendidikan & Jabatan</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="education_level" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Pendidikan Terakhir
                                    </label>
                                    <select id="education_level" 
                                            name="education_level" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 @error('education_level') border-red-500 @enderror">
                                        <option value="">-- Pilih Pendidikan --</option>
                                        <option value="D3" {{ old('education_level') == 'D3' ? 'selected' : '' }}>D3</option>
                                        <option value="S1" {{ old('education_level') == 'S1' ? 'selected' : '' }}>S1</option>
                                        <option value="S2" {{ old('education_level') == 'S2' ? 'selected' : '' }}>S2</option>
                                        <option value="S3" {{ old('education_level') == 'S3' ? 'selected' : '' }}>S3</option>
                                    </select>
                                    @error('education_level')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="position" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Jabatan
                                    </label>
                                    <input type="text" 
                                           id="position" 
                                           name="position" 
                                           value="{{ old('position') }}"
                                           placeholder="Guru Mata Pelajaran / Wali Kelas"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 @error('position') border-red-500 @enderror">
                                    @error('position')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Akun Login Section -->
                        <div>
                            <div class="flex items-center gap-2 mb-4 pb-2 border-b-2 border-purple-500">
                                <i class="fas fa-key text-purple-600"></i>
                                <h3 class="text-lg font-bold text-gray-900">Akun Login</h3>
                            </div>
                            
                            <div class="space-y-6">
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-envelope text-gray-400"></i>
                                        </div>
                                        <input type="email" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email') }}"
                                               placeholder="email@example.com"
                                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 @error('email') border-red-500 @enderror" 
                                               required>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Email akan digunakan untuk login</p>
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Password <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                        <input type="password" 
                                               id="password" 
                                               name="password"
                                               placeholder="Minimal 6 karakter"
                                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 @error('password') border-red-500 @enderror" 
                                               required>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Minimal 6 karakter</p>
                                    @error('password')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-teal-500 to-cyan-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-cyan-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-save"></i>
                                <span>Simpan Data Guru</span>
                            </button>
                            <a href="{{ route('teachers.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all duration-200 shadow-sm">
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
                <div class="px-6 py-4 bg-gradient-to-r from-cyan-500 to-blue-600">
                    <h3 class="text-base font-bold text-white flex items-center gap-2">
                        <i class="fas fa-info-circle"></i>
                        Informasi
                    </h3>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <p class="text-sm font-bold text-gray-900 mb-2">Field yang wajib diisi:</p>
                        <ul class="space-y-1.5">
                            <li class="flex items-center gap-2 text-xs text-gray-700">
                                <i class="fas fa-check-circle text-green-500"></i>
                                <span>NIP (unik)</span>
                            </li>
                            <li class="flex items-center gap-2 text-xs text-gray-700">
                                <i class="fas fa-check-circle text-green-500"></i>
                                <span>Nama Lengkap</span>
                            </li>
                            <li class="flex items-center gap-2 text-xs text-gray-700">
                                <i class="fas fa-check-circle text-green-500"></i>
                                <span>Jenis Kelamin</span>
                            </li>
                            <li class="flex items-center gap-2 text-xs text-gray-700">
                                <i class="fas fa-check-circle text-green-500"></i>
                                <span>Email (unik)</span>
                            </li>
                            <li class="flex items-center gap-2 text-xs text-gray-700">
                                <i class="fas fa-check-circle text-green-500"></i>
                                <span>Password</span>
                            </li>
                        </ul>
                    </div>
                    
                    <hr class="border-gray-200">
                    
                    <div>
                        <p class="text-sm font-bold text-gray-900 mb-2">Catatan:</p>
                        <ul class="space-y-1.5">
                            <li class="flex items-start gap-2 text-xs text-gray-600">
                                <i class="fas fa-dot-circle text-gray-400 mt-1"></i>
                                <span>Email digunakan untuk login</span>
                            </li>
                            <li class="flex items-start gap-2 text-xs text-gray-600">
                                <i class="fas fa-dot-circle text-gray-400 mt-1"></i>
                                <span>Password minimal 6 karakter</span>
                            </li>
                            <li class="flex items-start gap-2 text-xs text-gray-600">
                                <i class="fas fa-dot-circle text-gray-400 mt-1"></i>
                                <span>Foto maksimal 2MB</span>
                            </li>
                            <li class="flex items-start gap-2 text-xs text-gray-600">
                                <i class="fas fa-dot-circle text-gray-400 mt-1"></i>
                                <span>Status default: Aktif</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="bg-gradient-to-br from-teal-50 to-cyan-50 border border-teal-200 rounded-2xl p-5">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-teal-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-lightbulb text-teal-600 text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-teal-900 mb-1">Tips</h4>
                        <p class="text-xs text-teal-800 leading-relaxed">
                            Pastikan email yang dimasukkan valid dan dapat diakses oleh guru untuk keperluan login sistem.
                        </p>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
</div>
@endsection
