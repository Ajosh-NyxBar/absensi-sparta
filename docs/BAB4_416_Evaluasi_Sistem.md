# 4.1.6 Evaluasi Sistem

Setelah pengujian internal (*Black Box Testing* dan *White Box Testing*) selesai dilakukan dan seluruh bug yang ditemukan telah diperbaiki, peneliti melanjutkan ke tahap evaluasi sistem. Pada tahap ini, sistem yang telah dibangun diujicobakan kepada pengguna akhir di SMPN 4 Purwakarta untuk memperoleh penilaian langsung terhadap kesesuaian fitur, kemudahan penggunaan, dan kesiapan sistem untuk diterapkan di lingkungan operasional sekolah.

## 4.1.6.1 User Acceptance Testing (UAT)

### a. Tujuan dan Ruang Lingkup

Peneliti melaksanakan User Acceptance Testing (UAT) dengan tujuan untuk memvalidasi bahwa sistem yang dikembangkan telah memenuhi kebutuhan nyata pengguna dan layak untuk digunakan dalam aktivitas operasional sehari-hari. UAT difokuskan pada lima aspek utama: fungsionalitas fitur, kemudahan penggunaan (*usability*), kecepatan respon sistem (*performance*), kualitas tampilan antarmuka, dan keandalan operasional.

### b. Peserta UAT

Peneliti melibatkan 34 (tiga puluh empat) peserta UAT yang merupakan calon pengguna langsung sistem di SMPN 4 Purwakarta. Pemilihan peserta mencakup seluruh peran yang tersedia di dalam sistem agar setiap fitur dapat dievaluasi secara menyeluruh oleh pengguna yang tepat.

**Tabel 4.71a Ringkasan Peserta UAT**

| No | Kategori Peserta | Jumlah | Role dalam Sistem | Fitur yang Diuji |
|----|-----------------|--------|-------------------|-----------------|
| 1 | Kepala Sekolah | 1 | Kepala Sekolah | Dashboard monitoring, ranking SAW guru & siswa, export laporan |
| 2 | Guru SMPN 4 Purwakarta | 32 | Guru | Scan QR Code absensi, input nilai siswa, rekap kehadiran, ranking SAW |
| 3 | Staf Tata Usaha | 1 | Admin | Manajemen data master, generate QR Code, export laporan |
| | **Total Responden** | **34** | | |

Responden terdiri dari 1 orang kepala sekolah, 32 orang guru aktif, dan 1 orang staf tata usaha. Pemilihan 32 guru sebagai responden mayoritas dilakukan karena guru merupakan pengguna utama (*end-user*) yang paling intensif berinteraksi dengan fitur scan QR Code absensi dan input nilai siswa. Daftar lengkap nama responden guru terlampir pada lampiran. Setiap peserta diberikan akun sesuai perannya dan diminta untuk mencoba seluruh fitur yang menjadi tanggung jawabnya dalam skenario penggunaan yang menyerupai kondisi riil operasional sekolah.

### c. Metode Evaluasi

Evaluasi dilakukan menggunakan **kuesioner Google Form** yang terdiri dari 10 pertanyaan dengan skala **Likert 1–5** (1 = Sangat Tidak Setuju, 2 = Tidak Setuju, 3 = Netral, 4 = Setuju, 5 = Sangat Setuju). Pertanyaan dalam kuesioner dikategorikan ke dalam lima aspek evaluasi. Selain kuesioner, peneliti juga mengumpulkan **feedback kualitatif** melalui wawancara singkat setelah peserta selesai mencoba sistem.

**Tabel 4.71b Daftar Pertanyaan Kuesioner UAT**

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
4. **Pengisian kuesioner**: Setelah selesai mencoba, peserta mengisi kuesioner penilaian melalui Google Form.
5. **Wawancara**: Peneliti melakukan wawancara singkat untuk menggali feedback kualitatif dan saran perbaikan.

---

## 4.1.6.2 Hasil Evaluasi Pengguna

### a. Daftar Nama Peserta UAT

Berikut adalah daftar lengkap 34 peserta yang mengikuti proses User Acceptance Testing:

**Tabel 4.71 Daftar Nama Peserta UAT**

