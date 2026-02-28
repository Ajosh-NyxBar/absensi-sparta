@extends('layouts.modern')

@section('title', __('students.page_title'))

@section('content')
<div class="space-y-4 sm:space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                {{ __('students.page_title') }}
            </h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">{{ __('students.subtitle') }}</p>
        </div>
        <div class="flex items-center gap-2 sm:gap-3">
            <a href="{{ route('students.create') }}" 
               class="inline-flex items-center gap-2 px-4 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-cyan-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 text-sm sm:text-base">
                <i class="fas fa-plus"></i>
                <span>{{ __('students.add_student') }}</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <!-- Total Students -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl sm:rounded-2xl p-4 sm:p-6 text-white shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-xs sm:text-sm font-medium">{{ __('students.total_students') }}</p>
                    <h3 class="text-xl sm:text-3xl font-bold mt-1 sm:mt-2">{{ $students->total() }}</h3>
                </div>
                <div class="bg-white/20 p-2 sm:p-3 rounded-lg sm:rounded-xl">
                    <i class="fas fa-users text-lg sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Active Students -->
        <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl sm:rounded-2xl p-4 sm:p-6 text-white shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-xs sm:text-sm font-medium">{{ __('students.active_students') }}</p>
                    <h3 class="text-xl sm:text-3xl font-bold mt-1 sm:mt-2">{{ $students->where('status', 'active')->count() }}</h3>
                </div>
                <div class="bg-white/20 p-2 sm:p-3 rounded-lg sm:rounded-xl">
                    <i class="fas fa-check-circle text-lg sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Male Students -->
        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl sm:rounded-2xl p-4 sm:p-6 text-white shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-indigo-100 text-xs sm:text-sm font-medium">{{ __('students.male_students') }}</p>
                    <h3 class="text-xl sm:text-3xl font-bold mt-1 sm:mt-2">{{ $students->where('gender', 'L')->count() }}</h3>
                </div>
                <div class="bg-white/20 p-2 sm:p-3 rounded-lg sm:rounded-xl">
                    <i class="fas fa-mars text-lg sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Female Students -->
        <div class="bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl sm:rounded-2xl p-4 sm:p-6 text-white shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-pink-100 text-xs sm:text-sm font-medium">{{ __('students.female_students') }}</p>
                    <h3 class="text-xl sm:text-3xl font-bold mt-1 sm:mt-2">{{ $students->where('gender', 'P')->count() }}</h3>
                </div>
                <div class="bg-white/20 p-2 sm:p-3 rounded-lg sm:rounded-xl">
                    <i class="fas fa-venus text-lg sm:text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white rounded-xl sm:rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-4 sm:px-6 py-3 sm:py-4">
            <h2 class="text-lg sm:text-xl font-bold text-white">{{ __('general.filter_search') }}</h2>
        </div>
        <div class="p-4 sm:p-6">
            <form method="GET" action="{{ route('students.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                <!-- Search -->
                <div class="sm:col-span-2">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                        <i class="fas fa-search mr-1"></i> {{ __('students.search_student') }}
                    </label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="{{ __('students.search_placeholder') }}"
                           class="w-full px-3 sm:px-4 py-2 sm:py-2.5 bg-gradient-to-r from-blue-50 to-cyan-50 border-2 border-blue-200 rounded-lg sm:rounded-xl focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all text-sm">
                </div>

                <!-- Class Filter -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">
                        <i class="fas fa-door-open mr-1"></i> {{ __('students.class') }}
                    </label>
                    <select name="class_id" 
                            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 bg-gradient-to-r from-blue-50 to-cyan-50 border-2 border-blue-200 rounded-lg sm:rounded-xl focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all text-sm">
                        <option value="">{{ __('students.all_classes') }}</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-end gap-2">
                    <button type="submit" 
                            class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 sm:py-2.5 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-semibold rounded-lg sm:rounded-xl hover:from-blue-700 hover:to-cyan-700 transition-all duration-200 shadow-lg text-sm">
                        <i class="fas fa-filter"></i>
                        <span>{{ __('general.filter') }}</span>
                    </button>
                    <a href="{{ route('students.index') }}" 
                       class="px-4 py-2 sm:py-2.5 bg-gray-200 text-gray-700 font-semibold rounded-lg sm:rounded-xl hover:bg-gray-300 transition-all duration-200 text-sm">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Students Table -->
    <div class="bg-white rounded-xl sm:rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between">
            <div class="flex items-center gap-2 sm:gap-3">
                <div class="bg-white/20 p-1.5 sm:p-2 rounded-lg">
                    <i class="fas fa-table text-white text-base sm:text-lg"></i>
                </div>
                <h2 class="text-lg sm:text-xl font-bold text-white">{{ __('students.student_list') }}</h2>
            </div>
            <span class="bg-white/20 px-3 sm:px-4 py-1 sm:py-1.5 rounded-full text-white text-xs sm:text-sm font-semibold">
                {{ __('students.students_count', ['count' => $students->total()]) }}
            </span>
        </div>

        @if($students->count() > 0)
        <!-- Mobile Card View -->
        <div class="sm:hidden divide-y divide-gray-100">
            @foreach($students as $index => $student)
            <div class="p-4 hover:bg-gradient-to-r hover:from-blue-50 hover:to-cyan-50 transition-all">
                <div class="flex items-start gap-3">
                    <!-- Photo -->
                    @if($student->user && $student->user->profile_photo)
                    <img src="{{ asset('storage/' . $student->user->profile_photo) }}" 
                         alt="{{ $student->name }}" 
                         class="w-12 h-12 rounded-full object-cover border-2 border-blue-200 flex-shrink-0">
                    @else
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold">{{ substr($student->name, 0, 1) }}</span>
                    </div>
                    @endif
                    
                    <!-- Info -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <h3 class="font-semibold text-gray-900 text-sm truncate">{{ $student->name }}</h3>
                                <p class="text-xs text-gray-500">{{ $student->nis }} • {{ $student->nisn }}</p>
                            </div>
                            @if($student->status === 'active')
                            <span class="flex-shrink-0 px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-[10px] font-semibold">
                                {{ __('general.active') }}
                            </span>
                            @else
                            <span class="flex-shrink-0 px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full text-[10px] font-semibold">
                                {{ __('general.inactive') }}
                            </span>
                            @endif
                        </div>
                        
                        <div class="flex flex-wrap gap-1.5 mt-2">
                            @if($student->classRoom)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-[10px] font-medium">
                                <i class="fas fa-door-open"></i>
                                {{ $student->classRoom->name }}
                            </span>
                            @endif
                            @if($student->gender === 'L')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-indigo-100 text-indigo-700 rounded-full text-[10px] font-medium">
                                <i class="fas fa-mars"></i> L
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-pink-100 text-pink-700 rounded-full text-[10px] font-medium">
                                <i class="fas fa-venus"></i> P
                            </span>
                            @endif
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex items-center gap-2 mt-3">
                            <a href="{{ route('students.show', $student) }}" 
                               class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-1.5 bg-gradient-to-r from-blue-500 to-cyan-600 text-white rounded-lg text-xs font-semibold">
                                <i class="fas fa-eye"></i>
                                <span>{{ __('general.detail') }}</span>
                            </a>
                            <a href="{{ route('students.edit', $student) }}" 
                               class="inline-flex items-center justify-center px-3 py-1.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-lg text-xs font-semibold">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline-block delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        onclick="confirmDelete(this, '{{ $student->name }}')"
                                        class="inline-flex items-center justify-center px-3 py-1.5 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-lg text-xs font-semibold">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Desktop Table View -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-blue-50 to-cyan-50 border-b-2 border-blue-200">
                    <tr>
                        <th class="px-4 lg:px-6 py-3 lg:py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">{{ __('general.no') }}</th>
                        <th class="px-4 lg:px-6 py-3 lg:py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">{{ __('general.photo') }}</th>
                        <th class="px-4 lg:px-6 py-3 lg:py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">{{ __('students.nis_nisn') }}</th>
                        <th class="px-4 lg:px-6 py-3 lg:py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">{{ __('general.name') }}</th>
                        <th class="px-4 lg:px-6 py-3 lg:py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider hidden lg:table-cell">{{ __('students.class') }}</th>
                        <th class="px-4 lg:px-6 py-3 lg:py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider hidden md:table-cell">{{ __('general.gender') }}</th>
                        <th class="px-4 lg:px-6 py-3 lg:py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">{{ __('general.status') }}</th>
                        <th class="px-4 lg:px-6 py-3 lg:py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">{{ __('general.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($students as $index => $student)
                    <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-cyan-50 transition-all duration-200">
                        <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                            {{ $students->firstItem() + $index }}
                        </td>
                        <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap">
                            @if($student->user && $student->user->profile_photo)
                            <img src="{{ asset('storage/' . $student->user->profile_photo) }}" 
                                 alt="{{ $student->name }}" 
                                 class="w-9 h-9 lg:w-10 lg:h-10 rounded-full object-cover border-2 border-blue-200">
                            @else
                            <div class="w-9 h-9 lg:w-10 lg:h-10 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-xs lg:text-sm">{{ substr($student->name, 0, 1) }}</span>
                            </div>
                            @endif
                        </td>
                        <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $student->nis }}</div>
                            <div class="text-xs text-gray-500">{{ $student->nisn }}</div>
                        </td>
                        <td class="px-4 lg:px-6 py-3 lg:py-4">
                            <div class="text-sm font-semibold text-gray-900">{{ $student->name }}</div>
                            @if($student->email)
                            <div class="text-xs text-gray-500 hidden lg:block">{{ $student->email }}</div>
                            @endif
                        </td>
                        <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap hidden lg:table-cell">
                            @if($student->classRoom)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-800 rounded-full text-xs font-semibold">
                                <i class="fas fa-door-open"></i>
                                {{ $student->classRoom->name }}
                            </span>
                            @else
                            <span class="text-xs text-gray-400">{{ __('students.no_class') }}</span>
                            @endif
                        </td>
                        <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap hidden md:table-cell">
                            @if($student->gender === 'L')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-800 rounded-full text-xs font-semibold">
                                <i class="fas fa-mars"></i>
                                L
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gradient-to-r from-pink-100 to-rose-100 text-pink-800 rounded-full text-xs font-semibold">
                                <i class="fas fa-venus"></i>
                                P
                            </span>
                            @endif
                        </td>
                        <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap">
                            @if($student->status === 'active')
                            <span class="inline-flex items-center gap-1 px-2 lg:px-3 py-1 bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 rounded-full text-xs font-semibold">
                                <i class="fas fa-check-circle hidden lg:inline"></i>
                                {{ __('general.active') }}
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-2 lg:px-3 py-1 bg-gradient-to-r from-gray-100 to-slate-100 text-gray-800 rounded-full text-xs font-semibold">
                                <i class="fas fa-times-circle hidden lg:inline"></i>
                                {{ __('general.inactive') }}
                            </span>
                            @endif
                        </td>
                        <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-1 lg:gap-2">
                                <a href="{{ route('students.show', $student) }}" 
                                   class="inline-flex items-center gap-1 px-2 lg:px-3 py-1.5 bg-gradient-to-r from-blue-500 to-cyan-600 text-white rounded-lg hover:from-blue-600 hover:to-cyan-700 transition-all text-xs font-semibold shadow-sm hover:shadow-md"
                                   title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('students.edit', $student) }}" 
                                   class="inline-flex items-center gap-1 px-2 lg:px-3 py-1.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-lg hover:from-amber-600 hover:to-orange-700 transition-all text-xs font-semibold shadow-sm hover:shadow-md"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline-block delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            onclick="confirmDelete(this, '{{ $student->name }}')"
                                            class="inline-flex items-center gap-1 px-2 lg:px-3 py-1.5 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-lg hover:from-red-600 hover:to-rose-700 transition-all text-xs font-semibold shadow-sm hover:shadow-md"
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
        <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-blue-50 to-cyan-50 border-t border-blue-100">
            {{ $students->links() }}
        </div>
        @else
        <div class="text-center py-12 sm:py-16">
            <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-full mb-4">
                <i class="fas fa-user-graduate text-3xl sm:text-4xl text-blue-600"></i>
            </div>
            <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2">{{ __('students.no_data') }}</h3>
            <p class="text-sm sm:text-base text-gray-600 mb-6">{{ __('students.no_data_desc') }}</p>
            <a href="{{ route('students.create') }}" 
               class="inline-flex items-center gap-2 px-5 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-cyan-700 transition-all duration-200 shadow-lg text-sm sm:text-base">
                <i class="fas fa-plus"></i>
                <span>{{ __('students.add_first') }}</span>
            </a>
        </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(button, studentName) {
    Swal.fire({
        title: '{{ __('students.delete_title') }}',
        text: `{{ __('students.delete_text', ['name' => '']) }}`.replace(':name', studentName),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '{{ __('students.delete_confirm') }}',
        cancelButtonText: '{{ __('students.delete_cancel') }}',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    });
}
</script>
@endsection
