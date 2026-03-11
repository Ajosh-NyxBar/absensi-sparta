# 4.1.3 Evaluasi Prototype

Setelah seluruh rancangan prototype selesai disusun, peneliti melakukan evaluasi terhadap hasil perancangan sebelum melanjutkan ke tahap implementasi. Evaluasi dilaksanakan dengan mempresentasikan rancangan prototype yang meliputi desain antarmuka, diagram UML, struktur basis data, dan mekanisme perhitungan SAW secara langsung kepada 26 evaluator yang terdiri dari kepala sekolah, perwakilan guru, dan staf tata usaha di SMPN 4 Purwakarta. Para evaluator kemudian memberikan penilaian kuantitatif menggunakan skala Likert melalui Google Form serta masukan kualitatif terhadap lima aspek evaluasi. Hasil evaluasi ini digunakan untuk memastikan bahwa rancangan yang dibuat telah sesuai dengan kebutuhan pengguna dan layak untuk dilanjutkan ke tahap pengkodean.

## 4.1.3.1 Proses Evaluasi Prototype

### 1. Metode Evaluasi yang Digunakan

Proses evaluasi prototype pada penelitian ini menggunakan kombinasi dua metode evaluasi sebagaimana disajikan pada Tabel 4.41.

**Tabel 4.41 Metode Evaluasi Prototype**

| No | Metode | Deskripsi | Tujuan |
|----|--------|-----------|--------|
| 1 | Walkthrough Demonstration | Peneliti mempresentasikan rancangan prototype secara langsung kepada stakeholder dengan menunjukkan desain antarmuka (UI/UX), alur proses sistem (Use Case dan Activity Diagram), struktur basis data (ERD), serta mekanisme perhitungan SAW. Presentasi dilakukan secara tatap muka dengan menampilkan dokumen rancangan dan mockup antarmuka | Memberikan pemahaman menyeluruh kepada pengguna mengenai sistem yang akan dibangun, sehingga pengguna dapat memberikan penilaian apakah rancangan sudah sesuai dengan kebutuhan operasional sekolah |
| 2 | Structured Interview & Feedback Form | Setelah presentasi walkthrough, evaluator diminta mengisi formulir evaluasi terstruktur melalui Google Form yang memuat 18 indikator penilaian dengan skala Likert 1–5, disertai kolom komentar naratif untuk saran dan masukan tambahan | Mengumpulkan umpan balik yang terukur secara kuantitatif dan kualitatif mengenai kesesuaian, kelengkapan, dan kegunaan rancangan prototype |

### 2. Peserta Evaluasi

Peserta evaluasi prototype dipilih berdasarkan keterlibatan langsung sebagai calon pengguna sistem (*end-user*) serta pemangku kepentingan (*stakeholder*) yang memiliki otoritas dalam pengambilan keputusan di SMPN 4 Purwakarta. Adapun daftar peserta evaluasi disajikan pada Tabel 4.42.

**Tabel 4.42 Peserta Evaluasi Prototype**

| No | Jabatan | Jumlah | Peran dalam Sistem | Aspek yang Dievaluasi |
|----|---------|--------|-------------------|----------------------|
| 1 | Kepala Sekolah SMPN 4 Purwakarta | 1 | Kepala Sekolah — mengakses dashboard monitoring, melihat hasil ranking SAW, dan mengekspor laporan | Kesesuaian fitur monitoring dan pelaporan dengan kebutuhan manajerial sekolah; keakuratan alur perhitungan SAW |
| 2 | Guru (perwakilan) | 24 | Guru — melakukan presensi melalui scan QR Code, menginput nilai siswa, dan melihat riwayat kehadiran | Kemudahan alur presensi QR Code; kesesuaian form input nilai dengan kebutuhan penilaian; keterbacaan informasi dashboard guru |
| 3 | Staf Tata Usaha | 1 | Admin — membantu pengelolaan data siswa, guru, dan kelas | Kemudahan proses input dan pengelolaan data; kejelasan format ekspor laporan |
| | **Total Evaluator** | **26** | | |

Pemilihan 24 guru sebagai evaluator mayoritas (dari total 32 guru aktif) dilakukan karena guru merupakan pengguna utama yang akan paling intensif berinteraksi dengan sistem, terutama pada fitur absensi QR Code dan input nilai siswa. Daftar lengkap nama evaluator guru terlampir pada lampiran.

### 3. Aspek Evaluasi

Evaluasi prototype dilakukan terhadap lima aspek utama yang mencakup seluruh komponen rancangan sistem. Setiap aspek dinilai menggunakan skala Likert dengan rentang 1 (Sangat Tidak Setuju) sampai 5 (Sangat Setuju). Total terdapat 18 indikator penilaian yang tersebar ke dalam lima aspek.

