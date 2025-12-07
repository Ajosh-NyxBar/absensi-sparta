@extends('layouts.modern')

@section('title', 'Data Kelas')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-door-open text-white text-xl"></i>
                    </div>
                    Data Kelas
                </h1>
                <p class="text-gray-600 mt-2">Kelola data kelas sekolah</p>
            </div>
            <a href="{{ route('classes.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-plus"></i>
                <span>Tambah Kelas</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Kelas</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $classes->total() }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-door-open text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Siswa</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $classes->sum('students_count') }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-graduate text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Rata-rata/Kelas</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $classes->count() > 0 ? round($classes->sum('students_count') / $classes->count()) : 0 }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Mata Pelajaran</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $classes->sum('teacher_subjects_count') }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-book text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Classes Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($classes as $classRoom)
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden card-hover border border-gray-100">
                <!-- Header with gradient -->
                <div class="h-2 bg-gradient-to-r from-blue-500 to-blue-600"></div>
                
                <div class="p-6">
                    <!-- Class Name & Actions -->
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $classRoom->name }}</h3>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-blue-100 text-blue-700">
                                    <i class="fas fa-layer-group mr-1"></i>
                                    Kelas {{ $classRoom->grade }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('classes.show', $classRoom) }}" 
                               class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors duration-150" 
                               title="Detail">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                            <a href="{{ route('classes.edit', $classRoom) }}" 
                               class="inline-flex items-center justify-center w-8 h-8 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-200 transition-colors duration-150" 
                               title="Edit">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <form action="{{ route('classes.destroy', $classRoom) }}" method="POST" class="delete-class-form" data-class-name="{{ $classRoom->name }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="btn-delete-class inline-flex items-center justify-center w-8 h-8 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors duration-150" 
                                        title="Hapus">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Academic Year -->
                    <div class="mb-4 pb-4 border-b border-gray-100">
                        <p class="text-sm text-gray-600 flex items-center gap-2">
                            <i class="fas fa-calendar-alt text-gray-400"></i>
                            {{ $classRoom->academic_year }}
                        </p>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-3 gap-3">
                        <div class="text-center">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-user-graduate text-green-600"></i>
                            </div>
                            <p class="text-xs text-gray-500">Siswa</p>
                            <p class="text-lg font-bold text-gray-900">{{ $classRoom->students_count }}</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-chair text-purple-600"></i>
                            </div>
                            <p class="text-xs text-gray-500">Kapasitas</p>
                            <p class="text-lg font-bold text-gray-900">{{ $classRoom->capacity ?? '-' }}</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-book text-yellow-600"></i>
                            </div>
                            <p class="text-xs text-gray-500">Mapel</p>
                            <p class="text-lg font-bold text-gray-900">{{ $classRoom->teacher_subjects_count }}</p>
                        </div>
                    </div>

                    <!-- Capacity Indicator -->
                    @if($classRoom->capacity)
                    <div class="mt-4">
                        @php
                            $percentage = ($classRoom->students_count / $classRoom->capacity) * 100;
                            $colorClass = $percentage >= 90 ? 'bg-red-500' : ($percentage >= 70 ? 'bg-yellow-500' : 'bg-green-500');
                        @endphp
                        <div class="flex items-center justify-between text-xs text-gray-600 mb-1">
                            <span>Pengisian</span>
                            <span class="font-semibold">{{ round($percentage) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="{{ $colorClass }} h-2 rounded-full transition-all duration-300" style="width: {{ min($percentage, 100) }}%"></div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-2xl shadow-sm p-16 text-center">
                    <div class="flex flex-col items-center justify-center">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-inbox text-4xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada data kelas</p>
                        <p class="text-sm text-gray-400 mt-1">Klik tombol "Tambah Kelas" untuk menambahkan data baru</p>
                        <a href="{{ route('classes.create') }}" class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg">
                            <i class="fas fa-plus"></i>
                            <span>Tambah Kelas</span>
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($classes->hasPages())
    <div class="mt-8 bg-white rounded-2xl shadow-sm px-6 py-4">
        {{ $classes->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
// Delete Class Confirmation
document.querySelectorAll('.btn-delete-class').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('.delete-class-form');
        const className = form.dataset.className;
        
        Swal.fire({
            title: 'Hapus Kelas?',
            html: `
                <div style="text-align: left; padding: 0 20px;">
                    <p style="margin-bottom: 15px;">Anda akan menghapus kelas:</p>
                    <div style="background: #fee; padding: 15px; border-radius: 8px; border-left: 4px solid #dc3545; margin-bottom: 15px;">
                        <i class="fas fa-door-open" style="color: #dc3545; margin-right: 8px;"></i>
                        <strong style="color: #721c24;">${className}</strong>
                    </div>
                    <div style="background: #fff3cd; padding: 12px; border-radius: 8px; margin-top: 10px;">
                        <i class="fas fa-exclamation-triangle" style="color: #f59e0b; margin-right: 8px;"></i>
                        <small style="color: #856404;"><strong>Peringatan:</strong> Kelas yang masih memiliki siswa atau mata pelajaran tidak dapat dihapus!</small>
                    </div>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash me-2"></i>Ya, Hapus',
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
