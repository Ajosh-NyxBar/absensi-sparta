@extends('layouts.modern')

@section('title', __('reports.page_title'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
            <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-file-download text-white text-xl"></i>
            </div>
            {{ __('reports.page_title') }}
        </h1>
        <p class="text-gray-600 mt-2">{{ __('reports.subtitle') }}</p>
    </div>

    <!-- Reports Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Laporan Presensi -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
            <div class="h-2 bg-gradient-to-r from-purple-500 to-purple-600"></div>
            <div class="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clipboard-check text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ __('reports.attendance_report') }}</h3>
                        <p class="text-sm text-gray-500">{{ __('reports.attendance_report_desc') }}</p>
                    </div>
                </div>

                <form action="{{ route('reports.attendance.export') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            {{ __('reports.start_date') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                               name="start_date" 
                               value="{{ date('Y-m-01') }}" 
                               required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            {{ __('reports.end_date') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                               name="end_date" 
                               value="{{ date('Y-m-d') }}" 
                               required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('reports.type') }}</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                name="type">
                            <option value="">{{ __('reports.all_types') }}</option>
                            <option value="teacher">{{ __('reports.teacher_only') }}</option>
                            <option value="student">{{ __('reports.student_only') }}</option>
                        </select>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-100">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">{{ __('reports.export_format') }} <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="submit" name="format" value="excel" class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-green-500 text-white font-semibold rounded-xl hover:bg-green-600 transition-all duration-200 shadow-sm hover:shadow-md">
                                <i class="fas fa-file-excel"></i>
                                <span>Excel</span>
                            </button>
                            <button type="submit" name="format" value="pdf" class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-red-500 text-white font-semibold rounded-xl hover:bg-red-600 transition-all duration-200 shadow-sm hover:shadow-md">
                                <i class="fas fa-file-pdf"></i>
                                <span>PDF</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Laporan Nilai -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
            <div class="h-2 bg-gradient-to-r from-blue-500 to-blue-600"></div>
            <div class="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ __('reports.grade_report') }}</h3>
                        <p class="text-sm text-gray-500">{{ __('reports.grade_report_desc') }}</p>
                    </div>
                </div>

                <form action="{{ route('reports.grades.export') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('reports.select_class') }}</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                                name="class_id">
                            <option value="">{{ __('reports.all_classes') }}</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('general.semester') }}</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                                name="semester">
                            <option value="">{{ __('reports.all_semesters') }}</option>
                            <option value="1">{{ __('reports.semester_1') }}</option>
                            <option value="2">{{ __('reports.semester_2') }}</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('general.academic_year') }}</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                                name="academic_year">
                            <option value="">{{ __('reports.all_years') }}</option>
                            @foreach($academicYears as $year)
                                <option value="{{ $year->year }}" {{ $activeYear && $year->id == $activeYear->id ? 'selected' : '' }}>
                                    {{ $year->year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-100">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">{{ __('reports.export_format') }} <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="submit" name="format" value="excel" class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-green-500 text-white font-semibold rounded-xl hover:bg-green-600 transition-all duration-200 shadow-sm hover:shadow-md">
                                <i class="fas fa-file-excel"></i>
                                <span>Excel</span>
                            </button>
                            <button type="submit" name="format" value="pdf" class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-red-500 text-white font-semibold rounded-xl hover:bg-red-600 transition-all duration-200 shadow-sm hover:shadow-md">
                                <i class="fas fa-file-pdf"></i>
                                <span>PDF</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Laporan Siswa -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
            <div class="h-2 bg-gradient-to-r from-yellow-500 to-yellow-600"></div>
            <div class="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user-graduate text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ __('reports.student_report') }}</h3>
                        <p class="text-sm text-gray-500">{{ __('reports.student_report_desc') }}</p>
                    </div>
                </div>

                <form action="{{ route('reports.students.export') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('reports.select_class') }}</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200" 
                                name="class_id">
                            <option value="">{{ __('reports.all_classes') }}</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('reports.level') }}</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200" 
                                name="grade">
                            <option value="">{{ __('reports.all_levels') }}</option>
                            <option value="7">{{ __('reports.class_7') }}</option>
                            <option value="8">{{ __('reports.class_8') }}</option>
                            <option value="9">{{ __('reports.class_9') }}</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('reports.status') }}</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200" 
                                name="status">
                            <option value="active">{{ __('reports.active') }}</option>
                            <option value="inactive">{{ __('reports.inactive') }}</option>
                            <option value="">{{ __('reports.all_status') }}</option>
                        </select>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-100">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">{{ __('reports.export_format') }} <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="submit" name="format" value="excel" class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-green-500 text-white font-semibold rounded-xl hover:bg-green-600 transition-all duration-200 shadow-sm hover:shadow-md">
                                <i class="fas fa-file-excel"></i>
                                <span>Excel</span>
                            </button>
                            <button type="submit" name="format" value="pdf" class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-red-500 text-white font-semibold rounded-xl hover:bg-red-600 transition-all duration-200 shadow-sm hover:shadow-md">
                                <i class="fas fa-file-pdf"></i>
                                <span>PDF</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Laporan Guru -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
            <div class="h-2 bg-gradient-to-r from-cyan-500 to-cyan-600"></div>
            <div class="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chalkboard-teacher text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ __('reports.teacher_report') }}</h3>
                        <p class="text-sm text-gray-500">{{ __('reports.teacher_report_desc') }}</p>
                    </div>
                </div>

                <form action="{{ route('reports.teachers.export') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <!-- Data yang Diexport -->
                    <div class="bg-gradient-to-br from-cyan-50 to-blue-50 border border-cyan-200 rounded-xl p-5">
                        <h4 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-database text-cyan-600"></i>
                            {{ __('reports.data_exported') }}
                        </h4>
                        <div class="grid grid-cols-1 gap-2">
                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                <i class="fas fa-check-circle text-cyan-600 text-xs"></i>
                                <span>{{ __('reports.nip_name') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                <i class="fas fa-check-circle text-cyan-600 text-xs"></i>
                                <span>{{ __('reports.personal_data') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                <i class="fas fa-check-circle text-cyan-600 text-xs"></i>
                                <span>{{ __('reports.last_education') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                <i class="fas fa-check-circle text-cyan-600 text-xs"></i>
                                <span>{{ __('reports.subjects_taught') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                <i class="fas fa-check-circle text-cyan-600 text-xs"></i>
                                <span>{{ __('reports.account_status') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-100">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">{{ __('reports.export_format') }} <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="submit" name="format" value="excel" class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-green-500 text-white font-semibold rounded-xl hover:bg-green-600 transition-all duration-200 shadow-sm hover:shadow-md">
                                <i class="fas fa-file-excel"></i>
                                <span>Excel</span>
                            </button>
                            <button type="submit" name="format" value="pdf" class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-red-500 text-white font-semibold rounded-xl hover:bg-red-600 transition-all duration-200 shadow-sm hover:shadow-md">
                                <i class="fas fa-file-pdf"></i>
                                <span>PDF</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Informasi Penggunaan -->
<div class="mt-8 bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
    <div class="bg-gradient-to-r from-indigo-500 to-purple-500 px-6 py-4">
        <h3 class="text-lg font-bold text-white flex items-center gap-2">
            <i class="fas fa-info-circle"></i>
            {{ __('reports.usage_info') }}
        </h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Format Excel -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-5 border border-green-200">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-file-excel text-white text-xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-lg">{{ __('reports.excel_format') }}</h4>
                </div>
                <ul class="space-y-2.5">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-green-600 mt-1"></i>
                        <span class="text-gray-700">{{ __('reports.file_format') }}: <span class="font-mono text-xs bg-white px-2 py-1 rounded border border-green-200">.xlsx</span> (Microsoft Excel)</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-green-600 mt-1"></i>
                        <span class="text-gray-700">{{ __('reports.excel_editable') }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-green-600 mt-1"></i>
                        <span class="text-gray-700">{{ __('reports.excel_formula') }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-green-600 mt-1"></i>
                        <span class="text-gray-700">{{ __('reports.excel_smaller') }}</span>
                    </li>
                </ul>
            </div>

            <!-- Format PDF -->
            <div class="bg-gradient-to-br from-red-50 to-pink-50 rounded-xl p-5 border border-red-200">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-file-pdf text-white text-xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-lg">{{ __('reports.pdf_format') }}</h4>
                </div>
                <ul class="space-y-2.5">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-red-600 mt-1"></i>
                        <span class="text-gray-700">{{ __('reports.file_format') }}: <span class="font-mono text-xs bg-white px-2 py-1 rounded border border-red-200">.pdf</span> (Portable Document Format)</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-red-600 mt-1"></i>
                        <span class="text-gray-700">{{ __('reports.pdf_printable') }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-red-600 mt-1"></i>
                        <span class="text-gray-700">{{ __('reports.pdf_readonly') }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-red-600 mt-1"></i>
                        <span class="text-gray-700">{{ __('reports.pdf_consistent') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
