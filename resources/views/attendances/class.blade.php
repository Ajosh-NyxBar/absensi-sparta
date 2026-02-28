@extends('layouts.modern')

@section('title', 'Presensi Kelas ' . $class->name)

@section('content')
<div class="max-w-7xl mx-auto py-4 sm:py-8">
    <!-- Page Header -->
    <div class="mb-4 sm:mb-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-3 sm:gap-4">
            <div>
                <h1 class="text-xl sm:text-3xl font-bold text-gray-900 flex items-center gap-2 sm:gap-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-clipboard-list text-white text-lg sm:text-xl"></i>
                    </div>
                    Presensi {{ $class->name }}
                </h1>
                <p class="text-gray-600 mt-1 sm:mt-2 text-sm sm:text-base">Input kehadiran siswa untuk {{ \Carbon\Carbon::parse($date)->format('d M Y') }}</p>
            </div>
            <a href="{{ route('classes.show', $class) }}" class="inline-flex items-center justify-center gap-2 px-3 sm:px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg sm:rounded-xl hover:bg-gray-200 transition-all duration-200 text-sm sm:text-base">
                <i class="fas fa-arrow-left"></i>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-4 sm:mb-6 bg-green-50 border border-green-200 rounded-lg sm:rounded-xl p-3 sm:p-4 flex items-start gap-2 sm:gap-3">
        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
        <p class="text-green-800 flex-1 text-sm sm:text-base">{{ session('success') }}</p>
        <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 sm:mb-6 bg-red-50 border border-red-200 rounded-lg sm:rounded-xl p-3 sm:p-4 flex items-start gap-2 sm:gap-3">
        <i class="fas fa-exclamation-circle text-red-600 mt-0.5"></i>
        <p class="text-red-800 flex-1 text-sm sm:text-base">{{ session('error') }}</p>
        <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <!-- Date Filter -->
    <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 mb-4 sm:mb-8">
        <div class="p-4 sm:p-6">
            <form action="{{ route('attendances.class', $class) }}" method="GET" class="flex flex-col sm:flex-row sm:items-end gap-3 sm:gap-4">
                <div class="flex-1">
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Pilih Tanggal</label>
                    <input type="date" name="date" value="{{ $date }}" 
                        class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-sm">
                </div>
                <button type="submit" class="px-6 py-2 sm:py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-lg sm:rounded-xl hover:from-teal-600 hover:to-teal-700 transition-all duration-200 text-sm">
                    <i class="fas fa-search mr-2"></i>Tampilkan
                </button>
            </form>
        </div>
    </div>

    <!-- Class Info -->
    <div class="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-xl sm:rounded-2xl border border-teal-200 mb-4 sm:mb-8">
        <div class="p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="w-10 h-10 sm:w-14 sm:h-14 bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-door-open text-white text-lg sm:text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-xl font-bold text-gray-900">{{ $class->name }}</h3>
                        <p class="text-gray-600 text-xs sm:text-base truncate max-w-[150px] sm:max-w-none">Wali: {{ $class->teacher->name ?? 'Belum ditentukan' }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-xl sm:text-3xl font-bold text-teal-600">{{ $students->count() }}</div>
                    <div class="text-[10px] sm:text-sm text-gray-600">Siswa</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-5 gap-2 sm:gap-4 mb-4 sm:mb-8">
        <div class="bg-white rounded-lg sm:rounded-xl p-2 sm:p-4 border border-gray-100 text-center">
            <div class="text-lg sm:text-2xl font-bold text-green-600" id="countPresent">0</div>
            <div class="text-[10px] sm:text-sm text-gray-600">Hadir</div>
        </div>
        <div class="bg-white rounded-lg sm:rounded-xl p-2 sm:p-4 border border-gray-100 text-center">
            <div class="text-lg sm:text-2xl font-bold text-blue-600" id="countSick">0</div>
            <div class="text-[10px] sm:text-sm text-gray-600">Sakit</div>
        </div>
        <div class="bg-white rounded-lg sm:rounded-xl p-2 sm:p-4 border border-gray-100 text-center">
            <div class="text-lg sm:text-2xl font-bold text-purple-600" id="countPermission">0</div>
            <div class="text-[10px] sm:text-sm text-gray-600">Izin</div>
        </div>
        <div class="bg-white rounded-lg sm:rounded-xl p-2 sm:p-4 border border-gray-100 text-center">
            <div class="text-lg sm:text-2xl font-bold text-red-600" id="countAbsent">0</div>
            <div class="text-[10px] sm:text-sm text-gray-600">Alpha</div>
        </div>
        <div class="bg-white rounded-lg sm:rounded-xl p-2 sm:p-4 border border-gray-100 text-center">
            <div class="text-lg sm:text-2xl font-bold text-gray-600" id="countTotal">{{ $students->count() }}</div>
            <div class="text-[10px] sm:text-sm text-gray-600">Total</div>
        </div>
    </div>

    <!-- Attendance Form -->
    <form action="{{ route('attendances.class.save', $class) }}" method="POST">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}">

        <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 sm:p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                <h3 class="text-base sm:text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-users text-teal-500"></i>
                    Daftar Siswa
                </h3>
                <div class="flex gap-2">
                    <button type="button" onclick="setAllStatus('present')" class="flex-1 sm:flex-none px-3 py-2 bg-green-100 text-green-700 text-xs sm:text-sm font-semibold rounded-lg hover:bg-green-200 transition-all duration-200">
                        <i class="fas fa-check-double mr-1"></i>Hadir
                    </button>
                    <button type="button" onclick="setAllStatus('absent')" class="flex-1 sm:flex-none px-3 py-2 bg-red-100 text-red-700 text-xs sm:text-sm font-semibold rounded-lg hover:bg-red-200 transition-all duration-200">
                        <i class="fas fa-times mr-1"></i>Alpha
                    </button>
                </div>
            </div>
            <div class="p-3 sm:p-6">
                @if($students->isEmpty())
                <div class="text-center py-8 sm:py-12">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-slash text-gray-400 text-2xl sm:text-3xl"></i>
                    </div>
                    <p class="text-gray-500 text-sm sm:text-base">Tidak ada siswa aktif di kelas ini</p>
                </div>
                @else
                <!-- Mobile Card View -->
                <div class="sm:hidden space-y-3">
                    @foreach($students as $index => $student)
                    @php
                        $existingStatus = isset($attendances[$student->id]) ? $attendances[$student->id]->status : null;
                    @endphp
                    <div class="bg-gray-50 rounded-xl p-3 border border-gray-100">
                        <input type="hidden" name="attendances[{{ $index }}][student_id]" value="{{ $student->id }}">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-teal-500 to-teal-600 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                {{ substr($student->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-gray-900 text-sm truncate">{{ $student->name }}</div>
                                <div class="text-xs text-gray-500">NIS: {{ $student->nis }}</div>
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-2">
                            <label class="flex flex-col items-center cursor-pointer">
                                <input type="radio" name="attendances[{{ $index }}][status]" value="present" 
                                    {{ $existingStatus == 'present' ? 'checked' : '' }}
                                    class="sr-only peer status-radio" data-status="present">
                                <span class="w-10 h-10 rounded-full border-2 border-gray-200 flex items-center justify-center peer-checked:bg-green-500 peer-checked:border-green-500 peer-checked:text-white text-gray-400 transition-all duration-200">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="text-[10px] mt-1 text-gray-600">Hadir</span>
                            </label>
                            <label class="flex flex-col items-center cursor-pointer">
                                <input type="radio" name="attendances[{{ $index }}][status]" value="sick" 
                                    {{ $existingStatus == 'sick' ? 'checked' : '' }}
                                    class="sr-only peer status-radio" data-status="sick">
                                <span class="w-10 h-10 rounded-full border-2 border-gray-200 flex items-center justify-center peer-checked:bg-blue-500 peer-checked:border-blue-500 peer-checked:text-white text-gray-400 transition-all duration-200">
                                    <i class="fas fa-thermometer-half"></i>
                                </span>
                                <span class="text-[10px] mt-1 text-gray-600">Sakit</span>
                            </label>
                            <label class="flex flex-col items-center cursor-pointer">
                                <input type="radio" name="attendances[{{ $index }}][status]" value="permission" 
                                    {{ $existingStatus == 'permission' ? 'checked' : '' }}
                                    class="sr-only peer status-radio" data-status="permission">
                                <span class="w-10 h-10 rounded-full border-2 border-gray-200 flex items-center justify-center peer-checked:bg-purple-500 peer-checked:border-purple-500 peer-checked:text-white text-gray-400 transition-all duration-200">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <span class="text-[10px] mt-1 text-gray-600">Izin</span>
                            </label>
                            <label class="flex flex-col items-center cursor-pointer">
                                <input type="radio" name="attendances[{{ $index }}][status]" value="absent" 
                                    {{ $existingStatus == 'absent' ? 'checked' : '' }}
                                    class="sr-only peer status-radio" data-status="absent">
                                <span class="w-10 h-10 rounded-full border-2 border-gray-200 flex items-center justify-center peer-checked:bg-red-500 peer-checked:border-red-500 peer-checked:text-white text-gray-400 transition-all duration-200">
                                    <i class="fas fa-times"></i>
                                </span>
                                <span class="text-[10px] mt-1 text-gray-600">Alpha</span>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Desktop Table View -->
                <div class="hidden sm:block overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="px-3 lg:px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">No</th>
                                <th class="px-3 lg:px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Siswa</th>
                                <th class="px-3 lg:px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">
                                    <span class="inline-flex items-center gap-1 text-green-600">
                                        <i class="fas fa-check-circle"></i>
                                        <span class="hidden lg:inline">Hadir</span>
                                    </span>
                                </th>
                                <th class="px-3 lg:px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">
                                    <span class="inline-flex items-center gap-1 text-blue-600">
                                        <i class="fas fa-thermometer-half"></i>
                                        <span class="hidden lg:inline">Sakit</span>
                                    </span>
                                </th>
                                <th class="px-3 lg:px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">
                                    <span class="inline-flex items-center gap-1 text-purple-600">
                                        <i class="fas fa-envelope"></i>
                                        <span class="hidden lg:inline">Izin</span>
                                    </span>
                                </th>
                                <th class="px-3 lg:px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">
                                    <span class="inline-flex items-center gap-1 text-red-600">
                                        <i class="fas fa-times-circle"></i>
                                        <span class="hidden lg:inline">Alpha</span>
                                    </span>
                                </th>
                            </tr>
                        </thead>
                                        Sakit
                                    </span>
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">
                                    <span class="inline-flex items-center gap-1 text-purple-600">
                                        <i class="fas fa-envelope"></i>
                                        Izin
                                    </span>
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">
                                    <span class="inline-flex items-center gap-1 text-red-600">
                                        <i class="fas fa-times-circle"></i>
                                        Alpha
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($students as $index => $student)
                            @php
                                $existingStatus = isset($attendances[$student->id]) ? $attendances[$student->id]->status : null;
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-3 lg:px-4 py-3 lg:py-4 text-gray-600 text-sm">{{ $index + 1 }}</td>
                                <td class="px-3 lg:px-4 py-3 lg:py-4">
                                    <input type="hidden" name="attendances[{{ $index }}][student_id]" value="{{ $student->id }}">
                                    <div class="flex items-center gap-2 lg:gap-3">
                                        <div class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-br from-teal-500 to-teal-600 rounded-full flex items-center justify-center text-white font-bold text-xs lg:text-sm flex-shrink-0">
                                            {{ substr($student->name, 0, 1) }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-semibold text-gray-900 text-sm truncate">{{ $student->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $student->nis }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 lg:px-4 py-3 lg:py-4 text-center">
                                    <label class="inline-flex items-center justify-center cursor-pointer">
                                        <input type="radio" name="attendances[{{ $index }}][status]" value="present" 
                                            {{ $existingStatus == 'present' ? 'checked' : '' }}
                                            class="sr-only peer status-radio" data-status="present">
                                        <span class="w-8 h-8 lg:w-10 lg:h-10 rounded-full border-2 border-gray-200 flex items-center justify-center peer-checked:bg-green-500 peer-checked:border-green-500 peer-checked:text-white text-gray-400 transition-all duration-200 hover:border-green-400">
                                            <i class="fas fa-check text-sm"></i>
                                        </span>
                                    </label>
                                </td>
                                <td class="px-3 lg:px-4 py-3 lg:py-4 text-center">
                                    <label class="inline-flex items-center justify-center cursor-pointer">
                                        <input type="radio" name="attendances[{{ $index }}][status]" value="sick" 
                                            {{ $existingStatus == 'sick' ? 'checked' : '' }}
                                            class="sr-only peer status-radio" data-status="sick">
                                        <span class="w-8 h-8 lg:w-10 lg:h-10 rounded-full border-2 border-gray-200 flex items-center justify-center peer-checked:bg-blue-500 peer-checked:border-blue-500 peer-checked:text-white text-gray-400 transition-all duration-200 hover:border-blue-400">
                                            <i class="fas fa-thermometer-half text-sm"></i>
                                        </span>
                                    </label>
                                </td>
                                <td class="px-3 lg:px-4 py-3 lg:py-4 text-center">
                                    <label class="inline-flex items-center justify-center cursor-pointer">
                                        <input type="radio" name="attendances[{{ $index }}][status]" value="permission" 
                                            {{ $existingStatus == 'permission' ? 'checked' : '' }}
                                            class="sr-only peer status-radio" data-status="permission">
                                        <span class="w-8 h-8 lg:w-10 lg:h-10 rounded-full border-2 border-gray-200 flex items-center justify-center peer-checked:bg-purple-500 peer-checked:border-purple-500 peer-checked:text-white text-gray-400 transition-all duration-200 hover:border-purple-400">
                                            <i class="fas fa-envelope text-sm"></i>
                                        </span>
                                    </label>
                                </td>
                                <td class="px-3 lg:px-4 py-3 lg:py-4 text-center">
                                    <label class="inline-flex items-center justify-center cursor-pointer">
                                        <input type="radio" name="attendances[{{ $index }}][status]" value="absent" 
                                            {{ $existingStatus == 'absent' ? 'checked' : '' }}
                                            class="sr-only peer status-radio" data-status="absent">
                                        <span class="w-8 h-8 lg:w-10 lg:h-10 rounded-full border-2 border-gray-200 flex items-center justify-center peer-checked:bg-red-500 peer-checked:border-red-500 peer-checked:text-white text-gray-400 transition-all duration-200 hover:border-red-400">
                                            <i class="fas fa-times text-sm"></i>
                                        </span>
                                    </label>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Submit Button -->
                <div class="mt-4 sm:mt-6 flex flex-col sm:flex-row justify-end gap-2 sm:gap-4">
                    <a href="{{ route('classes.show', $class) }}" class="px-4 sm:px-6 py-2.5 sm:py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg sm:rounded-xl hover:bg-gray-200 transition-all duration-200 text-center text-sm sm:text-base">
                        Batal
                    </a>
                    <button type="submit" class="px-6 sm:px-8 py-2.5 sm:py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-lg sm:rounded-xl hover:from-teal-600 hover:to-teal-700 transition-all duration-200 shadow-lg hover:shadow-xl text-sm sm:text-base">
                        <i class="fas fa-save mr-2"></i>Simpan Presensi
                    </button>
                </div>
                @endif
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
function updateCounts() {
    const present = document.querySelectorAll('input[data-status="present"]:checked').length;
    const sick = document.querySelectorAll('input[data-status="sick"]:checked').length;
    const permission = document.querySelectorAll('input[data-status="permission"]:checked').length;
    const absent = document.querySelectorAll('input[data-status="absent"]:checked').length;
    
    document.getElementById('countPresent').textContent = present;
    document.getElementById('countSick').textContent = sick;
    document.getElementById('countPermission').textContent = permission;
    document.getElementById('countAbsent').textContent = absent;
}

function setAllStatus(status) {
    const radios = document.querySelectorAll(`input[data-status="${status}"]`);
    radios.forEach(radio => {
        radio.checked = true;
    });
    updateCounts();
}

// Add event listeners to all radio buttons
document.querySelectorAll('.status-radio').forEach(radio => {
    radio.addEventListener('change', updateCounts);
});

// Initial count
updateCounts();
</script>
@endpush
@endsection
