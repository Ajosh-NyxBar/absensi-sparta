@extends('layouts.modern')

@section('title', 'Detail Mata Pelajaran')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-100 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent mb-2">
                        Detail Mata Pelajaran
                    </h1>
                    <p class="text-gray-600 flex items-center gap-2">
                        <i class="fas fa-book"></i>
                        Informasi lengkap mata pelajaran
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('subjects.index') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-sm border border-gray-200">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Sidebar Profile -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg border border-emerald-100 overflow-hidden">
                    <div class="bg-gradient-to-br from-emerald-600 to-teal-600 px-6 py-8 text-center">
                        <div class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-book text-5xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">{{ $subject->name }}</h3>
                        <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/90 text-emerald-700 rounded-full font-bold text-sm">
                            <i class="fas fa-tag"></i>
                            {{ $subject->code }}
                        </span>
                    </div>
                    
                    <div class="p-6">
                        <!-- Statistics -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-cyan-50 rounded-xl p-4 text-center border border-cyan-100">
                                <h4 class="text-3xl font-bold text-cyan-600 mb-1">{{ $subject->teacher_subjects_count }}</h4>
                                <p class="text-xs text-gray-600 font-medium">Guru</p>
                            </div>
                            <div class="bg-emerald-50 rounded-xl p-4 text-center border border-emerald-100">
                                <h4 class="text-3xl font-bold text-emerald-600 mb-1">{{ $subject->grades_count }}</h4>
                                <p class="text-xs text-gray-600 font-medium">Data Nilai</p>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="space-y-3">
                            <a href="{{ route('subjects.edit', $subject) }}" 
                               class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-amber-600 to-orange-600 text-white rounded-lg hover:from-amber-700 hover:to-orange-700 transition-all duration-200 shadow-md hover:shadow-lg font-medium">
                                <i class="fas fa-edit"></i>
                                <span>Edit Mata Pelajaran</span>
                            </a>
                            
                            <form action="{{ route('subjects.destroy', $subject) }}" 
                                  method="POST" 
                                  class="delete-subject-form" 
                                  data-subject-name="{{ $subject->name }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-white text-red-600 rounded-lg hover:bg-red-50 transition-all duration-200 shadow-md hover:shadow-lg border border-red-200 font-medium btn-delete-subject">
                                    <i class="fas fa-trash"></i>
                                    <span>Hapus Mata Pelajaran</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Subject Information -->
                <div class="bg-white rounded-2xl shadow-lg border border-emerald-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-info-circle"></i>
                            <span>Informasi Mata Pelajaran</span>
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 gap-4">
                            <div class="bg-emerald-50 rounded-lg p-4 border border-emerald-100">
                                <p class="text-xs text-emerald-600 font-semibold mb-1">Kode</p>
                                <span class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-600 text-white rounded-lg font-bold text-sm">
                                    <i class="fas fa-tag"></i>
                                    {{ $subject->code }}
                                </span>
                            </div>
                            
                            <div class="bg-teal-50 rounded-lg p-4 border border-teal-100">
                                <p class="text-xs text-teal-600 font-semibold mb-1">Nama Mata Pelajaran</p>
                                <p class="text-gray-800 font-medium text-lg">{{ $subject->name }}</p>
                            </div>
                            
                            <div class="bg-cyan-50 rounded-lg p-4 border border-cyan-100">
                                <p class="text-xs text-cyan-600 font-semibold mb-1">Deskripsi</p>
                                <p class="text-gray-700 text-sm">{{ $subject->description ?? '-' }}</p>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-emerald-50 rounded-lg p-4 border border-emerald-100">
                                    <p class="text-xs text-emerald-600 font-semibold mb-1">Jumlah Guru</p>
                                    <p class="text-gray-800 font-medium text-sm">{{ $subject->teacher_subjects_count }} guru mengampu</p>
                                </div>
                                
                                <div class="bg-teal-50 rounded-lg p-4 border border-teal-100">
                                    <p class="text-xs text-teal-600 font-semibold mb-1">Data Nilai</p>
                                    <p class="text-gray-800 font-medium text-sm">{{ $subject->grades_count }} data tersimpan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Teachers Table -->
                @if($subject->teacherSubjects && $subject->teacherSubjects->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg border border-emerald-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-teal-600 to-emerald-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>Guru Pengampu</span>
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-emerald-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-emerald-700 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-emerald-700 uppercase tracking-wider">Nama Guru</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-emerald-700 uppercase tracking-wider">NIP</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-emerald-700 uppercase tracking-wider">Kelas</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-emerald-100">
                                @foreach($subject->teacherSubjects as $teacherSubject)
                                <tr class="hover:bg-emerald-50/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-800">{{ $teacherSubject->teacher->name ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $teacherSubject->teacher->nip ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-cyan-100 text-cyan-700 rounded-lg font-semibold text-xs border border-cyan-200">
                                            <i class="fas fa-school"></i>
                                            {{ $teacherSubject->classRoom->name ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center border border-emerald-100">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-slash text-4xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-500 font-medium">Belum ada guru yang mengampu mata pelajaran ini</p>
                </div>
                @endif
                
                <!-- System Information -->
                <div class="bg-white rounded-2xl shadow-lg border border-emerald-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-600 to-teal-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-clock"></i>
                            <span>Informasi Sistem</span>
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-cyan-50 rounded-lg p-4 border border-cyan-100">
                                <p class="text-xs text-cyan-600 font-semibold mb-1">Dibuat Pada</p>
                                <p class="text-gray-800 font-medium text-sm">{{ $subject->created_at->format('d F Y, H:i') }} WIB</p>
                            </div>
                            <div class="bg-teal-50 rounded-lg p-4 border border-teal-100">
                                <p class="text-xs text-teal-600 font-semibold mb-1">Terakhir Diupdate</p>
                                <p class="text-gray-800 font-medium text-sm">{{ $subject->updated_at->format('d F Y, H:i') }} WIB</p>
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
