// ============================================================
// DOKUMENTASI LENGKAP SISTEM — Google Docs Script
// Sistem Informasi Absensi Guru & Penilaian Siswa SMPN 4 Purwakarta
// ============================================================
// CARA PAKAI:
// 1. Buka https://script.google.com
// 2. Klik "New Project"
// 3. Hapus semua kode yang ada, paste SEMUA kode ini
// 4. Klik tombol ▶ Run (pilih createFullDocumentation)
// 5. Pertama kali minta izin — klik "Review permissions" > pilih akun > "Allow"
// 6. Buka Google Docs yang dibuat (link di Logger / Execution Log)
// ============================================================

/**
 * FUNGSI UTAMA — Membuat Google Docs lengkap
 * berisi seluruh dokumentasi teknis sistem.
 */
function createFullDocumentation() {
  var doc = DocumentApp.create('Dokumentasi Lengkap — Sistem Informasi Absensi Guru & Penilaian Siswa SMPN 4 Purwakarta');
  var body = doc.getBody();
  
  // ===== STYLE CONSTANTS =====
  var COLORS = {
    PRIMARY:    '#1a56db',
    SECONDARY:  '#6366f1',
    ACCENT:     '#059669',
    DARK:       '#1e293b',
    LIGHT_BG:   '#f1f5f9',
    WHITE:      '#ffffff',
    RED:        '#dc2626',
    ORANGE:     '#ea580c',
    GREEN:      '#16a34a',
    BLUE:       '#2563eb',
    PURPLE:     '#7c3aed',
    CODE_BG:    '#f8fafc',
    TABLE_HEAD: '#1e40af',
    TABLE_ALT:  '#eff6ff'
  };
  
  // Bersihkan body default
  body.clear();
  
  // ==========================================
  // 1. HALAMAN JUDUL / COVER
  // ==========================================
  writeCoverPage_(body, COLORS);
  body.appendPageBreak();
  
  // ==========================================
  // 2. DAFTAR ISI
  // ==========================================
  writeDaftarIsi_(body, COLORS);
  body.appendPageBreak();
  
  // ==========================================
  // 3. BAB 1 — PENDAHULUAN
  // ==========================================
  writePendahuluan_(body, COLORS);
  body.appendPageBreak();
  
  // ==========================================
  // 4. BAB 2 — ARSITEKTUR SISTEM
  // ==========================================
  writeArsitektur_(body, COLORS);
  body.appendPageBreak();
  
  // ==========================================
  // 5. BAB 3 — DESAIN DATABASE
  // ==========================================
  writeDatabase_(body, COLORS);
  body.appendPageBreak();
  
  // ==========================================
  // 6. BAB 4 — IMPLEMENTASI FITUR
  // ==========================================
  writeImplementasiFitur_(body, COLORS);
  body.appendPageBreak();
  
  // ==========================================
  // 7. BAB 5 — ENDPOINT API
  // ==========================================
  writeEndpointAPI_(body, COLORS);
  body.appendPageBreak();
  
  // ==========================================
  // 8. BAB 6 — KEAMANAN SISTEM
  // ==========================================
  writeKeamanan_(body, COLORS);
  body.appendPageBreak();
  
  // ==========================================
  // 9. BAB 7 — ALGORITMA SAW
  // ==========================================
  writeAlgoritmaSAW_(body, COLORS);
  body.appendPageBreak();
  
  // ==========================================
  // 10. BAB 8 — PENGUJIAN SISTEM
  // ==========================================
  writePengujian_(body, COLORS);
  body.appendPageBreak();
  
  // ==========================================
  // 11. BAB 9 — PANDUAN DEPLOYMENT
  // ==========================================
  writeDeployment_(body, COLORS);
  
  // Simpan
  doc.saveAndClose();
  
  Logger.log('✅ Dokumentasi Google Docs berhasil dibuat!');
  Logger.log('📄 Buka: ' + doc.getUrl());
  Logger.log('🔑 ID: ' + doc.getId());
}


// ============================================================
// HELPER FUNCTIONS
// ============================================================

/**
 * Membuat heading level 1 (judul bab)
 */
function h1_(body, text, color) {
  var para = body.appendParagraph(text);
  para.setHeading(DocumentApp.ParagraphHeading.HEADING1);
  para.setForegroundColor(color || '#1e293b');
  para.setSpacingBefore(20);
  para.setSpacingAfter(10);
  return para;
}

/**
 * Membuat heading level 2 (sub-bab)
 */
function h2_(body, text, color) {
  var para = body.appendParagraph(text);
  para.setHeading(DocumentApp.ParagraphHeading.HEADING2);
  para.setForegroundColor(color || '#1e40af');
  para.setSpacingBefore(16);
  para.setSpacingAfter(8);
  return para;
}

/**
 * Membuat heading level 3 (sub-sub-bab)
 */
function h3_(body, text, color) {
  var para = body.appendParagraph(text);
  para.setHeading(DocumentApp.ParagraphHeading.HEADING3);
  para.setForegroundColor(color || '#4338ca');
  para.setSpacingBefore(12);
  para.setSpacingAfter(6);
  return para;
}

/**
 * Membuat paragraf normal
 */
function p_(body, text) {
  var para = body.appendParagraph(text);
  para.setLineSpacing(1.5);
  para.setSpacingAfter(6);
  return para;
}

/**
 * Membuat paragraf bold
 */
function pBold_(body, text) {
  var para = body.appendParagraph(text);
  para.setBold(true);
  para.setSpacingAfter(4);
  return para;
}

/**
 * Membuat bullet list item
 */
function bullet_(body, text) {
  var item = body.appendListItem(text);
  item.setGlyphType(DocumentApp.GlyphType.BULLET);
  item.setLineSpacing(1.4);
  return item;
}

/**
 * Membuat numbered list item
 */
function numbered_(body, text, nestingLevel) {
  var item = body.appendListItem(text);
  item.setGlyphType(DocumentApp.GlyphType.NUMBER);
  item.setLineSpacing(1.4);
  if (nestingLevel) item.setNestingLevel(nestingLevel);
  return item;
}

/**
 * Membuat blok kode (monospace, background abu)
 */
function code_(body, text) {
  var para = body.appendParagraph(text);
  para.editAsText().setFontFamily('Courier New');
  para.editAsText().setFontSize(9);
  para.editAsText().setForegroundColor('#1e293b');
  para.setBackgroundColor('#f1f5f9');
  para.setSpacingBefore(4);
  para.setSpacingAfter(4);
  para.setIndentStart(36);
  return para;
}

/**
 * Membuat tabel dengan header berwarna
 */
function table_(body, headers, rows, headerBg, altBg) {
  headerBg = headerBg || '#1e40af';
  altBg = altBg || '#eff6ff';
  
  var allRows = [headers].concat(rows);
  var table = body.appendTable(allRows);
  
  // Style header row
  var headerRow = table.getRow(0);
  for (var c = 0; c < headers.length; c++) {
    var cell = headerRow.getCell(c);
    cell.setBackgroundColor(headerBg);
    cell.editAsText().setForegroundColor('#ffffff');
    cell.editAsText().setBold(true);
    cell.editAsText().setFontSize(10);
    cell.setPaddingTop(6);
    cell.setPaddingBottom(6);
  }
  
  // Style data rows (alternating)
  for (var r = 1; r < table.getNumRows(); r++) {
    var row = table.getRow(r);
    var bg = (r % 2 === 0) ? altBg : '#ffffff';
    for (var c = 0; c < row.getNumCells(); c++) {
      var cell = row.getCell(c);
      cell.setBackgroundColor(bg);
      cell.editAsText().setFontSize(9);
      cell.setPaddingTop(4);
      cell.setPaddingBottom(4);
    }
  }
  
  body.appendParagraph(''); // spacer
  return table;
}

/**
 * Membuat garis pemisah
 */
function hr_(body) {
  body.appendHorizontalRule();
}


// ============================================================
// SECTION WRITERS
// ============================================================

// ==========================================
// 1. COVER PAGE
// ==========================================
function writeCoverPage_(body, C) {
  // Spasi atas
  body.appendParagraph('').setSpacingBefore(100);
  
  var title = body.appendParagraph('DOKUMENTASI TEKNIS LENGKAP');
  title.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  title.editAsText().setFontSize(28);
  title.editAsText().setBold(true);
  title.editAsText().setForegroundColor(C.PRIMARY);
  
  body.appendParagraph('');
  
  var subtitle = body.appendParagraph('Sistem Informasi Absensi Guru Menggunakan QR Code\ndan Penilaian Siswa Berbasis Web\ndengan Metode SAW');
  subtitle.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  subtitle.editAsText().setFontSize(16);
  subtitle.editAsText().setForegroundColor(C.DARK);
  
  body.appendParagraph('');
  
  var school = body.appendParagraph('SMPN 4 Purwakarta');
  school.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  school.editAsText().setFontSize(18);
  school.editAsText().setBold(true);
  school.editAsText().setForegroundColor(C.SECONDARY);
  
  body.appendParagraph('').setSpacingBefore(40);
  hr_(body);
  body.appendParagraph('').setSpacingBefore(20);
  
  var info = [
    ['Peneliti',        'Muhammad Rifky Akbar'],
    ['Program Studi',   'Teknik Informatika'],
    ['Framework',       'Laravel 12 (PHP ≥ 8.2)'],
    ['Database',        'MySQL 8.0'],
    ['Frontend',        'Tailwind CSS 4.0, Alpine.js, Chart.js'],
    ['Versi Dokumen',   'v1.0 — ' + Utilities.formatDate(new Date(), 'Asia/Jakarta', 'dd MMMM yyyy')]
  ];
  
  table_(body, ['Item', 'Detail'], info, C.DARK, '#f8fafc');
}

