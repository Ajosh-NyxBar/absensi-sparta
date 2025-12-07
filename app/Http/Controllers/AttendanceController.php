<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AttendanceController extends Controller
{
    /**
     * Display attendance list
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Attendance::with('attendable');

        // If teacher, only show their own attendance
        if ($user->role->name === 'Guru' && $user->teacher) {
            $query->where('attendable_type', Teacher::class)
                  ->where('attendable_id', $user->teacher->id);
        } else {
            // Admin or Kepala Sekolah can see all attendances
            // Filter by type (teacher/student)
            if ($request->filled('type')) {
                if ($request->type === 'teacher') {
                    $query->where('attendable_type', Teacher::class);
                } elseif ($request->type === 'student') {
                    $query->where('attendable_type', Student::class);
                }
            }
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        } else {
            // Default to current month for teachers, today for admin
            if ($user->role->name === 'Guru') {
                $query->whereMonth('date', now()->month)
                      ->whereYear('date', now()->year);
            } else {
                $query->whereDate('date', today());
            }
        }

        $attendances = $query->orderBy('date', 'desc')
                             ->orderBy('check_in', 'desc')
                             ->paginate(20);

        return view('attendances.index', compact('attendances'));
    }

    /**
     * Show QR Code for teacher attendance
     */
    public function showQRCode()
    {
        $user = Auth::user();
        
        // Admin/Kepsek: redirect to admin QR page (teacher selection)
        if ($user->role->name === 'Admin' || $user->role->name === 'Kepala Sekolah') {
            return redirect()->route('attendances.admin-qr');
        }
        
        // Guru: redirect to scanner (camera)
        if ($user->role->name === 'Guru') {
            return redirect()->route('attendances.scanner');
        }

        return redirect()->route('dashboard')
            ->with('error', 'Akses tidak diizinkan.');
    }

    /**
     * Show Admin QR Code selection page
     */
    public function showAdminQR()
    {
        $user = Auth::user();
        
        // Only Admin/Kepsek can access
        if ($user->role->name === 'Guru') {
            return redirect()->route('attendances.qr-code');
        }
        
        $teachers = Teacher::with('user')
            ->orderBy('name')
            ->get();
        
        return view('attendances.admin-qr', compact('teachers'));
    }

    /**
     * API: Get teacher QR code
     */
    public function getTeacherQR($teacherId)
    {
        try {
            $teacher = Teacher::find($teacherId);
            
            if (!$teacher) {
                return response()->json([
                    'success' => false,
                    'message' => 'Guru tidak ditemukan',
                ], 404);
            }

            // Generate unique QR code for today
            $date = Carbon::now()->format('Y-m-d');
            $qrData = encrypt([
                'teacher_id' => $teacher->id,
                'date' => $date,
                'timestamp' => time(),
            ]);

            // Generate QR code as SVG string
            $qrCodeSvg = (string) QrCode::size(300)
                ->margin(1)
                ->generate($qrData);

            return response()->json([
                'success' => true,
                'qrCode' => $qrCodeSvg,
                'type' => 'svg'
            ], 200, [], JSON_UNESCAPED_SLASHES);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * API: Get teacher attendance status
     */
    public function getTeacherAttendanceStatus($teacherId)
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

        $data = null;
        if ($attendance) {
            $data = [
                'check_in_time' => $attendance->check_in ? $attendance->check_in->format('H:i:s') : null,
                'check_out_time' => $attendance->check_out ? $attendance->check_out->format('H:i:s') : null,
                'status' => $attendance->status,
            ];
        }

        return response()->json([
            'success' => true,
            'attendance' => $data,
        ]);
    }

    /**
     * Show QR Scanner page
     */
    public function showScanner()
    {
        $user = Auth::user();
        
        // Only teachers can access scanner
        if ($user->role->name !== 'Guru') {
            return redirect()->route('attendances.index')
                ->with('error', 'Halaman scanner hanya untuk guru.');
        }
        
        return view('attendances.scanner');
    }

    /**
     * Process scanned QR code
     */
    public function scanQR(Request $request)
    {
        $validated = $request->validate([
            'qr_data' => 'required|string',
        ]);

        try {
            // Decrypt QR data
            $data = decrypt($validated['qr_data']);
            
            // Validate data structure
            if (!isset($data['teacher_id']) || !isset($data['date']) || !isset($data['timestamp'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code tidak valid',
                ], 422);
            }

            // Check if QR code is still valid (within 10 minutes)
            $qrAge = time() - $data['timestamp'];
            if ($qrAge > 600) { // 10 minutes
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code sudah kadaluarsa. Silakan refresh QR Code.',
                ], 422);
            }

            // Check if date matches
            if ($data['date'] !== Carbon::now()->format('Y-m-d')) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code tidak valid untuk hari ini',
                ], 422);
            }

            $teacher = Teacher::find($data['teacher_id']);
            if (!$teacher) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data guru tidak ditemukan',
                ], 404);
            }

            // Check existing attendance
            $today = Carbon::today();
            $attendance = Attendance::where('attendable_type', Teacher::class)
                ->where('attendable_id', $teacher->id)
                ->whereDate('date', $today)
                ->first();

            $now = Carbon::now();
            $checkInLimit = Carbon::today()->setTime(7, 30); // 07:30

            // If no attendance yet or no check-in, do check-in
            if (!$attendance || !$attendance->check_in) {
                $status = $now->lte($checkInLimit) ? 'present' : 'late';
                
                if ($attendance) {
                    $attendance->update([
                        'check_in' => $now,
                        'status' => $status,
                    ]);
                } else {
                    $attendance = Attendance::create([
                        'attendable_type' => Teacher::class,
                        'attendable_id' => $teacher->id,
                        'date' => $today,
                        'check_in' => $now,
                        'status' => $status,
                    ]);
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
                ]);

                return response()->json([
                    'success' => true,
                    'action' => 'check-out',
                    'message' => 'Check-out berhasil!',
                    'data' => [
                        'teacher_name' => $teacher->name,
                        'check_in' => $attendance->check_in->format('H:i:s'),
                        'check_out' => $now->format('H:i:s'),
                    ],
                ]);
            }

            // Already checked in and out
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan check-in dan check-out hari ini',
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid atau rusak',
            ], 422);
        }
    }

    /**
     * Check in using geolocation
     */
    public function checkIn(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'type' => 'required|in:teacher,student',
            'id' => 'required|integer',
        ]);

        // School location (SMPN 4 Purwakarta) - Replace with actual coordinates
        $schoolLat = -6.5567;  // Example coordinates
        $schoolLong = 107.4442;
        $allowedRadius = 100; // meters

        // Check if within allowed radius
        $distance = $this->calculateDistance(
            $schoolLat,
            $schoolLong,
            $validated['latitude'],
            $validated['longitude']
        );

        if ($distance > $allowedRadius) {
            return response()->json([
                'success' => false,
                'message' => 'Anda berada di luar area sekolah. Jarak: ' . round($distance) . ' meter',
            ], 422);
        }

        // Get attendable model
        if ($validated['type'] === 'teacher') {
            $attendable = Teacher::find($validated['id']);
        } else {
            $attendable = Student::find($validated['id']);
        }

        if (!$attendable) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        // Check if already checked in today
        $today = Carbon::today();
        $existingAttendance = Attendance::where('attendable_type', get_class($attendable))
            ->where('attendable_id', $attendable->id)
            ->whereDate('date', $today)
            ->first();

        if ($existingAttendance && $existingAttendance->check_in) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan check-in hari ini',
            ], 422);
        }

        $now = Carbon::now();
        $checkInLimit = Carbon::today()->setTime(7, 30); // 07:30

        // Determine status
        $status = $now->lte($checkInLimit) ? 'present' : 'late';

        // Create or update attendance
        if ($existingAttendance) {
            $existingAttendance->update([
                'check_in' => $now,
                'latitude_in' => $validated['latitude'],
                'longitude_in' => $validated['longitude'],
                'status' => $status,
            ]);
            $attendance = $existingAttendance;
        } else {
            $attendance = Attendance::create([
                'attendable_type' => get_class($attendable),
                'attendable_id' => $attendable->id,
                'date' => $today,
                'check_in' => $now,
                'latitude_in' => $validated['latitude'],
                'longitude_in' => $validated['longitude'],
                'status' => $status,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil',
            'data' => $attendance,
            'status' => $status === 'present' ? 'Tepat Waktu' : 'Terlambat',
        ]);
    }

    /**
     * Check out using geolocation
     */
    public function checkOut(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'type' => 'required|in:teacher,student',
            'id' => 'required|integer',
        ]);

        // Get attendable model
        if ($validated['type'] === 'teacher') {
            $attendable = Teacher::find($validated['id']);
        } else {
            $attendable = Student::find($validated['id']);
        }

        if (!$attendable) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        // Find today's attendance
        $today = Carbon::today();
        $attendance = Attendance::where('attendable_type', get_class($attendable))
            ->where('attendable_id', $attendable->id)
            ->whereDate('date', $today)
            ->first();

        if (!$attendance) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum check-in hari ini',
            ], 422);
        }

        if ($attendance->check_out) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan check-out hari ini',
            ], 422);
        }

        $attendance->update([
            'check_out' => Carbon::now(),
            'latitude_out' => $validated['latitude'],
            'longitude_out' => $validated['longitude'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-out berhasil',
            'data' => $attendance,
        ]);
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

    /**
     * Show attendance form for students by class
     */
    public function classAttendance(ClassRoom $class)
    {
        $students = $class->students()->where('status', 'active')->get();
        $date = request()->input('date', Carbon::today()->format('Y-m-d'));

        // Get existing attendances
        $attendances = Attendance::where('attendable_type', Student::class)
            ->whereIn('attendable_id', $students->pluck('id'))
            ->whereDate('date', $date)
            ->get()
            ->keyBy('attendable_id');

        return view('attendances.class', compact('class', 'students', 'date', 'attendances'));
    }

    /**
     * Save class attendance
     */
    public function saveClassAttendance(Request $request, ClassRoom $class)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:students,id',
            'attendances.*.status' => 'required|in:present,absent,sick,permission',
        ]);

        foreach ($validated['attendances'] as $data) {
            Attendance::updateOrCreate(
                [
                    'attendable_type' => Student::class,
                    'attendable_id' => $data['student_id'],
                    'date' => $validated['date'],
                ],
                [
                    'status' => $data['status'],
                    'check_in' => $data['status'] === 'present' ? Carbon::now() : null,
                ]
            );
        }

        return redirect()->back()
            ->with('success', 'Data kehadiran berhasil disimpan');
    }
}
