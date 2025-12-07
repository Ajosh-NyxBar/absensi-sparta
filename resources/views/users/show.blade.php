@extends('layouts.modern')

@section('title', 'Detail User')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-violet-50 via-fuchsia-50 to-violet-100 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-transparent mb-2">
                        Detail User
                    </h1>
                    <p class="text-gray-600 flex items-center gap-2">
                        <i class="fas fa-user"></i>
                        Informasi lengkap data user
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('users.index') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-sm border border-gray-200">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- User Information -->
                <div class="bg-white rounded-2xl shadow-lg border border-violet-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-violet-600 to-fuchsia-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-info-circle"></i>
                            <span>Informasi User</span>
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 gap-4">
                            <div class="bg-violet-50 rounded-lg p-4 border border-violet-100">
                                <p class="text-xs text-violet-600 font-semibold mb-1">Nama Lengkap</p>
                                <p class="text-gray-800 font-medium text-lg">{{ $user->name }}</p>
                            </div>
                            
                            <div class="bg-fuchsia-50 rounded-lg p-4 border border-fuchsia-100">
                                <p class="text-xs text-fuchsia-600 font-semibold mb-1">Email</p>
                                <p class="text-gray-800 font-medium break-all">{{ $user->email }}</p>
                            </div>
                            
                            <div class="bg-violet-50 rounded-lg p-4 border border-violet-100">
                                <p class="text-xs text-violet-600 font-semibold mb-1">Role</p>
                                @if($user->role)
                                    @if($user->role->name == 'Admin')
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-red-100 text-red-700 rounded-lg font-semibold border border-red-200">
                                            <i class="fas fa-user-shield"></i>
                                            {{ $user->role->name }}
                                        </span>
                                    @elseif($user->role->name == 'Kepala Sekolah')
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-amber-100 text-amber-700 rounded-lg font-semibold border border-amber-200">
                                            <i class="fas fa-user-tie"></i>
                                            {{ $user->role->name }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg font-semibold border border-blue-200">
                                            <i class="fas fa-chalkboard-teacher"></i>
                                            {{ $user->role->name }}
                                        </span>
                                    @endif
                                @else
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg font-semibold border border-gray-200">
                                        <i class="fas fa-user"></i>
                                        No Role
                                    </span>
                                @endif
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-fuchsia-50 rounded-lg p-4 border border-fuchsia-100">
                                    <p class="text-xs text-fuchsia-600 font-semibold mb-1">Tanggal Dibuat</p>
                                    <p class="text-gray-800 font-medium text-sm">{{ $user->created_at->format('d F Y, H:i') }} WIB</p>
                                </div>
                                
                                <div class="bg-violet-50 rounded-lg p-4 border border-violet-100">
                                    <p class="text-xs text-violet-600 font-semibold mb-1">Terakhir Diupdate</p>
                                    <p class="text-gray-800 font-medium text-sm">{{ $user->updated_at->format('d F Y, H:i') }} WIB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-violet-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-cog text-violet-600"></i>
                        <span>Aksi</span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <a href="{{ route('users.edit', $user) }}" 
                           class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-amber-600 to-orange-600 text-white rounded-lg hover:from-amber-700 hover:to-orange-700 transition-all duration-200 shadow-md hover:shadow-lg font-medium">
                            <i class="fas fa-edit"></i>
                            <span>Edit User</span>
                        </a>
                        
                        <form action="{{ route('users.reset-password', $user) }}" 
                              method="POST" 
                              class="reset-password-form" 
                              data-user-name="{{ $user->name }}">
                            @csrf
                            <button type="button" 
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg font-medium btn-reset-password">
                                <i class="fas fa-key"></i>
                                <span>Reset Password</span>
                            </button>
                        </form>
                        
                        @if($user->id !== auth()->id())
                            <form action="{{ route('users.destroy', $user) }}" 
                                  method="POST" 
                                  class="delete-user-form" 
                                  data-user-name="{{ $user->name }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-white text-red-600 rounded-lg hover:bg-red-50 transition-all duration-200 shadow-md hover:shadow-lg border border-red-200 font-medium btn-delete-user">
                                    <i class="fas fa-trash"></i>
                                    <span>Hapus User</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Role Access Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-violet-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-fuchsia-600 to-violet-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-shield-alt"></i>
                            <span>Akses Role</span>
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($user->role)
                            @if($user->role->name == 'Admin')
                                <div class="mb-3">
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-red-100 text-red-700 rounded-lg font-semibold text-sm border border-red-200">
                                        <i class="fas fa-crown"></i>
                                        Akses Admin
                                    </span>
                                </div>
                                <ul class="space-y-2 text-sm text-gray-700">
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                                        <span>Manajemen User</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                                        <span>Manajemen Guru</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                                        <span>Manajemen Siswa</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                                        <span>Manajemen Presensi</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                                        <span>Input Nilai</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                                        <span>Laporan SAW</span>
                                    </li>
                                </ul>
                            @elseif($user->role->name == 'Kepala Sekolah')
                                <div class="mb-3">
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-amber-100 text-amber-700 rounded-lg font-semibold text-sm border border-amber-200">
                                        <i class="fas fa-user-tie"></i>
                                        Akses Kepala Sekolah
                                    </span>
                                </div>
                                <ul class="space-y-2 text-sm text-gray-700">
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                                        <span>Lihat Presensi</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                                        <span>Lihat Nilai</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                                        <span>Laporan SAW</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                                        <span>Dashboard Statistik</span>
                                    </li>
                                </ul>
                            @elseif($user->role->name == 'Guru')
                                <div class="mb-3">
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg font-semibold text-sm border border-blue-200">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                        Akses Guru
                                    </span>
                                </div>
                                <ul class="space-y-2 text-sm text-gray-700">
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                                        <span>Lihat Presensi</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                                        <span>Input Nilai Siswa</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                                        <span>Dashboard</span>
                                    </li>
                                </ul>
                            @endif
                        @else
                            <p class="text-gray-500 text-sm italic">Role belum ditentukan</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
// Reset Password Confirmation
document.querySelectorAll('.btn-reset-password').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('.reset-password-form');
        const userName = form.dataset.userName;
        
        Swal.fire({
            title: 'Reset Password User?',
            html: `
                <div style="text-align: left; padding: 0 20px;">
                    <p style="margin-bottom: 15px;">Anda akan mereset password untuk:</p>
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                        <i class="fas fa-user" style="color: #667eea; margin-right: 8px;"></i>
                        <strong style="color: #2d3748;">${userName}</strong>
                    </div>
                    <p style="margin-bottom: 10px;">Password baru akan menjadi:</p>
                    <div style="background: #fff3cd; padding: 12px; border-radius: 8px; border-left: 4px solid #ffc107;">
                        <i class="fas fa-key" style="color: #f59e0b; margin-right: 8px;"></i>
                        <code style="background: #ffe8a1; padding: 4px 8px; border-radius: 4px; font-weight: 600;">password123</code>
                    </div>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#667eea',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-check me-2"></i>Ya, Reset Password',
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
                    title: 'Memproses...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });
                form.submit();
            }
        });
    });
});

// Delete User Confirmation
document.querySelectorAll('.btn-delete-user').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('.delete-user-form');
        const userName = form.dataset.userName;
        
        Swal.fire({
            title: 'Hapus User?',
            html: `
                <div style="text-align: left; padding: 0 20px;">
                    <p style="margin-bottom: 15px;">Anda akan menghapus user:</p>
                    <div style="background: #fee; padding: 15px; border-radius: 8px; border-left: 4px solid #dc3545; margin-bottom: 15px;">
                        <i class="fas fa-user-times" style="color: #dc3545; margin-right: 8px;"></i>
                        <strong style="color: #721c24;">${userName}</strong>
                    </div>
                    <div style="background: #fff3cd; padding: 12px; border-radius: 8px; margin-top: 10px;">
                        <i class="fas fa-exclamation-triangle" style="color: #f59e0b; margin-right: 8px;"></i>
                        <small style="color: #856404;"><strong>Peringatan:</strong> Data yang dihapus tidak dapat dikembalikan!</small>
                    </div>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash me-2"></i>Ya, Hapus User',
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
                form.submit();
            }
        });
    });
});
</script>
@endpush