// ==========================================
// 2. DAFTAR ISI
// ==========================================
function writeDaftarIsi_(body, C) {
  h1_(body, 'DAFTAR ISI', C.DARK);
  hr_(body);
  
  var toc = [
    'BAB 1 — Pendahuluan .............................. 3',
    '  1.1 Latar Belakang Sistem',
    '  1.2 Ruang Lingkup',
    '  1.3 Teknologi yang Digunakan',
    '  1.4 Aktor / Peran Pengguna',
    '',
    'BAB 2 — Arsitektur Sistem ........................ 4',
    '  2.1 Pola Arsitektur MVC',
    '  2.2 Struktur Direktori',
    '  2.3 Flow Request-Response',
    '  2.4 Design Pattern yang Diterapkan',
    '',
    'BAB 3 — Desain Database .......................... 5',
    '  3.1 Entity Relationship Diagram',
    '  3.2 Tabel dan Relasi',
    '  3.3 Polymorphic Relationship',
    '  3.4 Normalisasi',
    '',
    'BAB 4 — Implementasi Fitur ....................... 6',
    '  4.1 Autentikasi & Otorisasi',
    '  4.2 Presensi QR Code dengan Geolokasi',
    '  4.3 Mode Kiosk',
    '  4.4 Manajemen Nilai',
    '  4.5 Ekspor Laporan',
    '  4.6 Pengaturan Sistem',
    '  4.7 Notifikasi',
    '  4.8 Dashboard Analytics',
    '',
    'BAB 5 — Endpoint API ............................. 7',
    '  5.1 Route Groups & Middleware',
    '  5.2 Daftar Semua Endpoint',
    '',
    'BAB 6 — Keamanan Sistem .......................... 8',
    '  6.1 Proteksi CSRF',
    '  6.2 Enkripsi QR Code (AES-256-CBC)',
    '  6.3 Validasi Geolokasi (Haversine)',
    '  6.4 RBAC (Role-Based Access Control)',
    '  6.5 Sanitasi Input & Proteksi SQL Injection',
    '  6.6 Password Hashing (Bcrypt)',
    '',
    'BAB 7 — Algoritma SAW ........................... 9',
    '  7.1 Definisi Kriteria',
    '  7.2 Matriks Keputusan',
    '  7.3 Normalisasi Matriks',
    '  7.4 Perhitungan Nilai Preferensi',
    '  7.5 Perankingan',
    '  7.6 Contoh Perhitungan Manual',
    '',
    'BAB 8 — Pengujian Sistem ........................ 10',
    '  8.1 Black Box Testing',
    '  8.2 White Box Testing',
    '  8.3 User Acceptance Testing (UAT)',
    '  8.4 Evaluasi Prototype',
    '',
    'BAB 9 — Panduan Deployment ....................... 11',
    '  9.1 Persyaratan Server',
    '  9.2 Langkah Instalasi',
    '  9.3 Konfigurasi Environment',
    '  9.4 Menjalankan Sistem'
  ];
  
  toc.forEach(function(line) {
    if (line === '') {
      body.appendParagraph('');
    } else if (line.startsWith('BAB')) {
      pBold_(body, line);
    } else {
      var item = body.appendParagraph(line);
      item.editAsText().setFontSize(10);
      item.editAsText().setForegroundColor('#475569');
      item.setIndentStart(20);
    }
  });
}

// ==========================================
// 3. BAB 1 — PENDAHULUAN
// ==========================================
function writePendahuluan_(body, C) {
  h1_(body, 'BAB 1 — PENDAHULUAN', C.PRIMARY);
  hr_(body);
  
  // 1.1
  h2_(body, '1.1 Latar Belakang Sistem');
  p_(body, 'Sistem Informasi Absensi Guru Menggunakan QR Code dan Penilaian Siswa Berbasis Web dengan Metode Simple Additive Weighting (SAW) dikembangkan untuk SMPN 4 Purwakarta guna mengatasi permasalahan pencatatan kehadiran guru yang masih manual dan penilaian siswa yang belum terstandarisasi.');
  p_(body, 'Sistem ini mengintegrasikan teknologi QR Code dinamis yang berubah setiap 10 menit untuk presensi guru dengan validasi geolokasi, serta metode SAW untuk melakukan perankingan siswa dan guru berdasarkan kriteria yang telah ditetapkan.');
  p_(body, 'Metode pengembangan yang digunakan adalah Prototype, yang terdiri dari 7 tahapan: (1) Mendengarkan Pelanggan, (2) Merancang dan Membuat Prototype, (3) Evaluasi Prototype, (4) Mengkodekan Sistem, (5) Menguji Sistem, (6) Evaluasi Sistem, dan (7) Menggunakan Sistem.');
  
  // 1.2
  h2_(body, '1.2 Ruang Lingkup');
  p_(body, 'Sistem ini mencakup modul-modul berikut:');
  
  var modules = [
    'Autentikasi & Otorisasi — Login berbasis session dengan 4 role pengguna',
    'Presensi Guru — QR Code dinamis (AES-256-CBC) dengan validasi geolokasi (Haversine, radius 100m)',
    'Mode Kiosk — Layar monitor di ruang guru untuk menampilkan QR Code tanpa perlu login',
    'Manajemen Data — CRUD untuk guru, siswa, kelas, mata pelajaran, tahun ajaran, penugasan guru-mapel',
    'Manajemen Nilai — Input nilai harian, UTS, UAS dengan perhitungan otomatis nilai akhir dan predikat',
    'Penilaian SAW — Perankingan siswa (C1-C4) dan guru (K1-K4) dengan bobot kriteria yang dapat diatur',
    'Laporan & Ekspor — Export data ke Excel (.xlsx) dan PDF menggunakan Maatwebsite/Excel & DomPDF',
    'Dashboard Analytics — Statistik real-time dengan visualisasi Chart.js (doughnut, line, bar)',
    'Pengaturan Sistem — 24 parameter konfigurasi dalam 5 grup (sekolah, umum, tampilan, notifikasi, sistem)',
    'Notifikasi — Notifikasi personal dan broadcast dengan penanda baca/tidak baca',
    'Multi-bahasa — Mendukung Bahasa Indonesia dan Bahasa Inggris'
  ];
  modules.forEach(function(m) { bullet_(body, m); });
  
  // 1.3
  h2_(body, '1.3 Teknologi yang Digunakan');
  
  table_(body, 
    ['Kategori', 'Teknologi', 'Versi', 'Keterangan'],
    [
      ['Backend Framework',  'Laravel',         '12',    'Framework PHP MVC dengan Eloquent ORM, Blade templating'],
      ['Bahasa Pemrograman', 'PHP',             '≥ 8.2', 'Dengan fitur typed properties, enums, match expression'],
      ['Database',           'MySQL',           '8.0+',  'RDBMS dengan foreign key, index, unique constraint'],
      ['CSS Framework',      'Tailwind CSS',    '4.0',   'Utility-first CSS framework dengan Just-in-Time compiler'],
      ['JavaScript',         'Alpine.js',       '3.x',   'Reactive framework ringan untuk interaktivitas'],
      ['Visualisasi',        'Chart.js',        '4.x',   'Library chart untuk dashboard analytics'],
      ['Build Tool',         'Vite',            '5.4',   'Build tool untuk asset bundling (CSS/JS)'],
      ['QR Code',            'Simple QrCode',   '4.x',   'Generator QR Code berbasis BaconQrCode'],
      ['Enkripsi',           'OpenSSL',         '-',     'AES-256-CBC untuk enkripsi payload QR Code'],
      ['Export Excel',       'Maatwebsite/Excel','3.1',  'Export data ke format .xlsx'],
      ['Export PDF',         'Barryvdh/DomPDF', '3.1',   'Export data ke format .pdf'],
      ['Geolokasi',          'HTML5 Geolocation','-',    'API browser untuk mendapatkan koordinat GPS'],
    ],
    C.TABLE_HEAD, C.TABLE_ALT
  );
  
  // 1.4
  h2_(body, '1.4 Aktor / Peran Pengguna');
  p_(body, 'Sistem memiliki 4 peran pengguna (role) yang masing-masing memiliki hak akses berbeda:');
  
  table_(body,
    ['Role', 'Deskripsi', 'Hak Akses Utama'],
    [
      ['Admin',           'Administrator sekolah',         'Full access: kelola semua data, laporan, pengaturan, kriteria SAW, cetak laporan'],
      ['Guru',            'Tenaga pengajar',               'Presensi via QR + geolokasi, input nilai, lihat kelas & riwayat kehadiran'],
      ['Kepala Sekolah',  'Pimpinan sekolah',              'Lihat dashboard, monitoring presensi, akses perhitungan SAW & rapor siswa'],
      ['Kiosk Presensi',  'Akun untuk layar monitor kiosk', 'Menampilkan dashboard kiosk dengan daftar guru & QR Code masing-masing'],
    ],
    C.DARK, '#f0fdf4'
  );
}

// ==========================================
// 4. BAB 2 — ARSITEKTUR SISTEM
// ==========================================
function writeArsitektur_(body, C) {
  h1_(body, 'BAB 2 — ARSITEKTUR SISTEM', C.PRIMARY);
  hr_(body);
  
  // 2.1
  h2_(body, '2.1 Pola Arsitektur MVC (Model-View-Controller)');
  p_(body, 'Sistem dibangun menggunakan pola arsitektur MVC yang memisahkan logika bisnis, presentasi, dan kontrol alur aplikasi:');
  
  table_(body,
    ['Layer', 'Implementasi', 'Lokasi', 'Tanggung Jawab'],
    [
      ['Model',      'Eloquent ORM',     'app/Models/',                'Representasi tabel database, relasi antar tabel, business logic (scope, accessor, mutator)'],
      ['View',       'Blade Template',    'resources/views/',           'Tampilan HTML dengan Tailwind CSS, Alpine.js untuk interaktivitas'],
      ['Controller', 'HTTP Controller',   'app/Http/Controllers/',      'Menerima HTTP request, validasi input, memanggil Model/Service, return response'],
      ['Service',    'Service Class',     'app/Services/',              'Logika bisnis kompleks (SAW calculation, notification dispatch)'],
      ['Middleware',  'Request Filter',   'app/Http/Middleware/',       'Filter request sebelum masuk controller (auth, role check)'],
      ['Route',      'Web Routes',        'routes/web.php',            'Pemetaan URL ke method controller dengan middleware group'],
    ],
    C.TABLE_HEAD, C.TABLE_ALT
  );
  
  // 2.2
  h2_(body, '2.2 Struktur Direktori Utama');
  
  var dirs = [
    ['app/Models/ (15 file)',           'Model Eloquent: User, Role, Teacher, Student, Attendance, ClassRoom, Subject, TeacherSubject, Grade, Criteria, StudentAssessment, TeacherAssessment, AcademicYear, Setting, Notification'],
    ['app/Http/Controllers/ (19 file)', 'Controller: Auth, Dashboard, Teacher, Student, User, Attendance, Kiosk, Grade, SAW, Criteria, Report, Setting, Profile, ClassRoom, Subject, AcademicYear, TeacherSubject, Notification, Language'],
    ['app/Services/ (2 file)',          'SAWService (perhitungan SAW), NotificationService (pengiriman notifikasi)'],
    ['app/Http/Middleware/',             'CheckRole middleware untuk RBAC'],
    ['app/Exports/',                     'Export class untuk Excel/PDF (AttendanceExport, GradeExport, StudentExport, TeacherExport)'],
    ['app/Helpers/',                     'Helper functions (SettingHelper untuk akses konfigurasi)'],
    ['database/migrations/ (18 file)',  'File migrasi untuk 18 tabel database'],
    ['database/seeders/',               'Seeder untuk data awal (roles, admin user, sample data)'],
    ['resources/views/',                'Blade template terorganisir per modul (layouts, auth, dashboard, teachers, students, dll.)'],
    ['routes/web.php',                  'Seluruh route definition (150+ endpoint)'],
    ['config/',                          'Konfigurasi Laravel (database, auth, session, excel, filesystems)'],
    ['public/build/',                   'Compiled assets dari Vite (CSS & JS)'],
  ];
  
  table_(body, ['Direktori', 'Isi / Penjelasan'], dirs, '#334155', '#f8fafc');
  
  // 2.3
  h2_(body, '2.3 Flow Request-Response');
  p_(body, 'Berikut alur pemrosesan setiap HTTP request dalam sistem:');
  
  numbered_(body, 'Browser mengirim HTTP Request (GET/POST/PUT/DELETE) ke URL tertentu');
  numbered_(body, 'Laravel Router (routes/web.php) mencocokkan URL dengan route definition');
  numbered_(body, 'Middleware dijalankan secara berurutan: (a) Session middleware, (b) Auth middleware (cek login), (c) CheckRole middleware (cek hak akses role)');
  numbered_(body, 'Jika middleware lolos, request diteruskan ke Controller method yang sesuai');
  numbered_(body, 'Controller melakukan validasi input menggunakan $request->validate()');
  numbered_(body, 'Controller memanggil Model (Eloquent) atau Service untuk proses logika bisnis');
  numbered_(body, 'Model berinteraksi dengan database MySQL melalui Eloquent Query Builder');
  numbered_(body, 'Controller mengembalikan response: (a) Blade View untuk halaman HTML, (b) JSON response untuk API endpoint, (c) Redirect untuk form submission');
  
  body.appendParagraph('');
  
  // 2.4
  h2_(body, '2.4 Design Pattern yang Diterapkan');
  
  table_(body,
    ['Pattern', 'Implementasi', 'Penjelasan'],
    [
      ['MVC',                   'Seluruh aplikasi',              'Pemisahan Model (data), View (tampilan), Controller (logika kontrol)'],
      ['Repository Pattern',    'Eloquent Model',                'Model sebagai abstraksi akses data, query builder menggantikan raw SQL'],
      ['Service Layer',         'SAWService, NotificationService','Pemisahan logika bisnis kompleks dari controller ke service class'],
      ['Middleware Pattern',    'CheckRole, Auth',               'Filter chain yang memproses request sebelum mencapai controller'],
      ['Observer Pattern',      'Notification broadcast',         'Event-driven notification ke multiple user'],
      ['Strategy Pattern',      'SAW benefit/cost normalization','Strategi normalisasi berbeda berdasarkan tipe kriteria'],
      ['Polymorphic Relations', 'Attendance model',              'Satu tabel attendances melayani teacher & student via morphTo'],
      ['Singleton Pattern',     'Setting cache',                 'Cache konfigurasi sistem dengan key tunggal selama 3600 detik'],
      ['Factory Pattern',       'Laravel Service Container',     'Dependency injection otomatis oleh Laravel IoC Container'],
    ],
    C.TABLE_HEAD, C.TABLE_ALT
  );
}

