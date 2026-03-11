<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassRoom extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'grade',
        'academic_year',
        'capacity',
        'homeroom_teacher_id',
    ];

    /**
     * Get the homeroom teacher (wali kelas)
     */
    public function homeroomTeacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'homeroom_teacher_id');
    }

    /**
     * Get all students in this class
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    /**
     * Get all teacher subjects for this class
     */
    public function teacherSubjects(): HasMany
    {
        return $this->hasMany(TeacherSubject::class, 'class_id');
    }

    /**
     * Get all student assessments for this class
     */
    public function studentAssessments(): HasMany
    {
        return $this->hasMany(StudentAssessment::class, 'class_id');
    }
}