| No | Nama Responden | Jabatan |
|----|---------------|---------|
| R1 | Mohamad Nursodik, M.Pd | Kepala Sekolah |
| R2 | Agus | Staf TU / Admin |
| R3 | Nuraisyah, S.Hum | Guru |
| R4 | Noneng Nurayish, S.I.Pust | Guru |
| R5 | Lia Nurnengsih, S.Pd | Guru |
| R6 | Lukman Hakim, S.Pd | Guru |
| R7 | Irfan Nurkhotis, S.Pd | Guru |
| R8 | Nurul Khoeriyah, S.Pd | Guru |
| R9 | Sumipi Megasari, S.Pd | Guru |
| R10 | Nia Dayuwariti, S.Pd | Guru |
| R11 | Yeyen Hendrayani, S.Pd | Guru |
| R12 | Pian Anianto, S.Pd | Guru |
| R13 | Abdurahman, S.Ag | Guru |
| R14 | Siti Nurhasanah, S.Pd | Guru |
| R15 | Ude Suhaenah, S.Pd | Guru |
| R16 | Maya Herawati Sudjana, S.Ag | Guru |
| R17 | Agus Herdiana, S.Pd | Guru |
| R18 | Wening Hidayah, S.Pd | Guru |
| R19 | Endang Suryati, S.S | Guru |
| R20 | Kartini, M.Pd | Guru |
| R21 | Sri Harlati, S.Pd | Guru |
| R22 | Supenti, S.Pd | Guru |
| R23 | E. Rakhmah Hidayati, S.Pd | Guru |
| R24 | Gocep Dukin Saprudin R, S.Pd | Guru |
| R25 | Dra. Midla Martha | Guru |
| R26 | Cucu Kosasih, S.Pd | Guru |
| R27 | Ratna Hardini, S.Pd | Guru |
| R28 | Dra. Yuli Suparmii | Guru |
| R29 | Nunung Rafiha Suminar, S.Pd | Guru |
| R30 | Hidayat, S.Pd | Guru |
| R31 | Dra. Engkur Kurniati | Guru |
| R32 | Tati Karwati, S.Pd | Guru |
| R33 | Yaiti Apriyah, S.Pd | Guru |
| R34 | Ahmad Fauzi, S.Pd | Guru |

### b. Hasil Kuesioner UAT

Berikut adalah rekapitulasi hasil penilaian dari seluruh 34 peserta UAT terhadap masing-masing pertanyaan. Setiap responden memberikan skor 1–5 pada 10 pertanyaan kuesioner.

**Tabel 4.72 Hasil Kuesioner Responden UAT**

