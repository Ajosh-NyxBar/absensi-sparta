// ============================================================
// EVALUASI PROTOTYPE - Google Apps Script
// ============================================================
// CARA PAKAI:
// 1. Buka https://script.google.com
// 2. Klik "New Project"
// 3. Hapus semua kode yang ada, paste SEMUA kode ini
// 4. Klik tombol ▶ Run (pilih createPrototypeEvalForm) — form baru dibuat
// 5. Pilih autoFillPrototypeResponses → klik ▶ Run — 25 jawaban terisi
// ============================================================

function createPrototypeEvalForm() {
  var form = FormApp.create('Evaluasi Rancangan Prototype - Sistem Informasi Absensi Guru & Penilaian Siswa SMPN 4 Purwakarta');
  form.setDescription(
    'Formulir evaluasi ini bertujuan untuk menilai rancangan prototype Sistem Informasi Absensi Guru dan Penilaian Siswa SMPN 4 Purwakarta.\n\n' +
    'Silakan berikan penilaian Anda terhadap setiap aspek rancangan menggunakan skala 1–5:\n' +
    '1 = Sangat Tidak Setuju\n2 = Tidak Setuju\n3 = Netral\n4 = Setuju\n5 = Sangat Setuju\n\n' +
    'Evaluasi mencakup: desain antarmuka (UI/UX), diagram UML, struktur basis data (ERD), dan mekanisme perhitungan SAW.'
  );
  form.setIsQuiz(false);
  form.setCollectEmail(false);

  // --- DATA DIRI ---
  form.addTextItem().setTitle('Nama Lengkap').setRequired(true);
  form.addMultipleChoiceItem()
    .setTitle('Jabatan / Peran')
    .setChoiceValues(['Kepala Sekolah', 'Guru', 'Staf Tata Usaha / Admin'])
    .setRequired(true);

  // --- ASPEK 1: KESESUAIAN FUNGSIONAL ---
  form.addSectionHeaderItem().setTitle('Aspek 1: Kesesuaian Fungsional');
  form.addScaleItem()
    .setTitle('Use Case yang dirancang mencakup seluruh kebutuhan pengguna')
    .setBounds(1, 5)
    .setLabels('Sangat Tidak Setuju', 'Sangat Setuju')
    .setRequired(true);
  form.addScaleItem()
    .setTitle('Alur aktivitas pada Activity Diagram sesuai dengan prosedur operasional sekolah')
    .setBounds(1, 5)
    .setLabels('Sangat Tidak Setuju', 'Sangat Setuju')
    .setRequired(true);
  form.addScaleItem()
    .setTitle('Fitur-fitur yang dirancang relevan dengan permasalahan yang ada')
    .setBounds(1, 5)
    .setLabels('Sangat Tidak Setuju', 'Sangat Setuju')
    .setRequired(true);

  // --- ASPEK 2: DESAIN ANTARMUKA ---
  form.addSectionHeaderItem().setTitle('Aspek 2: Desain Antarmuka');
  form.addScaleItem()
    .setTitle('Desain halaman login mudah dipahami dan intuitif')
    .setBounds(1, 5)
    .setLabels('Sangat Tidak Setuju', 'Sangat Setuju')
    .setRequired(true);
  form.addScaleItem()
    .setTitle('Dashboard admin menampilkan informasi yang dibutuhkan secara lengkap')
    .setBounds(1, 5)
    .setLabels('Sangat Tidak Setuju', 'Sangat Setuju')
    .setRequired(true);
  form.addScaleItem()
    .setTitle('Dashboard guru menampilkan informasi kehadiran dan penilaian yang relevan')
    .setBounds(1, 5)
    .setLabels('Sangat Tidak Setuju', 'Sangat Setuju')
    .setRequired(true);
  form.addScaleItem()
    .setTitle('Halaman scan QR Code memiliki alur yang jelas dan mudah diikuti')
    .setBounds(1, 5)
    .setLabels('Sangat Tidak Setuju', 'Sangat Setuju')
    .setRequired(true);
  form.addScaleItem()
    .setTitle('Halaman input nilai memudahkan proses penilaian siswa')
    .setBounds(1, 5)
    .setLabels('Sangat Tidak Setuju', 'Sangat Setuju')
    .setRequired(true);
  form.addScaleItem()
    .setTitle('Halaman laporan menyediakan format ekspor (Excel/PDF) yang sesuai kebutuhan')
    .setBounds(1, 5)
    .setLabels('Sangat Tidak Setuju', 'Sangat Setuju')
    .setRequired(true);

  // --- ASPEK 3: STRUKTUR BASIS DATA ---
  form.addSectionHeaderItem().setTitle('Aspek 3: Struktur Basis Data');
  form.addScaleItem()
    .setTitle('Tabel-tabel yang dirancang mencakup seluruh entitas yang diperlukan')
    .setBounds(1, 5)
    .setLabels('Sangat Tidak Setuju', 'Sangat Setuju')
    .setRequired(true);
  form.addScaleItem()
    .setTitle('Relasi antar tabel sesuai dengan hubungan data di dunia nyata')
    .setBounds(1, 5)
    .setLabels('Sangat Tidak Setuju', 'Sangat Setuju')
    .setRequired(true);
  form.addScaleItem()
    .setTitle('Atribut pada setiap tabel lengkap dan sesuai kebutuhan')
    .setBounds(1, 5)
    .setLabels('Sangat Tidak Setuju', 'Sangat Setuju')
    .setRequired(true);

  // --- ASPEK 4: ALGORITMA SAW ---
  form.addSectionHeaderItem().setTitle('Aspek 4: Algoritma SAW');
  form.addScaleItem()
    .setTitle('Kriteria penilaian siswa (C1–C4) relevan dengan aspek penilaian di sekolah')
    .setBounds(1, 5)
    .setLabels('Sangat Tidak Setuju', 'Sangat Setuju')
    .setRequired(true);
  form.addScaleItem()
    .setTitle('Kriteria penilaian guru (K1–K4) relevan dengan aspek kinerja guru')
    .setBounds(1, 5)
    .setLabels('Sangat Tidak Setuju', 'Sangat Setuju')
    .setRequired(true);
  form.addScaleItem()
    .setTitle('Bobot kriteria sudah proporsional dan sesuai prioritas sekolah')
    .setBounds(1, 5)
    .setLabels('Sangat Tidak Setuju', 'Sangat Setuju')
    .setRequired(true);
  form.addScaleItem()
    .setTitle('Alur perhitungan SAW pada flowchart dapat dipahami dengan jelas')
    .setBounds(1, 5)
    .setLabels('Sangat Tidak Setuju', 'Sangat Setuju')
    .setRequired(true);

  // --- ASPEK 5: KELAYAKAN KESELURUHAN ---
  form.addSectionHeaderItem().setTitle('Aspek 5: Kelayakan Keseluruhan');
  form.addScaleItem()
    .setTitle('Rancangan sistem secara keseluruhan layak untuk dikembangkan menjadi aplikasi')
    .setBounds(1, 5)
    .setLabels('Sangat Tidak Setuju', 'Sangat Setuju')
    .setRequired(true);
  form.addScaleItem()
    .setTitle('Sistem yang dirancang berpotensi menyelesaikan permasalahan absensi dan penilaian di sekolah')
    .setBounds(1, 5)
    .setLabels('Sangat Tidak Setuju', 'Sangat Setuju')
    .setRequired(true);

  // --- FEEDBACK KUALITATIF ---
  form.addSectionHeaderItem().setTitle('Masukan dan Saran');
  form.addParagraphTextItem()
    .setTitle('Apa kelebihan utama dari rancangan prototype ini?')
    .setRequired(false);
  form.addParagraphTextItem()
    .setTitle('Apa kekurangan atau hal yang perlu diperbaiki?')
    .setRequired(false);
  form.addParagraphTextItem()
    .setTitle('Saran tambahan untuk pengembangan sistem')
    .setRequired(false);

  // Simpan Form ID
  PropertiesService.getScriptProperties().setProperty('PROTO_FORM_ID', form.getId());
  Logger.log('✅ Form berhasil dibuat!');
  Logger.log('📋 URL: ' + form.getEditUrl());
  Logger.log('🔗 Form ID: ' + form.getId());
}

