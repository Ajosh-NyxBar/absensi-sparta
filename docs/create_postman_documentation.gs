// ============================================================
// DOKUMENTASI API POSTMAN — Google Apps Script
// Sistem Informasi Absensi Guru & Penilaian Siswa SMPN 4 Purwakarta
// ============================================================
// CARA PAKAI:
// 1. Buka https://script.google.com
// 2. Klik "New Project"
// 3. Hapus semua kode yang ada, paste SEMUA kode ini
// 4. Klik tombol ▶ Run (pilih createPostmanDocumentation)
// 5. Pertama kali minta izin — klik "Review permissions" > pilih akun > "Allow"
// 6. Buka Google Sheets yang dibuat (link di Logger / Execution Log)
// ============================================================

function createPostmanDocumentation() {
  var ss = SpreadsheetApp.create('Dokumentasi API - Sistem Absensi Guru SMPN 4 Purwakarta');
  PropertiesService.getScriptProperties().setProperty('SHEET_ID', ss.getId());

  // ===== SHEET 1: OVERVIEW =====
  createOverviewSheet_(ss);

  // ===== SHEET 2-19: PER MODUL =====
  createAuthSheet_(ss);
  createProfileSheet_(ss);
  createUserSheet_(ss);
  createTeacherSheet_(ss);
  createStudentSheet_(ss);
  createClassSheet_(ss);
  createSubjectSheet_(ss);
  createAcademicYearSheet_(ss);
  createTeacherSubjectSheet_(ss);
  createAttendanceSheet_(ss);
  createKioskSheet_(ss);
  createGradeSheet_(ss);
  createSAWSheet_(ss);
  createCriteriaSheet_(ss);
  createReportSheet_(ss);
  createSettingsSheet_(ss);
  createNotificationSheet_(ss);
  createMiscSheet_(ss);

  // Hapus Sheet1 default
  var defaultSheet = ss.getSheetByName('Sheet1');
  if (defaultSheet) ss.deleteSheet(defaultSheet);

  Logger.log('✅ Dokumentasi API berhasil dibuat!');
  Logger.log('📋 Buka: ' + ss.getUrl());
  Logger.log('🔑 ID: ' + ss.getId());
}

// ============================================================
// HELPER FUNCTIONS
// ============================================================
function setHeaderRow_(sheet, headers) {
  var range = sheet.getRange(1, 1, 1, headers.length);
  range.setValues([headers]);
  range.setFontWeight('bold');
  range.setBackground('#4F46E5');
  range.setFontColor('#FFFFFF');
  range.setHorizontalAlignment('center');
  sheet.setFrozenRows(1);
  for (var i = 0; i < headers.length; i++) {
    sheet.setColumnWidth(i + 1, getColumnWidth_(headers[i]));
  }
}

function getColumnWidth_(header) {
  var widths = {
    'No': 40, '#': 40,
    'Method': 70, 'HTTP': 70,
    'Endpoint': 280,
    'Deskripsi': 350, 'Description': 350,
    'Parameter': 300, 'Parameters': 300,
    'Validasi': 250, 'Validation': 250,
    'Response': 350,
    'Auth': 80,
    'Role': 120,
    'Content-Type': 130,
    'Body Example': 350,
    'Catatan': 300, 'Notes': 300
  };
  return widths[header] || 200;
}

function addDataRows_(sheet, data, startRow) {
  if (data.length === 0) return;
  var range = sheet.getRange(startRow, 1, data.length, data[0].length);
  range.setValues(data);
  range.setVerticalAlignment('top');
  range.setWrap(true);

  // Alternate row colors
  for (var i = 0; i < data.length; i++) {
    var rowRange = sheet.getRange(startRow + i, 1, 1, data[0].length);
    if (i % 2 === 0) {
      rowRange.setBackground('#F9FAFB');
    } else {
      rowRange.setBackground('#FFFFFF');
    }
  }

  // Color-code HTTP Methods
  for (var j = 0; j < data.length; j++) {
    var method = data[j][1]; // kolom Method
    var methodCell = sheet.getRange(startRow + j, 2);
    methodCell.setFontWeight('bold');
    methodCell.setHorizontalAlignment('center');
    if (method === 'GET') {
      methodCell.setFontColor('#059669');
    } else if (method === 'POST') {
      methodCell.setFontColor('#D97706');
    } else if (method === 'PUT') {
      methodCell.setFontColor('#2563EB');
    } else if (method === 'DELETE') {
      methodCell.setFontColor('#DC2626');
    }
  }
}

function addSectionTitle_(sheet, row, title, colCount) {
  var range = sheet.getRange(row, 1, 1, colCount);
  range.merge();
  range.setValue(title);
  range.setFontWeight('bold');
  range.setFontSize(12);
  range.setBackground('#EEF2FF');
  range.setFontColor('#3730A3');
}

