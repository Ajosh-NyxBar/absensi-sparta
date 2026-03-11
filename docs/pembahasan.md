# 4.2 Pembahasan

Penelitian ini bertujuan untuk membangun sistem informasi absensi guru menggunakan QR Code dan penilaian siswa berbasis web dengan metode SAW di SMPN 4 Purwakarta. Pengembangan dilakukan menggunakan metode Prototype yang terdiri dari tujuh tahapan, yaitu pengumpulan kebutuhan, membangun prototyping, evaluasi prototyping, mengkodekan sistem, menguji sistem, evaluasi sistem, dan menggunakan sistem. Pada bagian ini akan dibahas temuan-temuan utama penelitian serta kontribusi sistem terhadap penyelesaian permasalahan yang telah diidentifikasi.

## 4.2.1 Penyelesaian Permasalahan Absensi Guru

Berdasarkan hasil wawancara dan observasi yang dilakukan pada tahap pengumpulan kebutuhan, ditemukan empat permasalahan utama pada sistem absensi guru di SMPN 4 Purwakarta, yaitu ketidakakuratan data pencatatan kehadiran, proses rekapitulasi yang lambat (memerlukan 2–3 hari kerja), tingkat kedisiplinan pengisian absensi yang fluktuatif (32–40% guru tidak mengisi), serta risiko kehilangan data yang tinggi akibat pencatatan menggunakan buku fisik.

Sistem yang dikembangkan menjawab keempat permasalahan tersebut melalui mekanisme presensi digital berbasis QR Code dengan validasi geolokasi. Guru cukup memindai QR Code melalui smartphone untuk mencatat kehadiran, sehingga data waktu dan lokasi tercatat secara otomatis tanpa bergantung pada proses tulis-menulis manual. Proses yang sebelumnya memerlukan waktu sekitar 2 menit per guru (mencari buku, menulis, menandatangani) kini hanya membutuhkan waktu kurang dari 10 detik melalui pemindaian. Validasi lokasi menggunakan koordinat GPS memastikan bahwa guru benar-benar berada di area sekolah saat melakukan absensi, sehingga potensi kecurangan seperti titip absen dapat diminimalisir.

Dari sisi rekapitulasi, proses yang sebelumnya memerlukan 2–3 hari kerja oleh staf tata usaha karena harus menginput ulang data dari buku ke komputer kini dapat dilakukan secara instan melalui fitur export laporan. Admin cukup memilih periode yang diinginkan dan sistem langsung menghasilkan laporan dalam format Excel atau PDF yang siap digunakan. Perubahan ini secara signifikan mengurangi beban kerja administratif dan memungkinkan staf tata usaha untuk mengalokasikan waktu mereka pada tugas-tugas lain yang lebih strategis.

Keberadaan dashboard monitoring yang dapat diakses oleh Kepala Sekolah secara real-time juga memberikan dampak positif terhadap pengawasan kedisiplinan. Kepala Sekolah tidak perlu lagi menanyakan data kehadiran kepada staf tata usaha atau menunggu laporan bulanan, melainkan dapat langsung memantau siapa saja guru yang sudah hadir, terlambat, atau belum melakukan absensi pada hari tersebut. Kemampuan pemantauan langsung ini mendorong terciptanya budaya disiplin yang lebih baik di lingkungan sekolah.

## 4.2.2 Penyelesaian Permasalahan Penilaian Siswa

Permasalahan pada proses penilaian siswa yang teridentifikasi meliputi perhitungan yang memakan waktu lama (1–2 minggu per semester), kurangnya objektivitas karena hanya menggunakan nilai rata-rata tanpa mempertimbangkan bobot kriteria, serta keterbatasan transparansi dalam proses penentuan peringkat siswa.

Sistem yang dikembangkan menerapkan metode Simple Additive Weighting (SAW) untuk mengatasi permasalahan tersebut. Metode SAW memungkinkan penilaian dilakukan secara multi-kriteria, di mana setiap aspek penilaian — meliputi nilai akademik, kehadiran, sikap/perilaku, dan keterampilan — diberikan bobot yang proporsional sesuai dengan prioritas yang telah ditetapkan oleh pihak sekolah. Dengan demikian, proses perankingan tidak lagi hanya berdasarkan satu dimensi nilai rata-rata, melainkan mempertimbangkan berbagai aspek yang relevan secara komprehensif.

Perhitungan ranking yang sebelumnya memerlukan waktu berminggu-minggu secara manual menggunakan Microsoft Excel kini dapat diselesaikan dalam hitungan detik oleh sistem. Guru menginput nilai melalui form tabel interaktif yang telah dirancang sedemikian rupa agar mudah digunakan, kemudian sistem secara otomatis menghitung nilai akhir berdasarkan formula pembobotan yang telah ditetapkan. Selanjutnya, ketika proses perankingan SAW dijalankan, sistem melakukan seluruh tahapan perhitungan — mulai dari pembentukan matriks keputusan, normalisasi, hingga perhitungan nilai preferensi — secara otomatis dan akurat.