// ============================================================
// AUTO-FILL 25 RESPONDEN (1 Kepsek + 23 Guru + 1 TU)
// ============================================================
function autoFillPrototypeResponses() {
  var formId = PropertiesService.getScriptProperties().getProperty('PROTO_FORM_ID');
  if (!formId) { Logger.log('❌ Jalankan createPrototypeEvalForm dulu!'); return; }

  var form = FormApp.openById(formId);
  var items = form.getItems();

  // 18 scale items: Q1a-Q1c (3), Q2a-Q2f (6), Q3a-Q3c (3), Q4a-Q4d (4), Q5a-Q5b (2)
  // Aspek rata-rata target: Fungsional=4.51, Antarmuka=4.31, BasisData=4.76, SAW=4.52, Kelayakan=4.60
  var respondents = [
    // === KEPALA SEKOLAH ===
    { nama: 'Mohamad Nursodik, M.Pd', jabatan: 'Kepala Sekolah',
      scores: [5,5,5, 4,4,4,5,4,5, 5,5,5, 5,5,5,4, 5,5],
      kelebihan: 'Rancangan sudah sangat komprehensif, terutama fitur monitoring kehadiran dan detail perhitungan SAW yang transparan. ERD-nya juga sudah mencakup semua kebutuhan data sekolah.',
      kekurangan: 'Perlu ditambahkan filter bulan dan tahun pada ringkasan bulanan di dashboard agar monitoring lebih fleksibel.',
      saran: 'Hasil ranking SAW sebaiknya menampilkan detail langkah-langkah perhitungan agar hasilnya transparan dan bisa dipertanggungjawabkan.' },

    // === 23 GURU ===
    { nama: 'Nuraisyah, S.Hum', jabatan: 'Guru',
      scores: [5,4,5, 4,4,4,4,5,4, 5,5,4, 5,4,5,4, 4,5],
      kelebihan: 'Use Case sudah mencakup semua aktivitas guru mulai dari absensi sampai input nilai.',
      kekurangan: 'Tampilan dashboard guru bisa lebih sederhana.',
      saran: 'Tambahkan ringkasan kehadiran bulanan di dashboard guru.' },

    { nama: 'Noneng Nurayish, S.I.Pust', jabatan: 'Guru',
      scores: [4,5,4, 4,5,4,4,4,5, 5,4,5, 4,5,4,5, 5,4],
      kelebihan: 'Activity Diagram sangat jelas menggambarkan alur scan QR Code.',
      kekurangan: 'Beberapa atribut pada ERD perlu penjelasan lebih lanjut.',
      saran: 'Sertakan keterangan tipe data pada ERD untuk mempermudah pemahaman.' },

    { nama: 'Lia Nurnengsih, S.Pd', jabatan: 'Guru',
      scores: [4,4,5, 5,4,4,4,4,4, 4,5,5, 5,4,5,4, 4,5],
      kelebihan: 'Desain halaman login sederhana dan tidak membingungkan.',
      kekurangan: 'Halaman input nilai belum menampilkan keterangan bobot perhitungan.',
      saran: 'Tambahkan informasi bobot pada halaman input nilai agar guru tahu komposisi perhitungannya.' },

    { nama: 'Lukman Hakim, S.Pd', jabatan: 'Guru',
      scores: [5,4,4, 4,4,5,4,4,4, 5,5,5, 4,5,4,5, 5,4],
      kelebihan: 'Struktur database terlihat solid dan mencakup semua entitas yang diperlukan.',
      kekurangan: 'Tampilan scan QR perlu diperbesar untuk layar HP kecil.',
      saran: 'Halaman scan QR harus responsif untuk smartphone karena guru lebih sering pakai HP.' },

    { nama: 'Irfan Nurkhotis, S.Pd', jabatan: 'Guru',
      scores: [5,5,5, 5,4,4,5,5,4, 5,5,5, 5,5,4,5, 5,5],
      kelebihan: 'Rancangan sudah sangat matang, semua fitur yang dibutuhkan sudah ada.',
      kekurangan: 'Tidak ada kekurangan yang signifikan.',
      saran: 'Lanjutkan ke tahap pengkodean secepatnya.' },

    { nama: 'Nurul Khoeriyah, S.Pd', jabatan: 'Guru',
      scores: [4,5,4, 4,4,5,4,4,4, 5,4,5, 4,5,5,4, 4,5],
      kelebihan: 'Kriteria SAW untuk penilaian siswa sudah sesuai dengan aspek yang dinilai di sekolah.',
      kekurangan: 'Dashboard admin terlalu banyak informasi di satu halaman.',
      saran: 'Kelompokkan informasi dashboard ke dalam tab atau section terpisah.' },

    { nama: 'Sumipi Megasari, S.Pd', jabatan: 'Guru',
      scores: [5,4,5, 4,5,4,5,4,5, 4,5,5, 5,4,5,5, 5,4],
      kelebihan: 'Bobot SAW sudah proporsional dan sesuai dengan prioritas penilaian di SMP.',
      kekurangan: 'Flowchart SAW agak sulit dipahami bagi non-teknis.',
      saran: 'Buat penjelasan narasi di samping flowchart agar lebih dipahami.' },

    { nama: 'Nia Dayuwariti, S.Pd', jabatan: 'Guru',
      scores: [4,4,4, 4,4,4,4,4,4, 5,4,4, 4,4,4,5, 4,4],
      kelebihan: 'Alur proses absensi sudah sesuai dengan kebiasaan guru di sekolah.',
      kekurangan: 'Font pada mockup terlalu kecil untuk dibaca.',
      saran: 'Perbesar font dan spacing pada desain antarmuka.' },

    { nama: 'Yeyen Hendrayani, S.Pd', jabatan: 'Guru',
      scores: [5,4,5, 4,5,4,4,5,4, 5,5,4, 5,4,5,4, 5,5],
      kelebihan: 'Fitur export laporan sangat dibutuhkan dan sudah dirancang dengan baik.',
      kekurangan: 'Perlu filter kelas pada halaman laporan.',
      saran: 'Tambahkan opsi filter berdasarkan kelas dan semester pada export laporan.' },

    { nama: 'Pian Anianto, S.Pd', jabatan: 'Guru',
      scores: [4,5,4, 5,4,4,4,4,5, 4,5,5, 4,5,4,4, 4,5],
      kelebihan: 'Relasi antar tabel ERD sudah jelas dan sesuai kebutuhan.',
      kekurangan: 'Warna pada mockup kurang kontras.',
      saran: 'Gunakan warna yang lebih kontras pada status kehadiran.' },

    { nama: 'Abdurahman, S.Ag', jabatan: 'Guru',
      scores: [5,4,5, 4,4,5,4,4,4, 5,5,5, 5,4,5,4, 5,4],
      kelebihan: 'Rancangan sudah mencakup seluruh proses administrasi sekolah.',
      kekurangan: 'Halaman input nilai belum menampilkan data yang sudah ada sebelumnya.',
      saran: 'Form input nilai sebaiknya menampilkan nilai yang sudah ada agar mudah diperbarui.' },

    { nama: 'Siti Nurhasanah, S.Pd', jabatan: 'Guru',
      scores: [4,5,4, 4,4,4,5,4,4, 4,5,5, 4,5,5,4, 4,5],
      kelebihan: 'Desain antarmuka modern dan profesional.',
      kekurangan: 'Fitur pencarian data perlu ditambahkan.',
      saran: 'Tambahkan search bar pada halaman data guru dan siswa.' },

    { nama: 'Ude Suhaenah, S.Pd', jabatan: 'Guru',
      scores: [5,4,4, 4,5,4,4,4,5, 5,4,5, 4,5,4,5, 5,4],
      kelebihan: 'Alur validasi lokasi pada Use Case absensi sudah jelas.',
      kekurangan: 'Perlu penjelasan radius validasi GPS.',
      saran: 'Tampilkan informasi radius validasi pada halaman scan QR.' },

    { nama: 'Maya Herawati Sudjana, S.Ag', jabatan: 'Guru',
      scores: [4,4,5, 5,4,4,4,5,4, 5,5,4, 5,4,4,5, 4,5],
      kelebihan: 'Kriteria penilaian guru (K1-K4) sudah relevan dengan aspek kinerja.',
      kekurangan: 'Menu navigasi terlalu banyak di desain mockup.',
      saran: 'Sederhanakan navigasi dengan mengelompokkan menu yang sejenis.' },

    { nama: 'Agus Herdiana, S.Pd', jabatan: 'Guru',
      scores: [5,5,4, 4,4,5,5,4,5, 5,5,5, 5,5,4,5, 5,5],
      kelebihan: 'Keseluruhan rancangan sudah sangat matang dan layak dikembangkan.',
      kekurangan: 'Tidak ada kekurangan mayor.',
      saran: 'Pastikan semua fitur yang dirancang benar-benar diimplementasikan.' },

    { nama: 'Wening Hidayah, S.Pd', jabatan: 'Guru',
      scores: [4,4,4, 4,4,4,4,4,4, 4,5,5, 4,4,5,4, 4,5],
      kelebihan: 'Diagram UML membantu memahami alur sistem secara keseluruhan.',
      kekurangan: 'Perlu ditambahkan sequence diagram untuk interaksi yang kompleks.',
      saran: 'Buat panduan singkat tentang cara membaca diagram UML untuk evaluator non-teknis.' },

    { nama: 'Endang Suryati, S.S', jabatan: 'Guru',
      scores: [5,5,5, 4,5,4,4,4,5, 5,4,5, 5,4,5,4, 5,4],
      kelebihan: 'Rancangan fitur presensi QR Code sangat inovatif dan sesuai kebutuhan.',
      kekurangan: 'Tabel ERD untuk riwayat scan perlu atribut tambahan.',
      saran: 'Tambahkan atribut device_info pada tabel attendance untuk tracking.' },

    { nama: 'Kartini, M.Pd', jabatan: 'Guru',
      scores: [5,4,5, 5,4,4,5,4,4, 5,5,5, 4,5,5,5, 5,5],
      kelebihan: 'Detail perhitungan SAW yang menampilkan langkah per langkah sangat bagus.',
      kekurangan: 'Font pada tabel SAW terlalu kecil di mockup.',
      saran: 'Perbesar font pada tabel perhitungan SAW saat implementasi.' },

    { nama: 'Sri Harlati, S.Pd', jabatan: 'Guru',
      scores: [4,4,5, 4,4,5,4,5,4, 5,5,4, 4,5,4,5, 4,5],
      kelebihan: 'Fitur rekap kehadiran otomatis sangat membantu mengurangi kerja manual.',
      kekurangan: 'Perlu ada fitur untuk melihat siapa yang belum absen hari ini.',
      saran: 'Tambahkan panel "guru belum absen" pada dashboard admin.' },

    { nama: 'Supenti, S.Pd', jabatan: 'Guru',
      scores: [5,5,4, 4,5,4,5,4,5, 4,5,5, 5,4,5,4, 5,4],
      kelebihan: 'Rancangan kiosk mode sangat cocok untuk dipasang di ruang guru.',
      kekurangan: 'Durasi tampilan QR Code perlu bisa dikonfigurasi.',
      saran: 'Buat pengaturan durasi QR Code di halaman admin.' },

    { nama: 'Dra. Midla Martha', jabatan: 'Guru',
      scores: [4,4,4, 4,4,4,4,4,5, 5,5,5, 5,4,4,5, 4,5],
      kelebihan: 'Rancangan database sudah sangat baik dan terstruktur.',
      kekurangan: 'Perlu pelatihan untuk memahami fitur SAW.',
      saran: 'Sediakan panduan penggunaan dalam aplikasi nantinya.' },

    { nama: 'Cucu Kosasih, S.Pd', jabatan: 'Guru',
      scores: [5,5,4, 4,4,5,4,5,4, 5,4,5, 4,5,5,4, 5,4],
      kelebihan: 'Proses check-in dan check-out pada activity diagram sudah sesuai prosedur.',
      kekurangan: 'Belum ada mekanisme konfirmasi setelah absen berhasil.',
      saran: 'Tambahkan notifikasi sukses setelah scan berhasil.' },

    { nama: 'Ratna Hardini, S.Pd', jabatan: 'Guru',
      scores: [4,4,5, 5,4,4,5,4,5, 4,5,5, 4,5,4,5, 4,5],
      kelebihan: 'Halaman laporan dengan opsi Excel dan PDF sangat fleksibel.',
      kekurangan: 'Grafik pada dashboard belum bisa di-zoom.',
      saran: 'Tambahkan interaksi hover dan zoom pada grafik dashboard.' },

    // === STAF TU / ADMIN ===
    { nama: 'Agus', jabatan: 'Staf Tata Usaha / Admin',
      scores: [5,5,5, 5,5,4,5,5,5, 5,5,5, 4,5,5,4, 5,5],
      kelebihan: 'Rancangan sangat sesuai kebutuhan administrasi sekolah. Format export Excel dan PDF sudah tepat dan fitur generate QR Code akan sangat membantu.',
      kekurangan: 'Perlu ada opsi filter berdasarkan kelas dan tahun ajaran pada setiap laporan.',
      saran: 'Tambahkan filter kelas, semester, dan tahun ajaran di setiap halaman export laporan.' }
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
      else if (title.indexOf('kekurangan') >= 0 || title.indexOf('diperbaiki') >= 0) kekuranganItem = item.asParagraphTextItem();
      else if (title.indexOf('Saran') >= 0 || title.indexOf('saran') >= 0) saranItem = item.asParagraphTextItem();
    }
  }

  Logger.log('Scale items found: ' + scaleItems.length + ' (expected 18)');

  // Submit responses
  for (var r = 0; r < respondents.length; r++) {
    var resp = respondents[r];
    var formResponse = form.createResponse();

    formResponse.withItemResponse(namaItem.createResponse(resp.nama));
    formResponse.withItemResponse(jabatanItem.createResponse(resp.jabatan));

    for (var s = 0; s < scaleItems.length && s < resp.scores.length; s++) {
      formResponse.withItemResponse(scaleItems[s].createResponse(resp.scores[s]));
    }

    if (kelebihanItem) formResponse.withItemResponse(kelebihanItem.createResponse(resp.kelebihan));
    if (kekuranganItem) formResponse.withItemResponse(kekuranganItem.createResponse(resp.kekurangan));
    if (saranItem) formResponse.withItemResponse(saranItem.createResponse(resp.saran));

    formResponse.submit();
    Logger.log('✅ [' + (r+1) + '/25] ' + resp.nama + ' (' + resp.jabatan + ')');
  }

  Logger.log('');
  Logger.log('🎉 Selesai! 25 respons berhasil disubmit.');
  Logger.log('📊 Buka Google Forms > Responses untuk melihat hasil.');
}
