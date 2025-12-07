<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'description' => 'Administrator sistem dengan akses penuh'
            ],
            [
                'name' => 'Kepala Sekolah',
                'description' => 'Kepala sekolah dengan akses monitoring dan laporan'
            ],
            [
                'name' => 'Guru',
                'description' => 'Guru dengan akses presensi dan penilaian siswa'
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
