# Penjelasan Flowchart Perhitungan SAW

Pada Gambar 4.16 ditunjukkan *flowchart* proses perhitungan metode *Simple Additive Weighting* (SAW) yang diimplementasikan dalam sistem. Alur dimulai dari proses input data alternatif dan tipe penilaian, yaitu menentukan apakah perhitungan akan dilakukan untuk penilaian siswa atau penilaian guru. Selanjutnya sistem mengambil data kriteria beserta bobotnya dari database. Apabila data kriteria tidak tersedia, sistem mengembalikan respons dan mengulangi proses pengambilan data. Apabila data tersedia, sistem masuk ke blok utama yaitu Proses Metode SAW yang terdiri dari empat langkah.

Penjelasan detail setiap langkah pada flowchart di atas diuraikan sebagai berikut:

**Tabel 4.40 Penjelasan Tahapan Algoritma SAW**

| Langkah | Nama Proses | Rumus / Formula | Penjelasan |
|:-------:|-------------|-----------------|------------|
| 1 | Membuat Matriks Keputusan | $X = \begin{bmatrix} x_{11} & x_{12} & \cdots & x_{1n} \\ x_{21} & x_{22} & \cdots & x_{2n} \\ \vdots & \vdots & \ddots & \vdots \\ x_{m1} & x_{m2} & \cdots & x_{mn} \end{bmatrix}$ | Menyusun matriks keputusan $X$ berukuran $m \times n$, di mana $m$ adalah jumlah alternatif (siswa/guru) dan $n$ adalah jumlah kriteria. Setiap elemen $x_{ij}$ merupakan rating kinerja alternatif ke-$i$ terhadap kriteria ke-$j$. |
| 2 | Normalisasi Matriks | Benefit: $r_{ij} = \dfrac{x_{ij}}{\max_i(x_{ij})}$ | Untuk kriteria *benefit* (semakin besar semakin baik), nilai pada setiap sel dibagi dengan nilai maksimum pada kolom kriteria tersebut. |
|   |                       | Cost: $r_{ij} = \dfrac{\min_i(x_{ij})}{x_{ij}}$ | Untuk kriteria *cost* (semakin kecil semakin baik), nilai minimum pada kolom kriteria dibagi dengan nilai pada setiap sel. |
| 3 | Menghitung Nilai Preferensi | $V_i = \displaystyle\sum_{j=1}^{n} W_j \cdot r_{ij}$ | Nilai preferensi $V_i$ untuk setiap alternatif diperoleh dari penjumlahan hasil perkalian antara bobot kriteria ($W_j$) dengan nilai normalisasi ($r_{ij}$) pada setiap kriteria. |
| 4 | Perankingan | $\text{Rank} = \text{sort}(V_i, \text{desc})$ | Seluruh nilai preferensi $V_i$ diurutkan dari yang terbesar ke terkecil. Alternatif dengan nilai $V_i$ tertinggi menempati peringkat pertama. |

Setelah keempat langkah tersebut selesai, sistem menyimpan skor dan peringkat ke database, kemudian menampilkan output perankingan kepada pengguna dan proses berakhir.
