<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    /**
     * Display a listing of grades
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Grade::with(['student', 'subject', 'teacher']);

        // If teacher, only show grades they created
        if ($user->role->name === 'Guru' && $user->teacher) {
            $query->where('teacher_id', $user->teacher->id);
        }

        // Filter by semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        // Filter by academic year
        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }

        // Filter by subject
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        // Filter by class
        if ($request->filled('class_id')) {
            $classId = $request->class_id;
            $query->whereHas('student', function($q) use ($classId) {
                $q->where('class_id', $classId);
            });
        }

        $grades = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Get classes and subjects for filter
        if ($user->role->name === 'Guru' && $user->teacher) {
            $teacher = $user->teacher;
            $classIds = $teacher->teacherSubjects()->pluck('class_id')->unique();
            $classes = ClassRoom::whereIn('id', $classIds)->get();
            
            $subjectIds = $teacher->teacherSubjects()->pluck('subject_id')->unique();
            $subjects = Subject::whereIn('id', $subjectIds)->get();
        } else {
            $subjects = Subject::all();
            $classes = ClassRoom::all();
        }

        return view('grades.index', compact('grades', 'subjects', 'classes'));
    }

    /**
     * Show form for creating grades for a class and subject
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        
        // If teacher, only show classes and subjects they teach
        if ($user->role->name === 'Guru' && $user->teacher) {
            $teacher = $user->teacher;
            
            // Get classes from teacher_subjects
            $classIds = $teacher->teacherSubjects()->pluck('class_id')->unique();
            $classes = ClassRoom::whereIn('id', $classIds)->get();
            
            // Get subjects from teacher_subjects
            $subjectIds = $teacher->teacherSubjects()->pluck('subject_id')->unique();
            $subjects = Subject::whereIn('id', $subjectIds)->get();
        } else {
            // Admin or Kepala Sekolah can see all
            $classes = ClassRoom::all();
            $subjects = Subject::all();
        }

        return view('grades.create', compact('classes', 'subjects'));
    }

    /**
     * Show form for input grades by class and subject
     */
    public function inputByClass(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'semester' => 'required|string',
            'academic_year' => 'required|string',
        ]);

        $class = ClassRoom::findOrFail($validated['class_id']);
        $subject = Subject::findOrFail($validated['subject_id']);
        $students = $class->students()->where('status', 'active')->get();

        // Get existing grades
        $existingGrades = Grade::where('subject_id', $validated['subject_id'])
            ->where('semester', $validated['semester'])
            ->where('academic_year', $validated['academic_year'])
            ->whereIn('student_id', $students->pluck('id'))
            ->get()
            ->keyBy('student_id');

        $teacher = Auth::user()->teacher;

        return view('grades.input', compact(
            'class',
            'subject',
            'students',
            'existingGrades',
            'validated',
            'teacher'
        ));
    }

    /**
     * Store grades for multiple students
     */
    public function storeMultiple(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'semester' => 'required|string',
            'academic_year' => 'required|string',
            'students' => 'required|array',
            'students.*.student_id' => 'required|exists:students,id',
            'students.*.daily_test' => 'nullable|numeric|min:0|max:100',
            'students.*.midterm_exam' => 'nullable|numeric|min:0|max:100',
            'students.*.final_exam' => 'nullable|numeric|min:0|max:100',
        ]);

        $teacher = Auth::user()->teacher;

        foreach ($validated['students'] as $gradeData) {
            // Skip if no values entered
            if (empty($gradeData['daily_test']) && empty($gradeData['midterm_exam']) && empty($gradeData['final_exam'])) {
                continue;
            }

            // Calculate final grade
            $dailyTest = $gradeData['daily_test'] ?? 0;
            $midtermExam = $gradeData['midterm_exam'] ?? 0;
            $finalExam = $gradeData['final_exam'] ?? 0;

            $finalGrade = ($dailyTest * 0.3) + ($midtermExam * 0.3) + ($finalExam * 0.4);

            Grade::updateOrCreate(
                [
                    'student_id' => $gradeData['student_id'],
                    'subject_id' => $validated['subject_id'],
                    'semester' => $validated['semester'],
                    'academic_year' => $validated['academic_year'],
                ],
                [
                    'teacher_id' => $teacher ? $teacher->id : null,
                    'daily_test' => $dailyTest,
                    'midterm_exam' => $midtermExam,
                    'final_exam' => $finalExam,
                    'final_grade' => $finalGrade,
                ]
            );
        }

        return redirect()->route('grades.index')
            ->with('success', 'Nilai berhasil disimpan untuk ' . count($validated['students']) . ' siswa!');
    }

    /**
     * Show the form for editing the specified grade
     */
    public function edit(Grade $grade)
    {
        return view('grades.edit', compact('grade'));
    }

    /**
     * Update the specified grade
     */
    public function update(Request $request, Grade $grade)
    {
        $validated = $request->validate([
            'daily_test' => 'nullable|numeric|min:0|max:100',
            'midterm_exam' => 'nullable|numeric|min:0|max:100',
            'final_exam' => 'nullable|numeric|min:0|max:100',
            'behavior_score' => 'nullable|numeric|min:0|max:100',
            'skill_score' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        // Calculate final grade
        $dailyTest = $validated['daily_test'] ?? 0;
        $midtermExam = $validated['midterm_exam'] ?? 0;
        $finalExam = $validated['final_exam'] ?? 0;

        $validated['final_grade'] = ($dailyTest * 0.3) + ($midtermExam * 0.3) + ($finalExam * 0.4);

        $grade->update($validated);

        return redirect()->route('grades.index')
            ->with('success', 'Nilai berhasil diperbarui');
    }

    /**
     * Remove the specified grade
     */
    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect()->route('grades.index')
            ->with('success', 'Nilai berhasil dihapus');
    }

    /**
     * Show student report card
     */
    public function reportCard(Student $student, Request $request)
    {
        $semester = $request->input('semester', 'Ganjil');
        $academicYear = $request->input('academic_year', '2024/2025');

        $grades = Grade::where('student_id', $student->id)
            ->where('semester', $semester)
            ->where('academic_year', $academicYear)
            ->with('subject')
            ->get();

        $averageGrade = $grades->avg('final_grade');

        return view('grades.report-card', compact(
            'student',
            'grades',
            'semester',
            'academicYear',
            'averageGrade'
        ));
    }
}
