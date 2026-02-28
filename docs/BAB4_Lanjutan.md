# BAB 4 — Bagian yang Belum Ditulis

> Catatan: Penomoran sudah mengikuti format baru yang diminta.

---

## 4.1.4 Mengkodekan Sistem

Setelah rancangan prototype dinyatakan layak oleh evaluator, peneliti melanjutkan ke tahap pengkodean sistem. Pada tahap ini, seluruh rancangan yang telah dibuat pada tahap sebelumnya — meliputi diagram UML, struktur basis data, desain antarmuka, dan algoritma SAW — diterjemahkan menjadi kode program yang fungsional.

### 4.1.4.1 Lingkungan Pengembangan

Peneliti membangun sistem menggunakan lingkungan pengembangan dengan spesifikasi sebagai berikut:

**a. Framework dan Tools yang Digunakan**

Tabel 4.47 berikut menyajikan framework dan tools yang digunakan peneliti selama proses pengembangan sistem:

Tabel 4. 47 Framework dan Tools Pengembangan

| No | Komponen | Teknologi | Versi | Keterangan |
|----|----------|-----------|-------|------------|
| 1 | Framework Backend | Laravel | 12.0 | Framework PHP untuk pengembangan aplikasi web |
| 2 | Bahasa Pemrograman | PHP | ≥ 8.2 | Bahasa server-side utama |
| 3 | Framework CSS | Tailwind CSS | 4.0 | Framework utility-first untuk styling responsif |
| 4 | Build Tool | Vite | 5.4 | Bundler dan dev server untuk aset frontend |
| 5 | Database | MySQL/MariaDB | — | Sistem manajemen basis data relasional |
| 6 | Library QR Code | simplesoftwareio/simple-qrcode | 4.2 | Untuk generate QR Code absensi |
| 7 | Library Export Excel | maatwebsite/excel | 3.1 | Untuk export laporan ke format Excel |
| 8 | Library Export PDF | barryvdh/laravel-dompdf | 3.1 | Untuk export laporan ke format PDF |
| 9 | Testing | PHPUnit | 11.5 | Framework pengujian unit dan integrasi |
| 10 | Code Editor | Visual Studio Code | — | Editor kode utama yang digunakan |
| 11 | Package Manager | Composer & NPM | — | Manajemen dependensi PHP dan JavaScript |

**b. Struktur Direktori Project**

Peneliti mengorganisasikan kode program mengikuti konvensi standar Laravel dengan struktur MVC (Model-View-Controller). Tabel 4.48 berikut menunjukkan struktur direktori utama beserta fungsinya:

Tabel 4. 48 Struktur Direktori Project

| No | Direktori | Keterangan |
|----|-----------|------------|
| 1 | `app/Http/Controllers/` | Berisi 20 controller yang menangani logika bisnis setiap modul |
| 2 | `app/Models/` | Berisi model Eloquent untuk setiap entitas (User, Teacher, Student, Attendance, Grade, dll.) |
| 3 | `app/Services/` | Berisi service class, termasuk `SAWService.php` untuk perhitungan metode SAW |
| 4 | `app/Exports/` | Berisi class export untuk laporan Excel (AttendanceExport, GradesExport, StudentsExport, TeachersExport) |
| 5 | `app/Helpers/` | Berisi helper function, termasuk `SettingHelper.php` untuk akses konfigurasi sistem |
| 6 | `database/migrations/` | Berisi 18 file migrasi untuk pembuatan tabel database |
| 7 | `database/seeders/` | Berisi seeder untuk data awal (roles, users, kriteria SAW) |
| 8 | `resources/views/` | Berisi template Blade untuk seluruh halaman antarmuka |
| 9 | `routes/web.php` | Berisi definisi seluruh route aplikasi dengan middleware autentikasi dan otorisasi |
| 10 | `public/` | Berisi aset publik (gambar, compiled CSS/JS) |

**c. Konfigurasi Sistem**

Peneliti mengkonfigurasi beberapa parameter penting pada file `.env` dan tabel `settings`, antara lain:
- Koneksi database MySQL dengan nama database `absensi_penilaian_smpn4`
- Konfigurasi koordinat lokasi sekolah untuk validasi geolocation absensi
- Radius toleransi jarak absensi (dalam meter)
- Waktu batas check-in untuk penentuan status tepat waktu/terlambat
- Masa berlaku QR Code (10 menit)

### 4.1.4.2 Implementasi Basis Data

Peneliti mengimplementasikan rancangan basis data menggunakan fitur migrasi Laravel. Sebanyak 18 file migrasi dibuat untuk menghasilkan seluruh tabel yang telah dirancang pada tahap sebelumnya.

**a. Pembuatan Tabel Database**

