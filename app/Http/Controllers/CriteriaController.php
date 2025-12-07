<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studentCriteria = Criteria::where('for', 'student')->orderBy('code')->get();
        $teacherCriteria = Criteria::where('for', 'teacher')->orderBy('code')->get();
        
        // Calculate total weights
        $studentTotalWeight = $studentCriteria->sum('weight');
        $teacherTotalWeight = $teacherCriteria->sum('weight');
        
        return view('criteria.index', compact(
            'studentCriteria',
            'teacherCriteria',
            'studentTotalWeight',
            'teacherTotalWeight'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('criteria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:criteria,code',
            'name' => 'required|string|max:255',
            'type' => 'required|in:benefit,cost',
            'weight' => 'required|numeric|min:0|max:1',
            'for' => 'required|in:student,teacher',
            'description' => 'nullable|string',
        ], [
            'code.required' => 'Kode kriteria harus diisi',
            'code.unique' => 'Kode kriteria sudah digunakan',
            'name.required' => 'Nama kriteria harus diisi',
            'type.required' => 'Tipe kriteria harus dipilih',
            'type.in' => 'Tipe kriteria tidak valid',
            'weight.required' => 'Bobot harus diisi',
            'weight.min' => 'Bobot minimal 0',
            'weight.max' => 'Bobot maksimal 1',
            'for.required' => 'Kategori harus dipilih',
            'for.in' => 'Kategori tidak valid',
        ]);

        // Check total weight doesn't exceed 1.0
        $existingWeight = Criteria::where('for', $validated['for'])->sum('weight');
        if (($existingWeight + $validated['weight']) > 1.0) {
            return back()->withInput()->withErrors([
                'weight' => 'Total bobot untuk ' . ($validated['for'] === 'student' ? 'siswa' : 'guru') . 
                           ' akan melebihi 1.0. Sisa bobot: ' . (1.0 - $existingWeight)
            ]);
        }

        Criteria::create($validated);

        return redirect()->route('criteria.index')
            ->with('success', 'Kriteria berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Criteria $criterion)
    {
        return view('criteria.show', compact('criterion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Criteria $criterion)
    {
        return view('criteria.edit', compact('criterion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Criteria $criterion)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:criteria,code,' . $criterion->id,
            'name' => 'required|string|max:255',
            'type' => 'required|in:benefit,cost',
            'weight' => 'required|numeric|min:0|max:1',
            'for' => 'required|in:student,teacher',
            'description' => 'nullable|string',
        ], [
            'code.required' => 'Kode kriteria harus diisi',
            'code.unique' => 'Kode kriteria sudah digunakan',
            'name.required' => 'Nama kriteria harus diisi',
            'type.required' => 'Tipe kriteria harus dipilih',
            'type.in' => 'Tipe kriteria tidak valid',
            'weight.required' => 'Bobot harus diisi',
            'weight.min' => 'Bobot minimal 0',
            'weight.max' => 'Bobot maksimal 1',
            'for.required' => 'Kategori harus dipilih',
            'for.in' => 'Kategori tidak valid',
        ]);

        // Check total weight doesn't exceed 1.0 (excluding current criteria)
        $existingWeight = Criteria::where('for', $validated['for'])
            ->where('id', '!=', $criterion->id)
            ->sum('weight');
            
        if (($existingWeight + $validated['weight']) > 1.0) {
            return back()->withInput()->withErrors([
                'weight' => 'Total bobot untuk ' . ($validated['for'] === 'student' ? 'siswa' : 'guru') . 
                           ' akan melebihi 1.0. Sisa bobot: ' . (1.0 - $existingWeight)
            ]);
        }

        $criterion->update($validated);

        return redirect()->route('criteria.index')
            ->with('success', 'Kriteria berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Criteria $criterion)
    {
        // Check if criteria is used in assessments
        $studentAssessmentCount = $criterion->for === 'student' 
            ? \App\Models\StudentAssessment::where('criteria_id', $criterion->id)->count()
            : 0;
            
        $teacherAssessmentCount = $criterion->for === 'teacher'
            ? \App\Models\TeacherAssessment::where('criteria_id', $criterion->id)->count()
            : 0;

        if ($studentAssessmentCount > 0 || $teacherAssessmentCount > 0) {
            return back()->with('error', 'Kriteria tidak dapat dihapus karena sudah digunakan dalam penilaian');
        }

        $criterion->delete();

        return redirect()->route('criteria.index')
            ->with('success', 'Kriteria berhasil dihapus');
    }

    /**
     * Normalize weights to sum up to 1.0
     */
    public function normalizeWeights(Request $request)
    {
        $type = $request->input('type', 'student'); // student or teacher
        
        $criteria = Criteria::where('for', $type)->get();
        
        if ($criteria->isEmpty()) {
            return back()->with('error', 'Tidak ada kriteria untuk dinormalisasi');
        }

        $totalWeight = $criteria->sum('weight');
        
        if ($totalWeight == 0) {
            return back()->with('error', 'Total bobot tidak boleh 0');
        }

        // Normalize each criteria weight
        foreach ($criteria as $criterion) {
            $normalizedWeight = $criterion->weight / $totalWeight;
            $criterion->update(['weight' => round($normalizedWeight, 2)]);
        }

        return redirect()->route('criteria.index')
            ->with('success', 'Bobot kriteria berhasil dinormalisasi menjadi 1.0');
    }
}

