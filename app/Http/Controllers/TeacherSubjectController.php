<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Subject;
use App\Models\ClassRoom;
use App\Models\TeacherSubject;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class TeacherSubjectController extends Controller
{
    /**
     * Display a listing of teacher-subject assignments
     */
    public function index(Request $request)
    {
        $query = TeacherSubject::with(['teacher', 'subject', 'classRoom']);

        // Filter by teacher
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        // Filter by subject
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        // Filter by class
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        // Filter by academic year
        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }

        $assignments = $query->latest()->paginate(15);
        $teachers = Teacher::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        $classes = ClassRoom::orderBy('name')->get();
        $academicYears = AcademicYear::orderBy('year', 'desc')->get();

        return view('teacher-subjects.index', compact('assignments', 'teachers', 'subjects', 'classes', 'academicYears'));
    }

    /**
     * Show the form for creating a new assignment
     */
    public function create()
    {
        $teachers = Teacher::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        $classes = ClassRoom::orderBy('name')->get();
        $academicYears = AcademicYear::orderBy('year', 'desc')->get();

        return view('teacher-subjects.create', compact('teachers', 'subjects', 'classes', 'academicYears'));
    }

    /**
     * Store a newly created assignment
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'nullable|exists:classes,id',
            'academic_year' => 'required|string',
        ]);

        // Check for duplicate assignment
        $exists = TeacherSubject::where('teacher_id', $validated['teacher_id'])
            ->where('subject_id', $validated['subject_id'])
            ->where('class_id', $validated['class_id'])
            ->where('academic_year', $validated['academic_year'])
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Penugasan guru untuk mata pelajaran dan kelas ini sudah ada.');
        }

        TeacherSubject::create($validated);

        return redirect()->route('teacher-subjects.index')
            ->with('success', 'Penugasan guru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified assignment
     */
    public function edit(TeacherSubject $teacherSubject)
    {
        $teachers = Teacher::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        $classes = ClassRoom::orderBy('name')->get();
        $academicYears = AcademicYear::orderBy('year', 'desc')->get();

        return view('teacher-subjects.edit', compact('teacherSubject', 'teachers', 'subjects', 'classes', 'academicYears'));
    }

    /**
     * Update the specified assignment
     */
    public function update(Request $request, TeacherSubject $teacherSubject)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'nullable|exists:classes,id',
            'academic_year' => 'required|string',
        ]);

        // Check for duplicate assignment (excluding current)
        $exists = TeacherSubject::where('teacher_id', $validated['teacher_id'])
            ->where('subject_id', $validated['subject_id'])
            ->where('class_id', $validated['class_id'])
            ->where('academic_year', $validated['academic_year'])
            ->where('id', '!=', $teacherSubject->id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Penugasan guru untuk mata pelajaran dan kelas ini sudah ada.');
        }

        $teacherSubject->update($validated);

        return redirect()->route('teacher-subjects.index')
            ->with('success', 'Penugasan guru berhasil diperbarui.');
    }

    /**
     * Remove the specified assignment
     */
    public function destroy(TeacherSubject $teacherSubject)
    {
        $teacherSubject->delete();

        return redirect()->route('teacher-subjects.index')
            ->with('success', 'Penugasan guru berhasil dihapus.');
    }

    /**
     * Get subjects by teacher (AJAX)
     */
    public function getSubjectsByTeacher($teacherId)
    {
        $subjects = TeacherSubject::with('subject')
            ->where('teacher_id', $teacherId)
            ->get()
            ->pluck('subject');

        return response()->json($subjects);
    }

    /**
     * Get teachers by subject (AJAX)
     */
    public function getTeachersBySubject($subjectId)
    {
        $teachers = TeacherSubject::with('teacher')
            ->where('subject_id', $subjectId)
            ->get()
            ->pluck('teacher');

        return response()->json($teachers);
    }
}