Aspek transparansi perhitungan merupakan salah satu masukan penting yang diperoleh pada tahap evaluasi prototype dari Kepala Sekolah. Berdasarkan masukan tersebut, sistem dirancang untuk menampilkan detail seluruh langkah perhitungan SAW, meliputi matriks keputusan, matriks normalisasi, dan nilai preferensi akhir. Fitur ini memungkinkan pihak sekolah untuk memverifikasi kebenaran hasil perhitungan, sehingga hasil perankingan dapat dipertanggungjawabkan dan diterima oleh seluruh pihak.

## 4.2.3 Kesesuaian dengan Kebutuhan Pengguna

Proses pengembangan sistem menggunakan metode Prototype memungkinkan adanya keterlibatan pengguna secara aktif sejak tahap awal perancangan. Evaluasi prototype yang melibatkan 26 evaluator (1 kepala sekolah, 24 guru, dan 1 staf tata usaha) menghasilkan skor rata-rata 4,50/5,00 (90,00%) dengan kategori "Sangat Baik". Masukan kualitatif dari evaluator — seperti penambahan filter pada dashboard, tampilan detail perhitungan SAW, desain responsif untuk smartphone, serta mekanisme pre-filled data pada form input nilai — seluruhnya telah diakomodasi dalam proses pengkodean sistem.

Hasil evaluasi sistem melalui User Acceptance Testing (UAT) yang melibatkan 34 peserta (1 kepala sekolah, 32 guru, dan 1 staf tata usaha) menunjukkan bahwa sistem memperoleh skor rata-rata 4,46/5,00 (89,29%) dengan kategori "Sangat Baik". Kelima aspek yang dievaluasi — fungsionalitas (90,59%), kemudahan penggunaan (88,24%), kecepatan sistem (90,00%), tampilan antarmuka (86,47%), dan keandalan (91,18%) — seluruhnya berada pada kategori "Sangat Baik". Hal yang patut dicatat adalah dari seluruh 340 jawaban kuesioner, tidak terdapat satu pun responden yang memberikan penilaian di bawah skala 4 (Setuju), yang menunjukkan tingkat penerimaan yang sangat tinggi dari pengguna terhadap sistem yang dikembangkan.

Aspek keandalan memperoleh skor tertinggi (91,18%), yang sejalan dengan hasil pengujian internal di mana seluruh 58 skenario Black Box Testing berhasil tanpa kegagalan dan seluruh 19 jalur White Box Testing menghasilkan output yang sesuai. Sementara itu, aspek tampilan antarmuka memperoleh skor terendah (86,47%), yang mengindikasikan masih terdapat ruang perbaikan pada aspek visual meskipun tetap dikategorikan "Sangat Baik". Perbaikan akhir yang dilakukan berdasarkan feedback UAT — seperti penambahan tooltip bantuan, optimasi loading, penyesuaian tampilan mobile, dan penambahan pesan konfirmasi — turut meningkatkan kualitas pengalaman pengguna sebelum sistem diimplementasikan secara operasional.

## 4.2.4 Perbandingan dengan Penelitian Sebelumnya

Jika dibandingkan dengan penelitian-penelitian terdahulu, sistem yang dikembangkan dalam penelitian ini memiliki beberapa keunggulan dan kontribusi tersendiri.

Penelitian oleh Aji Pangestu dkk. (2024) mengembangkan sistem presensi karyawan menggunakan QR Code pada PT Berkat Bagi Sesama yang terbatas pada fitur absensi tanpa integrasi dengan sistem penilaian. Penelitian oleh Setiono & Oktafiandi (2022) di SMK Muhammadiyah Purwodadi juga fokus pada absensi guru dan siswa berbasis QR Code tanpa mekanisme validasi lokasi. Sementara itu, penelitian oleh Abrori & Samad (2024) di MA Ibrahimy mengembangkan sistem absensi guru berbasis QR Code yang terintegrasi dengan jadwal pelajaran namun tanpa penerapan metode pengambilan keputusan.

Di sisi penilaian, penelitian oleh Hadi Wijaya (2025) di SDN 36 Lubuk Batu menerapkan metode SAW untuk penentuan siswa berprestasi, dan penelitian oleh Widhiyanta dkk. (2022) di MTs Ath-Thohiriyah menggunakan SAW untuk identifikasi siswa bermasalah. Namun keduanya tidak mengintegrasikan SAW dengan sistem absensi dalam satu platform.

