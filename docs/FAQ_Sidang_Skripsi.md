# FAQ Sidang Skripsi — Pertanyaan Penguji & Jawaban

## Sistem Informasi Absensi Guru Menggunakan QR Code dan Penilaian Siswa Berbasis Web dengan Metode SAW di SMPN 4 Purwakarta

---

> **Panduan**: Dokumen ini berisi pertanyaan-pertanyaan yang **kemungkinan besar ditanyakan penguji** saat sidang skripsi, beserta jawaban yang sudah disiapkan. Dikelompokkan berdasarkan topik.

---

## A. PERTANYAAN UMUM

### A1. Apa masalah utama yang diselesaikan oleh sistem ini?

**Jawaban:**  
Sistem ini menyelesaikan **dua masalah utama** di SMPN 4 Purwakarta:

1. **Presensi guru yang masih manual** — Sebelumnya guru menandatangani buku kehadiran yang rentan pemalsuan (titip tanda tangan) dan menyulitkan rekapitulasi (2-3 hari untuk rekap bulanan). Sistem ini menggantinya dengan QR Code dinamis terenkripsi (AES-256-CBC) + validasi geolokasi Haversine, mengurangi waktu presensi dari ±2 menit menjadi ±10 detik per guru.

2. **Penilaian siswa dan guru yang belum terstandarisasi** — Belum ada mekanisme objektif untuk meranking kinerja guru dan prestasi siswa. Sistem menerapkan metode SAW (Simple Additive Weighting) dengan 4 kriteria untuk siswa (akademik 35%, kehadiran 25%, sikap 20%, keterampilan 20%) dan 4 kriteria untuk guru (kehadiran 30%, kualitas mengajar 30%, prestasi siswa 25%, kedisiplinan 15%).

---

### A2. Mengapa QR Code, bukan fingerprint atau face recognition?

**Jawaban:**  
QR Code dipilih berdasarkan analisis 4 aspek:

| Aspek | QR Code + Geolokasi | Fingerprint | Face Recognition |
|-------|---------------------|-------------|-----------------|
| Biaya hardware | **Rp 0** (pakai HP guru) | Rp 3-5 juta/unit | Rp 5-8 juta/unit |
| Anti titip absen | ✅ (QR dinamis + GPS) | ✅ (biometrik) | ✅ (biometrik) |
| Maintenance | Rendah (software) | Tinggi (sensor, hygiene) | Tinggi (kalibrasi) |
| Skalabilitas | Mudah (tambah monitor) | Perlu unit baru | Perlu unit baru |

Kombinasi QR Code dinamis (berubah tiap 10 menit, terenkripsi AES-256-CBC) + validasi geolokasi Haversine (radius 100m) memberikan keamanan **setara fingerprint** tanpa biaya hardware, sesuai dengan anggaran sekolah negeri.

---

### A3. Apa kontribusi/kebaruan penelitian ini dibanding penelitian terdahulu?

**Jawaban:**  
Terdapat **3 kontribusi utama**:

1. **Integrasi presensi QR Code dan penilaian SAW dalam satu platform** — Penelitian terdahulu umumnya membahas keduanya secara terpisah. Integrasi ini memungkinkan data kehadiran otomatis menjadi input kriteria SAW.

2. **QR Code dinamis terenkripsi + geolokasi** — Sistem terdahulu umumnya menggunakan QR statis (bisa di-screenshot). Sistem ini menggunakan AES-256-CBC dengan expiry 600 detik + validasi Haversine 100m, memberikan dual-factor verification.

3. **Mode Kiosk** — Inovasi fitur dimana monitor di depan ruang guru menampilkan daftar guru dengan QR Code masing-masing tanpa perlu login, memudahkan proses presensi harian.

---

### A4. Siapa saja pengguna sistem dan apa hak aksesnya?

**Jawaban:**  
Terdapat **4 role pengguna** dengan RBAC (Role-Based Access Control):

| Role | Hak Akses |
|------|-----------|
| **Admin** | Full access: kelola semua data (guru, siswa, kelas, mapel), laporan, pengaturan, kriteria SAW |
| **Guru** | Presensi via QR + geolokasi, input nilai siswa, lihat kelas sendiri, lihat riwayat kehadiran |
| **Kepala Sekolah** | Monitoring presensi, mengakses perhitungan SAW siswa & guru, melihat rapor siswa |
| **Kiosk Presensi** | Menampilkan dashboard kiosk dengan daftar guru dan QR Code |

