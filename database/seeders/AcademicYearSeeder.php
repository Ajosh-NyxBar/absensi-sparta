<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicYear;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYears = [
            [
                'year' => '2023/2024',
                'semester' => 'Ganjil',
                'start_date' => '2023-07-17',
                'end_date' => '2023-12-23',
                'is_active' => false,
                'description' => 'Tahun ajaran 2023/2024 semester ganjil',
            ],
            [
                'year' => '2023/2024',
                'semester' => 'Genap',
                'start_date' => '2024-01-08',
                'end_date' => '2024-06-29',
                'is_active' => false,
                'description' => 'Tahun ajaran 2023/2024 semester genap',
            ],
            [
                'year' => '2024/2025',
                'semester' => 'Ganjil',
                'start_date' => '2024-07-15',
                'end_date' => '2024-12-21',
                'is_active' => true,
                'description' => 'Tahun ajaran 2024/2025 semester ganjil (Aktif)',
            ],
            [
                'year' => '2024/2025',
                'semester' => 'Genap',
                'start_date' => '2025-01-06',
                'end_date' => '2025-06-28',
                'is_active' => false,
                'description' => 'Tahun ajaran 2024/2025 semester genap',
            ],
            [
                'year' => '2025/2026',
                'semester' => 'Ganjil',
                'start_date' => '2025-07-14',
                'end_date' => '2025-12-20',
                'is_active' => false,
                'description' => 'Tahun ajaran 2025/2026 semester ganjil',
            ],
        ];

        foreach ($academicYears as $year) {
            AcademicYear::create($year);
        }
    }
}
