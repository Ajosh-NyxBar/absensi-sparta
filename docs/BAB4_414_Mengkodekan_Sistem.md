# 4.1.4 Mengkodekan Sistem

Setelah rancangan prototype dinyatakan layak oleh seluruh evaluator pada tahap evaluasi, peneliti melanjutkan ke tahap pengkodean sistem. Pada tahap ini, seluruh rancangan yang telah dibuat pada tahap sebelumnya — meliputi diagram use case, activity diagram, class diagram, struktur basis data, desain antarmuka, dan algoritma SAW — diterjemahkan menjadi kode program yang fungsional. Proses pengkodean dilakukan secara bertahap dimulai dari penyiapan lingkungan pengembangan, implementasi basis data, implementasi setiap modul fitur, hingga implementasi algoritma SAW.

## 4.1.4.1 Lingkungan Pengembangan

Langkah pertama dalam tahap pengkodean adalah menyiapkan lingkungan pengembangan (*development environment*) yang terdiri dari framework, bahasa pemrograman, library pendukung, serta tools pengembangan. Pemilihan teknologi dilakukan berdasarkan pertimbangan kebutuhan sistem, kompatibilitas, dukungan komunitas, serta kemudahan pengembangan.

### a. Framework dan Bahasa Pemrograman

Peneliti memilih **Laravel versi 12** sebagai framework utama karena Laravel menerapkan arsitektur MVC (*Model-View-Controller*) yang memisahkan logika bisnis, tampilan, dan akses data secara terstruktur. Laravel juga menyediakan fitur bawaan yang mendukung kebutuhan sistem, antara lain: Eloquent ORM untuk interaksi dengan database, Blade templating engine untuk rendering halaman, middleware untuk otorisasi, serta migration dan seeder untuk pengelolaan skema database. Bahasa pemrograman yang digunakan adalah **PHP versi 8.2** atau lebih tinggi, sesuai dengan persyaratan minimum Laravel 12.

Untuk bagian frontend, peneliti menggunakan **Tailwind CSS versi 4** sebagai framework CSS utility-first yang memungkinkan penulisan styling secara langsung pada elemen HTML tanpa perlu membuat file CSS terpisah untuk setiap komponen. Proses build dan bundling aset frontend menggunakan **Vite versi 5.4** yang terintegrasi dengan Laravel melalui plugin `laravel-vite-plugin`.

### b. Library Pendukung

Selain framework utama, peneliti menggunakan beberapa library pihak ketiga untuk mendukung fitur-fitur khusus sistem. Tabel 4.49 berikut menyajikan daftar library yang digunakan beserta fungsinya:

**Tabel 4.49 Daftar Library Pendukung**

| No | Library | Versi | Fungsi |
|----|---------|-------|--------|
| 1 | `simplesoftwareio/simple-qrcode` | 4.2 | Membuat (*generate*) QR Code terenkripsi untuk fitur absensi guru. Library ini menghasilkan gambar QR Code dalam format SVG atau PNG yang dapat dipindai oleh kamera smartphone |
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
| 3 | Framework CSS | Tailwind CSS | 4.0 |
| 4 | Build Tool Frontend | Vite | 5.4 |
| 5 | Database | MySQL | — |
| 6 | Library QR Code | simplesoftwareio/simple-qrcode | 4.2 |
| 7 | Library Export Excel | maatwebsite/excel | 3.1 |
| 8 | Library Export PDF | barryvdh/laravel-dompdf | 3.1 |
| 9 | Framework Testing | PHPUnit | 11.5 |
| 10 | Package Manager PHP | Composer | — |
| 11 | Package Manager JS | NPM | — |
| 12 | Code Editor | Visual Studio Code | — |

## 4.1.4.2 Struktur Direktori dan Arsitektur Kode

Peneliti mengorganisasikan kode program mengikuti konvensi standar arsitektur MVC bawaan Laravel. Selain MVC, peneliti juga menerapkan pola *Service Layer* untuk memisahkan logika bisnis yang kompleks (seperti perhitungan SAW) dari controller, sehingga kode lebih modular dan mudah dipelihara.