---

## B. PERTANYAAN TENTANG METODE PENGEMBANGAN

### B1. Mengapa menggunakan metode Prototype, bukan Waterfall atau Agile?

**Jawaban:**  
Metode Prototype dipilih karena **3 alasan** spesifik:

1. **Kebutuhan belum sepenuhnya jelas** — Kepala sekolah dan guru belum bisa mendeskripsikan seluruh kebutuhan secara detail di awal. Prototype memungkinkan mereka "melihat" sistem sebelum fitur final ditentukan.

2. **Feedback langsung** — Evaluasi prototype oleh 26 evaluator (rata-rata 4.50/5.00) memberikan masukan konkret. Contoh: fitur transparansi langkah SAW ditambahkan berdasarkan feedback kepala sekolah.

3. **Satu developer** — Metode ini cocok untuk peneliti tunggal. Agile/Scrum membutuhkan tim minimal 3-5 orang. Waterfall terlalu kaku jika ada perubahan kebutuhan.

Metode Prototype terdiri dari **7 tahapan**: (1) Mendengarkan Pelanggan, (2) Merancang & Membuat Prototype, (3) Evaluasi Prototype, (4) Mengkodekan Sistem, (5) Menguji Sistem, (6) Evaluasi Sistem, (7) Menggunakan Sistem.

---

### B2. Bagaimana tahap mendengarkan pelanggan dilakukan?

**Jawaban:**  
Dilakukan melalui **wawancara semi-terstruktur** dengan 4 narasumber:
- 1 Kepala Sekolah SMPN 4 Purwakarta
- 3 Guru (perwakilan dari 24 guru)

Pertanyaan mencakup: proses presensi saat ini, kendala yang dihadapi, harapan terhadap sistem baru, kriteria penilaian yang diinginkan, dan mekanisme pelaporan yang dibutuhkan.

Hasil wawancara ditranskrip dan dianalisis untuk mengidentifikasi kebutuhan fungsional dan non-fungsional sebagai dasar perancangan prototype.

---

### B3. Berapa iterasi prototype yang dilakukan sebelum pengkodean?

**Jawaban:**  
Dilakukan **1 iterasi prototype** dengan evaluasi oleh 26 evaluator. Rata-rata skor evaluasi 4.50/5.00 (kategori "Sangat Baik") di semua aspek, sehingga prototype disetujui untuk dilanjutkan ke tahap pengkodean tanpa perlu iterasi ulang.

Masukan dari evaluasi yang diimplementasikan:
- Transparansi langkah perhitungan SAW → ditambahkan method `getCalculationDetails()`
- Fitur export laporan → ditambahkan modul Reports (Excel + PDF)
- Notifikasi kehadiran → ditambahkan NotificationService

---

## C. PERTANYAAN TENTANG METODE SAW

### C1. Jelaskan rumus SAW dan langkah-langkahnya!

**Jawaban:**  
SAW (Simple Additive Weighting) memiliki **4 langkah utama**:

**Langkah 1 — Matriks Keputusan (X):**  
Menyusun nilai setiap alternatif (siswa/guru) pada setiap kriteria ke dalam tabel.

**Langkah 2 — Normalisasi:**  
- Benefit: $r_{ij} = x_{ij} / \max(x_j)$ (semakin tinggi semakin baik)
- Cost: $r_{ij} = \min(x_j) / x_{ij}$ (semakin rendah semakin baik)

**Langkah 3 — Nilai Preferensi (Vi):**  
$V_i = \sum_{j=1}^{n} w_j \times r_{ij}$

**Langkah 4 — Ranking:**  
Urutkan Vi dari tertinggi ke terendah. Vi tertinggi = ranking 1.

---

### C2. Mengapa semua kriteria bertipe benefit? Tidak ada yang cost?

**Jawaban:**  
Ya, seluruh 8 kriteria (C1-C4 siswa, K1-K4 guru) bertipe **benefit** karena:

- **Nilai akademik (C1)**: Semakin tinggi semakin baik ✅
- **Kehadiran (C2, K1)**: Semakin tinggi persentase hadir semakin baik ✅
- **Sikap/perilaku (C3)**: Semakin tinggi semakin baik ✅
- **Keterampilan (C4)**: Semakin tinggi semakin baik ✅
- **Kualitas mengajar (K2)**: Semakin tinggi semakin baik ✅
- **Prestasi siswa (K3)**: Semakin tinggi semakin baik ✅
- **Kedisiplinan (K4)**: Semakin tinggi semakin baik ✅

Tidak ada kriteria yang "semakin rendah semakin baik" (cost) dalam konteks penilaian kinerja ini. Namun, **sistem mendukung kriteria cost** — jika admin menambah kriteria baru bertipe cost (misal "jumlah keterlambatan"), normalisasi cost akan otomatis diterapkan.

---

### C3. Bagaimana jika bobot total tidak sama dengan 1? Apa yang terjadi?

**Jawaban:**  
Admin dapat menormalisasi bobot melalui fitur **POST /criteria/normalize**. Method `normalizeWeights()` di CriteriaController membagi setiap bobot dengan total bobot sehingga hasilnya tepat 1.0.

Contoh: Jika admin mengatur C1=35, C2=25, C3=20, C4=20 (total 100), setelah normalize: C1=0.35, C2=0.25, C3=0.20, C4=0.20 (total 1.00).

---

### C4. Bagaimana menangani kasus jika semua nilai pada satu kriteria = 0?

**Jawaban:**  
Ini merupakan **edge case division by zero** yang sudah ditangani di method `normalizeMatrix()`:

```php
if ($maxValue > 0) {
    // Normalisasi normal: xij / max
    $normalized[$index][$code] = $row[$code] / $maxValue;
} else {
    // Jika max = 0, set normalisasi = 0 (bukan error)
    $normalized[$index][$code] = 0;
}
```

Jika semua nilai pada satu kriteria adalah 0, seluruh nilai normalisasi pada kriteria tersebut menjadi 0. Ini berarti kriteria tersebut tidak berkontribusi pada nilai preferensi — sebuah hasil yang logis karena tidak ada pembeda antar alternatif.

---

### C5. Mengapa SAW, bukan TOPSIS atau AHP?

**Jawaban:**  

| Aspek | SAW | TOPSIS | AHP |
|-------|-----|--------|-----|
| Jumlah langkah | 4 | 7 | 8+ |
| Transparansi | Sangat mudah dipahami non-teknis | Sedang (konsep solusi ideal) | Rendah (matriks perbandingan) |
| Input tambahan | Bobot saja | Bobot saja | Matriks perbandingan berpasangan |
| Consistency check | Tidak perlu | Tidak perlu | Perlu (CR < 0.10) |

SAW dipilih karena: **(1)** Langkah perhitungan bisa ditampilkan ke kepala sekolah dan diverifikasi manual; **(2)** Jumlah kriteria (4 per kelompok) dan alternatif (puluhan) sesuai untuk SAW; **(3)** Tidak ada kriteria yang saling konflik yang membutuhkan TOPSIS; **(4)** AHP terlalu kompleks untuk kebutuhan ini dan memerlukan matriks perbandingan berpasangan yang sulit di-interface ke web.

---

## D. PERTANYAAN TENTANG KEAMANAN

### D1. Bagaimana mencegah guru titip absen (fake attendance)?

**Jawaban:**  
Sistem menerapkan **3 lapis pencegahan**:

1. **QR Code dinamis** — QR berubah setiap 10 menit dan dienkripsi AES-256-CBC. Tidak bisa di-screenshot dan digunakan berulang (expire 600 detik).

2. **Validasi geolokasi** — GPS browser guru divalidasi menggunakan Haversine Formula. Jarak ke sekolah harus ≤100 meter. Koordinat lat/lng disimpan di database untuk audit trail.

3. **Enkripsi payload** — Payload QR dienkripsi dengan APP_KEY unik. Tanpa key, payload tidak bisa di-forge.

Kombinasi tiga lapis ini membuat pemalsuan presensi sangat sulit: guru harus (1) secara fisik berada di sekolah, (2) memindai QR yang valid, (3) dalam waktu 10 menit setelah QR di-generate.

---

### D2. Bagaimana jika APP_KEY bocor?

