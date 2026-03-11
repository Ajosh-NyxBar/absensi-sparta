# 4.1.5 Menguji Sistem

Setelah proses pengkodean selesai, peneliti melakukan pengujian sistem secara menyeluruh untuk memastikan seluruh fitur berfungsi sesuai dengan rancangan yang telah ditetapkan. Pengujian dilakukan menggunakan dua metode, yaitu *Black Box Testing* untuk menguji fungsionalitas dari perspektif pengguna dan *White Box Testing* untuk memverifikasi kebenaran logika internal kode program.

## 4.1.5.1 Black Box Testing

Pengujian *Black Box* dilakukan untuk memverifikasi bahwa setiap fungsi sistem menghasilkan output yang benar berdasarkan input yang diberikan, tanpa meninjau struktur kode internalnya. Peneliti merancang skenario pengujian berdasarkan use case dan activity diagram yang telah didefinisikan pada tahap perancangan. Setiap skenario mencakup data uji, hasil yang diharapkan, hasil aktual, dan status keberhasilan.

### a. Pengujian Fitur Login

Fitur login diuji untuk memastikan mekanisme autentikasi bekerja dengan benar pada seluruh role pengguna serta menangani kondisi error dengan tepat.

**Tabel 4.51 Hasil Black Box Testing — Fitur Login**

| No | Skenario Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-------------------|----------|----------------------|----------------|--------|
| 1 | Login sebagai Admin dengan kredensial valid | Email: admin@smpn4.com, Password: (valid) | Sistem memverifikasi kredensial, mengidentifikasi role Admin, redirect ke dashboard admin | Berhasil login, redirect ke halaman `/dashboard/admin` | ✓ Berhasil |
| 2 | Login sebagai Guru dengan kredensial valid | Email: guru@smpn4.com, Password: (valid) | Sistem mengidentifikasi role Guru, redirect ke dashboard guru | Berhasil login, redirect ke halaman `/dashboard/teacher` | ✓ Berhasil |
| 3 | Login sebagai Kepala Sekolah dengan kredensial valid | Email: kepsek@smpn4.com, Password: (valid) | Sistem mengidentifikasi role Kepala Sekolah, redirect ke dashboard kepala sekolah | Berhasil login, redirect ke halaman `/dashboard/headmaster` | ✓ Berhasil |
| 4 | Login dengan email yang tidak terdaftar | Email: tidakada@test.com, Password: test123 | Sistem menolak login, menampilkan pesan error | Pesan error "Email atau password salah" ditampilkan, tetap di halaman login | ✓ Berhasil |
| 5 | Login dengan password salah | Email: admin@smpn4.com, Password: salahpassword | Sistem menolak login, menampilkan pesan error | Pesan error "Email atau password salah" ditampilkan | ✓ Berhasil |
| 6 | Login dengan field email kosong | Email: (kosong), Password: test123 | Sistem menampilkan validasi "field wajib diisi" | Pesan validasi "The email field is required" muncul | ✓ Berhasil |
| 7 | Login dengan field password kosong | Email: admin@smpn4.com, Password: (kosong) | Sistem menampilkan validasi "field wajib diisi" | Pesan validasi "The password field is required" muncul | ✓ Berhasil |
| 8 | Akses halaman dashboard tanpa login | Langsung mengakses URL `/dashboard/admin` | Sistem menolak akses, redirect ke halaman login | Redirect otomatis ke halaman login | ✓ Berhasil |
| 9 | Akses halaman admin oleh role Guru | Login sebagai Guru, akses URL `/dashboard/admin` | Sistem menolak akses (middleware role) | Menampilkan halaman 403 Forbidden atau redirect | ✓ Berhasil |

### b. Pengujian Fitur Absensi Guru (QR Code)

Fitur absensi diuji secara komprehensif meliputi proses generate QR Code, scan QR Code, validasi geolocation, dan penanganan berbagai kondisi error.

