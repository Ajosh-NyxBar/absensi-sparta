# Justifikasi Pemilihan Teknologi

## Sistem Informasi Absensi Guru & Penilaian Siswa — SMPN 4 Purwakarta

---

## 1. Justifikasi Framework: Laravel 12

### 1.1 Mengapa Laravel?

| Kriteria | Laravel | CodeIgniter 4 | Django (Python) | Express.js (Node) |
|----------|---------|---------------|-----------------|-------------------|
| **Arsitektur** | MVC lengkap | MVC | MVT | Minimalis (perlu setup manual) |
| **ORM** | Eloquent (built-in, relations, migration) | Built-in basic | Django ORM | Tidak ada (perlu Sequelize/Prisma) |
| **Autentikasi** | Built-in (Auth, session, guards) | Shield (add-on) | Built-in | Passport.js (add-on) |
| **Template Engine** | Blade (inheritance, component) | PHP native | Jinja2 | EJS/Pug (basic) |
| **Migration** | Artisan migrate (version control DB) | Spark migrate | manage.py migrate | Knex/Sequelize migration |
| **Validasi** | FormRequest + 60+ rules | Validasi basic | Django Forms | express-validator (add-on) |
| **Ekosistem Indonesia** | Sangat besar | Besar | Kecil | Sedang |
| **Learning Curve** | Sedang | Rendah | Sedang-Tinggi | Rendah |
| **Dokumentasi** | Lengkap & terstruktur | Cukup | Lengkap | Fragmentasi |
| **Community** | 77k+ GitHub stars | 4.5k+ | 79k+ | 65k+ |

### 1.2 Alasan Pemilihan

1. **Fitur bawaan lengkap** — Autentikasi, session management, CSRF protection, Eloquent ORM, migration, seeder, dan artisan CLI sudah tersedia tanpa perlu library tambahan. Ini mempercepat pengembangan dan mengurangi risiko keamanan dari third-party library.

2. **Eloquent ORM dengan Polymorphic Relationship** — Fitur ini krusial untuk tabel `attendances` yang menyimpan kehadiran guru DAN siswa dalam satu tabel. Tanpa polymorphic relationship, dibutuhkan dua tabel terpisah yang berisi kolom identik.

3. **Blade Template Engine** — Mendukung template inheritance (`@extends`, `@section`, `@yield`) dan component (`@component`, `<x-component>`) yang memudahkan pembuatan layout konsisten di 50+ halaman.

4. **Ekosistem library** — Kompatibel dengan Maatwebsite/Excel (export), DomPDF (PDF), SimpleSoftwareIO/QrCode (QR), yang semuanya tersedia sebagai Composer package dengan dokumentasi lengkap.

5. **Komunitas Indonesia** — Banyak tutorial, forum, dan komunitas Laravel berbahasa Indonesia, memudahkan troubleshooting.

---

## 2. Justifikasi Database: MySQL 8.0

### 2.1 Mengapa MySQL?

| Kriteria | MySQL | PostgreSQL | SQLite | MongoDB |
|----------|-------|------------|--------|---------|
| **Tipe** | RDBMS | RDBMS | File-based RDBMS | NoSQL Document |
| **Relasi** | Foreign Key, JOIN | Lebih advanced | Terbatas | Tidak ada (embed/reference) |
| **Performa (read)** | Sangat baik | Baik | Baik (skala kecil) | Sangat baik |
| **Scalability** | Horizontal (replikasi) | Horizontal | Tidak scalable | Horizontal |
| **Hosting Support** | Sangat luas | Luas | N/A (embedded) | Terbatas |
| **Tool GUI** | phpMyAdmin, Workbench, DBeaver | pgAdmin, DBeaver | DB Browser | MongoDB Compass |
| **Integrasi Laravel** | Default, optimal | Didukung | Didukung | Perlu package tambahan |

### 2.2 Alasan Pemilihan

1. **Default Laravel** — MySQL adalah database default Laravel. Konfigurasi, migration, dan Eloquent ORM dioptimalkan untuk MySQL, mengurangi potensi incompatibility.

2. **Relasi antar tabel** — Sistem memiliki 18 tabel dengan relasi kompleks (foreign key, polymorphic, many-to-many via pivot). RDBMS dengan foreign key constraint menjamin integritas referensial.

