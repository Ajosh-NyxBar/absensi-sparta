<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * Send notification to specific user
     */
    public static function sendToUser($userId, $title, $message, $type = 'info', $icon = 'fa-bell', $link = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'icon' => $icon,
            'title' => $title,
            'message' => $message,
            'link' => $link,
        ]);
    }

    /**
     * Send notification to all admins
     */
    public static function sendToAdmins($title, $message, $type = 'info', $icon = 'fa-bell', $link = null)
    {
        $admins = User::whereHas('role', function($q) {
            $q->where('name', 'Admin');
        })->get();

        foreach ($admins as $admin) {
            self::sendToUser($admin->id, $title, $message, $type, $icon, $link);
        }
    }

    /**
     * Send notification to all users (broadcast)
     */
    public static function broadcast($title, $message, $type = 'info', $icon = 'fa-bell', $link = null)
    {
        return Notification::create([
            'user_id' => null, // null = untuk semua user
            'type' => $type,
            'icon' => $icon,
            'title' => $title,
            'message' => $message,
            'link' => $link,
        ]);
    }

    /**
     * Notify when new student is added
     */
    public static function studentAdded($studentName)
    {
        self::sendToAdmins(
            'Siswa Baru Ditambahkan',
            "Siswa baru bernama {$studentName} telah ditambahkan ke sistem.",
            'success',
            'fa-user-plus',
            route('students.index')
        );
    }

    /**
     * Notify when new teacher is added
     */
    public static function teacherAdded($teacherName)
    {
        self::sendToAdmins(
            'Guru Baru Ditambahkan',
            "Guru baru bernama {$teacherName} telah ditambahkan ke sistem.",
            'success',
            'fa-chalkboard-teacher',
            route('teachers.index')
        );
    }

    /**
     * Notify when grades are submitted
     */
    public static function gradesSubmitted($subjectName, $className)
    {
        self::sendToAdmins(
            'Nilai Baru Diinput',
            "Nilai mata pelajaran {$subjectName} untuk kelas {$className} telah diinput.",
            'info',
            'fa-star',
            route('grades.index')
        );
    }

    /**
     * Notify low attendance warning
     */
    public static function lowAttendanceWarning($className, $absentCount)
    {
        self::sendToAdmins(
            'Peringatan Kehadiran',
            "Terdapat {$absentCount} siswa tidak hadir di kelas {$className} hari ini.",
            'warning',
            'fa-exclamation-triangle',
            route('attendances.index')
        );
    }

    /**
     * System maintenance notification
     */
    public static function systemMaintenance($message)
    {
        self::broadcast(
            'Pemberitahuan Sistem',
            $message,
            'warning',
            'fa-cog',
            null
        );
    }
}