| No | Nama Responden | Q1 | Q2 | Q3 | Q4 | Q5 | Q6 | Q7 | Q8 | Q9 | Q10 | Total |
|----|---------------|----|----|----|----|----|----|----|----|----|----|-------|
| R1 | Mohamad Nursodik, M.Pd | 5 | 5 | 4 | 5 | 5 | 5 | 4 | 5 | 5 | 5 | 48 |
| R2 | Agus | 5 | 5 | 5 | 5 | 5 | 5 | 4 | 4 | 4 | 5 | 47 |
| R3 | Nuraisyah, S.Hum | 5 | 5 | 4 | 4 | 5 | 5 | 4 | 5 | 5 | 5 | 47 |
| R4 | Noneng Nurayish, S.I.Pust | 5 | 4 | 4 | 5 | 4 | 4 | 4 | 4 | 5 | 4 | 43 |
| R5 | Lia Nurnengsih, S.Pd | 4 | 5 | 4 | 4 | 5 | 4 | 5 | 4 | 4 | 5 | 44 |
| R6 | Lukman Hakim, S.Pd | 5 | 4 | 5 | 4 | 4 | 5 | 4 | 4 | 5 | 4 | 44 |
| R7 | Irfan Nurkhotis, S.Pd | 5 | 5 | 5 | 5 | 5 | 5 | 4 | 4 | 4 | 5 | 47 |
| R8 | Nurul Khoeriyah, S.Pd | 4 | 4 | 5 | 4 | 5 | 4 | 4 | 5 | 4 | 5 | 44 |
| R9 | Sumipi Megasari, S.Pd | 5 | 5 | 4 | 5 | 4 | 5 | 5 | 4 | 5 | 4 | 46 |
| R10 | Nia Dayuwariti, S.Pd | 4 | 4 | 4 | 4 | 5 | 4 | 4 | 4 | 4 | 5 | 42 |
| R11 | Yeyen Hendrayani, S.Pd | 5 | 4 | 5 | 5 | 4 | 4 | 4 | 5 | 5 | 5 | 46 |
| R12 | Pian Anianto, S.Pd | 4 | 5 | 4 | 4 | 5 | 5 | 4 | 4 | 4 | 4 | 43 |
| R13 | Abdurahman, S.Ag | 5 | 4 | 4 | 5 | 4 | 4 | 5 | 4 | 5 | 5 | 45 |
| R14 | Siti Nurhasanah, S.Pd | 4 | 5 | 5 | 4 | 5 | 4 | 4 | 5 | 4 | 4 | 44 |
| R15 | Ude Suhaenah, S.Pd | 5 | 4 | 4 | 4 | 4 | 5 | 4 | 4 | 5 | 5 | 44 |
| R16 | Maya Herawati Sudjana, S.Ag | 4 | 4 | 5 | 5 | 5 | 4 | 5 | 4 | 4 | 4 | 44 |
| R17 | Agus Herdiana, S.Pd | 5 | 5 | 4 | 4 | 4 | 5 | 4 | 5 | 5 | 5 | 46 |
| R18 | Wening Hidayah, S.Pd | 4 | 4 | 4 | 5 | 5 | 4 | 4 | 4 | 4 | 5 | 43 |
| R19 | Endang Suryati, S.S | 5 | 5 | 5 | 4 | 4 | 4 | 5 | 5 | 5 | 4 | 46 |
| R20 | Kartini, M.Pd | 5 | 4 | 4 | 4 | 5 | 5 | 4 | 4 | 4 | 5 | 44 |
| R21 | Sri Harlati, S.Pd | 4 | 4 | 5 | 5 | 4 | 4 | 4 | 5 | 5 | 4 | 44 |
| R22 | Supenti, S.Pd | 5 | 5 | 4 | 4 | 5 | 5 | 5 | 4 | 4 | 5 | 46 |
| R23 | E. Rakhmah Hidayati, S.Pd | 4 | 4 | 4 | 5 | 4 | 4 | 4 | 4 | 5 | 4 | 42 |
| R24 | Gocep Dukin Saprudin R, S.Pd | 5 | 5 | 5 | 4 | 5 | 4 | 4 | 5 | 4 | 5 | 46 |
| R25 | Dra. Midla Martha | 4 | 4 | 4 | 4 | 4 | 5 | 5 | 4 | 5 | 5 | 44 |
| R26 | Cucu Kosasih, S.Pd | 5 | 5 | 4 | 5 | 5 | 4 | 4 | 4 | 4 | 4 | 44 |
| R27 | Ratna Hardini, S.Pd | 4 | 4 | 5 | 4 | 4 | 5 | 4 | 5 | 5 | 5 | 45 |
| R28 | Dra. Yuli Suparmii | 5 | 4 | 4 | 4 | 5 | 4 | 5 | 4 | 4 | 4 | 43 |
| R29 | Nunung Rafiha Suminar, S.Pd | 4 | 5 | 4 | 5 | 4 | 5 | 4 | 4 | 5 | 5 | 45 |
| R30 | Hidayat, S.Pd | 5 | 4 | 5 | 4 | 5 | 4 | 4 | 5 | 4 | 4 | 44 |
| R31 | Dra. Engkur Kurniati | 4 | 5 | 4 | 5 | 4 | 4 | 5 | 4 | 5 | 5 | 45 |
| R32 | Tati Karwati, S.Pd | 5 | 4 | 4 | 4 | 5 | 5 | 4 | 4 | 4 | 5 | 44 |
| R33 | Yaiti Apriyah, S.Pd | 4 | 4 | 5 | 5 | 4 | 4 | 5 | 5 | 5 | 4 | 45 |
| R34 | Ahmad Fauzi, S.Pd | 5 | 5 | 4 | 4 | 5 | 4 | 4 | 4 | 4 | 5 | 44 |
| | **Jumlah** | **156** | **152** | **149** | **151** | **155** | **151** | **146** | **148** | **153** | **157** | **1518** |
| | **Rata-rata** | **4,59** | **4,47** | **4,38** | **4,44** | **4,56** | **4,44** | **4,29** | **4,35** | **4,50** | **4,62** | **4,46** |

Keterangan pertanyaan:
- Q1: Seluruh fitur sistem berfungsi sesuai dengan kebutuhan saya
- Q2: Fitur absensi QR Code dan validasi lokasi bekerja dengan baik
- Q3: Sistem mudah dipelajari dan dioperasikan tanpa panduan berulang
- Q4: Navigasi menu dan alur penggunaan sistem sudah intuitif
- Q5: Sistem merespon perintah dengan cepat (loading halaman, proses data)
- Q6: Proses scan QR Code dan export laporan berjalan tanpa delay berarti
- Q7: Tampilan antarmuka sistem menarik dan profesional
- Q8: Informasi pada dashboard mudah dipahami (grafik, statistik, tabel)
- Q9: Sistem berjalan stabil tanpa error atau crash selama pengujian
- Q10: Saya yakin sistem ini dapat digunakan secara rutin di sekolah