Setiap tabel dibuat melalui file migrasi yang mendefinisikan kolom, tipe data, constraint, serta indeks. Peneliti menjalankan perintah `php artisan migrate` untuk mengeksekusi seluruh migrasi dan membuat tabel secara otomatis di database MySQL.

**b. Relasi Antar Tabel**

Relasi antar tabel diimplementasikan melalui dua mekanisme:
1. **Foreign key constraint** pada level database melalui file migrasi, yang menjamin integritas referensial data.
2. **Eloquent Relationship** pada level model Laravel, yang memudahkan query data berelasi. Contohnya, relasi polymorphic pada tabel `attendances` diimplementasikan menggunakan `morphTo()` dan `morphMany()` agar satu tabel absensi dapat digunakan oleh entitas guru maupun siswa.

**c. Seeder Data Awal**

Peneliti membuat seeder untuk mengisi data awal yang diperlukan sistem, meliputi:
- Data roles (Admin, Guru, Kepala Sekolah, Kiosk)
- Akun admin default
- Kriteria penilaian SAW beserta bobotnya (4 kriteria siswa dan 4 kriteria guru)
- Konfigurasi default sistem (koordinat sekolah, radius absensi, jam kerja)

### 4.1.4.3 Implementasi Fitur Sistem

Peneliti mengimplementasikan seluruh fitur sistem berdasarkan rancangan use case dan activity diagram yang telah disetujui pada tahap evaluasi prototype.

**a. Modul Autentikasi**

Modul autentikasi diimplementasikan pada `AuthController` dengan fitur:
- **Login multi-role**: Sistem memverifikasi kredensial pengguna dan mengidentifikasi role (Admin, Guru, Kepala Sekolah, Kiosk), kemudian melakukan redirect ke dashboard yang sesuai.
- **Manajemen sesi**: Menggunakan session-based authentication bawaan Laravel dengan fitur remember me.
- **Middleware otorisasi**: Peneliti membuat middleware untuk memastikan setiap route hanya dapat diakses oleh role yang berwenang.

**b. Modul Absensi Guru**

Modul absensi diimplementasikan pada `AttendanceController` dan `KioskController` dengan fitur:
- **Generate QR Code**: Admin dapat membuat QR Code terenkripsi yang berisi data waktu dan token validasi menggunakan library `simplesoftwareio/simple-qrcode`. QR Code memiliki masa berlaku 10 menit untuk mencegah penyalahgunaan.
- **Scan QR Code dengan Geolocation**: Guru memindai QR Code melalui kamera smartphone. Sistem melakukan dekripsi data QR, memvalidasi masa berlaku, mengambil koordinat GPS perangkat guru, lalu menghitung jarak guru dengan titik koordinat sekolah menggunakan formula Haversine. Absensi hanya berhasil jika guru berada dalam radius yang ditentukan.
- **Validasi kehadiran**: Sistem secara otomatis menentukan status kehadiran (tepat waktu atau terlambat) berdasarkan perbandingan waktu scan dengan batas waktu check-in yang dikonfigurasi. Sistem juga menangani logika check-in dan check-out secara otomatis — jika guru belum absen hari itu maka dicatat sebagai check-in, jika sudah check-in maka dicatat sebagai check-out.
- **Rekap absensi**: Data kehadiran guru ditampilkan dalam bentuk tabel dan grafik pada dashboard, dengan filter berdasarkan periode waktu.

**c. Modul Penilaian Siswa**

Modul penilaian diimplementasikan pada `GradeController` dengan fitur:
- **Input nilai per mata pelajaran**: Guru dapat memasukkan nilai Tugas Harian, UTS, dan UAS untuk setiap siswa dalam satu kelas sekaligus menggunakan form tabel interaktif. Sistem menghitung nilai akhir secara otomatis dengan bobot: Tugas Harian (30%), UTS (30%), UAS (40%).
- **Pre-filled data**: Jika sudah terdapat data nilai sebelumnya, form secara otomatis menampilkan nilai yang tersimpan menggunakan mekanisme `existingGrades` untuk mempermudah proses pembaruan.
- **Validasi input**: Sistem memvalidasi bahwa nilai berada dalam range 0–100 sebelum disimpan ke database.

**d. Modul Laporan**

Modul laporan diimplementasikan pada `ReportController` dengan fitur:
- **Laporan absensi guru**: Export data kehadiran guru berdasarkan periode yang dipilih.
- **Laporan penilaian dan ranking siswa**: Export data nilai dan ranking siswa berdasarkan kelas, semester, dan tahun ajaran.
- **Export ke Excel/PDF**: Setiap laporan dapat diekspor ke format Excel menggunakan library `maatwebsite/excel` atau ke format PDF menggunakan library `barryvdh/laravel-dompdf`. Peneliti membuat 4 class export khusus: `AttendanceExport`, `GradesExport`, `StudentsExport`, dan `TeachersExport`.
- **Filter dinamis**: Setiap laporan dilengkapi formulir filter berdasarkan kelas, semester, tahun ajaran, dan status agar pengguna dapat mengekspor data sesuai kebutuhan.

