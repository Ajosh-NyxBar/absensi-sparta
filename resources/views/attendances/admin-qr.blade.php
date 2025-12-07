@extends('layouts.modern')

@section('title', 'QR Code Presensi Guru')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                QR Code Presensi Guru
            </h1>
            <p class="text-gray-600 mt-1">Pilih guru untuk menampilkan QR Code presensi</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('attendances.index') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-300 hover:bg-gray-50 transition-all duration-200 shadow-sm">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Teacher Carousel Selection -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 relative">
        <!-- School Logo Watermark -->
        @if(setting('school_logo'))
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-5">
            <img src="{{ asset('storage/' . setting('school_logo')) }}" alt="Logo" class="w-96 h-96 object-contain">
        </div>
        @endif

        <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-8 py-6 relative z-10">
            <div class="flex items-center gap-3">
                <div class="bg-white/20 p-2.5 rounded-lg">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-white">Pilih Guru</h2>
            </div>
        </div>

        <div class="py-12 px-4 sm:px-6 lg:px-8 relative z-10">
            @if($teachers->count() > 0)
            <!-- Carousel Container -->
            <div class="relative max-w-2xl mx-auto">
                <!-- Teacher Cards -->
                <div id="teacher-carousel" class="overflow-visible">
                    <div class="flex transition-transform duration-500 ease-out" id="carousel-track">
                        @foreach($teachers as $index => $teacher)
                        <div class="w-full flex-shrink-0 px-8" data-teacher-id="{{ $teacher->id }}">
                            <div class="max-w-lg mx-auto">
                                <!-- Teacher Card - 9:16 Aspect Ratio -->
                                <div class="relative bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl overflow-hidden border-4 border-purple-200 shadow-2xl hover:shadow-3xl transition-all duration-300 cursor-pointer group aspect-[9/16]"
                                     onclick="selectTeacher({{ $teacher->id }}, '{{ $teacher->name }}', '{{ $teacher->nip }}')">
                                    
                                    <!-- Full Body Photo -->
                                    <div class="relative w-full h-full overflow-hidden">
                                        @if($teacher->user && $teacher->user->profile_photo)
                                        <img src="{{ asset('storage/' . $teacher->user->profile_photo) }}" 
                                             alt="Guru" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        @else
                                        <!-- Default Avatar - Full Body Silhouette -->
                                        <div class="w-full h-full bg-gradient-to-br from-purple-400 via-pink-500 to-purple-600 flex items-center justify-center relative overflow-hidden">
                                            <div class="absolute inset-0 opacity-20">
                                                <div class="absolute inset-0 bg-gradient-to-br from-white/30 to-transparent"></div>
                                            </div>
                                            <i class="fas fa-user text-white/40 text-[15rem] relative z-10"></i>
                                        </div>
                                        @endif
                                        
                                        <!-- Gradient Overlay -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                                        
                                        <!-- Status Badge - Floating Top Right -->
                                        @php
                                            $todayAttendance = $teacher->attendances()->whereDate('date', today())->first();
                                        @endphp
                                        <div class="absolute top-6 right-6 z-10">
                                            @if($todayAttendance)
                                                @if($todayAttendance->check_in && $todayAttendance->check_out)
                                                <span class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900/80 backdrop-blur-sm text-white rounded-full text-sm font-bold shadow-lg border-2 border-white/30">
                                                    <i class="fas fa-check-double"></i>
                                                </span>
                                                @elseif($todayAttendance->check_in)
                                                <span class="inline-flex items-center gap-2 px-4 py-2 bg-green-600/80 backdrop-blur-sm text-white rounded-full text-sm font-bold shadow-lg border-2 border-white/30 animate-pulse">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                @endif
                                            @else
                                            <span class="inline-flex items-center gap-2 px-4 py-2 bg-red-600/80 backdrop-blur-sm text-white rounded-full text-sm font-bold shadow-lg border-2 border-white/30">
                                                <i class="fas fa-times"></i>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Hover Overlay with Select Button -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-purple-900/95 via-purple-900/70 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-center pb-12">
                                        <div class="transform translate-y-8 group-hover:translate-y-0 transition-transform duration-300">
                                            <div class="text-center mb-6 px-6">
                                                <div class="inline-flex items-center gap-3 px-8 py-4 bg-white/20 backdrop-blur-sm rounded-2xl border-2 border-white/30 mb-4">
                                                    <i class="fas fa-qrcode text-white text-3xl"></i>
                                                    <span class="text-white text-xl font-bold">Tampilkan QR Code</span>
                                                </div>
                                                <p class="text-white/80 text-sm">Klik untuk memilih guru ini</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Teacher Counter -->
                                <div class="text-center mt-6">
                                    <p class="text-gray-600 font-semibold">
                                        <span class="text-purple-600 text-2xl font-bold">{{ $index + 1 }}</span> 
                                        <span class="text-gray-400 mx-2">/</span> 
                                        <span class="text-gray-500">{{ $teachers->count() }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Navigation Buttons -->
                @if($teachers->count() > 1)
                <button id="prev-btn" 
                        class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-6 w-14 h-14 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-full shadow-2xl hover:from-purple-700 hover:to-pink-700 transition-all duration-200 flex items-center justify-center z-20 hover:scale-110">
                    <i class="fas fa-chevron-left text-xl"></i>
                </button>
                <button id="next-btn" 
                        class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-6 w-14 h-14 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-full shadow-2xl hover:from-purple-700 hover:to-pink-700 transition-all duration-200 flex items-center justify-center z-20 hover:scale-110">
                    <i class="fas fa-chevron-right text-xl"></i>
                </button>
                @endif

                <!-- Dots Indicator -->
                @if($teachers->count() > 1)
                <div class="flex justify-center gap-2 mt-8 flex-wrap">
                    @foreach($teachers as $index => $teacher)
                    <button class="carousel-dot w-3 h-3 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-purple-600 w-8' : 'bg-gray-300' }}" 
                            data-index="{{ $index }}"
                            onclick="goToSlide({{ $index }})"></button>
                    @endforeach
                </div>
                @endif
            </div>
            @else
            <div class="text-center py-20">
                <i class="fas fa-users text-gray-300 text-8xl mb-6"></i>
                <p class="text-gray-600 text-xl">Tidak ada data guru</p>
            </div>
            @endif
        </div>
    </div>

    <!-- QR Code Display (Hidden by default) -->
    <div id="qr-display" class="hidden">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/20 p-2.5 rounded-lg">
                            <i class="fas fa-qrcode text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white" id="selected-teacher-name">-</h2>
                            <p class="text-white/80 text-sm" id="selected-teacher-nip">-</p>
                        </div>
                    </div>
                    <button onclick="closeQR()" class="text-white hover:bg-white/20 p-2 rounded-lg transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- QR Code -->
                    <div class="text-center">
                        <div id="qr-code-container" class="inline-block p-6 bg-white border-4 border-gray-200 rounded-2xl shadow-lg mb-6">
                            <!-- QR will be inserted here -->
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center justify-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-calendar text-purple-600"></i>
                                <span>Tanggal: <span class="font-semibold">{{ now()->format('d M Y') }}</span></span>
                            </div>
                            <div class="flex items-center justify-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-clock text-purple-600"></i>
                                <span id="current-time" class="font-semibold">{{ now()->format('H:i:s') }}</span>
                            </div>
                        </div>

                        <button onclick="refreshQR()" class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-pink-700 transition-all duration-200">
                            <i class="fas fa-sync-alt"></i>
                            Refresh QR Code
                        </button>
                    </div>

                    <!-- Instructions -->
                    <div class="space-y-6">
                        <!-- Status -->
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-6 border-2 border-purple-200">
                            <h3 class="text-sm font-bold text-purple-900 mb-3 flex items-center gap-2">
                                <i class="fas fa-info-circle"></i>
                                Status Presensi Hari Ini
                            </h3>
                            <div id="teacher-status">
                                <p class="text-sm text-gray-600">Loading...</p>
                            </div>
                        </div>

                        <!-- Instructions -->
                        <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl shadow-sm border-2 border-blue-200 overflow-hidden">
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
                                            <p class="text-xs text-gray-600">QR Code sudah muncul di layar</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center shrink-0">
                                            <span class="text-blue-600 font-bold text-sm">2</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900 mb-1">Guru Scan QR Code</p>
                                            <p class="text-xs text-gray-600">Guru buka menu Presensi → Scan QR Code</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center shrink-0">
                                            <span class="text-blue-600 font-bold text-sm">3</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900 mb-1">Otomatis Tercatat</p>
                                            <p class="text-xs text-gray-600">Sistem akan merekam check-in/check-out</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tips -->
                        <div class="bg-gradient-to-br from-amber-50 to-yellow-50 rounded-2xl shadow-sm border-2 border-amber-200 p-5">
                            <h3 class="text-sm font-bold text-amber-900 mb-3 flex items-center gap-2">
                                <i class="fas fa-lightbulb"></i>
                                Tips
                            </h3>
                            <ul class="space-y-2">
                                <li class="flex items-start gap-2 text-xs text-gray-600">
                                    <i class="fas fa-check-circle text-amber-500 mt-0.5"></i>
                                    <span>QR Code valid selama 10 menit</span>
                                </li>
                                <li class="flex items-start gap-2 text-xs text-gray-600">
                                    <i class="fas fa-check-circle text-amber-500 mt-0.5"></i>
                                    <span>Refresh jika sudah lebih dari 5 menit</span>
                                </li>
                                <li class="flex items-start gap-2 text-xs text-gray-600">
                                    <i class="fas fa-check-circle text-amber-500 mt-0.5"></i>
                                    <span>Pastikan layar cukup terang</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@push('scripts')
<script>
let currentTeacherId = null;
let autoRefreshInterval = null;
let currentSlide = 0;
const totalSlides = {{ $teachers->count() }};

// Carousel Navigation
function updateCarousel() {
    const track = document.getElementById('carousel-track');
    const dots = document.querySelectorAll('.carousel-dot');
    
    if (track) {
        track.style.transform = `translateX(-${currentSlide * 100}%)`;
    }
    
    // Update dots
    dots.forEach((dot, index) => {
        if (index === currentSlide) {
            dot.classList.remove('bg-gray-300', 'w-3');
            dot.classList.add('bg-purple-600', 'w-8');
        } else {
            dot.classList.remove('bg-purple-600', 'w-8');
            dot.classList.add('bg-gray-300', 'w-3');
        }
    });
}

function goToSlide(index) {
    currentSlide = index;
    updateCarousel();
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    updateCarousel();
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    updateCarousel();
}

// Initialize carousel on page load
document.addEventListener('DOMContentLoaded', function() {
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    
    if (prevBtn) prevBtn.addEventListener('click', prevSlide);
    if (nextBtn) nextBtn.addEventListener('click', nextSlide);

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') prevSlide();
        if (e.key === 'ArrowRight') nextSlide();
    });

    // Touch swipe support
    let touchStartX = 0;
    let touchEndX = 0;
    const carousel = document.getElementById('teacher-carousel');
    
    if (carousel) {
        carousel.addEventListener('touchstart', e => {
            touchStartX = e.changedTouches[0].screenX;
        });
        
        carousel.addEventListener('touchend', e => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });
    }
    
    function handleSwipe() {
        if (touchEndX < touchStartX - 50) nextSlide();
        if (touchEndX > touchStartX + 50) prevSlide();
    }
});

