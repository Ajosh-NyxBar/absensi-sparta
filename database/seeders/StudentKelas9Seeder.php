<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentKelas9Seeder extends Seeder
{
    /**
     * Run the database seeds.
     * Menghapus semua siswa kelas IX dan menambahkan data baru dari Excel
     */
    public function run(): void
    {
        // Data siswa kelas 9 dari file Excel kelas_9A_9G_one_sheet.xlsx
        $studentsData = [
            'IX-A' => [
                'AIRA OKTAVIANI',
                'ALI MUJTAHID',
                'ALVIAN SUGIHARTO',
                'AMALIA PARI WIRAPANA',
                'AMANDA DWI MEISYA',
                'AMELIA PUSPITA SARI',
                'APRILIYANA',
                'AYUNIE BALLQIS',
                'AZMI ALAMSYAH',
                'DEYAN AKBAR QLANI',
                'ENDAH WANGI NUR KHADIJAH',
                'ERIC NUR JAMAN',
                'ERLANGGA MUHARAM PUTRAJAYA',
                'FADILLAH FALIH EFENDI',
                'GENTA MAULID DWI SYAHPUTRA',
                'HUSNA MUSLIMATUN NI\'MAH',
                'KENTARO KENZIE',
                'KEYLA ASYA NABILA',
                'M. ZAMIL SAPUTRA',
                'MEGA MUSTIKA SAPUTRI',
                'MITHA PUTRI SALSABILA',
                'MUHAMAD DEWANTARA PUTRA UTAMA',
                'MUHAMAD RAMDAN BADRUZAMAN',
                'MUHAMAD RISKI ARYA UTOMO',
                'MUHAMMAD LUTFHIE FADHILAH',
                'MUHAMMAD RIZKY ADITYA',
                'MUHAMMAD SYAFIQ FADHILLAH',
                'PUTRI ELLENA',
                'RAHMA AGUSTINA',
                'RAHMA FAUZIAH',
                'REGINA PUTRI',
                'RIZKY AUSIL WAHAB',
                'SALSABILA HARISA PUTRI',
                'SALWA NURFADILAH',
                'SHAKILLA OKTAVIA GUNAWAN',
                'TIARA MELISA PUTRI',
                'VAIS ALFA RISKY',
                'VEVIERA AZAHRA',
                'ZULEIKHA ATHALLAH PANDYA',
            ],
            'IX-B' => [
                'ADITYA NOOR PRATAMA',
                'AISYAH',
                'AMEL PUTRI ANGGRAENI',
                'AMRI FEBRIAN MAULANA',
                'ANDINI ANGGRAINI',
                'APRILIA ROSTIANA',
                'AYSSKA ZAHIRAH NANDA SETIAWAN',
                'AZKA MARGISKA',
                'BAGAS SETIAWAN',
                'DEFARA PUTRI KIRANA',
                'DIANA NUR APRILIANI',
                'DICKI FEBRIANSYAH',
                'ELSHA HINDIS PRADESTA',
                'FAHRI RAHMANSYAH',
                'FAIQ MUHAMMAD RAZAN DANENDRA',
                'FATIMAH SAMPI MARTAPURI',
                'FITRIA ANDJANI',
                'HAFIZ DWI HERMAWAN',
                'INDI AZIZAH',
                'KENZIE FACHRUDIN',
                'KEYSHA DWI ANANDHA',
                'MALISA AWALIATUL MILAH',
                'MARCELL FEBRIAN SIAGIAN',
                'MUHAMAD RAMDAN',
                'MUHAMAD REHAN GUNAWAN',
                'MUHAMMAD ARI NUGRAHA',
                'MUHAMMAD AZHAR',
                'MUHAMMAD HAFIZ',
                'MUHAMMAD KHALIFA RAHMADIKA',
                'MUTHIA ZULFA MAULIDA',
                'NABIL FATIH ABDILAH',
                'NARRAS ASSYKHA SYY',
                'NAYLA YULIANI',
                'PINAR BADI ASYA',
                'RAVA JALIANTI',
                'RD. NIZZAR MIFTAHUL AZMI',
                'REGINA ZASKIA PUTRI',
                'SHAKIRA FADHILATU SYA\'BANI',
                'WULAN RIZKY RISMAWATI',
            ],
            'IX-C' => [
                'AIRA NOVIANTI WIJAYA',
                'ALFI WILDAN PERDANA',
                'ANNISA NURFADHILAH',
                'APRILIA SHINTYA NOVIANTI',
                'ARGA SEPTIANA KUSUMAH',
                'AULIYA PUTRI NUR FADHILAH',
                'AUREL REGINA PUTRI',
                'AZKA ALFARIZI ALIMUDIN',
                'AZKIYA FATHIMATUZ ZAHRA',
                'BAGJA SUGEMA',
                'BUNGA ASRI FEBRIANI',
                'DIANA PUTRI ANGGRAENI',
                'DWI ARTIKA HARIYATMO',
                'FARIS FAUZAN',
                'FATTAN SYAMEEL AL FAIZ',
                'FIRDA NURJANAH',
                'GANJAR PUTRA GUMILANG',
                'GHINA SYAKIRA SYAHARANI',
                'HEKSA BANYU SAGARA',
                'INDRI PRATIWI',
                'KEYSAN NAWFAL ALI',
                'MAULANA RIZKY ZAENUDIN',
                'MEISYA CALYA ANYA',
                'MUHAMAD REZKY KURNIAWAN',
                'MUHAMAD RICKY',
                'MUTIARA MUSLINA',
                'NAUFAL RAIHAN LEGIANSYAH',
                'NIRMALA NUR AYU',
                'PUTRA PRATAMA MULYADI',
                'RANGGA PRATAMA',
                'REINHARD APRIELLIAN SIREGAR',
                'REISHYA SENZIANA',
                'RIZKY HADI PUTRA',
                'SHYRA SEGGARA PUTRI',
                'SILPA AGUSTIN',
                'SONI PERMANA',
                'YULIANTI KENCANA KOMALASARI',
                'ZIDNY DIAS AKBAR',
            ],
            'IX-D' => [
                'ADINDA NOOR SHALIHA',
                'AHMAD FEBRIAN SAPUTRA',
                'ALIFYA NURUL ILMA',
                'ARIP SAPUTRA',
                'ASTRIA AINUNNISA',
                'AUREL RAM ZHUL YESFA',
                'AZRA LEDHA NOOR FAZRYAH',
                'BINTANG RAYA ALFAREZI',
                'DIAS SAPUTRA',
                'DINARA SAYIDINA REFASYA',
                'FATHIAN YUDA NAFIS',
                'GINA FITRIA RAMADHANI',
                'HAFIYAH NURUL FADHILAH',
                'HISKIA VANO IMANUEL',
                'INES NUR ANISA',
                'IQBAL MUHAMAD RIZKY KAER',
                'KHADAFI MAULANA PUTRA',
                'KHANSA ZAHIRAH ATTAYA',
                'KUSTIAN ABDUL JABBAR',
                'M. AQSHAL BAIHAQI KAIZAN',
                'M. SANDI ANUGRAH',
                'MAIVIEN MEIDIAN PRATAMA',
                'MIRLIANA PUTRI',
                'MUHAMMAD FIKRI MUSTHAFA',
                'MUHAMMAD RAFA ISMAIL',
                'NADIN MULYANI',
                'NAZMHA ALIKHA KIRANA',
                'NUR QOMARA RAMADHAN',
                'NURUL AZMI NURSAHIDA',
                'RACHMA ALAWATUNNAZWA',
                'RANDI KURNIAWAN',
                'RENDI FARIS SAPUTRA',
                'RIA AMIN NUR HAMIDAH',
                'RIZKY NUR RAHMAN',
                'SALSABILA HURIYA',
                'SILVI MELINDA PUTRI',
                'SYIFA RAMADHANI NUGRAHA',
                'ZAHIRA NUR RAHMALIYANI',
                'ZAHRINA APRILIA AQILAH',
            ],
            'IX-E' => [
                'AHMAD RIDWAN',
                'ALDI RENALDI',
                'ALIF AWAL RAMADANI',
                'ALLEYA JASMINE KIRANIA',
                'ALYA NUR APRILIA',
                'ANABELLE DHIANG CHRISTIAN PUTRI',
                'ARKANANTA FADILLAH RUSLI',
                'ARYA PUTRA WIDODO',
                'ASYIFA NUR SALSABILA',
                'BELLA SAEPUL NOVIANTI',
                'BUKHARA',
                'DINDA SALSABILA',
                'EISHYA KARIMAH',
                'ERVIN IRHAM NUGRAHA',
                'FAUZI',
                'GHIFARI AJO HERISZKY',
                'GINAR NIGTA HIDASAH',
                'HAINUN NISSA SEPTIANI',
                'IKHSAN SUMAHARJA',
                'INTAN HALIMATUSSA\'DIAH',
                'M. AZKA FIRDAUS',
                'MOCH. FATHAN',
                'MUHAMAD ASSA PRADIRA PUTRA',
                'MUHAMAD RIZAL ABDULLAH',
                'MUHAMAD RIZKY FIRMANSYAH',
                'MUHAMMAD RAFKA JAYA PUTRA',
                'NADHIF MUHTAROM',
                'NAFISAH KHOIRUNNISA',
                'PUTRI ALIKHA',
                'QARIN SHAFARA',
                'RAFA APRIANA',
                'RAMDHANI AGUSTIN',
                'RANDIA DIKI ABIDIN',
                'ROBEKA CAROLEA DOBBERD',
                'ROMAN KHALIFAH FIRDAUS',
                'SILVY BUNGA CITRA',
                'VERA FEBRIANTI',
                'ZAHRA AVINA',
                'ZIPANA MAULIDINA',
            ],
            'IX-F' => [
                'AFIAH NURFADILAH',
                'AHMAD RIFA\'I',
                'ALYA NUR OKTAVIANI',
                'ARMAN BADRUZAMAN',
                'AULIA PUTERI',
                'CAHAYA WULAN TIKA',
                'CITRA ANGGETYA',
                'DESTA PRAMUDITYA DWIGUNA',
                'DIRA OKTAVIANA',
                'ERLANGGA GANENDRA KURNIA',
                'FAIZ IQBAR RAMADHAN',
                'FEBRI WIJAYA',
                'HALIFA NUR ARIF',
                'HANNA NASILA RAMADHANI',
                'HESA NURHAYATI',
                'IRFAN KUSNANDI',
                'ISMI NUR DWI PAMUNGKAS',
                'MANDA NUR SHAFINAH',
                'MOCH. ZILBRAN ALFHARIZI',
                'MUHAMAD AKBAR NUR FALAH',
                'MUHAMAD AKMAL RIZQULLAH',
                'MUHAMAD RAHMAN',
                'MUHAMAD TAUFIK NURAHMAN',
                'MUHAMMAD GILANG RAMADHAN',
                'MUHAMMAD RAIHAN ALFAZRI',
                'NAILA DWI RAMADHAN',
                'NAMIRA FIDELLYA AZZAHRA',
                'PUTRI NURHALISYAH',
                'RANGGA PRASETIA',
                'RASYA MAULIDU AHMAD',
                'RAVA DWI ANASTASYA',
                'RD ALVIANDRA ARFAN DWI SAPUTRA',
                'REYHAN NUGRAHA',
                'ROSIDAH KHAERUNNISA',
                'SHILVY PUSPITA SARI',
                'SITI ALMA ALIFAH',
                'SULTAN MAKHDUM MALIKUL ZAHIR',
                'YANTI NURCAHYA',
                'ZAHRA VIDYA KANITA',
            ],
            'IX-G' => [
                'ALFA AZHAR',
                'ALHAN MIGHWAR PUTRA',
                'ANNISA QUROTAAYUN',
                'ARINI FELICIA',
                'AURA SAVA RADITYA',
                'AZKA ALLANA FAUZAN',
                'CATUR AULIA',
                'DEDE ASRI SAFITRI',
                'DTRI NUR MAULANA',
                'FARDHAN ALRAZKA',
                'FARIDAH NUR SYABANI',
                'FERDIANSYAH ARIF',
                'HASTI',
                'HERNI ELYAS',
                'IRFAN NURRAHMAN MULYANA',
                'IRSYAD NUR HANIF',
                'KAYLA NATANIA WIDIYANA',
                'M RIZQI ARDIYANSYAH',
                'M. FADLAN AURRAHMAN',
                'MARISA PUTRI',
                'MUHAMAD BARRON THOBRONI',
                'MUHAMAD LUTHFI CAHYADIREJA',
                'MUHAMAD YURI PERDANA',
                'MUHAMMAD GHIFARISYA RAMZAN',
                'NAJMI ZAHIRA',
                'NISA APRILIA',
                'PUTRI DEA NUR KEISYA',
                'RAISAL SULAEMAN KAMUF',
                'RAKHA ABYAN PUTRA ARKAAN',
                'RAMDANI',
                'RATU NAZWA AURORA',
                'REZA PUTRA PRATAMA',
                'REZGHAL MUHAMAD YUNDHARA',
                'RIZKY MAULANA',
                'RUBY PUTRI ANJANI',
                'SITI HAFIFAH',
                'ZAHRA NURRAFI',
                'ZAHRA ZOYA OKTAVIANTI',
            ],
        ];

        // Ambil kelas 9 yang ada di database
        $classes9 = ClassRoom::where('grade', 9)->get()->keyBy('name');

        // Hapus semua siswa kelas 9 (termasuk yang baru dibuat sebelumnya)
        $class9Ids = $classes9->pluck('id')->toArray();
        if (!empty($class9Ids)) {
            $deletedCount = Student::whereIn('class_id', $class9Ids)->delete();
            $this->command->info("Deleted $deletedCount students from grade 9 classes");
        }

        // Counter untuk NISN dan NIS - mulai dari 9001 untuk menghindari duplikasi dengan data sebelumnya
        $studentCounter = 1;
        $totalCreated = 0;

        foreach ($studentsData as $className => $students) {
            // Cari atau buat kelas
            $class = $classes9->get($className);
            
            if (!$class) {
                // Buat kelas baru jika belum ada
                $class = ClassRoom::create([
                    'name' => $className,
                    'grade' => 9,
                    'academic_year' => '2025/2026',
                    'capacity' => 40,
                ]);
                $this->command->info("Created new class: $className");
            }

            foreach ($students as $index => $studentName) {
                // Generate NISN (10 digit) dan NIS (5-6 digit) yang unik
                // NISN: format 9 + 09 + 5digit counter = 9090XXXXX (10 digit)
                // NIS: format 9 + 4digit counter = 9XXXX (5 digit)
                $nisn = '909' . str_pad($studentCounter, 7, '0', STR_PAD_LEFT);
                $nis = '9' . str_pad($studentCounter, 4, '0', STR_PAD_LEFT);

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
            'endah', 'veviera', 'zuleikha', 'aisyah', 'amel', 'andini', 'aprilia',
            'aysska', 'defara', 'elsha', 'fitria', 'indi', 'keysha', 'malisa',
            'muthia', 'nayla', 'rava', 'wulan', 'aira', 'annisa', 'auliya', 'aurel',
            'azkiya', 'bunga', 'firda', 'ghina', 'indri', 'meisya', 'mutiara', 'nirmala',
            'reishya', 'shyra', 'silpa', 'yulianti', 'adinda', 'alifya', 'astria',
            'azra', 'dinara', 'gina', 'hafiyah', 'ines', 'khansa', 'mirliana', 'nadin',
            'nazmha', 'nurul', 'rachma', 'ria', 'salsabila', 'silvi', 'syifa', 'zahira',
            'zahrina', 'alleya', 'alya', 'anabelle', 'asyifa', 'bella', 'dinda', 'eishya',
            'ginar', 'hainun', 'intan', 'nafisah', 'qarin', 'ramdhani', 'robeka', 'vera',
            'zipana', 'afiah', 'cahaya', 'citra', 'dira', 'halifa', 'hanna', 'hesa',
            'ismi', 'manda', 'naila', 'namira', 'rosidah', 'shilvy', 'yanti', 'arini',
            'aura', 'dede', 'faridah', 'hasti', 'herni', 'kayla', 'marisa', 'najmi',
            'nisa', 'ratu', 'ruby'
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
     * Generate random birth date for grade 9 students (born around 2011-2012)
     */
    private function generateBirthDate(): string
    {
        $year = rand(2011, 2012);
        $month = rand(1, 12);
        $day = rand(1, 28);
        
        return sprintf('%04d-%02d-%02d', $year, $month, $day);
    }
}