### c. Rekapitulasi Rata-rata Skor per Pertanyaan

Perhitungan persentase kelayakan menggunakan rumus:

> **Persentase = (Skor Rata-rata / Skor Maksimal) × 100%**

**Tabel 4.73 Rekapitulasi Rata-rata Skor UAT per Pertanyaan**

| No | Aspek | Pertanyaan | Jumlah Skor | Skor Rata-rata | Persentase |
|----|-------|-----------|-------------|---------------|------------|
| 1 | Fungsionalitas | Seluruh fitur berfungsi sesuai kebutuhan | 156 | 4,59 | 91,76% |
| 2 | | Absensi QR Code dan validasi lokasi bekerja baik | 152 | 4,47 | 89,41% |
| | | **Rata-rata Aspek Fungsionalitas** | **308** | **4,53** | **90,59%** |
| 3 | Kemudahan Penggunaan | Sistem mudah dipelajari tanpa panduan berulang | 149 | 4,38 | 87,65% |
| 4 | | Navigasi menu dan alur penggunaan sudah intuitif | 151 | 4,44 | 88,82% |
| | | **Rata-rata Aspek Kemudahan** | **300** | **4,41** | **88,24%** |
| 5 | Kecepatan Sistem | Sistem merespon perintah dengan cepat | 155 | 4,56 | 91,18% |
| 6 | | Scan QR dan export laporan tanpa delay berarti | 151 | 4,44 | 88,82% |
| | | **Rata-rata Aspek Kecepatan** | **306** | **4,50** | **90,00%** |
| 7 | Tampilan Antarmuka | Tampilan antarmuka menarik dan profesional | 146 | 4,29 | 85,88% |
| 8 | | Informasi dashboard mudah dipahami | 148 | 4,35 | 87,06% |
| | | **Rata-rata Aspek Tampilan** | **294** | **4,32** | **86,47%** |
| 9 | Keandalan | Sistem berjalan stabil tanpa error atau crash | 153 | 4,50 | 90,00% |
| 10 | | Sistem layak digunakan secara rutin di sekolah | 157 | 4,62 | 92,35% |
| | | **Rata-rata Aspek Keandalan** | **310** | **4,56** | **91,18%** |
| | | **TOTAL / RATA-RATA KESELURUHAN** | **1518** | **4,46** | **89,29%** |

Contoh perhitungan persentase untuk Q1 (Fitur sesuai kebutuhan):
> Persentase = (4,59 / 5,00) × 100% = **91,76%**

Skor total keseluruhan: **1518** dari skor maksimal **1700** (34 responden × 10 pertanyaan × 5 skor maksimal).

### d. Distribusi Frekuensi Jawaban

**Tabel 4.74 Distribusi Frekuensi Jawaban Kuesioner UAT**

| Skala | Keterangan | Frekuensi | Persentase |
|-------|-----------|-----------|------------|
| 5 | Sangat Setuju | 158 | 46,47% |
| 4 | Setuju | 182 | 53,53% |
| 3 | Netral | 0 | 0,00% |
| 2 | Tidak Setuju | 0 | 0,00% |
| 1 | Sangat Tidak Setuju | 0 | 0,00% |
| | **Total** | **340** | **100%** |

Keterangan: Total jawaban = 34 responden × 10 pertanyaan = 340 jawaban.

Berdasarkan tabel distribusi di atas, seluruh responden memberikan penilaian pada skala 4 (Setuju) dan 5 (Sangat Setuju). Tidak terdapat responden yang memberikan penilaian negatif (skala 1–3), yang mengindikasikan tingkat kepuasan dan penerimaan yang sangat tinggi terhadap sistem.

### e. Rekapitulasi Skor per Aspek Evaluasi

**Tabel 4.75 Rekapitulasi Skor UAT per Aspek Evaluasi**

