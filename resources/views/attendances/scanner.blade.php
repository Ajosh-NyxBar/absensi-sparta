@extends('layouts.modern')

@section('title', 'Scan QR Code')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                Scan QR Code Presensi
            </h1>
            <p class="text-gray-600 mt-1">Gunakan kamera untuk scan QR Code</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('attendances.index') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-300 hover:bg-gray-50 transition-all duration-200 shadow-sm">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Scanner Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Scanner Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/20 p-2.5 rounded-lg">
                            <i class="fas fa-qrcode text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-white">QR Code Scanner</h2>
                    </div>
                </div>

                <!-- Scanner Area -->
                <div class="p-8">
                    <!-- Loading State -->
                    <div id="scanner-loading" class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center" style="min-height: 400px;">
                        <div class="text-center text-white">
                            <i class="fas fa-qrcode text-6xl mb-4 opacity-50"></i>
                            <p class="text-lg font-semibold">Klik "Mulai Scan" untuk memulai</p>
                            <p class="text-sm mt-2 opacity-75">Pastikan izin kamera sudah diaktifkan</p>
                        </div>
                    </div>
                    
                    <!-- QR Reader Container -->
                    <div id="qr-reader" style="display: none;"></div>

                    <!-- Controls -->
                    <div class="mt-6 flex flex-col sm:flex-row gap-3">
                        <button id="start-scan" 
                                class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-play mr-2"></i>
                            Mulai Scan
                        </button>
                        <button id="stop-scan" 
                                class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-lg hover:shadow-xl" 
                                style="display: none;">
                            <i class="fas fa-stop mr-2"></i>
                            Berhenti
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Sidebar -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div id="status-card" class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-br from-gray-600 to-gray-700 px-6 py-4">
                    <div class="flex items-center gap-2">
                        <div class="bg-white/20 p-2 rounded-lg">
                            <i class="fas fa-info-circle text-white"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white">Status</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="text-center py-4">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-qrcode text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-600 text-sm">Belum ada hasil scan</p>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl shadow-lg border-2 border-indigo-200 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600">
                    <h3 class="text-sm font-bold text-white flex items-center gap-2">
                        <i class="fas fa-book-open"></i>
                        Cara Menggunakan
                    </h3>
                </div>
                <div class="p-5">
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center shrink-0">
                                <span class="text-indigo-600 font-bold text-sm">1</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 mb-1">Izinkan Akses Kamera</p>
                                <p class="text-xs text-gray-600">Klik "Allow" saat browser meminta akses kamera</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center shrink-0">
                                <span class="text-indigo-600 font-bold text-sm">2</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 mb-1">Klik Mulai Scan</p>
                                <p class="text-xs text-gray-600">Kamera akan aktif dan siap memindai</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center shrink-0">
                                <span class="text-indigo-600 font-bold text-sm">3</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 mb-1">Arahkan ke QR Code</p>
                                <p class="text-xs text-gray-600">Posisikan QR Code di dalam kotak putih</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center shrink-0">
                                <span class="text-indigo-600 font-bold text-sm">4</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 mb-1">Tunggu Proses</p>
                                <p class="text-xs text-gray-600">Sistem akan otomatis memproses presensi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips -->
            <div class="bg-gradient-to-br from-amber-50 to-yellow-50 rounded-2xl shadow-lg border-2 border-amber-200 overflow-hidden">
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
                            <span>Pastikan pencahayaan cukup</span>
                        </li>
                        <li class="flex items-start gap-2 text-xs text-gray-600">
                            <i class="fas fa-check-circle text-amber-500 mt-0.5"></i>
                            <span>Jaga jarak 20-30 cm dari QR Code</span>
                        </li>
                        <li class="flex items-start gap-2 text-xs text-gray-600">
                            <i class="fas fa-check-circle text-amber-500 mt-0.5"></i>
                            <span>Tahan kamera tetap stabil</span>
                        </li>
                        <li class="flex items-start gap-2 text-xs text-gray-600">
                            <i class="fas fa-check-circle text-amber-500 mt-0.5"></i>
                            <span>QR Code valid selama 10 menit</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include QR Scanner Library -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@push('scripts')
<script>
let html5QrCode = null;
let isScanning = false;

// Initialize scanner
function initScanner() {
    html5QrCode = new Html5Qrcode("qr-reader");
}

// Start scanning
document.getElementById('start-scan').addEventListener('click', function() {
    if (isScanning) return;

    // Hide loading, show scanner
    document.getElementById('scanner-loading').style.display = 'none';
    document.getElementById('qr-reader').style.display = 'block';

    const config = {
        fps: 10,
        qrbox: { width: 250, height: 250 },
        aspectRatio: 1.0
    };

    html5QrCode.start(
        { facingMode: "environment" }, // Use back camera
        config,
        onScanSuccess,
        onScanFailure
    ).then(() => {
        isScanning = true;
        document.getElementById('start-scan').style.display = 'none';
        document.getElementById('stop-scan').style.display = 'flex';
    }).catch(err => {
        console.error('Error starting scanner:', err);
        
        // Show loading again
        document.getElementById('scanner-loading').style.display = 'flex';
        document.getElementById('qr-reader').style.display = 'none';
        
        Swal.fire({
            icon: 'error',
            title: 'Gagal Mengakses Kamera',
            html: 'Pastikan Anda telah memberikan izin akses kamera.<br><small class="text-gray-600">' + err + '</small>',
            confirmButtonColor: '#6366f1',
        });
    });
});

