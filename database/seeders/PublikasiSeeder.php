<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PublikasiConference;
use App\Models\PublikasiJurnal;

class PublikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PublikasiJurnal::create([
            'judul' => 'judul publikasi',
            'nim' => '220535608555',
            'jurnal' => 'judul jurnal',
            'volume' => '12',
            'nomor' => '21',
            'tanggal_terbit' => '2024-2-30',
            'link' => 'https://example.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        PublikasiJurnal::create([
            'judul' => 'judul publikasi 2',
            'nim' => '220535608555',
            'jurnal' => 'judul jurnal',
            'volume' => '12',
            'nomor' => '21',
            'tanggal_terbit' => '2024-2-30',
            'link' => 'https://example.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        PublikasiConference::create([
            'judul' => 'publikasi 1',
            'nim' => '220535608555',
            'namaConference' => 'malang',
            'penyelenggara' => 'dimas',
            'tanggal_Conference' => '2024-02-03',
            'lokasi_Conference' => 'malang',
            'tanggalPublikasi' => '2024-02-03',
            'link' => 'https://example.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        PublikasiConference::create([
            'judul' => 'publikasi 2',
            'nim' => '220535608555',
            'namaConference' => 'malang',
            'penyelenggara' => 'dimas',
            'lokasi_Conference' => 'malang',
            'tanggal_Conference' => '2024-02-03',
            'tanggalPublikasi' => '2024-02-03',
            'link' => 'https://example.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
