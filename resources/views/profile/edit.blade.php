@extends('layouts.modern')

@section('title', 'Edit Profil')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-2">
                        Edit Profil
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

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <div class="space-y-6">
            
            <!-- Profile Information Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <span>Informasi Profil</span>
                    </h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="remove_photo" id="remove_photo" value="0">
                        
                        <!-- Profile Photo -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Foto Profil
                            </label>
                            <div class="flex items-start gap-6">
                                <!-- Current Photo Preview -->
                                <div class="flex-shrink-0">
                                    <div class="w-32 h-32 rounded-full border-4 border-indigo-200 overflow-hidden bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                                        @if($user->profile_photo)
                                            <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                                 alt="Profile Photo" 
                                                 class="w-full h-full object-cover"
                                                 id="photoPreview">
                                        @else
                                            <div class="text-center" id="photoPlaceholder">
                                                <i class="fas fa-user text-5xl text-indigo-400"></i>
                                                <p class="text-xs text-gray-500 mt-2">No Photo</p>
                                            </div>
                                            <img src="" 
                                                 alt="Preview" 
                                                 class="w-full h-full object-cover hidden"
                                                 id="photoPreview">
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Upload Section -->
                                <div class="flex-1">
                                    <input type="file" 
                                           class="hidden" 
                                           id="profile_photo" 
                                           name="profile_photo"
                                           accept="image/jpeg,image/png,image/jpg,image/gif"
                                           onchange="previewPhoto(event)">
                                    <label for="profile_photo" 
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition-all duration-200 cursor-pointer border border-indigo-200">
                                        <i class="fas fa-upload"></i>
                                        <span>Pilih Foto</span>
                                    </label>
                                    <p class="mt-2 text-xs text-gray-500">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Format: JPG, PNG, GIF (Max: 2MB)
                                    </p>
                                    @if($user->profile_photo)
                                    <button type="button" 
                                            onclick="confirmRemovePhoto(event)"
                                            class="mt-3 inline-flex items-center gap-2 px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-all duration-200 text-sm border border-red-200">
                                        <i class="fas fa-trash"></i>
                                        <span>Hapus Foto</span>
                                    </button>
                                    @endif
                                    @error('profile_photo')
                                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-6 border-gray-200">
                        
                        <!-- Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-600">*</span>
                            </label>
                            <input type="text" 
                                   class="w-full px-4 py-3 bg-indigo-50 border border-indigo-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('name') border-red-500 bg-red-50 @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Email -->
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email <span class="text-red-600">*</span>
                            </label>
                            <input type="email" 
                                   class="w-full px-4 py-3 bg-purple-50 border border-purple-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 @error('email') border-red-500 bg-red-50 @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Role (Read Only) -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Role
                            </label>
                            <div class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-lg">
                                @if($user->role)
                                    @if($user->role->name == 'Admin')
                                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-red-100 text-red-700 rounded-lg font-semibold text-sm border border-red-200">
                                            <i class="fas fa-user-shield"></i>
                                            {{ $user->role->name }}
                                        </span>
                                    @elseif($user->role->name == 'Kepala Sekolah')
                                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-amber-100 text-amber-700 rounded-lg font-semibold text-sm border border-amber-200">
                                            <i class="fas fa-user-tie"></i>
                                            {{ $user->role->name }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-blue-100 text-blue-700 rounded-lg font-semibold text-sm border border-blue-200">
                                            <i class="fas fa-chalkboard-teacher"></i>
                                            {{ $user->role->name }}
                                        </span>
                                    @endif
                                @else
                                    <span class="text-gray-500 italic">No Role</span>
                                @endif
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Role tidak dapat diubah sendiri</p>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg font-medium">
                                <i class="fas fa-save"></i>
                                <span>Simpan Perubahan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-purple-100 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-key text-white"></i>
                        </div>
                        <span>Ubah Password</span>
                    </h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('profile.update-password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Current Password -->
                        <div class="mb-6">
                            <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Password Saat Ini <span class="text-red-600">*</span>
                            </label>
                            <input type="password" 
                                   class="w-full px-4 py-3 bg-purple-50 border border-purple-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 @error('current_password') border-red-500 bg-red-50 @enderror" 
                                   id="current_password" 
                                   name="current_password" 
                                   required>
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- New Password -->
                        <div class="mb-6">
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Password Baru <span class="text-red-600">*</span>
                            </label>
                            <input type="password" 
                                   class="w-full px-4 py-3 bg-pink-50 border border-pink-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200 @error('password') border-red-500 bg-red-50 @enderror" 
                                   id="password" 
                                   name="password" 
                                   required>
                            <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Confirm Password -->
                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                Konfirmasi Password Baru <span class="text-red-600">*</span>
                            </label>
                            <input type="password" 
                                   class="w-full px-4 py-3 bg-purple-50 border border-purple-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all duration-200 shadow-md hover:shadow-lg font-medium">
                                <i class="fas fa-lock"></i>
                                <span>Update Password</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Account Info Card -->
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl shadow-lg border border-indigo-200 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="fas fa-info-circle"></i>
                        <span>Informasi Akun</span>
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white rounded-lg p-4 border border-indigo-100">
                            <p class="text-xs text-indigo-600 font-semibold mb-1">Akun Dibuat</p>
                            <p class="text-gray-800 font-medium text-sm">{{ $user->created_at->format('d F Y, H:i') }} WIB</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 border border-purple-100">
                            <p class="text-xs text-purple-600 font-semibold mb-1">Terakhir Diupdate</p>
                            <p class="text-gray-800 font-medium text-sm">{{ $user->updated_at->format('d F Y, H:i') }} WIB</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function previewPhoto(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('photoPreview');
            const placeholder = document.getElementById('photoPlaceholder');
            
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (placeholder) {
                placeholder.classList.add('hidden');
            }
        }
        reader.readAsDataURL(file);
    }
}

function confirmRemovePhoto(event) {
    event.preventDefault();
    
    Swal.fire({
        title: 'Hapus Foto Profil?',
        html: `
            <div style="text-align: left; padding: 0 20px;">
                <p style="margin-bottom: 15px;">Anda akan menghapus foto profil Anda.</p>
                <div style="background: #fee; padding: 15px; border-radius: 8px; border-left: 4px solid #dc3545; margin-bottom: 15px;">
                    <i class="fas fa-image" style="color: #dc3545; margin-right: 8px;"></i>
                    <strong style="color: #721c24;">Foto profil akan dihapus permanen</strong>
                </div>
                <div style="background: #fff3cd; padding: 12px; border-radius: 8px; margin-top: 10px;">
                    <i class="fas fa-info-circle" style="color: #f59e0b; margin-right: 8px;"></i>
                    <small style="color: #856404;">Anda bisa upload foto baru kapan saja</small>
                </div>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash me-2"></i>Ya, Hapus Foto',
        cancelButtonText: '<i class="fas fa-times me-2"></i>Batal',
        customClass: {
            popup: 'border-0 shadow-lg',
            title: 'fs-5 fw-bold text-dark',
            confirmButton: 'btn btn-lg px-4',
            cancelButton: 'btn btn-lg px-4'
        },
        buttonsStyling: false,
        reverseButtons: true,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Menghapus...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            
            document.getElementById('remove_photo').value = '1';
            document.getElementById('profileForm').submit();
        }
    });
}
</script>
@endsection