Tabel 4.50a berikut menunjukkan struktur direktori utama beserta jumlah file dan fungsinya:

**Tabel 4.50a Struktur Direktori Utama Project**

| No | Direktori / File | Jumlah File | Keterangan |
|----|------------------|-------------|------------|
| 1 | `app/Http/Controllers/` | 20 controller | Menangani logika request-response untuk setiap modul: `AuthController`, `AttendanceController`, `KioskController`, `GradeController`, `SAWController`, `ReportController`, `DashboardController`, `TeacherController`, `StudentController`, `CriteriaController`, `UserController`, `ProfileController`, `SettingController`, `AcademicYearController`, `ClassRoomController`, `SubjectController`, `TeacherSubjectController`, `NotificationController`, `LanguageController` |
| 2 | `app/Models/` | 15 model | Model Eloquent untuk setiap entitas: `User`, `Role`, `Teacher`, `Student`, `ClassRoom`, `Subject`, `TeacherSubject`, `Attendance`, `Grade`, `Criteria`, `StudentAssessment`, `TeacherAssessment`, `AcademicYear`, `Setting`, `Notification` |
| 3 | `app/Services/` | 1 service | `SAWService.php` — class terpisah yang menangani seluruh perhitungan metode SAW |
| 4 | `app/Exports/` | 4 class export | `AttendanceExport`, `GradesExport`, `StudentsExport`, `TeachersExport` — menangani format dan isi file export Excel |
| 5 | `app/Helpers/` | 1 helper | `SettingHelper.php` — menyediakan fungsi global untuk mengakses konfigurasi sistem dari tabel `settings` |
| 6 | `database/migrations/` | 18 migrasi | File migrasi untuk pembuatan seluruh tabel database |
| 7 | `database/seeders/` | 15 seeder | File seeder untuk pengisian data awal sistem |
| 8 | `resources/views/` | — | Template Blade untuk seluruh halaman antarmuka, diorganisasikan berdasarkan modul (dashboard, attendance, grades, reports, dll.) |
| 9 | `routes/web.php` | 1 file | Definisi seluruh route aplikasi dengan pengelompokan berdasarkan middleware autentikasi dan otorisasi role |

## 4.1.4.3 Implementasi Basis Data

Peneliti mengimplementasikan rancangan basis data yang telah dibuat pada tahap perancangan prototype menggunakan fitur **migrasi** Laravel. Migrasi adalah file PHP yang mendefinisikan struktur tabel (kolom, tipe data, constraint, dan indeks) secara programatik, sehingga pembuatan dan modifikasi skema database dapat dilakukan secara terkontrol dan terdokumentasi.

### a. Pembuatan Tabel Database

Sebanyak 18 file migrasi dibuat untuk menghasilkan seluruh tabel yang dibutuhkan sistem. Setiap file migrasi berisi definisi kolom lengkap dengan tipe data, constraint `NOT NULL`, nilai default, serta foreign key. Peneliti menjalankan perintah `php artisan migrate` untuk mengeksekusi seluruh migrasi sekaligus dan membuat tabel-tabel secara otomatis di database MySQL.

Sebagai contoh, tabel `attendances` diimplementasikan dengan struktur kolom berikut:
- Kolom `attendable_type` dan `attendable_id` untuk relasi polymorphic (agar satu tabel dapat menyimpan absensi guru maupun siswa)
- Kolom `check_in` dan `check_out` bertipe `TIME` untuk mencatat waktu masuk dan pulang
- Kolom `status` bertipe `ENUM` dengan 5 nilai: `present` (hadir), `late` (terlambat), `absent` (tidak hadir), `sick` (sakit), dan `permission` (izin)
- Kolom `latitude_in`, `longitude_in`, `latitude_out`, `longitude_out` untuk menyimpan koordinat GPS saat check-in dan check-out
- Kolom `qr_code` untuk menyimpan data QR Code yang digunakan
- Index composite pada kolom `[attendable_type, attendable_id]` dan index pada kolom `date` untuk mempercepat query pencarian