// ============================================================
// SHEET: OVERVIEW
// ============================================================
function createOverviewSheet_(ss) {
  var sheet = ss.insertSheet('Overview');

  // Title
  sheet.getRange('A1:F1').merge().setValue('DOKUMENTASI API — Sistem Informasi Absensi Guru & Penilaian Siswa');
  sheet.getRange('A1').setFontSize(16).setFontWeight('bold').setFontColor('#1E1B4B');
  sheet.getRange('A2:F2').merge().setValue('SMPN 4 Purwakarta | Laravel 12 | PHP ≥ 8.2 | MySQL');
  sheet.getRange('A2').setFontSize(11).setFontColor('#6B7280');

  // Info Umum
  var info = [
    ['', ''],
    ['INFORMASI UMUM', ''],
    ['Base URL', 'http://localhost:8000'],
    ['Authentication', 'Session-based (Cookie + CSRF Token)'],
    ['CSRF Token', 'Diambil dari cookie XSRF-TOKEN atau meta tag csrf-token'],
    ['Content-Type', 'application/x-www-form-urlencoded (form), multipart/form-data (file upload), application/json (AJAX)'],
    ['Response Format', 'HTML (halaman web) atau JSON (endpoint AJAX/API)'],
    ['Pagination', 'Default 10-20 items per page'],
    ['File Upload', 'Max 2MB, format image (jpg, png, gif, svg)'],
    ['Geolocation', 'Validasi radius 100m dari koordinat sekolah (-6.5465236, 107.4414175)'],
    ['QR Code', 'Enkripsi AES-256-CBC, expired 600 detik (10 menit)'],
    ['', ''],
    ['ROLE & HAK AKSES', ''],
    ['Admin', 'Akses penuh ke semua fitur: CRUD data, settings, reports, SAW'],
    ['Guru', 'Attendance (scan QR), input nilai, lihat kelas sendiri, profil'],
    ['Kepala Sekolah', 'Lihat ranking SAW siswa & guru, rapor siswa, dashboard'],
    ['Kiosk Presensi', 'Display QR Code di monitor depan ruang guru'],
    ['', ''],
    ['DAFTAR MODUL (19 Folder)', ''],
    ['01. Authentication', 'Login, logout, dashboard redirect'],
    ['02. Profile Management', 'Edit profil & ganti password'],
    ['03. User Management', 'CRUD pengguna sistem (Admin only)'],
    ['04. Teacher Management', 'CRUD data guru (Admin only)'],
    ['05. Student Management', 'CRUD data siswa (Admin only)'],
    ['06. Class Management', 'CRUD data kelas (Admin only)'],
    ['07. Subject Management', 'CRUD mata pelajaran (Admin only)'],
    ['08. Academic Year', 'CRUD tahun ajaran (Admin only)'],
    ['09. Teacher-Subject', 'Penugasan guru-mapel-kelas (Admin only)'],
    ['10. Attendance & QR Code', 'Absensi QR + validasi geolokasi'],
    ['11. Kiosk Mode', 'Display monitor & scan QR (public + auth)'],
    ['12. Grade Management', 'Input & kelola nilai (Admin + Guru)'],
    ['13. SAW Calculation', 'Ranking siswa & guru (Admin + Kepsek)'],
    ['14. Criteria Management', 'CRUD kriteria SAW (Admin only)'],
    ['15. Reports & Export', 'Export ke Excel/PDF (Admin only)'],
    ['16. Settings', 'Pengaturan sistem (Admin only)'],
    ['17. Notifications', 'API notifikasi real-time (semua user)'],
    ['18. Teacher Features', 'Fitur khusus guru (my-classes, my-profile)'],
    ['19. Language & Misc', 'Ganti bahasa (id/en)'],
    ['', ''],
    ['TOTAL ENDPOINT', '~80+ endpoint (GET, POST, PUT, DELETE)'],
    ['', ''],
    ['CARA IMPORT KE POSTMAN', ''],
    ['Langkah 1', 'Buka Postman → klik Import (Ctrl+O)'],
    ['Langkah 2', 'Pilih file Postman_Collection.json dari folder docs/'],
    ['Langkah 3', 'Collection akan tampil di sidebar — buka folder per modul'],
    ['Langkah 4', 'Set variable base_url = http://localhost:8000'],
    ['Langkah 5', 'Jalankan GET Login Page dulu untuk ambil CSRF token'],
    ['Langkah 6', 'POST Login dengan email & password → cookie session tersimpan otomatis']
  ];

  sheet.getRange(3, 1, info.length, 2).setValues(info);
  sheet.getRange('A4').setFontWeight('bold').setFontSize(12).setFontColor('#4F46E5');
  sheet.getRange('A14').setFontWeight('bold').setFontSize(12).setFontColor('#4F46E5');
  sheet.getRange('A20').setFontWeight('bold').setFontSize(12).setFontColor('#4F46E5');
  sheet.getRange('A41').setFontWeight('bold').setFontSize(12).setFontColor('#4F46E5');
  sheet.getRange('A44').setFontWeight('bold').setFontSize(12).setFontColor('#4F46E5');

  sheet.setColumnWidth(1, 250);
  sheet.setColumnWidth(2, 500);
}

// ============================================================
// SHEET: 01. AUTHENTICATION
// ============================================================
function createAuthSheet_(ss) {
  var sheet = ss.insertSheet('01. Authentication');
  var headers = ['No', 'Method', 'Endpoint', 'Deskripsi', 'Parameters', 'Validasi', 'Response', 'Auth'];
  setHeaderRow_(sheet, headers);

  var data = [
    [1, 'GET', '/login', 'Menampilkan halaman login.\nMengambil CSRF token dari cookie.', '-', '-', 'View: auth.login\n(schoolName, schoolLogo, appName)', 'Guest'],
    [2, 'POST', '/login', 'Proses login ke sistem.\nRedirect ke dashboard sesuai role.', 'email (required, email)\npassword (required)\nremember (optional: on)', 'email: required, email\npassword: required', 'Redirect → /dashboard\natau back with errors', 'Guest'],
    [3, 'POST', '/logout', 'Logout dari sistem.\nHapus session.', '_token (CSRF)', '-', 'Redirect → /login', 'Auth'],
    [4, 'GET', '/dashboard', 'Redirect ke dashboard sesuai role:\n• Admin → admin-modern\n• Guru → teacher\n• Kepsek → headmaster\n• Kiosk → kiosk-dashboard', 'month (query, optional)\nyear (query, optional)', '-', 'View sesuai role\n(statistik, grafik, tabel)', 'Auth']
  ];

  addDataRows_(sheet, data, 2);
}

