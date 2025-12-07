<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // School Profile
            [
                'key' => 'school_name',
                'value' => 'SMPN 4 Purwakarta',
                'type' => 'text',
                'group' => 'school',
                'description' => 'Nama sekolah'
            ],
            [
                'key' => 'school_npsn',
                'value' => '20219024',
                'type' => 'text',
                'group' => 'school',
                'description' => 'NPSN (Nomor Pokok Sekolah Nasional)'
            ],
            [
                'key' => 'school_address',
                'value' => 'Jl. Raya Purwakarta-Subang, Purwakarta, Jawa Barat',
                'type' => 'text',
                'group' => 'school',
                'description' => 'Alamat lengkap sekolah'
            ],
            [
                'key' => 'school_phone',
                'value' => '(0264) 123456',
                'type' => 'text',
                'group' => 'school',
                'description' => 'Nomor telepon sekolah'
            ],
            [
                'key' => 'school_email',
                'value' => 'info@smpn4purwakarta.sch.id',
                'type' => 'text',
                'group' => 'school',
                'description' => 'Email sekolah'
            ],
            [
                'key' => 'school_website',
                'value' => 'https://smpn4purwakarta.sch.id',
                'type' => 'text',
                'group' => 'school',
                'description' => 'Website sekolah'
            ],
            [
                'key' => 'school_logo',
                'value' => null,
                'type' => 'file',
                'group' => 'school',
                'description' => 'Logo sekolah'
            ],
            [
                'key' => 'headmaster_name',
                'value' => 'Dr. H. Ahmad Sudrajat, M.Pd.',
                'type' => 'text',
                'group' => 'school',
                'description' => 'Nama Kepala Sekolah'
            ],
            [
                'key' => 'headmaster_nip',
                'value' => '196501011990031003',
                'type' => 'text',
                'group' => 'school',
                'description' => 'NIP Kepala Sekolah'
            ],

            // General Settings
            [
                'key' => 'app_name',
                'value' => 'SIM SMPN 4 Purwakarta',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Nama aplikasi'
            ],
            [
                'key' => 'app_timezone',
                'value' => 'Asia/Jakarta',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Timezone aplikasi'
            ],
            [
                'key' => 'app_language',
                'value' => 'id',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Bahasa aplikasi (id/en)'
            ],
            [
                'key' => 'date_format',
                'value' => 'd/m/Y',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Format tanggal'
            ],
            [
                'key' => 'time_format',
                'value' => 'H:i',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Format waktu'
            ],

            // Appearance
            [
                'key' => 'theme_color',
                'value' => '#667eea',
                'type' => 'text',
                'group' => 'appearance',
                'description' => 'Warna tema utama'
            ],
            [
                'key' => 'sidebar_color',
                'value' => 'dark',
                'type' => 'text',
                'group' => 'appearance',
                'description' => 'Warna sidebar (dark/light)'
            ],
            [
                'key' => 'items_per_page',
                'value' => '10',
                'type' => 'number',
                'group' => 'appearance',
                'description' => 'Jumlah item per halaman'
            ],

            // Notification Settings
            [
                'key' => 'email_notifications',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'notification',
                'description' => 'Aktifkan notifikasi email'
            ],
            [
                'key' => 'sms_notifications',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'notification',
                'description' => 'Aktifkan notifikasi SMS'
            ],
            [
                'key' => 'notification_email',
                'value' => 'admin@smpn4purwakarta.sch.id',
                'type' => 'text',
                'group' => 'notification',
                'description' => 'Email untuk menerima notifikasi'
            ],

            // System Settings
            [
                'key' => 'maintenance_mode',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'system',
                'description' => 'Mode maintenance'
            ],
            [
                'key' => 'auto_backup',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'system',
                'description' => 'Auto backup database'
            ],
            [
                'key' => 'backup_schedule',
                'value' => 'daily',
                'type' => 'text',
                'group' => 'system',
                'description' => 'Jadwal backup (daily/weekly/monthly)'
            ],
            [
                'key' => 'max_upload_size',
                'value' => '2048',
                'type' => 'number',
                'group' => 'system',
                'description' => 'Ukuran maksimal upload (KB)'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}

