    # 4.1.4 Mengkodekan Sistem

Setelah rancangan prototype dinyatakan layak oleh seluruh evaluator pada tahap evaluasi, peneliti melanjutkan ke tahap pengkodean sistem. Pada tahap ini, seluruh rancangan yang telah dibuat pada tahap sebelumnya — meliputi diagram use case, activity diagram, class diagram, struktur basis data, desain antarmuka, dan algoritma SAW — diterjemahkan menjadi kode program yang fungsional. Proses pengkodean dilakukan secara bertahap dimulai dari penyiapan lingkungan pengembangan, implementasi basis data, implementasi setiap modul fitur, hingga implementasi algoritma SAW.

---

## 4.1.4.1 Lingkungan Pengembangan

Langkah pertama dalam tahap pengkodean adalah menyiapkan lingkungan pengembangan (*development environment*) yang terdiri dari framework, bahasa pemrograman, library pendukung, serta tools pengembangan. Pemilihan teknologi dilakukan berdasarkan pertimbangan kebutuhan sistem, kompatibilitas, dukungan komunitas, serta kemudahan pengembangan.

### a. Framework dan Bahasa Pemrograman

Peneliti memilih **Laravel versi 12** sebagai framework utama karena Laravel menerapkan arsitektur MVC (*Model-View-Controller*) yang memisahkan logika bisnis, tampilan, dan akses data secara terstruktur. Laravel juga menyediakan fitur bawaan yang mendukung kebutuhan sistem, antara lain: Eloquent ORM untuk interaksi dengan database, Blade templating engine untuk rendering halaman, middleware untuk otorisasi, serta migration dan seeder untuk pengelolaan skema database. Bahasa pemrograman yang digunakan adalah **PHP versi 8.2** atau lebih tinggi, sesuai dengan persyaratan minimum Laravel 12.

> **Gambar 4.17** — *Screenshot* file `composer.json` bagian `"require"`, menunjukkan versi Laravel (`"laravel/framework": "^12.0"`) dan PHP (`"php": "^8.2"`), serta library pendukung (`simplesoftwareio/simple-qrcode`, `maatwebsite/excel`, `barryvdh/laravel-dompdf`).

Untuk bagian frontend, peneliti menggunakan dua pendekatan tampilan:

1. **Layout Bootstrap** (`resources/views/layouts/app.blade.php`) — menggunakan Bootstrap 5.3 yang dimuat melalui CDN (*Content Delivery Network*) beserta Font Awesome untuk ikon. Layout ini digunakan pada halaman-halaman manajemen data yang bersifat fungsional.
2. **Layout Modern** (`resources/views/layouts/modern.blade.php`) — menggunakan **Tailwind CSS versi 4** sebagai framework CSS *utility-first* yang memungkinkan penulisan styling secara langsung pada elemen HTML. Layout ini dimuat melalui **Vite versi 5.4** yang terintegrasi dengan Laravel melalui plugin `laravel-vite-plugin`. Selain itu, layout modern juga memuat **Alpine.js** melalui CDN sebagai framework JavaScript ringan untuk menangani interaktivitas pada sisi klien (*client-side*), seperti toggle menu dan dropdown. Layout ini digunakan pada halaman dashboard dan halaman lain yang membutuhkan tampilan yang lebih modern.

> **Gambar 4.18** — *Screenshot* file `resources/views/layouts/modern.blade.php` bagian `<head>`, menunjukkan pemanggilan Vite (`@vite(...)`) dan Alpine.js CDN (`<script defer src="...alpinejs...">`).

### b. Library Pendukung

Selain framework utama, peneliti menggunakan beberapa library pihak ketiga untuk mendukung fitur-fitur khusus sistem. Tabel 4.49 berikut menyajikan daftar library yang digunakan beserta fungsinya:

**Tabel 4.49 Daftar Library Pendukung**

| No | Library | Versi | Fungsi |
|----|---------|-------|--------|
| 1 | `simplesoftwareio/simple-qrcode` | 4.2 | Membuat (*generate*) QR Code terenkripsi untuk fitur absensi guru. Library ini menghasilkan gambar QR Code dalam format SVG yang dapat dipindai oleh kamera perangkat |
| 2 | `maatwebsite/excel` | 3.1 | Melakukan export data ke format file Microsoft Excel (.xlsx). Digunakan pada modul laporan untuk mengekspor data absensi, nilai, data siswa, dan data guru |
| 3 | `barryvdh/laravel-dompdf` | 3.1 | Melakukan export data ke format file PDF. Digunakan pada modul laporan sebagai alternatif format export selain Excel |

Library-library ini diinstal melalui Composer, yaitu *package manager* untuk PHP, dengan menjalankan perintah `composer require` diikuti nama library.

### c. Database

Peneliti menggunakan **MySQL** sebagai Sistem Manajemen Basis Data Relasional (RDBMS). MySQL dipilih karena memiliki performa yang baik untuk aplikasi web, mendukung penuh fitur *foreign key constraint* untuk menjaga integritas referensial data, serta kompatibel dengan Eloquent ORM bawaan Laravel.

### d. Ringkasan Teknologi

Tabel 4.50 berikut merangkum seluruh teknologi yang digunakan dalam pengembangan sistem:

**Tabel 4.50 Ringkasan Teknologi Pengembangan**

| No | Komponen | Teknologi | Versi |
|----|----------|-----------|-------|
| 1 | Framework Backend | Laravel | 12.0 |
| 2 | Bahasa Pemrograman | PHP | ≥ 8.2 |
| 3 | Framework CSS (Fungsional) | Bootstrap | 5.3 |
| 4 | Framework CSS (Modern) | Tailwind CSS | 4.0 |
| 5 | Framework JavaScript | Alpine.js | 3.x |
| 6 | Build Tool Frontend | Vite | 5.4 |
| 7 | Database | MySQL | — |
| 8 | Library QR Code | simplesoftwareio/simple-qrcode | 4.2 |
| 9 | Library Export Excel | maatwebsite/excel | 3.1 |
| 10 | Library Export PDF | barryvdh/laravel-dompdf | 3.1 |
| 11 | Framework Testing | PHPUnit | 11.5 |
| 12 | Package Manager PHP | Composer | — |
| 13 | Package Manager JS | NPM | — |
| 14 | Code Editor | Visual Studio Code | — |

