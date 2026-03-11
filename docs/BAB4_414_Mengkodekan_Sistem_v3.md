# 4.1.4 Mengkodekan Sistem

Setelah rancangan prototype dinyatakan layak oleh seluruh evaluator pada tahap evaluasi, peneliti melanjutkan ke tahap pengkodean sistem. Pada tahap ini, seluruh rancangan yang telah dibuat — meliputi diagram use case, activity diagram, class diagram, struktur basis data, desain antarmuka, dan algoritma SAW — diterjemahkan menjadi kode program yang fungsional. Proses pengkodean dilakukan secara bertahap, dimulai dari penyiapan lingkungan pengembangan, implementasi basis data, implementasi fitur-fitur utama, hingga implementasi algoritma SAW.

---

## 4.1.4.1 Lingkungan Pengembangan

Langkah pertama dalam tahap pengkodean adalah menyiapkan lingkungan pengembangan yang terdiri dari framework, bahasa pemrograman, library pendukung, serta tools pengembangan.

### a. Framework dan Bahasa Pemrograman

Peneliti memilih **Laravel versi 12** sebagai framework utama pengembangan. Laravel menerapkan arsitektur MVC (*Model-View-Controller*) yang memisahkan logika bisnis, tampilan, dan akses data secara terstruktur. Selain itu, Laravel menyediakan berbagai fitur bawaan yang dibutuhkan sistem, seperti pengelolaan database melalui Eloquent ORM, pembuatan halaman melalui Blade templating, pengaturan hak akses melalui middleware, serta pembuatan dan pengelolaan tabel database melalui migration dan seeder. Bahasa pemrograman yang digunakan adalah **PHP versi 8.2** atau lebih tinggi, sesuai dengan persyaratan minimum Laravel 12. Daftar dependensi utama proyek dapat dilihat pada file konfigurasi `composer.json`.

> **Gambar 4.17** — *Screenshot* file `composer.json`, menunjukkan daftar dependensi proyek beserta versi framework dan library yang digunakan.

Untuk bagian tampilan (*frontend*), peneliti menggunakan dua pendekatan:

1. **Bootstrap 5.3** — digunakan pada halaman-halaman manajemen data yang bersifat fungsional (seperti CRUD data guru, siswa, kelas, dan mata pelajaran).
2. **Tailwind CSS versi 4** — digunakan pada halaman dashboard dan halaman lain yang membutuhkan tampilan lebih modern. Tailwind CSS merupakan framework CSS berbasis *utility-first* yang memungkinkan penulisan styling langsung pada elemen HTML. Selain itu, halaman-halaman modern juga menggunakan **Alpine.js** sebagai framework JavaScript ringan untuk menangani interaksi di sisi pengguna, seperti toggle menu dan dropdown.

Proses pengelolaan dan penggabungan file CSS dan JavaScript dilakukan menggunakan **Vite versi 5.4** yang terintegrasi dengan Laravel.

> **Gambar 4.18** — *Screenshot* halaman layout modern, menunjukkan penggunaan Tailwind CSS dan Alpine.js.

### b. Library Pendukung

Selain framework utama, peneliti menggunakan tiga library tambahan untuk mendukung fitur khusus sistem:

**Tabel 4.49 Daftar Library Pendukung**

| No | Library | Versi | Fungsi |
|----|---------|-------|--------|
| 1 | `simplesoftwareio/simple-qrcode` | 4.2 | Membuat QR Code terenkripsi untuk fitur absensi guru |
| 2 | `maatwebsite/excel` | 3.1 | Mengekspor data ke format Microsoft Excel (.xlsx) pada modul laporan |
| 3 | `barryvdh/laravel-dompdf` | 3.1 | Mengekspor data ke format PDF pada modul laporan |

### c. Database

Peneliti menggunakan **MySQL** sebagai sistem manajemen basis data. MySQL dipilih karena performanya baik untuk aplikasi web, mendukung fitur *foreign key* untuk menjaga keutuhan data antar tabel, serta kompatibel dengan Laravel.

### d. Ringkasan Teknologi

**Tabel 4.50 Ringkasan Teknologi Pengembangan**

| No | Komponen | Teknologi | Versi |
|----|----------|-----------|-------|
| 1 | Framework Backend | Laravel | 12.0 |
| 2 | Bahasa Pemrograman | PHP | ≥ 8.2 |
| 3 | Framework CSS | Bootstrap & Tailwind CSS | 5.3 & 4.0 |
| 4 | Framework JavaScript | Alpine.js | 3.x |
| 5 | Build Tool | Vite | 5.4 |
| 6 | Database | MySQL | — |
| 7 | Library QR Code | simplesoftwareio/simple-qrcode | 4.2 |
| 8 | Library Export Excel | maatwebsite/excel | 3.1 |
| 9 | Library Export PDF | barryvdh/laravel-dompdf | 3.1 |
| 10 | Framework Testing | PHPUnit | 11.5 |
| 11 | Code Editor | Visual Studio Code | — |

---

## 4.1.4.2 Struktur Proyek

Kode program diorganisasikan mengikuti konvensi standar arsitektur MVC bawaan Laravel. Selain MVC, peneliti juga menerapkan pola *Service Layer* untuk memisahkan logika bisnis yang kompleks (seperti perhitungan SAW) dari bagian yang menangani alur halaman, sehingga kode lebih modular dan mudah dipelihara.

> **Gambar 4.19** — *Screenshot* struktur direktori utama proyek, menunjukkan organisasi folder untuk controller, model, service, export, migrasi, seeder, dan tampilan.

Secara keseluruhan, proyek ini terdiri dari 20 controller, 15 model data, 1 service untuk perhitungan SAW, 4 class untuk export laporan, 2 middleware untuk otorisasi dan pengaturan bahasa, 18 file migrasi database, 17 file seeder data awal, serta 63 file template halaman yang dikelompokkan ke dalam 19 modul. Tabel 4.50a berikut merangkum struktur tersebut:

**Tabel 4.50a Struktur Direktori Utama Proyek**

| No | Direktori | Isi | Keterangan |
|----|-----------|-----|------------|
| 1 | Controller | 20 file | Menangani alur logika untuk setiap modul: autentikasi, absensi, penilaian, dashboard, laporan, pengaturan, dan lain-lain |
| 2 | Model | 15 file | Merepresentasikan setiap entitas data: pengguna, guru, siswa, kelas, mata pelajaran, kehadiran, nilai, kriteria SAW, pengaturan, notifikasi, dan lain-lain |
| 3 | Service | 1 file | Menangani seluruh logika perhitungan metode SAW |
| 4 | Export | 4 file | Menangani format dan isi file export Excel untuk laporan absensi, nilai, data siswa, dan data guru |
| 5 | Middleware | 2 file | Mengontrol hak akses berdasarkan role pengguna dan pengaturan bahasa tampilan |
| 6 | Migrasi | 18 file | Mendefinisikan struktur seluruh tabel database |
| 7 | Seeder | 17 file | Mengisi data awal yang dibutuhkan sistem |
| 8 | View (Tampilan) | 63 file | Template halaman untuk seluruh antarmuka pengguna |
| 9 | Route | 1 file | Mendefinisikan seluruh alamat URL dan mengatur hak aksesnya |

---

## 4.1.4.3 Implementasi Basis Data

Peneliti mengimplementasikan rancangan basis data menggunakan fitur **migrasi** Laravel. Migrasi memungkinkan peneliti mendefinisikan struktur tabel (kolom, tipe data, dan relasi) dalam bentuk kode program, sehingga pembuatan tabel dapat dilakukan secara otomatis dan terdokumentasi dengan menjalankan satu perintah (`php artisan migrate`).

### a. Pembuatan Tabel Database

Sebanyak **18 file migrasi** dibuat untuk menghasilkan seluruh tabel yang dibutuhkan. Setiap file migrasi mendefinisikan kolom, tipe data, batasan (*constraint*), dan indeks (*index*) untuk masing-masing tabel.

> **Gambar 4.20** — *Screenshot* daftar 18 file migrasi di dalam folder `database/migrations/`.

Sebagai contoh, tabel **kehadiran** (*attendances*) dirancang dengan kolom-kolom berikut:

- Kolom tipe kehadiran (*polymorphic*), sehingga satu tabel dapat menyimpan data kehadiran guru maupun siswa sekaligus.
- Kolom waktu check-in dan check-out.
- Kolom status kehadiran dengan 5 pilihan: *hadir*, *terlambat*, *tidak hadir*, *sakit*, atau *izin*.
- Kolom koordinat GPS (latitude dan longitude) saat check-in maupun check-out, untuk menyimpan bukti lokasi.
- Kolom data QR Code yang digunakan saat absensi.
- Indeks pada kolom tanggal dan tipe kehadiran untuk mempercepat pencarian data.

> **Gambar 4.21** — *Screenshot* kode migrasi tabel kehadiran, menunjukkan definisi kolom status, koordinat GPS, dan QR Code.

Contoh lain, tabel **nilai** (*grades*) dirancang dengan:

- Relasi (*foreign key*) ke tabel siswa, mata pelajaran, dan guru. Jika data induk dihapus, data nilai terkait juga ikut terhapus secara otomatis.
- Kolom untuk setiap komponen nilai: ulangan harian, UTS, UAS, nilai akhir, nilai sikap, dan nilai keterampilan.
- Batasan unik agar satu siswa hanya memiliki satu record nilai untuk satu mata pelajaran pada semester dan tahun ajaran yang sama, sehingga tidak terjadi duplikasi.

> **Gambar 4.22** — *Screenshot* kode migrasi tabel nilai, menunjukkan kolom komponen nilai dan batasan unik.

### b. Relasi Antar Tabel

Relasi antar tabel diimplementasikan pada dua level:

1. **Level database** — melalui *foreign key constraint* pada file migrasi, sehingga database secara langsung menjamin tidak ada data yang "menggantung" tanpa tabel induk.
2. **Level aplikasi** — melalui definisi relasi pada model Laravel, sehingga pengambilan data yang saling terkait menjadi lebih mudah. Jenis relasi yang digunakan antara lain:
   - *One-to-Many* — misalnya satu kelas memiliki banyak siswa
   - *Many-to-Many* — misalnya relasi guru dengan mata pelajaran dan kelas
   - *Polymorphic* — misalnya tabel kehadiran yang dapat menyimpan data guru maupun siswa dalam satu tabel yang sama

> **Gambar 4.23** — *Screenshot* model kehadiran, menunjukkan definisi relasi *polymorphic* dan fungsi bantu untuk menentukan ketepatan waktu serta jarak lokasi.

### c. Data Awal (*Seeder*)

Sebanyak **17 file seeder** disiapkan untuk mengisi data awal yang dibutuhkan agar sistem dapat langsung beroperasi setelah instalasi. Data awal tersebut meliputi:

1. **Role pengguna** — 4 role: *Admin*, *Kepala Sekolah*, *Guru*, dan *Kiosk Presensi* (akun khusus untuk layar display QR di ruang guru).

2. **Akun default** — 3 akun untuk login pertama kali: Administrator, Kepala Sekolah, dan Guru contoh (masing-masing dengan email `@smpn4purwakarta.sch.id`).

3. **Kriteria penilaian SAW** — 8 kriteria default:
   - *Penilaian siswa*: Nilai Akademik (bobot 0,35), Kehadiran (0,25), Sikap/Perilaku (0,20), Keterampilan (0,20) — seluruhnya berjenis *benefit* (semakin tinggi semakin baik).
   - *Penilaian guru*: Kehadiran (0,30), Kualitas Mengajar (0,25), Prestasi Siswa (0,25), Kedisiplinan (0,20) — seluruhnya berjenis *benefit*.

4. **Pengaturan sistem** — 25 konfigurasi yang dikelompokkan ke dalam 5 grup: profil sekolah (9 item), umum (5 item), tampilan (3 item), notifikasi (3 item), dan sistem (4 item). Seluruh pengaturan ini dapat diubah melalui halaman pengaturan di dalam aplikasi.

5. **Data master** — data guru, mata pelajaran, kelas, dan siswa SMPN 4 Purwakarta (termasuk seeder terpisah untuk siswa kelas 7, 8, dan 9).

6. **Data contoh** — data absensi, nilai, dan penilaian siswa untuk keperluan pengujian.

> **Gambar 4.24** — *Screenshot* file seeder utama, menunjukkan daftar seeder yang dipanggil secara berurutan.

---

## 4.1.4.4 Implementasi Fitur Sistem

Peneliti mengimplementasikan seluruh fitur berdasarkan rancangan use case dan activity diagram yang telah dievaluasi pada tahap sebelumnya.

### a. Fitur Login dan Hak Akses

Sistem menggunakan autentikasi berbasis *session* bawaan Laravel. Proses login berjalan sebagai berikut:

1. Pengguna memasukkan email dan password pada halaman login.
2. Sistem memverifikasi kredensial terhadap data di database.
3. Jika valid, sistem mengarahkan pengguna ke dashboard yang sesuai dengan role-nya:
   - *Admin* → Dashboard Admin
   - *Guru* → Dashboard Guru
   - *Kepala Sekolah* → Dashboard Kepala Sekolah
   - *Kiosk Presensi* → Halaman kiosk
4. Jika tidak valid, sistem menampilkan pesan error.

> **Gambar 4.25** — *Screenshot* kode autentikasi, menunjukkan proses verifikasi login dan pengarahan ke dashboard berdasarkan role.

Untuk **hak akses**, peneliti membuat middleware yang memeriksa role pengguna setiap kali mengakses halaman tertentu. Middleware ini diterapkan pada pendefinisian route sehingga:
- Halaman manajemen data (guru, siswa, kelas, dll.) hanya bisa diakses oleh Admin.
- Halaman penilaian bisa diakses oleh Admin dan Guru.
- Halaman perhitungan SAW dan rapor bisa diakses oleh Admin dan Kepala Sekolah.
- Jika pengguna mencoba mengakses halaman yang tidak diizinkan, sistem menolak akses dengan menampilkan pesan "*Anda tidak memiliki akses ke halaman ini*".

> **Gambar 4.26** — *Screenshot* kode middleware hak akses, menunjukkan pengecekan role pengguna sebelum mengizinkan akses ke halaman.

Selain itu, sistem juga mendukung **dua bahasa** (Indonesia dan Inggris) melalui middleware pengaturan bahasa yang membaca preferensi pengguna dari session.

### b. Fitur Absensi Guru

Fitur absensi merupakan salah satu fitur inti sistem yang diimplementasikan dengan dua jalur: melalui **halaman admin** dan melalui **perangkat kiosk** di ruang guru.

**1) Pembuatan QR Code**

Sistem membuat QR Code terenkripsi yang berisi data identitas guru, tanggal, dan waktu pembuatan. Data ini dienkripsi menggunakan algoritma **AES-256-CBC** bawaan Laravel sehingga tidak dapat dibaca atau dipalsukan. QR Code dihasilkan dalam format gambar SVG menggunakan library `simplesoftwareio/simple-qrcode`.

Terdapat dua mekanisme pembuatan QR Code:
- **Melalui halaman admin**: Admin memilih guru, kemudian QR Code dibuat dengan masa berlaku **10 menit**.
- **Melalui perangkat kiosk**: Guru langsung memilih namanya pada layar kiosk, kemudian QR Code dibuat dengan masa berlaku **1 menit** (lebih singkat karena guru langsung memindai di tempat).

> **Gambar 4.27** — *Screenshot* kode pembuatan QR Code melalui halaman admin, menunjukkan proses enkripsi data dan pembuatan gambar QR.

> **Gambar 4.28** — *Screenshot* kode pembuatan QR Code melalui kiosk, menunjukkan masa berlaku 1 menit dan tingkat koreksi error tinggi.

**2) Pemindaian QR Code dan Validasi**

Ketika guru memindai QR Code menggunakan kamera perangkatnya, sistem melakukan serangkaian validasi:

1. **Dekripsi** — data QR didekripsi. Jika gagal (QR rusak atau palsu), sistem menolak dengan pesan error.
2. **Masa berlaku** — sistem memeriksa apakah QR masih berlaku (belum melewati batas waktu 10 menit atau 1 menit).
3. **Tanggal** — sistem memeriksa apakah QR dibuat pada hari yang sama.
4. **Status kehadiran** — sistem memeriksa data absensi guru pada hari tersebut:
   - Jika belum check-in → dicatat sebagai **check-in**. Status ditentukan otomatis: **tepat waktu** jika sebelum pukul 07:30, **terlambat** jika setelahnya.
   - Jika sudah check-in tapi belum check-out → dicatat sebagai **check-out**.
   - Jika sudah lengkap → sistem menampilkan pesan bahwa absensi hari itu sudah selesai.

Pada jalur kiosk, terdapat validasi tambahan: sistem memastikan bahwa guru yang memindai QR adalah guru yang sama dengan pemilik QR tersebut, untuk mencegah penyalahgunaan.

> **Gambar 4.29** — *Screenshot* kode proses pemindaian QR, menunjukkan alur dekripsi, validasi masa berlaku, penentuan status tepat waktu/terlambat, dan logika check-in/check-out.

**3) Validasi Lokasi (*Geolocation*)**

Saat melakukan absensi, sistem juga memvalidasi lokasi guru. Koordinat GPS dari perangkat guru diambil melalui browser, kemudian sistem menghitung jarak antara posisi guru dengan lokasi SMPN 4 Purwakarta menggunakan **formula Haversine** — rumus matematika untuk menghitung jarak antara dua titik di permukaan bumi berdasarkan koordinat latitude dan longitude.

Parameter yang ditetapkan:
- Koordinat SMPN 4 Purwakarta: latitude **-6.5465236**, longitude **107.4414175**
- Radius toleransi: **100 meter**

Jika jarak guru melebihi 100 meter dari titik sekolah, absensi ditolak. Koordinat GPS guru saat check-in dan check-out juga disimpan sebagai bukti lokasi.

> **Gambar 4.30** — *Screenshot* kode validasi lokasi, menunjukkan implementasi formula Haversine dan pengecekan radius 100 meter dari koordinat sekolah.

**4) Absensi Siswa per Kelas**

Selain absensi guru berbasis QR, sistem juga menyediakan fitur absensi siswa yang dilakukan oleh guru atau admin. Guru memilih kelas, kemudian menandai status kehadiran setiap siswa (hadir, sakit, izin, atau tidak hadir). Data disimpan secara bersamaan untuk seluruh siswa dalam satu kelas. Apabila ada siswa yang tidak hadir, sistem otomatis mengirimkan notifikasi.

### c. Fitur Penilaian Siswa

Fitur penilaian memungkinkan guru untuk menginput, mengedit, dan mengelola nilai siswa secara digital.

**1) Input Nilai**

Guru memilih kelas dan mata pelajaran, kemudian sistem menampilkan form berisi daftar seluruh siswa dalam kelas tersebut. Pilihan kelas dan mata pelajaran dibatasi sesuai penugasan guru, sehingga guru hanya dapat menginput nilai untuk kelas dan mata pelajaran yang diajarnya. Untuk setiap siswa, guru mengisi:
- Nilai Tugas Harian
- Nilai UTS
- Nilai UAS
- Nilai Sikap
- Nilai Keterampilan

**Nilai akhir** dihitung otomatis oleh sistem dengan formula:

**Nilai Akhir = (Tugas Harian × 0,30) + (UTS × 0,30) + (UAS × 0,40)**

Setelah nilai disimpan, sistem mengirimkan notifikasi ke admin dan kepala sekolah.

> **Gambar 4.31** — *Screenshot* kode penyimpanan nilai, menunjukkan formula penghitungan nilai akhir dan mekanisme penyimpanan untuk seluruh siswa sekaligus.

**2) Validasi dan Pencegahan Duplikasi**

Sebelum disimpan, sistem memvalidasi bahwa setiap nilai berupa angka dalam rentang **0–100**. Selain itu, database dirancang dengan batasan unik sehingga satu siswa hanya bisa memiliki satu record nilai untuk satu mata pelajaran pada semester dan tahun ajaran yang sama — mencegah duplikasi. Jika guru membuka form untuk kelas yang sudah memiliki data nilai sebelumnya, nilai lama ditampilkan secara otomatis pada form (*pre-filled*) sehingga guru tinggal mengedit jika diperlukan.

**3) Rapor Siswa**

Sistem juga menyediakan halaman rapor yang menampilkan seluruh nilai mata pelajaran seorang siswa beserta rata-rata nilai akhir pada semester dan tahun ajaran yang dipilih.

### d. Fitur Dashboard

Sistem menyediakan dashboard berbeda untuk setiap role:

- **Dashboard Admin**: menampilkan jumlah total siswa, guru, kelas, dan mata pelajaran; statistik kehadiran hari ini; distribusi siswa per tingkat kelas; grafik kehadiran mingguan; daftar kehadiran terbaru; serta statistik bulanan (persentase kehadiran, rata-rata nilai, tingkat kelengkapan data).
- **Dashboard Guru**: menampilkan informasi kehadiran pribadi dan rekap nilai kelas yang diampu.
- **Dashboard Kepala Sekolah**: menampilkan monitoring kehadiran guru dan statistik penilaian siswa untuk keperluan pengawasan.

> **Gambar 4.32** — *Screenshot* kode halaman dashboard admin, menunjukkan data statistik yang ditampilkan ke pengguna.

### e. Fitur Laporan dan Export

Sistem menyediakan fitur export laporan ke format **Excel** dan **PDF**, didukung oleh class export khusus yang mengatur format dan tampilan file yang dihasilkan.

**Tabel 4.51 Jenis Laporan yang Tersedia**

| No | Jenis Laporan | Filter yang Tersedia | Format |
|----|--------------|---------------------|--------|
| 1 | Laporan Presensi | Tanggal mulai, tanggal akhir, tipe (guru/siswa) | Excel, PDF |
| 2 | Laporan Nilai | Kelas, semester, tahun ajaran | Excel, PDF |
| 3 | Laporan Data Siswa | Kelas, tingkat (7/8/9), status | Excel, PDF |
| 4 | Laporan Data Guru | — (seluruh guru) | Excel, PDF |

Setiap file Excel memiliki header tabel yang diformatkan dengan warna dan teks tebal untuk memudahkan pembacaan. File PDF dihasilkan dari template halaman khusus yang dirancang untuk format cetak. Nama file export dibuat otomatis berdasarkan jenis laporan dan filter yang dipilih, contoh: `laporan_presensi_2025-09-01_to_2025-09-30.xlsx`.

> **Gambar 4.33** — *Screenshot* kode class export Excel, menunjukkan pengaturan kolom header, pemetaan data, dan styling tabel.

> **Gambar 4.34** — *Screenshot* kode logika export, menunjukkan percabangan format export (Excel atau PDF).

### f. Fitur Pengaturan Sistem

Admin dapat mengatur 25 parameter sistem melalui halaman pengaturan di dalam aplikasi, tanpa perlu mengubah file konfigurasi secara manual. Pengaturan dikelompokkan ke dalam 5 kategori:

| No | Kategori | Jumlah | Contoh Isi |
|----|----------|--------|------------|
| 1 | Profil Sekolah | 9 item | Nama sekolah, NPSN, alamat, kepala sekolah |
| 2 | Umum | 5 item | Nama aplikasi, zona waktu, bahasa |
| 3 | Tampilan | 3 item | Warna tema, jumlah item per halaman |
| 4 | Notifikasi | 3 item | Toggle email/SMS |
| 5 | Sistem | 4 item | Mode maintenance, backup otomatis |

Selain itu disediakan fitur *clear cache* dan *backup database* yang dapat dijalankan langsung dari halaman pengaturan. Seluruh pengaturan dapat diakses dari bagian manapun dalam sistem melalui fungsi helper bawaan.

> **Gambar 4.35** — *Screenshot* kode halaman pengaturan, menunjukkan 5 kategori pengaturan yang tersedia.

### g. Fitur Notifikasi

Sistem menyediakan notifikasi dalam aplikasi (*in-app notification*) yang dikirim secara otomatis pada kejadian penting, seperti saat nilai baru diinput oleh guru atau saat ada siswa yang tidak hadir. Pengguna dapat melihat daftar notifikasi, menandai sebagai sudah dibaca, atau menghapusnya. Jumlah notifikasi yang belum dibaca juga ditampilkan sebagai badge pada header halaman.

---

## 4.1.4.5 Implementasi Algoritma SAW

Metode *Simple Additive Weighting* (SAW) diimplementasikan dalam class service terpisah yang khusus menangani seluruh logika perhitungan, terpisah dari bagian yang menangani alur halaman. Pemisahan ini mengikuti prinsip agar setiap bagian kode hanya memiliki satu tanggung jawab dan lebih mudah dipelihara.

Proses perhitungan SAW yang diimplementasikan terdiri dari **4 tahap berurutan**:

### a. Tahap 1 — Penyusunan Matriks Keputusan

Pada tahap ini, sistem mengambil data dari database dan menyusunnya menjadi tabel (matriks) di mana setiap baris merepresentasikan satu alternatif dan setiap kolom merepresentasikan satu kriteria.

Untuk **penilaian siswa**, data yang diambil meliputi:
- **C1** (Nilai Akademik) — rata-rata nilai akhir seluruh mata pelajaran
- **C2** (Kehadiran) — persentase kehadiran
- **C3** (Sikap/Perilaku) — rata-rata nilai sikap
- **C4** (Keterampilan) — rata-rata nilai keterampilan

Untuk **penilaian guru**, data yang diambil meliputi:
- **K1** (Kehadiran) — persentase kehadiran
- **K2** (Kualitas Mengajar) — nilai kualitas mengajar
- **K3** (Prestasi Siswa) — rata-rata nilai siswa yang diajar
- **K4** (Kedisiplinan) — skor kedisiplinan berdasarkan data kehadiran

> **Gambar 4.36** — *Screenshot* kode tahap penyusunan matriks keputusan, menunjukkan bagaimana data siswa dan guru dipetakan ke masing-masing kriteria.

### b. Tahap 2 — Normalisasi Matriks

Pada tahap ini, seluruh nilai dalam matriks dinormalisasi ke skala yang sama (0–1) agar kriteria yang memiliki satuan atau rentang berbeda dapat dibandingkan secara adil. Rumus normalisasi yang digunakan bergantung pada jenis kriteria:

- **Benefit** (semakin tinggi semakin baik): nilai dibagi dengan nilai maksimum pada kriteria tersebut → `r = x / max(x)`
- **Cost** (semakin rendah semakin baik): nilai minimum pada kriteria tersebut dibagi dengan nilai → `r = min(x) / x`

Dalam implementasi ini, seluruh 8 kriteria (C1–C4 dan K1–K4) berjenis *benefit*. Sistem juga menangani kasus khusus: jika nilai maksimum atau minimum adalah nol, normalisasi tidak dilakukan untuk menghindari pembagian dengan nol.

> **Gambar 4.37** — *Screenshot* kode normalisasi matriks, menunjukkan rumus normalisasi benefit dan cost.

### c. Tahap 3 — Perhitungan Nilai Preferensi

Setelah dinormalisasi, sistem menghitung **nilai preferensi** untuk setiap alternatif dengan menjumlahkan hasil perkalian antara nilai normalisasi dengan bobot masing-masing kriteria:

**V_i = Σ (w_j × r_ij)**

Hasil dijumlahkan untuk semua kriteria dan dibulatkan hingga **4 digit desimal**. Nilai preferensi ini merepresentasikan skor akhir setiap alternatif dalam perhitungan SAW.

### d. Tahap 4 — Perankingan

Seluruh alternatif diurutkan berdasarkan nilai preferensi dari yang **tertinggi ke terendah**. Alternatif dengan nilai preferensi tertinggi mendapat ranking 1 (terbaik).

> **Gambar 4.38** — *Screenshot* kode perhitungan nilai preferensi dan perankingan, menunjukkan proses perkalian bobot, penjumlahan, dan pengurutan.

### e. Transparansi Perhitungan

Berdasarkan masukan dari kepala sekolah pada tahap evaluasi prototype, sistem menyediakan fitur transparansi yang menampilkan **seluruh detail langkah perhitungan** pada halaman hasil SAW, meliputi: daftar kriteria beserta bobotnya, matriks keputusan (nilai mentah), matriks normalisasi, dan skor akhir setiap alternatif. Fitur ini memungkinkan pengguna memverifikasi kebenaran perhitungan secara manual jika diperlukan.

> **Gambar 4.39** — *Screenshot* kode fitur transparansi perhitungan, menunjukkan data yang ditampilkan berupa matriks keputusan, normalisasi, skor SAW, dan bobot.

### f. Pemanggilan dan Penyimpanan Hasil

Perhitungan SAW dapat dipanggil untuk dua jenis penilaian:

1. **Penilaian Siswa** — mengambil data siswa (nilai rata-rata, kehadiran, sikap, keterampilan), menjalankan perhitungan SAW, lalu menyimpan hasil ranking ke tabel penilaian siswa.
2. **Penilaian Guru** — mengambil data guru (kehadiran, kualitas mengajar, prestasi siswa, kedisiplinan), menjalankan perhitungan SAW, lalu menyimpan hasil ranking ke tabel penilaian guru.

Kedua perhitungan ini dapat difilter berdasarkan semester, tahun ajaran, dan periode bulanan.

> **Gambar 4.40** — *Screenshot* kode perhitungan SAW siswa, menunjukkan pengambilan data, pemanggilan service SAW, dan penyimpanan hasil ranking.

---

## 4.1.4.6 Pengaturan Hak Akses dan Routing

Seluruh alamat URL sistem didefinisikan pada satu file konfigurasi route dengan pengelompokan berdasarkan hak akses. Struktur ini memastikan setiap halaman hanya dapat diakses oleh pengguna yang berwenang:

| Grup Akses | Halaman yang Dapat Diakses |
|------------|---------------------------|
| Publik (tanpa login) | Halaman login, halaman kiosk (tampilan QR) |
| Semua pengguna (setelah login) | Dashboard, profil, notifikasi, halaman QR absensi |
| Hanya Admin | Manajemen data master (guru, siswa, kelas, mata pelajaran, tahun ajaran, penugasan guru, kriteria, user), laporan & export, pengaturan sistem |
| Admin dan Guru | Input dan pengelolaan nilai, absensi siswa per kelas |
| Admin dan Kepala Sekolah | Perhitungan SAW (siswa dan guru), rapor siswa |
| Kiosk (khusus) | Halaman kiosk, API QR dan status kehadiran (publik); proses scan QR (memerlukan login guru) |

> **Gambar 4.41** — *Screenshot* file konfigurasi route, menunjukkan pengelompokan halaman berdasarkan hak akses untuk masing-masing role.

---

## 4.1.4.7 Konfigurasi Sistem

Selain pengkodean fitur, peneliti juga mengatur beberapa parameter penting untuk operasional sistem:

1. **Koneksi Database** — pengaturan host, port, nama database, username, dan password untuk MySQL, serta application key untuk enkripsi data.
2. **Parameter Absensi**:
   - Koordinat GPS SMPN 4 Purwakarta: latitude -6.5465236, longitude 107.4414175
   - Radius toleransi: 100 meter
   - Batas waktu check-in (tepat waktu): pukul 07:30
   - Masa berlaku QR Code: 10 menit (melalui admin), 1 menit (melalui kiosk)
3. **Profil Sekolah** — nama sekolah, NPSN (20219024), alamat, dan data kepala sekolah, disimpan pada tabel pengaturan dan dapat diubah melalui halaman pengaturan.
4. **Kriteria SAW** — 8 kriteria dengan bobot default, dapat disesuaikan melalui halaman manajemen kriteria.
5. **Build Frontend** — konfigurasi Vite untuk menggabungkan file CSS dan JavaScript.

---

## Daftar Gambar pada Bagian 4.1.4

Tabel berikut merangkum seluruh gambar yang perlu disertakan beserta keterangan:

| Gambar | Keterangan | Yang Perlu Di-*screenshot* |
|--------|-----------|---------------------------|
| 4.17 | Daftar dependensi proyek | File `composer.json` — bagian daftar library yang digunakan |
| 4.18 | Layout modern dengan Tailwind dan Alpine.js | File layout `modern.blade.php` — bagian pemanggilan CSS dan JavaScript |
| 4.19 | Struktur direktori utama proyek | Tampilan folder proyek di VS Code |
| 4.20 | Daftar file migrasi database | Isi folder `database/migrations/` — 18 file migrasi |
| 4.21 | Struktur tabel kehadiran | Kode migrasi tabel `attendances` — kolom status, koordinat, dan QR Code |
| 4.22 | Struktur tabel nilai | Kode migrasi tabel `grades` — kolom komponen nilai dan batasan unik |
| 4.23 | Model kehadiran dan relasi polymorphic | File model `Attendance` — relasi dan fungsi bantu |
| 4.24 | Daftar seeder data awal | File `DatabaseSeeder` — daftar seeder yang dipanggil |
| 4.25 | Proses login dan pengarahan berdasarkan role | Kode autentikasi — verifikasi login dan redirect |
| 4.26 | Middleware pengecekan hak akses | Kode middleware — logika pengecekan role |
| 4.27 | Pembuatan QR Code terenkripsi (admin) | Kode pembuatan QR — proses enkripsi dan generate gambar |
| 4.28 | Pembuatan QR Code melalui kiosk | Kode pembuatan QR kiosk — masa berlaku 1 menit |
| 4.29 | Proses pemindaian dan validasi QR Code | Kode scan QR — dekripsi, validasi, dan penentuan status |
| 4.30 | Validasi lokasi dengan formula Haversine | Kode validasi jarak — formula Haversine dan radius 100m |
| 4.31 | Penghitungan nilai akhir siswa | Kode penyimpanan nilai — formula (Harian×0,3 + UTS×0,3 + UAS×0,4) |
| 4.32 | Data statistik dashboard admin | Kode dashboard — query data statistik |
| 4.33 | Format export Excel | Kode class export — pengaturan kolom dan styling |
| 4.34 | Logika pemilihan format export | Kode export laporan — percabangan Excel atau PDF |
| 4.35 | Halaman pengaturan sistem | Kode pengaturan — 5 kategori setting |
| 4.36 | Penyusunan matriks keputusan SAW | Kode Service SAW — pemetaan data ke kriteria C1–C4 / K1–K4 |
| 4.37 | Normalisasi matriks SAW | Kode Service SAW — rumus normalisasi benefit dan cost |
| 4.38 | Perhitungan nilai preferensi dan ranking | Kode Service SAW — perkalian bobot, penjumlahan, pengurutan |
| 4.39 | Transparansi detail perhitungan SAW | Kode Service SAW — data matriks, normalisasi, dan skor yang ditampilkan |
| 4.40 | Perhitungan SAW siswa melalui controller | Kode controller SAW — pengambilan data dan penyimpanan hasil |
| 4.41 | Pengelompokan route berdasarkan hak akses | File konfigurasi route — pengelompokan berdasarkan role |
