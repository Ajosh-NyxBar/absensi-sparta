/**
 * ============================================================
 * SCRIPT PEMBUAT SPREADSHEET PERTANYAAN & JAWABAN WAWANCARA
 * Penelitian: Sistem Informasi Absensi dan Penilaian Siswa
 *             SMPN 4 Purwakarta
 * Peneliti  : Muhammad Rifky Akbar (NPM 2210631170088)
 * ============================================================
 *
 * CARA PENGGUNAAN:
 * 1. Buka https://script.google.com
 * 2. Buat project baru
 * 3. Salin seluruh kode ini ke editor
 * 4. Jalankan fungsi main()
 * 5. Beri izin akses Google Sheets saat diminta
 * 6. Spreadsheet akan otomatis terbuat di Google Drive
 */

function main() {
  var ss = SpreadsheetApp.create('Hasil Wawancara - Pengumpulan Kebutuhan Sistem (SMPN 4 Purwakarta)');

  createSheetCover(ss);
  createSheetKepalaSekolah(ss);
  createSheetTataUsaha(ss);
  createSheetRangkuman(ss);

  // Hapus sheet default "Sheet1"
  var defaultSheet = ss.getSheetByName('Sheet1');
  if (defaultSheet) {
    ss.deleteSheet(defaultSheet);
  }

  Logger.log('Spreadsheet berhasil dibuat: ' + ss.getUrl());
  SpreadsheetApp.flush();
}

/* ============================================================
 * HELPER: STYLING
 * ============================================================ */

var COLORS = {
  PRIMARY: '#1B4F72',       // Biru tua (header utama)
  SECONDARY: '#2980B9',     // Biru sedang (sub-header)
  ACCENT: '#2471A3',        // Biru aksen
  LIGHT_BLUE: '#D6EAF8',   // Biru muda (baris genap)
  WHITE: '#FFFFFF',
  LIGHT_GRAY: '#F8F9FA',   // Abu sangat muda (baris ganjil)
  DARK_TEXT: '#1C2833',
  BORDER: '#AEB6BF',
  GREEN: '#1E8449',
  GREEN_LIGHT: '#D5F5E3',
  ORANGE: '#E67E22',
  ORANGE_LIGHT: '#FDEBD0',
  RED_LIGHT: '#FADBD8',
  YELLOW_LIGHT: '#FEF9E7'
};

function styleHeader(range, bgColor) {
  range
    .setBackground(bgColor || COLORS.PRIMARY)
    .setFontColor(COLORS.WHITE)
    .setFontWeight('bold')
    .setFontSize(10)
    .setHorizontalAlignment('center')
    .setVerticalAlignment('middle')
    .setWrap(true)
    .setBorder(true, true, true, true, true, true, COLORS.BORDER, SpreadsheetApp.BorderStyle.SOLID);
}

function styleCell(range) {
  range
    .setFontSize(10)
    .setFontColor(COLORS.DARK_TEXT)
    .setVerticalAlignment('top')
    .setWrap(true)
    .setBorder(true, true, true, true, true, true, COLORS.BORDER, SpreadsheetApp.BorderStyle.SOLID);
}

function styleSectionHeader(range) {
  range
    .setBackground(COLORS.SECONDARY)
    .setFontColor(COLORS.WHITE)
    .setFontWeight('bold')
    .setFontSize(10)
    .setVerticalAlignment('middle')
    .setWrap(true)
    .setBorder(true, true, true, true, true, true, COLORS.BORDER, SpreadsheetApp.BorderStyle.SOLID);
}

function applyAlternatingRows(sheet, startRow, endRow, startCol, endCol) {
  for (var r = startRow; r <= endRow; r++) {
    var range = sheet.getRange(r, startCol, 1, endCol - startCol + 1);
    if ((r - startRow) % 2 === 0) {
      range.setBackground(COLORS.WHITE);
    } else {
      range.setBackground(COLORS.LIGHT_BLUE);
    }
  }
}

/* ============================================================
 * SHEET 1: COVER / INFORMASI UMUM
 * ============================================================ */

