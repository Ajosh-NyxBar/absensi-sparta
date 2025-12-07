@extends('layouts.modern')

@section('title', 'Scan QR Code Presensi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-teal-600 bg-clip-text text-transparent">
                Presensi QR Code
            </h1>
            <p class="text-gray-600 mt-1">Scan QR Code untuk check-in/check-out</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('attendances.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-300 hover:bg-gray-50 transition-all duration-200 shadow-sm">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    @php
        $todayAttendance = $teacher->attendances()->whereDate('date', today())->first();
    @endphp

    <!-- Status Card -->
    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl shadow-sm p-6 border border-blue-200">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-full flex items-center justify-center">
                <i class="fas fa-user-circle text-white text-2xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $teacher->name }}</h2>
                <p class="text-sm text-gray-600">NIP: {{ $teacher->nip }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- QR Code Section -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
            <div class="px-6 py-5 bg-gradient-to-r from-green-50 to-teal-50 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-qrcode text-green-600"></i>
                    QR Code Anda
                </h2>
            </div>
            
            <div class="p-8">
                <div class="text-center">
                    <!-- QR Code -->
                    <div class="inline-block p-6 bg-white border-4 border-gray-200 rounded-2xl shadow-lg mb-6">
                        {!! $qrCode !!}
                    </div>

                    <!-- Info -->
                    <div class="space-y-3">
                        <div class="flex items-center justify-center gap-2 text-sm text-gray-600">
                            <i class="fas fa-calendar text-green-600"></i>
                            <span>Tanggal: <span class="font-semibold">{{ now()->format('d M Y') }}</span></span>
                        </div>
                        <div class="flex items-center justify-center gap-2 text-sm text-gray-600">
                            <i class="fas fa-clock text-green-600"></i>
                            <span id="current-time" class="font-semibold">{{ now()->format('H:i:s') }}</span>
                        </div>
                    </div>

                    <!-- Refresh Button -->
                    <button onclick="location.reload()" class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-500 to-teal-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-teal-700 transition-all duration-200">
                        <i class="fas fa-sync-alt"></i>
                        Refresh QR Code
                    </button>
                </div>
            </div>
        </div>

        <!-- Status & Instructions -->
        <div class="space-y-6">
            <!-- Current Status -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                <div class="px-6 py-5 bg-gradient-to-r from-purple-50 to-purple-100 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-info-circle text-purple-600"></i>
                        Status Presensi Hari Ini
                    </h2>
                </div>
                
                <div class="p-6">
                    @if($todayAttendance && $todayAttendance->check_in)
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Check-in</p>
                                <p class="text-lg font-bold text-gray-900">{{ $todayAttendance->check_in->format('H:i:s') }}</p>
                            </div>
                        </div>

                        @if($todayAttendance->check_out)
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-sign-out-alt text-red-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Check-out</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $todayAttendance->check_out->format('H:i:s') }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-4 p-4 bg-yellow-50 rounded-xl border border-yellow-200">
                                <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                                <p class="text-sm text-yellow-800">Jangan lupa check-out saat pulang!</p>
                            </div>
                        @endif

                        <div class="mt-4 p-3 bg-gray-50 rounded-xl">
                            <p class="text-xs text-gray-600">Status: 
                                <span class="font-semibold text-gray-900">{{ $todayAttendance->status }}</span>
                            </p>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-exclamation-circle text-yellow-600 text-2xl"></i>
                            </div>
                            <p class="text-gray-600 mb-2">Belum melakukan check-in hari ini</p>
                            <p class="text-sm text-gray-500">Scan QR Code untuk check-in</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Instructions -->
            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl shadow-sm border border-blue-200 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-cyan-600">
                    <h3 class="text-sm font-bold text-white flex items-center gap-2">
                        <i class="fas fa-book-open"></i>
                        Cara Menggunakan
                    </h3>
                </div>
                <div class="p-5">
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center shrink-0">
                                <span class="text-blue-600 font-bold text-sm">1</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 mb-1">Tampilkan QR Code</p>
                                <p class="text-xs text-gray-600">Pastikan QR Code terlihat jelas</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center shrink-0">
                                <span class="text-blue-600 font-bold text-sm">2</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 mb-1">Scan di Scanner</p>
                                <p class="text-xs text-gray-600">Arahkan QR Code ke alat scanner</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center shrink-0">
                                <span class="text-blue-600 font-bold text-sm">3</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 mb-1">Tunggu Konfirmasi</p>
                                <p class="text-xs text-gray-600">Sistem akan merekam presensi Anda</p>
                            </div>
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
                            <span>Refresh QR Code jika sudah lebih dari 5 menit</span>
                        </li>
                        <li class="flex items-start gap-2 text-xs text-gray-600">
                            <i class="fas fa-check-circle text-amber-500 mt-0.5"></i>
                            <span>Pastikan koneksi internet stabil</span>
                        </li>
                        <li class="flex items-start gap-2 text-xs text-gray-600">
                            <i class="fas fa-check-circle text-amber-500 mt-0.5"></i>
                            <span>Check-out sebelum pulang</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Update current time every second
setInterval(function() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds}`;
}, 1000);

// Auto refresh QR Code every 5 minutes
setTimeout(function() {
    location.reload();
}, 5 * 60 * 1000);
</script>
@endpush
@endsection