**Tabel 4.52 Hasil Black Box Testing — Fitur Generate QR Code**

| No | Skenario Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-------------------|----------|----------------------|----------------|--------|
| 1 | Generate QR Code untuk guru terdaftar | Teacher ID: valid, tanggal: hari ini | QR Code terenkripsi berhasil dibuat dalam format SVG | QR Code ditampilkan, mengandung data terenkripsi (teacher_id, date, timestamp) | ✓ Berhasil |
| 2 | Generate QR Code baru (refresh) | Teacher ID: valid, 15 menit setelah QR pertama | QR Code baru dengan timestamp terbaru | QR Code baru berhasil di-generate dengan timestamp berbeda | ✓ Berhasil |

**Tabel 4.53 Hasil Black Box Testing — Fitur Scan QR Code dan Check-in**

| No | Skenario Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-------------------|----------|----------------------|----------------|--------|
| 1 | Scan QR Code valid, belum absen hari ini, sebelum jam 07:30 | QR Code valid, waktu: 07:15 | Check-in berhasil, status: "Tepat Waktu" (`present`) | Response JSON: success=true, action="check-in", status="Tepat Waktu" | ✓ Berhasil |
| 2 | Scan QR Code valid, belum absen hari ini, setelah jam 07:30 | QR Code valid, waktu: 08:00 | Check-in berhasil, status: "Terlambat" (`late`) | Response JSON: success=true, action="check-in", status="Terlambat" | ✓ Berhasil |
| 3 | Scan QR Code valid, sudah check-in tapi belum check-out | QR Code valid, sudah check-in hari ini | Check-out berhasil, waktu check-out tercatat | Response JSON: success=true, action="check-out", data menampilkan waktu check-in dan check-out | ✓ Berhasil |
| 4 | Scan QR Code valid, sudah check-in dan check-out | QR Code valid, sudah lengkap hari ini | Menampilkan pesan bahwa sudah absen | Response JSON: success=false, message="Anda sudah melakukan check-in dan check-out hari ini" | ✓ Berhasil |
| 5 | Scan QR Code kadaluarsa (lebih dari 10 menit) | QR Code yang di-generate >600 detik lalu | Menampilkan pesan QR kadaluarsa | Response JSON: success=false, message="QR Code sudah kadaluarsa. Silakan refresh QR Code." | ✓ Berhasil |
| 6 | Scan QR Code yang bukan untuk hari ini | QR Code dengan tanggal kemarin | Menampilkan pesan QR tidak valid | Response JSON: success=false, message="QR Code tidak valid untuk hari ini" | ✓ Berhasil |
| 7 | Scan QR Code rusak/tidak valid | Data QR yang tidak bisa di-decrypt | Menampilkan pesan error | Response JSON: success=false, message="QR Code tidak valid atau rusak" | ✓ Berhasil |
| 8 | Scan QR Code dengan teacher_id tidak ditemukan | QR Code valid tapi guru sudah dihapus | Menampilkan pesan data tidak ditemukan | Response JSON: success=false, message="Data guru tidak ditemukan" (HTTP 404) | ✓ Berhasil |

**Tabel 4.54 Hasil Black Box Testing — Fitur Validasi Geolocation**

| No | Skenario Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-------------------|----------|----------------------|----------------|--------|
| 1 | Check-in dalam radius sekolah (< 100 meter) | Latitude: -6.5465236, Longitude: 107.4414175, Jarak: ~20 meter | Absensi berhasil dicatat, koordinat GPS tersimpan | Check-in berhasil, `latitude_in` dan `longitude_in` tersimpan di database | ✓ Berhasil |
| 2 | Check-in di luar radius sekolah (> 100 meter) | Latitude: -6.5600, Longitude: 107.4500, Jarak: ~700 meter | Absensi ditolak, menampilkan pesan jarak | Response: success=false, message="Anda berada di luar area sekolah. Jarak: 700 meter" | ✓ Berhasil |
| 3 | Check-in tanpa data koordinat | Latitude: (kosong), Longitude: (kosong) | Validasi gagal, menampilkan pesan required | Pesan validasi "The latitude field is required" dan "The longitude field is required" | ✓ Berhasil |
| 4 | Check-in dengan koordinat format non-numerik | Latitude: "abc", Longitude: "xyz" | Validasi gagal, menampilkan pesan error | Pesan validasi "The latitude field must be a number" | ✓ Berhasil |

