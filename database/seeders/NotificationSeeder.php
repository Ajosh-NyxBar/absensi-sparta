<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all admin users
        $adminUsers = User::whereHas('role', function($q) {
            $q->where('name', 'Admin');
        })->get();

        // Sample notifications for admins
        foreach ($adminUsers as $admin) {
            // Welcome notification
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'info',
                'icon' => 'fa-hand-wave',
                'title' => 'Selamat Datang di Sistem!',
                'message' => 'Selamat datang di Sistem Informasi Sekolah. Jelajahi fitur-fitur yang tersedia untuk mengelola data sekolah.',
                'link' => route('dashboard'),
                'is_read' => false,
            ]);

            // System update notification
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'success',
                'icon' => 'fa-check-circle',
                'title' => 'Sistem Diperbarui',
                'message' => 'Fitur notifikasi baru telah ditambahkan ke sistem. Anda sekarang dapat menerima pemberitahuan realtime.',
                'link' => null,
                'is_read' => false,
            ]);
        }

        // Broadcast notification to all users
        Notification::create([
            'user_id' => null, // null = untuk semua user
            'type' => 'warning',
            'icon' => 'fa-calendar-check',
            'title' => 'Pengingat Presensi',
            'message' => 'Jangan lupa untuk melakukan presensi hari ini. Presensi penting untuk pencatatan kehadiran.',
            'link' => route('attendances.index'),
            'is_read' => false,
        ]);

        // Another broadcast
        Notification::create([
            'user_id' => null,
            'type' => 'info',
            'icon' => 'fa-bullhorn',
            'title' => 'Fitur Baru: Dual Bahasa',
            'message' => 'Sistem sekarang mendukung 2 bahasa (Indonesia & English). Pilih bahasa di menu atas.',
            'link' => null,
            'is_read' => false,
        ]);

        $this->command->info('Notification seeder completed!');
    }
}
