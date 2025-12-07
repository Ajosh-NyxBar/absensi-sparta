@extends('layouts.modern')

@section('title', 'Mata Pelajaran')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-book text-white text-xl"></i>
                    </div>
                    Mata Pelajaran
                </h1>
                <p class="text-gray-600 mt-2">Kelola data mata pelajaran sekolah</p>
            </div>
            <a href="{{ route('subjects.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-plus"></i>
                <span>Tambah Mata Pelajaran</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Mapel</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $subjects->total() }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-book text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Guru</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $subjects->sum('teacher_subjects_count') }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chalkboard-teacher text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Nilai</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $subjects->sum('grades_count') }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Rata-rata Nilai</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $subjects->sum('grades_count') > 0 ? number_format($subjects->sum('grades_count') / $subjects->count(), 0) : 0 }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-line text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Subjects Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($subjects as $subject)
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden card-hover border border-gray-100">
                <!-- Header with gradient -->
                <div class="h-2 bg-gradient-to-r from-purple-500 to-purple-600"></div>
                
                <div class="p-6">
                    <!-- Subject Code Badge -->
                    <div class="flex items-start justify-between mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-mono font-semibold bg-purple-100 text-purple-700">
                            {{ $subject->code }}
                        </span>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('subjects.show', $subject) }}" 
                               class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors duration-150" 
                               title="Detail">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                            <a href="{{ route('subjects.edit', $subject) }}" 
                               class="inline-flex items-center justify-center w-8 h-8 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-200 transition-colors duration-150" 
                               title="Edit">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="delete-subject-form" data-subject-name="{{ $subject->name }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="btn-delete-subject inline-flex items-center justify-center w-8 h-8 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors duration-150" 
                                        title="Hapus">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Subject Name -->
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $subject->name }}</h3>
                    
                    <!-- Description -->
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                        {{ $subject->description ?? 'Tidak ada deskripsi' }}
                    </p>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-3 pt-4 border-t border-gray-100">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-chalkboard-teacher text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Guru</p>
                                <p class="text-lg font-bold text-gray-900">{{ $subject->teacher_subjects_count }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-clipboard-list text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Nilai</p>
                                <p class="text-lg font-bold text-gray-900">{{ $subject->grades_count }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-2xl shadow-sm p-16 text-center">
                    <div class="flex flex-col items-center justify-center">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-inbox text-4xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada data mata pelajaran</p>
                        <p class="text-sm text-gray-400 mt-1">Klik tombol "Tambah Mata Pelajaran" untuk menambahkan data baru</p>
                        <a href="{{ route('subjects.create') }}" class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-purple-700 transition-all duration-200 shadow-lg">
                            <i class="fas fa-plus"></i>
                            <span>Tambah Mata Pelajaran</span>
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($subjects->hasPages())
    <div class="mt-8 bg-white rounded-2xl shadow-sm px-6 py-4">
        {{ $subjects->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
// Delete Subject Confirmation
document.querySelectorAll('.btn-delete-subject').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('.delete-subject-form');
        const subjectName = form.dataset.subjectName;
        
        Swal.fire({
            title: 'Hapus Mata Pelajaran?',
            html: `
                <div style="text-align: left; padding: 0 20px;">
                    <p style="margin-bottom: 15px;">Anda akan menghapus mata pelajaran:</p>
                    <div style="background: #fee; padding: 15px; border-radius: 8px; border-left: 4px solid #dc3545; margin-bottom: 15px;">
                        <i class="fas fa-book" style="color: #dc3545; margin-right: 8px;"></i>
                        <strong style="color: #721c24;">${subjectName}</strong>
                    </div>
                    <div style="background: #fff3cd; padding: 12px; border-radius: 8px; margin-top: 10px;">
                        <i class="fas fa-exclamation-triangle" style="color: #f59e0b; margin-right: 8px;"></i>
                        <small style="color: #856404;"><strong>Peringatan:</strong> Mata pelajaran yang masih digunakan tidak dapat dihapus!</small>
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