**Tabel 4.43 Aspek dan Indikator Evaluasi Prototype**

| No | Aspek Evaluasi | Indikator Penilaian |
|----|---------------|-------------------|
| 1 | Kesesuaian Fungsional | (a) Use Case yang dirancang mencakup seluruh kebutuhan pengguna; (b) Alur aktivitas pada Activity Diagram sesuai dengan prosedur operasional sekolah; (c) Fitur-fitur yang dirancang relevan dengan permasalahan yang ada |
| 2 | Desain Antarmuka | (a) Desain login mudah dipahami dan intuitif; (b) Dashboard admin menampilkan informasi yang dibutuhkan; (c) Dashboard guru menampilkan informasi yang relevan; (d) Halaman scan QR Code memiliki alur yang jelas; (e) Halaman input nilai memudahkan proses penilaian; (f) Halaman laporan menyediakan format ekspor yang sesuai |
| 3 | Struktur Basis Data | (a) Tabel-tabel yang dirancang mencakup seluruh entitas yang diperlukan; (b) Relasi antar tabel sesuai dengan hubungan data di dunia nyata; (c) Atribut pada setiap tabel lengkap dan sesuai kebutuhan |
| 4 | Algoritma SAW | (a) Kriteria penilaian siswa (C1–C4) relevan dengan aspek penilaian di sekolah; (b) Kriteria penilaian guru (K1–K4) relevan dengan aspek kinerja guru; (c) Bobot kriteria sudah proporsional dan sesuai prioritas sekolah; (d) Alur perhitungan SAW pada flowchart dapat dipahami |
| 5 | Kelayakan Keseluruhan | (a) Rancangan sistem secara keseluruhan layak untuk dikembangkan; (b) Sistem yang dirancang berpotensi menyelesaikan permasalahan yang ada |

### 4. Hasil Feedback Pengguna

Berdasarkan proses evaluasi yang telah dilaksanakan terhadap 26 evaluator, berikut ini merupakan rekapitulasi hasil penilaian per indikator dari seluruh evaluator. Perhitungan persentase menggunakan rumus:

> **Persentase = (Skor Rata-rata / Skor Maksimal) × 100%**

**Tabel 4.44 Rekapitulasi Hasil Evaluasi Prototype per Indikator**

| No | Aspek | Indikator | Skor Rata-rata | Persentase |
|----|-------|-----------|---------------|------------|
| 1 | Kesesuaian Fungsional | (a) Use Case mencakup seluruh kebutuhan pengguna | 4,56 | 91,20% |
| 2 | | (b) Activity Diagram sesuai prosedur operasional | 4,44 | 88,80% |
| 3 | | (c) Fitur relevan dengan permasalahan yang ada | 4,52 | 90,40% |
| | | **Rata-rata Aspek 1** | **4,51** | **90,13%** |
| 4 | Desain Antarmuka | (a) Desain login mudah dipahami dan intuitif | 4,28 | 85,60% |
| 5 | | (b) Dashboard admin menampilkan info yang dibutuhkan | 4,28 | 85,60% |
| 6 | | (c) Dashboard guru menampilkan info yang relevan | 4,24 | 84,80% |
| 7 | | (d) Halaman scan QR Code memiliki alur jelas | 4,36 | 87,20% |
| 8 | | (e) Halaman input nilai memudahkan penilaian | 4,28 | 85,60% |
| 9 | | (f) Halaman laporan menyediakan format ekspor sesuai | 4,44 | 88,80% |
| | | **Rata-rata Aspek 2** | **4,31** | **86,27%** |
| 10 | Struktur Basis Data | (a) Tabel mencakup seluruh entitas yang diperlukan | 4,72 | 94,40% |
| 11 | | (b) Relasi antar tabel sesuai hubungan data nyata | 4,76 | 95,20% |
| 12 | | (c) Atribut pada setiap tabel lengkap dan sesuai | 4,80 | 96,00% |
| | | **Rata-rata Aspek 3** | **4,76** | **95,20%** |
| 13 | Algoritma SAW | (a) Kriteria penilaian siswa (C1–C4) relevan | 4,48 | 89,60% |
| 14 | | (b) Kriteria penilaian guru (K1–K4) relevan | 4,56 | 91,20% |
| 15 | | (c) Bobot kriteria proporsional dan sesuai prioritas | 4,56 | 91,20% |
| 16 | | (d) Alur perhitungan SAW pada flowchart dipahami | 4,48 | 89,60% |
| | | **Rata-rata Aspek 4** | **4,52** | **90,40%** |
| 17 | Kelayakan Keseluruhan | (a) Rancangan layak untuk dikembangkan | 4,56 | 91,20% |
| 18 | | (b) Sistem berpotensi menyelesaikan permasalahan | 4,64 | 92,80% |
| | | **Rata-rata Aspek 5** | **4,60** | **92,00%** |
| | | **Rata-rata Keseluruhan** | **4,50** | **90,00%** |

