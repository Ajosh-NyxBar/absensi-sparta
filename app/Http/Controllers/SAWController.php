<?php

namespace App\Http\Controllers;

use App\Models\StudentAssessment;
use App\Models\TeacherAssessment;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ClassRoom;
use App\Models\Grade;
use App\Models\Attendance;
use App\Models\Criteria;
use App\Services\SAWService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SAWController extends Controller
{
    protected $sawService;

    public function __construct(SAWService $sawService)
    {
        $this->sawService = $sawService;
    }

    /**
     * Show SAW calculation page for students
     */
    public function studentIndex(Request $request)
    {
        $classes = ClassRoom::all();
        $selectedClass = $request->input('class_id');
        $activeSem = \App\Helpers\SemesterHelper::getActive();
        $semester = $request->input('semester', $activeSem?->semester ?? 'Genap');
        $academicYear = $request->input('academic_year', $activeSem?->year ?? '2025/2026');

        $assessments = null;
        $calculationDetails = null;

        if ($selectedClass) {
            $assessments = StudentAssessment::with('student')
                ->where('class_id', $selectedClass)
                ->where('semester', $semester)
                ->where('academic_year', $academicYear)
                ->orderBy('rank')
                ->get();

            if ($assessments->isNotEmpty()) {
                $calculationDetails = $this->sawService->getCalculationDetails($assessments, 'student');
            }
        }

        $criteria = Criteria::forStudent();

        return view('saw.students.index', compact(
            'classes',
            'selectedClass',
            'semester',
            'academicYear',
            'assessments',
            'criteria',
            'calculationDetails'
        ));
    }

    /**
     * Calculate SAW scores for students
     */
    public function calculateStudents(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'semester' => 'required|string',
            'academic_year' => 'required|string',
        ]);

        $class = ClassRoom::findOrFail($validated['class_id']);
        $students = $class->students()->where('status', 'active')->get();

        if ($students->isEmpty()) {
            return redirect()->back()
                ->with('error', 'Tidak ada siswa aktif di kelas ini');
        }

        // Prepare data for each student
        $studentData = collect();

        foreach ($students as $student) {
            // Get academic score (average of all subjects)
            $academicScore = Grade::where('student_id', $student->id)
                ->where('semester', $validated['semester'])
                ->where('academic_year', $validated['academic_year'])
                ->avg('final_grade') ?? 0;

            // Get attendance score
            $startDate = $this->getSemesterStartDate($validated['semester'], $validated['academic_year']);
            $endDate = $this->getSemesterEndDate($validated['semester'], $validated['academic_year']);
            
            $attendanceScore = $student->getAttendancePercentage($startDate, $endDate);

            // Get behavior score (average from all subjects)
            $behaviorScore = Grade::where('student_id', $student->id)
                ->where('semester', $validated['semester'])
                ->where('academic_year', $validated['academic_year'])
                ->avg('behavior_score') ?? 0;

            // Get skill score (average from all subjects)
            $skillScore = Grade::where('student_id', $student->id)
                ->where('semester', $validated['semester'])
                ->where('academic_year', $validated['academic_year'])
                ->avg('skill_score') ?? 0;

            $studentData->push((object)[
                'student_id' => $student->id,
                'class_id' => $class->id,
                'semester' => $validated['semester'],
                'academic_year' => $validated['academic_year'],
                'academic_score' => $academicScore,
                'attendance_score' => $attendanceScore,
                'behavior_score' => $behaviorScore,
                'skill_score' => $skillScore,
            ]);
        }

        // Calculate SAW scores and rankings
        $rankedData = $this->sawService->calculate($studentData, 'student');

        // Save to database
        foreach ($rankedData as $data) {
            StudentAssessment::updateOrCreate(
                [
                    'student_id' => $data->student_id,
                    'semester' => $data->semester,
                    'academic_year' => $data->academic_year,
                ],
                [
                    'class_id' => $data->class_id,
                    'academic_score' => $data->academic_score,
                    'attendance_score' => $data->attendance_score,
                    'behavior_score' => $data->behavior_score,
                    'skill_score' => $data->skill_score,
                    'saw_score' => $data->saw_score,
                    'rank' => $data->rank,
                ]
            );
        }

        return redirect()->route('saw.students.index', [
            'class_id' => $validated['class_id'],
            'semester' => $validated['semester'],
            'academic_year' => $validated['academic_year'],
        ])->with('success', 'Perhitungan SAW untuk siswa berhasil dilakukan');
    }

    /**
     * Show SAW calculation page for teachers
     */
    public function teacherIndex(Request $request)
    {
        $activeSem = \App\Helpers\SemesterHelper::getActive();
        $period = $request->input('period', $activeSem?->semester ?? 'Ganjil');
        $academicYear = $request->input('academic_year', $activeSem?->year ?? '2025/2026');

        $assessments = TeacherAssessment::with('teacher')
            ->where('period', $period)
            ->where('academic_year', $academicYear)
            ->orderBy('rank')
            ->get();

        $calculationDetails = null;
        if ($assessments->isNotEmpty()) {
            $calculationDetails = $this->sawService->getCalculationDetails($assessments, 'teacher');
        }

        $criteria = Criteria::forTeacher();
        $academicYears = \App\Models\AcademicYear::select('year')->distinct()->orderByDesc('year')->pluck('year');

        return view('saw.teachers.index', compact(
            'period',
            'academicYear',
            'assessments',
            'criteria',
            'calculationDetails',
            'academicYears'
        ));
    }

    /**
     * Calculate SAW scores for teachers
     */
    public function calculateTeachers(Request $request)
    {
        $validated = $request->validate([
            'period' => 'required|string|in:Ganjil,Genap',
            'academic_year' => 'required|string',
        ]);

        $teachers = Teacher::where('status', 'active')->get();

        if ($teachers->isEmpty()) {
            return redirect()->back()
                ->with('error', 'Tidak ada guru aktif');
        }

        // Prepare data for each teacher
        $teacherData = collect();

        // Use semester date range for attendance calculation
        $startDate = $this->getSemesterStartDate($validated['period'], $validated['academic_year']);
        $endDate = $this->getSemesterEndDate($validated['period'], $validated['academic_year']);

        foreach ($teachers as $teacher) {
            // Get attendance score (K1 - auto)
            $attendanceScore = $teacher->getAttendancePercentage($startDate, $endDate);

            // Check if manual scores exist in teacher_assessments
            $existingAssessment = TeacherAssessment::where('teacher_id', $teacher->id)
                ->where('period', $validated['period'])
                ->where('academic_year', $validated['academic_year'])
                ->first();

            // K2: Teaching quality (from manual input, default 80)
            $teachingQuality = $existingAssessment->teaching_quality ?? 80;

            // K3: Student achievement (auto from average grades of students taught)
            $studentAchievement = Grade::where('teacher_id', $teacher->id)
                ->where('semester', $validated['period'])
                ->where('academic_year', $validated['academic_year'])
                ->avg('final_grade') ?? 0;

            // K4: Discipline score (from manual input, fallback to attendance-based)
            $disciplineScore = $existingAssessment->discipline_score ?? min(100, $attendanceScore + 10);

            $teacherData->push((object)[
                'teacher_id' => $teacher->id,
                'period' => $validated['period'],
                'academic_year' => $validated['academic_year'],
                'attendance_score' => $attendanceScore,
                'teaching_quality' => $teachingQuality,
                'student_achievement' => $studentAchievement,
                'discipline_score' => $disciplineScore,
            ]);
        }

        // Calculate SAW scores and rankings
        $rankedData = $this->sawService->calculate($teacherData, 'teacher');

        // Save to database
        foreach ($rankedData as $data) {
            TeacherAssessment::updateOrCreate(
                [
                    'teacher_id' => $data->teacher_id,
                    'period' => $data->period,
                    'academic_year' => $data->academic_year,
                ],
                [
                    'attendance_score' => $data->attendance_score,
                    'teaching_quality' => $data->teaching_quality,
                    'student_achievement' => $data->student_achievement,
                    'discipline_score' => $data->discipline_score,
                    'saw_score' => $data->saw_score,
                    'rank' => $data->rank,
                ]
            );
        }

        return redirect()->route('saw.teachers.index', [
            'period' => $validated['period'],
            'academic_year' => $validated['academic_year'],
        ])->with('success', 'Perhitungan SAW untuk guru berhasil dilakukan');
    }

    /**
     * Helper function to get semester start date
     */
    protected function getSemesterStartDate($semester, $academicYear)
    {
        $year = explode('/', $academicYear)[0];
        return $semester === 'Ganjil' 
            ? Carbon::create($year, 7, 1) 
            : Carbon::create($year + 1, 1, 1);
    }

    /**
     * Helper function to get semester end date
     */
    protected function getSemesterEndDate($semester, $academicYear)
    {
        $year = explode('/', $academicYear)[0];
        return $semester === 'Ganjil' 
            ? Carbon::create($year, 12, 31) 
            : Carbon::create($year + 1, 6, 30);
    }

}
