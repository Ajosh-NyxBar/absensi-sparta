# Pengaturan Sistem (System Settings)

## Deskripsi
Fitur untuk mengelola konfigurasi dan pengaturan aplikasi secara terpusat. Menggunakan sistem key-value dengan caching untuk performa optimal.

## Arsitektur

### Database Schema
**Table**: `settings`

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| key | STRING(255) | Unique identifier setting |
| value | TEXT | Nilai setting (nullable) |
| type | STRING | Tipe data: text, number, boolean, file, json |
| group | STRING | Kategori: general, school, appearance, notification, system |
| description | TEXT | Deskripsi setting (nullable) |
| created_at | TIMESTAMP | Waktu dibuat |
| updated_at | TIMESTAMP | Waktu diupdate |

**Indexes**:
- PRIMARY: `id`
- UNIQUE: `key`

### Model Methods

#### Setting::get($key, $default = null)
**Purpose**: Get setting value by key dengan caching

**Parameters**:
- `$key` (string): Key setting
- `$default` (mixed): Default value jika tidak ditemukan

**Return**: Mixed (sesuai type)

**Example**:
```php
$schoolName = Setting::get('school_name', 'SMPN 4 Purwakarta');
$itemsPerPage = Setting::get('items_per_page', 10); // Returns integer
$emailEnabled = Setting::get('email_notifications', true); // Returns boolean
```

**Caching**: 3600 seconds (1 hour)

---

#### Setting::set($key, $value, $type = 'text', $group = 'general', $description = null)
**Purpose**: Set/update setting value

**Parameters**:
- `$key` (string): Unique key
- `$value` (mixed): Nilai setting
- `$type` (string): text|number|boolean|file|json
- `$group` (string): general|school|appearance|notification|system
- `$description` (string|null): Deskripsi

**Return**: Setting model instance

**Example**:
```php
Setting::set('school_name', 'SMPN 4 Purwakarta', 'text', 'school');
Setting::set('items_per_page', 15, 'number', 'appearance');
Setting::set('email_notifications', true, 'boolean', 'notification');
```

**Auto-clears cache** after update

---

#### Setting::getByGroup($group)
**Purpose**: Get all settings dalam satu grup

**Parameters**:
- `$group` (string): Nama grup

**Return**: Collection (key-value pairs)

**Example**:
```php
$schoolSettings = Setting::getByGroup('school');
// Returns: ['school_name' => 'SMPN 4...', 'school_npsn' => '20219024', ...]
```

---

#### Setting::clearCache()
**Purpose**: Clear semua settings cache

**Example**:
```php
Setting::clearCache();
```

---

## Helper Functions

### setting($key, $default = null)
**Purpose**: Shorthand untuk Setting::get()

**Global Usage**:
```php
// Di Blade view
{{ setting('school_name') }}

// Di Controller
$appName = setting('app_name', 'Default App');

// Di Config
'timezone' => setting('app_timezone', 'Asia/Jakarta'),
```

---

### settings($group)
**Purpose**: Shorthand untuk Setting::getByGroup()

**Global Usage**:
```php
$schoolInfo = settings('school');
foreach ($schoolInfo as $key => $value) {
    echo "$key: $value\n";
}
```

---

## Setting Groups

### 1. School Profile (school)

**Settings**:
```php
'school_name' => 'SMPN 4 Purwakarta'           // Nama sekolah
'school_npsn' => '20219024'                    // NPSN
'school_address' => 'Jl. Raya...'              // Alamat lengkap
'school_phone' => '(0264) 123456'              // Telepon
'school_email' => 'info@...'                   // Email
'school_website' => 'https://...'              // Website (nullable)
'school_logo' => 'logos/logo.png'              // Path logo (nullable)
'headmaster_name' => 'Dr. H. Ahmad...'         // Nama Kepala Sekolah
'headmaster_nip' => '196501011990031003'       // NIP Kepala Sekolah
```

**Validation Rules**:
- `school_name`: required|string|max:255
- `school_npsn`: required|string|max:20
- `school_address`: required|string
- `school_phone`: required|string|max:20
- `school_email`: required|email|max:255
- `school_website`: nullable|url|max:255
- `school_logo`: nullable|image|mimes:jpeg,png,jpg|max:2048 (KB)
- `headmaster_name`: required|string|max:255
- `headmaster_nip`: required|string|max:20

**Controller**: `SettingController@updateSchool`

**Route**: `PUT /settings/school`

**Features**:
- Logo upload dengan auto-delete old logo
- Storage: `storage/app/public/logos/`
- Display: `{{ asset('storage/' . setting('school_logo')) }}`

---

### 2. General Settings (general)