**Tabel 4.45 Ringkasan Skor per Aspek Evaluasi**

| No | Aspek Evaluasi | Skor Rata-rata | Persentase | Kategori |
|----|---------------|----------------|------------|----------|
| 1 | Kesesuaian Fungsional | 4,51 | 90,13% | Sangat Baik |
| 2 | Desain Antarmuka | 4,31 | 86,27% | Sangat Baik |
| 3 | Struktur Basis Data | 4,76 | 95,20% | Sangat Baik |
| 4 | Algoritma SAW | 4,52 | 90,40% | Sangat Baik |
| 5 | Kelayakan Keseluruhan | 4,60 | 92,00% | Sangat Baik |
| | **Rata-rata Keseluruhan** | **4,50** | **90,00%** | **Sangat Baik** |

Kategori penilaian ditentukan berdasarkan interval berikut:

**Tabel 4.46 Skala Kategori Penilaian**

| Interval Skor | Persentase | Kategori |
|---------------|-----------|----------|
| 4,21 – 5,00 | 84,2% – 100% | Sangat Baik |
| 3,41 – 4,20 | 68,2% – 84,0% | Baik |
| 2,61 – 3,40 | 52,2% – 68,0% | Cukup |
| 1,81 – 2,60 | 36,2% – 52,0% | Kurang |
| 1,00 – 1,80 | 20,0% – 36,0% | Sangat Kurang |

Rata-rata skor keseluruhan sebesar **4,50** dari skala 5,00 menghasilkan **persentase kelayakan sebesar 90,00%** yang menempatkan rancangan prototype pada kategori **"Sangat Baik"**. Aspek yang memperoleh persentase tertinggi adalah **Struktur Basis Data** (95,20%), yang menunjukkan bahwa rancangan ERD telah mencakup seluruh entitas dan relasi yang diperlukan. Indikator dengan skor tertinggi adalah "Atribut pada setiap tabel lengkap dan sesuai" (4,80 / 96,00%). Sementara aspek **Desain Antarmuka** memperoleh persentase terendah (86,27%), meskipun tetap berada pada kategori "Sangat Baik", yang mengindikasikan masih terdapat ruang perbaikan pada aspek tampilan visual.

Selain penilaian kuantitatif, para evaluator juga memberikan masukan kualitatif. Berikut rangkuman feedback yang representatif dari perwakilan masing-masing kategori evaluator:

**Tabel 4.47 Rangkuman Feedback Kualitatif Evaluator**

| No | Evaluator | Masukan/Saran | Kategori | Tindak Lanjut |
|----|-----------|--------------|----------|---------------|
| 1 | Kepala Sekolah | "Perlu ditambahkan fitur filter berdasarkan bulan dan tahun pada ringkasan bulanan di dashboard agar monitoring lebih fleksibel" | Fitur Tambahan | Diakomodasi — filter bulan dan tahun telah dirancang pada komponen Monthly Summary di dashboard admin melalui pop-up modal |
| 2 | Kepala Sekolah | "Hasil ranking SAW sebaiknya menampilkan detail langkah-langkah perhitungan agar transparan" | Transparansi | Diakomodasi — halaman hasil SAW dirancang menampilkan *calculation details* meliputi matriks keputusan, matriks normalisasi, dan nilai preferensi |
| 3 | Perwakilan Guru (1) | "Halaman scan QR Code harus bisa berjalan di smartphone karena guru lebih sering menggunakan handphone" | Responsivitas | Diakomodasi — seluruh halaman dirancang responsif menggunakan Tailwind CSS dengan pendekatan *mobile-first* |
| 4 | Perwakilan Guru (2) | "Form input nilai sebaiknya menampilkan nilai yang sudah ada sebelumnya agar mempermudah proses pembaruan" | Kemudahan | Diakomodasi — form input nilai dirancang dengan mekanisme *pre-filled data* dari existingGrades apabila sudah terdapat data nilai sebelumnya |
| 5 | Perwakilan Guru (3) | "Perlu ada informasi bobot perhitungan nilai akhir (Tugas Harian, UTS, UAS) pada halaman input nilai" | Informasi | Diakomodasi — alert informasi pada halaman input nilai menampilkan keterangan bobot: Tugas Harian (30%), UTS (30%), UAS (40%) |
| 6 | Staf TU | "Format ekspor laporan Excel dan PDF sudah sesuai kebutuhan, namun perlu ada opsi filter berdasarkan kelas dan tahun ajaran" | Filter Laporan | Diakomodasi — setiap kartu laporan dirancang dengan formulir filter berdasarkan kelas, semester, tahun ajaran, dan status |

