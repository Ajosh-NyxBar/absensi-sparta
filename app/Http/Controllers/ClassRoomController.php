<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = ClassRoom::with('homeroomTeacher')
            ->withCount('students', 'teacherSubjects')
            ->latest()
            ->paginate(10);
        return view('classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = Teacher::where('status', 'active')->orderBy('name')->get();
        return view('classes.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'grade' => 'required|in:7,8,9',
            'academic_year' => 'required|string|max:20',
            'capacity' => 'nullable|integer|min:1|max:50',
            'homeroom_teacher_id' => 'nullable|exists:teachers,id',
        ]);

        ClassRoom::create($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Kelas berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassRoom $class)
    {
        $class->loadCount('students', 'teacherSubjects');
        $class->load(['students', 'teacherSubjects.teacher', 'teacherSubjects.subject', 'homeroomTeacher']);
        
        return view('classes.show', compact('class'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassRoom $class)
    {
        $teachers = Teacher::where('status', 'active')->orderBy('name')->get();
        return view('classes.edit', compact('class', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassRoom $class)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'grade' => 'required|in:7,8,9',
            'academic_year' => 'required|string|max:20',
            'capacity' => 'nullable|integer|min:1|max:50',
            'homeroom_teacher_id' => 'nullable|exists:teachers,id',
        ]);

        $class->update($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Kelas berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassRoom $class)
    {
        // Check if class has students
        if ($class->students()->count() > 0) {
            return redirect()->route('classes.index')
                ->with('error', 'Kelas tidak dapat dihapus karena masih memiliki siswa!');
        }

        // Check if class has teacher subjects
        if ($class->teacherSubjects()->count() > 0) {
            return redirect()->route('classes.index')
                ->with('error', 'Kelas tidak dapat dihapus karena masih memiliki mata pelajaran!');
        }

        $class->delete();

        return redirect()->route('classes.index')
            ->with('success', 'Kelas berhasil dihapus!');
    }
}