Contoh lain, tabel `grades` diimplementasikan dengan:
- Foreign key ke tabel `students`, `subjects`, dan `teachers` dengan constraint `ON DELETE CASCADE`
- Kolom nilai bertipe `DECIMAL(5,2)` untuk presisi: `daily_test` (ulangan harian), `midterm_exam` (UTS), `final_exam` (UAS), `final_grade` (nilai akhir), `behavior_score` (nilai sikap), `skill_score` (nilai keterampilan)
- Unique constraint composite pada kolom `[student_id, subject_id, semester, academic_year]` untuk mencegah duplikasi data nilai

### b. Relasi Antar Tabel

Relasi antar tabel diimplementasikan melalui dua mekanisme:

1. **Foreign Key Constraint** pada level database — didefinisikan dalam file migrasi menggunakan method `foreignId()->constrained()->onDelete('cascade')`. Mekanisme ini menjamin integritas referensial data, artinya tidak mungkin ada data anak (*child record*) yang mereferensikan data induk (*parent record*) yang tidak ada.

2. **Eloquent Relationship** pada level model Laravel — didefinisikan sebagai method pada class model. Peneliti mengimplementasikan beberapa jenis relasi:
   - **One-to-Many**: contohnya `ClassRoom` memiliki banyak `Student`, diimplementasikan dengan `hasMany()` dan `belongsTo()`
   - **Many-to-Many**: contohnya relasi guru–mata pelajaran–kelas melalui tabel pivot `teacher_subjects`, diimplementasikan dengan `belongsToMany()`
   - **Polymorphic**: contohnya `Attendance` dapat dimiliki oleh `Teacher` maupun `Student`, diimplementasikan dengan `morphTo()` pada model `Attendance` dan `morphMany()` pada model `Teacher` dan `Student`
   - **One-to-One**: contohnya `Teacher` memiliki satu `User`, diimplementasikan dengan `belongsTo()`

### c. Seeder Data Awal

Peneliti membuat 15 file seeder untuk mengisi data awal yang diperlukan agar sistem dapat beroperasi. Seeder dieksekusi melalui perintah `php artisan db:seed`. Data awal yang di-seed meliputi:

1. **`RoleSeeder`** — membuat 4 role pengguna: Admin, Guru, Kepala Sekolah, dan Kiosk.
2. **`UserSeeder`** — membuat akun admin default untuk login pertama kali.
3. **`CriteriaSeeder`** — membuat 8 kriteria penilaian SAW:
   - 4 kriteria siswa: Nilai Akademik/C1 (bobot 0,35), Kehadiran/C2 (bobot 0,25), Sikap/C3 (bobot 0,20), Keterampilan/C4 (bobot 0,20) — seluruhnya berjenis *benefit*
   - 4 kriteria guru: Kehadiran/K1 (bobot 0,30), Kualitas Mengajar/K2 (bobot 0,25), Prestasi Siswa/K3 (bobot 0,25), Kedisiplinan/K4 (bobot 0,20) — seluruhnya berjenis *benefit*
4. **`SettingSeeder`** — membuat 23 konfigurasi sistem yang dikelompokkan ke dalam 5 grup:
   - *School* (9 item): nama sekolah, NPSN, alamat, telepon, email, website, logo, nama kepala sekolah, NIP kepala sekolah
   - *General* (5 item): nama aplikasi, timezone (`Asia/Jakarta`), bahasa (`id`), format tanggal, format waktu
   - *Appearance* (3 item): warna tema, warna sidebar, jumlah item per halaman
   - *Notification* (3 item): notifikasi email, notifikasi SMS, email penerima notifikasi
   - *System* (3 item): mode maintenance, auto backup, jadwal backup, ukuran maksimal upload
5. **`ClassSeeder`, `SubjectSeeder`, `TeacherSeeder`, `StudentSeeder`** — data master kelas, mata pelajaran, guru, dan siswa SMPN 4 Purwakarta. Untuk data siswa, dibuat seeder terpisah per tingkat: `StudentKelas7Seeder`, `StudentKelas8Seeder`, dan `StudentKelas9Seeder`.
6. **`AcademicYearSeeder`** — data tahun ajaran aktif.

## 4.1.4.4 Implementasi Fitur Sistem

