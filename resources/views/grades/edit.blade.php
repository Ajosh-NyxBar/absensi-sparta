@extends('layouts.modern')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent">
                Edit Nilai
            </h1>
            <p class="text-gray-600 mt-1">Ubah data nilai siswa</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('grades.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-300 hover:bg-gray-50 transition-all duration-200 shadow-sm">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                <div class="px-6 py-5 bg-gradient-to-r from-rose-50 to-pink-50 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-edit text-rose-600"></i>
                        Form Edit Nilai
                    </h2>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('grades.update', $grade->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Student Info (Read-only) -->
                        <div class="p-4 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl border border-blue-200">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-rose-500 to-pink-600 rounded-full flex items-center justify-center text-white font-bold text-2xl">
                                    {{ strtoupper(substr($grade->student->name, 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-600">Siswa</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $grade->student->name }}</p>
                                    <div class="flex items-center gap-3 mt-1">
                                        <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-xs font-semibold">
                                            {{ $grade->student->nis }}
                                        </span>
                                        <span class="px-2 py-0.5 bg-purple-100 text-purple-700 rounded text-xs font-semibold">
                                            {{ $grade->student->classRoom->name ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 mt-4 pt-4 border-t border-blue-200">
                                <div>
                                    <p class="text-xs text-gray-600">Mata Pelajaran</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ $grade->subject->name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600">Semester</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ $grade->semester }} {{ $grade->academic_year }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Nilai Section -->
                        <div class="space-y-4">
                            <div class="border-b-2 border-rose-200 pb-2">
                                <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                                    <i class="fas fa-calculator text-rose-600"></i>
                                    Komponen Nilai
                                </h3>
                            </div>

                            <!-- Tugas Harian -->
                            <div>
                                <label for="daily_test" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tugas Harian (Bobot 30%)
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-edit text-gray-400"></i>
                                    </div>
                                    <input type="number" 
                                           id="daily_test" 
                                           name="daily_test" 
                                           value="{{ old('daily_test', $grade->daily_test) }}" 
                                           class="grade-input w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all duration-200 @error('daily_test') border-red-500 @enderror"
                                           min="0"
                                           max="100"
                                           step="0.01"
                                           placeholder="0-100">
                                </div>
                                @error('daily_test')
                                    <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- UTS -->
                            <div>
                                <label for="midterm_exam" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Ujian Tengah Semester (Bobot 30%)
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-book-open text-gray-400"></i>
                                    </div>
                                    <input type="number" 
                                           id="midterm_exam" 
                                           name="midterm_exam" 
                                           value="{{ old('midterm_exam', $grade->midterm_exam) }}" 
                                           class="grade-input w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all duration-200 @error('midterm_exam') border-red-500 @enderror"
                                           min="0"
                                           max="100"
                                           step="0.01"
                                           placeholder="0-100">
                                </div>
                                @error('midterm_exam')
                                    <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- UAS -->
                            <div>
                                <label for="final_exam" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Ujian Akhir Semester (Bobot 40%)
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-file-alt text-gray-400"></i>
                                    </div>
                                    <input type="number" 
                                           id="final_exam" 
                                           name="final_exam" 
                                           value="{{ old('final_exam', $grade->final_exam) }}" 
                                           class="grade-input w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all duration-200 @error('final_exam') border-red-500 @enderror"
                                           min="0"
                                           max="100"
                                           step="0.01"
                                           placeholder="0-100">
                                </div>
                                @error('final_exam')
                                    <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nilai Akhir Display -->
                            <div class="p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl border border-green-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600 mb-1">Nilai Akhir (Auto-Calculate)</p>
                                        <p class="text-xs text-gray-500">Formula: (Tugas × 30%) + (UTS × 30%) + (UAS × 40%)</p>
                                    </div>
                                    <div class="text-right">
                                        <p id="final-grade" class="text-3xl font-bold text-green-700">
                                            {{ number_format($grade->final_grade, 2) }}
                                        </p>
                                        <p id="grade-letter" class="text-sm font-semibold text-gray-600 mt-1">
                                            @php
                                                $letter = 'E';
                                                if($grade->final_grade >= 90) $letter = 'A';
                                                elseif($grade->final_grade >= 80) $letter = 'B';
                                                elseif($grade->final_grade >= 70) $letter = 'C';
                                                elseif($grade->final_grade >= 60) $letter = 'D';
                                            @endphp
                                            Predikat: {{ $letter }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div>
                            <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                                Catatan (Opsional)
                            </label>
                            <textarea id="notes" 
                                      name="notes" 
                                      rows="3" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all duration-200 @error('notes') border-red-500 @enderror" 
                                      placeholder="Tambahkan catatan tentang nilai siswa...">{{ old('notes', $grade->notes) }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                            <a href="{{ route('grades.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-300 hover:bg-gray-50 transition-all duration-200">
                                <i class="fas fa-times"></i>
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-rose-500 to-pink-600 text-white font-semibold rounded-xl hover:from-rose-600 hover:to-pink-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <i class="fas fa-save"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Sidebar -->
        <div class="lg:col-span-1">
            <div class="space-y-6">
                <!-- Info Nilai -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-rose-500 to-pink-600">
                        <h3 class="text-sm font-bold text-white flex items-center gap-2">
                            <i class="fas fa-info-circle"></i>
                            Informasi Nilai
                        </h3>
                    </div>
                    <div class="p-5">
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500">Dibuat Pada</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $grade->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Terakhir Diupdate</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $grade->updated_at->format('d M Y H:i') }}</p>
                            </div>
                            @if($grade->teacher)
                            <div>
                                <p class="text-xs text-gray-500">Guru Pengajar</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $grade->teacher->name }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Skala Nilai -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl shadow-sm border border-purple-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-purple-500 to-purple-600">
                        <h3 class="text-sm font-bold text-white flex items-center gap-2">
                            <i class="fas fa-award"></i>
                            Skala Predikat
                        </h3>
                    </div>
                    <div class="p-5">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between p-2 bg-white rounded-lg">
                                <span class="text-sm font-semibold text-gray-700">A (Sangat Baik)</span>
                                <span class="text-sm font-bold text-green-600">90-100</span>
                            </div>
                            <div class="flex items-center justify-between p-2 bg-white rounded-lg">
                                <span class="text-sm font-semibold text-gray-700">B (Baik)</span>
                                <span class="text-sm font-bold text-blue-600">80-89</span>
                            </div>
                            <div class="flex items-center justify-between p-2 bg-white rounded-lg">
                                <span class="text-sm font-semibold text-gray-700">C (Cukup)</span>
                                <span class="text-sm font-bold text-yellow-600">70-79</span>
                            </div>
                            <div class="flex items-center justify-between p-2 bg-white rounded-lg">
                                <span class="text-sm font-semibold text-gray-700">D (Kurang)</span>
                                <span class="text-sm font-bold text-orange-600">60-69</span>
                            </div>
                            <div class="flex items-center justify-between p-2 bg-white rounded-lg">
                                <span class="text-sm font-semibold text-gray-700">E (Gagal)</span>
                                <span class="text-sm font-bold text-red-600">0-59</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tips -->
                <div class="bg-gradient-to-br from-amber-50 to-yellow-50 rounded-2xl shadow-sm border border-amber-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-amber-500 to-yellow-600">
                        <h3 class="text-sm font-bold text-white flex items-center gap-2">
                            <i class="fas fa-lightbulb"></i>
                            Tips
                        </h3>
                    </div>
                    <div class="p-5">
                        <ul class="space-y-2">
                            <li class="flex items-start gap-2 text-xs text-gray-600">
                                <i class="fas fa-check-circle text-amber-500 mt-0.5"></i>
                                <span>Nilai antara 0-100</span>
                            </li>
                            <li class="flex items-start gap-2 text-xs text-gray-600">
                                <i class="fas fa-check-circle text-amber-500 mt-0.5"></i>
                                <span>Nilai akhir dihitung otomatis</span>
                            </li>
                            <li class="flex items-start gap-2 text-xs text-gray-600">
                                <i class="fas fa-check-circle text-amber-500 mt-0.5"></i>
                                <span>Perubahan langsung tersimpan</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-calculate final grade
    const gradeInputs = document.querySelectorAll('.grade-input');
    
    gradeInputs.forEach(input => {
        input.addEventListener('input', calculateFinalGrade);
    });

    function calculateFinalGrade() {
        const dailyTest = parseFloat(document.getElementById('daily_test').value) || 0;
        const midtermExam = parseFloat(document.getElementById('midterm_exam').value) || 0;
        const finalExam = parseFloat(document.getElementById('final_exam').value) || 0;
        
        // Calculate: 30% + 30% + 40%
        const finalGrade = (dailyTest * 0.3) + (midtermExam * 0.3) + (finalExam * 0.4);
        
        document.getElementById('final-grade').textContent = finalGrade.toFixed(2);
        
        // Update grade letter
        let letter = 'E';
        if (finalGrade >= 90) letter = 'A';
        else if (finalGrade >= 80) letter = 'B';
        else if (finalGrade >= 70) letter = 'C';
        else if (finalGrade >= 60) letter = 'D';
        
        document.getElementById('grade-letter').textContent = 'Predikat: ' + letter;
    }
});
</script>
@endpush
@endsection