// Select teacher and show QR
function selectTeacher(teacherId, teacherName, teacherNip) {
    currentTeacherId = teacherId;
    
    // Update selected teacher info
    document.getElementById('selected-teacher-name').textContent = teacherName;
    document.getElementById('selected-teacher-nip').textContent = 'NIP: ' + teacherNip;
    
    // Show QR display section
    document.getElementById('qr-display').classList.remove('hidden');
    
    // Scroll to QR section
    document.getElementById('qr-display').scrollIntoView({ behavior: 'smooth' });
    
    // Load QR Code
    loadQRCode(teacherId);
    
    // Load teacher status
    loadTeacherStatus(teacherId);
    
    // Start auto refresh (every 5 minutes)
    if (autoRefreshInterval) {
        clearInterval(autoRefreshInterval);
    }
    autoRefreshInterval = setInterval(() => {
        refreshQR();
    }, 5 * 60 * 1000);
}

// Load QR Code
function loadQRCode(teacherId) {
    const container = document.getElementById('qr-code-container');
    container.innerHTML = '<i class="fas fa-spinner fa-spin text-4xl text-purple-600"></i>';
    
    fetch(`/api/teacher/${teacherId}/qr-code`)
        .then(response => response.json())
        .then(data => {
            console.log('QR Response:', data); // Debug
            if (data.success) {
                // Display SVG directly
                container.innerHTML = data.qrCode;
            } else {
                container.innerHTML = `<p class="text-red-600">${data.message || 'Gagal memuat QR Code'}</p>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            container.innerHTML = '<p class="text-red-600">Terjadi kesalahan</p>';
        });
}

// Load teacher status
function loadTeacherStatus(teacherId) {
    const statusDiv = document.getElementById('teacher-status');
    statusDiv.innerHTML = '<i class="fas fa-spinner fa-spin text-purple-600"></i> Loading...';
    
    fetch(`/api/teacher/${teacherId}/attendance-status`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let html = '';
                if (data.attendance) {
                    if (data.attendance.check_in && data.attendance.check_out) {
                        html = `
                            <div class="space-y-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-sign-in-alt text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600">Check-in</p>
                                        <p class="text-sm font-bold text-gray-900">${data.attendance.check_in_time}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-sign-out-alt text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600">Check-out</p>
                                        <p class="text-sm font-bold text-gray-900">${data.attendance.check_out_time}</p>
                                    </div>
                                </div>
                                <div class="mt-3 p-2 bg-gray-100 rounded-lg">
                                    <p class="text-xs text-gray-700 text-center">✓ Sudah presensi lengkap hari ini</p>
                                </div>
                            </div>
                        `;
                    } else if (data.attendance.check_in) {
                        html = `
                            <div class="space-y-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600">Check-in</p>
                                        <p class="text-sm font-bold text-gray-900">${data.attendance.check_in_time}</p>
                                    </div>
                                </div>
                                <div class="mt-3 p-2 bg-yellow-100 rounded-lg">
                                    <p class="text-xs text-yellow-800 text-center">Belum check-out</p>
                                </div>
                            </div>
                        `;
                    }
                } else {
                    html = `
                        <div class="text-center py-4">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-times text-red-600"></i>
                            </div>
                            <p class="text-sm text-gray-700">Belum presensi hari ini</p>
                        </div>
                    `;
                }
                statusDiv.innerHTML = html;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            statusDiv.innerHTML = '<p class="text-sm text-red-600">Gagal memuat status</p>';
        });
}

// Refresh QR Code
function refreshQR() {
    if (currentTeacherId) {
        loadQRCode(currentTeacherId);
        loadTeacherStatus(currentTeacherId);
    }
}

// Close QR display
function closeQR() {
    document.getElementById('qr-display').classList.add('hidden');
    currentTeacherId = null;
    
    if (autoRefreshInterval) {
        clearInterval(autoRefreshInterval);
        autoRefreshInterval = null;
    }
}

// Update current time every second
setInterval(function() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    const timeElement = document.getElementById('current-time');
    if (timeElement) {
        timeElement.textContent = `${hours}:${minutes}:${seconds}`;
    }
}, 1000);

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    if (autoRefreshInterval) {
        clearInterval(autoRefreshInterval);
    }
});
</script>
@endpush
@endsection
