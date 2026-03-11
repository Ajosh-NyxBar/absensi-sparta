<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Scan Presensi - {{ setting('school_name', 'SMPN 4 Purwakarta') }}</title>
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- QR Scanner Library -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    
    <style>
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .animated-gradient {
            background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #667eea);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        
        #reader {
            width: 100% !important;
            border-radius: 1rem;
            overflow: hidden;
        }
        
        #reader video {
            border-radius: 1rem;
        }
        
        @keyframes success-pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        
        .success-animation {
            animation: success-pulse 0.5s ease-in-out 2;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        
        .error-animation {
            animation: shake 0.3s ease-in-out 2;
        }
    </style>
</head>
<body class="min-h-full animated-gradient">
    <div class="min-h-screen flex flex-col p-4 md:p-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="mr-4 w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-white hover:bg-white/30 transition-colors">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold text-white">Scan Presensi</h1>
                        <p class="text-white/70 text-sm">{{ Auth::user()->name ?? 'Guru' }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-white" id="clock">--:--</div>
                    <div class="text-white/70 text-sm" id="date">-</div>
                </div>
            </div>
        </header>
        
        <!-- Main Content -->
        <main class="flex-1 flex flex-col max-w-lg mx-auto w-full">
            <!-- Scanner Container -->
            <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-4 md:p-6 mb-4">
                <div class="mb-4 text-center">
                    <h2 class="text-lg font-semibold text-white mb-1">
                        <i class="fas fa-camera mr-2"></i>
                        Arahkan Kamera ke QR Code
                    </h2>
                    <p class="text-white/70 text-sm">Pastikan QR Code terlihat jelas di dalam kotak</p>
                </div>
                
                <!-- QR Reader -->
                <div id="reader" class="bg-black/20 rounded-2xl overflow-hidden mb-4"></div>
                
                <!-- Camera Controls -->
                <div class="flex justify-center gap-4">
                    <button onclick="switchCamera()" class="px-4 py-2 bg-white/20 text-white rounded-xl hover:bg-white/30 transition-colors">
                        <i class="fas fa-sync-alt mr-2"></i>
                        Ganti Kamera
                    </button>
                    <button onclick="toggleFlash()" id="flashBtn" class="px-4 py-2 bg-white/20 text-white rounded-xl hover:bg-white/30 transition-colors hidden">
                        <i class="fas fa-bolt mr-2"></i>
                        Flash
                    </button>
                </div>
            </div>
            
            <!-- Today's Attendance Status -->
            <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-4 md:p-6 mb-4">
                <h3 class="text-white font-semibold mb-3">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Status Presensi Hari Ini
                </h3>
                <div id="attendanceStatus" class="bg-white/10 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white/70 text-sm">Check-in</p>
                            <p class="text-white font-semibold" id="checkInTime">-</p>
                        </div>
                        <div class="text-center">
                            <p class="text-white/70 text-sm">Status</p>
                            <p class="font-semibold" id="statusText">Belum Absen</p>
                        </div>
                        <div class="text-right">
                            <p class="text-white/70 text-sm">Check-out</p>
                            <p class="text-white font-semibold" id="checkOutTime">-</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Instructions -->
            <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-4 md:p-6">
                <h3 class="text-white font-semibold mb-3">
                    <i class="fas fa-info-circle mr-2"></i>
                    Petunjuk
                </h3>
                <ul class="text-white/80 text-sm space-y-2">
                    <li class="flex items-start">
                        <span class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center mr-2 flex-shrink-0 text-xs">1</span>
                        <span>Pilih nama Anda di monitor ruang guru</span>
                    </li>
                    <li class="flex items-start">
                        <span class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center mr-2 flex-shrink-0 text-xs">2</span>
                        <span>Arahkan kamera HP ke QR Code yang tampil</span>
                    </li>
                    <li class="flex items-start">
                        <span class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center mr-2 flex-shrink-0 text-xs">3</span>
                        <span>Presensi akan tercatat otomatis</span>
                    </li>
                </ul>
            </div>
        </main>
    </div>
    
    <!-- Result Modal -->
    <div id="resultModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl p-6 max-w-sm w-full transform transition-all" id="resultContent">
            <!-- Will be populated by JavaScript -->
        </div>
    </div>

    <script>
        let html5QrCode = null;
        let currentCameraId = null;
        let cameras = [];
        let isScanning = false;
        
        // Clock
        function updateClock() {
            const now = new Date();
            document.getElementById('clock').textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            document.getElementById('date').textContent = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'short', year: 'numeric' });
        }
        setInterval(updateClock, 1000);
        updateClock();
        
        // Load current attendance status
        function loadMyAttendanceStatus() {
            fetch('/api/attendance/my-status')
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.attendance) {
                        const att = data.attendance;
                        document.getElementById('checkInTime').textContent = att.check_in || '-';
                        document.getElementById('checkOutTime').textContent = att.check_out || '-';
                        
                        const statusEl = document.getElementById('statusText');
                        if (att.check_out) {
                            statusEl.textContent = 'Selesai';
                            statusEl.className = 'font-semibold text-blue-300';
                        } else if (att.status === 'present') {
                            statusEl.textContent = 'Tepat Waktu';
                            statusEl.className = 'font-semibold text-green-300';
                        } else if (att.status === 'late') {
                            statusEl.textContent = 'Terlambat';
                            statusEl.className = 'font-semibold text-yellow-300';
                        } else {
                            statusEl.textContent = 'Belum Absen';
                            statusEl.className = 'font-semibold text-gray-300';
                        }
                    }
                })
                .catch(err => console.error('Error loading status:', err));
        }
        loadMyAttendanceStatus();
        
        // Initialize QR Scanner
        async function initScanner() {
            try {
                cameras = await Html5Qrcode.getCameras();
                
                if (cameras && cameras.length > 0) {
                    // Prefer back camera
                    currentCameraId = cameras.find(c => c.label.toLowerCase().includes('back'))?.id || cameras[0].id;
                    startScanning(currentCameraId);
                } else {
                    document.getElementById('reader').innerHTML = `
                        <div class="p-8 text-center text-white">
                            <i class="fas fa-video-slash text-4xl mb-4"></i>
                            <p>Kamera tidak ditemukan</p>
                            <p class="text-sm text-white/70 mt-2">Pastikan browser memiliki izin akses kamera</p>
                        </div>
                    `;
                }
            } catch (err) {
                console.error('Error getting cameras:', err);
                document.getElementById('reader').innerHTML = `
                    <div class="p-8 text-center text-white">
                        <i class="fas fa-exclamation-triangle text-4xl mb-4"></i>
                        <p>Gagal mengakses kamera</p>
                        <p class="text-sm text-white/70 mt-2">${err.message}</p>
                    </div>
                `;
            }
        }
        
        function startScanning(cameraId) {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    html5QrCode = null;
                    startNewScanner(cameraId);
                }).catch(err => {
                    startNewScanner(cameraId);
                });
            } else {
                startNewScanner(cameraId);
            }
        }
        
        function startNewScanner(cameraId) {
            html5QrCode = new Html5Qrcode("reader");
            
            html5QrCode.start(
                cameraId,
                {
                    fps: 10,
                    qrbox: { width: 250, height: 250 },
                    aspectRatio: 1.0
                },
                onScanSuccess,
                onScanError
            ).then(() => {
                isScanning = true;
            }).catch(err => {
                console.error('Error starting scanner:', err);
            });
        }
        
        function onScanSuccess(decodedText, decodedResult) {
            if (isScanning) {
                isScanning = false;
                processQRCode(decodedText);
            }
        }
        
        function onScanError(errorMessage) {
            // Ignore scan errors (they happen when no QR is in view)
        }
        
        function processQRCode(qrData) {
            // Show loading
            showResult('loading', 'Memproses...', 'Mengambil lokasi GPS...');
            
            // Get GPS location first, then send to server
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        sendScanData(qrData, position.coords.latitude, position.coords.longitude);
                    },
                    function(error) {
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
                        showResult('error', 'Gagal Mendapatkan Lokasi', errorMsg);
                        isScanning = true;
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                );
            } else {
                showResult('error', 'GPS Tidak Didukung', 'Browser Anda tidak mendukung Geolocation.');
                isScanning = true;
            }
        }
        
        function sendScanData(qrData, latitude, longitude) {
            showResult('loading', 'Memproses...', 'Memvalidasi lokasi dan QR Code...');
            
            fetch('/kiosk/api/scan', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ 
                    qr_data: qrData,
                    latitude: latitude,
                    longitude: longitude
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const action = data.action === 'check-in' ? 'Check-in' : 'Check-out';
                    showResult('success', `${action} Berhasil!`, data.message, data.data);
                    loadMyAttendanceStatus();
                } else {
                    showResult('error', 'Gagal', data.message);
                }
            })
            .catch(err => {
                showResult('error', 'Error', 'Terjadi kesalahan. Silakan coba lagi.');
            });
        }
        
        function showResult(type, title, message, data = null) {
            const modal = document.getElementById('resultModal');
            const content = document.getElementById('resultContent');
            
            let html = '';
            
            if (type === 'loading') {
                html = `
                    <div class="text-center py-8">
                        <div class="w-16 h-16 mx-auto bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-spinner fa-spin text-3xl text-indigo-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">${title}</h3>
                        <p class="text-gray-600">${message}</p>
                    </div>
                `;
            } else if (type === 'success') {
                html = `
                    <div class="text-center success-animation">
                        <div class="w-20 h-20 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-check text-4xl text-green-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">${title}</h3>
                        <p class="text-gray-600 mb-4">${message}</p>
                        ${data ? `
                            <div class="bg-gray-50 rounded-xl p-4 text-left mb-4">
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    ${data.teacher_name ? `<p class="text-gray-500">Nama</p><p class="font-medium text-gray-800">${data.teacher_name}</p>` : ''}
                                    ${data.check_in ? `<p class="text-gray-500">Check-in</p><p class="font-medium text-gray-800">${data.check_in}</p>` : ''}
                                    ${data.check_out ? `<p class="text-gray-500">Check-out</p><p class="font-medium text-gray-800">${data.check_out}</p>` : ''}
                                    ${data.status ? `<p class="text-gray-500">Status</p><p class="font-medium ${data.status_class === 'success' ? 'text-green-600' : 'text-yellow-600'}">${data.status}</p>` : ''}
                                    ${data.duration ? `<p class="text-gray-500">Durasi</p><p class="font-medium text-gray-800">${data.duration}</p>` : ''}
                                </div>
                            </div>
                        ` : ''}
                        <button onclick="closeResultModal()" class="w-full py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-colors">
                            <i class="fas fa-check mr-2"></i>OK
                        </button>
                    </div>
                `;
            } else if (type === 'error') {
                html = `
                    <div class="text-center error-animation">
                        <div class="w-20 h-20 mx-auto bg-red-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-times text-4xl text-red-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">${title}</h3>
                        <p class="text-gray-600 mb-6">${message}</p>
                        <button onclick="closeResultModal()" class="w-full py-3 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition-colors">
                            <i class="fas fa-redo mr-2"></i>Coba Lagi
                        </button>
                    </div>
                `;
            }
            
            content.innerHTML = html;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        
        function closeResultModal() {
            const modal = document.getElementById('resultModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            
            // Resume scanning
            isScanning = true;
        }
        
        function switchCamera() {
            if (cameras.length > 1) {
                const currentIndex = cameras.findIndex(c => c.id === currentCameraId);
                const nextIndex = (currentIndex + 1) % cameras.length;
                currentCameraId = cameras[nextIndex].id;
                startScanning(currentCameraId);
            }
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', initScanner);
    </script>
</body>
</html>