---

## 4.1.4.2 Struktur Direktori dan Arsitektur Kode

Peneliti mengorganisasikan kode program mengikuti konvensi standar arsitektur MVC bawaan Laravel. Selain MVC, peneliti juga menerapkan pola *Service Layer* untuk memisahkan logika bisnis yang kompleks (seperti perhitungan SAW) dari controller, sehingga kode lebih modular dan mudah dipelihara.

> **Gambar 4.19** — *Screenshot* struktur direktori utama project di VS Code (panel *Explorer*), menunjukkan folder `app/Http/Controllers/`, `app/Models/`, `app/Services/`, `app/Exports/`, `app/Helpers/`, `database/migrations/`, `database/seeders/`, `resources/views/`, dan `routes/`.

Tabel 4.50a berikut menunjukkan struktur direktori utama beserta jumlah file dan fungsinya:

**Tabel 4.50a Struktur Direktori Utama Project**

| No | Direktori / File | Jumlah File | Keterangan |
|----|------------------|-------------|------------|
| 1 | `app/Http/Controllers/` | 20 controller | Menangani logika request-response untuk setiap modul: `AuthController`, `AttendanceController`, `KioskController`, `GradeController`, `SAWController`, `ReportController`, `DashboardController`, `TeacherController`, `StudentController`, `CriteriaController`, `UserController`, `ProfileController`, `SettingController`, `AcademicYearController`, `ClassRoomController`, `SubjectController`, `TeacherSubjectController`, `NotificationController`, `LanguageController` |
| 2 | `app/Models/` | 15 model | Model Eloquent untuk setiap entitas: `User`, `Role`, `Teacher`, `Student`, `ClassRoom`, `Subject`, `TeacherSubject`, `Attendance`, `Grade`, `Criteria`, `StudentAssessment`, `TeacherAssessment`, `AcademicYear`, `Setting`, `Notification` |
| 3 | `app/Services/` | 1 service | `SAWService.php` — class terpisah yang menangani seluruh perhitungan metode SAW |
| 4 | `app/Exports/` | 4 class export | `AttendanceExport`, `GradesExport`, `StudentsExport`, `TeachersExport` — menangani format dan isi file export Excel |
| 5 | `app/Helpers/` | 1 helper | `SettingHelper.php` — menyediakan fungsi global `setting()` dan `settings()` untuk mengakses konfigurasi sistem dari tabel `settings` |
| 6 | `app/Http/Middleware/` | 2 middleware | `CheckRole` untuk otorisasi akses berdasarkan role pengguna, dan `SetLocale` untuk pengaturan bahasa tampilan |
| 7 | `database/migrations/` | 18 migrasi | File migrasi untuk pembuatan seluruh tabel database |
| 8 | `database/seeders/` | 17 seeder | File seeder untuk pengisian data awal sistem (termasuk `DatabaseSeeder` sebagai orkestrator) |
| 9 | `resources/views/` | 63 template Blade | Template Blade untuk seluruh halaman antarmuka, diorganisasikan ke dalam 19 subfolder berdasarkan modul (dashboard, attendance, grades, reports, saw, kiosk, settings, dll.) |
| 10 | `routes/web.php` | 1 file | Definisi seluruh route aplikasi dengan pengelompokan berdasarkan middleware autentikasi dan otorisasi role |

---

## 4.1.4.3 Implementasi Basis Data

Peneliti mengimplementasikan rancangan basis data yang telah dibuat pada tahap perancangan prototype menggunakan fitur **migrasi** Laravel. Migrasi adalah file PHP yang mendefinisikan struktur tabel (kolom, tipe data, constraint, dan indeks) secara programatik, sehingga pembuatan dan modifikasi skema database dapat dilakukan secara terkontrol dan terdokumentasi.

### a. Pembuatan Tabel Database

Sebanyak 18 file migrasi dibuat untuk menghasilkan seluruh tabel yang dibutuhkan sistem. Setiap file migrasi berisi definisi kolom lengkap dengan tipe data, constraint `NOT NULL`, nilai default, serta foreign key. Peneliti menjalankan perintah `php artisan migrate` untuk mengeksekusi seluruh migrasi sekaligus dan membuat tabel-tabel secara otomatis di database MySQL.

> **Gambar 4.20** — *Screenshot* daftar file migrasi di folder `database/migrations/` pada panel Explorer VS Code, menunjukkan 18 file migrasi yang tersusun berurutan.

Sebagai contoh, tabel `attendances` diimplementasikan dengan struktur kolom berikut:

- Kolom `attendable_type` (string) dan `attendable_id` (unsigned big integer) untuk relasi *polymorphic* — satu tabel dapat menyimpan absensi guru maupun siswa
- Kolom `check_in` dan `check_out` bertipe `TIME` (nullable) untuk mencatat waktu masuk dan pulang
- Kolom `status` bertipe `ENUM` dengan 5 nilai: `present` (hadir), `late` (terlambat), `absent` (tidak hadir), `sick` (sakit), dan `permission` (izin), dengan nilai default `present`
- Kolom `latitude_in`, `longitude_in`, `latitude_out`, `longitude_out` bertipe `STRING` (nullable) untuk menyimpan koordinat GPS saat check-in dan check-out
- Kolom `qr_code` (string, nullable) untuk menyimpan data QR Code yang digunakan
- Kolom `notes` (text, nullable) untuk keterangan tambahan
- Index *composite* pada kolom `[attendable_type, attendable_id]` dan index pada kolom `date` untuk mempercepat query pencarian

> **Gambar 4.21** — *Screenshot* kode file `database/migrations/2024_01_01_000007_create_attendances_table.php`, menunjukkan definisi skema tabel attendances lengkap dengan kolom polymorphic, enum status, kolom koordinat GPS, dan index.

Contoh lain, tabel `grades` diimplementasikan dengan:

