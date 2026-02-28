<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\SAWController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherSubjectController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NotificationController;

// Language switcher route (available for all)
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    
    // Profile routes - accessible by all authenticated users
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    
    // Notification routes - accessible by all authenticated users
    Route::get('/notifications', [NotificationController::class, 'showAll'])->name('notifications.index');
    Route::get('/api/notifications', [NotificationController::class, 'index'])->name('notifications.api.index');
    Route::get('/api/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.api.unread-count');
    Route::post('/api/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.api.mark-read');
    Route::post('/api/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.api.mark-all-read');
    Route::delete('/api/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.api.destroy');
    
    // Attendance routes - accessible by all authenticated users
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::get('/attendance/qr-code', [AttendanceController::class, 'showQRCode'])->name('attendances.qr-code');
    Route::get('/attendance/admin-qr', [AttendanceController::class, 'showAdminQR'])->name('attendances.admin-qr');
    Route::get('/attendance/scanner', [AttendanceController::class, 'showScanner'])->name('attendances.scanner');
    Route::post('/attendance/scan-qr', [AttendanceController::class, 'scanQR'])->name('attendances.scan-qr');
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendances.check-in');
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendances.check-out');
    
    // API routes for attendance
    Route::get('/api/teacher/{teacher}/qr-code', [AttendanceController::class, 'getTeacherQR']);
    Route::get('/api/teacher/{teacher}/attendance-status', [AttendanceController::class, 'getTeacherAttendanceStatus']);
    
    // Admin only routes
    Route::middleware(\App\Http\Middleware\CheckRole::class . ':Admin')->group(function () {
        // User management
        Route::resource('users', UserController::class);
        Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
        
        // Teacher management
        Route::resource('teachers', TeacherController::class);
        
        // Student management
        Route::resource('students', StudentController::class);
        
        // Subject management
        Route::resource('subjects', SubjectController::class);
        
        // Class management
        Route::resource('classes', ClassRoomController::class);
        
        // Academic year management
        Route::resource('academic-years', AcademicYearController::class);
        Route::post('/academic-years/{academicYear}/toggle-active', [AcademicYearController::class, 'toggleActive'])->name('academic-years.toggle-active');
        
        // Teacher-Subject assignment management
        Route::resource('teacher-subjects', TeacherSubjectController::class);
        Route::get('/api/teacher/{teacher}/subjects', [TeacherSubjectController::class, 'getSubjectsByTeacher']);
        Route::get('/api/subject/{subject}/teachers', [TeacherSubjectController::class, 'getTeachersBySubject']);
        
        // Reports & Export
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::post('/reports/attendance/export', [ReportController::class, 'exportAttendance'])->name('reports.attendance.export');
        Route::post('/reports/grades/export', [ReportController::class, 'exportGrades'])->name('reports.grades.export');
        Route::post('/reports/students/export', [ReportController::class, 'exportStudents'])->name('reports.students.export');
        Route::post('/reports/teachers/export', [ReportController::class, 'exportTeachers'])->name('reports.teachers.export');
        
        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings/school', [SettingController::class, 'updateSchool'])->name('settings.school.update');
        Route::put('/settings/general', [SettingController::class, 'updateGeneral'])->name('settings.general.update');
        Route::put('/settings/appearance', [SettingController::class, 'updateAppearance'])->name('settings.appearance.update');
        Route::put('/settings/notification', [SettingController::class, 'updateNotification'])->name('settings.notification.update');
        Route::put('/settings/system', [SettingController::class, 'updateSystem'])->name('settings.system.update');
        Route::post('/settings/cache/clear', [SettingController::class, 'clearCache'])->name('settings.cache.clear');
        Route::post('/settings/backup', [SettingController::class, 'backup'])->name('settings.backup');
        
        // Criteria Management
        Route::resource('criteria', CriteriaController::class);
        Route::post('/criteria/normalize', [CriteriaController::class, 'normalizeWeights'])->name('criteria.normalize');
        
        // Class attendance
        Route::get('/attendance/class/{class}', [AttendanceController::class, 'classAttendance'])->name('attendances.class');
        Route::post('/attendance/class/{class}', [AttendanceController::class, 'saveClassAttendance'])->name('attendances.class.save');
    });
    
    // Admin and Guru routes
    Route::middleware(\App\Http\Middleware\CheckRole::class . ':Admin,Guru')->group(function () {
        // My Classes (for Teachers)
        Route::get('/my-classes', [TeacherController::class, 'myClasses'])->name('teachers.my-classes');
        
        // Teacher Profile (for Teachers to edit their own profile)
        Route::get('/my-profile', [TeacherController::class, 'editProfile'])->name('teachers.edit-profile');
        Route::put('/my-profile', [TeacherController::class, 'updateProfile'])->name('teachers.update-profile');
        
        // Grade management
        Route::get('/grades', [GradeController::class, 'index'])->name('grades.index');
        Route::get('/grades/create', [GradeController::class, 'create'])->name('grades.create');
        Route::post('/grades/input-by-class', [GradeController::class, 'inputByClass'])->name('grades.input-by-class');
        Route::post('/grades/store-multiple', [GradeController::class, 'storeMultiple'])->name('grades.store-multiple');
        Route::get('/grades/{grade}/edit', [GradeController::class, 'edit'])->name('grades.edit');
        Route::put('/grades/{grade}', [GradeController::class, 'update'])->name('grades.update');
        Route::delete('/grades/{grade}', [GradeController::class, 'destroy'])->name('grades.destroy');
    });
    
    // Admin and Kepala Sekolah routes
    Route::middleware(\App\Http\Middleware\CheckRole::class . ':Admin,Kepala Sekolah')->group(function () {
        // SAW for students
        Route::get('/saw/students', [SAWController::class, 'studentIndex'])->name('saw.students.index');
        Route::post('/saw/students/calculate', [SAWController::class, 'calculateStudents'])->name('saw.students.calculate');
        
        // SAW for teachers
        Route::get('/saw/teachers', [SAWController::class, 'teacherIndex'])->name('saw.teachers.index');
        Route::post('/saw/teachers/calculate', [SAWController::class, 'calculateTeachers'])->name('saw.teachers.calculate');
        
        // Report card
        Route::get('/students/{student}/report-card', [GradeController::class, 'reportCard'])->name('students.report-card');
    });
    
    // Teacher Scanner - for scanning QR from kiosk
    Route::get('/scan-presensi', [App\Http\Controllers\KioskController::class, 'showScanner'])->name('kiosk.scanner');
    Route::get('/api/attendance/my-status', [App\Http\Controllers\KioskController::class, 'getMyAttendanceStatus'])->name('api.attendance.my-status');
});

