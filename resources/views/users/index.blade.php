@extends('layouts.modern')

@section('title', 'Manajemen User')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    Manajemen User
                </h1>
                <p class="text-gray-600 mt-2">Kelola semua user sistem</p>
            </div>
            <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-plus"></i>
                <span>Tambah User</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Users</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $users->total() }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Admins</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $users->where('role.name', 'Admin')->count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-shield text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Teachers</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $users->where('role.name', 'Guru')->count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chalkboard-teacher text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Headmasters</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $users->where('role.name', 'Kepala Sekolah')->count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-tie text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
            <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <i class="fas fa-list text-purple-600"></i>
                Daftar User
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-16">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Dibuat</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                                        @if($user->id === auth()->id())
                                            <span class="text-xs text-purple-600 font-medium">(You)</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <i class="fas fa-envelope text-gray-400 mr-2"></i>{{ $user->email }}
                            </td>
                            <td class="px-6 py-4">
                                @if($user->role)
                                    @php
                                        $roleColors = [
                                            'Admin' => 'bg-red-100 text-red-700 border-red-200',
                                            'Kepala Sekolah' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                            'Guru' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        ];
                                        $color = $roleColors[$user->role->name] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $color }}">
                                        {{ $user->role->name }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border bg-gray-100 text-gray-700 border-gray-200">
                                        No Role
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <i class="fas fa-calendar text-gray-400 mr-2"></i>{{ $user->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('users.show', $user) }}" 
                                       class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors duration-150" 
                                       title="Detail">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    <a href="{{ route('users.edit', $user) }}" 
                                       class="inline-flex items-center justify-center w-8 h-8 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-200 transition-colors duration-150" 
                                       title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <form action="{{ route('users.reset-password', $user) }}" method="POST" class="reset-password-form" data-user-name="{{ $user->name }}">
                                        @csrf
                                        <button type="button" 
                                                class="btn-reset-password inline-flex items-center justify-center w-8 h-8 bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-200 transition-colors duration-150" 
                                                title="Reset Password">
                                            <i class="fas fa-key text-sm"></i>
                                        </button>
                                    </form>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="delete-user-form" data-user-name="{{ $user->name }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="btn-delete-user inline-flex items-center justify-center w-8 h-8 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors duration-150" 
                                                    title="Hapus">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-inbox text-4xl text-gray-400"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Belum ada data user</p>
                                    <p class="text-sm text-gray-400 mt-1">Klik tombol "Tambah User" untuk menambahkan user baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $users->links() }}
        </div>
        @endif
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
                // Show loading
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
                
                // Submit form
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
                // Show loading
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
                
                // Submit form
                form.submit();
            }
        });
    });
});
</script>
@endpush
