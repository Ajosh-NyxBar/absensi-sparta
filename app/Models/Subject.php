<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
    ];

    /**
     * Get all teacher subjects for this subject
     */
    public function teacherSubjects(): HasMany
    {
        return $this->hasMany(TeacherSubject::class);
    }

    /**
     * Get all grades for this subject
     */
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }
}
