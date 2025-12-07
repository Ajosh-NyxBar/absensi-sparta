<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Criteria extends Model
{
    use HasFactory;

    protected $table = 'criteria';

    protected $fillable = [
        'code',
        'name',
        'type',
        'weight',
        'for',
        'description',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
    ];

    /**
     * Get all student criteria
     */
    public static function forStudent()
    {
        return self::where('for', 'student')->get();
    }

    /**
     * Get all teacher criteria
     */
    public static function forTeacher()
    {
        return self::where('for', 'teacher')->get();
    }

    /**
     * Check if criteria is benefit type
     */
    public function isBenefit()
    {
        return $this->type === 'benefit';
    }

    /**
     * Check if criteria is cost type
     */
    public function isCost()
    {
        return $this->type === 'cost';
    }
}