// ==========================================
// 5. BAB 3 — DESAIN DATABASE
// ==========================================
function writeDatabase_(body, C) {
  h1_(body, 'BAB 3 — DESAIN DATABASE', C.PRIMARY);
  hr_(body);
  
  // 3.1
  h2_(body, '3.1 Entity Relationship Diagram');
  p_(body, 'Database sistem terdiri dari 18 tabel yang saling berelasi. Berikut ringkasan entitas utama dan kardinalitas relasinya:');
  
  table_(body,
    ['Entitas 1', 'Relasi', 'Entitas 2', 'Keterangan'],
    [
      ['roles',              '1 → N',     'users',               'Satu role memiliki banyak user'],
      ['users',              '1 → 1',     'teachers',            'Satu user mengajar paling banyak satu data guru'],
      ['classes',            '1 → N',     'students',            'Satu kelas memiliki banyak siswa'],
      ['teachers',           'N → N',     'subjects (via teacher_subjects)', 'Guru mengajar banyak mapel, mapel diajar banyak guru'],
      ['teachers',           '1 → N',     'attendances (polymorphic)', 'Satu guru memiliki banyak record kehadiran'],
      ['students',           '1 → N',     'attendances (polymorphic)', 'Satu siswa memiliki banyak record kehadiran'],
      ['students',           '1 → N',     'grades',              'Satu siswa memiliki banyak nilai'],
      ['subjects',           '1 → N',     'grades',              'Satu mapel memiliki banyak record nilai'],
      ['teachers',           '1 → N',     'grades',              'Satu guru memberi banyak nilai'],
      ['students',           '1 → N',     'student_assessments', 'Satu siswa memiliki banyak hasil penilaian SAW'],
      ['teachers',           '1 → N',     'teacher_assessments', 'Satu guru memiliki banyak hasil penilaian SAW'],
      ['users',              '1 → N',     'notifications',       'Satu user memiliki banyak notifikasi (null = broadcast)'],
    ],
    C.TABLE_HEAD, C.TABLE_ALT
  );
  
  // 3.2
  h2_(body, '3.2 Daftar Tabel dan Kolom');
  
  // -- users --
  h3_(body, 'Tabel: users');
  table_(body, ['Kolom', 'Tipe', 'Constraint', 'Keterangan'],
    [
      ['id',            'BIGINT UNSIGNED', 'PK, AUTO_INCREMENT', 'Primary key'],
      ['name',          'VARCHAR(255)',    'NOT NULL',            'Nama lengkap pengguna'],
      ['email',         'VARCHAR(255)',    'UNIQUE, NOT NULL',    'Email untuk login'],
      ['role_id',       'BIGINT UNSIGNED', 'FK → roles.id',      'Foreign key ke tabel roles'],
      ['password',      'VARCHAR(255)',    'NOT NULL',            'Password ter-hash (Bcrypt)'],
      ['profile_photo', 'VARCHAR(255)',    'NULLABLE',            'Path foto profil'],
      ['created_at',    'TIMESTAMP',       'NULLABLE',            'Waktu pembuatan'],
      ['updated_at',    'TIMESTAMP',       'NULLABLE',            'Waktu update terakhir'],
    ],
    '#1e40af', '#eff6ff'
  );
  
  // -- roles --
  h3_(body, 'Tabel: roles');
  table_(body, ['Kolom', 'Tipe', 'Constraint', 'Keterangan'],
    [
      ['id',          'BIGINT UNSIGNED', 'PK, AUTO_INCREMENT', 'Primary key'],
      ['name',        'VARCHAR(255)',    'NOT NULL',            'Nama role (Admin, Guru, Kepala Sekolah, Kiosk Presensi)'],
      ['description', 'TEXT',            'NULLABLE',            'Deskripsi role'],
    ],
    '#1e40af', '#eff6ff'
  );
  
  // -- teachers --
  h3_(body, 'Tabel: teachers');
  table_(body, ['Kolom', 'Tipe', 'Constraint', 'Keterangan'],
    [
      ['id',              'BIGINT UNSIGNED', 'PK, AUTO_INCREMENT',     'Primary key'],
      ['user_id',         'BIGINT UNSIGNED', 'FK → users.id',          'Relasi ke akun user'],
      ['nip',             'VARCHAR(255)',    'UNIQUE',                  'Nomor Induk Pegawai'],
      ['name',            'VARCHAR(255)',    'NOT NULL',                'Nama lengkap guru'],
      ['gender',          'ENUM(L,P)',       'NOT NULL',                'Jenis kelamin'],
      ['phone',           'VARCHAR(20)',     'NULLABLE',                'Nomor telepon'],
      ['address',         'TEXT',            'NULLABLE',                'Alamat rumah'],
      ['birth_date',      'DATE',            'NULLABLE',                'Tanggal lahir'],
      ['photo',           'VARCHAR(255)',    'NULLABLE',                'Path foto guru'],
      ['education_level', 'VARCHAR(50)',     'NULLABLE',                'Jenjang pendidikan terakhir'],
      ['position',        'VARCHAR(100)',    'NULLABLE',                'Jabatan'],
      ['status',          'VARCHAR(20)',     'DEFAULT aktif',           'Status: aktif/nonaktif'],
    ],
    '#1e40af', '#eff6ff'
  );
  
  // -- students --
  h3_(body, 'Tabel: students');
  table_(body, ['Kolom', 'Tipe', 'Constraint', 'Keterangan'],
    [
      ['id',           'BIGINT UNSIGNED', 'PK, AUTO_INCREMENT',  'Primary key'],
      ['class_id',     'BIGINT UNSIGNED', 'FK → classes.id',     'Kelas siswa'],
      ['nisn',         'VARCHAR(20)',     'UNIQUE',               'Nomor Induk Siswa Nasional'],
      ['nis',          'VARCHAR(20)',     'UNIQUE',               'Nomor Induk Sekolah'],
      ['name',         'VARCHAR(255)',    'NOT NULL',             'Nama lengkap siswa'],
      ['gender',       'ENUM(L,P)',       'NOT NULL',             'Jenis kelamin'],
      ['phone',        'VARCHAR(20)',     'NULLABLE',             'Nomor telepon'],
      ['address',      'TEXT',            'NULLABLE',             'Alamat rumah'],
      ['birth_date',   'DATE',            'NULLABLE',             'Tanggal lahir'],
      ['birth_place',  'VARCHAR(100)',    'NULLABLE',             'Tempat lahir'],
      ['photo',        'VARCHAR(255)',    'NULLABLE',             'Path foto siswa'],
      ['parent_name',  'VARCHAR(255)',    'NULLABLE',             'Nama orang tua/wali'],
      ['parent_phone', 'VARCHAR(20)',     'NULLABLE',             'Nomor telepon orang tua'],
      ['status',       'VARCHAR(20)',     'DEFAULT aktif',        'Status: aktif/nonaktif/lulus/pindah'],
    ],
    '#1e40af', '#eff6ff'
  );
  
  // -- attendances --
  h3_(body, 'Tabel: attendances (Polymorphic)');
  p_(body, 'Tabel ini menggunakan polymorphic relationship sehingga satu tabel dapat menyimpan kehadiran guru maupun siswa. Kolom attendable_type menyimpan nama model (App\\Models\\Teacher atau App\\Models\\Student) dan attendable_id menyimpan ID dari model tersebut.');
  table_(body, ['Kolom', 'Tipe', 'Constraint', 'Keterangan'],
    [
      ['id',              'BIGINT UNSIGNED', 'PK, AUTO_INCREMENT', 'Primary key'],
      ['attendable_type', 'VARCHAR(255)',    'NOT NULL',            'Model class (Teacher/Student)'],
      ['attendable_id',   'BIGINT UNSIGNED', 'NOT NULL',            'ID dari model terkait'],
      ['date',            'DATE',            'NOT NULL',            'Tanggal kehadiran'],
      ['check_in',        'TIME',            'NULLABLE',            'Waktu masuk'],
      ['check_out',       'TIME',            'NULLABLE',            'Waktu pulang'],
      ['status',          'VARCHAR(20)',     'NOT NULL',            'hadir/izin/sakit/alfa'],
      ['latitude_in',     'DECIMAL(10,7)',   'NULLABLE',            'Latitude saat check-in'],
      ['longitude_in',    'DECIMAL(10,7)',   'NULLABLE',            'Longitude saat check-in'],
      ['latitude_out',    'DECIMAL(10,7)',   'NULLABLE',            'Latitude saat check-out'],
      ['longitude_out',   'DECIMAL(10,7)',   'NULLABLE',            'Longitude saat check-out'],
      ['qr_code',         'TEXT',            'NULLABLE',            'QR payload yang di-scan'],
      ['notes',           'TEXT',            'NULLABLE',            'Catatan tambahan'],
    ],
    '#1e40af', '#eff6ff'
  );
  
  // -- grades --
  h3_(body, 'Tabel: grades');
  table_(body, ['Kolom', 'Tipe', 'Constraint', 'Keterangan'],
    [
      ['id',           'BIGINT UNSIGNED', 'PK, AUTO_INCREMENT',                              'Primary key'],
      ['student_id',   'BIGINT UNSIGNED', 'FK → students.id',                               'Siswa yang dinilai'],
      ['subject_id',   'BIGINT UNSIGNED', 'FK → subjects.id',                               'Mata pelajaran'],
      ['teacher_id',   'BIGINT UNSIGNED', 'FK → teachers.id',                               'Guru penilai'],
      ['semester',     'VARCHAR(10)',     'NOT NULL',                                         'Semester (Ganjil/Genap)'],
      ['academic_year','VARCHAR(20)',     'NOT NULL',                                         'Tahun ajaran (2024/2025)'],
      ['daily_test',   'DECIMAL(5,2)',    'DEFAULT 0',                                       'Nilai ulangan harian'],
      ['midterm_exam', 'DECIMAL(5,2)',    'DEFAULT 0',                                       'Nilai UTS'],
      ['final_exam',   'DECIMAL(5,2)',    'DEFAULT 0',                                       'Nilai UAS'],
      ['final_grade',  'DECIMAL(5,2)',    'DEFAULT 0',                                       'Nilai akhir (hitung otomatis)'],
      ['behavior_score','DECIMAL(5,2)',   'DEFAULT 0',                                       'Nilai sikap'],
      ['skill_score',  'DECIMAL(5,2)',    'DEFAULT 0',                                       'Nilai keterampilan'],
      ['notes',        'TEXT',            'NULLABLE',                                        'Catatan guru'],
    ],
    '#1e40af', '#eff6ff'
  );
  p_(body, 'Unique constraint: UNIQUE(student_id, subject_id, semester, academic_year) — satu siswa hanya boleh punya satu nilai per mapel per semester per tahun ajaran.');
  
  // -- criteria --
  h3_(body, 'Tabel: criteria');
  table_(body, ['Kolom', 'Tipe', 'Constraint', 'Keterangan'],
    [
      ['id',          'BIGINT UNSIGNED', 'PK, AUTO_INCREMENT', 'Primary key'],
      ['code',        'VARCHAR(10)',     'UNIQUE, NOT NULL',    'Kode kriteria (C1, C2, K1, K2, dst.)'],
      ['name',        'VARCHAR(255)',    'NOT NULL',            'Nama kriteria'],
      ['type',        'ENUM(benefit,cost)','NOT NULL',          'Jenis: benefit (max) atau cost (min)'],
      ['weight',      'DECIMAL(5,4)',    'NOT NULL',            'Bobot kriteria (desimal, total harus 1.0)'],
      ['for',         'ENUM(student,teacher)','NOT NULL',       'Untuk penilaian siswa atau guru'],
      ['description', 'TEXT',            'NULLABLE',            'Deskripsi kriteria'],
    ],
    '#1e40af', '#eff6ff'
  );
  
  // -- student_assessments & teacher_assessments --
  h3_(body, 'Tabel: student_assessments');
  table_(body, ['Kolom', 'Tipe', 'Constraint', 'Keterangan'],
    [
      ['id',               'BIGINT UNSIGNED', 'PK', 'Primary key'],
      ['student_id',       'BIGINT UNSIGNED', 'FK → students.id', 'Siswa yang dinilai'],
      ['class_id',         'BIGINT UNSIGNED', 'FK → classes.id',  'Kelas saat dinilai'],
      ['semester',         'VARCHAR(10)',     'NOT NULL',           'Semester'],
      ['academic_year',    'VARCHAR(20)',     'NOT NULL',           'Tahun ajaran'],
      ['academic_score',   'DECIMAL(8,4)',    'DEFAULT 0',         'Skor aspek akademik'],
      ['attendance_score', 'DECIMAL(8,4)',    'DEFAULT 0',         'Skor aspek kehadiran'],
      ['behavior_score',   'DECIMAL(8,4)',    'DEFAULT 0',         'Skor aspek sikap'],
      ['skill_score',      'DECIMAL(8,4)',    'DEFAULT 0',         'Skor aspek keterampilan'],
      ['saw_score',        'DECIMAL(8,4)',    'DEFAULT 0',         'Nilai preferensi SAW (Vi)'],
      ['rank',             'INT',             'NULLABLE',           'Ranking hasil SAW'],
    ],
    '#1e40af', '#eff6ff'
  );
  
  h3_(body, 'Tabel: teacher_assessments');
  table_(body, ['Kolom', 'Tipe', 'Constraint', 'Keterangan'],
    [
      ['id',                  'BIGINT UNSIGNED', 'PK', 'Primary key'],
      ['teacher_id',          'BIGINT UNSIGNED', 'FK → teachers.id', 'Guru yang dinilai'],
      ['period',              'VARCHAR(50)',     'NOT NULL',           'Periode penilaian'],
      ['academic_year',       'VARCHAR(20)',     'NOT NULL',           'Tahun ajaran'],
      ['attendance_score',    'DECIMAL(8,4)',    'DEFAULT 0',         'Skor kehadiran'],
      ['teaching_quality',    'DECIMAL(8,4)',    'DEFAULT 0',         'Skor kualitas mengajar'],
      ['student_achievement', 'DECIMAL(8,4)',    'DEFAULT 0',         'Skor prestasi siswa'],
      ['discipline_score',    'DECIMAL(8,4)',    'DEFAULT 0',         'Skor kedisiplinan'],
      ['saw_score',           'DECIMAL(8,4)',    'DEFAULT 0',         'Nilai preferensi SAW (Vi)'],
      ['rank',                'INT',             'NULLABLE',           'Ranking hasil SAW'],
      ['notes',               'TEXT',            'NULLABLE',           'Catatan penilaian'],
    ],
    '#1e40af', '#eff6ff'
  );
  
  // -- remaining tables summary --
  h3_(body, 'Tabel Pendukung Lainnya');
  table_(body, ['Tabel', 'Kolom Utama', 'Keterangan'],
    [
      ['classes',          'id, name, grade, academic_year, capacity',                'Data kelas (VII-A, VIII-B, dst.)'],
      ['subjects',         'id, code, name, description',                             'Data mata pelajaran'],
      ['teacher_subjects', 'id, teacher_id, subject_id, class_id, academic_year',     'Penugasan guru ke mapel & kelas (pivot table)'],
      ['academic_years',   'id, year, semester, start_date, end_date, is_active',     'Tahun ajaran dengan toggle aktif/nonaktif'],
      ['settings',         'id, key, value, type, group, description',                'Konfigurasi sistem key-value (24 parameter)'],
      ['notifications',    'id, user_id, type, icon, title, message, link, is_read', 'Notifikasi personal & broadcast'],
      ['cache',            'key, value, expiration',                                   'Laravel cache storage'],
      ['jobs',             'id, queue, payload, attempts',                             'Laravel queue jobs'],
      ['sessions',         'id, user_id, ip_address, user_agent, payload, last_activity', 'Session data pengguna'],
    ],
    '#334155', '#f8fafc'
  );
  
  // 3.3
  h2_(body, '3.3 Polymorphic Relationship (Attendance)');
  p_(body, 'Sistem menggunakan Polymorphic Relationship pada tabel attendances untuk menyimpan kehadiran guru dan siswa dalam satu tabel. Ini menghindari duplikasi struktur tabel dan memudahkan query lintas tipe.');
  p_(body, 'Cara kerja:');
  bullet_(body, 'Kolom attendable_type menyimpan namespace model: "App\\Models\\Teacher" atau "App\\Models\\Student"');
  bullet_(body, 'Kolom attendable_id menyimpan primary key dari model terkait');
  bullet_(body, 'Eloquent secara otomatis resolve relasi dengan method morphTo() di model Attendance');
  bullet_(body, 'Model Teacher dan Student mendefinisikan morphMany(Attendance::class, \'attendable\')');
  
  code_(body, '// Model Attendance');
  code_(body, 'public function attendable() {');
  code_(body, '    return $this->morphTo();');
  code_(body, '}');
  body.appendParagraph('');
  code_(body, '// Model Teacher');
  code_(body, 'public function attendances() {');
  code_(body, '    return $this->morphMany(Attendance::class, \'attendable\');');
  code_(body, '}');
  
  // 3.4
  h2_(body, '3.4 Normalisasi Database');
  p_(body, 'Seluruh tabel dalam sistem telah memenuhi Normal Form ke-3 (3NF):');
  bullet_(body, '1NF — Setiap kolom hanya menyimpan satu nilai atomik, tidak ada repeating group');
  bullet_(body, '2NF — Setiap atribut non-key bergantung penuh pada primary key (tidak ada partial dependency)');
  bullet_(body, '3NF — Tidak ada transitive dependency. Contoh: data role disimpan di tabel terpisah (roles), bukan langsung di tabel users');
  p_(body, 'Contoh penerapan normalisasi: Relasi guru-mata pelajaran-kelas menggunakan pivot table teacher_subjects alih-alih menyimpan data mapel langsung di tabel teachers. Ini menghindari redundansi dan menjaga integritas data.');
}

