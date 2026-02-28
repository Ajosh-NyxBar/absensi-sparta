@extends('layouts.modern')

@section('title', 'Detail Siswa')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                Detail Siswa
            </h1>
            <p class="text-gray-600 mt-1">Informasi lengkap data siswa</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('students.report-card', $student) }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                <i class="fas fa-file-alt"></i>
                <span>Lihat Rapor</span>
            </a>
            <a href="{{ route('students.edit', $student) }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-semibold rounded-xl hover:from-amber-600 hover:to-orange-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                <i class="fas fa-edit"></i>
                <span>Edit</span>
            </a>
            <button onclick="confirmDelete()" 
                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-red-500 to-rose-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-rose-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                <i class="fas fa-trash"></i>
                <span>Hapus</span>
            </button>
            <a href="{{ route('students.index') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-300 hover:bg-gray-50 transition-all duration-200 shadow-sm">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-6 py-8 text-center">
                    @if($student->user && $student->user->profile_photo)
                    <img src="{{ asset('storage/' . $student->user->profile_photo) }}" 
                         alt="{{ $student->name }}" 
                         class="w-32 h-32 rounded-full mx-auto border-4 border-white shadow-xl object-cover">
                    @else
                    <div class="w-32 h-32 bg-white rounded-full mx-auto flex items-center justify-center border-4 border-white shadow-xl">
                        <span class="text-blue-600 text-5xl font-bold">{{ substr($student->name, 0, 1) }}</span>
                    </div>
                    @endif
                    <h2 class="text-2xl font-bold text-white mt-4">{{ $student->name }}</h2>
                    <p class="text-blue-100 mt-1">{{ $student->nis }}</p>
                </div>
                
                <div class="p-6 space-y-4">
                    <!-- Status -->
                    <div class="text-center">
                        @if($student->status === 'active')
                        <span class="inline-flex items-center gap-2 px-6 py-2 bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 rounded-full text-sm font-bold">
                            <i class="fas fa-check-circle"></i>
                            Status Aktif
                        </span>
                        @else
                        <span class="inline-flex items-center gap-2 px-6 py-2 bg-gradient-to-r from-gray-100 to-slate-100 text-gray-800 rounded-full text-sm font-bold">
                            <i class="fas fa-times-circle"></i>
                            Status Non-Aktif
                        </span>
                        @endif
                    </div>

                    <!-- Gender -->
                    <div class="flex items-center gap-3 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl">
                        <div class="bg-gradient-to-br from-blue-500 to-cyan-600 p-3 rounded-lg">
                            <i class="fas fa-{{ $student->gender === 'L' ? 'mars' : 'venus' }} text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-medium">Jenis Kelamin</p>
                            <p class="text-sm font-bold text-gray-900">{{ $student->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                    </div>

                    <!-- Class -->
                    @if($student->classRoom)
                    <div class="flex items-center gap-3 p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl">
                        <div class="bg-gradient-to-br from-purple-500 to-pink-600 p-3 rounded-lg">
                            <i class="fas fa-door-open text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-medium">Kelas</p>
                            <p class="text-sm font-bold text-gray-900">{{ $student->classRoom->name }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Details -->
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
                        <div>
                            <label class="text-xs font-semibold text-gray-600 uppercase tracking-wider">NIS</label>
                            <p class="mt-1 text-lg font-bold text-gray-900">{{ $student->nis }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-600 uppercase tracking-wider">NISN</label>
                            <p class="mt-1 text-lg font-bold text-gray-900">{{ $student->nisn ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Lengkap</label>
                            <p class="mt-1 text-lg font-bold text-gray-900">{{ $student->name }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Lahir</label>
                            <p class="mt-1 text-lg font-bold text-gray-900">{{ $student->birth_date ? $student->birth_date->format('d F Y') : '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</label>
                            <p class="mt-1 text-lg font-bold text-gray-900">{{ $student->email ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-600 uppercase tracking-wider">No. Telepon</label>
                            <p class="mt-1 text-lg font-bold text-gray-900">{{ $student->phone ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Alamat</label>
                            <p class="mt-1 text-lg font-bold text-gray-900">{{ $student->address ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Parent Information -->
            @if($student->parent_name || $student->parent_phone)
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
                        <div>
                            <label class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Orang Tua</label>
                            <p class="mt-1 text-lg font-bold text-gray-900">{{ $student->parent_name ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-600 uppercase tracking-wider">No. Telepon Orang Tua</label>
                            <p class="mt-1 text-lg font-bold text-gray-900">{{ $student->parent_phone ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

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
                        <div>
                            <label class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Kelas</label>
                            <p class="mt-1 text-lg font-bold text-gray-900">{{ $student->classRoom ? $student->classRoom->name : 'Belum ada kelas' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</label>
                            <p class="mt-1">
                                @if($student->status === 'active')
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 rounded-full text-sm font-bold">
                                    <i class="fas fa-check-circle"></i>
                                    Aktif
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-gray-100 to-slate-100 text-gray-800 rounded-full text-sm font-bold">
                                    <i class="fas fa-times-circle"></i>
                                    Non-Aktif
                                </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Delete Form -->
<form id="delete-form" action="{{ route('students.destroy', $student) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete() {
    Swal.fire({
        title: 'Hapus Siswa?',
        text: "Data siswa {{ $student->name }} akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form').submit();
        }
    });
}
</script>
@endsection
