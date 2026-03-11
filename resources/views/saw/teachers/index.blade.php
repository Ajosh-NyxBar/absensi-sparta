@extends('layouts.modern')

@section('title', __('saw.teacher_saw_title'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chalkboard-teacher text-white text-xl"></i>
                    </div>
                    {{ __('saw.teacher_saw_title') }}
                </h1>
                <p class="text-gray-600 mt-2">{{ __('saw.teacher_saw_subtitle') }}</p>
            </div>
            <a href="{{ route('criteria.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all duration-200">
                <i class="fas fa-cog"></i>
                <span>{{ __('saw.manage_criteria') }}</span>
            </a>
        </div>
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
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-filter text-green-500"></i>
                {{ __('saw.filter_calculate') }}
            </h3>
        </div>
        <div class="p-6">
            <form action="{{ route('saw.teachers.calculate') }}" method="POST" id="calculateForm">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('saw.select_period') }}</label>
                        <select name="period" id="period" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200" required>
                            <option value="Ganjil" {{ $period == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="Genap" {{ $period == 'Genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('general.academic_year') }}</label>
                        <select name="academic_year" id="academic_year" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200" required>
                            @foreach($academicYears as $year)
                            <option value="{{ $year }}" {{ $academicYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="button" onclick="filterData()" class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all duration-200">
                            <i class="fas fa-search mr-2"></i>{{ __('saw.view') }}
                        </button>
                        <button type="submit" class="flex-1 px-4 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-200">
                            <i class="fas fa-calculator mr-2"></i>{{ __('saw.calculate') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Criteria Info -->
    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl border border-green-200 mb-8">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-green-500"></i>
                {{ __('saw.teacher_criteria') }}
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @forelse($criteria as $c)
                <div class="bg-white rounded-xl p-4 border border-green-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-mono font-bold text-green-600">{{ $c->code }}</span>
                        <span class="px-2 py-1 {{ $c->type == 'benefit' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded-lg text-xs font-semibold">
                            {{ ucfirst($c->type) }}
                        </span>
                    </div>
                    <div class="font-semibold text-gray-900">{{ $c->name }}</div>
                    <div class="text-sm text-gray-500 mt-1">{{ __('saw.weight') }}: {{ number_format($c->weight * 100, 0) }}%</div>
                </div>
                @empty
                <div class="col-span-4 text-center py-4 text-gray-500">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    {{ __('saw.no_criteria') }}. <a href="{{ route('criteria.create') }}" class="text-green-600 hover:underline">{{ __('saw.add_criteria') }}</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    @if($assessments && $assessments->isNotEmpty())
    <!-- Results Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8">
        <div class="p-6 border-b border-gray-100">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-trophy text-yellow-500"></i>
                    {{ __('saw.teacher_ranking_result') }}
                </h3>
                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-sm font-semibold">
                    {{ $assessments->count() }} {{ __('menu.teachers') }}
                </span>
            </div>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">{{ __('saw.rank') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">{{ __('saw.teacher') }}</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">{{ __('saw.attendance') }} (K1)</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">{{ __('saw.teaching_quality') }} (K2)</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">{{ __('saw.student_ranking') }} (K3)</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">{{ __('saw.discipline') }} (K4)</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">{{ __('saw.saw_score') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($assessments as $assessment)
                        <tr class="hover:bg-gray-50 transition-colors duration-150 {{ $assessment->rank <= 3 ? 'bg-yellow-50' : '' }}">
                            <td class="px-4 py-4 text-center">
                                @if($assessment->rank == 1)
                                <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center mx-auto shadow-lg">
                                    <i class="fas fa-crown text-white"></i>
                                </div>
                                @elseif($assessment->rank == 2)
                                <div class="w-10 h-10 bg-gradient-to-br from-gray-300 to-gray-400 rounded-full flex items-center justify-center mx-auto shadow-lg">
                                    <span class="font-bold text-white">2</span>
                                </div>
                                @elseif($assessment->rank == 3)
                                <div class="w-10 h-10 bg-gradient-to-br from-amber-600 to-amber-700 rounded-full flex items-center justify-center mx-auto shadow-lg">
                                    <span class="font-bold text-white">3</span>
                                </div>
                                @else
                                <span class="font-bold text-gray-600">{{ $assessment->rank }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ substr($assessment->teacher->name ?? 'N', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $assessment->teacher->name ?? 'N/A' }}</div>
                                        <div class="text-sm text-gray-500">NIP: {{ $assessment->teacher->nip ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="font-semibold {{ $assessment->attendance_score >= 80 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($assessment->attendance_score, 2) }}%
                                </span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="font-semibold {{ $assessment->teaching_quality >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($assessment->teaching_quality, 2) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="font-semibold {{ $assessment->student_achievement >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($assessment->student_achievement, 2) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="font-semibold {{ $assessment->discipline_score >= 80 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($assessment->discipline_score, 2) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="px-3 py-1 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg font-bold">
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
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Decision Matrix -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-table text-purple-500"></i>
                    {{ __('saw.decision_matrix') }}
                </h3>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-3 py-2 text-left font-bold text-gray-700">{{ __('saw.alt') }}</th>
                                @foreach($criteria as $c)
                                <th class="px-3 py-2 text-center font-bold text-gray-700">{{ $c->code }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($calculationDetails['matrix'] as $idx => $row)
                            <tr>
                                <td class="px-3 py-2 font-semibold">A{{ $idx + 1 }}</td>
                                @foreach($criteria as $c)
                                <td class="px-3 py-2 text-center">{{ number_format($row[$c->code] ?? 0, 2) }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Normalized Matrix -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-percentage text-green-500"></i>
                    {{ __('saw.normalized_matrix') }}
                </h3>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-3 py-2 text-left font-bold text-gray-700">{{ __('saw.alt') }}</th>
                                @foreach($criteria as $c)
                                <th class="px-3 py-2 text-center font-bold text-gray-700">{{ $c->code }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($calculationDetails['normalized'] as $idx => $row)
                            <tr>
                                <td class="px-3 py-2 font-semibold">A{{ $idx + 1 }}</td>
                                @foreach($criteria as $c)
                                <td class="px-3 py-2 text-center">{{ number_format($row[$c->code] ?? 0, 4) }}</td>
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
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-chart-bar text-indigo-500"></i>
                {{ __('saw.saw_score') }} {{ __('saw.teacher_ranking') }}
            </h3>
        </div>
        <div class="p-6">
            <canvas id="sawChart" height="100"></canvas>
        </div>
    </div>

    <!-- Radar Chart for Comparison -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-chart-pie text-pink-500"></i>
                {{ __('saw.criteria_scores') }} Top 5 {{ __('menu.teachers') }}
            </h3>
        </div>
        <div class="p-6">
            <canvas id="radarChart" height="150"></canvas>
        </div>
    </div>
    @endif

    @else
    <!-- Empty State -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="p-12 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-calculator text-gray-400 text-4xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('saw.no_data') }}</h3>
            <p class="text-gray-500 mb-6">{{ __('saw.select_class_first') }}</p>
            <div class="flex items-center justify-center gap-4">
                <a href="{{ route('teachers.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all duration-200">
                    <i class="fas fa-users"></i>
                    {{ __('menu.teachers') }}
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
    const period = document.getElementById('period').value;
    const academicYear = document.getElementById('academic_year').value;
    
    window.location.href = `{{ route('saw.teachers.index') }}?period=${encodeURIComponent(period)}&academic_year=${academicYear}`;
}

@if($assessments && $assessments->isNotEmpty())
// Bar Chart for SAW Score visualization
const ctx = document.getElementById('sawChart').getContext('2d');
const sawChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($assessments->pluck('teacher.name')) !!},
        datasets: [{
            label: 'Skor SAW',
            data: {!! json_encode($assessments->pluck('saw_score')) !!},
            backgroundColor: function(context) {
                const index = context.dataIndex;
                if (index === 0) return 'rgba(234, 179, 8, 0.8)';
                if (index === 1) return 'rgba(156, 163, 175, 0.8)';
                if (index === 2) return 'rgba(180, 83, 9, 0.8)';
                return 'rgba(34, 197, 94, 0.8)';
            },
            borderColor: function(context) {
                const index = context.dataIndex;
                if (index === 0) return 'rgb(234, 179, 8)';
                if (index === 1) return 'rgb(156, 163, 175)';
                if (index === 2) return 'rgb(180, 83, 9)';
                return 'rgb(34, 197, 94)';
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
                    text: 'Nama Guru'
                }
            }
        }
    }
});

// Radar Chart for top 5 teachers comparison
const radarCtx = document.getElementById('radarChart').getContext('2d');
const top5 = {!! json_encode($assessments->take(5)->values()) !!};
const colors = [
    'rgba(234, 179, 8, 0.5)',
    'rgba(156, 163, 175, 0.5)',
    'rgba(180, 83, 9, 0.5)',
    'rgba(34, 197, 94, 0.5)',
    'rgba(59, 130, 246, 0.5)'
];
const borderColors = [
    'rgb(234, 179, 8)',
    'rgb(156, 163, 175)',
    'rgb(180, 83, 9)',
    'rgb(34, 197, 94)',
    'rgb(59, 130, 246)'
];

const radarChart = new Chart(radarCtx, {
    type: 'radar',
    data: {
        labels: ['Kehadiran', 'Kualitas Mengajar', 'Prestasi Siswa', 'Kedisiplinan'],
        datasets: top5.map((item, index) => ({
            label: item.teacher?.name || `Guru ${index + 1}`,
            data: [
                item.attendance_score,
                item.teaching_quality,
                item.student_achievement,
                item.discipline_score
            ],
            backgroundColor: colors[index],
            borderColor: borderColors[index],
            borderWidth: 2,
            pointBackgroundColor: borderColors[index],
        }))
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        },
        scales: {
            r: {
                beginAtZero: true,
                max: 100,
                ticks: {
                    stepSize: 20
                }
            }
        }
    }
});
@endif
</script>
@endpush
@endsection