// ===============================
// KIOSK MODE ROUTES (No Auth Required for public display)
// These routes are for the display monitor in front of teacher's room
// ===============================
Route::prefix('kiosk')->name('kiosk.')->group(function () {
    // Main kiosk display - Teacher selection page (public, no auth)
    Route::get('/', [App\Http\Controllers\KioskController::class, 'index'])->name('index');
    
    // API endpoints for kiosk (public, no auth)
    Route::get('/api/qr/{teacher}', [App\Http\Controllers\KioskController::class, 'generateQR'])->name('api.qr');
    Route::get('/api/status/{teacher}', [App\Http\Controllers\KioskController::class, 'getAttendanceStatus'])->name('api.status');
    Route::get('/api/summary', [App\Http\Controllers\KioskController::class, 'getTodaySummary'])->name('api.summary');
    
    // QR Scan processing (requires auth - called from teacher's mobile)
    Route::post('/api/scan', [App\Http\Controllers\KioskController::class, 'processQRScan'])->name('api.scan')->middleware('auth');
});

// ===============================
// KIOSK USER DASHBOARD (Requires Auth with Kiosk Presensi role)
// When user with "Kiosk Presensi" role logs in, they see this
// ===============================
Route::middleware(['auth'])->group(function () {
    Route::get('/kiosk-dashboard', [App\Http\Controllers\KioskController::class, 'dashboard'])->name('kiosk.dashboard');
    Route::post('/kiosk-logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('kiosk.logout');
});

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

