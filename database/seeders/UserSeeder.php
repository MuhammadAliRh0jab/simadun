<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection('second_db')->table('user')->insert([
            // Mahasiswa
            [
                'username' => '222222222222',
                'email' => 'Mahaaaaa2@example.com',
                'no_hp' => '082134567896',
                'password' => Hash::make('password123'),
                'pwd_hash' => Hash::make('password123'),
                'nama_lengkap' => 'Mahasiswaaaaaa2',
                'tahun_masuk' => 2015,
                'kat_no_induk' => '6',
                'jenjang' => '4',
                'kode_prodi' => '10',
                'jenis_kelamin' => 'L',
                'level' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'nomor_induk' => '222222222222'
            ],
        ]);
    }
}