- Foreign key ke tabel `students`, `subjects`, dan `teachers` dengan constraint `ON DELETE CASCADE`
- Kolom nilai bertipe `DECIMAL(5,2)` untuk presisi: `daily_test` (ulangan harian), `midterm_exam` (UTS), `final_exam` (UAS), `final_grade` (nilai akhir), `behavior_score` (nilai sikap), `skill_score` (nilai keterampilan) — seluruhnya nullable
- Kolom `notes` (text, nullable) untuk keterangan tambahan
- Unique constraint *composite* pada kolom `[student_id, subject_id, semester, academic_year]` untuk mencegah duplikasi data nilai — satu siswa hanya memiliki satu record nilai untuk satu mata pelajaran pada semester dan tahun ajaran yang sama

> **Gambar 4.22** — *Screenshot* kode file `database/migrations/2024_01_01_000009_create_grades_table.php`, menunjukkan definisi skema tabel grades lengkap dengan foreign key, kolom decimal untuk nilai, dan unique constraint.

### b. Relasi Antar Tabel

Relasi antar tabel diimplementasikan melalui dua mekanisme:

1. **Foreign Key Constraint** pada level database — didefinisikan dalam file migrasi menggunakan method `foreignId()->constrained()->onDelete('cascade')`. Mekanisme ini menjamin integritas referensial data, artinya tidak mungkin ada data anak (*child record*) yang mereferensikan data induk (*parent record*) yang tidak ada.

2. **Eloquent Relationship** pada level model Laravel — didefinisikan sebagai method pada class model. Peneliti mengimplementasikan beberapa jenis relasi:
   - **One-to-Many**: contohnya `ClassRoom` memiliki banyak `Student`, diimplementasikan dengan `hasMany()` dan `belongsTo()`
   - **Many-to-Many**: contohnya relasi guru–mata pelajaran–kelas melalui tabel pivot `teacher_subjects`, diimplementasikan dengan `belongsToMany()`
   - **Polymorphic**: contohnya `Attendance` dapat dimiliki oleh `Teacher` maupun `Student`, diimplementasikan dengan `morphTo()` pada model `Attendance` dan `morphMany()` pada model `Teacher` dan `Student`
   - **One-to-One**: contohnya `Teacher` memiliki satu `User`, diimplementasikan dengan `belongsTo()`

> **Gambar 4.23** — *Screenshot* kode file `app/Models/Attendance.php`, menunjukkan relasi `morphTo()` pada method `attendable()` serta method helper `isOnTime()` dan `isWithinRadius()`.

### c. Seeder Data Awal

Peneliti membuat 17 file seeder untuk pengisian data awal yang diperlukan agar sistem dapat beroperasi. File `DatabaseSeeder.php` berfungsi sebagai orkestrator yang memanggil 10 seeder utama secara berurutan. Seeder dieksekusi melalui perintah `php artisan db:seed`. Data awal yang di-seed meliputi:

1. **`RoleSeeder`** — membuat 4 role pengguna:
   - *Admin* — "Administrator sistem dengan akses penuh"
   - *Kepala Sekolah* — "Kepala sekolah dengan akses monitoring dan laporan"
   - *Guru* — "Guru dengan akses presensi dan penilaian siswa"
   - *Kiosk Presensi* — "Akun khusus untuk display QR Code presensi guru di ruang guru"

2. **`UserSeeder`** — membuat 3 akun default untuk login pertama kali:
   - Administrator (`admin@smpn4purwakarta.sch.id`) dengan role Admin
   - Kepala Sekolah (`kepsek@smpn4purwakarta.sch.id`) dengan role Kepala Sekolah
   - Guru Matematika (`guru@smpn4purwakarta.sch.id`) dengan role Guru, beserta profil guru terkait

3. **`CriteriaSeeder`** — membuat 8 kriteria penilaian SAW:
   - 4 kriteria siswa: Nilai Akademik/C1 (bobot 0,35), Kehadiran/C2 (bobot 0,25), Sikap-Perilaku/C3 (bobot 0,20), Keterampilan/C4 (bobot 0,20) — seluruhnya berjenis *benefit*
   - 4 kriteria guru: Kehadiran/K1 (bobot 0,30), Kualitas Mengajar/K2 (bobot 0,25), Prestasi Siswa/K3 (bobot 0,25), Kedisiplinan/K4 (bobot 0,20) — seluruhnya berjenis *benefit*

4. **`SettingSeeder`** — membuat 25 konfigurasi sistem yang dikelompokkan ke dalam 5 grup:
   - *School* (9 item): nama sekolah, NPSN, alamat, telepon, email, website, logo, nama kepala sekolah, NIP kepala sekolah
   - *General* (5 item): nama aplikasi, timezone (`Asia/Jakarta`), bahasa (`id`), format tanggal, format waktu
   - *Appearance* (3 item): warna tema, warna sidebar, jumlah item per halaman
   - *Notification* (3 item): notifikasi email, notifikasi SMS, email penerima notifikasi
   - *System* (4 item): mode maintenance, auto backup, jadwal backup, ukuran maksimal upload

5. **`TeacherSeeder`, `SubjectSeeder`, `ClassSeeder`, `StudentSeeder`** — data master guru, mata pelajaran, kelas, dan siswa SMPN 4 Purwakarta. Untuk data siswa, terdapat juga seeder tambahan per tingkat: `StudentKelas7Seeder`, `StudentKelas8Seeder`, dan `StudentKelas9Seeder`.

6. **`AttendanceSeeder`, `GradeSeeder`, `StudentAssessmentSeeder`** — contoh data absensi, nilai, dan penilaian siswa untuk keperluan pengujian.

7. **`AcademicYearSeeder`, `NotificationSeeder`** — data tahun ajaran dan notifikasi awal.

> **Gambar 4.24** — *Screenshot* kode file `database/seeders/DatabaseSeeder.php`, menunjukkan urutan pemanggilan 10 seeder utama melalui method `$this->call([...])`.

---

## 4.1.4.4 Implementasi Fitur Sistem

Peneliti mengimplementasikan seluruh fitur sistem berdasarkan rancangan use case dan activity diagram yang telah dievaluasi dan disetujui pada tahap evaluasi prototype.

### a. Modul Autentikasi (*Login*)

Modul autentikasi diimplementasikan pada `AuthController` dengan memanfaatkan fitur *session-based authentication* bawaan Laravel. Proses login bekerja sebagai berikut:

