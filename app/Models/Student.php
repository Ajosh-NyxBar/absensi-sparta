<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'nisn',
        'nis',
        'name',
        'gender',
        'phone',
        'address',
        'birth_date',
        'birth_place',
        'photo',
        'parent_name',
        'parent_phone',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Get the class this student belongs to
     */
    public function classRoom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    /**
     * Get all attendances for this student
     */
    public function attendances(): MorphMany
    {
        return $this->morphMany(Attendance::class, 'attendable');
    }

    /**
     * Get all grades for this student
     */
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * Get all assessments for this student
     */
    public function assessments(): HasMany
    {
        return $this->hasMany(StudentAssessment::class);
    }

    /**
     * Calculate attendance percentage for a period
     */
    public function getAttendancePercentage($startDate, $endDate)
    {
        $totalDays = $this->attendances()
            ->whereBetween('date', [$startDate, $endDate])
            ->count();

        if ($totalDays == 0) return 0;

        $presentDays = $this->attendances()
            ->whereBetween('date', [$startDate, $endDate])
            ->whereIn('status', ['present', 'late'])
            ->count();

        return round(($presentDays / $totalDays) * 100, 2);
    }

    /**
     * Calculate average grade for a semester
     */
    public function getAverageGrade($semester, $academicYear)
    {
        return $this->grades()
            ->where('semester', $semester)
            ->where('academic_year', $academicYear)
            ->avg('final_grade') ?? 0;
    }
}