**Settings**:
```php
'app_name' => 'SIM SMPN 4 Purwakarta'         // Nama aplikasi
'app_timezone' => 'Asia/Jakarta'              // Timezone
'app_language' => 'id'                        // Bahasa (id/en)
'date_format' => 'd/m/Y'                      // Format tanggal
'time_format' => 'H:i'                        // Format waktu
```

**Validation Rules**:
- `app_name`: required|string|max:255
- `app_timezone`: required|string|max:50
- `app_language`: required|in:id,en
- `date_format`: required|string|max:20
- `time_format`: required|string|max:20

**Controller**: `SettingController@updateGeneral`

**Route**: `PUT /settings/general`

**Timezone Options**:
- Asia/Jakarta (WIB) - UTC+7
- Asia/Makassar (WITA) - UTC+8
- Asia/Jayapura (WIT) - UTC+9

**Date Format Options**:
- `d/m/Y` → 07/11/2024 (DD/MM/YYYY)
- `m/d/Y` → 11/07/2024 (MM/DD/YYYY)
- `Y-m-d` → 2024-11-07 (YYYY-MM-DD)

**Time Format Options**:
- `H:i` → 14:30 (24-hour)
- `h:i A` → 02:30 PM (12-hour)

---

### 3. Appearance Settings (appearance)

**Settings**:
```php
'theme_color' => '#667eea'                    // Warna tema utama (hex)
'sidebar_color' => 'dark'                     // Warna sidebar (dark/light)
'items_per_page' => '10'                      // Jumlah item per halaman
```

**Validation Rules**:
- `theme_color`: required|string|max:7
- `sidebar_color`: required|in:dark,light
- `items_per_page`: required|integer|min:5|max:100

**Controller**: `SettingController@updateAppearance`

**Route**: `PUT /settings/appearance`

**Usage**:
```php
// Pagination
$students = Student::paginate(setting('items_per_page', 10));

// Sidebar class
<div class="sidebar bg-{{ setting('sidebar_color', 'dark') }}">

// Custom CSS
<style>
    :root {
        --primary-color: {{ setting('theme_color', '#667eea') }};
    }
</style>
```

---

### 4. Notification Settings (notification)

**Settings**:
```php
'email_notifications' => 'true'               // Boolean (aktif/tidak)
'sms_notifications' => 'false'                // Boolean (aktif/tidak)
'notification_email' => 'admin@...'           // Email tujuan notifikasi
```

**Validation Rules**:
- `email_notifications`: boolean
- `sms_notifications`: boolean
- `notification_email`: required|email|max:255

**Controller**: `SettingController@updateNotification`

**Route**: `PUT /settings/notification`

**Usage**:
```php
if (setting('email_notifications', true)) {
    Mail::to(setting('notification_email'))->send(new AlertMail());
}

if (setting('sms_notifications', false)) {
    // Send SMS notification
}
```

---

### 5. System Settings (system)

**Settings**:
```php
'maintenance_mode' => 'false'                 // Boolean
'auto_backup' => 'true'                       // Boolean
'backup_schedule' => 'daily'                  // daily/weekly/monthly
'max_upload_size' => '2048'                   // KB (number)
```

**Validation Rules**:
- `maintenance_mode`: boolean
- `auto_backup`: boolean
- `backup_schedule`: required|in:daily,weekly,monthly
- `max_upload_size`: required|integer|min:1024|max:10240

**Controller**: `SettingController@updateSystem`

**Route**: `PUT /settings/system`

**Backup Schedule**:
- `daily`: Setiap hari (recommended)
- `weekly`: Setiap minggu
- `monthly`: Setiap bulan

**Max Upload Size**:
- Min: 1024 KB (1 MB)
- Max: 10240 KB (10 MB)

---

## Controller Actions

### 1. index()
**Purpose**: Display settings page dengan tabs

**Route**: `GET /settings`

**Data Passed to View**:
- `$schoolSettings`: Collection of school settings
- `$generalSettings`: Collection of general settings
- `$appearanceSettings`: Collection of appearance settings
- `$notificationSettings`: Collection of notification settings
- `$systemSettings`: Collection of system settings

**View**: `resources/views/settings/index.blade.php`

---

### 2. updateSchool(Request $request)
**Purpose**: Update school profile settings

**Route**: `PUT /settings/school`

**Validation**: See School Profile validation rules

**Special Handling**:
- Logo upload → stores to `storage/app/public/logos/`
- Auto-delete old logo before upload new one
- Uses `Storage::disk('public')`

**Success Message**: "Pengaturan profil sekolah berhasil diperbarui"

---

### 3. updateGeneral(Request $request)
**Purpose**: Update general settings

**Route**: `PUT /settings/general`

**Validation**: See General Settings validation rules

**Success Message**: "Pengaturan umum berhasil diperbarui"

---

### 4. updateAppearance(Request $request)
**Purpose**: Update appearance settings