// Stop scanning
document.getElementById('stop-scan').addEventListener('click', function() {
    if (!isScanning) return;

    html5QrCode.stop().then(() => {
        isScanning = false;
        document.getElementById('start-scan').style.display = 'flex';
        document.getElementById('stop-scan').style.display = 'none';
        document.getElementById('scanner-loading').style.display = 'flex';
        document.getElementById('qr-reader').style.display = 'none';
    }).catch(err => {
        console.error('Error stopping scanner:', err);
    });
});

// Handle successful scan
function onScanSuccess(decodedText, decodedResult) {
    // Stop scanning temporarily to prevent multiple scans
    if (isScanning) {
        html5QrCode.pause(true);
        
        // Show loading
        Swal.fire({
            title: 'Memproses...',
            html: 'Mengambil lokasi GPS dan memproses QR Code',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Get GPS location first, then send to server
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    // GPS success - send data with coordinates
                    sendScanData(decodedText, position.coords.latitude, position.coords.longitude);
                },
                function(error) {
                    // GPS failed
                    let errorMsg = 'Tidak dapat mengakses lokasi GPS.';
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            errorMsg = 'Izin lokasi ditolak. Aktifkan izin lokasi di pengaturan browser.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMsg = 'Informasi lokasi tidak tersedia.';
                            break;
                        case error.TIMEOUT:
                            errorMsg = 'Permintaan lokasi timeout. Silakan coba lagi.';
                            break;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Mendapatkan Lokasi',
                        text: errorMsg,
                        confirmButtonColor: '#ef4444',
                    });
                    if (isScanning) {
                        html5QrCode.resume();
                    }
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        } else {
            Swal.fire({
                icon: 'error',
                title: 'GPS Tidak Didukung',
                text: 'Browser Anda tidak mendukung Geolocation. Gunakan browser modern dengan HTTPS.',
                confirmButtonColor: '#ef4444',
            });
            if (isScanning) {
                html5QrCode.resume();
            }
        }
    }
}

// Send scan data with GPS coordinates to server
function sendScanData(qrData, latitude, longitude) {
    fetch('{{ route('attendances.scan-qr') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            qr_data: qrData,
            latitude: latitude,
            longitude: longitude
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update status card
            updateStatusCard(data);
            
            // Show success message
            Swal.fire({
                icon: 'success',
                title: data.message,
                html: formatSuccessMessage(data),
                confirmButtonColor: '#10b981',
                timer: 5000,
                timerProgressBar: true
            });

            // Stop scanner after successful scan
            setTimeout(() => {
                if (isScanning) {
                    document.getElementById('stop-scan').click();
                }
            }, 2000);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: data.message,
                confirmButtonColor: '#ef4444',
            });
            
            // Resume scanning
            if (isScanning) {
                html5QrCode.resume();
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: 'Gagal memproses QR Code. Silakan coba lagi.',
            confirmButtonColor: '#ef4444',
        });
        
        // Resume scanning
        if (isScanning) {
            html5QrCode.resume();
        }
    });
}

// Handle scan failure
function onScanFailure(error) {
    // Ignore scan failures (usually just means no QR code in view)
}

// Format success message
function formatSuccessMessage(data) {
    if (data.action === 'check-in') {
        return `
            <div class="text-left">
                <p class="mb-2"><strong>Guru:</strong> ${data.data.teacher_name}</p>
                <p class="mb-2"><strong>Check-in:</strong> ${data.data.check_in}</p>
                <p><strong>Status:</strong> <span class="badge bg-${data.data.status_class === 'success' ? 'green' : 'yellow'}-500 text-white px-2 py-1 rounded">${data.data.status}</span></p>
            </div>
        `;
    } else if (data.action === 'check-out') {
        return `
            <div class="text-left">
                <p class="mb-2"><strong>Guru:</strong> ${data.data.teacher_name}</p>
                <p class="mb-2"><strong>Check-in:</strong> ${data.data.check_in}</p>
                <p><strong>Check-out:</strong> ${data.data.check_out}</p>
            </div>
        `;
    }
    return '';
}

// Update status card
function updateStatusCard(data) {
    const statusCard = document.querySelector('#status-card .p-6');
    const iconClass = data.action === 'check-in' ? 'fa-sign-in-alt' : 'fa-sign-out-alt';
    const bgColor = data.action === 'check-in' ? 'bg-green-100' : 'bg-blue-100';
    const textColor = data.action === 'check-in' ? 'text-green-600' : 'text-blue-600';
    
    statusCard.innerHTML = `
        <div class="text-center py-4">
            <div class="w-16 h-16 ${bgColor} rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas ${iconClass} ${textColor} text-2xl"></i>
            </div>
            <p class="text-gray-900 font-semibold mb-1">${data.data.teacher_name}</p>
            <p class="text-sm text-gray-600">${data.message}</p>
            ${data.action === 'check-in' ? 
                `<p class="text-xs text-gray-500 mt-2">Waktu: ${data.data.check_in}</p>` :
                `<p class="text-xs text-gray-500 mt-2">Check-out: ${data.data.check_out}</p>`
            }
        </div>
    `;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initScanner();
});

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    if (html5QrCode && isScanning) {
        html5QrCode.stop();
    }
});
</script>
@endpush
@endsection