function createSheetCover(ss) {
  var sheet = ss.insertSheet('Cover');

  sheet.setColumnWidth(1, 40);
  sheet.setColumnWidth(2, 220);
  sheet.setColumnWidth(3, 400);
  sheet.setColumnWidth(4, 250);

  // === JUDUL UTAMA ===
  sheet.getRange('A1:D1').merge()
    .setValue('HASIL WAWANCARA PENGUMPULAN KEBUTUHAN SISTEM')
    .setBackground(COLORS.PRIMARY)
    .setFontColor(COLORS.WHITE)
    .setFontWeight('bold')
    .setFontSize(14)
    .setHorizontalAlignment('center')
    .setVerticalAlignment('middle');
  sheet.setRowHeight(1, 50);

  sheet.getRange('A2:D2').merge()
    .setValue('Sistem Informasi Absensi Guru Menggunakan QR Code dan Penilaian Siswa dengan Metode SAW\ndi SMPN 4 Purwakarta')
    .setBackground(COLORS.SECONDARY)
    .setFontColor(COLORS.WHITE)
    .setFontWeight('bold')
    .setFontSize(11)
    .setHorizontalAlignment('center')
    .setVerticalAlignment('middle')
    .setWrap(true);
  sheet.setRowHeight(2, 50);

  // === INFORMASI PENELITIAN ===
  sheet.getRange('A4:D4').merge()
    .setValue('INFORMASI PENELITIAN')
    .setBackground(COLORS.ACCENT)
    .setFontColor(COLORS.WHITE)
    .setFontWeight('bold')
    .setFontSize(11)
    .setHorizontalAlignment('center');
  sheet.setRowHeight(4, 30);

  var infoData = [
    ['Peneliti', 'Muhammad Rifky Akbar'],
    ['NPM', '2210631170088'],
    ['Program Studi', 'Teknik Informatika'],
    ['Universitas', 'Universitas Singaperbangsa Karawang'],
    ['Lokasi Penelitian', 'SMPN 4 Purwakarta'],
    ['Alamat Sekolah', 'Jl. Veteran, Nagri Kaler, Kec. Purwakarta, Kab. Purwakarta, Jawa Barat 41115'],
    ['Waktu Wawancara', '07 September 2025'],
    ['Metode', 'Wawancara langsung & observasi']
  ];

  for (var i = 0; i < infoData.length; i++) {
    var row = 5 + i;
    sheet.getRange(row, 2).setValue(infoData[i][0])
      .setFontWeight('bold').setFontSize(10).setFontColor(COLORS.DARK_TEXT)
      .setVerticalAlignment('middle');
    sheet.getRange(row, 3).setValue(infoData[i][1])
      .setFontSize(10).setFontColor(COLORS.DARK_TEXT)
      .setVerticalAlignment('middle');
    var bg = (i % 2 === 0) ? COLORS.WHITE : COLORS.LIGHT_BLUE;
    sheet.getRange(row, 1, 1, 4).setBackground(bg)
      .setBorder(true, true, true, true, true, true, COLORS.BORDER, SpreadsheetApp.BorderStyle.SOLID);
    sheet.setRowHeight(row, 28);
  }

  // === PROFIL RESPONDEN ===
  var respStart = 14;
  sheet.getRange(respStart, 1, 1, 4).merge()
    .setValue('PROFIL RESPONDEN')
    .setBackground(COLORS.ACCENT)
    .setFontColor(COLORS.WHITE)
    .setFontWeight('bold')
    .setFontSize(11)
    .setHorizontalAlignment('center');
  sheet.setRowHeight(respStart, 30);

  var respHeaders = ['No', 'Nama', 'Jabatan', 'Lama Bekerja'];
  var respHeaderRange = sheet.getRange(respStart + 1, 1, 1, 4);
  respHeaderRange.setValues([respHeaders]);
  styleHeader(respHeaderRange);
  sheet.setRowHeight(respStart + 1, 30);

  var respData = [
    [1, 'Mohamad Nursodik, M.Pd.', 'Kepala Sekolah', '3 Tahun menjabat'],
    [2, 'Agus', 'Staf Tata Usaha', '6 Tahun']
  ];

  for (var j = 0; j < respData.length; j++) {
    var rr = respStart + 2 + j;
    sheet.getRange(rr, 1, 1, 4).setValues([respData[j]]);
    styleCell(sheet.getRange(rr, 1, 1, 4));
    sheet.getRange(rr, 1).setHorizontalAlignment('center');
    var rbg = (j % 2 === 0) ? COLORS.WHITE : COLORS.LIGHT_BLUE;
    sheet.getRange(rr, 1, 1, 4).setBackground(rbg);
    sheet.setRowHeight(rr, 28);
  }

  // === DAFTAR ISI SHEET ===
  var tocStart = 19;
  sheet.getRange(tocStart, 1, 1, 4).merge()
    .setValue('DAFTAR ISI SPREADSHEET')
    .setBackground(COLORS.ACCENT)
    .setFontColor(COLORS.WHITE)
    .setFontWeight('bold')
    .setFontSize(11)
    .setHorizontalAlignment('center');
  sheet.setRowHeight(tocStart, 30);

  var tocHeaders = ['No', 'Nama Sheet', 'Keterangan', 'Jumlah Pertanyaan'];
  var tocHeaderRange = sheet.getRange(tocStart + 1, 1, 1, 4);
  tocHeaderRange.setValues([tocHeaders]);
  styleHeader(tocHeaderRange);

  var tocData = [
    [1, 'Wawancara Kepala Sekolah', 'Pertanyaan & jawaban wawancara dengan Kepala Sekolah tentang permasalahan absensi, penilaian, dan kebutuhan sistem', '20 pertanyaan'],
    [2, 'Wawancara Tata Usaha', 'Pertanyaan & jawaban wawancara dengan Staf Tata Usaha tentang proses operasional absensi dan pelaporan', '15 pertanyaan'],
    [3, 'Rangkuman Temuan', 'Ringkasan temuan utama, permasalahan, dan kebutuhan sistem yang teridentifikasi', '—']
  ];

  for (var k = 0; k < tocData.length; k++) {
    var tr = tocStart + 2 + k;
    sheet.getRange(tr, 1, 1, 4).setValues([tocData[k]]);
    styleCell(sheet.getRange(tr, 1, 1, 4));
    sheet.getRange(tr, 1).setHorizontalAlignment('center');
    sheet.getRange(tr, 4).setHorizontalAlignment('center');
    var tbg = (k % 2 === 0) ? COLORS.WHITE : COLORS.LIGHT_BLUE;
    sheet.getRange(tr, 1, 1, 4).setBackground(tbg);
    sheet.setRowHeight(tr, 40);
  }

  sheet.setFrozenRows(0);
}

/* ============================================================
 * SHEET 2: WAWANCARA KEPALA SEKOLAH
 * ============================================================ */