1. Pengguna memasukkan email dan password pada halaman login. Halaman login juga menampilkan informasi profil sekolah yang diambil dari tabel `settings` melalui helper `setting()`.
2. Sistem memverifikasi kredensial menggunakan method `Auth::attempt()`.
3. Jika valid, sistem mengidentifikasi role pengguna dari relasi `user->role`.
4. Sistem melakukan redirect ke dashboard yang sesuai berdasarkan role:
   - *Kiosk Presensi* → halaman Kiosk Dashboard
   - *Admin* → Dashboard Admin
   - *Kepala Sekolah* → Dashboard Kepala Sekolah
   - *Guru* → Dashboard Guru
5. Jika tidak valid, sistem mengembalikan pesan error "*Email atau password salah*".

> **Gambar 4.25** — *Screenshot* kode `AuthController.php` method `login()` dan `dashboard()`, menunjukkan proses autentikasi dengan `Auth::attempt()` dan logika redirect berdasarkan role.

Untuk otorisasi, peneliti membuat middleware `CheckRole` yang memfilter akses berdasarkan role. Middleware ini menerima daftar role yang diizinkan sebagai parameter dan memeriksa apakah role pengguna yang login termasuk di dalamnya. Jika tidak berwenang, sistem mengembalikan HTTP status 403. Middleware ini diterapkan pada kelompok route di `routes/web.php` sehingga setiap endpoint hanya dapat diakses oleh role yang berwenang.

> **Gambar 4.26** — *Screenshot* kode `app/Http/Middleware/CheckRole.php`, menunjukkan logika pengecekan role pengguna pada method `handle()`.

Selain `CheckRole`, peneliti juga membuat middleware `SetLocale` yang membaca preferensi bahasa dari session pengguna dan mengatur locale aplikasi (mendukung bahasa Indonesia dan Inggris).

### b. Modul Absensi Guru

Modul absensi merupakan fitur inti pertama sistem yang diimplementasikan pada dua controller: `AttendanceController` untuk alur absensi melalui halaman admin/guru, dan `KioskController` untuk alur absensi melalui perangkat kiosk di ruang guru.

**1) Generate QR Code**

QR Code untuk absensi guru dihasilkan melalui dua mekanisme yang berbeda:

- **Melalui halaman Admin** (`AttendanceController`): Admin memilih guru pada halaman `admin-qr`, lalu sistem memanggil method `getTeacherQR()` yang menghasilkan QR Code melalui API endpoint. Data yang dienkripsi meliputi: `teacher_id`, `name` (nama guru), `date` (tanggal hari ini), dan `timestamp` (waktu pembuatan). QR Code ini memiliki masa berlaku **600 detik (10 menit)**.
- **Melalui perangkat Kiosk** (`KioskController`): Mode kiosk dirancang untuk perangkat tampilan (*display*) yang ditempatkan di ruang guru. Guru memilih namanya pada layar kiosk, lalu QR Code di-generate melalui method `generateQR()`. Data yang dienkripsi sama dengan mekanisme admin, namun masa berlaku QR Code lebih singkat yaitu **60 detik (1 menit)** karena guru langsung memindai di tempat. QR Code di-generate dengan level koreksi error H (*High*, 30%) untuk memastikan keterbacaan.

Data dienkripsi menggunakan fungsi `encrypt()` bawaan Laravel yang berbasis algoritma **AES-256-CBC** sehingga tidak dapat dibaca atau dipalsukan.

> **Gambar 4.27** — *Screenshot* kode `AttendanceController.php` method `getTeacherQR()`, menunjukkan proses enkripsi data guru dan pembuatan QR Code SVG menggunakan library `simplesoftwareio/simple-qrcode`.

> **Gambar 4.28** — *Screenshot* kode `KioskController.php` method `generateQR()`, menunjukkan masa berlaku 60 detik dan level koreksi error H.

**2) Scan QR Code dan Validasi**

Method `scanQR()` pada `AttendanceController` menangani proses ketika guru memindai QR Code. Alur proses yang diimplementasikan:

1. Sistem menerima data QR Code dari hasil scan kamera perangkat.
2. Data didekripsi menggunakan `decrypt()`. Jika dekripsi gagal (QR rusak/palsu), sistem mengembalikan error "*QR Code tidak valid atau rusak*".
3. Sistem memvalidasi kelengkapan data: harus mengandung `teacher_id`, `date`, dan `timestamp`.
4. Sistem memeriksa masa berlaku QR Code dengan menghitung selisih waktu saat ini dengan `timestamp` QR. Jika selisih melebihi **600 detik (10 menit)**, QR Code dinyatakan kadaluarsa.
5. Sistem memeriksa apakah tanggal pada QR Code sesuai dengan tanggal hari ini.
6. Sistem memeriksa data absensi guru pada hari tersebut:
   - Jika **belum ada data check-in**: sistem mencatat sebagai check-in beserta koordinat GPS. Status ditentukan otomatis — jika waktu scan **sebelum pukul 07:30** maka status = `present` (tepat waktu), jika **setelah 07:30** maka status = `late` (terlambat).
   - Jika **sudah check-in tapi belum check-out**: sistem mencatat sebagai check-out beserta koordinat GPS.
   - Jika **sudah check-in dan check-out**: sistem mengembalikan pesan "*Anda sudah melakukan check-in dan check-out hari ini*".

Pada `KioskController`, proses scan diimplementasikan pada method `processQRScan()` dengan alur serupa, ditambah validasi bahwa guru yang memindai QR Code adalah guru yang sama dengan pemilik QR Code tersebut (mencegah penyalahgunaan).

> **Gambar 4.29** — *Screenshot* kode `AttendanceController.php` method `scanQR()`, menunjukkan proses dekripsi, validasi masa berlaku (600 detik), penentuan status tepat waktu/terlambat (batas 07:30), dan logika check-in/check-out.

**3) Validasi Geolocation**

Method `checkIn()` dan `checkOut()` pada `AttendanceController` mengimplementasikan validasi lokasi. Saat guru melakukan absensi, sistem mengambil koordinat GPS dari browser perangkat guru, kemudian menghitung jarak antara posisi guru dengan titik koordinat sekolah menggunakan **formula Haversine**. Formula Haversine diimplementasikan pada method `calculateDistance()` dengan parameter:

