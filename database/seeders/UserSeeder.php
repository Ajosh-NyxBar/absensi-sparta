<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();
        $headmasterRole = Role::where('name', 'Kepala Sekolah')->first();
        $teacherRole = Role::where('name', 'Guru')->first();

        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@smpn4purwakarta.sch.id',
            'password' => Hash::make('admin123'),
            'role_id' => $adminRole->id,
        ]);

        // Create Headmaster User
        User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@smpn4purwakarta.sch.id',
            'password' => Hash::make('kepsek123'),
            'role_id' => $headmasterRole->id,
        ]);

        // Create Sample Teacher User
        $teacherUser = User::create([
            'name' => 'Guru Matematika',
            'email' => 'guru@smpn4purwakarta.sch.id',
            'password' => Hash::make('guru123'),
            'role_id' => $teacherRole->id,
        ]);

        // Create Teacher Profile
        Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => '198501012010011001',
            'name' => 'Guru Matematika',
            'gender' => 'L',
            'birth_date' => '1985-01-01',
            'phone' => '081234567890',
            'address' => 'Purwakarta, Jawa Barat',
            'education_level' => 'S1 Pendidikan Matematika',
            'position' => 'Guru',
            'status' => 'active',
        ]);
    }
}
