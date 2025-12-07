<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $academicYears = AcademicYear::orderBy('year', 'desc')
            ->orderBy('semester', 'desc')
            ->paginate(10);
        
        return view('academic-years.index', compact('academicYears'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('academic-years.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'description' => 'nullable|string|max:500',
        ], [
            'year.required' => 'Tahun ajaran harus diisi',
            'semester.required' => 'Semester harus dipilih',
            'semester.in' => 'Semester harus Ganjil atau Genap',
            'start_date.required' => 'Tanggal mulai harus diisi',
            'end_date.required' => 'Tanggal selesai harus diisi',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai',
        ]);

        // Check if combination already exists
        if (AcademicYear::where('year', $validated['year'])
            ->where('semester', $validated['semester'])
            ->exists()) {
            return back()
                ->withInput()
                ->withErrors(['year' => 'Kombinasi tahun ajaran dan semester sudah ada']);
        }

        $academicYear = AcademicYear::create($validated);

        // If set as active, deactivate others
        if ($request->has('is_active') && $request->is_active) {
            $academicYear->setAsActive();
        }

        return redirect()->route('academic-years.index')
            ->with('success', 'Tahun ajaran berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademicYear $academicYear)
    {
        $relatedData = $academicYear->getRelatedDataInfo();
        
        return view('academic-years.show', compact('academicYear', 'relatedData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicYear $academicYear)
    {
        return view('academic-years.edit', compact('academicYear'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AcademicYear $academicYear)
    {
        $validated = $request->validate([
            'year' => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'description' => 'nullable|string|max:500',
        ], [
            'year.required' => 'Tahun ajaran harus diisi',
            'semester.required' => 'Semester harus dipilih',
            'semester.in' => 'Semester harus Ganjil atau Genap',
            'start_date.required' => 'Tanggal mulai harus diisi',
            'end_date.required' => 'Tanggal selesai harus diisi',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai',
        ]);

        // Check if combination already exists (excluding current record)
        if (AcademicYear::where('year', $validated['year'])
            ->where('semester', $validated['semester'])
            ->where('id', '!=', $academicYear->id)
            ->exists()) {
            return back()
                ->withInput()
                ->withErrors(['year' => 'Kombinasi tahun ajaran dan semester sudah ada']);
        }

        $academicYear->update($validated);

        // If set as active, deactivate others
        if ($request->has('is_active') && $request->is_active) {
            $academicYear->setAsActive();
        }

        return redirect()->route('academic-years.index')
            ->with('success', 'Tahun ajaran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicYear $academicYear)
    {
        if (!$academicYear->canBeDeleted()) {
            $info = $academicYear->getRelatedDataInfo();
            $message = 'Tahun ajaran tidak dapat dihapus karena masih digunakan: ';
            $details = [];
            
            if ($info['classes'] > 0) {
                $details[] = $info['classes'] . ' kelas';
            }
            if ($info['grades'] > 0) {
                $details[] = $info['grades'] . ' nilai';
            }
            
            $message .= implode(', ', $details);
            
            return redirect()->route('academic-years.index')
                ->with('error', $message);
        }

        // Don't allow deleting active academic year
        if ($academicYear->is_active) {
            return redirect()->route('academic-years.index')
                ->with('error', 'Tidak dapat menghapus tahun ajaran yang sedang aktif');
        }

        $academicYear->delete();

        return redirect()->route('academic-years.index')
            ->with('success', 'Tahun ajaran berhasil dihapus');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(AcademicYear $academicYear)
    {
        if ($academicYear->is_active) {
            // Cannot deactivate if it's the only one
            $activeCount = AcademicYear::where('is_active', true)->count();
            if ($activeCount <= 1) {
                return redirect()->route('academic-years.index')
                    ->with('error', 'Minimal harus ada 1 tahun ajaran aktif');
            }
            
            $academicYear->is_active = false;
            $academicYear->save();
            
            return redirect()->route('academic-years.index')
                ->with('success', 'Tahun ajaran dinonaktifkan');
        } else {
            $academicYear->setAsActive();
            
            return redirect()->route('academic-years.index')
                ->with('success', 'Tahun ajaran diaktifkan');
        }
    }
}
