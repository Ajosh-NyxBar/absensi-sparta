# Panduan Penggunaan Sistem

## Untuk Administrator

### 1. Login ke Sistem
- Akses `http://localhost:8000`
- Login dengan kredensial admin
- Email: `admin@smpn4purwakarta.sch.id`
- Password: `password`

### 2. Mengelola Data Guru
**Menambah Guru Baru:**
1. Pilih menu "Data Guru"
2. Klik tombol "Tambah Guru Baru"
3. Isi formulir dengan lengkap:
   - NIP (Nomor Induk Pegawai)
   - Nama lengkap
   - Email (untuk login)
   - Password
   - Jenis kelamin
   - Data lainnya
4. Klik "Simpan"

### 3. Mengelola Data Siswa
**Menambah Siswa Baru:**
1. Pilih menu "Data Siswa"
2. Klik "Tambah Siswa Baru"
3. Isi formulir:
   - NISN dan NIS
   - Nama lengkap
   - Kelas
   - Data pribadi
   - Data orang tua
4. Klik "Simpan"

### 4. Mengelola Presensi Kelas
1. Pilih menu "Daftar Presensi"
2. Klik "Presensi Kelas"
3. Pilih kelas dan tanggal
4. Tandai status kehadiran setiap siswa
5. Klik "Simpan"

### 5. Menghitung SAW
**Untuk Siswa:**
1. Menu "Prestasi Siswa"
2. Pilih kelas, semester, dan tahun ajaran
3. Klik "Hitung SAW"
4. Sistem akan otomatis menghitung dan menampilkan ranking

**Untuk Guru:**
1. Menu "Prestasi Guru"
2. Pilih periode dan tahun ajaran
3. Klik "Hitung SAW"
4. Lihat hasil ranking guru

## Untuk Guru

### 1. Melakukan Presensi
**Menggunakan Geolocation:**
1. Login ke sistem
2. Dashboard akan menampilkan status presensi
3. Klik "Scan QR Code" atau "Check-in"
4. Izinkan akses lokasi browser
5. Sistem akan memvalidasi lokasi Anda
6. Jika dalam radius sekolah, presensi berhasil

### 2. Input Nilai Siswa
1. Pilih menu "Input Nilai"
2. Klik "Input Nilai Baru"
3. Pilih kelas dan mata pelajaran
4. Pilih semester dan tahun ajaran
5. Klik "Lanjutkan"
6. Isi nilai untuk setiap siswa:
   - Ulangan harian
   - UTS
   - UAS
   - Nilai sikap
   - Nilai keterampilan
7. Sistem otomatis menghitung nilai akhir
8. Klik "Simpan"

### 3. Melihat Riwayat Presensi
1. Menu "Daftar Presensi"
2. Pilih filter tanggal jika perlu
3. Lihat riwayat presensi Anda

## Untuk Kepala Sekolah

### 1. Monitoring Presensi
1. Login dengan akun kepala sekolah
2. Dashboard menampilkan:
   - Total guru dan siswa
   - Kehadiran hari ini
   - Statistik kehadiran

### 2. Melihat Laporan SAW
**Laporan Prestasi Siswa:**
1. Menu "Prestasi Siswa"
2. Pilih kelas, semester, dan tahun
3. Lihat detail perhitungan SAW:
   - Matriks keputusan
   - Matriks normalisasi
   - Skor SAW
   - Ranking siswa

**Laporan Prestasi Guru:**
1. Menu "Prestasi Guru"
2. Pilih periode dan tahun
3. Lihat ranking guru berdasarkan kriteria:
   - Kehadiran
   - Kualitas mengajar
   - Prestasi siswa
   - Kedisiplinan

### 3. Export Laporan
1. Buka halaman laporan SAW
2. Klik tombol "Export PDF" atau "Export Excel"
3. Laporan akan diunduh

## Tips Penggunaan

### Untuk Presensi Berbasis Geolocation
- Pastikan GPS/Location aktif di perangkat
- Gunakan browser yang support geolocation (Chrome, Firefox, Edge)
- Izinkan akses lokasi saat diminta
- Pastikan berada dalam radius 100 meter dari sekolah

### Untuk Input Nilai
- Rentang nilai: 0-100
- Nilai akhir dihitung otomatis: (UH × 30%) + (UTS × 30%) + (UAS × 40%)
- Nilai sikap dan keterampilan terpisah
- Data dapat diupdate kapan saja sebelum semester berakhir

### Untuk Perhitungan SAW
- Pastikan semua data nilai sudah lengkap
- Kriteria dan bobot sudah ditentukan sistem
- Hasil perhitungan otomatis dan transparan
- Ranking dapat dicetak untuk keperluan administrasi

## Troubleshooting

### Presensi Gagal
**Masalah:** "Anda berada di luar area sekolah"
- **Solusi:** Pastikan Anda berada di area sekolah atau hubungi admin untuk update koordinat

### Tidak Bisa Login
**Masalah:** Email/password salah
- **Solusi:** Hubungi administrator untuk reset password

### Data Tidak Muncul
**Masalah:** Tabel kosong atau data tidak tampil
- **Solusi:** 
  1. Refresh halaman
  2. Periksa filter yang aktif
  3. Hubungi admin jika masalah berlanjut

### Error Saat Hitung SAW
**Masalah:** Perhitungan gagal
- **Solusi:**
  1. Pastikan semua siswa memiliki nilai
  2. Pastikan data presensi tersedia
  3. Hubungi admin untuk cek konfigurasi

## Kontak Dukungan

Untuk bantuan lebih lanjut, hubungi:
- **Admin Sistem**: admin@smpn4purwakarta.sch.id
- **IT Support**: it@smpn4purwakarta.sch.id
- **Telepon**: (0264) xxx-xxxx
