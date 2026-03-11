<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\Criteria;
use App\Models\Grade;
use App\Models\Setting;
use App\Models\Student;
use App\Models\StudentAssessment;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherAssessment;
use App\Models\TeacherSubject;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DataController extends Controller
{
    // ==========================================
    // TEACHERS
    // ==========================================

    public function teachers(Request $request): JsonResponse
    {
        $query = Teacher::with(['user:id,name,email,role_id', 'subjects:id,name,code']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        $perPage = min((int) $request->get('per_page', 15), 100);
        $teachers = $query->orderBy('name')->paginate($perPage);

        return response()->json($teachers);
    }

    public function teacherShow(Teacher $teacher): JsonResponse
    {
        $teacher->load(['user:id,name,email,role_id', 'subjects:id,name,code', 'teacherSubjects.classRoom', 'teacherSubjects.subject']);
        return response()->json(['data' => $teacher]);
    }

    // ==========================================
    // STUDENTS
    // ==========================================

    public function students(Request $request): JsonResponse
    {
        $query = Student::with('classRoom:id,name,grade');

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $perPage = min((int) $request->get('per_page', 15), 100);
        $students = $query->orderBy('name')->paginate($perPage);

        return response()->json($students);
    }

    public function studentShow(Student $student): JsonResponse
    {
        $student->load(['classRoom:id,name,grade', 'grades.subject:id,name,code', 'grades.teacher:id,name']);
        return response()->json(['data' => $student]);
    }

    // ==========================================
    // USERS
    // ==========================================

    public function users(Request $request): JsonResponse
    {
        $query = User::with('role:id,name');

        if ($request->filled('role')) {
            $query->where('role_id', $request->role);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $perPage = min((int) $request->get('per_page', 15), 100);
        $users = $query->orderBy('name')->paginate($perPage);

        return response()->json($users);
    }

    public function userShow(User $user): JsonResponse
    {
        $user->load(['role:id,name', 'teacher']);
        return response()->json(['data' => $user]);
    }

    // ==========================================
    // CLASSES
    // ==========================================

    public function classes(Request $request): JsonResponse
    {
        $query = ClassRoom::withCount('students');

        if ($request->filled('grade')) {
            $query->where('grade', $request->grade);
        }

        $classes = $query->orderBy('grade')->orderBy('name')->get();

        return response()->json(['data' => $classes]);
    }

    public function classShow(ClassRoom $class): JsonResponse
    {
        $class->load(['students:id,class_id,name,nis,nisn,gender,status', 'teacherSubjects.teacher:id,name', 'teacherSubjects.subject:id,name,code']);
        $class->loadCount('students');
        return response()->json(['data' => $class]);
    }

    // ==========================================
    // SUBJECTS
    // ==========================================

    public function subjects(): JsonResponse
    {
        $subjects = Subject::withCount('grades', 'teacherSubjects')->orderBy('name')->get();
        return response()->json(['data' => $subjects]);
    }

    public function subjectShow(Subject $subject): JsonResponse
    {
        $subject->load(['teacherSubjects.teacher:id,name', 'teacherSubjects.classRoom:id,name,grade']);
        return response()->json(['data' => $subject]);
    }

    // ==========================================
    // ACADEMIC YEARS
    // ==========================================

    public function academicYears(): JsonResponse
    {
        $years = AcademicYear::orderBy('year', 'desc')->orderBy('semester')->get();
        return response()->json(['data' => $years]);
    }

    public function academicYearShow(AcademicYear $academicYear): JsonResponse
    {
        return response()->json(['data' => $academicYear]);
    }

    // ==========================================
    // GRADES
    // ==========================================

    public function grades(Request $request): JsonResponse
    {
        $query = Grade::with([
            'student:id,name,nis,class_id',
            'student.classRoom:id,name,grade',
            'subject:id,name,code',
            'teacher:id,name',
        ]);

        if ($request->filled('class_id')) {
            $query->whereHas('student', fn($q) => $q->where('class_id', $request->class_id));
        }
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }
        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        $perPage = min((int) $request->get('per_page', 20), 100);
        $grades = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json($grades);
    }

    public function gradeShow(Grade $grade): JsonResponse
    {
        $grade->load(['student:id,name,nis,class_id', 'student.classRoom:id,name', 'subject:id,name,code', 'teacher:id,name']);
        return response()->json(['data' => $grade]);
    }

    // ==========================================
    // ATTENDANCE
    // ==========================================

    public function attendances(Request $request): JsonResponse
    {
        $query = Attendance::query();

        if ($request->filled('type')) {
            $type = $request->type === 'teacher'
                ? 'App\\Models\\Teacher'
                : 'App\\Models\\Student';
            $query->where('attendable_type', $type);
        }
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $query->with('attendable:id,name');

        $perPage = min((int) $request->get('per_page', 20), 100);
        $attendances = $query->orderBy('date', 'desc')->orderBy('check_in', 'desc')->paginate($perPage);

        return response()->json($attendances);
    }

    // ==========================================
    // CRITERIA (SAW)
    // ==========================================

    public function criteria(): JsonResponse
    {
        $studentCriteria = Criteria::where('for', 'student')->orderBy('code')->get();
        $teacherCriteria = Criteria::where('for', 'teacher')->orderBy('code')->get();

        return response()->json([
            'data' => [
                'student' => $studentCriteria,
                'teacher' => $teacherCriteria,
                'student_total_weight' => $studentCriteria->sum('weight'),
                'teacher_total_weight' => $teacherCriteria->sum('weight'),
            ]
        ]);
    }

    // ==========================================
    // SAW RANKINGS
    // ==========================================

    public function sawStudents(Request $request): JsonResponse
    {
        $query = StudentAssessment::with([
            'student:id,name,nis,nisn,class_id',
            'student.classRoom:id,name,grade',
        ]);

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }

        $rankings = $query->orderBy('rank')->get();

        return response()->json(['data' => $rankings]);
    }

    public function sawTeachers(Request $request): JsonResponse
    {
        $query = TeacherAssessment::with('teacher:id,name,nip');

        if ($request->filled('period')) {
            $query->where('period', $request->period);
        }
        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }

        $rankings = $query->orderBy('rank')->get();

        return response()->json(['data' => $rankings]);
    }

    // ==========================================
    // TEACHER SUBJECTS (Assignments)
    // ==========================================

    public function teacherSubjects(Request $request): JsonResponse
    {
        $query = TeacherSubject::with([
            'teacher:id,name,nip',
            'subject:id,name,code',
            'classRoom:id,name,grade',
        ]);

        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        $assignments = $query->get();

        return response()->json(['data' => $assignments]);
    }

    // ==========================================
    // SETTINGS
    // ==========================================

    public function settings(): JsonResponse
    {
        $settings = Setting::all()->groupBy('group')->map(function ($group) {
            return $group->pluck('value', 'key');
        });

        return response()->json(['data' => $settings]);
    }

    // ==========================================
    // DASHBOARD STATS
    // ==========================================

    public function dashboardStats(): JsonResponse
    {
        $today = now()->toDateString();

        $totalTeachers = Teacher::where('status', 'active')->count();
        $totalStudents = Student::where('status', 'active')->count();
        $totalClasses  = ClassRoom::count();
        $totalSubjects = Subject::count();

        $todayTeacherAttendance = Attendance::where('attendable_type', 'App\\Models\\Teacher')
            ->where('date', $today)
            ->count();

        $todayStudentAttendance = Attendance::where('attendable_type', 'App\\Models\\Student')
            ->where('date', $today)
            ->count();

        return response()->json([
            'data' => [
                'total_teachers'  => $totalTeachers,
                'total_students'  => $totalStudents,
                'total_classes'   => $totalClasses,
                'total_subjects'  => $totalSubjects,
                'today_teacher_attendance' => $todayTeacherAttendance,
                'today_student_attendance' => $todayStudentAttendance,
                'teacher_attendance_percentage' => $totalTeachers > 0
                    ? round(($todayTeacherAttendance / $totalTeachers) * 100, 1)
                    : 0,
            ]
        ]);
    }
}