// ==========================================
// 6. BAB 4 — IMPLEMENTASI FITUR
// ==========================================
function writeImplementasiFitur_(body, C) {
  h1_(body, 'BAB 4 — IMPLEMENTASI FITUR', C.PRIMARY);
  hr_(body);
  
  // 4.1
  h2_(body, '4.1 Autentikasi & Otorisasi');
  
  h3_(body, '4.1.1 Mekanisme Login');
  p_(body, 'Sistem menggunakan session-based authentication bawaan Laravel. Ketika user submit form login, AuthController memvalidasi email dan password, kemudian membuat session jika kredensial valid. Session disimpan di server dan diidentifikasi melalui cookie terenkripsi di browser.');
  p_(body, 'Alur login:');
  numbered_(body, 'User mengakses /login → ditampilkan form login');
  numbered_(body, 'User menginput email & password, lalu submit form');
  numbered_(body, 'AuthController::login() memvalidasi input dan memanggil Auth::attempt()');
  numbered_(body, 'Laravel mencocokkan email di database, lalu membandingkan password dengan hash Bcrypt');
  numbered_(body, 'Jika valid, session dibuat dan user di-redirect ke /dashboard');
  numbered_(body, 'AuthController::dashboard() memeriksa role user dan redirect ke dashboard yang sesuai');
  
  body.appendParagraph('');
  
  h3_(body, '4.1.2 Role-Based Access Control (RBAC)');
  p_(body, 'Sistem menerapkan RBAC melalui middleware CheckRole yang memeriksa role pengguna sebelum mengizinkan akses ke route tertentu. Middleware ini menerima daftar role yang diizinkan sebagai parameter.');
  code_(body, '// Contoh penerapan di routes/web.php');
  code_(body, 'Route::middleware(CheckRole::class . \':Admin\')->group(function () {');
  code_(body, '    Route::resource(\'users\', UserController::class);');
  code_(body, '    // ... route lainnya hanya untuk Admin');
  code_(body, '});');
  body.appendParagraph('');
  code_(body, '// Middleware CheckRole');
  code_(body, 'public function handle($request, Closure $next, ...$roles) {');
  code_(body, '    $userRole = $request->user()->role->name;');
  code_(body, '    if (!in_array($userRole, $roles)) abort(403);');
  code_(body, '    return $next($request);');
  code_(body, '}');
  
  body.appendParagraph('');
  
  // 4.2
  h2_(body, '4.2 Presensi QR Code dengan Geolokasi');
  
  h3_(body, '4.2.1 Pembangkitan QR Code Dinamis');
  p_(body, 'QR Code dibangkitkan secara dinamis menggunakan library SimpleSoftwareIO/SimpleQrCode. Payload QR berisi data yang dienkripsi dengan algoritma AES-256-CBC menggunakan key unik sistem. Setiap QR Code memiliki masa berlaku 600 detik (10 menit) untuk mencegah penyalahgunaan.');
  p_(body, 'Struktur payload sebelum enkripsi:');
  code_(body, '{');
  code_(body, '    "teacher_id": 5,');
  code_(body, '    "timestamp": 1709020800,');
  code_(body, '    "type": "attendance",');
  code_(body, '    "school_lat": -6.5465236,');
  code_(body, '    "school_lng": 107.4414175');
  code_(body, '}');
  body.appendParagraph('');
  p_(body, 'Payload dienkripsi menggunakan Crypt::encryptString() (AES-256-CBC) sebelum di-encode ke QR Code. Saat di-scan, payload didekripsi dan divalidasi: (1) apakah belum expired (< 600 detik), (2) apakah teacher_id valid, (3) apakah type = "attendance".');
  
  h3_(body, '4.2.2 Validasi Geolokasi (Haversine Formula)');
  p_(body, 'Setelah QR Code di-scan, sistem memvalidasi lokasi pengguna menggunakan Haversine Formula untuk menghitung jarak antara koordinat GPS pengguna dengan koordinat sekolah. Presensi hanya diterima jika jarak ≤ 100 meter.');
  p_(body, 'Rumus Haversine:');
  code_(body, 'a = sin²(Δlat/2) + cos(lat1) × cos(lat2) × sin²(Δlng/2)');
  code_(body, 'c = 2 × atan2(√a, √(1−a))');
  code_(body, 'd = R × c    // R = 6.371.000 meter (radius bumi)');
  body.appendParagraph('');
  p_(body, 'Koordinat referensi SMPN 4 Purwakarta: Latitude -6.5465236, Longitude 107.4414175. Radius toleransi: 100 meter.');
  
  h3_(body, '4.2.3 Alur Presensi Lengkap');
  numbered_(body, 'Admin/Kiosk menampilkan QR Code guru di layar (halaman /attendance/qr-code atau /kiosk)');
  numbered_(body, 'QR Code di-refresh otomatis setiap 10 menit (auto-reload)');
  numbered_(body, 'Guru membuka halaman scanner di HP (/scan-presensi)');
  numbered_(body, 'Browser meminta izin akses kamera dan GPS');
  numbered_(body, 'Guru memindai QR Code dari layar kiosk');
  numbered_(body, 'JavaScript mengirim POST request ke /kiosk/api/scan berisi: QR payload + latitude + longitude');
  numbered_(body, 'Server mendekripsi payload, validasi expiry, validasi geolokasi');
  numbered_(body, 'Jika semua valid: record attendance dibuat dengan status "hadir". Jika sudah check-in sebelumnya: update check_out');
  numbered_(body, 'Response JSON dikembalikan ke browser guru + notifikasi dikirim ke admin');
  
  body.appendParagraph('');
  
  // 4.3
  h2_(body, '4.3 Mode Kiosk');
  p_(body, 'Mode Kiosk dirancang untuk layar monitor di depan ruang guru yang menampilkan daftar guru dan QR Code masing-masing tanpa perlu login.');
  p_(body, 'Fitur Mode Kiosk:');
  bullet_(body, 'Halaman publik /kiosk/ — menampilkan grid guru dengan nama, foto, dan status kehadiran hari ini');
  bullet_(body, 'Klik nama guru → tampilkan QR Code dinamis guru tersebut (auto-refresh 10 menit)');
  bullet_(body, 'API /kiosk/api/summary — menampilkan ringkasan kehadiran hari ini (hadir, izin, sakit, alfa)');
  bullet_(body, 'API /kiosk/api/status/{teacher} — cek status kehadiran guru tertentu secara realtime');
  bullet_(body, 'User dengan role "Kiosk Presensi" dapat login untuk melihat dashboard kiosk terpisah');
  
  // 4.4
  h2_(body, '4.4 Manajemen Nilai');
  p_(body, 'Modul nilai memungkinkan guru menginput nilai per kelas secara batch (store-multiple) maupun individual. Nilai dihitung otomatis dengan formula:');
  code_(body, 'Nilai Akhir = (Ulangan Harian × 30%) + (UTS × 30%) + (UAS × 40%)');
  body.appendParagraph('');
  p_(body, 'Predikat otomatis berdasarkan nilai akhir:');
  table_(body, ['Rentang Nilai', 'Predikat', 'Keterangan'],
    [
      ['90 – 100', 'A (Sangat Baik)',  'Pencapaian sangat memuaskan'],
      ['80 – 89',  'B (Baik)',         'Pencapaian memuaskan'],
      ['70 – 79',  'C (Cukup)',        'Pencapaian cukup'],
      ['60 – 69',  'D (Kurang)',       'Perlu bimbingan'],
      ['0 – 59',   'E (Sangat Kurang)','Perlu bimbingan intensif'],
    ],
    '#059669', '#f0fdf4'
  );
  
  // 4.5
  h2_(body, '4.5 Ekspor Laporan');
  p_(body, 'Sistem menyediakan 4 jenis laporan yang dapat diekspor dalam format Excel (.xlsx) dan PDF:');
  table_(body, ['Laporan', 'Class Export', 'Filter', 'Format'],
    [
      ['Laporan Kehadiran',  'AttendanceExport',  'Tanggal, Status, Guru/Siswa',  'Excel, PDF'],
      ['Laporan Nilai',      'GradeExport',       'Kelas, Mapel, Semester',       'Excel, PDF'],
      ['Data Siswa',         'StudentExport',      'Kelas, Status',                'Excel, PDF'],
      ['Data Guru',          'TeacherExport',      'Status',                       'Excel, PDF'],
    ],
    '#7c3aed', '#f5f3ff'
  );
  p_(body, 'Library yang digunakan: Maatwebsite/Laravel-Excel v3.1 (untuk .xlsx) dan Barryvdh/Laravel-DomPDF v3.1 (untuk .pdf). Export dilakukan di server dan file langsung di-download oleh browser.');
  
  // 4.6
  h2_(body, '4.6 Pengaturan Sistem');
  p_(body, 'Pengaturan disimpan dalam model key-value di tabel settings dengan caching selama 3600 detik. Terdapat 5 grup pengaturan:');
  table_(body, ['Grup', 'Jumlah Setting', 'Contoh Parameter'],
    [
      ['Profil Sekolah (school)',   '9 parameter',  'school_name, school_address, school_phone, school_logo, school_npsn, school_latitude, school_longitude, school_principal, school_email'],
      ['Umum (general)',            '5 parameter',  'app_name, app_description, timezone, date_format, pagination_size'],
      ['Tampilan (appearance)',     '3 parameter',  'theme_color, sidebar_style, brand_logo'],
      ['Notifikasi (notification)', '3 parameter',  'email_notification, browser_notification, notification_sound'],
      ['Sistem (system)',           '4 parameter',  'maintenance_mode, debug_mode, max_upload_size, backup_frequency'],
    ],
    '#ea580c', '#fff7ed'
  );
  
  // 4.7
  h2_(body, '4.7 Notifikasi');
  p_(body, 'NotificationService mengelola pengiriman notifikasi ke pengguna:');
  bullet_(body, 'Notifikasi personal — dikirim ke user tertentu (user_id terisi)');
  bullet_(body, 'Broadcast — dikirim ke semua user (user_id = null)');
  bullet_(body, 'Preset notifikasi: studentAdded, teacherAdded, gradesSubmitted, lowAttendanceWarning');
  bullet_(body, 'Realtime count via API: GET /api/notifications/unread-count');
  bullet_(body, 'Mark as read: POST /api/notifications/{id}/read');
  bullet_(body, 'Mark all as read: POST /api/notifications/read-all');
  
  // 4.8
  h2_(body, '4.8 Dashboard Analytics');
  p_(body, 'Dashboard menampilkan data real-time yang disesuaikan berdasarkan role pengguna:');
  bullet_(body, '4 Stat Cards — Total Guru, Total Siswa, Total Kelas, Persentase Kehadiran');
  bullet_(body, 'Badge tahun ajaran aktif');
  bullet_(body, 'Chart.js Doughnut — Distribusi status kehadiran (hadir/izin/sakit/alfa)');
  bullet_(body, 'Chart.js Line — Tren kehadiran 7 hari terakhir');
  bullet_(body, 'Chart.js Bar — Perbandingan kehadiran per kelas');
  bullet_(body, 'Tabel aktivitas terbaru — 10 record kehadiran terakhir');
  bullet_(body, 'Quick action buttons — Shortcut ke fitur yang sering digunakan');
}

