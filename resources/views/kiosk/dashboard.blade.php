<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QR Code Presensi Guru - {{ setting('school_name', 'SMPN 4 Purwakarta') }}</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * { cursor: default; }
        body { 
            margin: 0; 
            padding: 0; 
            min-height: 100vh;
            background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #667eea);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            font-family: system-ui, -apple-system, sans-serif;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .clock {
            font-family: 'Courier New', monospace;
            font-variant-numeric: tabular-nums;
        }
        
        .teacher-card {
            transition: all 0.3s ease;
        }
        .teacher-card:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        
        .scrollable {
            overflow-y: auto;
            max-height: calc(100vh - 380px);
        }
        .scrollable::-webkit-scrollbar { width: 8px; }
        .scrollable::-webkit-scrollbar-track { background: rgba(255,255,255,0.1); border-radius: 10px; }
        .scrollable::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 10px; }
        
        @keyframes pulse-green {
            0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            50% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
        }
        .status-attended { animation: pulse-green 2s infinite; }
    </style>
</head>
<body>
    <div style="min-height: 100vh; display: flex; flex-direction: column; padding: 24px;">
        
        <!-- Header -->
        <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-shrink: 0;">
            <div style="display: flex; align-items: center;">
                <div style="width: 60px; height: 60px; background: white; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-right: 16px; box-shadow: 0 10px 20px rgba(0,0,0,0.2);">
                    <span style="font-size: 32px; font-weight: bold; background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">S</span>
                </div>
                <div>
                    <h1 style="color: white; font-size: 28px; font-weight: bold; margin: 0;">{{ setting('school_name', 'SMPN 4 Purwakarta') }}</h1>
                    <p style="color: rgba(255,255,255,0.8); margin: 0;">Sistem Presensi Guru</p>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 24px;">
                <div style="text-align: right;">
                    <div class="clock" style="font-size: 48px; font-weight: bold; color: white;" id="clock">--:--:--</div>
                    <div style="color: rgba(255,255,255,0.8); font-size: 16px;" id="date">Memuat...</div>
                </div>
                <form action="{{ route('kiosk.logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" style="width: 44px; height: 44px; background: rgba(255,255,255,0.2); border: none; border-radius: 12px; color: white; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </header>

        <!-- Summary Stats -->
        <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 16px; margin-bottom: 20px; flex-shrink: 0;">
            <div style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border-radius: 16px; padding: 20px; text-align: center;">
                <div style="font-size: 36px; font-weight: bold; color: white;" id="totalTeachers">{{ $teachers->count() }}</div>
                <div style="color: rgba(255,255,255,0.8);">Total Guru</div>
            </div>
            <div style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border-radius: 16px; padding: 20px; text-align: center;">
                <div style="font-size: 36px; font-weight: bold; color: #86efac;" id="attendedTeachers">0</div>
                <div style="color: rgba(255,255,255,0.8);">Sudah Hadir</div>
            </div>
            <div style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border-radius: 16px; padding: 20px; text-align: center;">
                <div style="font-size: 36px; font-weight: bold; color: #fde047;" id="notAttendedTeachers">{{ $teachers->count() }}</div>
                <div style="color: rgba(255,255,255,0.8);">Belum Hadir</div>
            </div>
            <div style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border-radius: 16px; padding: 20px; text-align: center;">
                <div style="font-size: 36px; font-weight: bold; color: #93c5fd;" id="onTimeTeachers">0</div>
                <div style="color: rgba(255,255,255,0.8);">Tepat Waktu</div>
            </div>
            <div style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border-radius: 16px; padding: 20px; text-align: center;">
                <div style="font-size: 36px; font-weight: bold; color: #fdba74;" id="lateTeachers">0</div>
                <div style="color: rgba(255,255,255,0.8);">Terlambat</div>
            </div>
        </div>

        <!-- Main Content -->
        <main style="flex: 1; display: flex; flex-direction: column; min-height: 0;">
            <div style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border-radius: 24px; padding: 24px; flex: 1; display: flex; flex-direction: column; min-height: 0;">
                
                <h2 style="color: white; font-size: 22px; font-weight: bold; margin: 0 0 16px 0; display: flex; align-items: center; flex-shrink: 0;">
                    <i class="fas fa-qrcode" style="margin-right: 12px;"></i>
                    Pilih Nama Anda untuk Menampilkan QR Code
                </h2>
                
                <!-- Search -->
                <div style="margin-bottom: 16px; flex-shrink: 0;">
                    <div style="position: relative;">
                        <input type="text" id="searchTeacher" placeholder="Cari nama guru..." 
                               style="width: 100%; padding: 16px 16px 16px 50px; font-size: 16px; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); border-radius: 16px; color: white; outline: none; box-sizing: border-box;">
                        <i class="fas fa-search" style="position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.6);"></i>
                    </div>
                </div>
                
                <!-- Teacher Grid -->
                <div class="scrollable" id="teacherContainer" style="flex: 1;">
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;" id="teacherGrid">
                        @foreach($teachers as $teacher)
                        <div class="teacher-card" 
                             data-teacher-id="{{ $teacher->id }}"
                             data-teacher-name="{{ strtolower($teacher->name) }}"
                             onclick="showTeacherQR({{ $teacher->id }}, '{{ addslashes($teacher->name) }}', '{{ $teacher->nip }}')"
                             style="background: rgba(255,255,255,0.2); border-radius: 16px; padding: 16px; cursor: pointer; border: 1px solid rgba(255,255,255,0.1);">
                            <div style="display: flex; align-items: center;">
                                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
                                    <span style="font-size: 22px; font-weight: bold; color: white;">{{ strtoupper(substr($teacher->name, 0, 1)) }}</span>
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <h3 style="color: white; font-weight: 600; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $teacher->name }}</h3>
                                    <p style="color: rgba(255,255,255,0.6); font-size: 14px; margin: 4px 0 0 0;">{{ $teacher->nip ?? '-' }}</p>
                                </div>
                                <div id="status-{{ $teacher->id }}" style="margin-left: 8px;">
                                    <span style="width: 12px; height: 12px; border-radius: 50%; background: #9ca3af; display: inline-block;"></span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer style="text-align: center; color: rgba(255,255,255,0.6); font-size: 14px; margin-top: 16px; flex-shrink: 0;">
            <p style="margin: 0;">Scan QR Code dengan aplikasi di HP Anda untuk melakukan presensi</p>
            <p style="margin: 4px 0 0 0;">Login sebagai: <strong style="color: rgba(255,255,255,0.9);">{{ Auth::user()->name }}</strong></p>
        </footer>
    </div>

    <!-- QR Modal -->
    <div id="qrModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); backdrop-filter: blur(5px); z-index: 1000; align-items: center; justify-content: center;" onclick="closeModal(event)">
        <div style="background: white; border-radius: 24px; padding: 32px; max-width: 480px; width: 90%; max-height: 90vh; overflow-y: auto;" onclick="event.stopPropagation()">
            <!-- Modal Header -->
            <div style="text-align: center; margin-bottom: 24px;">
                <div style="width: 80px; height: 80px; margin: 0 auto 16px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                    <span id="modalInitial" style="font-size: 36px; font-weight: bold; color: white;">-</span>
                </div>
                <h3 id="modalTeacherName" style="font-size: 24px; font-weight: bold; color: #1f2937; margin: 0;">-</h3>
                <p id="modalTeacherNIP" style="color: #6b7280; margin: 4px 0 0 0;">-</p>
            </div>
            
            <!-- QR Code -->
            <div style="background: #f3f4f6; border-radius: 16px; padding: 24px; margin-bottom: 24px;">
                <div id="qrCodeContainer" style="display: flex; align-items: center; justify-content: center; min-height: 300px;">
                    <div style="text-align: center; color: #9ca3af;">
                        <i class="fas fa-spinner fa-spin" style="font-size: 40px; margin-bottom: 8px;"></i>
                        <p>Memuat QR Code...</p>
                    </div>
                </div>
            </div>
            
            <!-- Timer & Status -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <div style="display: flex; align-items: center; color: #4b5563;">
                    <i class="fas fa-clock" style="margin-right: 8px;"></i>
                    <span>QR berlaku: <strong id="qrTimer" style="color: #667eea;">60</strong> detik</span>
                </div>
                <div id="attendanceStatusBadge" style="padding: 8px 16px; border-radius: 20px; font-size: 14px; background: #f3f4f6; color: #6b7280;">
                    Memuat status...
                </div>
            </div>
            
            <!-- Instructions -->
            <div style="background: #eef2ff; border-radius: 12px; padding: 16px; margin-bottom: 24px;">
                <h4 style="font-weight: 600; color: #4338ca; margin: 0 0 8px 0;">
                    <i class="fas fa-info-circle" style="margin-right: 8px;"></i>Cara Presensi:
                </h4>
                <ol style="margin: 0; padding-left: 20px; color: #6366f1; font-size: 14px;">
                    <li>Buka aplikasi presensi di HP Anda</li>
                    <li>Login dengan akun Anda</li>
                    <li>Scan QR Code di atas</li>
                    <li>Presensi akan tercatat otomatis</li>
                </ol>
            </div>
            
            <!-- Close Button -->
            <button onclick="closeQRModal()" style="width: 100%; padding: 16px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none; border-radius: 12px; font-size: 16px; font-weight: 600; cursor: pointer;">
                <i class="fas fa-arrow-left" style="margin-right: 8px;"></i>Kembali ke Daftar Guru
            </button>
        </div>
    </div>

    <script>
        let qrRefreshInterval = null;
        let timerInterval = null;
        let timerSeconds = 60;

        // Clock
        function updateClock() {
            const now = new Date();
            document.getElementById('clock').textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            document.getElementById('date').textContent = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
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
                    }
                })
                .catch(err => console.error('Error:', err));
        }
        setInterval(loadSummary, 30000);
        loadSummary();

        // Search
        document.getElementById('searchTeacher').addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            document.querySelectorAll('[data-teacher-id]').forEach(card => {
                card.style.display = card.dataset.teacherName.includes(query) ? 'block' : 'none';
            });
        });

        // Show QR Modal
        function showTeacherQR(teacherId, teacherName, teacherNIP) {
            document.getElementById('modalInitial').textContent = teacherName.charAt(0).toUpperCase();
            document.getElementById('modalTeacherName').textContent = teacherName;
            document.getElementById('modalTeacherNIP').textContent = 'NIP: ' + (teacherNIP || '-');
            
            const modal = document.getElementById('qrModal');
            modal.style.display = 'flex';
            
            loadQRCode(teacherId);
            qrRefreshInterval = setInterval(() => loadQRCode(teacherId), 60000);
            loadAttendanceStatus(teacherId);
        }

        function loadQRCode(teacherId) {
            const container = document.getElementById('qrCodeContainer');
            container.innerHTML = '<div style="text-align: center; color: #9ca3af;"><i class="fas fa-spinner fa-spin" style="font-size: 40px;"></i><p>Memuat...</p></div>';
            
            timerSeconds = 60;
            document.getElementById('qrTimer').textContent = timerSeconds;
            if (timerInterval) clearInterval(timerInterval);
            
            fetch('/kiosk/api/qr/' + teacherId)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        container.innerHTML = data.qrCode;
                        timerInterval = setInterval(() => {
                            timerSeconds--;
                            document.getElementById('qrTimer').textContent = timerSeconds;
                            if (timerSeconds <= 0) loadQRCode(teacherId);
                        }, 1000);
                    } else {
                        container.innerHTML = '<div style="text-align: center; color: #ef4444;"><i class="fas fa-exclamation-circle" style="font-size: 40px;"></i><p>' + data.message + '</p></div>';
                    }
                })
                .catch(err => {
                    container.innerHTML = '<div style="text-align: center; color: #ef4444;"><i class="fas fa-exclamation-circle" style="font-size: 40px;"></i><p>Gagal memuat QR</p></div>';
                });
        }

        function loadAttendanceStatus(teacherId) {
            const badge = document.getElementById('attendanceStatusBadge');
            fetch('/kiosk/api/status/' + teacherId)
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.attendance.has_attendance) {
                        const att = data.attendance;
                        if (att.check_out) {
                            badge.style.background = '#dbeafe';
                            badge.style.color = '#1d4ed8';
                            badge.innerHTML = '<i class="fas fa-check-double"></i> Selesai (' + att.check_in + ' - ' + att.check_out + ')';
                        } else if (att.status === 'present') {
                            badge.style.background = '#dcfce7';
                            badge.style.color = '#16a34a';
                            badge.innerHTML = '<i class="fas fa-check"></i> Hadir ' + att.check_in + ' (Tepat Waktu)';
                        } else {
                            badge.style.background = '#fef3c7';
                            badge.style.color = '#d97706';
                            badge.innerHTML = '<i class="fas fa-clock"></i> Hadir ' + att.check_in + ' (Terlambat)';
                        }
                    } else {
                        badge.style.background = '#f3f4f6';
                        badge.style.color = '#6b7280';
                        badge.innerHTML = '<i class="fas fa-minus-circle"></i> Belum Absen';
                    }
                });
        }

        function closeModal(event) {
            if (event.target.id === 'qrModal') closeQRModal();
        }

        function closeQRModal() {
            document.getElementById('qrModal').style.display = 'none';
            if (qrRefreshInterval) clearInterval(qrRefreshInterval);
            if (timerInterval) clearInterval(timerInterval);
            loadSummary();
        }

        // Prevent context menu
        document.addEventListener('contextmenu', e => e.preventDefault());
    </script>
</body>
</html>