**Route**: `PUT /settings/appearance`

**Validation**: See Appearance Settings validation rules

**Info Alert**: Changes require page reload

**Success Message**: "Pengaturan tampilan berhasil diperbarui"

---

### 5. updateNotification(Request $request)
**Purpose**: Update notification settings

**Route**: `PUT /settings/notification`

**Validation**: See Notification Settings validation rules

**Checkbox Handling**:
```php
Setting::set('email_notifications', $request->has('email_notifications'), 'boolean', 'notification');
```

**Success Message**: "Pengaturan notifikasi berhasil diperbarui"

---

### 6. updateSystem(Request $request)
**Purpose**: Update system settings

**Route**: `PUT /settings/system`

**Validation**: See System Settings validation rules

**Warning**: Maintenance mode akan menonaktifkan akses user (kecuali admin)

**Success Message**: "Pengaturan sistem berhasil diperbarui"

---

### 7. clearCache()
**Purpose**: Clear all settings cache manually

**Route**: `POST /settings/cache/clear`

**Method**: Setting::clearCache() → Cache::flush()

**Success Message**: "Cache berhasil dibersihkan"

---

### 8. backup()
**Purpose**: Manual database backup

**Route**: `POST /settings/backup`

**Process**:
1. Generate filename: `backup_YYYY-MM-DD_HH-ii-ss.sql`
2. Create directory: `storage/app/backups/` (if not exists)
3. Get database credentials from config
4. Execute mysqldump command
5. Save to storage

**Command Example**:
```bash
mysqldump -h127.0.0.1 -uroot -ppassword database_name > backup_2024-11-07_14-30-00.sql
```

**Success Message**: "Backup database berhasil: backup_2024-11-07_14-30-00.sql"

**Error Message**: "Gagal membuat backup database" or "Error: {exception message}"

**Requirements**:
- `mysqldump` must be installed and accessible
- Proper database credentials
- Write permission to `storage/app/backups/`

---

## View Components

### Tabs Navigation
**File**: `resources/views/settings/index.blade.php`

**Tabs**:
1. **Profil Sekolah** (school-tab) - icon: fa-school - Purple theme
2. **Umum** (general-tab) - icon: fa-sliders-h - Default
3. **Tampilan** (appearance-tab) - icon: fa-palette - Default
4. **Notifikasi** (notification-tab) - icon: fa-bell - Default
5. **Sistem** (system-tab) - icon: fa-server - Default

**Bootstrap 5 Tabs**: Using `data-bs-toggle="tab"`

---

### Header Actions
**Buttons**:
1. **Bersihkan Cache** (Clear Cache)
   - Form: POST → `settings.cache.clear`
   - Class: `btn btn-outline-warning`
   - Icon: fa-broom

2. **Backup Database**
   - Form: POST → `settings.backup`
   - Class: `btn btn-outline-info`
   - Icon: fa-database

---

### Form Inputs

#### Text Input
```blade
<input type="text" 
       name="school_name" 
       class="form-control @error('school_name') is-invalid @enderror" 
       value="{{ old('school_name', $schoolSettings->where('key', 'school_name')->first()->value ?? '') }}" 
       required>
```

#### Select Input
```blade
<select name="app_timezone" class="form-select" required>
    <option value="Asia/Jakarta" {{ $currentTimezone == 'Asia/Jakarta' ? 'selected' : '' }}>
        Asia/Jakarta (WIB)
    </option>
</select>
```

#### File Input (Logo)
```blade
<input type="file" 
       name="school_logo" 
       class="form-control" 
       accept="image/*">
<small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>

@if($logo)
<div class="mt-2">
    <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="img-thumbnail" style="max-height: 100px;">
</div>
@endif
```

#### Color Picker
```blade
<input type="color" 
       name="theme_color" 
       class="form-control form-control-color" 
       value="{{ old('theme_color', '#667eea') }}" 
       required>
```

#### Switch/Toggle
```blade
<div class="form-check form-switch">
    <input class="form-check-input" 
           type="checkbox" 
           name="email_notifications" 
           id="emailNotif" 
           {{ $emailEnabled ? 'checked' : '' }}>
    <label class="form-check-label" for="emailNotif">
        Aktifkan Notifikasi Email
    </label>
</div>
<small class="text-muted">Kirim notifikasi melalui email</small>
```

---

## Usage Examples

### 1. Display School Name in Header
```blade
<!-- resources/views/layouts/app.blade.php -->
<h1>{{ setting('school_name', 'SMPN 4 Purwakarta') }}</h1>
```

### 2. Use Date Format in View
```blade
{{ \Carbon\Carbon::parse($student->date_of_birth)->format(setting('date_format', 'd/m/Y')) }}
```

### 3. Pagination with Custom Items
```php
// Controller
$students = Student::paginate(setting('items_per_page', 10));
```

