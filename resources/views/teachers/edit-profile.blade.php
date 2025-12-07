@extends('layouts.modern')

@section('title', 'Edit Profil Guru')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-purple-100 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">
                        Edit Profil Guru
                    </h1>
                    <p class="text-gray-600 flex items-center gap-2">
                        <i class="fas fa-user-edit"></i>
                        Perbarui informasi profil Anda
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-sm border border-gray-200">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
                <i class="fas fa-check-circle text-2xl"></i>
                <div>
                    <h3 class="font-bold">Berhasil!</h3>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

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

        <form action="{{ route('teachers.update-profile') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Main Form Section -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Personal Information -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-purple-100">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-purple-600 to-pink-600 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                            <span>Informasi Pribadi</span>
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $teacher->name) }}" 
                                       required
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nip" class="block text-sm font-semibold text-gray-700 mb-2">
                                    NIP <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="nip" 
                                       name="nip" 
                                       value="{{ old('nip', $teacher->nip) }}" 
                                       required
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('nip') border-red-500 @enderror">
                                @error('nip')
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
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('phone') border-red-500 @enderror">
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="gender" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Jenis Kelamin
                                </label>
                                <select id="gender" 
                                        name="gender"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('gender') border-red-500 @enderror">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('gender', $teacher->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender', $teacher->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="birth_place" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tempat Lahir
                                </label>
                                <input type="text" 
                                       id="birth_place" 
                                       name="birth_place" 
                                       value="{{ old('birth_place', $teacher->birth_place) }}" 
                                       placeholder="Contoh: Jakarta"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('birth_place') border-red-500 @enderror">
                                @error('birth_place')
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
                                       value="{{ old('birth_date', $teacher->birth_date) }}" 
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('birth_date') border-red-500 @enderror">
                                @error('birth_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="religion" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Agama
                                </label>
                                <select id="religion" 
                                        name="religion"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('religion') border-red-500 @enderror">
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam" {{ old('religion', $teacher->religion) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('religion', $teacher->religion) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ old('religion', $teacher->religion) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ old('religion', $teacher->religion) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('religion', $teacher->religion) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ old('religion', $teacher->religion) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                </select>
                                @error('religion')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Alamat Lengkap
                                </label>
                                <textarea id="address" 
                                          name="address" 
                                          rows="3"
                                          placeholder="Masukkan alamat lengkap..."
                                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('address') border-red-500 @enderror">{{ old('address', $teacher->address) }}</textarea>
                                @error('address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Education Information -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-purple-100">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-purple-600 to-pink-600 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-graduation-cap text-sm"></i>
                            </div>
                            <span>Informasi Pendidikan</span>
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="education_level" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Jenjang Pendidikan
                                </label>
                                <select id="education_level" 
                                        name="education_level"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('education_level') border-red-500 @enderror">
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
                                <label for="major" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Jurusan/Program Studi
                                </label>
                                <input type="text" 
                                       id="major" 
                                       name="major" 
                                       value="{{ old('major', $teacher->major) }}" 
                                       placeholder="Contoh: Pendidikan Matematika"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('major') border-red-500 @enderror">
                                @error('major')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-purple-100">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-purple-600 to-pink-600 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-key text-sm"></i>
                            </div>
                            <span>Informasi Akun</span>
                        </h2>

                        <div class="space-y-4">
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', Auth::user()->email) }}" 
                                       required
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <p class="text-sm text-yellow-800 font-medium mb-2 flex items-center gap-2">
                                    <i class="fas fa-info-circle"></i>
                                    Ubah Password (Opsional)
                                </p>
                                <p class="text-xs text-yellow-700">Kosongkan jika tidak ingin mengubah password</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Password Baru
                                    </label>
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Minimal 8 karakter"
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('password') border-red-500 @enderror">
                                    @error('password')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Konfirmasi Password
                                    </label>
                                    <input type="password" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           placeholder="Ulangi password baru"
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Sidebar Section -->
                <div class="lg:col-span-1 space-y-6">
                    
                    <!-- Photo Upload -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-purple-100">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-camera text-purple-600"></i>
                            <span>Foto Profil</span>
                        </h2>

                        <div class="text-center mb-4">
                            @if($teacher->photo)
                                <img src="{{ asset('storage/' . $teacher->photo) }}" 
                                     alt="Current Photo" 
                                     id="preview-image"
                                     class="w-48 h-48 object-cover rounded-xl mx-auto border-4 border-purple-100 shadow-lg">
                            @else
                                <div id="preview-placeholder" class="w-48 h-48 bg-gradient-to-br from-purple-100 to-pink-100 rounded-xl mx-auto flex items-center justify-center border-4 border-purple-100 shadow-lg">
                                    <i class="fas fa-user text-6xl text-purple-400"></i>
                                </div>
                                <img src="#" 
                                     alt="Preview" 
                                     id="preview-image"
                                     class="w-48 h-48 object-cover rounded-xl mx-auto border-4 border-purple-100 shadow-lg hidden">
                            @endif
                        </div>

                        <div>
                            <label for="photo" class="block text-sm font-semibold text-gray-700 mb-2">
                                Upload Foto Baru
                            </label>
                            <input type="file" 
                                   id="photo" 
                                   name="photo" 
                                   accept="image/jpeg,image/png,image/jpg"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('photo') border-red-500 @enderror">
                            @error('photo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-2">
                                Format: JPG, JPEG, PNG. Maksimal 2MB
                            </p>
                        </div>
                    </div>

                    <!-- Info Card -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl shadow-lg p-6 border border-purple-200">
                        <h3 class="font-bold text-purple-800 mb-3 flex items-center gap-2">
                            <i class="fas fa-lightbulb"></i>
                            <span>Tips Pengisian</span>
                        </h3>
                        <ul class="space-y-2 text-sm text-purple-700">
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-purple-600 mt-0.5"></i>
                                <span>Pastikan data yang diisi akurat dan valid</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-purple-600 mt-0.5"></i>
                                <span>Gunakan foto formal untuk profil</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-purple-600 mt-0.5"></i>
                                <span>Email digunakan untuk login ke sistem</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-purple-600 mt-0.5"></i>
                                <span>Password minimal 8 karakter</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-purple-100 space-y-3">
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all duration-200 shadow-lg hover:shadow-xl font-medium">
                            <i class="fas fa-save"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                        
                        <a href="{{ route('dashboard') }}" 
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

@push('scripts')
<script>
    // Image preview
    document.getElementById('photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const previewImage = document.getElementById('preview-image');
                const previewPlaceholder = document.getElementById('preview-placeholder');
                
                previewImage.src = event.target.result;
                previewImage.classList.remove('hidden');
                
                if (previewPlaceholder) {
                    previewPlaceholder.classList.add('hidden');
                }
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection
