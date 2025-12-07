<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display settings page
     */
    public function index()
    {
        $schoolSettings = Setting::where('group', 'school')->get();
        $generalSettings = Setting::where('group', 'general')->get();
        $appearanceSettings = Setting::where('group', 'appearance')->get();
        $notificationSettings = Setting::where('group', 'notification')->get();
        $systemSettings = Setting::where('group', 'system')->get();

        return view('settings.index', compact(
            'schoolSettings',
            'generalSettings',
            'appearanceSettings',
            'notificationSettings',
            'systemSettings'
        ));
    }

    /**
     * Update school profile settings
     */
    public function updateSchool(Request $request)
    {
        $validated = $request->validate([
            'school_name' => 'required|string|max:255',
            'school_npsn' => 'required|string|max:20',
            'school_address' => 'required|string',
            'school_phone' => 'required|string|max:20',
            'school_email' => 'required|email|max:255',
            'school_website' => 'nullable|url|max:255',
            'school_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'headmaster_name' => 'required|string|max:255',
            'headmaster_nip' => 'required|string|max:20',
        ]);

        foreach ($validated as $key => $value) {
            if ($key === 'school_logo' && $request->hasFile('school_logo')) {
                // Delete old logo if exists
                $oldLogo = Setting::get('school_logo');
                if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                    Storage::disk('public')->delete($oldLogo);
                }

                // Store new logo
                $path = $request->file('school_logo')->store('logos', 'public');
                Setting::set('school_logo', $path, 'file', 'school', 'Logo sekolah');
            } else {
                Setting::set($key, $value, 'text', 'school');
            }
        }

        Setting::clearCache();

        return redirect()->route('settings.index')
            ->with('success', 'Pengaturan profil sekolah berhasil diperbarui');
    }

    /**
     * Update general settings
     */
    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_timezone' => 'required|string|max:50',
            'app_language' => 'required|in:id,en',
            'date_format' => 'required|string|max:20',
            'time_format' => 'required|string|max:20',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value, 'text', 'general');
        }

        // Apply language immediately
        if (isset($validated['app_language'])) {
            app()->setLocale($validated['app_language']);
        }

        // Apply timezone immediately
        if (isset($validated['app_timezone'])) {
            date_default_timezone_set($validated['app_timezone']);
        }

        Setting::clearCache();

        $message = $validated['app_language'] === 'id' 
            ? 'Pengaturan umum berhasil diperbarui' 
            : 'General settings successfully updated';

        return redirect()->route('settings.index')
            ->with('success', $message);
    }

    /**
     * Update appearance settings
     */
    public function updateAppearance(Request $request)
    {
        $validated = $request->validate([
            'theme_color' => 'required|string|max:7',
            'sidebar_color' => 'required|in:dark,light',
            'items_per_page' => 'required|integer|min:5|max:100',
        ]);

        foreach ($validated as $key => $value) {
            $type = $key === 'items_per_page' ? 'number' : 'text';
            Setting::set($key, $value, $type, 'appearance');
        }

        Setting::clearCache();

        return redirect()->route('settings.index')
            ->with('success', 'Pengaturan tampilan berhasil diperbarui');
    }

    /**
     * Update notification settings
     */
    public function updateNotification(Request $request)
    {
        $validated = $request->validate([
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'notification_email' => 'required|email|max:255',
        ]);

        Setting::set('email_notifications', $request->has('email_notifications'), 'boolean', 'notification');
        Setting::set('sms_notifications', $request->has('sms_notifications'), 'boolean', 'notification');
        Setting::set('notification_email', $validated['notification_email'], 'text', 'notification');

        Setting::clearCache();

        return redirect()->route('settings.index')
            ->with('success', 'Pengaturan notifikasi berhasil diperbarui');
    }

    /**
     * Update system settings
     */
    public function updateSystem(Request $request)
    {
        $validated = $request->validate([
            'maintenance_mode' => 'boolean',
            'auto_backup' => 'boolean',
            'backup_schedule' => 'required|in:daily,weekly,monthly',
            'max_upload_size' => 'required|integer|min:1024|max:10240',
        ]);

        Setting::set('maintenance_mode', $request->has('maintenance_mode'), 'boolean', 'system');
        Setting::set('auto_backup', $request->has('auto_backup'), 'boolean', 'system');
        Setting::set('backup_schedule', $validated['backup_schedule'], 'text', 'system');
        Setting::set('max_upload_size', $validated['max_upload_size'], 'number', 'system');

        Setting::clearCache();

        return redirect()->route('settings.index')
            ->with('success', 'Pengaturan sistem berhasil diperbarui');
    }

    /**
     * Clear all cache
     */
    public function clearCache()
    {
        Setting::clearCache();
        
        return redirect()->route('settings.index')
            ->with('success', 'Cache berhasil dibersihkan');
    }

    /**
     * Backup database
     */
    public function backup()
    {
        try {
            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $path = storage_path('app/backups/' . $filename);

            // Create backups directory if not exists
            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }

            // Get database config
            $database = config('database.connections.' . config('database.default') . '.database');
            $username = config('database.connections.' . config('database.default') . '.username');
            $password = config('database.connections.' . config('database.default') . '.password');
            $host = config('database.connections.' . config('database.default') . '.host');

            // Execute mysqldump
            $command = sprintf(
                'mysqldump -h%s -u%s -p%s %s > %s',
                escapeshellarg($host),
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($database),
                escapeshellarg($path)
            );

            exec($command, $output, $returnVar);

            if ($returnVar === 0) {
                return redirect()->route('settings.index')
                    ->with('success', 'Backup database berhasil: ' . $filename);
            } else {
                return redirect()->route('settings.index')
                    ->with('error', 'Gagal membuat backup database');
            }
        } catch (\Exception $e) {
            return redirect()->route('settings.index')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
}