**Jawaban:**  
Jika APP_KEY bocor:
- QR Code bisa di-forge (dibuat sendiri tanpa melalui sistem)
- Langkah mitigasi: **generate key baru** dengan `php artisan key:generate` → semua QR lama otomatis invalid
- APP_KEY disimpan di file `.env` yang **tidak di-commit ke Git** (ada di `.gitignore`)
- Di production, file `.env` harus memiliki permission ketat (600/640)

---

### D3. Bagaimana proteksi terhadap SQL Injection?

**Jawaban:**  
3 mekanisme proteksi:

1. **Eloquent ORM** — Semua query menggunakan parameterized statement secara otomatis. Tidak ada raw SQL yang menerima input user langsung.

2. **Input validation** — `$request->validate()` memastikan tipe dan format data sebelum masuk ke query.

3. **Mass assignment protection** — Model mendefinisikan `$fillable` sehingga hanya kolom yang diizinkan yang bisa di-update.

---

### D4. Apa proteksi terhadap CSRF?

**Jawaban:**  
- Setiap form POST/PUT/DELETE menyertakan `@csrf` directive yang meng-generate hidden input berisi CSRF token unik per session
- Middleware `VerifyCsrfToken` memvalidasi token sebelum request diproses
- Request tanpa token valid → HTTP 419 (Page Expired)
- Untuk AJAX request, token dikirim melalui header `X-CSRF-TOKEN` yang diambil dari meta tag

---

## E. PERTANYAAN TENTANG DATABASE

### E1. Mengapa menggunakan Polymorphic Relationship untuk attendance?

**Jawaban:**  
Tabel `attendances` menyimpan kehadiran **guru DAN siswa** dalam satu tabel menggunakan polymorphic relationship:

- `attendable_type` = model class (`App\Models\Teacher` atau `App\Models\Student`)
- `attendable_id` = primary key dari model terkait

**Alasan:**
1. Menghindari duplikasi tabel — tanpa polymorphic, perlu 2 tabel dengan kolom identik (`teacher_attendances` + `student_attendances`)
2. Memudahkan query lintas tipe — bisa aggregate kehadiran guru + siswa sekaligus
3. Satu migration, satu model — maintenance lebih sederhana

---

### E2. Apakah database sudah dinormalisasi? Sampai normal form berapa?

**Jawaban:**  
Seluruh **18 tabel** sudah memenuhi **3NF (Third Normal Form)**:

- **1NF**: Semua kolom bernilai atomik. Contoh: relasi guru-mapel menggunakan tabel pivot `teacher_subjects`, bukan kolom "subjects_taught" berisi list.
- **2NF**: Tidak ada partial dependency. Semua tabel menggunakan single-column PK (autoincrement `id`).
- **3NF**: Tidak ada transitive dependency. Contoh: data role disimpan di tabel `roles`, bukan langsung di tabel `users`.

*(Detail lengkap tersedia di dokumen Normalisasi_Database.md)*

---

### E3. Berapa tabel yang ada dan apa relasi utamanya?

**Jawaban:**  
**18 tabel** dengan relasi utama:
- `roles` → `users` (1:N)
- `users` → `teachers` (1:1)
- `classes` → `students` (1:N)
- `teachers` ↔ `subjects` via `teacher_subjects` (N:N)
- `teachers`/`students` → `attendances` (polymorphic 1:N)
- `students` → `grades` (1:N) via `subjects` + `teachers`
- `students` → `student_assessments` (1:N) — hasil SAW
- `teachers` → `teacher_assessments` (1:N) — hasil SAW

---

## F. PERTANYAAN TENTANG TEKNOLOGI

### F1. Mengapa Laravel, bukan CodeIgniter atau Django?

**Jawaban:**  
3 alasan utama:
1. **Fitur bawaan lengkap** — Auth, CSRF, Eloquent ORM (polymorphic), migration, seeder sudah built-in
2. **Eloquent Polymorphic Relationship** — Krusial untuk tabel attendances yang multi-tipe. CodeIgniter tidak mendukung ini secara native
3. **Ekosistem library** — Maatwebsite/Excel, DomPDF, SimpleQrCode terintegrasi sempurna via Composer

---

### F2. Mengapa MySQL, bukan PostgreSQL atau MongoDB?

**Jawaban:**  
1. **Default Laravel** — MySQL dioptimalkan dalam konfigurasi dan Eloquent
2. **Hosting tersedia luas** — Hampir semua shared hosting Indonesia menyediakan MySQL + phpMyAdmin
3. **Relasi kompleks** — 18 tabel dengan FK constraint cocok untuk RDBMS (bukan NoSQL)
4. **Familiar** — Tim IT sekolah lebih mengenal MySQL untuk maintenance ke depan

