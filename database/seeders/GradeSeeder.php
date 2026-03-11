<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradeSeeder extends Seeder
{
    /**
     * Mapping guru ke mata pelajaran berdasarkan data TeacherSeeder.
     * Key = keyword di kolom `subject` guru, Value = kode mata pelajaran.
     */
    private function getTeacherSubjectMap(): array
    {
        return [
            'Matematika' => 'MAT',
            'Bhs Inggris' => 'BING',
            'Bahasa Inggris' => 'BING',
            'Bhs Sunda'   => 'BSUN',
            'Bahasa Sunda' => 'BSUN',
            'B. Sunda'    => 'BSUN',
            'Prakarya'    => 'PKWU',
            'IPS'         => 'IPS',
            'PJOK'        => 'PJOK',
            'IPA'         => 'IPA',
            'B. Indonesia' => 'BIND',
            'Bhs Indonesia' => 'BIND',
            'Bahasa Indonesia' => 'BIND',
            'PAI'         => 'PAI',
            'PKn'         => 'PKN',
            'Seni Budaya' => 'SBD',
            'BP/BK'       => null, 
            'Guru Madya'  => null, 
        ];
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYear = '2025/2026';
        $semester = 'Ganjil';

        // Ambil semua data
        $subjects = Subject::all()->keyBy('code');
        $classes = ClassRoom::with('students')->get();
        $teachers = Teacher::all();

        if ($subjects->isEmpty() || $classes->isEmpty() || $teachers->isEmpty()) {
            $this->command->warn('Data subjects/classes/teachers belum tersedia. Jalankan seeder lain terlebih dahulu.');
            return;
        }

        // ── Mapping guru -> subject_id ──
        $teacherSubjectMap = $this->getTeacherSubjectMap();
        $subjectTeachers = []; // subject_code => [teacher_ids]

        foreach ($teachers as $teacher) {
            // Cari keyword yang cocok di field `subject` guru (dari TeacherSeeder)
            // Karena field subject tidak ada di tabel teachers, kita gunakan
            // data yang sudah ada. Kita assign tiap guru ke 1 mapel.
            // Kita ambil dari nama guru yang sudah kita ketahui.
        }

        // Karena tabel teachers tidak punya field `subject`, kita buat mapping
        // berdasarkan urutan guru dari TeacherSeeder.
        $teacherSubjectAssign = [
            // teacher_id => subject_code (berdasarkan urutan di TeacherSeeder)
            1  => 'MAT',   // Yaiti Apriyah - Matematika
            2  => null,     // Tati Karwati - Guru Madya (skip)
            3  => 'BING',  // Dra. Engkur Kurniati - Bhs Inggris
            4  => 'MAT',   // Hidayat - Matematika
            5  => 'BSUN',  // Nunung Rafiha - Bhs Sunda
            6  => 'PKWU',  // Dra Yuli Suparmii - Prakarya
            7  => 'IPS',   // Ratna Hardini - IPS
            8  => 'PJOK',  // Cucu Kosasih - PJOK
            9  => 'IPA',   // Dra. Midla Martha - IPA
            10 => 'IPS',   // Gocep Dukin - IPS
            11 => 'IPS',   // E. Rakhmah - IPS
            12 => 'BIND',  // Supenti - B. Indonesia
            13 => 'IPS',   // Sri Harlati - IPS
            14 => 'BING',  // Kartini - Bhs Inggris
            15 => 'BING',  // Endang Suryati - Bhs Inggris
            16 => 'MAT',   // Wening Hidayah - Matematika
            17 => 'IPA',   // Agus Herdiana - IPA
            18 => 'PAI',   // Maya Herawati - PAI
            19 => 'PKN',   // Ude Suhaenah - PKn
            20 => 'BIND',  // Siti Nurhasanah - B. Indonesia
            21 => 'PAI',   // Abdurahman - PAI
            22 => 'PJOK',  // Pian Anianto - PJOK
            23 => 'MAT',   // Yeyen Hendrayani - Matematika
            24 => 'PKWU',  // Nia Dayuwariti - Prakarya
            25 => 'IPA',   // Sumipi Megasari - IPA
            26 => null,     // Nurul Khoeriyah - BP/BK (skip)
            27 => 'MAT',   // Irfan Nurkhotis - Matematika
            28 => 'PJOK',  // Lukman Hakim - PJOK
            29 => 'BSUN',  // Lia Nurnengsih - B. Sunda
            30 => 'PKWU',  // Noneng Nurayish - Prakarya
            31 => 'BSUN',  // Nuraisyah - Bahasa Sunda
        ];

        // Bangun subjectTeachers: code => [teacher_id, ...]
        foreach ($teacherSubjectAssign as $tId => $code) {
            if ($code === null) continue;
            if (!$subjects->has($code)) continue;
            $subjectTeachers[$code][] = $tId;
        }

        // Pastikan semua mapel punya setidaknya 1 guru (fallback ke guru pertama)
        $fallbackTeacherId = $teachers->first()->id;
        foreach ($subjects as $code => $subject) {
            if (!isset($subjectTeachers[$code]) || empty($subjectTeachers[$code])) {
                // Cari guru SBD -> assign ke guru prakarya terdekat, atau fallback
                $subjectTeachers[$code] = [$fallbackTeacherId];
            }
        }

        $this->command->info("Semester: {$semester} | Tahun Ajaran: {$academicYear}");
        $this->command->info('Jumlah mapel: ' . $subjects->count());
        $this->command->info('Jumlah kelas: ' . $classes->count());

        $batch = [];
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $totalGrades = 0;

        foreach ($classes as $class) {
            $students = $class->students->where('status', 'active');

            if ($students->isEmpty()) continue;

            foreach ($subjects as $code => $subject) {
                // Pilih guru untuk mapel ini
                $teacherPool = $subjectTeachers[$code];
                $teacherId = $teacherPool[array_rand($teacherPool)];

                foreach ($students as $student) {
                    // Generate nilai realistis (distribusi normal-ish)
                    $dailyTest   = $this->generateScore(65, 95);
                    $midtermExam = $this->generateScore(60, 92);
                    $finalExam   = $this->generateScore(58, 95);

                    // Hitung nilai akhir: 30% UH + 30% UTS + 40% UAS
                    $finalGrade = round(($dailyTest * 0.3) + ($midtermExam * 0.3) + ($finalExam * 0.4), 2);

                    // Skor perilaku & keterampilan
                    $behaviorScore = $this->generateScore(70, 95);
                    $skillScore    = $this->generateScore(68, 95);

                    $batch[] = [
                        'student_id'     => $student->id,
                        'subject_id'     => $subject->id,
                        'teacher_id'     => $teacherId,
                        'semester'       => $semester,
                        'academic_year'  => $academicYear,
                        'daily_test'     => $dailyTest,
                        'midterm_exam'   => $midtermExam,
                        'final_exam'     => $finalExam,
                        'final_grade'    => $finalGrade,
                        'behavior_score' => $behaviorScore,
                        'skill_score'    => $skillScore,
                        'notes'          => null,
                        'created_at'     => $now,
                        'updated_at'     => $now,
                    ];

                    $totalGrades++;

                    // Batch insert per 500 record
                    if (count($batch) >= 500) {
                        DB::table('grades')->insert($batch);
                        $batch = [];
                    }
                }
            }

            $this->command->info("  ✓ Kelas {$class->name}: {$students->count()} siswa × {$subjects->count()} mapel");
        }

        // Sisa batch
        if (!empty($batch)) {
            DB::table('grades')->insert($batch);
        }

        $this->command->info("Selesai! Total {$totalGrades} record nilai berhasil dibuat.");
    }

    /**
     * Generate nilai acak yang realistis dengan distribusi mendekati normal.
     * Mayoritas siswa mendapat nilai di rentang tengah-atas.
     */
    private function generateScore(float $min, float $max): float
    {
        // Gunakan rata-rata dari beberapa random untuk mendekati distribusi normal
        $sum = 0;
        for ($i = 0; $i < 3; $i++) {
            $sum += mt_rand((int)($min * 100), (int)($max * 100));
        }
        return round($sum / 300, 2);
    }
}
