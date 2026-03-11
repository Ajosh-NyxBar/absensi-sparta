# Sistem Informasi Presensi dan Penilaian SMPN 4 Purwakarta

Sistem informasi berbasis web untuk mengelola presensi guru dan siswa menggunakan teknologi geolocation, serta penilaian siswa dengan metode Simple Additive Weighting (SAW).

## 📋 Deskripsi Proyek

Penelitian ini mengembangkan sistem informasi yang mengintegrasikan:
- **Presensi berbasis geolocation** untuk guru dan siswa
- **Penilaian siswa** dengan metode SAW (Simple Additive Weighting)
- **Dashboard monitoring** untuk admin, guru, dan kepala sekolah
- **Laporan prestasi** guru dan siswa berdasarkan perhitungan SAW

## 🎯 Fitur Utama

### 1. Manajemen Pengguna
- Login role-based (Admin, Kepala Sekolah, Guru)
- Manajemen data guru dan siswa
- Manajemen kelas dan mata pelajaran

### 2. Sistem Presensi
- **Geolocation-based attendance** - Presensi hanya bisa dilakukan dalam radius sekolah
- Check-in dan check-out otomatis
- Deteksi keterlambatan
- Riwayat presensi lengkap
- Dashboard monitoring kehadiran

### 3. Sistem Penilaian
- Input nilai siswa per mata pelajaran
- Penilaian harian, UTS, dan UAS
- Nilai sikap dan keterampilan
- Perhitungan nilai akhir otomatis

### 4. Metode SAW (Simple Additive Weighting)

#### Penilaian Siswa
Kriteria penilaian:
- **C1: Nilai Akademik** (Bobot: 35%) - Rata-rata nilai mata pelajaran
- **C2: Kehadiran** (Bobot: 25%) - Persentase kehadiran
- **C3: Sikap** (Bobot: 20%) - Penilaian sikap
- **C4: Keterampilan** (Bobot: 20%) - Penilaian keterampilan

#### Penilaian Guru
Kriteria penilaian:
- **T1: Kehadiran** (Bobot: 30%) - Persentase kehadiran
- **T2: Kualitas Mengajar** (Bobot: 30%) - Penilaian kualitas
- **T3: Prestasi Siswa** (Bobot: 25%) - Rata-rata prestasi siswa
- **T4: Kedisiplinan** (Bobot: 15%) - Tingkat kedisiplinan

#### Langkah Perhitungan SAW
1. Menentukan alternatif dan kriteria
2. Memberikan bobot pada setiap kriteria
3. Membuat matriks keputusan
4. Melakukan normalisasi matriks
5. Menghitung nilai preferensi
6. Menentukan peringkat

## 🛠️ Teknologi yang Digunakan

- **Framework**: Laravel 11.x
- **Database**: MySQL
- **Frontend**: Bootstrap 5, JavaScript
- **Icons**: Font Awesome 6
- **PHP**: 8.2+

## 📦 Instalasi

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM (optional)

### Langkah Instalasi

1. **Clone repository**
```bash
git clone <repository-url>
cd laravel-starter
```

2. **Install dependencies**
```bash
composer install
```

3. **Copy environment file**
```bash
copy .env.example .env
```

4. **Generate application key**
```bash
php artisan key:generate
```

5. **Konfigurasi database**

Edit file `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smpn4_presensi
DB_USERNAME=root
DB_PASSWORD=
```

6. **Buat database**
```sql
CREATE DATABASE smpn4_presensi;
```

7. **Jalankan migrasi dan seeder**
```bash
php artisan migrate --seed
```

8. **Jalankan aplikasi**
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

## 👥 Akun Demo

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@smpn4purwakarta.sch.id | password |
| Kepala Sekolah | kepsek@smpn4purwakarta.sch.id | password |
| Guru | siti.nurjanah@smpn4purwakarta.sch.id | password |

## 📂 Struktur Database

### Tabel Utama
- `users` - Data pengguna sistem
- `roles` - Role pengguna (Admin, Guru, Kepala Sekolah)
- `teachers` - Data guru
- `students` - Data siswa
- `classes` - Data kelas
- `subjects` - Data mata pelajaran
- `attendances` - Data presensi (polymorphic)
- `grades` - Data nilai siswa
- `criteria` - Kriteria penilaian SAW
- `student_assessments` - Hasil penilaian SAW siswa
- `teacher_assessments` - Hasil penilaian SAW guru

## 🎨 Tampilan Aplikasi

### Dashboard
- **Admin**: Monitoring keseluruhan sistem, manajemen data
- **Kepala Sekolah**: Laporan prestasi, monitoring kehadiran
- **Guru**: Input nilai, presensi, riwayat mengajar

### Fitur Presensi
- Geolocation detection
- Check-in/Check-out dengan koordinat
- Validasi radius sekolah
- Status kehadiran real-time

### Fitur SAW
- Perhitungan otomatis dengan bobot kriteria
- Normalisasi matriks
- Ranking siswa dan guru
- Detail perhitungan transparan

## 📊 Metodologi

Penelitian ini menggunakan **SDLC Model Prototype**:
1. Pengumpulan Kebutuhan
2. Membangun Prototyping
3. Evaluasi Prototyping
4. Mengkodekan Sistem
5. Menguji Sistem (Black Box & White Box Testing)
6. Evaluasi Sistem
7. Menggunakan Sistem

## 🔐 Keamanan

- Password hashing menggunakan bcrypt
- CSRF protection
- Role-based access control
- Input validation dan sanitization
- SQL injection protection (Eloquent ORM)

## 📝 Catatan Pengembangan

### Konfigurasi Geolocation
Edit koordinat sekolah di `AttendanceController.php`:
```php
$schoolLat = -6.5465236;  // Latitude SMPN 4 Purwakarta
$schoolLong = 107.4414175; // Longitude SMPN 4 Purwakarta
$allowedRadius = 100;   // Radius dalam meter
```

### Konfigurasi Kriteria SAW
Kriteria dapat diubah melalui database atau seeder di:
`database/seeders/CriteriaSeeder.php`

## 🤝 Kontributor

- **Peneliti**: [Nama Anda]
- **Pembimbing**: [Nama Pembimbing]
- **Institusi**: SMPN 4 Purwakarta

## 📄 Lisensi

Proyek ini dikembangkan untuk keperluan penelitian skripsi.

## 📞 Kontak

Untuk pertanyaan atau saran, silakan hubungi:
- Email: [email@domain.com]
- Website: [https://smpn4purwakarta.sch.id]

---

© 2025 SMPN 4 Purwakarta. All Rights Reserved.