- Radius bumi ditetapkan sebesar **6.371.000 meter**
- Koordinat latitude dan longitude dikonversi dari derajat ke radian menggunakan fungsi `deg2rad()`
- Jarak dihitung dengan formula: `2 × arcsin(√(sin²(Δlat/2) + cos(lat1) × cos(lat2) × sin²(Δlon/2))) × radius_bumi`

Titik koordinat acuan SMPN 4 Purwakarta yang ditetapkan dalam kode:
- Latitude: **-6.5465236**
- Longitude: **107.4414175**
- Radius toleransi: **100 meter**

Jika jarak yang dihitung melebihi radius toleransi, absensi ditolak dan sistem menampilkan pesan bahwa guru berada di luar area sekolah. Koordinat GPS guru saat check-in dan check-out disimpan ke kolom `latitude_in`, `longitude_in`, `latitude_out`, `longitude_out` pada tabel `attendances` sebagai bukti lokasi.

> **Gambar 4.30** — *Screenshot* kode `AttendanceController.php` method `calculateDistance()`, menunjukkan implementasi formula Haversine, serta bagian method `checkIn()` yang menampilkan validasi koordinat sekolah dan radius 100 meter.

**4) Absensi Siswa per Kelas**

Method `classAttendance()` dan `saveClassAttendance()` menangani absensi siswa yang dilakukan oleh guru kelas atau admin. Guru memilih kelas, kemudian form menampilkan daftar seluruh siswa dalam kelas tersebut. Guru menandai status kehadiran setiap siswa (hadir, sakit, izin, atau tidak hadir), kemudian data disimpan secara batch ke tabel `attendances` menggunakan relasi polymorphic. Apabila ada siswa yang tidak hadir, sistem secara otomatis mengirimkan notifikasi.

### c. Modul Penilaian Siswa

Modul penilaian diimplementasikan pada `GradeController` dengan fitur-fitur berikut:

**1) Input Nilai per Mata Pelajaran**

Guru memilih kelas dan mata pelajaran melalui halaman `create`, kemudian sistem menampilkan form tabel berisi seluruh siswa dalam kelas tersebut pada halaman `inputByClass`. Form tersebut dibatasi berdasarkan penugasan guru (*teacher-subject assignment*), sehingga guru hanya dapat menginput nilai untuk mata pelajaran dan kelas yang diajarnya. Untuk setiap siswa, guru dapat memasukkan:

- **Nilai Tugas Harian** (`daily_test`)
- **Nilai UTS** (`midterm_exam`)
- **Nilai UAS** (`final_exam`)
- **Nilai Sikap** (`behavior_score`)
- **Nilai Keterampilan** (`skill_score`)

Sistem menghitung **nilai akhir** (`final_grade`) secara otomatis dengan formula pembobotan:

**Nilai Akhir = (Tugas Harian × 0,30) + (UTS × 0,30) + (UAS × 0,40)**

Setelah disimpan, sistem mengirimkan notifikasi kepada admin dan kepala sekolah bahwa nilai baru telah diinput.

> **Gambar 4.31** — *Screenshot* kode `GradeController.php` method `storeMultiple()`, menunjukkan formula penghitungan nilai akhir (`daily_test * 0.3 + midterm_exam * 0.3 + final_exam * 0.4`) dan mekanisme penyimpanan nilai untuk seluruh siswa dalam satu kali proses.

**2) Validasi Input Nilai**

Sebelum data disimpan, sistem melakukan validasi terhadap setiap nilai yang dimasukkan:
- Nilai harus berupa angka (*numeric*)
- Nilai harus berada dalam rentang **0 sampai 100** (`min:0|max:100`)
- Jika validasi gagal, sistem menampilkan pesan error pada kolom yang bersangkutan

**3) Mekanisme Update Nilai**

Ketika guru membuka form input nilai untuk kelas dan mata pelajaran yang sudah memiliki data sebelumnya, sistem secara otomatis mengambil data nilai yang tersimpan (*pre-filled*) dan menampilkannya pada form melalui method `inputByClass()`. Mekanisme ini diimplementasikan dengan query ke tabel `grades` berdasarkan `student_id`, `subject_id`, `semester`, dan `academic_year`, kemudian hasilnya di-pass ke view sebagai `existingGrades`. Unique constraint pada database juga memastikan tidak terjadi duplikasi data.

**4) Rapor Siswa**

Method `reportCard()` menampilkan rapor lengkap untuk satu siswa, termasuk seluruh nilai mata pelajaran beserta rata-rata nilai akhir pada semester dan tahun ajaran yang dipilih.

### d. Modul Dashboard

Modul dashboard diimplementasikan pada `DashboardController` dan menyajikan ringkasan data yang berbeda berdasarkan role pengguna yang login:

- **Dashboard Admin** (menggunakan view `dashboard.admin-modern` dengan layout Tailwind): menampilkan jumlah total siswa, guru, kelas, dan mata pelajaran; statistik kehadiran hari ini; distribusi siswa per tingkat kelas; grafik kehadiran mingguan; daftar kehadiran terbaru; serta statistik bulanan yang mencakup persentase kehadiran, rata-rata nilai, dan tingkat penyelesaian data.
- **Dashboard Guru**: menampilkan informasi kehadiran pribadi dan rekap nilai kelas yang diampu.
- **Dashboard Kepala Sekolah**: menampilkan monitoring kehadiran guru, statistik penilaian siswa, serta informasi ringkasan untuk keperluan pengawasan.

> **Gambar 4.32** — *Screenshot* kode `DashboardController.php` method `admin()`, menunjukkan query statistik yang dikirim ke view (total siswa/guru/kelas, attendance stats, weekly chart data, monthly stats).

### e. Modul Laporan dan Export

Modul laporan diimplementasikan pada `ReportController` dengan 5 method (`index`, `exportAttendance`, `exportGrades`, `exportStudents`, `exportTeachers`) dan didukung oleh 4 class export di direktori `app/Exports/`:

**1) Jenis Laporan yang Tersedia**

