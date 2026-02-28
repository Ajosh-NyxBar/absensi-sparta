@extends('layouts.modern')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent">
                {{ __('grades.page_title') }}
            </h1>
            <p class="text-gray-600 mt-1">{{ __('grades.subtitle') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('grades.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-rose-500 to-pink-600 text-white font-semibold rounded-xl hover:from-rose-600 hover:to-pink-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                <i class="fas fa-plus"></i>
                <span>{{ __('grades.input_grade') }}</span>
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-start gap-3">
        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
        <p class="text-green-800 flex-1">{{ session('success') }}</p>
        <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <!-- Filter Section -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <form method="GET" action="{{ route('grades.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Kelas -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('general.class') }}</label>
                <select name="class_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all">
                    <option value="">{{ __('general.all_classes') }}</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Mata Pelajaran -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('general.subject') }}</label>
                <select name="subject_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all">
                    <option value="">{{ __('general.all_subjects') }}</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                            {{ $subject->code }} - {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Semester -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('general.semester') }}</label>
                <select name="semester" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all">
                    <option value="">{{ __('general.all_semesters') }}</option>
                    <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>{{ __('general.odd') }}</option>
                    <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>{{ __('general.even') }}</option>
                </select>
            </div>

            <!-- Tahun Ajaran -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('general.academic_year') }}</label>
                <input type="text" name="academic_year" value="{{ request('academic_year') }}" placeholder="2024/2025" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all">
            </div>

            <!-- Button -->
            <div class="md:col-span-4 flex gap-2">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-rose-500 to-pink-600 text-white font-semibold rounded-lg hover:from-rose-600 hover:to-pink-700 transition-all duration-200">
                    <i class="fas fa-filter"></i>
                    {{ __('general.filter') }}
                </button>
                <a href="{{ route('grades.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-all duration-200">
                    <i class="fas fa-redo"></i>
                    {{ __('general.reset') }}
                </a>
            </div>
        </form>
    </div>

    <!-- Grades Table -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
        <div class="px-6 py-5 bg-gradient-to-r from-rose-50 to-pink-50 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-list text-rose-600"></i>
                    {{ __('grades.data_grades') }} ({{ $grades->total() }} {{ __('grades.grades_count') }})
                </h2>
            </div>
        </div>

        <div class="p-6">
            @if($grades->isEmpty())
                <div class="text-center py-16">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-inbox text-gray-400 text-3xl"></i>
                    </div>
                    <p class="text-gray-500 mb-4">{{ __('grades.no_data') }}</p>
                    <a href="{{ route('grades.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-rose-500 to-pink-600 text-white font-semibold rounded-lg hover:from-rose-600 hover:to-pink-700 transition-all duration-200">
                        <i class="fas fa-plus"></i>
                        {{ __('grades.input_first_grade') }}
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">{{ __('general.no') }}</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">{{ __('students.nis') }}</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">{{ __('grades.student_name') }}</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">{{ __('general.class') }}</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">{{ __('general.subject') }}</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">{{ __('grades.daily_test') }}</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">{{ __('grades.midterm') }}</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">{{ __('grades.final_exam') }}</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">{{ __('grades.final_grade') }}</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">{{ __('general.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grades as $index => $grade)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-4 text-sm font-semibold text-gray-700">
                                        {{ ($grades->currentPage() - 1) * $grades->perPage() + $index + 1 }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-600">
                                        {{ $grade->student->nis ?? '-' }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-rose-500 to-pink-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                {{ strtoupper(substr($grade->student->name ?? 'N', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $grade->student->name ?? '-' }}</p>
                                                <p class="text-xs text-gray-500">{{ $grade->semester }} {{ $grade->academic_year }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-semibold">
                                            {{ $grade->student->classRoom->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-600">
                                        {{ $grade->subject->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-semibold text-gray-900">{{ $grade->daily_test ?? 0 }}</span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-semibold text-gray-900">{{ $grade->midterm_exam ?? 0 }}</span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-semibold text-gray-900">{{ $grade->final_exam ?? 0 }}</span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        @php
                                            $finalGrade = $grade->final_grade ?? 0;
                                            if ($finalGrade >= 90) {
                                                $color = 'bg-gradient-to-r from-green-500 to-green-600 text-white';
                                            } elseif ($finalGrade >= 80) {
                                                $color = 'bg-gradient-to-r from-blue-500 to-blue-600 text-white';
                                            } elseif ($finalGrade >= 70) {
                                                $color = 'bg-gradient-to-r from-yellow-500 to-yellow-600 text-white';
                                            } elseif ($finalGrade >= 60) {
                                                $color = 'bg-gradient-to-r from-orange-500 to-orange-600 text-white';
                                            } else {
                                                $color = 'bg-gradient-to-r from-red-500 to-red-600 text-white';
                                            }
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold {{ $color }}">
                                            {{ number_format($finalGrade, 2) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('grades.edit', $grade->id) }}" 
                                               class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-all text-xs font-semibold">
                                                <i class="fas fa-edit"></i>
                                                {{ __('general.edit') }}
                                            </a>
                                            <form action="{{ route('grades.destroy', $grade->id) }}" method="POST" class="inline-block delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        class="delete-btn inline-flex items-center gap-1 px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-all text-xs font-semibold">
                                                    <i class="fas fa-trash"></i>
                                                    {{ __('general.delete') }}
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
                @if($grades->hasPages())
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        {{ $grades->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-form');
            
            Swal.fire({
                title: '{{ __('grades.delete_confirm') }}',
                text: '{{ __('general.delete_warning') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ __('general.yes_delete') }}',
                cancelButtonText: '{{ __('general.cancel') }}',
                customClass: {
                    confirmButton: 'bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-2 rounded-lg hover:from-red-600 hover:to-red-700',
                    cancelButton: 'bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 ml-2'
                },
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: '{{ __('general.deleting') }}',
                        text: '{{ __('general.please_wait') }}',
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
});
</script>
@endpush
@endsection