function createSheetKepalaSekolah(ss) {
  var sheet = ss.insertSheet('Wawancara Kepala Sekolah');

  sheet.setColumnWidth(1, 40);   // No
  sheet.setColumnWidth(2, 130);  // Topik
  sheet.setColumnWidth(3, 380);  // Pertanyaan
  sheet.setColumnWidth(4, 480);  // Jawaban

  // === HEADER ===
  sheet.getRange('A1:D1').merge()
    .setValue('HASIL WAWANCARA — KEPALA SEKOLAH')
    .setBackground(COLORS.PRIMARY)
    .setFontColor(COLORS.WHITE)
    .setFontWeight('bold')
    .setFontSize(13)
    .setHorizontalAlignment('center')
    .setVerticalAlignment('middle');
  sheet.setRowHeight(1, 45);

  // === INFO RESPONDEN ===
  var infoRows = [
    ['Responden', 'Mohamad Nursodik, M.Pd.'],
    ['Jabatan', 'Kepala Sekolah SMPN 4 Purwakarta'],
    ['Lama Menjabat', '3 Tahun'],
    ['Tanggal Wawancara', '07 September 2025'],
    ['Pewawancara', 'Muhammad Rifky Akbar']
  ];

  for (var i = 0; i < infoRows.length; i++) {
    var row = 2 + i;
    sheet.getRange(row, 1, 1, 2).merge().setValue(infoRows[i][0])
      .setFontWeight('bold').setFontSize(10).setBackground(COLORS.LIGHT_GRAY)
      .setVerticalAlignment('middle');
    sheet.getRange(row, 3, 1, 2).merge().setValue(': ' + infoRows[i][1])
      .setFontSize(10).setBackground(COLORS.LIGHT_GRAY)
      .setVerticalAlignment('middle');
    sheet.setRowHeight(row, 25);
  }

  // === TABEL HEADER ===
  var tableStart = 8;
  var headers = ['No', 'Topik', 'Pertanyaan', 'Jawaban Responden'];
  var headerRange = sheet.getRange(tableStart, 1, 1, 4);
  headerRange.setValues([headers]);
  styleHeader(headerRange);
  sheet.setRowHeight(tableStart, 35);

  // === DATA PERTANYAAN & JAWABAN ===
  var qaData = [
    // --- BAGIAN A: KONDISI UMUM ABSENSI ---
    ['SECTION', 'A. KONDISI UMUM SISTEM ABSENSI GURU'],

    [1, 'Kondisi Umum Absensi',
     'Bagaimana sistem absensi guru yang saat ini diterapkan di SMPN 4 Purwakarta?',
     'Saat ini kami masih menggunakan buku absensi manual. Guru datang ke sekolah, lalu menandatangani buku kehadiran yang disediakan di ruang guru. Prosesnya sederhana, tapi kami menyadari bahwa cara ini sudah kurang efektif untuk kebutuhan sekolah saat ini.'],

    [2, 'Kondisi Umum Absensi',
     'Sudah berapa lama sistem absensi manual ini digunakan, dan apakah pernah ada upaya untuk mengubah atau memperbaikinya?',
     'Sistem ini sudah digunakan sejak lama, bahkan sebelum saya menjabat. Belum pernah ada perubahan berarti karena keterbatasan anggaran dan sumber daya teknologi. Kami sempat berpikir untuk menggunakan fingerprint, tapi belum terealisasi.'],

    [3, 'Permasalahan Absensi',
     'Permasalahan apa saja yang Bapak rasakan atau amati terkait sistem absensi yang berjalan saat ini?',
     'Permasalahan utamanya ada beberapa. Pertama, data kehadiran sering tidak akurat karena guru lupa menandatangani buku. Kedua, kami tidak bisa memantau kehadiran secara langsung — harus menunggu rekapitulasi dari tata usaha. Ketiga, buku absensi bisa rusak atau hilang dan datanya tidak bisa dikembalikan.'],

    [4, 'Permasalahan Absensi',
     'Berdasarkan data yang kami peroleh, tingkat guru yang tidak mengisi absensi mencapai 32-40% setiap bulannya. Apakah Bapak menyadari angka tersebut, dan menurut Bapak apa penyebab utamanya?',
     'Angka itu memang mengkhawatirkan. Penyebab utamanya karena tidak ada sistem yang mengingatkan guru untuk mengisi absensi. Buku hanya diletakkan di meja dan tidak ada mekanisme reminder. Kadang guru datang tapi lupa mengisi, atau sibuk langsung masuk ke kelas. Jadi bukan berarti mereka tidak hadir, tapi pencatatannya yang tidak terlaksana.'],

    [5, 'Dampak Permasalahan',
     'Bagaimana dampak permasalahan absensi ini terhadap pengambilan keputusan dan pengelolaan sekolah?',
     'Dampaknya cukup signifikan. Saya kesulitan mengetahui guru mana yang sering tidak hadir atau terlambat secara real-time. Keputusan terkait pembinaan kedisiplinan menjadi terhambat karena data yang saya terima sudah terlambat, biasanya baru di akhir bulan setelah tata usaha selesai merekap. Padahal idealnya saya bisa langsung mengetahui kondisi kehadiran guru setiap hari.'],

    // --- BAGIAN B: KONDISI PENILAIAN SISWA ---
    ['SECTION', 'B. KONDISI SISTEM PENILAIAN SISWA'],

    [6, 'Kondisi Penilaian',
     'Bagaimana proses penilaian dan penentuan ranking siswa yang saat ini berjalan di sekolah?',
     'Proses penilaian dilakukan oleh masing-masing guru mata pelajaran. Nilai direkap secara manual menggunakan Microsoft Excel. Untuk ranking, kami hanya mengurutkan berdasarkan rata-rata nilai akademik saja. Proses ini dilakukan setiap akhir semester oleh wali kelas dibantu guru mata pelajaran.'],

    [7, 'Permasalahan Penilaian',
     'Apa saja kendala yang dihadapi dalam proses penilaian siswa tersebut?',
     'Kendala utamanya adalah waktu yang dibutuhkan sangat lama, bisa 1-2 minggu untuk menyelesaikan seluruh perhitungan nilai dari semua siswa. Selain itu, karena menggunakan Excel manual, risiko salah rumus atau salah input cukup tinggi. Pernah ada kejadian nilai siswa tertukar karena kesalahan copy-paste di Excel.'],

    [8, 'Permasalahan Penilaian',
     'Apakah menurut Bapak sistem penilaian yang hanya berdasarkan rata-rata nilai akademik sudah cukup objektif untuk menilai prestasi siswa secara keseluruhan?',
     'Jujur, menurut saya belum cukup objektif. Penilaian seharusnya tidak hanya dari nilai akademik saja. Aspek lain seperti kedisiplinan yang bisa dilihat dari kehadiran, sikap sehari-hari, dan keterampilan siswa juga perlu dipertimbangkan. Tapi karena sistemnya manual, menghitung dengan banyak kriteria dan bobot yang berbeda itu sangat sulit dilakukan.'],

    [9, 'Transparansi Penilaian',
     'Bagaimana dengan transparansi proses penilaian? Apakah pihak sekolah, siswa, atau orang tua dapat mengetahui bagaimana ranking ditentukan?',
     'Saat ini transparansinya kurang baik. Orang tua hanya menerima hasil akhir berupa rapor tanpa mengetahui prosesnya. Bahkan sesama guru pun kadang tidak tahu bagaimana ranking akhir siswa ditentukan. Saya sendiri ingin agar prosesnya lebih terbuka, terutama jika nanti ada metode perhitungan yang lebih standar dan bisa dipertanggungjawabkan.'],

    // --- BAGIAN C: KEBUTUHAN SISTEM BARU ---
    ['SECTION', 'C. KEBUTUHAN DAN HARAPAN TERHADAP SISTEM BARU'],

    [10, 'Kebutuhan Absensi',
     'Jika dikembangkan sistem absensi digital, fitur apa yang Bapak harapkan untuk mengatasi permasalahan yang ada?',
     'Pertama, saya ingin sistem yang mencatat kehadiran secara otomatis dan akurat, tidak bisa dimanipulasi. Kedua, saya ingin bisa memantau kehadiran guru secara langsung dari perangkat saya tanpa harus menunggu rekapitulasi. Ketiga, perlu ada bukti kehadiran yang jelas, seperti lokasi atau waktu yang tercatat secara digital.'],

    [11, 'Kebutuhan Absensi',
     'Bagaimana pendapat Bapak mengenai penggunaan QR Code yang divalidasi dengan lokasi GPS untuk absensi guru?',
     'Menurut saya itu ide yang sangat bagus. Dengan QR Code, proses absensi menjadi cepat dan mudah. Ditambah validasi GPS, bisa dipastikan guru memang berada di lokasi sekolah saat absensi. Ini mengatasi masalah guru yang mungkin mengisi absensi tapi sebenarnya belum sampai di sekolah.'],

    [12, 'Kebutuhan Penilaian',
     'Untuk penilaian siswa, apakah Bapak terbuka dengan penggunaan metode perhitungan terstruktur seperti SAW (Simple Additive Weighting) yang mempertimbangkan beberapa kriteria dengan bobot yang dapat disesuaikan?',
     'Saya sangat terbuka. Justru itu yang kami butuhkan — sebuah metode yang jelas, terstruktur, dan bisa dipertanggungjawabkan. Kalau bobotnya bisa disesuaikan, kami bisa menyesuaikan sesuai kebijakan sekolah dan kurikulum. Yang penting, prosesnya transparan dan hasilnya bisa dilihat secara detail, bagaimana nilai akhirnya diperoleh.'],

    [13, 'Kebutuhan Dashboard',
     'Apakah Bapak membutuhkan dashboard khusus untuk monitoring kehadiran guru dan perkembangan siswa secara menyeluruh?',
     'Sangat dibutuhkan. Sebagai kepala sekolah, saya ingin bisa melihat ringkasan data penting di satu tempat. Misalnya berapa guru yang sudah hadir hari ini, siapa yang terlambat, bagaimana tren kehadiran bulanan, dan juga statistik nilai siswa. Ini akan sangat membantu saya dalam mengambil keputusan.'],

    [14, 'Kebutuhan Laporan',
     'Bagaimana dengan kebutuhan pelaporan? Format dan jenis laporan apa yang Bapak butuhkan?',
     'Kami butuh laporan yang bisa langsung dicetak atau diunduh dalam format Excel atau PDF. Laporan kehadiran guru bulanan, rekap nilai siswa per semester, dan data guru serta siswa. Saat ini proses pembuatan laporan sangat memakan waktu, jadi kalau bisa otomatis akan sangat membantu.'],

    [15, 'Hak Akses',
     'Siapa saja yang sebaiknya memiliki akses ke sistem ini, dan apakah masing-masing perlu hak akses yang berbeda?',
     'Ya, tentu harus dibedakan. Admin atau tata usaha punya akses penuh untuk mengelola data. Guru hanya bisa mengakses absensi dan penilaian untuk kelas yang diajarnya. Saya sebagai kepala sekolah perlu akses monitoring dan laporan. Jangan sampai semua orang bisa mengubah data sembarangan.'],

    // --- BAGIAN D: INFRASTRUKTUR DAN KESIAPAN ---
    ['SECTION', 'D. INFRASTRUKTUR DAN KESIAPAN SEKOLAH'],

    [16, 'Infrastruktur',
     'Bagaimana kondisi infrastruktur teknologi di sekolah saat ini? Apakah jaringan internet dan perangkat sudah memadai?',
     'Di sekolah kami sudah ada jaringan WiFi yang cukup stabil. Hampir semua guru juga sudah memiliki smartphone. Di ruang guru ada beberapa komputer dan juga tersedia proyektor. Jadi dari sisi infrastruktur, saya rasa sudah cukup mendukung untuk menggunakan sistem digital.'],

    [17, 'Kiosk Presensi',
     'Untuk memudahkan proses absensi di ruang guru, apakah Bapak setuju jika disediakan perangkat display (kiosk) khusus yang menampilkan QR Code di ruang guru?',
     'Itu ide yang bagus. Jadi guru cukup datang ke ruang guru, lihat QR Code di layar, scan dengan HP masing-masing, dan absensi otomatis tercatat. Simpel dan tidak perlu antri. Kami bisa memanfaatkan komputer atau tablet yang ada di ruang guru untuk ini.'],

    [18, 'Keamanan Data',
     'Terkait keamanan data, apa harapan Bapak terhadap sistem yang akan dikembangkan?',
     'Data kehadiran guru dan nilai siswa itu sensitif, jadi harus aman. Saya harap ada sistem backup agar data tidak hilang. Selain itu, harus ada pengamanan agar data tidak bisa diakses atau diubah oleh pihak yang tidak berwenang. Password atau sistem login yang aman itu penting.'],

    [19, 'Kesiapan SDM',
     'Bagaimana dengan kesiapan sumber daya manusia di sekolah untuk mengadopsi sistem digital?',
     'Sebagian besar guru dan staf sudah terbiasa menggunakan smartphone dan komputer untuk keperluan dasar. Memang ada beberapa yang kurang familiar dengan teknologi, tapi saya yakin dengan pelatihan singkat dan tampilan sistem yang mudah dipahami, mereka bisa beradaptasi.'],

    [20, 'Harapan Keseluruhan',
     'Secara keseluruhan, apa harapan utama Bapak terhadap sistem yang akan dikembangkan?',
     'Harapan saya, sistem ini bisa menyelesaikan masalah pencatatan kehadiran yang tidak akurat, mempercepat proses penilaian siswa, dan memberikan data yang bisa saya akses kapan saja untuk pengambilan keputusan. Intinya, sistem yang sederhana, mudah digunakan, tapi fungsionalitasnya lengkap dan datanya akurat.']
  ];

  var currentRow = tableStart + 1;
  var questionNum = 0;

  for (var q = 0; q < qaData.length; q++) {
    if (qaData[q][0] === 'SECTION') {
      // Section header
      sheet.getRange(currentRow, 1, 1, 4).merge()
        .setValue(qaData[q][1]);
      styleSectionHeader(sheet.getRange(currentRow, 1, 1, 4));
      sheet.getRange(currentRow, 1).setHorizontalAlignment('left');
      sheet.setRowHeight(currentRow, 30);
      currentRow++;
    } else {
      sheet.getRange(currentRow, 1).setValue(qaData[q][0]).setHorizontalAlignment('center');
      sheet.getRange(currentRow, 2).setValue(qaData[q][1]);
      sheet.getRange(currentRow, 3).setValue(qaData[q][2]);
      sheet.getRange(currentRow, 4).setValue(qaData[q][3]);
      styleCell(sheet.getRange(currentRow, 1, 1, 4));

      // Alternating colors (skip section rows)
      var bg = (questionNum % 2 === 0) ? COLORS.WHITE : COLORS.LIGHT_BLUE;
      sheet.getRange(currentRow, 1, 1, 4).setBackground(bg);

      sheet.setRowHeight(currentRow, 70);
      questionNum++;
      currentRow++;
    }
  }

  sheet.setFrozenRows(tableStart);
}