---

### F3. Kenapa pakai Tailwind CSS, bukan Bootstrap?

**Jawaban:**  
- **Customizable penuh** tanpa override CSS — setiap elemen bisa di-style presisi
- **Bundle size kecil** (~30KB vs Bootstrap ~200KB) karena JIT hanya compile class yang dipakai
- **Responsive built-in** dengan prefix `sm:`, `md:`, `lg:`, `xl:`
- **Integrasi baik dengan Alpine.js** — keduanya memiliki filosofi "declarative in HTML"

---

## G. PERTANYAAN TENTANG PENGUJIAN

### G1. Berapa skenario yang diuji dan bagaimana hasilnya?

**Jawaban:**  
| Metode | Skenario/Responden | Hasil |
|--------|-------------------|-------|
| Black Box Testing | 58 skenario | 58/58 berhasil (**100%**) |
| White Box Testing | 5 method kritis | Seluruh jalur basis path tercakup |
| UAT | 32 responden, 10 pertanyaan | **4.46/5.00 (89.29%)** — Sangat Baik |
| Evaluasi Prototype | 26 evaluator, 5 aspek | **4.50/5.00** — Sangat Baik |

---

### G2. Apa perbedaan Black Box dan White Box Testing yang dilakukan?

**Jawaban:**  

**Black Box Testing:** Menguji fungsionalitas dari perspektif pengguna. Skenario berbentuk "input X → harapan Y → cek hasil". Contoh: "Login dengan email valid dan password benar → redirect ke dashboard".

**White Box Testing:** Menguji alur logika internal menggunakan Basis Path Testing. Menghitung cyclomatic complexity dan memastikan setiap jalur keputusan (if/else) tercakup. Contoh: method `scanQR()` memiliki 5 jalur: sukses check-in, sukses check-out, QR expired, lokasi luar radius, QR invalid.

---

### G3. Bagaimana menghitung rata-rata UAT dan bagaimana kategorinya?

**Jawaban:**  
- Total 32 responden × 10 pertanyaan = 320 respons
- Setiap respons menggunakan skala Likert 1–5
- Rata-rata per aspek dihitung: (Σ semua skor per aspek) / jumlah respons
- Rata-rata total: 4.46 / 5.00 = 89.29%
- Interpretasi: 4.21–5.00 = **Sangat Baik** (berdasarkan skala interpretasi Likert 5 kategori)

---

## H. PERTANYAAN TEKNIS MENDALAM

### H1. Bagaimana alur lengkap presensi dari scan sampai tersimpan di database?

**Jawaban:**
1. Kiosk/Admin generate QR → `Crypt::encryptString(JSON payload)` → QR di-render di layar
2. Guru buka `/scan-presensi` → browser minta izin kamera + GPS
3. Guru scan QR → JavaScript extract QR data + `navigator.geolocation.getCurrentPosition()`
4. POST `/kiosk/api/scan` dengan body: `{ qr_data, latitude, longitude }`
5. Server: `Crypt::decryptString(qr_data)` → parse JSON
6. Server: Cek `timestamp` → jika `now() - timestamp > 600` → tolak (QR expired)
7. Server: Haversine(`guru_lat`, `guru_lng`, `school_lat`, `school_lng`) → jika `distance > 100m` → tolak
8. Server: Cek apakah sudah ada record attendance hari ini untuk teacher_id:
   - Belum ada → buat record baru (check_in = now, status = 'hadir')
   - Sudah ada (belum check_out) → update check_out = now
9. Response JSON → browser guru menampilkan notifikasi sukses
10. NotificationService → kirim notifikasi ke admin

---

### H2. Bagaimana Haversine Formula bekerja dan kenapa akurat?

**Jawaban:**  
Haversine Formula menghitung jarak antara dua titik pada permukaan bola (bumi) berdasarkan latitude dan longitude:

```
a = sin²(Δlat/2) + cos(lat1) × cos(lat2) × sin²(Δlng/2)
c = 2 × atan2(√a, √(1-a))
d = R × c    (R = 6.371.000 meter = radius bumi)
```

