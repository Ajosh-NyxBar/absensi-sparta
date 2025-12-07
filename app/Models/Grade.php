<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject_id',
        'teacher_id',
        'semester',
        'academic_year',
        'daily_test',
        'midterm_exam',
        'final_exam',
        'final_grade',
        'behavior_score',
        'skill_score',
        'notes',
    ];

    protected $casts = [
        'daily_test' => 'decimal:2',
        'midterm_exam' => 'decimal:2',
        'final_exam' => 'decimal:2',
        'final_grade' => 'decimal:2',
        'behavior_score' => 'decimal:2',
        'skill_score' => 'decimal:2',
    ];

    /**
     * Get the student
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the subject
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the teacher who gave this grade
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Calculate final grade automatically
     */
    public function calculateFinalGrade()
    {
        $dailyWeight = 0.3;
        $midtermWeight = 0.3;
        $finalWeight = 0.4;

        $this->final_grade = 
            ($this->daily_test * $dailyWeight) +
            ($this->midterm_exam * $midtermWeight) +
            ($this->final_exam * $finalWeight);

        return $this->final_grade;
    }
}