### c. Pengujian Fitur Input Nilai Siswa

Fitur penilaian diuji untuk memastikan proses input, validasi, perhitungan otomatis, dan mekanisme update berfungsi dengan benar.

**Tabel 4.55 Hasil Black Box Testing — Fitur Input Nilai**

| No | Skenario Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-------------------|----------|----------------------|----------------|--------|
| 1 | Input nilai lengkap untuk satu kelas | Kelas: 9A, Mapel: Matematika, Semester: 1, Tugas: 85, UTS: 80, UAS: 90 | Nilai tersimpan, nilai akhir dihitung otomatis: (85×0.3)+(80×0.3)+(90×0.4)=85.5 | Data tersimpan di tabel `grades`, `final_grade` = 85.50 | ✓ Berhasil |
| 2 | Input nilai hanya sebagian (Tugas saja, UTS dan UAS kosong) | Tugas: 85, UTS: null, UAS: null | Nilai Tugas tersimpan, UTS dan UAS disimpan sebagai null | Data tersimpan, `daily_test`=85, `midterm_exam`=null, `final_exam`=null | ✓ Berhasil |
| 3 | Input nilai melebihi batas maksimum | Tugas: 150 | Validasi gagal, pesan error ditampilkan | Pesan: "The students.*.daily_test field must not be greater than 100" | ✓ Berhasil |
| 4 | Input nilai negatif | Tugas: -10 | Validasi gagal, pesan error ditampilkan | Pesan: "The students.*.daily_test field must be at least 0" | ✓ Berhasil |
| 5 | Input nilai non-numerik | Tugas: "ABC" | Validasi gagal, pesan error ditampilkan | Pesan: "The students.*.daily_test field must be a number" | ✓ Berhasil |
| 6 | Update nilai yang sudah ada | Ubah Tugas dari 85 menjadi 90, kelas dan semester sama | Nilai lama terupdate, nilai akhir dihitung ulang | `daily_test` berubah menjadi 90, `final_grade` dihitung ulang | ✓ Berhasil |
| 7 | Buka form input untuk kelas yang sudah ada nilainya | Kelas: 9A, Mapel: Matematika, Semester: 1 (sudah ada data) | Form menampilkan nilai yang sudah tersimpan (*pre-filled*) | Kolom input terisi otomatis dengan nilai sebelumnya dari `existingGrades` | ✓ Berhasil |
| 8 | Input nilai oleh Guru untuk kelas yang tidak diampu | Guru Mapel IPA mencoba input nilai Matematika di kelas yang tidak diampu | Sistem menolak atau tidak menampilkan kelas tersebut | Kelas dan mata pelajaran yang ditampilkan hanya yang diampu oleh guru tersebut | ✓ Berhasil |
| 9 | Input kelas_id yang tidak valid | class_id: 99999 (tidak ada) | Validasi gagal | Pesan: "The selected class id is invalid" | ✓ Berhasil |

### d. Pengujian Fitur Perhitungan SAW

Fitur perhitungan SAW diuji untuk memastikan proses perankingan siswa dan guru menghasilkan output yang benar.

**Tabel 4.56 Hasil Black Box Testing — Fitur Perhitungan SAW**

| No | Skenario Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-------------------|----------|----------------------|----------------|--------|
| 1 | Hitung ranking siswa dalam satu kelas | Kelas: 9A, Semester: 1, Tahun Ajaran: 2025/2026 | Ranking terhitung dengan skor SAW, tersimpan di tabel `student_assessments` | Ranking ditampilkan, skor SAW dibulatkan 4 desimal, data tersimpan | ✓ Berhasil |
| 2 | Hitung ranking guru | Periode: Semester 1 | Ranking guru terhitung, tersimpan di tabel `teacher_assessments` | Ranking guru ditampilkan dengan detail skor SAW per kriteria | ✓ Berhasil |
| 3 | Lihat detail perhitungan SAW | Klik "Detail Perhitungan" setelah ranking terhitung | Menampilkan matriks keputusan, matriks normalisasi, dan nilai preferensi | Detail perhitungan lengkap ditampilkan: matriks, normalisasi, bobot, skor akhir | ✓ Berhasil |
| 4 | Hitung ranking dengan data siswa kosong (belum ada nilai) | Kelas baru tanpa data nilai | Sistem mengembalikan data tanpa perubahan (tidak crash) | Data dikembalikan tanpa skor SAW, tidak terjadi error | ✓ Berhasil |
| 5 | Hitung ranking ketika belum ada kriteria di database | Tabel `criteria` kosong | Sistem mengembalikan data tanpa perubahan | Data dikembalikan tanpa pemrosesan SAW, tidak terjadi error | ✓ Berhasil |

### e. Pengujian Fitur Laporan dan Export

Fitur laporan diuji untuk memastikan proses export ke format Excel dan PDF berfungsi dengan benar beserta filter yang tersedia.

**Tabel 4.57 Hasil Black Box Testing — Fitur Laporan**

| No | Skenario Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-------------------|----------|----------------------|----------------|--------|
| 1 | Export laporan presensi ke Excel | Tanggal mulai: 01/09/2025, Tanggal akhir: 30/09/2025, Format: Excel | File `.xlsx` berhasil diunduh dengan data presensi sesuai periode | File `laporan_presensi_2025-09-01_to_2025-09-30.xlsx` berhasil diunduh, data lengkap | ✓ Berhasil |
| 2 | Export laporan presensi ke PDF | Tanggal mulai: 01/09/2025, Tanggal akhir: 30/09/2025, Format: PDF | File `.pdf` berhasil diunduh dengan layout rapi | File PDF berhasil diunduh dengan tabel dan header sesuai | ✓ Berhasil |
| 3 | Export laporan nilai per kelas | Kelas: 9A, Semester: 1, Tahun Ajaran: 2025/2026, Format: Excel | File Excel berisi data nilai siswa kelas 9A semester 1 | File `laporan_nilai_9A_2025-2026.xlsx` berhasil diunduh, data sesuai filter | ✓ Berhasil |
| 4 | Export laporan siswa per tingkat | Tingkat: 7, Status: Active, Format: PDF | File PDF berisi data siswa kelas 7 yang aktif | File `laporan_siswa_kelas_7.pdf` berhasil diunduh | ✓ Berhasil |
| 5 | Export laporan guru | Format: Excel | File Excel berisi data seluruh guru | File `laporan_guru_2025-09-30.xlsx` berhasil diunduh | ✓ Berhasil |
| 6 | Export laporan dengan tanggal mulai > tanggal akhir | Tanggal mulai: 30/09/2025, Tanggal akhir: 01/09/2025 | Validasi gagal, pesan error | Pesan: "The end date field must be a date after or equal to start date" | ✓ Berhasil |
| 7 | Export laporan tanpa memilih format | Format: (kosong) | Validasi gagal, pesan error | Pesan: "The format field is required" | ✓ Berhasil |

### f. Pengujian Fitur Dashboard

**Tabel 4.58 Hasil Black Box Testing — Fitur Dashboard**

| No | Skenario Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-------------------|----------|----------------------|----------------|--------|
| 1 | Akses dashboard Admin | Login sebagai Admin | Menampilkan statistik: total siswa, guru, kelas, mata pelajaran, grafik absensi mingguan, absensi terbaru | Seluruh statistik ditampilkan dengan data akurat | ✓ Berhasil |
| 2 | Filter dashboard per bulan | Pilih bulan: September, tahun: 2025 | Statistik bulanan (attendance rate, rata-rata nilai, completion rate) sesuai bulan yang dipilih | Data statistik berubah sesuai bulan yang difilter | ✓ Berhasil |
| 3 | Akses dashboard Guru | Login sebagai Guru | Menampilkan informasi kehadiran pribadi dan kelas yang diampu | Dashboard guru ditampilkan sesuai data guru yang login | ✓ Berhasil |
| 4 | Akses dashboard Kepala Sekolah | Login sebagai Kepala Sekolah | Menampilkan monitoring kehadiran guru, statistik prestasi siswa | Dashboard kepala sekolah ditampilkan dengan data monitoring | ✓ Berhasil |

### g. Pengujian Fitur Manajemen Data Master

**Tabel 4.59 Hasil Black Box Testing — Fitur Manajemen Data**

| No | Skenario Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-------------------|----------|----------------------|----------------|--------|
| 1 | Tambah data guru baru | Nama: Test Guru, NIP: 12345, Email: testguru@test.com | Data guru berhasil disimpan | Data tersimpan, muncul di daftar guru | ✓ Berhasil |
| 2 | Edit data guru | Ubah nama guru dari "Test Guru" menjadi "Guru Baru" | Data guru terupdate | Nama berubah di database dan tampilan | ✓ Berhasil |
| 3 | Hapus data guru | Hapus guru "Guru Baru" | Data guru terhapus, data terkait (absensi, pengajaran) terhapus otomatis (cascade) | Data terhapus dari tabel `teachers` dan tabel terkait | ✓ Berhasil |
| 4 | Tambah data siswa baru | Nama: Test Siswa, NISN: 12345, Kelas: 7A | Data siswa berhasil disimpan | Data tersimpan di tabel `students` dengan `class_id` yang sesuai | ✓ Berhasil |
| 5 | Tambah kelas baru | Nama: 7D, Tingkat: 7 | Kelas berhasil ditambahkan | Kelas muncul di daftar dan dapat dipilih saat input data siswa/nilai | ✓ Berhasil |
| 6 | Tambah mata pelajaran baru | Nama: Bahasa Sunda, Kode: BASUN | Mata pelajaran berhasil ditambahkan | Data tersimpan, muncul di daftar pilihan mata pelajaran | ✓ Berhasil |
| 7 | Tambah data guru dengan email yang sudah ada | Email: admin@smpn4.com (sudah terdaftar) | Validasi gagal, pesan email sudah digunakan | Pesan: "The email has already been taken" | ✓ Berhasil |

### h. Pengujian Fitur Pengaturan Kriteria SAW

**Tabel 4.60 Hasil Black Box Testing — Fitur Pengaturan Kriteria**

| No | Skenario Pengujian | Data Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-------------------|----------|----------------------|----------------|--------|
| 1 | Ubah bobot kriteria siswa | C1: 0.40, C2: 0.20, C3: 0.20, C4: 0.20 (total = 1.0) | Bobot berhasil diupdate | Data `weight` pada tabel `criteria` terupdate | ✓ Berhasil |
| 2 | Ubah tipe kriteria dari benefit ke cost | C2 (Kehadiran): ubah dari benefit ke cost | Tipe berhasil diupdate, normalisasi SAW berubah sesuai | Perhitungan SAW menggunakan rumus cost (min/x_ij) untuk kriteria C2 | ✓ Berhasil |
| 3 | Lihat daftar kriteria siswa dan guru | Akses halaman manajemen kriteria | Menampilkan 4 kriteria siswa (C1–C4) dan 4 kriteria guru (K1–K4) | 8 kriteria ditampilkan lengkap dengan kode, nama, tipe, dan bobot | ✓ Berhasil |