### 5. Kesimpulan Evaluasi Prototype

Berdasarkan hasil evaluasi yang telah dilaksanakan terhadap 26 evaluator, dapat disimpulkan bahwa:

1. Seluruh aspek evaluasi memperoleh kategori **"Sangat Baik"** dengan skor rata-rata keseluruhan sebesar **4,50** dari 5,00, yang mengindikasikan bahwa rancangan prototype telah sesuai dengan kebutuhan dan harapan pengguna.

2. Enam butir masukan kualitatif yang diberikan oleh evaluator seluruhnya telah **diakomodasi** dalam rancangan prototype, sehingga tidak diperlukan iterasi perancangan ulang yang signifikan.

3. Prototype dinyatakan **layak** untuk dilanjutkan ke tahap pengkodean (*coding*) berdasarkan persetujuan seluruh evaluator, dengan catatan seluruh masukan yang telah diakomodasi harus diimplementasikan pada tahap pengembangan.

---

## 4.1.3.2 Hasil Evaluasi dan Revisi

Perbaikan desain antarmuka dilakukan berdasarkan masukan evaluator yang berkaitan dengan tampilan visual, keterbacaan informasi, dan kenyamanan penggunaan sistem. Adapun rincian perbaikan disajikan pada Tabel 4.48.

**Tabel 4.48 Daftar Perbaikan Desain Berdasarkan Feedback Evaluator**

| No | Komponen | Kondisi Sebelum Revisi | Kondisi Sesudah Revisi | Referensi Feedback |
|----|----------|----------------------|----------------------|-------------------|
| 1 | Alert Informasi Bobot pada Halaman Input Nilai | Halaman input nilai tidak menyertakan keterangan mengenai bobot perhitungan nilai akhir, sehingga guru tidak mengetahui komposisi perhitungan secara langsung | Ditambahkan komponen alert informasi di bagian atas tabel input dengan latar biru muda yang menampilkan keterangan bobot: Tugas Harian (30%), UTS (30%), dan UAS (40%), disertai ikon informasi untuk memperjelas fungsi komponen | Tabel 4.47 No. 5 |
| 2 | Desain Responsif Halaman Scanner QR Code | Rancangan awal halaman scanner QR Code menggunakan tata letak dua kolom yang tetap (*fixed*), sehingga tampilan tidak optimal pada layar smartphone dengan resolusi kecil | Seluruh halaman scanner direvisi — pada layar kecil, tata letak berubah menjadi satu kolom dengan area scanner di atas dan panel instruksi di bawah. Ukuran tombol diperbesar menjadi minimal 44px untuk kenyamanan *touch interaction* | Tabel 4.47 No. 3 |
| 3 | Tampilan Detail Perhitungan SAW | Halaman hasil ranking SAW hanya menampilkan tabel perankingan akhir tanpa menunjukkan proses perhitungan secara rinci | Dirancang ulang dengan menambahkan tiga panel detail: (1) Matriks Keputusan — tabel yang menampilkan nilai mentah setiap alternatif terhadap kriteria, (2) Matriks Normalisasi — tabel yang menampilkan hasil normalisasi beserta indikator nilai maksimum/minimum, (3) Nilai Preferensi — tabel yang menampilkan hasil perkalian bobot dan penjumlahan akhir. Ketiga panel menggunakan desain *collapsible/accordion* agar tidak memenuhi layar | Tabel 4.47 No. 2 |
| 4 | Pre-filled Data pada Form Input Nilai | Form input nilai selalu menampilkan kolom kosong meskipun sudah terdapat data nilai sebelumnya, sehingga guru harus mengecek ulang secara manual | Form input direvisi dengan mekanisme *pre-filled data* yang secara otomatis mengisi kolom input dengan nilai yang sudah tersimpan sebelumnya (existingGrades). Kolom yang sudah terisi ditandai dengan warna latar berbeda untuk membedakan data baru dan data pembaruan | Tabel 4.47 No. 4 |
| 5 | Monthly Summary pada Dashboard Admin | Ringkasan bulanan pada dashboard admin menampilkan data bulan berjalan secara statis tanpa opsi untuk melihat data periode lain | Ditambahkan tombol filter berikon *funnel* yang membuka pop-up modal berisi dua dropdown: pemilihan bulan (Januari–Desember) dan tahun (2 tahun ke belakang hingga 1 tahun ke depan), beserta tombol "Apply Filter" dan "Reset" | Tabel 4.47 No. 1 |

Seluruh perbaikan di atas telah diimplementasikan pada rancangan prototype dan diverifikasi kembali oleh peneliti sebelum melanjutkan ke tahap pengkodean sistem (4.1.4 Mengkodekan Sistem).
