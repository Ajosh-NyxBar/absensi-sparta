<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\Criteria;
use App\Models\Grade;
use App\Models\Student;
use App\Models\StudentAssessment;
use App\Services\SAWService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StudentAssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Menghitung SAW untuk semua kelas berdasarkan data grades & attendance yang sudah di-seed.
     */
    public function run(): void
    {
        $semester = 'Ganjil';
        $academicYear = '2025/2026';

        $classes = ClassRoom::with(['students' => function ($q) {
            $q->where('status', 'active');
        }])->get();

        $criteria = Criteria::forStudent();

        if ($criteria->isEmpty()) {
            $this->command->warn('Kriteria siswa belum tersedia. Jalankan CriteriaSeeder terlebih dahulu.');
            return;
        }

        $sawService = app(SAWService::class);

        // Tanggal yang digunakan untuk menghitung kehadiran
        // Semester Ganjil 2025/2026: 14 Juli 2025 - 20 Desember 2025
        $attendanceStart = Carbon::create(2025, 7, 14);
        $attendanceEnd = Carbon::create(2025, 12, 20);

        $totalAssessments = 0;

        foreach ($classes as $class) {
            $students = $class->students;

            if ($students->isEmpty()) {
                continue;
            }

            $studentData = collect();

            foreach ($students as $student) {
                // Rata-rata nilai akademik dari tabel grades
                $academicScore = Grade::where('student_id', $student->id)
                    ->where('semester', $semester)
                    ->where('academic_year', $academicYear)
                    ->avg('final_grade') ?? 0;

                // Persentase kehadiran dari data attendance yang ada
                $attendanceScore = $student->getAttendancePercentage(
                    $attendanceStart,
                    $attendanceEnd
                );

                // Rata-rata skor perilaku
                $behaviorScore = Grade::where('student_id', $student->id)
                    ->where('semester', $semester)
                    ->where('academic_year', $academicYear)
                    ->avg('behavior_score') ?? 0;

                // Rata-rata skor keterampilan
                $skillScore = Grade::where('student_id', $student->id)
                    ->where('semester', $semester)
                    ->where('academic_year', $academicYear)
                    ->avg('skill_score') ?? 0;

                $studentData->push((object) [
                    'student_id'       => $student->id,
                    'class_id'         => $class->id,
                    'semester'         => $semester,
                    'academic_year'    => $academicYear,
                    'academic_score'   => round($academicScore, 2),
                    'attendance_score' => round($attendanceScore, 2),
                    'behavior_score'   => round($behaviorScore, 2),
                    'skill_score'      => round($skillScore, 2),
                ]);
            }

            // Hitung SAW & ranking
            $rankedData = $sawService->calculate($studentData, 'student');

            // Simpan ke tabel student_assessments
            foreach ($rankedData as $data) {
                StudentAssessment::updateOrCreate(
                    [
                        'student_id'    => $data->student_id,
                        'semester'      => $data->semester,
                        'academic_year' => $data->academic_year,
                    ],
                    [
                        'class_id'         => $data->class_id,
                        'academic_score'   => $data->academic_score,
                        'attendance_score' => $data->attendance_score,
                        'behavior_score'   => $data->behavior_score,
                        'skill_score'      => $data->skill_score,
                        'saw_score'        => $data->saw_score,
                        'rank'             => $data->rank,
                    ]
                );
                $totalAssessments++;
            }

            $this->command->info("  ✓ Kelas {$class->name}: {$students->count()} siswa — Ranking SAW dihitung");
        }

        $this->command->info("Selesai! Total {$totalAssessments} penilaian SAW siswa berhasil dibuat.");
        $this->command->info("Semester: {$semester} | Tahun Ajaran: {$academicYear}");
    }
}
