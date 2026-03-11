<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\TeacherAssessment;
use App\Models\Grade;
use App\Models\AcademicYear;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TeacherAssessmentController extends Controller
{
    /**
     * Show teacher assessment input page
     */
    public function index(Request $request)
    {
        $activeSem = \App\Helpers\SemesterHelper::getActive();
        $academicYear = $request->input('academic_year', $activeSem?->year ?? '2025/2026');
        $semester = $request->input('semester', $activeSem?->semester ?? 'Genap');

        $teachers = Teacher::where('status', 'active')
            ->with(['teacherSubjects' => function ($q) use ($academicYear) {
                $q->where('academic_year', $academicYear)->with(['subject', 'classRoom']);
            }])
            ->orderBy('name')
            ->get();

        // Get existing assessments
        $period = $semester . ' ' . $academicYear;
        $existingAssessments = TeacherAssessment::where('academic_year', $academicYear)
            ->where('period', $period)
            ->get()
            ->keyBy('teacher_id');

        // Pre-calculate auto scores for each teacher
        $teacherScores = [];
        foreach ($teachers as $teacher) {
            // K1: Attendance (auto from attendance data)
            $startDate = $this->getSemesterStart($semester, $academicYear);
            $endDate = Carbon::now();
            $attendanceScore = $teacher->getAttendancePercentage($startDate, $endDate);

            // K3: Student Achievement (auto from average grades of students they teach)
            $studentAchievement = Grade::where('teacher_id', $teacher->id)
                ->where('academic_year', $academicYear)
                ->where('semester', $semester)
                ->avg('final_grade') ?? 0;

            $existing = $existingAssessments->get($teacher->id);

            $teacherScores[$teacher->id] = [
                'attendance_score' => round($attendanceScore, 2),
                'teaching_quality' => $existing->teaching_quality ?? null,
                'student_achievement' => round($studentAchievement, 2),
                'discipline_score' => $existing->discipline_score ?? null,
            ];
        }

        return view('teacher-assessments.index', compact(
            'teachers',
            'academicYear',
            'semester',
            'teacherScores',
            'existingAssessments'
        ));
    }

    /**
     * Store teacher assessment scores
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_year' => 'required|string',
            'semester' => 'required|string',
            'scores' => 'required|array',
            'scores.*.teacher_id' => 'required|exists:teachers,id',
            'scores.*.teaching_quality' => 'required|numeric|min:0|max:100',
            'scores.*.discipline_score' => 'required|numeric|min:0|max:100',
        ]);

        $period = $validated['semester'] . ' ' . $validated['academic_year'];

        foreach ($validated['scores'] as $scoreData) {
            $teacher = Teacher::find($scoreData['teacher_id']);

            // Auto-calculate K1 & K3
            $startDate = $this->getSemesterStart($validated['semester'], $validated['academic_year']);
            $endDate = Carbon::now();
            $attendanceScore = $teacher->getAttendancePercentage($startDate, $endDate);

            $studentAchievement = Grade::where('teacher_id', $teacher->id)
                ->where('academic_year', $validated['academic_year'])
                ->where('semester', $validated['semester'])
                ->avg('final_grade') ?? 0;

            TeacherAssessment::updateOrCreate(
                [
                    'teacher_id' => $scoreData['teacher_id'],
                    'period' => $period,
                    'academic_year' => $validated['academic_year'],
                ],
                [
                    'attendance_score' => round($attendanceScore, 2),
                    'teaching_quality' => $scoreData['teaching_quality'],
                    'student_achievement' => round($studentAchievement, 2),
                    'discipline_score' => $scoreData['discipline_score'],
                ]
            );
        }

        return redirect()->route('teacher-assessments.index', [
            'academic_year' => $validated['academic_year'],
            'semester' => $validated['semester'],
        ])->with('success', 'Penilaian guru berhasil disimpan!');
    }

    private function getSemesterStart($semester, $academicYear)
    {
        $year = explode('/', $academicYear)[0];
        return $semester === 'Ganjil'
            ? Carbon::create($year, 7, 1)
            : Carbon::create((int)$year + 1, 1, 1);
    }
}