// ============================================================
// SHEET: 02. PROFILE
// ============================================================
function createProfileSheet_(ss) {
  var sheet = ss.insertSheet('02. Profile');
  var headers = ['No', 'Method', 'Endpoint', 'Deskripsi', 'Parameters', 'Validasi', 'Response', 'Auth'];
  setHeaderRow_(sheet, headers);

  var data = [
    [1, 'GET', '/profile', 'Halaman edit profil user yang login.', '-', '-', 'View: profile.edit', 'Auth'],
    [2, 'PUT', '/profile', 'Update nama, email, foto profil.', 'name (required, max 255)\nemail (required, unique)\nprofile_photo (file, image, max 2MB)\nremove_photo (0/1)', 'name: required\nemail: unique except self\nphoto: image, max 2048KB', 'Redirect → /profile\nwith success message', 'Auth'],
    [3, 'PUT', '/profile/password', 'Ganti password.', 'current_password (required)\npassword (required, min 8)\npassword_confirmation (required)', 'current_password harus benar\npassword min 8, confirmed', 'Redirect → /profile\nwith success message', 'Auth']
  ];

  addDataRows_(sheet, data, 2);
}

// ============================================================
// SHEET: 03. USER MANAGEMENT
// ============================================================
function createUserSheet_(ss) {
  var sheet = ss.insertSheet('03. User Management');
  var headers = ['No', 'Method', 'Endpoint', 'Deskripsi', 'Parameters', 'Validasi', 'Response', 'Role'];
  setHeaderRow_(sheet, headers);

  var data = [
    [1, 'GET', '/users', 'Daftar user. Paginated 10/page.', 'search (query, optional)\nrole (query, optional)', '-', 'View: users.index\n(users, roles)', 'Admin'],
    [2, 'GET', '/users/create', 'Form tambah user baru.', '-', '-', 'View: users.create\n(roles)', 'Admin'],
    [3, 'POST', '/users', 'Simpan user baru.', 'name (required, max 255)\nemail (required, unique, email)\npassword (required, min 6)\npassword_confirmation (required)\nrole_id (required, exists)', 'email: unique\npassword: min 6, confirmed\nrole_id: exists in roles', 'Redirect → /users\nwith success', 'Admin'],
    [4, 'GET', '/users/{id}', 'Detail user.', 'id (URL)', '-', 'View: users.show\n(user, role)', 'Admin'],
    [5, 'GET', '/users/{id}/edit', 'Form edit user.', 'id (URL)', '-', 'View: users.edit\n(user, roles)', 'Admin'],
    [6, 'PUT', '/users/{id}', 'Update user.\nPassword opsional.', 'name (required)\nemail (required, unique except self)\nrole_id (required)\npassword (optional, min 6)\npassword_confirmation', 'email: unique except current\npassword: optional, min 6', 'Redirect → /users\nwith success', 'Admin'],
    [7, 'DELETE', '/users/{id}', 'Hapus user.\nTidak bisa hapus diri sendiri.', 'id (URL)', 'Bukan self-delete', 'Redirect → /users\nwith success/error', 'Admin'],
    [8, 'POST', '/users/{id}/reset-password', 'Reset password ke "password123".', 'id (URL)', '-', 'Redirect → /users\nwith success', 'Admin']
  ];

  addDataRows_(sheet, data, 2);
}

// ============================================================
// SHEET: 04. TEACHER MANAGEMENT
// ============================================================
function createTeacherSheet_(ss) {
  var sheet = ss.insertSheet('04. Teachers');
  var headers = ['No', 'Method', 'Endpoint', 'Deskripsi', 'Parameters', 'Validasi', 'Response', 'Role'];
  setHeaderRow_(sheet, headers);

  var data = [
    [1, 'GET', '/teachers', 'Daftar guru. Paginated 10/page.', '-', '-', 'View: teachers.index', 'Admin'],
    [2, 'GET', '/teachers/create', 'Form tambah guru.', '-', '-', 'View: teachers.create', 'Admin'],
    [3, 'POST', '/teachers', 'Simpan guru baru.\nOtomatis buat akun user Guru.', 'nip (required, unique, max 20)\nname (required, max 255)\nemail (required, unique, email)\npassword (required, min 6)\ngender (required: L/P)\nphone (optional, max 20)\naddress (optional)\nbirth_date (optional, Y-m-d)\nphoto (file, image, max 2MB)\neducation_level (optional)\nposition (optional)', 'nip: unique\nemail: unique\npassword: min 6\ngender: in L,P\nphoto: image, max 2048KB', 'Redirect → /teachers\nwith success', 'Admin'],
    [4, 'GET', '/teachers/{id}', 'Detail guru + mata pelajaran.', 'id (URL)', '-', 'View: teachers.show', 'Admin'],
    [5, 'GET', '/teachers/{id}/edit', 'Form edit guru.', 'id (URL)', '-', 'View: teachers.edit', 'Admin'],
    [6, 'PUT', '/teachers/{id}', 'Update data guru.', 'nip, name, email, gender, phone,\naddress, birth_date, photo,\neducation_level, position,\nstatus (active/inactive)', 'nip: unique except current\nemail: unique except current', 'Redirect → /teachers\nwith success', 'Admin'],
    [7, 'DELETE', '/teachers/{id}', 'Hapus guru + akun user terkait.', 'id (URL)', '-', 'Redirect → /teachers\nwith success', 'Admin']
  ];

  addDataRows_(sheet, data, 2);
}

// ============================================================
// SHEET: 05. STUDENT MANAGEMENT
// ============================================================
function createStudentSheet_(ss) {
  var sheet = ss.insertSheet('05. Students');
  var headers = ['No', 'Method', 'Endpoint', 'Deskripsi', 'Parameters', 'Validasi', 'Response', 'Role'];
  setHeaderRow_(sheet, headers);

  var data = [
    [1, 'GET', '/students', 'Daftar siswa. Paginated 10/page.', 'class_id (query, optional)\nstatus (query: active/inactive/graduated)\nsearch (query: nama/NISN/NIS)', '-', 'View: students.index\n(students, classes)', 'Admin'],
    [2, 'GET', '/students/create', 'Form tambah siswa.', '-', '-', 'View: students.create\n(classes)', 'Admin'],
    [3, 'POST', '/students', 'Simpan siswa baru.', 'class_id (required, exists)\nnisn (required, unique, max 20)\nnis (required, unique, max 20)\nname (required, max 255)\ngender (required: L/P)\nphone, address, birth_date,\nbirth_place, photo (image, max 2MB),\nparent_name, parent_phone', 'class_id: exists\nnisn: unique\nnis: unique\ngender: L/P\nphoto: image, max 2048KB', 'Redirect → /students\nwith success', 'Admin'],
    [4, 'GET', '/students/{id}', 'Detail siswa + nilai + kehadiran.', 'id (URL)', '-', 'View: students.show\n(grades, attendances)', 'Admin'],
    [5, 'PUT', '/students/{id}', 'Update data siswa.', 'class_id, nisn, nis, name, gender,\nphone, address, birth_date,\nbirth_place, photo, parent_name,\nparent_phone, status', 'nisn: unique except current\nnis: unique except current\nstatus: active/inactive/graduated', 'Redirect → /students\nwith success', 'Admin'],
    [6, 'DELETE', '/students/{id}', 'Hapus data siswa.', 'id (URL)', '-', 'Redirect → /students\nwith success', 'Admin']
  ];

  addDataRows_(sheet, data, 2);
}

