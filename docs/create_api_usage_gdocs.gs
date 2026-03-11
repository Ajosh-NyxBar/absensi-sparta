// ============================================================
// DOKUMENTASI LENGKAP CARA PENGGUNAAN API
// Sistem Informasi Absensi Guru & Penilaian Siswa SMPN 4 Purwakarta
// ============================================================
// CARA PAKAI:
// 1. Buka https://script.google.com
// 2. Klik "New Project"
// 3. Hapus semua kode yang ada, paste SEMUA kode ini
// 4. Klik tombol ▶ Run (pilih createAPIUsageDocs)
// 5. Pertama kali minta izin — klik "Review permissions" > pilih akun > "Allow"
// 6. Buka Google Docs yang dibuat (link di Logger / Execution Log)
// ============================================================

function createAPIUsageDocs() {
  var doc = DocumentApp.create('Dokumentasi Penggunaan API — Sistem Presensi & Penilaian SMPN 4 Purwakarta');
  var body = doc.getBody();

  var C = {
    PRIMARY:    '#1a56db',
    DARK:       '#1e293b',
    HEAD_BG:    '#1e40af',
    ALT_BG:     '#eff6ff',
    CODE_BG:    '#f1f5f9',
    GREEN:      '#16a34a',
    RED:        '#dc2626',
    ORANGE:     '#ea580c',
    PURPLE:     '#7c3aed',
    BLUE:       '#2563eb',
    ACCENT:     '#059669'
  };

  body.clear();

  // ====== COVER ======
  writeCover_(body, C);
  body.appendPageBreak();

  // ====== DAFTAR ISI ======
  writeTOC_(body, C);
  body.appendPageBreak();

  // ====== BAB 1 — PERSIAPAN & KONSEP DASAR ======
  writePrerequisites_(body, C);
  body.appendPageBreak();

  // ====== BAB 2 — AUTENTIKASI ======
  writeAuthAPI_(body, C);
  body.appendPageBreak();

  // ====== BAB 3 — PRESENSI GURU (Attendance) ======
  writeAttendanceAPI_(body, C);
  body.appendPageBreak();

  // ====== BAB 4 — MODE KIOSK ======
  writeKioskAPI_(body, C);
  body.appendPageBreak();

  // ====== BAB 5 — MANAJEMEN NILAI (Grades) ======
  writeGradesAPI_(body, C);
  body.appendPageBreak();

  // ====== BAB 6 — PENILAIAN SAW ======
  writeSAWAPI_(body, C);
  body.appendPageBreak();

  // ====== BAB 7 — LAPORAN & EXPORT ======
  writeReportsAPI_(body, C);
  body.appendPageBreak();

  // ====== BAB 8 — MANAJEMEN USER ======
  writeUsersAPI_(body, C);
  body.appendPageBreak();

  // ====== BAB 9 — MANAJEMEN GURU ======
  writeTeachersAPI_(body, C);
  body.appendPageBreak();

  // ====== BAB 10 — MANAJEMEN SISWA ======
  writeStudentsAPI_(body, C);
  body.appendPageBreak();

  // ====== BAB 11 — KELAS, MAPEL, TAHUN AJARAN ======
  writeMasterDataAPI_(body, C);
  body.appendPageBreak();

  // ====== BAB 12 — KRITERIA SAW ======
  writeCriteriaAPI_(body, C);
  body.appendPageBreak();

  // ====== BAB 13 — PENGATURAN SISTEM ======
  writeSettingsAPI_(body, C);
  body.appendPageBreak();

  // ====== BAB 14 — PROFIL & NOTIFIKASI ======
  writeProfileNotifAPI_(body, C);
  body.appendPageBreak();

  // ====== BAB 15 — REFERENSI KODE ERROR ======
  writeErrorReference_(body, C);

  doc.saveAndClose();
  Logger.log('Dokumentasi API berhasil dibuat!');
  Logger.log('Buka: ' + doc.getUrl());
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
  p.setBold(true); p.setSpacingAfter(4);
  return p;
}
function bullet_(body, text) {
  var i = body.appendListItem(text);
  i.setGlyphType(DocumentApp.GlyphType.BULLET);
  i.setLineSpacing(1.4);
  return i;
}
function numbered_(body, text, nest) {
  var i = body.appendListItem(text);
  i.setGlyphType(DocumentApp.GlyphType.NUMBER);
  i.setLineSpacing(1.4);
  if (nest) i.setNestingLevel(nest);
  return i;
}
function code_(body, text) {
  var p = body.appendParagraph(text);
  p.editAsText().setFontFamily('Courier New');
  p.editAsText().setFontSize(9);
  p.editAsText().setForegroundColor('#1e293b');
  p.setBackgroundColor('#f1f5f9');
  p.setSpacingBefore(2); p.setSpacingAfter(2);
  p.setIndentStart(36);
  return p;
}
function table_(body, headers, rows, hBg, aBg) {
  hBg = hBg || '#1e40af'; aBg = aBg || '#eff6ff';
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
/** Label berwarna inline */
function badge_(body, label, color) {
  var p = body.appendParagraph(label);
  p.editAsText().setFontFamily('Courier New');
  p.editAsText().setFontSize(9);
  p.editAsText().setForegroundColor('#ffffff');
  p.setBackgroundColor(color);
  p.setSpacingBefore(4); p.setSpacingAfter(4);
  p.setIndentStart(36);
  return p;
}
/** Blok kode multi-baris */
function codeBlock_(body, lines) {
  for (var i = 0; i < lines.length; i++) {
    code_(body, lines[i]);
  }
}


// ============================================================
// COVER
// ============================================================
function writeCover_(body, C) {
  body.appendParagraph('').setSpacingAfter(80);
  var title = body.appendParagraph('DOKUMENTASI LENGKAP');
  title.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  title.editAsText().setFontSize(28).setBold(true).setForegroundColor(C.HEAD_BG);
  title.setSpacingAfter(4);

  var sub = body.appendParagraph('CARA PENGGUNAAN API');
  sub.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  sub.editAsText().setFontSize(22).setBold(true).setForegroundColor(C.PRIMARY);
  sub.setSpacingAfter(20);

  var line = body.appendParagraph('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
  line.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  line.editAsText().setForegroundColor(C.HEAD_BG);
  line.setSpacingAfter(20);

  var app = body.appendParagraph('Sistem Informasi Absensi Guru & Penilaian Siswa');
  app.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  app.editAsText().setFontSize(16).setForegroundColor(C.DARK);
  app.setSpacingAfter(4);

  var sch = body.appendParagraph('SMP Negeri 4 Purwakarta');
  sch.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  sch.editAsText().setFontSize(14).setForegroundColor(C.DARK);
  sch.setSpacingAfter(40);

  var info = body.appendParagraph('Framework: Laravel 12  •  PHP ≥ 8.2  •  MySQL 8.0');
  info.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  info.editAsText().setFontSize(11).setForegroundColor(C.BLUE);
  info.setSpacingAfter(4);

  var info2 = body.appendParagraph('Autentikasi: Session-based (Cookie + CSRF Token)');
  info2.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  info2.editAsText().setFontSize(11).setForegroundColor(C.BLUE);
  info2.setSpacingAfter(4);

  var info3 = body.appendParagraph('Total Endpoint: 150+  •  Controller: 19  •  Role: 4');
  info3.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  info3.editAsText().setFontSize(11).setForegroundColor(C.BLUE);
  info3.setSpacingAfter(60);

  var date = body.appendParagraph('Dibuat: ' + Utilities.formatDate(new Date(), 'Asia/Jakarta', 'dd MMMM yyyy'));
  date.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  date.editAsText().setFontSize(10).setForegroundColor('#64748b');
}


// ============================================================
// DAFTAR ISI
// ============================================================
function writeTOC_(body, C) {
  h1_(body, 'DAFTAR ISI', C.DARK);
  var items = [
    'BAB 1  — Persiapan & Konsep Dasar',
    'BAB 2  — Autentikasi (Login / Logout / Dashboard)',
    'BAB 3  — Presensi Guru (QR Code & Geolokasi)',
    'BAB 4  — Mode Kiosk (Tampilan Publik)',
    'BAB 5  — Manajemen Nilai (Grades)',
    'BAB 6  — Penilaian SAW (Siswa & Guru)',
    'BAB 7  — Laporan & Export (Excel / PDF)',
    'BAB 8  — Manajemen User',
    'BAB 9  — Manajemen Guru',
    'BAB 10 — Manajemen Siswa',
    'BAB 11 — Master Data (Kelas, Mapel, Tahun Ajaran, Penugasan)',
    'BAB 12 — Kriteria SAW',
    'BAB 13 — Pengaturan Sistem',
    'BAB 14 — Profil & Notifikasi',
    'BAB 15 — Referensi Kode Error & Troubleshooting'
  ];
  for (var i = 0; i < items.length; i++) {
    numbered_(body, items[i]);
  }
}


// ============================================================
// BAB 1 — PERSIAPAN & KONSEP DASAR
// ============================================================
function writePrerequisites_(body, C) {
  h1_(body, 'BAB 1 — PERSIAPAN & KONSEP DASAR', C.DARK);

  // --- 1.1 ---
  h2_(body, '1.1 Base URL', C.PRIMARY);
  p_(body, 'Semua endpoint menggunakan base URL berikut. Ganti sesuai lingkungan deploy Anda.');
  code_(body, 'BASE_URL = http://127.0.0.1:8000');
  code_(body, 'Contoh production: https://presensi.smpn4purwakarta.sch.id');

  // --- 1.2 ---
  h2_(body, '1.2 Autentikasi: Session-Based (Bukan Token/JWT)', C.PRIMARY);
  p_(body, 'Sistem ini TIDAK menggunakan Bearer Token / JWT / API Key. Seluruh autentikasi menggunakan mekanisme session Laravel:');
  bullet_(body, 'Saat login berhasil, server mengirim cookie session (laravel_session & XSRF-TOKEN).');
  bullet_(body, 'Cookie ini WAJIB dikirim kembali di setiap request berikutnya.');
  bullet_(body, 'Setiap request POST/PUT/DELETE WAJIB menyertakan CSRF token.');
  p_(body, 'Implikasi: Anda TIDAK bisa langsung memanggil API dari domain lain (kecuali kiosk public endpoint). Semua request harus melalui browser session atau tool seperti Postman/cURL yang menyimpan cookie.');

  // --- 1.3 ---
  h2_(body, '1.3 Cara Mendapatkan CSRF Token', C.PRIMARY);
  p_(body, 'Ada 3 cara mendapatkan CSRF token:');

  pBold_(body, 'Cara 1: Dari Cookie XSRF-TOKEN (Untuk Postman / REST Client)');
  numbered_(body, 'Akses GET /login (atau halaman mana pun) — server akan men-set cookie XSRF-TOKEN.');
  numbered_(body, 'Ambil nilai XSRF-TOKEN dari response cookie.');
  numbered_(body, 'Kirim di header: X-XSRF-TOKEN: <url-decoded value>');
  p_(body, 'Contoh cURL:');
  codeBlock_(body, [
    '# 1. Dapatkan cookie session + CSRF',
    'curl -c cookies.txt -b cookies.txt http://127.0.0.1:8000/login',
    '',
    '# 2. Lihat XSRF-TOKEN di cookies.txt, decode URL-encoding',
    '# 3. Gunakan di request berikutnya'
  ]);

  pBold_(body, 'Cara 2: Dari Meta Tag (Untuk JavaScript di Browser)');
  codeBlock_(body, [
    '<!-- Di setiap halaman Blade Laravel: -->',
    '<meta name="csrf-token" content="{{ csrf_token() }}">',
    '',
    '// JavaScript:',
    'const token = document.querySelector(\'meta[name="csrf-token"]\').content;',
    'fetch("/api/endpoint", {',
    '    method: "POST",',
    '    headers: {',
    '        "X-CSRF-TOKEN": token,',
    '        "Accept": "application/json",',
    '        "Content-Type": "application/json"',
    '    },',
    '    body: JSON.stringify({ ... })',
    '});'
  ]);

  pBold_(body, 'Cara 3: Dari Input Hidden (Untuk Form HTML)');
  codeBlock_(body, [
    '<form method="POST" action="/endpoint">',
    '    @csrf   <!-- Laravel akan render: -->',
    '    <input type="hidden" name="_token" value="abc123...">',
    '    ...',
    '</form>'
  ]);

  // --- 1.4 ---
  h2_(body, '1.4 Header Wajib untuk Setiap Request', C.PRIMARY);
  table_(body,
    ['Header', 'Nilai', 'Kapan Diperlukan'],
    [
      ['Cookie', 'laravel_session=xxx; XSRF-TOKEN=xxx', 'SELALU (otomatis dari browser)'],
      ['X-CSRF-TOKEN', '<csrf_token>', 'Semua POST / PUT / DELETE'],
      ['X-XSRF-TOKEN', '<xsrf_cookie_decoded>', 'Alternatif CSRF (dari cookie)'],
      ['Accept', 'application/json', 'Untuk endpoint yang return JSON'],
      ['Content-Type', 'application/json', 'Jika body berupa JSON'],
      ['Content-Type', 'multipart/form-data', 'Jika upload file (foto)'],
      ['X-Requested-With', 'XMLHttpRequest', 'Opsional (untuk AJAX detection)']
    ]
  );

  // --- 1.5 ---
  h2_(body, '1.5 Role & Hak Akses', C.PRIMARY);
  p_(body, 'Sistem memiliki 4 role dengan hak akses berbeda:');
  table_(body,
    ['Role', 'ID', 'Hak Akses Utama'],
    [
      ['Admin', '1', 'Akses penuh: CRUD semua data, pengaturan, laporan, SAW, user management'],
      ['Guru', '2', 'Presensi (scan QR), input nilai, lihat kelas sendiri, edit profil'],
      ['Kepala Sekolah', '3', 'Lihat dashboard, SAW penilaian, rapor siswa (read-only)'],
      ['Kiosk Presensi', '4', 'Hanya tampilan kiosk presensi (redirect otomatis ke /kiosk-dashboard)']
    ]
  );

  // --- 1.6 ---
  h2_(body, '1.6 Format Response', C.PRIMARY);
  p_(body, 'Sistem menggunakan dua jenis response:');

  pBold_(body, 'A. HTML Redirect (untuk request dari browser/form)');
  bullet_(body, 'Response: HTTP 302 Redirect + Flash Message di session');
  bullet_(body, 'Flash key: success (hijau), error (merah), warning (kuning)');
  bullet_(body, 'Data flash diakses via: session(\'success\'), session(\'error\')');

  pBold_(body, 'B. JSON Response (untuk AJAX/API call)');
  bullet_(body, 'Dipicu jika header Accept: application/json dikirim');
  bullet_(body, 'Format sukses: { "success": true, "data": {...}, "message": "..." }');
  bullet_(body, 'Format error: { "success": false, "message": "error description" }');
  bullet_(body, 'Validation error (422): { "message": "...", "errors": { "field": ["rule1", "rule2"] } }');

  // --- 1.7 ---
  h2_(body, '1.7 HTTP Method Override (PUT/DELETE)', C.PRIMARY);
  p_(body, 'HTML form hanya mendukung GET dan POST. Untuk PUT dan DELETE, Laravel menggunakan method spoofing:');
  codeBlock_(body, [
    '<form method="POST" action="/users/1">',
    '    @csrf',
    '    @method("PUT")    <!-- atau @method("DELETE") -->',
    '    <input type="hidden" name="_method" value="PUT">',
    '    ...',
    '</form>'
  ]);
  p_(body, 'Untuk JSON request via Postman/fetch, kirim _method di body ATAU gunakan HTTP method langsung (PUT/DELETE).');

  // --- 1.8 ---
  h2_(body, '1.8 Paginasi', C.PRIMARY);
  p_(body, 'Endpoint yang menampilkan daftar data menggunakan paginasi Laravel:');
  bullet_(body, 'Default: 10 atau 20 item per halaman');
  bullet_(body, 'Query parameter: ?page=2 untuk halaman kedua');
  bullet_(body, 'Response HTML menyertakan link paginasi otomatis');
}


// ============================================================
// BAB 2 — AUTENTIKASI
// ============================================================
function writeAuthAPI_(body, C) {
  h1_(body, 'BAB 2 — AUTENTIKASI', C.DARK);
  p_(body, 'Modul autentikasi menangani login, logout, dan redirect dashboard berdasarkan role pengguna.');

  // --- 2.1 Login Page ---
  h2_(body, '2.1 Menampilkan Halaman Login', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/login'],
      ['Middleware', 'guest (hanya bisa diakses jika BELUM login)'],
      ['Response', 'HTML — halaman login'],
      ['Header Wajib', '— (tidak ada, ini halaman publik)']
    ]
  );
  p_(body, 'Halaman ini menampilkan form login dengan field email dan password. Jika sudah login, otomatis redirect ke /dashboard.');

  // --- 2.2 Proses Login ---
  h2_(body, '2.2 Proses Login', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'POST'],
      ['URL', '/login'],
      ['Middleware', 'guest'],
      ['Content-Type', 'application/x-www-form-urlencoded ATAU application/json'],
      ['CSRF', 'WAJIB — _token di body ATAU X-CSRF-TOKEN di header']
    ]
  );
  pBold_(body, 'Body Parameters (WAJIB):');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Contoh'],
    [
      ['email', 'string', 'required | email', 'admin@smpn4.sch.id'],
      ['password', 'string', 'required', 'password123'],
      ['remember', 'boolean', 'optional', 'true / false / 1 / 0']
    ]
  );
  pBold_(body, 'Contoh Request (cURL):');
  codeBlock_(body, [
    'curl -X POST http://127.0.0.1:8000/login \\',
    '  -c cookies.txt -b cookies.txt \\',
    '  -H "Content-Type: application/x-www-form-urlencoded" \\',
    '  -d "email=admin@smpn4.sch.id" \\',
    '  -d "password=password123" \\',
    '  -d "_token=<CSRF_TOKEN>"'
  ]);
  pBold_(body, 'Contoh Request (JavaScript fetch):');
  codeBlock_(body, [
    'const response = await fetch("/login", {',
    '    method: "POST",',
    '    headers: {',
    '        "Content-Type": "application/json",',
    '        "X-CSRF-TOKEN": csrfToken,',
    '        "Accept": "application/json"',
    '    },',
    '    body: JSON.stringify({',
    '        email: "admin@smpn4.sch.id",',
    '        password: "password123",',
    '        remember: true',
    '    })',
    '});'
  ]);
  pBold_(body, 'Response Sukses:');
  bullet_(body, 'HTTP 302 Redirect ke /dashboard');
  bullet_(body, 'Cookie laravel_session dan XSRF-TOKEN di-set otomatis');
  bullet_(body, 'Jika remember=true, cookie bertahan lebih lama (5 tahun default Laravel)');
  pBold_(body, 'Response Gagal:');
  bullet_(body, 'HTTP 302 Redirect kembali ke /login');
  bullet_(body, 'Flash: error = "Email atau password salah"');
  bullet_(body, 'HTTP 422 (jika Accept: application/json): { "message": "...", "errors": { "email": ["..."] } }');

  // --- 2.3 Logout ---
  h2_(body, '2.3 Logout', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'POST'],
      ['URL', '/logout'],
      ['Middleware', 'auth (harus sudah login)'],
      ['CSRF', 'WAJIB'],
      ['Body', 'Tidak ada parameter (hanya _token)']
    ]
  );
  pBold_(body, 'Contoh Request:');
  codeBlock_(body, [
    'curl -X POST http://127.0.0.1:8000/logout \\',
    '  -b cookies.txt \\',
    '  -d "_token=<CSRF_TOKEN>"'
  ]);
  p_(body, 'Efek: Session dihapus, cookie di-invalidate, CSRF token di-regenerate. Redirect ke /login.');

  // --- 2.4 Dashboard ---
  h2_(body, '2.4 Dashboard (Redirect by Role)', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/dashboard'],
      ['Middleware', 'auth'],
      ['Response', 'HTML — dashboard sesuai role']
    ]
  );
  p_(body, 'Endpoint ini otomatis mengarahkan ke dashboard sesuai role:');
  table_(body,
    ['Role', 'Redirect Ke', 'Keterangan'],
    [
      ['Kiosk Presensi', '/kiosk-dashboard', 'Tampilan kiosk presensi khusus'],
      ['Admin', 'DashboardController@admin', 'Statistik lengkap: jumlah guru, siswa, kehadiran, chart'],
      ['Guru', 'DashboardController@teacher', 'Jadwal, presensi hari ini, kelas yang diajar'],
      ['Kepala Sekolah', 'DashboardController@headmaster', 'Ringkasan kehadiran, SAW ranking']
    ]
  );
}