Peneliti mengimplementasikan seluruh fitur sistem berdasarkan rancangan use case dan activity diagram yang telah dievaluasi dan disetujui pada tahap evaluasi prototype.

### a. Modul Autentikasi (*Login dan Register*)

Modul autentikasi diimplementasikan pada `AuthController` dengan memanfaatkan fitur *session-based authentication* bawaan Laravel. Proses login bekerja sebagai berikut:

1. Pengguna memasukkan email dan password pada halaman login.
2. Sistem memverifikasi kredensial menggunakan method `Auth::attempt()`.
3. Jika valid, sistem mengidentifikasi role pengguna (Admin, Guru, atau Kepala Sekolah) dari relasi `user->role`.
4. Sistem melakukan redirect ke dashboard yang sesuai berdasarkan role.
5. Jika tidak valid, sistem mengembalikan pesan error "*Email atau password salah*".

Untuk otorisasi, peneliti membuat middleware yang memfilter akses berdasarkan role. Middleware ini ditempatkan pada kelompok route di `routes/web.php` sehingga setiap endpoint hanya dapat diakses oleh role yang berwenang. Sebagai contoh, route untuk manajemen data guru dan siswa hanya dapat diakses oleh Admin, sedangkan route untuk dashboard monitoring hanya dapat diakses oleh Kepala Sekolah.

### b. Modul Absensi Guru

Modul absensi merupakan fitur inti pertama sistem yang diimplementasikan pada `AttendanceController` (543 baris, 12 method) dan `KioskController` (untuk mode kiosk). Berikut penjelasan implementasi setiap sub-fitur:

**1) Generate QR Code**

Method `showQRCode()` dan `getTeacherQR()` menangani pembuatan QR Code. Data yang dienkripsi ke dalam QR Code meliputi: `teacher_id`, `date` (tanggal hari ini), dan `timestamp` (waktu pembuatan). Data ini dienkripsi menggunakan fungsi `encrypt()` bawaan Laravel (berbasis AES-256-CBC) sehingga tidak dapat dibaca atau dipalsukan. QR Code dihasilkan dalam format SVG menggunakan library `simplesoftwareio/simple-qrcode`.

**2) Scan QR Code dan Validasi**

Method `scanQR()` menangani proses ketika guru memindai QR Code. Alur proses yang diimplementasikan:

1. Sistem menerima data QR Code dari hasil scan kamera smartphone.
2. Data didekripsi menggunakan `decrypt()`. Jika dekripsi gagal (QR rusak/palsu), sistem mengembalikan error "*QR Code tidak valid atau rusak*".
3. Sistem memvalidasi kelengkapan data: harus mengandung `teacher_id`, `date`, dan `timestamp`.
4. Sistem memeriksa masa berlaku QR Code dengan menghitung selisih waktu saat ini (`time()`) dengan `timestamp` QR. Jika selisih melebihi **600 detik (10 menit)**, QR Code dinyatakan kadaluarsa.
5. Sistem memeriksa apakah tanggal pada QR Code sesuai dengan tanggal hari ini.
6. Sistem memeriksa data absensi guru pada hari tersebut:
   - Jika **belum ada data check-in**: sistem mencatat sebagai check-in. Status ditentukan otomatis — jika waktu scan **sebelum pukul 07:30** maka status = `present` (tepat waktu), jika **setelah 07:30** maka status = `late` (terlambat).
   - Jika **sudah check-in tapi belum check-out**: sistem mencatat sebagai check-out.
   - Jika **sudah check-in dan check-out**: sistem mengembalikan pesan "*Anda sudah melakukan check-in dan check-out hari ini*".

**3) Validasi Geolocation**

Method `checkIn()` dan `checkOut()` mengimplementasikan validasi lokasi. Saat guru melakukan absensi, sistem mengambil koordinat GPS dari browser perangkat guru, kemudian menghitung jarak antara posisi guru dengan titik koordinat sekolah menggunakan **formula Haversine**. Formula Haversine diimplementasikan pada method `calculateDistance()` sebagai berikut:

- Radius bumi ditetapkan sebesar 6.371.000 meter
- Koordinat latitude dan longitude dikonversi dari derajat ke radian
- Jarak dihitung dengan formula: `2 × arcsin(√(sin²(Δlat/2) + cos(lat1) × cos(lat2) × sin²(Δlon/2))) × radius_bumi`

Jika jarak yang dihitung melebihi **radius toleransi yang dikonfigurasi di tabel settings**, absensi ditolak dan sistem menampilkan pesan bahwa guru berada di luar area sekolah. Koordinat GPS guru saat check-in dan check-out juga disimpan ke kolom `latitude_in`, `longitude_in`, `latitude_out`, `longitude_out` pada tabel `attendances` sebagai bukti lokasi.

**4) Absensi Siswa per Kelas**

Method `classAttendance()` dan `saveClassAttendance()` menangani absensi siswa yang dilakukan oleh guru kelas atau admin. Guru memilih kelas, kemudian form menampilkan daftar seluruh siswa dalam kelas tersebut. Guru menandai status kehadiran setiap siswa (hadir, sakit, izin, atau tidak hadir), kemudian data disimpan secara batch ke tabel `attendances` menggunakan relasi polymorphic.

### c. Modul Penilaian Siswa

Modul penilaian diimplementasikan pada `GradeController` (9.097 bytes) dengan fitur-fitur berikut:

**1) Input Nilai per Mata Pelajaran**

Guru memilih kelas dan mata pelajaran, kemudian sistem menampilkan form tabel interaktif berisi seluruh siswa dalam kelas tersebut. Untuk setiap siswa, guru dapat memasukkan:
- **Nilai Tugas Harian** (`daily_test`)
- **Nilai UTS** (`midterm_exam`)
- **Nilai UAS** (`final_exam`)
- **Nilai Sikap** (`behavior_score`)
- **Nilai Keterampilan** (`skill_score`)

Sistem menghitung **nilai akhir** (`final_grade`) secara otomatis dengan formula pembobotan: `Nilai Akhir = (Tugas Harian × 0,30) + (UTS × 0,30) + (UAS × 0,40)`.

**2) Validasi Input Nilai**

Sebelum data disimpan, sistem melakukan validasi terhadap setiap nilai yang dimasukkan:
- Nilai harus berupa angka (*numeric*)
- Nilai harus berada dalam rentang **0 sampai 100**
- Jika validasi gagal, sistem menampilkan pesan error pada kolom yang bersangkutan

**3) Mekanisme Update Nilai**

Ketika guru membuka form input nilai untuk kelas dan mata pelajaran yang sudah memiliki data sebelumnya, sistem secara otomatis mengambil data nilai yang tersimpan (*pre-filled*) dan menampilkannya pada form. Mekanisme ini diimplementasikan dengan query ke tabel `grades` berdasarkan `student_id`, `subject_id`, `semester`, dan `academic_year`, kemudian hasilnya di-pass ke view sebagai `existingGrades`. Unique constraint pada database juga memastikan tidak terjadi duplikasi data — satu siswa hanya memiliki satu record nilai untuk satu mata pelajaran pada semester dan tahun ajaran yang sama.

### d. Modul Dashboard

Modul dashboard diimplementasikan pada `DashboardController` dan menyajikan ringkasan data yang berbeda berdasarkan role pengguna yang login:

- **Dashboard Admin**: menampilkan jumlah total guru, siswa, kelas, dan mata pelajaran, serta grafik statistik kehadiran
- **Dashboard Guru**: menampilkan informasi kehadiran pribadi dan rekap nilai kelas yang diampu
- **Dashboard Kepala Sekolah**: menampilkan monitoring real-time kehadiran guru hari ini, persentase kehadiran bulanan, statistik penilaian siswa, serta visualisasi grafik tren kehadiran

### e. Modul Laporan dan Export

Modul laporan diimplementasikan pada `ReportController` dengan 5 method (index, exportAttendance, exportGrades, exportStudents, exportTeachers) dan didukung oleh 4 class export di direktori `app/Exports/`:

**1) Jenis Laporan yang Tersedia**