/* ============================================================
 * SHEET 3: WAWANCARA STAF TATA USAHA
 * ============================================================ */

function createSheetTataUsaha(ss) {
  var sheet = ss.insertSheet('Wawancara Tata Usaha');

  sheet.setColumnWidth(1, 40);
  sheet.setColumnWidth(2, 130);
  sheet.setColumnWidth(3, 380);
  sheet.setColumnWidth(4, 480);

  // === HEADER ===
  sheet.getRange('A1:D1').merge()
    .setValue('HASIL WAWANCARA — STAF TATA USAHA')
    .setBackground(COLORS.PRIMARY)
    .setFontColor(COLORS.WHITE)
    .setFontWeight('bold')
    .setFontSize(13)
    .setHorizontalAlignment('center')
    .setVerticalAlignment('middle');
  sheet.setRowHeight(1, 45);

  // === INFO RESPONDEN ===
  var infoRows = [
    ['Responden', 'Agus'],
    ['Jabatan', 'Staf Tata Usaha SMPN 4 Purwakarta'],
    ['Lama Bekerja', '6 Tahun'],
    ['Tanggal Wawancara', '07 September 2025'],
    ['Pewawancara', 'Muhammad Rifky Akbar']
  ];

  for (var i = 0; i < infoRows.length; i++) {
    var row = 2 + i;
    sheet.getRange(row, 1, 1, 2).merge().setValue(infoRows[i][0])
      .setFontWeight('bold').setFontSize(10).setBackground(COLORS.LIGHT_GRAY)
      .setVerticalAlignment('middle');
    sheet.getRange(row, 3, 1, 2).merge().setValue(': ' + infoRows[i][1])
      .setFontSize(10).setBackground(COLORS.LIGHT_GRAY)
      .setVerticalAlignment('middle');
    sheet.setRowHeight(row, 25);
  }

  // === TABEL HEADER ===
  var tableStart = 8;
  var headers = ['No', 'Topik', 'Pertanyaan', 'Jawaban Responden'];
  var headerRange = sheet.getRange(tableStart, 1, 1, 4);
  headerRange.setValues([headers]);
  styleHeader(headerRange);
  sheet.setRowHeight(tableStart, 35);

  // === DATA PERTANYAAN & JAWABAN ===
  var qaData = [
    // --- BAGIAN A: PROSES ABSENSI ---
    ['SECTION', 'A. PROSES PENCATATAN DAN REKAPITULASI ABSENSI'],

    [1, 'Proses Pencatatan',
     'Bisa Bapak jelaskan secara detail bagaimana proses pencatatan absensi guru dilakukan sehari-hari?',
     'Setiap pagi kami menyiapkan buku absensi di meja ruang guru. Guru yang datang tinggal mengisi jam datang dan menandatangani. Sore hari, guru yang sudah selesai mengajar mengisi jam pulang. Prosesnya sederhana, tapi di situlah masalahnya — banyak yang lupa mengisi, terutama jam pulang.'],

    [2, 'Permasalahan Pencatatan',
     'Apa saja masalah yang sering Bapak temui saat mencatat kehadiran guru?',
     'Masalah paling sering itu guru lupa mengisi absensi. Kadang guru sudah hadir dan mengajar, tapi tidak mengisi buku. Ada juga guru yang tulisan tangannya sulit dibaca, sehingga saat saya input ke komputer kadang salah baca waktu kedatangannya. Pernah juga ada kasus buku absensi tercecer atau basah kena air minum.'],

    [3, 'Rekapitulasi',
     'Bagaimana proses rekapitulasi absensi guru yang Bapak lakukan? Berapa lama waktu yang dibutuhkan?',
     'Setiap bulan saya harus merekap semua data dari buku ke file Excel. Saya hitung satu per satu berapa kali setiap guru hadir, terlambat, izin, atau tidak hadir. Prosesnya memakan waktu 2-3 hari kerja karena harus teliti. Kadang tidak cocok antara hitungan manual dengan data di buku karena ada yang tidak jelas tulisannya.'],

    [4, 'Rekapitulasi',
     'Apakah pernah terjadi ketidakcocokan data saat rekapitulasi? Bagaimana cara Bapak mengatasinya?',
     'Sering terjadi. Misalnya di buku tertulis guru A hadir, tapi tidak ada tanda tangan. Atau sebaliknya. Kalau seperti itu, saya harus konfirmasi langsung ke guru yang bersangkutan, dan itu memakan waktu. Kadang guru juga sudah lupa apakah hari itu hadir atau tidak.'],

    [5, 'Pelaporan',
     'Bagaimana proses pembuatan laporan kehadiran yang Bapak lakukan? Kepada siapa laporannya diberikan?',
     'Setelah rekap bulanan selesai, saya buat laporan dalam format Excel lalu cetak untuk dilaporkan ke kepala sekolah. Formatnya di buat sendiri karena tidak ada standar baku. Kadang kepala sekolah minta format yang berbeda, jadi harus diubah lagi. Laporannya biasanya baru selesai di minggu pertama bulan berikutnya.'],

    // --- BAGIAN B: PENGELOLAAN DATA ---
    ['SECTION', 'B. PENGELOLAAN DAN KEAMANAN DATA'],

    [6, 'Penyimpanan Data',
     'Bagaimana Bapak menyimpan data kehadiran guru? Apakah ada sistem backup?',
     'Data asli ada di buku absensi yang disimpan di lemari arsip. Hasil rekapnya saya simpan di komputer dalam file Excel. Tapi tidak ada backup otomatis. Kalau komputernya rusak atau file-nya hilang, ya datanya hilang juga. Pernah sekali file rekap satu semester hilang karena harddisk rusak.'],

    [7, 'Penyimpanan Data',
     'Jika ingin mencari data kehadiran guru dari beberapa bulan atau tahun lalu, bagaimana caranya?',
     'Harus mencari buku arsip lama yang disimpan di lemari. Kadang butuh waktu lama karena tidak terorganisir dengan rapi. Untuk data digital, harus mencari file Excel satu per satu di komputer. Kalau filenya tidak diberi nama yang jelas, susah mencarinya.'],

    [8, 'Keamanan Data',
     'Apakah pernah ada kejadian kehilangan atau kerusakan data kehadiran?',
     'Pernah. Buku absensi pernah hampir rusak karena terkena tumpahan air. File di komputer juga pernah hilang saat komputer di-install ulang karena lupa backup. Kejadian seperti itu membuat kami was-was karena data yang hilang tidak bisa dikembalikan.'],

    // --- BAGIAN C: KEBUTUHAN TERHADAP SISTEM BARU ---
    ['SECTION', 'C. KEBUTUHAN DAN HARAPAN TERHADAP SISTEM BARU'],

    [9, 'Kebutuhan Sistem',
     'Menurut Bapak, fitur apa saja yang paling dibutuhkan jika nanti ada sistem absensi digital?',
     'Yang paling saya butuhkan adalah sistem yang bisa merekap kehadiran secara otomatis. Jadi saya tidak perlu lagi menghitung manual satu per satu. Selain itu, saya harap bisa langsung export laporan ke Excel atau PDF tanpa harus membuat format sendiri. Dan yang penting, datanya tersimpan aman secara digital.'],

    [10, 'Kebutuhan Sistem',
     'Bagaimana dengan fitur export laporan? Format apa yang Bapak butuhkan?',
     'Excel pasti dibutuhkan karena kami terbiasa mengolah data di situ. PDF juga bagus untuk laporan yang langsung dicetak dan diserahkan ke kepala sekolah. Kalau bisa ada filter juga, misalnya saya mau melihat rekap hanya untuk bulan tertentu atau guru tertentu saja.'],

    [11, 'Kebutuhan Sistem',
     'Untuk pengelolaan data siswa dan guru, apa yang Bapak harapkan dari sistem baru?',
     'Saya harap semua data guru dan siswa bisa dikelola di satu tempat. Sekarang data tersebar di banyak file Excel yang berbeda. Kalau ada sistem yang terpusat, mengelola data jadi lebih mudah. Misalnya data siswa bisa difilter per kelas, per tingkat, dan bisa langsung diexport kalau dibutuhkan.'],

    [12, 'Kemudahan Penggunaan',
     'Seberapa penting kemudahan penggunaan sistem bagi Bapak dan staf TU lainnya?',
     'Sangat penting. Kami bukan orang IT, jadi sistemnya harus mudah dipahami. Tombol-tombol harus jelas, tidak perlu banyak langkah untuk melakukan satu hal. Kalau terlalu rumit, nanti malah tidak dipakai. Kalau bisa, tampilan yang mirip dengan yang biasa kami gunakan sehari-hari.'],

    [13, 'Manajemen Pengguna',
     'Apakah menurut Bapak perlu ada pembatasan akses di dalam sistem? Misalnya, siapa yang boleh mengedit data dan siapa yang hanya bisa melihat?',
     'Perlu sekali. Tidak semua orang boleh mengubah data. Misalnya, guru hanya bisa melihat dan mengisi absensinya sendiri, tidak bisa mengubah data guru lain. Admin atau staf TU yang punya akses untuk mengelola keseluruhan data. Ini penting agar data tetap akurat dan tidak diubah sembarangan.'],

    [14, 'Pengaturan Sistem',
     'Apakah ada pengaturan-pengaturan tertentu yang Bapak ingin bisa diatur sendiri tanpa harus meminta bantuan teknis?',
     'Ya, misalnya mengubah informasi sekolah seperti nama kepala sekolah kalau ganti jabatan, atau mengatur tahun ajaran baru. Hal-hal seperti itu harusnya bisa diatur sendiri oleh admin tanpa perlu ubah kode program. Jadi fleksibel dan kami bisa mandiri mengelolanya.'],

    [15, 'Harapan Keseluruhan',
     'Secara keseluruhan, apa harapan utama Bapak terhadap sistem baru yang akan dikembangkan?',
     'Harapan saya sederhana: pekerjaan yang selama ini manual dan memakan waktu bisa menjadi lebih cepat dan akurat. Rekapitulasi yang biasanya 2-3 hari bisa selesai dalam hitungan menit. Data tersimpan aman, tidak takut hilang. Dan kalau kepala sekolah butuh laporan, saya bisa langsung cetak tanpa harus membuat ulang dari awal.']
  ];

  var currentRow = tableStart + 1;
  var questionNum = 0;

  for (var q = 0; q < qaData.length; q++) {
    if (qaData[q][0] === 'SECTION') {
      sheet.getRange(currentRow, 1, 1, 4).merge()
        .setValue(qaData[q][1]);
      styleSectionHeader(sheet.getRange(currentRow, 1, 1, 4));
      sheet.getRange(currentRow, 1).setHorizontalAlignment('left');
      sheet.setRowHeight(currentRow, 30);
      currentRow++;
    } else {
      sheet.getRange(currentRow, 1).setValue(qaData[q][0]).setHorizontalAlignment('center');
      sheet.getRange(currentRow, 2).setValue(qaData[q][1]);
      sheet.getRange(currentRow, 3).setValue(qaData[q][2]);
      sheet.getRange(currentRow, 4).setValue(qaData[q][3]);
      styleCell(sheet.getRange(currentRow, 1, 1, 4));

      var bg = (questionNum % 2 === 0) ? COLORS.WHITE : COLORS.LIGHT_BLUE;
      sheet.getRange(currentRow, 1, 1, 4).setBackground(bg);

      sheet.setRowHeight(currentRow, 70);
      questionNum++;
      currentRow++;
    }
  }

  sheet.setFrozenRows(tableStart);
}

