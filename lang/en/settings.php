<?php

return [
    'title' => 'Settings',
    'page_title' => 'System Settings',
    'subtitle' => 'Manage application configuration and settings',
    
    // Sections
    'general' => 'General',
    'school_info' => 'School Information',
    'school_profile' => 'School Profile',
    'appearance' => 'Appearance',
    'appearance_settings' => 'Appearance Settings',
    'notifications' => 'Notifications',
    'notification_settings' => 'Notification Settings',
    'security' => 'Security',
    'backup' => 'Backup & Restore',
    'system' => 'System',
    'system_settings' => 'System Settings',
    'general_settings' => 'General Settings',
    
    // General
    'app_name' => 'Application Name',
    'app_logo' => 'Application Logo',
    'timezone' => 'Timezone',
    'date_format' => 'Date Format',
    'time_format' => 'Time Format',
    'language' => 'Language',
    'current_language' => 'Current Language',
    
    // School Info
    'school_name' => 'School Name',
    'school_npsn' => 'NPSN',
    'school_address' => 'Address',
    'school_phone' => 'Phone',
    'school_email' => 'Email',
    'school_website' => 'Website',
    'school_logo' => 'School Logo',
    'logo_format' => 'Format: JPG, PNG. Maximum 2MB',
    'principal_name' => 'Principal Name',
    'principal_nip' => 'Principal NIP',
    
    // Attendance
    'attendance_settings' => 'Attendance Settings',
    'check_in_start' => 'Check-in Start Time',
    'check_in_end' => 'Check-in End Time',
    'late_threshold' => 'Late Threshold (minutes)',
    'working_days' => 'Working Days',
    
    // Appearance
    'theme_color' => 'Theme Color',
    'sidebar_color' => 'Sidebar Color',
    'items_per_page' => 'Items per Page',
    'appearance_note' => 'Theme and sidebar color changes will be applied after the page reloads.',
    
    // Notifications
    'notification_email' => 'Notification Email',
    'notification_email_desc' => 'Email that will receive system notifications',
    'enable_email_notifications' => 'Enable Email Notifications',
    'send_email_notifications' => 'Send notifications via email',
    'enable_sms_notifications' => 'Enable SMS Notifications',
    'send_sms_notifications' => 'Send notifications via SMS (requires additional configuration)',
    
    // System
    'backup_schedule' => 'Backup Schedule',
    'daily' => 'Daily',
    'weekly' => 'Weekly',
    'monthly' => 'Monthly',
    'max_upload_size' => 'Maximum Upload Size (KB)',
    'upload_size_desc' => 'Size in KB (1024 KB = 1 MB)',
    'maintenance_mode' => 'Maintenance Mode',
    'maintenance_warning' => 'Only admin can access during maintenance',
    'auto_backup' => 'Auto Backup Database',
    'auto_backup_desc' => 'Automatic backup according to schedule',
    'attention' => 'Attention:',
    'maintenance_note' => 'Maintenance mode will disable access for all users except admin.',
    
    // Time format
    '24_hour' => '24 Hour (HH:MM)',
    '12_hour' => '12 Hour (hh:mm AM/PM)',
    
    // Actions
    'clear_cache' => 'Clear Cache',
    'backup_database' => 'Backup Database',
    'save_settings' => 'Save Settings',
    'save_changes' => 'Save Changes',
    'reset_default' => 'Reset to Default',
    'upload_logo' => 'Upload Logo',
    'remove_logo' => 'Remove Logo',
    
    // Messages
    'saved' => 'Settings saved successfully',
    'save_failed' => 'Failed to save settings',
    'reset_title' => 'Reset Settings?',
    'reset_text' => 'All settings will be reset to default values!',
    'reset_confirm' => 'Yes, Reset!',
    'reset_cancel' => 'Cancel',
];
