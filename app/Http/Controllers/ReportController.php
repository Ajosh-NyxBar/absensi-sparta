<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceExport;
use App\Exports\GradesExport;
use App\Exports\StudentsExport;
use App\Exports\TeachersExport;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ClassRoom;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display report index
     */
    public function index()
    {
        $classes = ClassRoom::orderBy('grade')->orderBy('name')->get();
        $academicYears = AcademicYear::orderBy('year', 'desc')->get();
        $activeYear = AcademicYear::getActive();
        
        return view('reports.index', compact('classes', 'academicYears', 'activeYear'));
    }

    /**
     * Export Attendance Report
     */
    public function exportAttendance(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'type' => 'nullable|in:teacher,student',
            'format' => 'required|in:excel,pdf'
        ]);

        // Tentukan rentang tanggal: dari semester atau manual
        if (!empty($validated['academic_year_id'])) {
            $academicYear = AcademicYear::findOrFail($validated['academic_year_id']);
            $startDate = Carbon::parse($academicYear->start_date);
            $endDate = Carbon::parse($academicYear->end_date);
        } else {
            $startDate = Carbon::parse($validated['start_date']);
            $endDate = Carbon::parse($validated['end_date']);
        }

        $type = $validated['type'] ?? null;
        $format = $validated['format'];

        $filename = 'laporan_presensi_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d');

        if ($format === 'excel') {
            return Excel::download(
                new AttendanceExport($startDate, $endDate, $type),
                $filename . '.xlsx'
            );
        } else {
            // PDF: gunakan data ringkasan per orang agar tidak kehabisan memori
            $query = Attendance::with('attendable')
                ->whereBetween('date', [$startDate, $endDate]);

            if ($type) {
                $model = $type === 'teacher' ? 'App\Models\Teacher' : 'App\Models\Student';
                $query->where('attendable_type', $model);
            }

            // Hitung ringkasan per orang
            $summaries = $query
                ->selectRaw('attendable_type, attendable_id,
                    COUNT(*) as total_days,
                    SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present,
                    SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late,
                    SUM(CASE WHEN status = "sick" THEN 1 ELSE 0 END) as sick,
                    SUM(CASE WHEN status = "permission" THEN 1 ELSE 0 END) as permission,
                    SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent')
                ->groupBy('attendable_type', 'attendable_id')
                ->get();

            // Eager-load relasi attendable
            $summaries->load('attendable');

            $pdf = Pdf::loadView('reports.pdf.attendance', [
                'summaries' => $summaries,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'type' => $type
            ]);

            return $pdf->download($filename . '.pdf');
        }
    }

    /**
     * Export Grades Report
     */
    public function exportGrades(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'nullable|exists:classes,id',
            'semester' => 'nullable|in:1,2',
            'academic_year' => 'nullable|string',
            'format' => 'required|in:excel,pdf'
        ]);

        $classId = $validated['class_id'] ?? null;
        $semester = $validated['semester'] ?? null;
        $academicYear = $validated['academic_year'] ?? null;
        $format = $validated['format'];

        $filename = 'laporan_nilai';
        if ($classId) {
            $class = ClassRoom::find($classId);
            $filename .= '_' . str_replace(' ', '_', $class->name);
        }
        if ($academicYear) {
            $filename .= '_' . str_replace('/', '-', $academicYear);
        }

        if ($format === 'excel') {
            return Excel::download(
                new GradesExport($classId, $semester, $academicYear),
                $filename . '.xlsx'
            );
        } else {
            $query = Grade::with(['student', 'subject']);

            if ($classId) {
                $query->whereHas('student', function($q) use ($classId) {
                    $q->where('class_id', $classId);
                });
            }

            if ($semester) {
                $query->where('semester', $semester);
            }

            if ($academicYear) {
                $query->where('academic_year', $academicYear);
            }

            $grades = $query->orderBy('academic_year', 'desc')
                ->orderBy('semester', 'desc')
                ->get();

            $pdf = Pdf::loadView('reports.pdf.grades', [
                'grades' => $grades,
                'class' => $classId ? ClassRoom::find($classId) : null,
                'semester' => $semester,
                'academicYear' => $academicYear
            ]);

            return $pdf->download($filename . '.pdf');
        }
    }

    /**
     * Export Students Report
     */
    public function exportStudents(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'nullable|exists:classes,id',
            'grade' => 'nullable|in:7,8,9',
            'status' => 'nullable|in:active,inactive',
            'format' => 'required|in:excel,pdf'
        ]);

        $classId = $validated['class_id'] ?? null;
        $grade = $validated['grade'] ?? null;
        $status = $validated['status'] ?? 'active';
        $format = $validated['format'];

        $filename = 'laporan_siswa';
        if ($grade) {
            $filename .= '_kelas_' . $grade;
        }

        if ($format === 'excel') {
            return Excel::download(
                new StudentsExport($classId, $grade, $status),
                $filename . '.xlsx'
            );
        } else {
            $query = Student::with(['class']);

            if ($classId) {
                $query->where('class_id', $classId);
            }

            if ($grade) {
                $query->whereHas('class', function($q) use ($grade) {
                    $q->where('grade', $grade);
                });
            }

            if ($status) {
                $query->where('status', $status);
            }

            $students = $query->orderBy('class_id')->orderBy('name')->get();

            $pdf = Pdf::loadView('reports.pdf.students', [
                'students' => $students,
                'class' => $classId ? ClassRoom::find($classId) : null,
                'grade' => $grade,
                'status' => $status
            ]);

            return $pdf->download($filename . '.pdf');
        }
    }

    /**
     * Export Teachers Report
     */
    public function exportTeachers(Request $request)
    {
        $validated = $request->validate([
            'format' => 'required|in:excel,pdf'
        ]);

        $format = $validated['format'];
        $filename = 'laporan_guru_' . date('Y-m-d');

        if ($format === 'excel') {
            return Excel::download(
                new TeachersExport(),
                $filename . '.xlsx'
            );
        } else {
            $teachers = Teacher::with(['user', 'teacherSubjects.subject', 'teacherSubjects.class'])
                ->orderBy('name')
                ->get();

            $pdf = Pdf::loadView('reports.pdf.teachers', [
                'teachers' => $teachers
            ]);

            return $pdf->download($filename . '.pdf');
        }
    }
}