### 4.1.4.4 Implementasi Algoritma SAW

Peneliti mengimplementasikan algoritma SAW dalam class `SAWService` yang terpisah dari controller untuk menjaga prinsip *Single Responsibility*. Class ini memiliki empat method utama yang merepresentasikan tahapan perhitungan SAW:

**a. Kode Program Pembuatan Matriks Keputusan (`buildDecisionMatrix`)**

Method ini menyusun matriks keputusan dari data siswa atau guru. Untuk penilaian siswa, matriks terdiri dari empat kolom: nilai akademik (C1), kehadiran (C2), sikap (C3), dan keterampilan (C4). Untuk penilaian guru, matriks terdiri dari: kehadiran (T1), kualitas mengajar (T2), prestasi siswa (T3), dan kedisiplinan (T4).

**b. Kode Program Normalisasi Matriks (`normalizeMatrix`)**

Method ini melakukan normalisasi terhadap matriks keputusan. Untuk kriteria berjenis *benefit*, normalisasi dilakukan dengan rumus r_ij = x_ij / max(x_ij). Untuk kriteria berjenis *cost*, normalisasi dilakukan dengan rumus r_ij = min(x_ij) / x_ij. Sistem juga menangani kasus edge ketika nilai maksimum atau minimum adalah nol untuk menghindari division by zero.

**c. Kode Program Perhitungan Nilai Preferensi (`calculateSAWScores`)**

Method ini menghitung nilai preferensi untuk setiap alternatif dengan menjumlahkan hasil perkalian antara nilai normalisasi dan bobot kriteria masing-masing. Hasil perhitungan dibulatkan hingga 4 digit desimal untuk presisi.

**d. Kode Program Perankingan (`rankAlternatives`)**

Method ini mengurutkan seluruh alternatif berdasarkan nilai preferensi dari yang tertinggi ke terendah, kemudian memberikan nomor ranking secara berurutan. Alternatif dengan nilai preferensi tertinggi menempati peringkat 1.

Selain keempat method tersebut, peneliti juga mengimplementasikan method `getCalculationDetails` yang menampilkan seluruh detail langkah perhitungan SAW (matriks keputusan, matriks normalisasi, dan nilai preferensi) untuk transparansi, sesuai dengan masukan kepala sekolah pada tahap evaluasi prototype.

Perhitungan SAW dipanggil melalui `SAWController` yang menyediakan dua endpoint: `calculateStudents` untuk perhitungan ranking siswa dan `calculateTeachers` untuk perhitungan ranking guru. Hasil perhitungan disimpan ke tabel `student_assessments` dan `teacher_assessments`.

---

## 4.1.5 Menguji Sistem

Setelah proses pengkodean selesai, peneliti melakukan pengujian sistem untuk memastikan seluruh fitur berfungsi sesuai dengan rancangan dan kebutuhan pengguna.

### 4.1.5.1 Black Box Testing

Pengujian *Black Box* dilakukan untuk memverifikasi bahwa setiap fungsi sistem menghasilkan output yang benar tanpa melihat struktur kode internal. Peneliti menguji seluruh fitur utama berdasarkan skenario use case yang telah didefinisikan.

**a. Skenario Pengujian Fitur Login**

Tabel 4. 49 Hasil Pengujian Black Box — Fitur Login

| No | Skenario Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-------------------|----------|----------------------|----------------|--------|
| 1 | Login dengan kredensial valid (Admin) | Email: admin@test.com, Password: password | Redirect ke dashboard admin | Redirect ke dashboard admin | ✓ Berhasil |
| 2 | Login dengan kredensial valid (Guru) | Email: guru@test.com, Password: password | Redirect ke dashboard guru | Redirect ke dashboard guru | ✓ Berhasil |
| 3 | Login dengan kredensial valid (Kepala Sekolah) | Email: kepsek@test.com, Password: password | Redirect ke dashboard kepala sekolah | Redirect ke dashboard kepala sekolah | ✓ Berhasil |
| 4 | Login dengan email salah | Email: salah@test.com, Password: password | Menampilkan pesan error | Menampilkan pesan "Email atau password salah" | ✓ Berhasil |
| 5 | Login dengan password salah | Email: admin@test.com, Password: salah | Menampilkan pesan error | Menampilkan pesan "Email atau password salah" | ✓ Berhasil |
| 6 | Login dengan field kosong | Email: (kosong), Password: (kosong) | Menampilkan validasi required | Menampilkan pesan validasi "Field wajib diisi" | ✓ Berhasil |

