<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = ClassRoom::all();
        
        if ($classes->isEmpty()) {
            $this->command->warn('No classes found. Please run ClassSeeder first.');
            return;
        }

        $studentNames = [
            // Laki-laki
            'male' => [
                'Ahmad Rizki', 'Budi Santoso', 'Chandra Wijaya', 'Doni Prasetyo', 'Eko Saputra',
                'Fajar Ramadhan', 'Galih Pratama', 'Hendra Kurniawan', 'Indra Gunawan', 'Joko Susilo',
                'Kevin Andika', 'Lukman Hakim', 'Muhammad Iqbal', 'Naufal Azhar', 'Oscar Pratama',
                'Putra Mahendra', 'Qori Maulana', 'Reza Firmansyah', 'Surya Dinata', 'Toni Hermawan',
                'Umar Faruq', 'Vino Ramadhan', 'Wahyu Saputra', 'Xavier Wijaya', 'Yusuf Ibrahim',
                'Zaki Maulana', 'Aldo Permana', 'Bayu Kristianto', 'Candra Kusuma', 'Dimas Pratama',
            ],
            // Perempuan
            'female' => [
                'Aisyah Putri', 'Bella Safitri', 'Citra Dewi', 'Diana Sari', 'Eka Wulandari',
                'Fitri Handayani', 'Gita Permatasari', 'Hani Rahmawati', 'Indah Lestari', 'Jihan Azzahra',
                'Kirana Natasya', 'Lina Marlina', 'Maya Cantika', 'Nadia Syahputri', 'Olivia Maharani',
                'Putri Ayu', 'Qonita Zahra', 'Rina Anggraini', 'Siti Nurhaliza', 'Tika Amelia',
                'Umi Kalsum', 'Vanya Kristina', 'Wulan Sari', 'Xena Puspita', 'Yuni Kartika',
                'Zahra Amira', 'Anisa Rahma', 'Bunga Citra', 'Cindy Lestari', 'Dewi Anggraeni',
            ],
        ];

        $counter = 1;
        
        foreach ($classes as $class) {
            // Each class gets 30-35 students
            $studentsPerClass = rand(30, 35);
            
            for ($i = 0; $i < $studentsPerClass; $i++) {
                $gender = rand(0, 1) ? 'L' : 'P'; // L = Laki-laki, P = Perempuan
                $genderForName = $gender === 'L' ? 'male' : 'female';
                $name = $studentNames[$genderForName][array_rand($studentNames[$genderForName])];
                
                // Add number to name if it already exists
                $baseName = $name;
                $suffix = 1;
                while (Student::where('name', $name)->exists()) {
                    $name = $baseName . ' ' . chr(64 + $suffix); // A, B, C, etc.
                    $suffix++;
                }
                
                $nisn = '00' . str_pad($counter, 8, '0', STR_PAD_LEFT);
                $nis = str_pad($counter, 6, '0', STR_PAD_LEFT);
                
                // Birth year based on class grade (assuming age 12-15 for grades 7-9)
                $currentYear = date('Y');
                $age = 12 + (9 - $class->grade); // Grade 9 = 12 years old, Grade 7 = 14 years old
                $birthYear = $currentYear - $age;
                $birthMonth = rand(1, 12);
                $birthDay = rand(1, 28);
                
                Student::create([
                    'class_id' => $class->id,
                    'nisn' => $nisn,
                    'nis' => $nis,
                    'name' => $name,
                    'gender' => $gender,
                    'phone' => '08' . rand(1000000000, 9999999999),
                    'address' => 'Jl. Pendidikan No. ' . rand(1, 100) . ', Jakarta',
                    'birth_date' => sprintf('%d-%02d-%02d', $birthYear, $birthMonth, $birthDay),
                    'birth_place' => ['Jakarta', 'Bandung', 'Surabaya', 'Medan', 'Semarang'][array_rand(['Jakarta', 'Bandung', 'Surabaya', 'Medan', 'Semarang'])],
                    'photo' => null,
                    'parent_name' => 'Orang Tua ' . $name,
                    'parent_phone' => '08' . rand(1000000000, 9999999999),
                    'status' => 'active',
                ]);
                
                $counter++;
            }
        }

        $this->command->info('Students seeded successfully: ' . ($counter - 1) . ' students created.');
    }
}