// ============================================================
// BAB 3 — PRESENSI GURU
// ============================================================
function writeAttendanceAPI_(body, C) {
  h1_(body, 'BAB 3 — PRESENSI GURU (QR Code & Geolokasi)', C.DARK);
  p_(body, 'Modul presensi menggunakan QR Code terenkripsi AES-256-CBC dengan validasi geolokasi dan batas waktu.');

  // --- 3.1 ---
  h2_(body, '3.1 Daftar Presensi', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/attendance'],
      ['Middleware', 'auth'],
      ['Response', 'HTML — tabel daftar presensi']
    ]
  );
  pBold_(body, 'Query Parameters (Opsional):');
  table_(body,
    ['Key', 'Tipe', 'Contoh', 'Keterangan'],
    [
      ['type', 'string', 'teacher / student', 'Filter berdasarkan tipe presensi'],
      ['date', 'string', '2024-03-15', 'Format Y-m-d, filter tanggal']
    ]
  );
  p_(body, 'Catatan: Guru hanya bisa melihat presensi milik sendiri. Admin bisa melihat semua.');
  pBold_(body, 'Contoh URL:');
  code_(body, 'GET /attendance?type=teacher&date=2024-03-15');

  // --- 3.2 ---
  h2_(body, '3.2 Generate QR Code Guru', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/api/teacher/{teacher_id}/qr-code'],
      ['Middleware', 'auth'],
      ['Response', 'JSON'],
      ['Accept Header', 'application/json']
    ]
  );
  pBold_(body, 'Route Parameters:');
  table_(body,
    ['Parameter', 'Tipe', 'Keterangan'],
    [
      ['teacher_id', 'integer', 'ID guru dari tabel teachers (WAJIB)']
    ]
  );
  pBold_(body, 'Contoh Request:');
  code_(body, 'GET /api/teacher/5/qr-code');
  pBold_(body, 'Response Sukses (200):');
  codeBlock_(body, [
    '{',
    '  "success": true,',
    '  "qrCode": "<svg xmlns=...>...</svg>",',
    '  "type": "teacher_attendance"',
    '}'
  ]);
  p_(body, 'QR Code berisi data terenkripsi AES-256-CBC: { teacher_id, date (Y-m-d), timestamp }');
  p_(body, 'QR SVG berukuran 300x300 pixel. Masa berlaku: 600 detik (10 menit).');

  // --- 3.3 ---
  h2_(body, '3.3 Cek Status Presensi Guru', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/api/teacher/{teacher_id}/attendance-status'],
      ['Middleware', 'auth'],
      ['Response', 'JSON']
    ]
  );
  pBold_(body, 'Response:');
  codeBlock_(body, [
    '{',
    '  "success": true,',
    '  "attendance": {',
    '    "check_in_time": "07:15:00",',
    '    "check_out_time": "14:30:00",',
    '    "status": "present"',
    '  }',
    '}'
  ]);

  // --- 3.4 ---
  h2_(body, '3.4 Scan QR Code (Proses Presensi)', C.PRIMARY);
  p_(body, 'INI ADALAH ENDPOINT UTAMA PROSES PRESENSI. Dipanggil ketika guru memindai QR code.');
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'POST'],
      ['URL', '/attendance/scan-qr'],
      ['Middleware', 'auth'],
      ['CSRF', 'WAJIB'],
      ['Content-Type', 'application/json'],
      ['Accept', 'application/json']
    ]
  );
  pBold_(body, 'Body Parameters (SEMUA WAJIB):');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Contoh', 'Keterangan'],
    [
      ['qr_data', 'string', 'required | string', '"eyJpdiI6Ik1..."', 'String terenkripsi dari QR code'],
      ['latitude', 'numeric', 'required | numeric', '-6.5465236', 'Latitude GPS perangkat guru'],
      ['longitude', 'numeric', 'required | numeric', '107.4414175', 'Longitude GPS perangkat guru']
    ]
  );
  pBold_(body, 'Contoh Request (JavaScript):');
  codeBlock_(body, [
    'navigator.geolocation.getCurrentPosition(async (pos) => {',
    '    const response = await fetch("/attendance/scan-qr", {',
    '        method: "POST",',
    '        headers: {',
    '            "Content-Type": "application/json",',
    '            "X-CSRF-TOKEN": csrfToken,',
    '            "Accept": "application/json"',
    '        },',
    '        body: JSON.stringify({',
    '            qr_data: scannedQRString,',
    '            latitude: pos.coords.latitude,',
    '            longitude: pos.coords.longitude',
    '        })',
    '    });',
    '    const result = await response.json();',
    '});'
  ]);
  pBold_(body, 'Response Sukses — Check-in (200):');
  codeBlock_(body, [
    '{',
    '  "success": true,',
    '  "message": "Check-in berhasil!",',
    '  "action": "check-in",',
    '  "data": {',
    '    "teacher_name": "Budi Santoso",',
    '    "check_in": "07:25:00",',
    '    "status": "Tepat Waktu",',
    '    "status_class": "success"',
    '  }',
    '}'
  ]);
  pBold_(body, 'Response Sukses — Check-out (200):');
  codeBlock_(body, [
    '{',
    '  "success": true,',
    '  "message": "Check-out berhasil!",',
    '  "action": "check-out",',
    '  "data": {',
    '    "teacher_name": "Budi Santoso",',
    '    "check_in": "07:25:00",',
    '    "check_out": "14:30:00",',
    '    "duration": "7h 05m"',
    '  }',
    '}'
  ]);
  pBold_(body, 'Response Error (422):');
  codeBlock_(body, [
    '{ "success": false, "message": "QR Code tidak valid atau sudah kedaluwarsa" }',
    '{ "success": false, "message": "Anda berada di luar radius sekolah (maks 100 meter)" }',
    '{ "success": false, "message": "QR code ini bukan milik Anda" }',
    '{ "success": false, "message": "Tanggal QR tidak sesuai dengan hari ini" }'
  ]);

  pBold_(body, '⚠ VALIDASI PENTING:');
  bullet_(body, 'Geolokasi: Jarak dihitung menggunakan rumus Haversine. Maksimal radius 100 meter dari koordinat sekolah (-6.5465236, 107.4414175).');
  bullet_(body, 'Waktu QR: QR code berlaku maksimal 600 detik (10 menit) sejak dibuat.');
  bullet_(body, 'Batas Check-in: Jika check-in sebelum 07:30 → status "Tepat Waktu" (present). Setelah 07:30 → status "Terlambat" (late).');
  bullet_(body, 'Kepemilikan: QR code hanya bisa digunakan oleh guru yang sesuai dengan data QR.');
  bullet_(body, 'Check-out: Jika guru sudah check-in hari ini dan scan lagi → otomatis menjadi check-out.');

  // --- 3.5 ---
  h2_(body, '3.5 Presensi Siswa Per Kelas (Admin)', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/attendance/class/{class_id}'],
      ['Middleware', 'auth + Admin'],
      ['Response', 'HTML — form input presensi per siswa']
    ]
  );
  pBold_(body, 'Query Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Contoh'],
    [['date', 'string', '2024-03-15 (format Y-m-d, default hari ini)']]
  );

  // --- 3.6 ---
  h2_(body, '3.6 Simpan Presensi Kelas', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'POST'],
      ['URL', '/attendance/class/{class_id}'],
      ['Middleware', 'auth + Admin'],
      ['CSRF', 'WAJIB'],
      ['Content-Type', 'application/x-www-form-urlencoded']
    ]
  );
  pBold_(body, 'Body Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Keterangan'],
    [
      ['date', 'string', 'required', 'Tanggal presensi (Y-m-d)'],
      ['attendances', 'array', 'required', 'Array berisi data per siswa'],
      ['attendances[].student_id', 'integer', 'required', 'ID siswa'],
      ['attendances[].status', 'string', 'required', 'present / late / absent / excused']
    ]
  );
  pBold_(body, 'Contoh Body:');
  codeBlock_(body, [
    '{',
    '  "date": "2024-03-15",',
    '  "attendances": [',
    '    { "student_id": 1, "status": "present" },',
    '    { "student_id": 2, "status": "late" },',
    '    { "student_id": 3, "status": "absent" }',
    '  ]',
    '}'
  ]);
}