/* ============================================================
 * SHEET 4: RANGKUMAN TEMUAN
 * ============================================================ */

function createSheetRangkuman(ss) {
  var sheet = ss.insertSheet('Rangkuman Temuan');

  sheet.setColumnWidth(1, 40);
  sheet.setColumnWidth(2, 160);
  sheet.setColumnWidth(3, 350);
  sheet.setColumnWidth(4, 350);
  sheet.setColumnWidth(5, 120);

  // === HEADER ===
  sheet.getRange('A1:E1').merge()
    .setValue('RANGKUMAN TEMUAN HASIL WAWANCARA')
    .setBackground(COLORS.PRIMARY)
    .setFontColor(COLORS.WHITE)
    .setFontWeight('bold')
    .setFontSize(13)
    .setHorizontalAlignment('center')
    .setVerticalAlignment('middle');
  sheet.setRowHeight(1, 45);

  sheet.getRange('A2:E2').merge()
    .setValue('Disusun berdasarkan hasil wawancara dengan Kepala Sekolah dan Staf Tata Usaha SMPN 4 Purwakarta, 07 September 2025')
    .setBackground(COLORS.SECONDARY)
    .setFontColor(COLORS.WHITE)
    .setFontSize(10)
    .setHorizontalAlignment('center')
    .setVerticalAlignment('middle');
  sheet.setRowHeight(2, 30);

  // === TABEL 1: RANGKUMAN PERMASALAHAN ===
  var t1Start = 4;
  sheet.getRange(t1Start, 1, 1, 5).merge()
    .setValue('A. RANGKUMAN PERMASALAHAN YANG TERIDENTIFIKASI')
    .setBackground(COLORS.ACCENT)
    .setFontColor(COLORS.WHITE)
    .setFontWeight('bold')
    .setFontSize(11)
    .setHorizontalAlignment('center');
  sheet.setRowHeight(t1Start, 32);

  var h1 = ['No', 'Aspek', 'Kondisi Saat Ini', 'Dampak', 'Sumber'];
  var h1Range = sheet.getRange(t1Start + 1, 1, 1, 5);
  h1Range.setValues([h1]);
  styleHeader(h1Range);
  sheet.setRowHeight(t1Start + 1, 32);

  var problemData = [
    [1, 'Absensi Guru — Ketidakakuratan Data',
     'Absensi menggunakan buku manual. Guru sering lupa mengisi. Tulisan tangan sering tidak jelas saat di-input ke komputer.',
     'Data kehadiran tidak akurat. Tingkat guru yang tidak mengisi absensi mencapai 32-40% setiap bulannya.',
     'Kepala Sekolah,\nStaf TU'],
    [2, 'Absensi Guru — Rekapitulasi Lambat',
     'Rekapitulasi dilakukan manual dari buku ke Excel. Memakan waktu 2-3 hari kerja setiap bulan.',
     'Laporan baru tersedia di bulan berikutnya. Monitoring kehadiran real-time tidak dimungkinkan.',
     'Staf TU'],
    [3, 'Absensi Guru — Risiko Kehilangan Data',
     'Data tersimpan di buku fisik dan file Excel tanpa backup otomatis.',
     'Pernah terjadi kehilangan data akibat kerusakan harddisk dan buku basah. Data tidak dapat dipulihkan.',
     'Staf TU'],
    [4, 'Absensi Guru — Tidak Ada Reminder',
     'Buku hanya diletakkan di meja, tidak ada mekanisme pengingat.',
     'Guru yang hadir tapi lupa mengisi absensi tercatat seolah tidak hadir.',
     'Kepala Sekolah'],
    [5, 'Penilaian — Proses Lama & Rawan Error',
     'Perhitungan nilai dan ranking menggunakan Excel manual. Memakan waktu 1-2 minggu per semester.',
     'Risiko salah rumus dan salah input tinggi. Pernah terjadi nilai siswa tertukar karena kesalahan copy-paste.',
     'Kepala Sekolah'],
    [6, 'Penilaian — Kurang Objektif',
     'Ranking hanya berdasarkan rata-rata nilai akademik tanpa mempertimbangkan aspek lain.',
     'Aspek kedisiplinan, sikap, dan keterampilan tidak terhitung. Seleksi siswa berprestasi bersifat subjektif.',
     'Kepala Sekolah'],
    [7, 'Penilaian — Kurang Transparan',
     'Proses penentuan ranking tidak terdokumentasi. Orang tua hanya menerima hasil akhir.',
     'Sulit mempertanggungjawabkan proses seleksi. Sulit membandingkan prestasi antar periode.',
     'Kepala Sekolah'],
    [8, 'Pelaporan — Manual & Tidak Standar',
     'Format laporan dibuat sendiri oleh staf TU, tidak ada standar baku.',
     'Harus membuat ulang jika kepala sekolah minta format berbeda. Waktu terbuang untuk formatting.',
     'Staf TU']
  ];

  for (var p = 0; p < problemData.length; p++) {
    var pr = t1Start + 2 + p;
    sheet.getRange(pr, 1, 1, 5).setValues([problemData[p]]);
    styleCell(sheet.getRange(pr, 1, 1, 5));
    sheet.getRange(pr, 1).setHorizontalAlignment('center');
    var pbg = (p % 2 === 0) ? COLORS.WHITE : COLORS.LIGHT_BLUE;
    sheet.getRange(pr, 1, 1, 5).setBackground(pbg);
    sheet.setRowHeight(pr, 65);
  }

  // === TABEL 2: KEBUTUHAN FUNGSIONAL ===
  var t2Start = t1Start + 2 + problemData.length + 1;
  sheet.getRange(t2Start, 1, 1, 5).merge()
    .setValue('B. KEBUTUHAN FUNGSIONAL YANG TERIDENTIFIKASI')
    .setBackground(COLORS.GREEN)
    .setFontColor(COLORS.WHITE)
    .setFontWeight('bold')
    .setFontSize(11)
    .setHorizontalAlignment('center');
  sheet.setRowHeight(t2Start, 32);

  var h2 = ['No', 'Kebutuhan', 'Deskripsi', 'Solusi yang Diinginkan', 'Prioritas'];
  var h2Range = sheet.getRange(t2Start + 1, 1, 1, 5);
  h2Range.setValues([h2]);
  styleHeader(h2Range, COLORS.GREEN);
  sheet.setRowHeight(t2Start + 1, 32);

  var needsData = [
    [1, 'Absensi digital QR Code',
     'Sistem absensi guru menggunakan QR Code yang dipindai melalui smartphone.',
     'QR Code terenkripsi yang ditampilkan di halaman admin atau perangkat kiosk di ruang guru. Guru scan dengan HP.',
     'Tinggi'],
    [2, 'Validasi lokasi (Geolocation)',
     'Memastikan guru benar-benar berada di area sekolah saat melakukan absensi.',
     'Validasi koordinat GPS dengan radius toleransi dari titik koordinat sekolah.',
     'Tinggi'],
    [3, 'Monitoring kehadiran real-time',
     'Kepala sekolah dapat memantau kehadiran guru secara langsung tanpa menunggu rekapitulasi.',
     'Dashboard yang menampilkan data kehadiran hari ini, tren mingguan, dan statistik bulanan.',
     'Tinggi'],
    [4, 'Penilaian multi-kriteria (SAW)',
     'Penilaian siswa tidak hanya berdasarkan nilai akademik, tapi juga kehadiran, sikap, dan keterampilan.',
     'Metode SAW dengan 4 kriteria siswa dan 4 kriteria guru, bobot dapat disesuaikan.',
     'Tinggi'],
    [5, 'Transparansi perhitungan',
     'Proses perhitungan ranking harus bisa dilihat secara detail oleh pengguna.',
     'Menampilkan matriks keputusan, normalisasi, dan skor akhir di halaman hasil SAW.',
     'Sedang'],
    [6, 'Export laporan (Excel & PDF)',
     'Laporan bisa langsung diunduh dalam format standar tanpa perlu membuat ulang.',
     '4 jenis laporan (presensi, nilai, data siswa, data guru) dengan filter dan format Excel/PDF.',
     'Tinggi'],
    [7, 'Manajemen hak akses (role)',
     'Setiap pengguna memiliki hak akses yang berbeda sesuai jabatan.',
     '4 role: Admin, Guru, Kepala Sekolah, Kiosk Presensi. Masing-masing dengan menu yang berbeda.',
     'Tinggi'],
    [8, 'Pengaturan sistem fleksibel',
     'Admin dapat mengatur parameter sekolah tanpa bantuan teknis.',
     'Halaman pengaturan untuk profil sekolah, tampilan, notifikasi, dan parameter sistem.',
     'Sedang'],
    [9, 'Rekapitulasi otomatis',
     'Proses rekapitulasi kehadiran tidak perlu lagi dilakukan manual.',
     'Sistem otomatis menghitung rekap harian, mingguan, dan bulanan.',
     'Tinggi'],
    [10, 'Keamanan dan backup data',
     'Data tersimpan aman secara digital dengan mekanisme backup.',
     'Database digital dengan fitur backup dari halaman pengaturan. Enkripsi untuk data sensitif.',
     'Tinggi']
  ];

  for (var n = 0; n < needsData.length; n++) {
    var nr = t2Start + 2 + n;
    sheet.getRange(nr, 1, 1, 5).setValues([needsData[n]]);
    styleCell(sheet.getRange(nr, 1, 1, 5));
    sheet.getRange(nr, 1).setHorizontalAlignment('center');
    sheet.getRange(nr, 5).setHorizontalAlignment('center');

    // Warna berdasarkan prioritas
    var nbg;
    if (needsData[n][4] === 'Tinggi') {
      nbg = (n % 2 === 0) ? COLORS.WHITE : COLORS.GREEN_LIGHT;
    } else {
      nbg = (n % 2 === 0) ? COLORS.WHITE : COLORS.YELLOW_LIGHT;
    }
    sheet.getRange(nr, 1, 1, 5).setBackground(nbg);

    // Bold + warna prioritas
    var prioCell = sheet.getRange(nr, 5);
    prioCell.setFontWeight('bold');
    if (needsData[n][4] === 'Tinggi') {
      prioCell.setFontColor(COLORS.GREEN);
    } else {
      prioCell.setFontColor(COLORS.ORANGE);
    }

    sheet.setRowHeight(nr, 60);
  }

  // === TABEL 3: KUTIPAN PENTING ===
  var t3Start = t2Start + 2 + needsData.length + 1;
  sheet.getRange(t3Start, 1, 1, 5).merge()
    .setValue('C. KUTIPAN PENTING DARI RESPONDEN')
    .setBackground(COLORS.ORANGE)
    .setFontColor(COLORS.WHITE)
    .setFontWeight('bold')
    .setFontSize(11)
    .setHorizontalAlignment('center');
  sheet.setRowHeight(t3Start, 32);

  var h3 = ['No', 'Responden', 'Kutipan', 'Konteks', 'Relevansi'];
  var h3Range = sheet.getRange(t3Start + 1, 1, 1, 5);
  h3Range.setValues([h3]);
  styleHeader(h3Range, COLORS.ORANGE);
  sheet.setRowHeight(t3Start + 1, 32);

  var quoteData = [
    [1, 'Agus\n(Staf TU)',
     '"Setiap bulan kami kesulitan merekap absensi karena harus menghitung manual satu per satu dari buku. Kadang ada yang tidak mengisi, ada yang tulisannya tidak jelas."',
     'Menjelaskan proses rekapitulasi absensi bulanan yang memakan waktu 2-3 hari.',
     'Kebutuhan rekapitulasi otomatis dan absensi digital'],
    [2, 'M. Nursodik, M.Pd.\n(Kepala Sekolah)',
     '"Saya kesulitan mengetahui guru mana yang sering tidak hadir atau terlambat secara real-time. Keputusan terkait pembinaan kedisiplinan menjadi terhambat."',
     'Menjelaskan dampak keterlambatan data terhadap pengambilan keputusan.',
     'Kebutuhan dashboard monitoring real-time'],
    [3, 'M. Nursodik, M.Pd.\n(Kepala Sekolah)',
     '"Penilaian seharusnya tidak hanya dari nilai akademik saja. Aspek lain seperti kedisiplinan, sikap, dan keterampilan juga perlu dipertimbangkan."',
     'Menjelaskan kelemahan sistem penilaian yang hanya menggunakan rata-rata nilai.',
     'Kebutuhan metode SAW multi-kriteria'],
    [4, 'M. Nursodik, M.Pd.\n(Kepala Sekolah)',
     '"Yang penting, prosesnya transparan dan hasilnya bisa dilihat secara detail, bagaimana nilai akhirnya diperoleh."',
     'Menjelaskan kebutuhan transparansi dalam proses penilaian.',
     'Kebutuhan fitur transparansi perhitungan SAW'],
    [5, 'Agus\n(Staf TU)',
     '"Pernah sekali file rekap satu semester hilang karena harddisk rusak."',
     'Menjelaskan risiko kehilangan data pada sistem penyimpanan saat ini.',
     'Kebutuhan backup data digital'],
    [6, 'Agus\n(Staf TU)',
     '"Pekerjaan yang selama ini manual dan memakan waktu bisa menjadi lebih cepat dan akurat. Rekapitulasi yang biasanya 2-3 hari bisa selesai dalam hitungan menit."',
     'Menggambarkan harapan utama terhadap sistem baru.',
     'Efisiensi sebagai tujuan utama']
  ];

  for (var c = 0; c < quoteData.length; c++) {
    var cr = t3Start + 2 + c;
    sheet.getRange(cr, 1, 1, 5).setValues([quoteData[c]]);
    styleCell(sheet.getRange(cr, 1, 1, 5));
    sheet.getRange(cr, 1).setHorizontalAlignment('center');
    sheet.getRange(cr, 3).setFontStyle('italic');

    var cbg = (c % 2 === 0) ? COLORS.WHITE : COLORS.ORANGE_LIGHT;
    sheet.getRange(cr, 1, 1, 5).setBackground(cbg);
    sheet.setRowHeight(cr, 70);
  }

  // === KESIMPULAN ===
  var concStart = t3Start + 2 + quoteData.length + 1;
  sheet.getRange(concStart, 1, 1, 5).merge()
    .setValue('D. KESIMPULAN')
    .setBackground(COLORS.PRIMARY)
    .setFontColor(COLORS.WHITE)
    .setFontWeight('bold')
    .setFontSize(11)
    .setHorizontalAlignment('center');
  sheet.setRowHeight(concStart, 32);

  var conclusion =
    'Berdasarkan hasil wawancara dengan kedua responden, teridentifikasi bahwa sistem absensi dan penilaian yang berjalan di SMPN 4 Purwakarta masih sepenuhnya manual. ' +
    'Sistem absensi menggunakan buku yang menyebabkan ketidakakuratan data (32-40% guru tidak mengisi), rekapitulasi lambat (2-3 hari), dan risiko kehilangan data yang tinggi. ' +
    'Sistem penilaian menggunakan Excel manual yang memakan waktu 1-2 minggu dan hanya mempertimbangkan rata-rata nilai akademik tanpa aspek lain.\n\n' +
    'Kedua responden menyatakan kebutuhan akan sistem digital yang mampu: (1) mencatat kehadiran secara otomatis dan akurat melalui QR Code dengan validasi lokasi, ' +
    '(2) menyediakan monitoring real-time melalui dashboard, (3) menerapkan penilaian multi-kriteria yang objektif dan transparan menggunakan metode SAW, ' +
    '(4) menghasilkan laporan otomatis dalam format Excel dan PDF, serta (5) menjamin keamanan data melalui penyimpanan digital dengan backup.';

  sheet.getRange(concStart + 1, 1, 1, 5).merge()
    .setValue(conclusion)
    .setFontSize(10)
    .setFontColor(COLORS.DARK_TEXT)
    .setVerticalAlignment('top')
    .setWrap(true)
    .setBackground(COLORS.LIGHT_GRAY)
    .setBorder(true, true, true, true, true, true, COLORS.BORDER, SpreadsheetApp.BorderStyle.SOLID);
  sheet.setRowHeight(concStart + 1, 130);

  sheet.setFrozenRows(0);
}
