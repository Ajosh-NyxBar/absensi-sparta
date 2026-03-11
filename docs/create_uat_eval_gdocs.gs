// ============================================================
// PEMBAHASAN EVALUASI SISTEM (UAT) — Google Apps Script
// Sistem Informasi Absensi Guru & Penilaian Siswa SMPN 4 Purwakarta
// ============================================================
// CARA PAKAI:
// 1. Buka https://script.google.com
// 2. Klik "New Project"
// 3. Hapus semua kode yang ada, paste SEMUA kode ini
// 4. Klik tombol ▶ Run (pilih createUATEvalDocs)
// 5. Pertama kali minta izin — klik "Review permissions" > pilih akun > "Allow"
// 6. Buka Google Docs yang dibuat (link di Logger / Execution Log)
// ============================================================

function createUATEvalDocs() {
  var doc = DocumentApp.create('Evaluasi Sistem — User Acceptance Testing (UAT) — SMPN 4 Purwakarta');
  var body = doc.getBody();

  var C = {
    PRIMARY:  '#1e40af',
    DARK:     '#1e293b',
    HEAD_BG:  '#1e3a5f',
    ALT_BG:   '#eff6ff',
    GREEN:    '#16a34a',
    ACCENT:   '#059669'
  };

  body.clear();

  writeCover_(body, C);
  body.appendPageBreak();
  writePendahuluan_(body, C);
  body.appendPageBreak();
  writePesertaUAT_(body, C);
  body.appendPageBreak();
  writeMetodeEvaluasi_(body, C);
  body.appendPageBreak();
  writeProsedurPelaksanaan_(body, C);
  body.appendPageBreak();
  writeDaftarNamaPeserta_(body, C);
  body.appendPageBreak();
  writeHasilKuesioner_(body, C);
  body.appendPageBreak();
  writeRekapPerPertanyaan_(body, C);
  body.appendPageBreak();
  writeDistribusiFrekuensi_(body, C);
  body.appendPageBreak();
  writeRekapPerAspek_(body, C);
  body.appendPageBreak();
  writeAnalisisPerAspek_(body, C);
  body.appendPageBreak();
  writeFeedbackKualitatif_(body, C);
  body.appendPageBreak();
  writePerbaikanAkhir_(body, C);
  body.appendPageBreak();
  writeKesimpulan_(body, C);

  doc.saveAndClose();
  Logger.log('✅ Dokumen evaluasi UAT berhasil dibuat!');
  Logger.log('🔗 Buka: ' + doc.getUrl());
}


// ============================================================
// HELPER FUNCTIONS
// ============================================================
function h1_(body, text, color) {
  var p = body.appendParagraph(text);
  p.setHeading(DocumentApp.ParagraphHeading.HEADING1);
  p.setForegroundColor(color || '#1e293b');
  p.setSpacingBefore(20); p.setSpacingAfter(10);
  return p;
}
function h2_(body, text, color) {
  var p = body.appendParagraph(text);
  p.setHeading(DocumentApp.ParagraphHeading.HEADING2);
  p.setForegroundColor(color || '#1e40af');
  p.setSpacingBefore(16); p.setSpacingAfter(8);
  return p;
}
function h3_(body, text, color) {
  var p = body.appendParagraph(text);
  p.setHeading(DocumentApp.ParagraphHeading.HEADING3);
  p.setForegroundColor(color || '#4338ca');
  p.setSpacingBefore(12); p.setSpacingAfter(6);
  return p;
}
function p_(body, text) {
  var pr = body.appendParagraph(text);
  pr.setLineSpacing(1.5); pr.setSpacingAfter(6);
  return pr;
}
function pBold_(body, text) {
  var pr = body.appendParagraph(text);
  pr.editAsText().setBold(true); pr.setSpacingAfter(4);
  return pr;
}
function pItalic_(body, text) {
  var pr = body.appendParagraph(text);
  pr.editAsText().setItalic(true); pr.setSpacingAfter(4);
  pr.setForegroundColor('#64748b');
  return pr;
}
function bullet_(body, text) {
  var i = body.appendListItem(text);
  i.setGlyphType(DocumentApp.GlyphType.BULLET);
  i.setLineSpacing(1.4);
  return i;
}
function numberedItem_(body, text, nesting) {
  var i = body.appendListItem(text);
  i.setGlyphType(DocumentApp.GlyphType.NUMBER);
  i.setLineSpacing(1.4);
  if (nesting) i.setNestingLevel(nesting);
  return i;
}
function table_(body, headers, rows, hBg, aBg) {
  hBg = hBg || '#1e3a5f'; aBg = aBg || '#eff6ff';
  var all = [headers].concat(rows);
  var t = body.appendTable(all);
  var hr = t.getRow(0);
  for (var c = 0; c < headers.length; c++) {
    var cell = hr.getCell(c);
    cell.setBackgroundColor(hBg);
    cell.editAsText().setForegroundColor('#ffffff');
    cell.editAsText().setBold(true);
    cell.editAsText().setFontSize(10);
    cell.setPaddingTop(6); cell.setPaddingBottom(6);
  }
  for (var r = 1; r < t.getNumRows(); r++) {
    var row = t.getRow(r);
    var bg = (r % 2 === 0) ? aBg : '#ffffff';
    for (var c2 = 0; c2 < row.getNumCells(); c2++) {
      var cell2 = row.getCell(c2);
      cell2.setBackgroundColor(bg);
      cell2.editAsText().setFontSize(9);
      cell2.setPaddingTop(4); cell2.setPaddingBottom(4);
    }
  }
  body.appendParagraph('');
  return t;
}
function highlightRow_(t, rowIdx, bg) {
  var row = t.getRow(rowIdx);
  for (var c = 0; c < row.getNumCells(); c++) {
    var cell = row.getCell(c);
    cell.setBackgroundColor(bg || '#dbeafe');
    cell.editAsText().setBold(true);
  }
}


