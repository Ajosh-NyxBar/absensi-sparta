// ============================================================
// DOKUMENTASI JSON DATA API (Endpoint Langsung Return JSON)
// Sistem Informasi Absensi Guru & Penilaian Siswa SMPN 4 Purwakarta
// ============================================================
// CARA PAKAI:
// 1. Buka https://script.google.com
// 2. Klik "New Project"
// 3. Hapus semua kode yang ada, paste SEMUA kode ini
// 4. Klik tombol ▶ Run (pilih createJSONAPIDocs)
// 5. Pertama kali minta izin — klik "Review permissions" > pilih akun > "Allow"
// 6. Buka Google Docs yang dibuat (link di Logger / Execution Log)
// ============================================================

function createJSONAPIDocs() {
  var doc = DocumentApp.create('Dokumentasi JSON Data API — Sistem Presensi & Penilaian SMPN 4 Purwakarta');
  var body = doc.getBody();

  var C = {
    PRIMARY:  '#0d9488',
    DARK:     '#1e293b',
    HEAD_BG:  '#0f766e',
    ALT_BG:   '#f0fdfa',
    CODE_BG:  '#f1f5f9',
    GREEN:    '#16a34a',
    RED:      '#dc2626',
    ORANGE:   '#ea580c',
    PURPLE:   '#7c3aed',
    BLUE:     '#2563eb',
    ACCENT:   '#059669'
  };

  body.clear();

  writeCover_(body, C);
  body.appendPageBreak();
  writeTOC_(body, C);
  body.appendPageBreak();
  writeIntro_(body, C);
  body.appendPageBreak();
  writeAuth_(body, C);
  body.appendPageBreak();
  writeDashboard_(body, C);
  body.appendPageBreak();
  writeTeachers_(body, C);
  body.appendPageBreak();
  writeStudents_(body, C);
  body.appendPageBreak();
  writeUsers_(body, C);
  body.appendPageBreak();
  writeClasses_(body, C);
  body.appendPageBreak();
  writeSubjects_(body, C);
  body.appendPageBreak();
  writeAcademicYears_(body, C);
  body.appendPageBreak();
  writeGrades_(body, C);
  body.appendPageBreak();
  writeAttendances_(body, C);
  body.appendPageBreak();
  writeCriteria_(body, C);
  body.appendPageBreak();
  writeSAW_(body, C);
  body.appendPageBreak();
  writeTeacherSubjects_(body, C);
  body.appendPageBreak();
  writeSettings_(body, C);
  body.appendPageBreak();
  writeErrorRef_(body, C);

  doc.saveAndClose();
  Logger.log('Dokumentasi JSON API berhasil dibuat!');
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
  p.setForegroundColor(color || '#0f766e');
  p.setSpacingBefore(16); p.setSpacingAfter(8);
  return p;
}
function h3_(body, text, color) {
  var p = body.appendParagraph(text);
  p.setHeading(DocumentApp.ParagraphHeading.HEADING3);
  p.setForegroundColor(color || '#0d9488');
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
function table_(body, headers, rows, hBg, aBg) {
  hBg = hBg || '#0f766e'; aBg = aBg || '#f0fdfa';
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
function jsonBlock_(body, obj) {
  var json = JSON.stringify(obj, null, 2);
  var lines = json.split('\n');
  for (var i = 0; i < lines.length; i++) {
    code_(body, lines[i]);
  }
}
function endpoint_(body, method, url, C) {
  var color = method === 'GET' ? C.GREEN : method === 'POST' ? C.BLUE : method === 'PUT' ? C.ORANGE : C.RED;
  badge_(body, method + '  ' + url, color);
}


// ============================================================
// COVER
// ============================================================
function writeCover_(body, C) {
  body.appendParagraph('').setSpacingAfter(60);
  var title = body.appendParagraph('DOKUMENTASI JSON DATA API');
  title.setHeading(DocumentApp.ParagraphHeading.TITLE);
  title.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  title.setForegroundColor(C.PRIMARY);
  title.editAsText().setFontSize(28);

  var sub = body.appendParagraph('Endpoint yang Langsung Mengembalikan Data JSON');
  sub.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  sub.setForegroundColor(C.DARK);
  sub.editAsText().setFontSize(14);
  sub.setSpacingAfter(12);

  var line = body.appendParagraph('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
  line.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  line.setForegroundColor(C.PRIMARY);

  var app = body.appendParagraph('Sistem Informasi Presensi Guru & Penilaian Siswa');
  app.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  app.editAsText().setFontSize(12);
  app.setForegroundColor(C.DARK);

  var school = body.appendParagraph('SMPN 4 Purwakarta');
  school.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  school.editAsText().setFontSize(14);
  school.editAsText().setBold(true);
  school.setForegroundColor(C.PRIMARY);

  body.appendParagraph('').setSpacingAfter(20);
  var info = body.appendParagraph('Base URL: http://localhost:8000/api/v1');
  info.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  info.editAsText().setFontFamily('Courier New');
  info.editAsText().setFontSize(11);
  info.setForegroundColor(C.ACCENT);

  var note = body.appendParagraph('Semua endpoint mengembalikan JSON — bukan HTML');
  note.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  note.editAsText().setFontSize(11);
  note.setForegroundColor(C.ORANGE);
  note.editAsText().setBold(true);

  body.appendParagraph('').setSpacingAfter(20);
  var prefix = body.appendParagraph('Prefix: /api/v1/   |   Auth: Session Cookie   |   Format: JSON');
  prefix.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  prefix.editAsText().setFontSize(10);
  prefix.setForegroundColor('#64748b');

  var date = body.appendParagraph('Dibuat: ' + new Date().toLocaleDateString('id-ID', {day:'numeric',month:'long',year:'numeric'}));
  date.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  date.editAsText().setFontSize(10);
  date.setForegroundColor('#94a3b8');
}


// ============================================================
// TABLE OF CONTENTS
// ============================================================
function writeTOC_(body, C) {
  h1_(body, 'DAFTAR ISI', C.DARK);
  body.appendParagraph('');

  var chapters = [
    ['1', 'Pendahuluan & Base URL'],
    ['2', 'Autentikasi (Login via Session)'],
    ['3', 'Dashboard Stats'],
    ['4', 'Teachers (Guru)'],
    ['5', 'Students (Siswa)'],
    ['6', 'Users (Pengguna)'],
    ['7', 'Classes (Kelas)'],
    ['8', 'Subjects (Mata Pelajaran)'],
    ['9', 'Academic Years (Tahun Ajaran)'],
    ['10', 'Grades (Nilai)'],
    ['11', 'Attendances (Presensi)'],
    ['12', 'Criteria (Kriteria SAW)'],
    ['13', 'SAW Rankings (Peringkat)'],
    ['14', 'Teacher Subjects (Penugasan Guru)'],
    ['15', 'Settings (Pengaturan)'],
    ['16', 'Referensi Kode Error']
  ];

  for (var i = 0; i < chapters.length; i++) {
    var item = body.appendListItem('Bab ' + chapters[i][0] + ' — ' + chapters[i][1]);
    item.setGlyphType(DocumentApp.GlyphType.NUMBER);
    item.setLineSpacing(1.6);
    item.editAsText().setFontSize(11);
    if (i % 2 === 0) item.setForegroundColor(C.DARK);
  }
}


// ============================================================
// BAB 1 — INTRO
// ============================================================
function writeIntro_(body, C) {
  h1_(body, 'Bab 1 — Pendahuluan & Base URL', C.DARK);

  h2_(body, '1.1 Tentang Dokumen Ini', C.HEAD_BG);
  p_(body, 'Dokumen ini menjelaskan JSON Data API yang LANGSUNG mengembalikan data dalam format JSON — bukan HTML.');
  p_(body, 'API ini terpisah dari endpoint web biasa. Semua response berupa JSON murni yang bisa langsung digunakan oleh frontend JavaScript, Postman, atau aplikasi lainnya.');

  h2_(body, '1.2 Perbedaan dengan Web Endpoint', C.HEAD_BG);
  table_(body,
    ['Aspek', 'Web Endpoint', 'JSON Data API'],
    [
      ['URL Prefix', '/', '/api/v1/'],
      ['Response', 'HTML (Blade View)', 'JSON'],
      ['Contoh /teachers', '<html>...</html>', '{"data":[...], "current_page":1}'],
      ['Kegunaan', 'Tampilan web browser', 'Konsumsi data oleh app/frontend'],
      ['Auth', 'Session Cookie', 'Session Cookie (sama)']
    ]
  );

  h2_(body, '1.3 Base URL', C.HEAD_BG);
  code_(body, 'Base URL: http://localhost:8000/api/v1');
  p_(body, 'Semua endpoint dalam dokumen ini menggunakan prefix /api/v1/ diikuti resource name.');

  h2_(body, '1.4 Daftar Seluruh Endpoint', C.HEAD_BG);
  table_(body,
    ['Method', 'Endpoint', 'Keterangan'],
    [
      ['GET', '/api/v1/dashboard', 'Statistik dashboard'],
      ['GET', '/api/v1/teachers', 'Data semua guru (paginated)'],
      ['GET', '/api/v1/teachers/{id}', 'Detail guru'],
      ['GET', '/api/v1/students', 'Data semua siswa (paginated)'],
      ['GET', '/api/v1/students/{id}', 'Detail siswa'],
      ['GET', '/api/v1/users', 'Data semua user (paginated)'],
      ['GET', '/api/v1/users/{id}', 'Detail user'],
      ['GET', '/api/v1/classes', 'Data semua kelas'],
      ['GET', '/api/v1/classes/{id}', 'Detail kelas + siswa'],
      ['GET', '/api/v1/subjects', 'Data semua mata pelajaran'],
      ['GET', '/api/v1/subjects/{id}', 'Detail mata pelajaran'],
      ['GET', '/api/v1/academic-years', 'Tahun ajaran'],
      ['GET', '/api/v1/academic-years/{id}', 'Detail tahun ajaran'],
      ['GET', '/api/v1/grades', 'Data nilai (paginated)'],
      ['GET', '/api/v1/grades/{id}', 'Detail nilai'],
      ['GET', '/api/v1/attendances', 'Data presensi (paginated)'],
      ['GET', '/api/v1/criteria', 'Kriteria SAW'],
      ['GET', '/api/v1/saw/students', 'Ranking SAW siswa'],
      ['GET', '/api/v1/saw/teachers', 'Ranking SAW guru'],
      ['GET', '/api/v1/teacher-subjects', 'Penugasan guru-mapel-kelas'],
      ['GET', '/api/v1/settings', 'Pengaturan sistem']
    ]
  );

  h2_(body, '1.5 Format Response Umum', C.HEAD_BG);
  p_(body, 'Response List (non-paginated):');
  jsonBlock_(body, {
    data: ['array of objects']
  });
  p_(body, 'Response List (paginated):');
  jsonBlock_(body, {
    current_page: 1,
    data: ['array of objects'],
    first_page_url: 'http://localhost:8000/api/v1/resource?page=1',
    from: 1,
    last_page: 5,
    last_page_url: 'http://localhost:8000/api/v1/resource?page=5',
    next_page_url: 'http://localhost:8000/api/v1/resource?page=2',
    per_page: 15,
    prev_page_url: null,
    to: 15,
    total: 73
  });
  p_(body, 'Response Detail (single):');
  jsonBlock_(body, {
    data: { id: 1, '...': '...' }
  });
}


// ============================================================
// BAB 2 — AUTH
// ============================================================
function writeAuth_(body, C) {
  h1_(body, 'Bab 2 — Autentikasi', C.DARK);

  h2_(body, '2.1 Cara Login (Mendapatkan Session)', C.HEAD_BG);
  p_(body, 'API ini menggunakan session cookie. Anda harus login terlebih dahulu via web form atau via POST /login agar mendapatkan session cookie.');

  h3_(body, 'Step 1: GET CSRF Token + Session Cookie');
  endpoint_(body, 'GET', '/login', C);
  p_(body, 'Kirim GET ke /login. Response berupa HTML form, tapi yang penting adalah cookies yang dikirim (XSRF-TOKEN dan laravel_session).');

  h3_(body, 'Step 2: POST Login');
  endpoint_(body, 'POST', '/login', C);
  p_(body, 'Body (form-urlencoded):');
  table_(body,
    ['Field', 'Type', 'Contoh'],
    [
      ['email', 'string', 'admin@smpn4.sch.id'],
      ['password', 'string', 'password'],
      ['_token', 'string', '(dari cookie XSRF-TOKEN)']
    ]
  );
  p_(body, 'Response: Redirect 302 ke /dashboard. Sekarang cookie session Anda aktif, dan semua endpoint /api/v1/* bisa diakses.');

  h3_(body, 'Step 3: Gunakan Cookie untuk Request');
  p_(body, 'Di Postman/HTTP client, pastikan cookie disimpan dan dikirim di setiap request berikutnya.');
  p_(body, 'Jika session expired atau belum login, response:');
  jsonBlock_(body, { message: 'Unauthenticated.' });

  h2_(body, '2.2 Contoh cURL', C.HEAD_BG);
  code_(body, '# Step 1: Login dan simpan cookie');
  code_(body, 'curl -c cookies.txt -b cookies.txt \\');
  code_(body, '  -X POST http://localhost:8000/login \\');
  code_(body, '  -d "email=admin@smpn4.sch.id&password=password&_token=TOKEN"');
  code_(body, '');
  code_(body, '# Step 2: Akses JSON API');
  code_(body, 'curl -b cookies.txt http://localhost:8000/api/v1/teachers');

  h2_(body, '2.3 Contoh di Postman', C.HEAD_BG);
  p_(body, '1. Buat request GET /login — Postman otomatis simpan cookies');
  p_(body, '2. Buat request POST /login dengan body form-urlencoded');
  p_(body, '3. Setelah berhasil redirect, akses /api/v1/teachers');
  p_(body, '4. Pastikan "Cookies" tab di Postman menampilkan laravel_session');

  h2_(body, '2.4 Akun Default', C.HEAD_BG);
  table_(body,
    ['Role', 'Email', 'Password'],
    [
      ['Admin', 'admin@smpn4.sch.id', 'password'],
      ['Guru', 'guru@smpn4.sch.id', 'password'],
      ['Kepala Sekolah', 'kepsek@smpn4.sch.id', 'password'],
      ['Kiosk Presensi', 'kiosk@smpn4.sch.id', 'password']
    ]
  );
}


// ============================================================
// BAB 3 — DASHBOARD
// ============================================================
function writeDashboard_(body, C) {
  h1_(body, 'Bab 3 — Dashboard Stats', C.DARK);

  h2_(body, '3.1 GET /api/v1/dashboard', C.HEAD_BG);
  endpoint_(body, 'GET', '/api/v1/dashboard', C);
  p_(body, 'Mengembalikan statistik ringkasan dashboard.');

  pBold_(body, 'Response:');
  jsonBlock_(body, {
    data: {
      total_teachers: 25,
      total_students: 480,
      total_classes: 18,
      total_subjects: 12,
      today_teacher_attendance: 22,
      today_student_attendance: 445,
      teacher_attendance_percentage: 88.0
    }
  });

  pBold_(body, 'Keterangan Field:');
  table_(body,
    ['Field', 'Type', 'Keterangan'],
    [
      ['total_teachers', 'integer', 'Jumlah guru aktif (status=active)'],
      ['total_students', 'integer', 'Jumlah siswa aktif (status=active)'],
      ['total_classes', 'integer', 'Jumlah kelas'],
      ['total_subjects', 'integer', 'Jumlah mata pelajaran'],
      ['today_teacher_attendance', 'integer', 'Guru yang presensi hari ini'],
      ['today_student_attendance', 'integer', 'Siswa yang presensi hari ini'],
      ['teacher_attendance_percentage', 'float', 'Persentase presensi guru hari ini']
    ]
  );
}


// ============================================================
// BAB 4 — TEACHERS
// ============================================================
function writeTeachers_(body, C) {
  h1_(body, 'Bab 4 — Teachers (Guru)', C.DARK);

  // INDEX
  h2_(body, '4.1 GET /api/v1/teachers', C.HEAD_BG);
  endpoint_(body, 'GET', '/api/v1/teachers', C);
  p_(body, 'Mendapatkan daftar guru. Response berupa paginated JSON.');

  pBold_(body, 'Query Parameters:');
  table_(body,
    ['Parameter', 'Type', 'Required', 'Keterangan'],
    [
      ['search', 'string', 'Tidak', 'Cari berdasarkan nama/NIP'],
      ['status', 'string', 'Tidak', 'Filter: active / inactive'],
      ['per_page', 'integer', 'Tidak', 'Jumlah per halaman (default 15, max 100)'],
      ['page', 'integer', 'Tidak', 'Nomor halaman']
    ]
  );

  pBold_(body, 'Contoh Request:');
  code_(body, 'GET /api/v1/teachers?search=Budi&status=active&per_page=10&page=1');

  pBold_(body, 'Contoh Response:');
  jsonBlock_(body, {
    current_page: 1,
    data: [
      {
        id: 1,
        user_id: 2,
        nip: '198501012010011001',
        name: 'Budi Santoso, S.Pd.',
        gender: 'L',
        phone: '08123456789',
        address: 'Jl. Merdeka 10, Purwakarta',
        birth_date: '1985-01-01',
        photo: null,
        education_level: 'S1',
        position: 'Guru Tetap',
        status: 'active',
        user: { id: 2, name: 'Budi Santoso', email: 'budi@smpn4.sch.id', role_id: 2 },
        subjects: [
          { id: 1, name: 'Matematika', code: 'MTK' }
        ]
      }
    ],
    per_page: 10,
    total: 25,
    last_page: 3
  });

  pBold_(body, 'Keterangan Field Teacher:');
  table_(body,
    ['Field', 'Type', 'Keterangan'],
    [
      ['id', 'integer', 'ID guru'],
      ['user_id', 'integer', 'ID user (foreign key)'],
      ['nip', 'string', 'Nomor Induk Pegawai'],
      ['name', 'string', 'Nama lengkap guru'],
      ['gender', 'string', 'L = Laki-laki, P = Perempuan'],
      ['phone', 'string|null', 'Nomor telepon'],
      ['address', 'string|null', 'Alamat'],
      ['birth_date', 'date|null', 'Tanggal lahir (YYYY-MM-DD)'],
      ['photo', 'string|null', 'Path foto'],
      ['education_level', 'string|null', 'Jenjang pendidikan (S1, S2, dll)'],
      ['position', 'string|null', 'Jabatan'],
      ['status', 'string', 'active / inactive'],
      ['user', 'object', 'Data user terkait (id, name, email, role_id)'],
      ['subjects', 'array', 'Mata pelajaran yang diampu']
    ]
  );

  // SHOW
  h2_(body, '4.2 GET /api/v1/teachers/{id}', C.HEAD_BG);
  endpoint_(body, 'GET', '/api/v1/teachers/{id}', C);
  p_(body, 'Mendapatkan detail satu guru beserta data relasi lengkap.');

  pBold_(body, 'Path Parameter:');
  table_(body,
    ['Parameter', 'Type', 'Keterangan'],
    [['id', 'integer', 'ID guru']]
  );

  pBold_(body, 'Contoh Request:');
  code_(body, 'GET /api/v1/teachers/1');

  pBold_(body, 'Contoh Response:');
  jsonBlock_(body, {
    data: {
      id: 1,
      user_id: 2,
      nip: '198501012010011001',
      name: 'Budi Santoso, S.Pd.',
      gender: 'L',
      phone: '08123456789',
      address: 'Jl. Merdeka 10, Purwakarta',
      birth_date: '1985-01-01',
      photo: null,
      education_level: 'S1',
      position: 'Guru Tetap',
      status: 'active',
      user: { id: 2, name: 'Budi Santoso', email: 'budi@smpn4.sch.id', role_id: 2 },
      subjects: [{ id: 1, name: 'Matematika', code: 'MTK' }],
      teacher_subjects: [
        {
          id: 1,
          teacher_id: 1,
          subject_id: 1,
          class_id: 3,
          academic_year: '2024/2025',
          class_room: { id: 3, name: '7A', grade: '7' },
          subject: { id: 1, name: 'Matematika', code: 'MTK' }
        }
      ]
    }
  });
}


// ============================================================
// BAB 5 — STUDENTS
// ============================================================
function writeStudents_(body, C) {
  h1_(body, 'Bab 5 — Students (Siswa)', C.DARK);

  // INDEX
  h2_(body, '5.1 GET /api/v1/students', C.HEAD_BG);
  endpoint_(body, 'GET', '/api/v1/students', C);
  p_(body, 'Mendapatkan daftar siswa (paginated).');

  pBold_(body, 'Query Parameters:');
  table_(body,
    ['Parameter', 'Type', 'Required', 'Keterangan'],
    [
      ['search', 'string', 'Tidak', 'Cari berdasarkan nama/NIS/NISN'],
      ['class_id', 'integer', 'Tidak', 'Filter berdasarkan kelas'],
      ['status', 'string', 'Tidak', 'Filter: active / inactive / graduated'],
      ['per_page', 'integer', 'Tidak', 'Jumlah per halaman (default 15, max 100)'],
      ['page', 'integer', 'Tidak', 'Nomor halaman']
    ]
  );

  pBold_(body, 'Contoh Request:');
  code_(body, 'GET /api/v1/students?class_id=3&status=active&per_page=20');

  pBold_(body, 'Contoh Response:');
  jsonBlock_(body, {
    current_page: 1,
    data: [
      {
        id: 1,
        class_id: 3,
        nisn: '0012345678',
        nis: '12345',
        name: 'Andi Pratama',
        gender: 'L',
        phone: '081234567890',
        address: 'Jl. Sudirman 5',
        birth_date: '2010-05-15',
        birth_place: 'Purwakarta',
        photo: null,
        parent_name: 'Heru Pratama',
        parent_phone: '081298765432',
        status: 'active',
        class_room: { id: 3, name: '7A', grade: '7' }
      }
    ],
    per_page: 20,
    total: 32,
    last_page: 2
  });

  pBold_(body, 'Keterangan Field Student:');
  table_(body,
    ['Field', 'Type', 'Keterangan'],
    [
      ['id', 'integer', 'ID siswa'],
      ['class_id', 'integer', 'ID kelas'],
      ['nisn', 'string', 'Nomor Induk Siswa Nasional'],
      ['nis', 'string', 'Nomor Induk Siswa (lokal)'],
      ['name', 'string', 'Nama lengkap'],
      ['gender', 'string', 'L / P'],
      ['phone', 'string|null', 'Telepon'],
      ['address', 'string|null', 'Alamat'],
      ['birth_date', 'date|null', 'Tanggal lahir (YYYY-MM-DD)'],
      ['birth_place', 'string|null', 'Tempat lahir'],
      ['photo', 'string|null', 'Path foto'],
      ['parent_name', 'string|null', 'Nama orang tua'],
      ['parent_phone', 'string|null', 'Telepon orang tua'],
      ['status', 'string', 'active / inactive / graduated'],
      ['class_room', 'object', 'Data kelas (id, name, grade)']
    ]
  );

  // SHOW
  h2_(body, '5.2 GET /api/v1/students/{id}', C.HEAD_BG);
  endpoint_(body, 'GET', '/api/v1/students/{id}', C);
  p_(body, 'Detail siswa beserta nilai dan kelas.');

  pBold_(body, 'Contoh Request:');
  code_(body, 'GET /api/v1/students/1');

  pBold_(body, 'Contoh Response (potongan):');
  jsonBlock_(body, {
    data: {
      id: 1,
      name: 'Andi Pratama',
      nis: '12345',
      nisn: '0012345678',
      class_room: { id: 3, name: '7A', grade: '7' },
      grades: [
        {
          id: 10,
          subject_id: 1,
          teacher_id: 1,
          semester: 'Ganjil',
          academic_year: '2024/2025',
          daily_test: '85.00',
          midterm_exam: '80.00',
          final_exam: '78.00',
          final_grade: '81.00',
          subject: { id: 1, name: 'Matematika', code: 'MTK' },
          teacher: { id: 1, name: 'Budi Santoso, S.Pd.' }
        }
      ]
    }
  });
}


// ============================================================
// BAB 6 — USERS
// ============================================================
function writeUsers_(body, C) {
  h1_(body, 'Bab 6 — Users (Pengguna)', C.DARK);

  h2_(body, '6.1 GET /api/v1/users', C.HEAD_BG);
  endpoint_(body, 'GET', '/api/v1/users', C);
  p_(body, 'Daftar semua user/pengguna sistem (paginated).');

  pBold_(body, 'Query Parameters:');
  table_(body,
    ['Parameter', 'Type', 'Required', 'Keterangan'],
    [
      ['search', 'string', 'Tidak', 'Cari berdasarkan nama/email'],
      ['role', 'integer', 'Tidak', 'Filter role_id (1=Admin, 2=Guru, 3=Kepsek, 4=Kiosk)'],
      ['per_page', 'integer', 'Tidak', 'Jumlah per halaman (default 15, max 100)'],
      ['page', 'integer', 'Tidak', 'Nomor halaman']
    ]
  );

  pBold_(body, 'Contoh Request:');
  code_(body, 'GET /api/v1/users?role=2&search=budi');

  pBold_(body, 'Contoh Response:');
  jsonBlock_(body, {
    current_page: 1,
    data: [
      {
        id: 2,
        name: 'Budi Santoso',
        email: 'budi@smpn4.sch.id',
        role_id: 2,
        profile_photo: null,
        created_at: '2024-01-15T10:00:00.000000Z',
        role: { id: 2, name: 'Guru' }
      }
    ],
    per_page: 15,
    total: 25
  });

  h2_(body, '6.2 GET /api/v1/users/{id}', C.HEAD_BG);
  endpoint_(body, 'GET', '/api/v1/users/{id}', C);
  p_(body, 'Detail user termasuk relasi teacher (jika role guru).');

  pBold_(body, 'Contoh Response:');
  jsonBlock_(body, {
    data: {
      id: 2,
      name: 'Budi Santoso',
      email: 'budi@smpn4.sch.id',
      role_id: 2,
      profile_photo: null,
      role: { id: 2, name: 'Guru' },
      teacher: { id: 1, nip: '198501012010011001', name: 'Budi Santoso, S.Pd.', status: 'active' }
    }
  });
}


// ============================================================
// BAB 7 — CLASSES
// ============================================================
function writeClasses_(body, C) {
  h1_(body, 'Bab 7 — Classes (Kelas)', C.DARK);

  h2_(body, '7.1 GET /api/v1/classes', C.HEAD_BG);
  endpoint_(body, 'GET', '/api/v1/classes', C);
  p_(body, 'Daftar semua kelas (tidak dipaginasi, langsung semua data).');

  pBold_(body, 'Query Parameters:');
  table_(body,
    ['Parameter', 'Type', 'Required', 'Keterangan'],
    [['grade', 'string', 'Tidak', 'Filter tingkat: 7, 8, atau 9']]
  );

  pBold_(body, 'Contoh Response:');
  jsonBlock_(body, {
    data: [
      { id: 1, name: '7A', grade: '7', academic_year: '2024/2025', capacity: 32, students_count: 30 },
      { id: 2, name: '7B', grade: '7', academic_year: '2024/2025', capacity: 32, students_count: 31 },
      { id: 3, name: '8A', grade: '8', academic_year: '2024/2025', capacity: 30, students_count: 28 }
    ]
  });

  h2_(body, '7.2 GET /api/v1/classes/{id}', C.HEAD_BG);
  endpoint_(body, 'GET', '/api/v1/classes/{id}', C);
  p_(body, 'Detail kelas termasuk daftar siswa dan guru pengampu.');

  pBold_(body, 'Contoh Response:');
  jsonBlock_(body, {
    data: {
      id: 1,
      name: '7A',
      grade: '7',
      academic_year: '2024/2025',
      capacity: 32,
      students_count: 30,
      students: [
        { id: 1, class_id: 1, name: 'Andi Pratama', nis: '12345', nisn: '0012345678', gender: 'L', status: 'active' }
      ],
      teacher_subjects: [
        {
          id: 1,
          teacher: { id: 1, name: 'Budi Santoso, S.Pd.' },
          subject: { id: 1, name: 'Matematika', code: 'MTK' }
        }
      ]
    }
  });
}


// ============================================================
// BAB 8 — SUBJECTS
// ============================================================
function writeSubjects_(body, C) {
  h1_(body, 'Bab 8 — Subjects (Mata Pelajaran)', C.DARK);

  h2_(body, '8.1 GET /api/v1/subjects', C.HEAD_BG);
  endpoint_(body, 'GET', '/api/v1/subjects', C);
  p_(body, 'Daftar semua mata pelajaran.');

  pBold_(body, 'Contoh Response:');
  jsonBlock_(body, {
    data: [
      { id: 1, code: 'MTK', name: 'Matematika', description: 'Mata pelajaran Matematika', grades_count: 150, teacher_subjects_count: 5 },
      { id: 2, code: 'IPA', name: 'Ilmu Pengetahuan Alam', description: null, grades_count: 120, teacher_subjects_count: 4 }
    ]
  });

  h2_(body, '8.2 GET /api/v1/subjects/{id}', C.HEAD_BG);
  endpoint_(body, 'GET', '/api/v1/subjects/{id}', C);
  p_(body, 'Detail mata pelajaran termasuk guru pengampu dan kelas.');

  pBold_(body, 'Contoh Response:');
  jsonBlock_(body, {
    data: {
      id: 1,
      code: 'MTK',
      name: 'Matematika',
      description: 'Mata pelajaran Matematika',
      teacher_subjects: [
        {
          id: 1,
          teacher: { id: 1, name: 'Budi Santoso, S.Pd.' },
          class_room: { id: 1, name: '7A', grade: '7' }
        }
      ]
    }
  });
}


// ============================================================
// BAB 9 — ACADEMIC YEARS
// ============================================================
function writeAcademicYears_(body, C) {
  h1_(body, 'Bab 9 — Academic Years (Tahun Ajaran)', C.DARK);

  h2_(body, '9.1 GET /api/v1/academic-years', C.HEAD_BG);
  endpoint_(body, 'GET', '/api/v1/academic-years', C);
  p_(body, 'Daftar semua tahun ajaran, diurutkan dari terbaru.');

  pBold_(body, 'Contoh Response:');
  jsonBlock_(body, {
    data: [
      { id: 1, year: '2024/2025', semester: 'Ganjil', start_date: '2024-07-15', end_date: '2024-12-20', is_active: true, description: 'Tahun ajaran aktif' },
      { id: 2, year: '2024/2025', semester: 'Genap', start_date: '2025-01-06', end_date: '2025-06-20', is_active: false, description: null }
    ]
  });

  pBold_(body, 'Keterangan Field:');
  table_(body,
    ['Field', 'Type', 'Keterangan'],
    [
      ['id', 'integer', 'ID tahun ajaran'],
      ['year', 'string', 'Tahun ajaran (misal: 2024/2025)'],
      ['semester', 'string', 'Ganjil / Genap'],
      ['start_date', 'date', 'Tanggal mulai'],
      ['end_date', 'date', 'Tanggal selesai'],
      ['is_active', 'boolean', 'Apakah aktif saat ini'],
      ['description', 'string|null', 'Keterangan']
    ]
  );

  h2_(body, '9.2 GET /api/v1/academic-years/{id}', C.HEAD_BG);
  endpoint_(body, 'GET', '/api/v1/academic-years/{id}', C);
  p_(body, 'Detail satu tahun ajaran.');
}


// ============================================================
// BAB 10 — GRADES
// ============================================================
function writeGrades_(body, C) {
  h1_(body, 'Bab 10 — Grades (Nilai)', C.DARK);

  h2_(body, '10.1 GET /api/v1/grades', C.HEAD_BG);
  endpoint_(body, 'GET', '/api/v1/grades', C);
  p_(body, 'Daftar nilai siswa (paginated). Bisa difilter berdasarkan kelas, mata pelajaran, semester, tahun ajaran, atau siswa tertentu.');

  pBold_(body, 'Query Parameters:');
  table_(body,
    ['Parameter', 'Type', 'Required', 'Keterangan'],
    [
      ['class_id', 'integer', 'Tidak', 'Filter kelas'],
      ['subject_id', 'integer', 'Tidak', 'Filter mata pelajaran'],
      ['semester', 'string', 'Tidak', 'Filter: Ganjil / Genap'],
      ['academic_year', 'string', 'Tidak', 'Filter tahun ajaran (misal: 2024/2025)'],
      ['student_id', 'integer', 'Tidak', 'Filter siswa tertentu'],
      ['per_page', 'integer', 'Tidak', 'Jumlah per halaman (default 20, max 100)'],
      ['page', 'integer', 'Tidak', 'Nomor halaman']
    ]
  );

  pBold_(body, 'Contoh Request:');
  code_(body, 'GET /api/v1/grades?class_id=1&subject_id=1&semester=Ganjil&academic_year=2024/2025');

  pBold_(body, 'Contoh Response:');
  jsonBlock_(body, {
    current_page: 1,
    data: [
      {
        id: 10,
        student_id: 1,
        subject_id: 1,
        teacher_id: 1,
        semester: 'Ganjil',
        academic_year: '2024/2025',
        daily_test: '85.00',
        midterm_exam: '80.00',
        final_exam: '78.00',
        final_grade: '81.00',
        behavior_score: '88.00',
        skill_score: '82.00',
        notes: 'Baik',
        student: {
          id: 1, name: 'Andi Pratama', nis: '12345', class_id: 3,
          class_room: { id: 3, name: '7A', grade: '7' }
        },
        subject: { id: 1, name: 'Matematika', code: 'MTK' },
        teacher: { id: 1, name: 'Budi Santoso, S.Pd.' }
      }
    ],
    per_page: 20,
    total: 30
  });

  pBold_(body, 'Keterangan Field Grade:');
  table_(body,
    ['Field', 'Type', 'Keterangan'],
    [
      ['id', 'integer', 'ID nilai'],
      ['student_id', 'integer', 'ID siswa'],
      ['subject_id', 'integer', 'ID mata pelajaran'],
      ['teacher_id', 'integer', 'ID guru penilai'],
      ['semester', 'string', 'Ganjil / Genap'],
      ['academic_year', 'string', 'Tahun ajaran'],
      ['daily_test', 'decimal', 'Nilai ulangan harian'],
      ['midterm_exam', 'decimal', 'Nilai UTS'],
      ['final_exam', 'decimal', 'Nilai UAS'],
      ['final_grade', 'decimal', 'Nilai akhir'],
      ['behavior_score', 'decimal', 'Nilai sikap'],
      ['skill_score', 'decimal', 'Nilai keterampilan'],
      ['notes', 'string|null', 'Catatan guru']
    ]
  );

  h2_(body, '10.2 GET /api/v1/grades/{id}', C.HEAD_BG);
  endpoint_(body, 'GET', '/api/v1/grades/{id}', C);
  p_(body, 'Detail satu nilai tertentu.');
}


// ============================================================
// BAB 11 — ATTENDANCES
// ============================================================
function writeAttendances_(body, C) {
  h1_(body, 'Bab 11 — Attendances (Presensi)', C.DARK);

  h2_(body, '11.1 GET /api/v1/attendances', C.HEAD_BG);
  endpoint_(body, 'GET', '/api/v1/attendances', C);
  p_(body, 'Daftar presensi (guru dan/atau siswa). Response paginated.');

  pBold_(body, 'Query Parameters:');
  table_(body,
    ['Parameter', 'Type', 'Required', 'Keterangan'],
    [
      ['type', 'string', 'Tidak', 'Filter: teacher / student'],
      ['date', 'date', 'Tidak', 'Filter tanggal tertentu (YYYY-MM-DD)'],
      ['start_date', 'date', 'Tidak', 'Rentang mulai (gunakan bersama end_date)'],
      ['end_date', 'date', 'Tidak', 'Rentang akhir'],
      ['status', 'string', 'Tidak', 'Filter: hadir / izin / sakit / alpha'],
      ['per_page', 'integer', 'Tidak', 'Jumlah per halaman (default 20, max 100)'],
      ['page', 'integer', 'Tidak', 'Nomor halaman']
    ]
  );

  pBold_(body, 'Contoh Request:');
  code_(body, 'GET /api/v1/attendances?type=teacher&date=2024-12-10');

  pBold_(body, 'Contoh Response:');
  jsonBlock_(body, {
    current_page: 1,
    data: [
      {
        id: 100,
        attendable_type: 'App\\Models\\Teacher',
        attendable_id: 1,
        date: '2024-12-10',
        check_in: '07:15:00',
        check_out: '14:30:00',
        status: 'hadir',
        latitude_in: '-6.556789',
        longitude_in: '107.441234',
        latitude_out: '-6.556789',
        longitude_out: '107.441234',
        qr_code: 'QR-TCH-1-20241210',
        notes: null,
        attendable: { id: 1, name: 'Budi Santoso, S.Pd.' }
      }
    ],
    per_page: 20,
    total: 22
  });

  pBold_(body, 'Keterangan Field Attendance:');
  table_(body,
    ['Field', 'Type', 'Keterangan'],
    [
      ['id', 'integer', 'ID presensi'],
      ['attendable_type', 'string', 'App\\Models\\Teacher atau App\\Models\\Student'],
      ['attendable_id', 'integer', 'ID guru/siswa'],
      ['date', 'date', 'Tanggal presensi'],
      ['check_in', 'time|null', 'Jam masuk (HH:MM:SS)'],
      ['check_out', 'time|null', 'Jam keluar'],
      ['status', 'string', 'hadir / izin / sakit / alpha'],
      ['latitude_in', 'string|null', 'Latitude check-in'],
      ['longitude_in', 'string|null', 'Longitude check-in'],
      ['latitude_out', 'string|null', 'Latitude check-out'],
      ['longitude_out', 'string|null', 'Longitude check-out'],
      ['qr_code', 'string|null', 'Kode QR yang digunakan'],
      ['notes', 'string|null', 'Catatan'],
      ['attendable', 'object', 'Data guru/siswa (id, name)']
    ]
  );

  p_(body, 'Note: Field attendable_type menunjukkan apakah presensi milik guru atau siswa. Gunakan query parameter type=teacher atau type=student untuk memfilter.');
}


// ============================================================
// BAB 12 — CRITERIA
// ============================================================
function writeCriteria_(body, C) {
  h1_(body, 'Bab 12 — Criteria (Kriteria SAW)', C.DARK);

  h2_(body, '12.1 GET /api/v1/criteria', C.HEAD_BG);
  endpoint_(body, 'GET', '/api/v1/criteria', C);
  p_(body, 'Mendapatkan semua kriteria SAW, dikelompokkan berdasarkan target (student/teacher).');

  pBold_(body, 'Contoh Response:');
  jsonBlock_(body, {
    data: {
      student: [
        { id: 1, code: 'C1', name: 'Nilai Akademik', type: 'benefit', weight: 0.35, 'for': 'student', description: 'Rata-rata nilai akademik siswa' },
        { id: 2, code: 'C2', name: 'Kehadiran', type: 'benefit', weight: 0.25, 'for': 'student', description: 'Persentase kehadiran siswa' },
        { id: 3, code: 'C3', name: 'Sikap', type: 'benefit', weight: 0.20, 'for': 'student', description: 'Nilai perilaku siswa' },
        { id: 4, code: 'C4', name: 'Keterampilan', type: 'benefit', weight: 0.20, 'for': 'student', description: 'Nilai keterampilan siswa' }
      ],
      teacher: [
        { id: 5, code: 'C1', name: 'Kehadiran Guru', type: 'benefit', weight: 0.25, 'for': 'teacher', description: 'Persentase kehadiran mengajar' },
        { id: 6, code: 'C2', name: 'Kualitas Mengajar', type: 'benefit', weight: 0.30, 'for': 'teacher', description: 'Skor kualitas mengajar' },
        { id: 7, code: 'C3', name: 'Prestasi Siswa', type: 'benefit', weight: 0.25, 'for': 'teacher', description: 'Rata-rata prestasi siswa' },
        { id: 8, code: 'C4', name: 'Kedisiplinan', type: 'benefit', weight: 0.20, 'for': 'teacher', description: 'Skor kedisiplinan guru' }
      ],
      student_total_weight: 1.0,
      teacher_total_weight: 1.0
    }
  });

  pBold_(body, 'Keterangan Field Criteria:');
  table_(body,
    ['Field', 'Type', 'Keterangan'],
    [
      ['id', 'integer', 'ID kriteria'],
      ['code', 'string', 'Kode (C1, C2, C3, C4)'],
      ['name', 'string', 'Nama kriteria'],
      ['type', 'string', 'benefit / cost'],
      ['weight', 'float', 'Bobot (0.0 - 1.0)'],
      ['for', 'string', 'student / teacher'],
      ['description', 'string|null', 'Deskripsi']
    ]
  );

  p_(body, 'Catatan: type=benefit berarti semakin tinggi semakin baik. type=cost berarti semakin rendah semakin baik. Total weight untuk setiap group (student/teacher) harus = 1.0.');
}


// ============================================================
// BAB 13 — SAW RANKINGS
// ============================================================
function writeSAW_(body, C) {
  h1_(body, 'Bab 13 — SAW Rankings (Peringkat)', C.DARK);
  p_(body, 'Endpoint untuk mendapatkan hasil perangkingan metode SAW (Simple Additive Weighting).');

  // STUDENT SAW
  h2_(body, '13.1 GET /api/v1/saw/students', C.HEAD_BG);
  endpoint_(body, 'GET', '/api/v1/saw/students', C);
  p_(body, 'Peringkat SAW siswa.');

  pBold_(body, 'Query Parameters:');
  table_(body,
    ['Parameter', 'Type', 'Required', 'Keterangan'],
    [
      ['class_id', 'integer', 'Tidak', 'Filter kelas tertentu'],
      ['semester', 'string', 'Tidak', 'Filter semester: Ganjil / Genap'],
      ['academic_year', 'string', 'Tidak', 'Filter tahun ajaran']
    ]
  );

  pBold_(body, 'Contoh Request:');
  code_(body, 'GET /api/v1/saw/students?class_id=1&semester=Ganjil&academic_year=2024/2025');

  pBold_(body, 'Contoh Response:');
  jsonBlock_(body, {
    data: [
      {
        id: 1,
        student_id: 1,
        class_id: 1,
        semester: 'Ganjil',
        academic_year: '2024/2025',
        academic_score: '85.00',
        attendance_score: '95.00',
        behavior_score: '88.00',
        skill_score: '82.00',
        saw_score: '0.8750',
        rank: 1,
        student: {
          id: 1, name: 'Andi Pratama', nis: '12345', nisn: '0012345678', class_id: 1,
          class_room: { id: 1, name: '7A', grade: '7' }
        }
      },
      {
        id: 2,
        student_id: 5,
        class_id: 1,
        semester: 'Ganjil',
        academic_year: '2024/2025',
        academic_score: '80.00',
        attendance_score: '90.00',
        behavior_score: '85.00',
        skill_score: '79.00',
        saw_score: '0.8200',
        rank: 2,
        student: {
          id: 5, name: 'Dina Rahmawati', nis: '12349', nisn: '0012345682', class_id: 1,
          class_room: { id: 1, name: '7A', grade: '7' }
        }
      }
    ]
  });

  pBold_(body, 'Keterangan Field StudentAssessment:');
  table_(body,
    ['Field', 'Type', 'Keterangan'],
    [
      ['id', 'integer', 'ID assessment'],
      ['student_id', 'integer', 'ID siswa'],
      ['class_id', 'integer', 'ID kelas'],
      ['semester', 'string', 'Ganjil / Genap'],
      ['academic_year', 'string', 'Tahun ajaran'],
      ['academic_score', 'decimal', 'Skor akademik (C1)'],
      ['attendance_score', 'decimal', 'Skor kehadiran (C2)'],
      ['behavior_score', 'decimal', 'Skor sikap (C3)'],
      ['skill_score', 'decimal', 'Skor keterampilan (C4)'],
      ['saw_score', 'decimal', 'Skor SAW akhir (0.0 - 1.0)'],
      ['rank', 'integer', 'Peringkat (1 = terbaik)']
    ]
  );

  // TEACHER SAW
  h2_(body, '13.2 GET /api/v1/saw/teachers', C.HEAD_BG);
  endpoint_(body, 'GET', '/api/v1/saw/teachers', C);
  p_(body, 'Peringkat SAW guru.');

  pBold_(body, 'Query Parameters:');
  table_(body,
    ['Parameter', 'Type', 'Required', 'Keterangan'],
    [
      ['period', 'string', 'Tidak', 'Filter periode penilaian'],
      ['academic_year', 'string', 'Tidak', 'Filter tahun ajaran']
    ]
  );

  pBold_(body, 'Contoh Request:');
  code_(body, 'GET /api/v1/saw/teachers?academic_year=2024/2025');

  pBold_(body, 'Contoh Response:');
  jsonBlock_(body, {
    data: [
      {
        id: 1,
        teacher_id: 1,
        period: 'Semester Ganjil 2024/2025',
        academic_year: '2024/2025',
        attendance_score: '95.00',
        teaching_quality: '88.00',
        student_achievement: '85.00',
        discipline_score: '90.00',
        saw_score: '0.9050',
        rank: 1,
        notes: 'Sangat Baik',
        teacher: { id: 1, name: 'Budi Santoso, S.Pd.', nip: '198501012010011001' }
      },
      {
        id: 2,
        teacher_id: 3,
        period: 'Semester Ganjil 2024/2025',
        academic_year: '2024/2025',
        attendance_score: '90.00',
        teaching_quality: '85.00',
        student_achievement: '82.00',
        discipline_score: '88.00',
        saw_score: '0.8600',
        rank: 2,
        notes: 'Baik',
        teacher: { id: 3, name: 'Siti Nurhaliza, S.Pd.', nip: '198706152011012001' }
      }
    ]
  });

  pBold_(body, 'Keterangan Field TeacherAssessment:');
  table_(body,
    ['Field', 'Type', 'Keterangan'],
    [
      ['id', 'integer', 'ID assessment'],
      ['teacher_id', 'integer', 'ID guru'],
      ['period', 'string', 'Periode penilaian'],
      ['academic_year', 'string', 'Tahun ajaran'],
      ['attendance_score', 'decimal', 'Skor kehadiran (C1)'],
      ['teaching_quality', 'decimal', 'Skor kualitas mengajar (C2)'],
      ['student_achievement', 'decimal', 'Skor prestasi siswa (C3)'],
      ['discipline_score', 'decimal', 'Skor kedisiplinan (C4)'],
      ['saw_score', 'decimal', 'Skor SAW akhir (0.0 - 1.0)'],
      ['rank', 'integer', 'Peringkat (1 = terbaik)'],
      ['notes', 'string|null', 'Catatan penilaian']
    ]
  );
}


// ============================================================
// BAB 14 — TEACHER SUBJECTS
// ============================================================
function writeTeacherSubjects_(body, C) {
  h1_(body, 'Bab 14 — Teacher Subjects (Penugasan Guru)', C.DARK);

  h2_(body, '14.1 GET /api/v1/teacher-subjects', C.HEAD_BG);
  endpoint_(body, 'GET', '/api/v1/teacher-subjects', C);
  p_(body, 'Daftar penugasan guru ke mata pelajaran dan kelas.');

  pBold_(body, 'Query Parameters:');
  table_(body,
    ['Parameter', 'Type', 'Required', 'Keterangan'],
    [
      ['teacher_id', 'integer', 'Tidak', 'Filter guru tertentu'],
      ['class_id', 'integer', 'Tidak', 'Filter kelas tertentu']
    ]
  );

  pBold_(body, 'Contoh Request:');
  code_(body, 'GET /api/v1/teacher-subjects?teacher_id=1');

  pBold_(body, 'Contoh Response:');
  jsonBlock_(body, {
    data: [
      {
        id: 1,
        teacher_id: 1,
        subject_id: 1,
        class_id: 1,
        academic_year: '2024/2025',
        teacher: { id: 1, name: 'Budi Santoso, S.Pd.', nip: '198501012010011001' },
        subject: { id: 1, name: 'Matematika', code: 'MTK' },
        class_room: { id: 1, name: '7A', grade: '7' }
      },
      {
        id: 2,
        teacher_id: 1,
        subject_id: 1,
        class_id: 2,
        academic_year: '2024/2025',
        teacher: { id: 1, name: 'Budi Santoso, S.Pd.', nip: '198501012010011001' },
        subject: { id: 1, name: 'Matematika', code: 'MTK' },
        class_room: { id: 2, name: '7B', grade: '7' }
      }
    ]
  });

  pBold_(body, 'Keterangan Field:');
  table_(body,
    ['Field', 'Type', 'Keterangan'],
    [
      ['id', 'integer', 'ID penugasan'],
      ['teacher_id', 'integer', 'ID guru'],
      ['subject_id', 'integer', 'ID mata pelajaran'],
      ['class_id', 'integer', 'ID kelas'],
      ['academic_year', 'string', 'Tahun ajaran'],
      ['teacher', 'object', 'Data guru (id, name, nip)'],
      ['subject', 'object', 'Data mapel (id, name, code)'],
      ['class_room', 'object', 'Data kelas (id, name, grade)']
    ]
  );
}


// ============================================================
// BAB 15 — SETTINGS
// ============================================================
function writeSettings_(body, C) {
  h1_(body, 'Bab 15 — Settings (Pengaturan)', C.DARK);

  h2_(body, '15.1 GET /api/v1/settings', C.HEAD_BG);
  endpoint_(body, 'GET', '/api/v1/settings', C);
  p_(body, 'Semua pengaturan sistem, dikelompokkan berdasarkan group.');

  pBold_(body, 'Contoh Response:');
  jsonBlock_(body, {
    data: {
      general: {
        app_name: 'Sistem Presensi & Penilaian SMPN 4 Purwakarta',
        school_name: 'SMPN 4 Purwakarta',
        school_address: 'Jl. Ibrahim Singadilaga No.1'
      },
      attendance: {
        check_in_start: '06:00',
        check_in_end: '08:00',
        check_out_start: '13:00',
        check_out_end: '16:00',
        qr_expiry_minutes: '5',
        geofence_radius: '100'
      },
      grading: {
        daily_test_weight: '0.30',
        midterm_weight: '0.30',
        final_exam_weight: '0.40'
      }
    }
  });

  p_(body, 'Catatan: Response dikelompokkan (grouped) berdasarkan field group di tabel settings. Setiap group berisi key-value pairs.');
}


// ============================================================
// BAB 16 — ERROR REFERENCE
// ============================================================
function writeErrorRef_(body, C) {
  h1_(body, 'Bab 16 — Referensi Error', C.DARK);

  h2_(body, '16.1 HTTP Status Codes', C.HEAD_BG);
  table_(body,
    ['Status', 'Arti', 'Kapan Terjadi'],
    [
      ['200', 'OK', 'Request berhasil, data JSON dikembalikan'],
      ['302', 'Redirect', 'Belum login — diarahkan ke /login (bukan JSON!)'],
      ['401', 'Unauthorized', 'Session expired atau belum login'],
      ['403', 'Forbidden', 'Tidak punya akses ke resource ini'],
      ['404', 'Not Found', 'Resource dengan ID tersebut tidak ditemukan'],
      ['419', 'Page Expired', 'CSRF token expired (untuk POST request)'],
      ['422', 'Validation Error', 'Parameter tidak valid'],
      ['500', 'Server Error', 'Internal server error']
    ]
  );

  h2_(body, '16.2 Contoh Error Response', C.HEAD_BG);

  h3_(body, '401 Unauthorized:');
  jsonBlock_(body, { message: 'Unauthenticated.' });

  h3_(body, '404 Not Found:');
  jsonBlock_(body, { message: 'No query results for model [App\\Models\\Teacher] 999.' });

  h3_(body, '403 Forbidden:');
  jsonBlock_(body, { message: 'This action is unauthorized.' });

  h2_(body, '16.3 Tips Troubleshooting', C.HEAD_BG);
  bullet_(body, 'Selalu pastikan sudah login dan cookie session dikirim');
  bullet_(body, 'Gunakan Accept: application/json header agar error juga dikembalikan sebagai JSON');
  bullet_(body, 'Jika dapat redirect 302, artinya session belum aktif — login ulang');
  bullet_(body, 'Untuk POST/PUT/DELETE, sertakan CSRF token di header X-XSRF-TOKEN');
  bullet_(body, 'Check console/log jika mendapat 500 error');

  h2_(body, '16.4 Header yang Disarankan', C.HEAD_BG);
  table_(body,
    ['Header', 'Value', 'Keterangan'],
    [
      ['Accept', 'application/json', 'Agar error response juga JSON'],
      ['X-Requested-With', 'XMLHttpRequest', 'Menandai sebagai AJAX request'],
      ['Cookie', 'laravel_session=xxx', 'Session cookie (otomatis di browser/Postman)']
    ]
  );

  body.appendParagraph('').setSpacingAfter(30);
  var end = body.appendParagraph('— Akhir Dokumentasi JSON Data API —');
  end.setAlignment(DocumentApp.HorizontalAlignment.CENTER);
  end.setForegroundColor('#94a3b8');
  end.editAsText().setFontSize(11);
  end.editAsText().setItalic(true);
}