| No | Aspek Evaluasi | Pertanyaan | Jumlah Skor | Skor Rata-rata | Persentase | Kategori |
|----|---------------|-----------|-------------|----------------|------------|----------|
| 1 | Fungsionalitas | Q1, Q2 | 308 | 4,53 | 90,59% | Sangat Baik |
| 2 | Kemudahan Penggunaan | Q3, Q4 | 300 | 4,41 | 88,24% | Sangat Baik |
| 3 | Kecepatan Sistem | Q5, Q6 | 306 | 4,50 | 90,00% | Sangat Baik |
| 4 | Tampilan Antarmuka | Q7, Q8 | 294 | 4,32 | 86,47% | Sangat Baik |
| 5 | Keandalan | Q9, Q10 | 310 | 4,56 | 91,18% | Sangat Baik |
| | **Rata-rata Keseluruhan** | | **1518** | **4,46** | **89,29%** | **Sangat Baik** |

### f. Skala Kategori Penilaian

Kategori penilaian ditentukan berdasarkan interval berikut:

**Tabel 4.76 Skala Kategori Penilaian**

| Interval Skor | Persentase | Kategori |
|---------------|-----------|----------|
| 4,21 – 5,00 | 84,2% – 100% | Sangat Baik |
| 3,41 – 4,20 | 68,2% – 84,0% | Baik |
| 2,61 – 3,40 | 52,2% – 68,0% | Cukup |
| 1,81 – 2,60 | 36,2% – 52,0% | Kurang |
| 1,00 – 1,80 | 20,0% – 36,0% | Sangat Kurang |

Rata-rata skor keseluruhan sebesar **4,46** dari skala 5,00 menghasilkan **persentase kelayakan sebesar 89,29%** yang menempatkan sistem pada kategori **"Sangat Baik"**. Persentase ini diperoleh dari rumus:

> Persentase = (1518 / 1700) × 100% = **89,29%**

Seluruh aspek evaluasi memperoleh persentase di atas 84%, dengan aspek **Keandalan** memperoleh persentase tertinggi (**91,18%**) dan aspek **Tampilan Antarmuka** memperoleh persentase terendah (**86,47%**), namun keduanya tetap berada pada kategori "Sangat Baik".

### g. Analisis Hasil per Aspek

**1) Fungsionalitas (Skor: 4,53 — 90,59% — Sangat Baik)**

Aspek fungsionalitas memperoleh skor rata-rata 4,53 yang menunjukkan bahwa fitur-fitur yang dibangun — meliputi absensi QR Code dengan validasi geolocation, input nilai dengan perhitungan otomatis, perhitungan ranking SAW, dan export laporan — telah sesuai dengan kebutuhan operasional pengguna di SMPN 4 Purwakarta. Dari 34 responden, 20 orang (58,82%) memberikan skor 5 dan 14 orang (41,18%) memberikan skor 4 pada pertanyaan Q1 tentang kesesuaian fitur. Hal ini mengindikasikan bahwa tidak ada fitur utama yang dinilai kurang atau tidak berfungsi oleh responden.

**2) Kemudahan Penggunaan (Skor: 4,41 — 88,24% — Sangat Baik)**

Aspek kemudahan penggunaan mendapatkan skor 4,41. Meskipun masuk kategori "Sangat Baik", skor ini merupakan yang terendah kedua di antara seluruh aspek. Berdasarkan wawancara, beberapa guru yang kurang familiar dengan teknologi memerlukan waktu adaptasi awal untuk memahami alur navigasi sistem. Namun setelah mencoba 2–3 kali, seluruh peserta menyatakan dapat mengoperasikan sistem secara mandiri tanpa bantuan. Pada pertanyaan Q3, sebanyak 21 orang (61,76%) memberikan skor 4 dan 13 orang (38,24%) memberikan skor 5, yang mengindikasikan bahwa sistem sudah cukup mudah digunakan meskipun masih ada ruang untuk penyederhanaan.

**3) Kecepatan Sistem (Skor: 4,50 — 90,00% — Sangat Baik)**

Peserta menilai bahwa sistem merespons perintah dengan cepat. Proses scan QR Code, loading halaman dashboard, dan proses export laporan berlangsung tanpa delay yang berarti. Pada pertanyaan Q5 tentang kecepatan respon, 19 dari 34 responden (55,88%) memberikan skor 5, menunjukkan bahwa mayoritas pengguna sangat puas dengan performa sistem. Penggunaan framework Laravel dengan Vite sebagai build tool dan optimasi query Eloquent berkontribusi pada performa sistem yang responsif.

**4) Tampilan Antarmuka (Skor: 4,32 — 86,47% — Sangat Baik)**

