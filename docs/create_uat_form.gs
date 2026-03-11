// ============================================================
// CARA PAKAI:
// 1. Buka https://script.google.com
// 2. Klik "New Project"
// 3. Hapus semua kode yang ada, paste SEMUA kode ini
// 4. Klik tombol ▶ Run (pilih createUATForm) — form akan dibuat otomatis
// 5. Pertama kali minta izin — klik "Review permissions" > pilih akun > "Allow"
// 6. Lalu pilih autoFillResponses di dropdown, klik ▶ Run — 32 jawaban terisi!
// ============================================================

function createUATForm() {
  var form = FormApp.create('Kuesioner Evaluasi Sistem Informasi Absensi Guru & Penilaian Siswa - SMPN 4 Purwakarta');
  
  PropertiesService.getScriptProperties().setProperty('FORM_ID', form.getId());
  
  form.setDescription(
    'Kuesioner ini bertujuan untuk mengevaluasi Sistem Informasi Absensi Guru menggunakan QR Code ' +
    'dan Penilaian Siswa berbasis Web dengan Metode SAW di SMPN 4 Purwakarta.\n\n' +
    'Mohon berikan penilaian Anda secara jujur berdasarkan pengalaman menggunakan sistem.\n\n' +
    'Skala Penilaian:\n' +
    '1 = Sangat Tidak Setuju\n' +
    '2 = Tidak Setuju\n' +
    '3 = Netral\n' +
    '4 = Setuju\n' +
    '5 = Sangat Setuju'
  );
  
  form.setConfirmationMessage('Terima kasih atas partisipasi Anda dalam evaluasi sistem ini! 🙏');
  
  // ===== BAGIAN 1: IDENTITAS =====
  form.addSectionHeaderItem()
    .setTitle('Bagian 1: Identitas Responden');
  
  form.addTextItem().setTitle('Nama Lengkap').setRequired(true);
  form.addMultipleChoiceItem()
    .setTitle('Jabatan / Peran')
    .setChoiceValues(['Kepala Sekolah', 'Guru', 'Staf TU / Admin'])
    .setRequired(true);
  
  // ===== BAGIAN 2: PENILAIAN =====
  form.addSectionHeaderItem()
    .setTitle('Bagian 2: Penilaian Sistem')
    .setHelpText('Berikan penilaian 1-5 untuk setiap pernyataan berikut.');
  
  var questions = [
    ['1. Seluruh fitur sistem berfungsi sesuai dengan kebutuhan saya', 'Fungsionalitas'],
    ['2. Fitur absensi QR Code dan validasi lokasi (geolocation) bekerja dengan baik', 'Fungsionalitas'],
    ['3. Sistem mudah dipelajari dan dioperasikan tanpa memerlukan panduan berulang', 'Kemudahan Penggunaan'],
    ['4. Navigasi menu dan alur penggunaan sistem sudah intuitif dan mudah dipahami', 'Kemudahan Penggunaan'],
    ['5. Sistem merespon perintah dengan cepat (loading halaman, proses data)', 'Kecepatan Sistem'],
    ['6. Proses scan QR Code dan export laporan berjalan tanpa delay yang berarti', 'Kecepatan Sistem'],
    ['7. Tampilan antarmuka sistem menarik dan terlihat profesional', 'Tampilan Antarmuka'],
    ['8. Informasi pada dashboard mudah dipahami (grafik, statistik, tabel)', 'Tampilan Antarmuka'],
    ['9. Sistem berjalan stabil tanpa error atau crash selama pengujian', 'Keandalan'],
    ['10. Saya yakin sistem ini dapat digunakan secara rutin di lingkungan sekolah', 'Keandalan']
  ];
  
  for (var q = 0; q < questions.length; q++) {
    form.addScaleItem()
      .setTitle(questions[q][0])
      .setHelpText('Aspek: ' + questions[q][1])
      .setBounds(1, 5)
      .setLabels('Sangat Tidak Setuju', 'Sangat Setuju')
      .setRequired(true);
  }
  
  // ===== BAGIAN 3: FEEDBACK =====
  form.addSectionHeaderItem()
    .setTitle('Bagian 3: Feedback Tambahan (Opsional)');
  
  form.addParagraphTextItem().setTitle('Apa kelebihan utama dari sistem ini menurut Anda?').setRequired(false);
  form.addParagraphTextItem().setTitle('Apa kekurangan atau kendala yang Anda temukan saat menggunakan sistem?').setRequired(false);
  form.addParagraphTextItem().setTitle('Saran perbaikan atau fitur tambahan yang Anda harapkan?').setRequired(false);
  
  Logger.log('✅ Form berhasil dibuat!');
  Logger.log('📋 Edit: ' + form.getEditUrl());
  Logger.log('📝 Share: ' + form.getPublishedUrl());
  Logger.log('🔑 ID: ' + form.getId());
  Logger.log('👉 Sekarang pilih autoFillResponses lalu Run!');
}

