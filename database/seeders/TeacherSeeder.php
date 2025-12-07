<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guruRole = Role::where('name', 'Guru')->first();

        $teachers = [
            [
                'name' => 'Yaiti Apriyah, S.Pd',
                'nip' => '196704021988032010',
                'phone' => '8734 7456 4630 0012',
                'address' => 'PURWAKARTA',
                'birth_date' => '1967-04-02',
                'subject' => 'Guru Matematika',
                'employee_id' => 'E 549276',
            ],
            [
                'name' => 'Tati Karwati, S.Pd',
                'nip' => '196510131989032004',
                'phone' => '9554 7436 4630 0012',
                'address' => 'BANDUNG',
                'birth_date' => '1965-10-13',
                'subject' => 'Guru Madya',
                'employee_id' => 'E 569187',
            ],
            [
                'name' => 'Dra. Engkur Kurniati',
                'nip' => '196802071994122002',
                'phone' => '8539 7466 4830 0032',
                'address' => 'BANDUNG',
                'birth_date' => '1968-02-07',
                'subject' => 'Guru Bhs Inggris',
                'employee_id' => 'G 327277',
            ],
            [
                'name' => 'Hidayat, S.Pd',
                'nip' => '196602151988031012',
                'phone' => '7547 7446 4420 0002',
                'address' => 'JAKARTA',
                'birth_date' => '1966-02-15',
                'subject' => 'Guru Matematika',
                'employee_id' => 'E 640982',
            ],
            [
                'name' => 'Nunung Rafiha Suminar, S.Pd',
                'nip' => '197110201992052004',
                'phone' => '5534 7495 5130 0033',
                'address' => 'PURWAKARTA',
                'birth_date' => '1971-12-02',
                'subject' => 'Guru Bhs Sunda',
                'employee_id' => 'H 058758',
            ],
            [
                'name' => 'Dra Yuli Suparmii',
                'nip' => '196607101998022001',
                'phone' => '2042 7446 4630 0043',
                'address' => 'PURWAKARTA',
                'birth_date' => '1966-07-10',
                'subject' => 'Guru Prakarya',
                'employee_id' => 'H 058758',
            ],
            [
                'name' => 'Ratna Hardini, S.Pd',
                'nip' => '196712121995122002',
                'phone' => '7544 7456 4730 0053',
                'address' => 'BINJAI',
                'birth_date' => '1967-12-12',
                'subject' => 'Guru IPS',
                'employee_id' => 'G 295510',
            ],
            [
                'name' => 'Cucu Kosasih, S.Pd',
                'nip' => '196710171992011001',
                'phone' => '2349 7456 4820 0023',
                'address' => 'PURWAKARTA',
                'birth_date' => '1967-10-17',
                'subject' => 'Guru PJOK',
                'employee_id' => 'F 002378',
            ],
            [
                'name' => 'Dra. Midla Martha',
                'nip' => '196703151999032003',
                'phone' => '0647 7456 4630 0022',
                'address' => 'PURWAKARTA',
                'birth_date' => '1967-03-15',
                'subject' => 'Guru IPA',
                'employee_id' => 'B 03026187',
            ],
            [
                'name' => 'Gocep Dukin Saprudin R, S.Pd',
                'nip' => '196911291969097 001',
                'phone' => '5461 7475 4920 0013',
                'address' => 'PURWAKARTA',
                'birth_date' => '1969-11-29',
                'subject' => 'Guru IPS',
                'employee_id' => 'H 019094',
            ],
            [
                'name' => 'E. Rakhmah Hidayati, S.Pd',
                'nip' => '196911291996802 001',
                'phone' => '5461 7475 4920 0013',
                'address' => 'PURWAKARTA',
                'birth_date' => '1969-11-29',
                'subject' => 'Guru IPS',
                'employee_id' => 'H 019094',
            ],
            [
                'name' => 'Supenti, S.Pd',
                'nip' => '197101302007012004',
                'phone' => '2462 7496 4930 0002',
                'address' => 'PURWAKARTA',
                'birth_date' => '1971-01-30',
                'subject' => 'Guru B. Indonesia',
                'employee_id' => 'P 050052',
            ],
            [
                'name' => 'Sri Harlati, S.Pd',
                'nip' => '197004102006004 010',
                'phone' => '874274864930012',
                'address' => 'LAMPUNG',
                'birth_date' => '1970-04-10',
                'subject' => 'Guru IPS',
                'employee_id' => 'N 127747',
            ],
            [
                'name' => 'Kartini,M.Pd',
                'nip' => '197304091998022003',
                'phone' => '8741 7516 5430 0002',
                'address' => 'TEBNG TINGGI',
                'birth_date' => '1973-04-09',
                'subject' => 'Guru Bhs Inggris',
                'employee_id' => 'L 017100',
            ],
            [
                'name' => 'Endang Suryati Ss',
                'nip' => '196812012002012012',
                'phone' => '2533 7466 4830 0043',
                'address' => 'TEMPEH',
                'birth_date' => '1968-12-01',
                'subject' => 'Guru Bhs Inggris',
                'employee_id' => 'N 637018',
            ],
            [
                'name' => 'Wening Hidayah, S.Pd',
                'nip' => '197608232008012006',
                'phone' => '8155 7545 5530 0013',
                'address' => 'MAGELANG',
                'birth_date' => '1976-08-23',
                'subject' => 'Guru Matematika',
                'employee_id' => 'N 622901',
            ],
            [
                'name' => 'Agus Herdiana, S.Pd',
                'nip' => '197307302008011001',
                'phone' => '40527516532013',
                'address' => 'BANDUNG',
                'birth_date' => '1973-07-30',
                'subject' => 'Guru IPA',
                'employee_id' => 'P 241809',
            ],
            [
                'name' => 'Maya Herawati Sudjana, S.Ag',
                'nip' => '197903202008012007',
                'phone' => '75527576583082',
                'address' => 'BANDUNG',
                'birth_date' => '1979-03-20',
                'subject' => 'Guru PAI',
                'employee_id' => 'P 320298',
            ],
            [
                'name' => 'Ude Suhaenah, S.Pd',
                'nip' => '196912292014122002',
                'phone' => '155174765300033',
                'address' => 'GARUT',
                'birth_date' => '1969-12-29',
                'subject' => 'Guru PKn',
                'employee_id' => 'B 03011802',
            ],
            [
                'name' => 'Siti Nurhasanah, S.Pd',
                'nip' => '197905052023212001',
                'phone' => '083775765930042',
                'address' => 'PURWAKARTA',
                'birth_date' => '1979-05-05',
                'subject' => 'Guru Bhs Indonesia',
                'employee_id' => '',
            ],
            [
                'name' => 'Abdurahman,S.Ag',
                'nip' => '196812182024211002',
                'phone' => '25507466513003',
                'address' => 'MAJALENGKA',
                'birth_date' => '1968-12-18',
                'subject' => 'Guru PAI',
                'employee_id' => '',
            ],
            [
                'name' => 'Pian Anianto, S.Pd',
                'nip' => '197704272024211001',
                'phone' => '77597565682012',
                'address' => 'PURWAKARTA',
                'birth_date' => '1977-04-27',
                'subject' => 'GURU PJOK',
                'employee_id' => '',
            ],
            [
                'name' => 'Yeyen Hendrayani, S.Pd',
                'nip' => '198203252024212010',
                'phone' => '96577006230022',
                'address' => 'PURWAKARTA',
                'birth_date' => '1982-03-25',
                'subject' => 'Guru Matematika',
                'employee_id' => '',
            ],
            [
                'name' => 'Nia Dayuwariti, S.Pd',
                'nip' => '198209162024212012',
                'phone' => '96577006230022',
                'address' => 'PURWAKARTA',
                'birth_date' => '1982-09-16',
                'subject' => 'Guru Prakarya',
                'employee_id' => '',
            ],
            [
                'name' => 'Sumipi Megasari, S.Pd',
                'nip' => '198605182024212022',
                'phone' => '28507646530101',
                'address' => 'KARAWANG',
                'birth_date' => '1986-05-18',
                'subject' => 'Guru IPA',
                'employee_id' => '',
            ],
            [
                'name' => 'Nurul Khoeriyah, S.Pd',
                'nip' => '198809212024212022',
                'phone' => '42537666730173',
                'address' => 'PURWAKARTA',
                'birth_date' => '1988-09-21',
                'subject' => 'Guru BP/BK',
                'employee_id' => '',
            ],
            [
                'name' => 'Irfan Nurkhotis, S.Pd',
                'nip' => '198812092024211012',
                'phone' => '42537666730173',
                'address' => 'GARUT',
                'birth_date' => '1988-12-09',
                'subject' => 'Guru Matematika',
                'employee_id' => '',
            ],
            [
                'name' => 'Lukman Hakim, S.Pd',
                'nip' => '198907102024211034',
                'phone' => '42767668130883',
                'address' => 'PURWAKARTA',
                'birth_date' => '1989-07-10',
                'subject' => 'Guru PJOK',
                'employee_id' => '',
            ],
            [
                'name' => 'Lia Nurnengsih, SPd',
                'nip' => '199110012024212042',
                'phone' => '93337696701304',
                'address' => 'PURWAKARTA',
                'birth_date' => '1991-10-01',
                'subject' => 'Guru B. Sunda',
                'employee_id' => '',
            ],
            [
                'name' => 'Noneng Nurayish,S.I. Pust',
                'nip' => '197911052025212006',
                'phone' => '44377576581301',
                'address' => 'PURWAKARTA',
                'birth_date' => '1979-11-05',
                'subject' => 'Guru Prakarya',
                'employee_id' => '',
            ],
            [
                'name' => 'Nuraisyah, S.Hum',
                'nip' => '199610102025212093',
                'phone' => '',
                'address' => 'BANDUNG',
                'birth_date' => '1996-10-10',
                'subject' => 'Guru Bahasa Sunda',
                'employee_id' => '',
            ],
        ];

        foreach ($teachers as $teacherData) {
            $email = strtolower(str_replace([' ', '.', ','], '', explode(',', $teacherData['name'])[0])) . '@smpn4.sch.id';
            
            // Skip if user already exists
            if (User::where('email', $email)->exists()) {
                continue;
            }
            
            // Create user account
            $user = User::create([
                'name' => $teacherData['name'],
                'email' => $email,
                'password' => Hash::make('password'),
                'role_id' => $guruRole->id,
            ]);

            // Create teacher record
            Teacher::create([
                'user_id' => $user->id,
                'nip' => $teacherData['nip'],
                'name' => $teacherData['name'],
                'phone' => $teacherData['phone'],
                'address' => $teacherData['address'],
                'birth_date' => $teacherData['birth_date'],
            ]);
        }
    }
}
