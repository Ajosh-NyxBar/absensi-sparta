<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\TeacherSubject;
use Illuminate\Database\Seeder;

class TeacherSubjectAssignmentSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = Subject::all()->keyBy('code');
        $classes  = ClassRoom::orderBy('grade')->orderBy('name')->get();
        $teachers = Teacher::all();

        if ($teachers->isEmpty() || $classes->isEmpty() || $subjects->isEmpty()) {
            $this->command->warn('⚠ Data guru/kelas/mapel belum ada. Skip seeder.');
            return;
        }

        // ──────────────────────────────────────────────
        // Mapping nama guru -> kode mapel
        // Karena kolom 'subject' tidak ada di tabel teachers,
        // kita cocokkan berdasarkan nama guru.
        // ──────────────────────────────────────────────
        $teacherNameToSubject = [
            'Guru Matematika'   => 'MAT',  // dari UserSeeder
            'Yaiti Apriyah'     => 'MAT',
            'Tati Karwati'      => 'SBD',   // Guru Madya -> Seni Budaya
            'Engkur Kurniati'   => 'BING',
            'Hidayat'           => 'MAT',
            'Nunung Rafiha'     => 'BSUN',
            'Yuli Suparmii'     => 'PKWU',
            'Ratna Hardini'     => 'IPS',
            'Cucu Kosasih'      => 'PJOK',
            'Midla Martha'      => 'IPA',
            'Gocep Dukin'       => 'IPS',
            'Rakhmah'           => 'IPS',
            'Supenti'           => 'BIND',
            'Sri Harlati'       => 'IPS',
            'Kartini'           => 'BING',
            'Endang Suryati'    => 'BING',
            'Wening Hidayah'    => 'MAT',
            'Agus Herdiana'     => 'IPA',
            'Maya Herawati'     => 'PAI',
            'Ude Suhaenah'      => 'PKN',
            'Siti Nurhasanah'   => 'BIND',
            'Abdurahman'        => 'PAI',
            'Pian Anianto'      => 'PJOK',
            'Yeyen Hendrayani'  => 'MAT',
            'Nia Dayuwariti'    => 'PKWU',
            'Sumipi Megasari'   => 'IPA',
            'Nurul Khoeriyah'   => 'PKN',   // BP/BK -> PKn
            'Irfan Nurkhotis'   => 'MAT',
            'Lukman Hakim'      => 'PJOK',
            'Lia Nurnengsih'    => 'BSUN',
            'Noneng Nurayish'   => 'PKWU',
            'Nuraisyah'         => 'BSUN',
        ];

        $subjectTeachers = []; // code => [teacher_id, ...]

        foreach ($teachers as $teacher) {
            foreach ($teacherNameToSubject as $nameFragment => $code) {
                if ($code !== null && str_contains($teacher->name, $nameFragment)) {
                    $subjectTeachers[$code][] = $teacher->id;
                    break;
                }
            }
        }

        // Fallback: SBD belum ada guru khusus -> assign guru Prakarya
        if (!isset($subjectTeachers['SBD'])) {
            $subjectTeachers['SBD'] = $subjectTeachers['PKWU'] ?? [$teachers->first()->id];
        }

        $academicYear = '2025/2026';
        $totalAssigned = 0;
        $subjectIdx = [];

        foreach ($classes as $class) {
            foreach ($subjects as $code => $subject) {
                $pool = $subjectTeachers[$code] ?? null;
                if (!$pool) continue; // skip jika tidak ada guru untuk mapel ini

                if (!isset($subjectIdx[$code])) {
                    $subjectIdx[$code] = 0;
                }

                $teacherId = $pool[$subjectIdx[$code] % count($pool)];
                $subjectIdx[$code]++;

                TeacherSubject::create([
                    'teacher_id'    => $teacherId,
                    'subject_id'    => $subject->id,
                    'class_id'      => $class->id,
                    'academic_year' => $academicYear,
                ]);
                $totalAssigned++;
            }
        }

        $this->command->info("✓ {$totalAssigned} penugasan guru-mapel-kelas berhasil dibuat.");

        // ──────────────────────────────────────────────
        // WALI KELAS — assign berdasarkan nama guru
        // ──────────────────────────────────────────────
        $homeroomNames = [
            'VII-A'  => 'Yaiti Apriyah',
            'VII-B'  => 'Engkur Kurniati',
            'VII-C'  => 'Midla Martha',
            'VII-D'  => 'Supenti',
            'VII-E'  => 'Maya Herawati',
            'VII-F'  => 'Ratna Hardini',
            'VIII-A' => 'Hidayat',
            'VIII-B' => 'Kartini',
            'VIII-C' => 'Agus Herdiana',
            'VIII-D' => 'Siti Nurhasanah',
            'VIII-E' => 'Ude Suhaenah',
            'VIII-F' => 'Gocep Dukin',
            'IX-A'   => 'Wening Hidayah',
            'IX-B'   => 'Endang Suryati',
            'IX-C'   => 'Sumipi Megasari',
            'IX-D'   => 'Abdurahman',
            'IX-E'   => 'Cucu Kosasih',
            'IX-F'   => 'Nunung Rafiha',
        ];

        $waliCount = 0;
        foreach ($classes as $class) {
            $nameFragment = $homeroomNames[$class->name] ?? null;
            if (!$nameFragment) continue;

            $teacher = $teachers->first(fn($t) => str_contains($t->name, $nameFragment));
            if (!$teacher) continue;

            $class->update(['homeroom_teacher_id' => $teacher->id]);
            $waliCount++;
            $this->command->info("  Wali Kelas {$class->name}: {$teacher->name}");
        }

        $this->command->info("✓ {$waliCount} wali kelas berhasil ditugaskan.");
    }
}