// ============================================================
// BAB 4 — MODE KIOSK
// ============================================================
function writeKioskAPI_(body, C) {
  h1_(body, 'BAB 4 — MODE KIOSK (Tampilan Publik)', C.DARK);
  p_(body, 'Mode Kiosk digunakan pada monitor yang dipasang di depan ruang guru. Beberapa endpoint TIDAK MEMERLUKAN login (publik).');

  // --- 4.1 ---
  h2_(body, '4.1 Halaman Utama Kiosk (Publik)', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/kiosk'],
      ['Middleware', 'TIDAK ADA (publik, tanpa login)'],
      ['Response', 'HTML — tampilan pilih guru untuk QR']
    ]
  );
  p_(body, 'Halaman ini menampilkan daftar semua guru aktif. Klik pada nama guru untuk menampilkan QR code.');

  // --- 4.2 ---
  h2_(body, '4.2 Generate QR Kiosk (Publik)', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/kiosk/api/qr/{teacher_id}'],
      ['Middleware', 'TIDAK ADA (publik)'],
      ['Response', 'JSON'],
      ['Accept', 'application/json']
    ]
  );
  pBold_(body, 'Route Parameter:');
  table_(body,
    ['Parameter', 'Tipe', 'Keterangan'],
    [['teacher_id', 'integer', 'ID guru (WAJIB, harus ada di tabel teachers)']]
  );
  pBold_(body, 'Response Sukses (200):');
  codeBlock_(body, [
    '{',
    '  "success": true,',
    '  "qrCode": "<svg xmlns=...>...</svg>",',
    '  "teacher": {',
    '    "id": 5,',
    '    "name": "Budi Santoso",',
    '    "nip": "197505121998021001"',
    '  },',
    '  "generated_at": "2024-03-15 07:00:00",',
    '  "expires_in": 60',
    '}'
  ]);
  p_(body, 'QR kiosk berukuran 350x350 pixel. Masa berlaku: 60 detik (1 menit) — lebih pendek dari QR admin.');

  // --- 4.3 ---
  h2_(body, '4.3 Status Presensi Kiosk (Publik)', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/kiosk/api/status/{teacher_id}'],
      ['Middleware', 'TIDAK ADA (publik)'],
      ['Response', 'JSON']
    ]
  );
  pBold_(body, 'Response:');
  codeBlock_(body, [
    '{',
    '  "success": true,',
    '  "attendance": {',
    '    "check_in": "07:15:00",',
    '    "check_out": null,',
    '    "status": "present"',
    '  }',
    '}'
  ]);

  // --- 4.4 ---
  h2_(body, '4.4 Ringkasan Presensi Hari Ini (Publik)', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/kiosk/api/summary'],
      ['Middleware', 'TIDAK ADA (publik)'],
      ['Response', 'JSON']
    ]
  );
  pBold_(body, 'Response:');
  codeBlock_(body, [
    '{',
    '  "success": true,',
    '  "date": "Senin, 15 Maret 2024",',
    '  "time": "08:30:00",',
    '  "summary": {',
    '    "total": 25,',
    '    "attended": 20,',
    '    "not_attended": 5,',
    '    "on_time": 18,',
    '    "late": 2,',
    '    "percentage": 80',
    '  }',
    '}'
  ]);

  // --- 4.5 ---
  h2_(body, '4.5 Scan QR dari Kiosk (Auth)', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'POST'],
      ['URL', '/kiosk/api/scan'],
      ['Middleware', 'auth (harus login sebagai Guru)'],
      ['CSRF', 'WAJIB'],
      ['Content-Type', 'application/json']
    ]
  );
  pBold_(body, 'Body Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Keterangan'],
    [
      ['qr_data', 'string', 'required | string', 'Data QR terenkripsi dari kiosk'],
      ['latitude', 'numeric', 'required | numeric', 'Latitude GPS guru'],
      ['longitude', 'numeric', 'required | numeric', 'Longitude GPS guru']
    ]
  );
  p_(body, 'Logika sama seperti /attendance/scan-qr, tapi QR kiosk hanya berlaku 60 detik.');
  p_(body, 'Error tambahan: 401 (belum login), 403 (bukan guru).');

  // --- 4.6 ---
  h2_(body, '4.6 Status Presensi Saya (Auth)', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/api/attendance/my-status'],
      ['Middleware', 'auth'],
      ['Response', 'JSON']
    ]
  );
  pBold_(body, 'Response:');
  codeBlock_(body, [
    '{',
    '  "success": true,',
    '  "teacher": { "id": 5, "name": "Budi Santoso" },',
    '  "attendance": {',
    '    "check_in": "07:25",',
    '    "check_out": null,',
    '    "status": "present"',
    '  }',
    '}'
  ]);
}


