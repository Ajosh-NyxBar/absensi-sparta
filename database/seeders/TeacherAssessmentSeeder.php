<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\TeacherAssessment;
use Illuminate\Database\Seeder;

class TeacherAssessmentSeeder extends Seeder
{
    /**
     * Seed penilaian guru (K2 Kualitas Mengajar & K4 Kedisiplinan).
     * K1 (Kehadiran) dan K3 (Prestasi Siswa) dihitung otomatis.
     */
    public function run(): void
    {
        $teachers = Teacher::all();
        $academicYear = '2025/2026';
        $period = 'Ganjil';

        $count = 0;

        foreach ($teachers as $teacher) {
            // K2: Kualitas Mengajar (manual input, 70-95)
            $teachingQuality = fake()->randomFloat(2, 72, 95);

            // K4: Kedisiplinan (manual input, 75-98)
            $disciplineScore = fake()->randomFloat(2, 75, 98);

            TeacherAssessment::create([
                'teacher_id'          => $teacher->id,
                'period'              => $period,
                'academic_year'       => $academicYear,
                'attendance_score'    => 0, // placeholder, dihitung otomatis saat SAW
                'teaching_quality'    => $teachingQuality,
                'student_achievement' => 0, // placeholder, dihitung otomatis saat SAW
                'discipline_score'    => $disciplineScore,
            ]);
            $count++;
        }

        $this->command->info("✓ {$count} penilaian guru (K2 & K4) berhasil dibuat.");
    }
}
