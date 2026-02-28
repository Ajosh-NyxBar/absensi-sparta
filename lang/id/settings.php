<?php

return [
    'title' => 'Pengaturan',
    'page_title' => 'Pengaturan Sistem',
    'subtitle' => 'Kelola konfigurasi dan pengaturan aplikasi',
    
    // Sections
    'general' => 'Umum',
    'school_info' => 'Informasi Sekolah',
    'school_profile' => 'Profil Sekolah',
    'appearance' => 'Tampilan',
    'appearance_settings' => 'Pengaturan Tampilan',
    'notifications' => 'Notifikasi',
    'notification_settings' => 'Pengaturan Notifikasi',
    'security' => 'Keamanan',
    'backup' => 'Backup & Restore',
    'system' => 'Sistem',
    'system_settings' => 'Pengaturan Sistem',
    'general_settings' => 'Pengaturan Umum',
    
    // General
    'app_name' => 'Nama Aplikasi',
    'app_logo' => 'Logo Aplikasi',
    'timezone' => 'Zona Waktu',
    'date_format' => 'Format Tanggal',
    'time_format' => 'Format Waktu',
    'language' => 'Bahasa',
    'current_language' => 'Bahasa Saat Ini',
    
    // School Info
    'school_name' => 'Nama Sekolah',
    'school_npsn' => 'NPSN',
    'school_address' => 'Alamat',
    'school_phone' => 'Telepon',
    'school_email' => 'Email',
    'school_website' => 'Website',
    'school_logo' => 'Logo Sekolah',
    'logo_format' => 'Format: JPG, PNG. Maksimal 2MB',
    'principal_name' => 'Nama Kepala Sekolah',
    'principal_nip' => 'NIP Kepala Sekolah',
    
    // Attendance
    'attendance_settings' => 'Pengaturan Presensi',
    'check_in_start' => 'Waktu Mulai Masuk',
    'check_in_end' => 'Waktu Akhir Masuk',
    'late_threshold' => 'Batas Terlambat (menit)',
    'working_days' => 'Hari Kerja',
    
    // Appearance
    'theme_color' => 'Warna Tema',
    'sidebar_color' => 'Warna Sidebar',
    'items_per_page' => 'Item per Halaman',
    'appearance_note' => 'Perubahan warna tema dan sidebar akan diterapkan setelah halaman dimuat ulang.',
    
    // Notifications
    'notification_email' => 'Email Notifikasi',
    'notification_email_desc' => 'Email yang akan menerima notifikasi sistem',
    'enable_email_notifications' => 'Aktifkan Notifikasi Email',
    'send_email_notifications' => 'Kirim notifikasi melalui email',
    'enable_sms_notifications' => 'Aktifkan Notifikasi SMS',
    'send_sms_notifications' => 'Kirim notifikasi melalui SMS (perlu konfigurasi tambahan)',
    
    // System
    'backup_schedule' => 'Jadwal Backup',
    'daily' => 'Harian',
    'weekly' => 'Mingguan',
    'monthly' => 'Bulanan',
    'max_upload_size' => 'Ukuran Maksimal Upload (KB)',
    'upload_size_desc' => 'Ukuran dalam KB (1024 KB = 1 MB)',
    'maintenance_mode' => 'Mode Maintenance',
    'maintenance_warning' => 'Hanya admin yang bisa akses saat maintenance',
    'auto_backup' => 'Auto Backup Database',
    'auto_backup_desc' => 'Backup otomatis sesuai jadwal',
    'attention' => 'Perhatian:',
    'maintenance_note' => 'Mode maintenance akan menonaktifkan akses untuk semua pengguna kecuali admin.',
    
    // Time format
    '24_hour' => '24 Jam (HH:MM)',
    '12_hour' => '12 Jam (hh:mm AM/PM)',
    
    // Actions
    'clear_cache' => 'Bersihkan Cache',
    'backup_database' => 'Backup Database',
    'save_settings' => 'Simpan Pengaturan',
    'save_changes' => 'Simpan Perubahan',
    'reset_default' => 'Reset ke Default',
    'upload_logo' => 'Unggah Logo',
    'remove_logo' => 'Hapus Logo',
    
    // Messages
    'saved' => 'Pengaturan berhasil disimpan',
    'save_failed' => 'Gagal menyimpan pengaturan',
    'reset_title' => 'Reset Pengaturan?',
    'reset_text' => 'Semua pengaturan akan dikembalikan ke nilai default!',
    'reset_confirm' => 'Ya, Reset!',
    'reset_cancel' => 'Batal',
];