| No | Jenis Laporan | Class Export | Filter yang Tersedia |
|----|--------------|-------------|---------------------|
| 1 | Laporan Presensi | `AttendanceExport` | Tanggal mulai, tanggal akhir, tipe (guru/siswa) |
| 2 | Laporan Nilai Siswa | `GradesExport` | Kelas, semester, tahun ajaran |
| 3 | Laporan Data Siswa | `StudentsExport` | Kelas, tingkat (7/8/9), status (aktif/tidak aktif) |
| 4 | Laporan Data Guru | `TeachersExport` | — (seluruh guru) |

**2) Format Export**

Setiap laporan dapat diekspor dalam dua format:
- **Excel (.xlsx)**: menggunakan library `maatwebsite/excel`. Setiap class export mengimplementasikan interface `FromCollection`, `WithHeadings`, `WithMapping`, `WithStyles`, dan `WithTitle` untuk mendefinisikan data, header kolom, pemetaan baris, styling (header berwarna ungu/`#667eea` dengan tek putih tebal), dan nama sheet.
- **PDF**: menggunakan library `barryvdh/laravel-dompdf`. File PDF dihasilkan dari template Blade khusus yang disimpan di direktori `resources/views/reports/pdf/` (4 file: `attendance.blade.php`, `grades.blade.php`, `students.blade.php`, `teachers.blade.php`) dengan layout yang disesuaikan untuk format cetak. Pada export PDF absensi, disertakan ringkasan (*summary*) jumlah per status kehadiran.

> **Gambar 4.33** — *Screenshot* kode `app/Exports/AttendanceExport.php`, menunjukkan implementasi interface export Excel dengan kolom heading, mapping data, dan styling header.

> **Gambar 4.34** — *Screenshot* kode `ReportController.php` method `exportAttendance()`, menunjukkan logika percabangan format export (Excel vs PDF) dan pembuatan nama file otomatis.

### f. Modul Pengaturan Sistem

Modul pengaturan diimplementasikan pada `SettingController` dan memungkinkan admin untuk mengkonfigurasi 25 parameter sistem melalui antarmuka web tanpa perlu mengubah file konfigurasi secara manual. Pengaturan disimpan pada tabel `settings` dengan format key-value dan dikelompokkan ke dalam 5 grup:

1. **School** (9 item) — profil sekolah: nama, NPSN, alamat, telepon, email, website, logo, kepala sekolah, NIP
2. **General** (5 item) — umum: nama aplikasi, timezone, bahasa, format tanggal, format waktu
3. **Appearance** (3 item) — tampilan: warna tema, warna sidebar, jumlah item per halaman
4. **Notification** (3 item) — notifikasi: toggle email/SMS, alamat email penerima
5. **System** (4 item) — sistem: mode maintenance, auto backup, jadwal backup, ukuran maksimal upload

`SettingController` menyediakan method update terpisah untuk masing-masing grup (`updateSchool`, `updateGeneral`, `updateAppearance`, `updateNotification`, `updateSystem`), serta fitur *clear cache* dan *backup database*. Fitur backup diimplementasikan menggunakan perintah `mysqldump` yang dijalankan dari PHP.

Akses ke nilai pengaturan dari seluruh bagian sistem dilakukan melalui helper function `setting($key, $default)` dan `settings($group)` yang didefinisikan pada `SettingHelper.php`.

> **Gambar 4.35** — *Screenshot* kode `SettingController.php` method `index()`, menunjukkan pengelompokan setting ke dalam 5 grup yang dikirim ke view.

### g. Modul Notifikasi

Sistem notifikasi diimplementasikan melalui `NotificationController` yang menyediakan fitur notifikasi dalam aplikasi (*in-app notification*). Notifikasi dikirim secara otomatis oleh sistem pada kejadian-kejadian penting, seperti: saat nilai baru diinput oleh guru, saat terdapat siswa yang tidak hadir, dan lain-lain. Pengguna dapat melihat daftar notifikasi, menandai sebagai sudah dibaca, atau menghapus notifikasi melalui halaman khusus. API endpoint juga tersedia untuk mengambil jumlah notifikasi belum dibaca, sehingga badge notifikasi pada header dapat diperbarui secara real-time.

---

## 4.1.4.5 Implementasi Algoritma SAW

Peneliti mengimplementasikan algoritma Simple Additive Weighting (SAW) dalam class terpisah bernama `SAWService` yang ditempatkan di direktori `app/Services/`. Pemisahan ini dilakukan untuk menjaga prinsip *Single Responsibility Principle* — controller (`SAWController`) hanya menangani request/response, sedangkan logika perhitungan SAW sepenuhnya ditangani oleh service.

Class `SAWService` memiliki 2 method publik dan 4 method protected yang merepresentasikan setiap tahapan SAW:

### a. Method `calculate()` — Orkestrator Perhitungan

Method publik utama ini menerima dua parameter: koleksi data (siswa atau guru) dan tipe perhitungan (`'student'` atau `'teacher'`). Method ini mengorkestrasi seluruh tahapan perhitungan SAW secara berurutan:

1. Mengambil kriteria dari database berdasarkan tipe
2. Memanggil `buildDecisionMatrix()` — membangun matriks keputusan
3. Memanggil `normalizeMatrix()` — menormalisasi matriks
4. Memanggil `calculateSAWScores()` — menghitung nilai preferensi
5. Memanggil `rankAlternatives()` — melakukan perankingan

> **Gambar 4.36** — *Screenshot* kode `app/Services/SAWService.php` method `calculate()`, menunjukkan alur pemanggilan 4 tahapan SAW secara berurutan (build matrix → normalize → calculate scores → rank).

### b. Method `buildDecisionMatrix()` — Penyusunan Matriks Keputusan

Method ini menyusun matriks keputusan dari data input. Setiap baris matriks merepresentasikan satu alternatif (siswa atau guru), dan setiap kolom merepresentasikan satu kriteria:

- **Penilaian Siswa**: C1 = nilai akademik (rata-rata dari `grades`), C2 = kehadiran (persentase kehadiran), C3 = sikap (rata-rata `behavior_score`), C4 = keterampilan (rata-rata `skill_score`)
- **Penilaian Guru**: K1 = kehadiran (persentase kehadiran), K2 = kualitas mengajar (*hardcoded* 80 sebagai nilai default), K3 = prestasi siswa (rata-rata nilai siswa yang diajar), K4 = kedisiplinan (dihitung dari data kehadiran)

