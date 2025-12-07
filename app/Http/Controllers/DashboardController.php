<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\Attendance;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function admin()
    {
        $activeYear = AcademicYear::getActive();
        
        // Basic Statistics
        $totalStudents = Student::where('status', 'active')->count();
        $totalTeachers = Teacher::count();
        $totalClasses = ClassRoom::count();
        $totalSubjects = Subject::count();
        
        // Growth Calculations (mock data for now)
        $studentGrowth = 12; // +12% from last month
        $teacherGrowth = -2; // -2% from last month
        
        // Attendance Statistics
        $totalPresentToday = Attendance::where('date', today()->format('Y-m-d'))
            ->whereIn('status', ['present', 'late'])
            ->count();
        $attendancePercentage = $totalStudents > 0 ? ($totalPresentToday / $totalStudents) * 100 : 0;
        
        // Students by Grade
        $studentsByGrade = Student::where('status', 'active')
            ->join('classes', 'students.class_id', '=', 'classes.id')
            ->select('classes.grade', DB::raw('count(*) as total'))
            ->groupBy('classes.grade')
            ->orderBy('classes.grade')
            ->get();
        
        // Classes by Grade
        $classesByGrade = ClassRoom::select('grade', DB::raw('count(*) as total'))
            ->groupBy('grade')
            ->pluck('total', 'grade');
        
        // Attendance This Week (Last 7 days)
        $attendanceWeekly = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $attendanceWeekly->push([
                'date' => $date->format('D'),
                'full_date' => $date->format('Y-m-d'),
                'count' => Attendance::where('date', $date->format('Y-m-d'))->count(),
            ]);
        }
        
        // Recent Attendances (Last 10)
        $recentAttendances = Attendance::with(['student', 'teacher'])
            ->latest('created_at')
            ->take(10)
            ->get();
        
        // Monthly Stats
        $monthlyAttendanceRate = 87; // Mock data
        $monthlyAvgGrade = 82.5; // Mock data
        $monthlyCompletion = 75; // Mock data
        
        // New Students This Month
        $newStudentsThisMonth = Student::where('status', 'active')
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
        
        // Active Classes Today
        $activeClassesToday = rand($totalClasses - 2, $totalClasses);
        
        return view('dashboard.admin-modern', compact(
            'activeYear',
            'totalStudents',
            'totalTeachers',
            'totalClasses',
            'totalSubjects',
            'studentGrowth',
            'teacherGrowth',
            'totalPresentToday',
            'attendancePercentage',
            'studentsByGrade',
            'classesByGrade',
            'attendanceWeekly',
            'recentAttendances',
            'monthlyAttendanceRate',
            'monthlyAvgGrade',
            'monthlyCompletion',
            'newStudentsThisMonth',
            'activeClassesToday'
        ));
    }
    
    public function teacher()
    {
        // Teacher dashboard implementation
        return view('dashboard.teacher');
    }
    
    public function headmaster()
    {
        // Headmaster dashboard implementation
        return view('dashboard.headmaster');
    }
}
