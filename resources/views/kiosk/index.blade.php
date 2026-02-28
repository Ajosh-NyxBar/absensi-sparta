<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QR Code Presensi Guru - {{ setting('school_name', 'SMPN 4 Purwakarta') }}</title>
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            cursor: default;
        }
        
        body {
            overflow: hidden;
            user-select: none;
        }
        
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
        
        .teacher-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .teacher-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }
        
        .teacher-card:active {
            transform: scale(0.98);
        }
        
        /* Clock style */
        .clock {
            font-family: 'Courier New', monospace;
            font-variant-numeric: tabular-nums;
        }
        
        /* Status badge animation */
        @keyframes pulse-green {
            0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            50% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
        }
        
        .status-attended {
            animation: pulse-green 2s infinite;
        }
        
        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="h-full animated-gradient">
    <div id="app" class="h-full flex flex-col p-6">
        <!-- Header -->
        <header class="flex-shrink-0 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                        <span class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">S</span>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white">{{ setting('school_name', 'SMPN 4 Purwakarta') }}</h1>
                        <p class="text-white/80 text-lg">Sistem Presensi Guru</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="clock text-5xl font-bold text-white" id="clock">--:--:--</div>
                    <div class="text-white/80 text-lg" id="date">Memuat...</div>
                </div>
            </div>
        </header>

        <!-- Attendance Summary -->
        <div class="flex-shrink-0 mb-6">
            <div class="grid grid-cols-5 gap-4">
                <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-4 text-center">
                    <div class="text-4xl font-bold text-white" id="totalTeachers">-</div>
                    <div class="text-white/80">Total Guru</div>
                </div>
                <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-4 text-center">
                    <div class="text-4xl font-bold text-green-300" id="attendedTeachers">-</div>
                    <div class="text-white/80">Sudah Hadir</div>
                </div>
                <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-4 text-center">
                    <div class="text-4xl font-bold text-yellow-300" id="notAttendedTeachers">-</div>
                    <div class="text-white/80">Belum Hadir</div>
                </div>
                <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-4 text-center">
                    <div class="text-4xl font-bold text-blue-300" id="onTimeTeachers">-</div>
                    <div class="text-white/80">Tepat Waktu</div>
                </div>
                <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-4 text-center">
                    <div class="text-4xl font-bold text-orange-300" id="lateTeachers">-</div>
                    <div class="text-white/80">Terlambat</div>
                </div>
            </div>
        </div>

        <!-- Main Content - Teacher Selection -->
        <main class="flex-1 overflow-hidden">
            <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-6 h-full flex flex-col">
                <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                    <i class="fas fa-qrcode mr-3"></i>
                    Pilih Nama Anda untuk Menampilkan QR Code
                </h2>
                
                <!-- Search Box -->
                <div class="mb-4 flex-shrink-0">
                    <div class="relative">
                        <input type="text" 
                               id="searchTeacher" 
                               placeholder="Cari nama guru..."
                               class="w-full px-6 py-4 pl-14 text-lg bg-white/20 backdrop-blur border border-white/30 rounded-2xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent">
                        <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-white/60 text-xl"></i>
                    </div>
                </div>
                
                <!-- Teacher Grid -->
                <div class="flex-1 overflow-y-auto" id="teacherContainer">
                    <div class="grid grid-cols-4 gap-4" id="teacherGrid">
                        @foreach($teachers as $teacher)
                        <div class="teacher-card bg-white/20 backdrop-blur-lg rounded-2xl p-4 cursor-pointer hover:bg-white/30 border border-white/10"
                             data-teacher-id="{{ $teacher->id }}"
                             data-teacher-name="{{ strtolower($teacher->name) }}"
                             onclick="showTeacherQR({{ $teacher->id }}, '{{ $teacher->name }}', '{{ $teacher->nip }}')">
                            <div class="flex items-center">
                                <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center mr-3 flex-shrink-0">
                                    <span class="text-2xl font-bold text-white">{{ strtoupper(substr($teacher->name, 0, 1)) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-white truncate">{{ $teacher->name }}</h3>
                                    <p class="text-white/60 text-sm">{{ $teacher->nip ?? '-' }}</p>
                                </div>
                                <div class="ml-2 attendance-status" id="status-{{ $teacher->id }}">
                                    <span class="w-3 h-3 rounded-full bg-gray-400 inline-block"></span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="flex-shrink-0 mt-4 text-center text-white/60 text-sm">
            <p>Scan QR Code dengan aplikasi di HP Anda untuk melakukan presensi</p>
        </footer>
    </div>

    <!-- QR Code Modal -->
    <div id="qrModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm hidden items-center justify-center z-50" onclick="closeModal(event)">
        <div class="bg-white rounded-3xl p-8 max-w-lg w-full mx-4 transform transition-all" onclick="event.stopPropagation()">
            <!-- Header -->
            <div class="text-center mb-6">
                <div class="w-20 h-20 mx-auto bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mb-4">
                    <span class="text-4xl font-bold text-white" id="modalInitial">-</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-800" id="modalTeacherName">-</h3>
                <p class="text-gray-500" id="modalTeacherNIP">-</p>
            </div>
            
            <!-- QR Code -->
            <div class="bg-gray-100 rounded-2xl p-6 mb-6">
                <div class="flex items-center justify-center min-h-[350px]" id="qrCodeContainer">
                    <div class="text-center text-gray-400">
                        <i class="fas fa-spinner fa-spin text-4xl mb-2"></i>
                        <p>Memuat QR Code...</p>
                    </div>
                </div>
            </div>
            
            <!-- Timer & Status -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center text-gray-600">
                    <i class="fas fa-clock mr-2"></i>
                    <span>QR berlaku:</span>
                    <span class="font-bold text-indigo-600 ml-2" id="qrTimer">60</span>
                    <span class="ml-1">detik</span>
                </div>
                <div id="attendanceStatusBadge" class="px-4 py-2 rounded-full text-sm font-medium">
                    <span class="text-gray-500">Memuat status...</span>
                </div>
            </div>
            
            <!-- Instructions -->
            <div class="bg-indigo-50 rounded-xl p-4 mb-6">
                <h4 class="font-semibold text-indigo-800 mb-2">
                    <i class="fas fa-info-circle mr-2"></i>
                    Cara Presensi:
                </h4>
                <ol class="text-indigo-700 text-sm space-y-1">
                    <li>1. Buka aplikasi presensi di HP Anda</li>
                    <li>2. Login dengan akun Anda</li>
                    <li>3. Scan QR Code di atas</li>
                    <li>4. Presensi akan tercatat otomatis</li>
                </ol>
            </div>
            
            <!-- Close Button -->
            <button onclick="closeQRModal()" 
                    class="w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar Guru
            </button>
        </div>
    </div>

    <script>
        let qrRefreshInterval = null;
        let timerInterval = null;
        let currentTeacherId = null;
        let timerSeconds = 60;

        // Clock
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            const dateString = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            
            document.getElementById('clock').textContent = timeString;
            document.getElementById('date').textContent = dateString;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Load summary
        function loadSummary() {
            fetch('/kiosk/api/summary')
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('totalTeachers').textContent = data.summary.total;
                        document.getElementById('attendedTeachers').textContent = data.summary.attended;
                        document.getElementById('notAttendedTeachers').textContent = data.summary.not_attended;
                        document.getElementById('onTimeTeachers').textContent = data.summary.on_time;
                        document.getElementById('lateTeachers').textContent = data.summary.late;
                        
                        // Update individual status badges
                        updateAllTeacherStatuses();
                    }
                })
                .catch(err => console.error('Error loading summary:', err));
        }
        setInterval(loadSummary, 30000); // Refresh every 30 seconds
        loadSummary();

        // Update all teacher statuses
        function updateAllTeacherStatuses() {
            document.querySelectorAll('[data-teacher-id]').forEach(card => {
                const teacherId = card.dataset.teacherId;
                fetch(`/kiosk/api/status/${teacherId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            const statusEl = document.getElementById(`status-${teacherId}`);
                            if (data.attendance.has_attendance) {
                                if (data.attendance.check_out) {
                                    statusEl.innerHTML = '<span class="w-3 h-3 rounded-full bg-blue-400 inline-block" title="Selesai"></span>';
                                } else if (data.attendance.status === 'present') {
                                    statusEl.innerHTML = '<span class="w-3 h-3 rounded-full bg-green-400 inline-block status-attended" title="Hadir - Tepat Waktu"></span>';
                                } else {
                                    statusEl.innerHTML = '<span class="w-3 h-3 rounded-full bg-yellow-400 inline-block status-attended" title="Hadir - Terlambat"></span>';
                                }
                            } else {
                                statusEl.innerHTML = '<span class="w-3 h-3 rounded-full bg-gray-400 inline-block" title="Belum Absen"></span>';
                            }
                        }
                    })
                    .catch(err => {});
            });
        }

        // Search functionality
        document.getElementById('searchTeacher').addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            document.querySelectorAll('[data-teacher-id]').forEach(card => {
                const name = card.dataset.teacherName;
                if (name.includes(query)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Show QR Modal
        function showTeacherQR(teacherId, teacherName, teacherNIP) {
            currentTeacherId = teacherId;
            
            // Update modal content
            document.getElementById('modalInitial').textContent = teacherName.charAt(0).toUpperCase();
            document.getElementById('modalTeacherName').textContent = teacherName;
            document.getElementById('modalTeacherNIP').textContent = 'NIP: ' + (teacherNIP || '-');
            
            // Show modal
            const modal = document.getElementById('qrModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Load QR code
            loadQRCode(teacherId);
            
            // Start refresh interval
            qrRefreshInterval = setInterval(() => loadQRCode(teacherId), 60000);
            
            // Load attendance status
            loadAttendanceStatus(teacherId);
        }

        function loadQRCode(teacherId) {
            const container = document.getElementById('qrCodeContainer');
            container.innerHTML = `
                <div class="text-center text-gray-400">
                    <i class="fas fa-spinner fa-spin text-4xl mb-2"></i>
                    <p>Memuat QR Code...</p>
                </div>
            `;
            
            // Reset timer
            timerSeconds = 60;
            document.getElementById('qrTimer').textContent = timerSeconds;
            
            // Clear existing timer
            if (timerInterval) clearInterval(timerInterval);
            
            fetch(`/kiosk/api/qr/${teacherId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        container.innerHTML = data.qrCode;
                        // Start countdown timer
                        timerInterval = setInterval(() => {
                            timerSeconds--;
                            document.getElementById('qrTimer').textContent = timerSeconds;
                            if (timerSeconds <= 0) {
                                loadQRCode(teacherId);
                            }
                        }, 1000);
                    } else {
                        container.innerHTML = `
                            <div class="text-center text-red-500">
                                <i class="fas fa-exclamation-circle text-4xl mb-2"></i>
                                <p>${data.message}</p>
                            </div>
                        `;
                    }
                })
                .catch(err => {
                    container.innerHTML = `
                        <div class="text-center text-red-500">
                            <i class="fas fa-exclamation-circle text-4xl mb-2"></i>
                            <p>Gagal memuat QR Code</p>
                        </div>
                    `;
                });
        }

        function loadAttendanceStatus(teacherId) {
            const badge = document.getElementById('attendanceStatusBadge');
            
            fetch(`/kiosk/api/status/${teacherId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const att = data.attendance;
                        if (att.has_attendance) {
                            if (att.check_out) {
                                badge.className = 'px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-700';
                                badge.innerHTML = `<i class="fas fa-check-double mr-1"></i> Selesai (${att.check_in} - ${att.check_out})`;
                            } else if (att.status === 'present') {
                                badge.className = 'px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-700';
                                badge.innerHTML = `<i class="fas fa-check mr-1"></i> Hadir ${att.check_in} (Tepat Waktu)`;
                            } else {
                                badge.className = 'px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-700';
                                badge.innerHTML = `<i class="fas fa-clock mr-1"></i> Hadir ${att.check_in} (Terlambat)`;
                            }
                        } else {
                            badge.className = 'px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-600';
                            badge.innerHTML = `<i class="fas fa-minus-circle mr-1"></i> Belum Absen`;
                        }
                    }
                })
                .catch(err => {
                    badge.className = 'px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-500';
                    badge.innerHTML = 'Tidak diketahui';
                });
        }

        function closeModal(event) {
            if (event.target === document.getElementById('qrModal')) {
                closeQRModal();
            }
        }

        function closeQRModal() {
            const modal = document.getElementById('qrModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            
            // Clear intervals
            if (qrRefreshInterval) clearInterval(qrRefreshInterval);
            if (timerInterval) clearInterval(timerInterval);
            
            currentTeacherId = null;
            
            // Refresh summary and statuses
            loadSummary();
        }

        // Prevent right-click context menu (kiosk mode)
        document.addEventListener('contextmenu', e => e.preventDefault());
        
        // Prevent keyboard shortcuts (kiosk mode)
        document.addEventListener('keydown', function(e) {
            // Allow F5 for refresh
            if (e.key === 'F5') return;
            // Block other function keys and ctrl combinations
            if (e.key.startsWith('F') || e.ctrlKey || e.altKey) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