// ============================================================
// SHEET: 06. CLASS MANAGEMENT
// ============================================================
function createClassSheet_(ss) {
  var sheet = ss.insertSheet('06. Classes');
  var headers = ['No', 'Method', 'Endpoint', 'Deskripsi', 'Parameters', 'Validasi', 'Response', 'Role'];
  setHeaderRow_(sheet, headers);

  var data = [
    [1, 'GET', '/classes', 'Daftar kelas. Paginated 10/page.', '-', '-', 'View: classes.index', 'Admin'],
    [2, 'POST', '/classes', 'Tambah kelas baru.', 'name (required, max 255)\ngrade (required: 7/8/9)\nacademic_year (required)\ncapacity (optional, 1-50)', 'grade: in 7,8,9\ncapacity: 1-50', 'Redirect → /classes\nwith success', 'Admin'],
    [3, 'GET', '/classes/{id}', 'Detail kelas + siswa + guru-mapel.', 'id (URL)', '-', 'View: classes.show', 'Admin'],
    [4, 'PUT', '/classes/{id}', 'Update data kelas.', 'name, grade, academic_year, capacity', 'Same as store', 'Redirect → /classes\nwith success', 'Admin'],
    [5, 'DELETE', '/classes/{id}', 'Hapus kelas.\nGagal jika ada siswa/mapel terkait.', 'id (URL)', 'Tidak ada data terkait', 'Redirect → /classes\nwith success/error', 'Admin']
  ];

  addDataRows_(sheet, data, 2);
}

// ============================================================
// SHEET: 07. SUBJECT MANAGEMENT
// ============================================================
function createSubjectSheet_(ss) {
  var sheet = ss.insertSheet('07. Subjects');
  var headers = ['No', 'Method', 'Endpoint', 'Deskripsi', 'Parameters', 'Validasi', 'Response', 'Role'];
  setHeaderRow_(sheet, headers);

  var data = [
    [1, 'GET', '/subjects', 'Daftar mata pelajaran. Paginated 10/page.', '-', '-', 'View: subjects.index', 'Admin'],
    [2, 'POST', '/subjects', 'Tambah mata pelajaran.', 'code (required, unique, max 20)\nname (required, max 255)\ndescription (optional)', 'code: unique, max 20\nname: max 255', 'Redirect → /subjects\nwith success', 'Admin'],
    [3, 'GET', '/subjects/{id}', 'Detail mapel + guru + nilai.', 'id (URL)', '-', 'View: subjects.show', 'Admin'],
    [4, 'PUT', '/subjects/{id}', 'Update mata pelajaran.', 'code, name, description', 'code: unique except current', 'Redirect → /subjects\nwith success', 'Admin'],
    [5, 'DELETE', '/subjects/{id}', 'Hapus mapel.\nGagal jika ada guru/nilai terkait.', 'id (URL)', 'Tidak ada data terkait', 'Redirect → /subjects\nwith success/error', 'Admin']
  ];

  addDataRows_(sheet, data, 2);
}

// ============================================================
// SHEET: 08. ACADEMIC YEAR
// ============================================================
function createAcademicYearSheet_(ss) {
  var sheet = ss.insertSheet('08. Academic Year');
  var headers = ['No', 'Method', 'Endpoint', 'Deskripsi', 'Parameters', 'Validasi', 'Response', 'Role'];
  setHeaderRow_(sheet, headers);

  var data = [
    [1, 'GET', '/academic-years', 'Daftar tahun ajaran. Paginated 10/page.', '-', '-', 'View: academic-years.index', 'Admin'],
    [2, 'POST', '/academic-years', 'Tambah tahun ajaran.', 'year (required)\nsemester (required: Ganjil/Genap)\nstart_date (required, Y-m-d)\nend_date (required, > start_date)\nis_active (optional: 0/1)\ndescription (optional)', 'semester: Ganjil/Genap\nend_date > start_date\nyear+semester: unique combo', 'Redirect → /academic-years\nwith success', 'Admin'],
    [3, 'GET', '/academic-years/{id}', 'Detail + jumlah data terkait.', 'id (URL)', '-', 'View: academic-years.show', 'Admin'],
    [4, 'PUT', '/academic-years/{id}', 'Update tahun ajaran.', 'year, semester, start_date,\nend_date, is_active, description', 'Same as store', 'Redirect → /academic-years\nwith success', 'Admin'],
    [5, 'DELETE', '/academic-years/{id}', 'Hapus tahun ajaran.\nGagal jika aktif/ada data terkait.', 'id (URL)', 'Bukan tahun aktif\nTidak ada data terkait', 'Redirect → /academic-years\nwith success/error', 'Admin'],
    [6, 'POST', '/academic-years/{id}/toggle-active', 'Aktifkan/nonaktifkan.\nHanya 1 yang bisa aktif.', 'id (URL)', 'Minimal 1 tetap aktif', 'Redirect → /academic-years\nwith success/error', 'Admin']
  ];

  addDataRows_(sheet, data, 2);
}

