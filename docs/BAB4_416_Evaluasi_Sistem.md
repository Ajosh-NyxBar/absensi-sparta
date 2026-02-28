# 4.1.6 Evaluasi Sistem

Setelah pengujian internal (*Black Box Testing* dan *White Box Testing*) selesai dilakukan dan seluruh bug yang ditemukan telah diperbaiki, peneliti melanjutkan ke tahap evaluasi sistem. Pada tahap ini, sistem yang telah dibangun diujicobakan kepada pengguna akhir di SMPN 4 Purwakarta untuk memperoleh penilaian langsung terhadap kesesuaian fitur, kemudahan penggunaan, dan kesiapan sistem untuk diterapkan di lingkungan operasional sekolah.

## 4.1.6.1 User Acceptance Testing (UAT)

### a. Tujuan dan Ruang Lingkup

Peneliti melaksanakan User Acceptance Testing (UAT) dengan tujuan untuk memvalidasi bahwa sistem yang dikembangkan telah memenuhi kebutuhan nyata pengguna dan layak untuk digunakan dalam aktivitas operasional sehari-hari. UAT difokuskan pada lima aspek utama: fungsionalitas fitur, kemudahan penggunaan (*usability*), kecepatan respon sistem (*performance*), kualitas tampilan antarmuka, dan keandalan operasional.

### b. Peserta UAT

Peneliti melibatkan 5 (lima) peserta UAT yang merupakan calon pengguna langsung sistem di SMPN 4 Purwakarta. Pemilihan peserta disesuaikan dengan peran yang tersedia di dalam sistem agar setiap fitur dapat dievaluasi oleh pengguna yang tepat.

**Tabel 4.XX Daftar Peserta UAT**

| No | Peserta | Jabatan | Role dalam Sistem | Fitur yang Diuji |
|----|---------|---------|-------------------|------------------|
| 1 | Responden 1 | Kepala Sekolah | Kepala Sekolah | Dashboard monitoring, ranking SAW, laporan |
| 2 | Responden 2 | Guru Mata Pelajaran | Guru | Scan QR Code, input nilai, rekap kehadiran |
| 3 | Responden 3 | Guru Mata Pelajaran | Guru | Scan QR Code, input nilai, rekap kehadiran |
| 4 | Responden 4 | Guru Mata Pelajaran | Guru | Scan QR Code, input nilai, rekap kehadiran |
| 5 | Responden 5 | Staf Tata Usaha | Admin | Manajemen data master, generate QR Code, export laporan |

Setiap peserta diberikan akun sesuai perannya dan diminta untuk mencoba seluruh fitur yang menjadi tanggung jawabnya dalam skenario penggunaan yang menyerupai kondisi riil operasional sekolah.

### c. Metode Evaluasi

Evaluasi dilakukan menggunakan **kuesioner** yang terdiri dari 10 pertanyaan dengan skala **Likert 1–5** (1 = Sangat Tidak Setuju, 2 = Tidak Setuju, 3 = Netral, 4 = Setuju, 5 = Sangat Setuju). Pertanyaan dalam kuesioner dikategorikan ke dalam lima aspek evaluasi. Selain kuesioner, peneliti juga mengumpulkan **feedback kualitatif** melalui wawancara singkat setelah peserta selesai mencoba sistem.

**Tabel 4.XX Daftar Pertanyaan Kuesioner UAT**

| No | Pertanyaan | Aspek Evaluasi |
|----|-----------|----------------|
| 1 | Seluruh fitur sistem berfungsi sesuai dengan kebutuhan saya | Fungsionalitas |
| 2 | Fitur absensi QR Code dan validasi lokasi bekerja dengan baik | Fungsionalitas |
| 3 | Sistem mudah dipelajari dan dioperasikan tanpa panduan berulang | Kemudahan Penggunaan |
| 4 | Navigasi menu dan alur penggunaan sistem sudah intuitif | Kemudahan Penggunaan |
| 5 | Sistem merespon perintah dengan cepat (loading halaman, proses data) | Kecepatan Sistem |
| 6 | Proses scan QR Code dan export laporan berjalan tanpa delay berarti | Kecepatan Sistem |
| 7 | Tampilan antarmuka sistem menarik dan profesional | Tampilan Antarmuka |
| 8 | Informasi pada dashboard mudah dipahami (grafik, statistik, tabel) | Tampilan Antarmuka |
| 9 | Sistem berjalan stabil tanpa error atau crash selama pengujian | Keandalan |
| 10 | Saya yakin sistem ini dapat digunakan secara rutin di sekolah | Keandalan |

### d. Prosedur Pelaksanaan

Pelaksanaan UAT dilakukan dengan tahapan sebagai berikut:

1. **Briefing**: Peneliti memberikan penjelasan singkat mengenai tujuan evaluasi dan cara pengisian kuesioner kepada seluruh peserta.
2. **Eksplorasi mandiri**: Setiap peserta diberikan waktu untuk mengeksplorasi dan mengoperasikan fitur-fitur sistem sesuai perannya masing-masing.
3. **Skenario tugas**: Peserta diminta menjalankan tugas-tugas spesifik, antara lain:
   - *Guru*: melakukan scan QR Code untuk absensi, menginput nilai siswa satu kelas, dan melihat rekap kehadiran pribadi.
   - *Admin*: menambah data guru baru, melakukan generate QR Code, dan mengekspor laporan kehadiran ke Excel.
   - *Kepala Sekolah*: melihat dashboard monitoring, menjalankan perhitungan ranking SAW, dan melihat detail perhitungan.
4. **Pengisian kuesioner**: Setelah selesai mencoba, peserta mengisi kuesioner penilaian.
5. **Wawancara**: Peneliti melakukan wawancara singkat untuk menggali feedback kualitatif dan saran perbaikan.

---

## 4.1.6.2 Hasil Evaluasi Pengguna

### a. Hasil Kuesioner UAT

Berikut adalah rekapitulasi hasil penilaian dari seluruh peserta UAT terhadap masing-masing pertanyaan:

**Tabel 4.XX Hasil Penilaian Kuesioner UAT per Pertanyaan**

| No | Pertanyaan (Ringkas) | R1 | R2 | R3 | R4 | R5 | Rata-rata |
|----|---------------------|----|----|----|----|----|----|
| 1 | Fitur sesuai kebutuhan | 5 | 5 | 4 | 5 | 5 | 4,80 |
| 2 | Absensi QR + lokasi bekerja baik | 5 | 4 | 5 | 4 | 5 | 4,60 |
| 3 | Mudah dipelajari | 4 | 4 | 4 | 5 | 5 | 4,40 |
| 4 | Navigasi intuitif | 4 | 5 | 4 | 4 | 5 | 4,40 |
| 5 | Respon cepat | 5 | 4 | 5 | 4 | 5 | 4,60 |
| 6 | Scan QR + export tanpa delay | 5 | 4 | 4 | 5 | 5 | 4,60 |
| 7 | Tampilan menarik dan profesional | 4 | 4 | 5 | 4 | 4 | 4,20 |
| 8 | Dashboard mudah dipahami | 5 | 4 | 4 | 4 | 4 | 4,20 |
| 9 | Stabil tanpa error | 5 | 5 | 4 | 5 | 4 | 4,60 |
| 10 | Layak digunakan rutin | 5 | 4 | 5 | 4 | 5 | 4,60 |

Keterangan: R1 = Kepala Sekolah, R2 = Guru 1, R3 = Guru 2, R4 = Guru 3, R5 = Staf TU.

### b. Rekapitulasi Skor per Aspek

Hasil penilaian kemudian dikelompokkan berdasarkan lima aspek evaluasi:

**Tabel 4.XX Rekapitulasi Skor UAT per Aspek Evaluasi**

| No | Aspek Evaluasi | Pertanyaan | Skor Rata-rata | Kategori |
|----|---------------|-----------|----------------|----------|
| 1 | Fungsionalitas | Q1, Q2 | 4,70 | Sangat Baik |
| 2 | Kemudahan Penggunaan | Q3, Q4 | 4,40 | Sangat Baik |
| 3 | Kecepatan Sistem | Q5, Q6 | 4,60 | Sangat Baik |
| 4 | Tampilan Antarmuka | Q7, Q8 | 4,20 | Baik |
| 5 | Keandalan | Q9, Q10 | 4,60 | Sangat Baik |
| | **Rata-rata Keseluruhan** | | **4,50** | **Sangat Baik** |

Kategori penilaian ditentukan berdasarkan interval berikut:

**Tabel 4.XX Skala Kategori Penilaian**

| Interval Skor | Kategori |
|---------------|----------|
| 4,21 – 5,00 | Sangat Baik |
| 3,41 – 4,20 | Baik |
| 2,61 – 3,40 | Cukup |
| 1,81 – 2,60 | Kurang |
| 1,00 – 1,80 | Sangat Kurang |

Rata-rata skor keseluruhan sebesar **4,50** dari skala 5,00 menempatkan sistem pada kategori **"Sangat Baik"**, yang menunjukkan tingkat penerimaan yang sangat tinggi dari pengguna.

### c. Analisis Hasil per Aspek

**1) Fungsionalitas (Skor: 4,70 — Sangat Baik)**

Aspek fungsionalitas memperoleh skor tertinggi di antara seluruh aspek yang dievaluasi. Hal ini menunjukkan bahwa fitur-fitur yang dibangun — meliputi absensi QR Code dengan validasi geolocation, input nilai dengan perhitungan otomatis, perhitungan ranking SAW, dan export laporan — telah sesuai dengan kebutuhan operasional pengguna di SMPN 4 Purwakarta. Seluruh peserta memberikan skor 4 atau 5 untuk kedua pertanyaan pada aspek ini, mengindikasikan bahwa tidak ada fitur utama yang dinilai kurang atau tidak berfungsi.

**2) Kemudahan Penggunaan (Skor: 4,40 — Sangat Baik)**

Aspek kemudahan penggunaan mendapatkan skor 4,40. Meskipun masuk kategori "Sangat Baik", skor ini relatif lebih rendah dibanding aspek fungsionalitas. Berdasarkan wawancara, beberapa guru yang kurang familiar dengan teknologi memerlukan waktu adaptasi awal untuk memahami alur navigasi sistem. Namun setelah mencoba 2–3 kali, seluruh peserta menyatakan dapat mengoperasikan sistem secara mandiri tanpa bantuan.

**3) Kecepatan Sistem (Skor: 4,60 — Sangat Baik)**

Peserta menilai bahwa sistem merespons perintah dengan cepat. Proses scan QR Code, loading halaman dashboard, dan proses export laporan berlangsung tanpa delay yang berarti. Penggunaan framework Laravel dengan Vite sebagai build tool dan optimasi query Eloquent berkontribusi pada performa sistem yang responsif.

**4) Tampilan Antarmuka (Skor: 4,20 — Baik)**

Aspek tampilan antarmuka memperoleh skor terendah (4,20), meskipun masih masuk kategori "Baik". Beberapa peserta memberikan skor 4 ("Setuju") yang menunjukkan bahwa tampilan dinilai sudah memadai namun masih ada ruang untuk peningkatan. Berdasarkan feedback, saran perbaikan terkait tampilan meliputi penggunaan ukuran font yang lebih besar pada beberapa halaman dan penyesuaian tata letak untuk layar smartphone berukuran kecil.

**5) Keandalan (Skor: 4,60 — Sangat Baik)**

Peserta menilai bahwa sistem berjalan stabil selama proses evaluasi tanpa mengalami error atau crash. Seluruh peserta menyatakan keyakinan bahwa sistem layak digunakan secara rutin di lingkungan sekolah. Skor keandalan yang tinggi ini sejalan dengan hasil pengujian internal (Black Box 100% berhasil dan White Box 19/19 jalur lolos) yang telah dilakukan sebelumnya.

### d. Feedback Kualitatif dari Pengguna

Peneliti mengumpulkan feedback kualitatif melalui wawancara singkat dengan setiap peserta setelah proses evaluasi:

**Tabel 4.XX Feedback Kualitatif Peserta UAT**

| No | Peserta | Feedback | Kategori |
|----|---------|---------|----------|
| 1 | Kepala Sekolah | "Dashboard monitoring sangat membantu untuk memantau kehadiran guru secara langsung tanpa harus bertanya ke TU. Detail perhitungan SAW juga transparan sehingga bisa dipertanggungjawabkan." | Positif |
| 2 | Guru 1 | "Scan QR Code lewat HP sangat praktis, tidak perlu lagi cari buku absensi. Tapi perlu ada petunjuk di awal supaya tidak bingung saat pertama kali pakai." | Positif + Saran |
| 3 | Guru 2 | "Tampilan input nilai sudah bagus, apalagi sudah ada keterangan bobot perhitungan. Nilai akhir dihitung otomatis jadi tidak perlu kalkulator lagi." | Positif |
| 4 | Guru 3 | "Perlu petunjuk penggunaan singkat untuk guru-guru yang kurang familiar dengan teknologi. Kalau sudah terbiasa, sistemnya mudah dipakai." | Saran |
| 5 | Staf TU | "Export laporan ke Excel sangat menghemat waktu. Yang biasanya 2–3 hari rekapitulasi sekarang bisa langsung jadi. Filter per kelas dan per periode juga sangat membantu." | Positif |

### e. Tingkat Penerimaan Pengguna

Dari 5 evaluator, seluruhnya menyatakan **puas** terhadap sistem yang dikembangkan dan **menyetujui** bahwa sistem ini layak digunakan secara operasional di SMPN 4 Purwakarta. Hal ini terlihat dari skor pertanyaan Q10 ("Layak digunakan rutin") yang memperoleh rata-rata 4,60 — dimana seluruh peserta memberikan skor 4 atau 5. Tidak ada peserta yang memberikan skor di bawah 4 untuk pertanyaan ini.

---

## 4.1.6.3 Perbaikan Akhir Berdasarkan Feedback UAT

Berdasarkan feedback dan saran yang diperoleh dari peserta UAT, peneliti melakukan beberapa perbaikan akhir pada sistem sebelum tahap implementasi:

**Tabel 4.XX Daftar Perbaikan Akhir Berdasarkan Feedback UAT**

| No | Sumber Feedback | Perbaikan yang Dilakukan | Deskripsi | Status |
|----|----------------|-------------------------|-----------|--------|
| 1 | Guru 1, Guru 3 | Penambahan tooltip bantuan | Menambahkan ikon bantuan (?) dengan tooltip pada fitur-fitur utama seperti tombol scan QR, form input nilai, dan halaman perhitungan SAW untuk membantu pengguna baru memahami fungsi setiap elemen | Selesai |
| 2 | Staf TU | Optimasi loading halaman data | Menerapkan *lazy loading* dan paginasi pada tabel data yang memiliki banyak record (data siswa, data kehadiran) agar halaman tidak lambat saat jumlah data semakin besar | Selesai |
| 3 | Guru 2 | Penyesuaian tampilan mobile | Memperbesar area sentuh (*touch target*) tombol-tombol pada tampilan mobile sesuai standar minimum 44×44 pixel agar lebih mudah dioperasikan pada layar smartphone | Selesai |
| 4 | Guru 3 | Penambahan pesan konfirmasi | Menambahkan dialog konfirmasi sebelum aksi penting (hapus data, submit nilai) untuk mencegah kesalahan operasi yang tidak disengaja | Selesai |

Seluruh perbaikan telah diimplementasikan dan diverifikasi ulang sebelum sistem memasuki tahap implementasi akhir (4.1.7 Menggunakan Sistem).

---

## 4.1.6.4 Kesimpulan Evaluasi

Berdasarkan keseluruhan hasil evaluasi, peneliti menyimpulkan bahwa:

1. **Sistem memenuhi kebutuhan pengguna** — skor fungsionalitas 4,70 (Sangat Baik) menunjukkan bahwa fitur-fitur yang dibangun sesuai dengan kebutuhan operasional sekolah.

2. **Sistem dapat dioperasikan dengan mudah** — meskipun beberapa pengguna memerlukan waktu adaptasi awal, seluruh peserta dapat mengoperasikan sistem secara mandiri setelah pengenalan singkat.

3. **Performa sistem memadai** — respon sistem dinilai cepat oleh pengguna dengan skor 4,60 (Sangat Baik), tidak ada keluhan terkait delay atau lambatnya proses.

4. **Sistem stabil dan andal** — selama proses UAT tidak ditemukan error atau crash, sesuai dengan hasil pengujian internal yang menunjukkan kelulusan 100% pada Black Box dan White Box Testing.

5. **Sistem dinyatakan layak digunakan** — seluruh 5 peserta UAT menyetujui bahwa sistem layak digunakan secara rutin di SMPN 4 Purwakarta, dengan skor penerimaan rata-rata 4,50 (Sangat Baik).