// ============================================================
// BAB 5 — MANAJEMEN NILAI
// ============================================================
function writeGradesAPI_(body, C) {
  h1_(body, 'BAB 5 — MANAJEMEN NILAI (Grades)', C.DARK);
  p_(body, 'Modul penilaian digunakan oleh Admin dan Guru untuk menginput nilai siswa per mata pelajaran.');

  // --- 5.1 ---
  h2_(body, '5.1 Daftar Nilai', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/grades'],
      ['Middleware', 'auth + Admin/Guru'],
      ['Response', 'HTML — tabel nilai paginasi (20/halaman)']
    ]
  );
  pBold_(body, 'Query Parameters (Opsional):');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Contoh'],
    [
      ['semester', 'string', 'string', 'Ganjil / Genap'],
      ['academic_year', 'string', 'string', '2024/2025'],
      ['subject_id', 'integer', 'exists:subjects,id', '3'],
      ['class_id', 'integer', 'exists:classes,id', '1']
    ]
  );
  p_(body, 'Guru hanya melihat nilai yang dia input. Admin melihat semua.');
  code_(body, 'GET /grades?semester=Ganjil&academic_year=2024/2025&class_id=1');

  // --- 5.2 ---
  h2_(body, '5.2 Input Nilai Per Kelas (Step 1: Pilih Kelas)', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'POST'],
      ['URL', '/grades/input-by-class'],
      ['Middleware', 'auth + Admin/Guru'],
      ['CSRF', 'WAJIB'],
      ['Response', 'HTML — form input nilai per siswa']
    ]
  );
  pBold_(body, 'Body Parameters (SEMUA WAJIB):');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Contoh'],
    [
      ['class_id', 'integer', 'required | exists:classes,id', '1'],
      ['subject_id', 'integer', 'required | exists:subjects,id', '3'],
      ['semester', 'string', 'required | string', 'Ganjil'],
      ['academic_year', 'string', 'required | string', '2024/2025']
    ]
  );

  // --- 5.3 ---
  h2_(body, '5.3 Simpan Nilai Batch (Step 2: Submit Nilai)', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'POST'],
      ['URL', '/grades/store-multiple'],
      ['Middleware', 'auth + Admin/Guru'],
      ['CSRF', 'WAJIB'],
      ['Content-Type', 'application/json ATAU application/x-www-form-urlencoded']
    ]
  );
  pBold_(body, 'Body Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Keterangan'],
    [
      ['class_id', 'integer', 'required | exists:classes,id', 'ID kelas'],
      ['subject_id', 'integer', 'required | exists:subjects,id', 'ID mata pelajaran'],
      ['semester', 'string', 'required', '"Ganjil" atau "Genap"'],
      ['academic_year', 'string', 'required', '"2024/2025"'],
      ['students', 'array', 'required | array', 'Array data nilai per siswa'],
      ['students[].student_id', 'integer', 'required | exists:students,id', 'ID siswa'],
      ['students[].daily_test', 'numeric', 'nullable | min:0 | max:100', 'Nilai ulangan harian'],
      ['students[].midterm_exam', 'numeric', 'nullable | min:0 | max:100', 'Nilai UTS'],
      ['students[].final_exam', 'numeric', 'nullable | min:0 | max:100', 'Nilai UAS'],
      ['students[].behavior_score', 'numeric', 'nullable | min:0 | max:100', 'Nilai sikap'],
      ['students[].skill_score', 'numeric', 'nullable | min:0 | max:100', 'Nilai keterampilan']
    ]
  );
  pBold_(body, 'Contoh Body (JSON):');
  codeBlock_(body, [
    '{',
    '  "class_id": 1,',
    '  "subject_id": 3,',
    '  "semester": "Ganjil",',
    '  "academic_year": "2024/2025",',
    '  "students": [',
    '    {',
    '      "student_id": 1,',
    '      "daily_test": 85,',
    '      "midterm_exam": 80,',
    '      "final_exam": 82,',
    '      "behavior_score": 90,',
    '      "skill_score": 88',
    '    },',
    '    {',
    '      "student_id": 2,',
    '      "daily_test": 70,',
    '      "midterm_exam": 75,',
    '      "final_exam": 68,',
    '      "behavior_score": 85,',
    '      "skill_score": 80',
    '    }',
    '  ]',
    '}'
  ]);
  pBold_(body, 'Rumus Nilai Akhir (Otomatis):');
  code_(body, 'final_grade = (daily_test x 0.3) + (midterm_exam x 0.3) + (final_exam x 0.4)');
  p_(body, 'Siswa dengan semua nilai kosong (null) akan di-skip. Jika sudah ada nilai sebelumnya, akan diupdate (upsert).');

  // --- 5.4 ---
  h2_(body, '5.4 Update Nilai Individual', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'PUT'],
      ['URL', '/grades/{grade_id}'],
      ['Middleware', 'auth + Admin/Guru'],
      ['CSRF', 'WAJIB']
    ]
  );
  pBold_(body, 'Body Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Validasi'],
    [
      ['daily_test', 'numeric', 'nullable | min:0 | max:100'],
      ['midterm_exam', 'numeric', 'nullable | min:0 | max:100'],
      ['final_exam', 'numeric', 'nullable | min:0 | max:100'],
      ['behavior_score', 'numeric', 'nullable | min:0 | max:100'],
      ['skill_score', 'numeric', 'nullable | min:0 | max:100'],
      ['notes', 'string', 'nullable']
    ]
  );

  // --- 5.5 ---
  h2_(body, '5.5 Hapus Nilai', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'DELETE'],
      ['URL', '/grades/{grade_id}'],
      ['Middleware', 'auth + Admin/Guru'],
      ['CSRF', 'WAJIB'],
      ['Response', 'Redirect ke /grades dengan pesan sukses']
    ]
  );

  // --- 5.6 ---
  h2_(body, '5.6 Rapor Siswa', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/students/{student_id}/report-card'],
      ['Middleware', 'auth + Admin/Kepala Sekolah'],
      ['Response', 'HTML — tampilan rapor']
    ]
  );
  pBold_(body, 'Query Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Default', 'Contoh'],
    [
      ['semester', 'string', 'Ganjil', 'Ganjil / Genap'],
      ['academic_year', 'string', '2024/2025', '2024/2025']
    ]
  );
  code_(body, 'GET /students/5/report-card?semester=Genap&academic_year=2024/2025');
}


// ============================================================
// BAB 6 — PENILAIAN SAW
// ============================================================
function writeSAWAPI_(body, C) {
  h1_(body, 'BAB 6 — PENILAIAN SAW (Simple Additive Weighting)', C.DARK);
  p_(body, 'Metode SAW digunakan untuk meranking siswa dan guru berdasarkan kriteria tertimbang. Hanya diakses oleh Admin dan Kepala Sekolah.');

  // --- 6.1 ---
  h2_(body, '6.1 Ranking Siswa', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/saw/students'],
      ['Middleware', 'auth + Admin/Kepala Sekolah'],
      ['Response', 'HTML — tabel ranking SAW siswa']
    ]
  );
  pBold_(body, 'Query Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Default', 'Keterangan'],
    [
      ['class_id', 'integer', '(semua)', 'Filter kelas'],
      ['semester', 'string', 'Ganjil', '"Ganjil" atau "Genap"'],
      ['academic_year', 'string', '2025/2026', 'Tahun ajaran']
    ]
  );

  // --- 6.2 ---
  h2_(body, '6.2 Hitung SAW Siswa', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'POST'],
      ['URL', '/saw/students/calculate'],
      ['Middleware', 'auth + Admin/Kepala Sekolah'],
      ['CSRF', 'WAJIB']
    ]
  );
  pBold_(body, 'Body Parameters (SEMUA WAJIB):');
  table_(body,
    ['Key', 'Tipe', 'Contoh'],
    [
      ['class_id', 'integer', '1'],
      ['semester', 'string', 'Ganjil'],
      ['academic_year', 'string', '2024/2025']
    ]
  );
  pBold_(body, 'Kriteria Penilaian Siswa (default C1–C4):');
  table_(body,
    ['Kode', 'Kriteria', 'Bobot', 'Tipe', 'Sumber Data'],
    [
      ['C1', 'Nilai Akademik', '0.35 (35%)', 'Benefit', 'Rata-rata final_grade dari grades'],
      ['C2', 'Kehadiran', '0.25 (25%)', 'Benefit', 'Persentase hadir dalam periode semester'],
      ['C3', 'Sikap', '0.20 (20%)', 'Benefit', 'Rata-rata behavior_score dari grades'],
      ['C4', 'Keterampilan', '0.20 (20%)', 'Benefit', 'Rata-rata skill_score dari grades']
    ]
  );
  pBold_(body, 'Periode Semester:');
  bullet_(body, 'Ganjil: 1 Juli – 31 Desember');
  bullet_(body, 'Genap: 1 Januari – 30 Juni');
  p_(body, 'Hasil disimpan di tabel student_assessments dengan field: student_id, class_id, semester, academic_year, scores (JSON), final_score, rank.');

  // --- 6.3 ---
  h2_(body, '6.3 Ranking Guru', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/saw/teachers'],
      ['Middleware', 'auth + Admin/Kepala Sekolah'],
      ['Response', 'HTML — tabel ranking SAW guru']
    ]
  );
  pBold_(body, 'Query Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Default', 'Contoh'],
    [
      ['period', 'string', '(bulan ini)', 'March 2024 (format: NamaBulan Tahun)'],
      ['academic_year', 'string', '2024/2025', '2024/2025']
    ]
  );

  // --- 6.4 ---
  h2_(body, '6.4 Hitung SAW Guru', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'POST'],
      ['URL', '/saw/teachers/calculate'],
      ['Middleware', 'auth + Admin/Kepala Sekolah'],
      ['CSRF', 'WAJIB']
    ]
  );
  pBold_(body, 'Body Parameters (SEMUA WAJIB):');
  table_(body,
    ['Key', 'Tipe', 'Contoh'],
    [
      ['period', 'string', 'March 2024'],
      ['academic_year', 'string', '2024/2025']
    ]
  );
  pBold_(body, 'Kriteria Penilaian Guru (default K1–K4):');
  table_(body,
    ['Kode', 'Kriteria', 'Bobot', 'Tipe', 'Sumber Data'],
    [
      ['K1', 'Kehadiran', '0.30 (30%)', 'Benefit', 'Persentase presensi bulan tersebut'],
      ['K2', 'Kualitas Mengajar', '0.30 (30%)', 'Benefit', 'Default 80 (input admin)'],
      ['K3', 'Prestasi Siswa', '0.25 (25%)', 'Benefit', 'Rata-rata final_grade siswa yang diajar'],
      ['K4', 'Disiplin', '0.15 (15%)', 'Benefit', 'min(100, attendance_score + 10)']
    ]
  );
}