// ============================================================
// SHEET: 09. TEACHER-SUBJECT
// ============================================================
function createTeacherSubjectSheet_(ss) {
  var sheet = ss.insertSheet('09. Teacher-Subject');
  var headers = ['No', 'Method', 'Endpoint', 'Deskripsi', 'Parameters', 'Validasi', 'Response', 'Role'];
  setHeaderRow_(sheet, headers);

  var data = [
    [1, 'GET', '/teacher-subjects', 'Daftar penugasan guru-mapel.\nPaginated 15/page.', 'teacher_id (query)\nsubject_id (query)\nclass_id (query)\nacademic_year (query)', '-', 'View: teacher-subjects.index', 'Admin'],
    [2, 'POST', '/teacher-subjects', 'Tambah penugasan guru-mapel-kelas.', 'teacher_id (required, exists)\nsubject_id (required, exists)\nclass_id (required, exists)\nacademic_year (required)', 'Semua ID harus exist\nKombinasi harus unique', 'Redirect → index\nwith success/duplicate error', 'Admin'],
    [3, 'PUT', '/teacher-subjects/{id}', 'Update penugasan.', 'teacher_id, subject_id,\nclass_id, academic_year', 'Same as store', 'Redirect → index\nwith success', 'Admin'],
    [4, 'DELETE', '/teacher-subjects/{id}', 'Hapus penugasan.', 'id (URL)', '-', 'Redirect → index\nwith success', 'Admin'],
    [5, 'GET', '/api/teacher/{id}/subjects', 'AJAX: Mapel yang diampu guru.', 'id (URL)', '-', 'JSON: [{id, name, ...}]', 'Admin'],
    [6, 'GET', '/api/subject/{id}/teachers', 'AJAX: Guru yang mengajar mapel.', 'id (URL)', '-', 'JSON: [{id, name, ...}]', 'Admin']
  ];

  addDataRows_(sheet, data, 2);
}

// ============================================================
// SHEET: 10. ATTENDANCE & QR CODE
// ============================================================
function createAttendanceSheet_(ss) {
  var sheet = ss.insertSheet('10. Attendance & QR');
  var headers = ['No', 'Method', 'Endpoint', 'Deskripsi', 'Parameters', 'Validasi', 'Response', 'Auth'];
  setHeaderRow_(sheet, headers);

  var data = [
    [1, 'GET', '/attendance', 'Daftar kehadiran. Paginated 20/page.', 'type (query: teacher/student)\ndate (query: Y-m-d)', '-', 'View: attendances.index', 'Auth'],
    [2, 'GET', '/attendance/qr-code', 'Redirect ke halaman QR sesuai role.\nAdmin → admin-qr\nGuru → scanner', '-', '-', 'Redirect', 'Auth'],
    [3, 'GET', '/attendance/admin-qr', 'Halaman admin generate QR per guru.', '-', '-', 'View: attendances.admin-qr\n(teachers)', 'Admin'],
    [4, 'GET', '/attendance/scanner', 'Halaman scanner QR untuk guru.', '-', '-', 'View: attendances.scanner', 'Guru'],
    [5, 'GET', '/api/teacher/{id}/qr-code', 'AJAX: Generate QR Code guru.\nEnkripsi AES-256-CBC, expire 600s.', 'id (URL)', '-', 'JSON: {\n  success: true,\n  qrCode: "<svg>...",\n  type: "check_in"\n}', 'Auth'],
    [6, 'GET', '/api/teacher/{id}/attendance-status', 'AJAX: Status kehadiran hari ini.', 'id (URL)', '-', 'JSON: {\n  success: true,\n  attendance: {\n    check_in: "07:30",\n    check_out: null,\n    status: "present"\n  }\n}', 'Auth'],
    [7, 'POST', '/attendance/scan-qr', 'Proses scan QR Code.\nValidasi: QR valid, belum expire,\nlokasi dalam radius 100m.', 'qr_data (required)\nlatitude (required)\nlongitude (required)', 'QR: AES-256-CBC valid\nExpiry: < 600 detik\nJarak: ≤ 100m (Haversine)', 'JSON: {\n  success: true,\n  action: "check_in",\n  message: "Berhasil!",\n  data: {...}\n}', 'Auth'],
    [8, 'POST', '/attendance/check-in', 'Check-in manual kehadiran.', 'latitude (required)\nlongitude (required)\ntype (required: teacher/student)\nid (required)', 'Lokasi ≤ 100m\nBelum check-in hari ini', 'JSON: {\n  success: true,\n  message: "Check-in berhasil",\n  data: {...}\n}', 'Auth'],
    [9, 'POST', '/attendance/check-out', 'Check-out kehadiran.', 'latitude, longitude, type, id', 'Sudah check-in\nLokasi ≤ 100m', 'JSON: success + data', 'Auth'],
    [10, 'GET', '/attendance/class/{classId}', 'Kehadiran siswa per kelas.', 'classId (URL)', '-', 'View: attendances.class', 'Admin'],
    [11, 'POST', '/attendance/class/{classId}', 'Simpan kehadiran siswa 1 kelas.', 'students[id][status]\n(present/absent/late/sick/\npermission)\ndate (Y-m-d)', 'Status valid\nDate valid', 'Redirect → back\nwith success', 'Admin']
  ];

  addDataRows_(sheet, data, 2);
}