3. **Ketersediaan hosting** — Hampir semua shared hosting Indonesia (Niagahoster, IDCloudhost, Domainesia) menyediakan MySQL + phpMyAdmin. Deployment ke lingkungan sekolah menjadi lebih mudah.

4. **Familiar bagi developer** — MySQL adalah database paling populer untuk aplikasi web, mempermudah maintenance oleh tim IT sekolah di masa depan.

5. **Skala yang sesuai** — Dengan ~50 guru, ~500 siswa, dan ~1000 record kehadiran/bulan, MySQL mampu menangani beban ini dengan sangat baik tanpa perlu database enterprise.

---

## 3. Justifikasi Metode SAW (Simple Additive Weighting)

### 3.1 Perbandingan Metode MCDM

| Kriteria | SAW | TOPSIS | AHP | WP (Weighted Product) |
|----------|-----|--------|-----|----------------------|
| **Kompleksitas** | Rendah | Sedang | Tinggi | Rendah |
| **Konsep** | Penjumlahan berbobot | Jarak ke solusi ideal | Perbandingan berpasangan | Perkalian berbobot |
| **Jumlah Langkah** | 4 (matriks → normalisasi → Σ(w×r) → ranking) | 7 (+ solusi ideal & jarak Euclidean) | 8+ (+ consistency ratio) | 4 (× produk berbobot) |
| **Input Tambahan** | Bobot kriteria | Bobot kriteria | Matriks perbandingan berpasangan | Bobot kriteria |
| **Toleransi Error** | Tinggi | Sedang | Rendah (CR < 0.10) | Tinggi |
| **Transparansi** | Sangat mudah dipahami | Sedang | Kompleks | Mudah |
| **Kebutuhan Evaluator** | 1 (admin/kepsek set bobot) | 1 | Minimal 1 expert | 1 |

### 3.2 Alasan Pemilihan SAW

1. **Kesederhanaan konsep** — SAW menggunakan rumus Vi = Σ(wj × rij) yang mudah dipahami oleh stakeholder non-teknis (kepala sekolah, guru). Langkah perhitungan bisa diverifikasi secara manual.

2. **Transparansi penuh** — Sistem menampilkan setiap langkah: matriks keputusan → normalisasi → perhitungan skor → ranking. Kepala sekolah dapat memverifikasi kebenaran perhitungan (berdasarkan feedback evaluasi prototype).

3. **Fleksibilitas bobot** — Admin dapat mengubah bobot kriteria melalui antarmuka web tanpa mengubah kode. Total bobot dinormalisasi otomatis ke 1.0.

4. **Sesuai kebutuhan** — Untuk kasus perankingan dengan 4 kriteria dan puluhan alternatif, SAW sudah lebih dari cukup. Metode yang lebih kompleks (AHP, TOPSIS) tidak memberikan perbedaan signifikan pada hasil tetapi menambah kompleksitas implementasi dan penggunaan.

5. **Studi literatur** — Banyak penelitian terdahulu yang menggunakan SAW untuk penilaian kinerja guru dan ranking siswa dengan hasil yang valid, membuktikan kecocokan metode untuk domain ini.

### 3.3 Formula SAW

**Normalisasi (benefit):**  
$$r_{ij} = \frac{x_{ij}}{\max(x_j)}$$

**Normalisasi (cost):**  
$$r_{ij} = \frac{\min(x_j)}{x_{ij}}$$

**Nilai Preferensi:**  
$$V_i = \sum_{j=1}^{n} w_j \times r_{ij}$$

Dimana:
- $V_i$ = nilai preferensi alternatif ke-i
- $w_j$ = bobot kriteria ke-j
- $r_{ij}$ = nilai normalisasi alternatif ke-i pada kriteria ke-j

---

## 4. Justifikasi QR Code untuk Presensi

### 4.1 Perbandingan Metode Presensi Digital