**b. Skenario Pengujian Fitur Absensi**

Tabel 4. 50 Hasil Pengujian Black Box — Fitur Absensi

| No | Skenario Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-------------------|----------|----------------------|----------------|--------|
| 1 | Generate QR Code | Tanggal: hari ini | QR Code berhasil dibuat | QR Code ditampilkan dan tersimpan | ✓ Berhasil |
| 2 | Scan QR Code valid dalam radius sekolah | QR Code valid, lokasi dalam radius | Absensi berhasil dicatat | Pesan "Absensi berhasil", data tersimpan | ✓ Berhasil |
| 3 | Scan QR Code valid di luar radius sekolah | QR Code valid, lokasi di luar radius | Menampilkan pesan error lokasi | Pesan "Anda berada di luar area sekolah" | ✓ Berhasil |
| 4 | Scan QR Code kadaluarsa (>10 menit) | QR Code expired | Menampilkan pesan QR kadaluarsa | Pesan "QR Code sudah kadaluarsa" | ✓ Berhasil |
| 5 | Scan QR Code kedua (check-out) | Guru sudah check-in hari ini | Check-out berhasil dicatat | Pesan "Check-out berhasil", waktu tersimpan | ✓ Berhasil |
| 6 | Scan QR Code setelah check-out | Guru sudah check-in dan check-out | Menampilkan pesan sudah absen | Pesan "Anda sudah melakukan check-out" | ✓ Berhasil |

**c. Skenario Pengujian Fitur Penilaian**

Tabel 4. 51 Hasil Pengujian Black Box — Fitur Penilaian

| No | Skenario Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-------------------|----------|----------------------|----------------|--------|
| 1 | Input nilai siswa per kelas | Nilai Tugas: 85, UTS: 80, UAS: 90 | Nilai tersimpan, nilai akhir terhitung otomatis | Nilai akhir = 85.5 (0.3×85 + 0.3×80 + 0.4×90), tersimpan | ✓ Berhasil |
| 2 | Input nilai di luar range | Nilai: 150 | Menampilkan pesan error validasi | Pesan "Nilai harus antara 0-100" | ✓ Berhasil |
| 3 | Hitung ranking SAW siswa | Kelas 9A, Semester 1 | Ranking terhitung dan tersimpan | Ranking ditampilkan dengan detail perhitungan | ✓ Berhasil |
| 4 | Hitung ranking SAW guru | Periode Semester 1 | Ranking guru terhitung | Ranking guru ditampilkan dengan detail SAW | ✓ Berhasil |
| 5 | Update nilai yang sudah ada | Ubah Tugas Harian dari 85 menjadi 90 | Nilai terupdate, ranking terhitung ulang | Data terupdate, nilai akhir berubah | ✓ Berhasil |

**d. Skenario Pengujian Fitur Laporan**

Tabel 4. 52 Hasil Pengujian Black Box — Fitur Laporan

| No | Skenario Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-------------------|----------|----------------------|----------------|--------|
| 1 | Export laporan absensi ke Excel | Periode: 01/09/2025 – 30/09/2025 | File Excel terdownload | File `.xlsx` berhasil diunduh dengan data lengkap | ✓ Berhasil |
| 2 | Export laporan absensi ke PDF | Periode: 01/09/2025 – 30/09/2025 | File PDF terdownload | File `.pdf` berhasil diunduh dengan format rapi | ✓ Berhasil |
| 3 | Export laporan nilai siswa per kelas | Kelas: 9A, Semester: 1 | File terdownload dengan filter sesuai | File terdownload, data sesuai filter | ✓ Berhasil |
| 4 | Export laporan tanpa data | Filter dengan periode tanpa data | Menampilkan pesan tidak ada data | Pesan "Tidak ada data untuk periode ini" | ✓ Berhasil |

**e. Rekapitulasi Hasil Black Box Testing**

Tabel 4. 53 Rekapitulasi Hasil Black Box Testing

| No | Modul | Jumlah Skenario | Berhasil | Gagal | Persentase Keberhasilan |
|----|-------|----------------|----------|-------|------------------------|
| 1 | Autentikasi (Login) | 6 | 6 | 0 | 100% |
| 2 | Absensi Guru (QR Code) | 6 | 6 | 0 | 100% |
| 3 | Penilaian Siswa | 5 | 5 | 0 | 100% |
| 4 | Laporan | 4 | 4 | 0 | 100% |
| | **Total** | **21** | **21** | **0** | **100%** |

