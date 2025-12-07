@extends('layouts.modern')

@section('title', 'Edit Guru')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-amber-50 to-orange-100 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-amber-600 bg-clip-text text-transparent mb-2">
                        Edit Data Guru
                    </h1>
                    <p class="text-gray-600 flex items-center gap-2">
                        <i class="fas fa-user-edit"></i>
                        Edit data guru {{ $teacher->name }}
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('teachers.index') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-sm border border-gray-200">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl mb-6">
                <div class="flex items-center gap-3 mb-2">
                    <i class="fas fa-exclamation-circle text-2xl"></i>
                    <h3 class="font-bold">Terjadi Kesalahan!</h3>
                </div>
                <ul class="list-disc list-inside text-sm space-y-1 ml-8">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('teachers.update', $teacher) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Main Form Section -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Personal Information -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-orange-100">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-orange-600 to-amber-600 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                            <span>Data Pribadi</span>
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nip" class="block text-sm font-semibold text-gray-700 mb-2">
                                    NIP <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="nip" 
                                       name="nip" 
                                       value="{{ old('nip', $teacher->nip) }}" 
                                       required
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('nip') border-red-500 @enderror">
                                @error('nip')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $teacher->name) }}" 
                                       required
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="gender" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Jenis Kelamin <span class="text-red-500">*</span>
                                </label>
                                <select id="gender" 
                                        name="gender"
                                        required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('gender') border-red-500 @enderror">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('gender', $teacher->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender', $teacher->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="birth_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tanggal Lahir
                                </label>
                                <input type="date" 
                                       id="birth_date" 
                                       name="birth_date" 
                                       value="{{ old('birth_date', $teacher->birth_date ? $teacher->birth_date->format('Y-m-d') : '') }}" 
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('birth_date') border-red-500 @enderror">
                                @error('birth_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nomor Telepon
                                </label>
                                <input type="text" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $teacher->phone) }}" 
                                       placeholder="08xxxxxxxxxx"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('phone') border-red-500 @enderror">
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="photo" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Upload Foto
                                </label>
                                <input type="file" 
                                       id="photo" 
                                       name="photo" 
                                       accept="image/jpeg,image/png,image/jpg"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('photo') border-red-500 @enderror">
                                @error('photo')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-2">
                                    Format: JPG, JPEG, PNG. Kosongkan jika tidak ingin mengubah
                                </p>
                            </div>

                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Alamat Lengkap
                                </label>
                                <textarea id="address" 
                                          name="address" 
                                          rows="3"
                                          placeholder="Masukkan alamat lengkap..."
                                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('address') border-red-500 @enderror">{{ old('address', $teacher->address) }}</textarea>
                                @error('address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Education & Position -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-orange-100">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-orange-600 to-amber-600 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-graduation-cap text-sm"></i>
                            </div>
                            <span>Data Pendidikan & Jabatan</span>
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="education_level" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Jenjang Pendidikan
                                </label>
                                <select id="education_level" 
                                        name="education_level"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('education_level') border-red-500 @enderror">
                                    <option value="">Pilih Jenjang</option>
                                    <option value="D3" {{ old('education_level', $teacher->education_level) == 'D3' ? 'selected' : '' }}>D3</option>
                                    <option value="S1" {{ old('education_level', $teacher->education_level) == 'S1' ? 'selected' : '' }}>S1</option>
                                    <option value="S2" {{ old('education_level', $teacher->education_level) == 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="S3" {{ old('education_level', $teacher->education_level) == 'S3' ? 'selected' : '' }}>S3</option>
                                </select>
                                @error('education_level')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="position" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Jabatan
                                </label>
                                <input type="text" 
                                       id="position" 
                                       name="position" 
                                       value="{{ old('position', $teacher->position) }}" 
                                       placeholder="Guru Mata Pelajaran / Wali Kelas"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('position') border-red-500 @enderror">
                                @error('position')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select id="status" 
                                        name="status"
                                        required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('status') border-red-500 @enderror">
                                    <option value="active" {{ old('status', $teacher->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ old('status', $teacher->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-orange-100">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-orange-600 to-amber-600 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-key text-sm"></i>
                            </div>
                            <span>Akun Login</span>
                        </h2>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $teacher->user->email) }}" 
                                   required
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-2">Email digunakan untuk login ke sistem</p>
                        </div>
                    </div>

                </div>

                <!-- Sidebar Section -->
                <div class="lg:col-span-1 space-y-6">
                    
                    <!-- Current Photo Preview -->
                    @if($teacher->photo)
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-orange-100">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-image text-orange-600"></i>
                            <span>Foto Saat Ini</span>
                        </h3>
                        <img src="{{ asset('storage/' . $teacher->photo) }}" 
                             alt="{{ $teacher->name }}" 
                             class="w-full h-48 object-cover rounded-xl border-4 border-orange-100 shadow-lg">
                    </div>
                    @endif

                    <!-- Info Card -->
                    <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl shadow-lg p-6 border border-orange-200">
                        <h3 class="font-bold text-orange-800 mb-3 flex items-center gap-2">
                            <i class="fas fa-info-circle"></i>
                            <span>Informasi</span>
                        </h3>
                        <div class="space-y-2 text-sm text-orange-700">
                            <div class="flex items-start gap-2">
                                <i class="fas fa-calendar text-orange-600 mt-0.5"></i>
                                <div>
                                    <strong>Dibuat:</strong><br>
                                    {{ $teacher->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fas fa-clock text-orange-600 mt-0.5"></i>
                                <div>
                                    <strong>Update Terakhir:</strong><br>
                                    {{ $teacher->updated_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tips Card -->
                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl shadow-lg p-6 border border-amber-200">
                        <h3 class="font-bold text-amber-800 mb-3 flex items-center gap-2">
                            <i class="fas fa-lightbulb"></i>
                            <span>Tips</span>
                        </h3>
                        <ul class="space-y-2 text-sm text-amber-700">
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-amber-600 mt-0.5"></i>
                                <span>Pastikan data yang diisi akurat</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-amber-600 mt-0.5"></i>
                                <span>Email harus unik untuk setiap guru</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-amber-600 mt-0.5"></i>
                                <span>Foto akan diubah jika Anda upload file baru</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-orange-100 space-y-3">
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-orange-600 to-amber-600 text-white rounded-lg hover:from-orange-700 hover:to-amber-700 transition-all duration-200 shadow-lg hover:shadow-xl font-medium">
                            <i class="fas fa-save"></i>
                            <span>Update Data Guru</span>
                        </button>
                        
                        <a href="{{ route('teachers.index') }}" 
                           class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-md border border-gray-200 font-medium">
                            <i class="fas fa-times"></i>
                            <span>Batal</span>
                        </a>
                    </div>

                </div>
            </div>
        </form>

    </div>
</div>
@endsection