Penelitian ini menghadirkan kontribusi berupa integrasi dua aspek utama — absensi guru digital berbasis QR Code dengan validasi geolokasi dan penilaian siswa berbasis metode SAW — ke dalam satu platform web yang terpadu. Integrasi ini memungkinkan data kehadiran guru tidak hanya berfungsi sebagai catatan administratif, tetapi juga menjadi salah satu komponen dalam penilaian kinerja guru melalui metode SAW. Selain itu, sistem ini dikembangkan secara khusus untuk jenjang SMP dengan mempertimbangkan kebutuhan dan kondisi operasional SMPN 4 Purwakarta, sehingga memiliki relevansi kontekstual yang lebih tinggi.

## 4.2.5 Keakuratan Perhitungan Sistem

Keakuratan merupakan aspek krusial dalam sistem yang melibatkan perhitungan matematis. Pada penelitian ini, dua komponen perhitungan utama telah diverifikasi keakuratannya.

Pertama, perhitungan metode SAW diverifikasi melalui perbandingan hasil perhitungan sistem dengan perhitungan manual menggunakan data sampel. Hasil verifikasi menunjukkan bahwa nilai preferensi yang dihasilkan oleh sistem identik dengan perhitungan manual hingga empat digit desimal. Hal ini membuktikan bahwa implementasi algoritma SAW pada sistem telah dilakukan dengan benar dan menghasilkan output yang dapat dipercaya.

Kedua, perhitungan jarak menggunakan formula Haversine untuk validasi geolokasi diverifikasi dengan membandingkan hasil sistem terhadap jarak referensi. Hasil verifikasi menunjukkan deviasi kurang dari 1 meter, yang mengkonfirmasi bahwa proses validasi lokasi berjalan dengan akurat. Akurasi ini penting untuk memastikan bahwa hanya guru yang benar-benar berada di area sekolah yang dapat melakukan absensi.

## 4.2.6 Dampak Implementasi terhadap Operasional Sekolah

Implementasi sistem di SMPN 4 Purwakarta membawa perubahan yang signifikan pada proses operasional sekolah. Sebelum sistem diterapkan, pencatatan kehadiran guru menggunakan buku absensi fisik yang rentan terhadap kesalahan pencatatan, tulisan tangan yang sulit dibaca, dan ketidaklengkapan data. Proses penilaian dan perankingan siswa dilakukan secara manual menggunakan Microsoft Excel tanpa standar baku, membutuhkan waktu 1–2 minggu setiap semester, dan rentan terhadap kesalahan perhitungan.

Setelah sistem diterapkan, seluruh proses tersebut bertransformasi menjadi lebih terstruktur dan efisien. Data absensi guru tercatat secara otomatis dan tervalidasi, proses rekapitulasi yang semula memakan waktu berhari-hari kini bersifat instan, dan perankingan siswa yang sebelumnya memerlukan waktu berminggu-minggu kini dapat dilakukan dalam hitungan detik dengan hasil yang objektif dan transparan.

Strategi implementasi yang dilakukan secara bertahap (phased rollout) — dimulai dari fase paralel dengan sistem manual, fase transisi, hingga fase full digital — terbukti efektif dalam meminimalkan risiko gangguan operasional. Selama masa implementasi, tidak ditemukan kendala teknis kritis. Kendala minor yang muncul, seperti guru yang lupa password atau pertanyaan tentang cara menggunakan fitur tertentu, dapat diselesaikan melalui dukungan teknis tanpa perlu melakukan perubahan pada sistem.

## 4.2.7 Keterbatasan Penelitian

Meskipun sistem telah berhasil dikembangkan dan diimplementasikan, terdapat beberapa keterbatasan yang perlu diakui. Pertama, sistem dikembangkan dan diuji hanya pada satu sekolah (SMPN 4 Purwakarta), sehingga hasil evaluasi belum dapat digeneralisasi untuk sekolah dengan kondisi dan infrastruktur yang berbeda. Kedua, periode implementasi dan monitoring masih tergolong singkat, sehingga evaluasi jangka panjang terkait keberlanjutan penggunaan dan dampak terhadap kedisiplinan belum dapat dilakukan secara komprehensif. Ketiga, validasi geolokasi sepenuhnya bergantung pada sinyal GPS dari perangkat smartphone, yang dapat mengalami penurunan akurasi ketika digunakan di dalam gedung (indoor). Keempat, input data untuk kriteria non-akademik seperti sikap dan keterampilan masih bersifat subjektif karena hanya berasal dari satu penilai (guru mata pelajaran) tanpa mekanisme multi-rater.

Secara keseluruhan, penelitian ini telah berhasil menghasilkan sistem informasi yang fungsional, stabil, dan diterima oleh pengguna sebagai solusi digitalisasi proses absensi guru dan penilaian siswa di SMPN 4 Purwakarta. Sistem ini tidak hanya menjawab permasalahan yang telah diidentifikasi pada tahap pengumpulan kebutuhan, tetapi juga memberikan nilai tambah berupa transparansi, efisiensi, dan objektivitas dalam pengelolaan data sekolah.
