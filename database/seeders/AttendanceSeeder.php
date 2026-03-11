<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Teacher;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceSeeder extends Seeder
{
    /**
     * ===================================================================
     * ATTENDANCE SEEDER
     * Semester Ganjil 2025/2026: 14 Juli 2025 – 20 Desember 2025
     * Semester Genap 2025/2026: 5 Januari 2026 – 12 Maret 2026
     * ===================================================================
     *
     * Target rata-rata kehadiran guru keseluruhan ≈ 93%
     * Target rata-rata kehadiran siswa keseluruhan ≈ 95%
     */

    // Koordinat SMPN 4 Purwakarta
    private const SCHOOL_LAT  = -6.556290;
    private const SCHOOL_LNG  = 107.443508;

    /**
     * Hari libur nasional & cuti bersama
     */
    private function getHolidays(): array
    {
        return [
            // Semester Ganjil 2025/2026
            '2025-07-17', // Hari Raya Idul Adha
            '2025-07-18', // Cuti Bersama Idul Adha
            '2025-08-08', // Tahun Baru Islam
            '2025-08-17', // Hari Kemerdekaan RI
            '2025-10-06', // Maulid Nabi Muhammad SAW
            '2025-12-25', // Hari Natal
            // Semester Genap 2025/2026
            '2026-01-01', // Tahun Baru Masehi
            '2026-01-29', // Tahun Baru Imlek
            '2026-02-17', // Isra Mi'raj Nabi Muhammad SAW
            '2026-03-03', // Hari Raya Nyepi
        ];
    }

    /**
     * Generate array rate kehadiran acak per guru yang rata-ratanya mendekati target.
     *
     * Strategi:
     * - Gunakan distribusi normal-ish sekitar target mean 93
     * - Range individu: 85 – 100
     * - Rata-rata keseluruhan mendekati 93
     */
    private function generateRates(int $count, float $targetMean = 93.0): array
    {
        $rates = [];
        $minRate = 85;
        $maxRate = 100;

        for ($i = 0; $i < $count; $i++) {
            // Gunakan Box-Muller-like approach: rata-rata 3 random → normal-ish
            // Bias ke arah targetMean
            $r1 = rand($minRate * 10, $maxRate * 10) / 10;
            $r2 = rand($minRate * 10, $maxRate * 10) / 10;
            $r3 = rand($minRate * 10, $maxRate * 10) / 10;
            $avg = ($r1 + $r2 + $r3) / 3;

            // Dorong ke arah target
            $rate = round($avg * 0.6 + $targetMean * 0.4);
            $rate = max($minRate, min($maxRate, $rate));
            $rates[] = (int) $rate;
        }

        // Adjust agar rata-rata mendekati target
        $currentMean = array_sum($rates) / $count;
        $diff = $targetMean - $currentMean;

        // Distribusikan selisih secara acak
        $adjustCount = abs((int) round($diff * $count / 2));
        $direction = $diff > 0 ? 1 : -1;

        for ($i = 0; $i < $adjustCount && $i < $count; $i++) {
            $idx = rand(0, $count - 1);
            $rates[$idx] = max($minRate, min($maxRate, $rates[$idx] + $direction));
        }

        return $rates;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = Teacher::all();
        $students = Student::all();
        $holidays = $this->getHolidays();
        $now = Carbon::now()->format('Y-m-d H:i:s');

        // ============================================
        // SEMESTER GANJIL 2025/2026
        // Periode: 14 Juli 2025 – 20 Desember 2025
        // (Semester selesai, semua check-in + check-out)
        // ============================================
        $this->seedSemester(
            label: 'Ganjil 2025/2026',
            startDate: Carbon::create(2025, 7, 14),
            endDate: Carbon::create(2025, 12, 20),
            todayDate: null, // semester selesai, tidak ada "hari ini"
            teachers: $teachers,
            students: $students,
            holidays: $holidays,
            now: $now,
            teacherTargetRate: 93.0,
            studentTargetRate: 95.0,
        );

        // ============================================
        // SEMESTER GENAP 2025/2026
        // Periode: 5 Januari 2026 – 12 Maret 2026
        // (Semester berjalan, 12 Maret = hari ini)
        // ============================================
        $this->seedSemester(
            label: 'Genap 2025/2026',
            startDate: Carbon::create(2026, 1, 5),
            endDate: Carbon::create(2026, 3, 11),
            todayDate: Carbon::create(2026, 3, 12),
            teachers: $teachers,
            students: $students,
            holidays: $holidays,
            now: $now,
            teacherTargetRate: 93.0,
            studentTargetRate: 95.0,
        );
    }

    /**
     * Seed attendance data for one semester.
     */
    private function seedSemester(
        string $label,
        Carbon $startDate,
        Carbon $endDate,
        ?Carbon $todayDate,
        $teachers,
        $students,
        array $holidays,
        string $now,
        float $teacherTargetRate,
        float $studentTargetRate,
    ): void
    {
        $schoolDays     = []; // tanggal dgn check-in + check-out
        $todaySchoolDay = null;

        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            if (!$currentDate->isWeekend() && !in_array($currentDate->format('Y-m-d'), $holidays)) {
                $schoolDays[] = $currentDate->format('Y-m-d');
            }
            $currentDate->addDay();
        }

        // Cek apakah "hari ini" hari kerja
        if ($todayDate && !$todayDate->isWeekend() && !in_array($todayDate->format('Y-m-d'), $holidays)) {
            $todaySchoolDay = $todayDate->format('Y-m-d');
        }

        $totalPastDays = count($schoolDays);
        $totalAllDays  = $totalPastDays + ($todaySchoolDay ? 1 : 0);

        $displayEnd = $todayDate ?? $endDate;

        $this->command->info("═══════════════════════════════════════════════════");
        $this->command->info("  SEEDER ABSENSI — Semester {$label}");
        $this->command->info("═══════════════════════════════════════════════════");
        $this->command->info("Periode        : {$startDate->format('d M Y')} – {$displayEnd->format('d M Y')}");
        $this->command->info("Hari kerja     : {$totalPastDays} hari (check-in+out) + " . ($todaySchoolDay ? "1 hari (check-in only)" : "0"));
        $this->command->info("Total hari     : {$totalAllDays}");
        $this->command->info("Jumlah guru    : {$teachers->count()}");
        $this->command->info("Jumlah siswa   : {$students->count()}");
        $this->command->info("Target avg     : ~{$teacherTargetRate}% kehadiran guru");
        $this->command->info("───────────────────────────────────────────────────");

        // ══════════════════════════════════════════════════
        // GURU — Target rata-rata ~93%
        // ══════════════════════════════════════════════════
        $this->command->info('');
        $this->command->info('📋 Membuat data absensi guru...');

        $teacherRates = $this->generateRates($teachers->count(), $teacherTargetRate);
        $batch = [];
        $teacherStats = [];

        foreach ($teachers as $tIdx => $teacher) {
            $rate = $teacherRates[$tIdx];
            $presentCount = (int) round($totalAllDays * $rate / 100);
            $presentCount = max(0, min($presentCount, $totalAllDays));
            $absentCount  = $totalAllDays - $presentCount;

            // Pilih tanggal absen secara acak
            $allDays = $schoolDays;
            if ($todaySchoolDay) {
                $allDays[] = $todaySchoolDay;
            }

            $absentDaySet = [];
            if ($absentCount > 0) {
                // Pilih tanggal absen dari hari-hari yang sudah selesai saja
                $candidateDays = $schoolDays;
                if ($absentCount <= count($candidateDays)) {
                    $absentIndices = (array) array_rand($candidateDays, $absentCount);
                    foreach ($absentIndices as $ai) {
                        $absentDaySet[$candidateDays[$ai]] = true;
                    }
                } else {
                    // Jika absent count > candidate days, semua candidate absent
                    foreach ($candidateDays as $cd) {
                        $absentDaySet[$cd] = true;
                    }
                }
            }

            $hadir = 0;
            $tidakHadir = 0;

            // --- Hari-hari sebelumnya (check-in + check-out) ---
            foreach ($schoolDays as $dateStr) {
                $isPresent = !isset($absentDaySet[$dateStr]);

                if ($isPresent) {
                    $hadir++;
                    $checkInMinute = rand(0, 45);
                    $checkIn = "{$dateStr} 07:" . str_pad($checkInMinute, 2, '0', STR_PAD_LEFT) . ':00';

                    $checkOutHour = rand(14, 15);
                    $checkOutMinute = ($checkOutHour === 15) ? rand(0, 30) : rand(0, 59);
                    $checkOut = "{$dateStr} {$checkOutHour}:" . str_pad($checkOutMinute, 2, '0', STR_PAD_LEFT) . ':00';

                    $status = $checkInMinute <= 30 ? 'present' : 'late';

                    $batch[] = [
                        'attendable_type' => 'App\\Models\\Teacher',
                        'attendable_id'   => $teacher->id,
                        'date'            => $dateStr,
                        'check_in'        => $checkIn,
                        'check_out'       => $checkOut,
                        'status'          => $status,
                        'latitude_in'     => round(self::SCHOOL_LAT + (rand(-50, 50) / 100000), 6),
                        'longitude_in'    => round(self::SCHOOL_LNG + (rand(-50, 50) / 100000), 6),
                        'latitude_out'    => round(self::SCHOOL_LAT + (rand(-50, 50) / 100000), 6),
                        'longitude_out'   => round(self::SCHOOL_LNG + (rand(-50, 50) / 100000), 6),
                        'qr_code'         => 'QR-' . strtoupper(uniqid()),
                        'notes'           => null,
                        'created_at'      => $now,
                        'updated_at'      => $now,
                    ];
                } else {
                    $tidakHadir++;
                    $absentReasons = [
                        ['status' => 'sick',       'note' => 'Sakit'],
                        ['status' => 'permission', 'note' => 'Izin urusan keluarga'],
                        ['status' => 'permission', 'note' => 'Izin keperluan dinas'],
                        ['status' => 'absent',     'note' => 'Tanpa keterangan'],
                    ];
                    $reason = $absentReasons[array_rand($absentReasons)];

                    $batch[] = [
                        'attendable_type' => 'App\\Models\\Teacher',
                        'attendable_id'   => $teacher->id,
                        'date'            => $dateStr,
                        'check_in'        => null,
                        'check_out'       => null,
                        'status'          => $reason['status'],
                        'latitude_in'     => null,
                        'longitude_in'    => null,
                        'latitude_out'    => null,
                        'longitude_out'   => null,
                        'qr_code'         => null,
                        'notes'           => $reason['note'],
                        'created_at'      => $now,
                        'updated_at'      => $now,
                    ];
                }

                if (count($batch) >= 500) {
                    DB::table('attendances')->insert($batch);
                    $batch = [];
                }
            }

            // --- Hari ini (check-in ONLY, belum check-out) ---
            if ($todaySchoolDay) {
                $hadir++;
                $checkInMinute = rand(0, 30);
                $checkIn = "{$todaySchoolDay} 07:" . str_pad($checkInMinute, 2, '0', STR_PAD_LEFT) . ':00';

                $status = $checkInMinute <= 30 ? 'present' : 'late';

                $batch[] = [
                    'attendable_type' => 'App\\Models\\Teacher',
                    'attendable_id'   => $teacher->id,
                    'date'            => $todaySchoolDay,
                    'check_in'        => $checkIn,
                    'check_out'       => null,  // belum check out
                    'status'          => $status,
                    'latitude_in'     => round(self::SCHOOL_LAT + (rand(-50, 50) / 100000), 6),
                    'longitude_in'    => round(self::SCHOOL_LNG + (rand(-50, 50) / 100000), 6),
                    'latitude_out'    => null,
                    'longitude_out'   => null,
                    'qr_code'         => 'QR-' . strtoupper(uniqid()),
                    'notes'           => null,
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];
            }

            $actualRate = $totalAllDays > 0 ? round(($hadir / $totalAllDays) * 100, 1) : 0;
            $teacherStats[] = [
                'name'  => $teacher->name,
                'rate'  => $actualRate,
                'hadir' => $hadir,
                'absen' => $tidakHadir,
            ];
        }

        // Flush sisa batch guru
        if (!empty($batch)) {
            DB::table('attendances')->insert($batch);
            $batch = [];
        }

        // Hitung & tampilkan statistik guru
        $allTeacherRates = array_column($teacherStats, 'rate');
        $avgTeacherRate  = count($allTeacherRates) > 0 ? round(array_sum($allTeacherRates) / count($allTeacherRates), 2) : 0;
        $minTeacherRate  = count($allTeacherRates) > 0 ? min($allTeacherRates) : 0;
        $maxTeacherRate  = count($allTeacherRates) > 0 ? max($allTeacherRates) : 0;

        $this->command->info("✓ Data absensi guru selesai.");
        $this->command->info("  Rata-rata kehadiran: {$avgTeacherRate}%");
        $this->command->info("  Range: {$minTeacherRate}% – {$maxTeacherRate}%");
        $this->command->info('');

        // Detail per guru
        $this->command->info("  Detail per guru:");
        foreach ($teacherStats as $ts) {
            $bar = str_repeat('█', (int) ($ts['rate'] / 5));
            $this->command->info("  {$bar} {$ts['rate']}% — {$ts['name']} (Hadir: {$ts['hadir']}, Absen: {$ts['absen']})");
        }

        // ══════════════════════════════════════════════════
        // SISWA — Target rata-rata ~95%
        // ══════════════════════════════════════════════════
        $this->command->info('');
        $this->command->info('📋 Membuat data absensi siswa...');

        $studentRates = $this->generateRates($students->count(), $studentTargetRate);
        $allStudentRates = [];

        foreach ($students as $sIdx => $student) {
            $rate = $studentRates[$sIdx];
            $presentCount = (int) round($totalAllDays * $rate / 100);
            $presentCount = max(0, min($presentCount, $totalAllDays));
            $absentCount  = $totalAllDays - $presentCount;

            $absentDaySet = [];
            if ($absentCount > 0) {
                $candidateDays = $schoolDays;
                if ($absentCount <= count($candidateDays)) {
                    $absentIndices = (array) array_rand($candidateDays, $absentCount);
                    foreach ($absentIndices as $ai) {
                        $absentDaySet[$candidateDays[$ai]] = true;
                    }
                } else {
                    foreach ($candidateDays as $cd) {
                        $absentDaySet[$cd] = true;
                    }
                }
            }

            $hadir = 0;

            // --- Hari-hari sebelumnya ---
            foreach ($schoolDays as $dateStr) {
                $isPresent = !isset($absentDaySet[$dateStr]);

                if ($isPresent) {
                    $hadir++;
                    $checkInHour   = 7;
                    $checkInMinute = rand(0, 30);
                    $checkIn = "{$dateStr} 07:" . str_pad($checkInMinute, 2, '0', STR_PAD_LEFT) . ':00';

                    $checkOutMinute = rand(0, 59);
                    $checkOut = "{$dateStr} 14:" . str_pad($checkOutMinute, 2, '0', STR_PAD_LEFT) . ':00';

                    $status = $checkInMinute <= 15 ? 'present' : 'late';

                    $batch[] = [
                        'attendable_type' => 'App\\Models\\Student',
                        'attendable_id'   => $student->id,
                        'date'            => $dateStr,
                        'check_in'        => $checkIn,
                        'check_out'       => $checkOut,
                        'status'          => $status,
                        'latitude_in'     => round(self::SCHOOL_LAT + (rand(-50, 50) / 100000), 6),
                        'longitude_in'    => round(self::SCHOOL_LNG + (rand(-50, 50) / 100000), 6),
                        'latitude_out'    => round(self::SCHOOL_LAT + (rand(-50, 50) / 100000), 6),
                        'longitude_out'   => round(self::SCHOOL_LNG + (rand(-50, 50) / 100000), 6),
                        'qr_code'         => 'QR-' . strtoupper(uniqid()),
                        'notes'           => null,
                        'created_at'      => $now,
                        'updated_at'      => $now,
                    ];
                } else {
                    $absentReasons = [
                        ['status' => 'sick',       'note' => 'Sakit'],
                        ['status' => 'permission', 'note' => 'Izin'],
                        ['status' => 'absent',     'note' => 'Tanpa keterangan'],
                    ];
                    $reason = $absentReasons[array_rand($absentReasons)];

                    $batch[] = [
                        'attendable_type' => 'App\\Models\\Student',
                        'attendable_id'   => $student->id,
                        'date'            => $dateStr,
                        'check_in'        => null,
                        'check_out'       => null,
                        'status'          => $reason['status'],
                        'latitude_in'     => null,
                        'longitude_in'    => null,
                        'latitude_out'    => null,
                        'longitude_out'   => null,
                        'qr_code'         => null,
                        'notes'           => $reason['note'],
                        'created_at'      => $now,
                        'updated_at'      => $now,
                    ];
                }

                if (count($batch) >= 500) {
                    DB::table('attendances')->insert($batch);
                    $batch = [];
                }
            }

            // --- Hari ini (check-in only) ---
            if ($todaySchoolDay) {
                $hadir++;
                $checkInMinute = rand(0, 20);
                $checkIn = "{$todaySchoolDay} 07:" . str_pad($checkInMinute, 2, '0', STR_PAD_LEFT) . ':00';

                $batch[] = [
                    'attendable_type' => 'App\\Models\\Student',
                    'attendable_id'   => $student->id,
                    'date'            => $todaySchoolDay,
                    'check_in'        => $checkIn,
                    'check_out'       => null,
                    'status'          => 'present',
                    'latitude_in'     => round(self::SCHOOL_LAT + (rand(-50, 50) / 100000), 6),
                    'longitude_in'    => round(self::SCHOOL_LNG + (rand(-50, 50) / 100000), 6),
                    'latitude_out'    => null,
                    'longitude_out'   => null,
                    'qr_code'         => 'QR-' . strtoupper(uniqid()),
                    'notes'           => null,
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];
            }

            $actualRate = $totalAllDays > 0 ? round(($hadir / $totalAllDays) * 100, 1) : 0;
            $allStudentRates[] = $actualRate;

            if (count($batch) >= 500) {
                DB::table('attendances')->insert($batch);
                $batch = [];
            }
        }

        // Flush sisa batch siswa
        if (!empty($batch)) {
            DB::table('attendances')->insert($batch);
        }

        $avgStudentRate = count($allStudentRates) > 0 ? round(array_sum($allStudentRates) / count($allStudentRates), 2) : 0;
        $minStudentRate = count($allStudentRates) > 0 ? min($allStudentRates) : 0;
        $maxStudentRate = count($allStudentRates) > 0 ? max($allStudentRates) : 0;

        $this->command->info("✓ Data absensi siswa selesai.");
        $this->command->info("  Rata-rata kehadiran: {$avgStudentRate}%");
        $this->command->info("  Range: {$minStudentRate}% – {$maxStudentRate}%");
        $this->command->info('');

        // ══════════════════════════════════════════════════
        // RINGKASAN AKHIR
        // ══════════════════════════════════════════════════
        $this->command->info("═══════════════════════════════════════════════════");
        $this->command->info("  RINGKASAN SEEDER ABSENSI — {$label}");
        $this->command->info("═══════════════════════════════════════════════════");
        $this->command->info("  Guru  → Avg: {$avgTeacherRate}% (min {$minTeacherRate}%, max {$maxTeacherRate}%)");
        $this->command->info("  Siswa → Avg: {$avgStudentRate}% (min {$minStudentRate}%, max {$maxStudentRate}%)");
        $this->command->info("  Periode: {$startDate->format('d M Y')} s/d {$displayEnd->format('d M Y')}");
        $this->command->info("═══════════════════════════════════════════════════");
    }
}