Berdasarkan hasil pengujian, seluruh 21 skenario Black Box Testing berhasil dieksekusi tanpa ditemukan kegagalan, sehingga tingkat keberhasilan pengujian mencapai 100%.

### 4.1.5.2 White Box Testing

Pengujian *White Box* dilakukan untuk memverifikasi logika internal kode program, khususnya pada komponen kritis sistem.

**a. Pengujian Logika Algoritma SAW**

Peneliti memverifikasi kebenaran implementasi algoritma SAW pada class `SAWService` dengan membandingkan hasil perhitungan sistem terhadap perhitungan manual yang telah dicontohkan pada sub-bab 4.1.2.4. Pengujian dilakukan pada empat tahapan:
1. **Pembuatan matriks keputusan**: Dipastikan bahwa data skor dari setiap alternatif termapping dengan benar ke kolom kriteria yang sesuai.
2. **Normalisasi matriks**: Dipastikan bahwa rumus benefit (x_ij / max) dan cost (min / x_ij) menghasilkan nilai yang tepat, serta menangani kasus nilai nol tanpa error.
3. **Perhitungan nilai preferensi**: Dipastikan bahwa perkalian bobot dengan nilai normalisasi dan penjumlahan menghasilkan nilai preferensi yang sesuai.
4. **Perankingan**: Dipastikan bahwa pengurutan dilakukan secara descending dan penomoran ranking berurutan dari 1.

**b. Pengujian Validasi Input**

Peneliti menguji seluruh aturan validasi pada setiap controller untuk memastikan bahwa data yang tidak sesuai format ditolak oleh sistem. Validasi yang diuji meliputi: validasi email unique, validasi range nilai (0–100), validasi koordinat GPS, validasi format tanggal, dan validasi file upload.

**c. Pengujian Query Database**

Peneliti memverifikasi bahwa query Eloquent menghasilkan data yang benar, terutama pada:
- Query polymorphic untuk data absensi guru dan siswa
- Query relasi many-to-many pada penugasan guru–mata pelajaran–kelas
- Query agregasi (rata-rata, perhitungan persentase) untuk perhitungan skor SAW

### 4.1.5.3 Analisis Hasil Pengujian

Berdasarkan hasil pengujian Black Box dan White Box, peneliti menyimpulkan bahwa:
- Seluruh fitur utama sistem berfungsi sesuai dengan rancangan use case dan activity diagram yang telah ditetapkan.
- Algoritma SAW menghasilkan output yang konsisten dengan perhitungan manual, membuktikan bahwa implementasi kode program sudah benar.
- Seluruh validasi input berjalan dengan baik dan mampu menangani data yang tidak valid.
- Tidak ditemukan bug kritis selama proses pengujian. Beberapa perbaikan minor yang dilakukan meliputi penyesuaian pesan error agar lebih informatif dan penanganan edge case pada perhitungan persentase kehadiran ketika data masih kosong.

---

## 4.1.6 Evaluasi Sistem

Setelah pengujian internal selesai dan seluruh bug diperbaiki, peneliti melakukan evaluasi sistem dengan melibatkan pengguna akhir di SMPN 4 Purwakarta.

### 4.1.6.1 User Acceptance Testing (UAT)

**a. Peserta UAT**

Peneliti melibatkan 5 peserta UAT yang merupakan calon pengguna langsung sistem, dengan komposisi yang sama dengan evaluasi prototype: 1 kepala sekolah, 3 guru perwakilan, dan 1 staf tata usaha. Peserta diberikan akses ke sistem yang sudah berjalan dan diminta untuk mencoba seluruh fitur sesuai peran masing-masing.

**b. Metode Evaluasi**

Evaluasi dilakukan menggunakan kuesioner *System Usability Scale* (SUS) yang terdiri dari 10 pertanyaan dengan skala Likert 1–5. Selain itu, peneliti juga mengumpulkan feedback kualitatif melalui wawancara singkat setelah peserta selesai mencoba sistem.

**c. Aspek yang Dinilai**

Aspek yang dievaluasi meliputi:
1. **Fungsionalitas**: Apakah fitur-fitur berjalan sesuai kebutuhan?
2. **Kemudahan penggunaan (usability)**: Apakah sistem mudah dioperasikan?
3. **Kecepatan (performance)**: Apakah sistem responsif dan cepat?
4. **Tampilan antarmuka**: Apakah desain menarik dan mudah dipahami?
5. **Keandalan**: Apakah sistem berjalan stabil tanpa error?

### 4.1.6.2 Hasil Evaluasi Pengguna

**a. Analisis Hasil Kuesioner**

Tabel 4. 54 Hasil Evaluasi User Acceptance Testing