| Kriteria | QR Code + Geolokasi | Fingerprint | Face Recognition | NFC Card | GPS Only |
|----------|---------------------|-------------|-----------------|----------|----------|
| **Biaya Hardware** | Rp 0 (pakai HP) | Rp 2-5 juta/unit | Rp 3-8 juta/unit | Rp 500rb/reader + kartu | Rp 0 (pakai HP) |
| **Akurasi Identifikasi** | Tinggi (enkripsi + geolokasi) | Sangat tinggi | Tinggi | Tinggi | Rendah (lokasi saja) |
| **Anti Titip Absen** | ✅ (geolokasi + QR dinamis) | ✅ (sidik jari unik) | ✅ (wajah unik) | ❌ (kartu bisa dipinjam) | ❌ (lokasi bisa di-mock) |
| **Kecepatan** | ~10 detik | ~5 detik | ~3 detik | ~2 detik | ~5 detik |
| **Maintenance** | Rendah (software only) | Tinggi (sensor, hygiene) | Tinggi (kalibrasi) | Sedang (kartu hilang) | Rendah |
| **Konektivitas** | WiFi/4G | Lokal | Lokal | Lokal | WiFi/4G |
| **Scalability** | Mudah (tambah monitor) | Perlu unit baru | Perlu unit baru | Perlu reader baru | Mudah |

### 4.2 Alasan Pemilihan QR Code

1. **Biaya nol untuk hardware** — Tidak perlu membeli perangkat tambahan. Guru menggunakan smartphone pribadi untuk scan, sekolah cukup menyediakan monitor/TV untuk menampilkan QR Code.

2. **QR Code dinamis + enkripsi** — QR berubah setiap 10 menit dan dienkripsi AES-256-CBC. Berbeda dengan QR statis yang bisa di-screenshot dan digunakan berulang.

3. **Validasi ganda (dual-factor)** — Kombinasi QR Code (something you scan) + geolokasi (somewhere you are) memberikan keamanan setara fingerprint tanpa biaya hardware.

4. **Mode kiosk** — QR ditampilkan di monitor depan ruang guru (route `/kiosk/`), guru tinggal scan saat masuk. Tidak perlu antri seperti fingerprint scanner.

5. **Sesuai anggaran sekolah** — SMPN 4 Purwakarta sebagai sekolah negeri memiliki anggaran terbatas. Solusi QR Code menghemat Rp 10-50 juta dibanding solusi biometrik.

---

## 5. Justifikasi Frontend: Tailwind CSS 4.0 + Alpine.js

### 5.1 Mengapa Tailwind CSS (bukan Bootstrap)?

| Kriteria | Tailwind CSS 4.0 | Bootstrap 5 | Custom CSS |
|----------|------------------|-------------|------------|
| **Pendekatan** | Utility-first | Component-based | Manual |
| **Customization** | Sangat fleksibel | Terbatas (override CSS) | Unlimited |
| **Bundle Size** | Kecil (JIT, tree-shake) | ~200KB | Bervariasi |
| **Design Consistency** | Design token system | Predefined components | Tidak ada jaminan |
| **Responsive** | Built-in (sm, md, lg, xl, 2xl) | Built-in (sm, md, lg, xl, xxl) | Manual media query |
| **Dark Mode** | Built-in (`dark:`) | Tidak built-in | Manual |
| **Learning Curve** | Sedang (banyak class) | Rendah (komponen siap pakai) | Tinggi |

**Alasan**: Tailwind memberikan kontrol penuh atas desain tanpa overhead CSS yang tidak dipakai. Dengan JIT compiler, hanya class yang digunakan yang di-generate, menghasilkan bundle CSS < 30KB.

### 5.2 Mengapa Alpine.js (bukan React/Vue)?

| Kriteria | Alpine.js | React | Vue.js 3 | jQuery |
|----------|-----------|-------|----------|--------|
| **Ukuran** | ~15KB | ~45KB + ReactDOM ~130KB | ~33KB | ~87KB |
| **Paradigma** | Declarative in HTML | Component (JSX) | Component (SFC) | Imperative |
| **Build Tool** | Tidak perlu | Wajib (Webpack/Vite) | Wajib (Vite) | Tidak perlu |
| **Kurva Belajar** | Sangat rendah | Tinggi | Sedang | Rendah |
| **Integrasi Blade** | Sempurna (inline HTML) | Sulit (perlu API) | Sedang (perlu setup) | Baik |
| **SPA** | Tidak | Ya | Ya | Tidak |

**Alasan**: Alpine.js dirancang untuk menambahkan interaktivitas ringan langsung di HTML, sempurna untuk aplikasi server-rendered (Laravel + Blade). Tidak membutuhkan build step, SPA router, atau state management — cocok untuk fitur seperti dropdown, modal, toggle, live search, dan form validation.

---

## 6. Justifikasi Library Export (Maatwebsite/Excel + DomPDF)

### 6.1 Maatwebsite/Laravel-Excel v3.1

**Alternatif yang dipertimbangkan:**
- PhpSpreadsheet (low-level, perlu banyak konfigurasi manual)
- Laravel Excel by Spatie (lebih baru, fitur lebih terbatas)
- CSV export manual (tidak mendukung formatting)

**Alasan pemilihan:** Maatwebsite/Excel menyediakan abstraksi tingkat tinggi di atas PhpSpreadsheet. Cukup membuat class Export yang implements `FromCollection` dan memanggil `Excel::download()`. Mendukung formatting (header, border, auto-width, number format) dan chunk export untuk data besar.

### 6.2 Barryvdh/Laravel-DomPDF v3.1

**Alternatif yang dipertimbangkan:**
- Snappy (wkhtmltopdf, perlu binary installation)
- TCPDF (lebih fleksibel tapi API kompleks)
- Browser print (CSS @media print)

**Alasan pemilihan:** DomPDF memungkinkan render Blade template langsung ke PDF. Cukup memanggil `Pdf::loadView('template', $data)->download()`. Tidak perlu install binary tambahan, cocok untuk shared hosting.

---

## 7. Justifikasi Metode Pengembangan: Prototype

### 7.1 Perbandingan Metode Pengembangan

| Kriteria | Prototype | Waterfall | Agile (Scrum) | RAD |
|----------|-----------|-----------|---------------|-----|
| **Keterlibatan User** | Sangat tinggi | Rendah (awal saja) | Tinggi | Sedang |
| **Fleksibilitas Perubahan** | Tinggi | Rendah | Sangat tinggi | Sedang |
| **Dokumentasi** | Sedang | Sangat tinggi | Rendah | Rendah |
| **Kecepatan Iterasi** | Cepat | Lambat | Cepat (per sprint) | Cepat |
| **Cocok untuk** | Kebutuhan belum jelas | Kebutuhan sudah fix | Tim besar, project panjang | Prototype + pengembangan cepat |
| **Risiko** | Scope creep | Perubahan mahal | Dokumentasi minim | Over-prototype |

### 7.2 Alasan Pemilihan Prototype

1. **Kebutuhan belum sepenuhnya jelas** — Di awal penelitian, stakeholder (kepala sekolah, guru) belum bisa mendeskripsikan seluruh kebutuhan secara detail. Prototype memungkinkan mereka "melihat dan merasakan" sistem sebelum fitur final ditentukan.

2. **Feedback langsung** — Evaluasi prototype (26 evaluator, rata-rata 4.50/5.00) memberikan masukan konkret sebelum pengkodean penuh. Contoh: transparansi SAW ditambahkan berdasarkan feedback.

3. **Satu developer** — Metode ini cocok untuk peneliti tunggal (skripsi). Agile/Scrum membutuhkan tim. Waterfall terlalu kaku untuk kebutuhan yang berevolusi.

4. **7 tahapan terstruktur** — Memberikan kerangka kerja yang jelas untuk dokumentasi skripsi (setiap tahap = satu sub-bab di BAB IV).

---

## 8. Ringkasan Keputusan Teknologi

| Komponen | Pilihan | Alternatif Terkuat | Alasan Utama |
|----------|---------|-------------------|--------------|
| Framework | Laravel 12 | CodeIgniter 4 | Fitur bawaan lengkap, Eloquent ORM, komunitas Indonesia |
| Database | MySQL 8.0 | PostgreSQL | Default Laravel, hosting luas, familiar |
| Metode SPK | SAW | TOPSIS | Sederhana, transparan, sesuai kebutuhan |
| Presensi | QR Code + Geolokasi | Fingerprint | Biaya Rp 0, dual-factor validation |
| CSS | Tailwind 4.0 | Bootstrap 5 | Utility-first, bundle kecil, customizable |
| JS | Alpine.js | Vue.js 3 | Ringan, inline HTML, cocok Blade |
| Export Excel | Maatwebsite/Excel | PhpSpreadsheet | Abstraksi tinggi, integrasi Laravel |
| Export PDF | DomPDF | Snappy | Render Blade, tanpa binary |
| Metode Dev | Prototype | Waterfall | Kebutuhan berevolusi, feedback langsung |
