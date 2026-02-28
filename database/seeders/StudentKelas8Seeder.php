<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentKelas8Seeder extends Seeder
{
    /**
     * Run the database seeds.
     * Menghapus semua siswa kelas VIII dan menambahkan data baru dari Excel
     */
    public function run(): void
    {
        // Data siswa kelas 8 dari file Excel VIII_A_G_one_sheet.xlsx
        $studentsData = [
            'VIII-A' => [
                'ABDAN ALISYABANA',
                'AHMAD SALMAN RAMDHANI',
                'ALDIANSYAH ARDAN',
                'ALIKA NASSYA NOVIYANTI',
                'AMIR NUGRAHA',
                'ARVITA TUNGGAL IKA',
                'ASEP SAEFULOH',
                'AULIA PUTRIANI',
                'BAGAS ADINOTO',
                'CHERYL PUTRI FADILLAH',
                'CINDY SYALWHA FADILLAH',
                'DARA EMILIA ZERLINA',
                'DEVIKA APRILLIA',
                'FADEY RAMADHAN GAYRA',
                'FAIZZA RAIHAN',
                'FARELL MAULANA PUTRA',
                'FATIYATU ZAKIYYAH',
                'FEBY MAULIDA PUTRI',
                'HERA RAHAYU',
                'IJHARI MALIKI',
                'JONARDI ELMA RAMADHAN',
                'KAYLLA LUSIANA',
                'MUHAMAD ABDUL AZIS',
                'MUHAMAD RUBBY KUSNANDAR',
                'MUHAMAD RYAN YUDIANSYAH',
                'MUHAMMAD FADHIL ZHAFRAN',
                'MUHAMMAD JUANDA',
                'MUKHAMMAD SYAIFUL ALAM',
                'NABIL RAMADAN',
                'NADIEN ANJANI SHAFIRA',
                'NAIZAR FADIL BAIHAQI',
                'NAUFAL ADRIAN MULANA',
                'NUR AFFAF ANGGRAYENI',
                'NUR RIZKI AULIA DARMAWAN',
                'RACHEL JULIA RACHMAH',
                'RAISYA APRILIA',
                'RATU ASIAH SEPTIANI',
                'RAVI AUFHAR IBRAHIM',
                'RENGGANIS ALTALITA PUTRI',
                'SARAH SANIAH',
                'SITI FATIMAH AZAHRA',
                'SYAKILA MAYA MAULIDA',
                'SYAKIRA MAULIA ROSADI',
                'SYIRA AYUNI GINA NAFISYA',
                'TARUNA JAYA',
                'ZIVARRA AZHAR JINAN',
            ],
            'VIII-B' => [
                'ALFAHREZA JUMAWAN NAPUTRA',
                'ALIA KHINTANIA PUTRI PRAYUDHI',
                'ALISA PUTRI RASMANA',
                'ANDHIKA PRATAMA',
                'ARFAN FEBRIAN',
                'AZALEA HAFIZA AULIYA',
                'BARRA ADITYA PASCA',
                'CINDY ARTHA MEVIA',
                'EKA ADIPUTRA SUHENDI',
                'FAHRIJAL ALWAN ABDILLAH ADIREDJA',
                'FAJRI RIZKI ILHAMI',
                'FARANISA ZAHRA AZURA DARMAWAN',
                'FARDHAN PUTRA PURNAMA',
                'FARES AMR GOMAA ALI',
                'FATHIYYAH SALSABILA MUJAHIDAH',
                'FELIA INDAH SARI',
                'FELIKA HIKMATUL RAISYAH',
                'GHUFRON MUQIMUDDIN',
                'INTAN SUGANDA',
                'ISWANDA NOVIYANTI',
                'JOVANKA SAPUTRA',
                'KARINA ALMAHIRA BILQIS',
                'KAYNAN GASENDRA AZRA',
                'KHOIRUL ANAM AGUSTA',
                'MUHAMAD BINTANG MAHENDRA DINATA',
                'MUHAMAD FALLAH',
                'MUHAMAD LABIB NURJAMAN',
                'MUHAMMAD HAFIDZ NURYASIN',
                'MUHAMMAD HAFIDZ ZHAPAR',
                'MUHAMMAD RAMA ISMANTO HARYONO',
                'NAIDA AZZAHRA',
                'NAIZAR RAFI RABANI',
                'NIMAN MAULANA INIESTA',
                'NOVI AZAKHRA NURSOLIHAT',
                'NOVIA TRI YURIANSYAH',
                'NURSYIFA FAUZIYAH PUTRI FARDIMAN',
                'RAISSA MARWAH SITI NURJANAH',
                'REIHAN FEBRIANSYAH',
                'RENANTA MANDA KIRANA',
                'SALMA TRIFFA RAMDHANI',
                'SERLY CARISSA PUTRI',
                'SOFWATUSSOLIHAH',
                'SYIFA NADIA AFIAH',
                'TIA SOFYAN',
            ],
            'VIII-C' => [
                'AMDELIA FITRIA COLINE',
                'ADEN SYAID MAULANA',
                'ALVARO SAPUTRA PURWANTO',
                'ANDHARA NUR MAULIDA',
                'APRILIA SRI NURAENI',
                'ARI YUSRI',
                'AULLIA ZALAMAH',
                'DIAN RAMADHANI',
                'DICKY JANWARSYAH',
                'DYNDA PUTRI BRILLIAN',
                'FAHRI ZAFRAN KHAIRY',
                'HABIBAH SALSA HUSAENI',
                'HAFIZ KURNIAWAN JABARULOH',
                'HANA HUMAIRA',
                'HANIF ANWARUL MAJID',
                'HARSYA LUTFISSANI RAMADAN',
                'HUSNA NUR MAULIDA',
                'ILHAM NURROHMAN AL BUKHORI',
                'IQBAL RIECHAN NURYASIN',
                'KAILA RAMADANI',
                'KIRANA RAYDISKA PUTRI',
                'LUTFIAH AVISSA',
                'M. FAUZAN HAQIQI',
                'M. KEVIN PUTRA SYAMSUDIN',
                'MARWAH FAUZIAH',
                'MOHAMMAD ARYA RAJASA',
                'MUHAMAD RAPPI AL GHIPARI',
                'MUHAMAD RIZKI AGUSTIAN',
                'MUTIA NURUL AENI',
                'NAYLA AULAN YANUARI',
                'PUTTY ANDINI',
                'QYARA ZHAFIRA MEDIYAN',
                'RAFA ASNE SEPTIYANO',
                'RAFKA TADZUL ARIFIN',
                'RAISSA AQUEENA RAHMAN',
                'REGA NAUVAL ANGGARA',
                'SAFA NUR RAHMAH',
                'SALMA NUR ATIQAH',
                'SASKIA ZAHRA GUNAWAN',
                'SITI ANGGRAENI',
                'VALENTINA AYU AMELIA FEBRIYANTY',
                'YUMIKO NAOMI',
                'YUMNA ALYA ADILLAH',
                'ZACKY ARDIANSYAH',
                'ZAIRAN ARGY SUKMARA',
            ],
            'VIII-D' => [
                'AINUN NISA AL MAULIZAH',
                'ALIKA MUGNI GUNAWAN',
                'AMABELLE J\'LILA SEPTIANIE',
                'ANDRA ALFIANO RIFQI',
                'ARTHARIANY DYAH AMODYA WARDHANY',
                'AZZI FIRMANSYAH',
                'BILAAL FIRDAUS',
                'BILQIS MAHARANI PUTRI JUHARA',
                'DHEA AULIA AISYAH',
                'GIFARI ZAKI ATALAH',
                'GILANG ALFIANSYAH',
                'HALILAH ZHAHIR MIFTAHUL WIDAD',
                'HANNY BUNGA CINTA LESTARI',
                'JUWITA LOVIANI AZAHRA',
                'LUTHFI AKBAR',
                'MIFTAKUL ISTIQOMAH',
                'MOCHAMAD DZIKRI SAEPUDIN',
                'MUHAMAD DENNIS MUHARAM',
                'MUHAMAD FAHRI',
                'MUHAMAD FATIR BAIHAKI',
                'MUHAMAD RAYIHAN KURNIAWAN',
                'MUHAMAD RIFKI RAMDHANI',
                'MUHAMMAD RAMA JULIANSYAH',
                'MUHAMMAD RIFQI ARRIFA I',
                'MUHAMMAD SULTAN SAPUTRA',
                'NADIA SYAMSAHAWA',
                'NAURA SYAIRA FAJRINA SETIAWAN',
                'NAYLA VIRIZKI',
                'PADIATUN NISA',
                'PARSYA PEVI PERLINE',
                'PUTRA',
                'PUTRI INDRIA',
                'PUTRI NAYLA',
                'RADITYA JUNIANSYAH',
                'REZA DAVIN PRATAMA',
                'RIFFA FADILLA NAYLAFARI',
                'SHINE AARON LAMBAGU',
                'SILVIA AGUSTINA',
                'SISKA FITRIYANI',
                'SYAKILLA AULIA AZAHRA',
                'VIKA AZKIYA',
                'VIOLITHA AZZAHRA PERYOGA',
                'YOSAN PAMUNGKAS',
                'YUANDITO BAYU TRIYONO',
                'ZAKI KHOERUL IMAM',
            ],
            'VIII-E' => [
                'AFIKA DWI PUTRI FAMUJI',
                'ALIF FEBRIAN HANAFIYA',
                'ALISA SUHANDA',
                'ALYA NATASYA NASUTION',
                'ANDIKHA AQILLA MAULANA',
                'AZKA REVAN JAIDAN',
                'BAYU NUGRAHA',
                'CHANTIKA PUTRI AL HAMIM',
                'DELIA OCTAVIA',
                'FATHAN RAHADIAN',
                'FIRSCCA ALINAURAH PRINCESSA',
                'FITRIA AGUSTIN',
                'GAMA ANUGRAH PERMANA',
                'KEISHA ALYAA LESTARI',
                'KEN SANTOSA',
                'LIDYA LISTIAWATI',
                'MOHAMAD DAFFA RAMADHANI',
                'MUHAMAD FIRMAN',
                'MUHAMAD MIFTAH FAUZI',
                'MUHAMMAD IKHSAN FIRMANSYAH',
                'MUHAMMAD JAPAR SIDIK',
                'MUHAMMAD RAYHAN IRTIYAD',
                'MUHAMMAD ZIDAN JAELANI',
                'MYOURI SHARLEEN MAURILLA',
                'NABIILA DWI RIFINA',
                'NADA HASNA NISRINA',
                'NADHIFA MARSYA YUSWANDI',
                'NANDRA INAYAH SEPTIAWAN',
                'NIKY AULIA SARAH',
                'NUGI APRIANSYAH EFFENDI',
                'ORLIN OPHELIA AGELA',
                'PUSVITA DESMAYANTI',
                'REVAN NUR ZEIN',
                'REYSIA PUTRI',
                'REZKY SURYA PUTRA',
                'RIFQI FIRMANSYAH',
                'SALFA KHAERUNISA',
                'SALSA NAURA BERLIANA FITRIA',
                'SALWA SEFTIANA',
                'SYACHRAIN LATIEF MUNAJAT',
                'VANY APRILIA SALSABILA',
                'WIDIAWATI',
                'WILDAN FATHURROHMAN',
                'ZAHIRA WIDIA HARYANTI',
            ],
            'VIII-F' => [
                'ADELIA LATHIFA ZHAHIRAH',
                'AHFADZ KHAIRUL LUBNA',
                'ALIFA RESI LESTARI',
                'ANGGA GILANG PRATAMA',
                'ANIDA SALSA',
                'AQIILA DWI INDRIANI',
                'ARKANA BAYANAKA NALUNEDE',
                'BAGAS ALFARABY',
                'DESTIANI PUTRI',
                'DIKHA REEZKY GINANJAR PUTRA',
                'ELSA DWI SEPTIANI',
                'HANIF FAUJAN MUBAROK',
                'HELVIA RAMADHANI',
                'KANAYA AGNEZYA PUTRI AGENG',
                'LIGAR RAHMANTYA PUTRI',
                'M. AZZAM ARDIANTO',
                'MALIQA WAFA AL HAYA',
                'METTA OKTAVIA PUTRI',
                'MOCH DENATHAN NUR RIZKY',
                'MUHAMAD BAGAS PUTRA ATHALLAH',
                'MUHAMAD RIGA SADAMA',
                'MUHAMMAD ALVI ALFARIZI',
                'MUHAMMAD FAKHRI PUTRA WIJAYA',
                'MUHAMMAD VIRZA RAMADHAN',
                'NADHIFAH NAZMA AMANIA',
                'NAZWA AMELIA PUTRI',
                'PUTRA JIMMY NURJAMAN',
                'QISYA FEBIANDARA',
                'RAFFA RIZQIANA RAMADHAN',
                'RAICA APRIALIYANI',
                'RAKI RABBANI',
                'RIFKI ADITIA RUDIANSYAH',
                'RIZKY ADITYA RAHMAN',
                'RIZKY FITRA KHAIRUL',
                'SABILLA DWI ANGGRAENI',
                'SALWA SALSABILA',
                'SARAH DWI MAULINA',
                'SITI AISAH',
                'SITI FATIMAH ALI ASSIFA',
                'TEGAR MULYA SIDIQ',
                'VIANA SABIILA NARARYA',
                'YONATAN LEONARDUS SIHOL NAINGGOLAN',
                'ZAHRA ALYA NABILAH',
            ],
            'VIII-G' => [
                'AIRA PUTRI ANGGRAENI',
                'ALFIAN MAULANA AKBAR',
                'ALZENA ATHA NAIFAH',
                'ANEIRA AKASMA',
                'ANNISA MAULIDA BUDIARTI',
                'ARIS ALFIAN NUGRAHA',
                'AULIA SALWA',
                'DAFFA ZAIDAN MUZHAFFAR',
                'DIANA FEBRIYANI',
                'EKA BIMA PRATAMA',
                'FAHMI MAULANA ZAAFARANI',
                'FAQHIRA SALIMA',
                'HANNAN TARTILA',
                'ISMI SIAAMU ROMDHONI',
                'KAREN TRI AJENG FAKHIRA',
                'LUTHFI MAULANA RAMDAN',
                'M. RAFFA RAMDHAN HIDAYAT',
                'MIKAELA KIRANIAH FAISAL',
                'MOCH. DENDI NASRUL HAMDI',
                'MOCHAMAD DIAS TRISAPUTRA',
                'MUHAMAD ATTAR',
                'MUHAMAD KHAIRUL AZMI',
                'MUHAMAD RIFKY FADLIANSYAH',
                'MUHAMMAD ABNI ARSYAD WAHAB',
                'MUHAMMAD AZZAM LUTHFY RAMADHAN',
                'MUHAMMAD DAFFA PRATAMA',
                'MUHAMMAD ZAHID WIJAYA PUTRA',
                'NABILA FAUZYYAH',
                'NADHIFA ZAHIRA AMRIYADI',
                'NAURA HANIFA MUFID',
                'NENG PUTRI',
                'QUINSHA AZZAHRA KUSUMAH',
                'RAHMAN NURDIANSYAH',
                'RAHUL MAHEERA',
                'RAIHAN PRATAMA HANDOKO',
                'RAISA RAFANIA RAMADANY',
                'RASYA PUTRA HERIANSAH',
                'RATU FELYSHA SANJAYA',
                'REYNA AMALIA YULIANI',
                'RIFKY KANO RAMADHAN',
                'RIKANA',
                'SALMA ROHIMAH',
                'SITI NUR KHOIRUN MAULIDIA ZAHWA',
                'ZAHRA ERMINA PIDELA',
            ],
        ];

        // Ambil kelas 8 yang ada di database
        $classes8 = ClassRoom::where('grade', 8)->get()->keyBy('name');

        // Hapus semua siswa kelas 8
        $class8Ids = $classes8->pluck('id')->toArray();
        if (!empty($class8Ids)) {
            $deletedCount = Student::whereIn('class_id', $class8Ids)->delete();
            $this->command->info("Deleted $deletedCount students from grade 8 classes");
        }

        // Counter untuk NISN dan NIS - gunakan prefix 8 untuk kelas 8
        $studentCounter = 1;
        $totalCreated = 0;

        foreach ($studentsData as $className => $students) {
            // Cari atau buat kelas
            $class = $classes8->get($className);
            
            if (!$class) {
                // Buat kelas baru jika belum ada
                $class = ClassRoom::create([
                    'name' => $className,
                    'grade' => 8,
                    'academic_year' => '2025/2026',
                    'capacity' => 48,
                ]);
                $this->command->info("Created new class: $className");
            }

            foreach ($students as $index => $studentName) {
                // Generate NISN (10 digit) dan NIS (5 digit) yang unik
                // NISN: format 908 + 7digit counter = 908XXXXXXX (10 digit)
                // NIS: format 8 + 4digit counter = 8XXXX (5 digit)
                $nisn = '908' . str_pad($studentCounter, 7, '0', STR_PAD_LEFT);
                $nis = '8' . str_pad($studentCounter, 4, '0', STR_PAD_LEFT);

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
            'endah', 'veviera', 'zuleikha', 'amel', 'andini', 'aprilia', 'cheryl',
            'cindy', 'dara', 'devika', 'feby', 'hera', 'kaylla', 'nadien', 'rachel',
            'raisya', 'ratu', 'sarah', 'syakila', 'syakira', 'syira', 'zivarra',
            'alia', 'alisa', 'azalea', 'faranisa', 'fathiyyah', 'felia', 'felika',
            'intan', 'iswanda', 'karina', 'naida', 'novi', 'novia', 'nursyifa',
            'raissa', 'renanta', 'salma', 'serly', 'syifa', 'tia', 'amdelia',
            'andhara', 'aullia', 'dian', 'dynda', 'habibah', 'hana', 'husna',
            'kaila', 'kirana', 'lutfiah', 'marwah', 'mutia', 'nayla', 'putty',
            'qyara', 'safa', 'saskia', 'valentina', 'yumiko', 'yumna', 'ainun',
            'alika', 'amabelle', 'arthariany', 'bilqis', 'dhea', 'halilah', 'hanny',
            'juwita', 'miftakul', 'nadia', 'naura', 'padiatun', 'parsya', 'riffa',
            'silvia', 'siska', 'syakilla', 'vika', 'violitha', 'afika', 'alya',
            'chantika', 'delia', 'firscca', 'fitria', 'keisha', 'lidya', 'myouri',
            'nabiila', 'nada', 'nadhifa', 'nandra', 'niky', 'orlin', 'pusvita',
            'reysia', 'salfa', 'salwa', 'vany', 'widiawati', 'zahira', 'adelia',
            'alifa', 'anida', 'aqiila', 'destiani', 'elsa', 'helvia', 'kanaya',
            'ligar', 'maliqa', 'metta', 'nadhifah', 'nazwa', 'qisya', 'raica',
            'sabilla', 'viana', 'aira', 'alzena', 'aneira', 'annisa', 'faqhira',
            'hannan', 'ismi', 'karen', 'mikaela', 'quinsha', 'raisa', 'reyna',
            'rikana'
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
     * Generate random birth date for grade 8 students (born around 2012-2013)
     */
    private function generateBirthDate(): string
    {
        $year = rand(2012, 2013);
        $month = rand(1, 12);
        $day = rand(1, 28);
        
        return sprintf('%04d-%02d-%02d', $year, $month, $day);
    }
}
