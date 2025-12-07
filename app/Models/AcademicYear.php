<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'semester',
        'start_date',
        'end_date',
        'is_active',
        'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get active academic year
     */
    public static function getActive()
    {
        return self::where('is_active', true)->first();
    }

    /**
     * Set this as active academic year (deactivate others)
     */
    public function setAsActive()
    {
        // Deactivate all others
        self::where('id', '!=', $this->id)->update(['is_active' => false]);
        
        // Activate this one
        $this->is_active = true;
        $this->save();
        
        return $this;
    }

    /**
     * Get full name (Year - Semester)
     */
    public function getFullNameAttribute()
    {
        return "{$this->year} - Semester {$this->semester}";
    }

    /**
     * Check if can be deleted
     */
    public function canBeDeleted()
    {
        // Check if used in classes
        $classesCount = \App\Models\ClassRoom::where('academic_year', $this->year)->count();
        
        // Check if used in grades
        $gradesCount = \App\Models\Grade::where('academic_year', $this->year)->count();
        
        return $classesCount === 0 && $gradesCount === 0;
    }

    /**
     * Get related data info
     */
    public function getRelatedDataInfo()
    {
        $classesCount = \App\Models\ClassRoom::where('academic_year', $this->year)->count();
        $gradesCount = \App\Models\Grade::where('academic_year', $this->year)->count();
        
        return [
            'classes' => $classesCount,
            'grades' => $gradesCount,
        ];
    }
}