// ============================================================
// BAB 7 — LAPORAN & EXPORT
// ============================================================
function writeReportsAPI_(body, C) {
  h1_(body, 'BAB 7 — LAPORAN & EXPORT (Excel / PDF)', C.DARK);
  p_(body, 'Semua endpoint export hanya diakses oleh Admin. Response berupa file download (binary).');

  // --- 7.1 ---
  h2_(body, '7.1 Halaman Laporan', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/reports'],
      ['Middleware', 'auth + Admin'],
      ['Response', 'HTML — halaman pilih jenis laporan']
    ]
  );

  // --- 7.2 ---
  h2_(body, '7.2 Export Presensi', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'POST'],
      ['URL', '/reports/attendance/export'],
      ['Middleware', 'auth + Admin'],
      ['CSRF', 'WAJIB'],
      ['Response', 'File download (.xlsx atau .pdf)']
    ]
  );
  pBold_(body, 'Body Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Keterangan'],
    [
      ['format', 'string', 'required | in:excel,pdf', 'Format output file'],
      ['start_date', 'string', 'nullable | date', 'Tanggal mulai (Y-m-d)'],
      ['end_date', 'string', 'nullable | date | after_or_equal:start_date', 'Tanggal akhir'],
      ['academic_year_id', 'integer', 'nullable | exists:academic_years,id', 'Alternatif: gunakan tahun ajaran'],
      ['type', 'string', 'nullable | in:teacher,student', 'Filter tipe presensi']
    ]
  );
  p_(body, 'Jika academic_year_id diberikan, start_date dan end_date akan diabaikan (menggunakan tanggal tahun ajaran).');
  pBold_(body, 'Contoh:');
  codeBlock_(body, [
    '// Export presensi guru bulan Maret 2024 ke Excel',
    '{',
    '  "format": "excel",',
    '  "start_date": "2024-03-01",',
    '  "end_date": "2024-03-31",',
    '  "type": "teacher"',
    '}'
  ]);
  pBold_(body, 'Nama File Output:');
  code_(body, 'Excel: laporan_presensi_2024-03-01_to_2024-03-31.xlsx');
  code_(body, 'PDF:   laporan_presensi_2024-03-01_to_2024-03-31.pdf');

  // --- 7.3 ---
  h2_(body, '7.3 Export Nilai', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'POST'],
      ['URL', '/reports/grades/export'],
      ['Middleware', 'auth + Admin'],
      ['CSRF', 'WAJIB'],
      ['Response', 'File download']
    ]
  );
  pBold_(body, 'Body Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Keterangan'],
    [
      ['format', 'string', 'required | in:excel,pdf', 'Format file'],
      ['class_id', 'integer', 'nullable | exists:classes,id', 'Filter kelas'],
      ['semester', 'string', 'nullable | in:1,2', 'PERHATIAN: gunakan "1" atau "2", bukan "Ganjil"/"Genap"'],
      ['academic_year', 'string', 'nullable', '2024/2025']
    ]
  );

  // --- 7.4 ---
  h2_(body, '7.4 Export Data Siswa', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'POST'],
      ['URL', '/reports/students/export'],
      ['Middleware', 'auth + Admin'],
      ['CSRF', 'WAJIB']
    ]
  );
  pBold_(body, 'Body Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Keterangan'],
    [
      ['format', 'string', 'required | in:excel,pdf', 'Format file'],
      ['class_id', 'integer', 'nullable | exists:classes,id', 'Filter kelas'],
      ['grade', 'string', 'nullable | in:7,8,9', 'Filter tingkat kelas'],
      ['status', 'string', 'nullable | in:active,inactive', 'Filter status siswa']
    ]
  );

  // --- 7.5 ---
  h2_(body, '7.5 Export Data Guru', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'POST'],
      ['URL', '/reports/teachers/export'],
      ['Middleware', 'auth + Admin'],
      ['CSRF', 'WAJIB']
    ]
  );
  pBold_(body, 'Body Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Validasi'],
    [['format', 'string', 'required | in:excel,pdf']]
  );
  p_(body, 'Hanya memerlukan parameter format. Semua guru aktif akan diexport.');
  pBold_(body, 'Nama file: laporan_guru_2024-03-15.xlsx / .pdf');
}


// ============================================================
// BAB 8 — MANAJEMEN USER
// ============================================================
function writeUsersAPI_(body, C) {
  h1_(body, 'BAB 8 — MANAJEMEN USER', C.DARK);
  p_(body, 'CRUD user hanya diakses oleh Admin. User terdiri dari akun login (email + password + role).');

  // --- 8.1 ---
  h2_(body, '8.1 Daftar User', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/users'],
      ['Middleware', 'auth + Admin'],
      ['Response', 'HTML — paginasi 10/halaman']
    ]
  );
  pBold_(body, 'Query Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Keterangan'],
    [
      ['search', 'string', 'Cari di kolom name dan email'],
      ['role', 'integer', 'Filter berdasarkan role_id (1=Admin, 2=Guru, dst.)']
    ]
  );
  code_(body, 'GET /users?search=budi&role=2');

  // --- 8.2 ---
  h2_(body, '8.2 Tambah User', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'POST'],
      ['URL', '/users'],
      ['Middleware', 'auth + Admin'],
      ['CSRF', 'WAJIB']
    ]
  );
  pBold_(body, 'Body Parameters (SEMUA WAJIB):');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Contoh'],
    [
      ['name', 'string', 'required | max:255', 'Budi Santoso'],
      ['email', 'string', 'required | email | unique:users', 'budi@school.com'],
      ['password', 'string', 'required | min:6 | confirmed', 'password123'],
      ['password_confirmation', 'string', 'required (harus sama dengan password)', 'password123'],
      ['role_id', 'integer', 'required | exists:roles,id', '2']
    ]
  );
  pBold_(body, 'Role ID yang tersedia:');
  table_(body,
    ['ID', 'Nama Role'],
    [['1', 'Admin'], ['2', 'Guru'], ['3', 'Kepala Sekolah'], ['4', 'Kiosk Presensi']]
  );

  // --- 8.3 ---
  h2_(body, '8.3 Update User', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'PUT'],
      ['URL', '/users/{user_id}'],
      ['Middleware', 'auth + Admin'],
      ['CSRF', 'WAJIB']
    ]
  );
  pBold_(body, 'Body Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Keterangan'],
    [
      ['name', 'string', 'required | max:255', 'Nama lengkap'],
      ['email', 'string', 'required | email | unique (kecuali diri sendiri)', 'Email unik'],
      ['role_id', 'integer', 'required | exists:roles,id', 'Role baru'],
      ['password', 'string', 'nullable | min:6 | confirmed', 'Kosongkan jika tidak ingin ubah'],
      ['password_confirmation', 'string', 'Wajib jika password diisi', 'Konfirmasi password']
    ]
  );

  // --- 8.4 ---
  h2_(body, '8.4 Hapus User', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'DELETE'],
      ['URL', '/users/{user_id}'],
      ['Middleware', 'auth + Admin'],
      ['CSRF', 'WAJIB']
    ]
  );
  p_(body, 'PERHATIAN: Admin tidak bisa menghapus akun diri sendiri. Sistem akan menolak dengan pesan error.');

  // --- 8.5 ---
  h2_(body, '8.5 Reset Password User', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'POST'],
      ['URL', '/users/{user_id}/reset-password'],
      ['Middleware', 'auth + Admin'],
      ['CSRF', 'WAJIB'],
      ['Body', 'Tidak ada parameter (hanya CSRF token)']
    ]
  );
  p_(body, 'Password akan direset ke default: "password123". Password baru ditampilkan di flash message setelah redirect.');
}


// ============================================================
// BAB 9 — MANAJEMEN GURU
// ============================================================
function writeTeachersAPI_(body, C) {
  h1_(body, 'BAB 9 — MANAJEMEN GURU', C.DARK);
  p_(body, 'Manajemen data guru lengkap termasuk pembuatan akun otomatis dan upload foto.');

  // --- 9.1 ---
  h2_(body, '9.1 Daftar Guru', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/teachers'],
      ['Middleware', 'auth + Admin'],
      ['Response', 'HTML — paginasi 10/halaman dengan relasi user, subjects']
    ]
  );

  // --- 9.2 ---
  h2_(body, '9.2 Tambah Guru Baru', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'POST'],
      ['URL', '/teachers'],
      ['Middleware', 'auth + Admin'],
      ['CSRF', 'WAJIB'],
      ['Content-Type', 'multipart/form-data (karena upload foto)']
    ]
  );
  pBold_(body, 'Body Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Wajib', 'Contoh'],
    [
      ['nip', 'string', 'required | unique:teachers', 'YA', '197505121998021001'],
      ['name', 'string', 'required | max:255', 'YA', 'Budi Santoso'],
      ['email', 'string', 'required | email | unique:users', 'YA', 'budi@school.com'],
      ['password', 'string', 'required | min:6', 'YA', 'password123'],
      ['gender', 'string', 'required | in:L,P', 'YA', 'L (Laki-laki) / P (Perempuan)'],
      ['phone', 'string', 'nullable | max:20', 'TIDAK', '081234567890'],
      ['address', 'string', 'nullable', 'TIDAK', 'Jl. Merdeka No. 10'],
      ['birth_date', 'date', 'nullable | date', 'TIDAK', '1975-05-12'],
      ['photo', 'file', 'nullable | image | mimes:jpeg,png,jpg | max:2048', 'TIDAK', '<file binary max 2MB>'],
      ['education_level', 'string', 'nullable | max:50', 'TIDAK', 'S1 Pendidikan Matematika'],
      ['position', 'string', 'nullable | max:100', 'TIDAK', 'Guru Matematika']
    ]
  );
  pBold_(body, 'Efek Samping:');
  bullet_(body, 'Otomatis membuat akun User dengan role Guru (role_id=2)');
  bullet_(body, 'Foto disimpan ke storage/app/public/teachers/');
  bullet_(body, 'Status otomatis di-set "active"');
  bullet_(body, 'Notifikasi dikirim ke admin');

  // --- 9.3 ---
  h2_(body, '9.3 Update Guru', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'PUT (gunakan _method=PUT di form)'],
      ['URL', '/teachers/{teacher_id}'],
      ['Middleware', 'auth + Admin'],
      ['CSRF', 'WAJIB'],
      ['Content-Type', 'multipart/form-data']
    ]
  );
  p_(body, 'Parameter sama seperti store, ditambah:');
  table_(body,
    ['Key', 'Tipe', 'Validasi'],
    [['status', 'string', 'required | in:active,inactive']]
  );
  p_(body, 'NIP dan email boleh sama dengan data lama (unique mengecualikan record saat ini).');

  // --- 9.4 ---
  h2_(body, '9.4 Hapus Guru', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'DELETE'],
      ['URL', '/teachers/{teacher_id}'],
      ['Middleware', 'auth + Admin'],
      ['CSRF', 'WAJIB']
    ]
  );
  p_(body, 'EFEK: Foto dihapus dari storage. Akun User terkait juga dihapus (cascade).');

  // --- 9.5 ---
  h2_(body, '9.5 Profil Guru (Self-Edit)', C.PRIMARY);
  p_(body, 'Endpoint ini digunakan oleh guru untuk mengedit profil mereka sendiri.');
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'PUT'],
      ['URL', '/my-profile'],
      ['Middleware', 'auth + Admin/Guru'],
      ['CSRF', 'WAJIB'],
      ['Content-Type', 'multipart/form-data']
    ]
  );
  pBold_(body, 'Body Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Keterangan'],
    [
      ['name', 'string', 'required | max:255', 'Nama lengkap'],
      ['nip', 'string', 'required | max:20 | unique (exc. self)', 'NIP'],
      ['phone', 'string', 'nullable | max:15', 'No. HP'],
      ['address', 'string', 'nullable', 'Alamat'],
      ['birth_date', 'date', 'nullable', 'Tanggal lahir (Y-m-d)'],
      ['birth_place', 'string', 'nullable | max:100', 'Tempat lahir'],
      ['gender', 'string', 'nullable | in:L,P', 'Jenis kelamin'],
      ['religion', 'string', 'nullable | max:50', 'Agama'],
      ['education_level', 'string', 'nullable | max:50', 'Pendidikan terakhir'],
      ['major', 'string', 'nullable | max:100', 'Jurusan'],
      ['photo', 'file', 'nullable | image | max:2048', 'Foto profil'],
      ['email', 'string', 'required | email | unique (exc. self)', 'Email login'],
      ['password', 'string', 'nullable | min:8 | confirmed', 'Password baru (opsional)'],
      ['password_confirmation', 'string', 'wajib jika password diisi', 'Konfirmasi']
    ]
  );

  // --- 9.6 ---
  h2_(body, '9.6 Kelas Saya (Guru)', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/my-classes'],
      ['Middleware', 'auth + Admin/Guru'],
      ['Response', 'HTML — daftar kelas & mapel yang diajar guru yang login']
    ]
  );
}


