# Slide Presentasi — Metode Prototype

Berikut adalah susunan slide presentasi yang menjelaskan penerapan metode Prototype pada pengembangan Sistem Informasi Absensi Guru Menggunakan QR Code dan Penilaian Siswa Berbasis Web dengan Metode SAW di SMPN 4 Purwakarta.

---

## Slide 1 — Cover

**Judul:** Penerapan Metode Prototype pada Pengembangan Sistem Informasi Absensi Guru & Penilaian Siswa

**Isi:**
- Judul lengkap skripsi
- Nama: Muhammad Rifky Akbar
- Program Studi & Universitas
- Logo UNSIKA & logo SMPN 4 Purwakarta

**Gambar:** Logo kampus, logo sekolah

---

## Slide 2 — Model Prototype (Overview)

**Judul:** Metode Prototype

**Isi:**
- Tampilkan diagram Model Prototype 7 tahap (gambar yang sama dengan di skripsi)
- Penjelasan singkat: "Metode yang melibatkan pengguna secara aktif di setiap tahap pengembangan melalui evaluasi dan iterasi berulang"
- Sebutkan 7 tahap: Pengumpulan Kebutuhan → Membangun Prototyping → Evaluasi Prototyping → Mengkodekan Sistem → Menguji Sistem → Evaluasi Sistem → Menggunakan Sistem

**Gambar:** Diagram Model Prototype (7 langkah dengan panah iterasi)

---

## Slide 3 — Pengumpulan Kebutuhan

**Judul:** Tahap 1 — Pengumpulan Kebutuhan

**Isi:**
- Teknik yang digunakan: wawancara dengan Kepala Sekolah & guru, observasi langsung proses absensi manual dan penilaian di SMPN 4 Purwakarta
- Permasalahan yang ditemukan:
  - Absensi masih menggunakan buku fisik, 32–40% guru tidak mengisi
  - Rekapitulasi absensi membutuhkan 2–3 hari kerja
  - Penilaian siswa manual pakai Excel, membutuhkan 1–2 minggu per semester
  - Tidak ada standar pembobotan kriteria (hanya rata-rata nilai)
- Kebutuhan yang teridentifikasi: 13 use case, 3 aktor (Admin, Guru, Kepala Sekolah)

**Gambar:** Use Case Diagram (13 use case, 3 aktor)

---

## Slide 4 — Membangun Prototyping

**Judul:** Tahap 2 — Membangun Prototyping

**Isi:**
- Merancang desain awal sistem berdasarkan kebutuhan yang sudah dikumpulkan
- Yang dibuat pada tahap ini:
  - Perancangan database (ERD & LDM, 18 tabel)
  - Perancangan alur proses (Activity Diagram untuk setiap use case)
  - Perancangan interaksi (Sequence Diagram)
  - Perancangan algoritma SAW (Flowchart perhitungan)
  - Mockup tampilan antarmuka (halaman login, dashboard, form absensi, form nilai)
- Prototype ini yang nantinya ditunjukkan ke pihak sekolah untuk dievaluasi

**Gambar:** ERD Sistem atau salah satu mockup tampilan antarmuka (pilih yang paling mudah dipahami)

---

## Slide 5 — Evaluasi Prototyping

**Judul:** Tahap 3 — Evaluasi Prototyping

**Isi:**
- Prototype didemonstrasikan kepada 26 evaluator (1 Kepala Sekolah, 24 Guru, 1 Staf TU)
- Metode: walkthrough demonstration + kuesioner Google Form (18 indikator, skala Likert 1–5)
- Hasil evaluasi:
  - Skor rata-rata: **4,50 / 5,00 (90,00%) — Sangat Baik**
  - Tertinggi: Struktur Basis Data (95,20%)
  - Terendah: Desain Antarmuka (86,27%)
- 6 masukan dari evaluator yang seluruhnya diakomodasi:
  - Filter bulan/tahun di dashboard
  - Tampilan detail perhitungan SAW
  - Scanner QR responsif untuk HP
  - Form nilai pre-filled
  - dll.

**Gambar:** Tabel/grafik hasil evaluasi prototype (chart batang skor per aspek)

---

## Slide 6 — Mengkodekan Sistem

**Judul:** Tahap 4 — Mengkodekan Sistem

