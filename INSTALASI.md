# Instalasi dan Konfigurasi Sistem

## Persiapan Lingkungan

### Requirements
- PHP >= 8.2
- MySQL >= 5.7 atau MariaDB >= 10.3
- Composer
- Web Server (Apache/Nginx) atau PHP Built-in Server
- Extension PHP yang dibutuhkan:
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer
  - XML
  - Ctype
  - JSON
  - BCMath

## Instalasi Step-by-Step

### 1. Clone atau Extract Project
```bash
cd d:\AKbar\SKRIPSI\KODE\laravel-starter
```

### 2. Install Dependencies
```bash
composer install
```

Jika ada error, coba:
```bash
composer install --ignore-platform-reqs
```

### 3. Setup Environment
```bash
# Copy file .env.example menjadi .env
copy .env.example .env
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Konfigurasi Database

Edit file `.env`:
```env
APP_NAME="SMPN 4 Purwakarta"
APP_ENV=local
APP_KEY=base64:... # Sudah di-generate
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smpn4_presensi
DB_USERNAME=root
DB_PASSWORD=

# Konfigurasi sekolah
SCHOOL_NAME="SMPN 4 Purwakarta"
SCHOOL_ADDRESS="Purwakarta, Jawa Barat"
SCHOOL_LATITUDE=-6.5567
SCHOOL_LONGITUDE=107.4442
ATTENDANCE_RADIUS=100
```

### 6. Buat Database

Buka MySQL/PhpMyAdmin dan jalankan:
```sql
CREATE DATABASE smpn4_presensi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Atau via command line:
```bash
mysql -u root -p
```
```sql
CREATE DATABASE smpn4_presensi;
EXIT;
```

### 7. Jalankan Migration
```bash
php artisan migrate
```

Jika ada error, drop database dan buat ulang:
```bash
php artisan migrate:fresh
```

### 8. Jalankan Seeder
```bash
php artisan db:seed
```

Atau jalankan seeder spesifik:
```bash
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=SubjectSeeder
php artisan db:seed --class=ClassSeeder
php artisan db:seed --class=CriteriaSeeder
```

### 9. Create Storage Link
```bash
php artisan storage:link
```

### 10. Set Permissions (Linux/Mac)
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 11. Jalankan Aplikasi
```bash
php artisan serve
```

Akses di browser: `http://localhost:8000`

## Konfigurasi Lanjutan

### Koordinat Sekolah

Edit `app/Http/Controllers/AttendanceController.php` baris 89-91:
```php
$schoolLat = -6.5567;  // Ganti dengan latitude sekolah
$schoolLong = 107.4442; // Ganti dengan longitude sekolah
$allowedRadius = 100;   // Radius dalam meter
```

**Cara mendapatkan koordinat:**
1. Buka Google Maps
2. Cari lokasi sekolah
3. Klik kanan > "What's here?"
4. Copy koordinat yang muncul

### Kriteria Penilaian SAW

Edit bobot kriteria di `database/seeders/CriteriaSeeder.php`:

**Untuk Siswa:**
```php
'C1' => ['weight' => 0.35], // Nilai Akademik
'C2' => ['weight' => 0.25], // Kehadiran
'C3' => ['weight' => 0.20], // Sikap
'C4' => ['weight' => 0.20], // Keterampilan
```

**Untuk Guru:**
```php
'T1' => ['weight' => 0.30], // Kehadiran
'T2' => ['weight' => 0.30], // Kualitas Mengajar
'T3' => ['weight' => 0.25], // Prestasi Siswa
'T4' => ['weight' => 0.15], // Kedisiplinan
```

Setelah edit, jalankan ulang seeder:
```bash
php artisan db:seed --class=CriteriaSeeder
```

### Perhitungan Nilai Akhir

Edit bobot di `app/Http/Controllers/GradeController.php` baris 135-137:
```php
$finalGrade = ($dailyTest * 0.3) + ($midtermExam * 0.3) + ($finalExam * 0.4);
```

Ubah sesuai kebijakan sekolah, contoh:
```php
$finalGrade = ($dailyTest * 0.4) + ($midtermExam * 0.3) + ($finalExam * 0.3);
```

## Testing

### Test Login
1. Buka `http://localhost:8000`
2. Login dengan salah satu akun:
   - Admin: admin@smpn4purwakarta.sch.id / password
   - Kepsek: kepsek@smpn4purwakarta.sch.id / password
   - Guru: siti.nurjanah@smpn4purwakarta.sch.id / password

### Test Presensi
1. Login sebagai guru
2. Klik "Check-in"
3. Izinkan akses lokasi
4. Sistem akan validasi koordinat

### Test Input Nilai
1. Login sebagai guru
2. Menu "Input Nilai"
3. Pilih kelas dan mata pelajaran
4. Isi nilai siswa

### Test SAW
1. Login sebagai admin/kepsek
2. Menu "Prestasi Siswa"
3. Pilih kelas dan semester
4. Klik "Hitung SAW"

## Troubleshooting

### Error: "Class not found"
```bash
composer dump-autoload
```

### Error: "Access denied for user"
Periksa kredensial database di `.env`

### Error: "Base table or view not found"
```bash
php artisan migrate:fresh --seed
```

### Error: "The stream or file could not be opened"
```bash
# Windows
icacls storage /grant Users:F /T
icacls bootstrap/cache /grant Users:F /T

# Linux/Mac
chmod -R 775 storage bootstrap/cache
```

### Presensi tidak berfungsi
1. Periksa browser support geolocation
2. Pastikan HTTPS atau localhost
3. Izinkan akses lokasi di browser

## Deployment ke Production

### 1. Update .env
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://smpn4purwakarta.sch.id
```

### 2. Optimize
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

### 3. Setup Web Server

**Apache (.htaccess sudah included)**

**Nginx:**
```nginx
server {
    listen 80;
    server_name smpn4purwakarta.sch.id;
    root /path/to/laravel-starter/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 4. Setup SSL (Let's Encrypt)
```bash
sudo certbot --nginx -d smpn4purwakarta.sch.id
```

### 5. Setup Cron (untuk scheduled tasks)
```bash
* * * * * cd /path/to/laravel-starter && php artisan schedule:run >> /dev/null 2>&1
```

## Backup Database

### Manual Backup
```bash
mysqldump -u root -p smpn4_presensi > backup.sql
```

### Restore
```bash
mysql -u root -p smpn4_presensi < backup.sql
```

## Update Aplikasi

```bash
git pull origin main
composer install
php artisan migrate
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## Support

Jika menemui masalah:
1. Periksa log di `storage/logs/laravel.log`
2. Aktifkan debug mode di `.env`: `APP_DEBUG=true`
3. Hubungi developer