// ============================================================
// BAB 10 — MANAJEMEN SISWA
// ============================================================
function writeStudentsAPI_(body, C) {
  h1_(body, 'BAB 10 — MANAJEMEN SISWA', C.DARK);
  p_(body, 'CRUD siswa lengkap dengan upload foto dan data orang tua.');

  // --- 10.1 ---
  h2_(body, '10.1 Daftar Siswa', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/students'],
      ['Middleware', 'auth + Admin'],
      ['Response', 'HTML — paginasi 10/halaman']
    ]
  );
  pBold_(body, 'Query Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Contoh'],
    [
      ['class_id', 'integer', '1 (filter kelas)'],
      ['status', 'string', 'active / inactive / graduated'],
      ['search', 'string', 'Cari di name, NIS, NISN']
    ]
  );
  code_(body, 'GET /students?search=ahmad&class_id=1&status=active');

  // --- 10.2 ---
  h2_(body, '10.2 Tambah Siswa', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'POST'],
      ['URL', '/students'],
      ['Middleware', 'auth + Admin'],
      ['CSRF', 'WAJIB'],
      ['Content-Type', 'multipart/form-data']
    ]
  );
  pBold_(body, 'Body Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Wajib', 'Contoh'],
    [
      ['class_id', 'integer', 'required | exists:classes,id', 'YA', '1'],
      ['nisn', 'string', 'required | unique:students', 'YA', '0012345678'],
      ['nis', 'string', 'required | unique:students', 'YA', '001'],
      ['name', 'string', 'required | max:255', 'YA', 'Ahmad Ridho'],
      ['gender', 'string', 'required | in:L,P', 'YA', 'L / P'],
      ['phone', 'string', 'nullable | max:20', 'TIDAK', '081234567890'],
      ['address', 'string', 'nullable', 'TIDAK', 'Jl. Sudirman No. 5'],
      ['birth_date', 'date', 'nullable | date', 'TIDAK', '2009-05-12'],
      ['birth_place', 'string', 'nullable | max:100', 'TIDAK', 'Purwakarta'],
      ['photo', 'file', 'nullable | image | mimes:jpeg,png,jpg | max:2048', 'TIDAK', '<binary max 2MB>'],
      ['parent_name', 'string', 'nullable | max:255', 'TIDAK', 'Suparman'],
      ['parent_phone', 'string', 'nullable | max:20', 'TIDAK', '081234567891']
    ]
  );

  // --- 10.3 ---
  h2_(body, '10.3 Update Siswa', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'PUT'],
      ['URL', '/students/{student_id}'],
      ['Middleware', 'auth + Admin'],
      ['CSRF', 'WAJIB'],
      ['Content-Type', 'multipart/form-data']
    ]
  );
  p_(body, 'Parameter sama seperti store, ditambah:');
  table_(body,
    ['Key', 'Tipe', 'Validasi'],
    [['status', 'string', 'required | in:active,inactive,graduated']]
  );

  // --- 10.4 ---
  h2_(body, '10.4 Hapus Siswa', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'DELETE'],
      ['URL', '/students/{student_id}'],
      ['Middleware', 'auth + Admin'],
      ['CSRF', 'WAJIB']
    ]
  );
  p_(body, 'Foto dihapus dari storage secara otomatis.');
}


// ============================================================
// BAB 11 — MASTER DATA
// ============================================================
function writeMasterDataAPI_(body, C) {
  h1_(body, 'BAB 11 — MASTER DATA (Kelas, Mapel, Tahun Ajaran, Penugasan)', C.DARK);
  p_(body, 'Semua endpoint master data hanya diakses oleh Admin.');

  // === KELAS ===
  h2_(body, '11.1 Kelas (ClassRoom)', C.PRIMARY);
  p_(body, 'CRUD kelas / rombongan belajar.');
  table_(body,
    ['Method', 'URL', 'Keterangan'],
    [
      ['GET', '/classes', 'Daftar kelas (paginasi, dengan jumlah siswa)'],
      ['GET', '/classes/create', 'Form tambah kelas'],
      ['POST', '/classes', 'Simpan kelas baru'],
      ['GET', '/classes/{id}', 'Detail kelas'],
      ['GET', '/classes/{id}/edit', 'Form edit kelas'],
      ['PUT', '/classes/{id}', 'Update kelas'],
      ['DELETE', '/classes/{id}', 'Hapus kelas (gagal jika masih ada siswa/mapel)']
    ]
  );
  pBold_(body, 'Body Parameters (POST / PUT):');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Contoh'],
    [
      ['name', 'string', 'required | max:255', 'VII-A'],
      ['grade', 'integer', 'required | in:7,8,9', '7'],
      ['academic_year', 'string', 'nullable', '2024/2025'],
      ['homeroom_teacher_id', 'integer', 'nullable | exists:teachers,id', '5']
    ]
  );

  // === MAPEL ===
  h2_(body, '11.2 Mata Pelajaran (Subject)', C.PRIMARY);
  table_(body,
    ['Method', 'URL', 'Keterangan'],
    [
      ['GET', '/subjects', 'Daftar mapel (paginasi)'],
      ['POST', '/subjects', 'Simpan mapel baru'],
      ['GET', '/subjects/{id}', 'Detail mapel'],
      ['PUT', '/subjects/{id}', 'Update mapel'],
      ['DELETE', '/subjects/{id}', 'Hapus mapel']
    ]
  );
  pBold_(body, 'Body Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Contoh'],
    [
      ['name', 'string', 'required | max:255', 'Matematika'],
      ['code', 'string', 'required | max:10 | unique', 'MTK'],
      ['description', 'string', 'nullable', 'Mata pelajaran Matematika kelas 7-9']
    ]
  );

  // === TAHUN AJARAN ===
  h2_(body, '11.3 Tahun Ajaran (Academic Year)', C.PRIMARY);
  table_(body,
    ['Method', 'URL', 'Keterangan'],
    [
      ['GET', '/academic-years', 'Daftar tahun ajaran (paginasi desc)'],
      ['POST', '/academic-years', 'Simpan tahun ajaran'],
      ['PUT', '/academic-years/{id}', 'Update tahun ajaran'],
      ['DELETE', '/academic-years/{id}', 'Hapus (gagal jika ada data terkait)'],
      ['POST', '/academic-years/{id}/toggle-active', 'Aktifkan/nonaktifkan tahun ajaran']
    ]
  );
  pBold_(body, 'Body Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Contoh'],
    [
      ['year', 'string', 'required', '2024/2025'],
      ['semester', 'string', 'required', 'Ganjil / Genap'],
      ['start_date', 'date', 'required', '2024-07-15'],
      ['end_date', 'date', 'required | after:start_date', '2024-12-20'],
      ['is_active', 'boolean', 'nullable', 'true / false']
    ]
  );
  p_(body, 'toggle-active: Hanya satu tahun ajaran yang bisa aktif dalam satu waktu.');

  // === PENUGASAN GURU-MAPEL ===
  h2_(body, '11.4 Penugasan Guru-Mapel (Teacher Subject)', C.PRIMARY);
  table_(body,
    ['Method', 'URL', 'Keterangan'],
    [
      ['GET', '/teacher-subjects', 'Daftar penugasan (dengan filter)'],
      ['POST', '/teacher-subjects', 'Tambah penugasan'],
      ['PUT', '/teacher-subjects/{id}', 'Update penugasan'],
      ['DELETE', '/teacher-subjects/{id}', 'Hapus penugasan']
    ]
  );
  pBold_(body, 'Body Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Contoh'],
    [
      ['teacher_id', 'integer', 'required | exists:teachers,id', '5'],
      ['subject_id', 'integer', 'required | exists:subjects,id', '3'],
      ['class_id', 'integer', 'required | exists:classes,id', '1'],
      ['academic_year', 'string', 'nullable', '2024/2025']
    ]
  );
  p_(body, 'Sistem mencegah duplikat penugasan (guru + mapel + kelas yang sama).');

  // === API JSON endpoints ===
  h2_(body, '11.5 API JSON untuk Relasi Guru-Mapel', C.PRIMARY);
  p_(body, 'Endpoint JSON untuk keperluan dropdown dinamis di frontend:');
  table_(body,
    ['Method', 'URL', 'Response'],
    [
      ['GET', '/api/teacher/{teacher_id}/subjects', 'JSON array of subjects yang diajar guru ini'],
      ['GET', '/api/subject/{subject_id}/teachers', 'JSON array of teachers yang mengajar mapel ini']
    ]
  );
  pBold_(body, 'Contoh Response /api/teacher/5/subjects:');
  codeBlock_(body, [
    '[',
    '  { "id": 3, "name": "Matematika", "code": "MTK" },',
    '  { "id": 7, "name": "IPA", "code": "IPA" }',
    ']'
  ]);
}