// ============================================================
// SHEET: 11. KIOSK MODE
// ============================================================
function createKioskSheet_(ss) {
  var sheet = ss.insertSheet('11. Kiosk Mode');
  var headers = ['No', 'Method', 'Endpoint', 'Deskripsi', 'Parameters', 'Validasi', 'Response', 'Auth'];
  setHeaderRow_(sheet, headers);

  var data = [
    [1, 'GET', '/kiosk', 'Halaman utama kiosk.\nDaftar guru untuk dipilih di monitor.', '-', '-', 'View: kiosk.index\n(active teachers)', 'Public'],
    [2, 'GET', '/kiosk/api/qr/{teacherId}', 'AJAX: Generate QR Code untuk guru.\nDigunakan display monitor.', 'teacherId (URL)', '-', 'JSON: {\n  success: true,\n  qrCode: "<svg>...",\n  teacher: {name, nip},\n  generated_at: "...",\n  expires_in: 600\n}', 'Public'],
    [3, 'GET', '/kiosk/api/status/{teacherId}', 'AJAX: Status kehadiran guru.', 'teacherId (URL)', '-', 'JSON: {\n  success: true,\n  teacher: {name, nip},\n  attendance: {\n    status_text, status_class,\n    check_in, check_out\n  }\n}', 'Public'],
    [4, 'GET', '/kiosk/api/summary', 'AJAX: Ringkasan kehadiran hari ini.', '-', '-', 'JSON: summary data', 'Public'],
    [5, 'POST', '/kiosk/api/scan', 'Proses scan QR dari HP guru.\n(dipanggil dari scanner mobile)', 'qr_data (required)\nlatitude (required)\nlongitude (required)', 'QR valid, not expired\nLokasi ≤ 100m', 'JSON: success + action + data', 'Auth'],
    [6, 'GET', '/kiosk-dashboard', 'Dashboard user Kiosk Presensi.', '-', '-', 'View: kiosk.dashboard', 'Kiosk'],
    [7, 'GET', '/api/attendance/my-status', 'AJAX: Status kehadiran sendiri.', '-', '-', 'JSON: attendance status', 'Auth'],
    [8, 'GET', '/scan-presensi', 'Halaman scanner mobile guru.', '-', '-', 'View: kiosk.scanner', 'Auth']
  ];

  addDataRows_(sheet, data, 2);
}

// ============================================================
// SHEET: 12. GRADE MANAGEMENT
// ============================================================
function createGradeSheet_(ss) {
  var sheet = ss.insertSheet('12. Grades');
  var headers = ['No', 'Method', 'Endpoint', 'Deskripsi', 'Parameters', 'Validasi', 'Response', 'Role'];
  setHeaderRow_(sheet, headers);

  var data = [
    [1, 'GET', '/grades', 'Daftar nilai. Paginated 20/page.\nGuru hanya lihat kelasnya.', 'semester (query)\nacademic_year (query)\nsubject_id (query)\nclass_id (query)', '-', 'View: grades.index\n(grades, subjects, classes)', 'Admin, Guru'],
    [2, 'GET', '/grades/create', 'Form pilih kelas & mapel.', '-', '-', 'View: grades.create\n(classes, subjects)', 'Admin, Guru'],
    [3, 'POST', '/grades/input-by-class', 'Form input nilai per kelas.\nTampilkan semua siswa.', 'class_id (required, exists)\nsubject_id (required, exists)\nsemester (required)\nacademic_year (required)', 'class_id, subject_id: exists', 'View: grades.input\n(students, existing grades)', 'Admin, Guru'],
    [4, 'POST', '/grades/store-multiple', 'Simpan nilai seluruh siswa 1 kelas.\n\nRumus Nilai Akhir:\n= (daily × 0.3) + (midterm × 0.3)\n  + (final × 0.4)', 'class_id, subject_id, semester,\nacademic_year,\nstudents[id][daily_test] (0-100)\nstudents[id][midterm_exam] (0-100)\nstudents[id][final_exam] (0-100)\nstudents[id][behavior_score] (0-100)\nstudents[id][skill_score] (0-100)\nstudents[id][notes] (optional)', 'class_id, subject_id: exists\nSemua nilai: numeric, 0-100', 'Redirect → /grades\nwith success', 'Admin, Guru'],
    [5, 'GET', '/grades/{id}/edit', 'Form edit nilai individual.', 'id (URL)', '-', 'View: grades.edit', 'Admin, Guru'],
    [6, 'PUT', '/grades/{id}', 'Update nilai siswa.', 'daily_test, midterm_exam,\nfinal_exam, behavior_score,\nskill_score, notes', 'Semua: numeric, 0-100', 'Redirect → /grades\nwith success', 'Admin, Guru'],
    [7, 'DELETE', '/grades/{id}', 'Hapus nilai siswa.', 'id (URL)', '-', 'Redirect → /grades\nwith success', 'Admin, Guru'],
    [8, 'GET', '/students/{id}/report-card', 'Rapor siswa per semester.\nSemua nilai + rata-rata.', 'id (URL)\nsemester (query)\nacademic_year (query)', '-', 'View: grades.report-card\n(grades, average)', 'Admin, Kepsek']
  ];

  addDataRows_(sheet, data, 2);
}

// ============================================================
// SHEET: 13. SAW CALCULATION
// ============================================================
function createSAWSheet_(ss) {
  var sheet = ss.insertSheet('13. SAW Calculation');
  var headers = ['No', 'Method', 'Endpoint', 'Deskripsi', 'Parameters', 'Validasi', 'Response', 'Role'];
  setHeaderRow_(sheet, headers);

  addSectionTitle_(sheet, 2, 'RANKING SISWA — Kriteria: C1 (Akademik), C2 (Kehadiran), C3 (Sikap), C4 (Keterampilan)', 8);

  var studentData = [
    [1, 'GET', '/saw/students', 'Halaman ranking siswa SAW.\nMenampilkan:\n• Matriks keputusan\n• Matriks normalisasi\n• Skor SAW\n• Ranking', 'class_id (query, optional)\nsemester (query, optional)\nacademic_year (query, optional)', '-', 'View: saw.students.index\n(assessments, criteria,\ncalculation details)', 'Admin, Kepsek'],
    [2, 'POST', '/saw/students/calculate', 'Hitung ranking siswa.\nAlgoritma SAW:\n1. Buat matriks keputusan\n2. Normalisasi (benefit/cost)\n3. Kalikan bobot\n4. Jumlahkan → ranking', 'class_id (required, exists)\nsemester (required)\nacademic_year (required)', 'class_id: exists in classes', 'Redirect → /saw/students\nwith filter params', 'Admin, Kepsek']
  ];
  addDataRows_(sheet, studentData, 3);

  addSectionTitle_(sheet, 6, 'RANKING GURU — Kriteria: K1 (Kehadiran), K2 (Kualitas Mengajar), K3 (Prestasi Siswa), K4 (Kedisiplinan)', 8);

  var teacherData = [
    [3, 'GET', '/saw/teachers', 'Halaman ranking guru SAW.', 'period (query, optional)\nacademic_year (query, optional)', '-', 'View: saw.teachers.index', 'Admin, Kepsek'],
    [4, 'POST', '/saw/teachers/calculate', 'Hitung ranking guru SAW.', 'period (required)\nacademic_year (required)', '-', 'Redirect → /saw/teachers\nwith filter params', 'Admin, Kepsek']
  ];
  addDataRows_(sheet, teacherData, 7);
}

