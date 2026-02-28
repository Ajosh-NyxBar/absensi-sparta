@extends('layouts.modern')

@section('title', 'Penugasan Guru - Mata Pelajaran')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                Penugasan Guru - Mata Pelajaran
            </h1>
            <p class="text-gray-600 mt-1">Kelola penugasan guru ke mata pelajaran dan kelas</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('teacher-subjects.create') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-plus"></i>
                <span>Tambah Penugasan</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Assignments -->
        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl p-6 text-white shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-indigo-100 text-sm font-medium">Total Penugasan</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $assignments->total() }}</h3>
                </div>
                <div class="bg-white/20 p-3 rounded-xl">
                    <i class="fas fa-clipboard-list text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Active Teachers -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Guru Aktif</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $teachers->count() }}</h3>
                </div>
                <div class="bg-white/20 p-3 rounded-xl">
                    <i class="fas fa-chalkboard-teacher text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Subjects -->
        <div class="bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl p-6 text-white shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-pink-100 text-sm font-medium">Mata Pelajaran</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $subjects->count() }}</h3>
                </div>
                <div class="bg-white/20 p-3 rounded-xl">
                    <i class="fas fa-book text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Classes -->
        <div class="bg-gradient-to-br from-cyan-500 to-blue-600 rounded-2xl p-6 text-white shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-cyan-100 text-sm font-medium">Kelas</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $classes->count() }}</h3>
                </div>
                <div class="bg-white/20 p-3 rounded-xl">
                    <i class="fas fa-door-open text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white">Filter</h2>
        </div>
        <div class="p-6">
            <form method="GET" action="{{ route('teacher-subjects.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Teacher Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user-tie mr-1"></i> Guru
                    </label>
                    <select name="teacher_id" 
                            class="w-full px-4 py-2.5 bg-gradient-to-r from-indigo-50 to-purple-50 border-2 border-indigo-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all">
                        <option value="">Semua Guru</option>
                        @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Subject Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-book mr-1"></i> Mata Pelajaran
                    </label>
                    <select name="subject_id" 
                            class="w-full px-4 py-2.5 bg-gradient-to-r from-indigo-50 to-purple-50 border-2 border-indigo-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all">
                        <option value="">Semua Mapel</option>
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Class Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-door-open mr-1"></i> Kelas
                    </label>
                    <select name="class_id" 
                            class="w-full px-4 py-2.5 bg-gradient-to-r from-indigo-50 to-purple-50 border-2 border-indigo-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all">
                        <option value="">Semua Kelas</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Academic Year Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt mr-1"></i> Tahun Ajaran
                    </label>
                    <select name="academic_year" 
                            class="w-full px-4 py-2.5 bg-gradient-to-r from-indigo-50 to-purple-50 border-2 border-indigo-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all">
                        <option value="">Semua Tahun</option>
                        @foreach($academicYears as $year)
                        <option value="{{ $year->year }}" {{ request('academic_year') == $year->year ? 'selected' : '' }}>
                            {{ $year->year }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-end gap-2">
                    <button type="submit" 
                            class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg">
                        <i class="fas fa-filter"></i>
                        <span>Filter</span>
                    </button>
                    <a href="{{ route('teacher-subjects.index') }}" 
                       class="px-4 py-2.5 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition-all duration-200">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Assignments Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-white/20 p-2 rounded-lg">
                    <i class="fas fa-table text-white text-lg"></i>
                </div>
                <h2 class="text-xl font-bold text-white">Daftar Penugasan</h2>
            </div>
            <span class="bg-white/20 px-4 py-1.5 rounded-full text-white text-sm font-semibold">
                {{ $assignments->total() }} penugasan
            </span>
        </div>

        @if($assignments->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-indigo-50 to-purple-50 border-b-2 border-indigo-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Guru</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tahun Ajaran</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($assignments as $index => $assignment)
                    <tr class="hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition-all duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                            {{ $assignments->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($assignment->teacher->user && $assignment->teacher->user->profile_photo)
                                <img src="{{ asset('storage/' . $assignment->teacher->user->profile_photo) }}" 
                                     alt="{{ $assignment->teacher->name }}" 
                                     class="w-10 h-10 rounded-full object-cover border-2 border-indigo-200">
                                @else
                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">{{ substr($assignment->teacher->name, 0, 1) }}</span>
                                </div>
                                @endif
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $assignment->teacher->name }}</p>
                                    <p class="text-xs text-gray-500">NIP: {{ $assignment->teacher->nip }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gradient-to-r from-pink-100 to-rose-100 text-pink-800 rounded-full text-xs font-semibold">
                                <i class="fas fa-book"></i>
                                {{ $assignment->subject->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($assignment->classRoom)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-800 rounded-full text-xs font-semibold">
                                <i class="fas fa-door-open"></i>
                                {{ $assignment->classRoom->name }}
                            </span>
                            @else
                            <span class="text-xs text-gray-400">Semua Kelas</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-800 rounded-full text-xs font-semibold">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $assignment->academic_year }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('teacher-subjects.edit', $assignment) }}" 
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-lg hover:from-amber-600 hover:to-orange-700 transition-all text-xs font-semibold shadow-sm hover:shadow-md"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('teacher-subjects.destroy', $assignment) }}" method="POST" class="inline-block delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            onclick="confirmDelete(this, '{{ $assignment->teacher->name }} - {{ $assignment->subject->name }}')"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-lg hover:from-red-600 hover:to-rose-700 transition-all text-xs font-semibold shadow-sm hover:shadow-md"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-purple-50 border-t border-indigo-100">
            {{ $assignments->links() }}
        </div>
        @else
        <div class="text-center py-16">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full mb-4">
                <i class="fas fa-clipboard-list text-4xl text-indigo-600"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada data penugasan</h3>
            <p class="text-gray-600 mb-6">Belum ada penugasan guru ke mata pelajaran</p>
            <a href="{{ route('teacher-subjects.create') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg">
                <i class="fas fa-plus"></i>
                <span>Tambah Penugasan Pertama</span>
            </a>
        </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(button, assignmentName) {
    Swal.fire({
        title: 'Hapus Penugasan?',
        text: `Penugasan ${assignmentName} akan dihapus permanen!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    });
}
</script>
@endsection
