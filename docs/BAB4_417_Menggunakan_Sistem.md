# 4.1.7 Menggunakan Sistem

Setelah seluruh tahapan pengujian dan evaluasi selesai serta perbaikan akhir berdasarkan feedback UAT telah diterapkan, peneliti melanjutkan ke tahap terakhir dari metode *prototype* — yaitu tahap menggunakan sistem. Pada tahap ini, sistem yang telah dinyatakan layak oleh pengguna (*user accepted*) diterapkan di lingkungan operasional SMPN 4 Purwakarta.

## 4.1.7.1 Deployment Sistem

### a. Persiapan Lingkungan Server

Peneliti menyiapkan lingkungan server untuk menjalankan sistem secara operasional. Tabel berikut menyajikan spesifikasi server dan software yang diperlukan:

**Tabel 4.79 Spesifikasi Lingkungan Deployment**

| No | Komponen | Spesifikasi | Keterangan |
|----|----------|-------------|------------|
| 1 | Web Server | Apache / Nginx | Mengarahkan request ke direktori `public/` Laravel |
| 2 | PHP | ≥ 8.2 | Dengan ekstensi: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath, GD |
| 3 | Database | MySQL / MariaDB | Untuk penyimpanan seluruh data sistem |
| 4 | Composer | ≥ 2.x | Package manager untuk dependensi PHP |
| 5 | Node.js & NPM | ≥ 18.x | Untuk kompilasi aset frontend (Tailwind CSS, Vite) |
| 6 | HTTPS/SSL | Sertifikat SSL | Diperlukan untuk akses kamera dan GPS pada browser (fitur scan QR Code) |

Konfigurasi HTTPS bersifat **wajib** karena browser modern mensyaratkan koneksi aman (*secure context*) untuk mengizinkan akses ke API `navigator.mediaDevices` (kamera) dan `navigator.geolocation` (GPS) yang digunakan pada fitur scan QR Code dan validasi geolocation.

### b. Proses Instalasi dan Konfigurasi

Peneliti melaksanakan proses deployment dengan langkah-langkah berikut:

**Tabel 4.80 Langkah-langkah Deployment Sistem**

| No | Langkah | Perintah / Aksi | Keterangan |
|----|---------|-----------------|------------|
| 1 | Upload kode sumber | `git clone` atau transfer file ke server | Seluruh file proyek dipindahkan ke direktori server |
| 2 | Install dependensi PHP | `composer install --optimize-autoloader --no-dev` | Menginstal seluruh library PHP yang dibutuhkan dalam mode produksi |
| 3 | Install dependensi frontend | `npm install` | Menginstal dependensi JavaScript dan CSS |
| 4 | Kompilasi aset frontend | `npm run build` | Mengompilasi Tailwind CSS dan file JavaScript melalui Vite untuk produksi |
| 5 | Konfigurasi environment | Edit file `.env` | Mengisi parameter koneksi database, APP_KEY, APP_URL, dan konfigurasi lainnya |
| 6 | Generate application key | `php artisan key:generate` | Membuat encryption key unik yang digunakan untuk enkripsi data QR Code |
| 7 | Migrasi database | `php artisan migrate` | Membuat seluruh 18 tabel database sesuai file migrasi |
| 8 | Seeding data awal | `php artisan db:seed` | Mengisi data awal (roles, admin, kriteria SAW, konfigurasi) |
| 9 | Optimasi Laravel | `php artisan config:cache` dan `php artisan route:cache` | Meng-cache konfigurasi dan route untuk performa optimal |
| 10 | Konfigurasi web server | Pengaturan *virtual host* | Mengarahkan domain ke direktori `public/` dan mengaktifkan URL rewriting |

### c. Konfigurasi Parameter Operasional

Setelah instalasi dasar selesai, peneliti mengkonfigurasi parameter-parameter operasional yang spesifik untuk SMPN 4 Purwakarta melalui tabel `settings` di database:

**Tabel 4.81 Konfigurasi Parameter Operasional**

| No | Parameter | Nilai | Keterangan |
|----|-----------|-------|------------|
| 1 | Nama Sekolah | SMPN 4 Purwakarta | Ditampilkan pada header sistem dan laporan |
| 2 | Koordinat Sekolah (Latitude) | -6.5465236 | Titik pusat validasi geolocation absensi |
| 3 | Koordinat Sekolah (Longitude) | 107.4414175 | Titik pusat validasi geolocation absensi |
| 4 | Radius Absensi | 100 meter | Jarak maksimum guru dari titik sekolah saat check-in |
| 5 | Masa Berlaku QR Code | 600 detik (10 menit) | QR Code kadaluarsa setelah 10 menit |
| 6 | Batas Jam Check-in | 07:30 WIB | Check-in sebelum 07:30 = "Tepat Waktu", setelahnya = "Terlambat" |
| 7 | Tahun Ajaran Aktif | 2025/2026 | Dikonfigurasi melalui tabel `academic_years` |
| 8 | Timezone | Asia/Jakarta (WIB) | Zona waktu yang digunakan untuk pencatatan timestamp |