| No | Jenis Laporan | Class Export | Filter yang Tersedia |
|----|--------------|-------------|---------------------|
| 1 | Laporan Presensi | `AttendanceExport` | Tanggal mulai, tanggal akhir, tipe (guru/siswa) |
| 2 | Laporan Nilai Siswa | `GradesExport` | Kelas, semester, tahun ajaran |
| 3 | Laporan Data Siswa | `StudentsExport` | Kelas, tingkat (7/8/9), status (aktif/tidak aktif) |
| 4 | Laporan Data Guru | `TeachersExport` | — (seluruh guru) |

**2) Format Export**

Setiap laporan dapat diekspor dalam dua format:
- **Excel (.xlsx)**: menggunakan library `maatwebsite/excel`. Class export mengimplementasikan interface yang mendefinisikan kolom header, mapping data, dan styling tabel.
- **PDF**: menggunakan library `barryvdh/laravel-dompdf`. File PDF dihasilkan dari template Blade khusus yang disimpan di direktori `resources/views/reports/pdf/` dengan layout yang disesuaikan untuk format cetak.

Nama file export di-generate secara otomatis berdasarkan jenis laporan dan filter yang dipilih. Contoh: `laporan_presensi_2025-09-01_to_2025-09-30.xlsx`.

### f. Modul Pengaturan Sistem

Modul pengaturan diimplementasikan pada `SettingController` dan memungkinkan admin untuk mengkonfigurasi parameter sistem melalui antarmuka web tanpa perlu mengubah file konfigurasi secara manual. Pengaturan disimpan pada tabel `settings` dengan format key-value dan dikelompokkan ke dalam 5 grup (school, general, appearance, notification, system). Akses ke nilai pengaturan dari seluruh bagian sistem dilakukan melalui helper function `setting()` yang didefinisikan pada `SettingHelper.php`.

## 4.1.4.5 Implementasi Algoritma SAW

Peneliti mengimplementasikan algoritma Simple Additive Weighting (SAW) dalam class terpisah bernama `SAWService` yang ditempatkan di direktori `app/Services/`. Pemisahan ini dilakukan untuk menjaga prinsip *Single Responsibility Principle* — controller hanya menangani request/response, sedangkan logika perhitungan SAW sepenuhnya ditangani oleh service.

Class `SAWService` memiliki 2 method publik dan 4 method protected yang merepresentasikan setiap tahapan SAW:

### a. Method `calculate()` — Orkestrator Perhitungan

Method publik utama ini menerima dua parameter: koleksi data (siswa atau guru) dan tipe perhitungan (`'student'` atau `'teacher'`). Method ini mengorkestrasi seluruh tahapan perhitungan SAW secara berurutan:

1. Mengambil kriteria dari database berdasarkan tipe
2. Memanggil `buildDecisionMatrix()` — membangun matriks keputusan
3. Memanggil `normalizeMatrix()` — menormalisasi matriks
4. Memanggil `calculateSAWScores()` — menghitung nilai preferensi
5. Memanggil `rankAlternatives()` — melakukan perankingan

### b. Method `buildDecisionMatrix()` — Penyusunan Matriks Keputusan

Method ini menyusun matriks keputusan dari data input. Setiap baris matriks merepresentasikan satu alternatif (siswa atau guru), dan setiap kolom merepresentasikan satu kriteria:

- **Penilaian Siswa**: C1 = nilai akademik, C2 = kehadiran, C3 = sikap, C4 = keterampilan
- **Penilaian Guru**: K1 = kehadiran, K2 = kualitas mengajar, K3 = prestasi siswa, K4 = kedisiplinan

### c. Method `normalizeMatrix()` — Normalisasi Matriks

Method ini melakukan normalisasi nilai pada setiap sel matriks agar seluruh kriteria berada dalam skala yang sama (0–1). Normalisasi dilakukan berdasarkan jenis kriteria:

- **Kriteria Benefit** (semakin tinggi semakin baik): `r_ij = x_ij / max(x_j)`
  - Nilai setiap alternatif dibagi dengan nilai maksimum pada kriteria tersebut
- **Kriteria Cost** (semakin rendah semakin baik): `r_ij = min(x_j) / x_ij`
  - Nilai minimum pada kriteria tersebut dibagi dengan nilai setiap alternatif

