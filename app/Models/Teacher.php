<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nip',
        'name',
        'gender',
        'phone',
        'address',
        'birth_date',
        'photo',
        'education_level',
        'position',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Get the user associated with the teacher
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all attendances for this teacher
     */
    public function attendances(): MorphMany
    {
        return $this->morphMany(Attendance::class, 'attendable');
    }

    /**
     * Get all teacher subjects
     */
    public function teacherSubjects(): HasMany
    {
        return $this->hasMany(TeacherSubject::class);
    }

    /**
     * Get subjects through teacher_subjects
     */
    public function subjects(): HasManyThrough
    {
        return $this->hasManyThrough(
            Subject::class,
            TeacherSubject::class,
            'teacher_id', // Foreign key on teacher_subjects table
            'id', // Foreign key on subjects table
            'id', // Local key on teachers table
            'subject_id' // Local key on teacher_subjects table
        );
    }

    /**
     * Get all grades given by this teacher
     */
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * Get all assessments for this teacher
     */
    public function assessments(): HasMany
    {
        return $this->hasMany(TeacherAssessment::class);
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
}