// ============================================================
// SHEET: 14. CRITERIA
// ============================================================
function createCriteriaSheet_(ss) {
  var sheet = ss.insertSheet('14. Criteria');
  var headers = ['No', 'Method', 'Endpoint', 'Deskripsi', 'Parameters', 'Validasi', 'Response', 'Role'];
  setHeaderRow_(sheet, headers);

  var data = [
    [1, 'GET', '/criteria', 'Daftar kriteria SAW.\nTerpisah: student & teacher.', '-', '-', 'View: criteria.index\n(student_criteria,\nteacher_criteria, totals)', 'Admin'],
    [2, 'GET', '/criteria/create', 'Form tambah kriteria.', '-', '-', 'View: criteria.create', 'Admin'],
    [3, 'POST', '/criteria', 'Simpan kriteria baru.\nTotal bobot per kategori ≤ 1.0.', 'code (required, unique)\nname (required)\ntype (required: benefit/cost)\nweight (required: 0-1)\nfor (required: student/teacher)\ndescription (optional)', 'code: unique\ntype: benefit/cost\nweight: 0-1\nfor: student/teacher\nTotal weight ≤ 1.0', 'Redirect → /criteria\nwith success/error', 'Admin'],
    [4, 'GET', '/criteria/{id}', 'Detail kriteria.', 'id (URL)', '-', 'View: criteria.show', 'Admin'],
    [5, 'PUT', '/criteria/{id}', 'Update kriteria.', 'code, name, type, weight,\nfor, description', 'Same as store\n(code unique except current)', 'Redirect → /criteria\nwith success', 'Admin'],
    [6, 'DELETE', '/criteria/{id}', 'Hapus kriteria.\nGagal jika sudah dipakai assessment.', 'id (URL)', 'Tidak dipakai assessment', 'Redirect → /criteria\nwith success/error', 'Admin'],
    [7, 'POST', '/criteria/normalize', 'Normalisasi bobot agar total = 1.0.', 'type (required: student/teacher)', '-', 'Redirect → /criteria\nwith success', 'Admin']
  ];

  addDataRows_(sheet, data, 2);
}

// ============================================================
// SHEET: 15. REPORTS & EXPORT
// ============================================================
function createReportSheet_(ss) {
  var sheet = ss.insertSheet('15. Reports & Export');
  var headers = ['No', 'Method', 'Endpoint', 'Deskripsi', 'Parameters', 'Validasi', 'Response', 'Role'];
  setHeaderRow_(sheet, headers);

  var data = [
    [1, 'GET', '/reports', 'Halaman utama laporan.\nForm-form export per kategori.', '-', '-', 'View: reports.index\n(classes, academic_years)', 'Admin'],
    [2, 'POST', '/reports/attendance/export', 'Export laporan kehadiran.\nFile: attendance_YYYY-MM-DD.xlsx/.pdf', 'start_date (optional, Y-m-d)\nend_date (optional, Y-m-d)\nacademic_year_id (optional)\ntype (optional: teacher/student)\nformat (required: excel/pdf)', 'format: excel/pdf\ndates: valid format', 'Download file:\n.xlsx (Maatwebsite\\Excel)\n.pdf (DomPDF)', 'Admin'],
    [3, 'POST', '/reports/grades/export', 'Export laporan nilai siswa.\nFile: laporan_nilai.xlsx/.pdf', 'class_id (optional)\nsemester (optional)\nacademic_year (optional)\nformat (required: excel/pdf)', 'format: excel/pdf', 'Download file', 'Admin'],
    [4, 'POST', '/reports/students/export', 'Export laporan data siswa.\nFile: laporan_siswa.xlsx/.pdf', 'class_id (optional)\ngrade (optional: 7/8/9)\nstatus (optional)\nformat (required: excel/pdf)', 'format: excel/pdf', 'Download file', 'Admin'],
    [5, 'POST', '/reports/teachers/export', 'Export laporan data guru.\nFile: laporan_guru_YYYY-MM-DD', 'format (required: excel/pdf)', 'format: excel/pdf', 'Download file', 'Admin']
  ];

  addDataRows_(sheet, data, 2);
}