**Kenapa akurat?** Haversine memperhitungkan kelengkungan bumi (great-circle distance), bukan jarak garis lurus. Untuk jarak pendek (≤100m), error < 0.1%. Alternatif Vincenty Formula lebih presisi tapi signifikan hanya untuk jarak ratusan km.

---

### H3. Bagaimana handle concurrent access (banyak guru scan bersamaan)?

**Jawaban:**  
- Laravel menggunakan **single-threaded request handling** per process, didukung oleh web server (Nginx/Apache) yang mengelola multiple process/thread
- Setiap request POST scan mendapat transaksi database sendiri
- **Race condition dicegah** oleh unique constraint: satu guru hanya bisa punya satu attendance per hari → jika dua scan tiba bersamaan, yang kedua akan update check_out
- Untuk skala SMPN 4 Purwakarta (~50 guru), concurrent access bukan masalah signifikan

---

### H4. Method apa saja yang ada di SAWService dan apa fungsinya?

**Jawaban:**
| Method | Akses | Parameter | Fungsi |
|--------|-------|-----------|--------|
| `calculate()` | `public` | `$data (Collection), $type (string)` | Orkestrator utama: panggil semua langkah SAW |
| `buildDecisionMatrix()` | `protected` | `$data, $criteria, $type` | Susun matriks keputusan (baris = alternatif, kolom = kriteria) |
| `normalizeMatrix()` | `protected` | `$matrix, $criteria` | Normalisasi benefit/cost (0–1) |
| `calculateSAWScores()` | `protected` | `$normalizedMatrix, $criteria` | Hitung Vi = Σ(wj × rij), round 4 desimal |
| `rankAlternatives()` | `protected` | `$data, $scores` | Sort descending, assign ranking 1,2,3,... |
| `getCalculationDetails()` | `public` | — | Return seluruh detail langkah untuk transparansi |

---

## I. PERTANYAAN TENTANG KONTRIBUSI & SARAN

### I1. Apa saran pengembangan ke depan?

**Jawaban:**
1. **Progressive Web App (PWA)** — Agar bisa di-install sebagai apps di HP guru tanpa perlu download dari Play Store
2. **Offline mode** — Presensi bisa dilakukan saat internet mati, data di-sync setelah online
3. **WebSocket real-time** — Integrasi Laravel Reverb/Pusher untuk live update dashboard
4. **Presensi siswa QR** — Perluas sistem QR untuk presensi siswa per mata pelajaran
5. **Multi-tenant** — Satu instalasi untuk multiple sekolah dalam satu kecamatan/kabupaten
6. **API RESTful** — Pisahkan backend dan frontend untuk mendukung mobile app native
7. **Integrasi Dapodik** — Sinkronisasi data guru dan siswa dengan database nasional

---

### I2. Apa kelebihan dan kekurangan sistem ini?

**Jawaban:**

**Kelebihan:**
- Integrasi presensi + penilaian SAW dalam satu platform (belum ada di penelitian sebelumnya)
- QR Code dinamis terenkripsi + geolokasi → dual-factor verification
- Mode kiosk inovatif untuk kemudahan di ruang guru
- Biaya implementasi Rp 0 (tanpa hardware tambahan)
- Transparansi perhitungan SAW (langkah dapat dilihat oleh user)
- 4 role pengguna dengan hak akses granular

**Kekurangan:**
- Membutuhkan koneksi internet untuk presensi
- Akurasi GPS bervariasi antar perangkat
- Presensi siswa masih manual (belum QR)
- Belum ada notifikasi real-time (polling, bukan WebSocket)
- Dirancang untuk satu sekolah (single-tenant)

---

### I3. Apakah sistem ini bisa diterapkan di sekolah lain?

**Jawaban:**  
**Ya**, dengan penyesuaian minimal:
1. Ganti koordinat sekolah di pengaturan (`school_latitude`, `school_longitude`)
2. Ganti data sekolah (nama, alamat, NPSN, logo) melalui menu Pengaturan → Profil Sekolah
3. Sesuaikan kriteria SAW (nama, bobot) melalui menu Kriteria
4. Jalankan `php artisan migrate:fresh --seed` untuk reset database
5. Input data guru dan siswa baru

Seluruh konfigurasi dilakukan melalui **antarmuka web** (tidak perlu ubah kode), menjadikan sistem ini **reusable** untuk sekolah SMP/SMA lain.