### i. Rekapitulasi Hasil Black Box Testing

Tabel berikut merangkum hasil keseluruhan Black Box Testing yang telah dilakukan:

**Tabel 4.61 Rekapitulasi Hasil Black Box Testing**

| No | Modul yang Diuji | Jumlah Skenario | Berhasil | Gagal | Persentase |
|----|-----------------|----------------|----------|-------|------------|
| 1 | Login dan Autentikasi | 9 | 9 | 0 | 100% |
| 2 | Generate QR Code | 2 | 2 | 0 | 100% |
| 3 | Scan QR Code dan Check-in | 8 | 8 | 0 | 100% |
| 4 | Validasi Geolocation | 4 | 4 | 0 | 100% |
| 5 | Input Nilai Siswa | 9 | 9 | 0 | 100% |
| 6 | Perhitungan SAW | 5 | 5 | 0 | 100% |
| 7 | Laporan dan Export | 7 | 7 | 0 | 100% |
| 8 | Dashboard | 4 | 4 | 0 | 100% |
| 9 | Manajemen Data Master | 7 | 7 | 0 | 100% |
| 10 | Pengaturan Kriteria SAW | 3 | 3 | 0 | 100% |
| | **Total** | **58** | **58** | **0** | **100%** |

Berdasarkan hasil pengujian, seluruh **58 skenario** Black Box Testing berhasil dieksekusi tanpa ditemukan kegagalan. Setiap fungsi sistem menghasilkan output yang sesuai dengan hasil yang diharapkan, baik pada kondisi normal (*valid input*) maupun pada kondisi error (*invalid input*). Tingkat keberhasilan pengujian sebesar **100%** menunjukkan bahwa sistem telah memenuhi seluruh kebutuhan fungsional yang didefinisikan.

---

*Pengujian White Box Testing (4.1.5.2) dibahas secara terpisah pada file `BAB4_4152_White_Box_Testing.md`.*

---

## 4.1.5.3 Analisis Hasil Pengujian

Berdasarkan keseluruhan hasil pengujian Black Box dan White Box, peneliti menyimpulkan bahwa:

1. **Fungsionalitas sistem terpenuhi** — seluruh 58 skenario Black Box Testing berhasil (100%), membuktikan bahwa setiap fitur sistem berfungsi sesuai kebutuhan yang telah didefinisikan.

2. **Logika internal kode program terverifikasi** — pengujian White Box menggunakan teknik Basis Path Testing berhasil menguji seluruh 19 jalur independen (V(G) = 8 + 5 + 6) pada tiga method kritis. Seluruh jalur menghasilkan output yang benar.

3. **Algoritma SAW terimplementasi dengan benar** — verifikasi perhitungan manual vs sistem pada method `normalizeMatrix()` dan `calculateSAWScores()` menunjukkan hasil identik hingga 4 desimal.

4. **Validasi input berjalan efektif** — seluruh aturan validasi pada setiap controller mampu menolak data yang tidak valid dan memberikan pesan error yang informatif kepada pengguna.

5. **Perhitungan formula Haversine akurat** — validasi geolocation menghasilkan perhitungan jarak yang akurat dengan selisih < 1 meter dari nilai referensi.

6. **Penanganan edge case memadai** — jalur P3 dan P5–P6 pada `normalizeMatrix()` membuktikan bahwa sistem menangani kasus pembagian dengan nol tanpa error. Jalur P1–P5 pada `scanQR()` membuktikan bahwa seluruh kondisi error (QR rusak, kadaluarsa, tanggal tidak sesuai) ditangani dengan tepat.

Tidak ditemukan bug kritis selama proses pengujian. Beberapa perbaikan minor yang dilakukan meliputi penyesuaian pesan error agar lebih informatif dalam Bahasa Indonesia dan penanganan edge case pada perhitungan persentase kehadiran ketika data absensi masih kosong di awal penggunaan sistem.
