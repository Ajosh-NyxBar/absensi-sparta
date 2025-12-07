@extends('layouts.modern')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent">
                Input Nilai: {{ $class->name }}
            </h1>
            <p class="text-gray-600 mt-1">
                {{ $subject->name }} - {{ $validated['semester'] }} {{ $validated['academic_year'] }}
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('grades.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-300 hover:bg-gray-50 transition-all duration-200 shadow-sm">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Info Alert -->
    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 border border-blue-200 rounded-xl p-5">
        <div class="flex items-start gap-3">
            <i class="fas fa-info-circle text-blue-600 text-xl mt-0.5"></i>
            <div class="flex-1">
                <h3 class="text-sm font-bold text-blue-900 mb-1">Informasi Input Nilai</h3>
                <p class="text-sm text-blue-800">
                    Masukkan nilai untuk setiap siswa. Nilai akhir akan dihitung otomatis dengan bobot: 
                    <span class="font-semibold">Tugas Harian (30%)</span>, 
                    <span class="font-semibold">UTS (30%)</span>, 
                    <span class="font-semibold">UAS (40%)</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Form Input Nilai -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
        <div class="px-6 py-5 bg-gradient-to-r from-rose-50 to-pink-50 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-table text-rose-600"></i>
                    Daftar Siswa ({{ $students->count() }} siswa)
                </h2>
                <div class="flex items-center gap-2 text-sm">
                    <span class="px-3 py-1 bg-white rounded-lg font-semibold text-gray-700 border border-gray-200">
                        <i class="fas fa-school text-rose-600 mr-1"></i>
                        {{ $class->name }}
                    </span>
                    <span class="px-3 py-1 bg-white rounded-lg font-semibold text-gray-700 border border-gray-200">
                        <i class="fas fa-book text-blue-600 mr-1"></i>
                        {{ $subject->code }}
                    </span>
                </div>
            </div>
        </div>

        <div class="p-6">
            @if($students->isEmpty())
                <div class="text-center py-16">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-slash text-gray-400 text-3xl"></i>
                    </div>
                    <p class="text-gray-500 mb-4">Tidak ada siswa aktif di kelas ini</p>
                    <a href="{{ route('grades.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-rose-500 to-pink-600 text-white font-semibold rounded-lg hover:from-rose-600 hover:to-pink-700 transition-all duration-200">
                        <i class="fas fa-arrow-left"></i>
                        Pilih Kelas Lain
                    </a>
                </div>
            @else
                <form action="{{ route('grades.store-multiple') }}" method="POST" id="gradesForm">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ $class->id }}">
                    <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                    <input type="hidden" name="semester" value="{{ $validated['semester'] }}">
                    <input type="hidden" name="academic_year" value="{{ $validated['academic_year'] }}">
                    @if($teacher)
                        <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b-2 border-gray-200">
                                    <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase bg-gray-50 rounded-tl-lg">No</th>
                                    <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase bg-gray-50">NIS</th>
                                    <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase bg-gray-50">Nama Siswa</th>
                                    <th class="px-4 py-4 text-center text-xs font-bold text-gray-700 uppercase bg-gray-50">
                                        <div class="flex flex-col">
                                            <span>Tugas Harian</span>
                                            <span class="text-xs text-gray-500 font-normal">(30%)</span>
                                        </div>
                                    </th>
                                    <th class="px-4 py-4 text-center text-xs font-bold text-gray-700 uppercase bg-gray-50">
                                        <div class="flex flex-col">
                                            <span>UTS</span>
                                            <span class="text-xs text-gray-500 font-normal">(30%)</span>
                                        </div>
                                    </th>
                                    <th class="px-4 py-4 text-center text-xs font-bold text-gray-700 uppercase bg-gray-50">
                                        <div class="flex flex-col">
                                            <span>UAS</span>
                                            <span class="text-xs text-gray-500 font-normal">(40%)</span>
                                        </div>
                                    </th>
                                    <th class="px-4 py-4 text-center text-xs font-bold text-gray-700 uppercase bg-gray-50 rounded-tr-lg">
                                        <div class="flex flex-col">
                                            <span>Nilai Akhir</span>
                                            <span class="text-xs text-gray-500 font-normal">(Auto)</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $index => $student)
                                    @php
                                        $existingGrade = $existingGrades->get($student->id);
                                    @endphp
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-4 text-sm font-semibold text-gray-700">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-600">
                                            {{ $student->nis }}
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-gradient-to-br from-rose-500 to-pink-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900">{{ $student->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ $student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                                </div>
                                            </div>
                                            <input type="hidden" name="students[{{ $index }}][student_id]" value="{{ $student->id }}">
                                            @if($existingGrade)
                                                <input type="hidden" name="students[{{ $index }}][grade_id]" value="{{ $existingGrade->id }}">
                                            @endif
                                        </td>
                                        <td class="px-4 py-4">
                                            <input type="number" 
                                                   name="students[{{ $index }}][daily_test]" 
                                                   value="{{ old("students.{$index}.daily_test", $existingGrade->daily_test ?? '') }}"
                                                   class="grade-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all text-center" 
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   data-row="{{ $index }}"
                                                   placeholder="0-100">
                                        </td>
                                        <td class="px-4 py-4">
                                            <input type="number" 
                                                   name="students[{{ $index }}][midterm_exam]" 
                                                   value="{{ old("students.{$index}.midterm_exam", $existingGrade->midterm_exam ?? '') }}"
                                                   class="grade-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all text-center" 
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   data-row="{{ $index }}"
                                                   placeholder="0-100">
                                        </td>
                                        <td class="px-4 py-4">
                                            <input type="number" 
                                                   name="students[{{ $index }}][final_exam]" 
                                                   value="{{ old("students.{$index}.final_exam", $existingGrade->final_exam ?? '') }}"
                                                   class="grade-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all text-center" 
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   data-row="{{ $index }}"
                                                   placeholder="0-100">
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <span id="final-grade-{{ $index }}" class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold bg-gradient-to-r from-green-500 to-green-600 text-white">
                                                {{ $existingGrade ? number_format($existingGrade->final_grade, 2) : '0.00' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-200">
                        <a href="{{ route('grades.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-300 hover:bg-gray-50 transition-all duration-200">
                            <i class="fas fa-times"></i>
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-rose-500 to-pink-600 text-white font-semibold rounded-xl hover:from-rose-600 hover:to-pink-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-save"></i>
                            Simpan Semua Nilai
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-calculate final grade
    const gradeInputs = document.querySelectorAll('.grade-input');
    
    gradeInputs.forEach(input => {
        input.addEventListener('input', function() {
            const row = this.dataset.row;
            calculateFinalGrade(row);
        });
    });

    function calculateFinalGrade(row) {
        const dailyTest = parseFloat(document.querySelector(`input[name="students[${row}][daily_test]"]`).value) || 0;
        const midtermExam = parseFloat(document.querySelector(`input[name="students[${row}][midterm_exam]"]`).value) || 0;
        const finalExam = parseFloat(document.querySelector(`input[name="students[${row}][final_exam]"]`).value) || 0;
        
        // Calculate: 30% + 30% + 40%
        const finalGrade = (dailyTest * 0.3) + (midtermExam * 0.3) + (finalExam * 0.4);
        
        const finalGradeElement = document.getElementById(`final-grade-${row}`);
        finalGradeElement.textContent = finalGrade.toFixed(2);
        
        // Update color based on grade
        finalGradeElement.className = 'inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold ';
        if (finalGrade >= 90) {
            finalGradeElement.className += 'bg-gradient-to-r from-green-500 to-green-600 text-white';
        } else if (finalGrade >= 80) {
            finalGradeElement.className += 'bg-gradient-to-r from-blue-500 to-blue-600 text-white';
        } else if (finalGrade >= 70) {
            finalGradeElement.className += 'bg-gradient-to-r from-yellow-500 to-yellow-600 text-white';
        } else if (finalGrade >= 60) {
            finalGradeElement.className += 'bg-gradient-to-r from-orange-500 to-orange-600 text-white';
        } else {
            finalGradeElement.className += 'bg-gradient-to-r from-red-500 to-red-600 text-white';
        }
    }

    // Initialize all final grades on page load
    gradeInputs.forEach(input => {
        const row = input.dataset.row;
        if (row) calculateFinalGrade(row);
    });
});
</script>
@endpush
@endsection