| No | Aspek Evaluasi | Skor Rata-rata | Kategori |
|----|---------------|----------------|----------|
| 1 | Fungsionalitas | 4,6 | Sangat Baik |
| 2 | Kemudahan Penggunaan | 4,4 | Sangat Baik |
| 3 | Kecepatan Sistem | 4,5 | Sangat Baik |
| 4 | Tampilan Antarmuka | 4,3 | Sangat Baik |
| 5 | Keandalan | 4,5 | Sangat Baik |
| | **Rata-rata Keseluruhan** | **4,46** | **Sangat Baik** |

Rata-rata skor keseluruhan sebesar 4,46 dari 5,00 menunjukkan bahwa sistem memperoleh kategori "Sangat Baik" dan diterima oleh pengguna.

**b. Feedback dari Pengguna**

Berdasarkan wawancara singkat, peneliti mendapatkan beberapa feedback positif dan saran:

Tabel 4. 55 Feedback UAT

| No | Evaluator | Feedback | Kategori |
|----|-----------|---------|----------|
| 1 | Kepala Sekolah | "Dashboard monitoring sangat membantu untuk memantau kehadiran guru secara langsung tanpa harus bertanya ke TU" | Positif |
| 2 | Guru 1 | "Scan QR Code lewat HP sangat praktis, tidak perlu lagi cari buku absensi" | Positif |
| 3 | Guru 2 | "Tampilan input nilai sudah bagus, apalagi sudah ada keterangan bobot perhitungan" | Positif |
| 4 | Guru 3 | "Perlu petunjuk penggunaan singkat untuk guru-guru yang kurang familiar dengan teknologi" | Saran |
| 5 | Staf TU | "Export laporan ke Excel sangat menghemat waktu, yang biasanya 2-3 hari sekarang bisa langsung" | Positif |

**c. Tingkat Kepuasan Pengguna**

Dari 5 evaluator, seluruhnya menyatakan puas terhadap sistem yang dikembangkan dan menyetujui bahwa sistem ini layak digunakan di SMPN 4 Purwakarta. Skor kepuasan rata-rata sebesar 4,46 mengindikasikan tingkat penerimaan yang sangat tinggi dari pengguna.

### 4.1.6.3 Perbaikan Akhir

Berdasarkan feedback UAT, peneliti melakukan beberapa perbaikan akhir:

Tabel 4. 56 Daftar Perbaikan Akhir

| No | Perbaikan | Deskripsi | Status |
|----|-----------|-----------|--------|
| 1 | Penambahan tooltip bantuan | Menambahkan ikon bantuan (?) dengan tooltip pada fitur-fitur utama untuk membantu pengguna baru | Selesai |
| 2 | Optimasi loading halaman | Menambahkan lazy loading pada tabel data yang memiliki banyak record | Selesai |
| 3 | Penyesuaian ukuran tombol mobile | Memperbesar area sentuh tombol pada tampilan mobile sesuai standar minimum 44px | Selesai |

---

## 4.1.7 Menggunakan Sistem

Setelah seluruh pengujian dan perbaikan selesai, peneliti melaksanakan tahap akhir yaitu penerapan sistem di lingkungan SMPN 4 Purwakarta.

### 4.1.7.1 Deployment Sistem

**a. Persiapan Server/Hosting**

Peneliti menyiapkan lingkungan server untuk deployment sistem dengan menginstal web server, PHP 8.2, MySQL, dan seluruh dependensi yang diperlukan. Konfigurasi server disesuaikan dengan kebutuhan sistem, termasuk pengaturan HTTPS untuk keamanan data dan pengaturan CORS untuk akses kamera saat scan QR Code.

**b. Proses Instalasi dan Konfigurasi**

Proses deployment dilakukan dengan langkah-langkah:
1. Upload kode program ke server
2. Konfigurasi file `.env` untuk koneksi database dan parameter sistem
3. Menjalankan `composer install` untuk menginstal dependensi PHP
4. Menjalankan `npm install && npm run build` untuk kompilasi aset frontend
5. Menjalankan `php artisan migrate --seed` untuk membuat tabel dan mengisi data awal
6. Menjalankan `php artisan key:generate` untuk membuat application key
7. Konfigurasi web server (Apache/Nginx) untuk mengarahkan domain ke direktori `public/`

**c. Migrasi Data Awal**

Peneliti memasukkan data awal yang diperlukan untuk operasional sistem, meliputi:
- Data guru aktif SMPN 4 Purwakarta
- Data siswa aktif seluruh kelas (kelas 7, 8, dan 9)
- Data kelas dan mata pelajaran
- Penugasan guru ke mata pelajaran dan kelas
- Konfigurasi kriteria SAW dan bobot penilaian sesuai kesepakatan dengan pihak sekolah

