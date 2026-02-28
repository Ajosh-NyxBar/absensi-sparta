<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Teacher;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Start date: October 16, 2025
        $startDate = Carbon::create(2025, 10, 16);
        $endDate = Carbon::now();
        
        // Get all teachers
        $teachers = Teacher::all();
        
        // Get all students
        $students = Student::all();
        
        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate) {
            // Skip weekends (Saturday & Sunday)
            if ($currentDate->isWeekend()) {
                $currentDate->addDay();
                continue;
            }
            
            // Teacher attendance with 95% presence rate
            foreach ($teachers as $teacher) {
                // 95% chance to be present
                $isPresent = rand(1, 100) <= 95;
                
                if ($isPresent) {
                    // Random check-in time between 07:00 - 07:45
                    $checkInHour = 7;
                    $checkInMinute = rand(0, 45);
                    $checkInTime = $currentDate->copy()->setTime($checkInHour, $checkInMinute, 0);
                    
                    // Random check-out time between 14:00 - 15:30
                    $checkOutHour = rand(14, 15);
                    $checkOutMinute = rand(0, 59);
                    $checkOutTime = $currentDate->copy()->setTime($checkOutHour, $checkOutMinute, 0);
                    
                    // Determine status based on check-in time
                    $status = $checkInMinute <= 30 ? 'present' : 'late';
                    
                    Attendance::create([
                        'attendable_type' => Teacher::class,
                        'attendable_id' => $teacher->id,
                        'date' => $currentDate->format('Y-m-d'),
                        'check_in' => $checkInTime,
                        'check_out' => $checkOutTime,
                        'status' => $status,
                        'latitude_in' => -6.200000 + (rand(-100, 100) / 10000), // Simulate Jakarta area
                        'longitude_in' => 106.816666 + (rand(-100, 100) / 10000),
                        'latitude_out' => -6.200000 + (rand(-100, 100) / 10000),
                        'longitude_out' => 106.816666 + (rand(-100, 100) / 10000),
                        'qr_code' => 'QR-' . strtoupper(uniqid()),
                        'notes' => null,
                    ]);
                } else {
                    // 5% chance to be absent with varied reasons
                    $absentReasons = [
                        ['status' => 'sick', 'note' => 'Sakit'],
                        ['status' => 'permission', 'note' => 'Izin urusan keluarga'],
                        ['status' => 'absent', 'note' => null],
                    ];
                    
                    $reason = $absentReasons[array_rand($absentReasons)];
                    
                    Attendance::create([
                        'attendable_type' => Teacher::class,
                        'attendable_id' => $teacher->id,
                        'date' => $currentDate->format('Y-m-d'),
                        'check_in' => null,
                        'check_out' => null,
                        'status' => $reason['status'],
                        'latitude_in' => null,
                        'longitude_in' => null,
                        'latitude_out' => null,
                        'longitude_out' => null,
                        'qr_code' => null,
                        'notes' => $reason['note'],
                    ]);
                }
            }
            
            // Student attendance with ~90% presence rate
            foreach ($students as $student) {
                // 90% chance to be present
                $isPresent = rand(1, 100) <= 90;
                
                if ($isPresent) {
                    // Random check-in time between 06:30 - 07:30
                    $checkInHour = rand(6, 7);
                    $checkInMinute = rand(0, 59);
                    
                    // Ensure if hour is 6, minute is at least 30
                    if ($checkInHour === 6 && $checkInMinute < 30) {
                        $checkInMinute = rand(30, 59);
                    }
                    
                    $checkInTime = $currentDate->copy()->setTime($checkInHour, $checkInMinute, 0);
                    
                    // Random check-out time between 14:00 - 15:00
                    $checkOutHour = 14;
                    $checkOutMinute = rand(0, 59);
                    $checkOutTime = $currentDate->copy()->setTime($checkOutHour, $checkOutMinute, 0);
                    
                    // Determine status: present if before 07:00, late if after
                    $status = ($checkInHour < 7 || ($checkInHour === 7 && $checkInMinute === 0)) ? 'present' : 'late';
                    
                    Attendance::create([
                        'attendable_type' => Student::class,
                        'attendable_id' => $student->id,
                        'date' => $currentDate->format('Y-m-d'),
                        'check_in' => $checkInTime,
                        'check_out' => $checkOutTime,
                        'status' => $status,
                        'latitude_in' => -6.200000 + (rand(-100, 100) / 10000),
                        'longitude_in' => 106.816666 + (rand(-100, 100) / 10000),
                        'latitude_out' => -6.200000 + (rand(-100, 100) / 10000),
                        'longitude_out' => 106.816666 + (rand(-100, 100) / 10000),
                        'qr_code' => 'QR-' . strtoupper(uniqid()),
                        'notes' => null,
                    ]);
                } else {
                    // 10% absent with varied reasons
                    $absentReasons = [
                        ['status' => 'sick', 'note' => 'Sakit'],
                        ['status' => 'permission', 'note' => 'Izin'],
                        ['status' => 'absent', 'note' => null],
                    ];
                    
                    $reason = $absentReasons[array_rand($absentReasons)];
                    
                    Attendance::create([
                        'attendable_type' => Student::class,
                        'attendable_id' => $student->id,
                        'date' => $currentDate->format('Y-m-d'),
                        'check_in' => null,
                        'check_out' => null,
                        'status' => $reason['status'],
                        'latitude_in' => null,
                        'longitude_in' => null,
                        'latitude_out' => null,
                        'longitude_out' => null,
                        'qr_code' => null,
                        'notes' => $reason['note'],
                    ]);
                }
            }
            
            $currentDate->addDay();
        }
        
        $this->command->info('Attendance data seeded successfully from October 16, 2025 to ' . $endDate->format('Y-m-d'));
    }
}