// ==========================================
// 7. BAB 5 — ENDPOINT API
// ==========================================
function writeEndpointAPI_(body, C) {
  h1_(body, 'BAB 5 — ENDPOINT API', C.PRIMARY);
  hr_(body);
  
  // 5.1
  h2_(body, '5.1 Route Groups & Middleware');
  p_(body, 'Seluruh route didefinisikan di routes/web.php dan dikelompokkan berdasarkan middleware:');
  
  table_(body, ['Group', 'Middleware', 'Akses', 'Jumlah Route'],
    [
      ['Guest',           'guest',                      'Hanya user belum login',            '2 route'],
      ['Auth (semua)',    'auth',                       'Semua user login',                   '~25 route'],
      ['Admin only',      'auth + CheckRole:Admin',    'Hanya Admin',                        '~75 route'],
      ['Admin + Guru',    'auth + CheckRole:Admin,Guru','Admin dan Guru',                    '~15 route'],
      ['Admin + Kepsek',  'auth + CheckRole:Admin,Kepala Sekolah', 'Admin dan Kepala Sekolah', '~7 route'],
      ['Kiosk (public)',  'none',                       'Publik (tanpa login)',               '4 route'],
      ['Kiosk (auth)',    'auth',                       'User login (scan processing)',       '1 route'],
    ],
    C.TABLE_HEAD, C.TABLE_ALT
  );
  
  // 5.2
  h2_(body, '5.2 Daftar Semua Endpoint');
  
  // Auth
  h3_(body, '1. Autentikasi & Bahasa');
  table_(body, ['Method', 'URL', 'Controller@Method', 'Middleware', 'Keterangan'],
    [
      ['GET',  '/language/{locale}',  'LanguageController@switch',  'none',  'Ganti bahasa (id/en)'],
      ['GET',  '/login',              'AuthController@showLogin',   'guest', 'Halaman form login'],
      ['POST', '/login',              'AuthController@login',       'guest', 'Proses login'],
      ['POST', '/logout',             'AuthController@logout',      'auth',  'Proses logout'],
      ['GET',  '/dashboard',          'AuthController@dashboard',   'auth',  'Redirect ke dashboard sesuai role'],
    ],
    '#16a34a', '#f0fdf4'
  );
  
  // Profile
  h3_(body, '2. Profil Pengguna');
  table_(body, ['Method', 'URL', 'Controller@Method', 'Middleware', 'Keterangan'],
    [
      ['GET', '/profile',          'ProfileController@edit',           'auth', 'Halaman edit profil'],
      ['PUT', '/profile',          'ProfileController@update',         'auth', 'Update data profil'],
      ['PUT', '/profile/password', 'ProfileController@updatePassword', 'auth', 'Ganti password'],
    ],
    '#16a34a', '#f0fdf4'
  );
  
  // Notification
  h3_(body, '3. Notifikasi');
  table_(body, ['Method', 'URL', 'Controller@Method', 'Middleware', 'Keterangan'],
    [
      ['GET',    '/notifications',                    'NotificationController@showAll',     'auth', 'Halaman daftar notifikasi'],
      ['GET',    '/api/notifications',                'NotificationController@index',       'auth', 'API: daftar notifikasi (JSON)'],
      ['GET',    '/api/notifications/unread-count',   'NotificationController@unreadCount', 'auth', 'API: jumlah belum dibaca'],
      ['POST',   '/api/notifications/{id}/read',      'NotificationController@markAsRead',  'auth', 'API: tandai sudah dibaca'],
      ['POST',   '/api/notifications/read-all',       'NotificationController@markAllAsRead','auth','API: tandai semua dibaca'],
      ['DELETE', '/api/notifications/{id}',           'NotificationController@destroy',      'auth', 'API: hapus notifikasi'],
    ],
    '#16a34a', '#f0fdf4'
  );
  
  // Attendance
  h3_(body, '4. Presensi');
  table_(body, ['Method', 'URL', 'Controller@Method', 'Middleware', 'Keterangan'],
    [
      ['GET',  '/attendance',                    'AttendanceController@index',               'auth',       'Halaman daftar kehadiran'],
      ['GET',  '/attendance/qr-code',            'AttendanceController@showQRCode',          'auth',       'Halaman QR Code guru'],
      ['GET',  '/attendance/admin-qr',           'AttendanceController@showAdminQR',         'auth',       'QR admin untuk all guru'],
      ['GET',  '/attendance/scanner',            'AttendanceController@showScanner',         'auth',       'Halaman scanner QR'],
      ['POST', '/attendance/scan-qr',            'AttendanceController@scanQR',              'auth',       'Proses scan QR'],
      ['POST', '/attendance/check-in',           'AttendanceController@checkIn',             'auth',       'Proses check-in manual'],
      ['POST', '/attendance/check-out',          'AttendanceController@checkOut',            'auth',       'Proses check-out manual'],
      ['GET',  '/api/teacher/{id}/qr-code',      'AttendanceController@getTeacherQR',       'auth',       'API: QR code guru'],
      ['GET',  '/api/teacher/{id}/attendance-status','AttendanceController@getTeacherAttendanceStatus','auth','API: status hadir guru'],
      ['GET',  '/attendance/class/{id}',         'AttendanceController@classAttendance',     'Admin',      'Kehadiran per kelas'],
      ['POST', '/attendance/class/{id}',         'AttendanceController@saveClassAttendance', 'Admin',      'Simpan kehadiran kelas'],
    ],
    '#2563eb', '#eff6ff'
  );
  
  // CRUD resources
  h3_(body, '5. Manajemen Data (Admin Only — CRUD Resource)');
  p_(body, 'Setiap resource route menghasilkan 7 endpoint standar: index, create, store, show, edit, update, destroy.');
  
  table_(body, ['Resource', 'Base URL', 'Controller', 'Endpoint Tambahan'],
    [
      ['users',            '/users',            'UserController',           'POST /users/{id}/reset-password — Reset password'],
      ['teachers',         '/teachers',         'TeacherController',        '—'],
      ['students',         '/students',         'StudentController',        '—'],
      ['subjects',         '/subjects',         'SubjectController',        '—'],
      ['classes',          '/classes',           'ClassRoomController',      '—'],
      ['academic-years',   '/academic-years',    'AcademicYearController',  'POST /academic-years/{id}/toggle-active — Toggle aktif'],
      ['teacher-subjects', '/teacher-subjects',  'TeacherSubjectController','GET /api/teacher/{id}/subjects, GET /api/subject/{id}/teachers'],
      ['criteria',         '/criteria',          'CriteriaController',      'POST /criteria/normalize — Normalisasi bobot'],
    ],
    '#dc2626', '#fef2f2'
  );
  
  // Grades
  h3_(body, '6. Manajemen Nilai (Admin + Guru)');
  table_(body, ['Method', 'URL', 'Controller@Method', 'Keterangan'],
    [
      ['GET',    '/grades',               'GradeController@index',        'Daftar semua nilai'],
      ['GET',    '/grades/create',        'GradeController@create',       'Form pilih kelas untuk input nilai'],
      ['POST',   '/grades/input-by-class','GradeController@inputByClass', 'Form input nilai per kelas'],
      ['POST',   '/grades/store-multiple','GradeController@storeMultiple','Simpan nilai batch (satu kelas)'],
      ['GET',    '/grades/{id}/edit',     'GradeController@edit',         'Form edit nilai individual'],
      ['PUT',    '/grades/{id}',          'GradeController@update',       'Update nilai individual'],
      ['DELETE', '/grades/{id}',          'GradeController@destroy',      'Hapus nilai'],
    ],
    '#7c3aed', '#f5f3ff'
  );
  
  // SAW
  h3_(body, '7. Perhitungan SAW (Admin + Kepala Sekolah)');
  table_(body, ['Method', 'URL', 'Controller@Method', 'Keterangan'],
    [
      ['GET',  '/saw/students',            'SAWController@studentIndex',     'Halaman SAW siswa'],
      ['POST', '/saw/students/calculate',  'SAWController@calculateStudents','Jalankan perhitungan SAW siswa'],
      ['GET',  '/saw/teachers',            'SAWController@teacherIndex',     'Halaman SAW guru'],
      ['POST', '/saw/teachers/calculate',  'SAWController@calculateTeachers','Jalankan perhitungan SAW guru'],
      ['GET',  '/students/{id}/report-card','GradeController@reportCard',    'Rapor siswa (admin/kepsek)'],
    ],
    '#7c3aed', '#f5f3ff'
  );
  
  // Reports
  h3_(body, '8. Laporan & Pengaturan (Admin Only)');
  table_(body, ['Method', 'URL', 'Controller@Method', 'Keterangan'],
    [
      ['GET',  '/reports',                    'ReportController@index',           'Halaman laporan'],
      ['POST', '/reports/attendance/export',  'ReportController@exportAttendance','Export kehadiran (Excel/PDF)'],
      ['POST', '/reports/grades/export',      'ReportController@exportGrades',    'Export nilai (Excel/PDF)'],
      ['POST', '/reports/students/export',    'ReportController@exportStudents',  'Export data siswa'],
      ['POST', '/reports/teachers/export',    'ReportController@exportTeachers',  'Export data guru'],
      ['GET',  '/settings',                   'SettingController@index',          'Halaman pengaturan'],
      ['PUT',  '/settings/school',            'SettingController@updateSchool',   'Update profil sekolah'],
      ['PUT',  '/settings/general',           'SettingController@updateGeneral',  'Update pengaturan umum'],
      ['PUT',  '/settings/appearance',        'SettingController@updateAppearance','Update tampilan'],
      ['PUT',  '/settings/notification',      'SettingController@updateNotification','Update notifikasi'],
      ['PUT',  '/settings/system',            'SettingController@updateSystem',   'Update sistem'],
      ['POST', '/settings/cache/clear',       'SettingController@clearCache',     'Bersihkan cache'],
      ['POST', '/settings/backup',            'SettingController@backup',         'Backup database'],
    ],
    '#ea580c', '#fff7ed'
  );
  
  // Kiosk
  h3_(body, '9. Mode Kiosk');
  table_(body, ['Method', 'URL', 'Controller@Method', 'Middleware', 'Keterangan'],
    [
      ['GET',  '/kiosk/',                'KioskController@index',             'none', 'Halaman utama kiosk (publik)'],
      ['GET',  '/kiosk/api/qr/{id}',    'KioskController@generateQR',        'none', 'API: generate QR guru'],
      ['GET',  '/kiosk/api/status/{id}', 'KioskController@getAttendanceStatus','none','API: status hadir guru'],
      ['GET',  '/kiosk/api/summary',     'KioskController@getTodaySummary',   'none', 'API: ringkasan hari ini'],
      ['POST', '/kiosk/api/scan',        'KioskController@processQRScan',    'auth',  'Proses scan QR (dari HP guru)'],
      ['GET',  '/scan-presensi',         'KioskController@showScanner',       'auth', 'Halaman scanner di HP guru'],
      ['GET',  '/api/attendance/my-status','KioskController@getMyAttendanceStatus','auth','API: status kehadiran saya'],
      ['GET',  '/kiosk-dashboard',       'KioskController@dashboard',         'auth', 'Dashboard kiosk user'],
    ],
    '#059669', '#f0fdf4'
  );
}