### d. Migrasi Data Awal

Setelah sistem terpasang dan terkonfigurasi, peneliti memasukkan data operasional yang diperlukan. Proses ini dilakukan melalui kombinasi antara seeder otomatis dan input manual oleh admin melalui antarmuka sistem.

**Tabel 4.82 Data yang Dimasukkan ke Sistem**

| No | Jenis Data | Jumlah | Sumber Data | Metode Input |
|----|-----------|--------|-------------|-------------|
| 1 | Data Role Pengguna | 4 role (Admin, Guru, Kepala Sekolah, Kiosk) | `RoleSeeder` | Seeder otomatis |
| 2 | Akun Admin Default | 1 akun | `UserSeeder` | Seeder otomatis |
| 3 | Kriteria SAW Siswa | 4 kriteria (C1–C4) dengan bobot | `CriteriaSeeder` | Seeder otomatis |
| 4 | Kriteria SAW Guru | 4 kriteria (K1–K4) dengan bobot | `CriteriaSeeder` | Seeder otomatis |
| 5 | Data Guru Aktif | Sesuai jumlah guru SMPN 4 | Data kepegawaian sekolah | Input via admin panel / `TeacherSeeder` |
| 6 | Data Siswa Kelas 7, 8, 9 | Sesuai jumlah siswa aktif | Data kesiswaan sekolah | Input via admin panel / `StudentSeeder` |
| 7 | Data Kelas | Sesuai jumlah rombongan belajar | Struktur akademik sekolah | Input via admin panel / `ClassSeeder` |
| 8 | Data Mata Pelajaran | Sesuai kurikulum | Kurikulum SMPN 4 | Input via admin panel / `SubjectSeeder` |
| 9 | Penugasan Guru–Mapel–Kelas | Sesuai jadwal mengajar | SK Pembagian Tugas | Input via admin panel |
| 10 | Konfigurasi Sistem | Parameter operasional | Kesepakatan dengan sekolah | `SettingSeeder` + konfigurasi admin panel |

Urutan eksekusi seeder diatur dalam `DatabaseSeeder.php` untuk memastikan dependensi data terpenuhi: `RoleSeeder` → `UserSeeder` → `TeacherSeeder` → `SubjectSeeder` → `ClassSeeder` → `StudentSeeder` → `CriteriaSeeder` → `AttendanceSeeder`.

---

## 4.1.7.2 Pelatihan Pengguna

Sebelum sistem digunakan secara resmi, peneliti melaksanakan pelatihan kepada seluruh calon pengguna di SMPN 4 Purwakarta agar seluruh pihak memahami cara mengoperasikan sistem sesuai perannya masing-masing.

### a. Peserta dan Materi Pelatihan

Materi pelatihan disusun secara terstruktur berdasarkan peran pengguna:

**Tabel 4.83 Materi Pelatihan per Role Pengguna**

| No | Role | Peserta | Materi Pelatihan |
|----|------|---------|------------------|
| 1 | Admin (Staf TU) | 1 orang | Pengelolaan data master (guru, siswa, kelas, mata pelajaran), generate QR Code harian, konfigurasi sistem, export laporan ke Excel/PDF |
| 2 | Guru | Seluruh guru aktif | Cara melakukan scan QR Code untuk check-in dan check-out, cara menginput nilai siswa per kelas, melihat rekap kehadiran pribadi, memahami tampilan form penilaian |
| 3 | Kepala Sekolah | 1 orang | Cara membaca dashboard monitoring kehadiran guru, cara menjalankan dan membaca hasil perhitungan ranking SAW, cara melihat detail perhitungan, export laporan |

### b. Metode Pelatihan

Pelatihan dilaksanakan dengan metode **demonstrasi langsung** (*hands-on*) dan **praktik mandiri**, dengan tahapan:

1. **Demonstrasi oleh peneliti**: Peneliti mendemonstrasikan seluruh fitur sistem di depan peserta, menjelaskan alur penggunaan mulai dari login hingga export laporan.
2. **Praktik mandiri**: Setiap peserta diberikan kesempatan untuk mencoba mengoperasikan sistem secara langsung menggunakan perangkat masing-masing.
3. **Tanya jawab**: Peserta dapat mengajukan pertanyaan atau melaporkan kendala yang ditemui selama praktik.

### c. Dokumentasi Panduan Pengguna

Peneliti menyusun **panduan pengguna** (*user manual*) dalam format digital yang berisi langkah-langkah penggunaan sistem untuk setiap role, dilengkapi dengan *screenshot* antarmuka dan penjelasan setiap fitur. Panduan ini diberikan kepada pihak sekolah agar dapat diakses kapan saja oleh seluruh pengguna, termasuk guru baru yang bergabung di kemudian hari.

