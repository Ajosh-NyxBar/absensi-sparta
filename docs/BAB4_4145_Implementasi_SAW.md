## 4.1.4.5 Implementasi Algoritma SAW

Peneliti mengimplementasikan algoritma Simple Additive Weighting (SAW) dalam class terpisah bernama `SAWService` yang ditempatkan di direktori `app/Services/`. Pemisahan ini dilakukan untuk menjaga prinsip *Single Responsibility Principle*, yaitu controller hanya menangani request dan response, sedangkan logika perhitungan SAW sepenuhnya ditangani oleh service. Class `SAWService` memiliki 2 method publik dan 4 method protected yang merepresentasikan setiap tahapan SAW.

### a. Method `calculate()`

Method `calculate()` merupakan method publik utama yang berfungsi sebagai orkestrator seluruh tahapan perhitungan SAW. Method ini menerima dua parameter, yaitu koleksi data (siswa atau guru) dan tipe perhitungan (`'student'` atau `'teacher'`). Ketika dipanggil, method ini mengorkestrasi seluruh tahapan perhitungan SAW secara berurutan. Tahap pertama adalah mengambil kriteria dari database berdasarkan tipe yang diberikan. Setelah kriteria diperoleh, method ini memanggil `buildDecisionMatrix()` untuk membangun matriks keputusan. Selanjutnya, method memanggil `normalizeMatrix()` untuk menormalisasi matriks. Tahap berikutnya adalah pemanggilan `calculateSAWScores()` untuk menghitung nilai preferensi setiap alternatif. Terakhir, method memanggil `rankAlternatives()` untuk melakukan perankingan terhadap seluruh alternatif berdasarkan nilai preferensi yang telah dihitung.

### b. Method `buildDecisionMatrix()`

Method `buildDecisionMatrix()` bertugas menyusun matriks keputusan dari data input. Setiap baris matriks merepresentasikan satu alternatif (siswa atau guru), dan setiap kolom merepresentasikan satu kriteria. Untuk penilaian siswa, matriks terdiri dari empat kolom, yaitu C1 untuk nilai akademik, C2 untuk kehadiran, C3 untuk sikap, dan C4 untuk keterampilan. Sementara itu, untuk penilaian guru, matriks terdiri dari K1 untuk kehadiran, K2 untuk kualitas mengajar, K3 untuk prestasi siswa, dan K4 untuk kedisiplinan.

### c. Method `normalizeMatrix()`

Method `normalizeMatrix()` melakukan normalisasi nilai pada setiap sel matriks agar seluruh kriteria berada dalam skala yang sama, yaitu antara 0 hingga 1. Normalisasi dilakukan berdasarkan jenis kriteria. Untuk kriteria berjenis *benefit* (semakin tinggi semakin baik), normalisasi menggunakan rumus `r_ij = x_ij / max(x_j)`, di mana nilai setiap alternatif dibagi dengan nilai maksimum pada kriteria tersebut. Untuk kriteria berjenis *cost* (semakin rendah semakin baik), normalisasi menggunakan rumus `r_ij = min(x_j) / x_ij`, di mana nilai minimum pada kriteria tersebut dibagi dengan nilai setiap alternatif.

Method ini juga menangani kasus *edge case*, yaitu jika nilai maksimum (pada kriteria benefit) atau nilai minimum (pada kriteria cost) adalah nol, maka normalisasi tidak dilakukan untuk menghindari error *division by zero*. Dalam implementasi sistem ini, seluruh 8 kriteria (C1 hingga C4 dan K1 hingga K4) ditetapkan berjenis *benefit*, artinya semakin tinggi nilainya maka semakin baik.

### d. Method `calculateSAWScores()`

Method `calculateSAWScores()` menghitung nilai preferensi (V_i) untuk setiap alternatif dengan rumus **V_i = Σ (w_j × r_ij)**, di mana `w_j` adalah bobot kriteria ke-j dan `r_ij` adalah nilai normalisasi alternatif ke-i pada kriteria ke-j. Proses perhitungan dilakukan dengan mengalikan nilai normalisasi setiap kriteria dengan bobot kriteria yang bersangkutan, kemudian menjumlahkan seluruh hasil perkalian tersebut untuk memperoleh satu nilai preferensi bagi setiap alternatif. Hasil perhitungan dibulatkan hingga 4 digit desimal menggunakan fungsi `round()` untuk menjaga presisi tanpa mengorbankan keterbacaan.

### e. Method `rankAlternatives()`

Method `rankAlternatives()` mengurutkan seluruh alternatif berdasarkan nilai preferensi dari yang tertinggi ke terendah (*descending*) menggunakan method `sortByDesc()` milik Laravel Collection. Setelah pengurutan selesai, setiap alternatif diberi nomor ranking secara berurutan mulai dari 1. Alternatif dengan nilai preferensi tertinggi memperoleh ranking 1, yang menandakan bahwa alternatif tersebut merupakan yang terbaik.

### f. Method `getCalculationDetails()`

Method publik kedua ini diimplementasikan berdasarkan masukan kepala sekolah pada tahap evaluasi prototype yang menginginkan transparansi dalam proses penilaian. Method `getCalculationDetails()` mengembalikan seluruh detail langkah perhitungan dalam bentuk array yang berisi daftar kriteria beserta nama, tipe, dan bobotnya, matriks keputusan yang menampilkan nilai mentah setiap alternatif pada setiap kriteria, matriks normalisasi yang menampilkan hasil normalisasi setiap sel, nilai preferensi (skor SAW) yang merupakan hasil akhir perhitungan untuk setiap alternatif, serta ringkasan bobot kriteria dalam format kode dan bobot. Data ini ditampilkan pada halaman hasil perhitungan SAW sehingga pengguna, terutama kepala sekolah, dapat memverifikasi kebenaran perhitungan secara manual jika diperlukan.

### g. Pemanggilan SAW melalui Controller

Perhitungan SAW dipanggil melalui `SAWController` yang menyediakan dua endpoint utama. Endpoint pertama adalah `calculateStudents()` yang mengambil data siswa beserta skor masing-masing kriteria, memanggil `SAWService->calculate()` dengan tipe `'student'`, lalu menyimpan hasil ranking ke tabel `student_assessments`. Endpoint kedua adalah `calculateTeachers()` yang mengambil data guru beserta skor masing-masing kriteria, memanggil `SAWService->calculate()` dengan tipe `'teacher'`, lalu menyimpan hasil ranking ke tabel `teacher_assessments`.