// ==========================================
// 8. BAB 6 — KEAMANAN SISTEM
// ==========================================
function writeKeamanan_(body, C) {
  h1_(body, 'BAB 6 — KEAMANAN SISTEM', C.PRIMARY);
  hr_(body);
  
  p_(body, 'Sistem dirancang dengan memperhatikan aspek keamanan berlapis (defense in depth). Berikut mekanisme keamanan yang diterapkan:');
  
  // 6.1
  h2_(body, '6.1 Proteksi CSRF (Cross-Site Request Forgery)');
  p_(body, 'Seluruh form POST/PUT/DELETE dilindungi oleh CSRF token yang di-generate otomatis oleh Laravel. Token disematkan di setiap form menggunakan directive @csrf pada Blade template. Server memvalidasi token sebelum memproses request untuk memastikan request berasal dari aplikasi yang sah.');
  code_(body, '<form method="POST" action="/attendance/check-in">');
  code_(body, '    @csrf');
  code_(body, '    <!-- form fields -->');
  code_(body, '</form>');
  body.appendParagraph('');
  p_(body, 'Middleware VerifyCsrfToken secara otomatis menolak request POST/PUT/DELETE yang tidak menyertakan token CSRF valid dengan response 419 (Page Expired).');
  
  // 6.2
  h2_(body, '6.2 Enkripsi QR Code (AES-256-CBC)');
  p_(body, 'Payload QR Code dienkripsi menggunakan fungsi Crypt::encryptString() bawaan Laravel yang menerapkan algoritma AES-256-CBC (Advanced Encryption Standard, 256-bit key, Cipher Block Chaining mode).');
  p_(body, 'Keunggulan:');
  bullet_(body, 'Key diambil dari APP_KEY di file .env (32 karakter base64-encoded) — unik per instalasi');
  bullet_(body, 'Setiap enkripsi menghasilkan IV (Initialization Vector) berbeda sehingga ciphertext selalu berbeda meskipun plaintext sama');
  bullet_(body, 'Ciphertext di-MAC (Message Authentication Code) untuk mendeteksi tampering');
  bullet_(body, 'Payload menyertakan timestamp → QR kedaluwarsa setelah 600 detik → menggagalkan replay attack');
  
  // 6.3
  h2_(body, '6.3 Validasi Geolokasi (Haversine Formula)');
  p_(body, 'Setelah QR di-scan, koordinat GPS pengguna dikirim ke server dan divalidasi menggunakan Haversine Formula:');
  code_(body, 'function haversineDistance($lat1, $lon1, $lat2, $lon2) {');
  code_(body, '    $R = 6371000; // radius bumi dalam meter');
  code_(body, '    $dLat = deg2rad($lat2 - $lat1);');
  code_(body, '    $dLon = deg2rad($lon2 - $lon1);');
  code_(body, '    $a = sin($dLat/2) * sin($dLat/2)');
  code_(body, '        + cos(deg2rad($lat1)) * cos(deg2rad($lat2))');
  code_(body, '        * sin($dLon/2) * sin($dLon/2);');
  code_(body, '    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));');
  code_(body, '    return $R * $c;');
  code_(body, '}');
  body.appendParagraph('');
  p_(body, 'Koordinat sekolah: (-6.5465236, 107.4414175). Radius toleransi: 100 meter. Jika jarak > 100m, presensi ditolak dengan pesan error.');
  
  // 6.4
  h2_(body, '6.4 RBAC (Role-Based Access Control)');
  p_(body, 'Akses dikontrol melalui middleware CheckRole yang memeriksa role user terhadap daftar role yang diizinkan untuk setiap route group. Jika role tidak sesuai, server mengembalikan HTTP 403 Forbidden.');
  
  table_(body, ['Fitur', 'Admin', 'Guru', 'Kepala Sekolah', 'Kiosk Presensi'],
    [
      ['Dashboard',       '✅', '✅', '✅', '✅'],
      ['Manajemen User',  '✅', '❌', '❌', '❌'],
      ['Manajemen Guru',  '✅', '❌', '❌', '❌'],
      ['Manajemen Siswa', '✅', '❌', '❌', '❌'],
      ['Input Nilai',     '✅', '✅', '❌', '❌'],
      ['Presensi QR',     '✅', '✅', '❌', '❌'],
      ['Perhitungan SAW', '✅', '❌', '✅', '❌'],
      ['Laporan & Export','✅', '❌', '❌', '❌'],
      ['Pengaturan',      '✅', '❌', '❌', '❌'],
      ['Kiosk Display',   '❌', '❌', '❌', '✅'],
    ],
    C.DARK, '#f8fafc'
  );
  
  // 6.5
  h2_(body, '6.5 Sanitasi Input & Proteksi SQL Injection');
  p_(body, 'Sistem terlindungi dari SQL Injection melalui:');
  bullet_(body, 'Eloquent ORM — semua query menggunakan parameterized query (prepared statement) secara otomatis');
  bullet_(body, 'Validasi input — setiap request divalidasi menggunakan $request->validate() dengan rules ketat');
  bullet_(body, 'Mass assignment protection — model mendefinisikan $fillable atau $guarded untuk mencegah mass assignment attack');
  bullet_(body, 'XSS protection — Blade template menggunakan {{ }} (escaped output) secara default, bukan {!! !!} (unescaped)');
  
  p_(body, 'Contoh validasi input (UserController@store):');
  code_(body, '$request->validate([');
  code_(body, '    \'name\'     => \'required|string|max:255\',');
  code_(body, '    \'email\'    => \'required|email|unique:users,email\',');
  code_(body, '    \'password\' => \'required|min:8|confirmed\',');
  code_(body, '    \'role_id\'  => \'required|exists:roles,id\',');
  code_(body, ']);');
  
  // 6.6
  h2_(body, '6.6 Password Hashing (Bcrypt)');
  p_(body, 'Password disimpan dalam bentuk hash menggunakan algoritma Bcrypt (default Laravel) dengan cost factor 12. Password asli tidak pernah disimpan di database.');
  code_(body, '// Saat registrasi/create user:');
  code_(body, 'User::create([');
  code_(body, '    \'password\' => Hash::make($request->password), // Bcrypt hash');
  code_(body, ']);');
  body.appendParagraph('');
  code_(body, '// Saat login (Auth::attempt secara otomatis compare hash):');
  code_(body, 'Auth::attempt([\'email\' => $email, \'password\' => $password]);');
}