### 4. Conditional Notification
```php
if (setting('email_notifications', true)) {
    Notification::route('mail', setting('notification_email'))
        ->notify(new NewStudentNotification($student));
}
```

### 5. Logo in PDF Report
```blade
<!-- resources/views/reports/pdf/attendance.blade.php -->
@if(setting('school_logo'))
<img src="{{ public_path('storage/' . setting('school_logo')) }}" alt="Logo" height="50">
@endif
<h2>{{ setting('school_name') }}</h2>
<p>{{ setting('school_address') }}</p>
```

### 6. Dynamic Theme Color
```blade
<style>
:root {
    --primary-color: {{ setting('theme_color', '#667eea') }};
}
.btn-primary {
    background-color: var(--primary-color);
}
</style>
```

---

## Caching Strategy

### Cache Key Pattern
- Single setting: `setting.{key}`
- Group settings: `settings.group.{group}`

**Example**:
```
setting.school_name
setting.app_timezone
settings.group.school
settings.group.appearance
```

### Cache Duration
- **Default**: 3600 seconds (1 hour)
- **Method**: `Cache::remember()`

### Cache Invalidation
**Auto-clear** on:
- `Setting::set()` - clears specific key
- `SettingController@update*()` - calls `Setting::clearCache()`
- `SettingController@clearCache()` - manual flush

**Manual Clear**:
```php
Setting::clearCache(); // Flush all cache
Cache::forget('setting.school_name'); // Clear specific key
```

---

## Security Considerations

### Authorization
**Middleware**: `CheckRole:Admin`

Only Admin role can access `/settings/*` routes

### File Upload Security
- **Validation**: image|mimes:jpeg,png,jpg|max:2048
- **Storage**: `storage/app/public/logos/` (not web-accessible)
- **Display**: Through `asset('storage/...')` with symlink
- **Old file deletion**: Prevents storage bloat

### Maintenance Mode
**Effect**: Blocks all non-admin users

**Implementation** (future):
```php
// app/Http/Middleware/CheckMaintenanceMode.php
if (setting('maintenance_mode', false) && !auth()->user()->isAdmin()) {
    abort(503, 'Site is under maintenance');
}
```

---

## Database Backup

### Manual Backup
**Route**: `POST /settings/backup`

**Location**: `storage/app/backups/backup_YYYY-MM-DD_HH-ii-ss.sql`

**Format**: SQL dump (plain text)

### Auto Backup (Future Implementation)

**Scheduled Command**:
```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    if (setting('auto_backup', true)) {
        $frequency = setting('backup_schedule', 'daily');
        
        $command = $schedule->command('backup:run');
        
        match($frequency) {
            'daily' => $command->daily(),
            'weekly' => $command->weekly(),
            'monthly' => $command->monthly(),
        };
    }
}
```

**Package**: [spatie/laravel-backup](https://github.com/spatie/laravel-backup) (optional)

---

## Performance Tips

### 1. Use Helper Functions
```php
// ❌ Avoid
Setting::get('school_name')

// ✅ Better
setting('school_name')
```

### 2. Cache Group Queries
```php
// ❌ Multiple queries
$name = setting('school_name');
$npsn = setting('school_npsn');
$address = setting('school_address');

// ✅ Single query
$school = settings('school');
$name = $school['school_name'];
$npsn = $school['school_npsn'];
$address = $school['school_address'];
```

### 3. Preload in Service Provider
```php
// app/Providers/AppServiceProvider.php
public function boot()
{
    // Preload frequently used settings
    view()->share('schoolName', setting('school_name'));
    view()->share('appName', setting('app_name'));
}
```

---

## Testing

### Feature Test Example
```php
public function test_admin_can_update_school_settings()
{
    $admin = User::factory()->create(['role_id' => 1]); // Admin role
    
    $this->actingAs($admin)
        ->put(route('settings.school.update'), [
            'school_name' => 'New School Name',
            'school_npsn' => '12345678',
            // ... other fields
        ])
        ->assertRedirect(route('settings.index'))
        ->assertSessionHas('success');
    
    $this->assertEquals('New School Name', setting('school_name'));
}
```

---

## Future Enhancements

### Potential Features
1. **Setting History**: Track changes (who, when, old value, new value)
2. **Setting Categories**: Sub-groups within main groups
3. **Encrypted Settings**: For sensitive data (API keys, passwords)
4. **Setting Validation**: Custom rules per setting
5. **Import/Export**: Backup/restore settings as JSON
6. **Multi-language Settings**: Different values per language
7. **Setting Dependencies**: Auto-update related settings
8. **Web UI for Backup**: Browse, download, restore backups

---

**Created**: November 2025  
**Version**: 1.0  
**Module**: System Settings