// ============================================================
// BAB 12 — KRITERIA SAW
// ============================================================
function writeCriteriaAPI_(body, C) {
  h1_(body, 'BAB 12 — KRITERIA SAW', C.DARK);
  p_(body, 'Manajemen kriteria yang digunakan dalam perhitungan SAW. Hanya Admin yang bisa mengubah.');

  // --- 12.1 ---
  h2_(body, '12.1 Daftar Kriteria', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/criteria'],
      ['Middleware', 'auth + Admin'],
      ['Response', 'HTML — daftar kriteria siswa & guru']
    ]
  );
  p_(body, 'Response menampilkan: studentCriteria, teacherCriteria, total bobot masing-masing.');

  // --- 12.2 ---
  h2_(body, '12.2 Tambah Kriteria', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'POST'],
      ['URL', '/criteria'],
      ['Middleware', 'auth + Admin'],
      ['CSRF', 'WAJIB']
    ]
  );
  pBold_(body, 'Body Parameters (SEMUA WAJIB kecuali description):');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Contoh', 'Keterangan'],
    [
      ['code', 'string', 'required | max:10 | unique:criteria,code', 'C5', 'Kode unik kriteria'],
      ['name', 'string', 'required | max:255', 'Ekstrakurikuler', 'Nama kriteria'],
      ['type', 'string', 'required | in:benefit,cost', 'benefit', 'benefit=semakin tinggi semakin baik, cost=semakin rendah semakin baik'],
      ['weight', 'numeric', 'required | min:0 | max:1', '0.15', 'Bobot (0.00 – 1.00)'],
      ['for', 'string', 'required | in:student,teacher', 'student', 'Untuk penilaian siswa atau guru'],
      ['description', 'string', 'nullable', 'Skor partisipasi ekskul', 'Deskripsi opsional']
    ]
  );
  pBold_(body, 'VALIDASI PENTING:');
  p_(body, 'Total bobot semua kriteria per kategori (student/teacher) tidak boleh melebihi 1.0. Jika menambahkan kriteria ini menyebabkan total > 1.0, request akan ditolak.');

  // --- 12.3 ---
  h2_(body, '12.3 Update & Hapus Kriteria', C.PRIMARY);
  table_(body,
    ['Method', 'URL', 'Keterangan'],
    [
      ['PUT', '/criteria/{id}', 'Update kriteria (validasi total bobot ulang)'],
      ['DELETE', '/criteria/{id}', 'Hapus (ditolak jika sudah digunakan di assessment)']
    ]
  );

  // --- 12.4 ---
  h2_(body, '12.4 Normalisasi Bobot', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'POST'],
      ['URL', '/criteria/normalize'],
      ['Middleware', 'auth + Admin'],
      ['CSRF', 'WAJIB']
    ]
  );
  pBold_(body, 'Body Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Contoh'],
    [['type', 'string', '"student" atau "teacher"']]
  );
  p_(body, 'Fungsi: Membagi setiap bobot dengan total bobot sehingga jumlah = 1.0. Dibulatkan 2 desimal.');
  pBold_(body, 'Contoh:');
  code_(body, 'Sebelum: C1=0.40, C2=0.30, C3=0.20, C4=0.20 (total=1.10)');
  code_(body, 'Setelah normalize: C1=0.36, C2=0.27, C3=0.18, C4=0.18 (total=1.00)');
}


// ============================================================
// BAB 13 — PENGATURAN SISTEM
// ============================================================
function writeSettingsAPI_(body, C) {
  h1_(body, 'BAB 13 — PENGATURAN SISTEM', C.DARK);
  p_(body, 'Semua endpoint pengaturan hanya diakses Admin. Terbagi dalam 5 grup pengaturan + utilitas.');

  // --- 13.1 ---
  h2_(body, '13.1 Halaman Pengaturan', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/settings'],
      ['Middleware', 'auth + Admin'],
      ['Response', 'HTML — 5 tab pengaturan (School, General, Appearance, Notification, System)']
    ]
  );

  // --- 13.2 ---
  h2_(body, '13.2 Update Pengaturan Sekolah', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'PUT'],
      ['URL', '/settings/school'],
      ['CSRF', 'WAJIB'],
      ['Content-Type', 'multipart/form-data (karena upload logo)']
    ]
  );
  pBold_(body, 'Body Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Contoh'],
    [
      ['school_name', 'string', 'required | max:255', 'SMP Negeri 4 Purwakarta'],
      ['school_npsn', 'string', 'required | max:20', '20229001'],
      ['school_address', 'string', 'required', 'Jl. Veteran No. 14'],
      ['school_phone', 'string', 'required | max:20', '0263-223123'],
      ['school_email', 'string', 'required | email | max:255', 'smpn4@example.com'],
      ['school_website', 'string', 'nullable | url | max:255', 'https://smpn4.sch.id'],
      ['school_logo', 'file', 'nullable | image | mimes:jpeg,png,jpg | max:2048', '<file max 2MB>'],
      ['headmaster_name', 'string', 'required | max:255', 'Budi Santoso'],
      ['headmaster_nip', 'string', 'required | max:20', '196501151990031001']
    ]
  );

  // --- 13.3 ---
  h2_(body, '13.3 Update Pengaturan Umum', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'PUT'],
      ['URL', '/settings/general'],
      ['CSRF', 'WAJIB']
    ]
  );
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Contoh'],
    [
      ['app_name', 'string', 'required | max:255', 'Sistem Presensi & Penilaian'],
      ['app_timezone', 'string', 'required | max:50', 'Asia/Jakarta'],
      ['app_language', 'string', 'required | in:id,en', 'id'],
      ['date_format', 'string', 'required | max:20', 'd-m-Y'],
      ['time_format', 'string', 'required | max:20', 'H:i:s']
    ]
  );

  // --- 13.4 ---
  h2_(body, '13.4 Update Pengaturan Tampilan', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'PUT'],
      ['URL', '/settings/appearance'],
      ['CSRF', 'WAJIB']
    ]
  );
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Contoh'],
    [
      ['theme_color', 'string', 'required | max:7', '#007bff (hex color)'],
      ['sidebar_color', 'string', 'required | in:dark,light', 'dark'],
      ['items_per_page', 'integer', 'required | min:5 | max:100', '20']
    ]
  );

  // --- 13.5 ---
  h2_(body, '13.5 Update Pengaturan Notifikasi', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'PUT'],
      ['URL', '/settings/notification'],
      ['CSRF', 'WAJIB']
    ]
  );
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Contoh'],
    [
      ['email_notifications', 'boolean', 'boolean (checkbox)', 'true / false'],
      ['sms_notifications', 'boolean', 'boolean (checkbox)', 'true / false'],
      ['notification_email', 'string', 'required | email | max:255', 'admin@school.com']
    ]
  );

  // --- 13.6 ---
  h2_(body, '13.6 Update Pengaturan Sistem', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'PUT'],
      ['URL', '/settings/system'],
      ['CSRF', 'WAJIB']
    ]
  );
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Contoh'],
    [
      ['maintenance_mode', 'boolean', 'boolean', 'false'],
      ['auto_backup', 'boolean', 'boolean', 'true'],
      ['backup_schedule', 'string', 'required | in:daily,weekly,monthly', 'weekly'],
      ['max_upload_size', 'integer', 'required | min:1024 | max:10240', '5120 (dalam KB)']
    ]
  );

  // --- 13.7 ---
  h2_(body, '13.7 Utilitas: Clear Cache & Backup', C.PRIMARY);
  table_(body,
    ['Method', 'URL', 'Keterangan'],
    [
      ['POST', '/settings/cache/clear', 'Bersihkan cache pengaturan. Tidak butuh body.'],
      ['POST', '/settings/backup', 'Buat backup database MySQL (mysqldump). File: storage/app/backups/backup_YYYY-MM-DD_HH-MM-SS.sql']
    ]
  );
  p_(body, 'Kedua endpoint hanya membutuhkan CSRF token, tanpa body parameter.');
}


// ============================================================
// BAB 14 — PROFIL & NOTIFIKASI
// ============================================================
function writeProfileNotifAPI_(body, C) {
  h1_(body, 'BAB 14 — PROFIL & NOTIFIKASI', C.DARK);

  // === PROFIL ===
  h2_(body, '14.1 Edit Profil (Semua User)', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'PUT'],
      ['URL', '/profile'],
      ['Middleware', 'auth'],
      ['CSRF', 'WAJIB'],
      ['Content-Type', 'multipart/form-data']
    ]
  );
  pBold_(body, 'Body Parameters:');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Keterangan'],
    [
      ['name', 'string', 'required | max:255', 'Nama lengkap'],
      ['email', 'string', 'required | email | unique (exc. self)', 'Email login'],
      ['profile_photo', 'file', 'nullable | image | mimes:jpeg,png,jpg,gif | max:2048', 'Foto profil baru'],
      ['remove_photo', 'string', 'nullable', 'Kirim "1" untuk menghapus foto']
    ]
  );

  h2_(body, '14.2 Ubah Password', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'PUT'],
      ['URL', '/profile/password'],
      ['Middleware', 'auth'],
      ['CSRF', 'WAJIB']
    ]
  );
  pBold_(body, 'Body Parameters (SEMUA WAJIB):');
  table_(body,
    ['Key', 'Tipe', 'Validasi', 'Keterangan'],
    [
      ['current_password', 'string', 'required | current_password', 'Password lama (harus benar)'],
      ['password', 'string', 'required | min:8 | confirmed', 'Password baru (minimal 8 karakter)'],
      ['password_confirmation', 'string', 'required', 'Harus sama dengan password']
    ]
  );

  // === NOTIFIKASI ===
  h2_(body, '14.3 API Notifikasi (JSON)', C.PRIMARY);
  p_(body, 'Semua endpoint notifikasi mengembalikan JSON. Header Accept: application/json diperlukan.');
  table_(body,
    ['Method', 'URL', 'Keterangan', 'Body'],
    [
      ['GET', '/api/notifications', 'Daftar notifikasi (JSON array)', '—'],
      ['GET', '/api/notifications/unread-count', 'Jumlah belum dibaca: { "count": 5 }', '—'],
      ['POST', '/api/notifications/{id}/read', 'Tandai satu notifikasi sebagai dibaca', 'CSRF saja'],
      ['POST', '/api/notifications/read-all', 'Tandai SEMUA sebagai dibaca', 'CSRF saja'],
      ['DELETE', '/api/notifications/{id}', 'Hapus satu notifikasi', 'CSRF saja']
    ]
  );
  pBold_(body, 'Contoh Response GET /api/notifications:');
  codeBlock_(body, [
    '[',
    '  {',
    '    "id": "uuid-string",',
    '    "type": "App\\\\Notifications\\\\AttendanceNotification",',
    '    "data": {',
    '      "title": "Check-in Berhasil",',
    '      "message": "Budi Santoso check-in pukul 07:25",',
    '      "icon": "check-circle"',
    '    },',
    '    "read_at": null,',
    '    "created_at": "2024-03-15T07:25:00.000000Z"',
    '  }',
    ']'
  ]);

  // === HALAMAN NOTIFIKASI ===
  h2_(body, '14.4 Halaman Semua Notifikasi', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/notifications'],
      ['Middleware', 'auth'],
      ['Response', 'HTML — halaman daftar notifikasi (paginasi)']
    ]
  );

  // === BAHASA ===
  h2_(body, '14.5 Ganti Bahasa', C.PRIMARY);
  table_(body,
    ['Properti', 'Detail'],
    [
      ['Method', 'GET'],
      ['URL', '/language/{locale}'],
      ['Middleware', 'TIDAK ADA (tanpa login)'],
      ['Response', 'Redirect kembali ke halaman sebelumnya']
    ]
  );
  pBold_(body, 'Route Parameter:');
  table_(body,
    ['Parameter', 'Tipe', 'Nilai Valid'],
    [['locale', 'string', '"id" (Bahasa Indonesia) atau "en" (English)']]
  );
  code_(body, 'GET /language/id   → Ganti ke Bahasa Indonesia');
  code_(body, 'GET /language/en   → Ganti ke English');
}


