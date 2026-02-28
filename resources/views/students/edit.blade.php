@extends('layouts.modern')

@section('title', 'Edit Siswa')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                Edit Siswa
            </h1>
            <p class="text-gray-600 mt-1">Ubah data siswa {{ $student->name }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('students.show', $student) }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-300 hover:bg-gray-50 transition-all duration-200 shadow-sm">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <form action="{{ route('students.update', $student) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Photo Upload -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-6 py-4">
                        <h3 class="text-xl font-bold text-white">Foto Profil</h3>
                    </div>
                    <div class="p-6">
                        <div class="text-center">
                            <div id="preview-container" class="mb-4">
                                @if($student->user && $student->user->profile_photo)
                                <img id="photo-preview" src="{{ asset('storage/' . $student->user->profile_photo) }}" 
                                     alt="Preview" 
                                     class="w-48 h-48 rounded-full mx-auto border-4 border-blue-200 shadow-xl object-cover">
                                @else
                                <div id="photo-preview" class="w-48 h-48 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-full mx-auto flex items-center justify-center border-4 border-blue-200 shadow-xl">
                                    <span class="text-white text-6xl font-bold">{{ substr($student->name, 0, 1) }}</span>
                                </div>
                                @endif
                            </div>
                            
                            <label class="cursor-pointer inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-cyan-700 transition-all duration-200 shadow-lg">
                                <i class="fas fa-camera"></i>
                                <span>Pilih Foto</span>
                                <input type="file" name="photo" id="photo-input" class="hidden" accept="image/*" onchange="previewPhoto(this)">
                            </label>
                            <p class="text-xs text-gray-500 mt-2">JPG, PNG, max 2MB</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Fields -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Personal Information -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-white/20 p-2 rounded-lg">
                                <i class="fas fa-user text-white text-lg"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white">Informasi Pribadi</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- NIS -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    NIS <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="nis" 
                                       value="{{ old('nis', $student->nis) }}"
                                       class="w-full px-4 py-3 bg-gradient-to-r from-blue-50 to-cyan-50 border-2 border-blue-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all @error('nis') border-red-500 @enderror"
                                       required>
                                @error('nis')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NISN -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    NISN
                                </label>
                                <input type="text" 
                                       name="nisn" 
                                       value="{{ old('nisn', $student->nisn) }}"
                                       class="w-full px-4 py-3 bg-gradient-to-r from-blue-50 to-cyan-50 border-2 border-blue-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all @error('nisn') border-red-500 @enderror">
                                @error('nisn')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Name -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       value="{{ old('name', $student->name) }}"
                                       class="w-full px-4 py-3 bg-gradient-to-r from-blue-50 to-cyan-50 border-2 border-blue-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all @error('name') border-red-500 @enderror"
                                       required>
                                @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Jenis Kelamin <span class="text-red-500">*</span>
                                </label>
                                <select name="gender" 
                                        class="w-full px-4 py-3 bg-gradient-to-r from-blue-50 to-cyan-50 border-2 border-blue-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all @error('gender') border-red-500 @enderror"
                                        required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('gender', $student->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender', $student->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Birth Date -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Tanggal Lahir
                                </label>
                                <input type="date" 
                                       name="birth_date" 
                                       value="{{ old('birth_date', $student->birth_date ? $student->birth_date->format('Y-m-d') : '') }}"
                                       class="w-full px-4 py-3 bg-gradient-to-r from-blue-50 to-cyan-50 border-2 border-blue-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all @error('birth_date') border-red-500 @enderror">
                                @error('birth_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Email
                                </label>
                                <input type="email" 
                                       name="email" 
                                       value="{{ old('email', $student->email) }}"
                                       class="w-full px-4 py-3 bg-gradient-to-r from-blue-50 to-cyan-50 border-2 border-blue-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all @error('email') border-red-500 @enderror">
                                @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    No. Telepon
                                </label>
                                <input type="text" 
                                       name="phone" 
                                       value="{{ old('phone', $student->phone) }}"
                                       class="w-full px-4 py-3 bg-gradient-to-r from-blue-50 to-cyan-50 border-2 border-blue-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all @error('phone') border-red-500 @enderror">
                                @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Alamat
                                </label>
                                <textarea name="address" 
                                          rows="3"
                                          class="w-full px-4 py-3 bg-gradient-to-r from-blue-50 to-cyan-50 border-2 border-blue-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all @error('address') border-red-500 @enderror">{{ old('address', $student->address) }}</textarea>
                                @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Parent Information -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-white/20 p-2 rounded-lg">
                                <i class="fas fa-users text-white text-lg"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white">Informasi Orang Tua</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Parent Name -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Nama Orang Tua
                                </label>
                                <input type="text" 
                                       name="parent_name" 
                                       value="{{ old('parent_name', $student->parent_name) }}"
                                       class="w-full px-4 py-3 bg-gradient-to-r from-purple-50 to-pink-50 border-2 border-purple-200 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all @error('parent_name') border-red-500 @enderror">
                                @error('parent_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Parent Phone -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    No. Telepon Orang Tua
                                </label>
                                <input type="text" 
                                       name="parent_phone" 
                                       value="{{ old('parent_phone', $student->parent_phone) }}"
                                       class="w-full px-4 py-3 bg-gradient-to-r from-purple-50 to-pink-50 border-2 border-purple-200 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all @error('parent_phone') border-red-500 @enderror">
                                @error('parent_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Academic Information -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-white/20 p-2 rounded-lg">
                                <i class="fas fa-graduation-cap text-white text-lg"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white">Informasi Akademik</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Class -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Kelas
                                </label>
                                <select name="class_id" 
                                        class="w-full px-4 py-3 bg-gradient-to-r from-emerald-50 to-teal-50 border-2 border-emerald-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition-all @error('class_id') border-red-500 @enderror">
                                    <option value="">Pilih Kelas</option>
                                    @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Status
                                </label>
                                <select name="status" 
                                        class="w-full px-4 py-3 bg-gradient-to-r from-emerald-50 to-teal-50 border-2 border-emerald-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition-all @error('status') border-red-500 @enderror">
                                    <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ old('status', $student->status) == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                                    <option value="graduated" {{ old('status', $student->status) == 'graduated' ? 'selected' : '' }}>Lulus</option>
                                </select>
                                @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('students.show', $student) }}" 
                       class="px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-300 hover:bg-gray-50 transition-all duration-200">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-bold rounded-xl hover:from-blue-700 hover:to-cyan-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fas fa-save"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('photo-preview').innerHTML = 
                '<img src="' + e.target.result + '" class="w-48 h-48 rounded-full mx-auto border-4 border-blue-200 shadow-xl object-cover">';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