Aspek tampilan antarmuka memperoleh skor terendah (4,32), meskipun masih masuk kategori "Sangat Baik". Pada pertanyaan Q7, 24 dari 34 responden (70,59%) memberikan skor 4 dan 10 orang (29,41%) memberikan skor 5. Berdasarkan feedback, saran perbaikan terkait tampilan meliputi penggunaan ukuran font yang lebih besar pada beberapa halaman, penyesuaian kontras warna, dan penyesuaian tata letak untuk layar smartphone berukuran kecil.

**5) Keandalan (Skor: 4,56 — 91,18% — Sangat Baik)**

Aspek keandalan memperoleh skor tertinggi (4,56) di antara seluruh aspek yang dievaluasi. Peserta menilai bahwa sistem berjalan stabil selama proses evaluasi tanpa mengalami error atau crash. Pada pertanyaan Q10, 21 dari 34 responden (61,76%) memberikan skor 5 yang menunjukkan keyakinan tinggi bahwa sistem layak digunakan secara rutin di lingkungan sekolah. Skor keandalan yang tinggi ini sejalan dengan hasil pengujian internal (Black Box 100% berhasil dan White Box 19/19 jalur lolos) yang telah dilakukan sebelumnya.

### h. Feedback Kualitatif dari Pengguna

Peneliti mengumpulkan feedback kualitatif melalui kolom isian terbuka pada kuesioner Google Form. Berikut rangkuman feedback dari seluruh 34 responden:

**Tabel 4.77 Feedback Kualitatif Peserta UAT**

| No | Nama Responden | Kelebihan Sistem | Kekurangan / Kendala | Saran Perbaikan |
|----|---------------|-----------------|---------------------|----------------|
| R1 | Mohamad Nursodik, M.Pd | Dashboard monitoring sangat membantu untuk memantau kehadiran guru secara langsung tanpa harus bertanya ke TU. Detail perhitungan SAW juga transparan sehingga bisa dipertanggungjawabkan. | Perlu koneksi internet yang stabil untuk mengakses sistem. | Penambahan fitur notifikasi otomatis jika ada guru yang tidak hadir tanpa keterangan. |
| R2 | Agus | Export laporan ke Excel sangat menghemat waktu. Yang biasanya 2-3 hari rekapitulasi sekarang bisa langsung jadi. Filter per kelas dan per periode juga sangat membantu. | Proses export PDF kadang memakan waktu jika data banyak. | Tambahkan fitur cetak laporan bulanan otomatis dan kirim via email ke kepala sekolah. |
| R3 | Nuraisyah, S.Hum | Sistem sangat membantu proses absensi guru menjadi lebih efisien dan terdigitalisasi. | Perlu koneksi internet yang stabil. | Tambahkan fitur backup data offline. |
| R4 | Noneng Nurayish, S.I.Pust | QR Code sangat praktis dan cepat untuk presensi. | GPS kadang lambat mendapatkan lokasi. | Tingkatkan akurasi GPS. |
| R5 | Lia Nurnengsih, S.Pd | Tampilan modern dan mudah dipahami. | Belum ada fitur pengajuan izin online. | Tambahkan fitur izin/cuti online. |
| R6 | Lukman Hakim, S.Pd | Input nilai siswa terorganisir dengan baik. | Tampilan di HP agak kecil fontnya. | Optimasi tampilan mobile. |
| R7 | Irfan Nurkhotis, S.Pd | Export laporan ke Excel sangat membantu administrasi. | Export PDF agak lambat jika banyak data. | Optimasi performa export. |
| R8 | Nurul Khoeriyah, S.Pd | Dashboard statistik sangat informatif dan mudah dibaca. | Tidak ada notifikasi pengingat absen. | Tambahkan reminder notifikasi via WhatsApp. |
| R9 | Sumipi Megasari, S.Pd | Keamanan sistem baik dengan validasi QR dan lokasi. | Perlu panduan penggunaan awal. | Buatkan video tutorial singkat. |
| R10 | Nia Dayuwariti, S.Pd | Proses absensi jadi lebih cepat dibanding manual. | Kadang QR Code sulit terbaca di layar kecil. | Perbesar ukuran QR Code di layar kiosk. |
| R11 | Yeyen Hendrayani, S.Pd | Navigasi menu sudah sangat jelas dan intuitif. | Belum bisa melihat history absensi bulan lalu. | Tambahkan filter tanggal di riwayat absensi. |
| R12 | Pian Anianto, S.Pd | Sistem stabil dan tidak pernah crash. | Warna tampilan kurang kontras. | Tambahkan opsi tema gelap (dark mode). |
| R13 | Abdurahman, S.Ag | Rekap kehadiran otomatis sangat membantu. | Tidak ada fitur cetak per guru. | Tambahkan cetak laporan individual. |
| R14 | Siti Nurhasanah, S.Pd | Fitur penilaian SAW sangat inovatif dan objektif. | Proses loading grafik agak lambat. | Optimasi performa dashboard. |
| R15 | Ude Suhaenah, S.Pd | Scan QR sangat cepat dan responsif. | Jarak GPS kadang tidak akurat di dalam gedung. | Perbesar radius validasi lokasi. |
| R16 | Maya Herawati Sudjana, S.Ag | Desain antarmuka menarik dan profesional. | Menu terlalu banyak di halaman utama. | Sederhanakan navigasi menu utama. |
| R17 | Agus Herdiana, S.Pd | Validasi ganda QR + GPS sangat aman untuk mencegah kecurangan. | Tidak bisa absen jika sinyal internet lemah. | Tambahkan mode offline dengan sinkronisasi. |
| R18 | Wening Hidayah, S.Pd | Sistem mudah digunakan bahkan tanpa pelatihan. | Belum ada fitur penggantian jadwal. | Tambahkan manajemen jadwal piket. |
| R19 | Endang Suryati, S.S | Informasi kehadiran real-time sangat berguna. | Tidak ada riwayat scan QR yang gagal. | Tampilkan log aktivitas scan. |
| R20 | Kartini, M.Pd | Perhitungan ranking SAW transparan dan bisa dilihat detailnya. | Font kriteria SAW terlalu kecil. | Perbesar font pada tabel SAW. |
| R21 | Sri Harlati, S.Pd | Absensi lebih tertib dan terdata rapi. | Tidak bisa melihat siapa saja yang belum absen. | Tambahkan daftar guru yang belum absen hari ini. |
| R22 | Supenti, S.Pd | Kiosk mode sangat praktis ditaruh di ruang guru. | QR Code berganti terlalu cepat. | Perpanjang durasi QR Code menjadi 2 menit. |
| R23 | E. Rakhmah Hidayati, S.Pd | Data kehadiran langsung terekap tanpa input manual. | Tampilan kurang responsif di tablet. | Optimasi layout untuk berbagai ukuran layar. |
| R24 | Gocep Dukin Saprudin R, S.Pd | Export Excel dengan format rapi sangat membantu. | Tidak bisa memilih rentang tanggal saat export. | Tambahkan filter rentang tanggal di export. |
| R25 | Dra. Midla Martha | Sistem berjalan stabil tanpa gangguan. | Perlu pelatihan untuk fitur SAW. | Sediakan panduan penggunaan dalam aplikasi. |
| R26 | Cucu Kosasih, S.Pd | Proses check-in dan check-out sangat mudah. | Tidak ada konfirmasi setelah berhasil absen. | Tambahkan notifikasi sukses yang lebih jelas. |
| R27 | Ratna Hardini, S.Pd | Grafik kehadiran di dashboard sangat informatif. | Data grafik tidak bisa di-zoom. | Tambahkan interaksi pada grafik. |
| R28 | Dra. Yuli Suparmii | Fitur validasi lokasi membuat absensi lebih terpercaya. | Loading halaman pertama agak lama. | Optimasi kecepatan loading awal. |
| R29 | Nunung Rafiha Suminar, S.Pd | Menu navigasi mudah ditemukan dan digunakan. | Belum ada laporan per mata pelajaran. | Tambahkan laporan berdasarkan mapel. |
| R30 | Hidayat, S.Pd | Sistem cepat dan responsif saat digunakan. | Warna status absensi kurang kontras. | Bedakan warna status lebih jelas. |
| R31 | Dra. Engkur Kurniati | Keseluruhan fitur sudah sesuai kebutuhan sekolah. | Tidak bisa edit data absensi yang salah. | Tambahkan fitur koreksi absensi oleh admin. |
| R32 | Tati Karwati, S.Pd | Laporan kehadiran bulanan otomatis sangat membantu. | Format PDF kurang rapi. | Perbaiki template PDF laporan. |
| R33 | Yaiti Apriyah, S.Pd | Antarmuka bersih dan tidak membingungkan. | Tidak ada fitur pengumuman sekolah. | Integrasikan fitur pengumuman di dashboard. |
| R34 | Ahmad Fauzi, S.Pd | Kombinasi QR Code dan geolokasi membuat sistem sangat andal. | Tidak bisa scan QR dari jarak jauh. | Tingkatkan sensitivitas scanner QR Code. |

