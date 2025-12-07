<?php

namespace Database\Seeders;

use App\Models\Criteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kriteria untuk penilaian siswa
        $studentCriteria = [
            [
                'code' => 'C1',
                'name' => 'Nilai Akademik',
                'type' => 'benefit',
                'weight' => 0.35,
                'for' => 'student',
                'description' => 'Rata-rata nilai mata pelajaran'
            ],
            [
                'code' => 'C2',
                'name' => 'Kehadiran',
                'type' => 'benefit',
                'weight' => 0.25,
                'for' => 'student',
                'description' => 'Persentase kehadiran siswa'
            ],
            [
                'code' => 'C3',
                'name' => 'Sikap/Perilaku',
                'type' => 'benefit',
                'weight' => 0.20,
                'for' => 'student',
                'description' => 'Penilaian sikap dan perilaku'
            ],
            [
                'code' => 'C4',
                'name' => 'Keterampilan',
                'type' => 'benefit',
                'weight' => 0.20,
                'for' => 'student',
                'description' => 'Penilaian keterampilan praktik'
            ],
        ];

        // Kriteria untuk penilaian guru
        $teacherCriteria = [
            [
                'code' => 'K1',
                'name' => 'Kehadiran',
                'type' => 'benefit',
                'weight' => 0.30,
                'for' => 'teacher',
                'description' => 'Persentase kehadiran guru'
            ],
            [
                'code' => 'K2',
                'name' => 'Kualitas Mengajar',
                'type' => 'benefit',
                'weight' => 0.25,
                'for' => 'teacher',
                'description' => 'Penilaian kualitas pengajaran'
            ],
            [
                'code' => 'K3',
                'name' => 'Prestasi Siswa',
                'type' => 'benefit',
                'weight' => 0.25,
                'for' => 'teacher',
                'description' => 'Rata-rata prestasi siswa yang diajar'
            ],
            [
                'code' => 'K4',
                'name' => 'Kedisiplinan',
                'type' => 'benefit',
                'weight' => 0.20,
                'for' => 'teacher',
                'description' => 'Penilaian kedisiplinan guru'
            ],
        ];

        foreach ($studentCriteria as $criteria) {
            Criteria::create($criteria);
        }

        foreach ($teacherCriteria as $criteria) {
            Criteria::create($criteria);
        }
    }
}