---

## 4.1.7.3 Implementasi di SMPN 4 Purwakarta

### a. Strategi Go-Live

Peneliti menerapkan strategi **go-live bertahap** (*phased rollout*) untuk meminimalkan risiko gangguan operasional:

**Tabel 4.84 Strategi Implementasi Bertahap**

| Fase | Durasi | Aktivitas | Tujuan |
|------|--------|-----------|--------|
| Fase 1: Paralel | Minggu ke-1 | Sistem digital dijalankan bersamaan dengan sistem manual (buku absensi fisik) | Memastikan data pada sistem digital konsisten dengan pencatatan manual; mendeteksi masalah teknis awal |
| Fase 2: Transisi | Minggu ke-2 | Sistem digital menjadi metode utama, buku absensi manual sebagai cadangan | Membiasakan pengguna dengan sistem digital; memvalidasi keandalan dalam penggunaan harian |
| Fase 3: Full Digital | Minggu ke-3 dst. | Sistem digital digunakan sepenuhnya, buku absensi manual dihentikan | Operasional penuh menggunakan sistem yang dikembangkan |

### b. Monitoring Awal Penggunaan

Selama masa implementasi awal, peneliti melakukan monitoring terhadap beberapa indikator untuk memastikan sistem berjalan normal:

**Tabel 4.85 Indikator Monitoring Implementasi**

| No | Indikator | Metode Monitoring | Target |
|----|-----------|-------------------|--------|
| 1 | Ketersediaan sistem (*uptime*) | Pemantauan akses server | ≥ 99% uptime selama jam operasional |
| 2 | Jumlah pengguna aktif login | Query log `sessions` | Seluruh guru dan admin login setiap hari kerja |
| 3 | Transaksi absensi QR Code | Query tabel `attendances` | Seluruh guru berhasil check-in dan check-out |
| 4 | Error atau bug yang dilaporkan | Laporan dari pengguna | Zero critical bug |
| 5 | Waktu proses scan QR Code | Observasi langsung | ≤ 10 detik per transaksi |

### c. Dukungan Teknis

Peneliti menyediakan dukungan teknis (*technical support*) selama masa transisi untuk memastikan kelancaran implementasi:

1. **Kanal komunikasi**: Peneliti menyediakan nomor kontak yang dapat dihubungi oleh admin atau guru apabila mengalami kendala teknis saat menggunakan sistem.
2. **Penanganan insiden**: Setiap kendala yang dilaporkan oleh pengguna didokumentasikan, dianalisis, dan ditindaklanjuti. Kendala minor diselesaikan secara remote, sedangkan kendala yang memerlukan perubahan kode diperbaiki dan di-deploy ulang.
3. **Transfer knowledge**: Peneliti melakukan transfer pengetahuan teknis kepada staf TU yang ditunjuk sebagai admin sistem, meliputi: cara backup database, cara menangani kendala umum (reset password, refresh QR Code), dan cara menambah data master baru.

---

## 4.1.7.4 Hasil Implementasi

Setelah sistem diterapkan selama periode awal, peneliti mencatat beberapa hasil dari implementasi:

1. **Seluruh guru berhasil menggunakan fitur scan QR Code** untuk mencatat kehadiran harian. Proses yang sebelumnya memerlukan pencarian buku absensi dan pengisian manual (~2 menit) kini hanya membutuhkan waktu ~10 detik melalui scan QR Code pada smartphone.

2. **Proses rekapitulasi kehadiran yang sebelumnya memerlukan 2–3 hari kerja** oleh staf TU kini dapat dilakukan secara instan melalui fitur export laporan ke Excel atau PDF dengan filter periode yang diinginkan.

3. **Kepala sekolah dapat memantau kehadiran guru secara real-time** melalui dashboard tanpa harus menunggu laporan dari staf TU, meningkatkan efektivitas pengawasan.

4. **Proses input dan perhitungan nilai siswa menjadi lebih efisien** — guru menginput nilai melalui form tabel interaktif, dan sistem menghitung nilai akhir secara otomatis berdasarkan bobot yang telah ditetapkan.

5. **Perhitungan ranking SAW berjalan dengan benar** dan hasil perhitungannya dapat diterima oleh pihak sekolah karena transparansi detail langkah-langkah perhitungan yang ditampilkan oleh sistem.

6. **Tidak ditemukan kendala teknis kritis** selama masa implementasi. Beberapa kendala minor yang dilaporkan — seperti guru yang lupa password dan pertanyaan tentang cara menggunakan fitur tertentu — dapat diselesaikan melalui dukungan teknis tanpa harus melakukan perubahan pada kode sistem.