Method ini juga menangani kasus *edge case*: jika nilai maksimum (benefit) atau minimum (cost) adalah nol, maka normalisasi tidak dilakukan untuk menghindari error *division by zero*.

Dalam implementasi sistem ini, seluruh 8 kriteria (C1–C4 dan K1–K4) ditetapkan berjenis *benefit*, artinya semakin tinggi nilainya maka semakin baik.

### d. Method `calculateSAWScores()` — Perhitungan Nilai Preferensi

Method ini menghitung nilai preferensi (V_i) untuk setiap alternatif dengan rumus:

**V_i = Σ (w_j × r_ij)**

Di mana `w_j` adalah bobot kriteria ke-j dan `r_ij` adalah nilai normalisasi alternatif ke-i pada kriteria ke-j. Hasil perkalian bobot dan nilai normalisasi dijumlahkan untuk semua kriteria, kemudian dibulatkan hingga **4 digit desimal** menggunakan fungsi `round()` untuk menjaga presisi tanpa mengorbankan keterbacaan.

### e. Method `rankAlternatives()` — Perankingan

Method ini mengurutkan seluruh alternatif berdasarkan nilai preferensi dari yang **tertinggi ke terendah** (*descending*) menggunakan method `sortByDesc()` milik Laravel Collection. Kemudian setiap alternatif diberi **nomor ranking** secara berurutan mulai dari 1. Alternatif dengan nilai preferensi tertinggi memperoleh ranking 1 (terbaik).

### f. Method `getCalculationDetails()` — Transparansi Perhitungan

Method publik kedua ini diimplementasikan berdasarkan masukan kepala sekolah pada tahap evaluasi prototype yang menginginkan transparansi dalam proses penilaian. Method ini mengembalikan seluruh detail langkah perhitungan dalam bentuk array yang berisi:

- **Daftar kriteria** beserta nama, tipe, dan bobotnya
- **Matriks keputusan** — nilai mentah setiap alternatif pada setiap kriteria
- **Matriks normalisasi** — hasil normalisasi setiap sel
- **Nilai preferensi (skor SAW)** — hasil akhir perhitungan untuk setiap alternatif
- **Bobot kriteria** — ringkasan bobot dalam format kode-bobot

Data ini ditampilkan pada halaman hasil perhitungan SAW sehingga pengguna (terutama kepala sekolah) dapat memverifikasi kebenaran perhitungan secara manual jika diperlukan.

### g. Pemanggilan SAW melalui Controller

Perhitungan SAW dipanggil melalui `SAWController` yang menyediakan dua endpoint utama:

1. **`calculateStudents()`** — mengambil data siswa beserta skor masing-masing kriteria, memanggil `SAWService->calculate()` dengan tipe `'student'`, lalu menyimpan hasil ranking ke tabel `student_assessments`.
2. **`calculateTeachers()`** — mengambil data guru beserta skor masing-masing kriteria, memanggil `SAWService->calculate()` dengan tipe `'teacher'`, lalu menyimpan hasil ranking ke tabel `teacher_assessments`.

## 4.1.4.6 Konfigurasi Sistem

Selain pengkodean fitur, peneliti juga mengkonfigurasi beberapa parameter penting yang dibutuhkan untuk operasional sistem:

1. **Konfigurasi environment (`.env`)**: koneksi database (host, port, nama database, username, password), application key untuk enkripsi, timezone (Asia/Jakarta), dan locale (id).
2. **Konfigurasi absensi**: koordinat GPS SMPN 4 Purwakarta sebagai titik pusat validasi geolocation, radius toleransi jarak dalam meter, batas waktu check-in (07:30), dan masa berlaku QR Code (600 detik / 10 menit).
3. **Konfigurasi profil sekolah**: nama sekolah, NPSN (20219024), alamat, telepon, email, website, nama dan NIP kepala sekolah — seluruhnya disimpan pada tabel `settings` dan dapat diubah melalui halaman pengaturan.
4. **Konfigurasi penilaian SAW**: kriteria dan bobot default disimpan pada tabel `criteria` dan dapat disesuaikan melalui halaman manajemen kriteria oleh admin.
