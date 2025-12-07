<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            ['code' => 'PAI', 'name' => 'Pendidikan Agama Islam', 'description' => 'Mata pelajaran Pendidikan Agama Islam'],
            ['code' => 'PKN', 'name' => 'Pendidikan Kewarganegaraan', 'description' => 'Mata pelajaran PKN'],
            ['code' => 'BIND', 'name' => 'Bahasa Indonesia', 'description' => 'Mata pelajaran Bahasa Indonesia'],
            ['code' => 'MAT', 'name' => 'Matematika', 'description' => 'Mata pelajaran Matematika'],
            ['code' => 'IPA', 'name' => 'Ilmu Pengetahuan Alam', 'description' => 'Mata pelajaran IPA'],
            ['code' => 'IPS', 'name' => 'Ilmu Pengetahuan Sosial', 'description' => 'Mata pelajaran IPS'],
            ['code' => 'BING', 'name' => 'Bahasa Inggris', 'description' => 'Mata pelajaran Bahasa Inggris'],
            ['code' => 'SBD', 'name' => 'Seni Budaya', 'description' => 'Mata pelajaran Seni Budaya'],
            ['code' => 'PJOK', 'name' => 'Pendidikan Jasmani dan Kesehatan', 'description' => 'Mata pelajaran PJOK'],
            ['code' => 'PKWU', 'name' => 'Prakarya dan Kewirausahaan', 'description' => 'Mata pelajaran Prakarya'],
            ['code' => 'BSUN', 'name' => 'Bahasa Sunda', 'description' => 'Mata pelajaran Bahasa Daerah (Sunda)'],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