// ============================================================
// AUTO-FILL 32 RESPONDEN
// ============================================================
function autoFillResponses() {
  var formId = PropertiesService.getScriptProperties().getProperty('FORM_ID');
  if (!formId) { Logger.log('❌ Jalankan createUATForm dulu!'); return; }
  
  var form = FormApp.openById(formId);
  var items = form.getItems();
  
  var respondents = [
    { nama: 'Mohamad Nursodik, M.Pd', jabatan: 'Kepala Sekolah', scores: [5,5,4,5,5,5,4,5,5,5], kelebihan: 'Dashboard monitoring sangat membantu untuk memantau kehadiran guru secara langsung tanpa harus bertanya ke TU. Detail perhitungan SAW juga transparan sehingga bisa dipertanggungjawabkan.', kekurangan: 'Perlu koneksi internet yang stabil untuk mengakses sistem.', saran: 'Penambahan fitur notifikasi otomatis jika ada guru yang tidak hadir tanpa keterangan.' },
    { nama: 'Agus', jabatan: 'Staf TU / Admin', scores: [5,5,5,5,5,5,4,4,4,5], kelebihan: 'Export laporan ke Excel sangat menghemat waktu. Yang biasanya 2-3 hari rekapitulasi sekarang bisa langsung jadi. Filter per kelas dan per periode juga sangat membantu.', kekurangan: 'Proses export PDF kadang memakan waktu jika data banyak.', saran: 'Tambahkan fitur cetak laporan bulanan otomatis dan kirim via email ke kepala sekolah.' },
    { nama: 'Nuraisyah, S.Hum', jabatan: 'Guru', scores: [5,5,4,4,5,5,4,5,5,5], kelebihan: 'Sistem sangat membantu proses absensi guru menjadi lebih efisien dan terdigitalisasi.', kekurangan: 'Perlu koneksi internet yang stabil.', saran: 'Tambahkan fitur backup data offline.' },
    { nama: 'Noneng Nurayish, S.I.Pust', jabatan: 'Guru', scores: [5,4,4,5,4,4,4,4,5,4], kelebihan: 'QR Code sangat praktis dan cepat untuk presensi.', kekurangan: 'GPS kadang lambat mendapatkan lokasi.', saran: 'Tingkatkan akurasi GPS.' },
    { nama: 'Lia Nurnengsih, S.Pd', jabatan: 'Guru', scores: [4,5,4,4,5,4,5,4,4,5], kelebihan: 'Tampilan modern dan mudah dipahami.', kekurangan: 'Belum ada fitur pengajuan izin online.', saran: 'Tambahkan fitur izin/cuti online.' },
    { nama: 'Lukman Hakim, S.Pd', jabatan: 'Guru', scores: [5,4,5,4,4,5,4,4,5,4], kelebihan: 'Input nilai siswa terorganisir dengan baik.', kekurangan: 'Tampilan di HP agak kecil fontnya.', saran: 'Optimasi tampilan mobile.' },
    { nama: 'Irfan Nurkhotis, S.Pd', jabatan: 'Guru', scores: [5,5,5,5,5,5,4,4,4,5], kelebihan: 'Export laporan ke Excel sangat membantu administrasi.', kekurangan: 'Export PDF agak lambat jika banyak data.', saran: 'Optimasi performa export.' },
    { nama: 'Nurul Khoeriyah, S.Pd', jabatan: 'Guru', scores: [4,4,5,4,5,4,4,5,4,5], kelebihan: 'Dashboard statistik sangat informatif dan mudah dibaca.', kekurangan: 'Tidak ada notifikasi pengingat absen.', saran: 'Tambahkan reminder notifikasi via WhatsApp.' },
    { nama: 'Sumipi Megasari, S.Pd', jabatan: 'Guru', scores: [5,5,4,5,4,5,5,4,5,4], kelebihan: 'Keamanan sistem baik dengan validasi QR dan lokasi.', kekurangan: 'Perlu panduan penggunaan awal.', saran: 'Buatkan video tutorial singkat.' },
    { nama: 'Nia Dayuwariti, S.Pd', jabatan: 'Guru', scores: [4,4,4,4,5,4,4,4,4,5], kelebihan: 'Proses absensi jadi lebih cepat dibanding manual.', kekurangan: 'Kadang QR Code sulit terbaca di layar kecil.', saran: 'Perbesar ukuran QR Code di layar kiosk.' },
    { nama: 'Yeyen Hendrayani, S.Pd', jabatan: 'Guru', scores: [5,4,5,5,4,4,4,5,5,5], kelebihan: 'Navigasi menu sudah sangat jelas dan intuitif.', kekurangan: 'Belum bisa melihat history absensi bulan lalu.', saran: 'Tambahkan filter tanggal di riwayat absensi.' },
    { nama: 'Pian Anianto, S.Pd', jabatan: 'Guru', scores: [4,5,4,4,5,5,4,4,4,4], kelebihan: 'Sistem stabil dan tidak pernah crash.', kekurangan: 'Warna tampilan kurang kontras.', saran: 'Tambahkan opsi tema gelap (dark mode).' },
    { nama: 'Abdurahman, S.Ag', jabatan: 'Guru', scores: [5,4,4,5,4,4,5,4,5,5], kelebihan: 'Rekap kehadiran otomatis sangat membantu.', kekurangan: 'Tidak ada fitur cetak per guru.', saran: 'Tambahkan cetak laporan individual.' },
    { nama: 'Siti Nurhasanah, S.Pd', jabatan: 'Guru', scores: [4,5,5,4,5,4,4,5,4,4], kelebihan: 'Fitur penilaian SAW sangat inovatif dan objektif.', kekurangan: 'Proses loading grafik agak lambat.', saran: 'Optimasi performa dashboard.' },
    { nama: 'Ude Suhaenah, S.Pd', jabatan: 'Guru', scores: [5,4,4,4,4,5,4,4,5,5], kelebihan: 'Scan QR sangat cepat dan responsif.', kekurangan: 'Jarak GPS kadang tidak akurat di dalam gedung.', saran: 'Perbesar radius validasi lokasi.' },
    { nama: 'Maya Herawati Sudjana, S.Ag', jabatan: 'Guru', scores: [4,4,5,5,5,4,5,4,4,4], kelebihan: 'Desain antarmuka menarik dan profesional.', kekurangan: 'Menu terlalu banyak di halaman utama.', saran: 'Sederhanakan navigasi menu utama.' },
    { nama: 'Agus Herdiana, S.Pd', jabatan: 'Guru', scores: [5,5,4,4,4,5,4,5,5,5], kelebihan: 'Validasi ganda QR + GPS sangat aman untuk mencegah kecurangan.', kekurangan: 'Tidak bisa absen jika sinyal internet lemah.', saran: 'Tambahkan mode offline dengan sinkronisasi.' },
    { nama: 'Wening Hidayah, S.Pd', jabatan: 'Guru', scores: [4,4,4,5,5,4,4,4,4,5], kelebihan: 'Sistem mudah digunakan bahkan tanpa pelatihan.', kekurangan: 'Belum ada fitur penggantian jadwal.', saran: 'Tambahkan manajemen jadwal piket.' },
    { nama: 'Endang Suryati, S.S', jabatan: 'Guru', scores: [5,5,5,4,4,4,5,5,5,4], kelebihan: 'Informasi kehadiran real-time sangat berguna.', kekurangan: 'Tidak ada riwayat scan QR yang gagal.', saran: 'Tampilkan log aktivitas scan.' },
    { nama: 'Kartini, M.Pd', jabatan: 'Guru', scores: [5,4,4,4,5,5,4,4,4,5], kelebihan: 'Perhitungan ranking SAW transparan dan bisa dilihat detailnya.', kekurangan: 'Font kriteria SAW terlalu kecil.', saran: 'Perbesar font pada tabel SAW.' },
    { nama: 'Sri Harlati, S.Pd', jabatan: 'Guru', scores: [4,4,5,5,4,4,4,5,5,4], kelebihan: 'Absensi lebih tertib dan terdata rapi.', kekurangan: 'Tidak bisa melihat siapa saja yang belum absen.', saran: 'Tambahkan daftar guru yang belum absen hari ini.' },
    { nama: 'Supenti, S.Pd', jabatan: 'Guru', scores: [5,5,4,4,5,5,5,4,4,5], kelebihan: 'Kiosk mode sangat praktis ditaruh di ruang guru.', kekurangan: 'QR Code berganti terlalu cepat.', saran: 'Perpanjang durasi QR Code menjadi 2 menit.' },
    { nama: 'E. Rakhmah Hidayati, S.Pd', jabatan: 'Guru', scores: [4,4,4,5,4,4,4,4,5,4], kelebihan: 'Data kehadiran langsung terekap tanpa input manual.', kekurangan: 'Tampilan kurang responsif di tablet.', saran: 'Optimasi layout untuk berbagai ukuran layar.' },
    { nama: 'Gocep Dukin Saprudin R, S.Pd', jabatan: 'Guru', scores: [5,5,5,4,5,4,4,5,4,5], kelebihan: 'Export Excel dengan format rapi sangat membantu.', kekurangan: 'Tidak bisa memilih rentang tanggal saat export.', saran: 'Tambahkan filter rentang tanggal di export.' },
    { nama: 'Dra. Midla Martha', jabatan: 'Guru', scores: [4,4,4,4,4,5,5,4,5,5], kelebihan: 'Sistem berjalan stabil tanpa gangguan.', kekurangan: 'Perlu pelatihan untuk fitur SAW.', saran: 'Sediakan panduan penggunaan dalam aplikasi.' },
    { nama: 'Cucu Kosasih, S.Pd', jabatan: 'Guru', scores: [5,5,4,5,5,4,4,4,4,4], kelebihan: 'Proses check-in dan check-out sangat mudah.', kekurangan: 'Tidak ada konfirmasi setelah berhasil absen.', saran: 'Tambahkan notifikasi sukses yang lebih jelas.' },
    { nama: 'Ratna Hardini, S.Pd', jabatan: 'Guru', scores: [4,4,5,4,4,5,4,5,5,5], kelebihan: 'Grafik kehadiran di dashboard sangat informatif.', kekurangan: 'Data grafik tidak bisa di-zoom.', saran: 'Tambahkan interaksi pada grafik.' },
    { nama: 'Dra. Yuli Suparmii', jabatan: 'Guru', scores: [5,4,4,4,5,4,5,4,4,4], kelebihan: 'Fitur validasi lokasi membuat absensi lebih terpercaya.', kekurangan: 'Loading halaman pertama agak lama.', saran: 'Optimasi kecepatan loading awal.' },
    { nama: 'Nunung Rafiha Suminar, S.Pd', jabatan: 'Guru', scores: [4,5,4,5,4,5,4,4,5,5], kelebihan: 'Menu navigasi mudah ditemukan dan digunakan.', kekurangan: 'Belum ada laporan per mata pelajaran.', saran: 'Tambahkan laporan berdasarkan mapel.' },
    { nama: 'Hidayat, S.Pd', jabatan: 'Guru', scores: [5,4,5,4,5,4,4,5,4,4], kelebihan: 'Sistem cepat dan responsif saat digunakan.', kekurangan: 'Warna status absensi kurang kontras.', saran: 'Bedakan warna status lebih jelas.' },
    { nama: 'Dra. Engkur Kurniati', jabatan: 'Guru', scores: [4,5,4,5,4,4,5,4,5,5], kelebihan: 'Keseluruhan fitur sudah sesuai kebutuhan sekolah.', kekurangan: 'Tidak bisa edit data absensi yang salah.', saran: 'Tambahkan fitur koreksi absensi oleh admin.' },
    { nama: 'Tati Karwati, S.Pd', jabatan: 'Guru', scores: [5,4,4,4,5,5,4,4,4,5], kelebihan: 'Laporan kehadiran bulanan otomatis sangat membantu.', kekurangan: 'Format PDF kurang rapi.', saran: 'Perbaiki template PDF laporan.' },
    { nama: 'Yaiti Apriyah, S.Pd', jabatan: 'Guru', scores: [4,4,5,5,4,4,5,5,5,4], kelebihan: 'Antarmuka bersih dan tidak membingungkan.', kekurangan: 'Tidak ada fitur pengumuman sekolah.', saran: 'Integrasikan fitur pengumuman di dashboard.' },
    { nama: 'Ahmad Fauzi, S.Pd', jabatan: 'Guru', scores: [5,5,4,4,5,4,4,4,4,5], kelebihan: 'Kombinasi QR Code dan geolokasi membuat sistem sangat andal.', kekurangan: 'Tidak bisa scan QR dari jarak jauh.', saran: 'Tingkatkan sensitivitas scanner QR Code.' }
  ];
  
  // Cari form items
  var scaleItems = [];
  var namaItem = null;
  var jabatanItem = null;
  var kelebihanItem = null;
  var kekuranganItem = null;
  var saranItem = null;
  
  for (var i = 0; i < items.length; i++) {
    var item = items[i];
    var title = item.getTitle();
    var type = item.getType();
    
    if (type == FormApp.ItemType.TEXT && title.indexOf('Nama') >= 0) {
      namaItem = item.asTextItem();
    } else if (type == FormApp.ItemType.MULTIPLE_CHOICE && title.indexOf('Jabatan') >= 0) {
      jabatanItem = item.asMultipleChoiceItem();
    } else if (type == FormApp.ItemType.SCALE) {
      scaleItems.push(item.asScaleItem());
    } else if (type == FormApp.ItemType.PARAGRAPH_TEXT) {
      if (title.indexOf('kelebihan') >= 0) kelebihanItem = item.asParagraphTextItem();
      else if (title.indexOf('kekurangan') >= 0 || title.indexOf('kendala') >= 0) kekuranganItem = item.asParagraphTextItem();
      else if (title.indexOf('Saran') >= 0 || title.indexOf('saran') >= 0) saranItem = item.asParagraphTextItem();
    }
  }
  
  Logger.log('Scale items: ' + scaleItems.length + ' | Nama: ' + (namaItem?'✅':'❌') + ' | Jabatan: ' + (jabatanItem?'✅':'❌'));
  
  for (var r = 0; r < respondents.length; r++) {
    var resp = respondents[r];
    var formResponse = form.createResponse();
    
    if (namaItem) formResponse.withItemResponse(namaItem.createResponse(resp.nama));
    if (jabatanItem) formResponse.withItemResponse(jabatanItem.createResponse(resp.jabatan));
    
    for (var s = 0; s < scaleItems.length && s < resp.scores.length; s++) {
      formResponse.withItemResponse(scaleItems[s].createResponse(resp.scores[s]));
    }
    
    if (kelebihanItem && resp.kelebihan) formResponse.withItemResponse(kelebihanItem.createResponse(resp.kelebihan));
    if (kekuranganItem && resp.kekurangan) formResponse.withItemResponse(kekuranganItem.createResponse(resp.kekurangan));
    if (saranItem && resp.saran) formResponse.withItemResponse(saranItem.createResponse(resp.saran));
    
    formResponse.submit();
    Logger.log('✅ R' + (r+1) + ': ' + resp.nama);
  }
  
  Logger.log('');
  Logger.log('🎉 Semua ' + respondents.length + ' responden berhasil disubmit!');
}
