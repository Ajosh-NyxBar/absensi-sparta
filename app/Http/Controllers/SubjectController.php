<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::withCount('teacherSubjects', 'grades')
            ->latest()
            ->paginate(10);
        return view('subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:subjects,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Subject::create($validated);

        return redirect()->route('subjects.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        $subject->loadCount('teacherSubjects', 'grades');
        $subject->load(['teacherSubjects.teacher', 'teacherSubjects.classRoom']);
        
        return view('subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return view('subjects.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:subjects,code,' . $subject->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $subject->update($validated);

        return redirect()->route('subjects.index')
            ->with('success', 'Mata pelajaran berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        // Check if subject is being used
        if ($subject->teacherSubjects()->count() > 0) {
            return redirect()->route('subjects.index')
                ->with('error', 'Mata pelajaran tidak dapat dihapus karena masih digunakan oleh guru!');
        }

        if ($subject->grades()->count() > 0) {
            return redirect()->route('subjects.index')
                ->with('error', 'Mata pelajaran tidak dapat dihapus karena masih memiliki data nilai!');
        }

        $subject->delete();

        return redirect()->route('subjects.index')
            ->with('success', 'Mata pelajaran berhasil dihapus!');
    }
}
