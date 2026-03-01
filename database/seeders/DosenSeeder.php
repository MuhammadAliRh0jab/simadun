<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dosen;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dosen::create([
            'no_induk' => '1234567891',
            'nama' => 'John Dosen',
            'role' => 'dosen',
            'pangkat_gol' => 'IV/a',
            'email' => 'john@example.com',
            'password' => bcrypt('password')
        ]);
        Dosen::create([
            'no_induk' => '3262132812',
            'nama' => 'Jane Dosen',
            'role' => 'dosen',
            'pangkat_gol' => 'IV/a',
            'email' => 'jane@example.com',
            'password' => bcrypt('password')
        ]);
        Dosen::create([
            'no_induk' => '197412152008122002',
            'nama' => 'Dr. Ir. Triyanna Widiyaningtyas , M.T.',
            'role' => 'kaprodi',
            'pangkat_gol' => 'IV/a',
            'email' => 'triyannaw.ft@um.ac.id',
            'password' => bcrypt('password')
        ]);
        Dosen::create([
            'no_induk' => '197909302008011010',
            'nama' => 'Dr. Eng. Didik Dwi Prasetya, S.T., M.T.',
            'role' => 'dosen',
            'pangkat_gol' => 'IV/a',
            'email' => 'didikdwi@um.ac.id',
            'password' => bcrypt('password')
        ]);
        Dosen::create([
            'no_induk' => '197912182005011001',
            'nama' => 'Prof. Aji Prasetya Wibawa, S.T., M.M.T., Ph.D.',
            'role' => 'dosen',
            'pangkat_gol' => 'IV/a',
            'email' => 'aji.prasetya.ft@um.ac.id',
            'password' => bcrypt('password')
        ]);
    }
}
