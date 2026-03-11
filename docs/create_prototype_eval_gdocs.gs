// ============================================================
// PEMBAHASAN EVALUASI PROTOTYPE — Google Apps Script
// Sistem Informasi Absensi Guru & Penilaian Siswa SMPN 4 Purwakarta
// ============================================================
// CARA PAKAI:
// 1. Buka https://script.google.com
// 2. Klik "New Project"
// 3. Hapus semua kode yang ada, paste SEMUA kode ini
// 4. Klik tombol ▶ Run (pilih createPrototypeEvalDocs)
// 5. Pertama kali minta izin — klik "Review permissions" > pilih akun > "Allow"
// 6. Buka Google Docs yang dibuat (link di Logger / Execution Log)
// ============================================================

function createPrototypeEvalDocs() {
  var doc = DocumentApp.create('Pembahasan Evaluasi Prototype — Sistem Presensi & Penilaian SMPN 4 Purwakarta');
  var body = doc.getBody();

  // Warna tema
  var C = {
    PRIMARY:  '#1e40af',
    DARK:     '#1e293b',
    HEAD_BG:  '#1e3a5f',
    ALT_BG:   '#eff6ff',
    GREEN:    '#16a34a',
    RED:      '#dc2626',
    ORANGE:   '#ea580c',
    ACCENT:   '#059669'
  };

  body.clear();

  writeCover_(body, C);
  body.appendPageBreak();
  writePendahuluan_(body, C);
  body.appendPageBreak();
  writeResponden_(body, C);
  body.appendPageBreak();
  writeDataKuesioner_(body, C);
  body.appendPageBreak();
  writeHasilPerAspek_(body, C);
  body.appendPageBreak();
  writeRekapitulasi_(body, C);
  body.appendPageBreak();
  writeAnalisisKualitatif_(body, C);
  body.appendPageBreak();
  writeKesimpulan_(body, C);

  doc.saveAndClose();
  Logger.log('✅ Dokumen evaluasi prototype berhasil dibuat!');
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
  var p = body.appendParagraph(text);
  p.setLineSpacing(1.5); p.setSpacingAfter(6);
  return p;
}
function pBold_(body, text) {
  var p = body.appendParagraph(text);
  p.editAsText().setBold(true); p.setSpacingAfter(4);
  return p;
}
function pItalic_(body, text) {
  var p = body.appendParagraph(text);
  p.editAsText().setItalic(true); p.setSpacingAfter(4);
  p.setForegroundColor('#64748b');
  return p;
}
function bullet_(body, text) {
  var i = body.appendListItem(text);
  i.setGlyphType(DocumentApp.GlyphType.BULLET);
  i.setLineSpacing(1.4);
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
/** Baris rata-rata aspek (highlight) */
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

  var title = body.appendParagraph('PEMBAHASAN EVALUASI PROTOTYPE');
  title.setHeading(DocumentApp.ParagraphHeading.TITLE);
  title.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  title.setForegroundColor(C.PRIMARY);
  title.editAsText().setFontSize(26);

  var line = body.appendParagraph('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
  line.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  line.setForegroundColor(C.PRIMARY);

  var sub = body.appendParagraph('Sistem Informasi Absensi Guru & Penilaian Siswa');
  sub.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  sub.editAsText().setFontSize(13);
  sub.setForegroundColor(C.DARK);

  var school = body.appendParagraph('SMPN 4 Purwakarta');
  school.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  school.editAsText().setFontSize(15);
  school.editAsText().setBold(true);
  school.setForegroundColor(C.PRIMARY);

  body.appendParagraph('').setSpacingAfter(30);

  var info1 = body.appendParagraph('Jumlah Responden: 25 orang');
  info1.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  info1.editAsText().setFontSize(11);
  var info2 = body.appendParagraph('Komposisi: 1 Kepala Sekolah, 23 Guru, 1 Staf TU/Admin');
  info2.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  info2.editAsText().setFontSize(11);
  var info3 = body.appendParagraph('Rata-rata Keseluruhan: 4,50 / 5,00 (90,00%) — Sangat Baik');
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
  h1_(body, '1. Pendahuluan', C.DARK);

  h2_(body, '1.1 Tujuan Evaluasi', C.PRIMARY);
  p_(body, 'Evaluasi prototype bertujuan untuk menilai kelayakan rancangan Sistem Informasi Absensi Guru menggunakan QR Code dan Penilaian Siswa Berbasis Web dengan Metode SAW sebelum masuk ke tahap pengkodean (coding). Evaluasi dilakukan terhadap rancangan yang telah dibuat, meliputi diagram UML, desain antarmuka (mockup), struktur basis data (ERD), dan mekanisme perhitungan SAW.');

  h2_(body, '1.2 Metode Evaluasi', C.PRIMARY);
  p_(body, 'Evaluasi dilakukan menggunakan kuesioner dengan skala Likert 1–5 yang disebarkan kepada stakeholder SMPN 4 Purwakarta melalui Google Forms. Kuesioner mencakup 18 indikator yang dikelompokkan ke dalam 5 aspek penilaian, ditambah 3 pertanyaan terbuka untuk masukan kualitatif.');

  h2_(body, '1.3 Skala Penilaian', C.PRIMARY);
  table_(body,
    ['Skala', 'Keterangan'],
    [
      ['5', 'Sangat Setuju'],
      ['4', 'Setuju'],
      ['3', 'Netral'],
      ['2', 'Tidak Setuju'],
      ['1', 'Sangat Tidak Setuju']
    ]
  );

  h2_(body, '1.4 Kategori Kelayakan', C.PRIMARY);
  p_(body, 'Hasil rata-rata skor diinterpretasikan menggunakan kategori berikut:');
  table_(body,
    ['Rentang Skor', 'Persentase', 'Kategori'],
    [
      ['4,21 – 5,00', '84,20% – 100%', 'Sangat Baik'],
      ['3,41 – 4,20', '68,20% – 84,00%', 'Baik'],
      ['2,61 – 3,40', '52,20% – 68,00%', 'Cukup'],
      ['1,81 – 2,60', '36,20% – 52,00%', 'Kurang'],
      ['1,00 – 1,80', '20,00% – 36,00%', 'Sangat Kurang']
    ]
  );

  h2_(body, '1.5 Aspek Penilaian', C.PRIMARY);
  p_(body, 'Kuesioner evaluasi prototype terdiri dari 5 aspek utama:');
  table_(body,
    ['No', 'Aspek', 'Jumlah Indikator', 'Keterangan'],
    [
      ['1', 'Kesesuaian Fungsional', '3', 'Use Case, Activity Diagram, relevansi fitur'],
      ['2', 'Desain Antarmuka', '6', 'Login, dashboard admin/guru, scan QR, input nilai, laporan'],
      ['3', 'Struktur Basis Data', '3', 'Tabel, relasi, atribut ERD'],
      ['4', 'Algoritma SAW', '4', 'Kriteria siswa/guru, bobot, flowchart'],
      ['5', 'Kelayakan Keseluruhan', '2', 'Kelayakan pengembangan, potensi solusi']
    ]
  );
}


// ============================================================
// 2. PROFIL RESPONDEN
// ============================================================
function writeResponden_(body, C) {
  h1_(body, '2. Profil Responden', C.DARK);

  h2_(body, '2.1 Komposisi Responden', C.PRIMARY);
  p_(body, 'Evaluasi prototype diikuti oleh 25 responden yang terdiri dari stakeholder SMPN 4 Purwakarta:');
  table_(body,
    ['No', 'Jabatan/Peran', 'Jumlah', 'Persentase'],
    [
      ['1', 'Kepala Sekolah', '1', '4%'],
      ['2', 'Guru', '23', '92%'],
      ['3', 'Staf Tata Usaha / Admin', '1', '4%'],
      ['', 'Total', '25', '100%']
    ]
  );
  p_(body, 'Mayoritas responden adalah guru (92%) yang merupakan pengguna utama sistem, baik sebagai pengguna fitur absensi QR Code maupun sebagai penginput nilai siswa. Keterlibatan Kepala Sekolah dan Staf TU memastikan evaluasi mencakup perspektif manajemen dan administrasi.');

  h2_(body, '2.2 Daftar Responden', C.PRIMARY);
  table_(body,
    ['No', 'Nama', 'Jabatan'],
    [
      ['1', 'Mohamad Nursodik, M.Pd', 'Kepala Sekolah'],
      ['2', 'Nuraisyah, S.Hum', 'Guru'],
      ['3', 'Noneng Nurayish, S.I.Pust', 'Guru'],
      ['4', 'Lia Nurnengsih, S.Pd', 'Guru'],
      ['5', 'Lukman Hakim, S.Pd', 'Guru'],
      ['6', 'Irfan Nurkhotis, S.Pd', 'Guru'],
      ['7', 'Nurul Khoeriyah, S.Pd', 'Guru'],
      ['8', 'Sumipi Megasari, S.Pd', 'Guru'],
      ['9', 'Nia Dayuwariti, S.Pd', 'Guru'],
      ['10', 'Yeyen Hendrayani, S.Pd', 'Guru'],
      ['11', 'Pian Anianto, S.Pd', 'Guru'],
      ['12', 'Abdurahman, S.Ag', 'Guru'],
      ['13', 'Siti Nurhasanah, S.Pd', 'Guru'],
      ['14', 'Ude Suhaenah, S.Pd', 'Guru'],
      ['15', 'Maya Herawati Sudjana, S.Ag', 'Guru'],
      ['16', 'Agus Herdiana, S.Pd', 'Guru'],
      ['17', 'Wening Hidayah, S.Pd', 'Guru'],
      ['18', 'Endang Suryati, S.S', 'Guru'],
      ['19', 'Kartini, M.Pd', 'Guru'],
      ['20', 'Sri Harlati, S.Pd', 'Guru'],
      ['21', 'Supenti, S.Pd', 'Guru'],
      ['22', 'Dra. Midla Martha', 'Guru'],
      ['23', 'Cucu Kosasih, S.Pd', 'Guru'],
      ['24', 'Ratna Hardini, S.Pd', 'Guru'],
      ['25', 'Agus', 'Staf Tata Usaha / Admin']
    ]
  );
}


// ============================================================
// DATA HASIL KUESIONER
// ============================================================
function writeDataKuesioner_(body, C) {
  h2_(body, 'Tabel Hasil Kuesioner Evaluasi Prototype', C.PRIMARY);
  p_(body, 'Berikut adalah data skor dari 25 responden untuk 18 indikator penilaian (Q1–Q18):');
  pItalic_(body, 'Q1–Q3: Kesesuaian Fungsional  |  Q4–Q9: Desain Antarmuka  |  Q10–Q12: Struktur Basis Data  |  Q13–Q16: Algoritma SAW  |  Q17–Q18: Kelayakan Keseluruhan');

  var scores = [
    [5,5,5,4,4,4,5,4,5,5,5,5,5,5,5,4,5,5],
    [5,4,5,4,4,4,4,5,4,5,5,4,5,4,5,4,4,5],
    [4,5,4,4,5,4,4,4,5,5,4,5,4,5,4,5,5,4],
    [4,4,5,5,4,4,4,4,4,4,5,5,5,4,5,4,4,5],
    [5,4,4,4,4,5,4,4,4,5,5,5,4,5,4,5,5,4],
    [5,5,5,5,4,4,5,5,4,5,5,5,5,5,4,5,5,5],
    [4,5,4,4,4,5,4,4,4,5,4,5,4,5,5,4,4,5],
    [5,4,5,4,5,4,5,4,5,4,5,5,5,4,5,5,5,4],
    [4,4,4,4,4,4,4,4,4,5,4,4,4,4,4,5,4,4],
    [5,4,5,4,5,4,4,5,4,5,5,4,5,4,5,4,5,5],
    [4,5,4,5,4,4,4,4,5,4,5,5,4,5,4,4,4,5],
    [5,4,5,4,4,5,4,4,4,5,5,5,5,4,5,4,5,4],
    [4,5,4,4,4,4,5,4,4,4,5,5,4,5,5,4,4,5],
    [5,4,4,4,5,4,4,4,5,5,4,5,4,5,4,5,5,4],
    [4,4,5,5,4,4,4,5,4,5,5,4,5,4,4,5,4,5],
    [5,5,4,4,4,5,5,4,5,5,5,5,5,5,4,5,5,5],
    [4,4,4,4,4,4,4,4,4,4,5,5,4,4,5,4,4,5],
    [5,5,5,4,5,4,4,4,5,5,4,5,5,4,5,4,5,4],
    [5,4,5,5,4,4,5,4,4,5,5,5,4,5,5,5,5,5],
    [4,4,5,4,4,5,4,5,4,5,5,4,4,5,4,5,4,5],
    [5,5,4,4,5,4,5,4,5,4,5,5,5,4,5,4,5,4],
    [4,4,4,4,4,4,4,4,5,5,5,5,5,4,4,5,4,5],
    [5,5,4,4,4,5,4,5,4,5,4,5,4,5,5,4,5,4],
    [4,4,5,5,4,4,5,4,5,4,5,5,4,5,4,5,4,5],
    [5,5,5,5,5,4,5,5,5,5,5,5,4,5,5,4,5,5]
  ];

  var n = scores.length;
  var qCount = 18;

  // Build headers
  var headers = ['No'];
  for (var i = 1; i <= qCount; i++) headers.push('Q' + i);
  headers.push('Total');

  // Build rows + compute column sums
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
  avgRow.push((grandSum / n).toFixed(2).replace('.', ','));
  rows.push(avgRow);

  // Persentase row
  var pctRow = ['Persentase'];
  for (var j = 0; j < qCount; j++) { pctRow.push(((colSums[j] / n / 5) * 100).toFixed(2).replace('.', ',') + '%'); }
  pctRow.push(((grandSum / n / (qCount * 5)) * 100).toFixed(2).replace('.', ',') + '%');
  rows.push(pctRow);

  // Create table
  var all = [headers].concat(rows);
  var t = body.appendTable(all);

  // Style header row
  var hr = t.getRow(0);
  for (var c = 0; c < headers.length; c++) {
    var cell = hr.getCell(c);
    cell.setBackgroundColor(C.HEAD_BG);
    cell.editAsText().setForegroundColor('#ffffff');
    cell.editAsText().setBold(true);
    cell.editAsText().setFontSize(7);
    cell.setPaddingTop(3);
    cell.setPaddingBottom(3);
    cell.setPaddingLeft(2);
    cell.setPaddingRight(2);
  }

  // Style data rows
  for (var r2 = 1; r2 < t.getNumRows(); r2++) {
    var dataRow = t.getRow(r2);
    var bg = (r2 % 2 === 0) ? C.ALT_BG : '#ffffff';
    for (var c2 = 0; c2 < dataRow.getNumCells(); c2++) {
      var cell2 = dataRow.getCell(c2);
      cell2.setBackgroundColor(bg);
      cell2.editAsText().setFontSize(7);
      cell2.setPaddingTop(2);
      cell2.setPaddingBottom(2);
      cell2.setPaddingLeft(2);
      cell2.setPaddingRight(2);
    }
  }

  // Highlight summary rows (Jumlah, Rata-rata, Persentase)
  var numRows = t.getNumRows();
  var sumColors = ['#dbeafe', '#dcfce7', '#fef3c7'];
  for (var s = 0; s < 3; s++) {
    var sRow = t.getRow(numRows - 3 + s);
    for (var c3 = 0; c3 < sRow.getNumCells(); c3++) {
      var cell3 = sRow.getCell(c3);
      cell3.setBackgroundColor(sumColors[s]);
      cell3.editAsText().setBold(true);
    }
  }

  body.appendParagraph('');
}


// ============================================================
// 3. HASIL PER ASPEK
// ============================================================
function writeHasilPerAspek_(body, C) {
  h1_(body, '3. Hasil Evaluasi per Aspek', C.DARK);

  // ====== ASPEK 1 ======
  h2_(body, '3.1 Aspek 1: Kesesuaian Fungsional', C.PRIMARY);
  p_(body, 'Aspek ini menilai apakah rancangan fungsional sistem (Use Case dan Activity Diagram) telah mencakup seluruh kebutuhan pengguna dan sesuai dengan prosedur operasional sekolah.');

  var t1 = table_(body,
    ['No', 'Indikator', 'Skor Rata-rata', 'Persentase', 'Kategori'],
    [
      ['1', '(a) Use Case mencakup seluruh kebutuhan pengguna', '4,56', '91,20%', 'Sangat Baik'],
      ['2', '(b) Activity Diagram sesuai prosedur operasional', '4,44', '88,80%', 'Sangat Baik'],
      ['3', '(c) Fitur relevan dengan permasalahan yang ada', '4,52', '90,40%', 'Sangat Baik'],
      ['', 'Rata-rata Aspek 1', '4,51', '90,13%', 'Sangat Baik']
    ]
  );
  highlightRow_(t1, 4, '#dbeafe');

  pBold_(body, 'Analisis:');
  p_(body, 'Aspek Kesesuaian Fungsional memperoleh rata-rata skor 4,51 (90,13%) dengan kategori "Sangat Baik". Indikator tertinggi adalah "Use Case mencakup seluruh kebutuhan pengguna" (4,56 / 91,20%), yang menunjukkan bahwa Use Case Diagram yang dirancang telah berhasil merepresentasikan seluruh aktor dan interaksi utama dalam sistem. Activity Diagram juga dinilai sesuai dengan prosedur operasional sekolah yang ada (4,44 / 88,80%), meskipun beberapa responden menyarankan penambahan sequence diagram untuk alur yang lebih kompleks.');

  // ====== ASPEK 2 ======
  h2_(body, '3.2 Aspek 2: Desain Antarmuka', C.PRIMARY);
  p_(body, 'Aspek ini menilai kualitas desain antarmuka (UI/UX) dari mockup yang dirancang, mencakup halaman login, dashboard, scan QR Code, input nilai, dan laporan.');

  var t2 = table_(body,
    ['No', 'Indikator', 'Skor Rata-rata', 'Persentase', 'Kategori'],
    [
      ['4', '(a) Desain login mudah dipahami dan intuitif', '4,28', '85,60%', 'Sangat Baik'],
      ['5', '(b) Dashboard admin menampilkan info yang dibutuhkan', '4,28', '85,60%', 'Sangat Baik'],
      ['6', '(c) Dashboard guru menampilkan info yang relevan', '4,24', '84,80%', 'Sangat Baik'],
      ['7', '(d) Halaman scan QR Code memiliki alur jelas', '4,36', '87,20%', 'Sangat Baik'],
      ['8', '(e) Halaman input nilai memudahkan penilaian', '4,28', '85,60%', 'Sangat Baik'],
      ['9', '(f) Halaman laporan menyediakan format ekspor sesuai', '4,44', '88,80%', 'Sangat Baik'],
      ['', 'Rata-rata Aspek 2', '4,31', '86,27%', 'Sangat Baik']
    ]
  );
  highlightRow_(t2, 7, '#dbeafe');

  pBold_(body, 'Analisis:');
  p_(body, 'Aspek Desain Antarmuka memperoleh rata-rata skor 4,31 (86,27%) yang merupakan skor terendah di antara kelima aspek, meskipun tetap berada pada kategori "Sangat Baik". Indikator tertinggi pada aspek ini adalah "Halaman laporan menyediakan format ekspor sesuai kebutuhan" (4,44 / 88,80%), menunjukkan bahwa fitur export Excel dan PDF dinilai sangat berguna. Sementara indikator terendah adalah "Dashboard guru menampilkan informasi kehadiran dan penilaian yang relevan" (4,24 / 84,80%), yang mengindikasikan ruang perbaikan pada tata letak dan penyajian informasi di dashboard guru.');
  p_(body, 'Beberapa masukan dari responden terkait aspek ini meliputi: font yang perlu diperbesar, warna yang kurang kontras, serta dashboard admin yang terlalu padat informasi. Hal ini menjadi catatan penting untuk tahap implementasi.');

  // ====== ASPEK 3 ======
  h2_(body, '3.3 Aspek 3: Struktur Basis Data', C.PRIMARY);
  p_(body, 'Aspek ini menilai kelengkapan dan kesesuaian rancangan Entity Relationship Diagram (ERD) yang meliputi entitas, relasi, dan atribut.');

  var t3 = table_(body,
    ['No', 'Indikator', 'Skor Rata-rata', 'Persentase', 'Kategori'],
    [
      ['10', '(a) Tabel mencakup seluruh entitas yang diperlukan', '4,72', '94,40%', 'Sangat Baik'],
      ['11', '(b) Relasi antar tabel sesuai hubungan data nyata', '4,76', '95,20%', 'Sangat Baik'],
      ['12', '(c) Atribut pada setiap tabel lengkap dan sesuai', '4,80', '96,00%', 'Sangat Baik'],
      ['', 'Rata-rata Aspek 3', '4,76', '95,20%', 'Sangat Baik']
    ]
  );
  highlightRow_(t3, 4, '#dcfce7');

  pBold_(body, 'Analisis:');
  p_(body, 'Aspek Struktur Basis Data memperoleh rata-rata skor tertinggi di antara seluruh aspek, yaitu 4,76 (95,20%) dengan kategori "Sangat Baik". Indikator "Atribut pada setiap tabel lengkap dan sesuai kebutuhan" meraih skor tertinggi secara keseluruhan sebesar 4,80 (96,00%). Hal ini menunjukkan bahwa rancangan ERD yang mencakup 14 tabel (users, roles, teachers, students, classes, subjects, academic_years, attendances, grades, criteria, teacher_subject, student_assessments, teacher_assessments, settings) telah dinilai sangat memadai oleh responden.');
  p_(body, 'Tingginya skor pada aspek ini mengindikasikan bahwa responden, terutama Staf TU yang memahami kebutuhan data sekolah, merasa bahwa seluruh entitas dan hubungan data telah terepresentasi dengan baik dalam rancangan database.');

  // ====== ASPEK 4 ======
  h2_(body, '3.4 Aspek 4: Algoritma SAW', C.PRIMARY);
  p_(body, 'Aspek ini menilai kesesuaian kriteria penilaian, bobot, dan keterjelasan alur perhitungan metode Simple Additive Weighting (SAW) yang digunakan untuk perangkingan siswa dan penilaian guru.');

  var t4 = table_(body,
    ['No', 'Indikator', 'Skor Rata-rata', 'Persentase', 'Kategori'],
    [
      ['13', '(a) Kriteria penilaian siswa (C1–C4) relevan', '4,48', '89,60%', 'Sangat Baik'],
      ['14', '(b) Kriteria penilaian guru (K1–K4) relevan', '4,56', '91,20%', 'Sangat Baik'],
      ['15', '(c) Bobot kriteria proporsional dan sesuai prioritas', '4,56', '91,20%', 'Sangat Baik'],
      ['16', '(d) Alur perhitungan SAW pada flowchart dipahami', '4,48', '89,60%', 'Sangat Baik'],
      ['', 'Rata-rata Aspek 4', '4,52', '90,40%', 'Sangat Baik']
    ]
  );
  highlightRow_(t4, 5, '#dbeafe');

  pBold_(body, 'Analisis:');
  p_(body, 'Aspek Algoritma SAW memperoleh rata-rata skor 4,52 (90,40%) dengan kategori "Sangat Baik". Kriteria penilaian guru (K1–K4: Kehadiran, Kualitas Mengajar, Prestasi Siswa, Kedisiplinan) dan bobot kriteria sama-sama memperoleh skor tertinggi pada aspek ini sebesar 4,56 (91,20%). Hal ini menunjukkan bahwa kriteria dan bobot yang ditetapkan telah sesuai dengan prioritas penilaian di SMPN 4 Purwakarta.');
  p_(body, 'Namun, alur perhitungan SAW pada flowchart memperoleh skor sedikit lebih rendah (4,48 / 89,60%), yang mengindikasikan bahwa beberapa responden (terutama yang berlatar belakang non-teknis) memerlukan penjelasan tambahan untuk memahami langkah-langkah perhitungan. Beberapa responden menyarankan adanya penjelasan narasi di samping flowchart.');

  // ====== ASPEK 5 ======
  h2_(body, '3.5 Aspek 5: Kelayakan Keseluruhan', C.PRIMARY);
  p_(body, 'Aspek ini menilai penilaian menyeluruh responden terhadap kelayakan rancangan prototype untuk dikembangkan menjadi aplikasi serta potensinya dalam menyelesaikan permasalahan.');

  var t5 = table_(body,
    ['No', 'Indikator', 'Skor Rata-rata', 'Persentase', 'Kategori'],
    [
      ['17', '(a) Rancangan layak untuk dikembangkan', '4,56', '91,20%', 'Sangat Baik'],
      ['18', '(b) Sistem berpotensi menyelesaikan permasalahan', '4,64', '92,80%', 'Sangat Baik'],
      ['', 'Rata-rata Aspek 5', '4,60', '92,00%', 'Sangat Baik']
    ]
  );
  highlightRow_(t5, 3, '#dbeafe');

  pBold_(body, 'Analisis:');
  p_(body, 'Aspek Kelayakan Keseluruhan memperoleh rata-rata skor 4,60 (92,00%) dengan kategori "Sangat Baik". Indikator "Sistem berpotensi menyelesaikan permasalahan absensi dan penilaian di sekolah" memperoleh skor tertinggi pada aspek ini sebesar 4,64 (92,80%). Tingginya skor pada aspek ini menunjukkan kepercayaan responden bahwa rancangan yang dibuat mampu menjadi solusi nyata untuk permasalahan pencatatan kehadiran guru dan penilaian siswa yang selama ini dilakukan secara manual.');
  p_(body, 'Skor kelayakan pengembangan juga tinggi (4,56 / 91,20%), yang mengindikasikan bahwa responden mendukung untuk melanjutkan rancangan ini ke tahap implementasi/pengkodean.');
}


// ============================================================
// 4. REKAPITULASI
// ============================================================
function writeRekapitulasi_(body, C) {
  h1_(body, '4. Rekapitulasi Hasil Evaluasi', C.DARK);

  h2_(body, '4.1 Tabel Rekapitulasi Lengkap', C.PRIMARY);
  p_(body, 'Berikut adalah rekapitulasi seluruh hasil evaluasi prototype berdasarkan 18 indikator dalam 5 aspek penilaian:');

  var tAll = table_(body,
    ['No', 'Aspek', 'Indikator', 'Skor Rata-rata', 'Persentase'],
    [
      ['1', 'Kesesuaian Fungsional', '(a) Use Case mencakup seluruh kebutuhan pengguna', '4,56', '91,20%'],
      ['2', '', '(b) Activity Diagram sesuai prosedur operasional', '4,44', '88,80%'],
      ['3', '', '(c) Fitur relevan dengan permasalahan yang ada', '4,52', '90,40%'],
      ['', '', 'Rata-rata Aspek 1', '4,51', '90,13%'],
      ['4', 'Desain Antarmuka', '(a) Desain login mudah dipahami dan intuitif', '4,28', '85,60%'],
      ['5', '', '(b) Dashboard admin menampilkan info yang dibutuhkan', '4,28', '85,60%'],
      ['6', '', '(c) Dashboard guru menampilkan info yang relevan', '4,24', '84,80%'],
      ['7', '', '(d) Halaman scan QR Code memiliki alur jelas', '4,36', '87,20%'],
      ['8', '', '(e) Halaman input nilai memudahkan penilaian', '4,28', '85,60%'],
      ['9', '', '(f) Halaman laporan menyediakan format ekspor sesuai', '4,44', '88,80%'],
      ['', '', 'Rata-rata Aspek 2', '4,31', '86,27%'],
      ['10', 'Struktur Basis Data', '(a) Tabel mencakup seluruh entitas yang diperlukan', '4,72', '94,40%'],
      ['11', '', '(b) Relasi antar tabel sesuai hubungan data nyata', '4,76', '95,20%'],
      ['12', '', '(c) Atribut pada setiap tabel lengkap dan sesuai', '4,80', '96,00%'],
      ['', '', 'Rata-rata Aspek 3', '4,76', '95,20%'],
      ['13', 'Algoritma SAW', '(a) Kriteria penilaian siswa (C1–C4) relevan', '4,48', '89,60%'],
      ['14', '', '(b) Kriteria penilaian guru (K1–K4) relevan', '4,56', '91,20%'],
      ['15', '', '(c) Bobot kriteria proporsional dan sesuai prioritas', '4,56', '91,20%'],
      ['16', '', '(d) Alur perhitungan SAW pada flowchart dipahami', '4,48', '89,60%'],
      ['', '', 'Rata-rata Aspek 4', '4,52', '90,40%'],
      ['17', 'Kelayakan Keseluruhan', '(a) Rancangan layak untuk dikembangkan', '4,56', '91,20%'],
      ['18', '', '(b) Sistem berpotensi menyelesaikan permasalahan', '4,64', '92,80%'],
      ['', '', 'Rata-rata Aspek 5', '4,60', '92,00%'],
      ['', '', 'Rata-rata Keseluruhan', '4,50', '90,00%']
    ]
  );
  // Highlight sub-total rows
  highlightRow_(tAll, 4, '#dbeafe');
  highlightRow_(tAll, 11, '#dbeafe');
  highlightRow_(tAll, 15, '#dcfce7');
  highlightRow_(tAll, 20, '#dbeafe');
  highlightRow_(tAll, 23, '#dbeafe');
  highlightRow_(tAll, 24, '#fef3c7');

  h2_(body, '4.2 Ringkasan per Aspek', C.PRIMARY);
  table_(body,
    ['No', 'Aspek', 'Skor', 'Persentase', 'Kategori', 'Ranking'],
    [
      ['1', 'Struktur Basis Data', '4,76', '95,20%', 'Sangat Baik', '1 (Tertinggi)'],
      ['2', 'Kelayakan Keseluruhan', '4,60', '92,00%', 'Sangat Baik', '2'],
      ['3', 'Algoritma SAW', '4,52', '90,40%', 'Sangat Baik', '3'],
      ['4', 'Kesesuaian Fungsional', '4,51', '90,13%', 'Sangat Baik', '4'],
      ['5', 'Desain Antarmuka', '4,31', '86,27%', 'Sangat Baik', '5 (Terendah)']
    ]
  );

  h2_(body, '4.3 Interpretasi Keseluruhan', C.PRIMARY);
  p_(body, 'Rata-rata skor keseluruhan sebesar 4,50 dari skala 5,00 menghasilkan persentase kelayakan sebesar 90,00% yang menempatkan rancangan prototype pada kategori "Sangat Baik". Seluruh 5 aspek penilaian berada pada kategori "Sangat Baik" (skor > 4,21), yang menunjukkan bahwa rancangan prototype telah memenuhi harapan pengguna secara menyeluruh.');

  pBold_(body, 'Temuan Utama:');
  bullet_(body, 'Aspek yang memperoleh persentase tertinggi adalah Struktur Basis Data (95,20%), yang menunjukkan bahwa rancangan Entity Relationship Diagram (ERD) telah mencakup seluruh entitas dan relasi yang diperlukan.');
  bullet_(body, 'Indikator dengan skor tertinggi adalah "Atribut pada setiap tabel lengkap dan sesuai" (4,80 / 96,00%).');
  bullet_(body, 'Aspek Desain Antarmuka memperoleh persentase terendah (86,27%), meskipun tetap berada pada kategori "Sangat Baik", yang mengindikasikan masih terdapat ruang perbaikan pada aspek tampilan visual.');
  bullet_(body, 'Indikator dengan skor terendah adalah "Dashboard guru menampilkan informasi yang relevan" (4,24 / 84,80%).');

  h2_(body, '4.4 Perhitungan Rata-rata Keseluruhan', C.PRIMARY);
  p_(body, 'Rata-rata keseluruhan dihitung dari rata-rata seluruh 18 indikator:');
  p_(body, 'Total skor = (4,56 + 4,44 + 4,52 + 4,28 + 4,28 + 4,24 + 4,36 + 4,28 + 4,44 + 4,72 + 4,76 + 4,80 + 4,48 + 4,56 + 4,56 + 4,48 + 4,56 + 4,64) = 81,00');
  p_(body, 'Rata-rata = 81,00 ÷ 18 = 4,50');
  p_(body, 'Persentase = (4,50 ÷ 5,00) × 100% = 90,00%');
  p_(body, 'Kategori: Sangat Baik (berada pada rentang 4,21 – 5,00)');
}


// ============================================================
// 5. ANALISIS KUALITATIF
// ============================================================
function writeAnalisisKualitatif_(body, C) {
  h1_(body, '5. Analisis Masukan Kualitatif', C.DARK);

  p_(body, 'Selain penilaian kuantitatif, responden juga memberikan masukan kualitatif melalui 3 pertanyaan terbuka. Berikut adalah ringkasan dan pengelompokan masukan tersebut.');

  h2_(body, '5.1 Kelebihan Utama Menurut Responden', C.PRIMARY);
  p_(body, 'Masukan mengenai kelebihan dari rancangan prototype dapat dikelompokkan menjadi beberapa tema:');

  table_(body,
    ['No', 'Tema', 'Frekuensi', 'Contoh Masukan'],
    [
      ['1', 'Kelengkapan rancangan UML/Use Case', '6', '"Use Case sudah mencakup semua aktivitas guru", "Rancangan sudah sangat komprehensif"'],
      ['2', 'Kualitas ERD dan struktur database', '5', '"Struktur database terlihat solid", "Rancangan database sudah sangat baik dan terstruktur"'],
      ['3', 'Inovasi fitur QR Code untuk absensi', '4', '"Fitur presensi QR Code sangat inovatif", "Kiosk mode sangat cocok untuk ruang guru"'],
      ['4', 'Kesesuaian SAW dengan kebutuhan', '4', '"Bobot SAW sudah proporsional", "Kriteria penilaian siswa sudah sesuai"'],
      ['5', 'Fitur laporan dan export', '3', '"Fitur export Excel dan PDF sangat fleksibel", "Format export sudah tepat"'],
      ['6', 'Desain antarmuka', '2', '"Desain antarmuka modern dan profesional", "Desain login sederhana"'],
      ['7', 'Kelayakan keseluruhan', '2', '"Rancangan sudah sangat matang dan layak dikembangkan"']
    ]
  );

  h2_(body, '5.2 Kekurangan dan Hal yang Perlu Diperbaiki', C.PRIMARY);
  p_(body, 'Masukan mengenai kekurangan dikelompokkan berdasarkan tema yang relevan:');

  table_(body,
    ['No', 'Tema', 'Frekuensi', 'Contoh Masukan', 'Aspek Terkait'],
    [
      ['1', 'Ukuran font dan keterbacaan', '3', '"Font terlalu kecil", "Font pada tabel SAW terlalu kecil"', 'Desain Antarmuka'],
      ['2', 'Dashboard terlalu padat', '2', '"Dashboard admin terlalu banyak informasi", "Tampilan dashboard guru bisa lebih sederhana"', 'Desain Antarmuka'],
      ['3', 'Kurang filter pada laporan', '2', '"Perlu filter kelas", "Perlu opsi filter berdasarkan kelas dan tahun ajaran"', 'Desain Antarmuka'],
      ['4', 'Warna dan kontras', '1', '"Warna pada mockup kurang kontras"', 'Desain Antarmuka'],
      ['5', 'Flowchart SAW sulit dipahami non-teknis', '1', '"Flowchart SAW agak sulit dipahami bagi non-teknis"', 'Algoritma SAW'],
      ['6', 'Perlu penjelasan ERD', '1', '"Beberapa atribut perlu penjelasan lebih lanjut"', 'Struktur Basis Data'],
      ['7', 'Tidak ada kekurangan signifikan', '2', '"Tidak ada kekurangan yang signifikan", "Tidak ada kekurangan mayor"', '-']
    ]
  );

  p_(body, 'Mayoritas kekurangan yang diidentifikasi berkaitan dengan Aspek Desain Antarmuka, yang juga tercermin pada skor kuantitatif terendah (4,31 / 86,27%). Hal ini konsisten dan menunjukkan bahwa perbaikan pada aspek visual menjadi prioritas utama saat implementasi.');

  h2_(body, '5.3 Saran Pengembangan', C.PRIMARY);
  p_(body, 'Saran dari responden yang dapat diimplementasikan dikelompokkan berdasarkan prioritas:');

  pBold_(body, 'Prioritas Tinggi (langsung diimplementasikan):');
  bullet_(body, 'Perbesar font dan spacing pada desain antarmuka');
  bullet_(body, 'Tambahkan filter kelas, semester, dan tahun ajaran pada halaman laporan/export');
  bullet_(body, 'Tingkatkan kontras warna pada status kehadiran');
  bullet_(body, 'Sederhanakan dan kelompokkan informasi dashboard');

  pBold_(body, 'Prioritas Sedang (dipertimbangkan):');
  bullet_(body, 'Tambahkan ringkasan kehadiran bulanan di dashboard guru');
  bullet_(body, 'Tampilkan detail langkah perhitungan SAW pada halaman ranking');
  bullet_(body, 'Tambahkan panel "guru belum absen" pada dashboard admin');
  bullet_(body, 'Sediakan panduan penggunaan/modul pelatihan');

  pBold_(body, 'Prioritas Rendah (pengembangan lanjutan):');
  bullet_(body, 'Tambahkan sequence diagram untuk dokumentasi teknis');
  bullet_(body, 'Tambahkan notifikasi sukses setelah scan QR berhasil');
  bullet_(body, 'Konfigurasi durasi QR Code oleh admin');
  bullet_(body, 'Interaksi hover dan zoom pada grafik dashboard');
}


// ============================================================
// 6. KESIMPULAN
// ============================================================
function writeKesimpulan_(body, C) {
  h1_(body, '6. Kesimpulan Evaluasi Prototype', C.DARK);

  h2_(body, '6.1 Kesimpulan', C.PRIMARY);
  p_(body, 'Berdasarkan hasil evaluasi prototype yang melibatkan 25 responden (1 Kepala Sekolah, 23 Guru, dan 1 Staf TU) dari SMPN 4 Purwakarta, dapat disimpulkan bahwa:');

  bullet_(body, 'Rancangan prototype memperoleh rata-rata skor keseluruhan sebesar 4,50 dari skala 5,00 (persentase 90,00%), yang menempatkannya pada kategori "Sangat Baik".');
  bullet_(body, 'Seluruh 5 aspek penilaian (Kesesuaian Fungsional, Desain Antarmuka, Struktur Basis Data, Algoritma SAW, dan Kelayakan Keseluruhan) berada pada kategori "Sangat Baik" dengan skor > 4,21.');
  bullet_(body, 'Aspek Struktur Basis Data memperoleh skor tertinggi (4,76 / 95,20%), menunjukkan bahwa ERD yang dirancang telah sangat memadai.');
  bullet_(body, 'Aspek Desain Antarmuka memperoleh skor terendah (4,31 / 86,27%), mengindikasikan ruang perbaikan pada aspek visual yang telah dicatat untuk tahap implementasi.');
  bullet_(body, 'Tingginya skor Kelayakan Keseluruhan (4,60 / 92,00%) menunjukkan bahwa responden mendukung pengembangan rancangan ini menjadi aplikasi.');

  h2_(body, '6.2 Rekomendasi', C.PRIMARY);
  p_(body, 'Berdasarkan hasil evaluasi, direkomendasikan untuk:');

  bullet_(body, 'Melanjutkan rancangan prototype ke tahap pengkodean (coding) karena telah memperoleh kategori "Sangat Baik" dari stakeholder.');
  bullet_(body, 'Memprioritaskan perbaikan desain antarmuka saat implementasi, khususnya ukuran font, kontras warna, dan tata letak dashboard.');
  bullet_(body, 'Menambahkan filter yang lebih lengkap pada fitur laporan sesuai masukan responden.');
  bullet_(body, 'Menyediakan panduan/modul pelatihan penggunaan sistem untuk memastikan adopsi yang lancar.');
  bullet_(body, 'Menampilkan detail langkah perhitungan SAW agar hasil perangkingan lebih transparan dan mudah dipahami.');

  h2_(body, '6.3 Rangkuman Skor', C.PRIMARY);
  table_(body,
    ['Aspek', 'Skor', 'Persentase', 'Kategori'],
    [
      ['Kesesuaian Fungsional', '4,51', '90,13%', 'Sangat Baik'],
      ['Desain Antarmuka', '4,31', '86,27%', 'Sangat Baik'],
      ['Struktur Basis Data', '4,76', '95,20%', 'Sangat Baik'],
      ['Algoritma SAW', '4,52', '90,40%', 'Sangat Baik'],
      ['Kelayakan Keseluruhan', '4,60', '92,00%', 'Sangat Baik'],
      ['TOTAL KESELURUHAN', '4,50', '90,00%', 'Sangat Baik']
    ]
  );

  body.appendParagraph('').setSpacingAfter(30);
  var end = body.appendParagraph('— Akhir Dokumen Evaluasi Prototype —');
  end.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  end.setForegroundColor('#94a3b8');
  end.editAsText().setFontSize(11);
  end.editAsText().setItalic(true);
}