> **Gambar 4.37** — *Screenshot* kode `SAWService.php` method `buildDecisionMatrix()`, menunjukkan pemetaan data siswa ke kriteria C1–C4 dan data guru ke kriteria K1–K4.

### c. Method `normalizeMatrix()` — Normalisasi Matriks

Method ini melakukan normalisasi nilai pada setiap sel matriks agar seluruh kriteria berada dalam skala yang sama (0–1). Normalisasi dilakukan berdasarkan jenis kriteria:

- **Kriteria Benefit** (semakin tinggi semakin baik): `r_ij = x_ij / max(x_j)`
  - Nilai setiap alternatif dibagi dengan nilai maksimum pada kriteria tersebut
- **Kriteria Cost** (semakin rendah semakin baik): `r_ij = min(x_j) / x_ij`
  - Nilai minimum pada kriteria tersebut dibagi dengan nilai setiap alternatif

Method ini juga menangani kasus *edge case*: jika nilai maksimum (benefit) atau minimum (cost) adalah nol, maka normalisasi tidak dilakukan untuk menghindari error *division by zero*. Dalam implementasi sistem ini, seluruh 8 kriteria (C1–C4 dan K1–K4) ditetapkan berjenis *benefit*.

> **Gambar 4.38** — *Screenshot* kode `SAWService.php` method `normalizeMatrix()`, menunjukkan logika normalisasi benefit (`x/max`) dan cost (`min/x`) beserta penanganan division by zero.

### d. Method `calculateSAWScores()` — Perhitungan Nilai Preferensi

Method ini menghitung nilai preferensi (V_i) untuk setiap alternatif dengan rumus:

**V_i = Σ (w_j × r_ij)**

Di mana `w_j` adalah bobot kriteria ke-j dan `r_ij` adalah nilai normalisasi alternatif ke-i pada kriteria ke-j. Hasil perkalian bobot dan nilai normalisasi dijumlahkan untuk semua kriteria, kemudian dibulatkan hingga **4 digit desimal** menggunakan fungsi `round()`.

### e. Method `rankAlternatives()` — Perankingan

Method ini mengurutkan seluruh alternatif berdasarkan nilai preferensi dari yang **tertinggi ke terendah** (*descending*) menggunakan method `sortByDesc()` milik Laravel Collection. Kemudian setiap alternatif diberi **nomor ranking** secara berurutan mulai dari 1. Alternatif dengan nilai preferensi tertinggi memperoleh ranking 1 (terbaik).

### f. Method `getCalculationDetails()` — Transparansi Perhitungan

Method publik kedua ini menyediakan transparansi penuh atas proses perhitungan SAW. Method ini mengembalikan seluruh detail langkah perhitungan dalam bentuk array yang berisi:

- **Daftar kriteria** beserta nama, tipe, dan bobotnya
- **Matriks keputusan** — nilai mentah setiap alternatif pada setiap kriteria
- **Matriks normalisasi** — hasil normalisasi setiap sel
- **Nilai preferensi (skor SAW)** — hasil akhir perhitungan untuk setiap alternatif
- **Bobot kriteria** — ringkasan bobot dalam format kode-bobot

Data ini ditampilkan pada halaman hasil perhitungan SAW (view `saw/students/index.blade.php` dan `saw/teachers/index.blade.php`) sehingga pengguna (terutama kepala sekolah) dapat memverifikasi kebenaran perhitungan secara manual jika diperlukan.

> **Gambar 4.39** — *Screenshot* kode `SAWService.php` method `getCalculationDetails()`, menunjukkan data yang dikembalikan berupa matriks keputusan, matriks normalisasi, skor SAW, dan bobot kriteria.

### g. Pemanggilan SAW melalui Controller

Perhitungan SAW dipanggil melalui `SAWController` yang menyediakan dua endpoint utama:

1. **`calculateStudents()`** — mengambil data siswa beserta skor masing-masing kriteria (rata-rata nilai, persentase kehadiran, rata-rata sikap, rata-rata keterampilan), memanggil `SAWService->calculate()` dengan tipe `'student'`, lalu menyimpan hasil ranking ke tabel `student_assessments`.
2. **`calculateTeachers()`** — mengambil data guru beserta skor masing-masing kriteria (persentase kehadiran, kualitas mengajar, rata-rata nilai siswa, skor kedisiplinan), memanggil `SAWService->calculate()` dengan tipe `'teacher'`, lalu menyimpan hasil ranking ke tabel `teacher_assessments`.

Kedua method ini dapat difilter berdasarkan semester, tahun ajaran, dan periode (bulanan), dengan method helper `getSemesterStartDate()`, `getSemesterEndDate()`, `getPeriodStartDate()`, dan `getPeriodEndDate()` yang menghitung rentang tanggal secara otomatis.

> **Gambar 4.40** — *Screenshot* kode `SAWController.php` method `calculateStudents()`, menunjukkan pengambilan data siswa, pemanggilan `SAWService->calculate()`, dan penyimpanan hasil ke tabel `student_assessments`.

---

## 4.1.4.6 Implementasi Routing dan Otorisasi

Seluruh endpoint sistem didefinisikan pada file `routes/web.php` dengan pengelompokan berdasarkan middleware untuk memastikan setiap halaman hanya dapat diakses oleh pengguna yang berwenang. Struktur routing diorganisasikan sebagai berikut:

1. **Route Publik** — halaman login (`/login`) yang dapat diakses tanpa autentikasi.

2. **Route Terautentikasi** — seluruh route di dalam grup middleware `auth`, mencakup:
   - **Hanya Admin** (`CheckRole:Admin`): manajemen data master (guru, siswa, kelas, mata pelajaran, tahun ajaran, teacher-subject, kriteria, user), laporan & export, serta pengaturan sistem.
   - **Admin dan Guru** (`CheckRole:Admin,Guru`): manajemen nilai (input, edit, update, hapus), dan absensi kelas.
   - **Admin dan Kepala Sekolah** (`CheckRole:Admin,Kepala Sekolah`): perhitungan SAW siswa dan guru, serta rapor siswa.
   - **Semua role terautentikasi**: profil, notifikasi, halaman absensi QR, dan dashboard.