// ============================================================
// SHEET: 16. SETTINGS
// ============================================================
function createSettingsSheet_(ss) {
  var sheet = ss.insertSheet('16. Settings');
  var headers = ['No', 'Method', 'Endpoint', 'Deskripsi', 'Parameters', 'Validasi', 'Response', 'Role'];
  setHeaderRow_(sheet, headers);

  var data = [
    [1, 'GET', '/settings', 'Halaman pengaturan sistem.\n5 tab: Sekolah, Umum, Tampilan,\nNotifikasi, Sistem.', '-', '-', 'View: settings.index', 'Admin'],
    [2, 'PUT', '/settings/school', 'Update info sekolah.', 'school_name, school_npsn,\nschool_address, school_phone,\nschool_email (email),\nschool_website (url),\nschool_logo (image, max 2MB),\nheadmaster_name, headmaster_nip', 'email: valid email\nwebsite: valid URL\nlogo: image, max 2048KB', 'Redirect → /settings\nwith success', 'Admin'],
    [3, 'PUT', '/settings/general', 'Update pengaturan umum.', 'app_name, app_timezone,\napp_language (id/en),\ndate_format, time_format', 'app_language: id/en', 'Redirect → /settings\nwith success', 'Admin'],
    [4, 'PUT', '/settings/appearance', 'Update tampilan.', 'theme_color (hex, 7 chars)\nsidebar_color (dark/light)\nitems_per_page (5-100)', 'color: 7 chars\nsidebar: dark/light\nper_page: 5-100', 'Redirect → /settings\nwith success', 'Admin'],
    [5, 'PUT', '/settings/notification', 'Update notifikasi.', 'email_notifications (0/1)\nsms_notifications (0/1)\nnotification_email (required, email)', 'email: required, valid', 'Redirect → /settings\nwith success', 'Admin'],
    [6, 'PUT', '/settings/system', 'Update sistem.', 'maintenance_mode (0/1)\nauto_backup (0/1)\nbackup_schedule (daily/weekly/monthly)\nmax_upload_size (1024-10240 KB)', 'schedule: valid option\nupload: 1024-10240', 'Redirect → /settings\nwith success', 'Admin'],
    [7, 'POST', '/settings/cache/clear', 'Hapus cache aplikasi.\n(config, route, view, app cache)', '-', '-', 'Redirect → /settings\nwith success', 'Admin'],
    [8, 'POST', '/settings/backup', 'Backup database MySQL.\nMenggunakan mysqldump.', '-', '-', 'Redirect → /settings\nwith success/error', 'Admin']
  ];

  addDataRows_(sheet, data, 2);
}

// ============================================================
// SHEET: 17. NOTIFICATIONS
// ============================================================
function createNotificationSheet_(ss) {
  var sheet = ss.insertSheet('17. Notifications');
  var headers = ['No', 'Method', 'Endpoint', 'Deskripsi', 'Parameters', 'Validasi', 'Response', 'Auth'];
  setHeaderRow_(sheet, headers);

  var data = [
    [1, 'GET', '/notifications', 'Halaman semua notifikasi.\nPaginated 20/page.', '-', '-', 'View: notifications.index', 'Auth'],
    [2, 'GET', '/api/notifications', 'AJAX: 10 notifikasi terbaru.', '-', '-', 'JSON: {\n  notifications: [...],\n  unread_count: 3\n}', 'Auth'],
    [3, 'GET', '/api/notifications/unread-count', 'AJAX: Jumlah notif belum dibaca.', '-', '-', 'JSON: { count: 3 }', 'Auth'],
    [4, 'POST', '/api/notifications/{id}/read', 'AJAX: Tandai dibaca.', 'id (URL)', 'Milik user sendiri', 'JSON: { success: true }\natau 403 jika bukan milik', 'Auth'],
    [5, 'POST', '/api/notifications/read-all', 'AJAX: Tandai semua dibaca.', '-', '-', 'JSON: { success: true }', 'Auth'],
    [6, 'DELETE', '/api/notifications/{id}', 'AJAX: Hapus notifikasi.', 'id (URL)', 'Milik user sendiri', 'JSON: { success: true }\natau 403', 'Auth']
  ];

  addDataRows_(sheet, data, 2);
}

// ============================================================
// SHEET: 18. MISC (TEACHER + LANGUAGE)
// ============================================================
function createMiscSheet_(ss) {
  var sheet = ss.insertSheet('18. Teacher & Language');
  var headers = ['No', 'Method', 'Endpoint', 'Deskripsi', 'Parameters', 'Validasi', 'Response', 'Role'];
  setHeaderRow_(sheet, headers);

  addSectionTitle_(sheet, 2, 'FITUR KHUSUS GURU', 8);

  var teacherData = [
    [1, 'GET', '/my-classes', 'Daftar kelas yang diampu guru.', '-', '-', 'View: teachers.my-classes', 'Admin, Guru'],
    [2, 'GET', '/my-profile', 'Halaman edit profil guru sendiri.', '-', '-', 'View: teachers.edit-profile', 'Admin, Guru'],
    [3, 'PUT', '/my-profile', 'Update profil guru.\nBisa ganti password.', 'name, nip, phone, address,\nbirth_date, birth_place, gender,\nreligion, education_level, major,\nphoto (file), email, password,\npassword_confirmation', 'email/nip: unique\npassword: min 8, confirmed', 'Redirect → /my-profile\nwith success', 'Admin, Guru']
  ];
  addDataRows_(sheet, teacherData, 3);

  addSectionTitle_(sheet, 7, 'BAHASA / LANGUAGE', 8);

  var langData = [
    [4, 'GET', '/language/id', 'Ganti ke Bahasa Indonesia.', 'locale: id (URL)', 'Locale valid', 'Redirect → back\nSession updated', 'Public'],
    [5, 'GET', '/language/en', 'Ganti ke English.', 'locale: en (URL)', 'Locale valid', 'Redirect → back\nSession updated', 'Public']
  ];
  addDataRows_(sheet, langData, 8);
}

// ============================================================
// BONUS: AUTO-FORMAT ALL SHEETS
// ============================================================
function formatAllSheets() {
  var ssId = PropertiesService.getScriptProperties().getProperty('SHEET_ID');
  if (!ssId) { Logger.log('❌ Jalankan createPostmanDocumentation dulu!'); return; }

  var ss = SpreadsheetApp.openById(ssId);
  var sheets = ss.getSheets();

  for (var i = 0; i < sheets.length; i++) {
    var sheet = sheets[i];
    if (sheet.getName() === 'Overview') continue;

    // Auto-resize columns
    var lastCol = sheet.getLastColumn();
    for (var c = 1; c <= lastCol; c++) {
      sheet.autoResizeColumn(c);
    }

    // Add borders
    var lastRow = sheet.getLastRow();
    if (lastRow > 1 && lastCol > 0) {
      sheet.getRange(1, 1, lastRow, lastCol).setBorder(true, true, true, true, true, true);
    }
  }

  Logger.log('✅ Format selesai!');
}
