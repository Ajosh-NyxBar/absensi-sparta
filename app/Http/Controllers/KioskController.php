<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Services\NotificationService;

class KioskController extends Controller
{
    /**
     * Dashboard for Kiosk Presensi role
     * When user with "Kiosk Presensi" role logs in, they see this fullscreen kiosk
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Only Kiosk Presensi role can access
        if (!$user || !$user->isKiosk()) {
            return redirect()->route('dashboard');
        }
        
        $teachers = Teacher::where('status', 'active')
            ->orderBy('name')
            ->get();
        
        return view('kiosk.dashboard', compact('teachers'));
    }

    /**
     * Display the kiosk mode - Teacher selection for QR attendance
     * This page is displayed on a monitor in front of teacher's room
     */
    public function index()
    {
        $teachers = Teacher::where('status', 'active')
            ->orderBy('name')
            ->get();
        
        return view('kiosk.index', compact('teachers'));
    }

    /**
     * Display QR code for specific teacher
     */
    public function showTeacherQR($teacherId)
    {
        $teacher = Teacher::findOrFail($teacherId);
        
        return view('kiosk.teacher-qr', compact('teacher'));
    }

    /**
     * API: Generate QR code for teacher
     * QR contains encrypted data that can only be scanned by logged-in teacher
     */
    public function generateQR($teacherId)
    {
        try {
            $teacher = Teacher::find($teacherId);
            
            if (!$teacher) {
                return response()->json([
                    'success' => false,
                    'message' => 'Guru tidak ditemukan',
                ], 404);
            }

            // Generate unique QR code for today with timestamp
            $date = Carbon::now()->format('Y-m-d');
            $qrData = encrypt([
                'type' => 'teacher_attendance',
                'teacher_id' => $teacher->id,
                'date' => $date,
                'timestamp' => time(),
                'valid_for' => 60, // 60 seconds validity
            ]);

            // Generate QR code as SVG
            $qrCodeSvg = (string) QrCode::size(350)
                ->margin(1)
                ->errorCorrection('H')
                ->generate($qrData);

            return response()->json([
                'success' => true,
                'qrCode' => $qrCodeSvg,
                'teacher' => [
                    'id' => $teacher->id,
                    'name' => $teacher->name,
                    'nip' => $teacher->nip,
                ],
                'generated_at' => Carbon::now()->format('H:i:s'),
                'expires_in' => 60,
            ], 200, [], JSON_UNESCAPED_SLASHES);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * API: Get teacher attendance status for today
     */
    public function getAttendanceStatus($teacherId)
    {
        $teacher = Teacher::find($teacherId);
        
        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Guru tidak ditemukan',
            ], 404);
        }

        $today = Carbon::today();
        $attendance = Attendance::where('attendable_type', Teacher::class)
            ->where('attendable_id', $teacher->id)
            ->whereDate('date', $today)
            ->first();

        $status = [
            'has_attendance' => false,
            'check_in' => null,
            'check_out' => null,
            'status' => null,
            'status_text' => 'Belum Absen',
            'status_class' => 'text-gray-500',
        ];

        if ($attendance) {
            $status['has_attendance'] = true;
            $status['check_in'] = $attendance->check_in ? $attendance->check_in->format('H:i') : null;
            $status['check_out'] = $attendance->check_out ? $attendance->check_out->format('H:i') : null;
            $status['status'] = $attendance->status;
            
            if ($attendance->check_out) {
                $status['status_text'] = 'Selesai';
                $status['status_class'] = 'text-blue-500';
            } elseif ($attendance->status === 'present') {
                $status['status_text'] = 'Hadir - Tepat Waktu';
                $status['status_class'] = 'text-green-500';
            } elseif ($attendance->status === 'late') {
                $status['status_text'] = 'Hadir - Terlambat';
                $status['status_class'] = 'text-yellow-500';
            }
        }

