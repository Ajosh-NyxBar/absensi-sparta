@extends('layouts.modern')

@section('title', 'Manajemen Tahun Ajaran')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-white text-xl"></i>
                    </div>
                    Tahun Ajaran
                </h1>
                <p class="text-gray-600 mt-2">Kelola tahun ajaran dan semester</p>
            </div>
            <a href="{{ route('academic-years.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white font-semibold rounded-xl hover:from-indigo-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-plus"></i>
                <span>Tambah Tahun Ajaran</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Tahun Ajaran</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $academicYears->total() }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Aktif</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $academicYears->where('is_active', true)->count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Non-Aktif</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $academicYears->where('is_active', false)->count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-gray-500 to-gray-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-times-circle text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Tahun Ini</p>
                    <h3 class="text-xl font-bold mt-1">{{ $academicYears->where('is_active', true)->first()->year ?? '-' }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar-check text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Academic Years Cards -->
    @if($academicYears->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($academicYears as $index => $year)
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden card-hover border {{ $year->is_active ? 'border-green-200 ring-2 ring-green-100' : 'border-gray-100' }}">
                <!-- Header with gradient & Status Badge -->
                <div class="relative">
                    <div class="h-2 bg-gradient-to-r {{ $year->semester == 'Ganjil' ? 'from-blue-500 to-blue-600' : 'from-emerald-500 to-emerald-600' }}"></div>
                    @if($year->is_active)
                    <div class="absolute top-3 right-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-500 text-white shadow-lg">
                            <i class="fas fa-check-circle mr-1"></i>
                            Aktif
                        </span>
                    </div>
                    @endif
                </div>
                
                <div class="p-6">
                    <!-- Year Title -->
                    <div class="mb-4">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $year->year }}</h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold mt-2 {{ $year->semester == 'Ganjil' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700' }}">
                            <i class="fas fa-book-reader mr-1"></i>
                            Semester {{ $year->semester }}
                        </span>
                    </div>

                    <!-- Description -->
                    @if($year->description)
                    <p class="text-sm text-gray-600 mb-4 pb-4 border-b border-gray-100">
                        {{ $year->description }}
                    </p>
                    @endif

                    <!-- Period Info -->
                    <div class="space-y-3 mb-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center shrink-0">
                                <i class="fas fa-calendar-day text-indigo-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500">Periode</p>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $year->start_date->format('d M Y') }} - {{ $year->end_date->format('d M Y') }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-clock mr-1"></i>{{ $year->start_date->diffInDays($year->end_date) }} hari
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Toggle Active -->
                    <form action="{{ route('academic-years.toggle-active', $year->id) }}" method="POST" class="toggle-form mb-4">
                        @csrf
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">Status Aktif</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer toggle-checkbox" 
                                       {{ $year->is_active ? 'checked' : '' }}
                                       data-name="{{ $year->full_name }}"
                                       data-active="{{ $year->is_active ? 'true' : 'false' }}">
                                <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                            </label>
                        </div>
                    </form>

                    <!-- Actions -->
                    <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
                        <a href="{{ route('academic-years.show', $year->id) }}" 
                           class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors duration-150">
                            <i class="fas fa-eye text-sm"></i>
                            <span class="text-sm font-medium">Detail</span>
                        </a>
                        <a href="{{ route('academic-years.edit', $year->id) }}" 
                           class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-200 transition-colors duration-150">
                            <i class="fas fa-edit text-sm"></i>
                            <span class="text-sm font-medium">Edit</span>
                        </a>
                        <form action="{{ route('academic-years.destroy', $year->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                    class="delete-btn inline-flex items-center justify-center w-10 h-10 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors duration-150"
                                    data-name="{{ $year->full_name }}"
                                    data-active="{{ $year->is_active }}"
                                    title="Hapus">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($academicYears->hasPages())
    <div class="mt-8 bg-white rounded-2xl shadow-sm px-6 py-4">
        {{ $academicYears->links() }}
    </div>
    @endif
    @else
    <!-- Empty State -->
    <div class="bg-white rounded-2xl shadow-sm p-16 text-center">
        <div class="flex flex-col items-center justify-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-calendar-alt text-4xl text-gray-400"></i>
            </div>
            <p class="text-gray-500 font-medium">Belum ada tahun ajaran</p>
            <p class="text-sm text-gray-400 mt-1">Silakan tambah tahun ajaran baru</p>
            <a href="{{ route('academic-years.create') }}" class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white font-semibold rounded-xl hover:from-indigo-600 hover:to-indigo-700 transition-all duration-200 shadow-lg">
                <i class="fas fa-plus"></i>
                <span>Tambah Tahun Ajaran</span>
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
// Toggle Active Confirmation
document.querySelectorAll('.toggle-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function(e) {
        const form = this.closest('form');
        const name = this.dataset.name;
        const currentStatus = this.dataset.active === 'true';
        const action = currentStatus ? 'menonaktifkan' : 'mengaktifkan';
        
        Swal.fire({
            title: `${action.charAt(0).toUpperCase() + action.slice(1)} Tahun Ajaran?`,
            html: `Apakah Anda yakin ingin ${action} <strong>${name}</strong>?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#6366f1',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, ' + action.charAt(0).toUpperCase() + action.slice(1),
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            } else {
                // Reset checkbox if cancelled
                checkbox.checked = currentStatus;
            }
        });
    });
});

// Delete confirmation
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('form');
        const name = this.dataset.name;
        const isActive = this.dataset.active === '1';
        
        if (isActive) {
            Swal.fire({
                title: 'Tidak Dapat Dihapus',
                html: `Tahun ajaran <strong>${name}</strong> sedang aktif.<br>Nonaktifkan terlebih dahulu sebelum menghapus.`,
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc3545'
            });
            return;
        }
        
        Swal.fire({
            title: 'Hapus Tahun Ajaran?',
            html: `Apakah Anda yakin ingin menghapus <strong>${name}</strong>?<br><small class="text-muted">Data yang sudah dihapus tidak dapat dikembalikan.</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash me-2"></i>Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
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
