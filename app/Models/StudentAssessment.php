<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'class_id',
        'semester',
        'academic_year',
        'academic_score',
        'attendance_score',
        'behavior_score',
        'skill_score',
        'saw_score',
        'rank',
    ];

    protected $casts = [
        'academic_score' => 'decimal:2',
        'attendance_score' => 'decimal:2',
        'behavior_score' => 'decimal:2',
        'skill_score' => 'decimal:2',
        'saw_score' => 'decimal:2',
    ];

    /**
     * Get the student
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the class
     */
    public function classRoom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }
}