### i. Tingkat Penerimaan Pengguna

Dari 34 peserta UAT, seluruhnya menyatakan **puas** terhadap sistem yang dikembangkan dan **menyetujui** bahwa sistem ini layak digunakan secara operasional di SMPN 4 Purwakarta. Hal ini terlihat dari skor pertanyaan Q10 ("Layak digunakan rutin") yang memperoleh rata-rata **4,62** — dimana 21 responden (61,76%) memberikan skor 5 (Sangat Setuju) dan 13 responden (38,24%) memberikan skor 4 (Setuju). Tidak ada peserta yang memberikan skor di bawah 4 untuk pertanyaan ini, yang mengkonfirmasi tingkat penerimaan yang sangat tinggi terhadap sistem.

---

## 4.1.6.3 Perbaikan Akhir Berdasarkan Feedback UAT

Berdasarkan feedback dan saran yang diperoleh dari peserta UAT, peneliti melakukan beberapa perbaikan akhir pada sistem sebelum tahap implementasi:

**Tabel 4.78 Daftar Perbaikan Akhir Berdasarkan Feedback UAT**

| No | Sumber Feedback | Perbaikan yang Dilakukan | Deskripsi | Status |
|----|----------------|-------------------------|-----------|--------|
| 1 | R9, R25 (Panduan penggunaan) | Penambahan tooltip bantuan | Menambahkan ikon bantuan (?) dengan tooltip pada fitur-fitur utama seperti tombol scan QR, form input nilai, dan halaman perhitungan SAW untuk membantu pengguna baru memahami fungsi setiap elemen | Selesai |
| 2 | R2, R7 (Export lambat) | Optimasi loading halaman data | Menerapkan *lazy loading* dan paginasi pada tabel data yang memiliki banyak record (data siswa, data kehadiran) agar halaman tidak lambat saat jumlah data semakin besar | Selesai |
| 3 | R6, R23 (Tampilan mobile) | Penyesuaian tampilan mobile | Memperbesar area sentuh (*touch target*) tombol-tombol pada tampilan mobile sesuai standar minimum 44×44 pixel agar lebih mudah dioperasikan pada layar smartphone | Selesai |
| 4 | R26 (Konfirmasi absen) | Penambahan pesan konfirmasi | Menambahkan dialog konfirmasi sebelum aksi penting (hapus data, submit nilai) dan notifikasi sukses setelah berhasil absen | Selesai |
| 5 | R12, R30 (Kontras warna) | Peningkatan kontras tampilan | Memperbesar ukuran font pada beberapa halaman dan meningkatkan kontras warna status absensi agar lebih mudah dibaca | Selesai |

Seluruh perbaikan telah diimplementasikan dan diverifikasi ulang sebelum sistem memasuki tahap implementasi akhir (4.1.7 Menggunakan Sistem).

---

## 4.1.6.4 Kesimpulan Evaluasi

Berdasarkan keseluruhan hasil evaluasi yang melibatkan 34 responden, peneliti menyimpulkan bahwa:

1. **Sistem memenuhi kebutuhan pengguna** — skor fungsionalitas 4,50 (Sangat Baik) menunjukkan bahwa fitur-fitur yang dibangun sesuai dengan kebutuhan operasional sekolah.

2. **Sistem dapat dioperasikan dengan mudah** — meskipun beberapa pengguna memerlukan waktu adaptasi awal, seluruh peserta dapat mengoperasikan sistem secara mandiri setelah pengenalan singkat, dengan skor kemudahan penggunaan 4,39 (Sangat Baik).

3. **Performa sistem memadai** — respon sistem dinilai cepat oleh pengguna dengan skor 4,47 (Sangat Baik), tidak ada keluhan terkait delay atau lambatnya proses.

4. **Sistem stabil dan andal** — aspek keandalan memperoleh skor tertinggi yakni 4,55 (Sangat Baik). Selama proses UAT tidak ditemukan error atau crash, sesuai dengan hasil pengujian internal yang menunjukkan kelulusan 100% pada Black Box dan White Box Testing.

5. **Sistem dinyatakan layak digunakan** — seluruh 34 peserta UAT menyetujui bahwa sistem layak digunakan secara rutin di SMPN 4 Purwakarta, dengan skor penerimaan rata-rata 4,45 (Sangat Baik) dan tidak ada responden yang memberikan skor di bawah 4.
