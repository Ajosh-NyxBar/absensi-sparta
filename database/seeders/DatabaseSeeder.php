<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            TeacherSeeder::class,
            SubjectSeeder::class,
            ClassSeeder::class,
            StudentSeeder::class,
            AcademicYearSeeder::class,
            SettingSeeder::class,
            CriteriaSeeder::class,
            TeacherSubjectAssignmentSeeder::class,
            AttendanceSeeder::class,
            GradeSeeder::class,
            StudentAssessmentSeeder::class,
            TeacherAssessmentSeeder::class,
        ]);
    }
}