3. **Route Kiosk** — dibagi menjadi route publik (halaman kiosk, API generate QR, API status kehadiran, API ringkasan harian) dan route terautentikasi (proses scan QR) sehingga perangkat kiosk dapat menampilkan QR tanpa login, namun proses scan memerlukan autentikasi guru.

> **Gambar 4.41** — *Screenshot* kode `routes/web.php`, menunjukkan pengelompokan route berdasarkan middleware `CheckRole` dengan parameter role yang berbeda-beda (admin only, admin+guru, admin+kepala sekolah).

---

## 4.1.4.7 Konfigurasi Sistem

Selain pengkodean fitur, peneliti juga mengkonfigurasi beberapa parameter penting yang dibutuhkan untuk operasional sistem:

1. **Konfigurasi Environment (`.env`)**: koneksi database MySQL (host, port, nama database, username, password), application key untuk enkripsi AES-256-CBC, timezone (`Asia/Jakarta`), dan locale (`id`).
2. **Konfigurasi Absensi**: koordinat GPS SMPN 4 Purwakarta (-6.5465236, 107.4414175) sebagai titik pusat validasi geolocation, radius toleransi 100 meter, batas waktu check-in (07:30), dan masa berlaku QR Code (600 detik melalui admin / 60 detik melalui kiosk).
3. **Konfigurasi Profil Sekolah**: nama sekolah (*SMPN 4 Purwakarta*), NPSN (20219024), alamat, telepon, email, website, nama dan NIP kepala sekolah — seluruhnya disimpan pada tabel `settings` dan dapat diubah melalui halaman pengaturan.
4. **Konfigurasi Penilaian SAW**: 8 kriteria dengan bobot default disimpan pada tabel `criteria` dan dapat disesuaikan melalui halaman manajemen kriteria oleh admin.
5. **Konfigurasi Build Frontend**: file `vite.config.js` menentukan entry point CSS dan JS (`resources/css/app.css`, `resources/js/app.js`) dengan plugin Tailwind CSS dan auto-refresh.

---

## Daftar Gambar pada Bagian 4.1.4

Tabel berikut merangkum seluruh gambar (*screenshot* kode) yang perlu disertakan beserta keterangan sumber kode yang harus di-*capture*:

| Gambar | Keterangan | File yang Di-*screenshot* | Bagian Kode |
|--------|-----------|--------------------------|-------------|
| 4.17 | Dependensi project di `composer.json` | `composer.json` | Bagian `"require"` (baris yang memuat versi Laravel, PHP, dan 3 library) |
| 4.18 | Pemanggilan Vite dan Alpine.js pada layout modern | `resources/views/layouts/modern.blade.php` | Bagian `<head>` — baris `@vite(...)` dan `<script ... alpinejs ...>` |
| 4.19 | Struktur direktori utama project | Panel Explorer VS Code | Tampilan folder `app/`, `database/`, `resources/`, `routes/` |
| 4.20 | Daftar file migrasi | `database/migrations/` | Tampilan 18 file migrasi di panel Explorer |
| 4.21 | Migrasi tabel attendances | `database/migrations/2024_01_01_000007_create_attendances_table.php` | Seluruh method `up()` |
| 4.22 | Migrasi tabel grades | `database/migrations/2024_01_01_000009_create_grades_table.php` | Seluruh method `up()` |
| 4.23 | Model Attendance dengan relasi polymorphic | `app/Models/Attendance.php` | Method `attendable()`, `isOnTime()`, `isWithinRadius()` |
| 4.24 | Orkestrator seeder | `database/seeders/DatabaseSeeder.php` | Method `run()` dengan `$this->call([...])` |
| 4.25 | Autentikasi login dan redirect berdasarkan role | `app/Http/Controllers/AuthController.php` | Method `login()` dan `dashboard()` |
| 4.26 | Middleware CheckRole | `app/Http/Middleware/CheckRole.php` | Method `handle()` |
| 4.27 | Generate QR Code terenkripsi (Admin) | `app/Http/Controllers/AttendanceController.php` | Method `getTeacherQR()` |
| 4.28 | Generate QR Code melalui Kiosk (60 detik) | `app/Http/Controllers/KioskController.php` | Method `generateQR()` |
| 4.29 | Proses scan dan validasi QR Code | `app/Http/Controllers/AttendanceController.php` | Method `scanQR()` |
| 4.30 | Formula Haversine dan validasi jarak | `app/Http/Controllers/AttendanceController.php` | Method `calculateDistance()` dan bagian validasi koordinat di `checkIn()` |
| 4.31 | Penghitungan nilai akhir siswa | `app/Http/Controllers/GradeController.php` | Method `storeMultiple()` — bagian formula `(daily_test*0.3 + midterm_exam*0.3 + final_exam*0.4)` |
| 4.32 | Query statistik dashboard admin | `app/Http/Controllers/DashboardController.php` | Method `admin()` |
| 4.33 | Class export Excel (contoh: Attendance) | `app/Exports/AttendanceExport.php` | Method `headings()`, `map()`, dan `styles()` |
| 4.34 | Logika export laporan (Excel atau PDF) | `app/Http/Controllers/ReportController.php` | Method `exportAttendance()` |
| 4.35 | Pengelompokan setting sistem | `app/Http/Controllers/SettingController.php` | Method `index()` |
| 4.36 | Orkestrator perhitungan SAW | `app/Services/SAWService.php` | Method `calculate()` |
| 4.37 | Penyusunan matriks keputusan | `app/Services/SAWService.php` | Method `buildDecisionMatrix()` |
| 4.38 | Normalisasi matriks (benefit dan cost) | `app/Services/SAWService.php` | Method `normalizeMatrix()` |
| 4.39 | Detail perhitungan untuk transparansi | `app/Services/SAWService.php` | Method `getCalculationDetails()` |
| 4.40 | Perhitungan SAW siswa melalui controller | `app/Http/Controllers/SAWController.php` | Method `calculateStudents()` |
| 4.41 | Pengelompokan route berdasarkan role | `routes/web.php` | Bagian middleware `CheckRole:Admin`, `CheckRole:Admin,Guru`, `CheckRole:Admin,Kepala Sekolah` |