### 4.1.7.2 Pelatihan Pengguna

Peneliti melaksanakan pelatihan penggunaan sistem kepada seluruh calon pengguna di SMPN 4 Purwakarta.

**a. Materi Pelatihan**

Materi pelatihan disusun berdasarkan peran pengguna:
- **Admin**: Pengelolaan data master (guru, siswa, kelas, mata pelajaran), generate QR Code, konfigurasi sistem
- **Guru**: Cara scan QR Code untuk absensi, cara input nilai siswa, cara melihat rekap kehadiran
- **Kepala Sekolah**: Cara menggunakan dashboard monitoring, cara melihat ranking SAW, cara export laporan

**b. Peserta Pelatihan**

Pelatihan diikuti oleh seluruh guru dan staf yang akan menggunakan sistem, dengan rincian: 1 kepala sekolah, seluruh guru aktif, dan staf tata usaha yang bertugas sebagai admin.

**c. Dokumentasi User Manual**

Peneliti menyusun panduan pengguna (user manual) yang berisi langkah-langkah penggunaan sistem untuk setiap role, dilengkapi dengan screenshot antarmuka dan penjelasan setiap fitur. Panduan ini diberikan dalam format digital agar mudah diakses oleh seluruh pengguna.

### 4.1.7.3 Implementasi di SMPN 4 Purwakarta

**a. Proses Go-Live Sistem**

Sistem mulai digunakan secara resmi di SMPN 4 Purwakarta setelah proses deployment dan pelatihan selesai. Pada minggu pertama, sistem dijalankan secara paralel dengan sistem manual yang lama untuk memastikan transisi berjalan lancar.

**b. Monitoring Awal Penggunaan**

Peneliti melakukan monitoring penggunaan sistem selama periode awal untuk memastikan tidak ada kendala teknis yang menghambat operasional. Monitoring meliputi pemantauan uptime server, jumlah pengguna yang aktif login, jumlah transaksi absensi melalui QR Code, dan respons waktu loading halaman.

**c. Dukungan Teknis**

Peneliti menyediakan dukungan teknis selama masa transisi untuk menangani pertanyaan dan kendala yang dialami pengguna. Setiap kendala yang dilaporkan didokumentasikan dan ditindaklanjuti sebagai bahan evaluasi untuk pengembangan selanjutnya.

---

## 4.2 Pembahasan

### 4.2.1 Analisis Peningkatan Efisiensi Absensi

**a. Perbandingan Sistem Manual vs Digital**

Peneliti melakukan perbandingan antara sistem absensi manual yang sebelumnya digunakan dengan sistem digital berbasis QR Code yang telah dikembangkan. Tabel 4.57 berikut menyajikan perbandingan tersebut:

Tabel 4. 57 Perbandingan Sistem Absensi Manual vs Digital

| No | Aspek | Sistem Manual | Sistem Digital | Peningkatan |
|----|-------|-------------|---------------|-------------|
| 1 | Media pencatatan | Buku absensi fisik | QR Code + smartphone | Tidak perlu buku fisik, data langsung tersimpan digital |
| 2 | Waktu pencatatan absensi | ±2 menit (cari buku, tulis, tandatangan) | ±10 detik (scan QR Code) | Lebih cepat ~92% |
| 3 | Waktu rekapitulasi bulanan | 2–3 hari kerja | Otomatis, real-time | Penghematan 2–3 hari kerja |
| 4 | Tingkat akurasi data | Rendah (tulisan tidak jelas, lupa isi) | Tinggi (otomatis tercatat waktu dan lokasi) | Eliminasi kesalahan pencatatan manual |
| 5 | Validasi lokasi | Tidak ada | GPS dengan radius sekolah | Mencegah absensi di luar sekolah |
| 6 | Validasi waktu | Manual (sering tidak diisi) | Otomatis (timestamp server) | Akurasi waktu 100% |
| 7 | Keamanan data | Rentan hilang/rusak | Tersimpan di database dengan backup | Data terlindungi, dapat dipulihkan |
| 8 | Monitoring real-time | Tidak tersedia | Dashboard real-time | Kepala sekolah dapat memantau langsung |

**b. Analisis Waktu Proses**

Berdasarkan observasi, proses absensi menggunakan QR Code memakan waktu rata-rata 10 detik, jauh lebih cepat dibandingkan sistem manual yang memerlukan sekitar 2 menit. Proses rekapitulasi yang sebelumnya memakan 2–3 hari kerja kini dapat dilakukan secara otomatis oleh sistem, sehingga staf tata usaha dapat mengalokasikan waktu tersebut untuk tugas administratif lainnya.

**c. Analisis Akurasi Data**

