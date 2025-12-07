<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYear = '2024/2025';
        $classes = [];

        // Generate kelas VII, VIII, IX dengan 6 rombel (A-F)
        $grades = [
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX'
        ];

        foreach ($grades as $gradeNumber => $gradeRoman) {
            foreach (['A', 'B', 'C', 'D', 'E', 'F'] as $section) {
                $classes[] = [
                    'name' => $gradeRoman . '-' . $section,
                    'grade' => (string)$gradeNumber,
                    'academic_year' => $academicYear,
                    'capacity' => 32,
                ];
            }
        }

        foreach ($classes as $class) {
            ClassRoom::create($class);
        }
    }
}
