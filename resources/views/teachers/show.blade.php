@extends('layouts.modern')

@section('title', 'Detail Guru')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teal-50 via-emerald-50 to-teal-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-teal-600 to-emerald-600 bg-clip-text text-transparent mb-2">
                        Detail Guru
                    </h1>
                    <p class="text-gray-600 flex items-center gap-2">
                        <i class="fas fa-chalkboard-teacher"></i>
                        Informasi lengkap data guru
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Sidebar Profile -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Photo & Status Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-teal-100">
                    <div class="text-center mb-6">
                        @if($teacher->photo)
                            <img src="{{ asset('storage/' . $teacher->photo) }}" 
                                 alt="{{ $teacher->name }}" 
                                 class="w-48 h-48 object-cover rounded-xl mx-auto border-4 border-teal-100 shadow-lg">
                        @else
                            <div class="w-48 h-48 bg-gradient-to-br from-teal-500 to-emerald-600 rounded-xl mx-auto flex items-center justify-center text-white text-6xl font-bold shadow-lg">
                                {{ strtoupper(substr($teacher->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    
                    <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">{{ $teacher->name }}</h2>
                    <p class="text-gray-600 text-center mb-4">{{ $teacher->position ?? 'Guru' }}</p>
                    
                    <div class="flex justify-center mb-6">
                        @if($teacher->status == 'active')
                            <span class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 text-green-700 rounded-lg border border-green-200 font-semibold">
                                <i class="fas fa-check-circle"></i>
                                <span>Aktif</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 text-gray-700 rounded-lg border border-gray-200 font-semibold">
                                <i class="fas fa-times-circle"></i>
                                <span>Tidak Aktif</span>
                            </span>
                        @endif
                    </div>
                    
                    <div class="space-y-3">
                        <a href="{{ route('teachers.edit', $teacher) }}" 
                           class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-amber-600 to-orange-600 text-white rounded-lg hover:from-amber-700 hover:to-orange-700 transition-all duration-200 shadow-md hover:shadow-lg font-medium">
                            <i class="fas fa-edit"></i>
                            <span>Edit Data</span>
                        </a>
                        
                        <form action="{{ route('teachers.destroy', $teacher) }}" 
                              method="POST" 
                              class="delete-teacher-form" 
                              data-teacher-name="{{ $teacher->name }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-white text-red-600 rounded-lg hover:bg-red-50 transition-all duration-200 shadow-md hover:shadow-lg border border-red-200 font-medium btn-delete-teacher">
                                <i class="fas fa-trash"></i>
                                <span>Hapus Data</span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Personal Information -->
                <div class="bg-white rounded-2xl shadow-lg border border-teal-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-teal-600 to-emerald-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-user"></i>
                            <span>Informasi Pribadi</span>
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-teal-50 rounded-lg p-4 border border-teal-100">
                                <p class="text-xs text-teal-600 font-semibold mb-1">NIP</p>
                                <p class="text-gray-800 font-medium">{{ $teacher->nip }}</p>
                            </div>
                            
                            <div class="bg-emerald-50 rounded-lg p-4 border border-emerald-100">
                                <p class="text-xs text-emerald-600 font-semibold mb-1">Nama Lengkap</p>
                                <p class="text-gray-800 font-medium">{{ $teacher->name }}</p>
                            </div>
                            
                            <div class="bg-teal-50 rounded-lg p-4 border border-teal-100">
                                <p class="text-xs text-teal-600 font-semibold mb-1">Jenis Kelamin</p>
                                <p class="text-gray-800 font-medium">{{ $teacher->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                            
                            <div class="bg-emerald-50 rounded-lg p-4 border border-emerald-100">
                                <p class="text-xs text-emerald-600 font-semibold mb-1">Tanggal Lahir</p>
                                <p class="text-gray-800 font-medium">{{ $teacher->birth_date ? $teacher->birth_date->format('d F Y') : '-' }}</p>
                            </div>
                            
                            <div class="bg-teal-50 rounded-lg p-4 border border-teal-100">
                                <p class="text-xs text-teal-600 font-semibold mb-1">Nomor Telepon</p>
                                <p class="text-gray-800 font-medium">{{ $teacher->phone ?? '-' }}</p>
                            </div>
                            
                            <div class="bg-emerald-50 rounded-lg p-4 border border-emerald-100">
                                <p class="text-xs text-emerald-600 font-semibold mb-1">Email</p>
                                <p class="text-gray-800 font-medium break-all">{{ $teacher->user->email ?? '-' }}</p>
                            </div>
                            
                            <div class="md:col-span-2 bg-teal-50 rounded-lg p-4 border border-teal-100">
                                <p class="text-xs text-teal-600 font-semibold mb-1">Alamat</p>
                                <p class="text-gray-800 font-medium">{{ $teacher->address ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Education & Position -->
                <div class="bg-white rounded-2xl shadow-lg border border-teal-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Informasi Pendidikan & Jabatan</span>
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-emerald-50 rounded-lg p-4 border border-emerald-100">
                                <p class="text-xs text-emerald-600 font-semibold mb-1">Pendidikan Terakhir</p>
                                <p class="text-gray-800 font-medium">{{ $teacher->education_level ?? '-' }}</p>
                            </div>
                            
                            <div class="bg-teal-50 rounded-lg p-4 border border-teal-100">
                                <p class="text-xs text-teal-600 font-semibold mb-1">Jabatan</p>
                                <p class="text-gray-800 font-medium">{{ $teacher->position ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($teacher->teacherSubjects && $teacher->teacherSubjects->count() > 0)
                <!-- Subjects Teaching -->
                <div class="bg-white rounded-2xl shadow-lg border border-teal-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-teal-600 to-emerald-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-book"></i>
                            <span>Mata Pelajaran yang Diampu</span>
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-teal-100">
                                        <th class="text-left py-3 px-4 text-sm font-bold text-gray-700 bg-teal-50">No</th>
                                        <th class="text-left py-3 px-4 text-sm font-bold text-gray-700 bg-teal-50">Mata Pelajaran</th>
                                        <th class="text-left py-3 px-4 text-sm font-bold text-gray-700 bg-teal-50">Kelas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teacher->teacherSubjects as $teacherSubject)
                                    <tr class="border-b border-gray-100 hover:bg-teal-50 transition-colors duration-150">
                                        <td class="py-3 px-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                        <td class="py-3 px-4">
                                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-teal-50 text-teal-700 rounded-lg text-sm font-medium border border-teal-200">
                                                <i class="fas fa-book-open text-xs"></i>
                                                {{ $teacherSubject->subject->name ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-medium border border-emerald-200">
                                                <i class="fas fa-users text-xs"></i>
                                                {{ $teacherSubject->classRoom->name ?? '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                <!-- System Information -->
                <div class="bg-gradient-to-br from-teal-50 to-emerald-50 rounded-2xl shadow-lg p-6 border border-teal-200">
                    <h3 class="font-bold text-teal-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle"></i>
                        <span>Informasi Sistem</span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-teal-700">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-calendar text-teal-600 mt-0.5"></i>
                            <div>
                                <strong>Dibuat pada:</strong><br>
                                {{ $teacher->created_at->format('d F Y, H:i') }} WIB
                            </div>
                        </div>
                        <div class="flex items-start gap-2">
                            <i class="fas fa-clock text-teal-600 mt-0.5"></i>
                            <div>
                                <strong>Terakhir diupdate:</strong><br>
                                {{ $teacher->updated_at->format('d F Y, H:i') }} WIB
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

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
