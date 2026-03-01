<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class CombinedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Mahasiswa (level 1)
        DB::connection('second_db')->table('user')->insert([
            'username' => '220535603540',
            'pwd_hash' => md5('123'),
            'password' => Hash::make('123'),
            'kat_no_induk' => '1',
            'nomor_induk' => '220535603540',
            'email' => 'emailhj@gmail.com',
            'nama_lengkap' => 'maha3',
            'tahun_masuk' => '2022',
            'jenjang' => '4',
            'no_hp' => '087758496789',
            'kode_prodi' => '10',
            'offering' => 'A',
            'jenis_kelamin' => 'L',
            'level' => '1',
            'status' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Dosen (level 11)
        
    }
}