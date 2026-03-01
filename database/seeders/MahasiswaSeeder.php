<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use App\Models\DetailMahasiswa;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mahasiswa::create([
            'nim' => '220535608548',
            'nama' => 'Alvalen Shafelbilyunazra',
            'judul' => 'Judul Skripsi',
            'promotor_id' => 1,
            'co_promotor1_id' => 2,
            'password' => bcrypt('password')
        ]);
        Mahasiswa::create([
            'nim' => '220535608555',
            'nama' => 'DIMAS ARDIMINDA EDIA PUTRA',
            'judul' => 'Pengaruh BoreUp dan Stroke Up Terhadap Emosi seseorang',
            'promotor_id' => 1,
            'co_promotor1_id' => 2,
            'co_promotor2_id' => 3,
            'password' => bcrypt('password')
        ]);
        // Mahasiswa::create([
        //     'nim' => '220535608556',
        //     'nama' => 'Budiono Siregar',
        //     'judul' => "",
        //     'promotor_id' => "",
        //     'co_promotor1_id' => "",
        //     'co_promotor2_id' => "",
        //     'password' => bcrypt('password')
        // ]);
        DetailMahasiswa::create([
            'nim' => '220535608548',
            'nama' => 'Alvalen Shafelbilyunazra',
            'no_hp' => '028383163213',
            'email_um' => "alvalen.shafel.2205356@students.um.ac.id",
            'email_lain' => "cihuy@gmail.com",
            'alamat_malang' => "jl. kertesntono no 52, kec. lowokwaru, kota malang",
            'alamat_asal' => "pasuruan",
            'asal_instansi' => "UM",
            "PT_S1" => 3.25,
            "PT_S2" => 4.0,
            "skor_toefl" => "550",
            "skor_TPA" => "600",
        ]);
        DetailMahasiswa::create([
            'nim' => '220535608555',
            'nama' => 'Dimas Ardiminda EP',
            'no_hp' => '028383163213',
            'email_um' => "dimas.ardiminda.2205356@students.um.ac.id",
            'email_lain' => "cihuy@gmail.com",
            'alamat_malang' => "jl. kertesntono no 52, kec. lowokwaru, kota malang",
            'alamat_asal' => "pasuruan",
            'asal_instansi' => "UM",
            "PT_S1" => 3.25,
            "PT_S2" => 4.0,
            "skor_toefl" => "550",
            "skor_TPA" => "600",
        ]);
    }
}
