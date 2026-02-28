@extends('layouts.modern')

@section('title', __('saw.student_saw_title'))

@section('content')
<div class="max-w-7xl mx-auto space-y-4 sm:space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-user-graduate text-white text-lg sm:text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-3xl font-bold text-gray-900">{{ __('saw.student_saw_title') }}</h1>
                <p class="text-gray-600 mt-1 text-sm sm:text-base">{{ __('saw.student_saw_subtitle') }}</p>
            </div>
        </div>
        <a href="{{ route('criteria.index') }}" class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all duration-200 text-sm">
            <i class="fas fa-cog"></i>
            <span>{{ __('saw.manage_criteria') }}</span>
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 flex items-start gap-3">
        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
        <p class="text-green-800 flex-1">{{ session('success') }}</p>
        <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3">
        <i class="fas fa-exclamation-circle text-red-600 mt-0.5"></i>
        <p class="text-red-800 flex-1">{{ session('error') }}</p>
        <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <!-- Filter & Calculate Form -->
    <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100">
        <div class="p-4 sm:p-6 border-b border-gray-100">
            <h3 class="text-base sm:text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-filter text-blue-500"></i>
                {{ __('saw.filter_calculate') }}
            </h3>
        </div>
        <div class="p-4 sm:p-6">
            <form action="{{ route('saw.students.calculate') }}" method="POST" id="calculateForm">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">{{ __('general.class') }}</label>
                        <select name="class_id" id="class_id" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-sm" required>
                            <option value="">{{ __('saw.select_class') }}</option>
                            @foreach($classes as $kelas)
                            <option value="{{ $kelas->id }}" {{ $selectedClass == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">{{ __('general.semester') }}</label>
                        <select name="semester" id="semester" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-sm" required>
                            <option value="Ganjil" {{ $semester == 'Ganjil' ? 'selected' : '' }}>{{ __('general.odd') }}</option>
                            <option value="Genap" {{ $semester == 'Genap' ? 'selected' : '' }}>{{ __('general.even') }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">{{ __('general.academic_year') }}</label>
                        <select name="academic_year" id="academic_year" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-sm" required>
                            <option value="2023/2024" {{ $academicYear == '2023/2024' ? 'selected' : '' }}>2023/2024</option>
                            <option value="2024/2025" {{ $academicYear == '2024/2025' ? 'selected' : '' }}>2024/2025</option>
                            <option value="2025/2026" {{ $academicYear == '2025/2026' ? 'selected' : '' }}>2025/2026</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="button" onclick="filterData()" class="flex-1 px-3 sm:px-4 py-2.5 sm:py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg sm:rounded-xl hover:bg-gray-200 transition-all duration-200 text-sm">
                            <i class="fas fa-search mr-1 sm:mr-2"></i>{{ __('saw.view') }}
                        </button>
                        <button type="submit" class="flex-1 px-3 sm:px-4 py-2.5 sm:py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg sm:rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-200 text-sm">
                            <i class="fas fa-calculator mr-1 sm:mr-2"></i>{{ __('saw.calculate') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Criteria Info -->
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl sm:rounded-2xl border border-blue-200">
        <div class="p-4 sm:p-6">
            <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-3 sm:mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-blue-500"></i>
                {{ __('saw.student_criteria') }}
            </h3>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                @forelse($criteria as $c)
                <div class="bg-white rounded-lg sm:rounded-xl p-3 sm:p-4 border border-blue-100">
                    <div class="flex items-center justify-between mb-1.5 sm:mb-2">
                        <span class="font-mono font-bold text-blue-600 text-sm">{{ $c->code }}</span>
                        <span class="px-1.5 sm:px-2 py-0.5 sm:py-1 {{ $c->type == 'benefit' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded-lg text-[10px] sm:text-xs font-semibold">
                            {{ ucfirst($c->type) }}
                        </span>
                    </div>
                    <div class="font-semibold text-gray-900 text-xs sm:text-sm truncate">{{ $c->name }}</div>
                    <div class="text-[10px] sm:text-sm text-gray-500 mt-1">{{ __('saw.weight') }}: {{ number_format($c->weight * 100, 0) }}%</div>
                </div>
                @empty
                <div class="col-span-full text-center py-4 text-gray-500 text-sm">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    {{ __('saw.no_criteria') }}. <a href="{{ route('criteria.create') }}" class="text-blue-600 hover:underline">{{ __('saw.add_criteria') }}</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    @if($assessments && $assessments->isNotEmpty())
    <!-- Results Section -->
    <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100">
        <div class="p-4 sm:p-6 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                <h3 class="text-base sm:text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-trophy text-yellow-500"></i>
                    {{ __('saw.ranking_result') }}
                </h3>
                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs sm:text-sm font-semibold">
                    {{ $assessments->count() }} {{ __('menu.students') }}
                </span>
            </div>
        </div>
        
        <!-- Mobile Card View -->
        <div class="sm:hidden divide-y divide-gray-100">
            @foreach($assessments as $assessment)
            <div class="p-4 {{ $assessment->rank <= 3 ? 'bg-yellow-50' : '' }}">
                <div class="flex items-start gap-3">
                    <!-- Rank Badge -->
                    @if($assessment->rank == 1)
                    <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center shadow-lg flex-shrink-0">
                        <i class="fas fa-crown text-white text-sm"></i>
                    </div>
                    @elseif($assessment->rank == 2)
                    <div class="w-10 h-10 bg-gradient-to-br from-gray-300 to-gray-400 rounded-full flex items-center justify-center shadow-lg flex-shrink-0">
                        <span class="font-bold text-white">2</span>
                    </div>
                    @elseif($assessment->rank == 3)
                    <div class="w-10 h-10 bg-gradient-to-br from-amber-600 to-amber-700 rounded-full flex items-center justify-center shadow-lg flex-shrink-0">
                        <span class="font-bold text-white">3</span>
                    </div>
                    @else
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="font-bold text-gray-600">{{ $assessment->rank }}</span>
                    </div>
                    @endif
                    
                    <!-- Info -->
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-gray-900 text-sm truncate">{{ $assessment->student->name ?? 'N/A' }}</h4>
                        <p class="text-xs text-gray-500">NIS: {{ $assessment->student->nis ?? '-' }}</p>
                        
                        <div class="grid grid-cols-2 gap-2 mt-3">
                            <div class="bg-white rounded-lg p-2 border border-gray-100">
                                <p class="text-[10px] text-gray-500">{{ __('saw.academic') }}</p>
                                <p class="font-semibold text-sm {{ $assessment->academic_score >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($assessment->academic_score, 1) }}
                                </p>
                            </div>
                            <div class="bg-white rounded-lg p-2 border border-gray-100">
                                <p class="text-[10px] text-gray-500">{{ __('saw.attendance') }}</p>
                                <p class="font-semibold text-sm {{ $assessment->attendance_score >= 80 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($assessment->attendance_score, 1) }}%
                                </p>
                            </div>
                            <div class="bg-white rounded-lg p-2 border border-gray-100">
                                <p class="text-[10px] text-gray-500">{{ __('saw.behavior') }}</p>
                                <p class="font-semibold text-sm {{ $assessment->behavior_score >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($assessment->behavior_score, 1) }}
                                </p>
                            </div>
                            <div class="bg-white rounded-lg p-2 border border-gray-100">
                                <p class="text-[10px] text-gray-500">{{ __('saw.skill') }}</p>
                                <p class="font-semibold text-sm {{ $assessment->skill_score >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($assessment->skill_score, 1) }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="mt-3 flex justify-between items-center">
                            <span class="text-xs text-gray-500">{{ __('saw.saw_score') }}:</span>
                            <span class="px-3 py-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-bold text-sm">
                                {{ number_format($assessment->saw_score, 4) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Desktop Table View -->
        <div class="hidden sm:block p-4 sm:p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="px-2 lg:px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">{{ __('saw.rank') }}</th>
                            <th class="px-2 lg:px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">{{ __('saw.student') }}</th>
                            <th class="px-2 lg:px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase hidden lg:table-cell">{{ __('saw.academic') }}</th>
                            <th class="px-2 lg:px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase hidden lg:table-cell">{{ __('saw.attendance') }}</th>
                            <th class="px-2 lg:px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase hidden lg:table-cell">{{ __('saw.behavior') }}</th>
                            <th class="px-2 lg:px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase hidden lg:table-cell">{{ __('saw.skill') }}</th>
                            <th class="px-2 lg:px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">{{ __('saw.saw_score') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($assessments as $assessment)
                        <tr class="hover:bg-gray-50 transition-colors duration-150 {{ $assessment->rank <= 3 ? 'bg-yellow-50' : '' }}">
                            <td class="px-2 lg:px-4 py-3 lg:py-4 text-center">
                                @if($assessment->rank == 1)
                                <div class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center mx-auto shadow-lg">
                                    <i class="fas fa-crown text-white text-xs lg:text-sm"></i>
                                </div>
                                @elseif($assessment->rank == 2)
                                <div class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-br from-gray-300 to-gray-400 rounded-full flex items-center justify-center mx-auto shadow-lg">
                                    <span class="font-bold text-white text-sm">2</span>
                                </div>
                                @elseif($assessment->rank == 3)
                                <div class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-br from-amber-600 to-amber-700 rounded-full flex items-center justify-center mx-auto shadow-lg">
                                    <span class="font-bold text-white text-sm">3</span>
                                </div>
                                @else
                                <span class="font-bold text-gray-600">{{ $assessment->rank }}</span>
                                @endif
                            </td>
                            <td class="px-2 lg:px-4 py-3 lg:py-4">
                                <div class="flex items-center gap-2 lg:gap-3">
                                    <div class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-xs lg:text-sm flex-shrink-0">
                                        {{ substr($assessment->student->name ?? 'N', 0, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-semibold text-gray-900 text-sm truncate">{{ $assessment->student->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">{{ $assessment->student->nis ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-2 lg:px-4 py-3 lg:py-4 text-center hidden lg:table-cell">
                                <span class="font-semibold text-sm {{ $assessment->academic_score >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($assessment->academic_score, 2) }}
                                </span>
                            </td>
                            <td class="px-2 lg:px-4 py-3 lg:py-4 text-center hidden lg:table-cell">
                                <span class="font-semibold text-sm {{ $assessment->attendance_score >= 80 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($assessment->attendance_score, 2) }}%
                                </span>
                            </td>
                            <td class="px-2 lg:px-4 py-3 lg:py-4 text-center hidden lg:table-cell">
                                <span class="font-semibold text-sm {{ $assessment->behavior_score >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($assessment->behavior_score, 2) }}
                                </span>
                            </td>
                            <td class="px-2 lg:px-4 py-3 lg:py-4 text-center hidden lg:table-cell">
                                <span class="font-semibold text-sm {{ $assessment->skill_score >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($assessment->skill_score, 2) }}
                                </span>
                            </td>
                            <td class="px-2 lg:px-4 py-3 lg:py-4 text-center">
                                <span class="px-2 lg:px-3 py-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-bold text-xs lg:text-sm">
                                    {{ number_format($assessment->saw_score, 4) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($calculationDetails)
    <!-- Calculation Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
        <!-- Decision Matrix -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100">
            <div class="p-4 sm:p-6 border-b border-gray-100">
                <h3 class="text-base sm:text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-table text-purple-500"></i>
                    {{ __('saw.decision_matrix') }}
                </h3>
            </div>
            <div class="p-4 sm:p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-xs sm:text-sm">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-2 sm:px-3 py-2 text-left font-bold text-gray-700">{{ __('saw.alt') }}</th>
                                @foreach($criteria as $c)
                                <th class="px-2 sm:px-3 py-2 text-center font-bold text-gray-700">{{ $c->code }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($calculationDetails['matrix'] as $idx => $row)
                            <tr>
                                <td class="px-2 sm:px-3 py-2 font-semibold">A{{ $idx + 1 }}</td>
                                @foreach($criteria as $c)
                                <td class="px-2 sm:px-3 py-2 text-center">{{ number_format($row[$c->code] ?? 0, 2) }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Normalized Matrix -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100">
            <div class="p-4 sm:p-6 border-b border-gray-100">
                <h3 class="text-base sm:text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-percentage text-green-500"></i>
                    {{ __('saw.normalized_matrix') }}
                </h3>
            </div>
            <div class="p-4 sm:p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-xs sm:text-sm">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-2 sm:px-3 py-2 text-left font-bold text-gray-700">{{ __('saw.alt') }}</th>
                                @foreach($criteria as $c)
                                <th class="px-2 sm:px-3 py-2 text-center font-bold text-gray-700">{{ $c->code }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($calculationDetails['normalized'] as $idx => $row)
                            <tr>
                                <td class="px-2 sm:px-3 py-2 font-semibold">A{{ $idx + 1 }}</td>
                                @foreach($criteria as $c)
                                <td class="px-2 sm:px-3 py-2 text-center">{{ number_format($row[$c->code] ?? 0, 4) }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100">
        <div class="p-4 sm:p-6 border-b border-gray-100">
            <h3 class="text-base sm:text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-chart-bar text-indigo-500"></i>
                {{ __('saw.saw_score') }} {{ __('saw.student_ranking') }}
            </h3>
        </div>
        <div class="p-4 sm:p-6">
            <canvas id="sawChart" height="100"></canvas>
        </div>
    </div>
    @endif

    @else
    <!-- Empty State -->
    <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100">
        <div class="p-8 sm:p-12 text-center">
            <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                <i class="fas fa-calculator text-gray-400 text-3xl sm:text-4xl"></i>
            </div>
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">{{ __('saw.no_data') }}</h3>
            <p class="text-gray-500 mb-4 sm:mb-6 text-sm sm:text-base">{{ __('saw.select_class_first') }}</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4">
                <a href="{{ route('grades.index') }}" class="inline-flex items-center gap-2 px-5 sm:px-6 py-2.5 sm:py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all duration-200 text-sm">
                    <i class="fas fa-edit"></i>
                    {{ __('grades.input_grade') }}
                </a>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function filterData() {
    const classId = document.getElementById('class_id').value;
    const semester = document.getElementById('semester').value;
    const academicYear = document.getElementById('academic_year').value;
    
    if (!classId) {
        alert('Pilih kelas terlebih dahulu');
        return;
    }
    
    window.location.href = `{{ route('saw.students.index') }}?class_id=${classId}&semester=${semester}&academic_year=${academicYear}`;
}

@if($assessments && $assessments->isNotEmpty())
// Chart.js for SAW Score visualization
const ctx = document.getElementById('sawChart').getContext('2d');
const sawChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($assessments->pluck('student.name')) !!},
        datasets: [{
            label: 'Skor SAW',
            data: {!! json_encode($assessments->pluck('saw_score')) !!},
            backgroundColor: function(context) {
                const index = context.dataIndex;
                if (index === 0) return 'rgba(234, 179, 8, 0.8)';
                if (index === 1) return 'rgba(156, 163, 175, 0.8)';
                if (index === 2) return 'rgba(180, 83, 9, 0.8)';
                return 'rgba(59, 130, 246, 0.8)';
            },
            borderColor: function(context) {
                const index = context.dataIndex;
                if (index === 0) return 'rgb(234, 179, 8)';
                if (index === 1) return 'rgb(156, 163, 175)';
                if (index === 2) return 'rgb(180, 83, 9)';
                return 'rgb(59, 130, 246)';
            },
            borderWidth: 2,
            borderRadius: 8,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Skor: ' + context.raw.toFixed(4);
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 1,
                title: {
                    display: true,
                    text: 'Skor SAW'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Nama Siswa'
                }
            }
        }
    }
});
@endif
</script>
@endpush
@endsection
