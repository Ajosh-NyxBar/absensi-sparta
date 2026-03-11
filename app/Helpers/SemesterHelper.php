<?php

namespace App\Helpers;

use App\Models\AcademicYear;

class SemesterHelper
{
    /**
     * Get the active semester from session or database.
     */
    public static function getActive(): ?AcademicYear
    {
        $id = session('active_semester_id');
        if ($id) {
            $ay = AcademicYear::find($id);
            if ($ay) return $ay;
        }

        $ay = AcademicYear::where('is_active', true)->first();
        if ($ay) {
            session(['active_semester_id' => $ay->id]);
        }
        return $ay;
    }

    /**
     * Get semester name (Ganjil/Genap) from active semester.
     */
    public static function semester(?string $default = null): ?string
    {
        return static::getActive()?->semester ?? $default;
    }

    /**
     * Get academic year (2025/2026) from active semester.
     */
    public static function academicYear(?string $default = null): ?string
    {
        return static::getActive()?->year ?? $default;
    }
}