**Isi:**
- Teknologi yang digunakan:
  - Backend: Laravel 12, PHP ≥ 8.2
  - Frontend: Tailwind CSS 4, Vite 5.4
  - Database: MySQL (18 tabel)
  - QR Code: Enkripsi AES-256-CBC, masa berlaku 600 detik
  - Geolokasi: Formula Haversine, radius 100 meter
  - SAW: 4 kriteria penilaian siswa (C1–C4), 4 kriteria guru (K1–K4)
- Seluruh masukan dari tahap evaluasi prototype telah diimplementasikan

**Gambar:** Screenshot tampilan sistem yang sudah jadi (pilih 2–3):
  1. Halaman login
  2. Dashboard admin/kepala sekolah
  3. Halaman scan QR Code

---

## Slide 7 — Menguji Sistem

**Judul:** Tahap 5 — Menguji Sistem

**Isi:**
- **Black Box Testing:**
  - 58 skenario pengujian pada 10 modul
  - Hasil: **58/58 berhasil (100%)**
- **White Box Testing (Basis Path):**
  - 3 method kritis diuji: scanQR(), checkIn(), normalizeMatrix()
  - Total 19 jalur independen, **seluruhnya berhasil (100%)**
- Verifikasi akurasi:
  - Perhitungan SAW: identik dengan perhitungan manual hingga 4 digit desimal
  - Formula Haversine: deviasi < 1 meter

**Gambar:** Tabel ringkasan hasil pengujian (tabel Black Box: 10 modul, jumlah skenario, status) atau grafik 100% pass rate

---

## Slide 8 — Evaluasi Sistem

**Judul:** Tahap 6 — Evaluasi Sistem (UAT)

**Isi:**
- User Acceptance Testing oleh 34 responden (1 Kepala Sekolah, 32 Guru, 1 Staf TU)
- 10 pertanyaan, skala Likert 1–5, via Google Form
- Hasil:
  - Skor rata-rata: **4,46 / 5,00 (89,29%) — Sangat Baik**
  - Tertinggi: Keandalan (91,18%)
  - Terendah: Tampilan Antarmuka (86,47%)
  - **0% responden** memberi skor di bawah 4
  - Pertanyaan "Layak digunakan rutin": rata-rata **4,62**
- 5 perbaikan akhir berdasarkan feedback UAT:
  - Tooltip bantuan, lazy loading, touch targets 44×44px, dialog konfirmasi, perbaikan font/kontras

**Gambar:** Grafik batang skor per aspek UAT (Fungsionalitas, Kemudahan, Kecepatan, Tampilan, Keandalan) atau pie chart distribusi jawaban (46,47% skor 5, 53,53% skor 4)

---

## Slide 9 — Menggunakan Sistem

**Judul:** Tahap 7 — Menggunakan Sistem

**Isi:**
- Deployment ke server (Apache/Nginx, PHP ≥ 8.2, MySQL, HTTPS wajib untuk kamera & GPS)
- Strategi implementasi bertahap:
  - Minggu 1: Paralel (digital + manual berjalan bersamaan)
  - Minggu 2: Transisi (manual hanya sebagai backup)
  - Minggu 3+: Full digital
- Pelatihan hands-on untuk semua pengguna (Admin, Guru, Kepala Sekolah)
- Disertai buku panduan pengguna lengkap dengan screenshot
- Hasil implementasi:
  - Waktu absensi: ~2 menit → ~10 detik
  - Rekapitulasi bulanan: 2–3 hari → instan
  - Monitoring kehadiran: real-time oleh Kepala Sekolah
  - 0 bug kritis selama masa implementasi

**Gambar:** Screenshot sistem saat digunakan (dashboard live / halaman rekap absensi) atau foto pelatihan (jika ada)

---

## Slide 10 — Penutup

**Judul:** Kesimpulan

**Isi:**
- Metode Prototype berhasil diterapkan dalam 7 tahap pengembangan
- Keterlibatan pengguna di setiap tahap menghasilkan sistem yang sesuai kebutuhan
- Iterasi evaluasi → perbaikan memastikan kualitas akhir yang tinggi
- Skor evaluasi prototype: **90,00%** (Sangat Baik)
- Skor UAT: **89,29%** (Sangat Baik)
- Pengujian teknis: **100%** lulus (Black Box & White Box)
- Terima kasih

**Gambar:** Diagram Model Prototype kecil di pojok sebagai pengingat, atau ringkasan angka-angka penting dalam bentuk infografis sederhana