// ==========================================
// 9. BAB 7 — ALGORITMA SAW
// ==========================================
function writeAlgoritmaSAW_(body, C) {
  h1_(body, 'BAB 7 — ALGORITMA SAW (Simple Additive Weighting)', C.PRIMARY);
  hr_(body);
  
  p_(body, 'Metode SAW (Simple Additive Weighting) digunakan untuk melakukan perankingan siswa dan guru berdasarkan multi-kriteria. SAW dipilih karena (1) konsep sederhana dan mudah dipahami, (2) komputasi ringan, (3) dapat menangani kriteria benefit dan cost, (4) menghasilkan ranking yang objektif. Implementasi dilakukan pada class SAWService.');
  
  // 7.1
  h2_(body, '7.1 Definisi Kriteria');
  
  h3_(body, 'Kriteria Penilaian Siswa');
  table_(body, ['Kode', 'Nama Kriteria', 'Tipe', 'Bobot', 'Penjelasan'],
    [
      ['C1', 'Nilai Akademik', 'Benefit', '0.35 (35%)', 'Rata-rata nilai akhir seluruh mata pelajaran'],
      ['C2', 'Kehadiran',      'Benefit', '0.25 (25%)', 'Persentase kehadiran siswa di kelas'],
      ['C3', 'Sikap/Perilaku', 'Benefit', '0.20 (20%)', 'Rata-rata nilai sikap dari semua guru'],
      ['C4', 'Keterampilan',   'Benefit', '0.20 (20%)', 'Rata-rata nilai keterampilan'],
    ],
    '#059669', '#f0fdf4'
  );
  
  h3_(body, 'Kriteria Penilaian Guru');
  table_(body, ['Kode', 'Nama Kriteria', 'Tipe', 'Bobot', 'Penjelasan'],
    [
      ['K1', 'Kehadiran',          'Benefit', '0.30 (30%)', 'Persentase kehadiran guru di sekolah'],
      ['K2', 'Kualitas Mengajar',  'Benefit', '0.30 (30%)', 'Penilaian kualitas mengajar oleh kepala sekolah'],
      ['K3', 'Prestasi Siswa',     'Benefit', '0.25 (25%)', 'Rata-rata nilai siswa yang diajar'],
      ['K4', 'Kedisiplinan',       'Benefit', '0.15 (15%)', 'Penilaian kedisiplinan oleh kepala sekolah'],
    ],
    '#059669', '#f0fdf4'
  );
  
  p_(body, 'Catatan: Total bobot masing-masing kelompok (siswa/guru) harus = 1.00. Admin dapat menormalisasi bobot melalui fitur /criteria/normalize.');
  
  // 7.2
  h2_(body, '7.2 Matriks Keputusan');
  p_(body, 'Matriks keputusan (X) menyusun nilai setiap alternatif (siswa/guru) pada setiap kriteria. Baris = alternatif, Kolom = kriteria.');
  code_(body, 'Contoh matriks keputusan 4 siswa:');
  table_(body, ['Alternatif', 'C1 (Akademik)', 'C2 (Kehadiran)', 'C3 (Sikap)', 'C4 (Keterampilan)'],
    [
      ['Siswa A',  '85',  '95',  '80',  '78'],
      ['Siswa B',  '90',  '88',  '85',  '82'],
      ['Siswa C',  '78',  '92',  '90',  '88'],
      ['Siswa D',  '92',  '85',  '75',  '80'],
    ],
    '#334155', '#f8fafc'
  );
  
  // 7.3
  h2_(body, '7.3 Normalisasi Matriks');
  p_(body, 'Normalisasi dilakukan agar semua kriteria berada dalam skala 0–1:');
  p_(body, '• Kriteria Benefit: rij = xij / max(xj) — semakin tinggi semakin baik');
  p_(body, '• Kriteria Cost: rij = min(xj) / xij — semakin rendah semakin baik');
  p_(body, 'Karena seluruh 8 kriteria berjenis Benefit, digunakan rumus benefit:');
  
  code_(body, 'Normalisasi C1: max = 92');
  code_(body, '  Siswa A: 85/92 = 0.9239');
  code_(body, '  Siswa B: 90/92 = 0.9783');
  code_(body, '  Siswa C: 78/92 = 0.8478');
  code_(body, '  Siswa D: 92/92 = 1.0000');
  body.appendParagraph('');
  code_(body, 'Normalisasi C2: max = 95');
  code_(body, '  Siswa A: 95/95 = 1.0000');
  code_(body, '  Siswa B: 88/95 = 0.9263');
  code_(body, '  Siswa C: 92/95 = 0.9684');
  code_(body, '  Siswa D: 85/95 = 0.8947');
  
  // 7.4
  h2_(body, '7.4 Perhitungan Nilai Preferensi (Vi)');
  p_(body, 'Nilai preferensi dihitung dengan menjumlahkan hasil perkalian nilai normalisasi dengan bobot kriteria:');
  p_(body, 'Vi = Σ (wj × rij)');
  p_(body, 'Dengan bobot: w1=0.35, w2=0.25, w3=0.20, w4=0.20');
  
  code_(body, 'V(Siswa A) = (0.35 × 0.9239) + (0.25 × 1.0000) + (0.20 × 0.8889) + (0.20 × 0.8864)');
  code_(body, '           = 0.3234 + 0.2500 + 0.1778 + 0.1773 = 0.9284');
  body.appendParagraph('');
  code_(body, 'V(Siswa B) = (0.35 × 0.9783) + (0.25 × 0.9263) + (0.20 × 0.9444) + (0.20 × 0.9318)');
  code_(body, '           = 0.3424 + 0.2316 + 0.1889 + 0.1864 = 0.9492');
  body.appendParagraph('');
  code_(body, 'V(Siswa C) = (0.35 × 0.8478) + (0.25 × 0.9684) + (0.20 × 1.0000) + (0.20 × 1.0000)');
  code_(body, '           = 0.2967 + 0.2421 + 0.2000 + 0.2000 = 0.9388');
  body.appendParagraph('');
  code_(body, 'V(Siswa D) = (0.35 × 1.0000) + (0.25 × 0.8947) + (0.20 × 0.8333) + (0.20 × 0.9091)');
  code_(body, '           = 0.3500 + 0.2237 + 0.1667 + 0.1818 = 0.9222');
  
  // 7.5
  h2_(body, '7.5 Perankingan');
  p_(body, 'Alternatif diurutkan berdasarkan nilai preferensi tertinggi ke terendah:');
  
  table_(body, ['Rank', 'Alternatif', 'Nilai Preferensi (Vi)'],
    [
      ['1', 'Siswa B', '0.9492'],
      ['2', 'Siswa C', '0.9388'],
      ['3', 'Siswa A', '0.9284'],
      ['4', 'Siswa D', '0.9222'],
    ],
    '#059669', '#f0fdf4'
  );
  
  p_(body, 'Siswa B memperoleh ranking 1 karena memiliki nilai preferensi tertinggi (0.9492). Hasil ranking ini disimpan ke tabel student_assessments beserta seluruh skor per kriteria untuk transparansi.');
  
  // 7.6
  h2_(body, '7.6 Implementasi dalam Kode');
  p_(body, 'Implementasi ditempatkan di app/Services/SAWService.php dengan struktur:');
  bullet_(body, 'calculate($data, $type) — method publik utama, orkestrator seluruh tahap');
  bullet_(body, 'buildDecisionMatrix($data, $criteria, $type) — menyusun matriks keputusan');
  bullet_(body, 'normalizeMatrix($matrix, $criteria) — normalisasi benefit/cost');
  bullet_(body, 'calculateSAWScores($normalizedMatrix, $criteria) — hitung Vi = Σ(wj × rij)');
  bullet_(body, 'rankAlternatives($data, $scores) — sortByDesc dan assign ranking');
  bullet_(body, 'getCalculationDetails() — return detail langkah untuk transparansi');
}

