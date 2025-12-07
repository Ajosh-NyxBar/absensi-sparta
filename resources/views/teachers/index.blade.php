@extends('layouts.modern')

@section('title', 'Data Guru')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chalkboard-teacher text-white text-xl"></i>
                    </div>
                    Data Guru
                </h1>
                <p class="text-gray-600 mt-2">Kelola data guru sekolah</p>
            </div>
            <a href="{{ route('teachers.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-plus"></i>
                <span>Tambah Guru</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Guru</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $teachers->total() }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chalkboard-teacher text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Guru Aktif</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $teachers->where('status', 'active')->count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-check text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Tidak Aktif</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $teachers->where('status', '!=', 'active')->count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-gray-500 to-gray-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-times text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Mata Pelajaran</p>
                    <h3 class="text-2xl font-bold mt-1">{{ \App\Models\Subject::count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-book text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Teachers Table -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
            <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <i class="fas fa-list text-green-600"></i>
                Daftar Guru
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-16">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Guru</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">NIP</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No. HP</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($teachers as $teacher)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $loop->iteration + ($teachers->currentPage() - 1) * $teachers->perPage() }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($teacher->photo)
                                        <img src="{{ asset('storage/' . $teacher->photo) }}" 
                                             alt="{{ $teacher->name }}" 
                                             class="w-10 h-10 rounded-full object-cover ring-2 ring-green-100">
                                    @else
                                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white font-semibold">
                                            {{ strtoupper(substr($teacher->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $teacher->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $teacher->teacherSubjects->pluck('subject.name')->filter()->unique()->join(', ') ?: 'Belum ada mata pelajaran' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-mono font-semibold bg-gray-100 text-gray-700">
                                    {{ $teacher->nip }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <i class="fas fa-envelope text-gray-400 mr-2"></i>{{ $teacher->user->email ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <i class="fas fa-phone text-gray-400 mr-2"></i>{{ $teacher->phone ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($teacher->status == 'active')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border bg-green-100 text-green-700 border-green-200">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border bg-gray-100 text-gray-700 border-gray-200">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('teachers.show', $teacher) }}" 
                                       class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors duration-150" 
                                       title="Detail">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    <a href="{{ route('teachers.edit', $teacher) }}" 
                                       class="inline-flex items-center justify-center w-8 h-8 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-200 transition-colors duration-150" 
                                       title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="delete-teacher-form" data-teacher-name="{{ $teacher->name }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn-delete-teacher inline-flex items-center justify-center w-8 h-8 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors duration-150" 
                                                title="Hapus">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-inbox text-4xl text-gray-400"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Belum ada data guru</p>
                                    <p class="text-sm text-gray-400 mt-1">Klik tombol "Tambah Guru" untuk menambahkan data guru baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($teachers->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $teachers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// Delete Teacher Confirmation
document.querySelectorAll('.btn-delete-teacher').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('.delete-teacher-form');
        const teacherName = form.dataset.teacherName;
        
        Swal.fire({
            title: 'Hapus Data Guru?',
            html: `
                <div style="text-align: left; padding: 0 20px;">
                    <p style="margin-bottom: 15px;">Anda akan menghapus data guru:</p>
                    <div style="background: #fee; padding: 15px; border-radius: 8px; border-left: 4px solid #dc3545; margin-bottom: 15px;">
                        <i class="fas fa-chalkboard-teacher" style="color: #dc3545; margin-right: 8px;"></i>
                        <strong style="color: #721c24;">${teacherName}</strong>
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
            confirmButtonText: '<i class="fas fa-trash me-2"></i>Ya, Hapus Data',
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
