<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'period',
        'academic_year',
        'attendance_score',
        'teaching_quality',
        'student_achievement',
        'discipline_score',
        'saw_score',
        'rank',
        'notes',
    ];

    protected $casts = [
        'attendance_score' => 'decimal:2',
        'teaching_quality' => 'decimal:2',
        'student_achievement' => 'decimal:2',
        'discipline_score' => 'decimal:2',
        'saw_score' => 'decimal:2',
    ];

    /**
     * Get the teacher
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}