// ============================================================
// COVER
// ============================================================
function writeCover_(body, C) {
  body.appendParagraph('').setSpacingAfter(50);

  var title = body.appendParagraph('EVALUASI SISTEM');
  title.setHeading(DocumentApp.ParagraphHeading.TITLE);
  title.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  title.setForegroundColor(C.PRIMARY);
  title.editAsText().setFontSize(26);

  var sub1 = body.appendParagraph('User Acceptance Testing (UAT)');
  sub1.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  sub1.editAsText().setFontSize(16);
  sub1.editAsText().setBold(true);
  sub1.setForegroundColor(C.DARK);

  var line = body.appendParagraph('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
  line.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  line.setForegroundColor(C.PRIMARY);

  var sub2 = body.appendParagraph('Sistem Informasi Absensi Guru & Penilaian Siswa');
  sub2.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  sub2.editAsText().setFontSize(13);
  sub2.setForegroundColor(C.DARK);

  var school = body.appendParagraph('SMPN 4 Purwakarta');
  school.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  school.editAsText().setFontSize(15);
  school.editAsText().setBold(true);
  school.setForegroundColor(C.PRIMARY);

  body.appendParagraph('').setSpacingAfter(30);

  var info1 = body.appendParagraph('Jumlah Peserta UAT: 34 orang');
  info1.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  info1.editAsText().setFontSize(11);
  var info2 = body.appendParagraph('Komposisi: 1 Kepala Sekolah, 32 Guru, 1 Staf TU/Admin');
  info2.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  info2.editAsText().setFontSize(11);
  var info3 = body.appendParagraph('Rata-rata Keseluruhan: 4,46 / 5,00 (89,29%) — Sangat Baik');
  info3.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  info3.editAsText().setFontSize(12);
  info3.editAsText().setBold(true);
  info3.setForegroundColor(C.ACCENT);

  body.appendParagraph('').setSpacingAfter(20);
  var date = body.appendParagraph('Dibuat: ' + new Date().toLocaleDateString('id-ID', {day:'numeric',month:'long',year:'numeric'}));
  date.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  date.editAsText().setFontSize(10);
  date.setForegroundColor('#94a3b8');
}


// ============================================================
// 1. PENDAHULUAN
// ============================================================
function writePendahuluan_(body, C) {
  h1_(body, '1. Evaluasi Sistem', C.DARK);
  p_(body, 'Setelah pengujian internal menggunakan metode Black Box Testing dan White Box Testing selesai dilakukan serta seluruh kesalahan (bug) yang ditemukan telah diperbaiki, proses pengembangan dilanjutkan ke tahap evaluasi sistem. Pada tahap ini, sistem yang telah dibangun diuji coba kepada pengguna akhir di SMPN 4 Purwakarta untuk memperoleh penilaian langsung terkait kesesuaian fitur, kemudahan penggunaan, serta kesiapan sistem untuk diterapkan dalam lingkungan operasional sekolah.');

  h2_(body, '1.1 User Acceptance Testing (UAT)', C.PRIMARY);

  h3_(body, 'Tujuan dan Ruang Lingkup');
  p_(body, 'User Acceptance Testing (UAT) dilaksanakan dengan tujuan untuk memvalidasi bahwa sistem yang dikembangkan telah memenuhi kebutuhan nyata pengguna serta layak digunakan dalam aktivitas operasional sehari-hari. Proses UAT difokuskan pada lima aspek utama, yaitu fungsionalitas fitur, kemudahan penggunaan (usability), kecepatan respons sistem (performance), kualitas tampilan antarmuka, dan keandalan operasional sistem.');
}


// ============================================================
// 2. PESERTA UAT
// ============================================================
function writePesertaUAT_(body, C) {
  h2_(body, '1.2 Peserta UAT', C.PRIMARY);
  p_(body, 'Sebanyak 34 (tiga puluh empat) peserta dilibatkan dalam proses User Acceptance Testing (UAT) yang merupakan calon pengguna langsung sistem di SMPN 4 Purwakarta. Pemilihan peserta dilakukan dengan mencakup seluruh peran yang tersedia dalam sistem, sehingga setiap fitur dapat dievaluasi secara menyeluruh oleh pengguna yang sesuai dengan perannya.');

  pBold_(body, 'Tabel: Daftar Peserta UAT');
  table_(body,
    ['No', 'Kategori Peserta', 'Jumlah', 'Role dalam Sistem', 'Fitur yang Diuji'],
    [
      ['1', 'Kepala Sekolah', '1', 'Kepala Sekolah', 'Dashboard monitoring, ranking SAW guru & siswa, export laporan'],
      ['2', 'Guru SMPN 4 Purwakarta', '32', 'Guru', 'Scan QR Code absensi, input nilai siswa, rekap kehadiran, ranking SAW'],
      ['3', 'Staf Tata Usaha', '1', 'Admin', 'Manajemen data master, generate QR Code, export laporan'],
      ['', 'Total Responden', '34', '', '']
    ]
  );

  p_(body, 'Responden terdiri dari 1 orang kepala sekolah, 32 orang guru aktif, dan 1 orang staf tata usaha. Pemilihan 32 guru sebagai responden mayoritas dilakukan karena guru merupakan pengguna utama (end-user) yang paling intensif berinteraksi dengan fitur scan QR Code absensi dan input nilai siswa. Setiap peserta diberikan akun sesuai perannya dan diminta untuk mencoba seluruh fitur yang menjadi tanggung jawabnya dalam skenario penggunaan yang menyerupai kondisi riil operasional sekolah.');
}


// ============================================================
// 3. METODE EVALUASI
// ============================================================
function writeMetodeEvaluasi_(body, C) {
  h2_(body, '1.3 Metode Evaluasi', C.PRIMARY);
  p_(body, 'Evaluasi dilakukan menggunakan kuesioner yang terdiri dari 10 pertanyaan dengan skala Likert 1–5 (1 = Sangat Tidak Setuju, 2 = Tidak Setuju, 3 = Netral, 4 = Setuju, dan 5 = Sangat Setuju). Pertanyaan dalam kuesioner tersebut dikategorikan ke dalam lima aspek evaluasi. Selain menggunakan kuesioner, pengumpulan data juga dilakukan melalui feedback kualitatif yang diperoleh dari wawancara singkat setelah peserta selesai mencoba sistem.');

  pBold_(body, 'Tabel: Daftar Pertanyaan Kuesioner UAT');
  table_(body,
    ['No', 'Pertanyaan', 'Aspek Evaluasi'],
    [
      ['1', 'Seluruh fitur sistem berfungsi sesuai dengan kebutuhan saya', 'Fungsionalitas'],
      ['2', 'Fitur absensi QR Code dan validasi lokasi bekerja dengan baik', 'Fungsionalitas'],
      ['3', 'Sistem mudah dipelajari dan dioperasikan tanpa panduan berulang', 'Kemudahan Penggunaan'],
      ['4', 'Navigasi menu dan alur penggunaan sistem sudah intuitif', 'Kemudahan Penggunaan'],
      ['5', 'Sistem merespon perintah dengan cepat (loading halaman, proses data)', 'Kecepatan Sistem'],
      ['6', 'Proses scan QR Code dan export laporan berjalan tanpa delay berarti', 'Kecepatan Sistem'],
      ['7', 'Tampilan antarmuka sistem menarik dan profesional', 'Tampilan Antarmuka'],
      ['8', 'Informasi pada dashboard mudah dipahami (grafik, statistik, tabel)', 'Tampilan Antarmuka'],
      ['9', 'Sistem berjalan stabil tanpa error atau crash selama pengujian', 'Keandalan'],
      ['10', 'Saya yakin sistem ini dapat digunakan secara rutin di sekolah', 'Keandalan']
    ]
  );
}


// ============================================================
// 4. PROSEDUR PELAKSANAAN
// ============================================================
function writeProsedurPelaksanaan_(body, C) {
  h2_(body, '1.4 Prosedur Pelaksanaan', C.PRIMARY);
  p_(body, 'Pelaksanaan UAT dilakukan dengan tahapan sebagai berikut:');

  pBold_(body, '1. Briefing');
  p_(body, 'Pada tahap ini diberikan penjelasan singkat kepada seluruh peserta mengenai tujuan evaluasi yang dilakukan serta tata cara pengisian kuesioner agar proses penilaian dapat dilakukan dengan benar.');

  pBold_(body, '2. Eksplorasi Mandiri');
  p_(body, 'Setiap peserta diberikan waktu untuk mengeksplorasi dan mengoperasikan fitur-fitur sistem sesuai perannya masing-masing.');

  pBold_(body, '3. Skenario Tugas');
  p_(body, 'Peserta diminta menjalankan tugas-tugas spesifik:');
  bullet_(body, 'Guru: melakukan scan QR Code untuk absensi, menginput nilai siswa satu kelas, dan melihat rekap kehadiran pribadi.');
  bullet_(body, 'Admin: menambah data guru baru, melakukan generate QR Code, dan mengekspor laporan kehadiran ke Excel.');
  bullet_(body, 'Kepala Sekolah: melihat dashboard monitoring, menjalankan perhitungan ranking SAW, dan melihat detail perhitungan.');

  pBold_(body, '4. Pengisian Kuesioner');
  p_(body, 'Setelah selesai mencoba, peserta mengisi kuesioner penilaian.');

  pBold_(body, '5. Wawancara');
  p_(body, 'Pada tahap ini dilakukan wawancara singkat dengan peserta untuk memperoleh feedback kualitatif serta saran perbaikan yang dapat digunakan sebagai bahan evaluasi dan pengembangan sistem lebih lanjut.');
}


// ============================================================
// 5. DAFTAR NAMA PESERTA
// ============================================================
function writeDaftarNamaPeserta_(body, C) {
  h1_(body, '2. Hasil Evaluasi Pengguna', C.DARK);
  h2_(body, '2.1 Daftar Nama Peserta UAT', C.PRIMARY);
  p_(body, 'Berikut adalah daftar lengkap 34 peserta yang mengikuti proses User Acceptance Testing:');

  table_(body,
    ['No', 'Nama Responden', 'Jabatan'],
    [
      ['R1', 'Mohamad Nursodik, M.Pd', 'Kepala Sekolah'],
      ['R2', 'Agus', 'Staf TU / Admin'],
      ['R3', 'Nuraisyah, S.Hum', 'Guru'],
      ['R4', 'Noneng Nurayish, S.I.Pust', 'Guru'],
      ['R5', 'Lia Nurnengsih, S.Pd', 'Guru'],
      ['R6', 'Lukman Hakim, S.Pd', 'Guru'],
      ['R7', 'Irfan Nurkhotis, S.Pd', 'Guru'],
      ['R8', 'Nurul Khoeriyah, S.Pd', 'Guru'],
      ['R9', 'Sumipi Megasari, S.Pd', 'Guru'],
      ['R10', 'Nia Dayuwariti, S.Pd', 'Guru'],
      ['R11', 'Yeyen Hendrayani, S.Pd', 'Guru'],
      ['R12', 'Pian Anianto, S.Pd', 'Guru'],
      ['R13', 'Abdurahman, S.Ag', 'Guru'],
      ['R14', 'Siti Nurhasanah, S.Pd', 'Guru'],
      ['R15', 'Ude Suhaenah, S.Pd', 'Guru'],
      ['R16', 'Maya Herawati Sudjana, S.Ag', 'Guru'],
      ['R17', 'Agus Herdiana, S.Pd', 'Guru'],
      ['R18', 'Wening Hidayah, S.Pd', 'Guru'],
      ['R19', 'Endang Suryati, S.S', 'Guru'],
      ['R20', 'Kartini, M.Pd', 'Guru'],
      ['R21', 'Sri Harlati, S.Pd', 'Guru'],
      ['R22', 'Supenti, S.Pd', 'Guru'],
      ['R23', 'E. Rakhmah Hidayati, S.Pd', 'Guru'],
      ['R24', 'Gocep Dukin Saprudin R, S.Pd', 'Guru'],
      ['R25', 'Dra. Midla Martha', 'Guru'],
      ['R26', 'Cucu Kosasih, S.Pd', 'Guru'],
      ['R27', 'Ratna Hardini, S.Pd', 'Guru'],
      ['R28', 'Dra. Yuli Suparmii', 'Guru'],
      ['R29', 'Nunung Rafiha Suminar, S.Pd', 'Guru'],
      ['R30', 'Hidayat, S.Pd', 'Guru'],
      ['R31', 'Dra. Engkur Kurniati', 'Guru'],
      ['R32', 'Tati Karwati, S.Pd', 'Guru'],
      ['R33', 'Yaiti Apriyah, S.Pd', 'Guru'],
      ['R34', 'Ahmad Fauzi, S.Pd', 'Guru']
    ]
  );
}


// ============================================================
// 6. HASIL KUESIONER (TABEL SKOR LENGKAP)
// ============================================================
function writeHasilKuesioner_(body, C) {
  h2_(body, '2.2 Hasil Kuesioner UAT', C.PRIMARY);
  p_(body, 'Hasil pengisian kuesioner oleh para peserta User Acceptance Testing (UAT) digunakan untuk mengetahui tingkat penerimaan pengguna terhadap sistem yang telah dikembangkan. Setiap responden memberikan skor antara 1 hingga 5 pada 10 pertanyaan yang diajukan.');

  pBold_(body, 'Tabel: Hasil Kuesioner Responden UAT');

  var scores = [
    [5,5,4,5,5,5,4,5,5,5],
    [5,5,5,5,5,5,4,4,4,5],
    [5,5,4,4,5,5,4,5,5,5],
    [5,4,4,5,4,4,4,4,5,4],
    [4,5,4,4,5,4,5,4,4,5],
    [5,4,5,4,4,5,4,4,5,4],
    [5,5,5,5,5,5,4,4,4,5],
    [4,4,5,4,5,4,4,5,4,5],
    [5,5,4,5,4,5,5,4,5,4],
    [4,4,4,4,5,4,4,4,4,5],
    [5,4,5,5,4,4,4,5,5,5],
    [4,5,4,4,5,5,4,4,4,4],
    [5,4,4,5,4,4,5,4,5,5],
    [4,5,5,4,5,4,4,5,4,4],
    [5,4,4,4,4,5,4,4,5,5],
    [4,4,5,5,5,4,5,4,4,4],
    [5,5,4,4,4,5,4,5,5,5],
    [4,4,4,5,5,4,4,4,4,5],
    [5,5,5,4,4,4,5,5,5,4],
    [5,4,4,4,5,5,4,4,4,5],
    [4,4,5,5,4,4,4,5,5,4],
    [5,5,4,4,5,5,5,4,4,5],
    [4,4,4,5,4,4,4,4,5,4],
    [5,5,5,4,5,4,4,5,4,5],
    [4,4,4,4,4,5,5,4,5,5],
    [5,5,4,5,5,4,4,4,4,4],
    [4,4,5,4,4,5,4,5,5,5],
    [5,4,4,4,5,4,5,4,4,4],
    [4,5,4,5,4,5,4,4,5,5],
    [5,4,5,4,5,4,4,5,4,4],
    [4,5,4,5,4,4,5,4,5,5],
    [5,4,4,4,5,5,4,4,4,5],
    [4,4,5,5,4,4,5,5,5,4],
    [5,5,4,4,5,4,4,4,4,5]
  ];

  var n = scores.length;
  var qCount = 10;

  var headers = ['No'];
  for (var i = 1; i <= qCount; i++) headers.push('Q' + i);
  headers.push('Total');

  var rows = [];
  var colSums = [];
  for (var j = 0; j < qCount; j++) colSums.push(0);

  for (var r = 0; r < n; r++) {
    var row = ['R' + (r + 1)];
    var rowTotal = 0;
    for (var j = 0; j < qCount; j++) {
      row.push(String(scores[r][j]));
      colSums[j] += scores[r][j];
      rowTotal += scores[r][j];
    }
    row.push(String(rowTotal));
    rows.push(row);
  }

  // Jumlah row
  var sumRow = ['Jumlah'];
  var grandSum = 0;
  for (var j = 0; j < qCount; j++) { sumRow.push(String(colSums[j])); grandSum += colSums[j]; }
  sumRow.push(String(grandSum));
  rows.push(sumRow);

  // Rata-rata row
  var avgRow = ['Rata-rata'];
  for (var j = 0; j < qCount; j++) { avgRow.push((colSums[j] / n).toFixed(2).replace('.', ',')); }
  avgRow.push((grandSum / (n * qCount)).toFixed(2).replace('.', ','));
  rows.push(avgRow);

  // Build table
  var all = [headers].concat(rows);
  var t = body.appendTable(all);

  // Style header
  var hr = t.getRow(0);
  for (var c = 0; c < headers.length; c++) {
    var cell = hr.getCell(c);
    cell.setBackgroundColor(C.HEAD_BG);
    cell.editAsText().setForegroundColor('#ffffff');
    cell.editAsText().setBold(true);
    cell.editAsText().setFontSize(8);
    cell.setPaddingTop(4); cell.setPaddingBottom(4);
    cell.setPaddingLeft(3); cell.setPaddingRight(3);
  }

  // Style data rows
  for (var r2 = 1; r2 < t.getNumRows(); r2++) {
    var dataRow = t.getRow(r2);
    var bg = (r2 % 2 === 0) ? C.ALT_BG : '#ffffff';
    for (var c2 = 0; c2 < dataRow.getNumCells(); c2++) {
      var cell2 = dataRow.getCell(c2);
      cell2.setBackgroundColor(bg);
      cell2.editAsText().setFontSize(8);
      cell2.setPaddingTop(3); cell2.setPaddingBottom(3);
      cell2.setPaddingLeft(3); cell2.setPaddingRight(3);
    }
  }

  // Highlight Jumlah & Rata-rata rows
  var numRows = t.getNumRows();
  highlightRow_(t, numRows - 2, '#dbeafe');
  highlightRow_(t, numRows - 1, '#dcfce7');

  body.appendParagraph('');

  // Keterangan pertanyaan
  pBold_(body, 'Keterangan pertanyaan:');
  bullet_(body, 'Q1: Seluruh fitur sistem berfungsi sesuai dengan kebutuhan saya');
  bullet_(body, 'Q2: Fitur absensi QR Code dan validasi lokasi bekerja dengan baik');
  bullet_(body, 'Q3: Sistem mudah dipelajari dan dioperasikan tanpa panduan berulang');
  bullet_(body, 'Q4: Navigasi menu dan alur penggunaan sistem sudah intuitif');
  bullet_(body, 'Q5: Sistem merespon perintah dengan cepat (loading halaman, proses data)');
  bullet_(body, 'Q6: Proses scan QR Code dan export laporan berjalan tanpa delay berarti');
  bullet_(body, 'Q7: Tampilan antarmuka sistem menarik dan profesional');
  bullet_(body, 'Q8: Informasi pada dashboard mudah dipahami (grafik, statistik, tabel)');
  bullet_(body, 'Q9: Sistem berjalan stabil tanpa error atau crash selama pengujian');
  bullet_(body, 'Q10: Saya yakin sistem ini dapat digunakan secara rutin di sekolah');
}


// ============================================================
// 7. REKAPITULASI PER PERTANYAAN
// ============================================================
function writeRekapPerPertanyaan_(body, C) {
  h2_(body, '2.3 Rekapitulasi Rata-rata Skor per Pertanyaan', C.PRIMARY);

  p_(body, 'Perhitungan persentase kelayakan menggunakan rumus:');
  p_(body, 'Persentase = (Skor Total / Skor Maksimal) × 100%');
  p_(body, 'Persentase = (1518 / 1700) × 100% = 89,29%');

  p_(body, 'Hasil penilaian kemudian dianalisis per pertanyaan untuk mengetahui skor rata-rata pada setiap aspek evaluasi:');

  pBold_(body, 'Tabel: Hasil Penilaian Kuesioner UAT per Pertanyaan');
  var t = table_(body,
    ['No', 'Aspek', 'Pertanyaan', 'Skor Rata-rata', 'Persentase'],
    [
      ['1', 'Fungsionalitas', 'Seluruh fitur berfungsi sesuai kebutuhan (Q1)', '4,59', '91,76%'],
      ['2', '', 'Absensi QR Code dan validasi lokasi bekerja baik (Q2)', '4,47', '89,41%'],
      ['', '', 'Rata-rata Aspek Fungsionalitas', '4,53', '90,59%'],
      ['3', 'Kemudahan Penggunaan', 'Sistem mudah dipelajari tanpa panduan berulang (Q3)', '4,38', '87,65%'],
      ['4', '', 'Navigasi menu dan alur penggunaan sudah intuitif (Q4)', '4,44', '88,82%'],
      ['', '', 'Rata-rata Aspek Kemudahan Penggunaan', '4,41', '88,24%'],
      ['5', 'Kecepatan Sistem', 'Sistem merespon perintah dengan cepat (Q5)', '4,56', '91,18%'],
      ['6', '', 'Scan QR dan export laporan tanpa delay berarti (Q6)', '4,44', '88,82%'],
      ['', '', 'Rata-rata Aspek Kecepatan Sistem', '4,50', '90,00%'],
      ['7', 'Tampilan Antarmuka', 'Tampilan antarmuka menarik dan profesional (Q7)', '4,29', '85,88%'],
      ['8', '', 'Informasi dashboard mudah dipahami (Q8)', '4,35', '87,06%'],
      ['', '', 'Rata-rata Aspek Tampilan Antarmuka', '4,32', '86,47%'],
      ['9', 'Keandalan', 'Sistem berjalan stabil tanpa error atau crash (Q9)', '4,50', '90,00%'],
      ['10', '', 'Sistem layak digunakan secara rutin di sekolah (Q10)', '4,62', '92,35%'],
      ['', '', 'Rata-rata Aspek Keandalan', '4,56', '91,18%'],
      ['', '', 'Rata-rata Keseluruhan', '4,46', '89,29%']
    ]
  );

  // Highlight subtotal rows
  highlightRow_(t, 3, '#dbeafe');
  highlightRow_(t, 6, '#dbeafe');
  highlightRow_(t, 9, '#dbeafe');
  highlightRow_(t, 12, '#dbeafe');
  highlightRow_(t, 15, '#dbeafe');
  highlightRow_(t, 16, '#fef3c7');
}


// ============================================================
// 8. DISTRIBUSI FREKUENSI
// ============================================================
function writeDistribusiFrekuensi_(body, C) {
  h2_(body, '2.4 Distribusi Frekuensi Jawaban', C.PRIMARY);
  p_(body, 'Distribusi frekuensi jawaban dari seluruh peserta UAT digunakan untuk melihat penyebaran respons terhadap setiap pilihan pada skala Likert:');

  pBold_(body, 'Tabel: Distribusi Frekuensi Jawaban Kuesioner UAT');
  table_(body,
    ['Skala', 'Keterangan', 'Frekuensi', 'Persentase'],
    [
      ['5', 'Sangat Setuju', '158', '46,47%'],
      ['4', 'Setuju', '182', '53,53%'],
      ['3', 'Netral', '0', '0%'],
      ['2', 'Tidak Setuju', '0', '0%'],
      ['1', 'Sangat Tidak Setuju', '0', '0%'],
      ['', 'Total', '340', '100%']
    ]
  );

  pItalic_(body, 'Keterangan: Total jawaban = 34 responden × 10 pertanyaan = 340 jawaban.');
  p_(body, 'Berdasarkan tabel di atas, seluruh responden memberikan penilaian pada skala 4 (Setuju) dan 5 (Sangat Setuju). Tidak terdapat responden yang memberikan penilaian negatif (skala 1–3), yang mengindikasikan tingkat kepuasan dan penerimaan yang tinggi terhadap sistem.');
}


// ============================================================
// 9. REKAPITULASI PER ASPEK
// ============================================================
function writeRekapPerAspek_(body, C) {
  h2_(body, '2.5 Rekapitulasi Skor per Aspek Evaluasi', C.PRIMARY);
  p_(body, 'Hasil penilaian dikelompokkan berdasarkan lima aspek evaluasi untuk mengetahui tingkat penerimaan sistem pada setiap aspek yang dinilai:');

  pBold_(body, 'Tabel: Rekapitulasi Skor UAT per Aspek Evaluasi');
  var t = table_(body,
    ['No', 'Aspek Evaluasi', 'Pertanyaan', 'Skor Rata-rata', 'Persentase', 'Kategori'],
    [
      ['1', 'Fungsionalitas', 'Q1, Q2', '4,53', '90,59%', 'Sangat Baik'],
      ['2', 'Kemudahan Penggunaan', 'Q3, Q4', '4,41', '88,24%', 'Sangat Baik'],
      ['3', 'Kecepatan Sistem', 'Q5, Q6', '4,50', '90,00%', 'Sangat Baik'],
      ['4', 'Tampilan Antarmuka', 'Q7, Q8', '4,32', '86,47%', 'Sangat Baik'],
      ['5', 'Keandalan', 'Q9, Q10', '4,56', '91,18%', 'Sangat Baik'],
      ['', 'Rata-rata Keseluruhan', '', '4,46', '89,29%', 'Sangat Baik']
    ]
  );
  highlightRow_(t, 6, '#fef3c7');

  p_(body, 'Kategori penilaian ditentukan berdasarkan interval skor berikut:');

  pBold_(body, 'Tabel: Skala Kategori Penilaian');
  table_(body,
    ['Interval Skor', 'Persentase', 'Kategori'],
    [
      ['4,21 – 5,00', '84,2% – 100%', 'Sangat Baik'],
      ['3,41 – 4,20', '68,2% – 84,0%', 'Baik'],
      ['2,61 – 3,40', '52,2% – 68,0%', 'Cukup'],
      ['1,81 – 2,60', '36,2% – 52,0%', 'Kurang'],
      ['1,00 – 1,80', '20,0% – 36,0%', 'Sangat Kurang']
    ]
  );

  p_(body, 'Rata-rata skor keseluruhan sebesar 4,46 dari skala 5,00 menghasilkan persentase kelayakan sebesar 89,29% yang menempatkan sistem pada kategori "Sangat Baik". Seluruh aspek evaluasi memperoleh persentase di atas 84%, dengan aspek Keandalan memperoleh persentase tertinggi (91,18%) dan aspek Tampilan Antarmuka memperoleh persentase terendah (86,47%), namun keduanya tetap berada pada kategori "Sangat Baik".');
}


// ============================================================
// 10. ANALISIS PER ASPEK
// ============================================================
function writeAnalisisPerAspek_(body, C) {
  h2_(body, '2.6 Analisis Hasil per Aspek', C.PRIMARY);

  // Fungsionalitas
  h3_(body, 'a) Fungsionalitas (Skor: 4,53 — 90,59% — Sangat Baik)');
  p_(body, 'Aspek fungsionalitas memperoleh skor rata-rata 4,53 yang menunjukkan bahwa fitur-fitur yang dibangun meliputi absensi QR Code dengan validasi geolocation, input nilai dengan perhitungan otomatis, perhitungan ranking SAW, dan export laporan telah sesuai dengan kebutuhan operasional pengguna di SMPN 4 Purwakarta. Dari 34 responden, 20 orang (58,82%) memberikan skor 5 dan 14 orang (41,18%) memberikan skor 4 pada pertanyaan Q1 tentang kesesuaian fitur. Hal ini mengindikasikan bahwa tidak ada fitur utama yang dinilai kurang atau tidak berfungsi oleh responden.');

  // Kemudahan Penggunaan
  h3_(body, 'b) Kemudahan Penggunaan (Skor: 4,41 — 88,24% — Sangat Baik)');
  p_(body, 'Aspek kemudahan penggunaan mendapatkan skor 4,41. Meskipun masuk kategori "Sangat Baik", skor ini merupakan yang terendah kedua di antara seluruh aspek. Berdasarkan wawancara, beberapa guru yang kurang familiar dengan teknologi memerlukan waktu adaptasi awal untuk memahami alur navigasi sistem. Namun setelah mencoba 2–3 kali, seluruh peserta menyatakan dapat mengoperasikan sistem secara mandiri tanpa bantuan. Pada pertanyaan Q3, sebanyak 21 orang (61,76%) memberikan skor 4 dan 13 orang (38,24%) memberikan skor 5, yang mengindikasikan bahwa sistem sudah cukup mudah digunakan meskipun masih ada ruang untuk penyederhanaan.');

  // Kecepatan Sistem
  h3_(body, 'c) Kecepatan Sistem (Skor: 4,50 — 90,00% — Sangat Baik)');
  p_(body, 'Peserta menilai bahwa sistem merespons perintah dengan cepat. Proses scan QR Code, loading halaman dashboard, dan proses export laporan berlangsung tanpa delay yang berarti. Pada pertanyaan Q5 tentang kecepatan respon, 19 dari 34 responden (55,88%) memberikan skor 5, menunjukkan bahwa mayoritas pengguna sangat puas dengan performa sistem. Penggunaan framework Laravel dengan Vite sebagai build tool dan optimasi query Eloquent berkontribusi pada performa sistem yang responsif.');

  // Tampilan Antarmuka
  h3_(body, 'd) Tampilan Antarmuka (Skor: 4,32 — 86,47% — Sangat Baik)');
  p_(body, 'Aspek tampilan antarmuka memperoleh skor terendah (4,32), meskipun masih masuk kategori "Sangat Baik". Pada pertanyaan Q7, 24 dari 34 responden (70,59%) memberikan skor 4 dan 10 orang (29,41%) memberikan skor 5. Berdasarkan feedback, saran perbaikan terkait tampilan meliputi penggunaan ukuran font yang lebih besar pada beberapa halaman, penyesuaian kontras warna, dan penyesuaian tata letak untuk layar smartphone berukuran kecil.');

  // Keandalan
  h3_(body, 'e) Keandalan (Skor: 4,56 — 91,18% — Sangat Baik)');
  p_(body, 'Aspek keandalan memperoleh skor tertinggi (4,56) di antara seluruh aspek yang dievaluasi. Peserta menilai bahwa sistem berjalan stabil selama proses evaluasi tanpa mengalami error atau crash. Pada pertanyaan Q10, 21 dari 34 responden (61,76%) memberikan skor 5 yang menunjukkan keyakinan tinggi bahwa sistem layak digunakan secara rutin di lingkungan sekolah. Skor keandalan yang tinggi ini sejalan dengan hasil pengujian internal (Black Box 100% berhasil dan White Box 19/19 jalur lolos) yang telah dilakukan sebelumnya.');
}


// ============================================================
// 11. FEEDBACK KUALITATIF
// ============================================================
function writeFeedbackKualitatif_(body, C) {
  h2_(body, '2.7 Feedback Kualitatif dari Pengguna', C.PRIMARY);
  p_(body, 'Selain melalui kuesioner, pengumpulan data juga dilakukan dengan memperoleh feedback kualitatif melalui wawancara singkat dengan setiap peserta setelah proses evaluasi sistem selesai dilakukan:');

  pBold_(body, 'Tabel: Feedback Kualitatif Peserta UAT');
  table_(body,
    ['No', 'Peserta', 'Feedback', 'Kategori'],
    [
      ['1', 'Kepala Sekolah', '"Dashboard monitoring sangat membantu untuk memantau kehadiran guru secara langsung tanpa harus bertanya ke TU. Detail perhitungan SAW juga transparan sehingga bisa dipertanggungjawabkan."', 'Positif'],
      ['2', 'Guru 1', '"Scan QR Code lewat HP sangat praktis, tidak perlu lagi cari buku absensi. Tapi perlu ada petunjuk di awal supaya tidak bingung saat pertama kali pakai."', 'Positif + Saran'],
      ['3', 'Guru 2', '"Tampilan input nilai sudah bagus, apalagi sudah ada keterangan bobot perhitungan. Nilai akhir dihitung otomatis jadi tidak perlu kalkulator lagi."', 'Positif'],
      ['4', 'Guru 3', '"Perlu petunjuk penggunaan singkat untuk guru-guru yang kurang familiar dengan teknologi. Kalau sudah terbiasa, sistemnya mudah dipakai."', 'Saran'],
      ['5', 'Staf TU', '"Export laporan ke Excel sangat menghemat waktu. Yang biasanya 2–3 hari rekapitulasi sekarang bisa langsung jadi. Filter per kelas dan per periode juga sangat membantu."', 'Positif']
    ]
  );

  h3_(body, 'Tingkat Penerimaan Pengguna');
  p_(body, 'Dari 34 peserta UAT, seluruhnya menyatakan puas terhadap sistem yang dikembangkan dan menyetujui bahwa sistem ini layak digunakan secara operasional di SMPN 4 Purwakarta. Hal ini terlihat dari skor pertanyaan Q10 ("Layak digunakan rutin") yang memperoleh rata-rata 4,62 — dimana 21 responden (61,76%) memberikan skor 5 (Sangat Setuju) dan 13 responden (38,24%) memberikan skor 4 (Setuju). Tidak ada peserta yang memberikan skor di bawah 4 untuk pertanyaan ini, yang mengkonfirmasi tingkat penerimaan yang sangat tinggi terhadap sistem.');
}


// ============================================================
// 12. PERBAIKAN AKHIR
// ============================================================
function writePerbaikanAkhir_(body, C) {
  h2_(body, '2.8 Perbaikan Akhir Berdasarkan Feedback UAT', C.PRIMARY);
  p_(body, 'Berdasarkan feedback dan saran yang diperoleh dari peserta User Acceptance Testing (UAT), dilakukan beberapa perbaikan akhir pada sistem sebelum memasuki tahap implementasi:');

  pBold_(body, 'Tabel: Daftar Perbaikan Akhir Berdasarkan Feedback UAT');
  table_(body,
    ['No', 'Sumber Feedback', 'Perbaikan yang Dilakukan', 'Deskripsi', 'Status'],
    [
      ['1', 'Guru 1, Guru 3', 'Penambahan tooltip bantuan', 'Menambahkan ikon bantuan (?) dengan tooltip pada fitur-fitur utama seperti tombol scan QR, form input nilai, dan halaman perhitungan SAW untuk membantu pengguna baru memahami fungsi setiap elemen', 'Selesai'],
      ['2', 'Staf TU', 'Optimasi loading halaman data', 'Menerapkan lazy loading dan paginasi pada tabel data yang memiliki banyak record (data siswa, data kehadiran) agar halaman tidak lambat saat jumlah data semakin besar', 'Selesai'],
      ['3', 'Guru 2', 'Penyesuaian tampilan mobile', 'Memperbesar area sentuh (touch target) tombol-tombol pada tampilan mobile sesuai standar minimum 44×44 pixel agar lebih mudah dioperasikan pada layar smartphone', 'Selesai'],
      ['4', 'Guru 3', 'Penambahan pesan konfirmasi', 'Menambahkan dialog konfirmasi sebelum aksi penting (hapus data, submit nilai) untuk mencegah kesalahan operasi yang tidak disengaja', 'Selesai']
    ]
  );

  p_(body, 'Seluruh perbaikan telah diimplementasikan dan diverifikasi ulang sebelum sistem memasuki tahap implementasi akhir.');
}


// ============================================================
// 13. KESIMPULAN
// ============================================================
function writeKesimpulan_(body, C) {
  h1_(body, '3. Kesimpulan Evaluasi UAT', C.DARK);

  p_(body, 'Berdasarkan hasil User Acceptance Testing (UAT) yang melibatkan 34 peserta (1 Kepala Sekolah, 32 Guru, dan 1 Staf TU) dari SMPN 4 Purwakarta, dapat disimpulkan bahwa:');

  bullet_(body, 'Sistem memperoleh rata-rata skor keseluruhan sebesar 4,46 dari skala 5,00 (persentase 89,29%), yang menempatkannya pada kategori "Sangat Baik".');
  bullet_(body, 'Seluruh 5 aspek evaluasi (Fungsionalitas, Kemudahan Penggunaan, Kecepatan Sistem, Tampilan Antarmuka, dan Keandalan) berada pada kategori "Sangat Baik" dengan skor > 4,21.');
  bullet_(body, 'Aspek Keandalan memperoleh skor tertinggi (4,56 / 91,18%), menunjukkan bahwa sistem berjalan stabil dan siap untuk penggunaan rutin.');
  bullet_(body, 'Aspek Tampilan Antarmuka memperoleh skor terendah (4,32 / 86,47%), namun tetap masuk kategori "Sangat Baik". Perbaikan UI telah dilakukan berdasarkan feedback.');
  bullet_(body, 'Seluruh 340 jawaban (34 responden × 10 pertanyaan) berada pada skala 4 dan 5, tanpa ada penilaian negatif (skala 1–3).');
  bullet_(body, 'Skor Q10 "Layak digunakan rutin" memperoleh rata-rata tertinggi (4,62 / 92,35%), mengkonfirmasi penerimaan pengguna yang sangat tinggi.');
  bullet_(body, '4 perbaikan akhir berdasarkan feedback UAT telah berhasil diimplementasikan dan diverifikasi.');

  h2_(body, '3.1 Rangkuman Skor', C.PRIMARY);
  var t = table_(body,
    ['Aspek', 'Skor', 'Persentase', 'Kategori'],
    [
      ['Fungsionalitas', '4,53', '90,59%', 'Sangat Baik'],
      ['Kemudahan Penggunaan', '4,41', '88,24%', 'Sangat Baik'],
      ['Kecepatan Sistem', '4,50', '90,00%', 'Sangat Baik'],
      ['Tampilan Antarmuka', '4,32', '86,47%', 'Sangat Baik'],
      ['Keandalan', '4,56', '91,18%', 'Sangat Baik'],
      ['TOTAL KESELURUHAN', '4,46', '89,29%', 'Sangat Baik']
    ]
  );
  highlightRow_(t, 6, '#fef3c7');

  body.appendParagraph('').setSpacingAfter(30);
  var end = body.appendParagraph('— Akhir Dokumen Evaluasi Sistem (UAT) —');
  end.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  end.setForegroundColor('#94a3b8');
  end.editAsText().setFontSize(11);
  end.editAsText().setItalic(true);
}