        return response()->json([
            'success' => true,
            'teacher' => [
                'id' => $teacher->id,
                'name' => $teacher->name,
            ],
            'attendance' => $status,
        ]);
    }

    /**
     * API: Process QR scan from teacher's mobile device
     * Teacher must be logged in to scan
     */
    public function processQRScan(Request $request)
    {
        $validated = $request->validate([
            'qr_data' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Koordinat SMPN 4 Purwakarta (Google Maps)
        $schoolLat = -6.5465236;
        $schoolLong = 107.4414175;
        $allowedRadius = 100; // meter

        // Validasi jarak menggunakan rumus Haversine
        $distance = $this->calculateDistance(
            $schoolLat,
            $schoolLong,
            $validated['latitude'],
            $validated['longitude']
        );

        if ($distance > $allowedRadius) {
            return response()->json([
                'success' => false,
                'message' => 'Anda berada di luar area sekolah. Jarak: ' . round($distance) . ' meter dari sekolah.',
            ], 422);
        }

        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login terlebih dahulu',
            ], 401);
        }

        // Only teachers can scan
        if ($user->role->name !== 'Guru' || !$user->teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya guru yang dapat melakukan presensi',
            ], 403);
        }

        try {
            // Decrypt QR data
            $data = decrypt($validated['qr_data']);
            
            // Validate data structure
            if (!isset($data['type']) || $data['type'] !== 'teacher_attendance') {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code tidak valid',
                ], 422);
            }

            if (!isset($data['teacher_id']) || !isset($data['date']) || !isset($data['timestamp'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format QR Code tidak valid',
                ], 422);
            }

            // Check if QR code belongs to the scanning teacher
            if ($data['teacher_id'] != $user->teacher->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code ini bukan milik Anda. Silakan pilih nama Anda di layar.',
                ], 422);
            }

            // Check if QR code is still valid (within validity period)
            $qrAge = time() - $data['timestamp'];
            $validFor = $data['valid_for'] ?? 60;
            if ($qrAge > $validFor) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code sudah kadaluarsa. Silakan refresh QR Code di layar.',
                ], 422);
            }

            // Check if date matches
            if ($data['date'] !== Carbon::now()->format('Y-m-d')) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code tidak valid untuk hari ini',
                ], 422);
            }

            $teacher = $user->teacher;
            $today = Carbon::today();
            $now = Carbon::now();

            // Check existing attendance
            $attendance = Attendance::where('attendable_type', Teacher::class)
                ->where('attendable_id', $teacher->id)
                ->whereDate('date', $today)
                ->first();

            $checkInLimit = Carbon::today()->setTime(7, 30); // 07:30

            // If no attendance yet or no check-in, do check-in
            if (!$attendance || !$attendance->check_in) {
                $status = $now->lte($checkInLimit) ? 'present' : 'late';
                
                if ($attendance) {
                    $attendance->update([
                        'check_in' => $now,
                        'status' => $status,
                        'latitude_in' => $validated['latitude'],
                        'longitude_in' => $validated['longitude'],
                    ]);
                } else {
                    $attendance = Attendance::create([
                        'attendable_type' => Teacher::class,
                        'attendable_id' => $teacher->id,
                        'date' => $today,
                        'check_in' => $now,
                        'status' => $status,
                        'latitude_in' => $validated['latitude'],
                        'longitude_in' => $validated['longitude'],
                    ]);
                }

                // Send notification
                try {
                    $notificationService = app(NotificationService::class);
                    $notificationService->notifyTeacherCheckIn($teacher, $attendance);
                } catch (\Exception $e) {
                    // Ignore notification error
                }

                return response()->json([
                    'success' => true,
                    'action' => 'check-in',
                    'message' => 'Check-in berhasil!',
                    'data' => [
                        'teacher_name' => $teacher->name,
                        'check_in' => $now->format('H:i:s'),
                        'status' => $status === 'present' ? 'Tepat Waktu' : 'Terlambat',
                        'status_class' => $status === 'present' ? 'success' : 'warning',
                    ],
                ]);
            }

            // If already checked in but not checked out, do check-out
            if ($attendance->check_in && !$attendance->check_out) {
                $attendance->update([
                    'check_out' => $now,
                    'latitude_out' => $validated['latitude'],
                    'longitude_out' => $validated['longitude'],
                ]);

                // Send notification
                try {
                    $notificationService = app(NotificationService::class);
                    $notificationService->notifyTeacherCheckOut($teacher, $attendance);
                } catch (\Exception $e) {
                    // Ignore notification error
                }

                return response()->json([
                    'success' => true,
                    'action' => 'check-out',
                    'message' => 'Check-out berhasil!',
                    'data' => [
                        'teacher_name' => $teacher->name,
                        'check_in' => $attendance->check_in->format('H:i:s'),
                        'check_out' => $now->format('H:i:s'),
                        'duration' => $attendance->check_in->diff($now)->format('%H jam %I menit'),
                    ],
                ]);
            }

            // Already checked in and out
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan check-in dan check-out hari ini',
                'data' => [
                    'check_in' => $attendance->check_in->format('H:i:s'),
                    'check_out' => $attendance->check_out->format('H:i:s'),
                ],
            ], 422);

        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid atau rusak',
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get today's attendance summary for kiosk display
     */
    public function getTodaySummary()
    {
        $today = Carbon::today();
        
        $totalTeachers = Teacher::where('status', 'active')->count();
        
        $attendedTeachers = Attendance::where('attendable_type', Teacher::class)
            ->whereDate('date', $today)
            ->whereNotNull('check_in')
            ->count();
        
        $lateTeachers = Attendance::where('attendable_type', Teacher::class)
            ->whereDate('date', $today)
            ->where('status', 'late')
            ->count();
        
        $onTimeTeachers = Attendance::where('attendable_type', Teacher::class)
            ->whereDate('date', $today)
            ->where('status', 'present')
            ->count();

        return response()->json([
            'success' => true,
            'date' => $today->format('l, d F Y'),
            'time' => Carbon::now()->format('H:i:s'),
            'summary' => [
                'total' => $totalTeachers,
                'attended' => $attendedTeachers,
                'not_attended' => $totalTeachers - $attendedTeachers,
                'on_time' => $onTimeTeachers,
                'late' => $lateTeachers,
                'percentage' => $totalTeachers > 0 ? round(($attendedTeachers / $totalTeachers) * 100) : 0,
            ],
        ]);
    }

    /**
     * Get current user's attendance status
     */
    public function getMyAttendanceStatus()
    {
        $user = Auth::user();
        
        if (!$user || !$user->teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Data guru tidak ditemukan',
            ], 404);
        }

        $teacher = $user->teacher;
        $today = Carbon::today();
        
        $attendance = Attendance::where('attendable_type', Teacher::class)
            ->where('attendable_id', $teacher->id)
            ->whereDate('date', $today)
            ->first();

        $data = [
            'check_in' => null,
            'check_out' => null,
            'status' => null,
        ];

        if ($attendance) {
            $data = [
                'check_in' => $attendance->check_in ? $attendance->check_in->format('H:i') : null,
                'check_out' => $attendance->check_out ? $attendance->check_out->format('H:i') : null,
                'status' => $attendance->status,
            ];
        }

        return response()->json([
            'success' => true,
            'teacher' => [
                'id' => $teacher->id,
                'name' => $teacher->name,
            ],
            'attendance' => $data,
        ]);
    }

    /**
     * Show scanner page for teachers
     */
    public function showScanner()
    {
        $user = Auth::user();
        
        if (!$user || $user->role->name !== 'Guru') {
            return redirect()->route('dashboard')
                ->with('error', 'Halaman ini hanya untuk guru.');
        }
        
        return view('kiosk.scanner');
    }
    /**
     * Calculate distance between two coordinates using Haversine formula
     */
    protected function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }
}