// ============================================================
// BAB 15 — REFERENSI KODE ERROR & TROUBLESHOOTING
// ============================================================
function writeErrorReference_(body, C) {
  h1_(body, 'BAB 15 — REFERENSI KODE ERROR & TROUBLESHOOTING', C.DARK);

  // --- 15.1 ---
  h2_(body, '15.1 HTTP Status Code', C.PRIMARY);
  table_(body,
    ['Code', 'Status', 'Penjelasan', 'Contoh Penyebab'],
    [
      ['200', 'OK', 'Berhasil', 'GET sukses, JSON response'],
      ['302', 'Found', 'Redirect', 'Login sukses, form submit sukses'],
      ['401', 'Unauthorized', 'Belum login', 'Cookie session expired / tidak ada'],
      ['403', 'Forbidden', 'Tidak punya akses', 'Guru coba akses /users (admin only)'],
      ['404', 'Not Found', 'Resource tidak ditemukan', 'ID guru/siswa tidak ada di database'],
      ['405', 'Method Not Allowed', 'Method HTTP salah', 'GET ke endpoint POST'],
      ['419', 'Page Expired', 'CSRF token invalid', 'Token expired atau tidak dikirim'],
      ['422', 'Unprocessable Entity', 'Validasi gagal', 'Email sudah dipakai, field wajib kosong'],
      ['500', 'Server Error', 'Error internal', 'Bug di server, database down']
    ]
  );

  // --- 15.2 ---
  h2_(body, '15.2 Error 419 — CSRF Token Mismatch', C.RED);
  p_(body, 'Ini adalah error PALING UMUM saat menggunakan API. Penyebab dan solusi:');
  table_(body,
    ['Penyebab', 'Solusi'],
    [
      ['CSRF token tidak dikirim', 'Tambahkan _token di body ATAU X-CSRF-TOKEN di header'],
      ['CSRF token expired', 'Muat ulang halaman, ambil token baru'],
      ['Cookie session hilang', 'Pastikan cookie laravel_session dikirim di request'],
      ['Domain berbeda (CORS)', 'Sistem ini session-based, HARUS dari domain yang sama'],
      ['Postman: cookie tidak disimpan', 'Aktifkan "Automatically follow redirects" dan "Send cookies"']
    ]
  );
  pBold_(body, 'Quick Fix untuk Postman:');
  numbered_(body, 'Buat request GET ke /login terlebih dahulu');
  numbered_(body, 'Postman otomatis menyimpan cookie (laravel_session + XSRF-TOKEN)');
  numbered_(body, 'Copy nilai XSRF-TOKEN (URL-decode dulu, ganti %3D → =)');
  numbered_(body, 'Tambahkan header X-XSRF-TOKEN di request POST/PUT/DELETE');

  // --- 15.3 ---
  h2_(body, '15.3 Error 422 — Validation Failed', C.ORANGE);
  p_(body, 'Terjadi ketika data yang dikirim tidak memenuhi aturan validasi.');
  pBold_(body, 'Format Response:');
  codeBlock_(body, [
    '{',
    '  "message": "The email field is required. (and 2 more errors)",',
    '  "errors": {',
    '    "email": ["The email field is required."],',
    '    "password": ["The password must be at least 6 characters."],',
    '    "name": ["The name field is required."]',
    '  }',
    '}'
  ]);
  pBold_(body, 'Cara Debug:');
  bullet_(body, 'Perhatikan field mana yang error dari key "errors"');
  bullet_(body, 'Pastikan tipe data sesuai (string vs integer vs file)');
  bullet_(body, 'Cek constraint unique (email sudah dipakai orang lain)');
  bullet_(body, 'Untuk file upload: pastikan Content-Type: multipart/form-data');

  // --- 15.4 ---
  h2_(body, '15.4 Error Geolokasi (Presensi)', C.ORANGE);
  table_(body,
    ['Error Message', 'Penyebab', 'Solusi'],
    [
      ['Anda berada di luar radius sekolah', 'Jarak > 100m dari koordinat sekolah', 'Harus di dalam radius 100m dari (-6.5465236, 107.4414175)'],
      ['QR Code tidak valid', 'Data QR tidak bisa didekripsi', 'Pastikan mengirim string QR mentah tanpa modifikasi'],
      ['QR Code sudah kedaluwarsa', 'Waktu > 600s (admin) / 60s (kiosk)', 'Generate QR baru, scan dalam 10 menit (admin) / 1 menit (kiosk)'],
      ['QR code ini bukan milik Anda', 'Teacher ID di QR ≠ guru yang scan', 'Setiap guru hanya bisa scan QR milik sendiri'],
      ['Tanggal QR tidak sesuai', 'QR dibuat kemarin / tanggal berbeda', 'QR hanya valid untuk hari ini']
    ]
  );

  // --- 15.5 ---
  h2_(body, '15.5 Tips Penggunaan dengan Postman', C.ACCENT);
  numbered_(body, 'Import environment: Set variable {{base_url}} = http://127.0.0.1:8000');
  numbered_(body, 'Login dulu: POST {{base_url}}/login dengan email + password + _token');
  numbered_(body, 'Ambil CSRF dari cookie: Di tab Tests, tambahkan script untuk extract XSRF-TOKEN');
  numbered_(body, 'Set header global: X-XSRF-TOKEN diambil dari cookie variable');
  numbered_(body, 'Cookie manager: Pastikan Postman menyimpan cookie untuk domain 127.0.0.1');

  pBold_(body, 'Postman Pre-request Script (untuk auto CSRF):');
  codeBlock_(body, [
    '// Simpan di Collection level Pre-request Script',
    'const xsrfCookie = pm.cookies.get("XSRF-TOKEN");',
    'if (xsrfCookie) {',
    '    pm.request.headers.add({',
    '        key: "X-XSRF-TOKEN",',
    '        value: decodeURIComponent(xsrfCookie)',
    '    });',
    '}'
  ]);

  // --- 15.6 ---
  h2_(body, '15.6 Tips Penggunaan dengan JavaScript (Fetch API)', C.ACCENT);
  pBold_(body, 'Setup global untuk semua request:');
  codeBlock_(body, [
    '// Fungsi helper untuk semua API call',
    'async function apiCall(url, method = "GET", body = null) {',
    '    const token = document.querySelector(\'meta[name="csrf-token"]\').content;',
    '    const options = {',
    '        method: method,',
    '        headers: {',
    '            "X-CSRF-TOKEN": token,',
    '            "Accept": "application/json",',
    '            "X-Requested-With": "XMLHttpRequest"',
    '        },',
    '        credentials: "same-origin"  // PENTING: kirim cookie',
    '    };',
    '',
    '    if (body && !(body instanceof FormData)) {',
    '        options.headers["Content-Type"] = "application/json";',
    '        options.body = JSON.stringify(body);',
    '    } else if (body instanceof FormData) {',
    '        // Jangan set Content-Type untuk FormData (browser auto-set boundary)',
    '        options.body = body;',
    '    }',
    '',
    '    const response = await fetch(url, options);',
    '    if (!response.ok) {',
    '        const error = await response.json();',
    '        throw error;',
    '    }',
    '    return response.json();',
    '}'
  ]);

  pBold_(body, 'Contoh penggunaan:');
  codeBlock_(body, [
    '// Login',
    'await apiCall("/login", "POST", {',
    '    email: "admin@smpn4.sch.id",',
    '    password: "password123"',
    '});',
    '',
    '// Ambil notifikasi',
    'const notifs = await apiCall("/api/notifications");',
    '',
    '// Upload foto guru (FormData)',
    'const form = new FormData();',
    'form.append("nip", "197505121998021001");',
    'form.append("name", "Budi Santoso");',
    'form.append("email", "budi@school.com");',
    'form.append("password", "password123");',
    'form.append("gender", "L");',
    'form.append("photo", fileInput.files[0]);',
    'await apiCall("/teachers", "POST", form);'
  ]);

  // --- 15.7 ---
  h2_(body, '15.7 Ringkasan Endpoint per Role', C.PRIMARY);
  p_(body, 'Tabel ringkasan endpoint mana saja yang bisa diakses oleh setiap role:');
  table_(body,
    ['Modul', 'Admin', 'Guru', 'Kepala Sekolah', 'Kiosk', 'Publik'],
    [
      ['Login/Logout', '✓', '✓', '✓', '✓', '—'],
      ['Dashboard', '✓', '✓', '✓', '✓', '—'],
      ['Profil', '✓', '✓', '✓', '✓', '—'],
      ['Notifikasi', '✓', '✓', '✓', '✓', '—'],
      ['Presensi (lihat)', '✓', '✓ (sendiri)', '—', '—', '—'],
      ['Presensi (QR scan)', '✓', '✓', '—', '—', '—'],
      ['Presensi kelas siswa', '✓', '—', '—', '—', '—'],
      ['Input Nilai', '✓', '✓', '—', '—', '—'],
      ['SAW Ranking', '✓', '—', '✓', '—', '—'],
      ['Rapor Siswa', '✓', '—', '✓', '—', '—'],
      ['Laporan/Export', '✓', '—', '—', '—', '—'],
      ['User Management', '✓', '—', '—', '—', '—'],
      ['Guru Management', '✓', '—', '—', '—', '—'],
      ['Siswa Management', '✓', '—', '—', '—', '—'],
      ['Kelas/Mapel', '✓', '—', '—', '—', '—'],
      ['Tahun Ajaran', '✓', '—', '—', '—', '—'],
      ['Kriteria SAW', '✓', '—', '—', '—', '—'],
      ['Pengaturan', '✓', '—', '—', '—', '—'],
      ['Kiosk Display', '—', '—', '—', '✓', '✓'],
      ['Kiosk API (QR/Status)', '—', '—', '—', '—', '✓'],
      ['Ganti Bahasa', '✓', '✓', '✓', '✓', '✓']
    ]
  );
}