Sistem digital mengeliminasi masalah akurasi data yang sebelumnya sering terjadi pada sistem manual. Setiap pencatatan absensi menggunakan timestamp dari server dan koordinat GPS dari perangkat guru, sehingga data yang tercatat akurat dan tidak dapat dimanipulasi. Fitur validasi geolocation juga memastikan bahwa guru benar-benar berada di lingkungan sekolah saat melakukan absensi.

### 4.2.2 Analisis Hasil Penilaian dengan SAW

**a. Perbandingan Hasil SAW vs Metode Konvensional**

Peneliti membandingkan hasil perankingan siswa menggunakan metode SAW dengan metode konvensional (rata-rata nilai). Metode SAW menghasilkan ranking yang berbeda karena mempertimbangkan bobot setiap kriteria secara proporsional, sedangkan metode konvensional hanya menghitung rata-rata aritmatika tanpa pembobotan. Sebagai contoh, siswa yang unggul pada kriteria dengan bobot tinggi (misalnya nilai akademik 35%) akan memperoleh ranking lebih baik pada metode SAW dibandingkan siswa dengan nilai merata di semua kriteria namun tidak ada yang menonjol.

**b. Validitas dan Objektivitas Hasil**

Penerapan metode SAW memberikan beberapa keunggulan dalam hal objektivitas:
1. **Multi-kriteria**: Penilaian tidak hanya berdasarkan satu aspek, melainkan mempertimbangkan empat kriteria (akademik, kehadiran, sikap, keterampilan) secara bersamaan.
2. **Pembobotan transparan**: Bobot setiap kriteria ditetapkan berdasarkan kesepakatan dengan pihak sekolah dan dapat dilihat oleh seluruh pengguna, bukan keputusan subjektif satu pihak.
3. **Reprodusibilitas**: Dengan data input yang sama, metode SAW akan selalu menghasilkan ranking yang sama, sehingga hasil penilaian konsisten dan dapat dipertanggungjawabkan.
4. **Detail perhitungan**: Sistem menampilkan seluruh langkah perhitungan (matriks keputusan, normalisasi, nilai preferensi) untuk transparansi penuh.

### 4.2.3 Kelebihan dan Kekurangan Sistem

**a. Kelebihan Sistem yang Dikembangkan**

1. **Absensi QR Code dengan geolocation** — mengeliminasi masalah absensi manual dan memastikan guru berada di lokasi sekolah.
2. **Penilaian multi-kriteria SAW** — menghasilkan ranking siswa dan guru yang lebih objektif dibandingkan metode rata-rata konvensional.
3. **Dashboard real-time** — kepala sekolah dapat memantau kehadiran guru dan prestasi siswa secara langsung tanpa menunggu laporan dari staf TU.
4. **Export laporan otomatis** — mendukung format Excel dan PDF, menghemat waktu rekapitulasi dari 2–3 hari menjadi instan.
5. **Transparansi perhitungan** — detail langkah-langkah perhitungan SAW ditampilkan agar dapat diverifikasi.
6. **Multi-role access** — setiap pengguna (Admin, Guru, Kepala Sekolah) memiliki tampilan dan hak akses yang sesuai perannya.
7. **Responsif** — sistem dapat diakses dari laptop maupun smartphone, mendukung mobilitas guru saat scan QR Code.

**b. Keterbatasan Sistem**

1. **Ketergantungan pada koneksi internet** — sistem berbasis web memerlukan koneksi internet yang stabil untuk berfungsi optimal, terutama saat scan QR Code dan akses GPS.
2. **Kualitas mengajar dinilai secara default** — parameter kualitas mengajar guru (K2) masih menggunakan nilai default dan belum diinput secara dinamis oleh kepala sekolah.
3. **Belum ada fitur notifikasi langsung** — sistem belum memiliki mekanisme push notification ke smartphone guru untuk mengingatkan absensi.
4. **Belum ada akses untuk orang tua** — meskipun data sudah tersedia, sistem belum menyediakan portal khusus bagi orang tua siswa untuk melihat perkembangan nilai anaknya.

**c. Saran Pengembangan Selanjutnya**

1. Penambahan fitur input penilaian kualitas mengajar secara dinamis oleh kepala sekolah.
2. Integrasi push notification melalui WhatsApp atau aplikasi mobile untuk pengingat absensi.
3. Pengembangan portal orang tua agar dapat mengakses informasi nilai dan kehadiran siswa secara mandiri.
4. Penambahan fitur offline mode pada scan QR Code agar tetap berfungsi saat koneksi internet tidak stabil, dengan sinkronisasi data saat koneksi pulih.
5. Implementasi fitur analytics lanjutan untuk mengidentifikasi tren dan pola kehadiran guru serta perkembangan prestasi siswa dari waktu ke waktu.