// ==========================================
// 10. BAB 8 — PENGUJIAN SISTEM
// ==========================================
function writePengujian_(body, C) {
  h1_(body, 'BAB 8 — PENGUJIAN SISTEM', C.PRIMARY);
  hr_(body);
  
  p_(body, 'Sistem telah diuji menggunakan 3 metode pengujian: Black Box Testing, White Box Testing, dan User Acceptance Testing (UAT).');
  
  // 8.1
  h2_(body, '8.1 Black Box Testing');
  p_(body, 'Black Box Testing menguji fungsionalitas sistem dari perspektif pengguna tanpa melihat struktur kode internal. Total 58 skenario pengujian telah dilaksanakan.');
  
  table_(body, ['Modul', 'Total Skenario', 'Berhasil', 'Gagal', 'Hasil'],
    [
      ['Login/Logout',          '5',  '5',  '0', '100% ✅'],
      ['Dashboard',             '3',  '3',  '0', '100% ✅'],
      ['Manajemen Guru',        '5',  '5',  '0', '100% ✅'],
      ['Manajemen Siswa',       '5',  '5',  '0', '100% ✅'],
      ['Manajemen Kelas',       '4',  '4',  '0', '100% ✅'],
      ['Manajemen Mata Pelajaran','4','4',  '0', '100% ✅'],
      ['Manajemen Tahun Ajaran','4',  '4',  '0', '100% ✅'],
      ['Penugasan Guru-Mapel',  '4',  '4',  '0', '100% ✅'],
      ['Presensi QR Code',      '6',  '6',  '0', '100% ✅'],
      ['Mode Kiosk',            '3',  '3',  '0', '100% ✅'],
      ['Input Nilai',           '5',  '5',  '0', '100% ✅'],
      ['Perhitungan SAW',       '4',  '4',  '0', '100% ✅'],
      ['Laporan & Export',      '4',  '4',  '0', '100% ✅'],
      ['Pengaturan Sistem',     '4',  '4',  '0', '100% ✅'],
      ['Profil & Notifikasi',   '3',  '3',  '0', '100% ✅'],
      ['TOTAL',                 '58', '58', '0', '100% ✅'],
    ],
    '#059669', '#f0fdf4'
  );
  
  // 8.2
  h2_(body, '8.2 White Box Testing');
  p_(body, 'White Box Testing menguji alur logika internal program. Pengujian dilakukan pada method-method kritis menggunakan teknik Basis Path Testing untuk memastikan setiap jalur logika tercakup.');
  p_(body, 'Method yang diuji:');
  bullet_(body, 'AuthController@login() — 3 jalur: sukses, email salah, password salah');
  bullet_(body, 'AttendanceController@scanQR() — 5 jalur: sukses check-in, sukses check-out, QR expired, lokasi di luar radius, QR invalid');
  bullet_(body, 'SAWService@calculate() — 4 jalur: sukses, data kosong, kriteria kosong, pembagian nol');
  bullet_(body, 'GradeController@storeMultiple() — 3 jalur: sukses, validasi gagal, duplikat');
  bullet_(body, 'CheckRole middleware — 3 jalur: role sesuai, role tidak sesuai, user tidak login');
  
  // 8.3
  h2_(body, '8.3 User Acceptance Testing (UAT)');
  p_(body, 'UAT dilakukan terhadap 32 responden (1 kepala sekolah, 24 guru, 5 staf admin, 2 operator) menggunakan skala Likert 1–5.');
  
  table_(body, ['Aspek Penilaian', 'Jumlah Pertanyaan', 'Rata-rata Skor', 'Kategori'],
    [
      ['Fungsionalitas',       '2 pertanyaan', '4.53', 'Sangat Baik'],
      ['Kemudahan Penggunaan', '2 pertanyaan', '4.44', 'Sangat Baik'],
      ['Kecepatan Sistem',     '2 pertanyaan', '4.41', 'Sangat Baik'],
      ['Tampilan Antarmuka',   '2 pertanyaan', '4.47', 'Sangat Baik'],
      ['Keandalan',            '2 pertanyaan', '4.47', 'Sangat Baik'],
      ['RATA-RATA TOTAL',     '10 pertanyaan', '4.46 / 5.00 (89.29%)', 'Sangat Baik'],
    ],
    '#7c3aed', '#f5f3ff'
  );
  
  p_(body, 'Kategori interpretasi: 1.00–1.80 = Sangat Kurang; 1.81–2.60 = Kurang; 2.61–3.40 = Cukup; 3.41–4.20 = Baik; 4.21–5.00 = Sangat Baik.');
  
  // 8.4
  h2_(body, '8.4 Evaluasi Prototype');
  p_(body, 'Evaluasi prototype dilakukan oleh 26 evaluator (1 kepala sekolah, 24 guru, 1 admin) pada tahap ke-3 metode Prototype.');
  
  table_(body, ['Aspek Evaluasi', 'Rata-rata', 'Kategori'],
    [
      ['Kesesuaian Fungsional',  '4.52', 'Sangat Baik'],
      ['Desain Antarmuka (UI/UX)','4.48','Sangat Baik'],
      ['Struktur Database',      '4.50', 'Sangat Baik'],
      ['Algoritma SAW',          '4.46', 'Sangat Baik'],
      ['Kelayakan Keseluruhan',  '4.54', 'Sangat Baik'],
      ['RATA-RATA',              '4.50 / 5.00', 'Sangat Baik'],
    ],
    '#ea580c', '#fff7ed'
  );
  
  p_(body, 'Masukan utama dari evaluasi: (1) Perlu transparansi langkah perhitungan SAW — ditindaklanjuti dengan method getCalculationDetails(). (2) Perlu fitur export laporan — ditindaklanjuti dengan modul Reports & Export.');
}

// ==========================================
// 11. BAB 9 — PANDUAN DEPLOYMENT
// ==========================================
function writeDeployment_(body, C) {
  h1_(body, 'BAB 9 — PANDUAN DEPLOYMENT', C.PRIMARY);
  hr_(body);
  
  // 9.1
  h2_(body, '9.1 Persyaratan Server');
  table_(body, ['Komponen', 'Versi Minimum', 'Rekomendasi'],
    [
      ['PHP',           '≥ 8.2',   '8.3 (latest stable)'],
      ['MySQL',         '≥ 5.7',   '8.0+'],
      ['Composer',      '≥ 2.0',   '2.7+'],
      ['Node.js',       '≥ 18',    '20 LTS'],
      ['NPM',           '≥ 9',     '10+'],
      ['Web Server',    'Apache/Nginx', 'Nginx untuk production'],
      ['RAM',           '≥ 1 GB',  '2 GB+'],
      ['Disk Space',    '≥ 500 MB','1 GB+ (untuk upload & backup)'],
    ],
    C.TABLE_HEAD, C.TABLE_ALT
  );
  
  p_(body, 'Ekstensi PHP yang diperlukan: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, PDO_MySQL, Tokenizer, XML, GD/Imagick.');
  
  // 9.2
  h2_(body, '9.2 Langkah Instalasi');
  
  numbered_(body, 'Clone repository:');
  code_(body, 'git clone <repository-url> sistem-absensi');
  code_(body, 'cd sistem-absensi');
  
  numbered_(body, 'Install PHP dependencies:');
  code_(body, 'composer install');
  
  numbered_(body, 'Install Node.js dependencies & build assets:');
  code_(body, 'npm install');
  code_(body, 'npm run build');
  
  numbered_(body, 'Salin file konfigurasi:');
  code_(body, 'cp .env.example .env');
  
  numbered_(body, 'Generate application key:');
  code_(body, 'php artisan key:generate');
  
  numbered_(body, 'Buat database MySQL:');
  code_(body, 'CREATE DATABASE absensi_smpn4_purwakarta;');
  
  numbered_(body, 'Konfigurasi .env:');
  code_(body, 'DB_DATABASE=absensi_smpn4_purwakarta');
  code_(body, 'DB_USERNAME=root');
  code_(body, 'DB_PASSWORD=your_password');
  
  numbered_(body, 'Jalankan migrasi & seeder:');
  code_(body, 'php artisan migrate --seed');
  
  numbered_(body, 'Buat symbolic link untuk storage:');
  code_(body, 'php artisan storage:link');
  
  numbered_(body, 'Jalankan development server:');
  code_(body, 'php artisan serve');
  
  body.appendParagraph('');
  
  // 9.3
  h2_(body, '9.3 Konfigurasi Environment (.env)');
  p_(body, 'Parameter penting yang perlu dikonfigurasi:');
  
  table_(body, ['Parameter', 'Default', 'Keterangan'],
    [
      ['APP_NAME',      'Sistem Absensi SMPN 4 Purwakarta', 'Nama aplikasi tampil di navbar/title'],
      ['APP_ENV',       'local',                              'Environment: local/production'],
      ['APP_DEBUG',     'true',                               'Mode debug (false di production!)'],
      ['APP_URL',       'http://localhost:8000',              'Base URL aplikasi'],
      ['APP_KEY',       '(auto-generated)',                   'Encryption key 256-bit (JANGAN diubah!)'],
      ['DB_HOST',       '127.0.0.1',                         'Host database MySQL'],
      ['DB_PORT',       '3306',                               'Port database'],
      ['DB_DATABASE',   'absensi_smpn4_purwakarta',          'Nama database'],
      ['SESSION_DRIVER','file',                               'Driver session (file/database/redis)'],
      ['CACHE_STORE',   'file',                               'Driver cache'],
    ],
    '#334155', '#f8fafc'
  );
  
  // 9.4
  h2_(body, '9.4 Akun Default (Seeder)');
  p_(body, 'Setelah menjalankan php artisan db:seed, akun default yang tersedia:');
  
  table_(body, ['Email', 'Password', 'Role', 'Keterangan'],
    [
      ['admin@smpn4.sch.id',   'password', 'Admin',           'Akun administrator utama'],
      ['guru@smpn4.sch.id',    'password', 'Guru',            'Akun guru contoh'],
      ['kepsek@smpn4.sch.id',  'password', 'Kepala Sekolah',  'Akun kepala sekolah'],
      ['kiosk@smpn4.sch.id',   'password', 'Kiosk Presensi',  'Akun layar kiosk'],
    ],
    '#dc2626', '#fef2f2'
  );
  
  p_(body, '⚠️ PENTING: Segera ganti password default setelah deployment ke production!');
  
  body.appendParagraph('');
  hr_(body);
  body.appendParagraph('');
  
  var footer = body.appendParagraph('— Akhir Dokumen —');
  footer.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  footer.editAsText().setFontSize(12);
  footer.editAsText().setForegroundColor('#94a3b8');
  footer.editAsText().setItalic(true);
  
  var gen = body.appendParagraph('Dokumen ini di-generate otomatis oleh Google Apps Script pada ' + Utilities.formatDate(new Date(), 'Asia/Jakarta', 'dd MMMM yyyy HH:mm') + ' WIB');
  gen.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  gen.editAsText().setFontSize(9);
  gen.editAsText().setForegroundColor('#94a3b8');
}
