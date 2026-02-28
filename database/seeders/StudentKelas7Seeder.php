<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentKelas7Seeder extends Seeder
{
    /**
     * Run the database seeds.
     * Menghapus semua siswa kelas VII dan menambahkan data baru dari Excel
     */
    public function run(): void
    {
        // Data siswa kelas 7 dari file Excel VII_A_G_one_sheet.xlsx
        $studentsData = [
            'VII-A' => [
                'A IBRAHIM MALIK',
                'ADELIA PARANNISA AZMI',
                'ALBIAN IBTISAM HAUZAN',
                'ALYA NURAZIZAH',
                'ANISA PUTRI PAJRIAH',
                'ARYASATYA FATAHILLAH RUSLI',
                'AZKIYA SYAFIQA RAMADHANI',
                'CINDY SANDIANI',
                'DAFA FIRDAUS',
                'DAHFA ABDUL MUQSIT SUPRIATNA',
                'DINDA CHAIRUNNISA',
                'DWIYANTRI RIZKYAH RAMADHANTI',
                'FARJAH NURAULIA RAHMAN',
                'GEMA RAMADHAN AKALIL',
                'HANA NURFIKAH',
                'JASTIN MAULANA',
                'JIHAN KHALIFA SAKHI',
                'KHANZA NURHIDAYAH',
                'MAHESA ARYA PUTRA SETIAWAN',
                'MARLINA AGUSTIN',
                'MUHAMAD FIKRI AL ARKAN',
                'MUHAMAD NASHAR AL-NAWI',
                'MUHAMAD YUSUF RIZKI',
                'MUHAMMAD FAIZ FIRDAUS',
                'MUHAMMAD REZA',
                'MUHAMMAD RIKI ARDIYANSYAH',
                'NABILA HASNA AMIRA',
                'NAJMI NUR HALIMAH ANINDITA',
                'NATHA EZAR DEVIN TRIAWAN',
                'NAZWA NAURA PUTRI HARZA',
                'PAYRIRA APRILIA ANANDA',
                'RAFFKA ADITYA',
                'RAIFA DESPRIYANTI',
                'REHAN DWI RAMADAN',
                'RIANI MUTIA AZZAHRA',
                'RIDHO ARIF WIBOWO',
                'RIZKY SATRIA PRATAMA',
                'SALSA FADILAH NUGRAHA',
                'SATRIA PAMUNGKAS',
                'SHELLA MARCELINA',
                'SYAFIRA AULIA PUTRI',
                'UTARY AULIA',
                'ZAHIRA ANDRI YANTHY',
                'ZELDA JIBRIL KUSMAWAN',
            ],
            'VII-B' => [
                'ABIDILAH NUR YAZAM',
                'ADELLA FADIYA SOLEHA',
                'ALDEFFA KRESNAGHANI',
                'ALYA SABILA APRIYANI',
                'ANDHIKA DWI ANANDA',
                'ANISA SAHRIANI ROMADHON',
                'AZZAHRA KHOIRUNNISA',
                'DAFFA LUTHFI ALKHAIRY',
                'DARA RAMADHANI PUTRI',
                'DEFFAZAR RIZKY MUSLIM RAMADHAN',
                'DIKA PRASETIA',
                'ELIYA SANTIKA',
                'FANYA AMARILIS',
                'FENISA SEFTIANI',
                'HAFIYYAN DHAFIN HIZBA HUDAYA',
                'HASNA ZAHIRAH HAKIM',
                'JIHAN NADILLAH',
                'KARINA ANUGRAH PUTRI',
                'KHAYRA CANDRA AURELLYA',
                'LUKI HAKIM',
                'MARSYA QONITA PUTRI MAULANA',
                'MARVEL SANDI SUTEJA',
                'MUHAMAD HAFIZ SALAM',
                'MUHAMAD REYHAN AL BASKARA',
                'MUHAMAD ZIO AL FAHREZA',
                'MUHAMMAD FERREL BAADILLAH',
                'MUHAMMAD RIZAL PRAWIRANAGARA',
                'MUHAMMAD TAQI AL BASITH',
                'NABILA PUTRI PRATAMA',
                'NAJWAA PUTRI ZAREENA',
                'NAUFAL AZKA HASANUDIN',
                'NAZWHA SALSABILA AZZAHRA',
                'PUTRI AULIA NURHIKMAH',
                'REIFHAN RAMADHAN',
                'RESTU ANANDITA',
                'RIDHA FAULA',
                'RIDHO ANANDITA',
                'RYU FARREL ATHAYA',
                'SALSABILLA',
                'SATRIA PUTRA SCORNOVYANSAR',
                'SILVANI JASMIN',
                'SYALLU NUR AFIFAH',
                'VIOLA ALFINANSYAH',
                'ZAHRA OCTAVIANI',
            ],
            'VII-C' => [
                'ABIDJAN MAHALANI',
                'ADILA SHAREEFA',
                'AIYRA QANETA JUBAEDAH',
                'ALLYSA LUTHFIAH AZALIA HERMAWAN',
                'AMANDA PUSPITA DEWI',
                'ANISA SHOLEHA',
                'ARDHAN JANUAR',
                'BAIQ DEBY UMAYRAH',
                'DEAN NUR KARDIMAN',
                'DESWITA EPENDI',
                'DWI HIDAYATULLAH',
                'ELSA NOVIALATIP',
                'FELLISA KIERA SABILA',
                'FERONIKA JUHANA ADNAN',
                'FIKRY FEBRIYANA HADI',
                'HAFIZ RIZAL',
                'HERLINA APRIAN',
                'KHISYA RAMADHANIA PUTRI',
                'LAYLA NURRAHMA',
                'LUTFHI NUGIANSYAH RAMADHAN',
                'MAUDI FEBRIYANI',
                'MIKAEL RAEES ZAYD',
                'MUHAMAD ISYA PUTRA',
                'MUHAMAD REZA ADITYA',
                'MUHAMMAD AHDAN  FARIZ',
                'MUHAMMAD FAHRUL ROZI',
                'MUHAMMAD HAFID',
                'MUHAMMAD RIZKY SYAHBANA PUTRA ADLI',
                'NABILAH NURANGRAENI',
                'NANDHITA AYUDIYAH',
                'NAZRIL NOVIAN AULIA',
                'NISA JUNIA PUTRI',
                'RAFFA AZHAR RISMAWAN',
                'RAISYA TRI AHMADI',
                'RAKA AIDIL PUTRA',
                'REVAN MAULANA',
                'RISMA AULIYANTI',
                'SAHRUL RAMADHAN',
                'SALSADIVA MAULID RIYANTI',
                'SHAFWAN ABDURAHMAN',
                'SITI SALMAH',
                'SYAQILA AIDATUL MAULANI',
                'VIONA LOVYSA FLORECITA',
                'ZASKIA AZZAHRA',
            ],
            'VII-D' => [
                'AFIFA NURIN NAJWA',
                'AFRIZAL NUR FADILLAH',
                'AMIRA AWWALIYA SALSABILA',
                'ANATASYA HILLIATUL AULIA',
                'ARKAN YUSUF HAKIM',
                'ARSYLLA KANAYA BIRIN',
                'BUNGA FAYADH WIJAYA',
                'DEANDRA ABIANSYAH',
                'DEVINA ELYSIA',
                'ELSA SYAFITRI',
                'FAHRI RAZQA AZZAMI',
                'FENISA ZAHRA RAMADHANI',
                'GERALDI AL GIFFARI PRATAMA',
                'HARDI ARIS MAULANA',
                'IKVI AULYA DAVIT',
                'KARINA DEWI',
                'KIREINA ZAHIN BATRISYA',
                'LENTERA LINTANG AZZAHRA',
                'LUTFI KAMAL',
                'MEIZURA MAHARANI BATO LIMBONG',
                'MILJAN RAQILLA ARFA',
                'MUHAMAD KIANDRA NAZRIL TAWAKAL',
                'MUHAMMAD AZKA SETIAWAN',
                'MUHAMMAD AZKI SETIAWAN',
                'MUHAMMAD HARIS MAULANA',
                'MUHAMMAD SYAZNI AZMI',
                'NABILLA ZAHIRA PUTRI SUDRAJAT',
                'NATASYA ALFRIZA SYAHRIANTI',
                'NIKO SAPUTRA',
                'NITA APRILLIANI',
                'PUTRI NUR FADILAH ALSHAHRANI',
                'RAIFANSYAH AL-ARKAN',
                'RAIKA AVILLA AL KAHFI',
                'RAKHA ALVARO PRATAMA',
                'RANI MARYANI',
                'REYGAN ARIESYHANA',
                'RIZKA CALYA PURI NAFISHA',
                'SALWA AULIYA JASMINE',
                'SITI ZALFA NURKHOFIFAH',
                'SYIFA NURROHMAH',
                'TAUFIK MUZHAFFIR',
                'WULAN AYU JUANDINI',
                'ZEVARA ANINDHYA',
            ],
            'VII-E' => [
                'AGRA KIA PERMANA',
                'ALIFAH PUTRI SYAKIRAH',
                'ANDROMEDA AZZALFA ASYIFATURRATIFA',
                'ANGEL OLIVIA',
                'ARYA PUTRA RAMADAN',
                'AULIA IZMI',
                'CAHYA MEDITERANIA',
                'DENDA RAMDHANI',
                'DEWI APRILLIANI',
                'ELVIRA AZZAHRA RAMADHANI',
                'FARIS ALAMSYAH',
                'FITRI NUR AZIZAH MULYANI',
                'GINELYA PUNGKY',
                'HELMY SEPTYANA',
                'IKBAL TRISYANA',
                'ILMIRA AULIYAH',
                'KARTIKA FIRDAUS',
                'LASYA DEWI RAMADHANI',
                'LUTFI NAUFAL KAUTSAR',
                'MUHAMAD ALFIAN RIDWAN',
                'MUHAMAD LUTHFI ADITYA',
                'MUHAMAD RIZKY HARYANTO',
                'MUHAMMAD IKHBAR',
                'MUHAMMAD TEGAR SAPUTRA',
                'NADIA PUTRI GUNAWAN',
                'NATASYA ALIVIAZULFA',
                'NITA NUR AFIZAH',
                'NIZAR ADHLAN BASUKI',
                'NOURA LAVECHIA SYAHLA',
                'QEYSIA PUTRI FIRDAUS',
                'RAJA ALIFIANDRA FAEYZA',
                'RAMADHAN RIZAL PRATAMA',
                'RAYA PUTRI NABILA',
                'REYHAN HERLYAN',
                'RIZKY ARDIANSYAH PRIATNA',
                'ROSLIANTI FILDASARI',
                'SAMUEL IDO NABABAN',
                'SEGIA PRAMUDITA IDRIYANSYAH',
                'SRI WULAN MARLIANA',
                'SYILLA FADLIAH',
                'UMAR GUMILAR',
                'WULAN PUTRI APRILIYANTI',
                'ZULFA RAMADANTI',
            ],
            'VII-F' => [
                'AHMAD ZAKI RAMADAN',
                'AKBAR MAULANA',
                'ALIKA PUTRI',
                'ANISA FAHIRA',
                'ASYHILA SILVANA GOJALI',
                'AULIA PUTRI ARDIAN',
                'AZZAM NAUFAL DHIYA\'ULHAQ',
                'CANTIK SANTIA KUSUMA',
                'DENDI WARDIMAN',
                'DIANA MEGA CITRA',
                'ERNI ARYANI',
                'FATHURRAHMAN',
                'FISCA ZAHRA AMELIA',
                'HELFIZA SUNISTIRA',
                'HERTA AFDHIANSYAH',
                'INDAH NABILLA PUTRI',
                'KAZIA AGITA PUTRI',
                'LIVI NOVIA NUGRAHA',
                'M. FAKHRI NURRAHMAN',
                'MEYSKA KHOERUNISA',
                'MOHAMAD CAHYA JARISTA',
                'MUHAMAD MALFIN PRATAMA',
                'MUHAMAD RIZQI',
                'MUHAMMAD FADILLAH',
                'MUHAMMAD FAHRI',
                'MUHAMMAD NIZAM ILHAM',
                'MUHAMMAD YOGI MULYADI',
                'NADYA NUR FITRIANI',
                'NAURA NAZKIA EFFENDI',
                'NURLIA MUSDALIFAH',
                'PUTRA DERVIN ARRASYID',
                'QIANA ALEIA JELITA',
                'RAFID RAHMANTIO',
                'RAHMA SITI NUR AZIJAH',
                'RASYA MUHAMMAD ATAYA',
                'RAYYAA QOLBY',
                'REIFHAN RAMADHAN',
                'SACITA MITSALIYYA MELBIN PUTRI',
                'SANDI HARIANSYAH',
                'SHAFA DWI PUTRI KURNIAWAN',
                'SRIYUNI AGUSTIANI',
                'TARSIAH KIRANA',
                'USMAN ROJABI',
                'YASMIN NURLAILI SYAMSI',
            ],
            'VII-G' => [
                'AKBARI RAMADHAN',
                'ALIVIA NAYA LESMANA',
                'ANISA FITRIA OCTAVIANA',
                'AYU LESTARI',
                'AYUNI QURROTUN NISSA',
                'BAEZ IDHAM LISTIAWAN',
                'CARISSA AKILLA MAGANI PUTRI',
                'DENNIAS RADITYA',
                'DINDA AYU PUTRI',
                'EZIZA FACHIRA ZIHNI GUNATA',
                'FITRIYANI OKI',
                'GALANG NIZAM RAFIYANDRA',
                'ILHAM AGUSTIAR',
                'INZITTA',
                'JEMMY VEE AN\'NIZWA',
                'KHALISA AYUNDA FARID',
                'LUSY ALFI HUSNY',
                'M. RICO NOVYANA',
                'MATEO AKBAR RAMDHANSYAH',
                'MUHAMAD FERDIANSYAH',
                'MUHAMAD MUSFIK AMRULLAH',
                'MUHAMAD SAHRUL AJI',
                'MUHAMMAD FADLAN ASSYAKIRIE',
                'MUHAMMAD FAKHRI MAHADIKA',
                'MUHAMMAD PANDU PRIYANTO',
                'MYESHA DWI RAMADHANI',
                'NADHIF RADHIKA WAHHAB',
                'NAISHILA MAULANA FHADILAH',
                'NAYLA SEPTIANDHITA',
                'NURUL APRYANI',
                'R. MUHAMAD WAFFA RAMADHAN',
                'R. NISFAH SALMA JULIANTI',
                'REFAN PRATAMA',
                'REYINA ANINDIYA ADILINE',
                'RIFFAT AKBAR RIANTO',
                'RIO AL-FAQIH',
                'SAHNAZ ALIFYA',
                'SALWA FITRIANI',
                'SASTRA DIMERTA',
                'SHAFA HAURA INDRIANITA',
                'SRY NAORA HANIFAH',
                'TIARA RAHMADANI',
                'WILDAN HIDAYAT',
                'YAYU ALPIANI PUTRI',
            ],
        ];

        // Ambil kelas 7 yang ada di database
        $classes7 = ClassRoom::where('grade', 7)->get()->keyBy('name');

        // Hapus semua siswa kelas 7
        $class7Ids = $classes7->pluck('id')->toArray();
        if (!empty($class7Ids)) {
            $deletedCount = Student::whereIn('class_id', $class7Ids)->delete();
            $this->command->info("Deleted $deletedCount students from grade 7 classes");
        }

        // Counter untuk NISN dan NIS - gunakan prefix 7 untuk kelas 7
        $studentCounter = 1;
        $totalCreated = 0;

        foreach ($studentsData as $className => $students) {
            // Cari atau buat kelas
            $class = $classes7->get($className);
            
            if (!$class) {
                // Buat kelas baru jika belum ada
                $class = ClassRoom::create([
                    'name' => $className,
                    'grade' => 7,
                    'academic_year' => '2025/2026',
                    'capacity' => 48,
                ]);
                $this->command->info("Created new class: $className");
            }

            foreach ($students as $index => $studentName) {
                // Generate NISN (10 digit) dan NIS (5 digit) yang unik
                // NISN: format 907 + 7digit counter = 907XXXXXXX (10 digit)
                // NIS: format 7 + 4digit counter = 7XXXX (5 digit)
                $nisn = '907' . str_pad($studentCounter, 7, '0', STR_PAD_LEFT);
                $nis = '7' . str_pad($studentCounter, 4, '0', STR_PAD_LEFT);

                // Tentukan gender berdasarkan nama (heuristik sederhana)
                $gender = $this->guessGender($studentName);

                Student::create([
                    'class_id' => $class->id,
                    'nisn' => $nisn,
                    'nis' => $nis,
                    'name' => $this->formatName($studentName),
                    'gender' => $gender,
                    'status' => 'active',
                    'birth_date' => $this->generateBirthDate(),
                    'birth_place' => 'Purwakarta',
                ]);

                $studentCounter++;
                $totalCreated++;
            }

            $this->command->info("Added " . count($students) . " students to class $className");
        }

        $this->command->info("Total students created: $totalCreated");
    }

    /**
     * Format nama menjadi title case
     */
    private function formatName(string $name): string
    {
        // Convert to title case
        $name = mb_convert_case(mb_strtolower($name), MB_CASE_TITLE, 'UTF-8');
        
        // Fix some common patterns
        $name = preg_replace('/\bM\.\s/i', 'M. ', $name);
        $name = preg_replace('/\bRd\.\s/i', 'Rd. ', $name);
        $name = preg_replace('/\bR\.\s/i', 'R. ', $name);
        $name = preg_replace('/\bMoch\.\s/i', 'Moch. ', $name);
        
        return $name;
    }

    /**
     * Tebak gender berdasarkan nama
     * Return 'L' untuk Laki-laki, 'P' untuk Perempuan
     */
    private function guessGender(string $name): string
    {
        $femaleIndicators = [
            'putri', 'sari', 'wati', 'yani', 'ningsih', 'dewi', 'sri', 'ning', 
            'tika', 'ika', 'ani', 'ini', 'sih', 'lia', 'linda', 'wulan', 'bulan',
            'ayu', 'cantik', 'indah', 'fitri', 'nur', 'siti', 'aisyah', 'fatimah',
            'zahra', 'aulia', 'nabila', 'salsa', 'shaki', 'regina', 'diana', 'rahma',
            'mega', 'tiara', 'keyla', 'amanda', 'amelia', 'ayunie', 'mitha', 'husna',
            'adelia', 'alya', 'anisa', 'azkiya', 'cindy', 'dinda', 'dwiyantri',
            'farjah', 'hana', 'jihan', 'khanza', 'marlina', 'najmi', 'nazwa',
            'payrira', 'raifa', 'riani', 'shella', 'syafira', 'utary', 'zahira',
            'adella', 'azzahra', 'dara', 'eliya', 'fanya', 'fenisa', 'hasna',
            'karina', 'khayra', 'marsya', 'najwaa', 'nazwha', 'restu', 'ridha',
            'silvani', 'syallu', 'viola', 'adila', 'aiyra', 'allysa', 'baiq',
            'deswita', 'elsa', 'fellisa', 'feronika', 'herlina', 'khisya', 'layla',
            'maudi', 'nabilah', 'nandhita', 'nisa', 'raisya', 'risma', 'salsadiva',
            'syaqila', 'viona', 'zaskia', 'afifa', 'amira', 'anatasya', 'arsylla',
            'bunga', 'devina', 'kireina', 'lentera', 'meizura', 'miljan', 'nabilla',
            'natasya', 'nita', 'rani', 'rizka', 'salwa', 'syifa', 'zevara',
            'alifah', 'andromeda', 'angel', 'cahya', 'elvira', 'ginelya', 'helmy',
            'ilmira', 'kartika', 'lasya', 'nadia', 'noura', 'qeysia', 'raya',
            'roslianti', 'syilla', 'zulfa', 'alika', 'asyhila', 'erni', 'fisca',
            'helfiza', 'kazia', 'livi', 'meyska', 'nadya', 'naura', 'nurlia',
            'qiana', 'sacita', 'shafa', 'sriyuni', 'tarsiah', 'yasmin', 'alivia',
            'ayuni', 'carissa', 'eziza', 'fitriyani', 'inzitta', 'khalisa', 'lusy',
            'myesha', 'naishila', 'nayla', 'nurul', 'nisfah', 'reyina', 'sahnaz',
            'tiara', 'yayu'
        ];

        $nameLower = mb_strtolower($name);
        
        foreach ($femaleIndicators as $indicator) {
            if (str_contains($nameLower, $indicator)) {
                return 'P'; // Perempuan
            }
        }

        return 'L'; // Laki-laki
    }

    /**
     * Generate random birth date for grade 7 students (born around 2013-2014)
     */
    private function generateBirthDate(): string
    {
        $year = rand(2013, 2014);
        $month = rand(1, 12);
        $day = rand(1, 28);
        
        return sprintf('%04d-%02d-%02d', $year, $month, $day);
    }
}
