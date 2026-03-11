---
marp: true
theme: default
paginate: true
size: 16:9
style: |
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;900&display=swap');

  :root {
    --color-primary: #4361ee;
    --color-secondary: #7c3aed;
    --color-accent: #06d6a0;
    --color-warning: #f59e0b;
    --color-dark: #1a1a2e;
    --color-light: #f8f9fa;
  }

  section {
    font-family: 'Inter', sans-serif;
    color: var(--color-dark);
    font-size: 22px;
    padding: 40px 60px;
    line-height: 1.5;
  }

  h1 {
    color: var(--color-primary);
    font-weight: 800;
    font-size: 1.6em;
    margin-bottom: 0.3em;
  }

  h2 {
    color: var(--color-secondary);
    font-weight: 600;
    font-size: 1.15em;
    margin-bottom: 0.2em;
  }

  h3 {
    color: var(--color-primary);
    font-weight: 600;
    font-size: 1em;
  }

  p, li {
    font-size: 0.95em;
  }

  strong {
    color: var(--color-primary);
  }

  em {
    color: #6b7280;
    font-style: normal;
  }

  a {
    color: var(--color-primary);
  }

  code {
    background: #eef2ff;
    color: var(--color-primary);
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 0.85em;
  }

  table {
    font-size: 0.8em;
    border-collapse: collapse;
    width: 100%;
  }

  th {
    background: var(--color-primary);
    color: white;
    padding: 8px 14px;
    text-align: left;
    font-size: 0.9em;
  }

  td {
    padding: 6px 14px;
    border-bottom: 1px solid #e5e7eb;
  }

  tr:nth-child(even) {
    background: #f8f9fa;
  }

  blockquote {
    border-left: 4px solid var(--color-accent);
    background: #ecfdf5;
    padding: 10px 16px;
    margin: 12px 0;
    border-radius: 0 8px 8px 0;
    font-size: 0.85em;
  }

  ul {
    list-style: none;
    padding-left: 0;
  }

  ul li {
    padding: 3px 0;
    padding-left: 24px;
    position: relative;
    font-size: 0.9em;
  }

  ul li::before {
    content: '✅';
    position: absolute;
    left: 0;
    font-size: 0.85em;
  }

  ol {
    font-size: 0.9em;
  }

  ol li {
    padding: 2px 0;
    margin-left: 8px;
  }

  section.cover {
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #4361ee 0%, #7c3aed 50%, #4361ee 100%) !important;
    color: white !important;
  }

  section.cover h1 {
    color: white;
    font-size: 2em;
    text-shadow: 0 2px 10px rgba(0,0,0,0.2);
  }

  section.cover h2 {
    color: rgba(255,255,255,0.9);
    font-weight: 400;
    font-size: 1.1em;
  }

  section.cover h3 {
    color: rgba(255,255,255,0.85);
    font-weight: 400;
    font-size: 0.9em;
  }

  section.cover p {
    color: rgba(255,255,255,0.8);
    font-size: 0.85em;
  }

  section.cover em {
    color: rgba(255,255,255,0.85);
  }

  section.section-title {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    background: linear-gradient(135deg, #f8f9fa, #eef2ff) !important;
  }

  section.section-title h1 {
    font-size: 2em;
    margin-bottom: 0.1em;
  }

  section.section-title h2 {
    font-weight: 400;
    color: #6b7280;
    font-size: 1em;
  }

  section.tip {
    background: linear-gradient(135deg, #ecfdf5, #f0fdf4);
    border-left: 6px solid var(--color-accent);
  }

  section.warning {
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    border-left: 6px solid var(--color-warning);
  }

  footer {
    color: #9ca3af;
    font-size: 0.6em;
  }
---

<!-- _class: cover -->

# 📚 Modul Pelatihan

## Sistem Absensi Guru & Penilaian Siswa
### SMPN 4 Purwakarta

*Panduan Lengkap Penggunaan Sistem*

---

<!-- _class: section-title -->

# 👋 Selamat Datang!

## Panduan ini akan membantu Anda menggunakan sistem dengan mudah

---

# Apa Itu Sistem Absensi & Penilaian Ini?

Sistem ini adalah **aplikasi berbasis web** yang membantu sekolah dalam:

- Mencatat kehadiran guru secara **otomatis** menggunakan QR Code
- Menginput dan menghitung **nilai siswa** secara digital
- Membuat **laporan kehadiran** dan **ranking siswa** secara cepat
- Memantau **kehadiran guru** secara langsung dari mana saja

> 💡 Anda hanya perlu **browser** (Chrome/Firefox) dan **koneksi internet** untuk mengakses sistem ini. Tidak perlu install aplikasi apapun!

---

# Siapa Saja yang Menggunakan?

| Pengguna | Apa yang Bisa Dilakukan |
|----------|------------------------|
| 👨‍🏫 **Guru** | Absen pakai QR Code, input nilai siswa, lihat rekap kehadiran |
| 👨‍💼 **Kepala Sekolah** | Pantau kehadiran guru, lihat ranking, download laporan |
| 🏫 **Staf TU (Admin)** | Kelola data guru & siswa, buat QR Code, export laporan |

> Setiap pengguna punya **akun sendiri** dengan fitur yang berbeda sesuai tugasnya.

---

<!-- _class: section-title -->

# 🔐 Bagian 1
## Cara Masuk ke Sistem (Login)

---

# Cara Login

1. **Buka browser** di HP atau komputer Anda *(Chrome / Firefox)*

2. **Ketik alamat website** sistem di kolom alamat browser

3. **Masukkan Email** yang sudah didaftarkan oleh admin

4. **Masukkan Password** yang sudah diberikan

5. **Klik tombol "Masuk"**

> 💡 Jika lupa password, hubungi **Staf TU** untuk direset.

---

<!-- _class: tip -->

# 💡 Tips Login

- Gunakan **email yang sama** setiap kali login
- Centang **"Ingat Saya"** agar tidak perlu ketik ulang email lain kali
- Pastikan **huruf besar/kecil** password sudah benar
- Jika muncul pesan *"Email atau password salah"*, coba cek lagi ketikan Anda
- Setiap pengguna akan langsung diarahkan ke **halaman utama** sesuai perannya

---

<!-- _class: section-title -->

# 📱 Bagian 2
## Cara Absen Menggunakan QR Code *(Untuk Guru)*

---

# Apa Itu Absen QR Code?

Absen QR Code adalah cara **modern** untuk mencatat kehadiran guru:

- **Tidak perlu** tanda tangan di buku absensi ❌📖
- **Cukup scan** kode QR menggunakan kamera HP ✅📱
- **Otomatis tercatat** waktu dan lokasi kehadiran Anda
- **Aman** — tidak bisa dititipkan ke orang lain karena ada validasi lokasi

> 🔒 Sistem akan memastikan Anda **benar-benar berada di sekolah** saat melakukan absen melalui GPS di HP Anda.

---

# Langkah-Langkah Absen Masuk

1. **Buka HP** dan pastikan sudah login ke sistem

2. **Klik menu "Absensi Saya"** di halaman utama

3. **Klik tombol "Scan QR Code"**

4. **Izinkan akses kamera** jika HP meminta izin *(klik "Izinkan")*

5. **Arahkan kamera HP** ke layar monitor yang menampilkan QR Code di ruang guru

6. **Izinkan akses lokasi** jika HP meminta izin *(klik "Izinkan")*

7. **Selesai!** ✅ Akan muncul pesan *"Absensi berhasil dicatat"*

---

# Langkah-Langkah Absen Pulang

Caranya **sama persis** dengan absen masuk:

1. **Klik "Scan QR Code"** lagi di menu Absensi
2. **Arahkan kamera** ke QR Code
3. Sistem otomatis mencatat sebagai **absen pulang**

> 💡 Sistem sudah **otomatis membedakan** antara absen masuk dan pulang berdasarkan waktu. Jika Anda sudah absen masuk hari ini, scan berikutnya akan tercatat sebagai absen pulang.

---

<!-- _class: warning -->

# ⚠️ Yang Perlu Diperhatikan Saat Absen

- **Nyalakan GPS** di HP Anda sebelum scan
- **Pastikan berada di area sekolah** — sistem akan menolak jika Anda terlalu jauh
- **Izinkan akses kamera dan lokasi** saat browser meminta
- Jika muncul pesan *"Lokasi tidak valid"*, coba **keluar dan masuk kembali** ke gedung sekolah
- QR Code **berganti secara berkala** untuk keamanan, jadi selalu scan QR yang tampil di layar

---

<!-- _class: section-title -->

# ✏️ Bagian 3
## Cara Input Nilai Siswa *(Untuk Guru)*

---

# Cara Memasukkan Nilai Siswa

1. **Login** ke sistem

2. Klik menu **"Penilaian Siswa"**

3. **Pilih kelas** yang ingin Anda nilai *(contoh: Kelas 7A)*

4. Akan muncul **daftar siswa** beserta kolom-kolom nilai

5. **Isi nilai** di setiap kolom:
   - **Tugas Harian** *(bobot 30%)*
   - **UTS** *(bobot 30%)*
   - **UAS** *(bobot 40%)*

6. **Nilai akhir otomatis dihitung** oleh sistem!

7. Klik **"Simpan"** untuk menyimpan

---

<!-- _class: tip -->

# 💡 Tips Input Nilai

- Nilai harus antara **0 sampai 100**
- Anda bisa **mengedit nilai** yang sudah dimasukkan sebelumnya — data lama akan muncul otomatis
- **Nilai akhir** dihitung otomatis berdasarkan bobot: *Tugas 30% + UTS 30% + UAS 40%*
- Anda bisa input nilai **kapan saja** selama semester berjalan
- Klik tombol **"Simpan"** setiap kali selesai input agar data tidak hilang
- Jika ada informasi bobot, lihat keterangan di **bagian atas halaman**

---

<!-- _class: section-title -->

# 📊 Bagian 4
## Cara Melihat Rekap Kehadiran

---

# Melihat Rekap Kehadiran *(Guru)*

Sebagai guru, Anda bisa melihat **riwayat kehadiran sendiri**:

1. Klik menu **"Rekap Absensi"**
2. Pilih **bulan** yang ingin dilihat
3. Akan tampil tabel kehadiran Anda:

| Tanggal | Masuk | Pulang | Status |
|---------|-------|--------|--------|
| 1 Nov 2025 | 07:15 | 14:30 | ✅ Hadir |
| 2 Nov 2025 | 07:45 | 14:00 | ⚠️ Terlambat |
| 3 Nov 2025 | — | — | ❌ Tidak Hadir |

> 💡 Data ini tercatat **otomatis** dari hasil scan QR Code Anda setiap hari.

---

# Melihat Rekap Kehadiran *(Kepala Sekolah)*

Kepala Sekolah bisa melihat kehadiran **seluruh guru**:

1. Klik menu **"Rekap Absensi"**
2. Pilih **periode** *(bulan/semester)*
3. Akan tampil:
   - **Tabel kehadiran** seluruh guru
   - **Grafik statistik** kehadiran
   - **Persentase kehadiran** setiap guru

> 📊 Dashboard menampilkan data secara **langsung (real-time)** sehingga Anda bisa memantau kehadiran guru kapan saja tanpa menunggu laporan dari TU.

---

<!-- _class: section-title -->

# 🏆 Bagian 5
## Cara Melihat Ranking Siswa (SAW)

---

# Apa Itu Ranking SAW?

**SAW (Simple Additive Weighting)** adalah metode perhitungan untuk menentukan **peringkat siswa** secara **adil dan objektif**.

Berbeda dengan ranking biasa yang hanya lihat nilai rata-rata, SAW mempertimbangkan **beberapa aspek** dengan **bobot berbeda**:

| Aspek Penilaian | Bobot | Artinya |
|----------------|-------|---------|
| 📖 Nilai Akademik | 35% | Rata-rata nilai seluruh mapel |
| 📅 Kehadiran | 25% | Persentase kehadiran siswa |
| 🤝 Sikap/Perilaku | 20% | Penilaian sikap dari guru |
| 🔧 Keterampilan | 20% | Penilaian keterampilan praktik |

> 🎯 Hasilnya lebih **adil** karena tidak hanya berdasarkan nilai ujian saja!

---

# Cara Melihat Ranking

1. Klik menu **"Ranking Siswa"**

2. Pilih **kelas**, **tahun ajaran**, dan **semester**

3. Klik **"Tampilkan Ranking"**

4. Akan muncul tabel peringkat siswa:

| Peringkat | Nama Siswa | Akademik | Kehadiran | Sikap | Keterampilan | Skor Akhir |
|-----------|-----------|----------|-----------|-------|-------------|------------|
| 🥇 1 | Andi | 92 | 95% | 88 | 90 | 0.94 |
| 🥈 2 | Budi | 88 | 100% | 90 | 85 | 0.91 |
| 🥉 3 | Citra | 90 | 90% | 85 | 88 | 0.89 |

> 📋 Anda juga bisa klik **"Detail Perhitungan"** untuk melihat langkah-langkah perhitungan SAW secara transparan.

---

<!-- _class: section-title -->

# 📥 Bagian 6
## Cara Download Laporan *(Kepala Sekolah & Admin)*

---

# Cara Export Laporan

1. Klik menu **"Laporan"**

2. Pilih **jenis laporan**:
   - 📋 Laporan Kehadiran Guru
   - 📊 Laporan Nilai Siswa
   - 🏆 Laporan Ranking Siswa
   - 👨‍🏫 Laporan Ranking Guru

3. Atur **filter**:
   - Pilih kelas *(jika perlu)*
   - Pilih rentang tanggal
   - Pilih semester / tahun ajaran

4. Pilih **format file**:
   - 📗 **Excel** — untuk diolah lebih lanjut
   - 📕 **PDF** — untuk dicetak atau dilaporkan

5. Klik **"Export"** → file otomatis terdownload!

---

<!-- _class: tip -->

# 💡 Tips Export Laporan

- Gunakan format **Excel** jika ingin mengedit data atau menambahkan rumus
- Gunakan format **PDF** jika ingin langsung **dicetak** atau dikirim ke dinas pendidikan
- Laporan bisa di-download **kapan saja** dan **berulang kali**
- Data yang muncul di laporan sesuai dengan **filter** yang Anda pilih
- Untuk rekap **satu semester penuh**, pilih rentang tanggal dari awal sampai akhir semester

---

<!-- _class: section-title -->

# 🖥️ Bagian 7
## Mode Kiosk *(Layar Ruang Guru)*

---

# Apa Itu Mode Kiosk?

Mode Kiosk adalah **layar monitor di ruang guru** yang menampilkan QR Code untuk absensi.

**Cara kerjanya:**

1. Monitor di ruang guru **sudah menyala** dan menampilkan daftar nama guru
2. Guru **pilih namanya** di layar monitor
3. Muncul **QR Code** unik milik guru tersebut
4. Guru lain bisa langsung **scan QR Code tersebut** pakai HP
5. Selesai! ✅

> 💡 Anggap saja ini seperti **papan absensi digital** — bedanya, tinggal scan pakai HP, tidak perlu tanda tangan!

---

<!-- _class: section-title -->

# ❓ Bagian 8
## Pertanyaan yang Sering Ditanya (FAQ)

---

# FAQ — Masalah Umum

**❓ "Saya lupa password, bagaimana?"**
↳ Hubungi Staf TU / Admin untuk mereset password Anda.

**❓ "QR Code tidak bisa di-scan, kenapa?"**
↳ Pastikan kamera HP bersih, pencahayaan cukup, dan HP tidak terlalu jauh dari layar.

**❓ "Muncul pesan 'Lokasi tidak valid', padahal saya di sekolah?"**
↳ Nyalakan GPS di HP Anda, lalu coba lagi. Jika masih gagal, keluar gedung sebentar lalu masuk lagi agar GPS mendapatkan sinyal.

**❓ "Saya sudah input nilai tapi lupa klik Simpan?"**
↳ Sayangnya data belum tersimpan. Selalu klik **"Simpan"** setelah input nilai.

---

# FAQ — Pertanyaan Lainnya

**❓ "Apakah bisa absen dari rumah?"**
↳ Tidak bisa. Sistem memvalidasi bahwa Anda harus berada di area sekolah.

**❓ "Apakah data saya aman?"**
↳ Ya! Semua data dienkripsi dan hanya bisa diakses oleh pengguna yang berwenang.

**❓ "Nilai siswa bisa diedit setelah disimpan?"**
↳ Bisa! Buka halaman input nilai lagi, nilai lama otomatis muncul dan bisa Anda ubah.

**❓ "Siapa yang bisa melihat ranking siswa?"**
↳ Guru dan Kepala Sekolah bisa melihat ranking. Siswa dan orang tua tidak memiliki akses.

---

<!-- _class: section-title -->

# 📞 Bagian 9
## Butuh Bantuan?

---

# Kontak Bantuan

Jika mengalami kendala atau pertanyaan terkait sistem, silakan hubungi:

| Masalah | Hubungi | Peran |
|---------|---------|-------|
| 🔑 Lupa password / akun terkunci | Staf TU (Admin) | Reset akun |
| 🐛 Error atau bug di sistem | Developer (Peneliti) | Perbaikan teknis |
| 📊 Cara penggunaan fitur | Staf TU (Admin) | Bantuan operasional |

> 📱 Simpan nomor kontak admin di HP Anda untuk kemudahan akses bantuan.

---

<!-- _class: cover -->

# ✅ Selamat!

## Anda sudah siap menggunakan sistem

### Sistem Absensi Guru & Penilaian Siswa
### SMPN 4 Purwakarta

*Terima kasih atas partisipasi Anda! 🙏*
